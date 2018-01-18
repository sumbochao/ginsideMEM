<?php

class MeAPI_Controller_3Q_Events_DoiQuaController implements MeAPI_Controller_3Q_Events_DoiQuaInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/3q/cms/tooldoiqua/";

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
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/giaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/themgiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/chinhsuagiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function quanlyqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themdieukien(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/themdieukien', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuaqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/chinhsuaqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function chinhsuadieukien(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/chinhsuadieukien', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function quanlygoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/quanlygoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/themgoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/chinhsuagoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function thongke(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/thongke', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function lichsu(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function dieukiendoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/3q/Events/DoiQua/dieukiendoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //Process
    public function add_gift(MeAPI_RequestInterface $request) {
        $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png";

        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);
                if (empty($gift_img)) {
                    $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png";
                }
            }
        }

        $array = array(
            'item_id' => $_POST["item_id"],
            'gift_name' => $_POST["gift_name"],
            //'gift_required_level' => $_POST["gift_required_level"],
            'gift_quantity' => $_POST["gift_quantity"],
            //'tournament_id' => $_POST["tournament"],
            'gift_send_type' => $_POST["gift_send_type"],
            'gift_img' => $gift_img,
            'gift_status' => $_POST["gift_status"],
//            'item_id_2' => $_POST['item_id_2'],
//            'gift_quantity_2' => $_POST['gift_quantity_2'],
//            'gift_send_type_2' => $_POST['gift_send_type_2'],
//            
//            'item_id_3' => $_POST['item_id_3'],
//            'gift_quantity_3' => $_POST['gift_quantity_3'],
//            'gift_send_type_3' => $_POST['gift_send_type_3'],
//            
//            'item_id_4' => $_POST['item_id_4'],
//            'gift_quantity_4' => $_POST['gift_quantity_4'],
//            'gift_send_type_4' => $_POST['gift_send_type_4'],
//            
//            'item_id_5' => $_POST['item_id_5'],
//            'gift_quantity_5' => $_POST['gift_quantity_5'],
//            'gift_send_type_5' => $_POST['gift_send_type_5'],
            'gift_server_list' => $_POST['gift_server_list'],
        );


        $rsjson = $this->_call($array, "add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function edit_gift(MeAPI_RequestInterface $request) {
        $gift_img = $_POST["gift_img_text"];

        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);
                if (empty($gift_img)) {
                    $gift_img = $_POST["gift_img_text"];
                }
            }
        }

        $array = array(
            'id' => $_POST["id"],
            'item_id' => $_POST["item_id"],
            'gift_name' => $_POST["gift_name"],
            //'gift_required_level' => $_POST["gift_required_level"],
            'gift_quantity' => $_POST["gift_quantity"],
            //'tournament_id' => $_POST["tournament"],
            'gift_send_type' => $_POST["gift_send_type"],
            'gift_img' => $gift_img,
            'gift_status' => $_POST["gift_status"],
//            'item_id_2' => $_POST['item_id_2'],
//            'gift_quantity_2' => $_POST['gift_quantity_2'],
//            'gift_send_type_2' => $_POST['gift_send_type_2'],
//            
//            'item_id_3' => $_POST['item_id_3'],
//            'gift_quantity_3' => $_POST['gift_quantity_3'],
//            'gift_send_type_3' => $_POST['gift_send_type_3'],
//            
//            'item_id_4' => $_POST['item_id_4'],
//            'gift_quantity_4' => $_POST['gift_quantity_4'],
//            'gift_send_type_4' => $_POST['gift_send_type_4'],
//            
//            'item_id_5' => $_POST['item_id_5'],
//            'gift_quantity_5' => $_POST['gift_quantity_5'],
//            'gift_send_type_5' => $_POST['gift_send_type_5'],
            'gift_server_list' => $_POST['gift_server_list']);

        $rsjson = $this->_call($array, "edit_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function add_gift_condition(MeAPI_RequestInterface $request) {
        $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png";

        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);
                if (empty($gift_img)) {
                    $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png";
                }
            }
        }

        $array = array(
            'item_id' => $_POST["item_id"],
            'gift_quantity' => $_POST["gift_quantity"],
            'gift_name' => $_POST["gift_name"],
            'gift_img' => $gift_img,
            'gift_status' => $_POST["gift_status"],
            'gift_send_type' => $_POST["gift_send_type"],
            'gift_id' => $_POST["gift_id"]
        );

        $rsjson = $this->_call($array, "add_gift_condition");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function edit_gift_condition(MeAPI_RequestInterface $request) {
        $gift_img = $_POST["gift_img_text"];

        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);
                if (empty($gift_img)) {
                    $gift_img = $_POST["gift_img_text"];
                }
            }
        }
        
        $array = array(
            'id' => $_POST["id"],
            'item_id' => $_POST["item_id"],
            'gift_quantity' => $_POST["gift_quantity"],
            'gift_name' => $_POST["gift_name"],
            'gift_img' => $gift_img,
            'gift_status' => $_POST["gift_status"],
            'gift_send_type' => $_POST["gift_send_type"],
            'gift_id' => $_POST["gift_id"]
        );

        $rsjson = $this->_call($array, "edit_gift_condition");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    //Function
    protected function _call($params, $function_name) {
        set_time_limit(120);
        $last_link_request = $this->url_process . $function_name . "/?" . http_build_query($params);
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

    public function curlPost($params, $link = '') {
        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        if ($result) {
            $result = json_decode($result, true);
            if ($result['code'] == 0) {
                $result = $result['data'];
            }
        }
        return $result;
    }

    public function curlPostAPI($params, $link = '') {
        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        return $result;
    }

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
