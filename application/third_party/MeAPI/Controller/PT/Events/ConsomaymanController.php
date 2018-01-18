<?php

class MeAPI_Controller_PT_Events_ConsomaymanController implements MeAPI_Controller_PT_Events_ConsomaymanInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;
	const TABLE_DOMAIN = "share_facebook_game";

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    //private $url_process = "http://game.mobo.vn/hiepkhach/cms/tichluy/";
    private $url_process = "http://local.service.phongthan.mobo.vn/cms/qualevel/";
    //private $url_link = "http://game.mobo.vn/phongthan";
    public $url_link = "http://game.mobo.vn/phongthan";
	public $jsonrule = array("minvip"=>"Min Vip","maxvip"=>"Max Vip");
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
        $this->CI->load->MeAPI_Model('SocialmeModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
        $this->data['url'] = $this->url_link;
		
		
		$this->data['jsonrule'] = $this->jsonrule;
		$getlistgame = $this->CI->SocialmeModel->getlistgame();
		$this->data['listgame'] = $getlistgame;
    }
    public function index(MeAPI_RequestInterface $request) {
		$this->authorize->validateAuthorizeRequest($request, 0);   
		$getlistgame = $this->CI->SocialmeModel->getlistgame();
		$this->data['listgame'] = $getlistgame;
        $this->CI->template->write_view('content', 'game/pt/Events/consomayman/index', $this->data);
		$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function themconfig(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        
		
		$ids = $request->input_get('ids');
		if(isset($ids) && !empty($ids)){
			$linkdetail = $this->url_link.'/cms/consomayman/getDetailConfig?ids='.$ids;
			$infoDetail = file_get_contents($linkdetail);
			$datainfojson = json_decode($infoDetail,true);
			
		}
		$this->data['detail'] = $datainfojson;
        $this->CI->template->write_view('content', 'game/pt/Events/consomayman/themconfig', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function importLotteryResult(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/pt/Events/consomayman/update_result', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function history(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/pt/Events/consomayman/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function displayLotteryResult(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/pt/Events/consomayman/listresult', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
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

    //Function
    public function getResponse() {
        return $this->_response;
    }
    
}
