<?php
class MeAPI_Controller_MOBA_Events_TopeventController implements MeAPI_Controller_MOBA_Events_TopeventInterface {
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
        $this->CI->load->MeAPI_Model('Game/MoBa/TopEventModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.moba.mobo.vn/moba';
        }else{
            $this->url_service = 'http://game.mobo.vn/moba';
        }
        $this->data['url_service']=$this->url_service;
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'events':
                $this->data['title']= 'DANH SÁCH SỰ KIỆN';
            break;
            case 'filters':
                $this->data['title']= 'DANH SÁCH SERVER';
                $listItem = $this->CI->TopEventModel->listItems();
                $this->data['listItem'] = $listItem;
            break;
        }
        $this->CI->template->write_view('content', 'game/moba/Events/top_event/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'events':
                $this->data['title']= 'THÊM SỰ KIỆN';
            break;
            case 'filters':
                $this->data['title']= 'THÊM SERVER';
				if(isset($_POST['submit'])){
					$this->CI->TopEventModel->saveItem($_POST);
					redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
				}
            break;
        }
        $this->CI->template->write_view('content', 'game/moba/Events/top_event/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'events':
                $this->data['title']= 'SỬA SỰ KIỆN';
				$linkinfo = $this->url_service.'/cms/top_event/get_'.$_GET['view'].'?id='.$id;
				$infoDetail = file_get_contents($linkinfo);
				$items = json_decode($infoDetail,true);
				$this->data['items'] = $items; 
            break;
            case 'filters':
                $this->data['title']= 'SỬA SERVER';
				$items = $this->CI->TopEventModel->getItems($_GET['serverid']);
                $this->data['items'] = $items[0];
				if(isset($_POST['submit'])){
					$_POST['serverid'] = $_GET['serverid'];
					$this->CI->TopEventModel->saveItem($_POST);
					$items = $this->CI->TopEventModel->getItems($_GET['serverid']);
					$this->data['items'] = $items[0];
					$this->data['messg'] = 'Cập nhật thành công'; 
				}
            break;
        }
        $this->CI->template->write_view('content', 'game/moba/Events/top_event/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $linkInfo = $this->url_service.'/cms/top_event/delete_'.$_GET['view'].'?id='.$_GET['id'];
        $j_items = file_get_contents($linkInfo);
		redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all');  
    }
    
    public function getResponse() {
        return $this->_response;
    }
}