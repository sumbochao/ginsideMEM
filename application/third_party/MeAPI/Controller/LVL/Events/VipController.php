<?php

class MeAPI_Controller_LVL_Events_VipController implements MeAPI_Controller_LVL_Events_VipInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/volam/cms/toolvip/";

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
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/giaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/themgiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/chinhsuagiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function quanlyqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function quanlygoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/quanlygoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/themgoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/chinhsuagoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function lichsu(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
     public function chinhsuaqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/vip/chinhsuaqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //Process
    public function add_vip_gift(MeAPI_RequestInterface $request) {
        $picture = 'http://ginside.mobo.vn/assets/img/no-image.png';
        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $picture = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);
            }
        }

        $array = array(            
            'pakage_id' => $_POST["vip_gift_pakage"],
            'gift_name' => $_POST["gift_name"],
            'item_id' => $_POST["item_id"],
            'gift_quantity' => $_POST["gift_quantity"],
            'gift_status' => $_POST["gift_status"],
            'gift_img' => $picture);
        
        $rsjson = $this->_call($array, "add_vip_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }
    
    public function edit_vip_gift(MeAPI_RequestInterface $request) {
        $picture = $_POST["gift_img_text"];
        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $picture = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);
                
                if (empty($picture)) {
                    $picture = $_POST["gift_img_text"];
                }
            }
        }

        $array = array(
            'id' => $_POST["id"],                 
            'pakage_id' => $_POST["vip_gift_pakage"],
            'gift_name' => $_POST["gift_name"],
            'item_id' => $_POST["item_id"],
            'gift_quantity' => $_POST["gift_quantity"],
            'gift_status' => $_POST["gift_status"],
            'gift_img' => $picture);
        
        $rsjson = $this->_call($array, "edit_vip_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function edit_reward_details(MeAPI_RequestInterface $request) {
        $picture = $_POST["gift_img_text"];
        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $picture = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);

//                $result["result"] = -1;
//                $result["message"] = $picture;
//                $result = json_encode($result);
//                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//                return;

                if (empty($picture)) {
                    $picture = $_POST["gift_img_text"];
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
            'reward_item6_code' => $_POST["reward_item6_code"],
            'reward_item6_number' => $_POST["reward_item6_number"],
            'reward_item7_code' => $_POST["reward_item7_code"],
            'reward_item7_number' => $_POST["reward_item7_number"],
            'reward_item8_code' => $_POST["reward_item8_code"],
            'reward_item8_number' => $_POST["reward_item8_number"],
            'reward_item9_code' => $_POST["reward_item9_code"],
            'reward_item9_number' => $_POST["reward_item9_number"],
            'reward_item10_code' => $_POST["reward_item10_code"],
            'reward_item10_number' => $_POST["reward_item10_number"],
            'reward_status' => $_POST["reward_status"],
            'reward_vip_count' => $_POST["reward_vip_count"],
            'gift_img' => $picture);

//                $result["result"] = -1;
//                $result["message"] = json_encode($array);
//                $result = json_encode($result);
//                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
//                return;
        //$result = file_get_contents($this->url_process."edit_tournament_details?data=".json_encode($array));      
        $result = $this->curlPostAPI($array, $this->url_process . "edit_reward_details");

        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
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
