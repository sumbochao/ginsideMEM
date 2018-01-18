<?php

class MeAPI_Controller_ReportnapmoboController implements MeAPI_Controller_ReportnapmoboInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');

        $this->CI->load->MeAPI_Model('ReportModel');
        $this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        
        $session = $this->CI->Session->get_session('account');
        /*$acc = array("vietbl","hoangpc", "tuanhq", "nghiapq", "quannt","phuongnt","phuongnt2","hiennv","thinhndn");
        if (in_array($session['username'], $acc) === false) {
            echo 'Bạn không được phép truy cập!'; die;
        }*/
    }

    /*
     * Get Data Group
     */

    public function index(MeAPI_RequestInterface $request) {
        
        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        if($_GET['type'] == 'filter'){
            if($_POST['service_id']===''){
                $this->data['message'] = "Vui lòng chọn game!";
                return;
            }
            $arrayfilter = $_POST;
            
            foreach ($arrayfilter as $key => $value) {
                if ($value === null || $value === '') { unset($arrayfilter[$key]); }
                if ($key==='service_id'){$arrayfilter[$key]=explode('-', $value)[1];}
            }
            $this->CI->Session->set_session('arrayfilter', $arrayfilter);
            if (!empty($arrayfilter['service_id'])) {
                $slbServer = $this->CI->PaymentModel->listServerByGame($arrayfilter['service_id']);
//                var_dump($slbServer);
                $this->data['slbServer'] = $slbServer;
            }
        }else{
            unset($_SESSION['arrayfilter']);
        }
        $result = $this->call_api_napmobovn();
        $slbScopes = $this->CI->ReportModel->listScopes_Id();
        $this->data['slbScopes'] = $slbScopes;
        
        $this->data['result'] = $result['data'];
        $this->CI->template->write_view('content', 'report_napmobovn/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function getResponse() {
        return $this->_response;
    }
    
    public function getserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $arrGame = explode('-', $_REQUEST['game']);
        $game = $arrGame['0'];
        $listServer = $this->CI->PaymentModel->listServerByGame($game);
        if(!empty($game)){
            $xhtml = '<select name="server_id" class="textinput"><option value="">Chọn server</option>';
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
            $xhtml = '<select name="server_id" class="textinput"><option value="">Chọn server</option></select>';
            $f = array(
                'status'=>1,
                'messg'=>'Thất bại',
                'html'=>$xhtml
            );
        }
        echo json_encode($f);
        exit();
    }
    
    public function call_api_napmobovn() {
        $link = 'https://nap.mobo.vn/query?';
//        
        $arrayfilter = $this->CI->Session->get_session('arrayfilter');
        $dataKeyword = [];
        $wheres = array("app"=>$arrayfilter['service_id']);
        if(!empty($arrayfilter['keyword'])){
            $wheres["0"]= array(
                            "mobo_id like"=>"%{$arrayfilter['keyword']}%",
                            "mobo_service_id like"=>"%{$arrayfilter['keyword']}%",
                            "transaction_id like"=>"%{$arrayfilter['keyword']}%",
                            "character_id like"=>"%{$arrayfilter['keyword']}%",
                            "character_name like"=>"%{$arrayfilter['keyword']}%",
                            "serial like"=>"%{$arrayfilter['keyword']}%",
                        );
        }
        if(!empty($arrayfilter['keyword'])){
            $wheres["0"]= array(
                            "mobo_id like"=>"%{$arrayfilter['keyword']}%",
                            "mobo_service_id like"=>"%{$arrayfilter['keyword']}%",
                            "transaction_id like"=>"%{$arrayfilter['keyword']}%",
                            "character_id like"=>"%{$arrayfilter['keyword']}%",
                            "character_name like"=>"%{$arrayfilter['keyword']}%",
                            "serial like"=>"%{$arrayfilter['keyword']}%",
                        );
        }
        if(!empty($arrayfilter['create_date_from'])){
            $wheres["create_date >="]=$arrayfilter['create_date_from'];
        }
        if(!empty($arrayfilter['create_date_to'])){
            $wheres["create_date <="]=$arrayfilter['create_date_to'];
        }
        $data = array(
            "data" => json_encode(array(
                "order_id",
                "mobo_id",
                "mobo_service_id",
                "character_id",
                "character_name",
                "server_id",
                "money",
                "credit",
                "transaction_id",
                "status_code",
                "response_time",
                "create_date",
                "status",
                "pay_response",
                "type",
                "telco",
                "serial",
                "unit",
                "event_info"
            )),
            "wheres" => json_encode($wheres)
        );

//        $arrayfilter = $this->CI->Session->get_session('arrayfilter');
//        $wheres = 'wheres={"app":"'.$arrayfilter['service_id'].'"';
//        foreach ($arrayfilter as $key => $value) {
//            if($key != 'service_id'){
//                $wheres = $wheres.',"'.$key.'":"'.$value.'"';
//            }
//        }
//        $token = md5(implode('', $param) . 'IDpCJtb6Go10vKGRy5DQ');
        $last_link_request = $link . http_build_query($data);
        $api_url = $last_link_request;
        $api_result = json_decode($this->call_api_get($api_url), true);
        return $api_result;

    }

    private function call_api_get($api_url) {
        set_time_limit(30);
        $urlrequest = $api_url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlrequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $result = curl_exec($ch);
        $err_msg = "";

        if ($result === false)
            $err_msg = curl_error($ch);

        //var_dump($result);
        //die;
        curl_close($ch);
        return $result;
    }

}
