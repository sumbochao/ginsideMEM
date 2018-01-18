<?php
global $game;

if(isset($_GET['game']) && !empty($_GET['game'])){
    $game = htmlentities($_GET['game']) ;
}else{
    $game = 'GiangMa';
}

class MeAPI_Controller_Events_DauCoController implements MeAPI_Controller_Events_DauCoInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $key = "event_dauco";
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "";
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

        $control = $_GET['control'];
        $this->url_process = "http://game.mobo.vn/giangma/cms/tool_$control/";
        $this->data['url'] = $this->url_process;
        $this->data['control'] = $control;
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request) {

        global $game;
        $this->data['game'] = $game ;
        $configs =  $this->curlPostAPI(array('game' => $game), $this->url_process."config");
        $this->data['configs'] = $configs ;
        $_SESSION['configs'] = $configs;


        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/DauCo/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function getResponse() {
        return $this->_response;
    }


    public function showAddConfig(MeAPI_RequestInterface $request) {
        //gui du lieu de generate combobox package
        $this->data['packages'] = json_decode($this->curlPostAPI(array(),$this->url_process.'getPackages')) ;
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
        if(isset($_GET['game']) && !empty($_GET['game'])){
            $this->data['game'] = $_GET['game'];
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
        $this->CI->template->write_view('content', 'events/DauCo/addConfig', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function addConfig(MeAPI_RequestInterface $request) {

        if(!isset($_POST['is_tester']))
            $_POST['is_tester'] = 0;
        $result = $this->curlPostAPI($_POST, $this->url_process."addConfig");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);
    }


    public function quanlyqua(MeAPI_RequestInterface $request) {
        global $game;
        $this->data['game'] = $game ;
        $package =  $this->curlPostAPI(array('game' => $game), $this->url_process."gift_list");
        $this->data['package'] = $_SESSION[$game.$this->key.'package'] = $package;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/DauCo/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function themqua(MeAPI_RequestInterface $request) {
        //edit
        global $game;

        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];
//
        $package = json_decode($_SESSION[$game.$this->key.'package']);
        $pack = array_filter($package,function($p){
            if($p->id == $_GET['id']){
                return $p ;
            }
        });
        $this->data['pack'] = array_shift($pack) ;
        $this->data['game'] = $game;

        if(isset($_GET['config_id']))
            $this->data['config_id'] = $_GET['config_id'];


        $this->data['configs'] =  json_decode($_SESSION['configs'])  ;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/DauCo/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }





    public function add_gift(MeAPI_RequestInterface $request){
        $items = array();
        $items2 = array();

        for($i = 0; $i < count($_POST['item1_id']); $i++){
            $temp = array(
                'item_id' => $_POST['item1_id'][$i],
                'item_name' => $_POST['item1_name'][$i],
                'count' => $_POST['count1'][$i]
            );
            if(isset($_POST['type1'])){
                $temp['type'] = $_POST['type1'][$i];
            }
            $items[] = $temp;
        }

        for($i = 0; $i < count($_POST['item2_id']); $i++){
            $temp = array(
                'item_id' => $_POST['item2_id'][$i],
                'item_name' => $_POST['item2_name'][$i],
                'count' => $_POST['count2'][$i]
            );
            if(isset($_POST['type2'])){
                $temp['type'] = $_POST['type2'][$i];
            }
            $items2[] = $temp;
        }

        $post = array(
            'config_id' => json_encode($_POST['config_id']),
            'price' => $_POST['price'],
            'game' => $_POST['game'],
            'items_1' => json_encode($items),
            'items_2' => json_encode($items2)
        );
        if(!empty($_POST['id'])){
            $post['id'] = $_POST['id'];
        }

        //cau hinh upload hinh
        $config['upload_path'] = FCPATH.'assets/img/login7ngay/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->CI->load->library('upload', $config);

        if(isset($_FILES['image'])){
            $post['image'] = $_FILES['image']['name'];
            $this->CI->upload->do_upload('image');
        }


        $result = $this->curlPostAPI($post, $this->url_process."add_gift");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);

    }

    public function delete_gift(MeAPI_RequestInterface $request){

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $result = $this->curlPostAPI(array('id' => $_GET['id']), $this->url_process."delete_gift");
            $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
        }


    }


    public function get_log_muaqua(MeAPI_RequestInterface $request){
        global $game;
        $this->data['game'] = $game;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/DauCo/logmuaqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function get_log_nhanqua(MeAPI_RequestInterface $request){
        global $game;
        $this->data['game'] = $game;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/DauCo/lognhanqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function get_log_naptien(MeAPI_RequestInterface $request){
        global $game;
        $this->data['game'] = $game;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/DauCo/lognaptien', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function get_log_tien_tichluy(MeAPI_RequestInterface $request){
        global $game;
        $this->data['game'] = $game;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/DauCo/logtientichluy', $this->data);
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
        $header =  array('ID','CharacterID','Character name','Server ID','MoboID','MSI','Money','Ngày cập nhật');
        $objExcel->export($header,$result,array('5'=>''));
    }
}
