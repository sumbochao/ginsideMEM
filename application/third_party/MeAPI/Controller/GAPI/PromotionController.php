<?php
class MeAPI_Controller_GAPI_PromotionController implements MeAPI_Controller_GAPI_PromotionInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('Gapi/PromotionModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index&module=all'.$page;
    }
    public function loadserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Model('SearchInfoModel');
        $listServer = $this->CI->SearchInfoModel->listServerByGame($_GET['game_id'], true);
        $this->data['listServer'] = $listServer;
        $s_id = array();
        $n_id = $_GET['lid'];
        if (!empty($n_id)){
            $s_id = explode(",", $n_id);
        }
        $this->data['s_id']= $s_id;
        echo $this->CI->load->view('gapi/promotion/loadserver', $this->data, true);
        die();
    }
    public function loadamount(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $urlService = 'http://gapi.mobo.vn/?control=game&func=get_pay_element&app=game&token=d1fd6c44f2aa624d819657478177b9af';
        $arrInfo = json_decode(file_get_contents($urlService),true);
        $arrAmount = array();
        if($arrInfo['code']=='500102'){
            if(count($arrInfo['data']['data'])>0){
                foreach($arrInfo['data']['data'] as $v){
                    if($v['type']=='amount'){
                        $arrAmount[$v['value']] = $v['value'];
                    }
                }
                ksort($arrAmount);
            }
        }
        $this->data['slbAmount'] = $arrAmount;
        
        $a_id = array();
        $a_id = $_GET['aid'];
        if (!empty($a_id)){
            $a_id = explode(",", $a_id);
        }
        $this->data['a_id']= $a_id;
        echo $this->CI->load->view('gapi/promotion/loadamount', $this->data, true);
        die();
    }
    public function loadtype(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $urlService = 'http://gapi.mobo.vn/?control=game&func=get_pay_element&app=game&token=d1fd6c44f2aa624d819657478177b9af';
        $arrInfo = json_decode(file_get_contents($urlService),true);
        $arrPayType = array();
        if($arrInfo['code']=='500102'){
            if(count($arrInfo['data']['data'])>0){
                foreach($arrInfo['data']['data'] as $v){
                    if($v['type']=='paytype'){
                        $arrPayType[$v['value']] = $v['value'];
                    }
                }
                ksort($arrPayType);
            }
        }
        $this->data['slbType'] = $arrPayType;
        
        $t_id = array();
        $t_id = $_GET['tid'];
        if (!empty($t_id)){
            $t_id = explode(",", $t_id);
        }
        $this->data['t_id']= $t_id;
        echo $this->CI->load->view('gapi/promotion/loadtype', $this->data, true);
        die();
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Danh sách khuyến mãi';
        
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
            'game' => $this->CI->Session->get_session('game'),
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'colm' => "id",
                'order' => "DESC",
                'keyword' => $arrParam['keyword'],
                'game' => $arrParam['game'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->PromotionModel->listItem($arrFilter);
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=index&module=all';
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
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
		
        $this->CI->template->write_view('content', 'gapi/promotion/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('game', $arrParam['game']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('colm', $_GET['colm']);
        }
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sửa khuyến mãi';
        $this->data['items'] = $this->CI->PromotionModel->getItem((int)$_GET['id']);
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
        
        if ($this->CI->input->post()){
            $id = $this->CI->PromotionModel->saveItem($_REQUEST,array('task'=>'edit'));
			
			$this->CI->PromotionModel->insertLog($_REQUEST);
			
            if($id > 0){
                $R["result"] = 1;
                $R["message"]='SỬA DỮ LIỆU THÀNH CÔNG !';

            }else{
                $R["result"] = -1;
                $R["message"]='SỬA DỮ LIỆU THẤT BẠI !';
            }

            if(isset($_GET['callback'])){
                echo $_GET['callback']."(".json_encode($R).")";
            }else{
                $this->output->set_header('Content-type: application/json');
                $this->output->set_output(json_encode($R));
            }
            die();
        }
        $this->CI->template->write_view('content', 'gapi/promotion/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm khuyến mãi';
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
		
        if ($this->CI->input->post()){
            $id = $this->CI->PromotionModel->saveItem($_POST,array('task'=>'add'));
			
			$_POST['id']= $id;
            $_POST['control'] = $_GET['control'];
            $_POST['func'] = $_GET['func'];
            $this->CI->PromotionModel->insertLog($_POST);
			
            if($id > 0){
                $R["result"] = 1;
                $R["message"]='THÊM DỮ LIỆU THÀNH CÔNG !';

            }else{
                $R["result"] = -1;
                $R["message"]='THÊM DỮ LIỆU THẤT BẠI !';
            }

            if(isset($_GET['callback'])){
                echo $_GET['callback']."(".json_encode($R).")";
            }else{
                $this->output->set_header('Content-type: application/json');
                $this->output->set_output(json_encode($R));
            }
            die();
        }
        $this->CI->template->write_view('content', 'gapi/promotion/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->PromotionModel->deleteItem($arrParam,array('task'=>'multi'));
			$arrParamLog = array(
                'controller'=>$_GET['control'],
                'action'=>$_GET['func'],
                'delete_strid'=>@implode(',', $arrParam['cid']),
                'id_user'=>$_SESSION['account']['id'],
                'username'=>$_SESSION['account']['username'],
            );
            $this->CI->PromotionModel->insertLog($arrParamLog);
        }else{
            $this->CI->PromotionModel->deleteItem($arrParam);
			$arrParamLog = array(
                'controller'=>$_GET['control'],
                'action'=>$_GET['func'],
                'delete_data'=>(int)$_GET['id'],
                'id_user'=>$_SESSION['account']['id'],
                'username'=>$_SESSION['account']['username'],
            );
            $this->CI->PromotionModel->insertLog($arrParamLog);
        }
        redirect($this->_mainAction);
    }
    public function getResponse() {
        return $this->_response;
    }
}
