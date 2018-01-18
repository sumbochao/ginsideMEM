<?php
class MeAPI_Controller_SHOPITEMS_GroupController{
	
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
		$this->CI->load->MeAPI_Model('SHOPITEMS/GroupModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
		
		$this->data['loadgame']=$this->CI->GroupModel->listGame();
	    $str=json_encode($this->data['loadgame']);
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'group/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Tạo nhóm';
		$arr_p=$this->CI->security->xss_clean($_GET);
		//add new
		if(isset($_GET['action']) && $_GET['action']=="add"){
			if($this->addnew()){
				redirect($this->_mainAction);
			}else{
				$this->data['Mess']="Nhóm này đã tồn tại";
			}
		}
		 $arrFilter = array(
            'group_name' => ""
         );
		$this->data['listItems'] = $this->CI->GroupModel->listItem($arrFilter);
        $this->CI->template->write_view('content', 'toolsgame/group/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function addnew(){
		$arr_p=$this->CI->security->xss_clean($_POST);
		$arrParam = array(
			'group_name'=>$arr_p['group_name'],
			'type'=>$arr_p['chk_type'],
			'datecreate'=>date('Y-m-d H:i:s'),
			'user_log'=>$_SESSION['account']['id']
		);
		$bool=$this->CI->GroupModel->checkgroupexist($arr_p['group_name']);
		if(!$bool){
			$this->CI->GroupModel->add_new($arrParam);
			return true;
		}else{
			return false;
		}
	}
	
    public function getResponse() {
        return $this->_response;
    }
}
