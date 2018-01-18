<?php
class MeAPI_Controller_WpChannelController{
    protected $_response;
    private $CI;
    private $_mainAction;
	private $limit;
	
	
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->MeAPI_Library('TOTP');
		$this->CI->load->MeAPI_Library('Curl');
		$this->CI->load->MeAPI_Library("Graph_Inside_API");
		$this->CI->load->MeAPI_Library('Network');
		$this->CI->load->MeAPI_Model('SignapkModel');
		$this->CI->load->MeAPI_Model('SignHistoryAppModel');
		$this->CI->load->MeAPI_Validate('SignApkHistoryAppValidate');
		$this->CI->load->MeAPI_Model('SignConfigAppModel');
		$this->CI->load->MeAPI_Model('MestoreVersionModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
		if($session['id_group']!=1){
			$this->_mainAction = base_url().'?control='.$_GET['control'].'&func=noaccess';
		}
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
	
		
		$this->data['loadgame']=$this->CI->SignapkModel->listGame();
		$this->data['loadplatform']=$this->CI->SignapkModel->listPlatform();
		$this->data['loadstatus']=$this->CI->SignapkModel->listStatus();
		$this->data['slbTable'] = $this->CI->SignapkModel->listTableApp();
		
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'wpchannel/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$this->CI->load->library('form_validation');
        $this->data['title'] = 'Thông tin channel trong WindowPhone';
        $this->data['slbUser'] = $this->CI->SignapkModel->listUser();
		$this->data['slbGame'] = $this->CI->SignHistoryAppModel->listGame();
        $this->data['slbTable'] = $this->CI->SignHistoryAppModel->listTableApp();
		$this->data['slbSdk'] = $this->CI->SignapkModel->listSdk();
		
        $this->CI->template->write_view('content', 'wpchannel/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function showmsv(){
        if(isset($_GET['id_game'])){
            $data['slbMsv'] = $this->CI->SignapkModel->listMsvWp($_GET['id_game'],$_GET['type_app'],$_GET['package_identity'],$_GET['cert_id']);
            $data['service_id']=$_GET['id_game'];
			$f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('wpchannel/showmsv', $data, true)
            );
        }else{
            $data['slbMsv'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('wpchannel/showmsv', $data, true)
            );
        }
		
        echo json_encode($f);
        exit();
    }
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
           // $this->CI->Session->unset_session('msv_id', $arrParam['code']);
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('cbo_game', $arrParam['cbo_game']);
			$this->CI->Session->unset_session('cbo_app', $arrParam['cbo_app']);
        }
    }
	 public function getpackageidentity(){
        if(isset($_GET['id_game'])){
			$data['info']=$this->CI->MestoreVersionModel->listGamePlus($_GET['id_game']);
			$idgame=$data['info']['id'];
			$arrFilter = array(
                'id_game' =>$idgame,
				'platform' => $_GET['platform'],
				'cert_id' => $_GET['cert_id']
            );
            $data['list'] = $this->CI->SignConfigAppModel->listItemForMsv($arrFilter);
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('wpchannel/cbo_bunlderid', $data, true)
            );
        }else{
            $data['list'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('wpchannel/cbo_bunlderid', $data, true)
            );
        }
		/*$this->CI->template->write_view('content', 'mestoreversion/cbo_bunlderid', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/
       echo json_encode($f);
        exit();
    }
    public function getResponse() {
        return $this->_response;
    }
}
