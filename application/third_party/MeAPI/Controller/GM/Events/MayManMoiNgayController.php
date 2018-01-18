<?php

class MeAPI_Controller_GM_Events_MayManMoiNgayController implements MeAPI_Controller_GM_Events_MayManMoiNgayInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $key = "GM_event_MayManMoiNgay";
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/giangma/cms/tool_maymanmoingay/";

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
        $config =  $this->curlPostAPI(array(), $this->url_process."getConfig");
        $this->data['config'] = json_decode($config)[0]  ;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/gm/Events/MayManMoiNgay/addConfig', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

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
//        $this->CI->template->write_view('content', 'game/GM/Events/MayManMoiNgay/addConfig', $this->data);
//        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function addConfig(MeAPI_RequestInterface $request) {

        $result = $this->curlPostAPI($_POST, $this->url_process."addConfig");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);
    }


    public function quanlyqua(MeAPI_RequestInterface $request) {
        $package =  $this->curlPostAPI(array(), $this->url_process."gift_list");
        $this->data['package'] = $_SESSION[$this->key.'package'] = $package;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/gm/Events/MayManMoiNgay/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function themqua(MeAPI_RequestInterface $request) {
        $package = json_decode($_SESSION[$this->key.'package']);
        $this->data['dsQua'] = $package;

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
        $this->CI->template->write_view('content', 'game/gm/Events/MayManMoiNgay/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function add_gift(MeAPI_RequestInterface $request){


        $post['items'] = json_encode(array(
            'reward_name' => $_POST['reward_name'],
            'reward_item_code' => $_POST['reward_item_code'],
            'reward_item_number' => $_POST['reward_item_number'],
            'reward_img' => $_POST['reward_img'],
            'reward_item_type' => $_POST['reward_item_type'],
            'time' => $_POST['time'],
            'reward_point' => $_POST['reward_point'],
        ));

        if(!empty($_POST['id'])){ //update
            $post['id'] = $_POST['id'];
        }

//        echo "<pre>";print_r($post ); die;


        $result = $this->curlPostAPI($post, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);

    }


    public function get_log_nhanqua(MeAPI_RequestInterface $request){
        $logs =  $this->curlPostAPI(array(), $this->url_process."get_log_nhanqua");
        $this->data['logs'] = $logs ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/gm/Events/MayManMoiNgay/lognhanqua', $this->data);
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


    public function exportLogNhanQua(MeAPI_RequestInterface $request){
        $result = $this->curlPostAPI($_POST, $this->url_process."exportLogDoiQua");
        $objExcel = new Quick_CSV_import();
        $header =  array('ID','MOBO_ID','MSI','Character Name','SERVER ID','ITEMS','CREATED TIME');
        $objExcel->export($header, $result,array('2' => ''));
    }

}
