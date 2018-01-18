<?php

class MeAPI_Controller_LG_GOK_Events_onlinenhanquaController implements MeAPI_Controller_LG_GOK_Events_onlinenhanquaInterface {

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
        $this->url_service = 'https://sev-cok.addgold.net';
        $this->data['url_service'] = $this->url_service;
    }

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']) {
            case 'event':
                $this->data['title'] = 'DANH SÁCH SỰ KIỆN TÍCH LŨY';
                break;
            case 'filters':
                $this->data['title'] = 'DANH SÁCH QUÀ TÍCH LŨY';
                break;
        }
        $this->CI->template->write_view('content', 'game/lg/GOK/Events/onlinenhanqua/' . $_GET['view'] . '/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']) {
            case 'event':
                $this->data['title'] = 'THÊM SỰ KIỆN TÍCH LŨY';
                break;
            case 'filters':
                $this->data['title'] = 'THÊM QUÀ TÍCH LŨY';
                $linkinfoslbEvent = $this->url_service . '/ToolOnlineNhanQua/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent, true);
                $this->data['slbEvent'] = $slbEvent;
                break;
        }
        $this->CI->template->write_view('content', 'game/lg/GOK/Events/onlinenhanqua/' . $_GET['view'] . '/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']) {
            case 'event':
                $this->data['title'] = 'SỬA SỰ KIỆN TÍCH LŨY';
                break;
            case 'filters':
                $this->data['title'] = 'SỬA QUÀ TÍCH LŨY';
                $linkinfoslbEvent = $this->url_service . '/ToolOnlineNhanQua/slbevent';
                $infoDetailslbEvent = file_get_contents($linkinfoslbEvent);
                $slbEvent = json_decode($infoDetailslbEvent, true);
                $this->data['slbEvent'] = $slbEvent;
                break;
        }
        $linkinfo = $this->url_service . '/ToolOnlineNhanQua/gettem_' . $_GET['view'] . '?id=' . $id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail, true);
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'game/lg/GOK/Events/onlinenhanqua/' . $_GET['view'] . '/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        $linkInfo = $this->url_service . '/ToolOnlineNhanQua/delete_' . $_GET['view'] . '?id=' . $id;
        $j_items = file_get_contents($linkInfo);
        if ($_GET['view'] == 'history') {
            redirect(base_url() . '?control=' . $_GET['control'] . '&func=history&module=all');
        } else {
            redirect(base_url() . '?control=' . $_GET['control'] . '&func=index&view=' . $_GET['view'] . '&module=all');
        }
    }

    public function history(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'LỊCH SỬ TÍCH LŨY';
        $this->CI->template->write_view('content', 'game/lg/GOK/Events/onlinenhanqua/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function excel(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service . '/ToolOnlineNhanQua/excel?start=' . strtotime($_GET['start']) . '&end=' . strtotime($_GET['end']);
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items, true);
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
        if (count($listItem)) {
            foreach ($listItem as $v) {
                $create_date = date_format(date_create($v['create_date']), "d-m-Y G:i:s");
                $money = ($v['money'] > 0) ? number_format($v['money'], 0, ',', '.') : '0';
                $log_chests = json_decode($v['log_chests'], true);
                if ($log_chests['0']['result'] == false) {
                    $log_chestss = 'false';
                } else {
                    $log_chestss = 'true';
                }
                $data .= '<tr>
                    <td align="center">' . $v['id'] . '</td>
                    <td align="center">' . $v['moboid'] . '</td>
                    <td align="center">' . $v['character_id'] . '</td>
                    <td align="center">' . "'" . $v['mobo_service_id'] . '</td>
                    <td align="center">' . $v['character_name'] . '</td>
                    <td align="center">' . $v['server_id'] . '</td>
                    <td align="center">' . $v['event_name'] . '</td>
                    <td align="center">' . $v['condition'] . '</td>
                    <td align="center">' . $money . '</td>
                    <td align="center">' . $create_date . '</td>
					<td align="center">' . $log_chestss . '</td>
                    <td align="center">' . $v['result'] . '</td>
                </tr>';
                $i++;
            }
        }
        $data .= '</table>
            </body>
        </html>';
        header('Content-type: application/excel');
        $filename = 'online_nhanqua_LG_GOK.xls';
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $data;
        die();
    }

    public function getResponse() {
        return $this->_response;
    }

}
