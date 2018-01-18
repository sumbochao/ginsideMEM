<?php

class MeAPI_Controller_PT_Events_LoginController implements MeAPI_Controller_PT_Events_LoginInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    //private $url_process = "http://game.mobo.vn/hiepkhach/cms/tichluy/";
    private $url_process = "http://local.service.phongthan.mobo.vn/cms/qualogin/";
    private $url_link = "http://game.mobo.vn/bog";
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
        }
        $this->CI->template->write_view('content', 'game/pt/Events/qualogin/'.$layout.'/index', $this->data);
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
        }
        $this->CI->template->write_view('content', 'game/pt/Events/qualogin/'.$layout.'/add', $this->data);
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
        }
        $ids =$request->input_get('ids');
        $linkinfo = $this->url_link.'/cms/qualogin/delete_'.$layout.'?ids='.$ids;
        $infoDetail = file_get_contents($linkinfo);
        $datainfojson = json_decode($infoDetail,true);
        header('location: /?control=qualogin&func=index&view='.$layout);
    }
	function deleteconfig(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $ids = $request->input_get('ids');
        $linkinfo = $this->url_link.'/cms/qualogin/delete_config?ids='.$ids;
		
        $infoDetail = file_get_contents($linkinfo);
        $datainfojson = json_decode($infoDetail,true);
        header('location: /?control=qualogin&func=edit&view=wheel&ids='.$request->input_get('wheel') );
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
        }
        $ids =$request->input_get('ids');
        $linkinfo = $this->url_link.'/cms/qualogin/getitem_'.$layout.'?ids='.$ids;
        $infoDetail = file_get_contents($linkinfo);
        $datainfojson = json_decode($infoDetail,true);

        $linkinfo = $this->url_link.'/cms/qualogin/index_item';
        $SlbitemDetail = file_get_contents($linkinfo);
        $dataSlbitemJson = json_decode($SlbitemDetail,true);

        $this->data['slbItem'] = $dataSlbitemJson['rows'];;
        $this->data['infodetail'] = $datainfojson;
        $this->CI->template->write_view('content', 'game/pt/Events/qualogin/'.$layout.'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function clearcached(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/pt/Events/qualogin/clearcached', $this->data);
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
}
