<?php

class MeAPI_Controller_LG_MHK_Events_NapTheNhanLaiTheController implements MeAPI_Controller_HERO_Events_NapLienTucInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
//    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "https://mong.langgame.net/cms/toolnapthenhanlaithe/";

    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');

        //$this->CI->load->MeAPI_Model('ReportModel');
        //$this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/giaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/themgiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/chinhsuagiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function quanlyqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuaqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/chinhsuaqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function lichsu(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function lichsunhanlaithe(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lg/MHK/Events/NapTheNhanLaiThe/lichsunhanlaithe', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //Process
    public function add_gift(MeAPI_RequestInterface $request) {
        $total_gift_item = sizeof($_POST['item_id']);
        $array_items = [];
        for ($i = 0; $i < $total_gift_item; $i++) {
            $item['item_id'] = $_POST["item_id"][$i];
            $item['count'] = $_POST["count"][$i];
            array_push($array_items, $item);
        }
        $json_item = json_encode($array_items);
        $array = array(
            'item_name' => $_POST["item_name"],
            'condition_date_send' => $_POST["condition_date_send"],
            'tournament_id' => $_POST["tournament"],
            'status' => $_POST["gift_status"],
            'json_item' => $json_item
        );

        $rsjson = $this->_call($array, "add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function edit_gift(MeAPI_RequestInterface $request) {

        $total_gift_item = sizeof($_POST['item_id']);
        $array_items = [];
        for ($i = 0; $i < $total_gift_item; $i++) {
            $item['item_id'] = $_POST["item_id"][$i];
            $item['count'] = $_POST["count"][$i];
            array_push($array_items, $item);
        }
        $json_item = json_encode($array_items);
        $array = array(
            'id' => $_POST["id"],
            'item_name' => $_POST["item_name"],
            'condition_date_send' => $_POST["condition_date_send"],
            'tournament_id' => $_POST["tournament"],
            'status' => $_POST["gift_status"],
            'json_item' => $json_item
        );

        $rsjson = $this->_call($array, "edit_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    //Function
    protected function _call($params, $function_name) {
        set_time_limit(120);
        $last_link_request = $this->url_process . $function_name . "/?" . http_build_query($params);
//        var_dump($last_link_request);die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $result = curl_exec($ch);
        return $result;
    }

    public function getResponse() {
        return $this->_response;
    }

    function data_uri($file, $mime = 'image/jpeg') {
        if (empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
//
//    public function curlPost($params, $link = '') {
//        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POST, count($params));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
//        $result = curl_exec($ch);
//        if ($result) {
//            $result = json_decode($result, true);
//            if ($result['code'] == 0) {
//                $result = $result['data'];
//            }
//        }
//        return $result;
//    }
//
//    public function curlPostAPI($params, $link = '') {
//        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
//        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POST, count($params));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
//        $result = curl_exec($ch);
//        return $result;
//    }

    // Function to get the client IP address
    private function call_api_get($api_url) {
        set_time_limit(30);
        $urlrequest = $api_url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlrequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $result = curl_exec($ch);
        $err_msg = "";

        if ($result === false)
            $err_msg = curl_error($ch);

        //var_dump($result);
        //die;
        curl_close($ch);
        return $result;
    }

}
