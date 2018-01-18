<?php
session_start();
error_reporting(0);
class MeAPI_Controller_MiniappController implements MeAPI_Controller_MiniappInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    public $defineType = array();
    
    private $table_m_app = "tbl_m_app";
    private $table_m_app_config = "tbl_m_app_config";
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $api_mapp;
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    
    private $app_key = 'agiU7J0A';
    
    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
    }
    private function curlGet($link,$params=""){
        $this->last_link_request = $link;
        if(!empty($params)){
            $this->last_link_request.=http_build_query($params);
        }
		//echo $this->last_link_request;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
		
		if($result){
            $result = json_decode($result,true);
            if($result['code']==0){
                $result = $result['data'];
            }else{
				$result = null;
			}
        }

        return $result;
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
                
       // $this->CI->load->MeAPI_Model('MiniappModel');

        if(empty($_SESSION['listapp'])) {
			$link='';
            $link = $this->api_m_app . 'listapp';
            $_SESSION['listapp'] = $this->curlGet($link);
			 
        }
        rsort($_SESSION['listapp']);
        $this->data['slbApp'] = $_SESSION['listapp'];
        $this->data['result'] = array();
        if(isset($this->data['slbApp'][0]) && !empty($this->data['slbApp'][0]) ){
			$link='';
            $link = $this->api_m_app.'getconttentevent?';
            $this->data['result'] = $this->curlGet($link,array('id_app'=>$this->data['slbApp'][0]['id_app']) );
        }

        $this->CI->template->write_view('content', 'giftcodemobo/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function loadtypeevent(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $params = addslashes($_POST['typeevent']);
        if(isset($_POST['id']) && !empty($_POST['id'])){
           // $this->CI->load->MeAPI_Model('MiniappModel');
		   $link='';
            $link =$this->api_m_app.'getmapp?';
            $mapp = $this->curlGet($link,array('id'=>$_POST['id']) );
            //$mapp = $this->CI->MiniappModel->getmapp($_POST['id']);

            if($mapp){
                $this->data['detail'] = $mapp;
            }
        }
        //get info data;
        //check if exits get id then , access db to get info by id

        $c = $this->CI->load->view('giftcodemobo/loadajax/type_'.$params, $this->data,true);
        echo json_encode($c);
        die;
    }
    public function loadtypeeventcontent(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id_event = addslashes($_POST['typeevent']);

        //$this->CI->load->MeAPI_Model('MiniappModel');
		$link='';
        $link =$this->api_m_app.'getconttentevent?';
        $getcontent = $this->curlGet($link,array('id_app'=>$id_event) );
        //get info data;
        //check if exits get id then , access db to get info by id
        $tbody = "";
        $i = 1;
        foreach($getcontent as $val){
            $edit = "<a href='".base_url()."?control=miniapp&func=addmenu&id=".$val['id']."'><img src='".base_url()."assets/img/icon/icon_edit.png'></a>";
            $tbody.= "<tr>";
            $tbody.="<td>".$i."</td>";
            $tbody.="<td>".$val['id']."</td>";
            $tbody.="<td>".$val['type_event']."</td>";
            $tbody.="<td>".$val['title']."</td>";
            $tbody.="<td>".$val['order']."</td>";
            $tbody.="<td>".$val['isactive']."</td>";
            $tbody.="<td align='center'>".$edit."</td>";
            $tbody.= "</tr>";
            $i++;
        }
        echo $tbody;
        die;
    }
    public function loadbyapp(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        //$this->CI->load->MeAPI_Model('MiniappModel');
        $id_event = 0;
        if(isset($_POST['idapp']) && is_numeric($_POST['idapp'])){
            //if la co id

            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
				$link ='';
                $link = $this->api_m_app . 'getmapp?';
                $mapp = $this->curlGet($link,array("id"=>$_GET['id']));
                //$mapp = $this->CI->MiniappModel->getmapp($_GET['id']);
                if ($mapp) {
					$link ='';
                    $link = $this->api_m_app . 'getallappbyid?';
                    $arrayapp = $this->curlGet($link,array("id_app"=>$mapp['id_app'],"id_event"=>$mapp['id_event']));
                    //$arrayapp = $this->CI->MiniappModel->getallappbyid($mapp['id_app'], $mapp['id_event']);
                    $id_event = $mapp['id_event'];
                }
            }else {
				$link ='';
                $link = $this->api_m_app . 'getallapp?';
				$arrayapp = $this->curlGet($link,array("idapp"=>$_POST['idapp']));
				
				//$arrayapp = $this->CI->MiniappModel->getallapp($_POST['idapp']);
            }
            if(empty($_SESSION['listdefiney'])){
				$link='';
                $link = $this->api_m_app . 'listconfig';
                $_SESSION['listdefiney'] = $this->curlGet($link);
            }
            $arraylistapp = $_SESSION['listdefiney'];
			
            if(isset($arrayapp) && count($arrayapp)>=1) {
                foreach($arraylistapp as $key=>&$val){
                    foreach($arrayapp  as $info){
                        if($info['id_event'] == $val['id'] ){
                            unset($arraylistapp[$key]);
                        }
                    }
                }
				rsort($arraylistapp);
            }
            
            $html = "";
			if(isset($arraylistapp) && count($arraylistapp)>=1){
				
				foreach($arraylistapp as $v){
					$selected = ($v['id']==$id_event)?'selected="selected"':"";
					$html.="<option  value=".$v['type']."_".$v['id'].$selected .">".$v['name']."</option>";
				}
			}
            echo $html;

        }
        die;

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
    public function addmenu(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        //$this->CI->load->MeAPI_Model('MiniappModel');
        $this->data['display_name'] = '';
        $this->data['relative_url'] = '';
        $this->data['permission'] = 0;
        $this->data['order'] = 0;
        $this->data['menu_group_id'] = 0;
        $this->data['error'] ='';

        if(empty($_SESSION['listdefiney'])){
			$link='';
            $link = $this->api_m_app . 'listconfig';
            $_SESSION['listdefiney'] = $this->curlGet($link);
        }
        if(empty($_SESSION['listapp'])) {
			$link='';
            $link = $this->api_m_app . 'listapp';
            $slbApp = $this->curlGet($link);
            $_SESSION['listapp'] = $slbApp;
        }

        //$subgroupmenu = $this->CI->MiniappModel->getSubGroupMenu();
        //$this->data['sub_menu']= json_encode($subgroupmenu);
        $mapp =array();
        $arrayapp = array();
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
			$link='';
            $link = $this->api_m_app . 'getmapp?';
            $mapp = $this->curlGet($link,array("id"=>$_GET['id']));
            if($mapp) {
				$link='';
                $link = $this->api_m_app . 'getallappbyid?';
                $arrayapp = $this->curlGet($link,array("id_app"=>$mapp['id_app'],"id_event"=>$mapp['id_event'] ));
            }
        }
        $this->data['items'] = $mapp;
        
        if ($this->CI->input->post() && count($this->CI->input->post())>=1) {
			$getpath = "";
			if(isset($_FILES['picture']['tmp_name']) && !empty($_FILES['picture']['tmp_name'])) {
                $_FILES['picture']['encodefile'] = $this->data_uri($_FILES['picture']['tmp_name'], $_FILES['picture']['type']);
                $getpath = $this->curlPost($_FILES['picture']);
            }
			$id = $request->input_post('id');
            $kind_event = explode("_",$request->input_post('id_event'));
            $title = $request->input_post('title');
			
            $id_app = $request->input_post('id_app');

            $picture = $getpath;
            $isactive = ($request->input_post('isactive')=="on")?1:0;
			
			$isenable = ($request->input_post('isenable')=="on")?1:0;
			
            $order = $request->input_post('order');

            $fanpage = "";
            $share_link="";
            $share_caption="";
            $share_description="";
            $share_title="";
            $share_picture="";
			$comingsoon = "";

            if(!isset($kind_event[0]) || empty($kind_event[0])){
                //return false
                //thong tin khong chinh xac
                $this->data['error'] = 'Thông tin không chính xác..vui lòng thử lại';
                goto result;
            }
            $appidinfo = array();
            foreach ($_SESSION['listapp'] as $val) {

                if($id_app == $val['id_app']){
                    $appidinfo = $val;
                    break;
                }
            }

            $typeevent = $kind_event[0];
            $id_event = $kind_event[1];
            if($typeevent == 'like'){
                //check id fanpage
                $fanpage = $request->input_post('id_fanpage');
            }elseif($typeevent=='share'){
                //check params share
                $getpath_share = "";
                $share_link = $request->input_post('share_link');
                if(isset($_FILES['share_picture']['tmp_name']) && !empty($_FILES['share_picture']['tmp_name'])) {
                    $_FILES['share_picture']['encodefile'] = $this->data_uri($_FILES['share_picture']['tmp_name'], $_FILES['share_picture']['type']);
                    $getpath_share = $this->curlPost($_FILES['share_picture']);
                }
                $share_picture = $getpath_share;
                $share_caption = $request->input_post('share_caption');
                $share_title = $request->input_post('share_title');
                $share_description = $request->input_post('share_description');
            }
			$comingsoon = $request->input_post('comingsoon');
			if(!empty($id_event)  && !empty($title)  && !empty($id_app)){
                //luu id

                $arrayevent =array();

                foreach($_SESSION['listdefiney'] as $value){
                    if($value['type'] == $typeevent && $value['id']==$id_event){
                        $arrayevent = $value;
                        break;
                    }
                }
                $paramsinsert= array(
                    "id_app"=>$id_app,
                    "alias_app"=>$appidinfo['alias_app'],
                    "id_event"=>$id_event,
                    "type_event"=>$typeevent,
                    "title"=>$title,
                    "like_fanpage_id"=>$fanpage,
                    "share_link"=>$share_link,
                    "share_picture"=>$share_picture,
                    "share_caption"=>$share_caption,
                    "share_title"=>$share_title,
                    "share_description"=>$share_description,
                    "picture"=>$picture,
                    "event"=>$arrayevent['event'],
                    "note"=>$arrayevent['note'],
                    "iconimg"=>$arrayevent['iconimg'],
					"comingsoon"=>$comingsoon,
                    "isactive"=>$isactive,
					"isenable"=>$isenable,
                    "order"=>$order,
                    "insertDate"=>date('Y-m-d H:i:s',time())
                );
                if(empty($paramsinsert['share_picture']) ){
                    unset($paramsinsert['share_picture']);
                }
                if(empty($paramsinsert['picture']) ){
                    unset($paramsinsert['picture']);
                }
                if(!empty($id) && $id >=1){
                    $paramsinsert['id'] = $id;
                    $linkupdate = $this->api_m_app."updateAdd";
                    $statusupdate = $this->curlPost($paramsinsert,$linkupdate);
                    if($statusupdate)
                    $this->data['error']='Cập nhât thành công';
                    else
                    $this->data['error']='Cập nhât thất bại';
                }else{
                    //kiem tra da ton tai id_app va note nay` chua...neu ton tai thi hok cho insert
                    $linkupdate = $this->api_m_app."insertAdd";
					$statusinsert = $this->curlPost($paramsinsert,$linkupdate);
					if($statusinsert != false)
                    $this->data['error']='Thêm thành công';
                    else
                    $this->data['error']='Thêm thất bại';
                }
                //$url = $this->CI->config->base_url('?control=Miniapp&func=index');
                //echo("<script> top.location.href='" . $url . "'</script>");
                //redirect($url);
                //exit;
            }else{
                $this->data['error'] = 'Thông tin không chính xác..vui lòng thử lại';
                goto result;
            }
            
        }
    result:

        $arraylistapp = $_SESSION['listapp'];
        /*if(isset($arrayapp) && count($arrayapp)>=1) {
            foreach($arraylistapp as $key=>&$val){
                foreach($arrayapp  as $info){
                    if($info['id_app'] == $val['id_app'] ){
                        unset($arraylistapp[$key]);
                    }
                }
            }
        }*/
        rsort($arraylistapp);
        $this->data['slbApp'] = $arraylistapp;

        $arraylistevent = $_SESSION['listdefiney'];
        if(isset($arrayapp) && count($arrayapp)>=1) {
            foreach($arraylistevent as $key=>&$val){
                foreach($arrayapp  as $info){
                    if($info['id_event'] == $val['id'] ){
                        unset($arraylistevent[$key]);
                    }
                }
            }
        }
        if(count($arraylistevent)>=1)
		rsort($arraylistevent);
        $this->data['slType'] = $arraylistevent;

        /*
        $menus = $this->CI->MenuModel->getAllMenuApi();
        if (!empty($menus)) {
            $menu = array();
            foreach ($menus as $m) {
                $menu[$m['groupp']][] = $m;
            }

        }
        $this->data['result'] = $menu;
        */
                
        $this->CI->template->write_view('content', 'giftcodemobo/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());    
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
        if($result){
            $result = json_decode($result,true);
            if($result['code']==0){
                $result = $result['data'];
            }
        }
        return $result;
    }
    function isneed($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && isneed($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    public function getResponse() {
        return $this->_response;
    }
    public function listapibygame(MeAPI_RequestInterface $request){
        $this->CI->load->MeAPI_Model('MiniappModel');
        $alias_app = $request->input_get('alias_app');
		$data = array('code'=>-100,'message'=>'GET LIST FALIED');
        if(empty($alias_app)){
            echo json_encode($data);
            die;
        }
        $listapp = $this->CI->MiniappModel->listapibygame($alias_app);
		echo "<pre>";
		print_r($listapp);die;
        if($listapp){
            $data = array('code'=>0,'message'=>'GET LIST SUCCESSUL','data'=>$listapp);
        }
        echo json_encode($data);
        die;
    }
	public function toolconfig(MeAPI_RequestInterface $request){
		$link = $this->api_m_app . '/getallconfig';
		$getconfig = $this->curlGet($link);
		$this->data['listconfig'] = $getconfig;
        $this->CI->template->write_view('content', 'giftcodemobo/toolconfig_index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());   
	}
	public function addconfig(MeAPI_RequestInterface $request){
		
		$getconfig = "";
		if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $idget = $_GET['id'];
			$params = array('idapp'=>$idget);
			$link = $this->api_m_app . '/getconfigbyid?';
			$getconfig = $this->curlGet($link,$params);
        }
        
        if ($this->CI->input->post() && count($this->CI->input->post())>=1) {

            $id = $request->input_post('id');
            $event = $request->input_post('event');
            $note = $request->input_post('note');
			$name = $request->input_post('name');
			$type = $request->input_post('type');

            $isactive = ($request->input_post('isactive')=="on")?1:0;
			$paramsinsert= array(
                    "event"=>$event,
                    "note"=>$note,
					"name"=>$name,
					"type"=>$type,
                    "isactive"=>$isactive,
                    "insertDate"=>date('Y-m-d H:i:s',time())
                );
			if(!empty($id) && $id >=1){
                    $paramsinsert['id'] = $id;
                    $linkupdate = $this->api_m_app."updateconfigAdd";
                    $statusupdate = $this->curlPost($paramsinsert,$linkupdate);
                    if($statusupdate)
                    $this->data['error']='Cập nhât thành công';
                    else
                    $this->data['error']='Cập nhât thất bại';
            }else{
                    //kiem tra da ton tai id_app va note nay` chua...neu ton tai thi hok cho insert
                    $linkupdate = $this->api_m_app."insertconfigAdd";
                    $statusinsert = $this->curlPost($paramsinsert,$linkupdate);
                    if($statusinsert != false)
                    $this->data['error']='Thêm thành công';
                    else
                    $this->data['error']='Thêm thất bại';
            }
				
				
		}
			
		
		$this->data['configid'] = $getconfig;
        $this->CI->template->write_view('content', 'giftcodemobo/toolconfig_add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());   
	}
}