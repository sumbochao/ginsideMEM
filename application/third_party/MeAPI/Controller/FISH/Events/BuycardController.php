<?php
class MeAPI_Controller_FISH_Events_BuycardController implements MeAPI_Controller_FISH_Events_BuycardInterface {
    protected $_response;
    private $CI;
    public $url;
    
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
            $this->url = 'http://localhost.game.mobo.vn/fish/index.php';
        }else{
            $this->url = 'http://game.mobo.vn/fish';
        }
		$this->data['url'] = $this->url;
        $this->view_data = new stdClass();
    }
	public function index(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'config':
                $this->data['title'] = 'QUẢN LÝ CẤU HÌNH';
                $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/config/index', $this->data);
                break;
            case 'item':
                $this->data['title'] = 'QUẢN LÝ ITEM';
                $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/item/index', $this->data);
                break;
        } 
		
		//$this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/item/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
    public function config(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = 1;
        $linkinfo = $this->url_service.'/cms/primetime/gettem?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $infodetail = json_decode($infoDetail,true);
        $this->data['infodetail'] = $infodetail;  
       
        $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/config', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function history(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function historygroup(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/historygroup', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'config':
                $this->data['title'] = 'THÊM CẤU HÌNH';
                $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/config/add', $this->data);
                break;
            case 'item':
                $this->data['title'] = 'THÊM ITEM';
                $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/item/add', $this->data);
                break;
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'config':
                $this->data['title'] = 'SỬA CẤU HÌNH';
                $id = $_GET['ids'];
                $linkInfo = $this->url.'/event/buycard/getconfigId?idx='.$id."&type=config";
				$j_items = file_get_contents($linkInfo);
				$this->data['items'] = json_decode($j_items,true);
                $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/config/add', $this->data);
                break;
            case 'item':
                $this->data['title'] = 'SỬA ITEM';
                $id = $_GET['ids'];
                $linkInfo = $this->url.'/event/buycard/getconfigId?idx='.$id."&type=item";
                $j_items = file_get_contents($linkInfo);
                $this->data['items'] = json_decode($j_items,true);
                $this->CI->template->write_view('content', 'game/fish/Events/toolbuycard/item/add', $this->data);
                break;
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $id = $_GET['id'];
                $linkInfo = $this->url_service.'/cms/awardvip/delete_event?id='.$id;
                $j_items = file_get_contents($linkInfo);
                redirect(base_url().'?control='.$_GET['control'].'&func=index&view=event#event');
                break;
            case 'config':
                $id = $_GET['id'];
                $linkInfo = $this->url_service.'/cms/awardvip/delete_config?id='.$id;
                $j_items = file_get_contents($linkInfo);
                redirect(base_url().'?control='.$_GET['control'].'&func=index&view=config#config');
                break;
            case 'item':
                $id = $_GET['id'];
                $linkInfo = $this->url_service.'/cms/awardvip/delete_item?id='.$id;
                $j_items = file_get_contents($linkInfo);
                redirect(base_url().'?control='.$_GET['control'].'&func=index&view=item#item');
                break;
        }
    }
	
    public function getResponse() {
        return $this->_response;
    }
}
