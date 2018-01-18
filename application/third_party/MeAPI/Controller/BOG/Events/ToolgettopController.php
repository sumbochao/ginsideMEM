<?php

class MeAPI_Controller_BOG_Events_ToolgettopController implements MeAPI_Controller_BOG_Events_ToolgettopInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
	private $listtooltop = array("toplv"=>"Top Level","topguild"=>"Top Guild",
	"qua"=>'Top đấu trường cá nhân',
	"quatoploidaicanhan"=>'Top lôi đài cá nhân',
	"quatopdautruonglienthang"=>"Top đấu trường liên thắng",
	"quatoploidailienthang"=>"Top lôi đài liên thắng",
	"quatopchienluchothan"=>"Top chiến lực hộ thần",
	"quatopchienlucnguoichoi"=>"Top chiến lực người chơi",
	"quatopdautruongruclua"=>"Top đấu trường rực lửa");
	
	protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $url_link = "http://game.mobo.vn/bog";
    //public $url_link = "http://local.service.phongthan.mobo.vn";
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
        $this->data['url'] = $this->url_link;
		$this->data['listtop'] = $this->listtooltop;

    }
    
    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($request->input_get('view')){
            case 'item':
                $layout = 'item';
                break;
            case 'wheel':
                $layout = 'wheel';
                break;
            case 'filter':
                $layout = 'filter';
                break;
        }
        $this->CI->template->write_view('content', 'game/bog/Events/toolgettop/'.$layout.'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($request->input_get('view')){
            case 'item':
                $layout = 'item';
                break;
            case 'wheel':
                $layout = 'wheel';
                break;
            case 'filter':
                $layout = 'filter';
                break;
        }
        $this->CI->template->write_view('content', 'game/bog/Events/toolgettop/'.$layout.'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	function delete(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        switch ($request->input_get('view')){
            case 'item':
                $layout = 'item';
                break;
            case 'wheel':
                $layout = 'wheel';
                break;
            case 'filter':
                $layout = 'filter';
                break;
        }
        $ids =$request->input_get('ids');
        //$linkinfo = $this->url_link.'/cms/toolgettop/delete_'.$layout.'?ids='.$ids;
        //$infoDetail = file_get_contents($linkinfo);
        //$datainfojson = json_decode($infoDetail,true);
        header('location: /?control=toolgettop&func=index&view='.$layout);
    }
	function deleteconfig(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $ids = $request->input_get('ids');
        $linkinfo = $this->url_link.'/cms/toolgettop/delete_config?ids='.$ids;
		
        $infoDetail = file_get_contents($linkinfo);
        $datainfojson = json_decode($infoDetail,true);
        header('location: /?control=toolgettop&func=edit&view=wheel&ids='.$request->input_get('wheel') );
    }
	
    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($request->input_get('view')){
            case 'item':
                $layout = 'item';
                break;
            case 'wheel':
                $layout = 'wheel';
                break;
            case 'filter':
                $layout = 'filter';
                break;
        }
        $ids =$request->input_get('ids');
        $linkinfo = $this->url_link.'/cms/toolgettop/getitem_'.$layout.'?ids='.$ids;
        $infoDetail = file_get_contents($linkinfo);
        $datainfojson = json_decode($infoDetail,true);

        $linkinfo = $this->url_link.'/cms/toolgettop/index_item';
        $SlbitemDetail = file_get_contents($linkinfo);
        $dataSlbitemJson = json_decode($SlbitemDetail,true);

        $this->data['slbItem'] = $dataSlbitemJson['rows'];;
        $this->data['infodetail'] = $datainfojson;
        $this->CI->template->write_view('content', 'game/bog/Events/toolgettop/'.$layout.'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function clearcached(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/toolgettop/clearcached', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }    

    
    public function test(MeAPI_RequestInterface $request){
        //if ($this->CI->input->post() && count($this->CI->input->post())>=1) {           
        if(isset($_FILES['picture']['tmp_name']) && !empty($_FILES['picture']['tmp_name'])) {
            if($_FILES['picture']['size'] > 716800){
                $R["result"] = -1;
                $R["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
            }
            else{
                $_FILES['picture']['encodefile'] = $this->data_uri($_FILES['picture']['tmp_name'], $_FILES['picture']['type']);
                $getpath = $this->curlPost($_FILES['picture']);                    
                //$picture = $getpath;
                
                //$R["result"] = -1;
                //$R["message"] = $picture;
            }
        }
        else{
            
        }
        
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($R));
    }




    

    //Function
    public function getResponse() {
        return $this->_response;
    }
    
    function data_uri($file, $mime='image/jpeg')
    {
        if(empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    
    public function curlPost($params,$link=''){
        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
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
	public function history(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/toolgettop/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function excel(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkInfo = $this->url_link.'/cms/toolgettop/excel?start='.strtotime($_GET['start']).'&end='.strtotime($_GET['end']);
        $j_items = file_get_contents($linkInfo);
        $listItem = json_decode($j_items,true);
        
        header('Content-type: application/excel');
        $filename = 'muatuong_sub.xls';
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
                    <th align="center">Mobo Service ID</th>
                    <th align="center">Character Name</th>
                    <th align="center">Server ID</th>
                    <th align="center">Config</th>
                    <th align="center">Money</th>
                    <th align="center">Money Receive</th>
                    <th align="center">Create date</th>
					<th align="center">Result</th>
                </tr>';
        if(count($listItem)){
            foreach($listItem as $v){
                $date=date_create($v['create_date']);
                $create_date = date_format($date,"d-m-Y G:i:s");
                $data .= '<tr>
                    <td align="center">'.$v['id'].'</td>
                    <td align="center">'.$v['character_id'].'</td>
                    <td align="center">'.$v['mobo_service_id'].'</td>
                    <td align="center">'.$v['character_name'].'</td>
                    <td align="center">'.$v['server_id'].'</td>
                    <td align="center">'.$v['config_id'].'</td>
                    <td align="center">'.$v['money'].'</td>
                    <td align="center">'.$v['money_receive'].'</td>
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
}
