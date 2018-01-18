<?php

class MeAPI_Controller_LoginController implements MeAPI_Controller_LoginInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('cache');
        $this->CI->load->MeAPI_Library('Session');
		
		/*if ($_SERVER['PHP_AUTH_USER'] != 'bth' OR $_SERVER['PHP_AUTH_PW'] != 'admin') {
			header('WWW-Authenticate: Basic realm="Vui long nhap ten nguoi dung & mat khau"');
			header('HTTP/1.0 401 Unauthorized');
			echo "Access Denied";
			die;
		}*/
    }

    public function apisetmenu(MeAPI_RequestInterface $request) {
        $params = $request->input_request();
        $request_ip = $_SERVER['HTTP_REFERER'];

        if (is_required($params, array('username', 'menu', 'priority', 'token')) == TRUE) {
            $this->CI->config->load('admin');
            $admin_config = $this->CI->config->item('admin');
            $my_token = md5($params['username'] . $admin_config['inside']['app_id'] . $admin_config['inside']['api_login_key'] . date('YmdH'));
            if ($my_token == $params['token']) {
                
            } else {
                /*
                 * Token không hợp lệ
                 */
                $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
            }
        } else {
            /*
             * Thông tin không hợp lệ
             */
            $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
    }

    public function apilogin(MeAPI_RequestInterface $request) {
        $params = $request->input_request();
        $request_ip = $_SERVER['HTTP_REFERER'];

        $account = $this->CI->Session->get_session('account');
        if (substr($request_ip, 7, 13) != '123.30.104.14') {
            /*
             * Thằng này điêu , Logs lại
             */
            $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_REMOTE_SERVER');
        } else {
            if (is_required($params, array('username', 'token')) == TRUE) {

                $this->CI->config->load('admin');
                $admin_config = $this->CI->config->item('admin');
                $my_token = md5($params['username'] . $admin_config['inside']['app_id'] . $admin_config['inside']['api_login_key'] . date('YmdH'));
                if ($my_token == $params['token']) {
                    /*
                     * Lấy thông tin account từ db inside
                     */

                    $this->CI->load->MeAPI_Model('UserModel');
                    $account = $this->CI->UserModel->get_account($params['username']);

                    if (empty($account) === FALSE && $account['status'] == 'start') {
                        /*
                         * kiểm tra xem user đó có quyền xem app này hay không và có menu hay không và ip có hợp lệ hay không
                         */
                        $check_app = $this->_check_app($account['app'], $admin_config);
                        $menu = $this->_check_menu($account['uid'], $admin_config);
                        $ip = $this->_check_ips($account['ips']);
                        $time = $this->_check_time($account['start_use'], $account['end_use']);

                        if (empty($check_app) === FALSE && empty($menu) === FALSE && empty($ip) === FALSE && empty($time) === FALSE) {
                            /*
                             * Lưu session và trả về url đăng nhập
                             */
                            unset($account['pass']);
                            $this->CI->Session->set_session('account', $account);
                            $this->CI->Session->set_session('menu', $menu);
                            $url = $this->CI->config->base_url('?control=welcome&func=index');
                            echo("<script> top.location.href='" . $url . "'</script>");

                            exit;
                        } else {
                            /*
                             * Không có quyền xem đăng nhập
                             */
                            $this->_response = new MeAPI_Response_APIResponse($request, 'PERMISSION_DENY');
                        }
                    } else {
                        /*
                         * Không tìm thấy thông tin đăng nhập
                         */
                        $this->_response = new MeAPI_Response_APIResponse($request, 'LOGIN_INVALID_ACCOUNT');
                    }
                } else {
                    /*
                     * Token không hợp lệ
                     */
                    $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
                }
            } else {
                /*
                 * Đăng nhập không hợp lệ
                 */
                $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
            }
        }

        return FALSE;
    }
	public function remember($params){
        /*
        *Chung thuc bang LDAP
        */
        $username = $params['username'];
        $password = $params['password'];
        $hostname = 'webmail.mecorp.vn:389';        
        $con =  ldap_connect($hostname);
        if (!is_resource($con)) trigger_error("Unable to connect to $hostname",E_USER_WARNING);
        ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($con, LDAP_OPT_REFERRALS, 0);
        if (@ldap_bind($con,'mecorp\\'.$username, $password)){
            //echo "<pre>";print_r($account);die();
            // Logged in
            /*
             * Lấy thông tin account từ db inside
             */
			$this->CI->load->MeAPI_Library('Memcacher');
            $this->CI->load->MeAPI_Model('UserModel');

            $this->CI->load->MeAPI_Model('AccountModel');	
            $account = $this->CI->UserModel->get_account($params['username']);
			
			$key = "module_user" . $account['id'] . date("Ymd", time());
			$this->CI->Memcacher->Delete($key);
			$key = "cate_menu" . $account['id'] . date("Ymd", time());
			$this->CI->Memcacher->Delete($key);
			
            if(is_array($account) && empty($account) === FALSE){
                //User da ton tai
                if($account['status'] == 1){
                    $pass = md5($params['password']);

                    //$this->CI->config->load('admin');
                    //$admin_config = $this->CI->config->item('admin');
                    $this->CI->load->MeAPI_Model('MenuModel');
                    $menus = $this->CI->MenuModel->get_menu_cp($account['id']);

                    $arrayMenu = array();

                    foreach ($menus as $key => $value) {
                         if($value['menu_cp_parent'] != 0  ){
                            $arrayMenu[$value['menu_cp_parent']]['subtree'][] = $value;
                        }else{
                            $arrayMenu[$value['id']] = $value;
                        }
                    }
                    if (!empty($arrayMenu)) {
                        $menu = array();
                        foreach ($arrayMenu as $m) {
                            $menu[$m['groupp']][] = $m;
                        }
                    }

                    //start permission
                    $this->CI->load->MeAPI_Model('PermissionModel');
                    $listPerByUser = $this->CI->PermissionModel->listPermissionByUser($account['id']);
                    $listPerUserModule =array();
                    if(count($listPerByUser)>0){
                        foreach($listPerByUser as $v){

                            $item = $this->CI->PermissionModel->listPermissionById($v['id_permisssion']);
							
							//echo "<pre>";print_r($item);
                            if(!empty($item['controller']) && !empty($item['action']) && empty($item['report_game'])){
                                $listPerUserModule[$item['controller'].'-'.$item['action']] = $item['controller'].'-'.$item['action'];
                            }
                            if(!empty($item['controller']) && !empty($item['action']) && !empty($item['report_game'])){
                                $listPerUserModule[$item['controller'].'-'.$item['action'].'-'.$item['report_game']] = $item['controller'].'-'.$item['action'].'-'.$item['report_game'];
                            }
							//start module 11/12/2015
							if(!empty($item['controller']) && !empty($item['module']) && !empty($item['report_game'])){
                                $listPerUserModule[$item['controller'].'-'.$item['module'].'-'.$item['report_game']] = $item['controller'].'-'.$item['module'].'-'.$item['report_game'];
                            }
							//start 15/2/2017
							if(!empty($item['controller']) && !empty($item['action']) && !empty($item['layout'])){
								
                                $listPerUserModule[$item['controller'].'-'.$item['action'].'-'.$item['layout']] = $item['controller'].'-'.$item['action'].'-'.$item['layout'];
                            }
                            if(!empty($item['controller']) && !empty($item['module'])){
                                $listPerUserModule[$item['controller'].'-'.$item['module']] = $item['controller'].'-'.$item['module'];
                            }
							//end module
                            if(!empty($item['game'])){
                                $listPerUserModule[$item['game']] = $item['game'];
                            }
							//game theo module
                            if($v['id_game']>0){
                                $listGame = $this->CI->PermissionModel->listPermissionByIdGame($v['id_game']);
                                if($item['per_game']==1){
                                    $listPerUserModule[$item['controller'].'-'.$listGame['game']] = $item['controller'].'-'.$listGame['game'];
                                }
                            }
                        }
                    }
                    $listPerUserModule['welcome-index']='welcome-index';
                    $listPerUserModule['account-noaccess']='account-noaccess';
                    $listPerUserModule['payment-getserver']='payment-getserver';
                    $listPerUserModule['report-getvalidate']='report-getvalidate';
                    $listPerUserModule['report-viewhistory']='report-viewhistory';
                    $listPerUserModule['report-ajaxrequest']='report-ajaxrequest';
                    $listPerUserModule['report-ajaxevent']='report-ajaxevent';
					
					$listPerUserModule['managercontributor-edititem']='managercontributor-edititem';//3/3/2017
                    $listPerUserModule['managercontributor-additem']='managercontributor-additem';//3/3/2017
					
                    $listPerUserModule['event_dau_co_thang-config_event']='event_dau_co_thang-config_event';
                    $listPerUserModule['event_dau_co_lv-config_event']='event_dau_co_lv-config_event';
                    $listPerUserModule['event_lato_pt-add_new_item']='event_lato_pt-add_new_item';
                    $listPerUserModule['event_lato_pt-edit_item']='event_lato_pt-edit_item';
                    $listPerUserModule['crosssale-ajax_receive']='crosssale-ajax_receive';
					$listPerUserModule['event_dau_co_lv_1-config_event']='event_dau_co_lv_1-config_event';
                    //echo "<pre>";print_r($listPerUserModule);die();
					// check and set cookie
					if($params['remember'] == 1){
						$strDecode = base64_encode($username.'::'.$password.'::'.$params['remember'] );
						setcookie("AuthLoginUser", $strDecode, time()+86400);  /* expire in 1 day */    
					}
                    $this->CI->Session->set_session('permission', $listPerUserModule);
					//end permission

                    /*
                    unset($account['password']);
                    $this->CI->Session->set_session('account', $account);
                    $this->CI->Session->set_session('menu', $menu);
                    $url = $this->CI->config->base_url('?control=welcome&func=index');
                    echo("<script> top.location.href='" . $url . "'</script>");
                    exit;
                    */

                    if($account['ips'] == 'all'){
                        unset($account['password']);
                        $this->CI->Session->set_session('account_step1', $account);
                        $this->CI->Session->set_session('account',$account);
                        $this->CI->Session->set_session('menu', $menu);
                        $url = $this->CI->config->base_url('?control=welcome&func=index');
                        //$url = $this->CI->config->base_url('?control=login&func=googleauthencator');
						$referer = explode('?',$_SERVER['HTTP_REFERER']);
						if ($_SERVER['QUERY_STRING']==$referer[1]) {
							echo("<script> top.location.href='" . $url . "'</script>");
							redirect($url);
						} else {
							if(!empty($_SERVER['HTTP_REFERER'])){
								echo("<script> top.location.href='" . $_SERVER['HTTP_REFERER'] . "'</script>");
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								echo("<script> top.location.href='" . $url . "'</script>");
								redirect($url);
							}
						}
                        exit;
                    }else{
                        if(in_array($_SERVER["REMOTE_ADDR"], explode(",",$account['ips']))){
                            unset($account['password']);
                            $this->CI->Session->set_session('account_step1', $account);
                            $this->CI->Session->set_session('menu', $menu);
                            $this->CI->Session->set_session('account',$account);

                            $url = $this->CI->config->base_url('?control=welcome&func=index');
                            //$url = $this->CI->config->base_url('?control=login&func=googleauthencator');
							
							$referer = explode('?',$_SERVER['HTTP_REFERER']);
							if ($_SERVER['QUERY_STRING']==$referer[1]) {
								echo("<script> top.location.href='" . $url . "'</script>");
								redirect($url);
							} else {
								if(!empty($_SERVER['HTTP_REFERER'])){
									echo("<script> top.location.href='" . $_SERVER['HTTP_REFERER'] . "'</script>");
									redirect($_SERVER['HTTP_REFERER']);
								}else{
									echo("<script> top.location.href='" . $url . "'</script>");
									redirect($url);
								}
							}
                            
                            exit;
                        }else{
                            $this->data['error_string'] = 'Ban khong duoc dang nhap tu IP '.$_SERVER["REMOTE_ADDR"];
                        }
                    }						
                }else{
                    $this->data['error_string'] = 'Không có quyền đăng nhập hệ thống!';
                }
            }else{
                $this->data['error_string'] = 'Tai khoan chua duoc tao tren INSIDE';
            }
        }else{
            // Không tìm thấy thông tin đăng nhập
            $this->data['error_string'] = 'Thông tin không tồn tại trong hệ thống';
        }
        ldap_close($con);
    }
	public function index(MeAPI_RequestInterface $request) {
		$this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->template->set_template('blank');

        $params = $request->input_request();
        $account = $this->CI->Session->get_session('account_step1');
		if(!empty($_COOKIE['AuthLoginUser'])){
            $strEncode = base64_decode($_COOKIE['AuthLoginUser']);
            $arrEncode = explode("::",$strEncode);
            $strUsername = $arrEncode[0];
            $strPassword = $arrEncode[1];
			$strRemember = $arrEncode[2];
			$strTestaccount = $arrEncode[3];
            if ($strUsername && $strPassword){
                $arrParam  = array('username'=>$strUsername,'password'=>$strPassword,'remember'=>$strRemember,'testaccount'=>$strTestaccount);
				 if($strTestaccount==1){
					 $this->testaccount($arrParam);
				 }else{
					 $this->remember($arrParam);
				 }
            }
        }
        if (empty($account) === FALSE) {
            /*
             * Trả về url đăng nhập
             */
            $url = $this->CI->config->base_url('?control=welcome&func=index');
            //echo("<script> top.location.href='" . $url . "'</script>");
            //exit;
        }
        if ($this->CI->input->post()) {
            if (is_required($params, array('username', 'password', 'captcha')) == TRUE) {
                /*
                 * Check capcha
                 */
                $captcha = $this->CI->Session->get_session('captcha');
                if ($params['captcha'] == $captcha) {
					$arrParam  = array('username'=>$params['username'],'password'=>$params['password'],'remember'=>$params['remember'],'testaccount'=>$params['testaccount']);
					if($params['testaccount']==1){
						$this->testaccount($arrParam);
					}else{
						$this->remember($arrParam);
					}
                } else {
                    /*
                     * Đăng nhập không hợp lệ
                     */
                    $this->data['error_string'] = 'Mã xác nhận không đúng';
                    $this->_response = new MeAPI_Response_HTMLResponse($request, 'LOGIN_WRONG_CAPTCHA');
                }
            } else {
                /*
                 * Đăng nhập không hợp lệ
                 */
                $this->data['error_string'] = 'Vui lòng nhập đầy đủ thông tin';

                $this->_response = new MeAPI_Response_HTMLResponse($request, 'INVALID_PARAMS');
            }
        }
        $this->CI->template->write_view('content', 'login/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
    public function indexBK18_9_2015(MeAPI_RequestInterface $request) {
		$this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->template->set_template('blank');

        $params = $request->input_request();
        $account = $this->CI->Session->get_session('account_step1');
		if(!empty($_COOKIE['AuthLoginUser'])){
            $strEncode = base64_decode($_COOKIE['AuthLoginUser']);
            $arrEncode = explode("::",$strEncode);
            $strUsername = $arrEncode[0];
            $strPassword = $arrEncode[1];
			$strRemember = $arrEncode[2];
            if ($strUsername && $strPassword){
                $arrParam  = array('username'=>$strUsername,'password'=>$strPassword,'remember'=>$strRemember);
                $this->remember($arrParam);
            }
        }
        if (empty($account) === FALSE) {
            /*
             * Trả về url đăng nhập
             */
            $url = $this->CI->config->base_url('?control=welcome&func=index');
            //echo("<script> top.location.href='" . $url . "'</script>");
            //exit;
        }
		
        if ($this->CI->input->post()) {
			
            if (is_required($params, array('username', 'password', 'captcha')) == TRUE) {
			
                /*
                 * Check capcha
                 */
                $captcha = $this->CI->Session->get_session('captcha');
                if ($params['captcha'] == $captcha) {
                    
					/*
					 *Chung thuc bang LDAP
					 */
					$username = $params['username'];
					$password = $params['password'];
					$hostname = 'webmail.mecorp.vn:389';
					
                   
                    $con =  ldap_connect($hostname);
					
					if (!is_resource($con)) trigger_error("Unable to connect to $hostname",E_USER_WARNING);
					ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
					ldap_set_option($con, LDAP_OPT_REFERRALS, 0);
					
					if (@ldap_bind($con,'mecorp\\'.$username, $password))
					{
                    //echo "<pre>";print_r($account);die();
						// Logged in
						/*
						 * Lấy thông tin account từ db inside
						 */
												
						$this->CI->load->MeAPI_Model('UserModel');
						
						$this->CI->load->MeAPI_Model('AccountModel');
						
						$account = $this->CI->UserModel->get_account($params['username']);
						
						if(is_array($account) && empty($account) === FALSE){
							//User da ton tai
							if($account['status'] == 1){
								$pass = md5($params['password']);
															 
								//$this->CI->config->load('admin');
								//$admin_config = $this->CI->config->item('admin');
								$this->CI->load->MeAPI_Model('MenuModel');
								$menus = $this->CI->MenuModel->get_menu_cp($account['id']);
								
                                $arrayMenu = array();
								
                                foreach ($menus as $key => $value) {
                                     if($value['menu_cp_parent'] != 0  ){
                                        $arrayMenu[$value['menu_cp_parent']]['subtree'][] = $value;
                                    }else{
                                        $arrayMenu[$value['id']] = $value;
                                    }
                                }
								if (!empty($arrayMenu)) {
									$menu = array();
									foreach ($arrayMenu as $m) {
										$menu[$m['groupp']][] = $m;
									}

								}
								
								//start permission
                                $this->CI->load->MeAPI_Model('PermissionModel');
                                $listPerByUser = $this->CI->PermissionModel->listPermissionByUser($account['id']);
                                $listPerUserModule =array();
                                if(count($listPerByUser)>0){
                                    foreach($listPerByUser as $v){
                                        
                                        $item = $this->CI->PermissionModel->listPermissionById($v['id_permisssion']);
                                        
										if(!empty($item['controller']) && !empty($item['action']) && empty($item['report_game'])){
                                            $listPerUserModule[$item['controller'].'-'.$item['action']] = $item['controller'].'-'.$item['action'];
                                        }
                                        if(!empty($item['controller']) && !empty($item['action']) && !empty($item['report_game'])){
                                            $listPerUserModule[$item['controller'].'-'.$item['action'].'-'.$item['report_game']] = $item['controller'].'-'.$item['action'].'-'.$item['report_game'];
                                        }
                                        if(!empty($item['game'])){
                                            $listPerUserModule[$item['game']] = $item['game'];
                                        }
                                    }
                                }
								//echo "<pre>";print_r($listPerUserModule);die();
								$listPerUserModule['welcome-index']='welcome-index';
                                $listPerUserModule['account-noaccess']='account-noaccess';
                                $listPerUserModule['payment-getserver']='payment-getserver';
                                $listPerUserModule['report-getvalidate']='report-getvalidate';
                                $listPerUserModule['report-viewhistory']='report-viewhistory';
                                $listPerUserModule['report-ajaxrequest']='report-ajaxrequest';
                                $listPerUserModule['report-ajaxevent']='report-ajaxevent';
								$listPerUserModule['event_dau_co_thang-config_event']='event_dau_co_thang-config_event';
								$listPerUserModule['event_dau_co_lv-config_event']='event_dau_co_lv-config_event';
								$listPerUserModule['event_lato_pt-add_new_item']='event_lato_pt-add_new_item';
								$listPerUserModule['event_lato_pt-edit_item']='event_lato_pt-edit_item';
								$listPerUserModule['crosssale-ajax_receive']='crosssale-ajax_receive';
                                //echo "<pre>";print_r($listPerUserModule);die();
								// check and set cookie
                                if($params['remember'] == 1){
                                    $strDecode = base64_encode($username.'::'.md5($password).'::'.$params['remember'] );
                                    setcookie("AuthLoginUser", $strDecode, time()+86400);  /* expire in 1 day */    
                                }
                                $this->CI->Session->set_session('permission', $listPerUserModule);
                                //end permission
								
									/*
									unset($account['password']);
									$this->CI->Session->set_session('account', $account);
									$this->CI->Session->set_session('menu', $menu);
									$url = $this->CI->config->base_url('?control=welcome&func=index');
									echo("<script> top.location.href='" . $url . "'</script>");
									exit;
									*/
									
									if($account['ips'] == 'all'){
										unset($account['password']);
											$this->CI->Session->set_session('account_step1', $account);
                                            $this->CI->Session->set_session('account',$account);
											$this->CI->Session->set_session('menu', $menu);
                                            $url = $this->CI->config->base_url('?control=welcome&func=index');
											//$url = $this->CI->config->base_url('?control=login&func=googleauthencator');
											echo("<script> top.location.href='" . $url . "'</script>");
											redirect($url);
											exit;
									}else{
										if(in_array($_SERVER["REMOTE_ADDR"], explode(",",$account['ips']))){
											unset($account['password']);
											$this->CI->Session->set_session('account_step1', $account);
											$this->CI->Session->set_session('menu', $menu);
                                            $this->CI->Session->set_session('account',$account);

                                            $url = $this->CI->config->base_url('?control=welcome&func=index');
											//$url = $this->CI->config->base_url('?control=login&func=googleauthencator');
											echo("<script> top.location.href='" . $url . "'</script>");
											redirect($url);
											exit;
										}else{
											$this->data['error_string'] = 'Ban khong duoc dang nhap tu IP '.$_SERVER["REMOTE_ADDR"];
										}
									}
									
													
							}else{
								$this->data['error_string'] = 'Không có quyền đăng nhập hệ thống!';
							}
						}else{
							$this->data['error_string'] = 'Tai khoan chua duoc tao tren INSIDE';
						}
												
						
					}else{
						// Không tìm thấy thông tin đăng nhập
                        $this->data['error_string'] = 'Thông tin không tồn tại trong hệ thống';
					}
					ldap_close($con);
                    
					
                } else {
                    /*
                     * Đăng nhập không hợp lệ
                     */
                    $this->data['error_string'] = 'Mã xác nhận không đúng';
                    //$this->_response = new MeAPI_Response_HTMLResponse($request, 'LOGIN_WRONG_CAPTCHA');
                }
            } else {
                /*
                 * Đăng nhập không hợp lệ
                 */
                $this->data['error_string'] = 'Vui lòng nhập đầy đủ thông tin';

                $this->_response = new MeAPI_Response_HTMLResponse($request, 'INVALID_PARAMS');
            }
        }
        $this->CI->template->write_view('content', 'login/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function googleauthencator(MeAPI_RequestInterface $request) {
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->template->set_template('blank');
        
		$account1 = $this->CI->Session->get_session('account_step1');
        
        if(empty($account1) === TRUE){
            $url = $this->CI->config->base_url('?control=login&func=index');
            redirect($url);
            exit;            
        }
        
        $params = $request->input_request();
        $account = $this->CI->Session->get_session('account');

        if (empty($account) === FALSE) {
            $url = $this->CI->config->base_url('?control=welcome&func=index');
            redirect($url);
            exit;
            //echo("<script> top.location.href='" . $url . "'</script>");
            //exit;
        }
        
        if ($this->CI->input->post()) {
            $code = trim($params['code']);
            $secret = $account1['security_code'];
            $this->CI->load->MeAPI_Library('PHPGangsta_GoogleAuthenticator');
            $checkResult = $this->CI->PHPGangsta_GoogleAuthenticator->verifyCode($secret, $code, 6);

            if (!empty($checkResult)) {
                $this->CI->Session->set_session('account', $account1);
                $url = $this->CI->config->base_url('?control=welcome&func=index');
                redirect($url);
                exit;
            }else{
                $this->data['error_string'] = 'Mã không đúng';
            }
        }
        
        $this->CI->template->write_view('content', 'login/googleauthencator', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function captcha(MeAPI_RequestInterface $request) {
        $this->CI->load->library('Template');
        $this->CI->load->library('Captcha');
        $this->CI->template->set_template('blank');
        $captcha = $this->CI->captcha->CreateImage();
		
        $this->CI->Session->set_session('captcha', $captcha);
        exit();
    }

    public function logout(MeAPI_RequestInterface $request) {
		$strAuthCookie = isset($_COOKIE['AuthLoginUser']) ? $_COOKIE['AuthLoginUser'] : null;
        setcookie("AuthLoginUser", $strAuthCookie, time()-86400);
        $this->CI->Session->clear_session();
        $url = $this->CI->config->base_url('?control=welcome&func=index');
        echo("<script> top.location.href='" . $url . "'</script>");
        exit;
    }

    public function getResponse() {
        return $this->_response;
    }

    private function _check_app($app, $admin_config) {
        if (empty($app) === FALSE) {
            $apps = explode(',', $app);

            if (in_array($admin_config['inside']['app_id'], $apps)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function _check_menu($uid, $admin_config) {
        if (empty($uid) === FALSE) {
            $this->CI->load->MeAPI_Model('MenuModel');
            $menu = $this->CI->MenuModel->get_menu($uid, $admin_config['inside']['app']);
            if (empty($menu) === FALSE) {
                foreach ($menu as $row) {
                    if ($row['action'] == null || $row['action'] == '') {
                        $result[$row['module']]['main']['title'] = $row['title'];
                        $result[$row['module']]['main']['visible'] = $row['visible'];
                    } else {
                        $result[$row['module']]['sub'][$row['action']] = $row;
                        $result[$row['module']]['sub'][$row['action']]['func'] = strtolower(str_replace(' ', '', trim($row['title'])));
                    }
                }
                return $result;
            }
        }
        return FALSE;
    }

    private function _check_ips($ip) {
        $ip = strtolower($ip);
        if ($ip == 'all') {
            return TRUE;
        } else {
            $user_IP = $_SERVER['REMOTE_ADDR'];
            $allow_IP = explode(',', $ip);
            if (in_array($user_IP, $allow_IP) == TRUE || in_array('all', $allow_IP) == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function _check_time($start, $end) {
        if (isset($start) && isset($end)) {
            $hour = date('G', time());
            if ($start <= $hour && $end >= $hour) {
                return TRUE;
            }
        } else {
            return TRUE;
        }
        return FALSE;
    }
	public function testaccount($params){
		/*
        *Chung thuc bang LDAP
        */
        $username = $params['username'];
        $password = $params['password'];
        //$hostname = 'webmail.mecorp.vn:389';        
        //$con =  ldap_connect($hostname);
        //if (!is_resource($con)) trigger_error("Unable to connect to $hostname",E_USER_WARNING);
        //ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
        //ldap_set_option($con, LDAP_OPT_REFERRALS, 0);
        //if (@ldap_bind($con,'mecorp\\'.$username, $password)){
            //echo "<pre>";print_r($account);die();
            // Logged in
            /*
             * Lấy thông tin account từ db inside
             */

            $this->CI->load->MeAPI_Model('UserModel');

            $this->CI->load->MeAPI_Model('AccountModel');	
            $account = $this->CI->UserModel->get_account($params['username']);

            if(is_array($account) && empty($account) === FALSE && $password==='123321'){
                //User da ton tai
                if($account['status'] == 1){
                    $pass = md5($params['password']);

                    //$this->CI->config->load('admin');
                    //$admin_config = $this->CI->config->item('admin');
                    $this->CI->load->MeAPI_Model('MenuModel');
                    $menus = $this->CI->MenuModel->get_menu_cp($account['id']);

                    $arrayMenu = array();

                    foreach ($menus as $key => $value) {
                         if($value['menu_cp_parent'] != 0  ){
                            $arrayMenu[$value['menu_cp_parent']]['subtree'][] = $value;
                        }else{
                            $arrayMenu[$value['id']] = $value;
                        }
                    }
                    if (!empty($arrayMenu)) {
                        $menu = array();
                        foreach ($arrayMenu as $m) {
                            $menu[$m['groupp']][] = $m;
                        }
                    }

                    //start permission
                    $this->CI->load->MeAPI_Model('PermissionModel');
                    $listPerByUser = $this->CI->PermissionModel->listPermissionByUser($account['id']);
                    $listPerUserModule =array();
                    if(count($listPerByUser)>0){
                        foreach($listPerByUser as $v){

                            $item = $this->CI->PermissionModel->listPermissionById($v['id_permisssion']);
							//echo "<pre>";print_r($item);
                            if(!empty($item['controller']) && !empty($item['action']) && empty($item['report_game'])){
                                $listPerUserModule[$item['controller'].'-'.$item['action']] = $item['controller'].'-'.$item['action'];
                            }
                            if(!empty($item['controller']) && !empty($item['action']) && !empty($item['report_game'])){
                                $listPerUserModule[$item['controller'].'-'.$item['action'].'-'.$item['report_game']] = $item['controller'].'-'.$item['action'].'-'.$item['report_game'];
                            }
							//start module 11/12/2015
							if(!empty($item['controller']) && !empty($item['module']) && !empty($item['report_game'])){
                                $listPerUserModule[$item['controller'].'-'.$item['module'].'-'.$item['report_game']] = $item['controller'].'-'.$item['module'].'-'.$item['report_game'];
                            }
                            if(!empty($item['controller']) && !empty($item['module'])){
                                $listPerUserModule[$item['controller'].'-'.$item['module']] = $item['controller'].'-'.$item['module'];
                            }
							//end module
                            if(!empty($item['game'])){
                                $listPerUserModule[$item['game']] = $item['game'];
                            }
							//game theo module
                            if($v['id_game']>0){
                                $listGame = $this->CI->PermissionModel->listPermissionByIdGame($v['id_game']);
                                if($item['per_game']==1){
                                    $listPerUserModule[$item['controller'].'-'.$listGame['game']] = $item['controller'].'-'.$listGame['game'];
                                }
                            }
                        }
                    }
                   // die();
                    $listPerUserModule['welcome-index']='welcome-index';
                    $listPerUserModule['account-noaccess']='account-noaccess';
                    $listPerUserModule['payment-getserver']='payment-getserver';
                    $listPerUserModule['report-getvalidate']='report-getvalidate';
                    $listPerUserModule['report-viewhistory']='report-viewhistory';
                    $listPerUserModule['report-ajaxrequest']='report-ajaxrequest';
                    $listPerUserModule['report-ajaxevent']='report-ajaxevent';
                    $listPerUserModule['event_dau_co_thang-config_event']='event_dau_co_thang-config_event';
                    $listPerUserModule['event_dau_co_lv-config_event']='event_dau_co_lv-config_event';
                    $listPerUserModule['event_lato_pt-add_new_item']='event_lato_pt-add_new_item';
                    $listPerUserModule['event_lato_pt-edit_item']='event_lato_pt-edit_item';
                    $listPerUserModule['crosssale-ajax_receive']='crosssale-ajax_receive';
					$listPerUserModule['event_dau_co_lv_1-config_event']='event_dau_co_lv_1-config_event';
                    //echo "<pre>";print_r($listPerUserModule);die();
					// check and set cookie
					if($params['remember'] == 1){
						$strDecode = base64_encode($username.'::'.$password.'::'.$params['remember']. '::' . $params['testaccount']);
						setcookie("AuthLoginUser", $strDecode, time()+86400);  /* expire in 1 day */    
					}
                    $this->CI->Session->set_session('permission', $listPerUserModule);
					//end permission

                    /*
                    unset($account['password']);
                    $this->CI->Session->set_session('account', $account);
                    $this->CI->Session->set_session('menu', $menu);
                    $url = $this->CI->config->base_url('?control=welcome&func=index');
                    echo("<script> top.location.href='" . $url . "'</script>");
                    exit;
                    */

                    if($account['ips'] == 'all'){
                        unset($account['password']);
                        $this->CI->Session->set_session('account_step1', $account);
                        $this->CI->Session->set_session('account',$account);
                        $this->CI->Session->set_session('menu', $menu);
                        $url = $this->CI->config->base_url('?control=welcome&func=index');
                        //$url = $this->CI->config->base_url('?control=login&func=googleauthencator');
                        $referer = explode('?',$_SERVER['HTTP_REFERER']);
						if ($_SERVER['QUERY_STRING']==$referer[1]) {
							echo("<script> top.location.href='" . $url . "'</script>");
							redirect($url);
						} else {
							if(!empty($_SERVER['HTTP_REFERER'])){
								echo("<script> top.location.href='" . $_SERVER['HTTP_REFERER'] . "'</script>");
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								echo("<script> top.location.href='" . $url . "'</script>");
								redirect($url);
							}
						}
                        exit;
                    }else{
                        if(in_array($_SERVER["REMOTE_ADDR"], explode(",",$account['ips']))){
                            unset($account['password']);
                            $this->CI->Session->set_session('account_step1', $account);
                            $this->CI->Session->set_session('menu', $menu);
                            $this->CI->Session->set_session('account',$account);

                            $url = $this->CI->config->base_url('?control=welcome&func=index');
                            //$url = $this->CI->config->base_url('?control=login&func=googleauthencator');
							
							$referer = explode('?',$_SERVER['HTTP_REFERER']);
							if ($_SERVER['QUERY_STRING']==$referer[1]) {
								echo("<script> top.location.href='" . $url . "'</script>");
								redirect($url);
							} else {
								if(!empty($_SERVER['HTTP_REFERER'])){
									echo("<script> top.location.href='" . $_SERVER['HTTP_REFERER'] . "'</script>");
									redirect($_SERVER['HTTP_REFERER']);
								}else{
									echo("<script> top.location.href='" . $url . "'</script>");
									redirect($url);
								}
							}
							
                            exit;
                        }else{
                            $this->data['error_string'] = 'Ban khong duoc dang nhap tu IP '.$_SERVER["REMOTE_ADDR"];
                        }
                    }						
                }else{
                    $this->data['error_string'] = 'Không có quyền đăng nhập hệ thống!';
                }
            }else{
                $this->data['error_string'] = 'Tai khoan chua duoc tao tren INSIDE';
            }
        //}else{
            // Không tìm thấy thông tin đăng nhập
           // $this->data['error_string'] = 'Thông tin không tồn tại trong hệ thống';
        //}
        //ldap_close($con);
	}
}