<?php
class MeAPI_Controller_FISH_Events_TaiXiuController implements MeAPI_Controller_FISH_Events_TaiXiuInterface {
    protected $_response;
    private $CI;
    public $url_service;
    
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
            $this->url_service = 'http://localhost.service.fish.mobo.vn/fish/index.php';
        }else{
            $this->url_service = 'http://game.mobo.vn/fish';
        }
        $this->data['url_service'] = $this->url_service;
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'LỊCH SỬ';
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/fish/Events/taixiu/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if(!empty($_GET['start']) && !empty($_GET['end'])){ 
            $lnkHistory = $this->url_service.'/cms/taixiu/excel?start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        }
        $j_history = file_get_contents($lnkHistory);
        $listItem = json_decode($j_history,true);
        header('Content-type: application/excel');
        $filename = 'lich_su_taixiu.xls';
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
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Server ID</th>
                    <th align="center">Character ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Tài xỉu</th>
                    <th align="center">Số lượng đặt</th>
                    <th align="center">Kết quả</th>
                    <th align="center">Kết thúc</th>
                    <th align="center">Create date</th>
                    <th align="center">Status</th>
                </tr>';
        if(count($listItem)>0){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y G:i:s");
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['mobo_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['taixiu'].'</td>
                    <td align="center">'.$v['sodat'].'</td>
                    <td align="center">'.$v['result_taixiu'].'</td>
                    <td align="center">'.$v['result'].'</td>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$v['status'].'</td>
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