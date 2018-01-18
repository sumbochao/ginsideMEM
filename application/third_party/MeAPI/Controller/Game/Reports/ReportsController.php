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
			case 'langkhach':
                $this->game = 'hiepkhach';
                $this->database='active_langkhach_info';
                break;
			case 'bog':
                $this->game = 'bog';
                $this->database='active_bog_info';
                break;
            case 'tethien':
                $this->game = 'tethien3d';
                $this->database='active_tethien3d_info';
                break;
			case 'giangma':
                $this->game = '125';
                $this->database='active_giangma_info';
                break;
			case 'ifish':
                $this->game = 'ifish';
                $this->database_sql='active_ifish_info';
				$this->database='active_vicamobo_info';
                break;
			case 'koa':
                $this->game = '143';
                $this->database='active_koa_info';
                break;
        }
    }
	public function process_user_active($recNew,$server){
		 foreach($recNew as $key =>$val){
			foreach($val as $k=>$v){
				$arrResultNew[$v["date"]]['date'] = $v["date"];
				if(in_array($v['server'],$server)){
					$arrResultNew[$v["date"]]['data'][$v['server']] = array(
						'date'=>$v["date"],
						'server'=>$v["server"],
						'new_active'=>$v["new_active"],
						'daily_active'=>$v["daily_active"],
						'total_active'=>$v["total_active"],
					);
				}
				$arrResultNew[$v["date"]]['server'][$v['server']] = $v["server"];
			}
		}
		$arrNotServer = array();
		foreach($arrResultNew as $key =>$val){
			$notKey = array_diff_key($server,$val['server']);
			foreach ($notKey as $v){
				$arrNotServer[$key][$v] = array(
					'date'=>$key,
					'server'=>$v,
					'new_active'=>'',
					'daily_active'=>'',
					'total_active'=>''
				);
			}
		}
		$result = array();
		foreach($arrResultNew as $key =>$val){
			$result[$key]['date'] = $key;
			$arrData = is_array($val['data'])?$val['data']:array();
			$arrKey = is_array($arrNotServer[$key])?$arrNotServer[$key]:array();
			$data_merge = array_merge($arrKey,$arrData);
			if(count($data_merge)>0){
				foreach($data_merge as $v){
					$result[$key]['data'][$v['server']] = $v;
				}
			}
			ksort($result[$key]['data']);
		}
		ksort($result);
		return $result;
	}
    public function user_active_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        
        $data = array();
        if(count($listServer)>0){
            $date_from = trim(date('d-m-Y',  strtotime('-15 day')));$arrDateFrom = explode('-', $date_from);
            $date_to = trim(date('d-m-Y'));$arrDateTo = explode('-', $date_to);
            $i=0;
            foreach($listServer as $server){
                $arrParam = array(
                    'server'=>trim($server['server_id']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->userActiveByServer($arrParam,$this->database);
                $result[] = $listItems;
                $arrServer[$server['server_id']] = $server['server_id'];
                $arrkey[$server['server_id']] =$i;
                $i++;
            }
        }
		
        /*$result[1][2] = array('date'=>'2015-07-22','server'=>'2','new_active'=>'1330','total_active'=>'36818');
        $result[3][2] = array('date'=>'2015-07-22','server'=>'4','new_active'=>'2222','total_active'=>'44444');
        $result[5][2] = array('date'=>'2015-07-22','server'=>'6','new_active'=>'6666','total_active'=>'464646');*/
        
        $recNew = array();
        foreach($result as $key => $row){
            foreach($row as $field => $value){
                $recNew[$field][] = $value;
            }
        }
        /*$arrResultNew = array();
        $i=0;
        foreach($recNew as $key=>$val){
            $j=0;
            if($i==0) $checkCount = count($val);
            foreach($val as $k=>$v){
                if(!empty($v["date"])){
                    $arrResultNew[$v["date"]]['date'] = $v["date"];
                }
                if(count($val)==count($arrServer)){
                    $arrResultNew[$v["date"]]['data'][$j] = array(
                        'date'=>$v["date"],
                        'server'=>$v["server"],
                        'new_active'=>$v["new_active"],
                        'daily_active'=>$v["daily_active"],
                        'total_active'=>$v["total_active"],
                    );
                }else{
                    for($h=0;$h<$checkCount;$h++){
                        if($h==$arrkey[$v["server"]]){
                            $arrResultNew[$v["date"]]['data'][$h] = array(
                                'date'=>$v["date"],
                                'server'=>$v["server"],
                                'new_active'=>$v["new_active"],
                                'daily_active'=>$v["daily_active"],
                                'total_active'=>$v["total_active"],
                            );
                        }
                    }
                }
                $j++;
            }
            $i++;
        }
		ksort($arrResultNew);*/
		//echo "<pre>";print_r($this->process_user_active($recNew,$arrServer));die();
        $this->data['listItems'] = $this->process_user_active($recNew,$arrServer);
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
        if($resultDate<0 || $resultDate>25){
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
                $i=0;
                foreach($listServer as $server){
                    $arrParam = array(
                        'server'=>trim($server['server_id']),
                        'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                        'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                    );
                    $listItems = $this->CI->ReportActiveModel->userActiveByServer($arrParam,$this->database);
                    $result[] = $listItems;
                    $arrServer[$server['server_id']] = $server['server_id'];
                    $arrkey[$server['server_id']] =$i;
                    $i++;
                }
            }
            //$result[1][2] = array('date'=>'2015-07-22','server'=>'2','new_active'=>'1330','total_active'=>'36818');
            //$result[3][2] = array('date'=>'2015-07-22','server'=>'4','new_active'=>'2222','total_active'=>'44444');
            //$result[5][2] = array('date'=>'2015-07-22','server'=>'6','new_active'=>'6666','total_active'=>'464646');
        
            $recNew = array();
            foreach($result as $key => $row) {
                foreach($row as $field => $value) { 
                    $recNew[$field][] = $value;
                }
            }
           
            /*$arrResultNew = array();
            $i=0;
            foreach($recNew as $key=>$val){
                $j=0;
                if($i==0) $checkCount = count($val);
                foreach($val as $k=>$v){
                    if(!empty($v["date"])){
                        $arrResultNew[$v["date"]]['date'] = $v["date"];
                    }
                    if(count($val)==count($arrServer)){
                        $arrResultNew[$v["date"]]['data'][$j] = array(
                            'date'=>$v["date"],
                            'server'=>$v["server"],
                            'new_active'=>$v["new_active"],
                            'daily_active'=>$v["daily_active"],
                            'total_active'=>$v["total_active"],
                        );
                    }else{
                        for($h=0;$h<$checkCount;$h++){
                            if($h==$arrkey[$v["server"]]){
                                $arrResultNew[$v["date"]]['data'][$h] = array(
                                    'date'=>$v["date"],
                                    'server'=>$v["server"],
                                    'new_active'=>$v["new_active"],
                                    'daily_active'=>$v["daily_active"],
                                    'total_active'=>$v["total_active"],
                                );
                            }
                        }
                    }
                    $j++;
                }
                $i++;
            } 
			ksort($arrResultNew);*/
            $this->data['listItems'] = $this->process_user_active($recNew,$arrServer);;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_user_active_byserver', $this->data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function user_active_bydate(MeAPI_RequestInterface $request) {   
        //$result = json_decode('[{"date":"2015-10-12","server":"169001","new_active":"171","daily_active":"1498","total_active":"30352"},{"date":"2015-10-12","server":"169002","new_active":"151","daily_active":"1845","total_active":"42193"},{"date":"2015-10-12","server":"169003","new_active":"124","daily_active":"2303","total_active":"58675"},{"date":"2015-10-12","server":"169004","new_active":"100","daily_active":"2311","total_active":"53139"},{"date":"2015-10-12","server":"169005","new_active":"369","daily_active":"3140","total_active":"50672"},{"date":"2015-10-12","server":"169006","new_active":"335","daily_active":"4811","total_active":"57535"},{"date":"2015-10-12","server":"169007","new_active":"639","daily_active":"3455","total_active":"29250"},{"date":"2015-10-12","server":"169008","new_active":"723","daily_active":"4025","total_active":"23020"},{"date":"2015-10-12","server":"169009","new_active":"6637","daily_active":"11140","total_active":"21634"}]',true);
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $result = $this->CI->ReportActiveModel->userActiveByDate(array('date'=>date('Y-m-d')),$this->database);       
        $listItems[$result[0]['date']] = array(
            'date'=>$result[0]['date'],
            'data'=>$result
        );
        $this->data['listItems'] = $listItems;
        $this->data['database'] = $this->database;
        $this->CI->template->write_view('content', 'game/reports/user_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_user_active_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/reports/ajax_user_active_bydate', '', true)
            );
        }else{
            $listServer = $this->CI->ReportActiveModel->listServer($this->game);
            $this->data['listServer'] = $listServer;
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            $arrParam = array('date'=>$arrDate['2'].$arrDate['1'].$arrDate['0']);
            $result = $this->CI->ReportActiveModel->userActiveByDate($arrParam,$this->database);
            $listItems[$result[0]['date']] = array(
                'date'=>$result[0]['date'],
                'data'=>$result
            );
            $this->data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_user_active_bydate', $this->data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
	//end tai khoan theo ngay
	
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
            if($resultDate<=0 || $resultDate>25){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
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
            if($resultDate<=0 || $resultDate>25){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
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
	//money by server
    public function money_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
		$listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/money_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_money_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/ajax_money_bydate', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>25){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
                    'html' => $this->CI->load->view('game/reports/ajax_money_bydate', '', true)
                );
            }else{
                $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
                $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
                $arrParam = array(
                    'server'=>trim($_REQUEST['server']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->moneyByServer($arrParam,$this->database);
                $data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('game/reports/ajax_money_bydate', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
	//card trong game
    public function card_statistics(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listData = $this->CI->ReportActiveModel->cardStatisticsGame(array(),$this->database);
        
        $result = array();
        $arrkey = array();
        $arrServer = array();
        if(is_array($listData)){
            foreach($listData as $v){
                $result[$v['cardID']][] = $v;
                $arrServer[$v['serverID']] = $v['serverID'];
            }
            $i=0;
            foreach($arrServer as $ks){
                $arrkey[$ks] =$i;
                $i++;
            }
        }
        $recNew = array();
        foreach($result as $key => $row){
            foreach($row as $field => $value){
                for($h=0;$h<count($arrServer);$h++){
                    if($h==$arrkey[$value["serverID"]]){
                        $recNew[$value['cardID']][$arrkey[$value['serverID']]] = $value;
                    }
                }
            }
        }
        
        $this->data['listServer'] = $arrServer;
        $this->data['listItems'] = $recNew;
        $this->CI->template->write_view('content', 'game/reports/card_statistics', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML()); 
    }
	//UID theo chỉ số VIP
    public function list_vip_byserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/list_vip_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML()); 
    }
    public function ajax_list_vip_byserver(MeAPI_RequestInterface $request){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/ajax_list_vip_byserver', '', true)
            );
        }else{
            if(empty($_REQUEST['vip']) || !is_numeric($_REQUEST['vip'])){
                $reponse = array(
                    'error' =>1,
                    'messg' => 'Vui lòng nhập vip',
                    'html' => $this->CI->load->view('game/reports/ajax_list_vip_byserver', '', true)
                );
            }else{
                $arrParam = array(
                    'server'=>$_REQUEST['server'],
                    'vip'=>$_REQUEST['vip'],
                );
                $listItems = $this->CI->ReportActiveModel->listVipByserver($arrParam,$this->database);
				
                $data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('game/reports/ajax_list_vip_byserver', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
	//role active by server
    public function role_active_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        
        $data = array();
        if(count($listServer)>0){
            $date_from = trim(date('d-m-Y',  strtotime('-15 day')));$arrDateFrom = explode('-', $date_from);
            $date_to = trim(date('d-m-Y'));$arrDateTo = explode('-', $date_to);
            $i=0;
            foreach($listServer as $server){
                $arrParam = array(
                    'server'=>trim($server['server_id']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->roleActiveByServer($arrParam,$this->database);
                $result[] = $listItems;
                $arrServer[$server['server_id']] = $server['server_id'];
                $arrkey[$server['server_id']] =$i;
                $i++;
            }
        }
		
        /*$result[1][2] = array('date'=>'2015-07-22','server'=>'2','new_active'=>'1330','total_active'=>'36818');
        $result[3][2] = array('date'=>'2015-07-22','server'=>'4','new_active'=>'2222','total_active'=>'44444');
        $result[5][2] = array('date'=>'2015-07-22','server'=>'6','new_active'=>'6666','total_active'=>'464646');*/
        
        $recNew = array();
        foreach($result as $key => $row){
            foreach($row as $field => $value){
                $recNew[$field][] = $value;
            }
        }
        
        $arrResultNew = array();
        $i=0;
        foreach($recNew as $key=>$val){
            $j=0;
            if($i==0) $checkCount = count($val);
            foreach($val as $k=>$v){
                if(!empty($v["date"])){
                    $arrResultNew[$v["date"]]['date'] = $v["date"];
                }
                if(count($val)==count($arrServer)){
                    $arrResultNew[$v["date"]]['data'][$j] = array(
                        'date'=>$v["date"],
                        'server'=>$v["server"],
                        'new_active'=>$v["new_active"],
                        'daily_active'=>$v["daily_active"],
                        'total_active'=>$v["total_active"],
                    );
                }else{
                    for($h=0;$h<$checkCount;$h++){
                        if($h==$arrkey[$v["server"]]){
                            $arrResultNew[$v["date"]]['data'][$h] = array(
                                'date'=>$v["date"],
                                'server'=>$v["server"],
                                'new_active'=>$v["new_active"],
                                'daily_active'=>$v["daily_active"],
                                'total_active'=>$v["total_active"],
                            );
                        }
                    }
                }
                $j++;
            }
            $i++;
        }
		ksort($arrResultNew);
		//echo "<pre>";print_r($arrResultNew);die();
        $this->data['listItems'] = $arrResultNew;
        $this->data['database'] = $this->database;
        $this->CI->template->write_view('content', 'game/reports/role_active_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_role_active_byserver(){
        $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
        $resultDate = $resultDate/(3600*24);
        if($resultDate<0 || $resultDate>25){
            $reponse = array(
                'error' => 1,
                'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
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
                $i=0;
                foreach($listServer as $server){
                    $arrParam = array(
						'server'=>trim($server['server_id']),
						'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
						'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
					);
                    $listItems = $this->CI->ReportActiveModel->roleActiveByServer($arrParam,$this->database);
                    $result[] = $listItems;
                    $arrServer[$server['server_id']] = $server['server_id'];
                    $arrkey[$server['server_id']] =$i;
                    $i++;
                }
            }
			
            //$result[1][2] = array('date'=>'2015-07-22','server'=>'2','new_active'=>'1330','total_active'=>'36818');
            //$result[3][2] = array('date'=>'2015-07-22','server'=>'4','new_active'=>'2222','total_active'=>'44444');
            //$result[5][2] = array('date'=>'2015-07-22','server'=>'6','new_active'=>'6666','total_active'=>'464646');
            $recNew = array();
            foreach($result as $key => $row) {
				if(count($row)>0){
					foreach($row as $field => $value) { 
						$recNew[$field][] = $value;
					}
				}
            }
           
            $arrResultNew = array();
            $i=0;
            foreach($recNew as $key=>$val){
                $j=0;
                if($i==0) $checkCount = count($val);
                foreach($val as $k=>$v){
                    if(!empty($v["date"])){
                        $arrResultNew[$v["date"]]['date'] = $v["date"];
                    }
                    if(count($val)==count($arrServer)){
                        $arrResultNew[$v["date"]]['data'][$j] = array(
                            'date'=>$v["date"],
                            'server'=>$v["server"],
                            'new_active'=>$v["new_active"],
                            'daily_active'=>$v["daily_active"],
                            'total_active'=>$v["total_active"],
                        );
                    }else{
                        for($h=0;$h<$checkCount;$h++){
                            if($h==$arrkey[$v["server"]]){
                                $arrResultNew[$v["date"]]['data'][$h] = array(
                                    'date'=>$v["date"],
                                    'server'=>$v["server"],
                                    'new_active'=>$v["new_active"],
                                    'daily_active'=>$v["daily_active"],
                                    'total_active'=>$v["total_active"],
                                );
                            }
                        }
                    }
                    $j++;
                }
                $i++;
            } 
			ksort($arrResultNew);
            $this->data['listItems'] = $arrResultNew;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_role_active_byserver', $this->data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    //role active by date
    public function role_active_bydate(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $result = $this->CI->ReportActiveModel->roleActiveByDate(array('date'=>date('Y-m-d')),$this->database);       
        $listItems[$result[0]['date']] = array(
            'date'=>$result[0]['date'],
            'data'=>$result
        );
        $this->data['listItems'] = $listItems;
        $this->data['database'] = $this->database;
        $this->CI->template->write_view('content', 'game/reports/role_active_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_role_active_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/reports/ajax_role_active_bydate', '', true)
            );
        }else{
            $listServer = $this->CI->ReportActiveModel->listServer($this->game);
            $this->data['listServer'] = $listServer;
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            $arrParam = array('date'=>$arrDate['2'].$arrDate['1'].$arrDate['0']);
            $result = $this->CI->ReportActiveModel->roleActiveByDate($arrParam,$this->database);
            $listItems[$result[0]['date']] = array(
                'date'=>$result[0]['date'],
                'data'=>$result
            );
            $this->data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_role_active_bydate', $this->data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
	//bluegem by server
    public function bluegem_statistics_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/bluegem_statistics_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_bluegem_statistics_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/ajax_bluegem_statistics_byserver', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>25){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
                    'html' => $this->CI->load->view('game/reports/ajax_bluegem_statistics_byserver', '', true)
                );
            }else{
                $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
                $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
                $arrParam = array(
                    'server'=>trim($_REQUEST['server']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->bluegemStatisticsByServer($arrParam,$this->database);
                $data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('game/reports/ajax_bluegem_statistics_byserver', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    public function bluegem_statistics_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/reports/bluegem_statistics_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_bluegem_statistics_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/reports/ajax_bluegem_statistics_byserver', '', true)
            );
        }else{
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            
            $arrParam = array(
                'date'=>$arrDate['2'].$arrDate['1'].$arrDate['0'],
            );
            $listItems = $this->CI->ReportActiveModel->bluegemStatisticsByDate($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ajax_bluegem_statistics_byserver', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
	//te thien thong ke vip
    public function vip_statistics_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/reports/tethien/vip_statistics_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_vip_statistics_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/reports/tethien/ajax_vip_statistics', '', true)
            );
        }else{
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            
            $arrParam = array(
                'date'=>$arrDate['2'].$arrDate['1'].$arrDate['0'],
            );
            $listItems = $this->CI->ReportActiveModel->vipStatisticsByDate($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/tethien/ajax_vip_statistics', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
	public function vip_statistics_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/tethien/vip_statistics_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_vip_statistics_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/tethien/ajax_vip_statistics', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>25){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
                    'html' => $this->CI->load->view('game/reports/tethien/ajax_vip_statistics', '', true)
                );
            }else{
                $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
                $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
                $arrParam = array(
                    'server'=>trim($_REQUEST['server']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
                );
                $listItems = $this->CI->ReportActiveModel->vipStatisticsByServer($arrParam,$this->database);
                $data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('game/reports/tethien/ajax_vip_statistics', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
	//te thien thong ke card tuong
    public function card_statistics_bydate(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);        
        $this->CI->template->write_view('content', 'game/reports/tethien/card_statistics_bydate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_card_statistics_bydate(){
        if($_REQUEST['date']==''){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng nhập ngày',
                'html' => $this->CI->load->view('game/reports/tethien/ajax_card_statistics', '', true)
            );
        }else{
            $date = trim($_REQUEST['date']);$arrDate = explode('-', $date);
            
            $arrParam = array(
                'date'=>$arrDate['2'].$arrDate['1'].$arrDate['0'],
                'Is5Start'=>$_REQUEST['Is5Start']
            );
            $listItems = $this->CI->ReportActiveModel->cardStatisticsByDate($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/tethien/ajax_card_statistics', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function card_statistics_byserver(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/tethien/card_statistics_byserver', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_card_statistics_byserver(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/tethien/ajax_vip_statistics', '', true)
            );
        }else{
            $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
            $resultDate = $resultDate/(3600*24);
            if($resultDate<=0 || $resultDate>25){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
                    'html' => $this->CI->load->view('game/reports/tethien/ajax_card_statistics', '', true)
                );
            }else{
                $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
                $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
                $arrParam = array(
                    'server'=>trim($_REQUEST['server']),
                    'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                    'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0'],
                    'Is5Start'=>$_REQUEST['Is5Start']
                );
                $listItems = $this->CI->ReportActiveModel->cardStatisticsByServer($arrParam,$this->database);
                $data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('game/reports/tethien/ajax_card_statistics', $data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
	public function money_statistics_activeuser_all(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listItems = $this->CI->ReportActiveModel->moneyStatisticsActiveUserAll($this->database);
        $this->data['listItems'] = $listItems;
        $this->CI->template->write_view('content', 'game/reports/bog/money_statistics_activeuser_all', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function money_statistics_activeuser_details(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/bog/money_statistics_activeuser_details', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_money_statistics_activeuser_details(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/bog/ajax_money_statistics_activeuser_details', '', true)
            );
        }else{
            $arrParam = array(
                'server'=>trim($_REQUEST['server']),
            );
            $listItems = $this->CI->ReportActiveModel->moneyStatisticsActiveUserDetails($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/bog/ajax_money_statistics_activeuser_details', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
	public function top_battlescore(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/giangma/top_battlescore', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_top_battlescore(){
        if($_REQUEST['server']==0){
            $reponse = array(
                'error' =>1,
                'messg' => 'Vui lòng chọn máy chủ',
                'html' => $this->CI->load->view('game/reports/giangma/ajax_top_battlescore', '', true)
            );
        }else{
            $arrParam = array(
                'server'=>trim($_REQUEST['server']),
            );
            $listItems = $this->CI->ReportActiveModel->topBattleScore($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/giangma/ajax_top_battlescore', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
	//banca
    public function user_realtime(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'USER NHẬN THEO NGÀY';
        if (empty($_GET['ngay'])){
            $datetime = date('Ymd');
            $unixTime = strtotime(date('Y/m/d'));
        }else{
            $datetime = str_replace ('-','',$_GET['ngay']);
            $unixTime = strtotime($_GET['ngay']);
        }
        
        $arrParam = array('type'=>'ngay','date'=>$datetime);
        $listItems = $this->CI->ReportActiveModel->getDataUserIngot($arrParam);
        $this->data['listItems'] = $listItems;
		
        $this->data['prevUnixTime'] = $unixTime-86400;
        $this->data['currUnixTime'] = $unixTime;
        $this->data['nextUnixTime'] = $unixTime+86400;
        
        $this->CI->template->write_view('content', 'game/reports/ifish/user_realtime', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_user_realtime(){
		if (empty($_GET['ngay'])){
            $datetime = date('Ymd');
            $unixTime = strtotime(date('Y/m/d'));
        }else{
            $datetime = str_replace ('-','',$_GET['ngay']);
            $unixTime = strtotime($_GET['ngay']);
        }
        
        $arrParam = array('type'=>'ngay','date'=>$datetime);
        $listItems = $this->CI->ReportActiveModel->getDataUserIngot($arrParam);
        $this->data['listItems'] = $listItems;
        $response = array(
            'error' => 0,
            'msg'   => 'Success',
            'html'  => NULL,
        );
            
        $this->data['prevUnixTime'] = $unixTime-86400;
        $this->data['currUnixTime'] = $unixTime;
        $this->data['nextUnixTime'] = $unixTime+86400;
        
        $response['html'] = $this->CI->load->view('game/reports/ifish/ajax_user_realtime',$this->data, true);
        echo json_encode($response);
        exit;
    }
    public function user_ingot_between(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'TỔNG USER';
        $arrParam = array(
            'type'=>'tatca',
        );  
        $listItems = $this->CI->ReportActiveModel->getDataUserIngot($arrParam);
        $this->data['listItems'] = $listItems;
            
        $this->CI->template->write_view('content', 'game/reports/ifish/user_ingot_between', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_user_ingot_between(MeAPI_RequestInterface $request){
        $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
        $resultDate = $resultDate/(3600*24);
        if($resultDate<=0 || $resultDate>25){
            $reponse = array(
                'error' => 1,
                'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
                'html' => $this->CI->load->view('game/reports/ifish/ajax_user_ingot_between', '', true)
            );
        }else{
            $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
            $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
            $arrParam = array(
                'type'=>'khoangngay',
                'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
            );
            $listItems = $this->CI->ReportActiveModel->getDataUserIngot($arrParam);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ifish/ajax_user_ingot_between', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function user_ingot(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'TỔNG USER';
        if(!empty($_POST['userid'])){
            $arrParam = array('type'=>'userid','userid'=>$_POST['userid']);
        }else{
            $arrParam = array('type'=>'tatca');
        }
        $listItems = $this->CI->ReportActiveModel->getDataUserIngotDetail($arrParam);
        $this->data['listItems'] = $listItems;
        $this->CI->template->write_view('content', 'game/reports/ifish/user_ingot', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function rpt_account_info(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'VÍ TIỀN USER';
        if(!empty($_POST['msi'])){
            $arrParam = array('type'=>'msi','msi'=>$_POST['msi']);
        }else{
            $arrParam = array('type'=>'all');
        }
        $listItems = $this->CI->ReportActiveModel->getRptAccountInfo($arrParam,$this->database);
        $this->data['listItems'] = $listItems;
            
        $this->CI->template->write_view('content', 'game/reports/ifish/rpt_account_info', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	//thong tin luong nap theo ngay
    public function info_daily_realtime(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'THÔNG TIN LƯỢNG NẠP THEO NGÀY';
        if (empty($_GET['ngay'])){
            $datetime = date('Ymd');
            $unixTime = strtotime(date('Y/m/d'));
        }else{
            $datetime = str_replace ('-','',$_GET['ngay']);
            $unixTime = strtotime($_GET['ngay']);
        }
        $arrParam = array('type'=>'ngay','date'=>$datetime);
        $listItems = $this->CI->ReportActiveModel->getRptServerInfoDaily($arrParam,$this->database);
        $this->data['listItems'] = $listItems;
		
        $this->data['prevUnixTime'] = $unixTime-86400;
        $this->data['currUnixTime'] = $unixTime;
        $this->data['nextUnixTime'] = $unixTime+86400;
        
        $this->CI->template->write_view('content', 'game/reports/ifish/info_daily_realtime', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_info_daily_realtime(){
        if (empty($_GET['ngay'])){
            $datetime = date('Ymd');
            $unixTime = strtotime(date('Y/m/d'));
        }else{
            $datetime = str_replace ('-','',$_GET['ngay']);
            $unixTime = strtotime($_GET['ngay']);
        }
        $arrParam = array('type'=>'ngay','date'=>$datetime);
        $listItems = $this->CI->ReportActiveModel->getRptServerInfoDaily($arrParam,$this->database);
        $this->data['listItems'] = $listItems;
        $response = array(
            'error' => 0,
            'msg'   => 'Success',
            'html'  => NULL,
        );
            
        $this->data['prevUnixTime'] = $unixTime-86400;
        $this->data['currUnixTime'] = $unixTime;
        $this->data['nextUnixTime'] = $unixTime+86400;
        
        $response['html'] = $this->CI->load->view('game/reports/ifish/ajax_info_daily_realtime',$this->data, true);
        echo json_encode($response);
        exit;
    }
	//luong nap theo khoang thoi gian
    public function rpt_server_info_daily(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'LƯỢNG NẠP USER THEO KHOẢNG NGÀY';
        $arrParam = array(
            'type'=>'khoangngay',
            'date_from'=>date('Ymd',strtotime("-25 days")),
            'date_to'=>date('Ymd')
        );  
        $this->data['listItems'] = $this->CI->ReportActiveModel->getRptServerInfoDaily($arrParam,$this->database);
        
        $this->CI->template->write_view('content', 'game/reports/ifish/rpt_server_info_daily', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_rpt_server_info_daily(MeAPI_RequestInterface $request){
        $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
        $resultDate = $resultDate/(3600*24);
        if($resultDate<=0 || $resultDate>25){
            $reponse = array(
                'error' => 1,
                'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
                'html' => $this->CI->load->view('game/reports/ifish/ajax_rpt_server_info_daily', '', true)
            );
        }else{
            $date_from = trim($_REQUEST['date_from']);$arrDateFrom = explode('-', $date_from);
            $date_to = trim($_REQUEST['date_to']);$arrDateTo = explode('-', $date_to);
            $arrParam = array(
                'type'=>'khoangngay',
                'date_from'=>$arrDateFrom['2'].$arrDateFrom['1'].$arrDateFrom['0'],
                'date_to'=>$arrDateTo['2'].$arrDateTo['1'].$arrDateTo['0']
            );
            $listItems = $this->CI->ReportActiveModel->getRptServerInfoDaily($arrParam,$this->database);
            $data['listItems'] = $listItems;
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/ifish/ajax_rpt_server_info_daily', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
	//koa
    public function topup_hourly(MeAPI_RequestInterface $request) {        
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->ReportActiveModel->listServer($this->game);
        $this->data['listServer'] = $listServer;
        $this->CI->template->write_view('content', 'game/reports/koa/topup_hourly', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_topup_hourly(){
        $resultDate = strtotime($_REQUEST['date_to'])-strtotime($_REQUEST['date_from']);
        $resultDate = $resultDate/(3600*24);
        if($resultDate<=0 || $resultDate>25){
            $reponse = array(
                'error' => 1,
                'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 25 ngày)',
                'html' => $this->CI->load->view('game/reports/koa/ajax_topup_hourly', '', true)
            );
        }else{
            $date_from = trim($_REQUEST['date_from']);
            $date_to = trim($_REQUEST['date_to']);
            $arrParam = array(
                'server'=>trim($_REQUEST['server']),
                'platform'=>$_REQUEST['platform'],
                'date_from'=>date_format(date_create($date_from),"Y-m-d"),
                'date_to'=>date_format(date_create($date_to),"Y-m-d")
            );
            $data['listItems'] = $this->CI->ReportActiveModel->getTopupHourly($arrParam,$this->database);
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('game/reports/koa/ajax_topup_hourly', $data, true)
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function getResponse() {
        return $this->_response;
    }
}
