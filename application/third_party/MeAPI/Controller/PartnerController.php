<?php
class MeAPI_Controller_PartnerController{
	 public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('PartnerModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($session['id_group']!=1){
			$this->_mainAction = base_url().'?control='.$_GET['control'].'&func=noaccess';
		}
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index';
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'partner/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$this->CI->load->library('form_validation');
        $this->data['title'] = 'Quản lý Partner(Đối tác)';
        $this->data['slbUser'] = $this->CI->PartnerModel->listUser();
        $this->filter();
        $getcolm = $this->CI->Session->get_session('colm');
        if (empty($getcolm)) {
            $this->CI->Session->set_session('colm', 'order');
            $this->CI->Session->set_session('order', 'ASC');
        }
        $arrFilter = array(
            'colm' => $this->CI->Session->get_session('colm'),
            'order' => $this->CI->Session->get_session('order'),
            'keyword' => $this->CI->Session->get_session('keyword')
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
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->PartnerModel->listItem($arrFilter);
		
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
		
 
        $this->CI->template->write_view('content', 'partner/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm Partner (Đối tác)';
		if($this->CI->input->post()){
			
			$arrControl=array(
				"partner"=>$this->CI->input->post('partner'),
				"datecreates"=>date('y-m-d H:i:s'),
				"status"=>0,
				"notes"=>$this->CI->input->post('notes'),
				"link_url"=>$this->CI->input->post('link_url'),
				"userid"=>$_SESSION['account']['id']				
			);
			$rs=$this->CI->PartnerModel->saveItem($arrControl);	
			if($rs){
				$this->data['errors']="Tạo mới thành công";
			}else{
				$this->data['errors']="Không thực hiện được";
			}
		}
		
        $this->CI->template->write_view('content', 'partner/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật Partner';
		if(isset($_GET['act']) && $_GET['act']=="action"){
			$arrControl=array(
					"partner"=>$this->CI->input->post('partner'),
					"status"=>0,
					"notes"=>$this->CI->input->post('notes'),
					"link_url"=>$this->CI->input->post('link_url'),
					"userid"=>$_SESSION['account']['id']			
				);
			$rs=$this->CI->PartnerModel->updateItem($arrControl,intval($_GET['id']));
			if($rs){
				$this->data['errors']="Cập nhật thành công";
				redirect($this->_mainAction);
			}else{
				$this->data['errors']="Không thực hiện được";
			}
			
		}
        $this->CI->template->write_view('content', 'partner/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	 public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->PartnerModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->PartnerModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
	public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->PartnerModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->PartnerModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
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
	
	public function getResponse() {
        return $this->_response;
    }
	
}
?>