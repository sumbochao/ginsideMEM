<?php
class MeAPI_Controller_PT_Events_DealswpController implements MeAPI_Controller_PT_Events_DealswpInterface {
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
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.phongthan.mobo.vn';
        }else{
            $this->url_service = 'http://service.phongthan.mobo.vn';
        }
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
        $this->CI->template->write_view('content', 'game/pt/Events/dealswp/'.$_GET['view'].'/index', $this->data);
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
                $linkinfoslbEvent = $this->url_service.'/cms/dealswp/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
            break;
        }
        $this->CI->template->write_view('content', 'game/pt/Events/dealswp/'.$_GET['view'].'/add', $this->data);
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
                $linkinfoslbEvent = $this->url_service.'/cms/dealswp/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
                break;
        }
        $linkinfo = $this->url_service.'/cms/dealswp/gettem_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->CI->template->write_view('content', 'game/pt/Events/dealswp/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/dealswp/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'#'.$_GET['view']); 
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'LỊCH SỬ';
        $this->CI->template->write_view('content', 'game/pt/Events/dealswp/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/dealswp/excel?&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'dealswp.xls';
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
                    <th align="center">Server ID</th>
                    <th align="center">Event ID</th>
                    <th align="center">Condition</th>
                    <th align="center">Device</th>
                    <th align="center">Device ID</th>
                    <th align="center">Create date</th>
                    <th align="center">Result</th>
                    
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $date=date_create($v['create_date']);
                $create_date = date_format($date,"d-m-Y G:i:s");
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['moboid'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$v['condition'].'</td>
                    <td align="center">'.$v['device'].'</td>
                    <td align="center">'.$v['device_id'].'</td>
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