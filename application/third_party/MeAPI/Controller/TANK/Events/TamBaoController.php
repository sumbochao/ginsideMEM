<?php
class MeAPI_Controller_TANK_Events_TamBaoController implements MeAPI_Controller_TANK_Events_TamBaoInterface {
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
        $this->CI->load->MeAPI_Model('SearchInfoModel');
        $listServer = $this->CI->SearchInfoModel->listServerByIDGame($_GET['game_id']);
        $this->data['listServer'] = $listServer;
        $this->view_data = new stdClass();
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.tank.mobo.vn/tank/index.php';
        }else{
            $this->url_service = 'http://game.mobo.vn/tank';
        }
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
        echo $this->CI->load->view('game/tank/Events/tambao/event/listserver', $this->data, true);
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
            case 'history':
                $this->data['title']= 'LỊCH SỬ';
            break;
            case 'user':
                $this->data['title']= 'USER';
                $linkinfoslbEvent = $this->url_service.'/cms/tambao/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
            break;
        }
        $this->CI->template->write_view('content', 'game/tank/Events/tambao/'.$_GET['view'].'/index', $this->data);
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
            break;
            case 'user':
                $this->data['title']= 'THÊM USER';
                $linkinfoslbEvent = $this->url_service.'/cms/tambao/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
            break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/tank/Events/tambao/'.$_GET['view'].'/add', $this->data);
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
                break;
            case 'user':
                $this->data['title']= 'SỬA USER';
                $linkinfoslbEvent = $this->url_service.'/cms/tambao/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
            break;
        }
        $linkinfo = $this->url_service.'/cms/tambao/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/tank/Events/tambao/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/tambao/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function excel_history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/tambao/excel_history?start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'history_tam_bao.xls';
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
                    <th align="center">Mobo ID</th>
                    <th align="center">Character ID</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Server</th>
                    <th align="center">Sự kiện</th>
                    <th align="center">Tiền</th>
                    <th align="center">Quà</th>
                    <th align="center">Lượt</th>
                    <th align="center">Vị trí</th>
                    <th align="center">Ngày lật ô</th>
                    <th align="center">Ngày tạo</th>
                    <th align="center">Kết quả</th>
                    
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y H:i:s");
                $startday = date_format(date_create($v['startday']),"d-m-Y");
                $money = $v['money']>0?number_format($v['money'],0,',','.'):'0';
                $log_chests = json_decode($v['log_chests'],true);
                if($log_chests['0']['result']==false){
                    $log_chestss = 'false';
                }else{
                    $log_chestss = 'true';
                }
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['moboid'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">"'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$money.'</td>
                    <td align="center">'.$v['item_name'].'</td>
                    <td align="center">'.$v['turn'].'</td>
                    <td align="center">'.$v['position'].'</td>
                    <td align="center">'.$startday.'</td>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$log_chestss.'</td>
                </tr>';
            }
        }
        $data .= '</table>
        </body>
        </html>';
        echo $data;
        die();
    }
    
    public function excel_user(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/tambao/excel_user?start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'user_tam_bao.xls';
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
                    <th align="center">Mobo ID</th>
                    <th align="center">Character ID</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Server</th>
                    <th align="center">Sự kiện</th>
                    <th align="center">Tiền</th>
                    <th align="center">Lượt</th>
                    <th align="center">Mốc cài đặt</th>
                    <th align="center">Ngày tạo</th>
                    <th align="center">Lượt nạp tiền</th>
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y H:i:s");
                $money = $v['money']>0?number_format($v['money'],0,',','.'):'0';
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['moboid'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">"'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$money.'</td>
                    <td align="center">'.$v['turn'].'</td>
                    <td align="center">'.$v['flag_money'].'</td>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$v['num_add'].'</td>
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