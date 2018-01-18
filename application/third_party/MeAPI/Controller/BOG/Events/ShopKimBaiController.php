<?php

class MeAPI_Controller_BOG_Events_ShopKimBaiController implements MeAPI_Controller_BOG_Events_ShopKimBaiInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/bog/cms/toolshopkimbai/";

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
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function giaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/giaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themgiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/themgiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function chinhsuagiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/chinhsuagiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }   

    public function quanlyqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    } 
    
    public function themqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function chinhsuaqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/chinhsuaqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function quanlygoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/quanlygoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function themgoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/themgoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function chinhsuagoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/chinhsuagoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function thongke(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/thongke', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function lichsu(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/ShopKimBai/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //Process
    public function add_gift(MeAPI_RequestInterface $request){
       $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png"; 
        
        if(isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])){
            if($_FILES['gift_img']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }
            else{                
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn". $this->curlPost($_FILES['gift_img']);                  
                if(empty($gift_img)){
                    $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png";
                }
            }
        }
        
        $array = array(
            'item_id'=>$_POST["item_id"],
            'gift_name'=>$_POST["gift_name"],                                       
            'gift_price'=>$_POST["gift_price"],
            'server_list'=>$_POST["server_list"],
            'gift_quantity'=>$_POST["gift_quantity"],
            'gift_type'=>$_POST["gift_type"], 
            'gift_send_type'=>$_POST["gift_send_type"], 
            'gift_img'=>$gift_img, 
            'gift_buy_max'=>$_POST["gift_buy_max"], 
            'gift_status'=>$_POST["gift_status"]);          
        
        $rsjson = $this->_call($array, "add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }
    
    public function edit_gift(MeAPI_RequestInterface $request){
       $gift_img = $_POST["gift_img_text"]; 
        
        if(isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])){
            if($_FILES['gift_img']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }
            else{                
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn". $this->curlPost($_FILES['gift_img']);                  
                if(empty($gift_img)){
                    $gift_img = $_POST["gift_img_text"];
                }
            }
        }
        
        $array = array(
            'id'=>$_POST["id"],
            'item_id'=>$_POST["item_id"],
            'gift_name'=>$_POST["gift_name"],                                       
            'gift_price'=>$_POST["gift_price"],
            'server_list'=>$_POST["server_list"],
            'gift_quantity'=>$_POST["gift_quantity"],
            'gift_type'=>$_POST["gift_type"], 
            'gift_send_type'=>$_POST["gift_send_type"], 
            'gift_img'=>$gift_img, 
            'gift_buy_max'=>$_POST["gift_buy_max"], 
            'gift_status'=>$_POST["gift_status"]);          
        
        $rsjson = $this->_call($array, "edit_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    } 
    
    public function add_gift_pakage(MeAPI_RequestInterface $request){
       $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png"; 
        
        if(isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])){
            if($_FILES['gift_img']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }
            else{                
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn". $this->curlPost($_FILES['gift_img']);                  
                if(empty($gift_img)){
                    $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png";
                }
            }
        }
        
        $array = array(
            'gift_name'=>$_POST["gift_name"],                                               
            'gift_price'=>$_POST["gift_price"],
            'gift_img'=> $gift_img,
            'gift_status'=>$_POST["gift_status"],
            'server_list'=>$_POST["server_list"], 
            'gift_buy_max'=>$_POST["gift_buy_max"],           
            'gifttype' => $_POST["gifttype"],
            'gift_date_start' =>  $_POST['startdate'],
            'gift_date_end' =>  $_POST['enddate'],  
            'gift_vip_point' =>  $_POST['gift_vip_point'],
            'gift_number_request' =>  $_POST['gift_number_request'],
            'reward_item1_code' => $_POST['reward_item1_code'],
            'reward_item1_number' => $_POST['reward_item1_number'],
            'reward_item1_type' => $_POST['reward_item1_type'],
            'reward_item2_code' => $_POST['reward_item2_code'],
            'reward_item2_number' => $_POST['reward_item2_number'],
            'reward_item2_type' => $_POST['reward_item2_type'],
            'reward_item3_code' => $_POST['reward_item3_code'],
            'reward_item3_number' => $_POST['reward_item3_number'],
            'reward_item3_type' => $_POST['reward_item3_type'],
            'reward_item4_code' => $_POST['reward_item4_code'],
            'reward_item4_number' => $_POST['reward_item4_number'],
            'reward_item4_type' => $_POST['reward_item4_type'],
            'reward_item5_code' => $_POST['reward_item5_code'],
            'reward_item5_number' => $_POST['reward_item5_number'],
            'reward_item5_type' => $_POST['reward_item5_type']
                );
        
        $rsjson = $this->_call($array, "add_gift_pakage");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }
    
    public function edit_gift_pakage(MeAPI_RequestInterface $request){
       $gift_img = $_POST["gift_img_text"]; 
        
        if(isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])){
            if($_FILES['gift_img']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }
            else{                
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn". $this->curlPost($_FILES['gift_img']);                  
                if(empty($gift_img)){
                    $gift_img = $_POST["gift_img_text"];
                }
            }
        }
        
        $array = array(
            'id'=>$_POST["id"],
            'gift_name'=>$_POST["gift_name"],                                               
            'gift_price'=>$_POST["gift_price"],
            'gift_img'=> $gift_img,
            'gift_status'=>$_POST["gift_status"],
            'server_list'=>$_POST["server_list"], 
            'gift_buy_max'=>$_POST["gift_buy_max"],           
            'gifttype' => $_POST["gifttype"],
            'gift_date_start' =>  $_POST['startdate'],
            'gift_date_end' =>  $_POST['enddate'],  
            'gift_vip_point' =>  $_POST['gift_vip_point'],
            'gift_number_request' =>  $_POST['gift_number_request'],
            'reward_item1_code' => $_POST['reward_item1_code'],
            'reward_item1_number' => $_POST['reward_item1_number'],
            'reward_item1_type' => $_POST['reward_item1_type'],
            'reward_item2_code' => $_POST['reward_item2_code'],
            'reward_item2_number' => $_POST['reward_item2_number'],
            'reward_item2_type' => $_POST['reward_item2_type'],
            'reward_item3_code' => $_POST['reward_item3_code'],
            'reward_item3_number' => $_POST['reward_item3_number'],
            'reward_item3_type' => $_POST['reward_item3_type'],
            'reward_item4_code' => $_POST['reward_item4_code'],
            'reward_item4_number' => $_POST['reward_item4_number'],
            'reward_item4_type' => $_POST['reward_item4_type'],
            'reward_item5_code' => $_POST['reward_item5_code'],
            'reward_item5_number' => $_POST['reward_item5_number'],
            'reward_item5_type' => $_POST['reward_item5_type']   
                );
        
        $rsjson = $this->_call($array, "edit_gift_pakage");
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
