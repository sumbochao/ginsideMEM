<?php

class MeAPI_Controller_MT_Events_TuHaiHuynhDeController implements MeAPI_Controller_MT_Events_TuHaiHuynhDeInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/mathan/cms/tooltuhaihuynhde/";

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
        $this->CI->template->write_view('content', 'game/mt/Events/TuHaiHuynhDe/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mt/Events/TuHaiHuynhDe/giaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mt/Events/TuHaiHuynhDe/themgiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mt/Events/TuHaiHuynhDe/chinhsuagiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function lichsu(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mt/Events/TuHaiHuynhDe/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function quanlyqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mt/Events/TuHaiHuynhDe/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mt/Events/TuHaiHuynhDe/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
     public function chinhsuaqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mt/Events/TuHaiHuynhDe/chinhsuaqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //Process
    public function add_tuhaihuynhde_gift(MeAPI_RequestInterface $request) {

        $total_gift_item = sizeof($_POST['item_name']);
        $array_items = [];
        for ($i = 0; $i< $total_gift_item ; $i++) {
            $item['item_id']=$_POST["item_id"][$i];
            $item['item_name']=$_POST["item_name"][$i];
            $item['count']=$_POST["item_quantity"][$i];
            $picture = 'http://ginside.mobo.vn/assets/img/no-image.png';
            if (isset($_FILES['gift_img']['tmp_name'][$i]) && !empty($_FILES['gift_img']['tmp_name'][$i])) {
                if ($_FILES['gift_img']['size'][$i] > 716800) {
                    $result["result"] = -1;
                    $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                    $result = json_encode($result);
                    $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                    return;
                } else {
                    $_FILES['gift_img']['encodefile'][$i] = $this->data_uri($_FILES['gift_img']['tmp_name'][$i], $_FILES['gift_img']['type'][$i]);
                    $NewFiles['gift_img']['name'] = $_FILES['gift_img']['name'][$i];
                    $NewFiles['gift_img']['type'] = $_FILES['gift_img']['type'][$i];
                    $NewFiles['gift_img']['tmp_name'] = $_FILES['gift_img']['tmp_name'][$i];
                    $NewFiles['gift_img']['error'] = $_FILES['gift_img']['error'][$i];
                    $NewFiles['gift_img']['size'] = $_FILES['gift_img']['size'][$i];
                    $picture = "http://m-app.mobo.vn" . $this->curlPost($NewFiles['gift_img']);
                }
            }
            $item['image']=$picture;
            array_push($array_items, $item);
        }
        $json_item = json_encode($array_items);

        $array = array(  
            'tournament' => $_POST["tournament"],
            'json_item' => $json_item,
            'conditions_receiving_gifts' => $_POST["conditions_receiving_gifts"]);
        
        $rsjson = $this->_call($array, "add_tuhaihuynhde_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }
    
    public function edit_tuhaihuynhde_gift(MeAPI_RequestInterface $request) {
        $total_gift_item = sizeof($_POST['item_name']);
        $array_items = [];
        for ($i = 0; $i< $total_gift_item ; $i++) {
            $item['item_id']=$_POST["item_id"][$i];
            $item['item_name']=$_POST["item_name"][$i];
            $item['count']=$_POST["item_quantity"][$i];
            $picture = $_POST["item_img_text"][$i];
            if (isset($_FILES['item_img']['tmp_name'][$i]) && !empty($_FILES['item_img']['tmp_name'][$i])) {
                if ($_FILES['item_img']['size'][$i] > 716800) {
                    $result["result"] = -1;
                    $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                    $result = json_encode($result);
                    $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                    return;
                } else {
                    $_FILES['item_img']['encodefile'][$i] = $this->data_uri($_FILES['item_img']['tmp_name'][$i], $_FILES['gift_img']['type'][$i]);
                    $NewFiles['gift_img']['name'] = $_FILES['item_img']['name'][$i];
                    $NewFiles['gift_img']['type'] = $_FILES['gift_img']['type'][$i];
                    $NewFiles['gift_img']['tmp_name'] = $_FILES['gift_img']['tmp_name'][$i];
                    $NewFiles['gift_img']['error'] = $_FILES['gift_img']['error'][$i];
                    $NewFiles['gift_img']['size'] = $_FILES['gift_img']['size'][$i];
                    $picture = "http://m-app.mobo.vn" . $this->curlPost($NewFiles['gift_img']);
                    if (empty($picture)) {
                        $picture = $_POST["item_img_text"];
                    }
                }
            }
            $item['image']=$picture;
            array_push($array_items, $item);
        }
        $json_item = json_encode($array_items);
        
        $array = array(
            'id' => $_POST["id"],                 
            'tournament' => $_POST["tournament"],
            'json_item' => $json_item,
            'conditions_receiving_gifts' => $_POST["conditions_receiving_gifts"]);
                
        $rsjson = $this->_call($array, "edit_tuhaihuynhde_gift");
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
