<?php
class MeAPI_Controller_Nutme_FacebookConfigController implements MeAPI_Controller_Nutme_FacebookConfigInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    private $urlService;
    private $_game;
    private $_view = 'nutme/facebookconfig/';
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('Nutme/FacebookConfigModel');
        $this->CI->load->MeAPI_Validate('Nutme/FacebookConfigValidate');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        if(!empty($_GET['idgame'])){
            $this->_game = '&idgame='.$_GET['idgame'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$this->_game.$page;
        //link service
        if(!empty($_GET['idgame'])){
            $getItemGame = $this->CI->FacebookConfigModel->getItemByGame($_GET['idgame']);
            if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") {
                switch ($getItemGame['alias']){
                    case 'phongthan':
                        $this->urlService = $this->data['urlService'] = 'http://localhost.service.phongthan.mobo.vn/cms/facebook_config/';
                        break;
                    case 'hiepkhach':
                        $this->urlService = $this->data['urlService'] = 'http://localhost.game.mobo.vn/hiepkhach/index.php/cms/facebook_config/';
                        break;
                }
            }else{
                $this->urlService = $this->data['urlService'] = $getItemGame['domain'].'/cms/facebook_config/';
            }
        }//echo $this->urlService;
        //default lang
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Danh sách cấu hình facebook';
        $this->data['slbGame'] = $this->CI->FacebookConfigModel->slbGame();
        
        $linkService = $this->urlService.'index';
        $j_listItems = @file_get_contents($linkService);
        $listItems = json_decode($j_listItems,true);
        $this->data['listItems'] = $listItems;
        $this->data['urlService'] = $this->urlService;
        if($_REQUEST['ajax_active']!=1){
            $this->CI->template->write_view('content', $this->_view.'index', $this->data);
            $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
        }else{
            echo $this->CI->load->view($this->_view.'load-index', $this->data, true);
            die();
        }
        
    }
    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm cấu hình facebook';
        $this->data['slbGame'] = $this->CI->FacebookConfigModel->slbGame();
        $this->data['urlService'] = $this->urlService;
        if ($this->CI->input->post()){
            $this->CI->FacebookConfigValidate->validateForm($this->CI->input->post());
            if($this->CI->FacebookConfigValidate->isVaild()){
                $errors = $this->CI->FacebookConfigValidate->getMessageErrors();
                $items = $this->CI->FacebookConfigValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->FacebookConfigValidate->getData();
                $linkService = $this->urlService.'add';
                $j_result = $this->curlPost($data,$linkService);
                 
                $result = json_decode($j_result,true);
                if($_GET['types']==1){
                    if($_GET['page']>0){
                        $page = '&page='.$_GET['page'];
                    }
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$result['id'].$this->_game.$page);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->CI->template->write_view('content', $this->_view.'add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sửa cấu hình facebook';
        $this->data['slbGame'] = $this->CI->FacebookConfigModel->slbGame();
        $this->data['urlService'] = $this->urlService;
        $linkService = $this->urlService.'getItem?id='.$_GET['id'];
        $j_items = file_get_contents($linkService);
        $items = json_decode($j_items,true);
        $this->data['items'] = $items;
        
        if ($this->CI->input->post()){
            $this->CI->FacebookConfigValidate->validateForm($this->CI->input->post());
            if($this->CI->FacebookConfigValidate->isVaild()){
                $errors = $this->CI->FacebookConfigValidate->getMessageErrors();
                $items = $this->CI->FacebookConfigValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->FacebookConfigValidate->getData();
                $linkService = $this->urlService.'edit';
                $result = $this->curlPost($data,$linkService);
                
                if($_GET['types']==1){
                    if($_GET['page']>0){
                        $page = '&page='.$_GET['page'];
                    }
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$_GET['id'].$this->_game.$page);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->CI->template->write_view('content', $this->_view.'add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function status(MeAPI_RequestInterface $request){
        $linkService = $this->urlService.'status';
        $arrParam = array(
            'cid'=> count($_POST['cid']>0)?@implode(',', $_POST['cid']):'',
            'type'=>$_GET['type'],
            'id'=>($_GET['id']>0)?$_GET['id']:'',
            's'=>$_GET['s']
        );
        $result = $this->curlPost($arrParam,$linkService);
        redirect($this->_mainAction);
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkService = $this->urlService.'delete';
        $arrParam = array(
            'cid'=> count($_POST['cid']>0)?@implode(',', $_POST['cid']):'',
            'type'=>$_GET['type'],
            'id'=>$_GET['id']
        );
        $result = $this->curlPost($arrParam,$linkService);
        redirect($this->_mainAction);
    }
    public function getResponse() {
        return $this->_response;
    }
    public function curlPost($arrParam,$link=''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_URL,$link);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrParam);
        $result = curl_exec($ch);
        return $result;
    }
}