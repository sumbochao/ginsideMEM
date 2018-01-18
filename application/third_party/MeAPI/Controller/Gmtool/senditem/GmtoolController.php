<?php

class MeAPI_Controller_Gmtool_GmtoolController implements MeAPI_Controller_Gmtool_GmtoolInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    //private $url_link = "http://game.mobo.vn/phongthan";
    private $url_link = "http://game.mobo.vn/bog/";
    private $url_process = "http://game.mobo.vn/bog/cms/gmtool/";
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
		$this->CI->load->MeAPI_Model('SearchInfoModel');
        $this->CI->load->MeAPI_Model('SocialmeModel');

        //$this->CI->load->MeAPI_Model('ReportModel');
        //$this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
        $this->data['url'] = $this->url_link;

    }
    
    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function event(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $getlistgame = $this->CI->SocialmeModel->getlistgame();
        $this->data['listgame'] = $getlistgame;
        $this->CI->template->write_view('content', 'gmtool/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function addeventitems(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
echo '11';die;
        $getlistgame = $this->CI->SocialmeModel->getlistgame();
        $this->data['listgame'] = $getlistgame;
        $this->CI->template->write_view('content', 'gmtool/addeventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function submiteventitems(MeAPI_RequestInterface $request){
        $paramsfile = array();
        if(isset($_FILES['listgamer']['tmp_name']) && !empty($_FILES['listgamer']['tmp_name'])) {
            $readfile = array();
            if ($_FILES['listgamer']['size'] > 716800) {
                $result["code"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB 22";
                goto result;
            }else {
                $file = fopen($_FILES['listgamer']['tmp_name'],"r");
                while(! feof($file))
                {
                    $datarows = fgetcsv($file);
                    $getrows  =  explode(' ', $datarows[0]);
                    $parserows['mobo_service_id'] = $getrows[0];
                    $parserows['server_id'] = $getrows[1];
                    if(isset($getrows[2]) && !empty($getrows[2])){
                        $parserows['character_id'] = $getrows[2];
                    }
                    if(!empty($code)){

                    }
                    array_push($readfile,$parserows);

                }
                fclose($file);
            }
            $paramsfile['readfile'] = json_encode($readfile);
        }


        $item_id = $_POST['item_id'];
        $name = $_POST['name'];
        $count = $_POST['count'];
        $type = $_POST['type'];
        $game = $_POST['game'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $email = $_POST['email'];
        $server_id = $_POST['server_id'];
        $id = $_POST['id'];

        if(empty($end) || empty($email)  || empty($start) || empty($game) || count($item_id)==0 || ( empty($id) && (empty($paramsfile['readfile'])  && empty($server_id) ) )  ){
            $result["code"] = -1;
            $result["message"]='FAILED[ginside] !';
            $result['daa'] = $id;
            goto result;
        }
        $arrItems = array();
        for($i=0;$i<count($item_id);$i++){
            $arrItems[] = array(
                'item_id' =>$item_id[$i],
                'name'=>$name[$i],
                'count'=>$count[$i],
                'type'=>$type[$i],
            );
        }
        $_POST['items'] = json_encode($arrItems);
        unset($_POST['item_id'],$_POST['name'],$_POST['count'],$_POST['type']);
        $params = array_merge($_POST,$paramsfile);

        $resultpost = $this->curlPost($params, $this->url_process."addeventitems");
        $result = json_decode($resultpost,true);
        result:
        unset($_POST);
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }

    public function editeventitems(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		echo '11';die;
        $ids = $request->input_get('ids');
        if(isset($ids) && !empty($ids)){
            $linkdetail = $this->url_link.'/cms/gmtool/getDetailConfig?ids='.$ids;
            $infoDetail = file_get_contents($linkdetail);
            $datainfojson = json_decode($infoDetail,true);

        }
        $this->data['detail'] = $datainfojson;

		
		$getlistgame = $this->CI->SearchInfoModel->listGame();
		echo "<pre>";
		print_r($getlistgame);die;
		
        //$getlistgame = $this->CI->SocialmeModel->getlistgame();
        $this->data['listgame'] = $getlistgame;
        $this->CI->template->write_view('content', 'gmtool/addeventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    

    //Function
    public function getResponse() {
        return $this->_response;
    }
    
    function data_uri($file, $mime='image/jpeg')
    {
        if(empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    
    public function curlPost($params,$link=''){
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
        if($result){
            $result = json_decode($result,true);
            if($result['code']==0){
                $result = $result;
            }
        }
        return $result;
    }

}
