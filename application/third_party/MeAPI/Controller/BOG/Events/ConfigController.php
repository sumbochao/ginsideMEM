<?php
class MeAPI_Controller_BOG_Events_ConfigController implements MeAPI_Controller_BOG_Events_ConfigInterface {
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
            $this->url_service = 'http://localhost.service.bog.mobo.vn/bog/index.php';
        }else{
            $this->url_service = 'http://game.mobo.vn/bog';
        }
        $this->view_data = new stdClass();
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
         $this->data['title']= 'DANH SÁCH CẤU HÌNH';
        $this->CI->template->write_view('content', 'game/bog/Events/config/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->data['title']= 'THÊM CẤU HÌNH';
        $this->authorize->validateAuthorizeRequest($request, 0);     
        $this->CI->template->write_view('content', 'game/bog/Events/config/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'SỬA CẤU HÌNH';
        $id = $_GET['id'];
        $linkinfo = $this->url_service.'/cms/config/gettem?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        
        $this->CI->template->write_view('content', 'game/bog/Events/config/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/config/delete?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index#item');      
    }
    public function getResponse() {
        return $this->_response;
    }
}