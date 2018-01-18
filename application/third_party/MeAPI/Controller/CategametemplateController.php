<?php
class MeAPI_Controller_CategametemplateController{
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
		$this->CI->load->MeAPI_Model('CategoriesGameModel');
		$this->CI->load->MeAPI_Model('GroupuserModel');
		$this->CI->load->MeAPI_Model('GrandRequestUserModel');
		$this->CI->load->MeAPI_Model('TemplateModel');
		$this->CI->load->MeAPI_Model('TemplatechecklistModel');
		$this->CI->load->MeAPI_Model('RequestModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
		$this->data['loadgame']=$this->CI->TemplatechecklistModel->listGame();
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'categametemplate/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý hạng mục';
		$arr_p=$this->CI->security->xss_clean($_GET);
		$this->filter();
        if(isset($_GET['type']) && $_POST['cbo_group']!=""){
			//lọc hạng mục theo nhóm
			$listItems = $this->CI->CategoriesGameModel->listItemSerachOnGroup($arr_p['id_game'],$_POST['cbo_group']);
		}else{
			
			$arrFilter = array(
				'names' => $this->CI->Session->get_session('names'),
				'id_game'=> $arr_p['id_game'],
				'id_template'=> $arr_p['id_template']
			);
			$listItems = $this->CI->CategoriesGameModel->listItem($arrFilter);
		}
        $per_page = 1000;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
		
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=index';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
		$this->data['slbUser'] = $this->CI->CategoriesGameModel->listUser();
		$this->data['slbCategories'] = $this->CI->CategoriesGameModel->getItemId();
		$this->data['Group'] = $this->CI->GroupuserModel->listItem(NULL);
        $this->CI->template->write_view('content', 'categametemplate/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function addnew(){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			"id_game"=>$arr_p['id_game'],
			"id_template"=>$arr_p['id_template'],
			"id_parrent"=>$arr_p['cbo_categories'],
			"names"=>$arr_p['names'],
			"notes"=>addslashes($arr_p['notes']),
			"datecreate"=>date('y-m-d H:i:s'),
			"userlog"=>$_SESSION['account']['id']		
		);
		$arrfilter= array(
			"id_game"=>$arr_p['id_game'],
			"names"=>$arr_p['names']
		);
		$bool=$this->CI->CategoriesGameModel->checknamesexist($arrfilter);
		if(!$bool){
			$idadd = $this->CI->CategoriesGameModel->add_new($arrParam);
			return $idadd;
		}else{
			return false;
		}
	}
	
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Tạo hạng mục';
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($this->CI->input->post()){
			$id=$this->addnew();
			
			if($id!=FALSE){
				$this->data['errors']="<strong style='color:#008000'>Tạo mới thành công</strong>";
			}else{
				$this->data['errors']="Hạng mục này đã tồn tại! Vui lòng nhập tên khác";
			}
		}
		$this->data['parent'] = $this->CI->CategoriesGameModel->listCategorisParentInTemp($arr_p['id_game']);
		//$this->data['parent']=$this->CI->CategoriesGameModel->listCategorisParent();
        $this->CI->template->write_view('content', 'categametemplate/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function editnew(){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			"id_game"=>$arr_p['id_game'],
			"id_template"=>$arr_p['id_template'],
			"id_parrent"=>$arr_p['cbo_categories'],
			"names"=>$arr_p['names'],
			"notes"=>addslashes($arr_p['notes']),
			"datecreate"=>date('y-m-d H:i:s'),
			"userlog"=>$_SESSION['account']['id']	
		);

		$rs = $this->CI->CategoriesGameModel->edit_new($arrParam,$arr_p['id']);
		return $rs;
	}
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật hạng mục';
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($this->CI->input->post()){
			if($this->editnew()){
				$this->data['errors']="<strong style='color:#008000'>Cập nhật thành công</strong>";
				//redirect($this->_mainAction);
			}else{
				$this->data['errors']="Không thực hiện được";
			}
			
		}
		$this->data['parent'] = $this->CI->CategoriesGameModel->listCategorisParentInTemp($arr_p['id_game'],$arr_p['id_template']);
		$this->data['item']=$this->CI->CategoriesGameModel->getItem(intval($_GET['id']));
        $this->CI->template->write_view('content', 'categametemplate/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function addchecklisttemplate(){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			"id_template"=>$arr_p['idtemplate'],
			"id_categories"=>$arr_p['idcategories'],
			"id_request"=>$arr_p['cbo_request'],
			"notes"=>addslashes($arr_p['notes']),
			"datecreate"=>date('y-m-d H:i:s'),
			"userlog"=>$_SESSION['account']['id']		
		);
		$arrfilter= array(
			"id_template"=>$arr_p['idtemplate'],
			"id_categories"=>$arr_p['idcategories'],
			"id_request"=>$arr_p['cbo_request']
		);
		$bool=$this->CI->TemplatechecklistModel->checkexist($arrfilter);
		if(!$bool){
			$idadd = $this->CI->TemplatechecklistModel->add_new($arrParam);
			return $idadd;
		}else{
			return false;
		}
	}
	public function checklist(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Tạo yêu cầu Template';
		if($this->CI->input->post()){
			$id=$this->addchecklisttemplate();
			if($id!=FALSE){
				$this->data['errors']="<strong style='color:#008000'>Tạo thành công</strong>";
			}else{
				$this->data['errors']="Khai báo yêu cầu này đã tồn tại!";
			}
		}
		$arrFilter=array(
			"id_categories"=>intval($_GET['idcategories'])
		);
		$this->data['slbTemp']=$this->CI->TemplateModel->getItemId();
		$this->data['request']=$this->CI->RequestModel->listItem($arrFilter);
		$this->data['item']=$this->CI->CategoriesGameModel->getItem(intval($_GET['idcategories']));
        $this->CI->template->write_view('content', 'categametemplate/checklist', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function ajaxrequest(){
		$arr_p = $this->CI->security->xss_clean($_GET);
		if($arr_p['idrequest'] > 0){
			$arrFill=array(
				'id_request'=>intval($arr_p['idrequest'])
			);
            $data['item']=$this->CI->RequestModel->getItem(intval($arr_p['idrequest']));
			$data['groupActive']=$this->CI->GroupuserModel->listItemInnerJoin($arrFill,0);
			$data['groupActiveSupport']=$this->CI->GroupuserModel->listItemInnerJoinSupport($arrFill,0);
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('categametemplate/ajaxrequest', $data, true)
            );
        }else{
            $data['item'] = array();
			$data['groupActive']=array();
			$data['groupActiveSupport']=array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('categametemplate/ajaxrequest', $data, true)
            );
        }
        echo json_encode($f);
        exit();
	}
	
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('names', $arrParam['keyword']);
        }
    }
	public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->CategoriesGameModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->CategoriesGameModel->deleteItem($arrParam);
        }
        redirect("?control=categametemplate&func=index&id_game=".$arrParam['id_game']);
    }
	public function updatestatus(){
		$arr_p = $this->CI->security->xss_clean($_GET);
		if($arr_p['id'] > 0){
			$arrFill=array(
				'id'=>intval($arr_p['id']),
				'status'=>intval($arr_p['status'])
			);
            $result=$this->CI->CategoriesGameModel->updatestatus($arrFill);
			$data['status']=$this->CI->CategoriesGameModel->getItem(intval($arr_p['id']));
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('categametemplate/status', $data, true)
            );
        }else{
            $data['item'] = array();
			$data['groupActive']=array();
			$data['groupActiveSupport']=array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>'Fail'
            );
        }
        echo json_encode($f);
        exit();
	}
	
	public function updatesort(){
		$arr_p = $this->CI->security->xss_clean($_GET);
		if($arr_p['id'] > 0){
			$arrFill=array(
				'order'=>intval($arr_p['values'])
			);
            $result=$this->CI->CategoriesGameModel->updatesort($arrFill,intval($arr_p['id']));
            $f = array(
                'error'=>'0',
                'messg'=>'success'
            );
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'fail'
            );
        }
        echo json_encode($f);
        exit();
	}
	
	public function showcategories(){
		$arr_p = $this->CI->security->xss_clean($_GET);
        if(isset($arr_p['idgame'])){
            $data['parent'] = $this->CI->CategoriesGameModel->listCategorisParentInTemp($arr_p['idgame']);
			$data['item']=$this->CI->CategoriesGameModel->getItem(intval($arr_p['idedit']));
            $f = array(
                'error'=>'0',
                'messg'=>'OK',
                'html'=>$this->CI->load->view('categametemplate/cbocate', $data, true)
            );
        }else{
            $data['parent'] = array();
			$data['item'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Error',
                'html'=>$this->CI->load->view('categametemplate/cbocate', $data, true)
            );
        }
		
        echo json_encode($f);
        exit();
    }
	
    public function getResponse() {
        return $this->_response;
    }
}
