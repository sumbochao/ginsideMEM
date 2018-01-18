<?php
class MeAPI_Controller_PT_Events_AccumulationController implements MeAPI_Controller_PT_Events_AccumulationInterface {
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
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.phongthan.mobo.vn';
        }else{
            $this->url_service = 'http://service.phongthan.mobo.vn';
        }
    }
    public function index_event(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);     
        $this->CI->template->write_view('content', 'game/pt/Events/accumulation/event/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add_event(MeAPI_RequestInterface $request){
        $this->data['title']= 'THÊM MỚI SỰ KIỆN';
        $this->authorize->validateAuthorizeRequest($request, 0);     
        $this->CI->template->write_view('content', 'game/pt/Events/accumulation/event/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit_event(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        $linkinfo = $this->url_service.'/cms/accumulation/gettem_event?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        
        $this->data['title']= 'SỬA SỰ KIỆN';
        $this->CI->template->write_view('content', 'game/pt/Events/accumulation/event/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);     
        $this->CI->template->write_view('content', 'game/pt/Events/accumulation/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}