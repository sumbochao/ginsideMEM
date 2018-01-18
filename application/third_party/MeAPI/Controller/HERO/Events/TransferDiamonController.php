<?php
class MeAPI_Controller_HERO_Events_TransferDiamonController implements MeAPI_Controller_HERO_Events_TransferDiamonInterface {
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
		$this->url_service = 'http://game.mobo.vn/hero';
        $this->data['url_service'] = $this->url_service;
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'EVENT TRANSFER PLATFORM';
            break;
            case 'filters':
                $this->data['title']= 'EVENT GIFT TRANSFER PLATFORM';
            break;
        }
        $this->CI->template->write_view('content', 'game/hero/Events/transferdiamon/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'LỊCH SỬ TÍCH LŨY';
        $this->CI->template->write_view('content', 'game/hero/Events/transferdiamon/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/accumulation/excel?game='.$_GET['game'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
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
                    <th align="center">Mobo ID</th>
                    <th align="center">Character ID</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Server ID</th>
                    <th align="center">Event</th>
                    <th align="center">Condition</th>
                    <th align="center">Money</th>
                    <th align="center">Create date</th>
					<th align="center">Status</th>
                    <th align="center">Result</th> 
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y G:i:s");
                $money = ($v['money']>0)?number_format($v['money'],0,',','.'):'0';
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
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$v['condition'].'</td>
                    <td align="center">'.$money.'</td>
                    <td align="center">'.$create_date.'</td>
					<td align="center">'.$log_chestss.'</td>
                    <td align="center">'.$v['result'].'</td>
                </tr>';
                $i++;
            }
        }
        $data .= '</table>
            </body>
        </html>';        
        header('Content-type: application/excel');
        $filename = 'accumulation.xls';
        header('Content-Disposition: attachment; filename='.$filename);
        echo $data;
        die();
    }
    public function getResponse() {
        return $this->_response;
    }
}