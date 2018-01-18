<?php
class MeAPI_Controller_Game_BuyAccountController implements MeAPI_Controller_Game_BuyAccountInterface {
    protected $_response;
    private $CI;
    private $url_service;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.account.mobo.vn';
            $this->url_picture = 'http://localhost.account.mobo.vn/assets/buyaccount';
        }else{
            $this->url_service = 'http://acc.mobo.vn';
            $this->url_picture = $this->url_service.'/assets/buyaccount';
        }
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'game':
                $this->data['title']= 'DANH SÁCH GAME';
                $this->data['url_picture'] = $this->url_picture;
            break;
        }
        $linkItem = $this->url_service.'/cms/buyaccount/index_'.$_GET['view'];
        $j_listItem = file_get_contents($linkItem);
        $listItems = json_decode($j_listItem,true);
        $this->data['listItems'] = $listItems;
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/buyaccount/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'game':
                $this->data['title']= 'THÊM GAME';
                $this->data['url_picture'] = $this->url_picture;
            break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/buyaccount/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'game':
                $this->data['title']= 'SỬA GAME';
                $this->data['url_picture'] = $this->url_picture;
            break;
        }
        $id = $_GET['id'];
        $linkinfo = $this->url_service.'/cms/buyaccount/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        
        $this->CI->template->write_view('content', 'game/buyaccount/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        if($_POST['cid']>0){
            foreach($_POST['cid'] as $v){
                $linkInfo = $this->url_service.'/cms/buyaccount/delete_'.$_GET['view'].'?id='.$v;
                $j_items = file_get_contents($linkInfo);
            }
        }else{
            $linkInfo = $this->url_service.'/cms/buyaccount/delete_'.$_GET['view'].'?id='.$id;
            $j_items = file_get_contents($linkInfo);
        }
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function sort(MeAPI_RequestInterface $request){
        $linkService = $this->url_service.'/cms/buyaccount/sort';
        $arrParam = array(
            'listid'=>count($_POST['listid']>0)?@implode(',', $_POST['listid']):'',
            'listorder'=>count($_POST['listorder']>0)?@implode(',', $_POST['listorder']):''
        );
        
        $result = $this->curlPost($arrParam,array(),$linkService);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function post(MeAPI_RequestInterface $request){
        if(isset($_FILES['picture']['tmp_name']) && !empty($_FILES['picture']['tmp_name'])){
            if($_FILES['picture']['size'] > 1048576){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700MB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }else{
                $_FILES['picture']['encodefile'] = $this->data_uri($_FILES['picture']['tmp_name'], $_FILES['picture']['type']);
                $arrPOST = array('id'=>$_POST['id'],'current_picture'=>$_POST['current_picture']);
                $picture = $this->curlPost($_FILES['picture'],$arrPOST);
            }
        }else{
            if($_POST['id']>0){
                $picture = $_POST['current_picture'];
            }
        }
        
        if($_POST['id']>0){
            $array = array(
                'id'=>$_POST['id'],
                'name'=>$_POST['name'],
                'app'=>$_POST['app'],
                'service_id'=>$_POST['service_id'],
                'service_name'=>$_POST['service_name'],
                'picture'=>$picture,
                'type'=>$_POST['type'],
                'item_id'=>$_POST['item_id'],
				'api_secret'=>$_POST['api_secret'],
            );
        }else{
            $array = array(
                'name'=>$_POST['name'],
                'app'=>$_POST['app'],
                'service_id'=>$_POST['service_id'],
                'service_name'=>$_POST['service_name'],
                'picture'=>$picture,
                'type'=>$_POST['type'],
                'item_id'=>$_POST['item_id'],
				'api_secret'=>$_POST['api_secret'],
            );
        }
        
        $action = ($_POST['id']>0)?'edit_game':'add_game';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/buyaccount/".$action);        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
    
    public function getResponse() {
        return $this->_response;
    }
    public function curlPost($params,$post,$link=''){
        $arrParam = array_merge($params,$post);
        $this->last_link_request = empty($link)?$this->url_service."/cms/buyaccount/save_image":$link;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($arrParam));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrParam);
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
    function data_uri($file, $mime='image/jpeg'){
        if(empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    public function curlPostAPI($params,$link=''){
        $this->last_link_request = empty($link)?$this->url_service."/cms/buyaccount/save_image":$link;	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);        
        return $result;
    }
}