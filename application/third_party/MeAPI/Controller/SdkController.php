<?php
class MeAPI_Controller_SdkController{
	 public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('SdkModel');
		$this->CI->load->MeAPI_Model('MestoreVersionModel');
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
        $this->CI->template->write_view('content', 'sdk/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$this->CI->load->library('form_validation');
        $this->data['title'] = 'Quản lý SDK Version';
        $this->data['slbUser'] = $this->CI->SdkModel->listUser();
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
            'cbo_platform' => $this->CI->Session->get_session('cbo_platform')
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
                'cbo_platform' => $arrParam['cbo_platform'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->SdkModel->listItem($arrFilter);
		
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
		
 
        $this->CI->template->write_view('content', 'sdk/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm SDK';
		if($this->CI->input->post()){
			
			$arrControl=array(
				"versions"=>$this->CI->input->post('txt_sdk_version'),
				"platform"=>$this->CI->input->post('cbo_platform'),
				"datecreates"=>date('y-m-d H:i:s'),
				"status"=>$this->CI->input->post('status'),
				"notes"=>$this->CI->input->post('notes'),
				"userid"=>$_SESSION['account']['id']				
			);
			$rs=$this->CI->SdkModel->saveItem($arrControl);	
			if($rs){
				$this->data['errors']="Tạo mới thành công";
			}else{
				$this->data['errors']="Không thực hiện được";
			}
		}
		
        $this->CI->template->write_view('content', 'sdk/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật SDK';
		if(isset($_GET['act']) && $_GET['act']=="action"){
			$arrControl=array(
					"versions"=>$this->CI->input->post('txt_sdk_version'),
					"platform"=>$this->CI->input->post('cbo_platform'),
					"status"=>$this->CI->input->post('status'),
					"notes"=>$this->CI->input->post('notes'),
					"userid"=>$_SESSION['account']['id']
				);
			$rs=$this->CI->SdkModel->updateItem($arrControl,intval($_GET['id']));
			if($rs){
				$this->data['errors']="Cập nhật thành công";
				redirect($this->_mainAction);
			}else{
				$this->data['errors']="Không thực hiện được";
			}
			
		}
        $this->CI->template->write_view('content', 'sdk/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	 public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->SdkModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->SdkModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
	public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->SdkModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->SdkModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
	 public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('cbo_platform', $arrParam['cbo_platform']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('colm', $_GET['colm']);
        }
    }
	
	public function getResponse() {
        return $this->_response;
    }
	
}
?>