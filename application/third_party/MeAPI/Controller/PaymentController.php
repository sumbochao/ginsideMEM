<?php
class MeAPI_Controller_PaymentController implements MeAPI_Controller_PaymentInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;
    private $api_secret = "tPhV6cTNoUtdppNEw9sI";
    /**
     *
     * @var CI_Controller
     */
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
        MeAPI_Autoloader::register();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->MeAPI_Library('PaymentValidate');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('PaymentModel');
        
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        
        
        $session = $this->CI->Session->get_session('account');
        
        /*$acc = array("vietbl", "hoangpc", "tuanhq", "nghiapq", "quannt", "thinhndn","phuongnt2");
        if (in_array($session['username'], $acc) === false) {
            echo 'Bạn không được phép truy cập!'; die;
        }*/
    }

    public function add(MeAPI_RequestInterface $request) {
         $this->authorize->validateAuthorizeRequest($request, 0);
        
        $listScopes = $this->CI->PaymentModel->listScopes();
        $this->data['listScopes'] = $listScopes;
        
        $session = $this->CI->Session->get_session('account');
        if ($this->CI->input->post()) {
            $this->CI->PaymentValidate->validateForm($this->CI->input->post());
            if($this->CI->PaymentValidate->isVaild()){
                $errors = $this->CI->PaymentValidate->getMessageErrors();
                $Item = $this->CI->PaymentValidate->getData();
                
                if(!empty($Item['service_id'])){
                    $slbServer = $this->CI->PaymentModel->listServerByGame($Item['service_id']);
                }
                $this->data['errors'] = $errors;
                $this->data['Item'] = $Item;
                $this->data['slbServer'] = $slbServer;
            }else{
                $data = $this->CI->PaymentValidate->getData();
                $arrListScopes = array();
                if(empty($listScopes)!==TRUE){
                    foreach($listScopes as $v){
                        $arrListScopes[$v['service']] = $v;
                    }
                }
                
                //$api_secret = $arrListScopes[$data['service_id']]['app_secret'];
                
                $game_info = array(
                    'platform'=>$data['game_platform'],
                    'character_id'=>$data['game_character_id'],
                    'character_name'=>$data['game_character_name'],
                    'server_id'=>$data['game_server_id'],
                );
                $game_info = json_encode($game_info);
                $arrURL = array(                    
                    'transaction_id'=>$data['transaction_id'],
                    'date'=>strtotime($data['date']),
                    'mobo_id'=>$data['mobo_id'],
                    'mobo_service_id'=>$data['mobo_service_id'],
                    'money'=>$data['money'],
                    'mcoin'=>$data['mcoin'],
                    'credit'=>$data['credit'],
                    'credit_original'=>$data['credit_original'],
                    'payment_type'=>$data['payment_type'],
                    'service_name'=>$data['service_id'],
                    'service_id'=>$arrListScopes[$data['service_id']]['service_id'],
                    'game_info'=>$game_info,
                    'desc'=>$session['username'].'-'.$data['description'],
					'source_value'=>$data['source_value'],
					'source_type'=>$data['source_type'],
                );
                $token = md5(implode("", $arrURL) . $this->api_secret);
                if($data['service_id']=='aow_tl'){
					$strURL = "http://g-api-thai.mobo.vn/?control=payment&func=recharge&". http_build_query($arrURL) . "&app=payment&" . 'token=' .$token;
				}else{
					$strURL = URL_PAYMENT_GAPI_MOBO_VN . "&". http_build_query($arrURL) . "&app=payment&" . 'token=' .$token;
				}
                

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $strURL);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                $result = curl_exec($ch);
                curl_close($ch);
                echo $result;
                MeAPI_Log::writeCsv(array("request" => $strURL, "result" => $strURL, "data" => json_encode($_GET)), 'payment_' . date('H'));
                
                if(isset($result)){
                    $code = '&code='.$result;
                }
				
                redirect(APPLICATION_URL.'?control=payment&func=success'.$code);
            }
        }
        
        $this->CI->template->write_view('content', 'payment/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function success(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if(isset($_GET['code'])){
             $code = json_decode($_GET['code'],true);
        }else{
            $code = 'Lỗi dữ liệu';
        }
        $this->data['items'] = $code;
        $this->CI->template->write_view('content', 'payment/success',$this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $game = $_REQUEST['game'];
        $listServer = $this->CI->PaymentModel->listServerByGame($game);
        
        if(!empty($game)){
            $xhtml = '<select name="game_server_id" class="textinput"><option value="0">Chọn server</option>';
            if(empty($listServer) !== TRUE){
                foreach($listServer as $v){
                    $xhtml .='<option value="'.$v['server_id'].'">'.$v['server_name'].'</option>';
                }
            }
            $xhtml .= '</select>';
            $f = array(
                'status'=>0,
                'messg'=>'Thành công',
                'html'=>$xhtml
            );
        }else{
			$xhtml = '<select name="game_server_id" class="textinput"><option value="0">Chọn server</option></select>';
            $f = array(
                'status'=>1,
                'messg'=>'Thất bại',
                'html'=>$xhtml
            );
        }
        echo json_encode($f);
        exit();
    }
    public function getResponse() {
        return $this->_response;
    }
}