<?php
class MeAPI_Controller_KOA_Events_UocnguyenController implements MeAPI_Controller_KOA_Events_UocnguyenInterface {
    protected $_response;
    private $CI;
    private $url_service;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->MeAPI_Model('ServerModel');
		$this->CI->load->MeAPI_Model('BuildHoThanModel');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.koa.mobo.vn/koa/index.php';
            $this->url_picture = 'http://localhost.service.koa.mobo.vn/koa/assets/uocnguyen';
        }else{
            $this->url_service = 'http://game.mobo.vn/lucgioi';
            $this->url_picture = $this->url_service.'/assets/uocnguyen';
        }
		$this->data['url_service'] = $this->url_service;
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'DANH SÁCH SỰ KIỆN';
                break;
            case 'item':
                $this->data['title']= 'DANH SÁCH QUÀ';
                break;
            case 'user':
                $this->data['title']= 'DANH SÁCH THÀNH VIÊN';
                break;
            case 'paymentrate':
                $this->data['title']= 'DANH SÁCH THANH TOÁN';
                break;
            case 'serverthan':
                $this->data['title']= 'DANH SÁCH SERVER THẦN';
				$linkSlbThan = $this->url_service.'/cms/uocnguyen/slbthan';
                $j_slbThan = file_get_contents($linkSlbThan);
                $slbThan = json_decode($j_slbThan,true);
                $arrThan = array();
                if(count($slbThan)>0){
                    foreach($slbThan as $v){
                        $arrThan[$v['id']] = $v['name'];
                    }
                }
                $this->data['slbThan'] = json_encode($arrThan);
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->data['url_picture'] = $this->url_picture;
        $this->data['slbServer'] = $this->CI->ServerModel->slbServerByGame('koa');
        $this->CI->template->write_view('content', 'game/koa/Events/uocnguyen/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'THÊM SỰ KIỆN';
                break;
            case 'item':
                $this->data['title']= 'THÊM QUÀ';
                break;
            case 'user':
                $this->data['title']= 'THÊM THÀNH VIÊN';
                break;
            case 'paymentrate':
                $this->data['title']= 'THÊM THANH TOÁN';
                $linkSlbEvent = $this->url_service.'/cms/uocnguyen/slbevent';
                $j_slbEvent = file_get_contents($linkSlbEvent);
                $slbEvent = json_decode($j_slbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
                break;
            case 'serverthan':
                $this->data['title']= 'THÊM SERVER THẦN';
                $linkSlbEvent = $this->url_service.'/cms/uocnguyen/slbevent';
                $j_slbEvent = file_get_contents($linkSlbEvent);
                $slbEvent = json_decode($j_slbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
                
                $linkSlbItem = $this->url_service.'/cms/uocnguyen/slbitem';
                $j_slbItem = file_get_contents($linkSlbItem);
                $slbItem = json_decode($j_slbItem,true);
                $this->data['slbItem'] = $slbItem;
                
                
                $linkSlbThan = $this->url_service.'/cms/uocnguyen/slbthan';
                $j_slbThan = file_get_contents($linkSlbThan);
                $slbThan = json_decode($j_slbThan,true);
                $this->data['slbThan'] = $slbThan;
                $this->data['slbServer'] = $this->CI->ServerModel->slbServerByGame('koa');
                break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->data['url_picture'] = $this->url_picture;
        $this->CI->template->write_view('content', 'game/koa/Events/uocnguyen/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'SỬA SỰ KIỆN';
                break;
            case 'item':
                $this->data['title']= 'SỬA QUÀ';
                break;
            case 'user':
                $this->data['title']= 'SỬA THÀNH VIÊN';
                break;
            case 'paymentrate':
                $this->data['title']= 'SỬA THANH TOÁN';
                $linkSlbEvent = $this->url_service.'/cms/uocnguyen/slbevent';
                $j_slbEvent = file_get_contents($linkSlbEvent);
                $slbEvent = json_decode($j_slbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
                break;
            case 'serverthan':
                $this->data['title']= 'SỬA SERVER THẦN';
                $linkSlbEvent = $this->url_service.'/cms/uocnguyen/slbevent';
                $j_slbEvent = file_get_contents($linkSlbEvent);
                $slbEvent = json_decode($j_slbEvent,true);
                $this->data['slbEvent'] = $slbEvent;
                
                $linkSlbItem = $this->url_service.'/cms/uocnguyen/slbitem';
                $j_slbItem = file_get_contents($linkSlbItem);
                $slbItem = json_decode($j_slbItem,true);
                $this->data['slbItem'] = $slbItem;
                
                $linkSlbThan = $this->url_service.'/cms/uocnguyen/slbthan';
                $j_slbThan = file_get_contents($linkSlbThan);
                $slbThan = json_decode($j_slbThan,true);
                $this->data['slbThan'] = $slbThan;
                
                $this->data['slbServer'] = $this->CI->ServerModel->slbServerByGame('koa');
                break;
        }
        $linkinfo = $this->url_service.'/cms/uocnguyen/gettem_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->data['url_picture'] = $this->url_picture;
        $this->CI->template->write_view('content', 'game/koa/Events/uocnguyen/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/uocnguyen/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&module=all&view='.$_GET['view'].'#'.$_GET['view']); 
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $this->data['slbServer'] = $this->CI->ServerModel->slbServerByGame('koa');
        $arrResult = array();
        if($_POST['server_id']>0 && !empty($_POST['start']) && !empty($_POST['end'])){
           
            $lnkCountUser = $this->url_service.'/cms/uocnguyen/count_by_user?server_id='.$_POST['server_id'].'&start='.strtotime($_POST['start']).'&end='.strtotime($_POST['end']);
            $j_CountUser = file_get_contents($lnkCountUser);
            $arrUser = json_decode($j_CountUser,true);
            
           
            $lnkCountFree = $this->url_service.'/cms/uocnguyen/count_by_free?server_id='.$_POST['server_id'].'&start='.strtotime($_POST['start']).'&end='.strtotime($_POST['end']);
            $j_CountFree = file_get_contents($lnkCountFree);
            $arrFree = json_decode($j_CountFree,true);
            
            $lnkCountNoFree = $this->url_service.'/cms/uocnguyen/count_by_nofree?server_id='.$_POST['server_id'].'&start='.strtotime($_POST['start']).'&end='.strtotime($_POST['end']);
            $j_CountNoFree = file_get_contents($lnkCountNoFree);
            $arrNoFree = json_decode($j_CountNoFree,true);
             
            if(count($arrUser)>0){
                foreach($arrUser as $k=> $user){
                    $arrResult[$user['created_date']] = $user;
                    if(count($arrFree)>0){
                        $arrResult[$user['created_date']]['count_free'] = $arrFree[$user['created_date']]['count_free'];
                    }
                    if(count($arrNoFree)>0){
                        $arrResult[$user['created_date']]['count_nofree'] = $arrNoFree[$user['created_date']]['count_nofree'];
                    }
                }
            }
        }else{
            $start = strtotime($_POST['start']);
            $end = strtotime($_POST['end']);
            $lnkCountUser = $this->url_service.'/cms/uocnguyen/date_count_by_user?start='.$start.'&end='.$end;
            $j_CountUser = file_get_contents($lnkCountUser);
            $arrUser = json_decode($j_CountUser,true);
            $lnkCountFree = $this->url_service.'/cms/uocnguyen/date_count_by_free?start='.$start.'&end='.$end;
            $j_CountFree = file_get_contents($lnkCountFree);
            $arrFree = json_decode($j_CountFree,true);
            
            $lnkCountNoFree = $this->url_service.'/cms/uocnguyen/date_count_by_nofree?start='.$start.'&end='.$end;
            $j_CountNoFree = file_get_contents($lnkCountNoFree);
            $arrNoFree = json_decode($j_CountNoFree,true);
            if(count($arrUser)>0){
                foreach($arrUser as $k=> $user){
                    $arrResult[$user['server_id']] = $user;
                    if(is_array($arrFree[$user['server_id']])){
                        $arrResult[$user['server_id']]['count_free'] = $arrFree[$user['server_id']]['count_free'];
                    }
                    if(is_array($arrNoFree[$user['server_id']])){
                        $arrResult[$user['server_id']]['count_nofree'] = $arrNoFree[$user['server_id']]['count_nofree'];
                    }
                }
            }
        }
        $this->data['listItem'] = $arrResult;
        $this->CI->template->write_view('content', 'game/koa/Events/uocnguyen/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function post_event(MeAPI_RequestInterface $request){
        if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
            if($_FILES['image']['size'] > 1048576){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700MB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }else{
                $_FILES['image']['encodefile'] = $this->data_uri($_FILES['image']['tmp_name'], $_FILES['image']['type']);
                $arrPOST = array('id'=>$_POST['id'],'current_image'=>$_POST['current_image']);
                $image = $this->curlPost($_FILES['image'],$arrPOST);
            }
        }else{
            if($_POST['id']>0){
                $image = $_POST['current_image'];
            }
        }
        if($_POST['id']>0){
            $array = array(
                'id'=>$_POST['id'],
                'event_name'=>$_POST['event_name'],
                'image'=>$image,
                'is_active'=>$_POST['is_active'],
                'start_date'=>$_POST['start_date'],
                'end_date'=>$_POST['end_date'],
                'free'=>$_POST['free'],
            );
        }else{
            $array = array(
                'event_name'=>$_POST['event_name'],
                'image'=>$image,
                'is_active'=>$_POST['is_active'],
                'start_date'=>$_POST['start_date'],
                'end_date'=>$_POST['end_date'],
                'free'=>$_POST['free'],
            );
        }
        
        $action = ($_POST['id']>0)?'edit_event':'add_event';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/uocnguyen/".$action);        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
    public function post_item(MeAPI_RequestInterface $request){
        if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
            if($_FILES['image']['size'] > 1048576){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700MB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }else{
                $_FILES['image']['encodefile'] = $this->data_uri($_FILES['image']['tmp_name'], $_FILES['image']['type']);
                $arrPOST = array('id'=>$_POST['id'],'current_image'=>$_POST['current_image']);
                $image = $this->curlPost($_FILES['image'],$arrPOST);
            }
        }else{
            if($_POST['id']>0){
                $image = $_POST['current_image'];
            }
        }
        if($_POST['id']>0){
            $array = array(
                'id'=>$_POST['id'],
                'item_name'=>$_POST['item_name'],
                'image'=>$image,
                'quantity'=>$_POST['quantity']
            );
        }else{
            $array = array(
                'item_name'=>$_POST['item_name'],
                'image'=>$image,
                'quantity'=>$_POST['quantity']
            );
        }
        
        $action = ($_POST['id']>0)?'edit_item':'add_item';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/uocnguyen/".$action);        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
    public function post_serverthan(MeAPI_RequestInterface $request){
        $arrPicture = array();
        if(count($_FILES['images']['name'])>0){
            foreach($_FILES['images']['name'] as $k=>$v){
                $arrPicture[$k]['name'] = $v;
                $arrPicture[$k]['type'] = $_FILES['images']['type'][$k];
                $arrPicture[$k]['tmp_name'] = $_FILES['images']['tmp_name'][$k];
                $arrPicture[$k]['error'] = $_FILES['images']['error'][$k];
                $arrPicture[$k]['size'] = $_FILES['images']['size'][$k];
                $arrPicture[$k]['current_images'] = $_POST['current_images'][$k];
            }
        }
       
        $item_id = '';
        if(count($_POST['item_id'])>0){
            foreach($_POST['item_id'] as $k=>$v){
                $arrItem[$k]['item_id'] = $v;
                $arrItem[$k]['name'] = $_POST['name'][$k];
                if(isset($arrPicture[$k]['tmp_name']) && !empty($arrPicture[$k]['tmp_name'])){
                    $arrPicture[$k]['encodefile'] = $this->data_uri($arrPicture[$k]['tmp_name'], $arrPicture[$k]['type']);
                    $arrPOST = array('id'=>$_POST['id'],'current_images'=>$arrPicture[$k]['current_images']);
                    $image = $this->curlPost($arrPicture[$k],$arrPOST);
                }else{
                    if($_POST['id']>0){
                        $image = $_POST['current_images'][$k];
                    }
                }
                $arrItem[$k]['images'] = $image;
                $arrItem[$k]['count'] = $_POST['count'][$k];
				$arrItem[$k]['quantity'] = $_POST['quantity'][$k];
				if($_POST['action']=='add'){
                    $arrItem[$k]['current_quantity'] = $_POST['quantity'][$k];
                }else{
                    if(isset($_POST['current_quantity'][$k]) && !empty($_POST['current_quantity'][$k])){
                        $arrItem[$k]['current_quantity'] = $_POST['current_quantity'][$k];
                    }else{
                        $arrItem[$k]['current_quantity'] = $_POST['quantity'][$k];
                    }
                }
                $arrItem[$k]['rate'] = $_POST['rate'][$k];
            }
            $item_id = json_encode($arrItem);
        }
        
        if($_POST['id']>0){
            //check remove picture
            $data_items = json_decode(base64_decode($_POST['data_items']),true);
            $arrDataPicture = array();
            if(is_array($data_items)){
                foreach($data_items as $v){
                    $arrDataPicture[] = $v['images'];
                }
            }
            if(is_array($_POST['current_images'])){
                $arrCurrentImages = $_POST['current_images'];
            }else{
                $arrCurrentImages = array();
            }
            $resultDiff = array_diff($arrDataPicture,$arrCurrentImages);
            if(count($resultDiff)>0){
                foreach($resultDiff as $picture){
                    $this->curlPost(array(),array('images'=>$picture),$this->url_service."/cms/uocnguyen/remove_path_images");
                }
            }
            
            $array = array(
                'id'=>$_POST['id'],
                'than_id'=>$_POST['than_id'],
                'server_id'=>$_POST['server_id'],
                'event_id'=>$_POST['event_id'],
                'item_id'=>$item_id
            );
        }else{
            $array = array(
                'than_id'=>$_POST['than_id'],
                'server_id'=>$_POST['server_id'],
                'event_id'=>$_POST['event_id'],
                'item_id'=>$item_id
            );
        }
        
        $action = ($_POST['id']>0)?'edit_serverthan':'add_serverthan';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/uocnguyen/".$action);        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
    public function ajaxsave(){
        $arrParam = $this->CI->security->xss_clean($_REQUEST);
        $f = array(
            'status' => 0,
            'messg' => 'Thành công',
        );
        if($arrParam['than_id']>0 && $arrParam['server_id']>0){
            $lnkCheck = $this->url_service.'/cms/uocnguyen/ajaxsave?than_id='.$arrParam['than_id'].'&server_id='.$arrParam['server_id'];
            $j_Check = file_get_contents($lnkCheck);
            $countData = count(json_decode($j_Check,true));
            $f = array(
                'show' =>$countData
            );
        }else{
            $f = array(
                'status' => 0,
                'messg' => 'Lỗi dữ liệu',
            );
        }
        echo json_encode($f);
        exit();
    }
    public function excel_history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if($_GET['server_id']>0 && !empty($_GET['start']) && !empty($_GET['end'])){
           
            $lnkCountUser = $this->url_service.'/cms/uocnguyen/count_by_user?server_id='.$_GET['server_id'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
            $j_CountUser = file_get_contents($lnkCountUser);
            $arrUser = json_decode($j_CountUser,true);
            
           
            $lnkCountFree = $this->url_service.'/cms/uocnguyen/count_by_free?server_id='.$_GET['server_id'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
            $j_CountFree = file_get_contents($lnkCountFree);
            $arrFree = json_decode($j_CountFree,true);
            
            $lnkCountNoFree = $this->url_service.'/cms/uocnguyen/count_by_nofree?server_id='.$_GET['server_id'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
            $j_CountNoFree = file_get_contents($lnkCountNoFree);
            $arrNoFree = json_decode($j_CountNoFree,true);
             
            if(count($arrUser)>0){
                foreach($arrUser as $k=> $user){
                    $arrResult[$user['created_date']] = $user;
                    if(count($arrFree)>0){
                        $arrResult[$user['created_date']]['count_free'] = $arrFree[$user['created_date']]['count_free'];
                    }
                    if(count($arrNoFree)>0){
                        $arrResult[$user['created_date']]['count_nofree'] = $arrNoFree[$user['created_date']]['count_nofree'];
                    }
                }
            }
            header('Content-type: application/excel');
            $filename = 'lich_su_uoc_nguyen.xls';
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
                        <th align="center">STT</th>
                        <th align="center">Ngày</th>
                        <th align="center">Số lượng user tham gia</th>
                        <th align="center">Số lần Ước Free</th>
                        <th align="center">Số lần Ước trả phí</th>
                    </tr>';
            if(count($arrResult)>0){
                $i=0;
                foreach($arrResult as $v){
                    $i++;
                    $create_date = date_format(date_create($v['created_date']),"d-m-Y");
                    $count_user = ($v['count_user']>0)?number_format($v['count_user'],0,',','.'):'0';
                    $count_free = ($v['count_free']>0)?number_format($v['count_free'],0,',','.'):0;
                    $count_nofree = ($v['count_nofree']>0)?number_format($v['count_nofree'],0,',','.'):0;
                    $data .= '<tr>
                        <td align="center">'.$i.'</td>
                        <td align="center">'.$create_date.'</td>
                        <td align="center">'.$count_user.'</td>
                        <td align="center">'.$count_free.'</td>
                        <td align="center">'.$count_nofree.'</td>
                    </tr>';
                }
            }
            $data .= '</table>
            </body>
            </html>';
            echo $data;
            die();
        }else{
            $start = strtotime($_GET['start']);
            $end = strtotime($_GET['end']);
            $lnkCountUser = $this->url_service.'/cms/uocnguyen/date_count_by_user?start='.$start.'&end='.$end;
            $j_CountUser = file_get_contents($lnkCountUser);
            $arrUser = json_decode($j_CountUser,true);
           
            $lnkCountFree = $this->url_service.'/cms/uocnguyen/date_count_by_free?start='.$start.'&end='.$end;
            $j_CountFree = file_get_contents($lnkCountFree);
            $arrFree = json_decode($j_CountFree,true);
            
            $lnkCountNoFree = $this->url_service.'/cms/uocnguyen/date_count_by_nofree?start='.$start.'&end='.$end;
            $j_CountNoFree = file_get_contents($lnkCountNoFree);
            $arrNoFree = json_decode($j_CountNoFree,true);
            if(count($arrUser)>0){
                foreach($arrUser as $k=> $user){
                    $arrResult[$user['server_id']] = $user;
                    if(is_array($arrFree[$user['server_id']])){
                        $arrResult[$user['server_id']]['count_free'] = $arrFree[$user['server_id']]['count_free'];
                    }
                    if(is_array($arrNoFree[$user['server_id']])){
                        $arrResult[$user['server_id']]['count_nofree'] = $arrNoFree[$user['server_id']]['count_nofree'];
                    }
                }
            }
            header('Content-type: application/excel');
            $filename = 'lich_su_uoc_nguyen.xls';
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
                        <th align="center">STT</th>
                        <th align="center">Server</th>
                        <th align="center">Tổng số lượng user tham gia</th>
                        <th align="center">Tổng số lần Ước Free</th>
                        <th align="center">Tổng số lần Ước trả phí</th>
                    </tr>';
            if(count($arrResult)>0){
                $i=0;
                foreach($arrResult as $v){
                    $i++;
                    
                    $count_user = ($v['count_user']>0)?number_format($v['count_user'],0,',','.'):'0';
                    $count_free = ($v['count_free']>0)?number_format($v['count_free'],0,',','.'):0;
                    $count_nofree = ($v['count_nofree']>0)?number_format($v['count_nofree'],0,',','.'):0;
                    $data .= '<tr>
                        <td align="center">'.$i.'</td>
                        <td align="center">'.$v['server_id'].'</td>
                        <td align="center">'.$count_user.'</td>
                        <td align="center">'.$count_free.'</td>
                        <td align="center">'.$count_nofree.'</td>
                    </tr>';
                }
            }
            $data .= '</table>
            </body>
            </html>';
            echo $data;
            die();
            
        }
    }
    public function excel_user(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $lnkUser = $this->url_service.'/cms/uocnguyen/excel_user?server_id='.$_GET['server_id'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        $j_User = file_get_contents($lnkUser);
        $listItems = json_decode($j_User,true);
        header('Content-type: application/excel');
        $filename = 'user_uoc_nguyen.xls';
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
                    <th align="center">STT</th>
                    <th align="center">Server ID</th>
                    <th align="center">Username</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Money</th>
                    <th align="center">Turn Free Total</th>
                    <th align="center">Turn Free Used</th>
                    <th align="center">Turn Buy Total</th>
                    <th align="center">Turn Buy Used</th>
					<th align="center">Ngày tạo</th>
                </tr>';
        if(count($listItems)>0){
            $i=0;
            foreach($listItems as $v){
                $i++;
				$date=date_create($v['created_date']);
                $create_date = date_format($date,"d-m-Y G:i:s");
                $money = ($v['money']>0)?number_format($v['money'],0,',','.'):'0';
                $turn_free_total = ($v['turn_free_total']>0)?number_format($v['turn_free_total'],0,',','.'):0;
                $turn_free_used = ($v['turn_free_used']>0)?number_format($v['turn_free_used'],0,',','.'):0;
                $turn_buy_total = ($v['turn_buy_total']>0)?number_format($v['turn_buy_total'],0,',','.'):0;
                $turn_buy_used = ($v['turn_buy_used']>0)?number_format($v['turn_buy_used'],0,',','.'):0;
                $data .= '<tr>
                    <td align="center">'.$i.'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['username'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$money.'</td>
                    <td align="center">'.$turn_free_total.'</td>
                    <td align="center">'.$turn_free_used.'</td>
                    <td align="center">'.$turn_buy_total.'</td>
                    <td align="center">'.$turn_buy_used.'</td>
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
	public function history_item(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $this->data['slbServer'] = $this->CI->ServerModel->slbServerByGame('koa');
        $this->CI->template->write_view('content', 'game/koa/Events/uocnguyen/history_item', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel_history_item(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $lnkListItem = $this->url_service.'/cms/uocnguyen/excel_item?server_id='.$_GET['server_id'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        $j_listItem = file_get_contents($lnkListItem);
        $listItem = json_decode($j_listItem,true);
        header('Content-type: application/excel');
        $filename = 'uocnguyen_item.xls';
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
                    <th align="center">Username</th>
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Server</th>
                    <th align="center">Event</th>
                    <th align="center">Thần</th>
                    <th align="center">Item</th>
                    <th align="center">Type</th>
                    <th align="center">Create date</th>
                    
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $type = $v['type']==1?'Có phí':'Miễn phí';
                $create_date = date_format(date_create($v['created_date']),"d-m-Y G:i:s");
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['mobo_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
                    <td align="center">'.$v['than_name'].'</td>
                    <td align="center">'.$v['item_id'].'</td>
                    <td align="center">'.$type.'</td>
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
    public function curlPost($params,$post,$link=''){
        $arrParam = array_merge($params,$post);
        $this->last_link_request = empty($link)?$this->url_service."/cms/uocnguyen/save_image":$link;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($arrParam));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrParam);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        if($result){
            $result = json_decode($result,true);
            if($result['code']==0){
                $result = $result['data'];
            }
        }
        return $result;
    }
    function data_uri($file, $mime='image/jpeg'){
        if(empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    public function curlPostAPI($params,$link=''){
        $this->last_link_request = empty($link)?$this->url_service."/cms/uocnguyen/save_image":$link;	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);        
        return $result;
    }
}