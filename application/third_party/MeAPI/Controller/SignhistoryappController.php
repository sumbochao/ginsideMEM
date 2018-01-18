<?php
class MeAPI_Controller_SignhistoryappController implements MeAPI_Controller_SignhistoryappInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
	
	//ftp info
	protected static $ftp_server="115.78.161.88"; //10.8.36.180 ,115.78.161.124/134/88 , port web : 21112
	protected $ftp_server2="115.78.161.124";
	
	protected static $web_server="115.78.161.88";
	protected $web_server2="115.78.161.124";
	
	protected $ftp_user_name="deploy";
	protected $ftp_user_pass="Deploy123@@@";
	
	protected $ftp_port="21111";
	protected $web_port="21112";
	
	//path sign ios
	protected $path_sign_ios="signios/upload/export";
	protected $path_sign_ios_file_exe="/signios/upload/export/process_file.php";
	
	//path sign ios plus , đây là phiên bản nâng cấp
	protected $path_sign_ios_plus="signios/me/";
	protected $path_sign_ios_file_exe_plus="signios/me/process_file_plus.php";
	
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->MeAPI_Library('Network');
		//$this->CI->load->MeAPI_Library('ActiveResource');
		$this->CI->load->MeAPI_Library('RedmineAPI');
        $this->CI->load->MeAPI_Model('SignHistoryAppModel');
        $this->CI->load->MeAPI_Validate('SignHistoryAppValidate');
		$this->CI->load->MeAPI_Validate('SignHistoryAppValidatePlus');
		$this->CI->load->MeAPI_Model('PartnerModel');
		$this->CI->load->MeAPI_Model('CertificateModel');
		$this->CI->load->MeAPI_Model('SignConfigAppModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index';
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$this->CI->load->library('form_validation');
        $this->data['title'] = 'Sign IPA file';
		
        
        $this->filter();
        $getcolm = $this->CI->Session->get_session('colm');
        if (empty($getcolm)) {
            $this->CI->Session->set_session('colm', 'order');
            $this->CI->Session->set_session('order', 'ASC');
        }
        $arrFilter = array(
            'colm' => $this->CI->Session->get_session('colm'),
            'order' => $this->CI->Session->get_session('order'),
            'keyword' => $this->CI->Session->get_session('keyword'),
            'id_game' => $this->CI->Session->get_session('id_game'),
            'cert_id' => $this->CI->Session->get_session('cert_id')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'colm' => "order",
                'order' => "ASC",
                'keyword' => $arrParam['keyword'],
                'id_game' => $arrParam['id_game'],
                'cert_id' => $arrParam['cert_id'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->SignHistoryAppModel->listItem($arrFilter);
		if(isset($_GET['type']) && $_GET['type']=="success"){
			//tung
			$dataItemView['rs'] = $this->CI->SignHistoryAppModel->getItem(intval($_GET['id']));
			//end tung
		}
		
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
        
        $this->data['slbGame'] = $this->CI->SignHistoryAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignHistoryAppModel->listTableApp();
        $this->data['slbUser'] = $this->CI->SignHistoryAppModel->listUser();
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
		
		$this->data['viewitem']=$dataItemView;
		$this->data['partner'] = $this->CI->PartnerModel->listPartner();
 
        $this->CI->template->write_view('content', 'signhistoryapp/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('id_game', $arrParam['id_game']);
            $this->CI->Session->unset_session('cert_id', $arrParam['cert_id']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('colm', $_GET['colm']);
        }
    }
	public function checknetwork(){
		//default 115.78.161.88
		$net_def=$this->CI->Network->statusnetwork(MeAPI_Controller_SignhistoryappController::$web_server,$this->web_port);
		
		if($net_def){
			$f = array(
                'error'=>'0',
                'messg'=>"Network 88 is ok"
            );
		}else{
			//set 115.78.161.124
			$net_sec=$this->CI->Network->statusnetwork($this->web_server2,$this->web_port);
			if($net_sec){
				MeAPI_Controller_SignhistoryappController::$ftp_server=$this->ftp_server2;
				MeAPI_Controller_SignhistoryappController::$web_server=$this->web_server2;
				$f = array(
                'error'=>'0',
                'messg'=>"Network 124 is ok"
            	);
			}else{
				$f = array(
					'error'=>'1',
					'messg'=>"Network is not working (88/124) ..! Please try again"
				);
			}
		}
		echo json_encode($f);
        exit();
	}
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật thông tin IPA file';
        $this->data['items'] = $this->CI->SignHistoryAppModel->getItem((int)$_GET['id']);
        $this->data['slbGame'] = $this->CI->SignHistoryAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignHistoryAppModel->listTableApp();
        $POST = $this->CI->input->post();
        if ($POST){
            $POST['id'] = $_GET['id'];
            $this->CI->SignHistoryAppValidate->validateForm($POST,$_FILES);
            if($this->CI->SignHistoryAppValidate->isVaild()){
                $errors = $this->CI->SignHistoryAppValidate->getMessageErrors();
                $items = $this->CI->SignHistoryAppValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->SignHistoryAppValidate->getData();
                $data['id'] = $_GET['id'];
                $this->CI->SignHistoryAppModel->saveItem($data,array('task'=>'edit'));
                if($_GET['type']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$_GET['id']);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->data['slbParents'] = $slbParents;
        $this->CI->template->write_view('content', 'signhistoryapp/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function GetFolderName(){
		$service=explode('|',$_POST['id_game']);
		$fn = $this->CI->SignConfigAppModel->GetFolderInProjects($service[2]);
		return $fn==""?"NONAME".$service[2]:$fn;
	}
	public function IsLibV3($c){
		$service=explode('|',$_POST['id_game']);
		$cername=$_POST['cert_name_text'];
		$packegename=$_POST['cbo_bunlderid'];
		$arrP=array(
				'service'=>$service[2]=="monggiangho"?"mgh":$service[2],
				'platform'=>"ios",
				'package_name'=>$packegename
			);
		if($c==0){
			//Bản AppstoreDev
			$arrP['cert_name']=$cername;
		}else{
			//Bản Appstore
			$arrP['cert_name']="Appstore";
		}
		$getConfigGoogleApp = $this->CI->SignConfigAppModel->GetGoogleInfoProjects($arrP);
		
		$app_id=trim($getConfigGoogleApp['app_id']);
		$client_id_google=trim($getConfigGoogleApp['client_key']);
		$url_scheme_google=trim($getConfigGoogleApp['url_scheme']);
		$facebook_appid=trim($getConfigGoogleApp['fb_appid']);
		return $value=$client_id_google."|".$url_scheme_google."|".$app_id."|".$facebook_appid;
	}
	public function setTimeLimitServer(){
		ini_set('max_execution_time', 3600);
		ini_set('set_time_limit', 3600);
	}
    public function add(MeAPI_RequestInterface $request){
		$this->setTimeLimitServer();
		//set_time_limit(3600);
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm thông tin IPA file';
        $this->data['slbGame'] = $this->CI->SignHistoryAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignHistoryAppModel->listTableApp();
		$this->data['slbSdk'] = $this->CI->SignHistoryAppModel->listSdk();
		$this->data['partner'] = $this->CI->PartnerModel->listItem();
        if ($this->CI->input->post()){
			
            $this->CI->SignHistoryAppValidate->validateForm($this->CI->input->post(),$_FILES);
            if($this->CI->SignHistoryAppValidate->isVaild()){
                $errors = $this->CI->SignHistoryAppValidate->getMessageErrors();
                $items = $this->CI->SignHistoryAppValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
				MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),$errors,$items), "{$params['control']}_{$params['func']}_" . date('H'));
            }else{
                $data = $this->CI->SignHistoryAppValidate->getData();
				//nếu sign vối Lib V3
				if(isset($_POST['cbo_libv3']) && $_POST['cbo_libv3']=="ok"){
					switch($_POST['cert_name_text']){
						case "AppstoreDev":$env=1;break;
						case "Appstore":$env=2;break;
						case "Inhouse":$env=3;break;
						default:$env=0;break;
					}
					//
					$pr=explode("|",$this->IsLibV3(0));
					$client_id_google=$pr[0];
					$url_scheme_google=$pr[1];
					$app_id=$pr[2];
					$facebook_app_id=$pr[3];
					if($client_id_google=="" || $url_scheme_google=="" || $app_id=="" || $facebook_app_id==""){
						$info_mess= "Thông tin Google Client ID hoặc URL Scheme,App ID,Facebook AppID chưa khai báo";
						$errors = $this->CI->SignHistoryAppValidate->getMessageErrors();
						$errors['google_err']=$info_mess;
						$items = $this->CI->SignHistoryAppValidate->getData();
						$this->data['errors'] = $errors;
						$this->data['items'] = $items;
						$this->CI->template->write_view('content', 'signhistoryapp/add', $this->data);
						$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
						 //redirect($this->_mainAction.'&type=unsuccess&info='.base64_encode($info_mess));
						 return;
					}
					$isv3="on";
				}else{
					$env=0;
					$client_id_google="0";
					$url_scheme_google="0";
					$app_id="0";
					$facebook_app_id="0";
					$isv3="off";
				}
				
                $id = $this->CI->SignHistoryAppModel->saveItem($data,array('task'=>'add'));
                
                $getItem = $this->CI->SignHistoryAppModel->getItem($id);
				$partner=explode("|",$_POST['cbo_partner']);
				$bundleid = trim($getItem['bundleidentifier']);
                $getConfigApp = $this->CI->SignHistoryAppModel->getValueBundleID(array('id_game'=>$getItem['id_game'],'cert_id'=>$getItem['cert_id'],'idpartner'=>$partner[0],'bundleid'=>$bundleid));
				$getConfigAppPlus = $this->CI->SignHistoryAppModel->getValueBundleID(array('id_game'=>$getItem['id_game'],'cert_id'=>2,'idpartner'=>$partner[0],'bundleid'=>$bundleid));
                $getGame = $this->CI->SignHistoryAppModel->getGame($getItem['id_game']);
                $getApp = $this->CI->SignHistoryAppModel->getApp($getItem['cert_id']);
				/* Tung add code */
				$file_ipa = 'files/'.$getItem['ipa_file'];//tobe uploaded
				$file_provision = 'files/'.$getConfigApp['provision'];//tobe uploaded
				$file_entitlements = 'files/'.$getConfigApp['entitlements'];//tobe uploaded
				
				$remote_file_plist_pro = $this->path_sign_ios."/uploaded/";// files at ftp path
				$remote_file_client = $this->path_sign_ios."/uploaded/";// files at ftp path
				
				//2
				$file_provision_plus = 'files/'.$getConfigAppPlus['provision'];//tobe uploaded
				$file_entitlements_plus = 'files/'.$getConfigAppPlus['entitlements'];//tobe uploaded
				
				if($getConfigApp['provision']=="" || $getConfigApp['entitlements']==""){
					echo "File provision or entilement is not exist. Please check agiant";
					exit;
				}
				 // set up basic connection  
				 $conn_id = ftp_connect(MeAPI_Controller_SignhistoryappController::$ftp_server,$this->ftp_port) or die ("Cannot connect to host");
				 
				 // login with username and password
				 $login_result = ftp_login($conn_id, $this->ftp_user_name, $this->ftp_user_pass) or die("Cannot login");
				 // upload a file
				
				 if (!ftp_put($conn_id, $remote_file_client.$getItem['ipa_file'], $file_ipa, FTP_BINARY)) {
					echo "There was a problem while uploading ipa $file_ipa\n";
					exit;
				 }
				 
				if (!ftp_put($conn_id, $remote_file_plist_pro.$getConfigApp['provision'], $file_provision, FTP_BINARY)) {
					echo "There was a problem while uploading provision $file_provision\n";
					exit;
				 }
				 
				
				if (!ftp_put($conn_id, $remote_file_plist_pro.$getConfigApp['entitlements'], $file_entitlements, FTP_BINARY)) {
					echo "There was a problem while uploading provision $file_entitlements\n";
					exit;
				 }
				 if($partner[0]==1){
					 // chỉ có partner là MeCorp , khi chọn sign là AppstoreDev => sign thêm bản Appstore
					 if($getItem['cert_id']==1){
						 //2
						 //Plus
						 if (!ftp_put($conn_id, $remote_file_plist_pro.$getConfigAppPlus['provision'], $file_provision_plus, FTP_BINARY)) {
							echo "There was a problem while uploading provision $file_provision\n";
							exit;
						 }
						 if (!ftp_put($conn_id, $remote_file_plist_pro.$getConfigAppPlus['entitlements'], $file_entitlements_plus, FTP_BINARY)) 					 {
							echo "There was a problem while uploading provision $file_provision\n";
							exit;
						 }
					 }//end if
				 }//end if partner
				 
				 // close the connection
				 ftp_close($conn_id);
				/* end tung */
				if($this->CI->input->post('cbo_sdk')!="0"){
					$sdk=explode("|",$this->CI->input->post('cbo_sdk'));
					$newfiles=$getGame['app_name'].'_'.str_replace(" ", "_",$getApp['cert_type']).'_'.$sdk[1].'_'.gmdate('d_m_Y_G_i_s',time()+7*3600);
				}else{
					$newfiles=$getGame['app_name'].'_'.str_replace(" ", "_",$getApp['cert_type']).'_'.gmdate('d_m_Y_G_i_s',time()+7*3600);
					
				}
				
				// update 07/01/2016 LSApplicationQueriesSchemes
				$KeyQueriesSchemes="";
				$plist=$this->CI->SignHistoryAppModel->getKeyQueriesSchemes();
				foreach($plist as $pl){
					$KeyQueriesSchemes=$KeyQueriesSchemes.$pl['notes'].";";
				}
				
             	$post_array = array(
						"file1"=>trim($getItem['ipa_file']),
						"file2"=>trim($getConfigApp['provision']),
						"file3"=>trim($getConfigApp['entitlements']),
						"cert"=>trim($getApp['cert_name']),
						"b"=>trim($getItem['bundleidentifier']),
						"c"=>trim($getItem["channel"]),
						"n"=>trim($getItem["version"]),
						"v"=>trim($getItem["bundle_version"]),
						"u"=>trim($getItem["url_scheme"]),
						"m"=>trim($getItem["minimum_os_version"]),
						"newfile"=>$newfiles,
						"env"=>$env,
						"client_id_google"=>$client_id_google,
						"url_scheme_google"=>$url_scheme_google,
						"app_id"=>$app_id,
						"facebook_app_id"=>$facebook_app_id,
						"key_queries_schemes"=>$KeyQueriesSchemes,
						"folder"=>$this->GetFolderName()
					);
                if(!empty($getConfigApp['provision']) && !empty($getConfigApp['entitlements']) && !empty($getItem['ipa_file'])){
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
                    curl_setopt($ch, CURLOPT_URL, 'http://'.MeAPI_Controller_SignhistoryappController::$web_server.':'.$this->web_port.$this->path_sign_ios_file_exe );

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                    $reponse = curl_exec($ch);
                    $arrReponse = json_decode($reponse,true);
                    curl_close($ch);
                    if($arrReponse['error']==0){
                        $arrParam = array(
                            'log_file_path'=>$arrReponse['link_debug'],
                            'signed_file_path'=>$arrReponse['link_download'],
                            'id'=>$getItem['id'],
							'libv3'=>$isv3
                        );
                        $this->CI->SignHistoryAppModel->saveItem($arrParam,array('task'=>'updatelink'));
                        if(empty($getItem["version"]) && empty($getItem["bundle_version"])){
                            $arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
                                'bundle_version'=>$arrReponse['bundleVersion']
                            );
                            $this->CI->SignHistoryAppModel->saveItem($arrParamUpdate,array('task'=>'updateversion'));
                        }
						//update channel
						$ipa_arr=explode("/",$arrReponse['link_download']);
						$pos=count($ipa_arr)-1; //lay vi tri cuoi cung
						$name_ipa_sign=$ipa_arr[$pos];//lay phan tu cuoi cung vi tri $pos
						$arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
								'ipa_name_sign'=>$name_ipa_sign,
								'path_folder_sign'=>$arrReponse['pathfolder']
                            );
                            $this->CI->SignHistoryAppModel->saveItem($arrParamUpdate,array('task'=>'updatechannel'));
						
						/*
						 Tung add code ghi log
						*/
						$this->CI->SignHistoryAppModel->savelog($arrReponse['logdata'],$getItem['id']);
						/* End Tung*/
						
						/* 
							Nếu sign là Appstore dev thi tu động sign bản Appstore 
							Bắt đầu Sign Appstore sau khi Sign Appstore dev thành công
						 */
						 //MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),$name_ipa_sign,"user_id:".$_SESSION['account']['id']), "{$params['control']}_{$params['func']}_" . date('H'));
					   if($partner[0]==1){
						 // chỉ có partner là MeCorp với id=1, khi chọn sign là AppstoreDev => sign thêm bản Appstore
						 // gọi hàm sign lần 2 , bản Appstore
							if($getItem['cert_id']==1){
								if($this->AutoSignAppstore(trim($getItem['bundleidentifier']))){
									redirect($this->_mainAction.'&type=success&id='.$getItem['id']);
								}else{
									redirect($this->_mainAction.'&type=unsuccess');
								}
							}else{
								redirect($this->_mainAction.'&type=success&id='.$getItem['id']);
							}//end if
					   }else{
						   redirect($this->_mainAction.'&type=success&id='.$getItem['id']);
					   }
                    }else{
                        $arrParam = array(
                            'log_file_path'=>$arrReponse['link_debug'],
                            'signed_file_path'=>'',
                            'id'=>$getItem['id'],
                        );
                        $this->CI->SignHistoryAppModel->saveItem($arrParam,array('task'=>'updatelink'));
                        if(empty($getItem["version"]) && empty($getItem["bundle_version"])){
                            $arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
                                'bundle_version'=>$arrReponse['bundleVersion']
                            );
                            $this->CI->SignHistoryAppModel->saveItem($arrParamUpdate,array('task'=>'updateversion'));
                        }
						//save log
						$this->CI->SignHistoryAppModel->savelog($arrReponse['logdata'],$getItem['id']);
						MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),"Error Sign","user_id:".$_SESSION['account']['id']), "{$params['control']}_{$params['func']}_" . date('H'));
                        redirect($this->_mainAction.'&type=unsuccess');
                    }
                }
                
            }
        }
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'signhistoryapp/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	/* 
		Ham tu dong sign ban Appstore 
		Nâng cấp 06/11/2015 , thêm đối số bundleid , vì 1 bản có nhiều hơn 1 bundleid
	
	*/
	public function AutoSignAppstore($bundleid){
		$this->setTimeLimitServer();
		$isok=true;
				$data = $this->CI->SignHistoryAppValidate->getDatai();
				//neu sign ban lib V3
				if(isset($_POST['cbo_libv3']) && $_POST['cbo_libv3']=="ok"){
					$env=2; //Appstore
					
					$pr=explode("|",$this->IsLibV3(1));
					$client_id_google=$pr[0];
					$url_scheme_google=$pr[1];
					$app_id=$pr[2];
					$facebook_app_id=$pr[3];
					if($client_id_google=="" || $url_scheme_google=="" || $app_id=="" || $facebook_app_id==""){
						 return $isok=false;
					}
					$isv3="on";
				}else{
					$env=0;
					$client_id_google="0";
					$url_scheme_google="0";
					$app_id="0";
					$facebook_app_id="0";
					$isv3="off";
				}
				
                $id = $this->CI->SignHistoryAppModel->saveItemi($data,array('task'=>'add'));
                
                $getItem = $this->CI->SignHistoryAppModel->getItem($id);
				$partner=explode("|",$_POST['cbo_partner']);
                $getConfigApp = $this->CI->SignHistoryAppModel->getValueBundleID(array('id_game'=>$getItem['id_game'],'cert_id'=>2,'idpartner'=>$partner[0],'bundleid'=>$bundleid));
                $getGame = $this->CI->SignHistoryAppModel->getGame($getItem['id_game']);
                $getApp = $this->CI->SignHistoryAppModel->getApp($getItem['cert_id']);
				
				
				if($this->CI->input->post('cbo_sdk')!="0"){
					$sdk=explode("|",$this->CI->input->post('cbo_sdk'));
					$newfile=$getGame['app_name'].'_'.str_replace(" ", "_",$getApp['cert_type']).'_'.$sdk[1].'_'.gmdate('d_m_Y_G_i_s',time()+7*3600);
				}else{
					$newfile=$getGame['app_name'].'_'.str_replace(" ", "_",$getApp['cert_type']).'_'.gmdate('d_m_Y_G_i_s',time()+7*3600);
					
				}
				
				// update 07/01/2016 LSApplicationQueriesSchemes
				$KeyQueriesSchemes="";
				$plist=$this->CI->SignHistoryAppModel->getKeyQueriesSchemes();
				foreach($plist as $pl){
					$KeyQueriesSchemes=$KeyQueriesSchemes.$pl['notes'].";";
				}
				
				$post_array = array(
						"file1"=>trim($getItem['ipa_file']),
						"file2"=>trim($getConfigApp['provision']),
						"file3"=>trim($getConfigApp['entitlements']),
						"cert"=>trim($getApp['cert_name']),
						//"b"=>trim($getItem['bundleidentifier']),
						"b"=>$bundleid,
						"c"=>trim($getItem["channel"]),
						"n"=>trim($getItem["version"]),
						"v"=>trim($getItem["bundle_version"]),
						"u"=>trim($getItem["url_scheme"]),
						"m"=>trim($getItem["minimum_os_version"]),
						"newfile"=>$newfile,
						"env"=>$env,
						"client_id_google"=>$client_id_google,
						"url_scheme_google"=>$url_scheme_google,
						"app_id"=>$app_id,
						"facebook_app_id"=>$facebook_app_id,
						"key_queries_schemes"=>$KeyQueriesSchemes,
						"folder"=>$this->GetFolderName()
					);
				if(!empty($getConfigApp['provision']) && !empty($getConfigApp['entitlements']) && !empty($getItem['ipa_file'])){
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
                    curl_setopt($ch, CURLOPT_URL, 'http://'.MeAPI_Controller_SignhistoryappController::$web_server.':'.$this->web_port.$this->path_sign_ios_file_exe );

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                    $reponse = curl_exec($ch);
                    $arrReponse = json_decode($reponse,true);
                    curl_close($ch);
                    if($arrReponse['error']==0){
                        $arrParam = array(
                            'log_file_path'=>$arrReponse['link_debug'],
                            'signed_file_path'=>$arrReponse['link_download'],
                            'id'=>$getItem['id'],
							'libv3'=>$isv3
                        );
                        $this->CI->SignHistoryAppModel->saveItemi($arrParam,array('task'=>'updatelink'));
                        if(empty($getItem["version"]) && empty($getItem["bundle_version"])){
                            $arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
                                'bundle_version'=>$arrReponse['bundleVersion']
                            );
                            $this->CI->SignHistoryAppModel->saveItemi($arrParamUpdate,array('task'=>'updateversion'));
                        }
						//update channel
						$ipa_arr=explode("/",$arrReponse['link_download']);
						$pos=count($ipa_arr)-1; //lay vi tri cuoi cung
						$name_ipa_sign=$ipa_arr[$pos];//lay phan tu cuoi cung vi tri $pos
						$arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
								'ipa_name_sign'=>$name_ipa_sign,
								'path_folder_sign'=>$arrReponse['pathfolder']
                            );
                            $this->CI->SignHistoryAppModel->saveItemi($arrParamUpdate,array('task'=>'updatechannel'));
						
						/*
						 Tung add code ghi log
						*/
						$this->CI->SignHistoryAppModel->savelog($arrReponse['logdata'],$getItem['id']);
						/* End Tung*/
						
						/* 
							Nếu sign là Appstore dev thi tu động sign bản Appstore 
							Bắt đầu Sign Appstore sau khi Sign Appstore dev thành công
						 */
						
                        //redirect($this->_mainAction.'&type=success&id='.$getItem['id']);
						$isok=true;
                    }else{
                        $arrParam = array(
                            'log_file_path'=>$arrReponse['link_debug'],
                            'signed_file_path'=>'',
                            'id'=>$getItem['id'],
							'libv3'=>$isv3
                        );
                        $this->CI->SignHistoryAppModel->saveItemi($arrParam,array('task'=>'updatelink'));
                        if(empty($getItem["version"]) && empty($getItem["bundle_version"])){
                            $arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
                                'bundle_version'=>$arrReponse['bundleVersion']
                            );
                            $this->CI->SignHistoryAppModel->saveItemi($arrParamUpdate,array('task'=>'updateversion'));
                        }
						//save log
						$this->CI->SignHistoryAppModel->savelog($arrReponse['logdata'],$getItem['id']);
                        //redirect($this->_mainAction.'&type=unsuccess');
						$isok=false;
                    }//end if
				}//end if
				
		return $isok;
	}
    public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->SignHistoryAppModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->SignHistoryAppModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->SignHistoryAppModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->SignHistoryAppModel->deleteItem($arrParam);
        }
		MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),$arrParam,"deleted","Userid:".$_SESSION['account']['id']), "{$params['control']}_{$params['func']}_" . date('H'));
        redirect($this->_mainAction);
    }
	public function updatenotes(){
		 if($_GET['_id_ipa']>0){
            $result = $this->CI->SignHistoryAppModel->updatenotes($_GET['_id_ipa'],$_GET['_val_notes']);
			if($result){
				$mess="Cập nhật thành công";
			}else{
				$mess="Cập nhật thất bại";
			}
            $f = array(
                'error'=>'0',
                'messg'=>$mess
            );
        }else{
            $data['slbTable'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
        }
        echo json_encode($f);
        exit();
	}
	public function updatepublished(){
		 if($_GET['_id_ipa']>0){
            $result = $this->CI->SignHistoryAppModel->updatepublished($_GET['_msv_id'],$_GET['_id_ipa'],$_GET['_val_publish']);
			if($result){
				$mess="Cập nhật thành công";
			}else{
				$mess="Cập nhật thất bại";
			}
            $f = array(
                'error'=>'0',
                'messg'=>$mess
            );
        }else{
            $data['slbTable'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
        }
        echo json_encode($f);
        exit();
	}
    public function showapp(){
        if($_GET['id_game']>0){
            $data['slbTable'] = $this->CI->SignHistoryAppModel->listTableApp();
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('signhistoryapp/showapp', $data, true)
            );
        }else{
            $data['slbTable'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('signhistoryapp/showapp', $data, true)
            );
        }
        echo json_encode($f);
        exit();
    }
	public function showmsv(){
        if(isset($_GET['service_id'])){
            $data['slbMsv'] = $this->CI->SignHistoryAppModel->listMsvPlus($_GET['service_id'],$_GET['type_app'],$_GET['bunlde_name'],$_GET['cert_id']);
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('signhistoryapp/showmsv', $data, true)
            );
        }else{
            $data['slbMsv'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('signhistoryapp/showmsv', $data, true)
            );
        }
		/*$this->CI->template->write_view('content', 'signhistoryapp/showmsv', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/
        echo json_encode($f);
        exit();
    }
    public function showvalue(){
        if($_GET['cert_id']>0 && $_GET['id_game']>0 && $_GET['idpartner']>0){
            $showValue = $this->CI->SignHistoryAppModel->getValueBundleID(array("cert_id"=>$_GET['cert_id'],"id_game"=>$_GET['id_game'],"idpartner"=>$_GET['idpartner']));
			
			if($_GET['idpartner']==1){
				//nếu Holder là Mecorp
				$showValuei = $this->CI->SignHistoryAppModel->getValueBundleID(array("cert_id"=>2,"id_game"=>$_GET['id_game'],"idpartner"=>$_GET['idpartner']));
			}else{
				//nếu Holder không là Mecorp
				$showValuei=array();
				$showValuei['bundleidentifier']="";
			}
            $f = array(
				'bundleidentifier_hide'=>$showValuei['bundleidentifier'],
                'bundleidentifier'=>$showValue['bundleidentifier'],
                'error'=>'0',
                'messg'=>'Thành công',
            );
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
            );
        }
        echo json_encode($f);
        exit();
    }
    public function export(){
        if((int)$_GET['id']>0 && (int)$_GET['id_game']>0 && (int)$_GET['id_app']>0){
            $getConfigApp = $this->CI->SignHistoryAppModel->getValueBundleID($_GET);
            $getItem = $this->CI->SignHistoryAppModel->getItem($_GET['id']);
            $getGame = $this->CI->SignHistoryAppModel->getGame($getItem['id_game']);
            $getApp = $this->CI->SignHistoryAppModel->getApp($getItem['cert_id']);
            $post_array = array(
                "file1"=>new CURLFile(FILE_PATH.'/'.$getItem['certificate']),
                "file2"=>new CURLFile(FILE_PATH.'/'.$getConfigApp['provision']),
                "file3"=>new CURLFile(FILE_PATH.'/'.$getConfigApp['entitlements']),
                "cert"=>trim($getApp['keyapp']),
                "b"=>trim($getItem['bundleidentifier']),
                "c"=>trim($getItem["channel"]),
                "n"=>trim($getItem["version"]),
                "v"=>trim($getItem["bundle_version"]),
                "u"=>trim($getItem["url_scheme"]),
                "m"=>trim($getItem["minimum_os_version"]),
                "newfile"=>str_replace(" ", "_", $getGame['app_fullname']).'_'.str_replace(" ", "_",$getApp['name']).'_'.gmdate('d_m_Y_G_i_s',time()+7*3600)
            );
            if(!empty($getConfigApp['provision']) && !empty($getConfigApp['entitlements']) && !empty($getItem['certificate'])){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
                curl_setopt($ch, CURLOPT_URL, 'http://10.8.36.180/signios/upload/export/process_file.php' );

                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                $reponse = curl_exec($ch);
                $arrReponse = json_decode($reponse,true);
                
                if($arrReponse['error']==0){
                    $arrParam = array(
                        'link_debug'=>$arrReponse['link_debug'],
                        'link_download'=>$arrReponse['link_download'],
                        'id_history_app'=>$getItem['id'],
                        'id_game'=>$getItem['id_game'],
                        'cert_id'=>$getItem['cert_id'],
                    );
                    $this->CI->SignHistoryFileModel->saveItem($arrParam);
                    if(empty($getItem["version"]) && empty($getItem["bundle_version"])){
                        $arrParamUpdate = array(
                            'id'=>$getItem['id'],
                            'version'=>$arrReponse['version'],
                            'bundle_version'=>$arrReponse['bundleVersion']
                        );
                        $this->CI->SignHistoryAppModel->saveItem($arrParamUpdate,array('task'=>'updateversion'));
                    }
                    $f = array(
                        'error'=>'0',
                        'messg'=>'Thành công'
                    );
                }else{
                    $f = array(
                        'error'=>'1',
                        'messg'=>'Tải file thất bại'
                    );
                }
            }else{
                $f = array(
                    'error'=>'1',
                    'messg'=>'Dữ liệu chưa đầy đủ'
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
	
	public function getcert(){
        if(isset($_GET['idPartner'])){
			$arrFilter = array(
                'idpartner' => $_GET['idPartner']
            );
            $data['cert_type'] = $this->CI->CertificateModel->listItem($arrFilter);
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('signhistoryapp/cbo_cert', $data, true)
            );
        }else{
            $data['package'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('signhistoryapp/cbo_cert', $data, true)
            );
        }
		
        echo json_encode($f);
        exit();
    }
	public function getbunlderid(){
        if(isset($_GET['id_game'])){
			$arrFilter = array(
                'id_game' =>$_GET['id_game'],
				'platform' => $_GET['platform'],
				'cert_id' => $_GET['cert_id']
            );
            $data['list'] = $this->CI->SignConfigAppModel->listItemForMsv($arrFilter);
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('signhistoryapp/cbo_bunlderid', $data, true)
            );
        }else{
            $data['list'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('signhistoryapp/cbo_bunlderid', $data, true)
            );
        }
		/*$this->CI->template->write_view('content', 'mestoreversion/cbo_bunlderid', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/
       echo json_encode($f);
        exit();
    }
	
	//update 08/01/2016
	public function popupsign(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật Info.plist';
		$this->CI->load->library('form_validation');
		$arr_p=$this->CI->security->xss_clean($_GET);
		$this->data['slbUser'] = $this->CI->SignHistoryAppModel->listUser();
		$listData = $this->CI->SignHistoryAppModel->listInfoPlist();
		$this->data['listItems'] = $listData;
		$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'signhistoryapp/popup_sign', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function addkeysplist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
        if(isset($arr_p['val'])){
			$arrFilter = array(
                'notes' =>$arr_p['val'],
				'datecreate' =>date('Y-m-d H:i:s'),
				'userlog' => $_SESSION['account']['id']
            );
			$bool=$this->CI->SignHistoryAppModel->checkexitskeyvalues($arr_p['val']);
			if(count($bool)>0){
				$f = array(
					'error'=>'-1',
					'messg'=>'Trùng data'
				);
			}else{
				$id = $this->CI->SignHistoryAppModel->addkeyvalues($arrFilter);
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công'
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
	public function deletekeyplist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
        if(isset($arr_p['id'])){
			$bool=$this->CI->SignHistoryAppModel->deletedkeyvalues($arr_p['id']);
			$f = array(
					'error'=>'0',
					'messg'=>'Thành công'
				);
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
        }
       echo json_encode($f);
       exit();
    }
	
	//update 15/01/2016
	//ham sign ban v3 ,nhan 2 param 1: cert_name , 2: bunlde
	public function IsLibV3new($cername,$packegename){
		$service=explode('|',$_POST['id_game']);
		//$cername=$_POST['cert_name_text'];
		//$packegename=$_POST['cbo_bunlderid'];
		$arrP=array(
				'service'=>$service[2]=="monggiangho"?"mgh":$service[2],
				'platform'=>"ios",
				'cert_name'=>$cername,
				'package_name'=>$packegename
			);
		$getConfigGoogleApp = $this->CI->SignConfigAppModel->GetGoogleInfoProjects($arrP);
		
		$app_id=trim($getConfigGoogleApp['app_id']);
		$client_id_google=trim($getConfigGoogleApp['client_key']);
		$url_scheme_google=trim($getConfigGoogleApp['url_scheme']);
		$facebook_appid=trim($getConfigGoogleApp['fb_appid']);
		return $value=$client_id_google."|".$url_scheme_google."|".$app_id."|".$facebook_appid;
	}
	//hàm dùng đẩy file .ipa,.provision,.entitlements lên máy MAX OS
	//$remote_provision_entitlements là đường dẫn upfile .provision,.entitlements lên máy MAC OS
	//$remote_ipa là đường dẫn upfile .ipa lên máy MAC OS
	public function FtpFileToMacOX($file_ipa,$file_provision,$file_entitlements,$remote_provision_entitlements,$remote_ipa){
		try{
				 $path="files/";
			 	 // set up basic connection  
				 $conn_id = ftp_connect(MeAPI_Controller_SignhistoryappController::$ftp_server,$this->ftp_port) or die ("Cannot connect to host");
				 
				 // login with username and password
				 $login_result = ftp_login($conn_id, $this->ftp_user_name, $this->ftp_user_pass) or die("Cannot login");
				 // upload a file
				
				 if (!ftp_put($conn_id, $remote_ipa.$file_ipa, $path.$file_ipa, FTP_BINARY)) {
					echo "There was a problem while uploading ipa $file_ipa\n";
					exit;
				 }
				 
				if (!ftp_put($conn_id, $remote_provision_entitlements.$file_provision, $path.$file_provision, FTP_BINARY)) {
					echo "There was a problem while uploading provision $file_provision\n";
					exit;
				 }
				 
				
				if (!ftp_put($conn_id, $remote_provision_entitlements.$file_entitlements, $path.$file_entitlements, FTP_BINARY)) {
					echo "There was a problem while uploading provision $file_entitlements\n";
					exit;
				 }
				 // close the connection
				 ftp_close($conn_id);
				 
		}catch(Exception $e){
			echo 'Caught exception: '.$e->getMessage()."\n";
			exit();
		}
	} //end ftpfile
	
	//Hàm đẩy các tham số sang máy MAC , gọi đến file process_file.php
	// hàm trả về json khi process_file.php thực thi xong
	public function CurlOtpPost($file_ipa,$file_provision,$file_entitlements,$cert_name,$bundleidentifier,$channel,$version,$bundle_version,$url_scheme,$minimum_os_version,$newfiles,$env,$client_id_google,$url_scheme_google,$app_id,$facebook_app_id,$sub_folder,$hour){
		try{
				// update 07/01/2016 LSApplicationQueriesSchemes
				$KeyQueriesSchemes="";
				$plist=$this->CI->SignHistoryAppModel->getKeyQueriesSchemes();
				foreach($plist as $pl){
					$KeyQueriesSchemes=$KeyQueriesSchemes.$pl['notes'].";";
				}
				
             	$post_array = array(
						"file1"=>trim($file_ipa),
						"file2"=>trim($file_provision),
						"file3"=>trim($file_entitlements),
						"cert"=>trim($cert_name),
						"b"=>trim($bundleidentifier),
						"c"=>trim($channel),
						"n"=>trim($version),
						"v"=>trim($bundle_version),
						"u"=>trim($url_scheme),
						"m"=>trim($minimum_os_version),
						"newfile"=>$newfiles,
						"env"=>$env,
						"client_id_google"=>$client_id_google,
						"url_scheme_google"=>$url_scheme_google,
						"app_id"=>$app_id,
						"facebook_app_id"=>$facebook_app_id,
						"key_queries_schemes"=>$KeyQueriesSchemes,
						"folder"=>$this->GetFolderName(),
						"subfolder"=>$sub_folder,
						"hour"=>$hour
					);
                	
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
                    curl_setopt($ch, CURLOPT_URL, 'http://'.MeAPI_Controller_SignhistoryappController::$web_server.':'.$this->web_port."/".$this->path_sign_ios_file_exe_plus );

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                    $reponse = curl_exec($ch);
                    $arrReponse = json_decode($reponse,true);
                    curl_close($ch);
					return $arrReponse;
					
		}catch(Exception $e)
		{
			echo 'Caught exception: '.$e->getMessage()."\n";
			exit();
		}
		
	}//end CurlOtpPost
	
	//hàm cập nhật thông tin sau khi Sign vào CSDL
	//tham số gồm 1 Array $arrReponse, 1 Array $getItem
	// hàm trả về success hay unsuccess
	public function UpdateDataBase($arrReponse,$getItem,$isv3){
		try{
				
				if($arrReponse['error']==0){
                        $arrParam = array(
                            'log_file_path'=>$arrReponse['link_debug'],
                            'signed_file_path'=>$arrReponse['link_download'],
                            'id'=>$getItem['id'],
							'libv3'=>$isv3
                        );
                        $this->CI->SignHistoryAppModel->saveItem($arrParam,array('task'=>'updatelink'));
                        if(empty($getItem["version"]) && empty($getItem["bundle_version"])){
                            $arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
                                'bundle_version'=>$arrReponse['bundleVersion']
                            );
                            $this->CI->SignHistoryAppModel->saveItem($arrParamUpdate,array('task'=>'updateversion'));
                        }
						//update channel
						$ipa_arr=explode("/",$arrReponse['link_download']);
						$pos=count($ipa_arr)-1; //lay vi tri cuoi cung
						$name_ipa_sign=$ipa_arr[$pos];//lay phan tu cuoi cung vi tri $pos
						$arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
								'ipa_name_sign'=>$name_ipa_sign,
								'path_folder_sign'=>$arrReponse['pathfolder'],
								'current_sdk'=>$arrReponse['sdk_version_cur']
                            );
                            $this->CI->SignHistoryAppModel->saveItem($arrParamUpdate,array('task'=>'updatechannel'));
						
						/*
						 Tung add code ghi log
						*/
						$this->CI->SignHistoryAppModel->savelog($arrReponse['logdata'],$getItem['id']);
						/* End Tung*/
					   return 'success';
					    //redirect($this->_mainAction.'&type=success&id='.$getItem['id']);
                    }else{
                        $arrParam = array(
                            'log_file_path'=>$arrReponse['link_debug'],
                            'signed_file_path'=>'',
                            'id'=>$getItem['id'],
                        );
                        $this->CI->SignHistoryAppModel->saveItem($arrParam,array('task'=>'updatelink'));
                        if(empty($getItem["version"]) && empty($getItem["bundle_version"])){
                            $arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
                                'bundle_version'=>$arrReponse['bundleVersion']
                            );
                            $this->CI->SignHistoryAppModel->saveItem($arrParamUpdate,array('task'=>'updateversion'));
                        }
						//save log
						
						$this->CI->SignHistoryAppModel->savelog($arrReponse['logdata'],$getItem['id']);
						MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),"Error Sign","user_id:".$_SESSION['account']['id']), "{$params['control']}_{$params['func']}_" . date('H'));
						
                        return 'unsuccess';
						//redirect($this->_mainAction.'&type=unsuccess');
                    }//end if
					
		}catch(Exception $e){
			echo 'Caught exception: '.$e->getMessage()."\n";
			return 'unsuccess';
		}
	}//end UpdateDataBase
	
	//hàm thông báo Nếu Thông tin bên Projects không đầy đủ , hoạc thông tin Sign chưa chọn đầy đủ
	public function ViewMessInfo($arr = NULL,$mess,$is){
		if($is==0){
			$info_mess = $mess;
			$errors = $this->CI->SignHistoryAppValidatePlus->getMessageErrors();
			$errors['google_err']=$info_mess;
			$items = $this->CI->SignHistoryAppValidatePlus->getData($arr);
			$this->data['errors'] = $errors;
			$this->data['items'] = $items;
			$this->CI->template->write_view('content', 'signhistoryapp/add', $this->data);
			$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
		}else{
			$errors = $this->CI->SignHistoryAppValidatePlus->getMessageErrors();
			$items = $this->CI->SignHistoryAppValidatePlus->getData($arr);
			$this->data['errors'] = $errors;
			$this->data['items'] = $items;
			MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),$errors,$items), "{$params['control']}_{$params['func']}_" . date('H'));
			
		} //end if
		
	}//end func
	
	//hàm trả về tên file sau khi ghép các thông số liên quan
	public function GetNameFileSignIpa($app_game,$cert_type){
		if($this->CI->input->post('cbo_sdk')!="0"){
			$sdk=explode("|",$this->CI->input->post('cbo_sdk'));
			$newfiles=$app_game.'_'.str_replace(" ", "_",$cert_type).'_'.$sdk[1].'_'.gmdate('d_m_Y_G_i_s',time()+7*3600);
		}else{
			$newfiles=$app_game.'_'.str_replace(" ", "_",$cert_type).'_'.gmdate('d_m_Y_G_i_s',time()+7*3600);
			
		}//end if
		return $newfiles;
	} //end func
	
	// Ham Sign , tham số 1 array Data , tham số đầu vào $in_cert_id,$in_bunlde,$in_msv,$in_channel
	public function SignIOS($data,$in_cert_id,$in_cert_name,$in_bunlde,$in_channel,$hour){
		try{
				switch($in_cert_name){
					case "AppstoreDev":$env=1;break;
					case "Appstore":$env=2;break;
					case "Inhouse":$env=3;break;
					default:$env=0;break;
				}
				//
				$pr=explode("|",$this->IsLibV3new($in_cert_name,$in_bunlde));
				$client_id_google=$pr[0];
				$url_scheme_google=$pr[1];
				$app_id=$pr[2];
				$facebook_app_id=$pr[3];
				if($client_id_google=="" || $url_scheme_google=="" || $app_id=="" || $facebook_app_id==""){
					$mess=$this->ViewMessInfo("Thông tin Google Client ID hoặc URL Scheme,App ID,Facebook AppID chưa khai báo",0);
					 return;
				}
				$isv3="on";
				
                $id = $this->CI->SignHistoryAppModel->saveItem($data,array('task'=>'add'));
                
                $getItem = $this->CI->SignHistoryAppModel->getItem($id);
				$partner=explode("|",$_POST['cbo_partner']);
				$bundleid = trim($getItem['bundleidentifier']);
				
                $getConfigApp = $this->CI->SignHistoryAppModel->getValueBundleID(array('id_game'=>$getItem['id_game'],'cert_id'=>$in_cert_id,'idpartner'=>$partner[0],'bundleid'=>$in_bunlde));
				
				
                $getGame = $this->CI->SignHistoryAppModel->getGame($getItem['id_game']);
				
                $getApp = $this->CI->SignHistoryAppModel->getApp($in_cert_id);
				
				$path_provision_entitlements = $this->path_sign_ios_plus."/uploaded/plist_provisioning/";// files at ftp path
				$path_file_ipa = $this->path_sign_ios_plus."uploaded/";// files ipa at ftp path
				
				
				if($getConfigApp['provision']=="" || $getConfigApp['entitlements']==""){
					echo "File provision or entilement is not exist. Please check agiant";
					exit;
				}
				//gọi hàm ftp file lên máy MAC OS , ftp 3 file ,.ipa .provision .entitlements
				$this->FtpFileToMacOX($getItem['ipa_file'],$getConfigApp['provision'],$getConfigApp['entitlements'],$path_provision_entitlements,$path_file_ipa);
				
				//hàm tạo tên file ipa
				$newfiles=$this->GetNameFileSignIpa($getGame['app_name'],$getApp['cert_type']);
					
                if(!empty($getConfigApp['provision']) && !empty($getConfigApp['entitlements']) && !empty($getItem['ipa_file'])){
					//hàm post thông số qua máy MAC OS goi den file process_file.php
                   $arrReponse=$this->CurlOtpPost($getItem['ipa_file'],$getConfigApp['provision'],$getConfigApp['entitlements'],$getApp['cert_name'],$in_bunlde,$in_channel,$getItem["version"],$getItem["bundle_version"],$getItem["url_scheme"],$getItem["minimum_os_version"],$newfiles,$env,$client_id_google,$url_scheme_google,$app_id,$facebook_app_id,$_POST['cbo_why'],$hour);
				   
				   //sau khi Sign xong cập nhật CSDL
				   $result=$this->UpdateDataBase($arrReponse,$getItem,$isv3);
				   if($result=="success"){
					   $value_data=array(
						"status"=>$result,
						"id"=>$getItem['id'],
						"Message"=>"OK"
						);
				   		
				   }else{
					   $value_data=array(
						"status"=>$result,
						"id"=>0,
						"Message"=>"ERROR"
						);
				   }
				   
                }else{
					 $value_data=array(
						"status"=>'unsuccess',
						"id"=>0,
						"Message"=>"ERROR"
						);
				}//end if
				
		}catch(Exception $e){
			$value_data=array(
						"status"=>'unsuccess',
						"id"=>-1,
						"Message"=>$e->getMessage()
						);
		}//end try
		return json_encode($value_data);
	}// end func
	
	//ham tra ve mang cac tham so
	public function ArrayParam($i,$filename){
		$arr=array(
		  'id_game'=>$_POST['id_game'],
		  'cbo_p5_msv'=>$_POST['txt_msv_id_'.$i],
		  'cbo_sdk'=>$_POST['cbo_sdk'],
		  'cert_id'=>$_POST['txt_cert_id_'.$i],
		  'certificate'=>$filename,
		  'bundleidentifier'=>$_POST['txt_bunlde_'.$i],
		  'channel'=>$_POST['txt_channel_'.$i],
		  'version'=>$_POST['version'],
		  'bundle_version'=>$_POST['bundle_version'],
		  'url_scheme'=>$_POST['txt_bunlde_'.$i],
		  'minimum_os_version'=>$_POST['minimum_os_version'],
		  'notes'=>addslashes($_POST['notes'])
		  );
		  return $arr;
	} //end func
	
	public function RedirectSuccess($param){
		if(count($param)>0){
			$str="";
			for($i=1;$i<=count($param);$i++){
				$str.=$param[$i].",";
			}
			$url=base_url().'?control='.$_GET['control'].'&func=success&id='.$str.'0';
			redirect($url);
		}
	}
	public function success(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Success';
		$this->data['slbUser'] = $this->CI->SignHistoryAppModel->listUser();
		$this->data['slbGame'] = $this->CI->SignHistoryAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignHistoryAppModel->listTableApp();
		
		if(isset($_GET['id'])){
			$str=$_GET['id'];
			$id=explode(",",$str);
			$getItem = $this->CI->SignHistoryAppModel->getItem($id[0]);
			$this->data['listItem'] = $this->CI->SignHistoryAppModel->GetListItem($_GET['id']);
			
		}else{
			$this->data['listItem'] = array();
			$getItem=array();
		}
		
		//Redmine
		$this->data['listProjectRedmine'] = $this->CI->RedmineAPI->get_project_redmine();
		//end
		$path=str_replace("\\","&#47;",$getItem['path_folder_sign']);
		//$path=$getItem['path_folder_sign'];
		$desc=$this->CI->RedmineAPI->SetDescRedmine($path);
		//echo $desc="Dear Coor, QC, All Đã có bản mới tại thư mục: ad01/ME.GAME-RES/ (Ghi chú: Map ổ đĩa Y:/ với đường dẫn mạng ad01/ME.GAME-RES) Nội dung client game: - - Nội dung bug đã fix: - - QC và các team tiến hành test. Nếu tìm thấy Bug, vui lòng báo Bug trong subtask của Task này để dễ monitor. Nội dung test chính: - Đăng ký (Mobo, Facebook...)/Login/Logout Game/Log out SDK/Chuyển tài khoản/Chuyển Server/Kích hoạt tài khoản - Push Notification - Tracking Marketing Code - Thanh toán các kiểu, bao gồm InApp, Mopay, SMS, Banking, - Đứt kết nối, timeout, tắt nguồn, mở app từ background... - Kiểm tra mapping tài khoản Game <> tài khoản Mobo - Play Game - Check policy icloud storage ..... Thanks";
		if($getItem['current_sdk']!=""){
			$arr_sdk=explode("=",$getItem['current_sdk']);
			$sdk_version=$arr_sdk[1];
		}else{
			$sdk_version="";
		}//end if
		$subjects=$this->CI->RedmineAPI->SetSubjectsRedmine($sdk_version,$getItem['bundle_version']);
		//echo $desc."<br/>".$subjects;
		if(isset($_POST['btn_exe'])){
			if($_POST['cbo_projects']!=""){
				$this->data['Issues'] = $this->CI->RedmineAPI->create_new_issues($_POST['cbo_projects'],$subjects,$desc,"60");
				$this->data['Mess']="http://128.199.129.217/issues/".$this->data['Issues'];
			}else{
				$this->data['Mess']="Vui lòng chọn Projects";
			}
		}
		
        $this->CI->template->write_view('content', 'signhistoryapp/success', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }//end func ssuccess
	
	public function addnew(MeAPI_RequestInterface $request){
		$this->setTimeLimitServer();
		//set_time_limit(3600);
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sign IPA file';
        $this->data['slbGame'] = $this->CI->SignHistoryAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignHistoryAppModel->listTableApp();
		$this->data['slbSdk'] = $this->CI->SignHistoryAppModel->listSdk();
		$this->data['partner'] = $this->CI->PartnerModel->listItem();
		
        if(isset($_POST['btn_Sign'])){
			
            $this->CI->SignHistoryAppValidatePlus->validateForm($_FILES);
			$bool=$this->CI->SignHistoryAppValidatePlus->isVaild($_POST['id_game'],$_FILES);
			
            if(!$bool){
			 	  $arr=array(
				  'id_game'=>$_POST['id_game'],
				  'cbo_p5_msv'=>'',
				  'cbo_sdk'=>$_POST['cbo_sdk'],
				  'cert_id'=>'',
				  'certificate'=>$_FILES['ipa_file']['name'],
				  'bundleidentifier'=>'',
				  'channel'=>'',
				  'version'=>$_POST['version'],
				  'bundle_version'=>$_POST['bundle_version'],
				  'url_scheme'=>'',
				  'minimum_os_version'=>$_POST['minimum_os_version'],
				  'notes'=>$_POST['notes']
				  );
               $mess=$this->ViewMessInfo($arr,"Thông tin chưa đầy đủ",1);
            }else{
                //upload file ipa
				$filename=$this->CI->SignHistoryAppValidatePlus->upload();
				$arr_id=array();
				$hour=date('H_m_s'); //hàm lấy giờ
				for($i=1;$i<=3;$i++){
					
					if($_POST['txt_cert_'.$i]!=""){
						$arr=$this->ArrayParam($i,$filename);
						$data = $this->CI->SignHistoryAppValidatePlus->getData($arr);
						$rs=json_decode($this->SignIOS($data,$_POST['txt_cert_id_'.$i],$_POST['txt_cert_'.$i],$_POST['txt_bunlde_'.$i],$_POST['txt_channel_'.$i],$hour));
						$kq=$rs->{'status'};
						$id=$rs->{'id'};
						$cert=$_POST['txt_cert_'.$i];
						if($kq=="unsuccess"){
							break;
						}
						$arr_id[$i]=$id;
					}//end if
				} //end for
				
				if($kq=="success"){
					$this->RedirectSuccess($arr_id);
					return;
				}elseif($kq=="unsuccess"){
					redirect($this->_mainAction.'&type=unsuccess&cert='.$cert);
				}
				
            }//end 
			
        }else{
			 $arr=array(
			  'id_game'=>$_POST['id_game'],
			  'cbo_p5_msv'=>'',
			  'cbo_sdk'=>$_POST['cbo_sdk'],
			  'cert_id'=>'',
			  'certificate'=>$_FILES['ipa_file']['name'],
			  'bundleidentifier'=>'',
			  'channel'=>'',
			  'version'=>$_POST['version'],
			  'bundle_version'=>$_POST['bundle_version'],
			  'url_scheme'=>'',
			  'minimum_os_version'=>$_POST['minimum_os_version'],
			  'notes'=>$_POST['notes']
			  );
			$mess=$this->ViewMessInfo($arr,NULL,1);
		}//end if(isset($_POST['btn_Sign']))
		
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'signhistoryapp/addnew', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	} //end add new
	
	
    public function getResponse() {
        return $this->_response;
    }
}
