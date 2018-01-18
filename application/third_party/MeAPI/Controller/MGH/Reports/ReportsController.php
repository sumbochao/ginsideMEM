<?php

class MeAPI_Controller_MGH_Reports_ReportsController implements MeAPI_Controller_MGH_Reports_ReportsInterface {

    protected $_response;
    protected $database = 'active_mgh_info';
    protected $game = 'monggiangho';
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
    }

    public function user_active_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/mgh/Reports/user_active_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_user_active_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_user_active_byserver', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>14){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)',
                    'html' => $this->CI->load->view('game/mgh/Reports/ajax_user_active_byserver', '', true)
                );
            }else{
                $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
                $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
                $arrParam = array(
                    'server'=>trim($_REQUEST['server']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->userActiveByServer($arrParam,$this->database);
                $data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('game/mgh/Reports/ajax_user_active_byserver', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    
    public function user_active_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/mgh/Reports/user_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_user_active_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_user_active_byserver', '', true)
            );
        }else{
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            
            $arrParam = array(
                'date'=>$arrDate['2'].$arrDate['1'].$arrDate['0'],
            );
            $listItems = $this->CI->ReportActiveModel->userActiveByDate($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_user_active_byserver', $data, true)
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
        $this->CI->template->write_view('content', 'game/mgh/Reports/level_active_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_active_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_level_active_byserver', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>14){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)',
                    'html' => $this->CI->load->view('game/mgh/Reports/ajax_level_active_byserver', '', true)
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
                    'html' => $this->CI->load->view('game/mgh/Reports/ajax_level_active_byserver', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    
    public function level_active_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/mgh/Reports/level_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_active_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_level_active_byserver', '', true)
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
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_level_active_byserver', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    
    public function level_statistics_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/mgh/Reports/level_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_statistics_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_level_active_byserver', '', true)
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
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_level_active_byserver', $data, true)
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
        $this->CI->template->write_view('content', 'game/mgh/Reports/topup_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_topup_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/mgh/Reports/ajax_topup_byserver', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>14){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)',
                    'html' => $this->CI->load->view('game/mgh/Reports/ajax_topup_byserver', '', true)
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
                    'html' => $this->CI->load->view('game/mgh/Reports/ajax_topup_byserver', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    public function getResponse() {
        return $this->_response;
    }
}
