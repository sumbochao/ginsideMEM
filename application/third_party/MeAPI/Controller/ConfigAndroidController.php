<?php
class MeAPI_Controller_ConfigAndroidController{
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('ConfigAndroidModel');
		$this->CI->load->MeAPI_Model('PartnerModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
		/*if($session['id_group']!=1){
			$this->_mainAction = base_url().'?control='.$_GET['control'].'&func=noaccess';
		}*/
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'configandroid/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Thông tin Config Android';
        
        $this->filter();
      
        $arrFilter = array(
            'keyword' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'keyword' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->ConfigAndroidModel->listItem($arrFilter);
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=index';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();
		$this->data['partner'] = $this->CI->PartnerModel->listItem();
        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
        
        
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
 		
		$this->data['lblUser'] = $this->CI->ConfigAndroidModel->listUser();
		$this->data['lblPartner'] = $this->CI->PartnerModel->listPartner();
		
        $this->CI->template->write_view('content', 'configandroid/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('colm', $_GET['colm']);
        }
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sửa bảng config';
       
        $get = $this->CI->security->xss_clean($_GET);
		$post = $this->CI->security->xss_clean($_POST);
		$pn=explode("|",$post['cbo_partner']);
        if (isset($get['action']) && $get['action']==1){
  			$arrControl=array(
				"id"=>$get['id'],
				"id_partner"=>$pn[0],
				"keystore"=>$post['keystore'],
				"storepass"=>$post['storepass'],
				"alias"=>$post['alias'],
				"datecreate"=>date('y-m-d H:i:s'),
				"status"=>0,
				"userlog"=>$_SESSION['account']['id']				
			);
			$rs=$this->CI->ConfigAndroidModel->saveItem($arrControl,array("task"=>"edit"));	
			if($rs){
				$this->data['errors']="cập nhật thành công";
				redirect(base_url().'?control='.$_GET['control'].'&func=index');
			}else{
				$this->data['errors']="Không thực hiện được";
			}
        }
		$this->data['items'] = $this->CI->ConfigAndroidModel->getItem((int)$_GET['id']);
		$this->data['partner'] = $this->CI->PartnerModel->listItem();
        $this->CI->template->write_view('content', 'configandroid/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm bảng config';
		$get = $this->CI->security->xss_clean($_GET);
		$post = $this->CI->security->xss_clean($_POST);
		$pn=explode("|",$post['cbo_partner']);
        if (isset($get['action']) && $get['action']==1){
  			$arrControl=array(
				"id_partner"=>$pn[0],
				"keystore"=>$post['keystore'],
				"storepass"=>$post['storepass'],
				"alias"=>$post['alias'],
				"datecreate"=>date('y-m-d H:i:s'),
				"status"=>0,
				"userlog"=>$_SESSION['account']['id']				
			);
			$rs=$this->CI->ConfigAndroidModel->saveItem($arrControl,array("task"=>"add"));	
			if($rs){
				$this->data['errors']="Tạo mới thành công";
				redirect(base_url().'?control='.$_GET['control'].'&func=index');
			}else{
				$this->data['errors']="Không thực hiện được";
			}
        }
		$this->data['partner'] = $this->CI->PartnerModel->listItem();
       
        $this->CI->template->write_view('content', 'configandroid/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function sort(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if ($this->CI->input->post()){
            $this->CI->ConfigAndroidModel->sortItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->ConfigAndroidModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->ConfigAndroidModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->ConfigAndroidModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->ConfigAndroidModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function getResponse() {
        return $this->_response;
    }
}
