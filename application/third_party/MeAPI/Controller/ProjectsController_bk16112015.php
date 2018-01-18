<?php
class MeAPI_Controller_ProjectsController{
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
		$this->CI->load->MeAPI_Model('ProjectsModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
		/*if($session['id_group']!=1){
			$this->_mainAction = base_url().'?control='.$_GET['control'].'&func=noaccess';
		}*/
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
	
		
		$this->data['loaditem']=$this->CI->ProjectsModel->listItem();
		$this->data['loadplatform']=$this->CI->ProjectsModel->listPlatform();
		
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'projects/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý dự án Game';
		
		$this->filter();
      
        $arrFilter = array(
            'names' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'names' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->ProjectsModel->listItem($arrFilter);
		
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=index';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
		$this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
 
        $this->CI->template->write_view('content', 'projects/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function logupdate(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Nhật ký cập nhật';
        
		
		$this->filter();
      
        $arrFilter = array(
            'actions' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
				'actions' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
		 	$options = array(
				'username' => $_SESSION['account']['id'],
                'id_actions' =>$_GET['id'],
				'tables'=>$_GET['table']
            );
        $listItems = $this->CI->ProjectsModel->listItemLog($arrFilter,$options);
		
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=logupdate&table='.$_GET['table'].'&id='.$_GET['id'];
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
		$this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
 
        $this->CI->template->write_view('content', 'projects/logupdate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function logupdate1(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Nhật ký cập nhật';
        
		
		$this->filter();
      
        $arrFilter = array(
            'actions' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
				'actions' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
		 	$options = array(
				'username' => $_SESSION['account']['id'],
                'id_actions' =>$_GET['id'],
				'tables'=>$_GET['table']
            );
        $listItems = $this->CI->ProjectsModel->listItemLog($arrFilter,$options);
		
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=logupdate1&table='.$_GET['table'].'&id='.$_GET['id'];
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
		$this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
 
        $this->CI->template->write_view('content', 'projects/logupdate1', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function listlog(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Nhật ký user thao tác Xóa trên dự án Game';
        
		
		$this->filter();
      
        $arrFilter = array(
            'names' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'names' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->ProjectsModel->listItemLog($arrFilter);
		
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=listlog';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
		$this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
 
        $this->CI->template->write_view('content', 'projects/log', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function getdevice(){
		$device=preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$_SERVER['HTTP_USER_AGENT'])==0?"desktop":"mobile";
		return $device;
	}
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm dự án Game';
		$this->CI->load->library('form_validation');
        $this->CI->template->write_view('content', 'projects/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật thông tin dự án Game';
		$this->CI->load->library('form_validation');
		$this->data['getitem'] = $this->CI->ProjectsModel->getItem($_GET['id']); 
		
        $this->CI->template->write_view('content', 'projects/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function popupinapp(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'In App Items';
		$this->CI->load->library('form_validation');
		$arr_p=$this->CI->security->xss_clean($_GET);
	    $arrFilter = array(
            'type' => 'inapp',
			'id_projects' => $arr_p['id_projects'],
			'id_projects_property' => $arr_p['id_projects_property']
        );
		$this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
		$listData = $this->CI->ProjectsModel->listPayment($arrFilter);
		$this->data['listItems'] = $listData;
		$this->data['getrate'] = $this->CI->ProjectsModel->getRate($arr_p['id_projects']);
		$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'projects/popupinappplus', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function updatefiles(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật file Certificates';
		$this->CI->load->library('form_validation');
		$arr_p=$this->CI->security->xss_clean($_GET);
		$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'projects/updatefiles', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function updatefiledatabase(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$arrParam = array(
                            'files_certificates'=>"files/certificates/".$arr_p['files_certificates']
                        );
						
			$result = $this->CI->ProjectsModel->edit_field_filename($arrParam,$arr_p['id']);
			if($result){
				echo "ok";
			}else{
				echo "false";
			}
        }else{
           		echo "false id ".$arr_p['id'];
		}
        exit();
	}
	public function updaterowsitem(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$arrParam = array(
							'id'=>$arr_p['id'],
                            //'platform'=>$arr_p['cbo_platform_e'],
							'app_id'=>$arr_p['app_id_e'],
                            'package_name'=>$arr_p['package_name_e'],
							'inapp_items'=>$arr_p['inapp_items_e'],
							'public_key'=>$arr_p['public_key_e'],
							'wp_p1'=>$arr_p['wp_p1_e'],
							'wp_p2'=>$arr_p['wp_p2_e'],
							'notes'=>$arr_p['notes_p_e'],
							'pass_certificates'=>$arr_p['pass_certificates_e'],
							'api_key'=>$arr_p['api_key_e'],
							'client_key'=>$arr_p['client_key_e'],
							'url_scheme'=>$arr_p['url_scheme_e'],
							'client_secret'=>$arr_p['client_secret_e'],
							'userlog'=>$_SESSION['account']['id'],
							'cert_name'=>$arr_p['cert_name']

                        );
						
			$result = $this->CI->ProjectsModel->edit_rows_item($arrParam,$arr_p['id']);
			$arrParam['keys_name'];
			$arrParam['platform'] = $arr_p['cbo_platform_e'];
			// save log database
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"Cập nhật",
						"logs"=>json_encode($arrParam),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id(),
						"tables"=>"tbl_projects_property",
						"id_actions"=>$arr_p['id']
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			// end log
			if($result){
				echo "ok";
			}else{
				echo "false";
			}
        }else{
           		echo "false id ".$arr_p['id'];
		}
        exit();
	}
	public function editajax(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['code'])){
			//lu log rows cu truoc khi cap nhat len
			$this->data['gethistory'] = $this->CI->ProjectsModel->getItem($arr_p['id']);
			$arrParam = array(
                            'code'=>$arr_p['code'],
                            'names'=>$arr_p['names'],
                            'namesetup'=>$arr_p['namesetup'],
							'servicekeyapp'=>$arr_p['servicekeyapp'],
							'servicekey'=>$arr_p['servicekey'],
							'facebookapp'=>$arr_p['facebookapp'],
							'facebookappid'=>$arr_p['facebookappid'],
							'facebookappsecret'=>$arr_p['facebookappsecret'],
							'itunesconnect'=>$arr_p['itunesconnect'],
							'appleid'=>$arr_p['appleid'],
							'gacode'=>$arr_p['gacode'],
							'appsflyerid'=>$arr_p['appsflyerid'],
							'googleproductapi'=>$arr_p['googleproductapi'],
							'urlschemes'=>$arr_p['urlschemes'],
							'facebookurlschemes'=>$arr_p['facebookurlschemes'],
							'googlesenderid'=>$arr_p['googlesenderid'],
							'googleapikey'=>$arr_p['googleapikey'],
							'facebookfanpagelink'=>$arr_p['facebookfanpagelink'],
							'request_per'=>$arr_p['request_per'],
							'accept_per'=>$arr_p['accept_per'],
							'notes'=>$arr_p['notes'],
							'screens'=>$arr_p['screens'],
							'servicekey_second'=>$arr_p['servicekey_second'],
							'config_logout'=>$arr_p['config_logout'],
							'language_sdk'=>$arr_p['language_sdk'],
							'folder'=>$arr_p['folder']
                        );
			
			$result = $this->CI->ProjectsModel->edit_new($arrParam,$arr_p['id']);
			MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),"Edit:".json_encode($arrParam),"Uid:".$_SESSION['account']['id'],"Update:Ok"), "Projects_Log_" . date('H'));
			
			// save log database
			array_unshift($arrParam,'id');
			$arrParam['googleproductapi']=base64_encode($arr_p['googleproductapi']);
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"Cập nhật",
						"logs"=>json_encode($arrParam),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id(),
						"tables"=>"tbl_projects",
						"id_actions"=>$arr_p['id']
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			// end log
			
			if($result){
				$f = array(
					'error'=>'0',
					'messg'=>'Cập nhật thành công '.$result.$var
				);
			}else{
				$f = array(
                'error'=>'1',
                'messg'=>'Thất bại '.$result
            	);
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
        }
		
        echo json_encode($f);
        exit();
	}
	public function addajax(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['code'])){
			$arrParam = array(
                            'code'=>$arr_p['code'],
                            'names'=>$arr_p['names'],
                            'namesetup'=>$arr_p['namesetup'],
							'servicekeyapp'=>$arr_p['servicekeyapp'],
							'servicekey'=>$arr_p['servicekey'],
							'facebookapp'=>$arr_p['facebookapp'],
							'facebookappid'=>$arr_p['facebookappid'],
							'facebookappsecret'=>$arr_p['facebookappsecret'],
							'itunesconnect'=>$arr_p['itunesconnect'],
							'appleid'=>$arr_p['appleid'],
							'gacode'=>$arr_p['gacode'],
							'appsflyerid'=>$arr_p['appsflyerid'],
							'googleproductapi'=>$arr_p['googleproductapi'],
							'urlschemes'=>$arr_p['urlschemes'],
							'facebookurlschemes'=>$arr_p['facebookurlschemes'],
							'googlesenderid'=>$arr_p['googlesenderid'],
							'googleapikey'=>$arr_p['googleapikey'],
							'facebookfanpagelink'=>$arr_p['facebookfanpagelink'],
							'request_per'=>$arr_p['request_per'],
							'accept_per'=>$arr_p['accept_per'],
							'notes'=>$arr_p['notes'],
							'datecreate'=>date('Y-m-d H:i:s'),
							'status'=>1,
							'userlog'=>$_SESSION['account']['id'],
							'screens'=>$arr_p['screens'],
							'config_logout'=>$arr_p['config_logout'],
							'language_sdk'=>$arr_p['language_sdk'],
							'folder'=>$arr_p['folder']
                        );
						
			$result = $this->CI->ProjectsModel->add_new($arrParam);
			MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),"Add:".json_encode($arrParam),"Uid:".$_SESSION['account']['id'],"Add:OK"), "Projects_Log_" . date('H'));
			// save log database
			array_unshift($arrParam,'id');
			$arrParam['googleproductapi']=base64_encode($arr_p['googleproductapi']);
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"Cập nhật",
						"logs"=>json_encode($arrParam),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id(),
						"tables"=>"tbl_projects",
						"id_actions"=>$result
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			// end log
			if($result){
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công '.$result
				);
			}else{
				$f = array(
                'error'=>'1',
                'messg'=>'Thất bại '.$result
            	);
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
        }
		
        echo json_encode($f);
        exit();
	}
	public function addajaxstep2(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['cbo_platform'])){
			$arrParam = array(
                            'platform'=>$arr_p['cbo_platform'],
                            //'app_id'=>$arr_p['app_id'],
                            'package_name'=>$arr_p['package_name'],
							//'version_type'=>$arr_p['version_type'],
							'public_key'=>$arr_p['public_key'],
							//'inapp_product'=>$arr_p['inapp_product'],
							'appstore_inapp_items'=>$arr_p['appstore_inapp_items'],
							'gp_inapp_items'=>$arr_p['gp_inapp_items'],
							'notes'=>$arr_p['notes_p'],
							'datecreate'=>date('Y-m-d H:i:s'),
							'status'=>1,
							'userlog'=>$_SESSION['account']['id']
                        );
						
			$result = $this->CI->ProjectsModel->add_new_proper($arrParam,$arr_p['id_projects']);
			// save log database
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"Tạo mới [2]",
						"logs"=>json_encode($arrParam),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id()
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			// end log
			if($result){
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công '.$result
				);
			}else{
				$f = array(
                'error'=>'1',
                'messg'=>'Thất bại '.$result
            	);
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
        }
		
        echo json_encode($f);
        exit();
	}
	public function addinapp(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['id_projects'])){
			//insert payment (type inapp)
			$arrinapp=explode('|',$arr_p['code']);
			if(count($arrinapp)>0){
				for($i=0;$i<count($arrinapp);$i++){
					if($i==(count($arrinapp)-1)) break;
					$arrParam_payment = array(
						'id_projects'=>$arr_p['id_projects'],
						'id_projects_property'=>$arr_p['id_projects_property'],
						'type'=>'inapp',
						'code'=>$arrinapp[$i],
						'datecreate'=>date('Y-m-d H:i:s'),
						'status'=>1,
						'userlog'=>$_SESSION['account']['id']
					);
					$pay = $this->CI->ProjectsModel->add_payment($arrParam_payment,$arr_p['id_projects']);
				}//end for
			}
			$f = array(
			'error'=>'0',
			'messg'=>'Thành công '
			);
		}else{
			$f = array(
			'error'=>'1',
			'messg'=>'Thất bại '
			);
		}
		echo json_encode($f);
        exit();
	}
	public function addinappplus(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['id_projects'])){
			//insert payment (type inapp)
			$arrinapp=explode('|',$arr_p['code']);
			
			if(count($arrinapp)>0){
				for($i=0;$i<count($arrinapp);$i++){
					if($i==(count($arrinapp)-1)) break;
					// phan ra phan tu $arrinapp
					$item=explode(';',$arrinapp[$i]);
					
					$arrParam_payment = array(
						'id_projects'=>$arr_p['id_projects'],
						'id_projects_property'=>$arr_p['id_projects_property'],
						'type'=>'inapp',
						'code'=>$item[0],
						'promotion_gem'=>$item[1],
						'gem'=>$item[2],
						'mcoin'=>$item[3],
						'vnd'=>$item[4],
						'datecreate'=>date('Y-m-d H:i:s'),
						'status'=>1,
						'userlog'=>$_SESSION['account']['id']
					);
					$pay = $this->CI->ProjectsModel->add_payment($arrParam_payment,$arr_p['id_projects']);
				}//end for
			}
			$f = array(
			'error'=>'0',
			'messg'=>'Thành công '
			);
		}else{
			$f = array(
			'error'=>'1',
			'messg'=>'Thất bại '
			);
		}
		echo json_encode($f);
        exit();
	}
	public function addpaymentplus(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['code'])){
			//insert payment (type inapp)
			$arrinapp=explode('|',$arr_p['code']);
			
			if(count($arrinapp)>0){
				for($i=0;$i<count($arrinapp);$i++){
					if($i==(count($arrinapp)-1)) break;
					// phan ra phan tu $arrinapp
					$item=explode(';',$arrinapp[$i]);
					$v_type=explode(':',$item[0]);
					$v_code=explode(':',$item[1]);
					$v_vnd=explode(':',$item[2]);
					$v_mcoin=explode(':',$item[3]);
					$v_gem=explode(':',$item[4]);
					$v_promotion_gem=explode(':',$item[5]);
					$v_notes=explode(':',$item[6]);
					$arrParam_payment = array(
						'id_projects'=>$arr_p['id_projects'],
						'id_projects_property'=>-1,
						'type'=>trim($v_type[1]),
						'code'=>$v_code[1],
						'promotion_gem'=>trim(str_replace(',','',$v_promotion_gem[1])),
						'gem'=>trim(str_replace(',','',$v_gem[1])),
						'mcoin'=>trim(str_replace(',','',$v_mcoin[1])),
						'vnd'=>trim(str_replace(',','',$v_vnd[1])),
						'notes'=>$v_notes[1],
						'datecreate'=>date('Y-m-d H:i:s'),
						'status'=>1,
						'userlog'=>$_SESSION['account']['id']
					);
					$pay = $this->CI->ProjectsModel->add_payment_plus($arrParam_payment);
				}//end for
			} //end if
			
			$f = array(
			'error'=>'0',
			'messg'=>'Thành công '
			);
		}else{
			$f = array(
			'error'=>'1',
			'messg'=>'Thất bại '
			);
		}
		echo json_encode($f);
        exit();
	}
	public function addpaymentplusforinapp(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['code'])){
			//insert payment (type inapp)
			$arrinapp=explode('|',$arr_p['code']);
			
			if(count($arrinapp)>0){
				for($i=0;$i<count($arrinapp);$i++){
					if($i==(count($arrinapp)-1)) break;
					// phan ra phan tu $arrinapp
					$item=explode(';',$arrinapp[$i]);
					$v_type=explode(':',$item[0]);
					$v_code=explode(':',$item[1]);
					$v_vnd=explode(':',$item[2]);
					$v_mcoin=explode(':',$item[3]);
					$v_gem=explode(':',$item[4]);
					$v_promotion_gem=explode(':',$item[5]);
					$v_notes=explode(':',$item[6]);
					$v_id_projects_property=explode(':',$item[7]);
					$arrParam_payment = array(
						'id_projects'=>$arr_p['id_projects'],
						'id_projects_property'=>$v_id_projects_property[1],
						'type'=>trim($v_type[1]),
						'code'=>$v_code[1],
						'promotion_gem'=>trim(str_replace(',','',$v_promotion_gem[1])),
						'gem'=>trim(str_replace(',','',$v_gem[1])),
						'mcoin'=>trim(str_replace(',','',$v_mcoin[1])),
						'vnd'=>trim(str_replace(',','',$v_vnd[1])),
						'notes'=>$v_notes[1],
						'datecreate'=>date('Y-m-d H:i:s'),
						'status'=>1,
						'userlog'=>$_SESSION['account']['id']
					);
					$pay = $this->CI->ProjectsModel->add_payment_plus($arrParam_payment);
				}//end for
			} //end if
			
			$f = array(
			'error'=>'0',
			'messg'=>'Thành công '
			);
		}else{
			$f = array(
			'error'=>'1',
			'messg'=>'Thất bại '
			);
		}
		echo json_encode($f);
        exit();
	}
	public function addajaxstep2new(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['cbo_platform'])){
			$arrParam = array(
                            'platform'=>$arr_p['cbo_platform'],
                            'package_name'=>$arr_p['package_name'],
							'public_key'=>$arr_p['public_key'],
							'inapp_items'=>$arr_p['inapp_items'],
							'wp_p1'=>$arr_p['wp_p1'],
							'wp_p2'=>$arr_p['wp_p2'],
							'notes'=>$arr_p['notes_p'],
							'datecreate'=>date('Y-m-d H:i:s'),
							'status'=>1,
							'userlog'=>$_SESSION['account']['id'],
							'files_certificates'=>"files/certificates/".$arr_p['files_certificates'],
							'pass_certificates'=>$arr_p['pass_certificates'],
							'api_key'=>$arr_p['api_key'],
							'client_key'=>$arr_p['client_key'],
							'url_scheme'=>$arr_p['url_scheme'],
							'client_secret'=>$arr_p['client_secret'],
							'app_id'=>$arr_p['app_id'],
							'cert_name'=>$arr_p['cert_name']
                        );
						
			$result = $this->CI->ProjectsModel->add_new_proper_new($arrParam,$arr_p['id_projects']);
			//insert payment (type inapp)
			$arrinapp=explode('|',$arr_p['inapp_items']);
			if(count($arrinapp)>0){
				for($i=0;$i<count($arrinapp);$i++){
					if($i==(count($arrinapp)-1)) break;
					$arrParam_payment = array(
						'type'=>'inapp',
						'code'=>$arrinapp[$i],
						'datecreate'=>date('Y-m-d H:i:s'),
						'status'=>1,
						'userlog'=>$_SESSION['account']['id']
					);
					$pay = $this->CI->ProjectsModel->add_payment($arrParam_payment,$arr_p['id_projects']);
				}//end for
			}
			// save log database
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"Tạo mới [2]",
						"logs"=>json_encode($arrParam),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id()
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			// end log
			if($result){
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công '
				);
			}else{
				$f = array(
                'error'=>'1',
                'messg'=>'Thất bại '.$result
            	);
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
        }
		
        echo json_encode($f);
        exit();
	} // end 2 new
	
	public function deleteoneitemrow(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			//lu log rows cu truoc khi cap nhat len
			$this->data['gethistory'] = $this->CI->ProjectsModel->getItem($arr_p['id']);
			// save log database
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"Xóa dữ liệu [1]",
						"logs"=>json_encode($this->data['gethistory']),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id()
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			$result = $this->CI->ProjectsModel->deleteoneitem($arr_p['id']);
			// end log
			if($result!=NULL){
				$data['info'] ='Xóa thành công';
			}else{
				$data['info']='Không thể xóa dòng này, đang có dữ liệu tham chiếu đến';
			}
        }else{
            $data['info'] ='Xóa thất bại';
        }
       redirect($this->_mainAction."&info=".base64_encode($data['info']));
	}
	public function loadlist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		 if($arr_p['isok']>0){
            $data['list'] = $this->CI->ProjectsModel->loadlist();
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('projects/list', $data, true)
            );
        }else{
            $data['list'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('projects/list', $data, true)
            );
        }
        echo json_encode($f);
        exit();
	}
	public function loadlistplus(){
		 if($_GET['id_project']>0){
			 	$fillter=isset($_GET['fillter'])?$_GET['fillter']:"";
			 	//phan trang ajax
			 	$this->CI->load->MeAPI_Library('Pgt');
			    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
					$page = $_GET['page'];
				}else{
					$page = 1;
				}
			   
				$per_page = 15;
				$pa = $page - 1;
				$start = $pa * $per_page;
		
				//$data['start'] = $start;
				$listItems = $this->CI->ProjectsModel->loadlistplus($_GET['id_project'],$fillter);
				
				$total = count($listItems);
				$config = array();
				$config['cur_page'] = $page;
				$config['base_url'] = base_url() . '?control=projects&func=loadlistplus';
				$config['total_rows'] = $total;
				$config['per_page'] = $per_page;
				$this->CI->Pgt->cfig($config);
        		$data['pages'] = $this->CI->Pgt->create_links_ajax();
				$listData = FALSE;
				if(empty($listItems) !== TRUE){
					$listData = array_slice($listItems, $start, $per_page);
				}
				$data['slbUser'] = $this->CI->ProjectsModel->listUser();
            	$data['list'] = $listData;
				$data['total']=$total;
			if($data['list']!=0){
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công',
					'html'=>$this->CI->load->view('projects/list', $data, true)
				);
			}else{
				$data['list'] = array();
				 $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('projects/list', $data, true)
            	 );
			}
        }else{
            $data['list'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('projects/list', $data, true)
            );
        }
        echo json_encode($f);
        exit();
	}
	//xoa 1 phan tu in app item
	public function deletedinappitem(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$arrParam=array(
				'id'=>$arr_p['id']
			);
			$reults = $this->CI->ProjectsModel->deletePayment($arrParam,0);
			if($reults){
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công '
				);
			}else{
				$f = array(
					'error'=>'1',
					'messg'=>'Thất bại '
				);
				
			}
		}else{
			$f = array(
					'error'=>'1',
					'messg'=>'Thất bại '
			);
		}
		echo json_encode($f);
        exit();
	}
	//ham xoa payment theo cap cha
	public function deleteListPayment($id_projects,$id_projects_property,$type){
			$isok=true;
		    $arrParam=array(
				'id_projects'=>$id_projects,
				'id_projects_property'=>$id_projects_property
			);
			$reults = $this->CI->ProjectsModel->deletePayment($arrParam,$type);
			if($reults){
				$isok=true;
			}else{
				$isok=false;
			}
			return $isok;
	}
	public function deletelistinappitem(){
			$arr_p=$this->CI->security->xss_clean($_GET);
			$this->data['gethistory'] = $this->CI->ProjectsModel->getPayment($arr_p['id']);
			if($arr_p['id']>0){
				$arrParam=array(
					'id'=>$arr_p['id']
				);
				$reults = $this->CI->ProjectsModel->deletePayment($arrParam,0);
				//ghi nhat ky
				// save log database
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"Xóa Payment",
						"logs"=>json_encode($this->data['gethistory']),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id(),
						"tables"=>"tbl_projects_payment"
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
				if($reults){
					$f = array(
						'error'=>'0',
						'messg'=>'Thành công '.$reults
					);
				}else{
					$f = array(
						'error'=>'1',
						'messg'=>'Thất bại '.$reults
					);
					
				}
			}else{
				 $f = array(
					'error'=>'1',
					'messg'=>'Thất bại'
				 );
			}
	    echo json_encode($f);
        exit();
	}
	
	public function deletelist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
            //lu log rows cu truoc khi cap nhat len
			$this->data['gethistory'] = $this->CI->ProjectsModel->getItemChild($arr_p['id']);
			// save log database
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"Xóa dữ liệu [2]",
						"logs"=>json_encode($this->data['gethistory']),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id()
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			// end log
			//kiem tra xem co payment hay khong
			$pay=$this->deleteListPayment($arr_p['id_projects'],$arr_p['id'],1);
			if($pay){
				$reults = $this->CI->ProjectsModel->deletelistitem($arr_p['id']);
				if($reults){
					$f = array(
						'error'=>'0',
						'messg'=>'Thành công '.$reults
					);
				}else{
					$f = array(
						'error'=>'1',
						'messg'=>'Thất bại '.$reults
					);
					
				}
			}else{
					$f = array(
						'error'=>'1',
						'messg'=>'Không xóa được Payment'.$pay
					);
					
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
			
        }
        echo json_encode($f);
        exit();
	}
	public function checkpayment(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		$reults = $this->CI->ProjectsModel->checkListPayment($arr_p['id_projects'],$arr_p['id_projects_property']);
		if($reults == true){
			$f = array(
				'error'=>'0',
				'messg'=>'Có paymnet'
			);
		}else{
			$f = array(
				'error'=>'1',
				'messg'=>'Không có payment'
			);
		}
        echo json_encode($f);
        exit();
	}
	
	/* kiểm tra trùng mã Projects */
	public function checkcodeexist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		$reults = $this->CI->ProjectsModel->checkcodeexist($arr_p['code']);
		if($reults == true){
			$f = array(
				'error'=>'0',
				'messg'=>'Mã đã tồn tại'
			);
		}else{
			$f = array(
				'error'=>'1',
				'messg'=>'Chưa có mã này'
			);
		}
        echo json_encode($f);
        exit();
	}
	/* kiểm tra trùng mã Bundle/Package */
	public function checkbundleisexit(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['types']=="edit"){
			$reults = $this->CI->ProjectsModel->bundleisexit($arr_p,"edit");
		}else{
			$reults = $this->CI->ProjectsModel->bundleisexit($arr_p,"add");
		}
		
		if($reults == true){
			$f = array(
				'error'=>'0',
				'messg'=>'Bundle/Package đã tồn tại'
			);
		}else{
			$f = array(
				'error'=>'1',
				'messg'=>'Chưa có Bundle/Package này'
			);
		}
        echo json_encode($f);
        exit();
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
	//add 22_09_2015
	public function viewpayment(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
		$this->CI->load->MeAPI_Library('Pgt');
		$this->data['error'] = '';
		$this->CI->load->library('form_validation');
		$arrPost = $this->CI->security->xss_clean($_POST);
		$arrGet = $this->CI->security->xss_clean($_GET);
		$this->data['getitem'] = $this->CI->ProjectsModel->getItem($arrGet['id_projects']);
		$this->data['title'] = 'Thông tin Payment của Game <strong style="color:#BB25AE">'.$this->data['getitem']['names'].'</strong>';
		if(isset($_POST['btn_update_rate'])){
			$arr_param=array(
						"id_projects"=>$arrGet['id_projects'],
						"mcoin"=>$arrPost['rate_mcoin'],
						"gem"=>$arrPost['rate_gem'],
						"units"=>$arrPost['units'],
						"datecreate"=>date('Y-m-d H:i:s'),
						"userlog"=>$_SESSION['account']['id']
			);
			$rate=$this->CI->ProjectsModel->update_rate($arr_param);
			//cap nhat lai tat ca ty gia trong bang payment theo projects
			$rate_payment=$this->CI->ProjectsModel->update_rate_payment($arr_param,1);
		}
		$this->data['getrate'] = $this->CI->ProjectsModel->getRate($arrGet['id_projects']); 
		if(isset($arrGet['action']) && $arrGet['action']=="add"){
			$arr_param=array(
						"id_projects"=>$arrGet['id_projects'],
						"type"=>$arrPost['cbo_type'],
						"code"=>$arrPost['code'],
						"promotion_gem"=>$arrPost['promotion_gem'],
						"gem"=>$arrPost['gem'],
						"mcoin"=>$arrPost['mcoin'],
						"vnd"=>$arrPost['vnd'],
						"notes"=>$arrPost['notes'],
						"datecreate"=>date('Y-m-d H:i:s'),
						"status"=>1,
						"userlog"=>$_SESSION['account']['id']
			);
			$result=$this->CI->ProjectsModel->add_payment_plus($arr_param);
			if($result){
				$this->data['error']="Thêm mới Payment thành công";
			}else{
				$this->data['error']="Không thêm được";
			}
		}
		//load danh sách
		 //$arrFilter = array();
		 if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
			$arrFilter = array(
				'id_projects'=>$arrGet['id_projects'],
                'page' => $page
            );
            //$arrFilter["page"] = $page;
        }else {            
            $arrFilter = array(
				'id_projects'=>$arrGet['id_projects'],
                'page' => 1
            );
            $page = 1;
        }
		//get platform on tbl_projects_property1
		$this->data['tpp1']=$this->CI->ProjectsModel->getListChildByIdparrent($arrGet['id_projects']);
		
		$per_page = 100000;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->ProjectsModel->listPaymentView($arrFilter);
		
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=viewpayment&id_projects='.$_GET['id_projects'];
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
		//$listData = $this->CI->ProjectsModel->listPaymentView($arrFilter);
		$this->data['property']=$this->CI->ProjectsModel->listProjectsProperty(intval($_GET['id_projects']));
		$this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
		$this->data['listData']=$listData;
        $this->CI->template->write_view('content', 'projects/viewpayment', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function paymentlist(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['getitem'] = $this->CI->ProjectsModel->getItem($_GET['id_projects']); 
        $this->data['title'] = 'Thông tin Payment [<strong style="color:#090">'.$_GET['info_package'].'</strong>] thuộc Projects [<strong style="color:#090">'.$this->data['getitem']['names'].'</strong>]';
		$this->data['error'] = '';
		$this->CI->load->library('form_validation');
		$arrPost = $this->CI->security->xss_clean($_POST);
		$arrGet = $this->CI->security->xss_clean($_GET);
		if(isset($arrGet['action']) && $arrGet['action']=="add"){
			$arr_param=array(
						"id_projects"=>$arrGet['id_projects'],
						"id_projects_property"=>$arrGet['id_projects_property'],
						"type"=>$arrPost['cbo_type'],
						"code"=>$arrPost['code'],
						"promotion_gem"=>trim(str_replace(',','',$arrPost['promotion_gem'])),
						"gem"=>trim(str_replace(',','',$arrPost['gem'])),
						"mcoin"=>trim(str_replace(',','',$arrPost['mcoin'])),
						"vnd"=>trim(str_replace(',','',$arrPost['vnd'])),
						"notes"=>$arrPost['notes'],
						"datecreate"=>date('Y-m-d H:i:s'),
						"status"=>1,
						"userlog"=>$_SESSION['account']['id']
			);
			$result=$this->CI->ProjectsModel->add_payment_plus($arr_param);
			if($result){
				$this->data['error']="Thêm mới Payment thành công";
			}else{
				$this->data['error']="Không thêm được";
			}
			redirect(base_url()."?control=projects&func=paymentlist&id_projects=".$_GET['id_projects']."&id_projects_property=".$_GET['id_projects_property']."&info_package=".$_GET['info_package']);
		}
		//load danh sách InAppItem
		$arrFilter = array(
            'type' => 'inapp',
			'id_projects' => $arrGet['id_projects'],
			'id_projects_property' => $arrGet['id_projects_property']
        );
		$this->data['getrate'] = $this->CI->ProjectsModel->getRate($arrGet['id_projects']);
		$this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
		$listData = $this->CI->ProjectsModel->listPayment($arrFilter);
		$this->data['listData']=$listData;
        $this->CI->template->write_view('content', 'projects/paymentlist', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	} // end function
	
	public function updaterowsinappitem(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$arrParam = array(
							'id'=>$arr_p['id'],
                            'code'=>$arr_p['code_e'],
							'promotion_gem'=>trim(str_replace(',','',$arr_p['promotion_gem_e'])),
                            'gem'=>trim(str_replace(',','',$arr_p['gem_e'])),
							'mcoin'=>trim(str_replace(',','',$arr_p['mcoin_e'])),
							'vnd'=>trim(str_replace(',','',$arr_p['vnd_e'])),
							'notes'=>$arr_p['notes_e'],
							"datecreate"=>date('Y-m-d H:i:s'),
							"userlog"=>$_SESSION['account']['id']
                        );
						
			$result = $this->CI->ProjectsModel->edit_rows_item_payment($arrParam,$arr_p['id']);
			// save log database
			$arrParam['type']="inapp";
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"update_payment_inapp",
						"logs"=>json_encode($arrParam),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id(),
						"tables"=>"tbl_projects_payment",
						"id_actions"=>$arr_p['id']
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			// end log
			if($result){
				echo "ok";
			}else{
				echo "false";
			}
        }else{
           		echo "false id ".$arr_p['id'];
		}
        exit();
	}//end function
	
	public function updaterate(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id_projects']>0){
			$arrParam = array(
							'id_projects'=>$arr_p['id_projects'],
                            'mcoin'=>$arr_p['mcoin'],
                            'gem'=>$arr_p['gem'],
							"datecreate"=>date('Y-m-d H:i:s'),
							'userlog'=>$_SESSION['account']['id']
                        );
						
			$rate=$this->CI->ProjectsModel->update_rate($arrParam);
			//cap nhat lai tat ca ty gia trong bang payment theo projects
			$rate_payment=$this->CI->ProjectsModel->update_rate_payment($arrParam,1);
			if($rate_payment){
				echo "ok";
			}else{
				echo "false";
			}
        }else{
           		echo "false id ".$arr_p['id'];
		}
        exit();
	}//end function
	public function getpackage(){
        if(isset($_GET['id_projects'])){
            $data['package'] = $this->CI->ProjectsModel->getpackagename($_GET['id_projects'],$_GET['platform']);
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('projects/cbo_pakage', $data, true)
            );
        }else{
            $data['package'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('projects/cbo_pakage', $data, true)
            );
        }
		
        echo json_encode($f);
        exit();
    }
    public function getResponse() {
        return $this->_response;
    }
}
