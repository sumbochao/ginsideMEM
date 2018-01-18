<?php
class MeAPI_Controller_LOL_Events_CovuController implements MeAPI_Controller_LOL_Events_CovuInterface {
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
            $this->url_service = 'http://localhost.service.lol.mobo.vn';
        }else{
            $this->url_service = 'http://game.mobo.vn/lol';
        }
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'DANH SÁCH SỰ KIỆN';
                break;
            case 'tournament':
                $this->data['title']= 'DANH SÁCH GIẢI ĐẤU';
                break;
            case 'match':
                $this->data['title']= 'DANH SÁCH TRẬN ĐẤU';
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/covu/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'THÊM SỰ KIỆN';
                break;
            case 'tournament':
                $this->data['title']= 'THÊM GIẢI ĐẤU';
                break;
            case 'match':
                $this->data['title']= 'THÊM TRẬN ĐẤU';
                $linkslbTournaments = $this->url_service.'/cms/covu/slbTournaments';
                $contentslbTournaments = file_get_contents($linkslbTournaments);
                $slbTournaments = json_decode($contentslbTournaments,true);
                $this->data['slbTournaments'] = $slbTournaments;
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/covu/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        
        $linkinfo = $this->url_service.'/cms/covu/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'SỬA SỰ KIỆN';
                break;
            case 'tournament':
                $this->data['title']= 'SỬA GIẢI ĐẤU';
                break;
            case 'match':
                $this->data['title']= 'SỬA TRẬN ĐẤU';
                $linkslbTournaments = $this->url_service.'/cms/covu/slbTournaments';
                $contentslbTournaments = file_get_contents($linkslbTournaments);
                $slbTournaments = json_decode($contentslbTournaments,true);
                $this->data['slbTournaments'] = $slbTournaments;
                break;
        }
        
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/covu/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function result_match(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'CẬP NHẬT KẾT QUẢ';
        
        $id = $_GET['id'];
        $linkinfo = $this->url_service.'/cms/covu/get_match?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/covu/match/result_match', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/covu/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module='.$_GET['module']); 
    }
    public function history_datcuoc(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lol/Events/covu/history_datcuoc', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel_datcuoc(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if(!empty($_GET['start']) && !empty($_GET['end'])){ 
            $lnkHistory = $this->url_service.'/cms/covu/excel_datcuoc?start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        }
        $j_history = file_get_contents($lnkHistory);
        $listItem = json_decode($j_history,true);
        header('Content-type: application/excel');
        $filename = 'lich_su_dat_cuoc.xls';
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
                    <th align="center">Match</th>
                    <th align="center">Team win</th>
                    <th align="center">Point</th>
                    <th align="center">Create date</th>
                    <th align="center">Status</th>
                </tr>';
        if(count($listItem)>0){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['created_date']),"d-m-Y G:i:s");
                $capdau = json_decode($v['capdau'],true);
                switch ($v['team_win']){
                    case 'win_a':
                        $team_win = $capdau['ten_teama'];
                        break;
                    case 'win_b':
                        $team_win = $capdau['ten_teamb'];
                        break;
                }
                switch ($v['status']){
                    case 'thang':
                        $status = 'Thắng';
                        break;
                    case 'hoa':
                        $status = 'Hòa';
                        break;
                    case 'thua':
                        $status = 'Thua';
                        break;
                    case 'cho':
                        $status = 'Đang chờ';
                        break;
                }
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['moboid'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$capdau['ten_teama'].' - '.$capdau['ten_teamb'].'</td>
                    <td align="center">'.$team_win.'</td>
                    <td align="center">'.$v['point'].'</td>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$status.'</td>
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