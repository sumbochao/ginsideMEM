<?php
class MeAPI_Controller_Game_Events_WalletController implements MeAPI_Controller_Game_Events_WalletInterface {
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
        $this->CI->load->MeAPI_Model('Game/AcDau/WalletModel');
        $listGame = $this->CI->SearchInfoModel->listGamePermission();
        $game_id = '';
        if(is_array($listGame)){
            foreach($listGame as $v){
                $gameID[] = $v['service_id'];
            }
            $game_id = implode(',', $gameID);
        }
        $this->data['listGame'] = $listGame;
        $this->data['game_id'] = $game_id;
        $this->view_data = new stdClass();
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.acdau.mobo.vn';
        }else{
            $this->url_service = 'http://game.mobo.vn/acdau';
        }
		
	
    }
	
	
    public function index(MeAPI_RequestInterface $request){
		$this->getEventsByGame(); die('aaaaaaaaaaa');
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'rate':
                $this->data['title']= 'DANH SÁCH TỶ LỆ';
                break;
        }
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/wallet/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'rate':
                $this->data['title']= 'THÊM TỶ LỆ';
                $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/wallet/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        
        $linkinfo = $this->url_service.'/cms/wallet/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        switch ($_GET['view']){
            case 'rate':
                $this->data['title']= 'SỬA TỶ LỆ';
                $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
                break;
        }
        
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/wallet/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/wallet/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        if($_GET['iframe']!=1){
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
        }else{
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all&iframe=1&tid='.$_GET['tid']); 
        }
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['url_service'] = $this->url_service;
        $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
		
		
		
        switch ($_GET['view']){
            case 'wallet':
                $this->data['title']= 'LỊCH SỬ VÍ';
                break;
            case 'logs':
                $this->data['title']= 'LỊCH SỬ LOGS';
                break;
            case 'used':
                $this->data['title']= 'LỊCH SỬ USED';
                break;
			case 'statistical_payment':
				$this->data['payment_history'] =  json_encode(array());
                $this->data['title']= 'THỐNG KÊ GIAO DỊCH';
                break;
        }
		
		//process filter statistical payment
		if(isset($_POST['filter_payment'])){
			$this->data['payment_history'] =  json_encode($this->CI->WalletModel->filter_payment($_POST));
		}elseif(isset($_POST['exportPaymentHistory'])){
			$this->exportPaymentHistory();
		}
		
		// echo '<pre>';print_r($this->data['payment_history']);
        $this->CI->template->write_view('content', 'game/Events/wallet/history/'.$_GET['view'], $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function getEventsByGame(){
		
		$game = $_POST['game'];
		$events = $this->CI->WalletModel->getEventsByGame($game);
		// echo '<pre>';print_r($events);die;
		$html = '<option value="">--Event--</option>';
		foreach($events as $e){
			$event = $e['event'];
			$html .= "<option value='$event'>$event</option>" ;
		}
		echo $html;die;
		
	}
	
	public function getServers(){
		$game = $_POST['game'];
		$servers = $this->CI->WalletModel->getServers($game);
		// echo '<pre>';print_r($servers);die;
		$html = '<option value="">--Server--</option>';
		foreach($servers as $s){
			$server = $s['server_id'];
			$html .= "<option value='$server'>$server</option>" ;
		}
		echo $html;die;
		
	}
    
	
	public function exportPaymentHistory(){
		$this->CI->load->library('Quick_CSV_import');
		$result = json_encode($this->CI->WalletModel->filter_payment($_POST));
        $objExcel = new Quick_CSV_import();
        $header =  array('Event','Server','Money','Create Date');
        $objExcel->export($header, $result);
	}
	
	public function excel_wallet(MeAPI_RequestInterface $request){
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
            $lnkHistory = $this->url_service.'/cms/wallet/excel_wallet?game_id='.$gameid.'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        }
        $j_history = file_get_contents($lnkHistory);
        $listItem = json_decode($j_history,true);
        header('Content-type: application/excel');
        $filename = 'lich_su_wallet.xls';
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
                    <th align="center">Amount</th>
                    <th align="center">Total Recharge Money</th>
                    <th align="center">Total Recharge</th>
                    <th align="center">Total Minus</th>
                    <th align="center">Total Plus</th>
                    <th align="center">Create date</th>
                </tr>';
        if(count($listItem)>0){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y G:i:s");
                $total_recharge_money = $v['total_recharge_money']>0?number_format($v['total_recharge_money'],0,',','.'):0;
                $total_recharge = $v['total_recharge']>0?number_format($v['total_recharge'],0,',','.'):0;
                $total_minus = $v['total_minus']>0?number_format($v['total_minus'],0,',','.'):0;
                $total_plus = $v['total_plus']>0?number_format($v['total_plus'],0,',','.'):0;
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['game_id'].'</td>
                    <td align="center">'.$v['mobo_id'].'</td>
                    <td align="center">'."'".$v['msi'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['amount'].'</td>
                    <td align="center">'.$total_recharge_money.'</td>
                    <td align="center">'.$total_recharge.'</td>
                    <td align="center">'.$total_minus.'</td>
                    <td align="center">'.$total_plus.'</td>
                    <td align="center">'.$create_date.'</td>
                </tr>';
            }
        }
        $data .= '</table>
        </body>
        </html>';
        echo $data;
        die();
    }
    public function excel_logs(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if(!empty($_GET['start']) && !empty($_GET['end'])){ 
            $lnkHistory = $this->url_service.'/cms/wallet/excel_logs?game_id='.$_GET['game_id'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        }
        $j_history = file_get_contents($lnkHistory);
        $listItem = json_decode($j_history,true);
        header('Content-type: application/excel');
        $filename = 'lich_su_logs.xls';
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
                    <th align="center">Service Name</th>
                    <th align="center">Mobo ID</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Character ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Server ID</th>
                    <th align="center">Serial</th>
                    <th align="center">Pin</th>
                    <th align="center">Card</th>
                    <th align="center">Mobo Account</th>
                    <th align="center">Event</th>
                    <th align="center">Status</th>
                    <th align="center">Value</th>
                    <th align="center">Point</th>
                    <th align="center">Create Date</th>
                </tr>';
        if(count($listItem)>0){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y G:i:s");
                $point = $v['point']>0?number_format($v['point'],0,',','.'):0;
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['service_name'].'</td>
                    <td align="center">'.$v['mobo_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'."'".$v['character_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'."'".$v['serial'].'</td>
                    <td align="center">'."'".$v['pin'].'</td>
                    <td align="center">'.$v['card'].'</td>
                    <td align="center">'.$v['mobo_account'].'</td>
                    <td align="center">'.$v['event'].'</td>
                    <td align="center">'.$v['status'].'</td>
                    <td align="center">'.$v['value'].'</td>
                    <td align="center">'.$point.'</td>
                    <td align="center">'.$create_date.'</td>
                </tr>';
            }
        }
        $data .= '</table>
        </body>
        </html>';
        echo $data;
        die();
    }
    public function excel_used(MeAPI_RequestInterface $request){
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
            $lnkHistory = $this->url_service.'/cms/wallet/excel_used?game_id='.$gameid.'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        }
        $j_history = file_get_contents($lnkHistory);
        $listItem = json_decode($j_history,true);
        header('Content-type: application/excel');
        $filename = 'lich_su_used.xls';
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
                    <th align="center">Service Name</th>
                    <th align="center">Mobo ID</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Character ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Server ID</th>
                    <th align="center">Event</th>
                    <th align="center">Type</th>
                    <th align="center">Trans ID</th>
                    <th align="center">Value</th>
                    <th align="center">Status</th>
                    <th align="center">Create Date</th>
                    <th align="center">Comment</th>
                </tr>';
        if(count($listItem)>0){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y G:i:s");
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['game_id'].'</td>
                    <td align="center">'.$v['service_name'].'</td>
                    <td align="center">'.$v['mobo_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event'].'</td>
                    <td align="center">'.$v['type'].'</td>
                    <td align="center">'.$v['trans_id'].'</td>
                    <td align="center">'.$v['value'].'</td>
                    <td align="center">'.$v['status'].'</td>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$v['comment'].'</td>
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