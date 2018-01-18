<?php
class MeAPI_Controller_LG_GOK_Events_BaodanhnhanthuongController implements MeAPI_Controller_LG_GOK_Events_BaodanhnhanthuongInterface {
    
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
        $this->url_service = 'https://sev-cok.addgold.net';
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
        echo $this->CI->load->view('game/lg/GOK/Events/baodanhnhanthuong/filters/listserver', $this->data, true);
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
                $linkinfoslbEvent = $this->url_service.'/ToolBaoDanhNhanQua/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
            break;
        }
        $this->CI->template->write_view('content', 'game/lg/GOK/Events/baodanhnhanthuong/'.$_GET['view'].'/index', $this->data);
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
                $linkinfoslbEvent = $this->url_service.'/ToolBaoDanhNhanQua/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
            break;
            case 'user':
                $this->data['title']= 'THÊM USER';
            break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lg/GOK/Events/baodanhnhanthuong/'.$_GET['view'].'/add', $this->data);
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
                $linkinfoslbEvent = $this->url_service.'/ToolBaoDanhNhanQua/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
                break;
            case 'user':
                $this->data['title']= 'SỬA USER';
            break;
        }
        $linkinfo = $this->url_service.'/ToolBaoDanhNhanQua/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lg/GOK/Events/baodanhnhanthuong/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/ToolBaoDanhNhanQua/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function reset_user(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $event_id = $_GET['event_id'];
        $linkInfo = $this->url_service.'/ToolBaoDanhNhanQua/reset_type?event_id='.$event_id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/ToolBaoDanhNhanQua/excel?start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'baodanh.xls';
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
                    <th align="center">Character Name</th>
                    <th align="center">Server</th>
                    <th align="center">Sự kiện</th>
                    <th align="center">Loại</th>
                    <th align="center">Điều kiện</th>
                    <th align="center">Ngày tạo</th>
                    <th align="center">Result</th>
                    
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y H:i:s");
                switch ($v['type']){
                    case '1':
                        $type = 'Liên tục';
                        break;
                    case '2':
                        $type = 'Theo ngày';
                        break;
                }
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$type.'</td>
                    <td align="center">'.$v['condition'].'</td>
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