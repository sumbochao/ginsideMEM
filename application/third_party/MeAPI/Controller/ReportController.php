<?php

class MeAPI_Controller_ReportController implements MeAPI_Controller_ReportInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');

        $this->CI->load->MeAPI_Model('ReportModel');
        $this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        
        $session = $this->CI->Session->get_session('account');
        
        /*$acc = array("vietbl","hoangpc", "tuanhq", "nghiapq", "quannt","phuongnt","phuongnt2","hiennv","thinhndn");
        if (in_array($session['username'], $acc) === false) {
            echo 'Bạn không được phép truy cập!'; die;
        }*/
    }

    /*
     * Get Data Group
     */

    public function index(MeAPI_RequestInterface $request) {
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->filter();
        $getcol = $this->CI->Session->get_session('col');
        //var_dump($getcol);die;
        if (empty($getcol)) {
            $this->CI->Session->set_session('col', 'date');
            $this->CI->Session->set_session('order', 'DESC');
        }
		$arrGame = explode('-',$this->CI->Session->get_session('slbGame'));
        $arrFilter = array('col' => $this->CI->Session->get_session('col'),
            'order' => $this->CI->Session->get_session('order'),
            'slbGame' => $arrGame['0'],
            'keyword' => $this->CI->Session->get_session('keyword'),
            'date_from' => $this->CI->Session->get_session('date_from'),
            'date_to' => $this->CI->Session->get_session('date_to'),
            'slbStatus' => $this->CI->Session->get_session('slbStatus'),
            'slbPlatform' => $this->CI->Session->get_session('slbPlatform'),
            'slbType' => $this->CI->Session->get_session('slbType'),
            'game_server_id' => $this->CI->Session->get_session('game_server_id'),
			'type'=>$arrGame['1']
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            //if(isset($_GET['order'] )){
            //    $arrFilter["order"] = $_GET['order'];
            //}
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
			$arrGame = explode('-',$arrParam['slbGame']);
            $arrFilter = array('col' => "date",
                'order' => "desc",
                'slbGame' => $arrGame['0'],
                'keyword' => $arrParam['keyword'],
                'date_from' => $arrParam['date_from'],
                'date_to' => $arrParam['date_to'],
                'slbStatus' => $arrParam['slbStatus'],
                'slbPlatform' => $arrParam['slbPlatform'],
                'slbType' => $arrParam['slbType'],
                'game_server_id' => $arrParam['game_server_id'],
				'type'=>$arrGame['1'],
                'page' => 1
            );
            //var_dump($arrFilter);die;
            $page = 1;
        }

        $per_page = 20;
        $pa = $page - 1;
        $start = $pa * $per_page;
        $this->data['start'] = $start;
		if($arrFilter['type']=='local'){
            $listItems = $this->CI->ReportModel->listTable($arrFilter);
        }else{
            $listItems = $this->CI->ReportModel->listTableApi($arrFilter);
        }
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=report&func=index';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

		$listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = @array_slice($listItems, $start, $per_page);
        }
		
		$this->data['listItems'] = $listData;
        $this->data['arrFilter'] = $arrFilter;

		$slbScopes = $this->CI->ReportModel->listScopes();
        $this->data['slbScopes'] = $slbScopes;
        if (!empty($arrGame['0'])) {
            $slbServer = $this->CI->PaymentModel->listServerByGame($arrGame['0']);
            $this->data['slbServer'] = $slbServer;
        }

        $this->CI->template->write_view('content', 'report/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function getserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $arrGame = explode('-', $_REQUEST['game']);
        $game = $arrGame['0'];
        $listServer = $this->CI->PaymentModel->listServerByGame($game);
        
        if(!empty($game)){
            $xhtml = '<select name="game_server_id" class="textinput"><option value="0">Chọn server</option>';
            if(empty($listServer) !== TRUE){
                foreach($listServer as $v){
                    $xhtml .='<option value="'.$v['server_id'].'">'.$v['server_name'].'</option>';
                }
            }
            $xhtml .= '</select>';
            $f = array(
                'status'=>0,
                'messg'=>'Thành công',
                'html'=>$xhtml
            );
        }else{
			$xhtml = '<select name="game_server_id" class="textinput"><option value="0">Chọn server</option></select>';
            $f = array(
                'status'=>1,
                'messg'=>'Thất bại',
                'html'=>$xhtml
            );
        }
        echo json_encode($f);
        exit();
    }
	public function getvalidate(){
        $resultDate = strtotime($_REQUEST['dateTo'])-strtotime($_REQUEST['dateForm']);
        $resultDate = $resultDate/(3600*24);
        if($resultDate<=0 || $resultDate>14){
            $reponse = array(
                'error' => 1,
                'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)'
            );
        }else{
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công'
            );
        }
        echo json_encode($reponse);
        exit();
    }
	public function viewhistory(){
        if(isset($_REQUEST['transaction_id'])){
            $listItems = $this->CI->ReportModel->listViewHistoryByTransaction($_REQUEST);
            $this->data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('report/viewhistory', $this->data, true)
            );
        }else{
            $reponse = array(
                'error' => 1,
                'messg' => 'Thất bại',
                'html' => NULL
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function filter() {
        //$this->authorize->validateAuthorizeRequest($request, 0);
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('slbGame', $arrParam['slbGame']);
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('date_from', $arrParam['date_from']);
            $this->CI->Session->unset_session('date_to', $arrParam['date_to']);
            $this->CI->Session->unset_session('slbStatus', $arrParam['slbStatus']);
            $this->CI->Session->unset_session('slbPlatform', $arrParam['slbPlatform']);
            $this->CI->Session->unset_session('slbType', $arrParam['slbType']);
            $this->CI->Session->unset_session('game_server_id', $arrParam['game_server_id']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('col', $_GET['col']);
        }
        //echo "<pre/>";
        //var_dump($_SESSION);die;

        if ($_GET['type'] == 'clear') {
            $this->CI->Session->unset_session('slbGame', '');
            $this->CI->Session->unset_session('keyword', '');
            $this->CI->Session->unset_session('date_from', '');
            $this->CI->Session->unset_session('date_to', '');
            $this->CI->Session->unset_session('slbStatus', '0');
            $this->CI->Session->unset_session('slbPlatform', '');
            $this->CI->Session->unset_session('slbType', '');
            $this->CI->Session->unset_session('game_server_id', '');
        }

        //$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
        //redirect(APPLICATION_URL.'?control=report&func=index');
    }

    public function ajaxrequest() {
        if (!empty($_REQUEST['urlrequest'])) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $_REQUEST['urlrequest']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $result = curl_exec($ch);
            curl_close($ch);
            MeAPI_Log::writeCsv(array("request" => $_REQUEST['urlrequest'], "result" => $_REQUEST['urlrequest'], "data" => json_encode($_REQUEST['urlrequest'])), 'payment_' . date('H'));

            $arrResult = array();
            if (!empty($result)) {
                $arrResult = json_decode($result, true);
                $reponse = array(
                    'status' => 0,
                    'messg' => 'Thành công',
                    'messgInfo' => $arrResult['message']
                );
            } else {
                $reponse = array(
                    'status' => 0,
                    'messg' => 'Không Thành công',
                    'messgInfo' => 'Giao dịch thất bại [2].'
                );
            }
        } else {
            $reponse = array(
                'status' => 1,
                'messg' => 'Lỗi dữ liệu',
            );
        }
        echo json_encode($reponse);
        exit();
    }

    public function reset(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        //connect web service
        $linkListApp = URL_APP_MOBO.'/?control=report&func=listapp';
        $slbApp = json_decode(file_get_contents($linkListApp), true);
        $this->data['slbApp'] = $slbApp;
        if ($this->CI->input->post()) {
            if($_POST['app']==0){
                $error = '<div class="error">Vui lòng chọn 1 ứng dụng</div>';
                $this->data['error'] = $error;
            }else{
                $this->data['items'] = $_POST;
                
                $strURL = URL_APP_MOBO.'/?control=report&func=count_event_by_app&id_app='.$_POST['app'];
                $result = file_get_contents($strURL);
                $listEvent = json_decode($result,true);
                $this->data['listEvent'] = $listEvent;
                //get alias by app
                $strURL = URL_APP_MOBO.'/?control=report&func=get_app_by_id&id_app='.$_POST['app'];
                $result = file_get_contents($strURL);
                $getApp = json_decode($result,true);
                //update code
                $strURL = URL_APP_MOBO.'/?control=report&func=update&alias_app='.$getApp['alias_app'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $strURL);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                $result = curl_exec($ch);
                curl_close($ch);
                
				$session = $this->CI->Session->get_session('account');
                $_POST['username'] = $session['username'];
                MeAPI_Log::writeCsv(array("request" => $strURL, "result" =>'Thành viên :'.$session['username'], "data" => json_encode($_POST)), 'reset_' . date('H'));
            }
        }

        $this->CI->template->write_view('content', 'report/reset', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function ajaxevent() {
        $arrParam = $this->CI->security->xss_clean($_REQUEST);
        if ($arrParam['id_app'] > 0) {
            $strURL = URL_APP_MOBO.'/?control=report&func=count_event_by_app&id_app='.$arrParam['id_app'];
            $result = file_get_contents($strURL);
            $listEvent = json_decode($result,true);
            $this->data['listEvent'] = $listEvent;
            $html = $this->CI->load->view('report/ajaxevent', $this->data, true);
			if((in_array($_REQUEST['control'].'-filter_reset-'.$_REQUEST['id_app'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                $htmlButton = $this->CI->load->view('report/reset_button', $this->data, true);
            }else{
                $htmlButton = '';
            }
            $reponse = array(
                'status' => 0,
                'messg' => 'Thành công',
                'html' => $html,
				'htmlbutton'=>$htmlButton
            );
        } else {
            $this->data['listEvent'] = array();
            $html = $this->CI->load->view('report/ajaxevent', $this->data, true);
            $reponse = array(
                'status' => 1,
                'messg' => 'Thất bại',
                'html' => $html,
				'htmlbutton'=>""
            );
        }
        echo json_encode($reponse);
        exit();
    }
	
	public function exportdata(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $this->CI->load->MeAPI_Library('Pgt');
        $this->filterExport();
        
        $slbGame = $this->CI->Session->get_session('slbGame');
        
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $arrFilter = array(
                'slbGame' => $slbGame,
                'date_from' => $this->CI->Session->get_session('date_from'),
                'date_to' => $this->CI->Session->get_session('date_to'),
                
                'operator_from' => $this->CI->Session->get_session('operator_from'),
                'price_from' => $this->CI->Session->get_session('price_from'),
                'operator_to' => $this->CI->Session->get_session('operator_to'),
                'price_to' => $this->CI->Session->get_session('price_to'),
                'page'=>$_GET['page']
            );
            $page = $_GET['page'];
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'slbGame' => $arrParam['slbGame'],
                'date_from' => $arrParam['date_from'],
                'date_to' => $arrParam['date_to'],
                
                'operator_from' => $arrParam['operator_from'],
                'price_from' => $arrParam['price_from'],
                'operator_to' => $arrParam['operator_to'],
                'price_to' => $arrParam['price_to'],
                'page' => 1
            );
            $page = 1;
        }
        
        $per_page = 10;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->ReportModel->listExportDataByUser($arrFilter, $start, $per_page, true);
        $this->data['listItems'] = $listItems;

        $total = count($this->CI->ReportModel->listExportDataByUser($arrFilter));
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=report&func=exportdata';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $this->data['listItems'] = $listItems;
        $this->data['arrFilter'] = $arrFilter;

        if (!empty($slbGame)) {
            $slbServer = $this->CI->PaymentModel->listServerByGame($slbGame);
            $this->data['slbServer'] = $slbServer;
        }
        
        $this->CI->template->write_view('content', 'report/exportdata',$this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filterExport(){
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('slbGame', $arrParam['slbGame']);
            $this->CI->Session->unset_session('date_from', $arrParam['date_from']);
            $this->CI->Session->unset_session('date_to', $arrParam['date_to']);
            
            $this->CI->Session->unset_session('operator_from', $arrParam['operator_from']);
            $this->CI->Session->unset_session('price_from', $arrParam['price_from']);
            $this->CI->Session->unset_session('operator_to', $arrParam['operator_to']);
            $this->CI->Session->unset_session('price_to', $arrParam['price_to']);
        }
        if ($_GET['type'] == 'clear') {
            $this->CI->Session->unset_session('slbGame', '');
            $this->CI->Session->unset_session('keyword', '');
            $this->CI->Session->unset_session('date_from', '');
            $this->CI->Session->unset_session('date_to', '');
            
            $this->CI->Session->unset_session('operator_from','');
            $this->CI->Session->unset_session('price_from','');
            $this->CI->Session->unset_session('operator_to','');
            $this->CI->Session->unset_session('price_to','');
        }
    }

	public function callurl(MeAPI_RequestInterface $request){
		ini_set('max_execution_time', 1200);
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['listUrl'] = '';
        if ($this->CI->input->post()){
            if(!empty($_POST['txtUrl'])){
                $strUrl = explode("\n", $_POST['txtUrl']);
                $listData = array();
                if(count($strUrl)>0){
                    foreach($strUrl as $v){
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, trim($v));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                        $result = curl_exec($ch);
                        curl_close($ch);
                        $listData[] = array(
                            'url'=>$v,
                            'result'=>$result
                        );
                    }
                }
                $this->data['listData'] = $listData;
            }
        }
        $this->CI->template->write_view('content', 'report/callurl',$this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function giftcode(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->filterfiftcode();        
        $slbDbGiftcode = $this->CI->Session->get_session('slbDbGiftcode');
        $arrFilter = array(
            'slbDbGiftcode' => $slbDbGiftcode,
            'dategif' => $this->CI->Session->get_session('dategif'),
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'slbDbGiftcode' => $arrParam['slbDbGiftcode'],
                'dategif' => $arrParam['dategif'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 20;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        
        $listData = $this->CI->ReportModel->listTableGiftCode($arrFilter);
        $listItems = array();
        if(empty($listData) !== TRUE){
            foreach($listData as $v){
                $listItems[$v['soluong'].$v['character_id']] = $v;
            }
        }
        krsort($listItems);
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=report&func=giftcode';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['arrFilter'] = $arrFilter;
        
        
        $this->CI->template->write_view('content', 'report/giftcode',$this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filterfiftcode(){
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('slbDbGiftcode', $arrParam['slbDbGiftcode']);
            $this->CI->Session->unset_session('dategif', $arrParam['dategif']);
        }
    }
	public function paycard(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->filter_paycard();
        $slbGame = $this->CI->Session->get_session('slbGame');
        $arrFilter = array(
            'slbGame' => $slbGame,
            'game_server_id' => $this->CI->Session->get_session('game_server_id'),
            'keyword' => $this->CI->Session->get_session('keyword'),
            'date_from' => $this->CI->Session->get_session('date_from'),
            'date_to' => $this->CI->Session->get_session('date_to'),
        );
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'slbGame' => $arrParam['slbGame'],
                'game_server_id' => $arrParam['game_server_id'],
                'keyword' => $arrParam['keyword'],
                'date_from' => $arrParam['date_from'],
                'date_to' => $arrParam['date_to'],
                'page' => 1
            );
            $page = 1;
        }
        $per_page = 20;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->ReportModel->listItemsPaycard($arrFilter);

        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=report&func=paycard';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
		
        $this->data['listItems'] = $listData;
        $this->data['arrFilter'] = $arrFilter;

        $slbScopes = $this->CI->ReportModel->listScopes();
        $this->data['slbScopes'] = $slbScopes;
        if (!empty($slbGame)) {
            $slbServer = $this->CI->PaymentModel->listServerByGame($slbGame);
            $this->data['slbServer'] = $slbServer;
        }
        
        $this->CI->template->write_view('content', 'report/paycard',$this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getvalidate_paycard(){
        $resultDate = strtotime($_REQUEST['dateTo'])-strtotime($_REQUEST['dateForm']);
        $resultDate = $resultDate/(3600*24);
        if($resultDate<=0 || $resultDate>14){
            $reponse = array(
                'error' => 1,
                'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)'
            );
        }else{
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công'
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function filter_paycard() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter_paycard') {
            $this->CI->Session->unset_session('slbGame', $arrParam['slbGame']);
            $this->CI->Session->unset_session('game_server_id', $arrParam['game_server_id']);
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('date_from', $arrParam['date_from']);
            $this->CI->Session->unset_session('date_to', $arrParam['date_to']);
        }
    }
	public function paycard_excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $arrFilter = array(
                'slbGame' => $_POST['slbGame'],
                'game_server_id' => $_POST['game_server_id'],
                'keyword' => $_POST['keyword'],
                'date_from' => $_POST['date_from'],
                'date_to' => $_POST['date_to'],
            );
        $listItem = $this->CI->ReportModel->listItemsPaycard($arrFilter);
        header('Content-type: application/excel');
        $filename = 'gio_vang.xls';
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
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Server ID</th>
                    <th align="center">Mobo ID</th>
                    <th align="center">Mobo Account</th>
                    <th align="center">Event</th>
                    <th align="center">Serial</th>
                    <th align="center">Money</th>
                    <th align="center">Type</th>
                    <th align="center">App</th>
                    <th align="center">Description</th>
                    <th align="center">Date</th>
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $date=date_create($v['date']);
                $create_date = date_format($date,"d-m-Y G:i:s");
                $money = ($v['money']>0)?number_format($v['money'],0,',',','):'0';
                $description = json_decode($v['description'],true);
                $str_description = 'ID: '.$description['id'].'<br>'.
                                    'Value: '.$description['value'].'<br>'.
                                    'Msg: '.$description['msg'].'<br>';
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['mobo_id'].'</td>
                    <td align="center">'.$v['mobo_account'].'</td>
                    <td align="center">'.$v['event'].'</td>
                    <td align="center">'.$v['serial'].'</td>
                    <td align="center">'.$money.'</td>
                    <td align="center">'.$v['type'].'</td>
                    <td align="center">'.$v['app'].'</td>
                    <td align="center">'.$str_description.'</td>
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
    public function getResponse() {
        return $this->_response;
    }
	
	public function listGameApprove(MeAPI_RequestInterface $request){
		$slbScopes = $this->CI->ReportModel->listScopes();
		print_r($slbScopes);die;
	}

}
