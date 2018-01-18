<?php
class MeAPI_Controller_Game_Reports_CheckAccountController implements MeAPI_Controller_Game_Reports_CheckAccountInterface {
    protected $_response;
    protected $game;
    private $CI;
    private $api_secret = "VI8qPbOIbWrMbockiPUW2SvunKURtVr6";
    
    public function __construct() {   
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('SearchInfoModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->view_data = new stdClass();
        switch ($_GET['game']){
            case 'giangma':
                $this->game = '125';
                break;
        }
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $slbServer = $this->CI->SearchInfoModel->listServerByGame($this->game);
        $this->data['slbServer'] = $slbServer;
        $this->data['title'] = 'Kiểm tra thông tin nhân vật';
        if ($this->CI->input->post()){
            $arrParam = $this->CI->input->post();
            $arrData = array(                    
                'action'=>'playerInfo',
                'playerId'=>$arrParam['playerid'],
                'serverId'=>$arrParam['game_server_id'],
                'zoneId'=>$arrParam['zoneid'],
            );
            $this->data['item'] = $this->processData($arrData);
        }
        
        $this->CI->template->write_view('content', 'game/checkaccount/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function searchcardinfo(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $slbServer = $this->CI->SearchInfoModel->listServerByGame($this->game);
        $this->data['slbServer'] = $slbServer;
        $this->data['title'] = 'Check Tướng Nguyên Thần';
        
        if ($this->CI->input->post()){
            $arrParam = $this->CI->input->post();
            $arrData = array(                    
                'action'=>'searchCardInfo',
                'playerId'=>$arrParam['playerid'],
                'serverId'=>$arrParam['game_server_id'],
                'zoneId'=>$arrParam['zoneid'],
            );
            $this->data['item'] = $this->processData($arrData);
        }
        
        $this->CI->template->write_view('content', 'game/checkaccount/searchcardinfo', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function searchitem(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $slbServer = $this->CI->SearchInfoModel->listServerByGame($this->game);
        $this->data['slbServer'] = $slbServer;
        $this->data['title'] = 'Check Túi';
        
        if ($this->CI->input->post()){
            $arrParam = $this->CI->input->post();
            $arrData = array(                    
                'action'=>'searchItem',
                'playerId'=>$arrParam['playerid'],
                'serverId'=>$arrParam['game_server_id'],
                'zoneId'=>$arrParam['zoneid'],
            );
            $this->data['item'] = $this->processData($arrData);
        }
        $this->CI->template->write_view('content', 'game/checkaccount/searchitem', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function winquestinfo(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $slbServer = $this->CI->SearchInfoModel->listServerByGame($this->game);
        $this->data['slbServer'] = $slbServer;
        $this->data['title'] = 'Check Phó Bản';
        
        if ($this->CI->input->post()){
            $arrParam = $this->CI->input->post();
            $arrData = array(                    
                'action'=>'winQuestInfo',
                'playerId'=>$arrParam['playerid'],
                'serverId'=>$arrParam['game_server_id'],
                'zoneId'=>$arrParam['zoneid'],
            );
            $this->data['item'] = $this->processData($arrData);
        }
        $this->CI->template->write_view('content', 'game/checkaccount/winquestinfo', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function giftcodeinfo(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Check Gift Code Info';
        
        if ($this->CI->input->post()){
            $arrParam = $this->CI->input->post();
            $arrData = array(                    
                'action'=>'giftCodeInfo',
                'giftId'=>$arrParam['giftId'],
                'zoneId'=>$arrParam['zoneid'],
            );
            $this->data['item'] = $this->processData($arrData);
        }
        $this->CI->template->write_view('content', 'game/checkaccount/giftcodeinfo', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function drawcardinfo(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Check Rút Tướng';
        $slbServer = $this->CI->SearchInfoModel->listServerByGame($this->game);
        $this->data['slbServer'] = $slbServer;
        if ($this->CI->input->post()){
            $arrParam = $this->CI->input->post();
            $arrData = array(                    
                'action'=>'drawCardInfo',
                'zoneId'=>$arrParam['zoneid'],
                'serverId'=>$arrParam['game_server_id'],
                'playerId'=>$arrParam['playerId'],
                'startDate'=>date_format(date_create($arrParam['startDate']),"Y-m-d G:i:s"),
                'endDate'=>date_format(date_create($arrParam['endDate']),"Y-m-d G:i:s"),
                'page'=>$arrParam['page'],
                'perpage'=>$arrParam['perpage'],
            );
            $this->data['item'] = $this->processData($arrData);
        }
        $this->CI->template->write_view('content', 'game/checkaccount/drawcardinfo', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function playermailinfo(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Check Thư';
        $slbServer = $this->CI->SearchInfoModel->listServerByGame($this->game);
        $this->data['slbServer'] = $slbServer;
        if ($this->CI->input->post()){
            $arrParam = $this->CI->input->post();
            $arrData = array(                    
                'action'=>'playerMailInfo',
                'zoneId'=>$arrParam['zoneId'],
                'serverId'=>$arrParam['serverId'],
                'playerId'=>$arrParam['playerId'],
                'startDate'=>date_format(date_create($arrParam['startDate']),"Y-m-d G:i:s"),
                'endDate'=>date_format(date_create($arrParam['endDate']),"Y-m-d G:i:s"),
                'page'=>$arrParam['page'],
                'perpage'=>$arrParam['perpage'],
            );
            $this->data['item'] = $this->processData($arrData);
        }
        $this->CI->template->write_view('content', 'game/checkaccount/playermailinfo', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getplayerinfobyvip(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Check Thư';
        $slbServer = $this->CI->SearchInfoModel->listServerByGame($this->game);
        $this->data['slbServer'] = $slbServer;
        if ($this->CI->input->post()){
            $arrParam = $this->CI->input->post();
            $arrData = array(                    
                'action'=>'getPlayerInfoByvip',
                'zoneId'=>$arrParam['zoneId'],
                'serverId'=>$arrParam['serverId'],
                'vip'=>$arrParam['vip'],
                'start'=>$arrParam['start'],
                'length'=>$arrParam['length'],
            );
            $this->data['item'] = $this->processData($arrData);
        }
        $this->CI->template->write_view('content', 'game/checkaccount/getplayerinfobyvip', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
    function processData($arrData){
        $data = json_encode($arrData);
        $sign  = md5($data.$arrData['zoneId'].$this->api_secret);
        $strURL = 'http://10.10.29.148/moon_gm/openApi/chengDuGmApi';
        $data_post = 'data='.$data.'&zoneId='.$arrData['zoneId'].'&sign='.$sign;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $strURL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        $resultData = $this->json_decode_nice($result);
        
        /*echo $strURL.'<br>'.$data_post;
        echo "<pre>";print_r($result);echo "<pre>";
        */
        if($resultData['code']==0){
            $item = $resultData['data'];
        }else{
            $item = array();
        }
        return $item;
    }
    public function json_decode_nice($json, $assoc = TRUE){
        $json = str_replace(array("\n","\r"),"\\n",$json);
        $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
        $json = preg_replace('/(,)\s*}$/','}',$json);
        return json_decode($json,$assoc);
    }
}