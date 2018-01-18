<?php

class MeAPI_Controller_EDEN_Events_LoanDauVoDaiController implements MeAPI_Controller_EDEN_Events_LoanDauVoDaiInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://service.eden.mobo.vn/cms/toolloandauvodai/";
    private $server_merge = array("1", "2", "3");
    private $server_merge2 = array("4", "5", "6");
    
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

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
    }
    
    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    } 
    
    public function logxephang(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function lognhanqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/lognhanqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
   
    public function logthamgia(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logthamgia', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function getResponse() {
        return $this->_response;
    }
    
    //Process 
    public function get_sv_filters(MeAPI_RequestInterface $request){
        $sv_filters = $this->call_api_get($this->url_process."get_sv_filters");     
        $this->_response = new MeAPI_Response_HTMLResponse($request, $sv_filters); 
    }    
    
     public function edit_sv_filters(MeAPI_RequestInterface $request){      
        $array = array(
                       id => $_POST['id'],
                       start => $_POST['tournament_date_start'],
                       end => $_POST["tournament_date_end"],                     
                       status => $_POST["tournament_status"],
                     );
        
        $result = $this->curlPostAPI($array, $this->url_process."edit_sv_filters");             
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    } 
    
    public function get_server_list(MeAPI_RequestInterface $request){
        //Load Server List        
        $server_list_filter = array();
        $api_url = "http://gapi.mobo.vn/?control=game&func=get_server_list&service_id=103&service_name=eden&app=eden&token=65b3443189be4ce7580f15d83b4c9014";
        $api_result = json_decode($this->call_api_get($api_url), true);

        if ($api_result["desc"] == "GET_INFO_SUCCESS") {
            foreach ($api_result["data"]["data"] as $key => $value) {
                array_push($server_list_filter, Array("server_id" => $value["server_id"], "server_name" => $value["server_name"]));
            }
        }       
        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($server_list_filter)); 
    }
    
    public function get_top_100(MeAPI_RequestInterface $request){
        $server_id = $_GET["server_id"];
        
        $server_id_merge = $server_id;
        if (in_array($server_id, $this->server_merge)) {
            $server_id_merge = 1;
        }
        
        if (in_array($server_id, $this->server_merge2)) {
            $server_id_merge = 4;
        }
       
        $api_url = "http://service.eden.mobo.vn/cms/toolloandauvodai/get_top100?server_id=".$server_id_merge;        
        $api_result = json_decode($this->call_api_get($api_url), true);  
        
        $html = '<tr><th style="text-align: center;">Hạng</th><th style="text-align: center;">Nhân vật</th><th style="text-align: center;">Server</th><th style="text-align: center;">Tổng Điểm</th><th style="text-align: center;">Trận Thắng</th></tr>';
        
         foreach ($api_result as $key => $value) { 
             $html .= '<tr><td style="text-align: center;">'.$value["RANK"].'</td><td style="text-align: center;">'.$value["RoleName"].'</td><td style="text-align: center;">'.$value["ServerID"].'</td><td style="text-align: center;">'.$value["TotalPoint"].'</td><td style="text-align: center;">'.$value["TotalWincount"].'</td></tr>';
         }
        
        //var_dump($api_result); die;
                
        $this->_response = new MeAPI_Response_HTMLResponse($request, $html); 
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
