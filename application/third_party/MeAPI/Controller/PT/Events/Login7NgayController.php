<?php
class MeAPI_Controller_PT_Events_Login7NgayController implements MeAPI_Controller_PT_Events_Login7NgayInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $key = "phongthan_event_login_7ngay";
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/phongthan/cms/tool_event_login_7ngay/";
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

    }

    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $configs =  $this->curlPostAPI(array(), $this->url_process."config");
        $this->data['configs'] = $configs ;
        $_SESSION[$this->key.'configs'] = $configs;


        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/Login7Ngay/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function getResponse() {
        return $this->_response;
    }


    public function showAddConfig(MeAPI_RequestInterface $request) {
        //edit
        if(isset($_GET['name']) && !empty($_GET['name']))
            $this->data['name'] = $_GET['name'];

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

        if(isset($_GET['article_id']) && !empty($_GET['article_id'])){
            $this->data['article_id'] = $_GET['article_id'];
        }

        if(isset($_GET['day_number']) && $_GET['day_number'] != 'null'){
            $this->data['day_number'] = $_GET['day_number'];
        }

        if(isset($_GET['is_tester']) && !empty($_GET['is_tester'])){
            $this->data['is_tester'] = $_GET['is_tester'];
        }else{
            $this->data['is_tester'] = 0;
        }


        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/Login7Ngay/addConfig', $this->data);
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
        $this->CI->template->write_view('content', 'game/pt/Events/Login7Ngay/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {

        //lay package theo id
        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];
        $package = json_decode($_SESSION[$this->key.'package']);
        $pack = array_filter($package,function($p){
            if($p->id == $_GET['id']){
                return $p ;
            }
        });
        $this->data['pack'] = array_shift($pack) ;


//        echo "<pre>";
//        print_r($this->data['pack']);die;

        $this->data['configs'] =  json_decode($_SESSION[$this->key.'configs'])  ;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/Login7Ngay/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }





    public function add_gift(MeAPI_RequestInterface $request){

        $post = array(
            'config_id' => json_encode($_POST['config_id'])
        );

        for($i = 1; $i <= 7; $i++){
            ${'items'.$i} = array();
            for($j = 0; $j < count($_POST['item'.$i.'_id']); $j++){
                $temp = array(
                    'item_id' => $_POST['item'.$i.'_id'][$j],
                    'item_name' => $_POST['item'.$i.'_name'][$j],
                    'count' => $_POST["count$i"][$j]
                );
                ${'items'.$i}[] = $temp;
            }
            $post["items_$i"] = json_encode(${'items'.$i});
        }

        if(!empty($_POST['id'])){
            $post['id'] = $_POST['id'];
        }

//        echo "<pre>";
//        print_r($post);
//        die;
        $result = $this->curlPostAPI($post, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);

    }

    public function delete_gift(MeAPI_RequestInterface $request){

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $result = $this->curlPostAPI(array('id' => $_GET['id']), $this->url_process."delete_gift");
            $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
        }


    }


    public function get_log_nhanqua(MeAPI_RequestInterface $request){
        $log_nhanqua =  $this->curlPostAPI(array(), $this->url_process."get_log_nhanqua");
        $this->data['log_nhanqua'] = $log_nhanqua;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/Login7Ngay/lognhanqua', $this->data);
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
        $header =  array('ID','CharacterID','Character name','Server ID','MSI','MoboID','Status','Ngày nhận');
        $objExcel->export($header,$result,array('4'=>''));
    }
}
