<?php

class MeAPI_Controller_BOG_Events_GoiquavipController implements MeAPI_Controller_BOG_Events_GoiquavipInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/bog/cms/toolgoiquavip/";
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
		$this->CI->load->library('Quick_CSV_import');
        //$this->CI->load->MeAPI_Model('ReportModel');
        //$this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->data['url'] = $this->url_process;
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        //get config event
//        $config = $this->curlPostAPI(array(), $this->url_process."config");
//        $this->data['config'] = json_decode($config) ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/GoiQuaVip/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function getResponse() {
        return $this->_response;
    }

    public function quanlyqua(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/GoiQuaVip/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        //edit
        if(isset($_GET['name']))
            $this->data['name'] = $_GET['name'];
        /*
		if(isset($_GET['money']))
            $this->data['money'] = $_GET['money'];
		*/
        if(isset($_GET['vip']))
            $this->data['vip'] = $_GET['vip'];
        if(isset($_GET['items'])){
            $items = json_decode($_GET['items']) ;
            $this->data['items'] = json_decode($_GET['items']);
        }
        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/GoiQuaVip/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function showAddConfig(MeAPI_RequestInterface $request) {
        //gui du lieu de generate combobox package
        $this->data['packages'] = json_decode($this->curlPostAPI(array(),$this->url_process.'getPackages')) ;
        //edit
        if(isset($_GET['name']) && !empty($_GET['name']))
            $this->data['name'] = $_GET['name'];

        if(isset($_GET['ip_list']) && !empty($_GET['ip_list']))
            $this->data['ip_list'] = $_GET['ip_list'];

        if(isset($_GET['server_list']) && !empty($_GET['server_list']))
            $this->data['server_list'] = $_GET['server_list'];

        if(isset($_GET['date_start']) && !empty($_GET['date_start'])){
            $this->data['date_start'] = $_GET['date_start'];
        }
        if(isset($_GET['date_end']) && !empty($_GET['date_end'])){
            $this->data['date_end'] = $_GET['date_end'];
        }
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $this->data['status'] = $_GET['status'];
        }
        if(isset($_GET['package_id']) && !empty($_GET['package_id'])){
            $this->data['package_id_array'] = explode(',',$_GET['package_id']);
        }

        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/GoiQuaVip/addConfig', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function add_gift(MeAPI_RequestInterface $request){
        $items = array();
        $item_id_array = $_POST['item_id'];
        $item_name_array = $_POST['item_name'];
        $item_count_array = $_POST['item_count'];
        for($i = 0; $i < count($item_id_array); $i++){
            $items[] = array(
                'item_id' => $item_id_array[$i],
                'item_name' => $item_name_array[$i],
                'count' => $item_count_array[$i]
            );
        }
        $post = array(
            'name' => $_POST['name'],
            'vip' => $_POST['vip'],
            'items' => json_encode($items)
        );
        if(!empty($_POST['id']))
            $post['id'] = $_POST['id'];

        $result = $this->curlPostAPI($post, $this->url_process."add_gift");
		
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }

    public function delete_gift(MeAPI_RequestInterface $request){

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $result = $this->curlPostAPI(array('id' => $_GET['id']), $this->url_process."delete_gift");
            $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
        }


    }

    public function lichsu(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/GoiQuaVip/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function log_nap_tien(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/GoiQuaVip/log_nap_tien', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function config_event(MeAPI_RequestInterface $request){
        $result = $this->curlPostAPI($_POST, $this->url_process."config_event");
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



    public function addConfig(MeAPI_RequestInterface $request) {
       
        //print_r(http_build_query($_POST));
        //die;
        $result = $this->curlPostAPI(http_build_query($_POST), $this->url_process."addConfig");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
	
	
	public function export(MeAPI_RequestInterface $request){
        $result = $this->curlPostAPI($_POST, $this->url_process."export");
        $objExcel = new Quick_CSV_import();
        $header =  array('ID', 'CharacterID','Character name','Server ID','MSI','Gift Package','Money','Created Date');
        $objExcel->export($header,$result, array('4' => ''));
    }
}
