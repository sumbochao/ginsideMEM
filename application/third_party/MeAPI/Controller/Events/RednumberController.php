<?php
class MeAPI_Controller_Events_RednumberController implements MeAPI_Controller_Events_RednumberInterface {
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
            $this->url_service = 'http://localhost.service.acdau.mobo.vn';
        }else{
            $this->url_service = 'http://game.mobo.vn/acdau';
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
        echo $this->CI->load->view('game/Events/rednumber/groups/listserver', $this->data, true);
        die();
    }
    public function listprizes(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkSlbPrizes = $this->url_service.'/cms/rednumber/slb_prizes';
        $contentSlbPrizes = file_get_contents($linkSlbPrizes);
        $slbPrizes = json_decode($contentSlbPrizes,true);
        $this->data['listPrizes'] = $slbPrizes;
        $s_id = array();
        $n_id = $_GET['lid'];
        if (!empty($n_id)){
            $s_id = explode(",", $n_id);
        }
        $this->data['s_id']= $s_id;
        echo $this->CI->load->view('game/Events/rednumber/groups/listprizes', $this->data, true);
        die();
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'groups':
                $this->data['title']= 'DANH SÁCH NHÓM';
                break;
            case 'result':
                $this->data['title']= 'DANH SÁCH KẾT QUẢ';
                break;
            case 'turns':
                $this->data['title']= 'DANH SÁCH LƯỢT';
                break;
        }
        
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/rednumber/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'groups':
                $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
                $this->data['title']= 'THÊM NHÓM';
                break;
            case 'result':
                $this->data['title']= 'THÊM KẾT QUẢ';
                $linkSlbPrizes = $this->url_service.'/cms/rednumber/slb_prizes';
                $contentSlbPrizes = file_get_contents($linkSlbPrizes);
                $slbPrizes = json_decode($contentSlbPrizes,true);
                $this->data['listPrizes'] = $slbPrizes;
                
                $game_id = $_SESSION['account']['id_group']==2?$this->data['game_id']:'';
                $linkSlbGroups = $this->url_service.'/cms/rednumber/slb_group?game='.$game_id;
                $contentSlbGroups = file_get_contents($linkSlbGroups);
                $slbGroups = json_decode($contentSlbGroups,true);
                $this->data['slbGroups'] = $slbGroups;
                break;
            case 'turns':
                $this->data['title']= 'THÊM LƯỢT';
                $game_id = $_SESSION['account']['id_group']==2?$this->data['game_id']:'';
                $linkSlbGroups = $this->url_service.'/cms/rednumber/slb_group?game='.$game_id;
                $contentSlbGroups = file_get_contents($linkSlbGroups);
                $slbGroups = json_decode($contentSlbGroups,true);
                $this->data['slbGroups'] = $slbGroups;

                $linkSlbPrizes = $this->url_service.'/cms/rednumber/slb_prizes';
                $contentSlbPrizes = file_get_contents($linkSlbPrizes);
                $slbPrizes = json_decode($contentSlbPrizes,true);
                $this->data['listPrizes'] = $slbPrizes;
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/rednumber/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        
        $linkinfo = $this->url_service.'/cms/rednumber/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        switch ($_GET['view']){
            case 'groups':
                $this->data['title']= 'SỬA NHÓM';
                $this->data['slbGame'] = $this->CI->PromotionModel->slbScopes();
                break;
            case 'result':
                $this->data['title']= 'SỬA KẾT QUẢ';
                $linkSlbPrizes = $this->url_service.'/cms/rednumber/slb_prizes';
                $contentSlbPrizes = file_get_contents($linkSlbPrizes);
                $slbPrizes = json_decode($contentSlbPrizes,true);
                $this->data['listPrizes'] = $slbPrizes;
                break;
            case 'turns':
                $this->data['title']= 'SỬA LƯỢT';
                $game_id = $_SESSION['account']['id_group']==2?$this->data['game_id']:'';
                $linkSlbGroups = $this->url_service.'/cms/rednumber/slb_group?game='.$game_id;
                $contentSlbGroups = file_get_contents($linkSlbGroups);
                $slbGroups = json_decode($contentSlbGroups,true);
                $this->data['slbGroups'] = $slbGroups;
                
                $linkSlbPrizes = $this->url_service.'/cms/rednumber/slb_prizes';
                $contentSlbPrizes = file_get_contents($linkSlbPrizes);
                $slbPrizes = json_decode($contentSlbPrizes,true);
                $this->data['listPrizes'] = $slbPrizes;
                break;
        }
        
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/rednumber/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/rednumber/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        $game_id = $_SESSION['account']['id_group']==2?$this->data['game_id']:'';
        if($_GET['iframe']!=1){
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module='.$_GET['module'].'&game='.$game_id); 
        }else{
            redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module='.$_GET['module'].'&game='.$game_id.'&iframe=1&tid='.$_GET['tid']); 
        }
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/Events/rednumber/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if(!empty($_GET['start']) && !empty($_GET['end'])){ 
            $lnkHistory = $this->url_service.'/cms/rednumber/excel?game='.$_GET['game'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        }
        $j_history = file_get_contents($lnkHistory);
        $listItem = json_decode($j_history,true);
        header('Content-type: application/excel');
        $filename = 'lich_su.xls';
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
                    <th align="center">Game ID</th>
                    <th align="center">Group</th>
                    <th align="center">Prizes</th>
                    <th align="center">Day Turn</th>
                    <th align="center">Option</th>
                    <th align="center">Number</th>
                    <th align="center">Amount</th>
                    <th align="center">Percent</th>
                    <th align="center">Create date</th>
                    <th align="center">Status</th>
                    <th align="center">Lose</th>
                    <th align="center">Win</th>
                    <th align="center">Wamount</th>
                    <th align="center">Warning</th>
                    <th align="center">Wincount</th>
                    <th align="center">Udate</th>
                    <th align="center">Transid</th>
                    <th align="center">Failed</th>
                </tr>';
        if(count($listItem)>0){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y G:i:s");
                $udate = date_format(date_create($v['udate']),"d-m-Y G:i:s");
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['mobo_id'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['group_game'].'</td>
                    <td align="center">'.$v['name_group'].'</td>
                    <td align="center">'.$v['name_prize'].'</td>
                    <td align="center">'.$v['day'].'</td>
                    <td align="center">'.$v['option'].'</td>
                    <td align="center">'.$v['number'].'</td>
                    <td align="center">'.$v['amount'].'</td>
                    <td align="center">'.$v['percent'].'</td>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$v['status'].'</td>
                    <td align="center">'.$v['lose'].'</td>
                    <td align="center">'.$v['win'].'</td>
                    <td align="center">'.$v['wamount'].'</td>
                    <td align="center">'.$v['warning'].'</td>
                    <td align="center">'.$v['wincount'].'</td>
                    <td align="center">'.$udate.'</td>
                    <td align="center">'."'".$v['transid'].'</td>
                    <td align="center">'.$v['failed'].'</td>
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