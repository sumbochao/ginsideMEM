<?php
class MeAPI_Controller_PopupController {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('PopupModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index';
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
       	$dataItemView['rs'] = $this->CI->PopupModel->getItem(intval($_GET['id']));
		
		$this->data['viewitem']=$dataItemView['rs'];
		
		$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'popup/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
  	 public function getResponse() {
        return $this->_response;
    }
}
