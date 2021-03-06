<?php

class MeAPI_Controller_DHT_Events_BongDaController implements MeAPI_Controller_DHT_Events_BongDaInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process;
    protected $url_service;


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
        
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $url_service = 'http://localhost.service.onepiece.mobo.vn';
        }else{
            $url_service = 'http://game.mobo.vn/onepiece';
        }
        $this->url_process = $url_service."/cms/toolbongda/";
        $this->data["url_service"] = $url_service;
        $this->view_data = new stdClass();
    }
    
    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function giaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/giaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function themgiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/themgiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function chinhsuagiaidau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/chinhsuagiaidau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function trandau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/trandau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function themtrandau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/themtrandau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function chinhsuatrandau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/chinhsuatrandau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function ketquatrandau(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/ketquatrandau', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function quanlyqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function themqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function chinhsuaqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/chinhsuaqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function lichsu(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function lichsudoiqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/lichsudoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function thongke(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/dht/Events/BongDa/thongke', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    //Process
    public function edit_tournament_details(MeAPI_RequestInterface $request){
        $picture = $_POST["tournament_img_text"];
        if(isset($_FILES['tournament_img']['tmp_name']) && !empty($_FILES['tournament_img']['tmp_name'])){
            if($_FILES['tournament_img']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB 22";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }
            else{
                $_FILES['tournament_img']['encodefile'] = $this->data_uri($_FILES['tournament_img']['tmp_name'], $_FILES['tournament_img']['type']);
                $picture = "http://m-app.mobo.vn". $this->curlPost($_FILES['tournament_img']);  
                
                //$result["result"] = -1;
                //$result["message"] = $picture;
                //$result = json_encode($result);
                //$this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                //return;
                
                if(empty($picture)){
                    $picture = $_POST["tournament_img_text"];
                }
            }
        }
        
        $array = array(
                     'id'=>$_POST["id"],         
                       'tournament_date_start'=>$_POST["tournament_date_start"],
                       'tournament_date_end'=>$_POST["tournament_date_end"],                           
                       'tournament_server_list'=>$_POST["tournament_server_list"],
                       'tournament_ip_list'=>$_POST["tournament_ip_list"],
                       'tournament_status'=>$_POST["tournament_status"],
                       'tournament_img'=>$picture);
        
        //$result = file_get_contents($this->url_process."edit_tournament_details?data=".json_encode($array));      
        $result = $this->curlPostAPI($array, $this->url_process."edit_tournament_details");
        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    } 
    
    public function add_match(MeAPI_RequestInterface $request){
        $match_team_img_a = "http://ginside.mobo.vn/assets/img/no-image.png";
        $match_team_img_b = "http://ginside.mobo.vn/assets/img/no-image.png";
        
        if(isset($_FILES['match_team_img_a']['tmp_name']) && !empty($_FILES['match_team_img_a']['tmp_name'])){
            if($_FILES['match_team_img_a']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh đội A không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }
            else{                
                $_FILES['match_team_img_a']['encodefile'] = $this->data_uri($_FILES['match_team_img_a']['tmp_name'], $_FILES['match_team_img_a']['type']);
                $match_team_img_a = "http://m-app.mobo.vn". $this->curlPost($_FILES['match_team_img_a']);                  
                if(empty($match_team_img_a)){
                    $match_team_img_a = "http://ginside.mobo.vn/assets/img/no-image.png";
                }
            }
        }
        
        if(isset($_FILES['match_team_img_b']['tmp_name']) && !empty($_FILES['match_team_img_b']['tmp_name'])){
            if($_FILES['match_team_img_b']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh đội B không được lớn hơn 700KB"; 
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));     
                return;
            }
            else{
                $_FILES['match_team_img_b']['encodefile'] = $this->data_uri($_FILES['match_team_img_b']['tmp_name'], $_FILES['match_team_img_b']['type']);
                $match_team_img_b = "http://m-app.mobo.vn". $this->curlPost($_FILES['match_team_img_b']);                  
                if(empty($match_team_img_b)){
                    $match_team_img_b = "http://ginside.mobo.vn/assets/img/no-image.png";
                } 
            }
        }
        
        $array = array(
                  'tournament_id'=>$_POST["tournament_id"],  
                  
                  'match_team_name_a'=>$_POST["match_team_name_a"],
                  'match_team_img_a'=>$match_team_img_a,                           
                  'match_team_chap_a'=>$_POST["match_team_chap_a"],
                  'match_team_win_rate_a'=>$_POST["match_team_win_rate_a"],
                  
                  'match_team_name_b'=>$_POST["match_team_name_b"],
                  'match_team_img_b'=>$match_team_img_b,                           
                  'match_team_chap_b'=>$_POST["match_team_chap_b"],
                  'match_team_win_rate_b'=>$_POST["match_team_win_rate_b"],
                  
                  'match_team_hoa'=>$_POST["match_team_hoa"],
                  'match_team_rate'=>$_POST["match_team_rate"],
            
                  'match_start_date'=>$_POST["match_start_date"],
                  'match_end_date'=>$_POST["match_end_date"],
                  'match_end_pet_date'=>$_POST["match_end_pet_date"],
                  'match_status'=>$_POST["match_status"],
                  'match_pet_max'=>$_POST["match_pet_max"],
                  
                  
            );
        
        //$result = file_get_contents($this->url_process."add_match?data=".json_encode($array)); 
        $result = $this->curlPostAPI($array, $this->url_process."add_match");        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    } 
    
    public function edit_match_details(MeAPI_RequestInterface $request){
        $match_team_img_a = $_POST["match_team_img_a_text"];
        $match_team_img_b = $_POST["match_team_img_b_text"];
        
        if(isset($_FILES['match_team_img_a']['tmp_name']) && !empty($_FILES['match_team_img_a']['tmp_name'])){
            if($_FILES['match_team_img_a']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh đội A không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));     
                return;
            }  
            else{
                $_FILES['match_team_img_a']['encodefile'] = $this->data_uri($_FILES['match_team_img_a']['tmp_name'], $_FILES['match_team_img_a']['type']);
                $match_team_img_a = "http://m-app.mobo.vn". $this->curlPost($_FILES['match_team_img_a']);                  
                if(empty($match_team_img_a)){
                    $match_team_img_a = $_POST["match_team_img_a_text"];
                }            
            }
        }       
        
        if(isset($_FILES['match_team_img_b']['tmp_name']) && !empty($_FILES['match_team_img_b']['tmp_name'])){
            if($_FILES['match_team_img_b']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh đội B không được lớn hơn 700KB"; 
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));     
                return;
            }
            else{
                $_FILES['match_team_img_b']['encodefile'] = $this->data_uri($_FILES['match_team_img_b']['tmp_name'], $_FILES['match_team_img_b']['type']);
                $match_team_img_b = "http://m-app.mobo.vn". $this->curlPost($_FILES['match_team_img_b']);                  
                if(empty($match_team_img_b)){
                    $match_team_img_b = $_POST["match_team_img_b_text"];
                }
            }
        }
        
        $array = array(
                  'id'=>$_POST["id"],  
                  'tournament_id'=>$_POST["tournament_id"],  
                  
                  'match_team_name_a'=>$_POST["match_team_name_a"],
                  'match_team_img_a'=>$match_team_img_a,                           
                  'match_team_chap_a'=>$_POST["match_team_chap_a"],
                  'match_team_win_rate_a'=>$_POST["match_team_win_rate_a"],
                  
                  'match_team_name_b'=>$_POST["match_team_name_b"],
                  'match_team_img_b'=>$match_team_img_b,                           
                  'match_team_chap_b'=>$_POST["match_team_chap_b"],
                  'match_team_win_rate_b'=>$_POST["match_team_win_rate_b"],
            
                  'match_team_hoa'=>$_POST["match_team_hoa"],
                  'match_team_rate'=>$_POST["match_team_rate"],
                  
                  'match_start_date'=>$_POST["match_start_date"],
                  'match_end_date'=>$_POST["match_end_date"],
                  'match_end_pet_date'=>$_POST["match_end_pet_date"],
                  'match_status'=>$_POST["match_status"],
                  'match_pet_max'=>$_POST["match_pet_max"]);
        
        //$result = file_get_contents($this->url_process."edit_match_details?data=".json_encode($array)); 
        $result = $this->curlPostAPI($array, $this->url_process."edit_match_details");        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    } 
    
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
            'gift_quantity'=>$_POST["gift_quantity"], 
            'gift_img'=>$gift_img, 
            'gift_type'=>$_POST["gift_type"], 
            'gift_status'=>$_POST["gift_status"]);
        
        //$result["result"] = -1;
        //$result["message"] = json_encode($array);
        //$result = json_encode($result);
        
        //$result = file_get_contents($this->url_process."add_gift?data=".json_encode($array)); 
        $result = $this->curlPostAPI($array, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    } 

    public function edit_gift_details(MeAPI_RequestInterface $request){
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
            'gift_quantity'=>$_POST["gift_quantity"], 
            'gift_img'=>$gift_img,
            'gift_type'=>$_POST["gift_type"], 
            'gift_status'=>$_POST["gift_status"]);
        
        $result = $this->curlPostAPI($array, $this->url_process."edit_gift_details");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    } 
    
    //Function
    public function getResponse() {
        return $this->_response;
    }
    
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
