<?php
class MeAPI_Controller_Nutme_NavigatorController implements MeAPI_Controller_Nutme_NavigatorInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    private $urlService;
    private $_game;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('Nutme/NavigatorModel');
        $this->CI->load->MeAPI_Validate('Nutme/NavigatorValidate');
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
            $getItemGame = $this->CI->NavigatorModel->getItemByGame($_GET['idgame']);
            if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") {
                switch ($getItemGame['alias']){
                    case 'phongthan':
                        $this->urlService = $this->data['urlService'] = 'http://localhost.service.phongthan.mobo.vn';
                        break;
                    case 'hiepkhach':
                        $this->urlService = $this->data['urlService'] = 'http://localhost.game.mobo.vn/hiepkhach/index.php';
                        break;
                }
            }else{
                $this->urlService = $this->data['urlService'] = $getItemGame['domain'];
            }
        }
        //default lang
        $lang = $this->CI->NavigatorModel->defaultLang();
        $this->data['language'] = $lang['alias'];
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Danh sách sự kiện';
        $this->data['slbGame'] = $this->CI->NavigatorModel->slbGame();
        
        $linkService = $this->urlService.'/navigator_ginside/index';
        $j_listItems = @file_get_contents($linkService);
        $listItems = json_decode($j_listItems,true);
        $this->data['listItems'] = $listItems;
        $this->data['urlService'] = $this->urlService;
        if($_REQUEST['ajax_active']!=1){
            $this->CI->template->write_view('content', 'nutme/navigator/index', $this->data);
            $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
        }else{
            echo $this->CI->load->view('nutme/navigator/loadnavigator', $this->data, true);
            die();
        }
        
    }
    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm sự kiện';
        $this->data['slbGame'] = $this->CI->NavigatorModel->slbGame();
        $this->data['listLang'] = $this->CI->NavigatorModel->listItemLang();
        $this->data['urlService'] = $this->urlService;
        if ($this->CI->input->post()){
            $this->CI->NavigatorValidate->validateForm($this->CI->input->post());
            if($this->CI->NavigatorValidate->isVaild()){
                $errors = $this->CI->NavigatorValidate->getMessageErrors();
                $items = $this->CI->NavigatorValidate->getData();
                $jsonRule = '';
                $arrServer_id = $items['server_id'];
                $arrService_starts = $items['service_starts'];
                $arrService_ends = $items['service_ends'];
                $arrItems = array();
                for($i=0;$i<count($arrServer_id);$i++){
                    $arrItems[$arrServer_id[$i]] = array(
                        'server_id' =>$arrServer_id[$i],
                        'service_start'=>$arrService_starts[$i],
                        'service_end'=>$arrService_ends[$i],
                    );
                }
                $jsonRule = json_encode($arrItems);
                $items['jsonRule'] = $jsonRule;
                
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->NavigatorValidate->getData();
                $jsonRule = '';
                $arrServer_id = $data['server_id'];
                $arrService_starts = $data['service_starts'];
                $arrService_ends = $data['service_ends'];
                $arrItems = array();
                for($i=0;$i<count($arrServer_id);$i++){
                    $arrItems[$arrServer_id[$i]] = array(
                        'server_id' =>$arrServer_id[$i],
                        'service_start'=>$arrService_starts[$i],
                        'service_end'=>$arrService_ends[$i],
                    );
                }
                
                $jsonRule = json_encode($arrItems);
                $data['jsonRule'] = $jsonRule;
                $strLang  = '';
                if(count($this->data['listLang'])>0){
                    foreach($this->data['listLang'] as $lang){
                        $arrLang[$lang['alias']] = $lang['alias'];
                    }
                    $strLang = @implode(',', $arrLang);
                }
                $data['strlang'] = $strLang;
                $data['service_author']= $this->data['session_account']['username'];
               
                $linkService = $this->urlService.'/navigator_ginside/add';
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
        $this->CI->template->write_view('content', 'nutme/navigator/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sửa sự kiện';
        $this->data['slbGame'] = $this->CI->NavigatorModel->slbGame();
        $this->data['listLang'] = $this->CI->NavigatorModel->listItemLang();
        $this->data['urlService'] = $this->urlService;
        $linkService = $this->urlService.'/navigator_ginside/getItem?id='.$_GET['id'];
        $j_items = file_get_contents($linkService);
        $items = json_decode($j_items,true);
        $this->data['items'] = $items;
        
        if ($this->CI->input->post()){
            $this->CI->NavigatorValidate->validateForm($this->CI->input->post());
            if($this->CI->NavigatorValidate->isVaild()){
                $errors = $this->CI->NavigatorValidate->getMessageErrors();
                $items = $this->CI->NavigatorValidate->getData();
                $jsonRule = '';
                $arrServer_id = $items['server_id'];
                $arrService_starts = $items['service_starts'];
                $arrService_ends = $items['service_ends'];
                $arrItems = array();
                for($i=0;$i<count($arrServer_id);$i++){
                    $arrItems[$arrServer_id[$i]] = array(
                        'server_id' =>$arrServer_id[$i],
                        'service_start'=>$arrService_starts[$i],
                        'service_end'=>$arrService_ends[$i],
                    );
                }
                $jsonRule = json_encode($arrItems);
                $items['jsonRule'] = $jsonRule;
                
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->NavigatorValidate->getData();
                $jsonRule = '';
                $arrServer_id = $data['server_id'];
                $arrService_starts = $data['service_starts'];
                $arrService_ends = $data['service_ends'];
                $arrItems = array();
                for($i=0;$i<count($arrServer_id);$i++){
                    $arrItems[$arrServer_id[$i]] = array(
                        'server_id' =>$arrServer_id[$i],
                        'service_start'=>$arrService_starts[$i],
                        'service_end'=>$arrService_ends[$i],
                    );
                }
                
                $jsonRule = json_encode($arrItems);
                $data['id'] = $_GET['id'];
                $data['jsonRule'] = $jsonRule;
                $strLang  = '';
                if(count($this->data['listLang'])>0){
                    foreach($this->data['listLang'] as $lang){
                        $arrLang[$lang['alias']] = $lang['alias'];
                    }
                    $strLang = implode(',', $arrLang);
                }
                $data['strlang'] = $strLang;
                $data['service_author']= $this->data['session_account']['username'];
                $linkService = $this->urlService.'/navigator_ginside/edit';
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
        $this->CI->template->write_view('content', 'nutme/navigator/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function sort(MeAPI_RequestInterface $request){
        $linkService = $this->urlService.'/navigator_ginside/sort';
        $arrParam = array(
            'listid'=>count($_POST['listid']>0)?@implode(',', $_POST['listid']):'',
            'listorder'=>count($_POST['listorder']>0)?@implode(',', $_POST['listorder']):''
        );
        $result = $this->curlPost($arrParam,$linkService);
        redirect($this->_mainAction);
    }
    public function status(MeAPI_RequestInterface $request){
        $linkService = $this->urlService.'/navigator_ginside/status';
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
        $linkService = $this->urlService.'/navigator_ginside/delete';
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