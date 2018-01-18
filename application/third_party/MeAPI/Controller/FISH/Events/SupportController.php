<?php
class MeAPI_Controller_FISH_Events_SupportController implements MeAPI_Controller_FISH_Events_SupportInterface {
    protected $_response;
    private $CI;
    public $url_service;
    private $url = "http://doixubanca.com/cms/toolsupport";
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
		$this->data['url'] = $this->url;
    }
	public function index(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'LỊCH SỬ';
		//load model
        $this->CI->template->write_view('content', 'game/fish/Events/support/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'PHẢN HỒI';
		if(!empty($_GET['ids'])){
			$getdetail = $this->url.'/getdetail?idx='.$_GET['ids'];
			$infoDetail = file_get_contents($getdetail);
			$infodetail = json_decode($infoDetail,true);
			$this->data['infodetail'] = $infodetail;  
		}else{
			$this->CI->template->write_view('content', 'game/fish/Events/support/notfound', $this->data);
			$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
			return;
		}
        $this->CI->template->write_view('content', 'game/fish/Events/support/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}