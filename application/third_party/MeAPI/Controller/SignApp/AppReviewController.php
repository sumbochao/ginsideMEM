<?php
class MeAPI_Controller_SignApp_AppReviewController implements MeAPI_Controller_SignApp_AppReviewInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('SignApp/AppReviewModel');
        $this->CI->load->MeAPI_Validate('SignApp/AppReviewValidate');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
    public function getplatform(){
        if(empty($_REQUEST['platform'])){
            $f = array(
                'error'=>'1',
                'messg'=>'Vui lòng chọn loại'
            );
        }else{
            $this->data['slbProjects'] = $this->CI->AppReviewModel->listPackage($_REQUEST['platform']);
            $f = array(
                'error'=>'0',
                'html'=>$this->CI->load->view('appreview/slbpackage', $this->data, true)
            );
        }
        echo json_encode($f);
        exit();
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Danh sách app review';
        
        $this->filter();
        $getcolm = $this->CI->Session->get_session('colm');
        if (empty($getcolm)) {
            $this->CI->Session->set_session('colm', 'status');
            $this->CI->Session->set_session('order', 'ASC');
        }
        $arrFilter = array(
            'colm' => $this->CI->Session->get_session('colm'),
            'order' => $this->CI->Session->get_session('order'),
            'keyword' => $this->CI->Session->get_session('keyword'),
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrFilter = array(
                'colm' => "status",
                'order' => "DESC",
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->AppReviewModel->listItem($arrFilter);
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
        $this->CI->template->write_view('content', 'appreview/index', $this->data);
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
        $this->data['title'] = 'Sửa app review';
        $this->data['items'] = $this->CI->AppReviewModel->getItem((int)$_GET['id']);
        $this->data['slbProjects'] = $this->CI->AppReviewModel->listPackage($this->data['items']['type']);
        if ($this->CI->input->post()){
            $this->CI->AppReviewValidate->validateForm($this->CI->input->post());
            if($this->CI->AppReviewValidate->isVaild()){
                $errors = $this->CI->AppReviewValidate->getMessageErrors();
                $items = $this->CI->AppReviewValidate->getData();
                if(!empty($_POST['type'])){
                    $this->data['slbProjects'] = $this->CI->AppReviewModel->listPackage($_POST['type']);
                }
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->AppReviewValidate->getData();
                $data['id'] = $_GET['id'];
                $this->CI->AppReviewModel->saveItem($data,array('task'=>'edit'));
                $linkInfo = 'http://service.doden.us/api/clearcache?key=review';
                $j_items = file_get_contents($linkInfo);
                if($_GET['type']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$_GET['id']);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->CI->template->write_view('content', 'appreview/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm app review';
        $this->data['slbProjects'] = array();
        if ($this->CI->input->post()){
            $this->CI->AppReviewValidate->validateForm($this->CI->input->post());
            if($this->CI->AppReviewValidate->isVaild()){
                $errors = $this->CI->AppReviewValidate->getMessageErrors();
                $items = $this->CI->AppReviewValidate->getData();
                if(!empty($_POST['type'])){
                    $this->data['slbProjects'] = $this->CI->AppReviewModel->listPackage($_POST['type']);
                }
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->AppReviewValidate->getData();
                $id = $this->CI->AppReviewModel->saveItem($data,array('task'=>'add'));
                $linkInfo = 'http://service.doden.us/api/clearcache?key=review';
                $j_items = file_get_contents($linkInfo);
                $data['id'] = $id;
                if($_GET['type']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.$id);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'appreview/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function sort(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if ($this->CI->input->post()){
            $this->CI->AppReviewModel->sortItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->AppReviewModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->AppReviewModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->AppReviewModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->AppReviewModel->deleteItem($arrParam);
        }
		$linkInfo = 'http://service.doden.us/api/clearcache?key=review';
		$j_items = file_get_contents($linkInfo);
        redirect($this->_mainAction);
    }
    public function api(MeAPI_RequestInterface $request){
        $listItem = $this->CI->AppReviewModel->listData();
        $arrData = array(
            'reviewApps'=>array(),
            'disabledGPlus'=>array(),
        );
        if($listItem==true){
            foreach($listItem as $v){
                switch ($v['type']){
                    case 'ios':
                        $type = '0';
                        break;
                    case 'android':
                        $type = '2';
                        break;
                }
                $arrData['reviewApps'][] = array(
                    'bundle'=>$v['package_name'],
                    'version'=>$v['version'],
                    'platform'=>$type
                );
            }
        }
        echo json_encode($arrData);
        exit();
    }
    public function getResponse() {
        return $this->_response;
    }
}
