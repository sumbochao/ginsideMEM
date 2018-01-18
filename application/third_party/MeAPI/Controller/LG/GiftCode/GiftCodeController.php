<?php
class MeAPI_Controller_LG_GiftCode_GiftCodeController implements MeAPI_Controller_LG_GiftCode_GiftCodeInterface {
    protected $_response;
    private $CI;
    private $url_service;
    private $secret_key = "qgvQ^cD#h68_h9_Hu9+";
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');        
        
        $this->view_data = new stdClass();
        $this->url_service = 'https://lg.addgold.net';
        $this->data['url_service'] = $this->url_service;
		if(!empty($_GET['code_type'])){
            $code_type = '&code_type='.$_GET['code_type'];
        }
        if(!empty($_GET['token'])){
            $token = '&token='.$_GET['token'];
        }
        $this->_mainAction = base_url() . '?control=' . $_GET['control'] . '&func=index&view='.$_GET['view'].'&module=all'.$code_type.$token;
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'typecode':
                $this->data['title']= 'DANH SÁCH LOẠI CODE';
                $linkTypeCode = $this->url_service.'/cms/toolgiftcode/code_type';
                $infoTypeCode = file_get_contents($linkTypeCode);                
                $this->data['listItems'] = json_decode($infoTypeCode,true);  
            break;
            case 'giftcode':
                $this->data['title']= 'DANH SÁCH CODE';
                $linkTypeCode = $this->url_service.'/cms/toolgiftcode/code_type';
                $slbTypeCode = file_get_contents($linkTypeCode);                
                $this->data['slbTypeCode'] = json_decode($slbTypeCode,true);
                
                $linkGiftCode = $this->url_service.'/cms/toolgiftcode/code_list?code_type='.$_GET['code_type'].'&token='.$_GET['token'];
                $infoGiftCode = file_get_contents($linkGiftCode);
                $data = json_decode($infoGiftCode,true);
                if($data['result']=='-1'){
                    $this->data['listItems']['result'] = '-1';
                }else{
                    $this->data['listItems']['result'] = '0';
                    if(count($data['rows'])>0){
                        $this->data['listItems']['data'] = $data['rows'];
                    }
                }
                //echo "<pre>";print_r($this->data['listItems']);die();
            break;
        }
        if($_REQUEST['ajax_active']!=1){
            $this->CI->template->write_view('content', 'game/lg/GiftCode/'.$_GET['view'].'/index', $this->data);
            $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
        }else{
            if(empty($_POST['code_type'])){
                $this->data['errors'] = 'Vui lòng chọn loại code';
            }else{
                $arrParam = $this->CI->input->post();
                $addData = array("code_type" => $arrParam['code_type']);
                $addData["token"] = md5(implode("", $addData) . $this->secret_key);                
                $url_data = $this->url_service.'/cms/toolgiftcode/code_list?' . http_build_query($addData);
                $infoGiftCode = @file_get_contents($url_data);                
                $data = json_decode($infoGiftCode,true);                
                $this->data['code_type']= $arrParam['code_type'];   
                $this->data['token']= $addData["token"];   
                if($data['result']=='-1'){
                    $this->data['listItems']['result'] = '-1';
                }else{
                    $this->data['listItems']['result'] = '0';
                    if(count($data['rows'])>0){
                        $this->data['listItems']['data'] = $data['rows'];
                    }
                }
            }
            $f = array(
                'token'=>$addData["token"],
                'html'=>$this->CI->load->view('game/lg/GiftCode/'.$_GET['view'].'/loadgiftcode', $this->data, true)
            );
            echo json_encode($f);
            die();
        }
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'typecode':
                $this->data['title']= 'THÊM LOẠI CODE';
                if ($this->CI->input->post()){
                    if(empty($_POST['code_type'])){
                        $this->data['errors'] = 'Vui lòng nhập loại code';
                    }else{
                        $arrParam = $this->CI->input->post();
                        $addData = array("code_type" => $arrParam['code_type']);
                        $addData["token"] = md5(implode("", $addData) . $this->secret_key);                
                        $url_data = $this->url_service.'/cms/toolgiftcode/add_code_type?' . http_build_query($addData);
                        @file_get_contents($url_data);
                        redirect($this->_mainAction);
                        
                    }
                }
            break;
            case 'giftcode':
                $this->data['title']= 'THÊM CODE';                
                if ($this->CI->input->post()){
                    if(empty($_POST['code_type'])){
                        $this->data['errors']['code_type'] = 'Vui lòng nhập loại code';
                    }
                    if(empty($_POST['giftcode_value'])){
                        $this->data['errors']['giftcode_value'] = 'Vui lòng nhập giá trị';
                    }
                    if(empty($_POST['code_quantity'])){
                        $this->data['errors']['code_quantity'] = 'Vui lòng nhập số lượng';
                    }
                    if(empty($_POST['ause_username'])){
                        $this->data['errors']['ause_username'] = 'Vui lòng nhập username';
                    }
                    if(!empty($_POST['code_type']) && !empty($_POST['giftcode_value'])&& !empty($_POST['code_quantity'])&& !empty($_POST['ause_username'])){
                        $arrParam = $this->CI->input->post();
                        $addData = array(
                            "giftcode_value"=>$arrParam['giftcode_value'],
                            "code_quantity"=>$arrParam['code_quantity'],
                            "ause_username"=>$arrParam['ause_username'],
                            "code_type" => $arrParam['code_type']
                            );
                        $addData["token"] = md5(implode("", $addData) . $this->secret_key);                
                        $url_data = $this->url_service.'/cms/toolgiftcode/gen_code?' . http_build_query($addData);
                        @file_get_contents($url_data);
                        redirect($this->_mainAction);
                        
                    }
                }
            break;
        }
        $this->CI->template->write_view('content', 'game/lg/GiftCode/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    
    public function getResponse() {
        return $this->_response;
    }
}