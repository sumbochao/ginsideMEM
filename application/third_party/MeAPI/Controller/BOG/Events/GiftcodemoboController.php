<?php
class MeAPI_Controller_BOG_Events_GiftcodemoboController implements MeAPI_Controller_BOG_Events_GiftcodemoboInterface {
    protected $_response;
    private $CI;
    private $url_service;
	private $url_process = "http://game.mobo.vn/bog/cms/giftcodemobo/";
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
		$this->CI->load->library('Quick_CSV_import');
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
	
	public function export(MeAPI_RequestInterface $request){
		$result = $this->curlPostAPI($_POST, $this->url_process."export");
        $objExcel = new Quick_CSV_import();
        $header =  array('MSI', 'SERVER_ID','GIFTCODE','INSERT_DATE','EVENT_NAME','TYPEGC','JSONLOG','STATUS');
        $objExcel->export($header,$result, array('4' => ''));
    }
	
	public function curlPostAPI($params,$link=''){
        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
        $this->last_link_request = empty($link)?$this->api_m_app."returnpathimg":$link;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        return $result;
    }
	
	
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
         $this->data['title']= 'DANH SÁCH CẤU HÌNH';
        $this->CI->template->write_view('content', 'game/bog/Events/giftcodemobo/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->data['title']= 'THÊM CẤU HÌNH';
        $this->authorize->validateAuthorizeRequest($request, 0);     
        $this->CI->template->write_view('content', 'game/bog/Events/giftcodemobo/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'SỬA CẤU HÌNH';
        $id = $_GET['id'];
        $linkinfo = $this->url_service.'/cms/giftcodemobo/gettem?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        
        $this->CI->template->write_view('content', 'game/bog/Events/giftcodemobo/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/giftcodemobo/delete?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index#item');      
    }
	public function history(MeAPI_RequestInterface $request) {
        $this->data['title']= 'HISTORY';
        $this->authorize->validateAuthorizeRequest($request, 0);     
        $this->CI->template->write_view('content', 'game/bog/Events/giftcodemobo/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());     
    }
    public function getResponse() {
        return $this->_response;
    }
}