<?php

class MeAPI_Controller_MGH_Events_ShopUyDanhController implements MeAPI_Controller_MGH_Events_ShopUyDanhInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $key = "MGH_event_ShopUyDanh";
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://service.mgh.mobo.vn/cms/tool_shop_uy_danh/";

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
        die('aaaaaaaaaaaaaaaa');
//        global $game;
//        $configs =  $this->curlPostAPI(array(), $this->url_process."config");
//        $this->data['configs'] = $configs ;
//        $_SESSION[$this->key.'configs'] = $configs;
//
//
//        $this->authorize->validateAuthorizeRequest($request, 0);
//        $this->CI->template->write_view('content', 'game/MGH/Events/ShopUyDanh/index', $this->data);
//        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function getResponse() {
        return $this->_response;
    }


	public function get_config_doidiem(MeAPI_RequestInterface $request){
		$package =  $this->curlPostAPI(array(), $this->url_process."get_config_doidiem");
		// echo '<pre>';print_r($package);die;
        $this->data['package'] = $_SESSION['config_doidiem'] = $package;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/configbangdiem', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	
	
    public function showAddConfigBangDiem(MeAPI_RequestInterface $request) {
        //edit
        if(isset($_GET['id'])){
            $this->data['id'] = $_GET['id'];
			$package = json_decode($_SESSION['config_doidiem']);
			// echo '<pre>';print_r($package);die;
			
            $pack = array_filter($package,function($p){
                if($p->id == $_GET['id']){
                    return $p ;
                }
            });
            $this->data['pack'] = array_shift($pack) ;
        }

       // echo '<pre>';print_r($this->data['pack']);die;



        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/addConfig', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }


    public function addConfigBangDiem(MeAPI_RequestInterface $request) {

       $result = $this->curlPostAPI($_POST, $this->url_process."add_config_bangdiem");
       $this->_response = new MeAPI_Response_HTMLResponse($request, $result);
    }


    public function quanlybangdiem(MeAPI_RequestInterface $request) {
        $package =  $this->curlPostAPI(array(), $this->url_process."get_point_table");
        $this->data['package'] = $_SESSION['point_table'] = $package;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/quanlybangdiem', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function quanlyqua(MeAPI_RequestInterface $request) {
        $package =  $this->curlPostAPI(array(), $this->url_process."gift_list");
        $this->data['package'] = $_SESSION[$this->key.'package'] = $package;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        $package = json_decode($_SESSION[$this->key.'package']);


        $dsQua = array_filter($package,function($p){
            if($p->parent_id == 0){
                return $p ;
            }
        });

        $this->data['dsQua'] = $dsQua;

        //edit
        if(isset($_GET['id'])){
            $this->data['id'] = $_GET['id'];


            $pack = array_filter($package,function($p){
                if($p->id == $_GET['id']){
                    return $p ;
                }
            });
            $this->data['pack'] = array_shift($pack) ;
        }

//        echo '<pre>';print_r($this->data['pack']);die;



        $this->authorize->validateAuthorizeRequest($request, 0);
        if(isset($_GET['parent_id']) && $_GET['parent_id'] == 0){
            $this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/themloaiqua', $this->data);
        }else{
            $this->data['parent_id'] = $_GET['parent_id'];
            $this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/themqua', $this->data);
        }



        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function thembangdiem(MeAPI_RequestInterface $request) {
        if(isset($_GET['type']))
            $this->data['type'] = $_GET['type'];
        elseif(isset($_GET['idcard'])){
            if($_GET['idcard'] != 'null'){
                $this->data['type'] = 'tuong';
            }else{
                $this->data['type'] = 'level';
            }
        }
        //edit
        if(isset($_GET['id'])){
            $package = json_decode($_SESSION['point_table']) ;
            $this->data['id'] = $_GET['id'];

            $pack = array_filter($package,function($p){
                if($p->id == $_GET['id']){
                    return $p ;
                }
            });
            $this->data['pack'] = array_shift($pack) ;
        }

//        echo '<pre>';print_r($this->data['pack']);die;



        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/thembangdiem', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function add_gift_category(MeAPI_RequestInterface $request){
        if(empty($_POST['id']))
            $_POST['parent_id'] = 0;

        $result = $this->curlPostAPI($_POST, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);

    }


    public function add_gift(MeAPI_RequestInterface $request){


        $post['parent_id'] = $_POST['parent_id'];
        $post['items'] = json_encode(array(
           'name' => $_POST['name'],
           'item_id' => $_POST['item_id'],
           'price' => $_POST['price'],
           'image' => $_POST['image'],
           'server_list' => $_POST['server_list'],
        ));

        if(!empty($_POST['id'])){ //update
            $post['id'] = $_POST['id'];
        }

//        echo "<pre>";print_r($post ); die;


        $result = $this->curlPostAPI($post, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);

    }
    public function add_bangdiem(MeAPI_RequestInterface $request){

        if(isset($_POST['IDCard'])){
            $post['items'] = json_encode(
                array(
                    'IDCard' => $_POST['IDCard'],
                    'name' => $_POST['name'],
                    'point' => $_POST['point']
                ));
        }else{
            $post['items'] = json_encode(
                array(
                'start_level' => $_POST['start_level'],
                'end_level' => $_POST['end_level'],
                'point' => $_POST['point']
            ));
        }



        if(!empty($_POST['id'])){ //update
            $post['id'] = $_POST['id'];
        }

//        echo "<pre>";print_r($post ); die;
        $result = $this->curlPostAPI($post, $this->url_process."add_bangdiem");
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
        $this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/logdoiqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function get_log_doidiem(MeAPI_RequestInterface $request){
        $logs =  $this->curlPostAPI(array(), $this->url_process."get_log_doidiem");
        $this->data['logs'] = $logs ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/mgh/Events/ShopUyDanh/logdoidiem', $this->data);
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


    public function exportLogDoiQua(MeAPI_RequestInterface $request){
        $result = $this->curlPostAPI($_POST, $this->url_process."exportLogDoiQua");
        $objExcel = new Quick_CSV_import();
        $header =  array('ID','MOBO_ID','MSI','Character Name','SERVER ID','ITEMS','CREATED TIME');
        $objExcel->export($header, $result,array('2' => ''));
    }


    public function exportLogDoiDiem(MeAPI_RequestInterface $request){
        $result = $this->curlPostAPI($_POST, $this->url_process."exportLogDoiDiem");
        $objExcel = new Quick_CSV_import();
        $header =  array('ID','MOBO_ID','MSI','Character Name','SERVER ID','POINT','CREATED TIME');
        $objExcel->export($header, $result,array('2' => ''));
    }
}
