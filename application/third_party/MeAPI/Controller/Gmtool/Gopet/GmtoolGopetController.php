<?php
class MeAPI_Controller_Gmtool_Gopet_GmtoolGopetController implements MeAPI_Controller_Gmtool_Gopet_GmtoolGopetInterface {
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
    private $url_process = "http://game.mobo.vn/bog/cms/gmtool/gopet/";
	private $listserver = array(1=>"SERVER 1",2=>"SERVER 2",
	3=>"SERVER 3",4=>"SERVER 4");
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
        $this->CI->load->MeAPI_Model('Gmtool/GmtoolgopetModel');
        //$this->CI->load->MeAPI_Model('ReportModel');
        //$this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
        $this->data['url'] = $this->url_link;
		$this->data['listserver'] = $this->listserver;
    }

    /*******HISTORY LOG*******/
    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    /*******backup_clean*******/
    public function backup_Userdata(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if($request->input_post()) {
            $params = $request->input_post();
            if(!is_numeric($params['eventid']) || $params['eventid'] <=0 || empty($params['serverid']) ){
                $this->data['message'] = 'Nhập thông tin không hợp lệ';
            }else{
                $this->CI->GmtoolgopetModel->call_procedure("sp_GMT_clean_userdata_oldevent",$params);
            }
            //call model
        }
        $this->CI->template->write_view('content', 'gmtool/gopet/backup/userdata', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function backup_Characterdata(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        if($request->input_post()) {
            $params = $request->input_post();
            if(!is_numeric($params['eventid']) || $params['eventid'] <=0 || empty($params['serverid'])){
                $this->data['message'] = 'Nhập thông tin không hợp lệ';
            }else{
                $this->CI->GmtoolgopetModel->call_procedure("sp_GMT_clean_chardata_oldevent",$params);
            }
            //call model
        }

        $this->CI->template->write_view('content', 'gmtool/gopet/backup/characterdata', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    /*******updateevent*******/

    public function update_time(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        if($request->input_post()) {
            $params = $request->input_post();
            if(!is_numeric($params['eventid']) || $params['eventid'] <=0 || empty($params['jsondata']) || empty($params['serverid']) ){
                return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            }else{
                $this->CI->GmtoolgopetModel->call_procedure("sp_GMT_update_event_time",$params);
				return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
            }
            //call model
			return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
        }


        $this->CI->template->write_view('content', 'gmtool/gopet/update/time', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function update_desc(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        if($request->input_post()) {
            $params = $request->input_post();
            if(!is_numeric($params['eventid']) || $params['eventid'] <=0 || empty($params['jsondata']) || empty($params['serverid']) ){
                return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            }else{
                //$this->CI->GmtoolgopetModel->call_procedure("sp_GMT_update_event_desc",$params);
				return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
            }
            //call model
			return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
        }


        $this->CI->template->write_view('content', 'gmtool/gopet/update/desc', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function update_data(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        if($request->input_post()) {
            $params = $request->input_post();
            if(!is_numeric($params['name']) || $params['name'] <=0 || empty($params['jsondata']) || empty($params['serverid']) ){
                return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            }else{
                $this->CI->GmtoolgopetModel->call_procedure("sp_GMT_update_event_data",$params);
				return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            }
			return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            //call model
        }


        $this->CI->template->write_view('content', 'gmtool/gopet/update/data', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function update_reward(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        if($request->input_post()) {
            $params = $request->input_post();
            if(!is_numeric($params['name']) || $params['name'] <=0 || empty($params['jsondata']) || empty($params['serverid']) ){
                return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            }else{
                $this->CI->GmtoolgopetModel->call_procedure("sp_update_event_reward",$params);
				return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            }
			return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            //call model
        }

        $this->CI->template->write_view('content', 'gmtool/gopet/update/reward', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    /*******updateprice*******/
    public function updateopri_all(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        if($request->input_post()) {
            $params = $request->input_post();
            if(!is_numeric($params['pricegold']) || $params['pricegold'] <=0 || empty($params['pricegem'] ) || empty($params['serverid']) ){
                return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            }else{
                $this->CI->GmtoolgopetModel->call_procedure("sp_GMT_update_item_price_all",$params);
				return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
            }
			
			return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            //call model
        }

        $this->CI->template->write_view('content', 'gmtool/gopet/updateopri/all', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function updateopri_itemid(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        if($request->input_post()) {
            $params = $request->input_post();
            if(!is_numeric($params['itemid']) || $params['itemid'] <=0 || empty($params['pricegold']) || empty($params['serverid'])
			|| empty($params['pricegem'] ) ){
                return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
            }else{
                $this->CI->GmtoolgopetModel->call_procedure("sp_GMT_update_item_price_by_itemid",$params);
				return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
            }
            //call model
			return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
        }


        $this->CI->template->write_view('content', 'gmtool/gopet/updateopri/itemid', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    /*******updateboss*******/
    public function updatebossinfo_bossid(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);


        if($request->input_post()) {
			$params = $request->input_post();
			if(!is_numeric($params['bossid']) || $params['bossid'] <=0 || empty($params['des']) 
				|| empty($params['hp']) || empty($params['atk'])
				|| empty($params['def'])|| empty($params['crit']) || empty($params['serverid']) ){
				return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
            }else{
                //$this->CI->GmtoolgopetModel->call_procedure("sp_GMT_update_boss_info_by_bossid",$params);
				return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
            }
            //call model
			
			return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
        }


        $this->CI->template->write_view('content', 'gmtool/gopet/updatebossinfo/bossid', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    /*******updatepetinfo*******/
    public function updatepetinfo_petid(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    /*******petitemservice*******/
    public function news_mpet_shoppet(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function news_mpet_shopitem(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function news_mpet_shopsecret(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function news_mpet_shopleague(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function news_mpet_shopupgradebet(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function news_mpet_exchangeitem(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function news_mpet_tatoomaxslot(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }



    public function event(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $getlistgame = $this->CI->SocialmeModel->getlistgame();
        $this->data['listgame'] = $getlistgame;
        $this->CI->template->write_view('content', 'gmtool/gopet/eventitems', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function addeventitems(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);

        $getlistgame = $this->CI->SocialmeModel->getlistgame();
        $this->data['listgame'] = $getlistgame;
        $this->CI->template->write_view('content', 'gmtool/gopet/addeventitems', $this->data);
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

        $ids = $request->input_get('ids');
        if(isset($ids) && !empty($ids)){
            $linkdetail = $this->url_link.'/cms/gmtool/gopet/getDetailConfig?ids='.$ids;
            $infoDetail = file_get_contents($linkdetail);
            $datainfojson = json_decode($infoDetail,true);

        }
        $this->data['detail'] = $datainfojson;


        $getlistgame = $this->CI->SocialmeModel->getlistgame();
        $this->data['listgame'] = $getlistgame;
        $this->CI->template->write_view('content', 'gmtool/gopet/addeventitems', $this->data);
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
