<?php
/*
1: created menu config to api service willl reponse getalllistnagator and link update(or params, insert)
2: load category by game, Edit ,Insert
*/
error_reporting(0);
class MeAPI_Controller_SocialmeController implements MeAPI_Controller_SocialmeInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    public $defineType = array();
	private $tbl_navigator = "share_facebook_game";
    private $api_mapp;
    protected $_response;
	
	private $configlink = array(
		'getcategoryall'=>'/responseginside/getcategoryall',
		'getcategorybyid'=>'/responseginside/getcategorybyid',
		'update'=>'/responseginside/update',
		'delete'=>'/responseginside/delete',
		'insert'=>'/responseginside/insert');
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
        $ch = curl_init();
        //echo $this->last_link_request ;
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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
    public function index(MeAPI_RequestInterface $request) {
	
        $this->authorize->validateAuthorizeRequest($request, 0);
		
		$this->CI->load->MeAPI_Model('SocialmeModel');
		$loadnavigators = $this->CI->SocialmeModel->getnavigatorall();
        $this->data['slbApp'] = $loadnavigators;
        $this->CI->template->write_view('content', 'socialme/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function loadtypeevent(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $params = addslashes($_POST['typeevent']);
        if(isset($_POST['id']) && !empty($_POST['id'])){
           // $this->CI->load->MeAPI_Model('socialmeModel');
            $link =$this->api_m_app.'getmapp?';
            $mapp = $this->curlGet($link,array('id'=>$_POST['id']) );
            //$mapp = $this->CI->socialmeModel->getmapp($_POST['id']);

            if($mapp){
                $this->data['detail'] = $mapp;
            }
        }
        //get info data;
        //check if exits get id then , access db to get info by id

        $c = $this->CI->load->view('socialme/loadajax/type_'.$params, $this->data,true);
        echo json_encode($c);
        die;
    }
    public function loadtypeeventcontent(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id_event = addslashes($_POST['typeevent']);
		echo $id_event;die;
		
		$this->CI->load->MeAPI_Model('SocialmeModel');
		$loadnavigators = $this->CI->SocialmeModel->getnavigatorall();
		$linkdomain = '';
        $idgame = "";
		
		echo "<pre>";
		print_r($loadnavigators);die;
		foreach($loadnavigators as $val){
			if($id_event == $val['alias'] ){
				$linkdomain = $val['domain'];
                $idgame = $val['id'];
				break;
			}
		}
        if(empty($linkdomain)){
            echo '';
            die;
        }
        $link =$linkdomain.$this->configlink['getcategoryall'];
		
		$getcategoryall = $this->curlGet($link);
		 if(empty($getcategoryall)){
            echo '';
            die;
        }
        //get info data;
        //check if exits get id then , access db to get info by id
        $tbody = "";
        $i = 1;
        foreach($getcategoryall as $val){
            $edit = "<a href='".base_url()."?control=socialme&func=addmenu&game=".$idgame."&id=".$val['service_id']."'><img src='".base_url()."assets/img/icon/icon_edit.png'></a>";
            $tbody.= "<tr>";
            $tbody.="<td>".$i."</td>";
            $tbody.="<td>".$val['service_id']."</td>";
            $tbody.="<td>".$val['service_title']."</td>";
            $tbody.="<td>".$val['service_url']."</td>";
            $tbody.="<td>".$val['service_author']."</td>";
            $tbody.="<td>".$val['service_status']."</td>";
            $tbody.="<td>".$val['service_ishot']."</td>";
            $tbody.="<td>".$val['service_lang']."</td>";
            $tbody.="<td align='center'>".$edit."</td>";
            $tbody.= "</tr>";
            $i++;
        }
        echo $tbody;
        die;
    }
    public function loadbyapp(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        //$this->CI->load->MeAPI_Model('socialmeModel');
        $id_event = 0;
        if(isset($_POST['idapp']) && is_numeric($_POST['idapp'])){
            //if la co id

            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                $link = $this->api_m_app . 'getmapp?';
                $mapp = $this->curlGet($link,array("id"=>$_GET['id']));
                //$mapp = $this->CI->socialmeModel->getmapp($_GET['id']);
                if ($mapp) {
                    $link = $this->api_m_app . 'getallappbyid?';
                    $arrayapp = $this->curlGet($link,array("id_app"=>$mapp['id_app'],"id_event"=>$mapp['id_event']));

                    //$arrayapp = $this->CI->socialmeModel->getallappbyid($mapp['id_app'], $mapp['id_event']);
                    $id_event = $mapp['id_event'];
                }
            }else {
                $link = $this->api_m_app . 'getallapp?';
                $arrayapp = $this->curlGet($link,array("idapp"=>$_POST['idapp']));
                //$arrayapp = $this->CI->socialmeModel->getallapp($_POST['idapp']);
            }
            if(empty($_SESSION['listdefiney'])){
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
            }
            rsort($arraylistapp);
            $html = "";
            foreach($arraylistapp as $v){
                $selected = ($v['id']==$id_event)?'selected="selected"':"";
                $html.="<option  value=".$v['type']."_".$v['id'].$selected .">".$v['name']."</option>";
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
        //$this->CI->load->MeAPI_Model('socialmeModel');
        $this->data['display_name'] = '';
        $this->data['relative_url'] = '';
        $this->data['permission'] = 0;
        $this->data['order'] = 0;
        $this->data['menu_group_id'] = 0;
        $this->data['error'] ='';

        $linkdomain = '';
        $id_sevice = $_GET['id'];
        $this->CI->load->MeAPI_Model('SocialmeModel');
        $loadnavigators = $this->CI->SocialmeModel->getnavigatorall();
		
        if(isset($_GET['game']) && $_GET['game']>=1 ){
            foreach($loadnavigators as $val){
                if($_GET['game'] == $val['id']){
                    $this->data['slbApp'][] = $val;
                    $linkdomain = $val['domain'];
                    break;
                }
            }
        }else{
            $this->data['slbApp'] = $loadnavigators;
        }
		
        if(empty($linkdomain) ){
            echo 'Thông tin không chính xác Game..vui lòng thử lại[1]';
			die;
            goto result;
        }
        $link =$linkdomain.$this->configlink['getcategorybyid']."?id=".$id_sevice;
		
        $getcategorydetail = $this->curlGet($link);
        if(empty($getcategorydetail)){
            $this->data['error'] = 'Sự cố đường truyền.tạm thời không lấy được thông tin[1]';
            goto result;
        }
        $this->data['items'] = $getcategorydetail;
        
        if ($this->CI->input->post() && count($this->CI->input->post())>=1) {

            $service_android = isset($_POST['service_android'])?$_POST['service_android']:0;
            $service_ios = isset($_POST['service_ios'])?$_POST['service_ios']:0;
            $service_wp = isset($_POST['service_wp'])?$_POST['service_wp']:0;
            $service_trustip = !empty($_POST['service_trustip'])?$_POST['service_trustip']:"";
            $service_title = addslashes($_POST['title']);
            $service_url = addslashes($_POST['link']);
            $service_status = addslashes($_POST['service_status']);
            $service_lang = $_POST['service_lang'];
			
			if(empty($service_lang)|| !is_array($service_lang)){
				$this->data['error'] = 'Bạn chưa chọn ngôn ngữ[1]';
				goto result;
			}
			$service_lang = implode(",",$service_lang);
            $service_ishot = addslashes($_POST['service_ishot']);
			
			$service_start = addslashes($_POST['startdate']);
            $service_end = addslashes($_POST['enddate']);
			
            $jsonitem = array();

            if(isset($_POST['service_trustserver']) && is_array($_POST['service_trustserver'])){
                $service_start = $_POST['service_start'];
                $service_end = $_POST['service_end'];
                foreach($_POST['service_trustserver'] as $key=>$val){
                    $jsonitem[$val] = array('server_id'=>$val,'service_start'=>$service_start[$key],'service_end'=>$service_end[$key]);
                }
            }
            $parseJson = json_encode($jsonitem);


            if(!empty($service_url)  && !empty($service_title)   ){
                //luu id

                $arrayevent =array();
				
                $paramsinsert= array(
                    "service_trustip"=>$service_trustip,
                    "service_title"=>$service_title,
                    "service_insert"=>date('Y-m-d H:i:s',time()),
                    "service_status"=>$service_status,
                    "service_author"=>$_SESSION['account']['username'],
                    "service_url"=>$service_url,
                    "service_ishot"=>$service_ishot,
                    "service_android"=>$service_android,
                    "service_ios"=>$service_ios,
                    "service_wp"=>$service_wp,
                    "service_language"=>$service_lang,
					"service_start"=>$service_start,
					"service_end"=>$service_end,
                    "jsonRule"=>$parseJson
                );
				if(empty($paramsinsert['service_trustip'])){
					unset($paramsinsert['service_trustip']);
				}

                if(!empty($id_sevice) && $id_sevice >=1){
                    $paramsinsert['service_id'] = $id_sevice;
                    $link =$linkdomain.$this->configlink['update'];
                    $statusupdate = $this->curlPost($paramsinsert,$link);
                    if($statusupdate)
                    $this->data['error']='Cập nhât thành công';
                    else
                    $this->data['error']='Cập nhât thất bại';
                }else{
                    //kiem tra da ton tai id_app va note nay` chua...neu ton tai thi hok cho insert
                    $link =$linkdomain.$this->configlink['insert'];
                    $statusinsert = $this->curlPost($paramsinsert,$link);
                    if($statusinsert != false)
                    $this->data['error']='Thêm thành công';
                    else
                    $this->data['error']='Thêm thất bại';
                }
                //$url = $this->CI->config->base_url('?control=socialme&func=index');
                //echo("<script> top.location.href='" . $url . "'</script>");
                //redirect($url);
                //exit;
            }else{
                $this->data['error'] = 'Thông tin không chính xác..vui lòng thử lại';
                goto result;
            }
            
        }
    result:

        $this->CI->template->write_view('content', 'socialme/add', $this->data);
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
        $this->CI->load->MeAPI_Model('socialmeModel');
        $alias_app = $request->input_get('alias_app');
        $data = array('code'=>-100,'message'=>'GET LIST FALIED');
        if(empty($alias_app)){
            echo json_encode($data);
            die;
        }
        $listapp = $this->CI->socialmeModel->listapibygame($alias_app);
        if($listapp){
            $data = array('code'=>0,'message'=>'GET LIST SUCCESSUL','data'=>$listapp);
        }
        echo json_encode($data);
        die;
    }
	public function configmenu(MeAPI_RequestInterface $request){
		$this->CI->load->MeAPI_Model('SocialmeModel');
		$loadnavigators = $this->CI->SocialmeModel->getnavigatorall();
		$this->data['listconfig'] = $loadnavigators;
        $this->CI->template->write_view('content', 'socialme/toolconfig_index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());   
	}
	public function configmenuadd(MeAPI_RequestInterface $request){
		$this->CI->load->MeAPI_Model('SocialmeModel');
		$getconfig = "";
		if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $idget = $_GET['id'];
			$getconfig = $this->CI->SocialmeModel->getnavigator($idget);
        }
        
        if ($this->CI->input->post() && count($this->CI->input->post())>=1) {

            $id = $request->input_post('id');
            $name = $request->input_post('name');
            $alias = $request->input_post('alias');
			$linkdomain = $request->input_post('linkdomain');
			
			$paramsinsert= array(
					"game"=>$name,
					"alias"=>$alias,
                    "domain"=>$linkdomain
            );
			if(!empty($id) && $id >=1){
                    $whereUpdate=  array('id'=>$id);
					$statusupdate = $this->CI->SocialmeModel->update($this->tbl_navigator,$paramsinsert,$whereUpdate);
					if($statusupdate)
                    $this->data['error']='Cập nhât thành công';
                    else
                    $this->data['error']='Cập nhât thất bại';
            }else{
                    //kiem tra da ton tai id_app va note nay` chua...neu ton tai thi hok cho insert
                    $statusinsert = $this->CI->SocialmeModel->insert_id($this->tbl_navigator,$paramsinsert);
                    if($statusinsert != false)
                    $this->data['error']='Thêm thành công';
                    else
                    $this->data['error']='Thêm thất bại';
            }
				
				
		}
			
		
		$this->data['configid'] = $getconfig;
        $this->CI->template->write_view('content', 'socialme/toolconfig_add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());   
	}
}