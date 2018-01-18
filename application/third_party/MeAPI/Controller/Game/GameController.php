<?php
class MeAPI_Controller_Game_GameController implements MeAPI_Controller_Game_GameInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('Game/GameModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index&module=all'.$page;
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Danh sách game';
        
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
       
        $per_page = 25;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->GameModel->listItem();
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
        $this->CI->template->write_view('content', 'game/game/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function status(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->GameModel->statusItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->GameModel->statusItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function getResponse() {
        return $this->_response;
    }
}
