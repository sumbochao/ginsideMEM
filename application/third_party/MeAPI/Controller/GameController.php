<?php
set_time_limit(10000000);
ini_set('memory_limit', '5120M');
class MeAPI_Controller_GameController implements MeAPI_Controller_GameInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    public $arraylist = array('115.78.161.124','115.78.161.88','118.69.76.212','14.161.5.226');
    private $app_key = 'agiU7J0A';
    
    public function __construct() {
        $this->CI = & get_instance();

        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
    }
    public function gametype(MeAPI_RequestInterface $request){
        try{
            $requestLink = $request->input_request();
            $checkApp = ( isset($requestLink['app']) && !empty($requestLink['app']) )?$requestLink['app']: ""; 

            $checkData = ( isset($requestLink['data']) && !empty($requestLink['data']) )?$requestLink['data']: ""; 
            if(empty($checkApp) === TRUE || empty($checkData) === TRUE){
                $this->redirectMenu();
            }
            $getreturn =  $this->dataGet($checkApp,$checkData);
            $this->data['info'] = $getreturn['data'];
            /*
            switch ($checkApp) {
                case '3t':
                  $this->data=  $this->data3t($checkApp,$checkData);
                    break;
                case '3k':
                  $this->data=  $this->data3k($checkApp,$checkData);
                    break;
                case '8t':
                  $this->data=   $this->data8t($checkApp,$checkData);
                    break;
                case '12g':
                  $this->data=   $this->data12g($checkApp,$checkData);
                    break;
                default:
                    $this->redirectMenu();
                    break;
            }
            */
        }catch (Exception $e) {
            //echo $e->getMessage();
            echo '<script>alert("'.$e->getMessage().'")</script>';
        }
       // $this->CI->template->write_view('content', 'game/infotop', $this->data);
        $this->CI->template->write_view('content', 'game/'.$checkApp."/".$checkData, $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }
    private function redirectMenu(){
        $url = $this->CI->config->base_url('?control=menu&func=index');
        redirect($url);
        exit;
    }
	

    private function dataGet($checkApp,$data){
        if(empty($checkApp) || empty($data)){
            $this->redirectMenu();
        }
        //call api get data;
        $this->api_url = "";
        switch ($checkApp) {
            case '3t':
              $this->api_url=  "http://local.api.3t.mobo.vn/?";
                break;
            case '3k':
              $this->api_url=  "http://local.api.3k.mobo.vn/?";
                break;
            case '8t':
              $this->api_url=  "http://local.api.8t.mobo.vn/?";
                break;
            case '12g':
              $this->api_url=  "http://local.api.12g.mobo.vn/?";
                break;
        }
        $params = array('control'=>"api","func"=>$data,"app"=>$checkApp);
        $result = $this->_call_api($params);
        return empty($result) === FALSE? json_decode($result,true): false;
    }
    private function _return_api($params){
       return $this->link_request = $this->api_url  . http_build_query($params)  ;
    }
    private function _call_api($params) {
        $this->link_request = $this->api_url  . http_build_query($params)  . '&token=' . md5(implode('', $params) . $this->app_key);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $params['link_request'] = $this->link_request;
        $result = curl_exec($ch);
        return $result;
    }
    private function data3t($checkApp,$data){
        if(empty($data) ){
            $this->redirectMenu();
        }
    }
    private function data3k($checkApp,$data){
        if(empty($data) ){
            $this->redirectMenu();
        }
    }
    private function data8t($checkApp,$data){
        if(empty($data) ){
            $this->redirectMenu();
        }
    }
    private function data12g($checkApp,$data){
        if(empty($data) ){
            $this->redirectMenu();
        }
    }
	
	public function giftcode(MeAPI_RequestInterface $request){
		try{
			$this->authorize->validateAuthorizeMenu($request);
			//$this->authorize->validateAuthorizeRequest($request, 0);
			$app = $_GET['app'];
			$datainfo = $_GET['data'];
			
			if(!empty($app) ){
				$this->CI->load->MeAPI_Model('GameModel');
				$infoAll = $this->CI->GameModel->getInfoByApp($app);
				$this->data["infomfb"] = $infoAll;
			}else{
				//info falied
			}   
		} catch (Exception $e) {
			//echo $e->getMessage();
			echo '<script>alert("'.$e->getMessage().'")</script>';
			
		} 
		$this->CI->template->write_view('content', 'mfb/index', $this->data);
		$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function giftcodeapi(MeAPI_RequestInterface $request){
		$arrayapi = array('code'=>-110,'message'=>'Không có dữ liệu','data'=>null);
		try{
			//$this->authorize->validateAuthorizeRequest($request, 0);
			$app = $_GET['app'];
			$datainfo = $_GET['data'];
			
			if(!empty($app) ){
				$this->CI->load->MeAPI_Model('GameModel');
				$infoAll = $this->CI->GameModel->getInfoByApp($app);
				$arrayapi = array('code'=>200,'message'=>'GET INFO SUCCESS','data'=>$infoAll);
			}else{
				//info falied
			}   
		} catch (Exception $e) {
			//echo $e->getMessage();
			echo '<script>alert("'.$e->getMessage().'")</script>';
			
		}
		echo json_encode($arrayapi);
		die;
	}
	public function downloadapi(MeAPI_RequestInterface $request){
		$arrayapi = array('code'=>-110,'message'=>'Không có dữ liệu','data'=>null);
		
		$authen = $this->authorize->validateAuthorizeApi($request);
		if($authen === TRUE){	
			$app = $_GET['app'];
			$ip = $_GET['ip'];
			if(!empty($app)  && !empty($ip)){
				$this->CI->load->MeAPI_Model('GameModel');
				$infoAll = $this->CI->GameModel->getDownloadApp($app,false);
				$returndata = array();
				if(!empty($infoAll['ipi_api']) ){
					$ipi_api = explode(",",$infoAll['ipi_api']);
					if(in_array($ip,$ipi_api)){
						$returndat['linki_api'] = $infoAll['linki_api'];
					}
				}else{
					$returndat['linki_api'] = $infoAll['linki_api'];
				}
				if(!empty($infoAll['ipi_plist']) ){
					$ipi_plist = explode(",",$infoAll['ipi_plist']);
					if(in_array($ip,$ipi_plist)){
						$returndat['linki_plist'] = $infoAll['linki_plist'];
					}
				}else{
					$returndat['linki_plist'] = $infoAll['linki_plist'];
				}
				if(!empty($infoAll['ipi_apple']) ){
					$ipi_apple = explode(",",$infoAll['ipi_apple']);
					if(in_array($ip,$ipi_apple)){
						$returndat['linki_apple'] = $infoAll['linki_apple'];
					}
				}else{
					$returndat['linki_apple'] = $infoAll['linki_apple'];
				}
				if(!empty($infoAll['ipa_apk']) ){
					$ipa_apk = explode(",",$infoAll['ipa_apk']);
					if(in_array($ip,$ipa_apk)){
						$returndat['linka_apk'] = $infoAll['linka_apk'];
					}
				}else{
					$returndat['linka_apk'] = $infoAll['linka_apk'];
				}
				if(!empty($infoAll['ipa_gg']) ){
					$ipa_gg = explode(",",$infoAll['ipa_gg']);
					if(in_array($ip,$ipa_gg)){
						$returndat['linka_gg'] = $infoAll['linka_gg'];
					}
				}else{
					$returndat['linka_gg'] = $infoAll['linka_gg'];
				}
				
				$arrayapi = array('code'=>200,'message'=>'GET INFO SUCCESS','data'=>$returndat);
			}   
		}else{
			$arrayapi = array('code'=>-100,'message'=>'Authen không hợp lệ','data'=>null);
		}
		echo json_encode($arrayapi);
		die;
	}
	public function download(MeAPI_RequestInterface $request){
		try{
			//$this->authorize->validateAuthorizeMenu($request);
			//$this->authorize->validateAuthorizeRequest($request, 0);
			
			$app = $_GET['app'];
			$datainfo = $_GET['data'];
			$this->CI->load->MeAPI_Model('GameModel');
			if(isset($_GET['app']) && !empty($_GET['app'])){
				$infomfb = $this->CI->GameModel->getDownloadApp($app,true);
				$this->data['ipi_api'] = $infomfb['ipi_api'];
				$this->data['linki_api'] = $infomfb['linki_api'];
				$this->data['linki_plist'] = $infomfb['linki_plist'];
				$this->data['ipi_plist'] = $infomfb['ipi_plist'];
				$this->data['linki_apple'] = $infomfb['linki_apple'];
				$this->data['ipi_apple'] = $infomfb['ipi_apple'];
				$this->data['linka_apk'] = $infomfb['linka_apk'];
				
				$this->data['ipa_apk'] = $infomfb['ipa_apk'];
				$this->data['linka_gg'] = $infomfb['linka_gg'];
				$this->data['ipa_gg'] = $infomfb['ipa_gg'];
				$this->data['active'] = $infomfb['active'];
			}
			if(!empty($app) && $_POST ){
				
				if (count($_POST) >=1 ) {
					$this->CI->GameModel->saveItemDownload();
					$url = $this->CI->config->base_url('?control=game&func=download&app='.$app.'&data='.$datainfo);
					redirect($url);
					exit;
				}
				
				
			}else{
				//info falied
			}
		} catch (Exception $e) {
			//echo $e->getMessage();
			echo '<script>alert("'.$e->getMessage().'")</script>';
			
		} 		
		$this->CI->template->write_view('content', 'download/add', $this->data);
		$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function addgiftcode(MeAPI_RequestInterface $request){
		try{
			//$this->authorize->validateAuthorizeMenu($request);
			//$this->authorize->validateAuthorizeRequest($request, 0);
			
			$app = $_GET['app'];
			$datainfo = $_GET['data'];
			$this->CI->load->MeAPI_Model('GameModel');
			
			if(isset($_GET['id']) && is_numeric($_GET['id'])){
				$infomfb = $this->CI->GameModel->getInfoByAppID($_GET['id'],$app);
				
				$this->data['message'] = $infomfb['message'];
				$this->data['type'] = $infomfb['type'];
				$this->data['photo'] = $infomfb['photo'];
				$this->data['link'] = $infomfb['link'];
				$this->data['startdate'] = $infomfb['startdate'];
				$this->data['enddate'] = $infomfb['enddate'];
				$this->data['status'] = $infomfb['status'];
			}
			if(!empty($app) && $_POST ){
				
				if (count($_POST) >=1 ) {
					$this->CI->GameModel->saveItem();
					$url = $this->CI->config->base_url('?control=game&func=giftcode&app='.$app.'&data='.$datainfo);
					redirect($url);
					exit;
				}
				
				
			}else{
				//info falied
			}
		} catch (Exception $e) {
			//echo $e->getMessage();
			echo '<script>alert("'.$e->getMessage().'")</script>';
			
		} 		
		$this->CI->template->write_view('content', 'mfb/add', $this->data);
		$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	
    public function infouser(MeAPI_RequestInterface $request) {
	try{
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $this->data['server'] = $admin_config['config']['server'];
        
        $arrServer = $admin_config['config']['server'];
        
		$srvItem = '';
        $co = 0;
        foreach($arrServer as $k => $s){
            try{
                $srvItem = $k;
                $this->CI->load->MeAPI_Model('GameModel');
                $role_all = $this->CI->GameModel->checkdb($srvItem);

                if(empty($role_all) === TRUE){
                    $co = 1;
                    break;
                }

            }catch (Exception $e){
                $co = 1;
                break;
            }
        }



        if($co){
            $srvItem = 'game'.((int)substr($srvItem, 4) - 1);
        }
                        
        $this->data['srvItem'] = $srvItem;
        
		
		
		
		
        $arrServerData = $admin_config['config']['server_data']; 
        
        $arrServerAccount = $admin_config['config']['server_account'];
        
        
        $this->CI->load->MeAPI_Model('GameModel');
        
        if ($this->CI->input->post()) {
            $params = $request->input_post();
            $pm = array_diff($params, array('server'=>$params['server'],'btnsubmit'=>$params['btnsubmit']));
            $param = null;
            foreach($pm as $k => $v){
                if($v != ''){
                    $param = $v;
                    $func = $k;
                    break;
                }
            }
            if(empty($param) === TRUE){
                $url = $this->CI->config->base_url('?control=game&func=infouser');
                redirect($url);
                exit;
            }
            
			//echo $func;
           
            foreach($arrServer as $key => $val){
                $srv = "game_account".substr($key, 4);
                $game_account = $this->CI->GameModel->{$func}(trim($param), $srv);
                if(empty($game_account) === FALSE){
                    break;
                }                
            }
			
            //Get info mobo account
            $mobo_info = $this->CI->GameModel->mobo_info($game_account['user_key'],"game_account".substr($params['server'], 4));
            $this->data['mobo_info'] = $mobo_info;
            
			
            //Get info game account
            			
			$game_info = $this->CI->GameModel->game_info($game_account['user_key'],"game_account".substr($params['server'], 4));
            if(empty($game_info) === FALSE){			
            $game_info = json_decode($game_info['value_'],true);
            $game_info['createTime'] = date('Y-m-d H:i:s',(int)($game_info['createTime']/1000));
            $game_info['registerTime'] = date('Y-m-d H:i:s',(int)($game_info['registerTime']/1000));
            $game_info['lastLoginTime'] = date('Y-m-d H:i:s',(int)($game_info['lastLoginTime']/1000));
            }
			$this->data['game_info'] = $game_info;
                
           
            $char_info = $this->CI->GameModel->char_info($game_account['user_key'],$params['server']);
			
            if(empty($char_info) === FALSE){
                foreach($char_info as $key => $val){
                    $char_info[$key]['registerTime'] = date('Y-m-d H:i:s',(int)($val['registerTime']/1000));
                }
            }
            $this->data['char_info'] = $char_info;
                  
            $arrShop = array();
            $arrHero = array();
			
            if(empty($char_info) === FALSE){
                foreach($char_info as $v){
                    //get info user game
                    //$info_user_role = $this->CI->GameModel->infouserrole($game_account['role_id'],$params['server']);
                    $info_user_role = $this->CI->GameModel->infouserrole($v['uid'],$params['server']);
                    //get shop
                    $pEquips = $info_user_role['pEquips'];

                    $eqKey = $this->getKey($pEquips);

                    $collection = $this->CI->GameModel->getCollection($eqKey,$params['server']);

                    //get vls

                    $vls = $this->CI->GameModel->getVls($collection,$params['server']);

                    //hero
                    //$this->data['hero'] = $vls;
                    $arrHero[$v['name']] = $vls;

                    //get value shop

                    $strItem = '';
                    if(empty($vls) === FALSE){
                        foreach($vls as $val){
                            if($strItem == ''){
                               $strItem .= "'".$val['itemId']."'"; 
                            }else{
                                $strItem .= ",'".$val['itemId']."'";
                            }
                        }
                    }

                    $shop = $this->CI->GameModel->shopequip($strItem,$params['server']);


                    //$this->data['shopequip'] = $shop;
                    $arrShop[$v['name']] = $shop;
                }
            }

            $this->data['hero'] = $arrHero;
            $this->data['shopequip'] = $arrShop;
            
            
			/*
            //get shop
            $userbuy = $this->CI->GameModel->userbuy($strId,$params['server']);
            
            if(empty($userbuy) === FALSE){
                foreach($userbuy as $key => $val){
                    $userbuy[$key]['buytime'] = date('Y-m-d H:i:s',$val['buytime']);
                }
            }
            $this->data['userbuy'] = $userbuy;
           
            //get card
            $usercard = $this->CI->GameModel->usercard($strId,$params['server']);
            
            $this->data['usercard'] = $usercard;
            
            //get friend
            $userfriend = $this->CI->GameModel->userfriend($strId,$params['server']);
            
            $this->data['userfriend'] = $userfriend;
             */         
            
        }
    } catch (Exception $e) {
		//echo $e->getMessage();
		echo '<script>alert("'.$e->getMessage().'")</script>';
		
	}     
        $this->CI->template->write_view('content', 'game/infouser', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function infoitem(MeAPI_RequestInterface $request) {
	try{
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $arrServer = $admin_config['config']['server'];
        
		$srvItem = '';
        $co = 0;
        foreach($arrServer as $k => $s){
            try{
                $srvItem = $k;
                $this->CI->load->MeAPI_Model('GameModel');
                $role_all = $this->CI->GameModel->checkdb($srvItem);

                if(empty($role_all) === TRUE){
                    $co = 1;
                    break;
                }

            }catch (Exception $e){
                $co = 1;
                break;
            }
        }



        if($co){
            $srvItem = 'game'.((int)substr($srvItem, 4) - 1);
        }
                        
        $this->data['srvItem'] = $srvItem;
		
		
		
		
        $this->data['server'] = $arrServer;
        
        
        
        $this->CI->load->MeAPI_Model('GameModel');
        if ($this->CI->input->post()) {
            $params = $request->input_post();
            
            //get role all
            $role_all = $this->CI->GameModel->role_all("game_account".substr($params['server'], 4));
            //get user_all
            $user_all = $this->CI->GameModel->user_all("game_account".substr($params['server'], 4));
            //shop_all
            $shop_all = $this->CI->GameModel->shop_all($params['server']);
            //item_all
            $item_all = $this->CI->GameModel->item_all();
            
            $this->CI->load->MeAPI_Library('Pgt');
                     
            if(isset($_POST['page']) && is_numeric($_POST['page'])){
                $page = $_POST['page'];
            }else{
                $page=1;
            }
            $this->data['page'] = $page;
            $per_page = 5000;
            $pa = $page - 1;
            $start = $pa * $per_page;
            
             
                //get info user game
                $info_user_role = $this->CI->GameModel->infouserrole(null,$params['server']);
                $eqKey = '';
                if(empty($info_user_role) === FALSE){
                    
                    foreach($info_user_role as $key => $val){
                        $pEquips = $val['pEquips'];
                        if($eqKey == ''){
                            $eqKey .= "'".$this->getKey($pEquips)."'";
                        }else{
                            $eqKey .= ",'".$this->getKey($pEquips)."'";
                        }
                        
                    }
                    
                }
                
                $collection = $this->CI->GameModel->getCollection_All($eqKey,$params['server']);
                
                //get vls
				$rs = array();
                $role_top = $this->CI->GameModel->getVls_All($collection,$params['server'],$per_page,$page);
                
                if (!empty($role_top)) {
                    $r = array();
                    foreach ($role_top as $m) {
                        $r[$m['itemId']][] = $m;
                    }
                
                
                $i = 0;
                foreach ($r as $key => $val){
                    $t = 0;
                    foreach ($val as $v){
                        $t += 1;
                    }
                    $rs[$i]['id'] = $key;
                    $rs[$i]['number'] = $t;
                    $i += 1;
                }
                
                foreach ($rs as $k => $v){
                    $rs[$k]['name'] = $item_all[$v['id']]['name'];
                    $rs[$k]['type'] = $item_all[$v['id']]['type'];
                    $rs[$k]['coin'] = $item_all[$v['id']]['coin'];
                    $rs[$k]['gold'] = $item_all[$v['id']]['gold'];
                    $rs[$k]['color'] = $item_all[$v['id']]['color'];
                    $rs[$k]['shop'] = $item_all[$v['id']]['shop'];
                    $rs[$k]['desc'] = $item_all[$v['id']]['desc'];
                }
                }         
            
           
            $this->data['result'] = $rs;
            
            $total = $this->CI->GameModel->getTotal();
            $config = array();
            $config['cur_page'] = $page;
            $config['base_url'] = base_url().'?control=game&func=infotop';
            $config['total_rows'] = $total;
            $config['per_page'] = $per_page;
            /* Initialize the pagination library with the config array */
            $this->CI->Pgt->cfig($config);

            $this->data['pages'] = $this->CI->Pgt->create_links();
         }
    } catch (Exception $e) {
	  //echo $e->getMessage();
   }  
        
        
        $this->CI->template->write_view('content', 'game/infoitem', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
     }
    public function infouslgi(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $this->data['server'] = $admin_config['config']['server'];
        
        $arrServer = $admin_config['config']['server'];
		
		$srvItem = '';
        $co = 0;
        foreach($arrServer as $k => $s){
            try{
                $srvItem = $k;
                $this->CI->load->MeAPI_Model('GameModel');
                $role_all = $this->CI->GameModel->checkdb($srvItem);

                if(empty($role_all) === TRUE){
                    $co = 1;
                    break;
                }

            }catch (Exception $e){
                $co = 1;
                break;
            }
        }



        if($co){
            $srvItem = 'game'.((int)substr($srvItem, 4) - 1);
        }
                        
        $this->data['srvItem'] = $srvItem;
        
		
		
        
        $arrServerData = $admin_config['config']['server_data']; 
        
        $arrServerAccount = $admin_config['config']['server_account'];
        
             
        $this->CI->load->MeAPI_Model('GameModel');
               
        if ($this->CI->input->post()) {
            $params = $request->input_post();
            
        }
                
        $this->CI->template->write_view('content', 'game/infouslgi', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());        
    }
    public function loaddata(MeAPI_RequestInterface $request){
        $this->CI->load->MeAPI_Model('GameModel');
        $params = $request->input_post();
        $result = $this->CI->GameModel->loginnum('game_log'.substr($params['server'], 4));
		
        $arr = array();
        
        if(empty($result) === FALSE){
            foreach($result as $val){
                $arr[$val['d']] = $val['v'];
            }
        }
        $ngayBd = date('Y-m-d',strtotime(date('Y-m-d')) - 86400*30);
        
        $ngayKt = date('Y-m-d');
        $arrNgay = $this->tinhngay($ngayBd, $ngayKt);
        
		
        $data_y = array();
        $data_x = array();
        foreach($arrNgay as $key => $val){
            $data_x[] = $val;
            if(isset($arr[$val])){
                $data_y[] = (int)$arr[$val];
            }else{
                $data_y[] = 0;
            }
                      
        }
                
        $arr = array();
        $arr['data_y'] = $data_y;
        $arr['data_x'] = $data_x;
        echo json_encode($arr);
        exit;
    }
    
    public function loadquit(MeAPI_RequestInterface $request){
        $this->CI->load->MeAPI_Model('GameModel');
        $params = $request->input_post();
        
        $q7 = $this->CI->GameModel->quit7($params['server']);
        
        $arrQ7 = array();
        if(empty($q7) === FALSE){
            foreach($q7 as $key => $val){
                $arrQ7[$val['level']] = $val['c'];
            }
        }
        
        $q30 = $this->CI->GameModel->quit30($params['server']);
        
        $arrQ30 = array();
        if(empty($q30) === FALSE){
            foreach($q30 as $key => $val){
                $arrQ30[$val['level']] = $val['c'];
            }
        }
        
        $max7 = count($q7) - 1;
        $maxL7 = $q7[$max7]['level'];
        
        $max30 = count($q30) - 1;
        $maxL30 = $q30[$max30]['level'];
        
        
        if($maxL30 > $maxL7){
            $maxL = $maxL30;
        }else{
            $maxL = $maxL7;
        }
        $arrL = array();
        $arr7_y = array();
        $arr30_y = array();
        for($i=1; $i <= $maxL; $i++){
            $arrL[] = $i;
            if(isset($arrQ7[$i])){
                $arr7_y[] = (int)$arrQ7[$i];
            }else{
                $arr7_y[] = 0;
            }
            
            if(isset($arrQ30[$i])){
                $arr30_y[] = (int)$arrQ30[$i];
            }else{
                $arr30_y[] = 0;
            }
        }
        
        $html = "<table width='100%' class='table table-striped table-bordered table-condensed table-hover'>";
        $html .= "
                  <thead>  
                  <tr>
                    <th>Level</th>
                    <th>Quit7</th>
                    <th>Quit30</th>
                  </tr>
                  </thead>
                  <tbody>";
                  foreach($arrL as $key => $val){
                  $html .= "
                            <tr>
                                <td>".$val."</td>
                                <td>".$arr7_y[$key]."</td>
                                <td>".$arr30_y[$key]."</td>
                            </tr>
                           ";
                  }
        $html .= "</tbody></table>";
        
        
        $arr = array();
        $arr['data_y7'] = $arr7_y;
        $arr['data_y30'] = $arr30_y;
        $arr['data_x'] = $arrL;
        $arr['data_html'] = $html;
        echo json_encode($arr);
        exit;
    }
    public function getKey($str){
        $eq = explode(':', $str);
        return $eq[1];
    }
	
	 public function infolgtime(MeAPI_RequestInterface $request){
         $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $arrServer = $admin_config['config']['server'];
        
        $arrServerLog = $admin_config['config']['server_log'];
        $this->data['server'] = $arrServer;
                
        $logs = array(
            'accountlogin' => 'Account Login',
            //'accountregister' => 'Account Register',
            //'level' => 'Level',
            //'moneyremove' => 'Money Remove',
            //'rolelogin' => 'Role Login',
            //'roleregister' => 'Role Register',            
        );
        $this->data['logs'] = $logs;
        
        $this->CI->load->MeAPI_Model('GameModel');
         
        if ($this->CI->input->post()) {
            $params = $request->input_post();
            $pm = array_diff($params, array('server'=>$params['server'],'btnsubmit'=>$params['btnsubmit'],'log_name'=>$params['log_name'],'date_log'=>$params['date_log'],'page'=>$params['page']));
            $param = null;
            foreach($pm as $k => $v){
                if($v != ''){
                    $param = $v;
                    $func = $k;
                    break;
                }
            }
            
            if(empty($param) === TRUE){
                $url = $this->CI->config->base_url('?control=game&func=infolog');
                //redirect($url);
                //exit;
            }
                     
            /*
            foreach($arrServer as $key => $val){
                $srv = "game_account".substr($key, 4);
                $game_account = $this->CI->GameModel->{$func}(trim($param), $srv);
                if(empty($game_account) === FALSE){
                    break;
                }                
            }
            */         
            $this->CI->load->MeAPI_Library('Pgt');
                     
            if(isset($_POST['page']) && is_numeric($_POST['page'])){
                $page = $_POST['page'];
            }else{
                $page=1;
            }
            $this->data['page'] = $page;
            $per_page = 50;
            $pa = $page - 1;
            $start = $pa * $per_page;
            
            if($params['log_name'] == 'level'){
                $result_log = $this->CI->GameModel->level_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page,date('Y-m-d',strtotime($params['date_log'])));
            }elseif($params['log_name'] == 'accountlogin'){
                $mobo_all = $this->CI->GameModel->mobo_all();
				//echo '<pre>';
				//print_r($mobo_all);
				//echo '</pre>';
				
				$role_alll = $this->CI->GameModel->role_alll("game_account".substr($params['server'], 4));
				//echo '<pre>';
				//print_r($role_alll);
				//echo '</pre>';
				//exit;
				//get role all
				//$role_all = $this->CI->GameModel->role_all("game_account".substr($params['server'], 4));
				//get user_all
				$user_all = $this->CI->GameModel->user_all("game_account".substr($params['server'], 4));
				$username_all = $this->CI->GameModel->username_all($params['server']);
				
				//echo '<pre>';
				//print_r($username_all);
				//echo '</pre>';
				
				$arrr = array();
				$stt = 0;
				foreach($username_all as $val){
					if($val['level'] >= 80){
						$arrr[$stt]['level'] = $val['level'];
						$arrr[$stt]['key_'] = $val['key_'];
						$stt ++;
					}
				}
				
				foreach($arrr as $key => $v){
					$arrr[$key]['roleName'] = $role_alll[$v['key_']]['roleName'];
					$arrr[$key]['moboName'] = $mobo_all[$user_all[$role_alll[$v['key_']]['ownerId']]];
				}
				
				//echo json_encode($arrr);
				//exit;
				
				//$role_top = $this->CI->GameModel->role_top($params['server'],10000,'toplevel',1);
                
				//echo '<pre>';
				//print_r($arrr);
				//echo '</pre>';
				//exit;
				
				$result_log = $this->CI->GameModel->accountlogin_logtime('game_log'.substr($params['server'], 4),$per_page,$page,date('Y-m-d H:i:s',strtotime($params['date_log'])));
				
				
				if(empty($result_log) === FALSE){
                    foreach($result_log as $key => $val){
                        //$role_top[$key]['roleName'] = $role_all[$val['role_id']];
                        //$role_top[$key]['userName'] = $user_all[$val['account_id']];
                        //$result_log[$key]['Level'] = $val['value_'];
                        //$result_log[$key]['roleId'] = $val['key_'];
                        //$role_top[$key]['roleName'] = $role_all[$val['key_']];
						//$result_log[$key]['roleName'] = $role_alll[$val['key_']]['roleName'];
                        $result_log[$key]['role'] = $username_all[$val['account_id']];
						//$result_log[$key]['moboName'] = $mobo_all[$user_all[$role_alll[$val['key_']]['ownerId']]];
						//echo $user_all[$val['account_id']];
                    }
                }
				
				
            }elseif ($params['log_name'] == 'accountregister') {
                $result_log = $this->CI->GameModel->accountregister_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page);
            }elseif ($params['log_name'] == 'moneyremove') {
                $result_log = $this->CI->GameModel->moneyremove_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page,date('Y-m-d',strtotime($params['date_log'])));
            }elseif ($params['log_name'] == 'rolelogin') {
                $result_log = $this->CI->GameModel->rolelogin_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page,date('Y-m-d',strtotime($params['date_log'])));
            }elseif ($params['log_name'] == 'roleregister') {
                $result_log = $this->CI->GameModel->roleregister_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page);
            }       
            
            
            
            
            
            
            
            
            $this->data['result'] = $result_log;
            
            $total = $this->CI->GameModel->getTotal();
            $config = array();
            $config['cur_page'] = $page;
            $config['base_url'] = base_url().'?control=game&func=infolog';
            $config['total_rows'] = $total;
            $config['per_page'] = $per_page;
            /* Initialize the pagination library with the config array */
            $this->CI->Pgt->cfig($config);

            $this->data['pages'] = $this->CI->Pgt->create_links();
            
        }
        
        $this->CI->template->write_view('content', 'game/infolgtime', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	
    public function infolog(MeAPI_RequestInterface $request) {
	try{
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $arrServer = $admin_config['config']['server'];
        
		
		$srvItem = '';
        $co = 0;
        foreach($arrServer as $k => $s){
            try{
                $srvItem = $k;
                $this->CI->load->MeAPI_Model('GameModel');
                $role_all = $this->CI->GameModel->checkdb($srvItem);

                if(empty($role_all) === TRUE){
                    $co = 1;
                    break;
                }

            }catch (Exception $e){
                $co = 1;
                break;
            }
        }



        if($co){
            $srvItem = 'game'.((int)substr($srvItem, 4) - 1);
        }
                        
        $this->data['srvItem'] = $srvItem;
        
		
		
        $arrServerLog = $admin_config['config']['server_log'];
        $this->data['server'] = $arrServer;
                
        $logs = array(
            'accountlogin' => 'Account Login',
            'accountregister' => 'Account Register',
            'level' => 'Level',
            'moneyremove' => 'Money Remove',
            'rolelogin' => 'Role Login',
            'roleregister' => 'Role Register',            
        );
        $this->data['logs'] = $logs;
        
        $this->CI->load->MeAPI_Model('GameModel');
         
        if ($this->CI->input->post()) {
            $params = $request->input_post();
            $pm = array_diff($params, array('server'=>$params['server'],'btnsubmit'=>$params['btnsubmit'],'log_name'=>$params['log_name'],'date_log'=>$params['date_log'],'page'=>$params['page']));
            $param = null;
            foreach($pm as $k => $v){
                if($v != ''){
                    $param = $v;
                    $func = $k;
                    break;
                }
            }
            
            if(empty($param) === TRUE){
                $url = $this->CI->config->base_url('?control=game&func=infolog');
                redirect($url);
                exit;
            }
                     
            
            foreach($arrServer as $key => $val){
                $srv = "game_account".substr($key, 4);
                $game_account = $this->CI->GameModel->{$func}(trim($param), $srv);
                if(empty($game_account) === FALSE){
                    break;
                }                
            }
                       
            $this->CI->load->MeAPI_Library('Pgt');
                     
            if(isset($_POST['page']) && is_numeric($_POST['page'])){
                $page = $_POST['page'];
            }else{
                $page=1;
            }
            $this->data['page'] = $page;
            $per_page = 50;
            $pa = $page - 1;
            $start = $pa * $per_page;
            
            if($params['log_name'] == 'level'){
                $result_log = $this->CI->GameModel->level_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page,date('Y-m-d',strtotime($params['date_log'])));
            }elseif($params['log_name'] == 'accountlogin'){
                $result_log = $this->CI->GameModel->accountlogin_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page,date('Y-m-d',strtotime($params['date_log'])));
            }elseif ($params['log_name'] == 'accountregister') {
                $result_log = $this->CI->GameModel->accountregister_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page);
            }elseif ($params['log_name'] == 'moneyremove') {
                $result_log = $this->CI->GameModel->moneyremove_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page,date('Y-m-d',strtotime($params['date_log'])));
            }elseif ($params['log_name'] == 'rolelogin') {
                $result_log = $this->CI->GameModel->rolelogin_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page,date('Y-m-d',strtotime($params['date_log'])));
            }elseif ($params['log_name'] == 'roleregister') {
                $result_log = $this->CI->GameModel->roleregister_log($game_account['user_key'],'game_log'.substr($params['server'], 4),$per_page,$page);
            }       
            
            
            
            
            
            
            
            
            $this->data['result'] = $result_log;
            
            $total = $this->CI->GameModel->getTotal();
            $config = array();
            $config['cur_page'] = $page;
            $config['base_url'] = base_url().'?control=game&func=infolog';
            $config['total_rows'] = $total;
            $config['per_page'] = $per_page;
            /* Initialize the pagination library with the config array */
            $this->CI->Pgt->cfig($config);

            $this->data['pages'] = $this->CI->Pgt->create_links();
            
        }
    } catch (Exception $e) {
		  //echo $e->getMessage();
	}   
        $this->CI->template->write_view('content', 'game/infolog', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
     }
    public function infomail(MeAPI_RequestInterface $request){
	try{
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $this->data['server'] = $admin_config['config']['server'];
        
        $arrServer = $admin_config['config']['server'];
        
		$srvItem = '';
        $co = 0;
        foreach($arrServer as $k => $s){
            try{
                $srvItem = $k;
                $this->CI->load->MeAPI_Model('GameModel');
                $role_all = $this->CI->GameModel->checkdb($srvItem);

                if(empty($role_all) === TRUE){
                    $co = 1;
                    break;
                }

            }catch (Exception $e){
                $co = 1;
                break;
            }
        }



        if($co){
            $srvItem = 'game'.((int)substr($srvItem, 4) - 1);
        }
                        
        $this->data['srvItem'] = $srvItem;
        
		
		
		
		
        $arrServerData = $admin_config['config']['server_data']; 
        
        $arrServerAccount = $admin_config['config']['server_account'];
        
        
        $this->CI->load->MeAPI_Model('GameModel');
        
        if ($this->CI->input->post()) {
            $params = $request->input_post();
            $pm = array_diff($params, array('server'=>$params['server'],'btnsubmit'=>$params['btnsubmit']));
            $param = null;
            foreach($pm as $k => $v){
                if($v != ''){
                    $param = $v;
                    $func = $k;
                    break;
                }
            }
            if(empty($param) === TRUE){
                $url = $this->CI->config->base_url('?control=game&func=infomail');
                redirect($url);
                exit;
            }
                     
            
            foreach($arrServer as $key => $val){
                $srv = "game_account".substr($key, 4);
                $game_account = $this->CI->GameModel->{$func}(trim($param), $srv);
                if(empty($game_account) === FALSE){
                    break;
                }                
            }
            
           
            $option = 'preceivemail';
            $result_preceivemail = $this->CI->GameModel->get_mail($params['server'],$game_account['role_id'],$option);
            
            $option = 'psendmail';
            $result_psendmail = $this->CI->GameModel->get_mail($params['server'],$game_account['role_id'],$option);
            
            $result = array_merge($result_preceivemail,$result_psendmail);
            
            
            $this->data['result'] = $result;
            
        }
    } catch (Exception $e) {
	  //echo $e->getMessage();
   }    
        $this->CI->template->write_view('content', 'game/infomail', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
        
    }
    public function infotop(MeAPI_RequestInterface $request) {
		try{
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $arrServer = $admin_config['config']['server'];
        
		
		$srvItem = '';
        $co = 0;
        foreach($arrServer as $k => $s){
            try{
                $srvItem = $k;
                $this->CI->load->MeAPI_Model('GameModel');
                $role_all = $this->CI->GameModel->checkdb($srvItem);

                if(empty($role_all) === TRUE){
                    $co = 1;
                    break;
                }

            }catch (Exception $e){
                $co = 1;
                break;
            }
        }



        if($co){
            $srvItem = 'game'.((int)substr($srvItem, 4) - 1);
        }
                        
        $this->data['srvItem'] = $srvItem;
        
		
		
		
        $this->data['server'] = $arrServer;
        
        $arrTop = array('10' => 'Top 10', '50' => 'Top 50', '100' => 'Top 100');
        $this->data['arrtop'] = $arrTop;
        
        //$arrLoaitop = array('toplevel' => 'Top Level', 'topdanhvong' => 'Top Danh Vọng' ,'topthucluc' => 'Top Thực Lực', 'onlineMilliTime' => 'Thời gian chơi','hero'=>'Ds Hero', 'userbuy' => 'Vật phẩm');
        $arrLoaitop = array(
                            'toplevel' => 'Top Level',
                            'rmbamount' => 'Top Rmbamount',
                            'gold' => 'Top Gold',
                            'heronum' => 'Top Heronum',
                            'pvpwinning' => 'Top Pvpwinning',
                            'hero'=>'Ds Hero',
                            'userbuy' => 'Ds Vật phẩm');
        $this->data['arrloaitop'] = $arrLoaitop;
        
        $this->CI->load->MeAPI_Model('GameModel');
        if ($this->CI->input->post()) {
            $params = $request->input_post();
            
			
			$mobo_all = $this->CI->GameModel->mobo_all();
			//echo '<pre>';
			//print_r($mobo_all);
			//echo '</pre>';
			
			$role_alll = $this->CI->GameModel->role_alll("game_account".substr($params['server'], 4));
			
            //get role all
            $role_all = $this->CI->GameModel->role_all("game_account".substr($params['server'], 4));
            //get user_all
            $user_all = $this->CI->GameModel->user_all("game_account".substr($params['server'], 4));
            //shop_all
            $shop_all = $this->CI->GameModel->shop_all($params['server']);
            
            
            $this->CI->load->MeAPI_Library('Pgt');
                     
            if(isset($_POST['page']) && is_numeric($_POST['page'])){
                $page = $_POST['page'];
            }else{
                $page=1;
            }
            $this->data['page'] = $page;
            $per_page = 100;
            $pa = $page - 1;
            $start = $pa * $per_page;
            
             
            if($params['loaitop'] == 'toplevel'){
                $role_top = $this->CI->GameModel->role_top($params['server'],$per_page,$params['loaitop'],$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        //$role_top[$key]['roleName'] = $role_all[$val['role_id']];
                        //$role_top[$key]['userName'] = $user_all[$val['account_id']];
                        $role_top[$key]['Level'] = $val['value_'];
                        $role_top[$key]['roleId'] = $val['key_'];
                        //$role_top[$key]['roleName'] = $role_all[$val['key_']];
						$role_top[$key]['roleName'] = $role_alll[$val['key_']]['roleName'];
                        //$role_top[$key]['userName'] = $user_all[$role_alll[$val['key_']]['ownerId']];
						$role_top[$key]['moboName'] = $mobo_all[$user_all[$role_alll[$val['key_']]['ownerId']]];
                    }
                }
            }elseif ($params['loaitop'] == 'gold') {
                $role_top = $this->CI->GameModel->gold_top($params['server'],$per_page,$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['key_']];
                    }
                }
            }elseif ($params['loaitop'] == 'rmbamount') {
                $role_top = $this->CI->GameModel->rmbamount_top($params['server'],$per_page,$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['key_']];
                    }
                }        
            }elseif ($params['loaitop'] == 'heronum') {
                $role_top = $this->CI->GameModel->heronum_top($params['server'],$per_page,$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['key_']];
                    }
                }
            }elseif ($params['loaitop'] == 'pvpwinning') {
               $role_top = $this->CI->GameModel->pvpwinning_top($params['server'],$per_page,$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['key_']];
                    }
                }            
            }elseif($params['loaitop'] == 'hero'){
                //get info user game
                $info_user_role = $this->CI->GameModel->infouserrole(null,$params['server']);
                $eqKey = '';
                if(empty($info_user_role) === FALSE){
                    
                    foreach($info_user_role as $key => $val){
                        $pEquips = $val['pEquips'];
                        if($eqKey == ''){
                            $eqKey .= "'".$this->getKey($pEquips)."'";
                        }else{
                            $eqKey .= ",'".$this->getKey($pEquips)."'";
                        }
                        
                    }
                    
                }
                
                $collection = $this->CI->GameModel->getCollection_All($eqKey,$params['server']);
                
                //get vls

                $role_top = $this->CI->GameModel->getVls_All($collection,$params['server'],$per_page,$page);
                
                if(empty($role_top) === FALSE){
                    foreach ($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['ownerId']];
                    }
                }
                
            }elseif($params['loaitop'] == 'userbuy'){
                //get info user game
                $info_user_role = $this->CI->GameModel->infouserrole(null,$params['server']);
                $eqKey = '';
                if(empty($info_user_role) === FALSE){
                    
                    foreach($info_user_role as $key => $val){
                        $pEquips = $val['pEquips'];
                        if($eqKey == ''){
                            $eqKey .= "'".$this->getKey($pEquips)."'";
                        }else{
                            $eqKey .= ",'".$this->getKey($pEquips)."'";
                        }
                        
                    }
                    
                }
                
                $collection = $this->CI->GameModel->getCollection_All($eqKey,$params['server']);
                
                //get vls

                $role_top = $this->CI->GameModel->getVls_All($collection,$params['server'],$per_page,$page);
                
                if(empty($role_top) === FALSE){
                    foreach ($role_top as $key => $val){
                            $role_top[$key]['roleName'] = $role_all[$val['ownerId']];
                            $role_top[$key]['shopName'] = $shop_all[$val['itemId']]['name'];
                            $role_top[$key]['money'] = $shop_all[$val['itemId']]['money'];
                    }
                }
                                
            }
           
            $this->data['result'] = $role_top;
            
            $total = $this->CI->GameModel->getTotal();
            $config = array();
            $config['cur_page'] = $page;
            $config['base_url'] = base_url().'?control=game&func=infotop';
            $config['total_rows'] = $total;
            $config['per_page'] = $per_page;
            /* Initialize the pagination library with the config array */
            $this->CI->Pgt->cfig($config);

            $this->data['pages'] = $this->CI->Pgt->create_links();
         }
		
		} catch (Exception $e) {
			//echo $e->getMessage();
			echo '<script>alert("'.$e->getMessage().'")</script>';
	   }
        
        $this->CI->template->write_view('content', 'game/infotop', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function mission(MeAPI_RequestInterface $request){
        $params = $request->input_request();
        $id = $params['id'];
        $this->CI->load->MeAPI_Model('GameModel');
        $result = $this->CI->GameModel->missionid($id);
        $html = "<tr><td colspan='4'>
                     <table width='100%'>
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>desc</th>
                                <th>repeatTimes</th>
                             </tr>
                         </thead>
                         <tbody>";
            if(empty($result) === FALSE){
                foreach($result as $val){
                    $html .= "<tr>
                              <td>".$val['name']."</td>
                              <td>".$val['desc']."</td>
                              <td>".$val['repeatTimes']."</td>
                             </tr>";
                    }
                }
            $html .= "</tbody>
            </table></td></tr>";
    
        echo json_encode($html);
        exit;
    }
    
    public function tinhngay($ngaybd, $ngaykt){
        $nambd = (int)(date('Y',strtotime($ngaybd)));
        $namkt = (int)(date('Y',strtotime($ngaykt)));

        $arrNam = array();
        $j=0;
        for($i = $nambd; $i <= $namkt; $i++){
                $arrNam[$j] = $i;
                $j++;
        }
        $arrNgay = array();
        if(strtotime($ngaykt) > strtotime($ngaybd)){
                if(count($arrNam) == 1){
                        $t1 = (int)(date('m',strtotime($ngaybd)));
                        $n1 = (int)(date('d',strtotime($ngaybd)));
                        $t2 = (int)(date('m',strtotime($ngaykt)));
                        $n2 = (int)(date('d',strtotime($ngaykt)));
                        $nam = date('Y',strtotime($ngaybd));
                        $t21 = $t2 - $t1;

                        if($t21 > 0){
                                $snv = mktime(0,0,0,$t1,1,$nam);
                                $sn = date("t", $snv);
                                for($n=$n1; $n<=$sn; $n++){
                                         $arrNgay[] = date('Y-m-d',  strtotime($nam . "-" . $t1 . "-" . $n));
                                }


                                if($t21 > 1 ){
                                        for($t=$t1+1; $t<=$t2-1; $t++){
                                                                   $snv = mktime(0,0,0,$t,1,$nam);
                                                                   $sn = date("t", $snv);
                                                                   for($n=1; $n<=$sn; $n++){
                                                                                 $arrNgay[] = $nam . "-" . $t . "-" . $n;
                                                                   }
                                        }
                                }

                                for($n=1; $n<=$n2; $n++){
                                         $arrNgay[] = date('Y-m-d',strtotime($nam . "-" . $t2 . "-" . $n));
                                }

                        }else{
                                for($n=$n1; $n<=$n2; $n++){
                                         $arrNgay[] = date('Y-m-d',strtotime($nam . "-" . $t1 . "-" . $n));
                                }
                        }


                }

                if(count($arrNam)>1){
                        //Get ngay cua nam dau
                        $t1 = (int)(date('m',strtotime($ngaybd)));
                        $n1 = (int)(date('d',strtotime($ngaybd)));
                        $nam = date('Y',strtotime($ngaybd));

                                   $snv = mktime(0,0,0,$t1,1,$nam);
                                   $sn = date("t", $snv);
                                   for($n=$n1; $n<=$sn; $n++){
                                                 $arrNgay[] = date('Y-m-d',strtotime($nam . "-" . $t1 . "-" . $n));
                                   }

                        if($t1 != 12){
                                for($t=$t1+1; $t<=12; $t++){
                                                           $snv = mktime(0,0,0,$t,1,$nam);
                                                           $sn = date("t", $snv);
                                                           for($n=1; $n<=$sn; $n++){
                                                                         $arrNgay[] = date('Y-m-d',  strtotime($nam . "-" . $t . "-" . $n));
                                                           }
                                }
                        }

                        //Get ngay cua cac nam giua
                        if(count($arrNam)>2){
                        foreach($arrNam as $key => $value){
                                 if($key > 0 && $key < count($arrNam)-1){
                                          for($t=1; $t<=12; $t++){
                                                   $snv = mktime(0,0,0,$t,1,$value);
                                                   $sn = date("t", $snv);
                                                   for($n=1; $n<=$sn; $n++){
                                                                 $arrNgay[] = date('Y-m-d',  strtotime($value . "-" . $t . "-" . $n));
                                                   }
                                          }
                                 }

                        }
                        }
                        //Get ngay cua nam cuoi
                        $t2 = (int)(date('m',strtotime($ngaykt)));
                        $n2 = (int)(date('d',strtotime($ngaykt)));
                        $nam = date('Y',strtotime($ngaykt));
                        if($t2>1){
                        for($t=1; $t<$t2; $t++){
                                                   $snv = mktime(0,0,0,$t,1,$nam);
                                                   $sn = date("t", $snv);
                                                   for($n=1; $n<=$sn; $n++){
                                                                 $arrNgay[] = date('Y-m-d',strtotime($nam . "-" . $t . "-" . $n));
                                                   }
                        }
                        }

                        for($n=1; $n<=$n2; $n++){
                                 $arrNgay[] = date('Y-m-d',strtotime($nam . "-" . $t2 . "-" . $n));
                        }

                }
        }

        return $arrNgay;
}
	
	public function checkdb(MeAPI_RequestInterface $request) {
		$this->CI->load->MeAPI_Model('GameModel');
        $game_account = '18d1lel8b';
		$strId = '806789';
		$server = 'game1';
		
		//$roleadvertisement = $this->CI->GameModel->roleadvertisement($strId,$server);
        //$adver = $this->CI->GameModel->advertisement();
		//$rolemember = $this->CI->GameModel->rolemember($strId,$server);
        //$member = $this->CI->GameModel->memberdata();
		$params = $request->input_request();
		//$server = $params['db'];
		//$table = $params['tb'];
		
		$server = 'game_log3';
		$table = 'level';
		
		$server = 'game3';
		$table = 'game_service_user_userprofile_level';
		
		$server = 'game_account3';
		$table = 'cn_x6game_model_roleinfo_rolename';
		
		//$table = 'accountregis
		//$table = 'accountregister';
		//$table = 'accountcharge';
		$server = 'moboinfo';
		$table = 'accounts';
		//$server = 'game_account1';
		//$table = 'cn_x6game_user_xuserprofile_regname';
		
		//$server = '3k_logs';
		//$table = 'cron_top_level';
		
		//$server = 'game1';
		//$table = 'game_service_user_userprofile';
		//$server = 'inside_info';
		//$table = 'account_name`';
		
		//$server = 'game_log1';
		//$table = 'level';
		
		//$server = 'game4';
		//$table = 'game_service_user_userprofile';
		
		//$server = 'game_account5';
		//$table = 'cn_x6game_user_xuserprofile_mac';
		
		$server = 'inside_info';
		$table = 'account_has_menu';
		
		$check = $this->CI->GameModel->check_db($server,$table);
		echo '<pre>';
		print_r($check);
		echo '</pre>';
		
		exit;
	}
    /*
	public function cron_level(MeAPI_RequestInterface $request){
		$this->CI->config->load('admin');
		$admin_config = $this->CI->config->item('admin');
		$arrServer = $admin_config['config']['server'];
	   
		$srv = end(array_keys($arrServer));
		
		$this->CI->load->MeAPI_Model('GameModel');
		$role_all = $this->CI->GameModel->role_all("game_account".substr($srv, 4));
		$user_all = $this->CI->GameModel->user_all("game_account".substr($srv, 4));
		
		
		
		$curent = strtotime(date('Y-m-d H:i:s'));
        
		$last = date('Y-m-d H:i:s', $curent - 3600);
		
		$role_top = $this->CI->GameModel->top_level_cron($srv,100,$last,1);
				
		if(empty($role_top) === FALSE){
			foreach($role_top as $key => $val){
				$role_top[$key]['roleName'] = $role_all[$val['role_id']];
				$role_top[$key]['userName'] = $user_all[$val['account_id']];

			}
		}
				
	    $data = json_encode($role_top);
	    $this->CI->GameModel->save_cron_level($data,$last);
	    exit();
	}
	*/
public function cron_level(MeAPI_RequestInterface $request){
    $this->CI->config->load('admin');
    $admin_config = $this->CI->config->item('admin');
    $arrServer = $admin_config['config']['server'];
    $srv = '';
    $co = 0;
    foreach($arrServer as $k => $s){
        try{
            $srv = $k;
            $this->CI->load->MeAPI_Model('GameModel');
            $role_all = $this->CI->GameModel->checkdb($srv);
            if(empty($role_all) === TRUE){
				$co = 1;
				break;
			}
        }catch (Exception $e){
            $co = 1;
            break;
        }
    }
        
    if($co){
        $srv = 'game'.((int)substr($srv, 4) - 1);
    }
			
    //$srv = end(array_keys($arrServer));
    
    try {   
    
    $this->CI->load->MeAPI_Model('GameModel');
    
    $role_all = $this->CI->GameModel->role_all("game_account".substr($srv, 4));
    $user_all = $this->CI->GameModel->user_all("game_account".substr($srv, 4));
    
    $curent = strtotime(date('Y-m-d H:i:s'));
        
    $last = date('Y-m-d H:i:s', $curent - 3600);
    
    $role_top = $this->CI->GameModel->top_level_cron($srv,100,$last,1);
    
	
    if(empty($role_top) === FALSE){
        foreach($role_top as $key => $val){
            //$role_top[$key]['roleName'] = $role_all[$val['role_id']];
            //$role_top[$key]['userName'] = $user_all[$val['account_id']];
			$role_top[$key]['Level'] = $val['value_'];
            $role_top[$key]['roleId'] = $val['key_'];
            $role_top[$key]['roleName'] = $role_all[$val['key_']];
            $role_top[$key]['server'] = $srv;
            $role_top[$key]['time'] = date('Y-m-d H:i:s');
        }
    }
   
   $data = json_encode($role_top);
   $this->CI->GameModel->save_cron_level($data,$last);
   
      
   } catch (Exception $e) {
      echo $e->getMessage();
   }
    
   
   exit();
}

public function exportTop(MeAPI_RequestInterface $request){
   try{
        //$this->authorize->validateAuthorizeMenu($request);
        //$this->authorize->validateAuthorizeRequest($request, 0);
        
        $this->CI->config->load('admin');
        $admin_config = $this->CI->config->item('admin');
        $arrServer = $admin_config['config']['server'];
        
		
		$srvItem = '';
        $co = 0;
        foreach($arrServer as $k => $s){
            try{
                $srvItem = $k;
                $this->CI->load->MeAPI_Model('GameModel');
                $role_all = $this->CI->GameModel->checkdb($srvItem);

                if(empty($role_all) === TRUE){
                    $co = 1;
                    break;
                }

            }catch (Exception $e){
                $co = 1;
                break;
            }
        }



        if($co){
            $srvItem = 'game'.((int)substr($srvItem, 4) - 1);
        }
                        
        $this->data['srvItem'] = $srvItem;
        
		
		
		
        $this->data['server'] = $arrServer;
        
        $arrTop = array('10' => 'Top 10', '50' => 'Top 50', '100' => 'Top 100');
        $this->data['arrtop'] = $arrTop;
        
        //$arrLoaitop = array('toplevel' => 'Top Level', 'topdanhvong' => 'Top Danh Vọng' ,'topthucluc' => 'Top Thực Lực', 'onlineMilliTime' => 'Thời gian chơi','hero'=>'Ds Hero', 'userbuy' => 'Vật phẩm');
        $arrLoaitop = array(
                            'toplevel' => 'Top Level',
                            'rmbamount' => 'Top Rmbamount',
                            'gold' => 'Top Gold',
                            'heronum' => 'Top Heronum',
                            'pvpwinning' => 'Top Pvpwinning',
                            'hero'=>'Ds Hero',
                            'userbuy' => 'Ds Vật phẩm');
        $this->data['arrloaitop'] = $arrLoaitop;
        
        $this->CI->load->MeAPI_Model('GameModel');
        if ($this->CI->input->post()) {
            $params = $request->input_post();
            
			
			$mobo_all = $this->CI->GameModel->mobo_all();
					
			$role_alll = $this->CI->GameModel->role_alll("game_account".substr($params['server'], 4));
			
            //get role all
            $role_all = $this->CI->GameModel->role_all("game_account".substr($params['server'], 4));
            //get user_all
            $user_all = $this->CI->GameModel->user_all("game_account".substr($params['server'], 4));
            //shop_all
            $shop_all = $this->CI->GameModel->shop_all($params['server']);
            
            
            $this->CI->load->MeAPI_Library('Pgt');
                     
            if(isset($_POST['page']) && is_numeric($_POST['page'])){
                $page = $_POST['page'];
            }else{
                $page=1;
            }
            $this->data['page'] = $page;
            $per_page = 100;
            $pa = $page - 1;
            $start = $pa * $per_page;
            
             
            if($params['loaitop'] == 'toplevel'){
                $role_top = $this->CI->GameModel->role_top($params['server'],$per_page,$params['loaitop'],$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        //$role_top[$key]['roleName'] = $role_all[$val['role_id']];
                        //$role_top[$key]['userName'] = $user_all[$val['account_id']];
                        $role_top[$key]['Level'] = $val['value_'];
                        $role_top[$key]['roleId'] = $val['key_'];
                        //$role_top[$key]['roleName'] = $role_all[$val['key_']];
						$role_top[$key]['roleName'] = $role_alll[$val['key_']]['roleName'];
                        //$role_top[$key]['userName'] = $user_all[$role_alll[$val['key_']]['ownerId']];
						$role_top[$key]['moboName'] = $mobo_all[$user_all[$role_alll[$val['key_']]['ownerId']]];
                    }
                }
            }elseif ($params['loaitop'] == 'gold') {
                $role_top = $this->CI->GameModel->gold_top($params['server'],$per_page,$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['key_']];
                    }
                }
            }elseif ($params['loaitop'] == 'rmbamount') {
                $role_top = $this->CI->GameModel->rmbamount_top($params['server'],$per_page,$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['key_']];
                    }
                }        
            }elseif ($params['loaitop'] == 'heronum') {
                $role_top = $this->CI->GameModel->heronum_top($params['server'],$per_page,$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['key_']];
                    }
                }
            }elseif ($params['loaitop'] == 'pvpwinning') {
               $role_top = $this->CI->GameModel->pvpwinning_top($params['server'],$per_page,$page);
                if(empty($role_top) === FALSE){
                    foreach($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['key_']];
                    }
                }            
            }elseif($params['loaitop'] == 'hero'){
                //get info user game
                $info_user_role = $this->CI->GameModel->infouserrole(null,$params['server']);
                $eqKey = '';
                if(empty($info_user_role) === FALSE){
                    
                    foreach($info_user_role as $key => $val){
                        $pEquips = $val['pEquips'];
                        if($eqKey == ''){
                            $eqKey .= "'".$this->getKey($pEquips)."'";
                        }else{
                            $eqKey .= ",'".$this->getKey($pEquips)."'";
                        }
                        
                    }
                    
                }
                
                $collection = $this->CI->GameModel->getCollection_All($eqKey,$params['server']);
                
                //get vls

                $role_top = $this->CI->GameModel->getVls_All($collection,$params['server'],$per_page,$page);
                
                if(empty($role_top) === FALSE){
                    foreach ($role_top as $key => $val){
                        $role_top[$key]['roleName'] = $role_all[$val['ownerId']];
                    }
                }
                
            }elseif($params['loaitop'] == 'userbuy'){
                //get info user game
                $info_user_role = $this->CI->GameModel->infouserrole(null,$params['server']);
                $eqKey = '';
                if(empty($info_user_role) === FALSE){
                    
                    foreach($info_user_role as $key => $val){
                        $pEquips = $val['pEquips'];
                        if($eqKey == ''){
                            $eqKey .= "'".$this->getKey($pEquips)."'";
                        }else{
                            $eqKey .= ",'".$this->getKey($pEquips)."'";
                        }
                        
                    }
                    
                }
                
                $collection = $this->CI->GameModel->getCollection_All($eqKey,$params['server']);
                
                //get vls

                $role_top = $this->CI->GameModel->getVls_All($collection,$params['server'],$per_page,$page);
                
                if(empty($role_top) === FALSE){
                    foreach ($role_top as $key => $val){
                            $role_top[$key]['roleName'] = $role_all[$val['ownerId']];
                            $role_top[$key]['shopName'] = $shop_all[$val['itemId']]['name'];
                            $role_top[$key]['money'] = $shop_all[$val['itemId']]['money'];
                    }
                }
                                
            }
			
			$this->export($role_top,$params['loaitop']);
            $this->data['result'] = $role_top;
            
            $total = $this->CI->GameModel->getTotal();
            $config = array();
            $config['cur_page'] = $page;
            $config['base_url'] = base_url().'?control=game&func=infotop';
            $config['total_rows'] = $total;
            $config['per_page'] = $per_page;
            /* Initialize the pagination library with the config array */
            $this->CI->Pgt->cfig($config);

            $this->data['pages'] = $this->CI->Pgt->create_links();
         }
		
		} catch (Exception $e) {
			//echo $e->getMessage();
			echo '<script>alert("'.$e->getMessage().'")</script>';
	   }
        
        //$this->CI->template->write_view('content', 'game/infotop', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
}
public function export($params,$type){
	$arrCol = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T');
    switch ($type){
        case "toplevel":
            $title = 'TOP LEVEL';
            $arrTitle = array('Level','RoleName','MoboName');
            $arrField = array('Level','roleName','moboName');
            break;
        case "rmbamount":	
            $title = 'TOP RMBAMOUNT';
            $arrTitle = array('Value','RoleName');
            $arrField = array('value_','roleName');    
            break;
        case "gold":
            $title = 'TOP GOLD';
            $arrTitle = array('Value','RoleName');
            $arrField = array('value_','roleName');
            break;
        case "heronum":
            $title = 'TOP HERONUM';
            $arrTitle = array('Value','RoleName');
            $arrField = array('value_','roleName');
            break;
        case "pvpwinning":
            $title = 'TOP PVPWINNING';
            $arrTitle = array('Value','RoleName');
            $arrField = array('value_','roleName');
            break;
		case "hero":
			$title = 'LIST HERO';
            $arrTitle = array('heroName','roleName','enhancedLevel','normalatk','enhancedCoin','sellingPrice','level','grade','soldierMax','decrease','demoteCoin');
            $arrField = array('heroName','roleName','enhancedLevel','normalatk','enhancedCoin','sellingPrice','level','grade','soldierMax','decrease','demoteCoin');
			break;
		case "userbuy":
			$title = 'LIST VATPHAM';
            $arrTitle = array('shopName','money','heroName','roleName');
            $arrField = array('shopName','money','heroName','roleName');
            break;
        }	
    //Export Excel
    $this->CI->load->library('excel');
    //activate worksheet number 1
    $this->CI->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->CI->excel->getActiveSheet()->setTitle('test worksheet');
    //set cell A1 content with some text
    $this->CI->excel->getActiveSheet()->setCellValue('A1', $title);
    //change the font size
    $this->CI->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
    //make the font become bold
    $this->CI->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    //merge cell A1 until D1
   
    //Title
    $this->CI->excel->getActiveSheet()->mergeCells($arrCol[0].'1:'.$arrCol[count($arrTitle)-1].'1');
    foreach($arrTitle as $k => $v){
        $this->CI->excel->getActiveSheet()->setCellValueByColumnAndRow($k,3,$v);
    }
    
    $this->CI->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

 
    $this->CI->excel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $this->CI->excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
    $this->CI->excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
    $this->CI->excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
    $this->CI->excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
    $this->CI->excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
    $this->CI->excel->getActiveSheet()->getColumnDimension('F')->setWidth('40');
    
    $styleArrayTitle = array(
      'font' => array(
            'name'      => 'Arial',
            'size'        => 10,
            'bold'      => true,
            'italic'    => false,
            'underline' => false,
            'strike'    => false,
            'color'     => array(
                    'rgb' => 'FF0000'
            )
      ),
      'borders' => array(
            'left' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'right' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
               'color' => array(
                            'rgb' => '000000'
                    ),
            ),
            'vertical' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'bottom' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'top' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
      ),
      'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
              'argb' => 'FFFFFFCC',
            ),
      ),
      'alignment' => array(
            'wrap'    => true,
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
    );
    $styleArray = array(
      'font' => array(
            'name'      => 'Arial',
            'size'        => 10,
            'bold'      => false,
            'italic'    => false,
            'underline' => false,
            'strike'    => false,
            'color'     => array(
                    'rgb' => '000000'
            )
      ),
      'borders' => array(
            'left' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'right' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
               'color' => array(
                            'rgb' => '000000'
                    ),
            ),
            'vertical' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'bottom' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'top' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
      ),

      'alignment' => array(
            'wrap'    => true,
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
    );

    $styleArrayTotal = array(
      'font' => array(
            'name'      => 'Arial',
            'size'        => 10,
            'bold'      => true,
            'italic'    => false,
            'underline' => false,
            'strike'    => false,
            'color'     => array(
                    'rgb' => 'FF0000'
            )
      ),
      'borders' => array(
            'left' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'right' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
               'color' => array(
                            'rgb' => '000000'
                    ),
            ),
            'vertical' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'bottom' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'top' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
      ),
      'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
              'argb' => 'CCCCCCCC',
            ),
      ),
      'alignment' => array(
            'wrap'    => true,
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
    );

    $row = 3;
    $this->CI->excel->getActiveSheet()->getStyle($arrCol[0].'3:'.$arrCol[count($arrTitle)-1].$row)->applyFromArray($styleArrayTitle);


    
    foreach($params as $key => $val){
        $l = 4 + $key;
        foreach($arrField as $k => $v){
            $this->CI->excel->getActiveSheet()->setCellValueByColumnAndRow($k,4 + $key,$val[$v]);
            $this->CI->excel->getActiveSheet()->getStyle($arrCol[$k].$l.':'.$arrCol[count($arrField)-1].$l)->applyFromArray($styleArray);
        }
    }
    
    $filename= $title.'.xls'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->CI->excel, 'Excel5');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');

}

	
public function getResponse() {
	return $this->_response;
}

}