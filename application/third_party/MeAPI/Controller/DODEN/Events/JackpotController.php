<?php
class MeAPI_Controller_DODEN_Events_JackpotController implements MeAPI_Controller_DODEN_Events_JackpotInterface {
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
            $this->url = 'http://sev.banca888.net';
        }
		$this->data['url'] = $this->url;
        $this->view_data = new stdClass();
    }
	public function index(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'config':
                $this->data['title'] = 'QUẢN LÝ CẤU HÌNH';
                $this->CI->template->write_view('content', 'game/doden/Events/jackpot/config/index', $this->data);
                break;
        } 
		
		//$this->CI->template->write_view('content', 'game/fish/Events/toolbuygem/item/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
    public function config(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = 1;
        $linkinfo = $this->url_service.'/cms/primetime/gettem?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $infodetail = json_decode($infoDetail,true);
        $this->data['infodetail'] = $infodetail;  
       
        $this->CI->template->write_view('content', 'game/banca/Events/toolbuygem/config', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function history(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/banca/Events/toolbuygem/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function historygroup(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/banca/Events/toolbuygem/historygroup', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
    public function getResponse() {
        return $this->_response;
    }
}
