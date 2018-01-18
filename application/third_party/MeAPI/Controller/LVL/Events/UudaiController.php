<?php

class MeAPI_Controller_LVL_Events_UudaiController implements MeAPI_Controller_LVL_Events_UudaiInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://game.mobo.vn/volam/cms/tooluudai/";

    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');

        //$this->CI->load->MeAPI_Model('ReportModel');
        //$this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
    }
	
	public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = "http://game.mobo.vn/volam/cms/tooluudai/get_exchange_history";
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'history_uudai.xls';
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
                    <th align="center">Server</th>
                    <th align="center">Character ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">MSI</th>
                    <th align="center">KNB</th>
                    <th align="center">Amount</th>
                    <th align="center">KNB Nhận</th>
                    <th align="center">Trạng thái</th>
                    <th align="center">Thời Gian</th>
                </tr>';
        if(count($listItem)){
            foreach($listItem['rows'] as $v){
                $status_send = $v['status_send'] == 1?"Thành Công":"Thất Bại";
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">"'.$v['character_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['cardvalue'].'</td>
                    <td align="center">'.$v['amount'].'</td>
                    <td align="center">'.$v['items'].'</td>
                    <td align="center">'.$status_send.'</td>
					<td align="center">'.$v['createDate'].'</td>
                </tr>';
            }
        }
        $data .= '</table>
        </body>
        </html>';
        echo $data;
        die();
    }
	
    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/uudai/items', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function items(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/uudai/items', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function additems(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/uudai/add_items', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function edititems(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/uudai/edit_items', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function historygamer(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/uudai/history_gamer', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
    public function history(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/lvl/Events/uudai/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    

    //Function
    protected function _call($params, $function_name) {
        set_time_limit(120);
        $last_link_request = $this->url_process . $function_name . "/?" . http_build_query($params);     
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $result = curl_exec($ch);
        return $result;
    }
    
    public function getResponse() {
        return $this->_response;
    }

    function data_uri($file, $mime = 'image/jpeg') {
        if (empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }

    public function curlPost($params, $link = '') {
        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        if ($result) {
            $result = json_decode($result, true);
            if ($result['code'] == 0) {
                $result = $result['data'];
            }
        }
        return $result;
    }

    public function curlPostAPI($params, $link = '') {
        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        return $result;
    }

    // Function to get the client IP address
    private function call_api_get($api_url) {
        set_time_limit(30);
        $urlrequest = $api_url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlrequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $result = curl_exec($ch);
        $err_msg = "";

        if ($result === false)
            $err_msg = curl_error($ch);

        //var_dump($result);
        //die;
        curl_close($ch);
        return $result;
    }

}
