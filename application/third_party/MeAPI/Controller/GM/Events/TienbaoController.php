<?php
class MeAPI_Controller_GM_Events_TienbaoController implements MeAPI_Controller_GM_Events_TienbaoInterface {
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
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.giangma.mobo.vn';
        }else{
            $this->url_service = 'http://game.mobo.vn/giangma';
        }
        $this->url_picture = $this->url_service.'/assets/tienbao';
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
        }
        $this->data['url_service'] = $this->url_service;
        $this->data['url_picture'] = $this->url_picture;
        $this->CI->template->write_view('content', 'game/gm/Events/tienbao/'.$_GET['view'].'/index', $this->data);
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
        }
        $this->data['url_service'] = $this->url_service;
        $this->data['url_picture'] = $this->url_picture;
        $this->CI->template->write_view('content', 'game/gm/Events/tienbao/'.$_GET['view'].'/add', $this->data);
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
        }
        $linkinfo = $this->url_service.'/cms/tienbao/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->data['url_picture'] = $this->url_picture;
        $this->CI->template->write_view('content', 'game/gm/Events/tienbao/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/tienbao/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module='.$_GET['module']); 
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/gm/Events/tienbao/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        if(!empty($_GET['start']) && !empty($_GET['end'])){ 
            $lnkHistory = $this->url_service.'/cms/tienbao/excel?type='.$_GET['type'].'&start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        }
        $j_history = file_get_contents($lnkHistory);
        $listItem = json_decode($j_history,true);
        header('Content-type: application/excel');
        $filename = 'lich_su_tienbao.xls';
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
                    <th align="center">Type</th>
                    <th align="center">Item Name</th>
                    <th align="center">Quantity</th>
                    <th align="center">Money</th>
                    <th align="center">Total</th>
                    <th align="center">Level vip</th>
                    <th align="center">Order Buy</th>
                    <th align="center">Create date</th>
                    <th align="center">Result</th>
                </tr>';
        if(count($listItem)>0){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['created_date']),"d-m-Y G:i:s");
                $money = ($v['money']>0)?number_format($v['money'],0):'0';
                if($v['quantity']>0){
                    $amount = $v['money']*$v['quantity'];
                }else{
                    $amount = $v['money'];
                }
                $total = ($amount>0)?number_format($amount,0):'0';
                switch ($v['type']){
                    case '1':
                        $type = 'Thẻ tướng';
                        break;
                    case '2':
                        $type = 'Item Khác';
                        break;
                    case '3':
                        $type = 'Item VIP';
                        break;
                    case '4':
                        $type = 'Item Kỳ Ngộ';
                        break;
                }
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['moboid'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'."'".$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <th align="center">'.$type.'</th>
                    <th align="center">'.$v['item_name'].'</th>
                    <th align="center">'.$v['quantity'].'</th>
                    <th align="center">'.$money.'</th>
                    <th align="center">'.$total.'</th>
                    <th align="center">'.$v['vipLv'].'</th>
                    <th align="center">'.$v['order'].'</th>
                    <td align="center">'.$create_date.'</td>
                    <td align="center">'.$v['result'].'</td>
                </tr>';
            }
        }
        $data .= '</table>
        </body>
        </html>';
        echo $data;
        die();
    }
    public function post_item(MeAPI_RequestInterface $request){
        $item = NULL;
        if(count($_POST['item_id'])>0){
            $arrItem = array();
            foreach($_POST['item_id'] as $k=>$v){
                $arrItem[$k]['item_id'] = $v;
                $arrItem[$k]['count'] = $_POST['item_count'][$k];
                $arrItem[$k]['type'] = $_POST['item_type'][$k];
            }
            $item  =  json_encode($arrItem);
        }
        if(isset($_FILES['picture']['tmp_name']) && !empty($_FILES['picture']['tmp_name'])){
            if($_FILES['picture']['size'] > 1048576){
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700MB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            }else{
                $_FILES['picture']['encodefile'] = $this->data_uri($_FILES['picture']['tmp_name'], $_FILES['picture']['type']);
                $arrPOST = array('id'=>$_POST['id'],'current_picture'=>$_POST['current_picture']);
                $picture = $this->curlPost($_FILES['picture'],$arrPOST);
            }
        }else{
            if($_POST['id']>0){
                $picture = $_POST['current_picture'];
            }
        }
        if($_POST['id']>0){
            $array = array(
                'id'=>$_POST['id'],
                'name'=>$_POST['name'],
                'picture'=>$picture,
                'item'=>$item,
                'server_id'=>$_POST['server_id'],
                'money'=>  str_replace('.', '', $_POST['money']),
                'quantity'=>$_POST['quantity'],
                'type'=>$_POST['type'],
                'status'=>$_POST['status'],
                'start'=>date_format(date_create($_POST['start']),"Y-m-d G:i:s"),
                'end'=>date_format(date_create($_POST['end']),"Y-m-d G:i:s"),
                'levelvip'=>$_POST['levelvip'],
                'order'=>$_POST['order'],
            );
        }else{
            $array = array(
                'name'=>$_POST['name'],
                'picture'=>$picture,
                'item'=>$item,
                'server_id'=>$_POST['server_id'],
                'money'=>  str_replace('.', '', $_POST['money']),
                'quantity'=>$_POST['quantity'],
                'type'=>$_POST['type'],
                'status'=>$_POST['status'],
                'start'=>date_format(date_create($_POST['start']),"Y-m-d G:i:s"),
                'end'=>date_format(date_create($_POST['end']),"Y-m-d G:i:s"),
                'levelvip'=>$_POST['levelvip'],
                'order'=>$_POST['order'],
            );
        }
        
        $action = ($_POST['id']>0)?'edit_item':'add_item';
        $result = $this->curlPostAPI($array, $this->url_service."/cms/tienbao/".$action);        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
    }
    public function getResponse() {
        return $this->_response;
    }
    public function curlPost($params,$post,$link=''){
        $arrParam = array_merge($params,$post);
        $this->last_link_request = empty($link)?$this->url_service."/cms/tienbao/save_image":$link;
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
        $this->last_link_request = empty($link)?$this->url_service."/cms/tienbao/save_image":$link;	
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