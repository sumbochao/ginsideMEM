<?php
class MeAPI_Controller_LVL_Events_ConsomaymanController implements MeAPI_Controller_LVL_Events_ConsomaymanInterface {
    protected $_response;
    private $CI;
    private $url_service;
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    
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
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.volam.mobo.vn/volam/index.php';
        }else{
            $this->url_service = 'http://game.mobo.vn/volam';
        }
        $this->data['url_service'] = $this->url_service;
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'config':
                $this->data['title']= 'DANH SÁCH CẤU HÌNH';
            break;
            case 'lottery':
                $this->data['title']= 'DANH SÁCH CON SỐ';
            break;
            case 'point':
                $this->data['title']= 'DANH SÁCH ĐIỂM';
            break;
            case 'history':
                $this->data['title']= 'LỊCH SỬ';
            break;
            case 'history_point':
                $this->data['title']= 'LỊCH SỬ NHẬN QUÀ';
            break;
            case 'item':
                $this->data['title']= 'DANH SÁCH QUÀ';
            break;
        }
        $this->CI->template->write_view('content', 'game/lvl/Events/consomayman/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'config':
                $this->data['title']= 'THÊM CẤU HÌNH';
            break;
            case 'lottery':
                $this->data['title']= 'THÊM CON SỐ';
            break;
            case 'point':
                $this->data['title']= 'THÊM ĐIỂM';
            break;
            case 'item':
                $this->data['title']= 'THÊM QUÀ';
            break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lvl/Events/consomayman/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'config':
                $this->data['title']= 'SỬA CẤU HÌNH';
            break;
            case 'lottery':
                $this->data['title']= 'SỬA CON SỐ';
            break;
            case 'point':
                $this->data['title']= 'SỬA ĐIỂM';
            break;
            case 'item':
                $this->data['title']= 'SỬA QUÀ';
            break;
        }
        $linkinfo = $this->url_service.'/cms/consomayman/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/lvl/Events/consomayman/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/consomayman/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function add_item(MeAPI_RequestInterface $request){
        $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png";
        
        if(isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])){
            if($_FILES['gift_img']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }
            else{                
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn". $this->curlPost($_FILES['gift_img']);                  
                if(empty($gift_img)){
                    $gift_img = "http://ginside.mobo.vn/assets/img/no-image.png";
                }
            }
        }
        
        $array = array(
            'item_id'=>$_POST["item_id"],
            'name'=>$_POST["name"],
            'images'=>$gift_img,
            'count'=>$_POST["count"],                                       
            'point'=>$_POST["point"]);
        $result = $this->curlPostAPI($array, $this->url_service."/cms/consomayman/add_item");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
    public function edit_item(MeAPI_RequestInterface $request){
        $gift_img = $_POST["gift_img_text"];
        
        if(isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])){
            if($_FILES['gift_img']['size'] > 716800){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh quà không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }
            else{                
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $gift_img = "http://m-app.mobo.vn". $this->curlPost($_FILES['gift_img']);                  
                if(empty($gift_img)){
                    $gift_img = $_POST["gift_img_text"];
                }
            }
        }
        $array = array(
            'id'=>$_POST["id"],
            'item_id'=>$_POST["item_id"],
            'name'=>$_POST["name"],
            'images'=>$gift_img,
            'count'=>$_POST["count"],                                       
            'point'=>$_POST["point"]
        );
        $result = $this->curlPostAPI($array, $this->url_service."/cms/consomayman/edit_item");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
    function data_uri($file, $mime='image/jpeg'){
        if(empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    public function curlPost($params,$link=''){      
        $this->last_link_request = empty($link)?$this->api_m_app."returnpathimg":$link;
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
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
    
    public function curlPostAPI($params,$link=''){
        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
        $this->last_link_request = empty($link)?$this->api_m_app."returnpathimg":$link;
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);        
        return $result;
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/consomayman/excel?start='.$_GET['start'].'&end='.$_GET['end'];
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'con_so_may_man.xls';
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
                    <th align="center">Giải</th>
                    <th align="center">Số</th>
                    <th align="center">Đặt cược</th>
                    <th align="center">Ngày tạo</th>
                    <th align="center">Trạng thái</th>
                    <th align="center">Kết quả</th>
                    <th align="center">Cập nhật</th>
                    <th align="center">Điểm thưởng</th>
                    <th align="center">Ngày nhận thưởng</th>
                    
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $createdDate = date_format(date_create($v['createdDate']),"d-m-Y");
                $updatedDate = date_format(date_create($v['updatedDate']),"d-m-Y H:i:s");
                $nhanthuong = date_format(date_create($v['nhanthuong']),"d-m-Y H:i:s");
                switch ($v['look_up']){
                    case '0':
                        $look_up = 'Chờ kết quả';
                        break;
                    case '1':
                        $look_up = 'Có kết quả';
                        break;
                }
                switch ($v['giai']){
                    case 'dacbiet':
                        $giai = 'Đặc biệt';
                        break;
                    case 'tatca':
                        $giai = 'Tất cả';
                        break;
                }
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">"'.$v['character_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$giai.'</td>
                    <td align="center">'.$v['so'].'</td>
                    <td align="center">'.$v['datcuoc'].'</td>
                    <td align="center">'.$createdDate.'</td>
                    <td align="center">'.$look_up.'</td>
                    <td align="center">'.$v['result'].'</td>
                    <td align="center">'.$updatedDate.'</td>
                    <td align="center">'.$v['diemthuong'].'</td>
                    <td align="center">'.$nhanthuong.'</td>
                </tr>';
            }
        }
        $data .= '</table>
        </body>
        </html>';
        echo $data;
        die();
    }
    public function excel_point(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/consomayman/excel_point?start='.$_GET['start'].'&end='.$_GET['end'];
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'con_so_may_man_excel_point.xls';
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
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Item ID</th>
                    <th align="center">Item Name</th>
                    <th align="center">Số lượng</th>
                    <th align="center">Giá</th>
                    <th align="center">Điểm user</th>
                    <th align="center">Ngày tạo</th>
                    <th align="center">Trạng thái</th>
                    
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $createdDate = date_format(date_create($v['date']),"d-m-Y H:i:s");
                if(!empty($v['result'])){
                    $j_result = json_decode(json_decode($v['result'],true),true);
                    if($j_result['code']=='0'){
                        $status = 'Thành công';
                    }else{
                        $status = 'Thất bại';
                    }
                }
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">"'.$v['char_id'].'</td>
                    <td align="center">'.$v['char_name'].'</td>
                    <td align="center">"'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['item_id'].'</td>
                    <td align="center">'.$v['name'].'</td>
                    <td align="center">'.$v['count'].'</td>
                    <td align="center">'.$v['point'].'</td>
                    <td align="center">'.$v['amount'].'</td>
                    <td align="center">'.$createdDate.'</td>
                    <td align="center">'.$status.'</td>
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