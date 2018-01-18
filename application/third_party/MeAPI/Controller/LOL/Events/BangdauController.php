<?php
class MeAPI_Controller_LOL_Events_BangdauController implements MeAPI_Controller_LOL_Events_BangdauInterface {
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
            $this->url_service = 'http://localhost.service.lol.mobo.vn';
        }else{
            $this->url_service = 'http://game.mobo.vn/lol';
        }
        $this->data['url_service'] = $this->url_service;
    }
    public function bangdau(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'BẢNG ĐẤU OFFLINE';
        $linkinfo = $this->url_service.'/cms/bangdau/get_bangdau?id=1';
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->CI->template->write_view('content', 'game/lol/Events/bangdau/bangdau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function bangdauv1(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'BẢNG ĐẤU V1 OFFLINE';
        $linkinfo = $this->url_service.'/cms/bangdau/get_bangdauv1?id=1';
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->CI->template->write_view('content', 'game/lol/Events/bangdau/bangdauv1', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function config(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'BẢNG ĐẤU LCS2016';
        $linkinfo = $this->url_service.'/cms/bangdau_lcs/getItem?id=1';
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->CI->template->write_view('content', 'game/lol/Events/bangdau/config', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}