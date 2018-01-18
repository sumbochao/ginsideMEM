<?php

class MeAPI_Controller_PT_Events_PromotionLatOController implements MeAPI_Controller_PT_Events_PromotionLatOInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/phongthan/cms/promotion_lato/";
    
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
        $this->CI->template->write_view('content', 'game/pt/Events/LatO/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function productbox(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/LatO/productbox', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function productboxediting(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        //load info editchest
        $ids = $_GET['ids'];
        $linkinfo = 'http://game.mobo.vn/phongthan/cms/promotion_lato/boxitemdetailload?ids='.$ids;
        $infoDetail = file_get_contents($linkinfo);
        $infodetail = json_decode($infoDetail,true);

        $this->data['infodetail'] = $infodetail;      
        
        $this->CI->template->write_view('content', 'game/pt/Events/LatO/productboxediting', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function thongke(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/LatO/thongke', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function logdoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/LatO/tralogdoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function logthamgia(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/LatO/logthamgia', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function logdoiluotbangtien(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/LatO/logdoiluotbangtien', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function clearcached(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/LatO/clearcached', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function getResponse() {
        return $this->_response;
    }
    
    //Process
    public function add_new_item(MeAPI_RequestInterface $request){
        $picture = "http://ginside.mobo.vn/assets/img/no-image.png";
        if(isset($_FILES['picture']['tmp_name']) && !empty($_FILES['picture']['tmp_name'])){
            if($_FILES['picture']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";             
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));     
                return;                
            }
            else{
                $_FILES['picture']['encodefile'] = $this->data_uri($_FILES['picture']['tmp_name'], $_FILES['picture']['type']);
                $picture = "http://m-app.mobo.vn". $this->curlPost($_FILES['picture']);  
                
                if(empty($picture)){
                    $picture = "http://ginside.mobo.vn/assets/img/no-image.png";
                }
            }
        }      
        
        $array = array(
                       catstatus => $_POST['catstatus'],
                       item_name => $_POST["item_name"],
                       picture => $picture,
                       item_id => $_POST["item_id"],
                       current_rate => $_POST["current_rate"],
                       item_count => $_POST["item_count"],
                       play_count_open => $_POST["play_count_open"]);
        
        //$result["result"] = -1;
        //$result["message"] = json_encode($array);   
        //$result = json_encode($result);
        
        //$result = $this->call_api_get($this->url_process."onSubmitBox?data=".json_encode($array));  
        $result = $this->curlPostAPI($array, $this->url_process."onSubmitBox");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }    
    
    public function edit_item(MeAPI_RequestInterface $request){
        $idx = $_GET['ids'];
        $picture = $_POST["gift_img_text"];
        
        if(isset($_FILES['picture']['tmp_name']) && !empty($_FILES['picture']['tmp_name'])){
            if($_FILES['picture']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));     
                return;  
            }
            else{
                $_FILES['picture']['encodefile'] = $this->data_uri($_FILES['picture']['tmp_name'], $_FILES['picture']['type']);
                $picture = "http://m-app.mobo.vn". $this->curlPost($_FILES['picture']);  
                
                if(empty($picture)){
                    $picture = $_POST["gift_img_text"];
                }
            }
        }
        
        $array = array(
                       id => $idx,
                       catstatus => $_POST['catstatus'],
                       item_name => $_POST["item_name"],
                       picture => $picture,
                       item_id => $_POST["item_id"],
                       current_rate => $_POST["current_rate"],
                       item_count => $_POST["item_count"],
                       play_count_open => $_POST["play_count_open"]); 
        
        //$result = file_get_contents($this->url_process."onSubmitBoxEditing?data=".json_encode($array));
        $result = $this->curlPostAPI($array, $this->url_process."onSubmitBoxEditing");             
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }  
    
    public function test(MeAPI_RequestInterface $request){
        //if ($this->CI->input->post() && count($this->CI->input->post())>=1) {           
        if(isset($_FILES['picture']['tmp_name']) && !empty($_FILES['picture']['tmp_name'])) {
            if($_FILES['picture']['size'] > 716800){
                $R["result"] = -1;
                $R["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
            }
            else{
                $_FILES['picture']['encodefile'] = $this->data_uri($_FILES['picture']['tmp_name'], $_FILES['picture']['type']);
                $getpath = $this->curlPost($_FILES['picture']);                    
                //$picture = $getpath;
                
                //$R["result"] = -1;
                //$R["message"] = $picture;
            }
        }
        else{
            
        }
        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($R));
    }    
    
    //Function
    function data_uri($file, $mime='image/jpeg')
    {
        if(empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    
    public function curlPost($params,$link=''){
        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
        $this->last_link_request = empty($link)?$this->api_m_app."returnpathimg":$link;
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        if($result){
            $result = json_decode($result,true);
            if($result['code']==0){
                $result = $result['data'];
            }
        }
        return $result;
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
