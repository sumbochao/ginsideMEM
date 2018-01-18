<?php
class MeAPI_Controller_LK_Reports_UserRequestController implements MeAPI_Controller_LK_Reports_UserRequestInterface {
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
    public function index(MeAPI_RequestInterface $request){
        
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

        $linkListItem = $this->url_service.'/cms/user_request/index?keyword='.$arrFilter['keyword'];
        $j_listItem = file_get_contents($linkListItem);
        $listItem = json_decode($j_listItem,true);
        
        $linkListItemHistory = $this->url_service.'/cms/user_request/history?keyword='.$arrFilter['keyword'];
        $j_listItemHistory = file_get_contents($linkListItemHistory);
        $listItemHistory = json_decode($j_listItemHistory,true);
        
        $maxTotal = max(count($listItem),count($listItemHistory));
        $total = $maxTotal;
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=index';
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
        $this->CI->template->write_view('content', 'game/lk/Reports/userrequest/index', $this->data);
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
}