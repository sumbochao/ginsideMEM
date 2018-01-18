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
	
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->MeAPI_Library('Network');
        $this->CI->load->MeAPI_Model('SignHistoryAppModel');
        $this->CI->load->MeAPI_Validate('SignHistoryAppValidate');
		$this->CI->load->MeAPI_Model('PartnerModel');
		$this->CI->load->MeAPI_Model('CertificateModel');
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
       
        $per_page = 1000;
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
					'messg'=>"Network is not working (88/124) ..! Please contact to MrViet :))"
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
    public function add(MeAPI_RequestInterface $request){
		ini_set('max_execution_time', 3600);
		ini_set('set_time_limit', 3600);
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
                $id = $this->CI->SignHistoryAppModel->saveItem($data,array('task'=>'add'));
                
                $getItem = $this->CI->SignHistoryAppModel->getItem($id);
				$partner=explode("|",$_POST['cbo_partner']);
				
                $getConfigApp = $this->CI->SignHistoryAppModel->getValueBundleID(array('id_game'=>$getItem['id_game'],'cert_id'=>$getItem['cert_id'],'idpartner'=>$partner[0]));
				$getConfigAppPlus = $this->CI->SignHistoryAppModel->getValueBundleID(array('id_game'=>$getItem['id_game'],'cert_id'=>2,'idpartner'=>$partner[0]));
                $getGame = $this->CI->SignHistoryAppModel->getGame($getItem['id_game']);
                $getApp = $this->CI->SignHistoryAppModel->getApp($getItem['cert_id']);
				/* Tung add code */
				$file_ipa = 'files/'.$getItem['ipa_file'];//tobe uploaded
				$file_provision = 'files/'.$getConfigApp['provision'];//tobe uploaded
				$file_entitlements = 'files/'.$getConfigApp['entitlements'];//tobe uploaded
				$remote_file = "signios/upload/export/uploaded/";// files at ftp path
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
				
				 if (!ftp_put($conn_id, $remote_file.$getItem['ipa_file'], $file_ipa, FTP_BINARY)) {
					echo "There was a problem while uploading ipa $file_ipa\n";
					exit;
				 }
				 
				if (!ftp_put($conn_id, $remote_file.$getConfigApp['provision'], $file_provision, FTP_BINARY)) {
					echo "There was a problem while uploading provision $file_provision\n";
					exit;
				 }
				 
				
				if (!ftp_put($conn_id, $remote_file.$getConfigApp['entitlements'], $file_entitlements, FTP_BINARY)) {
					echo "There was a problem while uploading provision $file_entitlements\n";
					exit;
				 }
				 if($partner[0]==1){
					 // chỉ có partner là MeCorp , khi chọn sign là AppstoreDev => sign thêm bản Appstore
					 if($getItem['cert_id']==1){
						 //2
						 //Plus
						 if (!ftp_put($conn_id, $remote_file.$getConfigAppPlus['provision'], $file_provision_plus, FTP_BINARY)) {
							echo "There was a problem while uploading provision $file_provision\n";
							exit;
						 }
						 if (!ftp_put($conn_id, $remote_file.$getConfigAppPlus['entitlements'], $file_entitlements_plus, FTP_BINARY)) 					 {
							echo "There was a problem while uploading provision $file_provision\n";
							exit;
						 }
					 }//end if
				 } //end if
				 // close the connection
				 ftp_close($conn_id);
				/* end tung */
				if($this->CI->input->post('cbo_sdk')!="0"){
					$sdk=explode("|",$this->CI->input->post('cbo_sdk'));
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
						"newfile"=>$getGame['app_name'].'_'.str_replace(" ", "_",$getApp['cert_type']).'_'.$sdk[1].'_'.gmdate('d_m_Y_G_i_s',time()+7*3600),
					);
				}else{
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
						"newfile"=>$getGame['app_name'].'_'.str_replace(" ", "_",$getApp['cert_type']).'_'.gmdate('d_m_Y_G_i_s',time()+7*3600),
					);
				}
             
                if(!empty($getConfigApp['provision']) && !empty($getConfigApp['entitlements']) && !empty($getItem['ipa_file'])){
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
                    curl_setopt($ch, CURLOPT_URL, 'http://'.MeAPI_Controller_SignhistoryappController::$web_server.':'.$this->web_port.'/signios/upload/export/process_file.php' );

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                    $reponse = curl_exec($ch);
                    $arrReponse = json_decode($reponse,true);
                    curl_close($ch);
                    if($arrReponse['error']==0){
                        $arrParam = array(
                            'log_file_path'=>$arrReponse['link_debug'],
                            'signed_file_path'=>$arrReponse['link_download'],
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
						//update channel
						$ipa_arr=explode("/",$arrReponse['link_download']);
						$pos=count($ipa_arr)-1; //lay vi tri cuoi cung
						$name_ipa_sign=$ipa_arr[$pos];//lay phan tu cuoi cung vi tri $pos
						$arrParamUpdate = array(
                                'id'=>$getItem['id'],
                                'version'=>$arrReponse['version'],
								'ipa_name_sign'=>$name_ipa_sign
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
									if($this->AutoSignAppstore()){
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
	/* Ham tu dong sign ban Appstore*/
	public function AutoSignAppstore(){
		ini_set('max_execution_time', 3600);
		ini_set('set_time_limit', 3600);
		$isok=true;
				$data = $this->CI->SignHistoryAppValidate->getDatai();
				
                $id = $this->CI->SignHistoryAppModel->saveItemi($data,array('task'=>'add'));
                
                $getItem = $this->CI->SignHistoryAppModel->getItem($id);
				$partner=explode("|",$_POST['cbo_partner']);
                $getConfigApp = $this->CI->SignHistoryAppModel->getValueBundleID(array('id_game'=>$getItem['id_game'],'cert_id'=>2,'idpartner'=>$partner[0]));
                $getGame = $this->CI->SignHistoryAppModel->getGame($getItem['id_game']);
                $getApp = $this->CI->SignHistoryAppModel->getApp($getItem['cert_id']);
				if($this->CI->input->post('cbo_sdk')!="0"){
					$sdk=explode("|",$this->CI->input->post('cbo_sdk'));
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
						"newfile"=>$getGame['app_name'].'_'.str_replace(" ", "_",$getApp['cert_type']).'_'.$sdk[1].'_'.gmdate('d_m_Y_G_i_s',time()+7*3600),
					);
				}else{
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
						"newfile"=>$getGame['app_name'].'_'.str_replace(" ", "_",$getApp['cert_type']).'_'.gmdate('d_m_Y_G_i_s',time()+7*3600),
					);
				}
				if(!empty($getConfigApp['provision']) && !empty($getConfigApp['entitlements']) && !empty($getItem['ipa_file'])){
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
                    curl_setopt($ch, CURLOPT_URL, 'http://'.MeAPI_Controller_SignhistoryappController::$web_server.':'.$this->web_port.'/signios/upload/export/process_file.php' );

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                    $reponse = curl_exec($ch);
                    $arrReponse = json_decode($reponse,true);
                    curl_close($ch);
                    if($arrReponse['error']==0){
                        $arrParam = array(
                            'log_file_path'=>$arrReponse['link_debug'],
                            'signed_file_path'=>$arrReponse['link_download'],
                            'id'=>$getItem['id'],
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
								'ipa_name_sign'=>$name_ipa_sign
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
            $data['slbMsv'] = $this->CI->SignHistoryAppModel->listMsv($_GET['service_id'],$_GET['type_app']);
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
		
        echo json_encode($f);
        exit();
    }
    public function showvalue(){
        if($_GET['cert_id']>0 && $_GET['id_game']>0 && $_GET['idpartner']>0){
            $showValue = $this->CI->SignHistoryAppModel->getValueBundleID(array("cert_id"=>$_GET['cert_id'],"id_game"=>$_GET['id_game'],"idpartner"=>$_GET['idpartner']));
			$showValuei = $this->CI->SignHistoryAppModel->getValueBundleID(array("cert_id"=>2,"id_game"=>$_GET['id_game'],"idpartner"=>$_GET['idpartner']));
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
	
    public function getResponse() {
        return $this->_response;
    }
}
