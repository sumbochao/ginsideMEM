    <?php
class MeAPI_Controller_HKGH_Events_TraiNghiemAlphaController implements MeAPI_Controller_HKGH_Events_TraiNghiemAlphaInterface {
    protected $_response;
    private $CI;
    private $url_service;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->MeAPI_Library('Excel');
        $this->CI->load->MeAPI_Model('Service/HKGH/TraiNghiemAlphaModel');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.thichkhach.mobo.vn/hiepkhach/index.php';
        }else{
            $this->url_service = 'http://game.mobo.vn/hiepkhach';
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
                $this->data['title']= 'DANH SÁCH USER';
            break;
        }
        $this->CI->template->write_view('content', 'game/hkgh/Events/trainghiemalpha/'.$_GET['view'].'/index', $this->data);
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
                $this->data['title']= 'THÊM USER';
            break;
        }
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/hkgh/Events/trainghiemalpha/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'event':
                $this->data['title']= 'SỬA SỰ KIỆN';
                break;
            case 'filters':
                $this->data['title']= 'SỬA QUÀ';
                break;
        }
        $linkinfo = $this->url_service.'/cms/trainghiemalpha/get_'.$_GET['view'].'?id='.$id;
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/hkgh/Events/trainghiemalpha/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function import(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        if ($this->CI->input->post()){
            $file = explode('.', $_FILES['file']['name']);
            if(!in_array($file[1],array('xls'))){
                $this->data['error'] = 'Vui lòng nhập file xls';
            }else{
                move_uploaded_file($_FILES["file"]["tmp_name"], 'service/user.xls');
                $filename = FILE_SERVICE_PATH.'/user.xls';
                $excel = new Excel($filename,true,"UTF-8");
                $rowsnum = $excel->rowcount($sheet_index=0);
                $colsnum =  $excel->colcount($sheet_index=0);
                $data_excel = array();
                for ($i=2;$i<=$rowsnum;$i++){
                    $data_excel[] = array('msi'=>$excel->val($i,1),'lvl'=>$excel->val($i,2));
                }
                $this->CI->TraiNghiemAlphaModel->saveItem($data_excel);
                $this->data['success'] = 'Import thành công';
            }
        }
        $this->CI->template->write_view('content', 'game/hkgh/Events/trainghiemalpha/'.$_GET['view'].'/import', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
        $linkInfo = $this->url_service.'/cms/trainghiemalpha/delete_'.$_GET['view'].'?id='.$id;
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module=all'); 
    }
    public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'LỊCH SỬ';
        $this->data['url_service'] = $this->url_service;
        $this->CI->template->write_view('content', 'game/hkgh/Events/trainghiemalpha/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_service.'/cms/trainghiemalpha/excel?start='.$_GET['start'].'&end='.$_GET['end'];
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'qua_alpha.xls';
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
                    <th align="center">Server</th>
                    <th align="center">Sự kiện</th>
                    <th align="center">Ngày tạo</th>
                    <th align="center">Result</th>
                    
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $create_date = date_format(date_create($v['create_date']),"d-m-Y H:i:s");
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['moboid'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">"'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['event_name'].'</td>
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
    
    
    public function getResponse() {
        return $this->_response;
    }
}