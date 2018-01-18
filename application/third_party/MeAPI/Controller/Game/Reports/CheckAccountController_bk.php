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
            $data = json_encode($arrData);
            $sign  = md5($data.$arrParam['zoneid'].$this->api_secret);
            $strURL = 'http://10.10.29.148/moon_gm/openApi/chengDuGmApi';
			$data_post = 'data='.$data.'&zoneId='.$arrParam['zoneid'].'&sign='.$sign;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $strURL);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $result = curl_exec($ch);
            curl_close($ch);
			
            $resultData = json_decode($result,true);
            if($resultData['code']==0){
                $this->data['item'] = $resultData['data'];
            }else{
                $this->data['item'] = array();
            }
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
            $data = json_encode($arrData);
            $sign  = md5($data.$arrParam['zoneid'].$this->api_secret);
            $strURL = 'http://10.10.29.148/moon_gm/openApi/chengDuGmApi';
            $data_post = 'data='.$data.'&zoneId='.$arrParam['zoneid'].'&sign='.$sign;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $strURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $result = curl_exec($ch);
            curl_close($ch);
            $resultData = $this->json_decode_nice($result);
            if($resultData['code']==0){
                $this->data['item'] = $resultData['data'];
            }else{
                $this->data['item'] = array();
            }
        }
        
        $this->CI->template->write_view('content', 'game/checkaccount/searchcardinfo', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
    public function json_decode_nice($json, $assoc = TRUE){
        $json = str_replace(array("\n","\r"),"\\n",$json);
        $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
        $json = preg_replace('/(,)\s*}$/','}',$json);
        return json_decode($json,$assoc);
    }
}