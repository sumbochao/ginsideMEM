<?php
class MeAPI_Controller_LibsdkController{
	 public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->MeAPI_Library('Libcommon');
        $this->CI->load->MeAPI_Model('LibsdkModel');
		$this->CI->load->MeAPI_Model('MestoreVersionModel');
		$this->CI->load->MeAPI_Model('ProjectsModel');
		$this->CI->load->MeAPI_Model('SdkModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($session['id_group']!=1){
			$this->_mainAction = base_url().'?control='.$_GET['control'].'&func=noaccess';
		}
		$this->data['loadplatform']=$this->CI->MestoreVersionModel->listPlatform();
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index';
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'libsdk/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$this->CI->load->library('form_validation');
        $this->data['title'] = 'Quản lý LIB SDK VERSION';
        $this->data['slbUser'] = $this->CI->LibsdkModel->listUser();
		$this->data['slbGame'] = $this->CI->LibsdkModel->listGame();
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
			'game_code' => $this->CI->Session->get_session('cbo_game'),
            'cbo_platform' => $this->CI->Session->get_session('cbo_platform')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
             $arrParam = $this->CI->security->xss_clean(array_merge($_POST,$_GET));
            $arrFilter = array(
                'colm' => "order",
                'order' => "ASC",
                'keyword' => $arrParam['keyword'],
				'game_code' => $arrParam['cbo_game'],
                'cbo_platform' => $arrParam['cbo_platform'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->LibsdkModel->listItem($arrFilter);
		
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
		
		$this->data['viewitem']=$dataItemView;
		
 
        $this->CI->template->write_view('content', 'libsdk/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Tạo LIB SDK';
		$this->data['slbGame'] = $this->CI->LibsdkModel->listGame();
		$arrParam = $this->CI->security->xss_clean($_POST);
		
		if($this->CI->input->post()){
			$game=explode("|",$arrParam['cbo_game']);
			$arrControl=array(
				"game_code"=>$game[1],
				"game_name"=>$arrParam['game_name'],
				"platform"=>$arrParam['cbo_platform'],
				"sdkversion"=>$arrParam['sdkversion'],
				"client_version"=>$arrParam['client_version'],
				"client_build"=>$arrParam['client_build'],
				"story_stype"=>$arrParam['cbo_story_stype'],
				"package_type"=>$arrParam['cbo_package_type'],
				"package_name"=>$arrParam['cbo_package_name'],
				"version_code"=>"",
				"msv"=>$arrParam['cbo_msv'],
				"min_sdk_version"=>$arrParam['min_sdk_version'],
				"target_sdk_version"=>$arrParam['target_sdk_version'],
				"file_name"=>$arrParam['file_name'],
				"datecreate"=>date('y-m-d H:i:s'),
				"userlog"=>$_SESSION['account']['id'],
				"status"=>0,
				"notes"=>$arrParam['notes']		
			);
			if($arrParam['cbo_platform']=="android"){
				$arrControl["version_code"]=$arrParam['version_code'];
			}
			$rs=$this->CI->LibsdkModel->saveItem($arrControl);	
			
			if($rs){
				$this->data['errors']="<strong style='color:#090'>Tạo mới thành công</strong>";
			}else{
				$this->data['errors']="SDK Version đã tồn tại";
			}
		}
		
        $this->CI->template->write_view('content', 'libsdk/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['slbGame'] = $this->CI->LibsdkModel->listGame();
		$arrParam = $this->CI->security->xss_clean($_POST);
        $this->data['title'] = 'Cập nhật LIB SDK';
		
		if(isset($_GET['act']) && $_GET['act']=="action"){
			$game=explode("|",$arrParam['cbo_game']);
			$arrControl=array(
				"game_code"=>$game[1],
				"game_name"=>$arrParam['game_name'],
				"platform"=>$arrParam['cbo_platform'],
				"sdkversion"=>$arrParam['sdkversion'],
				"client_version"=>$arrParam['client_version'],
				"client_build"=>$arrParam['client_build'],
				"story_stype"=>$arrParam['cbo_story_stype'],
				"package_type"=>$arrParam['cbo_package_type'],
				"package_name"=>$arrParam['cbo_package_name'],
				"version_code"=>"",
				"msv"=>$arrParam['cbo_msv'],
				"min_sdk_version"=>$arrParam['min_sdk_version'],
				"target_sdk_version"=>$arrParam['target_sdk_version'],
				"file_name"=>$arrParam['file_name'],
				"datecreate"=>date('y-m-d H:i:s'),
				"userlog"=>$_SESSION['account']['id'],
				"notes"=>$arrParam['notes']		
			);
			$rs=$this->CI->LibsdkModel->updateItem($arrControl,intval($_GET['id']));
			if($rs){
				$this->data['errors']="<strong style='color:#090'>Cập nhật thành công</strong>";
				//redirect($this->_mainAction);
			}else{
				$this->data['errors']="Trùng thông tin đã có.";
			}
			
		}
		$this->data['itemview'] = $this->CI->LibsdkModel->getItem(intval($_GET['id']));
        $this->CI->template->write_view('content', 'libsdk/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function copyedit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['slbGame'] = $this->CI->LibsdkModel->listGame();
		$arrParam = $this->CI->security->xss_clean($_POST);
        $this->data['title'] = 'Tạo LIB SDK';
		
		if($this->CI->input->post()){
			$game=explode("|",$arrParam['cbo_game']);
			$arrControl=array(
				"game_code"=>$game[1],
				"game_name"=>$arrParam['game_name'],
				"platform"=>$arrParam['cbo_platform'],
				"sdkversion"=>$arrParam['sdkversion'],
				"client_version"=>$arrParam['client_version'],
				"client_build"=>$arrParam['client_build'],
				"story_stype"=>$arrParam['cbo_story_stype'],
				"package_type"=>$arrParam['cbo_package_type'],
				"package_name"=>$arrParam['cbo_package_name'],
				"version_code"=>"",
				"msv"=>$arrParam['cbo_msv'],
				"min_sdk_version"=>$arrParam['min_sdk_version'],
				"target_sdk_version"=>$arrParam['target_sdk_version'],
				"file_name"=>$arrParam['file_name'],
				"datecreate"=>date('y-m-d H:i:s'),
				"userlog"=>$_SESSION['account']['id'],
				"status"=>0,
				"notes"=>$arrParam['notes']		
			);
			if($arrParam['cbo_platform']=="android"){
				$arrControl["version_code"]=$arrParam['version_code'];
			}
			$rs=$this->CI->LibsdkModel->saveItem($arrControl);	
			
			if($rs){
				$this->data['errors']="<strong style='color:#090'>Tạo mới thành công</strong>";
			}else{
				//redirect("?control=libsdk&func=copyedit&id=".intval($_GET['id']));
				$this->data['errors']="SDK Version đã tồn tại";
			}
		}
		
		$this->data['itemview'] = $this->CI->LibsdkModel->getItem(intval($_GET['id']));
        $this->CI->template->write_view('content', 'libsdk/copy', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	 public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->LibsdkModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->LibsdkModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
	public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->LibsdkModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->LibsdkModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
	 public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
			$this->CI->Session->unset_session('cbo_game', $arrParam['cbo_game']);
            $this->CI->Session->unset_session('cbo_platform', $arrParam['cbo_platform']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('colm', $_GET['colm']);
        }
    }
	public function getbundle(){
		$arrParam = $this->CI->security->xss_clean($_GET);
        if(isset($arrParam['id_game'])){
			$arrFilter = array(
                'id_game' =>$arrParam['id_game'],
				'platform' => $arrParam['platform'],
				'cert_name' => $arrParam['cert_name'],
				'service'=>$arrParam['service']
            );
            $data['list'] = $this->CI->LibsdkModel->GetBundleProjects($arrFilter);
			$data['itemview'] = $this->CI->LibsdkModel->getItem(intval($arrParam['id_edit']));
			if(count($data['list'])>=0){
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công',
					'html'=>$this->CI->load->view('libsdk/cbo_bunlderid', $data, true)
				);
			}else{
				$f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('libsdk/cbo_bunlderid', $data, true)
            	);
			}
        }else{
            $data['list'] = array();
			$data['itemview']=array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('libsdk/cbo_bunlderid', $data, true)
            );
        }
       echo json_encode($f);
        exit();
    }
	public function getsdk(){
		$arrParam = $this->CI->security->xss_clean($_GET);
        if(isset($arrParam['platform'])){
			$arrFilter = array(
				'cbo_platform' => $arrParam['platform']
            );
            $data['list'] = $this->CI->SdkModel->listItem($arrFilter);
			if(count($data['list'])>=0){
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công',
					'html'=>$this->CI->load->view('libsdk/cbo_sdk', $data, true)
				);
			}else{
				$f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('libsdk/cbo_sdk', $data, true)
            	);
			}
        }else{
            $data['list'] = array();
			
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('libsdk/cbo_sdk', $data, true)
            );
        }
       echo json_encode($f);
        exit();
    }
	public function showmsv(){
		$arrParam = $this->CI->security->xss_clean($_GET);
        if(isset($arrParam['service_id'])){
			$arrFilter = array(
				'platform' => $arrParam['platform'],
				'service_id' => $arrParam['service_id'],
				'type_app' => $arrParam['type_app'],
				'bunlde_name' => $arrParam['bunlde_name']
            );
            $data['slbMsv'] = $this->CI->LibsdkModel->listMsvforLibsdk($arrFilter);
			$data['itemview'] = $this->CI->LibsdkModel->getItem(intval($arrParam['id_edit']));
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('libsdk/showmsv', $data, true)
            );
        }else{
            $data['slbMsv'] = array();
			$data['itemview']=array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('libsdk/showmsv', $data, true)
            );
        }
        echo json_encode($f);
        exit();
    }
	public function exportexcel(){
		$arrParam = $this->CI->security->xss_clean($_GET);
		if(isset($arrParam['type']) && $arrParam['type']=="one"){
			if(isset($arrParam['idrows'])){
				$arrFilter = array(
					'id' => $arrParam['idrows']
				);
				$dataexp = $this->CI->LibsdkModel->getItem(intval($arrFilter['id']));
				$data['filesname'] = $this->CI->Libcommon->ExportExcel($dataexp,base_url()."files/excel/");
			
			}
		}else{ 
			//export nhiều dòng
			$arrParam = array_merge($_POST,$_GET);
			$arrData = array();
			$arrParamPlus=explode(',',$arrParam['idrows']);
			if(count($arrParamPlus)>0){
				for($i=0 ; $i <count($arrParamPlus) ; $i++){
					 $dataexp = $this->CI->LibsdkModel->getItem(intval($arrParamPlus[$i]));
					 $arrData[$i]=$dataexp;
				}
            }
			$data['filesname'] = $this->CI->Libcommon->ExportExcelAll($arrData,base_url()."files/excel/");
			
		}
		$this->CI->template->write_view('content', 'libsdk/exportexcel', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
		/*echo json_encode($f);
		exit();*/
    }
	public function getResponse() {
        return $this->_response;
    }
	
}
?>