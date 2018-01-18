<?php
class MeAPI_Controller_SignconfigappController implements MeAPI_Controller_SignconfigappInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('SignConfigAppModel');
        $this->CI->load->MeAPI_Validate('SignConfigAppValidate');
		$this->CI->load->MeAPI_Model('PartnerModel');
		$this->CI->load->MeAPI_Model('CertificateModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
		if($session['id_group']!=1){
			$this->_mainAction = base_url().'?control='.$_GET['control'].'&func=noaccess';
		}
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'signconfigapp/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Danh sách cấu hình ứng dụng';
        
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
       
        $per_page = 30;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->SignConfigAppModel->listItem($arrFilter);
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
        
        $this->data['slbGame'] = $this->CI->SignConfigAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignConfigAppModel->listTableApp();
		$this->data['slbPartner'] = $this->CI->PartnerModel->listPartner();
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
 		$this->data['partner'] = $this->CI->PartnerModel->listItem();
        $this->CI->template->write_view('content', 'signconfigapp/index', $this->data);
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
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sửa cấu hình ứng dụng';
        $this->data['items'] = $this->CI->SignConfigAppModel->getItem((int)$_GET['id']);
        $this->data['slbGame'] = $this->CI->SignConfigAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignConfigAppModel->listTableApp();
		$this->data['loadplatform']=$this->CI->SignConfigAppModel->listPlatform();
        $POST = $this->CI->input->post();
        if ($POST){
            $POST['id'] = $_GET['id'];
            $this->CI->SignConfigAppValidate->validateForm($POST,$_FILES);
            if($this->CI->SignConfigAppValidate->isVaild()){
                $errors = $this->CI->SignConfigAppValidate->getMessageErrors();
                $items = $this->CI->SignConfigAppValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->SignConfigAppValidate->getData();
                $data['id'] = $_GET['id'];
                $this->CI->SignConfigAppModel->saveItem($data,array('task'=>'edit'));
                if($_GET['type']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$_GET['id']);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
		$cbo_part=explode("|",$this->data['items']['idpartner']);
		$arrFilter = array(
                'idpartner' => $cbo_part[0]
            );
        $this->data['cert_type'] = $this->CI->CertificateModel->listItem($arrFilter);
		$this->data['partner'] = $this->CI->PartnerModel->listItem();
        $this->data['slbParents'] = $slbParents;
        $this->CI->template->write_view('content', 'signconfigapp/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm cấu hình ứng dụng';
        $this->data['slbGame'] = $this->CI->SignConfigAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignConfigAppModel->listTableApp();
		$this->data['loadplatform']=$this->CI->SignConfigAppModel->listPlatform();
        if ($this->CI->input->post()){
            $this->CI->SignConfigAppValidate->validateForm($this->CI->input->post(),$_FILES);
            if($this->CI->SignConfigAppValidate->isVaild()){
                $errors = $this->CI->SignConfigAppValidate->getMessageErrors();
                $items = $this->CI->SignConfigAppValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->SignConfigAppValidate->getData();
                
                $id = $this->CI->SignConfigAppModel->saveItem($data,array('task'=>'add'));
                $data['id'] = $id;
                $this->CI->SignConfigAppModel->updateOrder($data);
                if($_GET['type']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.$id);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
		$this->data['partner'] = $this->CI->PartnerModel->listItem();
        $this->data['slbParents'] = $slbParents;
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'signconfigapp/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function sort(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if ($this->CI->input->post()){
            $this->CI->SignConfigAppModel->sortItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->SignConfigAppModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->SignConfigAppModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->SignConfigAppModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->SignConfigAppModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function remove_provision(){
        $this->CI->SignConfigAppModel->removeFile($_GET);
        @unlink(FILE_PATH . '/'.$_GET['file']);
        die();
    }
    public function remove_entitlements(){
        $this->CI->SignConfigAppModel->removeEntitlements($_GET);
        @unlink(FILE_PATH . '/'.$_GET['file']);
        die();
    }
    public function download(){
        $url = FILE_URL.'/'.$_GET['file'];
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        die();
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
                'html'=>$this->CI->load->view('signconfigapp/cbo_cert', $data, true)
            );
        }else{
            $data['package'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('signconfigapp/cbo_cert', $data, true)
            );
        }
		
        echo json_encode($f);
        exit();
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
            $data['list'] = $this->CI->SignConfigAppModel->GetBundleProjects($arrFilter);
			$data['items'] = $this->CI->SignConfigAppModel->getItem((int)$_GET['id']);
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('signconfigapp/cbo_bunlderid', $data, true)
            );
        }else{
            $data['list'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('signconfigapp/cbo_bunlderid', $data, true)
            );
        }
		/*$this->CI->template->write_view('content', 'mestoreversion/cbo_bunlderid', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/
       echo json_encode($f);
        exit();
    }
	/* kiểm tra trùng thông tin */
	public function checkisexitconfigapp(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p)){
			$reults = $this->CI->SignConfigAppModel->checkisexitconfigapp($arr_p);
		}
		if($reults == true){
			$f = array(
				'error'=>'0',
				'messg'=>'Đã tồn tại'
			);
		}else{
			$f = array(
				'error'=>'1',
				'messg'=>'Chưa tồn tại'
			);
		}
        echo json_encode($f);
        exit();
	}
    public function getResponse() {
        return $this->_response;
    }
}
