<?php

class MeAPI_Controller_EDEN_Reports_ReportsController implements MeAPI_Controller_EDEN_Reports_ReportsInterface {

    protected $_response;
    protected $database = 'active_eden_info';
    protected $game = 'eden';
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
        //$result[2][3] = array('date'=>'2015-07-22','server'=>3,'new_active'=>'45','total_active'=>'456');
        
        $recNew = array();
        $arrServer = array();
        foreach($result as $key => $row){
            foreach($row as $field => $value){
                $recNew[$field][$value['server']] = $value;
            }
        }
        $checkStatus=0;
        $arrResultNew = array();
        $i=0;
        foreach($recNew as $key=>$val){
            $checkStatus++;
            if($checkStatus==1)$checkCount = count($val);
            for($j=1;$j<=$checkCount;$j++){
                if(!empty($val[$j]["date"])){
                    $arrResultNew[$i]['date'] = $val[$j]["date"];
                }
                $arrResultNew[$i]['data'][$j] = array(
                    'date'=>$val[$j]["date"],
                    'server'=>$val[$j]["server"],
                    'new_active'=>$val[$j]["new_active"],
                    'daily_active'=>$val[$j]["daily_active"],
                    'total_active'=>$val[$j]["total_active"],
                );
            }
            $i++;
        }
        
        $this->data['listItems'] = $arrResultNew;
        $this->data['database'] = $this->database;
        $this->CI->template->write_view('content', 'game/eden/Reports/user_active_byserver', $this->data);
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
            
            if(is_array($_REQUEST['server'])){
                $listServer = $this->CI->ReportActiveModel->listByServer($_REQUEST['server'],$this->game);
            }else{
                $listServer = $this->CI->ReportActiveModel->listServer($this->game);
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
            //$result[2][3] = array('date'=>'2015-07-22','server'=>2,'new_active'=>'45','total_active'=>'456');
            $recNew = array();
            foreach($result as $key => $row) {
                foreach($row as $field => $value) { 
                    $recNew[$field][$value['server']] = $value;
                }
            }
            
            $checkStatus=0;
            $arrResultNew = array();
            $i=0;
            
            foreach($recNew as $key=>$val){
                $checkStatus++;
                if($checkStatus==1)$checkCount = count($val);
                
                if(is_array($_REQUEST['server'])){
                    $s=0;
                    foreach($_REQUEST['server'] as $vs){
                        if($vs !='multiselect-all'){
                            $s++;
                            if($s==1) $start = $vs;
                        }
                    }
                    $end = end($_REQUEST['server']);  
                }else{
                    $start = 1;
                    $end  = $checkCount;
                }
                for($j=$start;$j<=$end;$j++){
                    if(!empty($val[$j]["date"])){
                        $arrResultNew[$i]['date'] = $val[$j]["date"];
                    }
                    $arrResultNew[$i]['data'][$j] = array(
                        'date'=>$val[$j]["date"],
                        'server'=>$val[$j]["server"],
                        'new_active'=>$val[$j]["new_active"],
                        'daily_active'=>$val[$j]["daily_active"],
                        'total_active'=>$val[$j]["total_active"],
                    );
                }
                $i++;
            }
          // echo "<pre>";print_r($arrResultNew);
            $this->data['listItems'] = $arrResultNew;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/eden/Reports/ajax_user_active_byserver', $this->data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    
    public function excel_user_active_byserver(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        ini_set('memory_limit', '55048M');
        if (PHP_SAPI == 'cli')
                die('This example should only be run from a Web Browser');
        /** Include PHPExcel */
       
        require_once(APPPATH . '/third_party/PHPExcel/PHPExcel.php');
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                    ->setLastModifiedBy("Maarten Balliauw")
                                    ->setTitle("Office 2007 XLSX Test Document")
                                    ->setSubject("Office 2007 XLSX Test Document")
                                    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                    ->setKeywords("office 2007 openxml php")
                                    ->setCategory("Test result file");
        
        //$arrServer = $_POST['server'];
        //$date_from = $_POST['date_from'];
        //$date_to = $_POST['date_to'];
        $sheet = $objPHPExcel->getActiveSheet();
        
        $arrChar = array();
        for($i='A';$i<='Z';$i++){
            $arrChar[]=$i;
        }
        for($i=0;$i<10;$i++){
            if($i%3==0){
                $stt=$i;
            }
            if($i%2==0){
                echo $i;
            }
            //$sheet->setCellValueByColumnAndRow(0,1,"Gabriel[".$i."]")->mergeCells('A1:C1')->getStyle('A1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        }
        die();
        /*$sheet->setCellValueByColumnAndRow(0,1,"Gabriel[1]")->mergeCells('A1:C1')->getStyle('A1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(3,1,"Gabriel[2]")->mergeCells('D1:F1')->getStyle('D1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(6,1,"Gabriel[3]")->mergeCells('G1:I1')->getStyle('G1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(9,1,"Gabriel[4]")->mergeCells('J1:L1')->getStyle('J1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(12,1,"Gabriel[5]")->mergeCells('M1:O1')->getStyle('M1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(15,1,"Gabriel[6]")->mergeCells('P1:R1')->getStyle('P1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(18,1,"Gabriel[7]")->mergeCells('S1:U1')->getStyle('S1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(21,1,"Gabriel[8]")->mergeCells('V1:X1')->getStyle('V1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(24,1,"Gabriel[9]")->mergeCells('Y1:AA1')->getStyle('Y1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $sheet->setCellValueByColumnAndRow(27,1,"Gabriel[10]")->mergeCells('AB1:AD1')->getStyle('AB1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
       */
        
        
         /* 
         * // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:B2','Noi dung 1');
         */
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2','Noi dung 2');
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Thành viên');
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        $namefile = 'tk_kich_hoat_theo_server_'.gmdate('d-m-Y G:i:s',time()+7*3600).'.xls';
        header('Content-Disposition: attachment;filename="'.$namefile.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    //level
    public function level_active_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/eden/Reports/level_active_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_active_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/eden/Reports/ajax_level_active_byserver', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>14){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)',
                    'html' => $this->CI->load->view('game/eden/Reports/ajax_level_active_byserver', '', true)
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
                    'html' => $this->CI->load->view('game/eden/Reports/ajax_level_active_byserver', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    
    public function level_active_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/eden/Reports/level_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_active_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/eden/Reports/ajax_level_active_byserver', '', true)
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
                'html' => $this->CI->load->view('game/eden/Reports/ajax_level_active_byserver', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    
    public function level_statistics_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/eden/Reports/level_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_level_statistics_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/eden/Reports/ajax_level_active_byserver', '', true)
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
                'html' => $this->CI->load->view('game/eden/Reports/ajax_level_active_byserver', $data, true)
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
        $this->CI->template->write_view('content', 'game/eden/Reports/topup_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_topup_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/eden/Reports/ajax_topup_byserver', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>14){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)',
                    'html' => $this->CI->load->view('game/eden/Reports/ajax_topup_byserver', '', true)
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
                    'html' => $this->CI->load->view('game/eden/Reports/ajax_topup_byserver', $data, true)
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
