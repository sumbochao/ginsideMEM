<?php

class MeAPI_Controller_PT_Events_DaucolvController implements MeAPI_Controller_PT_Events_DaucolvInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/phongthan/cms/tooldaucolv/";
    
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
        //get config event
        $config = $this->curlPostAPI(array(), $this->url_process."config");
        $this->data['dclv_config'] = json_decode($config) ;
		
		//echo '<pre>';print_r( $this->data['dclv_config'] );die;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/DauCoLV/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function getResponse() {
        return $this->_response;
    }

    public function quanlyqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/DauCoLV/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        //edit
        if(isset($_GET['level']))
            $this->data['level'] = $_GET['level'];
        if(isset($_GET['vang']))
            $this->data['vang'] = $_GET['vang'];
        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/DauCoLV/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function add_gift(MeAPI_RequestInterface $request){
        $post = array(
            'level' => $_POST['level'],
            'vang' => $_POST['vang'],
        );

        if(!empty($_POST['id']))
            $post['id'] = $_POST['id'];

        $result = $this->curlPostAPI($post, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }


    public function lichsu(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/DauCoLV/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

	
	 public function log_nap_tien(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/DauCoLV/log_nap_tien', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	
	 public function config_event(MeAPI_RequestInterface $request){
        $result = $this->curlPostAPI(array('status' => $_POST['status']), $this->url_process."config_event");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
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
