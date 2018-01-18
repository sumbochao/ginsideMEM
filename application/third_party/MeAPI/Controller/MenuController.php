<?php
class MeAPI_Controller_MenuController implements MeAPI_Controller_MenuInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('MenuModel');
        $this->CI->load->MeAPI_Validate('MenuValidate');
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
        $this->data['title'] = 'Danh sách menu';
        
        $this->filter();
        $getcolmenu = $this->CI->Session->get_session('colmenu');
        if (empty($getcolmenu)) {
            $this->CI->Session->set_session('colmenu', 'order');
            $this->CI->Session->set_session('order', 'ASC');
        }
        $arrFilter = array(
            'colmenu' => $this->CI->Session->get_session('colmenu'),
            'order' => $this->CI->Session->get_session('order'),
            'keyword' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'colmenu' => "order",
                'order' => "ASC",
                'keyword' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
		$listItems = $this->CI->MenuModel->listItem($arrFilter);
        $total = count($listItems);
		switch ($_SESSION['limitpage']){
            case '1':
                $per_page = 40;
                break;
            case '2':
                $per_page = 80;
                break;
            case '3':
                $per_page = 160;
                break;
            case '4':
                $per_page = 300;
                break;
            case '5':
                $per_page = 500;
                break;
            case '6':
                $per_page = $total;
                break;
            default :
                $per_page = 120;
        }
		
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        
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
 
        $this->CI->template->write_view('content', 'menu/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
			$this->CI->Session->unset_session('limitpage', $arrParam['limitpage']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('colmenu', $_GET['colmenu']);
        }
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sửa menu';
        $items = $this->CI->MenuModel->getItem((int)$_GET['id']);
        $this->data['items'] = $items;
        $slbParents = $this->CI->MenuModel->listItem($_GET,array('task'=>'remove-id'));
        
        if ($this->CI->input->post()){
            $this->CI->MenuValidate->validateForm($this->CI->input->post());
            if($this->CI->MenuValidate->isVaild()){
                $errors = $this->CI->MenuValidate->getMessageErrors();
                $items = $this->CI->MenuValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->MenuValidate->getData();
                $data['id'] = $_GET['id'];
                $this->CI->MenuModel->saveItemNews($data,array('task'=>'edit'));
                if($_GET['type']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$_GET['id']);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->data['slbParents'] = $slbParents;
        $this->CI->template->write_view('content', 'menu/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm menu';
        $slbParents = $this->CI->MenuModel->listItem();
        if ($this->CI->input->post()){
            $this->CI->MenuValidate->validateForm($this->CI->input->post());
            if($this->CI->MenuValidate->isVaild()){
                $errors = $this->CI->MenuValidate->getMessageErrors();
                $items = $this->CI->MenuValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->MenuValidate->getData();
                $id = $this->CI->MenuModel->saveItemNews($data,array('task'=>'add'));
                $data['id'] = $id;
                $this->CI->MenuModel->updateOrder($data);
                if($_GET['type']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.$id);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->data['slbParents'] = $slbParents;
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'menu/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function sort(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if ($this->CI->input->post()){
            $this->CI->MenuModel->sortItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->MenuModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->MenuModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->MenuModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->MenuModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function getResponse() {
        return $this->_response;
    }
}
