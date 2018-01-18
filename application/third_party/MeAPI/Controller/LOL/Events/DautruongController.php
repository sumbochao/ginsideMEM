<?php
class MeAPI_Controller_LOL_Events_DautruongController implements MeAPI_Controller_LOL_Events_DautruongInterface {
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
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'DANH SÁCH SỰ KIỆN';
                break;
            case 'order_hero':
                $this->data['title']= 'DANH SÁCH NHẬN TƯỚNG';
                break;
            case 'history_money':
                $this->data['title']= 'DANH SÁCH TRỪ TIỀN';
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/dautruong/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'THÊM SỰ KIỆN';
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/dautruong/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        
        $linkinfo = $this->url_service.'/cms/dautruong/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'SỬA SỰ KIỆN';
                break;
        }
        
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/dautruong/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        file_get_contents($this->url_service.'/cms/dautruong/delete_'.$_GET['view'].'?id='.$id);
        switch ($_GET['view']){
            case 'event':
                redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module='.$_GET['module']); 
                break;
            case 'order_hero':
                //cache
                file_get_contents($this->url_service.'/event/dautruong/del_cache?mobo_id='.$_GET['mobo_id'].'&event_id='.$_GET['id_event']);
                redirect(base_url().'?control='.$_GET['control'].'&func=history&view='.$_GET['view'].'&module='.$_GET['module']); 
                break;
            case 'history_money':
                redirect(base_url().'?control='.$_GET['control'].'&func=history&view='.$_GET['view'].'&module='.$_GET['module']); 
                break;
        }
        
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'history_money':
                $this->data['title']= 'LỊCH SỬ TRỪ TIỀN';
                break;
            case 'order_hero':
                $this->data['title']= 'LỊCH SỬ NHẬN TƯỚNG';
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/dautruong/history/'.$_GET['view'], $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}

