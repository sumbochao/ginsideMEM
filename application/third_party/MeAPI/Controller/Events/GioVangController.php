<?php
global $game;

if(isset($_GET['game']) && !empty($_GET['game'])){
    $game = htmlentities($_GET['game']) ;
}else{
    $game = 'BOG';
}

class MeAPI_Controller_Events_GioVangController implements MeAPI_Controller_Events_GioVangInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/bog/cms/tool_event_gio_vang/";
	private $view = '';
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
		
		if(isset($_GET['view'])){
			$this->view = $_GET['view'];
		}
		global $game;
        $this->data['game'] = $game ;
    }

	
	public function display(MeAPI_RequestInterface $request){
		global $game;
		if($this->view == 'index'){
			$configs =  $this->curlPostAPI(array('game' => $game), $this->url_process."config");
			$this->data['configs'] = $configs ;
			$_SESSION['configs'] = $configs;
		}elseif($this->view == 'addConfig'){
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

			if(isset($_GET['id']))
				$this->data['id'] = $_GET['id'];
		}elseif($this->view == 'themqua'){
			//edit
			if(isset($_GET['condition']))
				$this->data['condition'] = $_GET['condition'];
			if(isset($_GET['start']))
				$this->data['start'] = $_GET['start'];
			if(isset($_GET['end']))
				$this->data['end'] = $_GET['end'];
			if(isset($_GET['items'])){
				$items = json_decode($_GET['items']) ;
				$this->data['items'] = json_decode($_GET['items']);
			}
			if(isset($_GET['id']))
				$this->data['id'] = $_GET['id'];
			if(isset($_GET['game']))
				$this->data['game'] = $_GET['game'];
			if(isset($_GET['config_id']))
				$this->data['config_id'] = $_GET['config_id'];

			$this->data['configs'] =  json_decode($_SESSION['configs'])  ;
		}
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/GioVang/'.$this->view, $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}

	
	
    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        
        

        /*$configs =  $this->curlPostAPI(array('game' => $game), $this->url_process."config");
        $this->data['configs'] = $configs ;
        $_SESSION['configs'] = $configs;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/GioVang/'.$this->view.'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/

    }

    public function getResponse() {
        return $this->_response;
    }


    /*public function showAddConfig(MeAPI_RequestInterface $request) {
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

        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/GioVang/'.$this->view.'/addConfig', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }*/


    public function addConfig(MeAPI_RequestInterface $request) {
        $result = $this->curlPostAPI($_POST, $this->url_process."addConfig");
        $this->_response = new MeAPI_Response_HTMLResponse($request, $result);
    }


    /*public function quanlyqua(MeAPI_RequestInterface $request) {
        global $game;
        $this->data['game'] = $game ;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/GioVang/'.$this->view.'/quanlyqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }*/

    /*public function themqua(MeAPI_RequestInterface $request) {
        //edit
        if(isset($_GET['condition']))
            $this->data['condition'] = $_GET['condition'];
        if(isset($_GET['start']))
            $this->data['start'] = $_GET['start'];
        if(isset($_GET['end']))
            $this->data['end'] = $_GET['end'];
        if(isset($_GET['items'])){
            $items = json_decode($_GET['items']) ;
            $this->data['items'] = json_decode($_GET['items']);
        }
        if(isset($_GET['id']))
            $this->data['id'] = $_GET['id'];
        if(isset($_GET['game']))
            $this->data['game'] = $_GET['game'];
        if(isset($_GET['config_id']))
            $this->data['config_id'] = $_GET['config_id'];

        $this->data['configs'] =  json_decode($_SESSION['configs'])  ;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/GioVang/'.$this->view.'/themqua', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }*/





    public function add_gift(MeAPI_RequestInterface $request){
        $items = array();

        for($i = 0; $i < count($_POST['item_id']); $i++){
            $temp = array(
                'item_id' => $_POST['item_id'][$i],
                'item_name' => $_POST['item_name'][$i],
                'count' => $_POST['count'][$i]
            );
            if(isset($_POST['type'])){
                $temp['type'] = $_POST['type'][$i];
            }
            $items[] = $temp;
        }
        $post = array(
            'condition' => $_POST['condition'],
            'start' => $_POST['start'],
            'end' => $_POST['end'],
            'config_id' => $_POST['config_id'],
            'game' => $_POST['game'],
            'items' => json_encode($items)
        );
        if(!empty($_POST['id'])){
            $post['id'] = $_POST['id'];
            $post['updated_time'] = date('Y-m-d H:i:s',time());
        }else{
            $post['created_time'] = date('Y-m-d H:i:s',time());
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

    /*public function lichsu(MeAPI_RequestInterface $request){
        global $game;
        $this->data['game'] = $game;
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'events/GioVang/'.$this->view.'/lichsu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }*/



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
        $header =  array('ID','CharacterID','Character name','Server ID','Status','API Result','Received Time');
        $objExcel->export($header,$result);
    }
}
