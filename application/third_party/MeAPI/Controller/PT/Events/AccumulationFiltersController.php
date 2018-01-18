<?php
class MeAPI_Controller_PT_Events_AccumulationFiltersController implements MeAPI_Controller_PT_Events_AccumulationFiltersInterface {
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
    public function index_filters(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'DANH SÁCH BỘ LỌC';
        $this->CI->template->write_view('content', 'game/pt/Events/accumulation/filters/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add_filters(MeAPI_RequestInterface $request){
        $this->data['title']= 'THÊM MỚI BỘ LỌC';
        $this->authorize->validateAuthorizeRequest($request, 0); 
			
		$linkinfoslbEvent = $this->url_service.'/cms/accumulation/index_event';
        $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
        $slbEvent = json_decode($infoDetailslbEvent,true);
        $this->data['slbEvent'] = $slbEvent;
		
        $this->CI->template->write_view('content', 'game/pt/Events/accumulation/filters/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function delete_filters(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/accumulation/delete_filters?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index_filters#filters'); 
    }
    public function edit_filters(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'SỬA BỘ LỌC';
        $id = $_GET['id'];
        $linkinfo = $this->url_service.'/cms/accumulation/gettem_filters?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        
		$linkinfoslbEvent = $this->url_service.'/cms/accumulation/index_event';
        $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
        $slbEvent = json_decode($infoDetailslbEvent,true);
        $this->data['slbEvent'] = $slbEvent;
		
        $this->data['title']= 'SỬA BỘ LỌC';
        $this->CI->template->write_view('content', 'game/pt/Events/accumulation/filters/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}