<?php
class MeAPI_Controller_SignapkController{
    protected $_response;
    private $CI;
    private $_mainAction;
	private $limit;
	
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
		$this->CI->load->MeAPI_Library('TOTP');
		$this->CI->load->MeAPI_Library('Curl');
		$this->CI->load->MeAPI_Library("Graph_Inside_API");
		$this->CI->load->MeAPI_Library('Network');
		$this->CI->load->MeAPI_Model('SignapkModel');
		$this->CI->load->MeAPI_Model('SignHistoryAppModel');
		$this->CI->load->MeAPI_Validate('SignApkHistoryAppValidate');
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
	
		
		$this->data['loadgame']=$this->CI->SignapkModel->listGame();
		$this->data['loadplatform']=$this->CI->SignapkModel->listPlatform();
		$this->data['loadstatus']=$this->CI->SignapkModel->listStatus();
		$this->data['slbTable'] = $this->CI->SignapkModel->listTableApp();
		
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'signapk/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$this->CI->load->library('form_validation');
        $this->data['title'] = 'Quản lý Sign APK (Android)';
        $this->data['slbUser'] = $this->CI->SignapkModel->listUser();
		$this->filter();
        $getcolm = $this->CI->Session->get_session('colm');
        if (empty($getcolm)) {
            $this->CI->Session->set_session('colm', 'order');
            $this->CI->Session->set_session('order', 'ASC');
        }
		$k=0;
		$arrFilter = array(
				'colm' => $this->CI->Session->get_session('colm'),
				'order' => $this->CI->Session->get_session('order'),
				'games' => $this->CI->Session->get_session('keyword'),
				'id_game' => $this->CI->Session->get_session('cbo_game'),
				'type_app_id' =>$this->CI->Session->get_session('cbo_app')
				);
		if(isset($_GET['type']) && $_GET['type']=="filter"){
			if (isset($_GET['page']) && is_numeric($_GET['page'])) {
				$page = $_GET['page'];
			} else {            
				$arrParam = $this->CI->security->xss_clean($_POST);
				$arrFilter["page"] = 1;
				$page = 1;
			}
			$k=1;
		}else{
			$arrFilter=array();
			$k=0;
		}
        
       
        $per_page = 1000;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->SignapkModel->listItem($arrFilter,$k);
		if(isset($_GET['type']) && $_GET['type']=="success"){
			$dataItemView['rs'] = $this->CI->SignapkModel->getItem(intval($_GET['id']));
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
		
		
        $this->CI->template->write_view('content', 'signapk/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function checknetwork(){
		//default 115.78.161.88
		$net_def=$this->CI->Network->statusnetwork(MeAPI_Controller_SignapkController::$web_server,$this->web_port);
		
		if($net_def){
			$f = array(
                'error'=>'0',
                'messg'=>"Network 88 is ok"
            );
		}else{
			//set 115.78.161.124
			$net_sec=$this->CI->Network->statusnetwork($this->web_server2,$this->web_port);
			if($net_sec){
				MeAPI_Controller_SignapkController::$ftp_server=$this->ftp_server2;
				MeAPI_Controller_SignapkController::$web_server=$this->web_server2;
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
	public function updatenotes(){
		 if($_GET['_id_apk']>0){
            $result = $this->CI->SignapkModel->updatenotes($_GET['_id_apk'],$_GET['_val_notes']);
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
		 if($_GET['_id_apk']>0){
            $result = $this->CI->SignapkModel->updatepublished($_GET['_msv_id'],$_GET['_id_apk'],$_GET['_val_publish']);
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
	public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->SignapkModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->SignapkModel->deleteItem($arrParam);
        }
		MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),$arrParam,"deleted","Userid:".$_SESSION['account']['id']), "{$params['control']}_{$params['func']}_" . date('H'));
        redirect($this->_mainAction);
    }
	public function add(MeAPI_RequestInterface $request){
		ini_set('max_execution_time', 3600);
		ini_set('set_time_limit', 3600);
		//set_time_limit(3600);
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sign APK (Android)';
        $this->data['slbGame'] = $this->CI->SignHistoryAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignHistoryAppModel->listTableApp();
		$this->data['slbSdk'] = $this->CI->SignapkModel->listSdk();
        if ($this->CI->input->post()){
            $this->CI->SignApkHistoryAppValidate->validateForm($this->CI->input->post(),$_FILES);
            if($this->CI->SignApkHistoryAppValidate->isVaild()){
                $errors = $this->CI->SignApkHistoryAppValidate->getMessageErrors();
                $items = $this->CI->SignApkHistoryAppValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
				MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),$errors,$items), "{$params['control']}_{$params['func']}_" . date('H'));
            }else{
                $data = $this->CI->SignApkHistoryAppValidate->getData();
                $id = $this->CI->SignapkModel->saveItem($data,array('task'=>'add'));
				
				$getItem = $this->CI->SignapkModel->getItem($id);
                // up file sang may MAC
				$file_apk = 'files/'.$getItem['filenames_notsign'];//tobe uploaded
				$remote_file = "/signapk/upload/export/upload/";// files at ftp path
				 // set up basic connection  
				 $conn_id = ftp_connect(MeAPI_Controller_SignapkController::$ftp_server,$this->ftp_port) or die ("Cannot connect to host");
				 
				 // login with username and password
				 $login_result = ftp_login($conn_id, $this->ftp_user_name, $this->ftp_user_pass) or die("Cannot login");
				 // upload a apk
				
				 if (!ftp_put($conn_id, $remote_file.$getItem['filenames_notsign'], $file_apk, FTP_BINARY)) {
					echo "There was a problem while uploading apk $file_apk\n";
					exit;
				 }
				 // close the connection
				 ftp_close($conn_id);
				$post_array = array(
					"file_apk"=>trim($getItem['filenames_notsign']),
					"c"=>trim($getItem["channels"])
				);
				
             
                if(!empty($getItem['filenames_notsign'])){
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
                    curl_setopt($ch, CURLOPT_URL, 'http://'.MeAPI_Controller_SignapkController::$web_server.':'.$this->web_port.'/signapk/upload/export/upload/file_uploader_plus.php' );

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                    $reponse = curl_exec($ch);
                    $arrReponse = json_decode($reponse,true);
                    curl_close($ch);
                    if($arrReponse['error']==0){
                        $arrParam = array(
                            'filenames_signed'=>$arrReponse['filenames_signed'],
                            'links_signed'=>$arrReponse['links_signed'],
							'logs'=>$arrReponse['logs'],
							'package_name'=>$arrReponse['package_name'],
							'version_name'=>$arrReponse['version_name'],
							'version_code'=>$arrReponse['version_code'],
                            'id'=>$id,
                        );
						
                        $result=$this->CI->SignapkModel->saveItem($arrParam,array('task'=>'updatelink'));
						//$this->CI->SignapkModel->savelog($arrReponse['logdata'],$getItem['id']);
						if($result==1){
							redirect($this->_mainAction.'&type=success&id='.$getItem['id']);
						}
                    }else{
                         $arrParam = array(
                            'filenames_signed'=>$arrReponse['filenames_signed'],
                            'links_signed'=>$arrReponse['links_signed'],
							'logs'=>$arrReponse['logs'],
							'package_name'=>$arrReponse['package_name'],
							'version_name'=>$arrReponse['version_name'],
							'version_code'=>$arrReponse['version_code'],
                            'id'=>$id,
                        );
                         $result=$this->CI->SignapkModel->saveItem($arrParam,array('task'=>'updatelink'));
                    	if($result==1){
							MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),"Error Sign","user_id:".$_SESSION['account']['id']), "{$params['control']}_{$params['func']}_" . date('H'));
							redirect($this->_mainAction.'&type=unsuccess');
						}
                    } //end if
                }//end if
                
            }
			
        }//end if
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'signapk/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'signapk/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function showmsv(){
        if(isset($_GET['id_game'])){
            $data['slbMsv'] = $this->CI->SignapkModel->listMsv($_GET['id_game'],$_GET['type_app']);
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('signapk/showmsv', $data, true)
            );
        }else{
            $data['slbMsv'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('signapk/showmsv', $data, true)
            );
        }
		
        echo json_encode($f);
        exit();
    }
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
           // $this->CI->Session->unset_session('msv_id', $arrParam['code']);
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('cbo_game', $arrParam['cbo_game']);
			$this->CI->Session->unset_session('cbo_app', $arrParam['cbo_app']);
        }
    }
	 
    public function getResponse() {
        return $this->_response;
    }
}
