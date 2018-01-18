<?php

class MeAPI_Controller_AccountController implements MeAPI_Controller_AccountInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    
    private $app_key = 'agiU7J0A';
    
    public function __construct() {
        $this->CI = & get_instance();

        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
		$this->CI->load->MeAPI_Library('Memcacher');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->helper('recursive_helper');
		$this->CI->load->helper('partition_helper');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
    }

    /*
     * Get Data Group
     */

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        //echo $_SERVER["REMOTE_ADDR"];
        $this->CI->load->MeAPI_Library('Pgt');
        
        if(isset($_GET['page']) && is_numeric($_GET['page'])){
            $page = $_GET['page'];
        }else{
            $page=1;
        }
        $per_page = 500;
        $pa = $page - 1;
	$start = $pa * $per_page;
        
        $this->data['start'] = $start;
        
        $this->CI->load->MeAPI_Model('AccountModel');
        $accounts = $this->CI->AccountModel->getAccount($start, $per_page);
        $this->data['result'] = $accounts;
        
        $total = $this->CI->AccountModel->getTotal();
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url().'?control=account&func=index';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        /* Initialize the pagination library with the config array */
        $this->CI->Pgt->cfig($config);
        
        $this->data['pages'] = $this->CI->Pgt->create_links();
                
        $this->CI->template->write_view('content', 'account/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    //http://localhost/inside/public/?control=account&func=getListUser&page=1&limit=3&token=766a26cf865d1e9f6819826a12ee3bd9
    public function getListUser(MeAPI_RequestInterface $request) {
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE || empty($params['page']) === TRUE || empty($params['limit']) === TRUE){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params,array('token'=>$params['token']));
        $token = md5(implode('', $pm) . $this->app_key);
        
        if($token == $params['token']){
            $this->CI->load->MeAPI_Model('AccountModel');
            $accounts = $this->CI->AccountModel->getAccountsApi($params['page'],$params['limit']);
            $this->data['result'] = $accounts;
            $this->data['total_record'] = $this->CI->AccountModel->getTotal();  

            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS' , $this->data);
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
    }
    //http://localhost/inside/public/?control=account&func=searchUserName&username=khoapm&token=fddba2e66104c3d3d8b9b0d7623283d5
    public function searchUserName(MeAPI_RequestInterface $request){
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE || empty($params['username']) === TRUE){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params,array('token'=>$params['token']));
        $token = md5(implode('', $pm) . $this->app_key);
        
        if($token == $params['token']){
            
            $this->CI->load->MeAPI_Model('AccountModel');
            $account = $this->CI->AccountModel->getAccountApi($params['username']);
            $this->data['result']['account'] = $account;
            $userId = $account['id'];
            $menus = $this->CI->AccountModel->getMenuApi($userId);
            if (!empty($menus)) {
                $menu = array();
                foreach ($menus as $m) {
                    $menu[$m['groupp']][] = $m;
                }

            }
            $this->data['result']['menu'] = $menu;
            
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS' , $this->data);
                        
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
    }
    //http://localhost/inside/public/?control=account&func=searchUserStatus&status=1&token=7f5fc1a9df9f0ba53ab7e1a3e17ea241
    public function searchUserStatus(MeAPI_RequestInterface $request){
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE || !isset($params['status']) || !is_numeric($params['status'])){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params,array('token'=>$params['token']));
        $token = md5(implode('', $pm) . $this->app_key);
        
        if($token == $params['token']){
            
            $this->CI->load->MeAPI_Model('AccountModel');
            $account = $this->CI->AccountModel->getAccountStatusApi($params['status']);
            $this->data['result'] = $account;
                      
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS' , $this->data);
                        
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
    }
    //http://localhost/inside/public/?control=account&func=searchUserMenu&menuid=1&token=c79a97bc0a4ec9c128e8b658aa0f495e
    public function searchUserMenu(MeAPI_RequestInterface $request){
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE || !isset($params['menuid']) || !is_numeric($params['menuid'])){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params,array('token'=>$params['token']));
        $token = md5(implode('', $pm) . $this->app_key);
        
        if($token == $params['token']){
            
            $this->CI->load->MeAPI_Model('AccountModel');
            $account = $this->CI->AccountModel->getAccountMenuApi($params['menuid']);
            $this->data['result'] = $account;
                      
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS' , $this->data);
                        
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
    }
    //http://localhost/inside/public/?control=account&func=addMenu&menuid=2&userid=6&token=9ee7085b472c4b45d831d6646777e50f
    public function addMenu(MeAPI_RequestInterface $request){
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE || !isset($params['menuid']) || !is_numeric($params['menuid']) || !isset($params['userid']) || !is_numeric($params['userid'])){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params,array('token'=>$params['token']));
        $token = md5(implode('', $pm) . $this->app_key);
        
        if($token == $params['token']){
            
            $this->CI->load->MeAPI_Model('MenuModel');
            $account = $this->CI->MenuModel->addMenuApi($params['menuid'],$params['userid']);
            
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
                        
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
    }
    //localhost/inside/public/?control=account&func=removeMenu&menuid=2&userid=6&token=aa4bcd97e7665d93f3a07a6d70a438b9
    public function removeMenu(MeAPI_RequestInterface $request){
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE || !isset($params['menuid']) || !is_numeric($params['menuid']) || !isset($params['userid']) || !is_numeric($params['userid'])){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params,array('token'=>$params['token']));
        $token = md5(implode('', $pm) . $this->app_key);
        
        if($token == $params['token']){
            
            $this->CI->load->MeAPI_Model('MenuModel');
            $account = $this->CI->MenuModel->removeMenuApi($params['menuid'],$params['userid']);
            
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
                        
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
    }
    //http://localhost/inside/public/?control=account&func=addUser&username=quangmn&fullname=Mai%20Nhat%20Quang&password=123456&token=840cdf4aa23f6b688aa2a521df1eee95
    public function addUser(MeAPI_RequestInterface $request){
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE || empty($params['username']) === TRUE || empty($params['fullname']) === TRUE || empty($params['token']) === TRUE){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params,array('token'=>$params['token']));
        $token = md5(implode('', $pm) . $this->app_key);
        
        if($token == $params['token']){
            
            $this->CI->config->load('admin');
            $admin_config = $this->CI->config->item('admin');
            $ips = $admin_config['config']['clientIP'];
            
            $ips = array_diff($ips, array('all'));
            
            $strip = implode(",", $ips);
            
            $this->CI->load->MeAPI_Model('AccountModel');
            $account = $this->CI->AccountModel->saveItemApi($params['username'],$params['fullname'],$strip);
            
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
                        
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
        
    }
    //http://localhost/inside/public/?control=account&func=getAllMenu&token=f206b6cd31e86a33aa911a964ea1163a
    public function getAllMenu(MeAPI_RequestInterface $request){
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params,array('token'=>$params['token']));
        $token = md5(implode('', $pm).$this->app_key);
        
        if($token == $params['token']){
            $this->CI->load->MeAPI_Model('MenuModel');
            $menus = $this->CI->MenuModel->getAllMenuApi();
            if (!empty($menus)) {
                $menu = array();
                foreach ($menus as $m) {
                    $menu[$m['groupp']][] = $m;
                }

            }
            $this->data['result'] = $menu;
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS',$this->data);
                        
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
        
    }
    //http://localhost/inside/public/?control=account&func=changeStatusUser&username=tailm&status=0&token=6255c87348c0303b277d48d19cbc9356
    //http://localhost/inside/public/?control=account&func=changeStatusUser&username=tailm&status=1&token=16b5308643c85a448dd27d75b1aa9580
    public function changeStatusUser(MeAPI_RequestInterface $request){
        $params = $_REQUEST;
        $params = $this->CI->security->xss_clean($params);
        if(empty($params['control']) === TRUE || empty($params['func']) === TRUE || empty($params['username']) === TRUE || !isset($params['status']) || !is_numeric($params['status'])){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $pm = array_diff($params, array('token'=>$params['token']));
        $token = md5(implode('', $pm).$this->app_key);
        if($token == $params['token']){
            $this->CI->load->MeAPI_Model('AccountModel');
            $account = $this->CI->AccountModel->statusApi($params['username'],$params['status']);
                                  
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
                        
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
        }
    }
    public function orderArray(&$array,$findarrAd,$i =1){
        foreach($array as $key => $vl){
            if(isset($vl['subtree']) && is_array($vl['subtree'])){
                $this->orderArray($array[$key]['subtree'],$findarrAd,++$i);
            }
            if(in_array($vl['id'],$findarrAd)){
                    $array[$key]['checked'] = 1;
            }else{
                    $array[$key]['checked'] = 0;
            }
            $array[$key]['level'] = $i;
        }
        return $array;
    }
    public function removeKeysArray($arrays){
        foreach ($arrays as $key => $value) {

           if(isset($value['level'] ) ){
                $arrayss[] = $value;
           }else{
                foreach ($value as $key1 => $value1) {
                   $arrayss[] = $value1; 
                }
           }
           
        }
        return $arrayss;
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $this->CI->load->MeAPI_Model('AccountModel');
        
        $st = $request->input_get('st');
        if(isset($_GET['st'])){
             $this->CI->AccountModel->status();
             $url = $this->CI->config->base_url('?control=account&func=index');
             redirect($url);
             exit;
        }
        if(isset($_GET['iddelete'])){
             $this->CI->AccountModel->delete();
             $url = $this->CI->config->base_url('?control=account&func=index');
             redirect($url);
             exit;
        }
               
        $this->data['username'] = '';
        $this->data['fullname'] = '';
        $arrAd = array();
        $arrIp = array();
        
        $arr = array();
        if(isset($_GET['id'])){
            $adminmenu = $this->CI->AccountModel->get_adminmenu($_GET['id']);
            foreach($adminmenu as $val){
                    $arrAd[] = $val['menu_id'];
            }
            $this->data['id'] = $_GET['id'];
            $admin = $this->CI->AccountModel->get_admin($_GET['id']);
            if(empty($admin['ips']) === FALSE){
                $arrIp = explode(",", $admin['ips']);
            }
            $this->data['username'] = $admin['username'];
            $this->data['fullname'] = $admin['fullname'];
			$this->data['id_group'] = $admin['id_group'];
        }
        $arrG = $this->CI->AccountModel->get_groupmenu();
        foreach($arrG as $key => $val){
            $val['level'] = 0;
            $arr[] = $val;
            $arrySub = array();
            $arrM = $this->CI->AccountModel->get_menu($val['id']);

            foreach ($arrM as $keysyb => $valuesyb) {
                if($valuesyb['menu_cp_parent'] != 0  ){
                    $arrySub[$valuesyb['menu_cp_parent']]['subtree'][] = $valuesyb;
                }else{
                    $arrySub[$valuesyb['id']] = $valuesyb;
                    $arrySub[$valuesyb['id']]['idgroup'] = $val['id'];
                }
            }
            $arr[] = $this->orderArray($arrySub,$arrAd);
        }
        $returnArray = $this->removeKeysArray($arr);
        //permission ip
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $ips = $admin_config['config']['clientIP'];
        
        $ip = array();
        
        foreach($ips as $key => $val){
            $ip[$key]['ip'] = $val;
            if(in_array($val,$arrIp)){
                $ip[$key]['checked'] = 1;
            }else{
                $ip[$key]['checked'] = 0;
            }
        }
               
        if ($this->CI->input->post()) {
            /*
            echo 'jiohoujio'.$request->input_post('username');
            echo '<pre>';
            print_r($request->input_post());
            echo '</pre>';
            exit;
            
             * 
             */
            
            if($request->input_post('username') != '' && $request->input_post('fullname') != ''){
                $this->CI->AccountModel->saveItem();
                $url = $this->CI->config->base_url('?control=account&func=index');
                echo("<script> top.location.href='" . $url . "'</script>");
                redirect($url);
                exit;
            }
        }
        $this->data['menu'] = $returnArray;
        $this->data['ips'] = $ip;
        
        $this->CI->template->write_view('content', 'account/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	
	public function qr(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Model('AccountModel');
        
        $this->CI->load->MeAPI_Library('PHPGangsta_GoogleAuthenticator');
        
        
        $list_user = $this->CI->AccountModel->getAccounts(0,500);
        $arrU = array();
        foreach($list_user as $val){
            $arrU[$val['username']]['fullname'] = $val['fullname'];
            $arrU[$val['username']]['security_code'] = $val['security_code'];
        }
        
        $this->data['listuser'] = $arrU;
        $userqrcode = $this->CI->Session->get_session('userqrcode');
        if(isset($userqrcode)){
            $username = $this->CI->Session->get_session('userqrcode');
        }else{
            $username = '';   
        }
        $this->data['user'] = $username;
        
        if ($this->CI->input->post()) {
            $arrParam = $this->CI->input->post();
            $secret = $arrParam['secret'];
            $code = trim($arrParam['code']);
            
            $checkResult = $this->CI->PHPGangsta_GoogleAuthenticator->verifyCode($secret, $code, 5);
            
                if (!empty($checkResult)) {
                   
                    if($this->CI->AccountModel->updateQr()){
                        $this->data['message'] = 'Cập nhật thông tin thành công!';
                    }else{
                        $this->data['message'] = 'Cập nhật thất bại vui lòng thử lại!';
                    }
                    
                } else {
					   $this->data['code'] = $code;
                       $this->data['message'] = 'Code không đúng! Vui lòng click vào button Add lần nửa vì có thể giờ ĐT của bạn và server không đồng bộ';
                }
            
        }else{        
            $secret = $this->CI->PHPGangsta_GoogleAuthenticator->createSecret();
        }
        
        
        $this->data['secret'] = $secret;
        $this->data['qrCodeUrl'] = $this->CI->PHPGangsta_GoogleAuthenticator->getQRCodeGoogleUrl($username, $secret,urlencode('Mecorp - Inside - 3K'));
        
        $this->CI->template->write_view('content', 'account/qr', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
     }
     public function setuserqr(MeAPI_RequestInterface $request){
        $this->CI->load->MeAPI_Model('GameModel');
        $params = $request->input_post();
        $this->CI->Session->set_session('userqrcode', $params['username']);
        echo json_encode(1);
        exit();
     }
	public function del_cache(MeAPI_RequestInterface $request){
        $key = "listModule" . $_GET['id'] . date("Ymd", time());
        $this->CI->Memcacher->Set($key, false);
		redirect(base_url().'?control='.$_GET['control'].'&func=permission&id='.(int)$_GET['id']);
    }
	public function permission(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Model('AccountModel');
        $adminmenu = $this->CI->AccountModel->get_adminmenu($_GET['id']);
        foreach($adminmenu as $val){
            $arrAd[] = $val['menu_id'];
        }
        $this->data['id'] = $_GET['id'];
        $admin = $this->CI->AccountModel->get_admin($_GET['id']);
        $this->data['title'] = 'Phân quyền <span class="red">'.$admin['username'].'</span>';
        
        
		
		$key = "listModule" . $_GET['id'] . date("Ymd", time());
		$finalModule = $this->CI->Memcacher->Get($key);
        if ($finalModule == false) {
            $listModuleData = $this->CI->AccountModel->listModule();
			$listModule = array();
			if(empty($listModuleData) !== TRUE){
				foreach($listModuleData as $v){
					if($v['parents']==0){
						$listModule[$v['id']]['title'] = $v;
					}
					if($v['parents']>0){
						$result = process($listModuleData,$v['parents']);
						$listModule[$v['parents']]['data'] = $result;                    
						$i++;
					}
				}
			}
			$finalModule = array();
			if(count($listModule)>0){
				foreach($listModule as $table){
					if(!empty($table['title']['name'])){
						$finalModule[] = $table;
					}
				}
				$finalModule  =  partition($finalModule, 2);
			}
			$this->CI->Memcacher->Set($key, $finalModule, 999999999999999);
		}
		$this->data['listModule'] = $finalModule;
		
		
		$userPermission = $this->CI->AccountModel->userPermission($_GET['id']);
        $listCheckedPermisssion = array();
		$listCheckedGamePermisssion = array();
		$listCheckedModule = array();
        if(count($userPermission)>0){
            foreach($userPermission as $v){
				if($v['id_game']>0 && $v['id_permisssion']>0){
					$listCheckedGamePermisssion[$v['id_permisssion']][$v['id_game']] = $v['id_game'];
                    $listCheckedModule[$v['id_permisssion']] = $v['id_permisssion'];
				}else{
					$listCheckedPermisssion[$v['id_permisssion']] = $v['id_permisssion'];
				}
            }
        }
		$this->data['listCheckedModule'] = $listCheckedModule;
        $this->data['listCheckedPermisssion'] = $listCheckedPermisssion;
		$this->data['listCheckedGamePermisssion'] = $listCheckedGamePermisssion;
        
		$listGame = $this->CI->AccountModel->listGamePermission();
        $this->data['listGame'] = $listGame;
        $this->CI->template->write_view('content', 'account/permission', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function ajax_permisssion(){
        $this->CI->load->MeAPI_Model('AccountModel');
        if($_REQUEST['id_user']>0 && $_REQUEST['id_permisssion']>0){
            if($_REQUEST['type']=='multi'){
                if($_REQUEST['option']=='active'){
                    $this->CI->AccountModel->savePermisssion($_REQUEST);
                }else{
                    $this->CI->AccountModel->deletePermisssion($_REQUEST);
                }
            }else{
                if($_REQUEST['option']=='active'){
                    $this->CI->AccountModel->savePermisssion($_REQUEST);
                }else{
                    $this->CI->AccountModel->deletePermisssion($_REQUEST);
                }
            }
            //check
            $userPermission = $this->CI->AccountModel->checkUserPermission($_REQUEST['id_user'],$_REQUEST['id_permisssion'],$_REQUEST['id_game']);
            $this->data['id_user'] = $_REQUEST['id_user'];
            $this->data['id_permisssion'] = $_REQUEST['id_permisssion'];
			$this->data['id_game'] = $_REQUEST['id_game'];
            $this->data['userPermission'] = $userPermission;
            $f = array(
                'error'=>0,
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('account/ajax_permisssion', $this->data, true)
            );
        }else{
            $f = array(
                'error'=>1,
                'messg'=>'Thất bại',
                'html'=>NULL
            );
        }
        echo json_encode($f);
        exit();
    }
    public function ajax_permisssionBK(){
        $this->CI->load->MeAPI_Model('AccountModel');
        $listModuleData = $this->CI->AccountModel->listModule();
        if($_REQUEST['id_user']>0 && $_REQUEST['id_permisssion']>0){
            if($_REQUEST['type']=='multi'){
                if($_REQUEST['option']=='active'){
                    $this->CI->AccountModel->savePermisssion($_REQUEST);
                }else{
                    $this->CI->AccountModel->deletePermisssion($_REQUEST);
                }
            }else{
                if($_REQUEST['option']=='active'){
                    $this->CI->AccountModel->savePermisssion($_REQUEST);
                }else{
                    $this->CI->AccountModel->deletePermisssion($_REQUEST);
                }
            }
            
            $listModule = array();
            if(empty($listModuleData) !== TRUE){
                foreach($listModuleData as $v){
                    if($v['parents']==0){
                        $listModule[$v['id']]['title'] = $v;
                    }
                    if($v['parents']>0){
						$result = process($listModuleData,$v['parents']);
						$listModule[$v['parents']]['data'] = $result;
						$i++;
					}
                }
            }
			$finalModule = array();
            if(count($listModule)>0){
                foreach($listModule as $table){
                    if(!empty($table['title']['name'])){
                        $finalModule[] = $table;
                    }
                }
                $finalModule  =  partition($finalModule, 2);
            }
            $this->data['listModule'] = $finalModule;
            //check
            $userPermission = $this->CI->AccountModel->userPermission($_REQUEST['id_user']);
            $listCheckedPermisssion = array();
            if(count($userPermission)>0){
                foreach($userPermission as $v){
                    $listCheckedPermisssion[$v['id_permisssion']] = $v['id_permisssion'];
                }
            }
            $this->data['id_user'] = $_REQUEST['id_user'];
            $this->data['listCheckedPermisssion'] = $listCheckedPermisssion;
            $f = array(
                'error'=>0,
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('account/ajax_permisssion', $this->data, true)
            );
        }else{
            $f = array(
                'error'=>1,
                'messg'=>'Thất bại',
                'html'=>NULL
            );
        }
        echo json_encode($f);
        exit();
    }
    /*
     * Cron Group
     */
    public function noaccess(MeAPI_RequestInterface $request){
        $this->data['title'] ='';
        $this->CI->template->write_view('content', 'account/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    /*
     * Cron Group
     */

    public function getResponse() {
        return $this->_response;
    }

}