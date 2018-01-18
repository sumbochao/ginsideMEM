<?php
class MeAPI_Controller_ModuleController implements MeAPI_Controller_ModuleInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('ModuleModel');
		$this->CI->load->MeAPI_Model('AccountModel');
        $this->CI->load->MeAPI_Validate('ModuleValidate');
        $this->CI->load->helper('cmsselect_helper');
        $this->CI->load->helper('recursive_helper');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Danh sách chức năng';
        $this->CI->template->write_view('content', 'module/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function indexBK(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Danh sách chức năng';
        
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
       
        $per_page = 120;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->ModuleModel->listItem($arrFilter);
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
 
        $this->CI->template->write_view('content', 'module/index', $this->data);
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
        $this->data['title'] = 'Sửa chức năng';
        $items = $this->CI->ModuleModel->getItem((int)$_GET['id']);
        $this->data['items'] = $items;
        $slbParents = $this->CI->ModuleModel->listItem($_GET,array('task'=>'remove-id'));
        
        if ($this->CI->input->post()){
            $this->CI->ModuleValidate->validateForm($this->CI->input->post());
            if($this->CI->ModuleValidate->isVaild()){
                $errors = $this->CI->ModuleValidate->getMessageErrors();
                $items = $this->CI->ModuleValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->ModuleValidate->getData();
                $data['id'] = $_GET['id'];
                $this->CI->ModuleModel->saveItem($data,array('task'=>'edit'));
				if($data['per_game']==0){
                    $listGame = $this->CI->AccountModel->listGamePermission();
                    if(count($listGame)>0){
                        foreach($listGame as $v){
                            $this->CI->ModuleModel->deleteItemGame(array('id_permisssion'=>$_GET['id'],'id_game'=>$v['id']));
                        }
                    }
                }
                if($_GET['type']==1){
					if($_GET['page']>0){
                        $page = '&page='.$_GET['page'];
                    }
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$_GET['id'].$page);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->data['slbParents'] = $slbParents;
        $this->CI->template->write_view('content', 'module/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm chức năng';
        $slbParents = $this->CI->ModuleModel->listItem();
        if ($this->CI->input->post()){
            $this->CI->ModuleValidate->validateForm($this->CI->input->post());
            if($this->CI->ModuleValidate->isVaild()){
                $errors = $this->CI->ModuleValidate->getMessageErrors();
                $items = $this->CI->ModuleValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->ModuleValidate->getData();
                $id = $this->CI->ModuleModel->saveItem($data,array('task'=>'add'));
                $data['id'] = $id;
                $this->CI->ModuleModel->updateOrder($data);
                if($_GET['type']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.$id);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->data['slbParents'] = $slbParents;
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'module/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function sort(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if ($this->CI->input->post()){
            $this->CI->ModuleModel->sortItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->ModuleModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->ModuleModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->ModuleModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->ModuleModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function getResponse() {
        return $this->_response;
    }
}
