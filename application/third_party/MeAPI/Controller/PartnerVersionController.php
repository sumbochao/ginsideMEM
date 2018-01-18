<?php
class MeAPI_Controller_PartnerVersionController{
    protected $_response;
    private $CI;
    private $_mainAction;
	private $limit;
	
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->MeAPI_Library('TOTP');
		$this->CI->load->MeAPI_Library('Curl');
		$this->CI->load->MeAPI_Library("Graph_Inside_API");
		$this->CI->load->MeAPI_Model('PartnerVersionModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
		if($session['id_group']!=1){
			$this->_mainAction = base_url().'?control='.$_GET['control'].'&func=noaccess';
		}
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
	
		$this->data['loadpartner']=$this->CI->PartnerVersionModel->listPartner();
		$this->data['loadgame']=$this->CI->PartnerVersionModel->listGame();
		$this->data['loadplatform']=$this->CI->PartnerVersionModel->listPlatform();
		$this->data['loadstatus']=$this->CI->PartnerVersionModel->listStatus();
		$this->data['slbTable'] = $this->CI->PartnerVersionModel->listTableApp();
		
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'partnerversion/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý Version Đối tác';
        $this->data['slbUser'] = $this->CI->PartnerVersionModel->listUser();
		/*
		$this->filter();
		$arrFilter = array(
            'msv_id' => $this->CI->Session->get_session('msv_id'),
            'platform' => $this->CI->Session->get_session('platform'),
            'status' => $this->CI->Session->get_session('status'),
            'service_id' => $this->CI->Session->get_session('service_id')
        );*/
		
		if(isset($_GET['type']) && $_GET['type']=="filter"){
			$arrParam = $this->CI->security->xss_clean($_POST);
			$arrFilter = array(
				'msv_id' => $arrParam['code'], // msv_id
				'platform' => $arrParam['cbo_platform'],
				'status' => $arrParam['cbo_status'],
				'service_id' => $arrParam['cbo_app'] //service_id
			);
			// lay so OTP
			$otp = $this->CI->Graph_Inside_API->get_otp();
			$arrPurl = array(
            'control' => "inside", // msv_id
            'func' => "msv_get",
			'limit'=>500,
			'app' => "ginside",
        	);
			//kiem tra phan tu rong
				foreach($arrFilter as $key=>$value){
					if($value=="" || empty($value)){
						if($key=='service_id'){
							$arrFilter[$key]='0';
						}else{
							unset($arrFilter[$key]);
						}
					}
				}
			
			if(!empty($arrFilter) && count($arrFilter)>0){
				$arr=array_merge($arrPurl,$arrFilter);
				$arr['otp']=$otp;
			}else{
				$arr=$arrPurl;
				$arr['service_id']='0';
				$arr['otp']=$otp;
			}//end if
			
			$param=$this->CI->Graph_Inside_API->get_param_url($arr);
			// tao chuoi ma hoa md5 Token
			$token = md5(implode("", $param) . $this->CI->Graph_Inside_API->get_Secretkey());
			$param["token"] = $token;
			//cac tham so va gia tri cua url
			$url_param = http_build_query($param, true);
			//du lieu tra ve 
			$reponse=$this->CI->Graph_Inside_API->view_msv($url_param);
			$this->data['api_view_msv']=$reponse;
		}else{
			if(isset($_GET['service_id']) && !empty($_GET['service_id']) && isset($_GET['platform']) && !empty($_GET['platform'])){
				$srv_id=$_GET['service_id'];
				$platform=$_GET['platform'];
			}else{
				$srv_id='0';
				$platform='0';
			}
			// lay so OTP
			$otp = $this->CI->Graph_Inside_API->get_otp();
			//Tham so url 
			/*$param=$this->CI->Graph_Inside_API->get_param_url(array("control"=>"inside","func"=>"msv_get","msv_id"=>"","status"=>"","platform"=>"","service_id"=>"111","me_button"=>"","me_chat"=>"","me_game"=>"","me_event"=>"","limit"=>"","page"=>"","app"=>"ginside","otp"=> $otp,"page"=>""));*/
			$param=$this->CI->Graph_Inside_API->get_param_url(array("control"=>"inside","func"=>"msv_get","service_id"=>$srv_id,"platform"=>$platform,"limit"=>500,"app"=>"ginside","otp"=> $otp));
			// tao chuoi ma hoa md5 Token
			$token = md5(implode("", $param) . $this->CI->Graph_Inside_API->get_Secretkey());
			$param["token"] = $token;
			//cac tham so va gia tri cua url
			$url_param = http_build_query($param, true);
			//du lieu tra ve 
			$reponse=$this->CI->Graph_Inside_API->view_msv($url_param);
			$this->data['api_view_msv']=$reponse;
		}
        $this->CI->template->write_view('content', 'partnerversion/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm thông tin Version đối tác';
		//$this->CI->load->library('form_validation');
		//$this->CI->form_validation->set_rules('txt_msv', 'Nhận số', 'integer');
		if($this->CI->input->post()){
			// lay so OTP
			$otp = $this->CI->Graph_Inside_API->get_otp();
			$param=array(
				"control"=>"inside",
				"func"=>"msv_add",
				"msv_id"=>$this->CI->input->post('txt_msv'),
				"status"=>$this->CI->input->post('cbo_status'),
				"platform"=>$this->CI->input->post('cbo_platform'),
				"service_id"=>$this->CI->input->post('cbo_app'),
				"app"=>"ginside",
				"otp"=> $otp,					
			);
			
			$param_c=array(
				"msv_id"=>"msv_".$this->CI->input->post('txt_msv'),
				"status"=>$this->CI->input->post('cbo_status'),
				"platform"=>$this->CI->input->post('cbo_platform'),
				"service_id"=>$this->CI->input->post('cbo_app'),
				"service_name"=>$this->CI->input->post('cbo_app_hiden'),
				"type_app"=>$this->CI->input->post('cbo_type_app'),
				"published"=>$this->CI->input->post('cbo_published'),
				"datecreate"=>date('d-m-y H:m:s'),
				"days"=>date('d-m-y'),
				"notes"=>$this->CI->input->post('notes'),
				"users_act"=>$this->data['session_account']['id']		
			);
			//Tham so url 
			$param_url=$this->CI->Graph_Inside_API->get_param_url($param);
			// tao chuoi ma hoa md5 Token
			$token = md5(implode("", $param_url) . $this->CI->Graph_Inside_API->get_Secretkey());
			$param["token"] = $token;
			
			$kq=$this->CI->Graph_Inside_API->msv_add($param);
			if($kq['status']!=FALSE){
				//them thanh cong msv
				//sau do insert csdl
				$this->CI->PartnerVersionModel->add_new($param_c);
				redirect($this->_mainAction);
				
			}else{
				$this->data['error']="THông báo : Không thêm được msv_add, vui lòng thử lại";
			}
		}
		
        $this->CI->template->write_view('content', 'partnerversion/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật thông tin Me Store Version';
		
		$arrControl=array(
				"msv_id"=>$this->CI->input->get('msv_id'),
				"status"=>$this->CI->input->get('status'),
				"platform"=>$this->CI->input->get('platform'),
				"service_id"=>$this->CI->input->get('service_id'),
				"type_app"=>$this->CI->input->get('type_app'),
				"published"=>$this->CI->input->get('published'),
				"id"=>$this->CI->input->get('id'),
				"notes"=>$this->CI->input->get('notes'),					
			);
		$this->data['control']=$arrControl;
		
		
		if(isset($_GET['act']) && $_GET['act']=="action"){
			// lay so OTP
			$otp = $this->CI->Graph_Inside_API->get_otp();
			$param=array(
				"control"=>"inside",
				"func"=>"msv_approve",
				"id"=>$this->CI->input->get('id'),
				"status"=>$this->CI->input->post('cbo_status'),
				//"platform"=>$this->CI->input->post('cbo_platform'),
				//"service_id"=>$this->CI->input->post('cbo_app'),
				"app"=>"ginside",
				"otp"=> $otp,					
			);
			
			$param_c=array(
				"service_name"=>$this->CI->input->post('cbo_app_hiden'),
				"status"=>$this->CI->input->post('cbo_status'),
				"type_app"=>$this->CI->input->post('cbo_type_app'),
				"published"=>$this->CI->input->post('cbo_published'),
				"datecreate"=>date('y-m-d H:i:s'),
				"notes"=>$this->CI->input->post('notes'),
				"users_act"=>$this->data['session_account']['id']				
			);
			$param_where=array(
				"msv_id"=>"msv_".$this->CI->input->post('txt_msv'),
				"platform"=>$this->CI->input->post('cbo_platform'),
				"service_id"=>$this->CI->input->post('cbo_app'),				
			);
			//Tham so url 
			$param_url=$this->CI->Graph_Inside_API->get_param_url($param);
			// tao chuoi ma hoa md5 Token
			$token = md5(implode("", $param_url) . $this->CI->Graph_Inside_API->get_Secretkey());
			$param["token"] = $token;
			
			$kq=$this->CI->Graph_Inside_API->msv_edit($param);
			if($kq['status']!=FALSE){
				//them thanh cong msv
				//sau do insert csdl
				$this->CI->PartnerVersionModel->edit_new($param_c,$param_where);
				redirect($this->_mainAction."&service_id=".$_GET['service_id']."&platform=".$_GET['platform']);
				
			}else{
				$this->data['error']="THông báo : Không cập nhật được msv_edit, vui lòng thử lại";
			}
		}
		
        $this->CI->template->write_view('content', 'partnerversion/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('msv_id', $arrParam['code']);
            $this->CI->Session->unset_session('platform', $arrParam['cbo_platform']);
            $this->CI->Session->unset_session('status', $arrParam['cbo_status']);
			$this->CI->Session->unset_session('service_id', $arrParam['cbo_app']);
        }
    }
	 
    public function getResponse() {
        return $this->_response;
    }
}
