<?php
class MeAPI_Controller_PushIOS_PushIOSController implements MeAPI_Controller_PushIOS_PushIOSInterface {
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
        $this->view_data = new stdClass();
        $this->url_service = 'http://ginside.mobo.vn';
        $this->data['url_service'] = $this->url_service;
    }
    
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'DANH SÁCH ADD CATEGORY';
        $this->CI->template->write_view('content', 'pushIOS/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'ADD CATEGORY';
        $linkSlbDomain = $this->url_service.'/api/category';
        $slbDomain = json_decode(file_get_contents($linkSlbDomain),true);
        $this->data['slbDomain'] = $slbDomain;
        //echo "<pre>";print_r($slbDomain);die();
        $this->CI->template->write_view('content', 'pushIOS/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }    
    public function getResponse() {
        return $this->_response;
    }
}