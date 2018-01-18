<?php

class MeAPI_Controller_BOG_Events_TaiXiuController implements MeAPI_Controller_BOG_Events_TaiXiuInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $key = "BOG_event_TaiXiu";
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/bog/cms/tool_event_taixiu/";
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

        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();

        $this->data['url'] = $this->url_process;
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request) {

//        global $game;
//        $configs =  $this->curlPostAPI(array(), $this->url_process."config");
//        $this->data['configs'] = $configs ;
//        $_SESSION[$this->key.'configs'] = $configs;
//
//
//        $this->authorize->validateAuthorizeRequest($request, 0);
//        $this->CI->template->write_view('content', 'game/BOG/Events/TaiXiu/index', $this->data);
//        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function getResponse() {
        return $this->_response;
    }


    public function showAddConfig(MeAPI_RequestInterface $request) {
        //gui du lieu de generate combobox package
//        $this->data['packages'] = json_decode($this->curlPostAPI(array(),$this->url_process.'getPackages')) ;
//        //edit
//        if(isset($_GET['id'])){
//            $this->data['id'] = $_GET['id'];
//            $configs = json_decode($_SESSION[$this->key.'configs']) ;
//            $rs = array_filter($configs,function($p){
//                if($p->id == $_GET['id']){
//                    return $p ;
//                }
//            });
//            $this->data['config'] = array_shift($rs) ;
//        }
//
//
//        $this->authorize->validateAuthorizeRequest($request, 0);
//        $this->CI->template->write_view('content', 'game/BOG/Events/TaiXiu/addConfig', $this->data);
//        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function addConfig(MeAPI_RequestInterface $request) {

//        if(!isset($_POST['is_tester']))
//            $_POST['is_tester'] = 0;
//        $result = $this->curlPostAPI($_POST, $this->url_process."addConfig");
//        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);
    }


    public function quanlytiencuoc(MeAPI_RequestInterface $request) {
        $package =  $this->curlPostAPI(array(), $this->url_process."get_list_tiencuoc");
        $this->data['package'] = $_SESSION[$this->key.'list_tiencuoc'] = $package;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/TaiXiu/quanlytiencuoc', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function quanlyqua(MeAPI_RequestInterface $request) {
        $package =  $this->curlPostAPI(array(), $this->url_process."gift_list");
        $this->data['package'] = $_SESSION[$this->key.'package'] = $package;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/TaiXiu/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        //edit

        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];
//
        $package = json_decode($_SESSION[$this->key.'package']);
        $pack = array_filter($package,function($p){
            if($p->id == $_GET['id']){
                return $p ;
            }
        });
        $this->data['pack'] = array_shift($pack) ;



        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/TaiXiu/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function themtiencuoc(MeAPI_RequestInterface $request) {
        //edit

        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];
//
        $package = json_decode($_SESSION[$this->key.'package']);
        $pack = array_filter($package,function($p){
            if($p->id == $_GET['id']){
                return $p ;
            }
        });
        $this->data['pack'] = array_shift($pack) ;


        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/TaiXiu/themtiencuoc', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function add_gift(MeAPI_RequestInterface $request){

        //cau hinh upload hinh
        $config['upload_path'] = FCPATH.'assets/img/taixiu/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->CI->load->library('upload', $config);


        $post = array(
            'server_list' => $_POST['server_list'],
            'start_time' => $_POST['start_time'],
            'end_time' => $_POST['end_time'],
        );
        $items = array();

        $files = $_FILES['image'];

        for($i = 0; $i < count($_POST['item_id']); $i++ ){
            $item = array(
                'item_id' => $_POST['item_id'][$i],
                'name' => $_POST['name'][$i],
                'price' => $_POST['price'][$i]
            );
            if(isset($files['name'][$i]) && $files['name'][$i] != ''){
                $_FILES['image']['name'] = $files['name'][$i];
                $_FILES['image']['type'] = $files['type'][$i];
                $_FILES['image']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['image']['error'] = $files['error'][$i];
                $_FILES['image']['size'] = $files['size'][$i];

                $item['image'] = $files['name'][$i];
                $this->CI->upload->do_upload('image');
            }

            $items[] = $item;
        }

        $post['items'] = json_encode($items);
        if(!empty($_POST['id'])){ //update
            $post['id'] = $_POST['id'];
        }

        $result = $this->curlPostAPI($post, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);

    }
    public function add_tiencuoc(MeAPI_RequestInterface $request){


        $post = array(
            'milestone1' => $_POST['milestone1'],
            'milestone2' => $_POST['milestone2'],
            'milestone3' => $_POST['milestone3'],
            'milestone4' => $_POST['milestone4'],
            'milestone5' => $_POST['milestone5'],
        );

        if(!empty($_POST['id'])){ //update
            $post['id'] = $_POST['id'];
        }


        $result = $this->curlPostAPI($post, $this->url_process."add_tiencuoc");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);

    }

    /*public function delete_gift(MeAPI_RequestInterface $request){

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $result = $this->curlPostAPI(array('id' => $_GET['id']), $this->url_process."delete_gift");
            $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
        }


    }*/


    public function get_log_doiqua(MeAPI_RequestInterface $request){
        $logs =  $this->curlPostAPI(array(), $this->url_process."get_log_doiqua");
        $this->data['logs'] = $logs ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/TaiXiu/logdoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function get_log_datcuoc(MeAPI_RequestInterface $request){
        $logs =  $this->curlPostAPI(array(), $this->url_process."get_log_datcuoc");
        $this->data['logs'] = $logs ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/TaiXiu/logdatcuoc', $this->data);
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


	public function export(MeAPI_RequestInterface $request){
        $result = $this->curlPostAPI($_POST, $this->url_process."exportLogDoiQua");
        $objExcel = new Quick_CSV_import();
        $header =  array('ID','MOBO_ID','MSI','Character Name','SERVER ID','ITEMS','RUBY','CREATED TIME');
        $objExcel->export($header, $result,array('2' => ''));
    }
	
	
	public function exportLogDatCuoc(MeAPI_RequestInterface $request){
        $result = $this->curlPostAPI($_POST, $this->url_process."exportLogDatCuoc");
        $objExcel = new Quick_CSV_import();
        $header =  array('ID','MOBO_ID','MSI','Character Name','SERVER ID','RUBY','CREATED TIME');
        $objExcel->export($header, $result,array('2' => ''));
    }
}
