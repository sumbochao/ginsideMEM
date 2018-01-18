<?php
class MeAPI_Controller_Game_Events_QuaHoTroController implements MeAPI_Controller_Game_Events_QuaHoTroInterface {
    protected $_response;
    private $CI;
    private $url_service;
    
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
        
        $this->CI->load->MeAPI_Model('Gapi/PromotionModel');
	$this->CI->load->MeAPI_Model('SearchInfoModel');
        $listServer = $this->CI->SearchInfoModel->listServerByIDGame($_GET['game_id']);
        $listGame = $this->CI->SearchInfoModel->listGamePermissionByController($_GET);
        $game_id = '';
        if(is_array($listGame)){
            foreach($listGame as $v){
                $gameID[] = $v['service_id'];
            }
            $game_id = implode(',', $gameID);
        }
        $this->data['game_id'] = $game_id;
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.bog.mobo.vn';
        }else{
            $this->url_service = 'http://game.mobo.vn/bog';
        }
        $this->data['listServer'] = $listServer;
        $this->data['url_service'] = $this->url_service;
    }
    public function listserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $s_id = array();
        $n_id = $_GET['lid'];
        if (!empty($n_id)){
            $s_id = explode(",", $n_id);
        }
        $this->data['s_id']= $s_id;
        echo $this->CI->load->view('game/Events/quahotro/filters/listserver', $this->data, true);
        die();
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'DANH SÁCH SỰ KIỆN';
            break;
            case 'filters':
                $this->data['title']= 'DANH SÁCH QUÀ';
            break;
        }
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
        $this->CI->template->write_view('content', 'game/Events/quahotro/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'THÊM SỰ KIỆN';
            break;
            case 'filters':
                $this->data['title']= 'THÊM QUÀ';
                $linkinfoslbEvent = $this->url_service.'/cms/quahotro/slbevent?game_id='.$this->data['game_id'];
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
            break;
        }
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
        $this->CI->template->write_view('content', 'game/Events/quahotro/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'SỬA SỰ KIỆN';
                break;
            case 'filters':
                $this->data['title']= 'SỬA QUÀ';
                $linkinfoslbEvent = $this->url_service.'/cms/quahotro/slbevent?game_id='.$this->data['game_id'];
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
                break;
        }
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
        $linkinfo = $this->url_service.'/cms/quahotro/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->CI->template->write_view('content', 'game/Events/quahotro/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/quahotro/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all&game='.$_GET['game']); 
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'LỊCH SỬ';
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
        $this->CI->template->write_view('content', 'game/Events/quahotro/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/quahotro/excel?game='.$_GET['game'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
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
        $data .= '<tr>
                    <th align="center">ID</th>
                    <th align="center">Game ID</th>
                    <th align="center">Mobo ID</th>
                    <th align="center">Character ID</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Server ID</th>
                    <th align="center">Event</th>
                    <th align="center">Vip</th>
                    <th align="center">Money</th>
                    <th align="center">Create date</th>
                    <th align="center">Result</th> 
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y G:i:s");
                $money = ($v['money']>0)?number_format($v['money'],0,',','.'):'0';
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['game_id'].'</td>
                    <td align="center">'.$v['moboid'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$v['condition'].'</td>
                    <td align="center">'.$money.'</td>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$v['result'].'</td>
                </tr>';
                $i++;
            }
        }
        $data .= '</table>
            </body>
        </html>';        
        header('Content-type: application/excel');
        $filename = 'quahotro.xls';
        header('Content-Disposition: attachment; filename='.$filename);
        echo $data;
        die();
    }
    public function getResponse() {
        return $this->_response;
    }
}