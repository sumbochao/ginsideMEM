<?php

class MeAPI_Controller_MGH2_Events_TichLuyController implements MeAPI_Controller_MGH2_Events_TichLuyInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/mgh2/cms/tooltichluy/";
    protected $secret_key = "qgvQ^cD#h68_h9_Hu9+";

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
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/giaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/themgiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/chinhsuagiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //Tournament TotalDate
    public function giaidau_totaldate(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/giaidau_totaldate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgiaidau_totaldate(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/themgiaidau_totaldate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagiaidau_totaldate(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/chinhsuagiaidau_totaldate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaithuong(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/giaithuong', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaithuongtop(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/giaithuongtop', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaithuongpremiership(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/giaithuongpremiership', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function thongke(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/thongke', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function lichsu(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function sendnl(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/sendnl', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function lichsu_sendnl(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh2/Events/TichLuy/lichsu_sendnl', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //Process
    public function edit_reward_details(MeAPI_RequestInterface $request) {
        $picture = $_POST["reward_img_text"];
        if (isset($_FILES['reward_img']['tmp_name']) && !empty($_FILES['reward_img']['tmp_name'])) {
            if ($_FILES['reward_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['reward_img']['encodefile'] = $this->data_uri($_FILES['reward_img']['tmp_name'], $_FILES['reward_img']['type']);
                $picture = "http://m-app.mobo.vn" . $this->curlPost($_FILES['reward_img']);

//                $result["result"] = -1;
//                $result["message"] = $picture;
//                $result = json_encode($result);
//                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//                return;

                if (empty($picture)) {
                    $picture = $_POST["reward_img_text"];
                }
            }
        }

        $array = array(
            'id' => $_POST["id"],
            'reward_point' => $_POST["reward_point"],
            'reward_item1_code' => $_POST["reward_item1_code"],
            'reward_item1_number' => $_POST["reward_item1_number"],
            'reward_item2_code' => $_POST["reward_item2_code"],
            'reward_item2_number' => $_POST["reward_item2_number"],
            'reward_item3_code' => $_POST["reward_item3_code"],
            'reward_item3_number' => $_POST["reward_item3_number"],
            'reward_item4_code' => $_POST["reward_item4_code"],
            'reward_item4_number' => $_POST["reward_item4_number"],
            'reward_item5_code' => $_POST["reward_item5_code"],
            'reward_item5_number' => $_POST["reward_item5_number"],
            'reward_status' => $_POST["reward_status"],
            'reward_img' => $picture);

//                $result["result"] = -1;
//                $result["message"] = json_encode($array);
//                $result = json_encode($result);
//                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//                return;
        //$result = file_get_contents($this->url_process."edit_tournament_details?data=".json_encode($array)); 
        $rsjson = $this->_call($array, "edit_reward_details");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    //Process
    public function edit_reward_details_top(MeAPI_RequestInterface $request) {
        $picture = $_POST["reward_img_text"];
        if (isset($_FILES['reward_img']['tmp_name']) && !empty($_FILES['reward_img']['tmp_name'])) {
            if ($_FILES['reward_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['reward_img']['encodefile'] = $this->data_uri($_FILES['reward_img']['tmp_name'], $_FILES['reward_img']['type']);
                $picture = "http://m-app.mobo.vn" . $this->curlPost($_FILES['reward_img']);

//                $result["result"] = -1;
//                $result["message"] = $picture;
//                $result = json_encode($result);
//                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//                return;

                if (empty($picture)) {
                    $picture = $_POST["reward_img_text"];
                }
            }
        }

        $array = array(
            'id' => $_POST["id"],
            'reward_point' => $_POST["reward_point"],
            'reward_item1_code' => $_POST["reward_item1_code"],
            'reward_item1_number' => $_POST["reward_item1_number"],
            'reward_item2_code' => $_POST["reward_item2_code"],
            'reward_item2_number' => $_POST["reward_item2_number"],
            'reward_item3_code' => $_POST["reward_item3_code"],
            'reward_item3_number' => $_POST["reward_item3_number"],
            'reward_item4_code' => $_POST["reward_item4_code"],
            'reward_item4_number' => $_POST["reward_item4_number"],
            'reward_item5_code' => $_POST["reward_item5_code"],
            'reward_item5_number' => $_POST["reward_item5_number"],
            'reward_status' => $_POST["reward_status"],
            'reward_img' => $picture);

//                $result["result"] = -1;
//                $result["message"] = json_encode($array);
//                $result = json_encode($result);
//                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//                return;
        //$result = file_get_contents($this->url_process."edit_tournament_details?data=".json_encode($array)); 
        $rsjson = $this->_call($array, "edit_reward_details_top");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function edit_reward_details_premiership(MeAPI_RequestInterface $request) {
        $picture = $_POST["reward_img_text"];
        if (isset($_FILES['reward_img']['tmp_name']) && !empty($_FILES['reward_img']['tmp_name'])) {
            if ($_FILES['reward_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['reward_img']['encodefile'] = $this->data_uri($_FILES['reward_img']['tmp_name'], $_FILES['reward_img']['type']);
                $picture = "http://m-app.mobo.vn" . $this->curlPost($_FILES['reward_img']);

//                $result["result"] = -1;
//                $result["message"] = $picture;
//                $result = json_encode($result);
//                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//                return;

                if (empty($picture)) {
                    $picture = $_POST["reward_img_text"];
                }
            }
        }

        $array = array(
            'id' => $_POST["id"],
            'reward_point' => $_POST["reward_point"],
            'reward_item1_code' => $_POST["reward_item1_code"],
            'reward_item1_number' => $_POST["reward_item1_number"],
            'reward_item2_code' => $_POST["reward_item2_code"],
            'reward_item2_number' => $_POST["reward_item2_number"],
            'reward_item3_code' => $_POST["reward_item3_code"],
            'reward_item3_number' => $_POST["reward_item3_number"],
            'reward_item4_code' => $_POST["reward_item4_code"],
            'reward_item4_number' => $_POST["reward_item4_number"],
            'reward_item5_code' => $_POST["reward_item5_code"],
            'reward_item5_number' => $_POST["reward_item5_number"],
            'reward_status' => $_POST["reward_status"],
            'reward_img' => $picture);

//                $result["result"] = -1;
//                $result["message"] = json_encode($array);
//                $result = json_encode($result);
//                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//                return;
        //$result = file_get_contents($this->url_process."edit_tournament_details?data=".json_encode($array)); 
        $rsjson = $this->_call($array, "edit_reward_details_premiership");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function send_nl(MeAPI_RequestInterface $request) {       
        $token = md5($_POST["email"] . $_POST["nl_count"] . $_POST["mobo_service_id"] . $_POST["send_note"] . $this->secret_key);

//        $result["result"] = -1;
//        $result["message"] = var_dump($_POST);
//        $result = json_encode($result);
//        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//        return;

        $array = array(
            'email' => $_POST["email"],
            'nl_count' => $_POST["nl_count"],
            'mobo_service_id' => $_POST["mobo_service_id"],
            'send_note' => $_POST["send_note"],
            'token' => $token);

        $rsjson = $this->_call($array, "send_nl");
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
