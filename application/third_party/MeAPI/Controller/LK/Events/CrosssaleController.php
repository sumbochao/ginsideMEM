<?php
class MeAPI_Controller_LK_Events_CrosssaleController implements MeAPI_Controller_LK_Events_CrosssaleInterface {
    protected $_response;
    private $CI;
    private $url_service;
    
    public function __construct() {       
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.game.mobo.vn/hiepkhach/index.php';
        }else{
            $this->url_service = 'http://game.mobo.vn/hiepkhach';
        }
        $this->view_data = new stdClass();
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'config':
                $this->data['title'] = 'QUẢN LÝ CẤU HÌNH';    
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/config/index', $this->data);
                break;
            case 'listgame':
                $this->data['title'] = 'QUẢN LÝ GAME';   
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/listgame/index', $this->data);
                break;
            case 'requestcat':
                $this->data['title'] = 'QUẢN LÝ YÊU CẦU';
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/requestcat/index', $this->data);
                break;
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'config':
                $this->data['title'] = 'THÊM CẤU HÌNH';
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/config/add', $this->data);
                break;
            case 'listgame':
                $this->data['title'] = 'THÊM GAME';
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/listgame/add', $this->data);
                break;
            case 'requestcat':
                $this->data['title'] = 'THÊM YÊU CẦU';
                $linkConfigFitter = $this->url_service.'/cms/crosssale/index_config';
                $j_configFitter = file_get_contents($linkConfigFitter);
                $configFitter['rows']['rows'] = json_decode($j_configFitter,true);
                $this->data['configFitter'] = $configFitter['rows']['rows']['rows'];
                $linkGameFitter = $this->url_service.'/cms/crosssale/listgame';
                $j_gameFitter = file_get_contents($linkGameFitter);
                $this->data['slbGame'] = json_decode($j_gameFitter,true);
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/requestcat/add', $this->data);
                break;
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'config':
                $this->data['title'] = 'SỬA CẤU HÌNH';
                $linkInfo = $this->url_service.'/cms/crosssale/gettem_config?id='.$id;
                $j_items = file_get_contents($linkInfo);
                $this->data['items'] = json_decode($j_items,true);
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/config/add', $this->data);
                break;
            case 'listgame':
                $this->data['title'] = 'SỬA GAME';
                $linkInfo = $this->url_service.'/cms/crosssale/gettem_listgame?id='.$id;
                $j_items = file_get_contents($linkInfo);
                $this->data['items'] = json_decode($j_items,true);
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/listgame/add', $this->data);
                break;
            case 'requestcat':
                $this->data['title'] = 'SỬA YÊU CẦU';
                $linkInfo = $this->url_service.'/cms/crosssale/gettem_requestcat?id='.$id;
                $j_items = file_get_contents($linkInfo);
                $this->data['items'] = json_decode($j_items,true);

                $linkConfigFitter = $this->url_service.'/cms/crosssale/index_config';
                $j_configFitter = file_get_contents($linkConfigFitter);
                $configFitter['rows']['rows'] = json_decode($j_configFitter,true);
                $this->data['configFitter'] = $configFitter['rows']['rows']['rows'];

                $linkGameFitter = $this->url_service.'/cms/crosssale/listgame';
                $j_gameFitter = file_get_contents($linkGameFitter);
                $this->data['slbGame'] = json_decode($j_gameFitter,true);

                $linkGameReceiveFitter = $this->url_service.'/cms/crosssale/listgame_receive?receive_game='.$this->data['items']['gameID'];
                $j_gameReceiveFitter = file_get_contents($linkGameReceiveFitter);
                $this->data['slbGameReceive'] = json_decode($j_gameReceiveFitter,true);
                $this->CI->template->write_view('content', 'game/lk/Events/crosssale/requestcat/add', $this->data);
                break;
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add_match(MeAPI_RequestInterface $request){
        if(isset($_FILES['url']['tmp_name']) && !empty($_FILES['url']['tmp_name'])){
            if($_FILES['url']['size'] > 1048576){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh đội A không được lớn hơn 700MB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }else{
                $_FILES['url']['encodefile'] = $this->data_uri($_FILES['url']['tmp_name'], $_FILES['url']['type']);
                $arrPOST = array('ids'=>$_POST['id'],'current_url'=>$_POST['current_url']);
                $url = $this->curlPost($_FILES['url'],$arrPOST);
            }
        }else{
            if($_POST['id']>0){
                $url = $_POST['current_url'];
            }
        }
        if($_POST['id']>0){
            $array = array(
                'id'=>$_POST['id'],
                'gameID'=>$_POST['gameID'],
                'name'=>$_POST['name'],
                'alias'=>$_POST['alias'],
                'url'=>$url,
                'linkandroid'=>$_POST['linkandroid'],
                'linkios'=>$_POST['linkios'],
                'linkwp'=>$_POST['linkwp'],
                'status'=>$_POST['status'],
            );
        }else{
            $array = array(
                'gameID'=>$_POST['gameID'],
                'name'=>$_POST['name'],
                'alias'=>$_POST['alias'],
                'url'=>$url,
                'linkandroid'=>$_POST['linkandroid'],
                'linkios'=>$_POST['linkios'],
                'linkwp'=>$_POST['linkwp'],
                'status'=>$_POST['status'],
            );
        }
        $action = ($_POST['id']>0)?'edit_listgame':'add_listgame';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/crosssale/".$action);        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'config':
                $linkInfo = $this->url_service.'/cms/crosssale/delete_config?id='.$id;
                $j_items = file_get_contents($linkInfo);
                redirect(base_url().'?control='.$_GET['control'].'&func=index&view=config#config');
                break;
            case 'listgame':
                $linkInfo = $this->url_service.'/cms/crosssale/delete_listgame?id='.$id;
                $j_items = file_get_contents($linkInfo);
                redirect(base_url().'?control='.$_GET['control'].'&func=index&view=listgame#listgame');
                break;
            case 'requestcat':
                $linkInfo = $this->url_service.'/cms/crosssale/delete_requestcat?id='.$id;
                $j_items = file_get_contents($linkInfo);
                redirect(base_url().'?control='.$_GET['control'].'&func=index&view=requestcat#requestcat');
                break;
        }
    }
    
    public function history(MeAPI_RequestInterface $request){
        $this->CI->load->MeAPI_Library('Pgt');
        $this->authorize->validateAuthorizeRequest($request, 0);
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
        $per_page = 5;
        $pa = $page - 1;
        $start = $pa * $per_page;
        $this->data['start'] = $start;

        $linkListItem = $this->url_service.'/cms/crosssale/user_request?keyword='.$arrFilter['keyword'];
        $j_listItem = file_get_contents($linkListItem);
        $listItem = json_decode($j_listItem,true);
        
        $linkListItemHistory = $this->url_service.'/cms/crosssale/user_history?keyword='.$arrFilter['keyword'];
        $j_listItemHistory = file_get_contents($linkListItemHistory);
        $listItemHistory = json_decode($j_listItemHistory,true);
        
        $maxTotal = max(count($listItem),count($listItemHistory));
        $total = $maxTotal;
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=history';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItem) !== TRUE){
            $listData = array_slice($listItem, $start, $per_page);
        }
        $listDataHistory = FALSE;
        if(empty($listItemHistory) !== TRUE){
            $listDataHistory = array_slice($listItemHistory, $start, $per_page);
        }
        
        $this->data['listItem'] = $listData;
        $this->data['listItemHistory'] = $listDataHistory;
        $this->data['arrFilter'] = $arrFilter;
        $this->CI->template->write_view('content', 'game/lk/Events/crosssale/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
        }
    }
    
    public function getResponse() {
        return $this->_response;
    }
    public function curlPost($params,$post,$link=''){
        $arrParam = array_merge($params,$post);
        $this->last_link_request = empty($link)?$this->url_service."/cms/crosssale/returnpathimg":$link;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($arrParam));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrParam);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        if($result){
            $result = json_decode($result,true);
            if($result['code']==0){
                $result = $result['data'];
            }
        }
        return $result;
    }
    function data_uri($file, $mime='image/jpeg'){
        if(empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    public function curlPostAPI($params,$link=''){
        $this->last_link_request = empty($link)?$this->url_service."/cms/crosssale/returnpathimg":$link;	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);        
        return $result;
    }
    public function ajax_receive(){
        $arrParam = $this->CI->security->xss_clean($_REQUEST);
        if($arrParam['id']>0){
            $linkGameReceiveFitter = $this->url_service.'/cms/crosssale/listgame_receive?receive_game='.$arrParam['id'];
            $j_gameReceiveFitter = file_get_contents($linkGameReceiveFitter);
            $data['slbGameReceive'] = json_decode($j_gameReceiveFitter,true);
            $html = $this->CI->load->view('game/lk/Events/crosssale/requestcat/ajax_receive', $data, true);
            $reponse = array(
                'status' => 0,
                'messg' => 'Thành công',
                'html' => $html
            );
        }else{
            $html = $this->CI->load->view('game/lk/Events/crosssale/requestcat/ajax_receive', $data, true);
            $reponse = array(
                'status' => 1,
                'messg' => 'Thất bại',
                'html' => $html
            );
        }
        echo json_encode($reponse);
        exit();
    }
}
