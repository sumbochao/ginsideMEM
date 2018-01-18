<?php

class MeAPI_Controller_LOL_Events_NhanGiftCodeController implements MeAPI_Controller_LOL_Events_NhanGiftCodeInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $key = "LOL_event_NhanGiftCode";
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/lol/cms/tool_event_nhan_giftcode/";
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

        global $game;
        $configs =  $this->curlPostAPI(array(), $this->url_process."config");
        $this->data['configs'] = $configs ;
        $_SESSION[$this->key.'configs'] = $configs;


        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lol/Events/NhanGiftCode/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function getResponse() {
        return $this->_response;
    }


    public function showAddConfig(MeAPI_RequestInterface $request) {
        //gui du lieu de generate combobox package
        $this->data['packages'] = json_decode($this->curlPostAPI(array(),$this->url_process.'getPackages')) ;
        //edit
        if(isset($_GET['id'])){
            $this->data['id'] = $_GET['id'];
            $configs = json_decode($_SESSION[$this->key.'configs']) ;
            $rs = array_filter($configs,function($p){
                if($p->id == $_GET['id']){
                    return $p ;
                }
            });
            $this->data['config'] = array_shift($rs) ;
        }


        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lol/Events/NhanGiftCode/addConfig', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function addConfig(MeAPI_RequestInterface $request) {

        if(!isset($_POST['is_tester']))
            $_POST['is_tester'] = 0;
        $result = $this->curlPostAPI($_POST, $this->url_process."addConfig");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);
    }


    public function quanlyqua(MeAPI_RequestInterface $request) {
        $package =  $this->curlPostAPI(array(), $this->url_process."gift_list");
        $this->data['package'] = $_SESSION[$this->key.'package'] = $package;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lol/Events/NhanGiftCode/quanlyqua', $this->data);
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

        if(isset($_GET['type']))
            $this->data['type'] = $_GET['type'];

        if(isset($_GET['status']))
            $this->data['status'] = $_GET['status'];


        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lol/Events/NhanGiftCode/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }





    public function add_gift(MeAPI_RequestInterface $request){

        $post = array(
            'type' => $_POST['type']
        );

        if(!empty($_POST['id'])){ //update
            $post['id'] = $_POST['id'];
            $post['status'] = $_POST['status'];
            $post['giftcode'] = $_POST['giftcode'];
        }else{
            $listGiftCode = file($_FILES["listGiftCode"]["tmp_name"]);
            $post['listGiftCode'] = json_encode($listGiftCode);
        }
        $result = $this->curlPostAPI($post, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);

    }

    /*public function delete_gift(MeAPI_RequestInterface $request){

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $result = $this->curlPostAPI(array('id' => $_GET['id']), $this->url_process."delete_gift");
            $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
        }


    }*/


    public function get_log_nhanqua(MeAPI_RequestInterface $request){
        $logs =  $this->curlPostAPI(array(), $this->url_process."get_log_nhanqua");
        $this->data['logs'] = $logs ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lol/Events/NhanGiftCode/lognhanqua', $this->data);
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
        $result = $this->curlPostAPI($_POST, $this->url_process."export");
        $objExcel = new Quick_CSV_import();
        $header =  array('ID','CharacterID','Character name','Server ID','Items','Ngày nhận');
        $objExcel->export($header, $result,array('1' => ''));
    }
}
