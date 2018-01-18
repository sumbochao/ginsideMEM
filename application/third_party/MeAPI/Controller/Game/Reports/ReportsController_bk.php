<?php

class MeAPI_Controller_Game_Reports_ReportsController implements MeAPI_Controller_Game_Reports_ReportsInterface {

    protected $_response;
    protected $database;
    protected $game;
    private $CI;
    
    public function __construct() {   
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->CI->load->MeAPI_Model('ReportActiveModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
        switch ($_GET['game']){
            case 'eden':
                $this->game = 'eden';
                $this->database='active_eden_info';
                break;
            case 'mgh':
                $this->game = 'monggiangho';
                $this->database='active_mgh_info';
                break;
        }
    }

    public function user_active_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        
        $data = array();
        if(count($listServer)>0){
            $date_from = trim(date('d-m-Y',  strtotime('-15 day')));$arrDateFrom = explode('-', $date_from);
            $date_to = trim(date('d-m-Y'));$arrDateTo = explode('-', $date_to);
            foreach($listServer as $server){
                $arrParam = array(
                    'server'=>trim($server['server_id']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->userActiveByServer($arrParam,$this->database);
                $result[] = $listItems;
                
            }
        }
        $recNew = array();
        $arrServer = array();
        foreach($result as $key => $row){
            foreach($row as $field => $value){
                $recNew[$field][$value['server']] = $value;
            }
        }
        
        $arrResultNew = array();
        $i=0;
        foreach($recNew as $key=>$val){
            $j=0;
            foreach($val as $v){
                if(!empty($v["date"])){
                    $arrResultNew[$i]['date'] = $v["date"];
                }
                $arrResultNew[$i]['data'][$j] = array(
                    'date'=>$v["date"],
                    'server'=>$v["server"],
                    'new_active'=>$v["new_active"],
                    'daily_active'=>$v["daily_active"],
                    'total_active'=>$v["total_active"],
                );
                $j++;
            }
            $i++;
        }
       
        $this->data['listItems'] = $arrResultNew;
        $this->data['database'] = $this->database;
        $this->CI->template->write_view('content', 'game/reports/user_active_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function first(&$array) {
        if (!is_array($array)) 
            return $array;
        if (!count($array)) return null;
        reset($array);
        return $array[key($array)];
    } 
    public function ajax_user_active_byserver(){
        $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
        $resultDate = $resultDate/(3600*24);
        if($resultDate<0 || $resultDate>15){
            $reponse = array(
                'error' => 1,
                'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)',
            );
        }else{
            $allServer = $this->CI->ReportActiveModel->listServer($this->game);
            if(is_array($_REQUEST['server'])){
                $listServer = $this->CI->ReportActiveModel->listByServer($_REQUEST['server'],$this->game);
            }else{
                $listServer = $allServer;
            }
            
            $this->data['listServer'] = $listServer;
            $data = array();
            if(count($listServer)>0){
                $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
                $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
                foreach($listServer as $server){
                    $arrParam = array(
                        'server'=>trim($server['server_id']),
                        'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                        'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                    );
                    $listItems = $this->CI->ReportActiveModel->userActiveByServer($arrParam,$this->database);
                    $result[] = $listItems;
                }
            }
            $recNew = array();
            foreach($result as $key => $row) {
                foreach($row as $field => $value) { 
                    $recNew[$field][$value['server']] = $value;
                }
            }
            
            $arrResultNew = array();
            $i=0;
            foreach($recNew as $key=>$val){
                $j=0;
                foreach($val as $v){
                    if(!empty($v["date"])){
                        $arrResultNew[$i]['date'] = $v["date"];
                    }
                    $arrResultNew[$i]['data'][$j] = array(
                        'date'=>$v["date"],
                        'server'=>$v["server"],
                        'new_active'=>$v["new_active"],
                        'daily_active'=>$v["daily_active"],
                        'total_active'=>$v["total_active"],
                    );
                    $j++;
                }
                $i++;
            }
          // echo "<pre>";print_r($arrResultNew);
            $this->data['listItems'] = $arrResultNew;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_user_active_byserver', $this->data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    
    //level
    public function level_active_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/level_active_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_active_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/ajax_level_active_byserver', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>14){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)',
                    'html' => $this->CI->load->view('game/reports/ajax_level_active_byserver', '', true)
                );
            }else{
                $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
                $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
                $arrParam = array(
                    'server'=>trim($_REQUEST['server']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->levelActiveByServer($arrParam,$this->database);
                $data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('game/reports/ajax_level_active_byserver', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    
    public function level_active_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/reports/level_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_active_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/reports/ajax_level_active_byserver', '', true)
            );
        }else{
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            
            $arrParam = array(
                'date'=>$arrDate['2'].$arrDate['1'].$arrDate['0'],
            );
            $listItems = $this->CI->ReportActiveModel->levelActiveByDate($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_level_active_byserver', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    
    public function level_statistics_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/reports/level_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_statistics_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/reports/ajax_level_active_byserver', '', true)
            );
        }else{
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            
            $arrParam = array(
                'date'=>$arrDate['2'].$arrDate['1'].$arrDate['0'],
            );
            $listItems = $this->CI->ReportActiveModel->levelStatisticsByDate($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_level_active_byserver', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    //topup
    public function topup_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/topup_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_topup_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/ajax_topup_byserver', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>14){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)',
                    'html' => $this->CI->load->view('game/reports/ajax_topup_byserver', '', true)
                );
            }else{
                $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
                $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
                $arrParam = array(
                    'server'=>trim($_REQUEST['server']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->topupByServer($arrParam,$this->database);
                $data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('game/reports/ajax_topup_byserver', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    
    //lượng vàng tồn trong game
    public function money(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $money = $this->CI->ReportActiveModel->money(array(),$this->database);
        $this->data['money'] = $money;
        $this->CI->template->write_view('content', 'game/reports/money', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    //luong vang theo ngày
    public function money_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/reports/money_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_money_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/reports/ajax_money_bydate', '', true)
            );
        }else{
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            
            $arrParam = array(
                'date'=>$arrDate['2'].$arrDate['1'].$arrDate['0'],
            );
            $listItems = $this->CI->ReportActiveModel->moneyByDate($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_money_bydate', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function getResponse() {
        return $this->_response;
    }
}
