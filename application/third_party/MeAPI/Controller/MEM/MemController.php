<?php
class MeAPI_Controller_MEM_MemController implements MeAPI_Controller_MEM_MemInterface {
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
            $this->url_service = 'http://localhost.mem.net.vn';
            $this->url_image = $this->url_service.'/assets/mem';
        }else{
            $this->url_service = 'http://mem.mobo.vn';
            $this->url_image = $this->url_service.'/assets/mem';
        }
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'language':
                $this->data['title']= 'DANH SÁCH NGÔN NGỮ';
                break;
            case 'post':
                $this->data['title']= 'DANH SÁCH NỘI DUNG';
                $linkDefaultLanguage = $this->url_service.'/cms/mem/defaultlang';
                $j_defaultLanguage = file_get_contents($linkDefaultLanguage);
                $defaultLanguage = json_decode($j_defaultLanguage,true);
                $this->data['defaultLanguage'] = $defaultLanguage;
                if(isset($_POST['page'])){
                    $_SESSION['filter']['page'] = $_POST['page'];
                    $page = $_SESSION['filter']['page'];
                }
                break;
            case 'gallery':
                $this->data['title']= 'DANH SÁCH HÌNH ẢNH';
                $linkDefaultLanguage = $this->url_service.'/cms/mem/defaultlang';
                $j_defaultLanguage = file_get_contents($linkDefaultLanguage);
                $defaultLanguage = json_decode($j_defaultLanguage,true);
                $this->data['defaultLanguage'] = $defaultLanguage;
                if(isset($_POST['type'])){
                    $_SESSION['filter']['type'] = $_POST['type'];
                    $page = $_SESSION['filter']['type'];
                }
                break;
			case 'keyword':
                $this->data['title']= 'DANH SÁCH TỪ KHÓA';
                $linkDefaultLanguage = $this->url_service.'/cms/mem/defaultlang';
                $j_defaultLanguage = file_get_contents($linkDefaultLanguage);
                $defaultLanguage = json_decode($j_defaultLanguage,true);
                $this->data['defaultLanguage'] = $defaultLanguage;
                break;
        }
        $linkItem = $this->url_service.'/cms/mem/index_'.$_GET['view'].'?page='.$page;
        $j_listItem = file_get_contents($linkItem);
        $listItems = json_decode($j_listItem,true);
        $this->data['listItems'] = $listItems;
        $this->data['url_service'] = $this->url_service;
        $this->data['url_image'] = $this->url_image;
        $this->CI->template->write_view('content', 'mem/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'language':
                $this->data['title']= 'THÊM NGÔN NGỮ';
                break;
            case 'post':
                $this->data['title']= 'THÊM NỘI DUNG';
                $linkSlbLanguage = $this->url_service.'/cms/mem/slblanguage';
                $j_slbLanguage = file_get_contents($linkSlbLanguage);
                $slbLanguage = json_decode($j_slbLanguage,true);
                $this->data['slbLanguage'] = $slbLanguage;
                
                $this->data['items'] = $_POST;
                $this->data['items']['summary'] = $_POST['summary'];
                $this->data['items']['content'] = $_POST['content_mem'];
                if(isset($_POST) && count($_POST)>0){
                    $flag = 0;
                    if($_POST['page']==0){
                        $this->data['error']['page'] = '<div class="error" style="padding-left:0px">Chọn trang</div>';
                        $flag =1;
                        $this->data['items']['page']=0;
                    }
                    if($_FILES['image']['size'] > 1048576){
                        $this->data['error']['image'] = '<div class="error" style="padding-left:0px;">Dung lượng ảnh không được lớn hơn 700MB</div>';
                        $flag =1;
                    }
                    if($flag==0){
                        $this->post();
                    }
                }
                break;
            case 'gallery':
                $this->data['title']= 'THÊM HÌNH ẢNH';
                $linkSlbLanguage = $this->url_service.'/cms/mem/slblanguage';
                $j_slbLanguage = file_get_contents($linkSlbLanguage);
                $slbLanguage = json_decode($j_slbLanguage,true);
                $this->data['slbLanguage'] = $slbLanguage;
                
                $this->data['items'] = $_POST;
                if(isset($_POST) && count($_POST)>0){
                    $flag = 0;
                    if($_POST['type']==0){
                        $this->data['error']['type'] = '<div class="error" style="padding-left:0px;">Chọn loại hình ảnh</div>';
                        $flag =1;
                        $this->data['items']['type']=0;
                    }
                    if($_FILES['image']['size'] > 1048576){
                        $this->data['error']['image'] = '<div class="error" style="padding-left:0px;">Dung lượng ảnh không được lớn hơn 700MB</div>';
                        $flag =1;
                    }
                    if($_FILES['avatar']['size'] > 1048576){
                        $this->data['error']['avatar'] = '<div class="error" style="padding-left:0px;">Dung lượng ảnh không được lớn hơn 700MB</div>';
                        $flag =1;
                    }
                    if($flag==0){
                        $this->post_gallery();
                    }
                }
                break;
			case 'keyword':
                $this->data['title']= 'THÊM TỪ KHÓA';
                $linkSlbLanguage = $this->url_service.'/cms/mem/slblanguage';
                $j_slbLanguage = file_get_contents($linkSlbLanguage);
                $slbLanguage = json_decode($j_slbLanguage,true);
                $this->data['slbLanguage'] = $slbLanguage;
                
                $this->data['items'] = $_POST;
                $this->data['items']['value'] = $_POST['value'];
                if(isset($_POST) && count($_POST)>0){
                    $this->post_keyword();
                }
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->data['url_image'] = $this->url_image;
        $this->CI->template->write_view('content', 'mem/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'language':
                $this->data['title']= 'SỬA NGÔN NGỮ';
                $linkinfo = $this->url_service.'/cms/mem/get_language?id='.$id;
                $infoDetail = file_get_contents($linkinfo);
                $items = json_decode($infoDetail,true);
                $this->data['items'] = $items; 
                break;
            case 'post':
                $this->data['title']= 'SỬA NỘI DUNG';
                $linkSlbLanguage = $this->url_service.'/cms/mem/slblanguage';
                $j_slbLanguage = file_get_contents($linkSlbLanguage);
                $slbLanguage = json_decode($j_slbLanguage,true);
                $this->data['slbLanguage'] = $slbLanguage;
                
                $linkinfo = $this->url_service.'/cms/mem/get_post?id='.$id;
                $infoDetail = file_get_contents($linkinfo);
                $items = json_decode($infoDetail,true);
                $this->data['items'] = $items; 
                if(isset($_POST) && count($_POST)>0){
                    $this->data['items'] = $_POST;
                    $this->data['items']['summary'] = $_POST['summary'];
                    $this->data['items']['content'] = $_POST['content_mem'];
                    $this->data['items']['image'] = $_POST['current_image'];
                    $flag = 0;
                    if($_POST['page']==0){
                        $this->data['error']['page'] = '<div class="error" style="padding-left:0px;">Chọn trang</div>';
                        $flag =1;
                        $this->data['items']['page']=0;
                    }
                    if($_FILES['image']['size'] > 1048576){
                        $this->data['error']['image'] = '<div class="error" style="padding-left:0px;">Dung lượng ảnh không được lớn hơn 700MB</div>';
                        $flag =1;
                    }
                    if($flag==0){
                        $this->post();
                    }
                }
                break;
            case 'gallery':
                $this->data['title']= 'SỬA HÌNH ẢNH';
                $linkSlbLanguage = $this->url_service.'/cms/mem/slblanguage';
                $j_slbLanguage = file_get_contents($linkSlbLanguage);
                $slbLanguage = json_decode($j_slbLanguage,true);
                $this->data['slbLanguage'] = $slbLanguage;
                
                $linkinfo = $this->url_service.'/cms/mem/get_gallery?id='.$id;
                $infoDetail = file_get_contents($linkinfo);
                $items = json_decode($infoDetail,true);
                $this->data['items'] = $items; 
                if(isset($_POST) && count($_POST)>0){
                    $this->data['items'] = $_POST;
                    $this->data['items']['image'] = $_POST['current_image'];
                    $this->data['items']['avatar'] = $_POST['current_avatar'];
                    $flag = 0;
                    if($_POST['type']==0){
                        $this->data['error']['type'] = '<div class="error" style="padding-left:0px;">Chọn loại hình ảnh</div>';
                        $flag =1;
                        $this->data['items']['type']=0;
                    }
                    if($_FILES['image']['size'] > 1048576){
                        $this->data['error']['image'] = '<div class="error" style="padding-left:0px;">Dung lượng ảnh không được lớn hơn 700MB</div>';
                        $flag =1;
                    }
                    if($_FILES['avatar']['size'] > 1048576){
                        $this->data['error']['avatar'] = '<div class="error" style="padding-left:0px;">Dung lượng ảnh không được lớn hơn 700MB</div>';
                        $flag =1;
                    }
                    if($flag==0){
                        $this->post_gallery();
                    }
                }
                break;
			case 'keyword':
                $this->data['title']= 'THÊM TỪ KHÓA';
                $linkSlbLanguage = $this->url_service.'/cms/mem/slblanguage';
                $j_slbLanguage = file_get_contents($linkSlbLanguage);
                $slbLanguage = json_decode($j_slbLanguage,true);
                $this->data['slbLanguage'] = $slbLanguage;
                
                $linkinfo = $this->url_service.'/cms/mem/get_keyword?id='.$id;
                $infoDetail = file_get_contents($linkinfo);
                $items = json_decode($infoDetail,true);
                $this->data['items'] = $items; 
                if(isset($_POST) && count($_POST)>0){
                    $this->data['items'] = $_POST;
                    $this->data['items']['value'] = $_POST['value'];
                    $this->post_keyword();
                }
                break;
        }
        
        $this->data['url_service'] = $this->url_service;
        $this->data['url_image'] = $this->url_image;
        $this->CI->template->write_view('content', 'mem/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        if($_POST['cid']>0){
            foreach($_POST['cid'] as $v){
                $linkInfo = $this->url_service.'/cms/mem/delete_'.$_GET['view'].'?id='.$v;
                $j_items = file_get_contents($linkInfo);
            }
        }else{
            $linkInfo = $this->url_service.'/cms/mem/delete_'.$_GET['view'].'?id='.$id;
            $j_items = file_get_contents($linkInfo);
        }
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function sort(MeAPI_RequestInterface $request){
        $linkService = $this->url_service.'/cms/mem/sort_'.$_GET['view'];
        $arrParam = array(
            'listid'=>count($_POST['listid']>0)?@implode(',', $_POST['listid']):'',
            'listorder'=>count($_POST['listorder']>0)?@implode(',', $_POST['listorder']):''
        );
        
        $result = $this->curlPost($arrParam,array(),$linkService);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function post(){
        if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
            $_FILES['image']['encodefile'] = $this->data_uri($_FILES['image']['tmp_name'], $_FILES['image']['type']);
            $arrPOST = array('id'=>$_POST['id'],'current_image'=>$_POST['current_image']);
            $image = $this->curlPost($_FILES['image'],$arrPOST);
        }else{
            if($_POST['id']>0){
                $image = $_POST['current_image'];
            }
        }
        $android = $_POST['mobile_android']==1?'1':'0';
        $ios = $_POST['mobile_ios']==1?'1':'0';
        $wp = $_POST['mobile_wp']==1?'1':'0';
        $mobile = json_encode(array('android'=>$android,'ios'=>$ios,'wp'=>$wp));
        if($_POST['id']>0){
            $array['id'] = $_POST['id'];
            $array['image'] = $image;
            $array['is_active'] = $_POST['is_active'];
            $array['page'] = $_POST['page'];
            if(count($this->data['slbLanguage'])>0){
                foreach($this->data['slbLanguage'] as $lang){
                    $title['title_'.$lang['code']] = $_POST['title_'.$lang['code']];
                    $summary['summary_'.$lang['code']] = $_POST['summary_'.$lang['code']];
                    $content['content_'.$lang['code']] = $_POST['content_mem_'.$lang['code']];
                }
            }
            $array['title'] = json_encode($title);
            $array['summary'] = json_encode($summary);
            $array['content'] = json_encode($content);
            $array['link'] = $_POST['link'];
            $array['mobile'] =$mobile;
            $array['update_date'] =date('Y-m-d G:i:s');
			$array['status'] = $_POST['status'];
        }else{
            $array['image'] = $image;
            $array['is_active'] = $_POST['is_active'];
            $array['page'] = $_POST['page'];
            if(count($this->data['slbLanguage'])>0){
                foreach($this->data['slbLanguage'] as $lang){
                    $title['title_'.$lang['code']] = $_POST['title_'.$lang['code']];
                    $summary['summary_'.$lang['code']] = $_POST['summary_'.$lang['code']];
                    $content['content_'.$lang['code']] = $_POST['content_mem_'.$lang['code']];
                }
            }
            $array['title'] = json_encode($title);
            $array['summary'] = json_encode($summary);
            $array['content'] = json_encode($content);
            $array['link'] = $_POST['link'];
            $array['mobile'] =$mobile;
            $array['created_date'] =date('Y-m-d G:i:s');
            $array['update_date'] =date('Y-m-d G:i:s');
			$array['status'] = $_POST['status'];
        }

        $action = ($_POST['id']>0)?'edit_post':'add_post';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/mem/".$action);
        $result = json_decode($result,true);
        if($_GET['type']==1){
            if($_GET['func']=='add'){
                redirect(base_url().'?control='.$_GET['control'].'&func=edit&view=post&module=all&id='.$result['data']);
            }else{
                redirect(base_url().'?control='.$_GET['control'].'&func=edit&view=post&module=all&id='.$_POST['id']);
            }
        }else{
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view=post&module=all');
        }
    }
    
    public function post_gallery(){
        if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
            $_FILES['image']['encodefile'] = $this->data_uri($_FILES['image']['tmp_name'], $_FILES['image']['type']);
            $arrPOST = array('id'=>$_POST['id'],'current_image'=>$_POST['current_image']);
            $image = $this->curlPost($_FILES['image'],$arrPOST,$this->url_service."/cms/mem/save_gallery_image");
        }else{
            if($_POST['id']>0){
                $image = $_POST['current_image'];
            }
        }
        if(isset($_FILES['avatar']['tmp_name']) && !empty($_FILES['avatar']['tmp_name'])){
            $_FILES['avatar']['encodefile'] = $this->data_uri($_FILES['avatar']['tmp_name'], $_FILES['avatar']['type']);
            $arrPOSTAvatar = array('id'=>$_POST['id'],'current_avatar'=>$_POST['current_avatar']);
            $avatar = $this->curlPost($_FILES['avatar'],$arrPOSTAvatar,$this->url_service."/cms/mem/save_gallery_avatar");
        }else{
            if($_POST['id']>0){
                $avatar = $_POST['current_avatar'];
            }
        }
        if($_POST['id']>0){
            $array['id'] = $_POST['id'];
            if(count($this->data['slbLanguage'])>0){
                foreach($this->data['slbLanguage'] as $lang){
                    $name['name_'.$lang['code']] = $_POST['name_'.$lang['code']];
                }
            }
            $array['name'] = json_encode($name);
            $array['image'] = $image;
            $array['avatar'] = $avatar;
            $array['link'] = $_POST['link'];
            $array['type'] = $_POST['type'];
        }else{
            if(count($this->data['slbLanguage'])>0){
                foreach($this->data['slbLanguage'] as $lang){
                    $name['name_'.$lang['code']] = $_POST['name_'.$lang['code']];
                }
            }
            $array['name'] = json_encode($name);
            $array['image'] = $image;
            $array['avatar'] = $avatar;
            $array['link'] = $_POST['link'];
            $array['type'] = $_POST['type'];
            $array['created_date'] =date('Y-m-d G:i:s');
        }

        $action = ($_POST['id']>0)?'edit_gallery':'add_gallery';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/mem/".$action);
        $result = json_decode($result,true);
        if($_GET['type']==1){
            if($_GET['func']=='add'){
                redirect(base_url().'?control='.$_GET['control'].'&func=edit&view=gallery&module=all&id='.$result['data']);
            }else{
                redirect(base_url().'?control='.$_GET['control'].'&func=edit&view=gallery&module=all&id='.$_POST['id']);
            }
        }else{
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view=gallery&module=all');
        }
    }
	public function post_keyword(){
        if($_POST['id']>0){
            $array['id'] = $_POST['id'];
            if(count($this->data['slbLanguage'])>0){
                foreach($this->data['slbLanguage'] as $lang){
                    $value['value_'.$lang['code']] = $_POST['value_'.$lang['code']];
                }
            }
            $array['value'] = json_encode($value);
            $array['name'] = $_POST['name'];
        }else{
            if(count($this->data['slbLanguage'])>0){
                foreach($this->data['slbLanguage'] as $lang){
                    $value['value_'.$lang['code']] = $_POST['value_'.$lang['code']];
                }
            }
            $array['value'] = json_encode($value);
            $array['name'] = $_POST['name'];
        }
        
        $action = ($_POST['id']>0)?'edit_keyword':'add_keyword';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/mem/".$action);
        $result = json_decode($result,true);
        if($_GET['type']==1){
            if($_GET['func']=='add'){
                redirect(base_url().'?control='.$_GET['control'].'&func=edit&view=keyword&module=all&id='.$result['data']);
            }else{
                redirect(base_url().'?control='.$_GET['control'].'&func=edit&view=keyword&module=all&id='.$_POST['id']);
            }
        }else{
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view=keyword&module=all');
        }
    }
    public function getResponse() {
        return $this->_response;
    }
    public function curlPost($params,$post,$link=''){
        $arrParam = array_merge($params,$post);
        $this->last_link_request = empty($link)?$this->url_service."/cms/mem/save_image":$link;
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
        $this->last_link_request = empty($link)?$this->url_service."/cms/mem/save_image":$link;	
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