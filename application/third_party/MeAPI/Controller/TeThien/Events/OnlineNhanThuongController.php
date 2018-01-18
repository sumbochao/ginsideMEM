<?php

class MeAPI_Controller_TeThien_Events_OnlineNhanThuongController implements MeAPI_Controller_TeThien_Events_OnlineNhanThuongInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url= "http://game.mobo.vn/tethien/cms/tool_online_nhan_thuong/";
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
        $this->data['url'] = $this->url;
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request) {
		
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/tethien/Events/OnlineNhanThuong/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function getResponse() {
        return $this->_response;
    }


    
    public function lichsu(MeAPI_RequestInterface $request){
		
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/tethien/Events/OnlineNhanThuong/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
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

}
