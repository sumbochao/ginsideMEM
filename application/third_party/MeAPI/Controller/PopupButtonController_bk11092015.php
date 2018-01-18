<?php
class MeAPI_Controller_PopupButtonController {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->MeAPI_Library('TOTP');
		$this->CI->load->MeAPI_Library('Curl');
		$this->CI->load->MeAPI_Library("Graph_Inside_API");
        $this->CI->load->MeAPI_Model('PopupButtonModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index';
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->CI->load->library('form_validation');
		$this->CI->load->helper('form');
		//$this->CI->template->set_template('blank');
		//get msv_id viewone
		//$arrParam = $this->CI->security->xss_clean($_POST);
			// lay so OTP
			$otp = $this->CI->Graph_Inside_API->get_otp();
			$arrPurl = array(
            'control' => "inside", // msv_id
            'func' => "msv_get",
			'app' => "ginside",
			'msv_id' => $this->CI->input->get('msv_id'), // msv_id
			'platform' => $this->CI->input->get('platform'),
			'status' =>$this->CI->input->get('status'),
			'service_id' =>$this->CI->input->get('service_id'), //service_id
			'otp'=>$otp
        	);
			$param=$this->CI->Graph_Inside_API->get_param_url($arrPurl);
			// tao chuoi ma hoa md5 Token
			$token = md5(implode("", $param) . $this->CI->Graph_Inside_API->get_Secretkey());
			$param["token"] = $token;
			//cac tham so va gia tri cua url
			$url_param = http_build_query($param, true);
			//du lieu tra ve 
			$reponse=$this->CI->Graph_Inside_API->view_msv($url_param);
			$this->data['api_view_msv']=$reponse;
        $this->CI->template->write_view('content', 'popupbutton/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
       $this->CI->load->library('form_validation');
		$this->CI->load->helper('form');
        $this->CI->load->MeAPI_Library('Pgt');
		//get json
		$links=$this->CI->input->post('link')==""?"null":$this->CI->input->post('link');
		$mess=$this->CI->input->post('message')==""?"null":$this->CI->input->post('message');
		
       	$msg=array('link'=>$links,'message'=>$mess);
		$jsonmsg=json_encode($msg);
		$this->CI->form_validation->run();
		
		$otp = $this->CI->Graph_Inside_API->get_otp();
			$param=array(
				"control"=>"inside",
				"func"=>"msv_update",
				"id"=>$this->CI->input->get('id'),
				"me_button"=>$this->CI->input->post('mebutton'),
				"me_chat"=>$this->CI->input->post('mechat'),
				"me_game"=>$this->CI->input->post('megame'),
				"me_event"=>$this->CI->input->post('meevent'),
				"me_login"=>$this->CI->input->post('melogin'),
				"msg_login"=>$jsonmsg,
				"me_gm"=>$this->CI->input->post('megm'),
				"app"=>"ginside",
				"otp"=> $otp,					
			);
		
		//Tham so url 
		$param_url=$this->CI->Graph_Inside_API->get_param_url($param);
		// tao chuoi ma hoa md5 Token
		$token = md5(implode("", $param_url) . $this->CI->Graph_Inside_API->get_Secretkey());
		$param["token"] = $token;
		
		$kq=$this->CI->Graph_Inside_API->msv_update_button($param);
			if($kq['status']!=FALSE){
				$this->data['error']="Thông báo : Cập nhật thành công";
			}else{
				$this->data['error']="Thông báo : Không cập nhật được Me button, vui lòng thử lại";
			}
		
       $this->CI->template->write_view('content', 'popupbutton/index', $this->data);
       $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function actionajax(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->library('form_validation');
		$this->CI->load->helper('form');
        $this->CI->load->MeAPI_Library('Pgt');
		//get json
		$links=$this->CI->input->post('linktext')==""?"":$this->CI->input->post('linktext');
		$mess=$this->CI->input->post('mess')==""?"":$this->CI->input->post('mess');
		
       	$msg=array('link'=>$links,'message'=>$mess);
		$jsonmsg=json_encode($msg);
		$this->CI->form_validation->run();
		
		$otp = $this->CI->Graph_Inside_API->get_otp();
			$param=array(
				"control"=>"inside",
				"func"=>"msv_update",
				"id"=>$this->CI->input->post('id'),
				"me_button"=>$this->CI->input->post('mebutton'),
				"me_chat"=>$this->CI->input->post('mechat'),
				"me_game"=>$this->CI->input->post('megame'),
				"me_event"=>$this->CI->input->post('meevent'),
				"me_login"=>$this->CI->input->post('melogin'),
				"msg_login"=>$jsonmsg,
				"me_gm"=>$this->CI->input->post('megm'),
				"app"=>"ginside",
				"otp"=> $otp,					
			);
		
		//Tham so url 
		$param_url=$this->CI->Graph_Inside_API->get_param_url($param);
		// tao chuoi ma hoa md5 Token
		$token = md5(implode("", $param_url) . $this->CI->Graph_Inside_API->get_Secretkey());
		$param["token"] = $token;
		
		$kq=$this->CI->Graph_Inside_API->msv_update_button($param);
			if($kq['status']!=FALSE){
				$f = array(
                'error'=>'0',
                'messg'=>'Thông báo : Cập nhật thành công '.$kq['status'],
           		 );
			}else{
				 $f = array(
                'error'=>'1',
                'messg'=>'Thông báo : Không cập nhật được Me button, vui lòng thử lại ??'.$kq['status'],
           		 );
			}
        echo json_encode($f);
        exit();
    }
  	 public function getResponse() {
        return $this->_response;
    }
}
?>