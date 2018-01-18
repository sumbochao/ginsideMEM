<?php
class MeAPI_Controller_GameRequest_RequestCatController implements MeAPI_Controller_GameRequest_RequestCatInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('RequestCatModel');
        $this->CI->load->MeAPI_Validate('RequestCatValidate');
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
        $this->data['title'] = 'Danh sách request';
        
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
            'configID' => $this->CI->Session->get_session('configID'),
            'gameID' => $this->CI->Session->get_session('gameID'),
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
                'configID' => $arrParam['configID'],
                'gameID' => $arrParam['gameID'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->RequestCatModel->listItem($arrFilter);
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
        $this->data['slbConfig'] = $this->CI->RequestCatModel->listConfig();
        $this->data['slbGame'] = $this->CI->RequestCatModel->listGame();
        
        $this->CI->template->write_view('content', 'gamerequest/requestcat/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('configID', $arrParam['configID']);
            $this->CI->Session->unset_session('gameID', $arrParam['gameID']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('colm', $_GET['colm']);
        }
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sửa request';
        $this->data['items'] = $this->CI->RequestCatModel->getItem((int)$_GET['id']);
        $this->data['slbConfig'] = $this->CI->RequestCatModel->listConfig();
        $this->data['slbGame'] = $this->CI->RequestCatModel->listGame();
        $this->data['slbReceiveGame'] = $this->CI->RequestCatModel->listReceiveGame($this->data['items']['gameID']);
        if ($this->CI->input->post()){
            $this->CI->RequestCatValidate->validateForm($this->CI->input->post());
            if($this->CI->RequestCatValidate->isVaild()){
                $errors = $this->CI->RequestCatValidate->getMessageErrors();
                $items = $this->CI->RequestCatValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
                $this->data['slbReceiveGame'] = array();
                if($items['gameID']>0){
                    $this->data['slbReceiveGame'] = $this->CI->RequestCatModel->listReceiveGame($items['gameID']);
                }
            }else{
                $data = $this->CI->RequestCatValidate->getData();
                $data['id'] = $_GET['id'];
                $this->CI->RequestCatModel->saveItem($data,array('task'=>'edit'));
                if($_GET['types']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$_GET['id']);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->CI->template->write_view('content', 'gamerequest/requestcat/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm request';
        $this->data['slbConfig'] = $this->CI->RequestCatModel->listConfig();
        $this->data['slbGame'] = $this->CI->RequestCatModel->listGame();
        if ($this->CI->input->post()){
            $this->CI->RequestCatValidate->validateForm($this->CI->input->post());
            if($this->CI->RequestCatValidate->isVaild()){
                $errors = $this->CI->RequestCatValidate->getMessageErrors();
                $items = $this->CI->RequestCatValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
                $this->data['slbReceiveGame'] = array();
                if($items['gameID']>0){
                    $this->data['slbReceiveGame'] = $this->CI->RequestCatModel->listReceiveGame($items['gameID']);
                }
            }else{
                $data = $this->CI->RequestCatValidate->getData();
                $id = $this->CI->RequestCatModel->saveItem($data,array('task'=>'add'));
                $data['id'] = $id;
                $this->CI->RequestCatModel->updateOrder($data);
                if($_GET['types']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.$id);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'gamerequest/requestcat/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->RequestCatModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->RequestCatModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->RequestCatModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->RequestCatModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function sort(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if ($this->CI->input->post()){
            $this->CI->RequestCatModel->sortItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function ajax_receive(){
        $arrParam = $this->CI->security->xss_clean($_REQUEST);
        if($arrParam['id']>0){
            $data['slbReceiveGame'] = $this->CI->RequestCatModel->listReceiveGame($arrParam['id']);
            $html = $this->CI->load->view('gamerequest/requestcat/ajax_receive', $data, true);
            $reponse = array(
                'status' => 0,
                'messg' => 'Thành công',
                'html' => $html
            );
        }else{
            $html = $this->CI->load->view('gamerequest/requestcat/ajax_receive', $data, true);
            $reponse = array(
                'status' => 1,
                'messg' => 'Thất bại',
                'html' => $html
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function getResponse() {
        return $this->_response;
    }
}
