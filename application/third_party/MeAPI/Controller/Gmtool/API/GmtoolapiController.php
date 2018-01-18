<?php

class MeAPI_Controller_Gmtool_API_GmtoolapiController implements MeAPI_Controller_Gmtool_API_GmtoolapiInterface {

    protected $_response;
    private $CI;
    private $url_service;
    private $secretkey;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->CI->load->MeAPI_Model('PaymentModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
        $this->url_service = 'http://graph.mobo.vn/v2/?';
//        $this->secretkey = 'TWVHQDNSVXDEHVNN';
        $this->secretkey = 'TWVHQDNSVXDEHVNN';
        $this->data['url_service'] = $this->url_service;
    }

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'DANH SÁCH GM';
        $listScopes = $this->CI->PaymentModel->listScopes();
        $this->data['listScopes'] = $listScopes;
        $this->CI->template->write_view('content', 'gmtool/api/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function add(MeAPI_RequestInterface $request) {
        $this->data['title'] = 'THÊM GM SUPPORT';
        $listScopes = $this->CI->PaymentModel->listScopes();
        $this->data['listScopes'] = $listScopes;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'gmtool/api/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'SỬA CẤU HÌNH';
        $id = $_GET['id'];
        $linkinfo = $this->url_service . '/cms/giftcodemobo/gettem?id=' . $id;

//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
//        curl_setopt($ch, CURLOPT_URL, $linkinfo);
//
//        $infoDetail = curl_exec($ch);
//        curl_close($ch);


        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail, true);
        $this->data['items'] = $items;

        $this->CI->template->write_view('content', 'gmtool/api/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        $linkInfo = $this->url_service . '/cms/giftcodemobo/delete?id=' . $id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url() . '?control=' . $_GET['control'] . '&func=index#item');
    }

    public function index_icon_mobo(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'DANH SÁCH ICON MOBO';

        $listScopes = $this->CI->PaymentModel->listScopes();
        $this->data['listScopes'] = $listScopes;

        $this->CI->template->write_view('content', 'gmtool/api/indexiconmobo', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function add_icon_mobo(MeAPI_RequestInterface $request) {
        $this->data['title'] = 'THÊM ICON MOBO';
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listScopes = $this->CI->PaymentModel->listScopes();
        $this->data['listScopes'] = $listScopes;
        $this->CI->template->write_view('content', 'gmtool/api/addiconmobo', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function edit_gm_support() {
        $gm_support = $_POST['gm_support'];
        $service_id = $_POST['service_id'];
        $params = array(
            'control' => 'inside',
            'func' => 'edit_gm_support',
            'gm_support' => $gm_support,
            'service_id' => $service_id,
            'app' => 'ginside'
        );

        $token = md5(implode('', $params) . $this->secretkey);
        $edit_gm_support = $this->url_service . http_build_query($params) . '&token=' . $token;
        $infoDetail = file_get_contents($edit_gm_support);
        $results = json_decode($infoDetail, true);
//        $this->_response = new MeAPI_Response_HTMLResponse($request, $results);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $infoDetail);
//        return $results;
    }

    public function edit_init_icon_mobo() {
        $icon_mobo_floating = $_POST['icon_mobo_floating_b64'];
        $icon_mobo_unactive = $_POST['icon_mobo_unactive_b64'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $service_id = $_POST['service_id'];

        $icon_mobo_floating = $this->getlink_uri($_FILES['icon_mobo_floating'],$service_id);

        var_dump($icon_mobo_floating);
        die;

        $icon_mobo_unactive = $this->getlink_uri($_FILES['icon_mobo_unactive']);




        $params = array(
            'control' => 'inside',
            'func' => 'edit_init_icon_mobo',
            'icon_mobo_floating' => $icon_mobo_floating,
            'icon_mobo_unactive' => $icon_mobo_unactive,
            'service_id' => $service_id,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'app' => 'ginside'
        );
        if (!empty($_POST['id'])) {
            $params['id'] = $_POST['id'];
        }
//        $id = $_POST['id']?$_POST['id']:'';

        $token = md5(implode('', $params) . $this->secretkey);
        //$params['token'] = $token;


        $url = $this->url_service . 'control=inside&func=edit_init_icon_mobo&token=' . $token;

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $params);

        $infoDetail = curl_exec($handle);
        curl_close($handle);

//        $infoDetail = file_get_contents($edit_init_icon_mobo);
        $results = json_decode($infoDetail, true);
    }

    public function get_gm_support() {
        $service_id = $_POST['service_id'];
        $id = $_POST['id'] ? $_POST['id'] : '';
        $params = array(
            'control' => 'inside',
            'func' => 'get_gm_support',
            'service_id' => $service_id,
            'id' => '',
            'app' => 'ginside'
        );

        $token = md5(implode('', $params) . $this->secretkey);
        $get_gm_support = $this->url_service . http_build_query($params) . '&token=' . $token;
        $infoDetail = file_get_contents($get_gm_support);
//        $results = json_decode($infoDetail, true);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $infoDetail);
    }

    public function get_icon_mobo() {
        $service_id = $_POST['service_id'];
        $id = $_POST['id'] ? $_POST['id'] : '';
        $params = array(
            'control' => 'inside',
            'func' => 'get_icon_mobo',
            'service_id' => $service_id,
            'id' => '',
            'app' => 'ginside'
        );

        $token = md5(implode('', $params) . $this->secretkey);
        $get_icon_mobo = $this->url_service . http_build_query($params) . '&token=' . $token;
        $infoDetail = file_get_contents($get_icon_mobo);
        $results = json_decode($infoDetail, true);
    }

    function getlink_uri($file, $service_id) {
        $base64img = $this->data_uri($file['tmp_name'], $file['type']);

        /* http://graph.mobo.vn/v2/
         * ?control=inside&
         * func=uploadimage&
         * service_id=155&
         * name=filename&
         * encodefile=base64img&
         * app=ginside&
         * token=89afaf3609947953ef76cef010a4828f        
         */
        $params = array(
            'control' => 'inside',
            'func' => 'uploadimage',
            'service_id' => $service_id,
            'name' => $file['name'],
            'encodefile' => $base64img,
            'app' => 'ginside'
        );
        
        var_dump($params);die;

        $token = md5(implode('', $params) . $this->secretkey);

//        $link_img = $this->url_service . http_build_query($params) . '&token=' . $token;
        $link_img = $this->url_service . 'control=inside&func=uploadimage&token=' . $token;

        $handle = curl_init($link_img);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $params);

        $infoDetail = curl_exec($handle);
        curl_close($handle);
        
        var_dump($infoDetail);
        die;
        return $link_img;
    }

    function data_uri($file, $mime = 'image/jpeg') {
        if (empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }

    public function getResponse() {
        return $this->_response;
    }

}
