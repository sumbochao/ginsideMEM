<?php
class MeAPI_Controller_Game_Events_ToppayController implements MeAPI_Controller_Game_Events_ToppayInterface {
    protected $_response;
    private $CI;
    private $url_service;
    protected $game_id;
    protected $data;

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
        $this->CI->load->MeAPI_Model('Gapi/PromotionModel');
        
        $this->CI->load->MeAPI_Model('SearchInfoModel');
        $listServer = $this->CI->SearchInfoModel->listServerByIDGame($_GET['game_id']);
        $listGame = $this->CI->SearchInfoModel->listGamePermission();
        $game_id = '';
        if(is_array($listGame)){
            foreach($listGame as $v){
                $gameID[] = $v['service_id'];
            }
            $game_id = implode(',', $gameID);
        }
        $this->data['listServer'] = $listServer;
        $this->data['listGame'] = $listGame;
        $this->data['game_id'] = $game_id;
        $this->view_data = new stdClass();
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.moba.mobo.vn';
        }else{
            $this->url_service = 'http://game.mobo.vn/moba';
        }
    }
    public function listserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $s_id = array();
        $n_id = $_GET['lid'];
        if (!empty($n_id)){
            $s_id = explode(",", $n_id);
        }
        $this->data['s_id']= $s_id;
        echo $this->CI->load->view('game/Events/toppay/rules/listserver', $this->data, true);
        die();
    }
    
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'events':
                $this->data['title']= 'DANH SÁCH SỰ KIỆN';
                break;
            case 'rules':
                $this->data['title']= 'DANH SÁCH QUI TẮC';
                break;
        }
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/toppay/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'events':
                $this->data['title']= 'THÊM SỰ KIỆN';
                $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
                break;
            case 'rules':
                $this->data['title']= 'THÊM QUI TẮC';
                $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/toppay/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        
        $linkinfo = $this->url_service.'/cms/toppay/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        switch ($_GET['view']){
            case 'events':
                $this->data['title']= 'SỬA SỰ KIỆN';
                $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
                break;
            case 'rules':
                $this->data['title']= 'SỬA QUI TẮC';
                $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
                break;
        }
        
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/toppay/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/toppay/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        $game_id = $_SESSION['account']['id_group']==2?$this->data['game_id']:'';
        if($_GET['iframe']!=1){
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
        }else{
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all&iframe=1&tid='.$_GET['tid']); 
        }
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'LỊCH SỬ';
        $this->data['url_service'] = $this->url_service;
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
        $this->CI->template->write_view('content', 'game/Events/toppay/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if(isset($_GET['game_id'])){
            if($_SESSION['account']['id_group']==2){
                if($_GET['game_id']>=0){
                    $gameid = $_GET['game_id'];
                }else{
                    $gameid = $this->data['game_id'];
                }
            }else{
                if($_GET['game_id']>=0){
                    $gameid = $_GET['game_id'];
                }
            }
        }
        
        if(!empty($_GET['start']) && !empty($_GET['end'])){ 
            $lnkHistory = $this->url_service.'/cms/toppay/excel?game_id='.$gameid.'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        }
        $j_history = file_get_contents($lnkHistory);
        $listItem = json_decode($j_history,true);
        header('Content-type: application/excel');
        $filename = 'lich_su_toppay.xls';
        header('Content-Disposition: attachment; filename='.$filename);

        $data .= '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <!--[if gte mso 9]>
            <xml>
                <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name>Sheet 1</x:Name>
                            <x:WorksheetOptions>
                                <x:Print>
                                    <x:ValidPrinterInfo/>
                                </x:Print>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                </x:ExcelWorkbook>
            </xml>
            <![endif]-->
        </head>

        <body>
            <table>';
        $data .= '
                <tr>
                    <th align="center">ID</th>
                    <th align="center">Game ID</th>
                    <th align="center">Mobo ID</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Server ID</th>
                    <th align="center">Character ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Event name</th>
                    <th align="center">Top</th>
                    <th align="center">Accu</th>
                    <th align="center">Min charge</th>
                    <th align="center">Extend</th>
                    <th align="center">Create date</th>
                    <th align="center">Result</th>
                </tr>';
        if(count($listItem)>0){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y G:i:s");
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['game_id'].'</td>
                    <td align="center">'.$v['mobo_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$v['top'].'</td>
                    <td align="center">'.$v['accu'].'</td>
                    <td align="center">'.$v['min_charge'].'</td>
                    <td align="center">'.$v['extend'].'</td>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$v['result'].'</td>
                </tr>';
            }
        }
        $data .= '</table>
        </body>
        </html>';
        echo $data;
        die();
    }
    
    public function getResponse() {
        return $this->_response;
    }
}