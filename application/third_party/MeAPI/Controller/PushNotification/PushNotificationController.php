<?php

class MeAPI_Controller_PushNotification_PushNotificationController implements MeAPI_Controller_PushNotification_PushNotificationInterface {

    protected $_response;
    private $CI;
    private $url_service;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->MeAPI_Model('ReportModel');
        $this->CI->load->MeAPI_Model('ProjectsModel');
        $this->CI->load->MeAPI_Model('PushModel');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
        $this->url_service = 'https://webpush.mobo.vn';
        $this->data['url_service'] = $this->url_service;
    }

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']) {
            case 'safari':
                $this->data['title'] = 'DANH SÁCH PUSH SAFARI';
            case 'chrome':
                $this->data['title'] = 'DANH SÁCH PUSH CHROME';
                break;
            case 'createsite':
                $this->data['title'] = 'DANH SÁCH SITE';
                break;
            case 'pushios':
                $this->data['title'] = 'DANH SÁCH ADD CATEGORY';
                break;
        }
        $this->CI->template->write_view('content', 'pushnotification/' . $_GET['view'] . '/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']) {
            case 'safari':
                $this->data['title'] = 'THÊM PUSH SAFARI';
                break;
            case 'chrome':
                $this->data['title'] = 'THÊM PUSH CHROME';
                break;
            case 'createsite':
                $this->data['title'] = 'THÊM SITE';
                break;
            case 'pushios':
//                $slbScopes = $this->CI->ReportModel->listScopes();
                $slbScopes = $this->CI->ProjectsModel->getProjectsList();
                $this->data['slbScopes'] = $slbScopes;
                break;
        }
        $linkSlbDomain = $this->url_service . '/api/domain';
        $slbDomain = json_decode(file_get_contents($linkSlbDomain), true);
        $this->data['slbDomain'] = $slbDomain;
        //echo "<pre>";print_r($slbDomain);die();
        $this->CI->template->write_view('content', 'pushnotification/' . $_GET['view'] . '/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']) {
            case 'safari':
                $this->data['title'] = 'SỬA PUSH SAFARI';
                break;
            case 'chrome':
                $this->data['title'] = 'SỬA PUSH CHROME';
                break;
            case 'pushios':
//                $slbScopes = $this->CI->ReportModel->listScopes();
                $gameId = $_GET['game'];
                $slbScopes = $this->CI->ProjectsModel->getProjectsByKeyApp($gameId);
                $items = $getAllCategoris = $this->CI->PushModel->getDetailCategoris($id);
                $this->data['items'] = $items;
                $this->data['slbScopes'] = $slbScopes;
                break;
        }
        $linkSlbDomain = $this->url_service . '/api/domain';
        $slbDomain = json_decode(file_get_contents($linkSlbDomain), true);

//        $linkinfo = $this->url_service.'/ToolchoiKOKnhanKNB/get_'.$_GET['view'].'?id='.$id;
//        $infoDetail = file_get_contents($linkinfo);
//        $items = json_decode($infoDetail,true);


        $this->data['slbDomain'] = $slbDomain;
        //echo "<pre>";print_r($slbDomain);die();
        $this->CI->template->write_view('content', 'pushnotification/' . $_GET['view'] . '/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function get_package_name() {
        $id_projects = $_POST["id_projects"];
        $platform = $_POST["platform"];
        $package_detail = $this->CI->ProjectsModel->getpackagename($id_projects, $platform);
        for ($i = 0; $i < count($package_detail); $i++) {
            $package_array[$i] = $package_detail[$i]["package_name"];
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $package_array);
    }

    public function get_push_notication() {
        $getAllCategoris = $this->CI->PushModel->getAllCategoris();
        for ($i = 0; $i < count($getAllCategoris); $i++) {
            if ((@in_array($getAllCategoris[$i]["game"], $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1) {
                $getAllCategoris_permission[$i] = $getAllCategoris[$i];
            }
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $getAllCategoris_permission);
    }

    public function updateCategory() {
        $id = $_GET['id'];
        $updateCategory = $this->CI->PushModel->editFinish(array('platform'=>$_POST['platform'], 'packageName'=>$_POST['package_name'], 'message' => $_POST['message']), array('id'=>$_GET['id']));
        $this->_response = new MeAPI_Response_HTMLResponse($request, $updateCategory);
    }

    public function getResponse() {
        return $this->_response;
    }

}
