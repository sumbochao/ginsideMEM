<?php
class MeAPI_Controller_LK_Events_AwardVipController implements MeAPI_Controller_LK_Events_AwardVipInterface {
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
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.game.mobo.vn/hiepkhach/index.php';
        }else{
            $this->url_service = 'http://game.mobo.vn/hiepkhach';
        }
        $this->view_data = new stdClass();
    }
    public function index_event(MeAPI_RequestInterface $request){
        $this->data['title'] = 'QUẢN LÝ SỰ KIỆN';
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/event/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add_event(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'THÊM SỰ KIỆN';
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/event/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit_event(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'SỬA SỰ KIỆN';
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/awardvip/getitem_event?id='.$id;
        $j_items = file_get_contents($linkInfo);
        $this->data['items'] = json_decode($j_items,true);
        
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/event/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete_event(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/awardvip/delete_event?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index_event#event');
    }
    //config
    public function index_config(MeAPI_RequestInterface $request){
        $this->data['title'] = 'QUẢN LÝ CẤU HÌNH';
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/config/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add_config(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'THÊM CẤU HÌNH';
        //slbEvent
        $linkSlbEvent = $this->url_service.'/cms/awardvip/select_event';
        $j_slbEvent = file_get_contents($linkSlbEvent);
        $this->data['slbEvent'] = json_decode($j_slbEvent,true);
        //slbItem
        $linkSlbItem = $this->url_service.'/cms/awardvip/select_item';
        $j_slbItem = file_get_contents($linkSlbItem);
        $this->data['slbItem'] = json_decode($j_slbItem,true);
        
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/config/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit_config(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'SỬA CẤU HÌNH';
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/awardvip/getitem_config?id='.$id;
        $j_items = file_get_contents($linkInfo);
        $this->data['items'] = json_decode($j_items,true);
        
        //slbEvent
        $linkSlbEvent = $this->url_service.'/cms/awardvip/select_event';
        $j_slbEvent = file_get_contents($linkSlbEvent);
        $this->data['slbEvent'] = json_decode($j_slbEvent,true);
        //slbItem
        $linkSlbItem = $this->url_service.'/cms/awardvip/select_item';
        $j_slbItem = file_get_contents($linkSlbItem);
        $this->data['slbItem'] = json_decode($j_slbItem,true);
        
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/config/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete_config(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/awardvip/delete_config?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index_config#config');
    }
    //item
    public function index_item(MeAPI_RequestInterface $request){
        $this->data['title'] = 'QUẢN LÝ ITEM';
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/item/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add_item(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'THÊM ITEM';
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/item/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit_item(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'SỬA ITEM';
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/awardvip/getitem_item?id='.$id;
        $j_items = file_get_contents($linkInfo);
        $this->data['items'] = json_decode($j_items,true);
        
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/item/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete_item(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/awardvip/delete_item?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index_item#item');
    }
    public function history(MeAPI_RequestInterface $request) {
        $this->data['title'] = 'LỊCH SỬ';
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/lk/Events/awardvip/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/awardvip/excel';
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        header('Content-type: application/excel');
        $filename = 'uu_dai_nap_vip.xls';
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
                    <th align="center">Character ID</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Server ID</th>
                    <th align="center">Config ID</th>
                    <th align="center">Item</th>
                    <th align="center">Event</th>
                    <th align="center">Vip Point</th>
                    <th align="center">Condition</th>
                    <th align="center">Create date</th>
                    <th align="center">Result</th>
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $date=date_create($v['create_date']);
                $create_date = date_format($date,"d-m-Y G:i:s");
                $condition = json_decode($v['condition'],true);
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['config_id'].'</td>
                    <td align="center">'.$v['itemname'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$v['vippoint'].'</td>
                    <td align="center">'.$condition['gold'].' : '.$condition['from'].' - '.$condition['to'].'</td>
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