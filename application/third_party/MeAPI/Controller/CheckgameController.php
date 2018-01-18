<?php
class MeAPI_Controller_CheckgameController{
    protected $_response;
    private $CI;
    private $_mainAction;
	private $limit;
	
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->MeAPI_Model('CategoriesModel');
		$this->CI->load->MeAPI_Model('GroupuserModel');
		$this->CI->load->MeAPI_Model('GrandRequestUserModel');
		$this->CI->load->MeAPI_Model('CategoriesModel');
		$this->CI->load->MeAPI_Model('TemplateModel');
		$this->CI->load->MeAPI_Model('TemplatechecklistModel');
		$this->CI->load->MeAPI_Model('RequestModel');
		
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
		$this->data['loadgame']=$this->CI->TemplatechecklistModel->listGame();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'checkgame/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'CHECK LIST GAME';
		$this->data['listtemplate'] = $this->CI->TemplateModel->listItem(NULL,1);
	
        $this->CI->template->write_view('content', 'checkgame/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('cbo_categories', $arrParam['cbo_categories']);
        }
    }
	
    public function getResponse() {
        return $this->_response;
    }
}
