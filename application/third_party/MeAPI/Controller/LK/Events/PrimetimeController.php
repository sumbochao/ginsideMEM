<?php
class MeAPI_Controller_LK_Events_PrimetimeController implements MeAPI_Controller_LK_Events_PrimetimeInterface {
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
    public function config(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = 1;
        $linkinfo = $this->url_service.'/cms/primetime/gettem?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $infodetail = json_decode($infoDetail,true);
        $this->data['infodetail'] = $infodetail;  
       
        $this->CI->template->write_view('content', 'game/lk/Events/primetime/config', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function history(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/lk/Events/primetime/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}
