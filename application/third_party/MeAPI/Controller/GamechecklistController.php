<?php
class MeAPI_Controller_GamechecklistController{
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
		$this->CI->load->MeAPI_Model('CategoriesModel');
		$this->CI->load->MeAPI_Model('GroupuserModel');
		$this->CI->load->MeAPI_Model('GrandRequestUserModel');
		$this->CI->load->MeAPI_Model('CategoriesModel');
		$this->CI->load->MeAPI_Model('TemplateModel');
		$this->CI->load->MeAPI_Model('TemplatechecklistModel');
		$this->CI->load->MeAPI_Model('RequestModel');
		$this->CI->load->MeAPI_Model('GamechecklistModel');
		
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
		$this->data['loadgame']=$this->CI->TemplatechecklistModel->listGame();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
		
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'gamechecklist/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'CHECK LIST';
		
		$this->filter();
      	//add new
		if(isset($_GET['action']) && $_GET['action']=="add"){
			if($this->addnew()){
				$mess="Thành công";
				redirect('?control='.$_GET['control'].'&func=index&mess=');
				//$this->data['Mess']="OK";
			}else{
				redirect('?control='.$_GET['control'].'&func=index&mess=');
				$this->data['Mess']="Template này đã tồn tại";
			}
		}
		
		$this->data['slbUser'] = $this->CI->TemplateModel->listUser(); 
 		$this->data['slbTemp']=$this->CI->TemplateModel->getItemId();
		$this->data['slbCategories']=$this->CI->CategoriesModel->getItemId();
		$this->data['slbRequest']=$this->CI->RequestModel->getItemId();
		$this->data['slbGroup']=$this->CI->GroupuserModel->getItemId();
		
		// load Hạng mục
		$arrFilterC = array(
			'id_template' => intval($_GET['id_template'])
        );
		$this->data['listCategories'] = $this->CI->CategoriesModel->listItem($arrFilterC);
		$this->data['categories']=$this->CI->CategoriesModel->listItem($arrFilterC);
		//load game checklist
		$arrFilterG = array(
			'id_template' => intval($_GET['id_template']),
			'id_game' => intval($_GET['id_game']),
			'id_group'=> '0'
        );
		
		/*$this->record['data']=$this->CI->GroupuserModel->ReturnGroup($_SESSION['account']['id']);
		foreach($this->record['data'] as $val){
			$r.=$val['id_group'].",";
		}
		$d=explode(',',$r);
		unset($d[count($d)-1]);
		$typeu="admin";
		if($_SESSION['account']['id']!=56){
			// id 56 là full admin
			if(count($this->record['data'])>0){
				$typeu="user";
				$arrFilterG['id_group']=implode(',',$d);
			}
		}*/
		
		$this->data['listGameChecklist'] = $this->CI->GamechecklistModel->listItem($arrFilterG,$typeu);
		//$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'gamechecklist/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function resultchecklist(MeAPI_RequestInterface $request){
		 $this->authorize->validateAuthorizeRequest($request, 0);
		 $arrGet = $this->CI->security->xss_clean($_GET);
		 $arrPost = $this->CI->security->xss_clean($_POST);
		 //load game checklist
			$arrFilterG = array(
				'id_template' => intval($_GET['id_template']),
				'id_game' => intval($_GET['id_game'])
			);
		   $data['obj'] = $this->CI->GamechecklistModel->listItem($arrFilterG);
		   if(count($data['obj'])>0){
			   //xoa du lieu cu tren bang result
			   $this->CI->GamechecklistModel->delresultold($arrFilterG);
			   foreach($data['obj'] as $v){
				   $arrP = array(
					'id_template' => $arrGet['id_template'],
					'id_game' => $arrGet['id_game'],
					'id_categories' => $v['id_categories'],
					'id_request' => $v['id_request'],
					'android' => $arrPost['cbo_result_clients_android_'.$v['id_request']],
					'ios' => $arrPost['cbo_result_clients_ios_'.$v['id_request']],
					'wp' => $arrPost['cbo_result_clients_wp_'.$v['id_request']],
					'pc' => $arrPost['cbo_result_clients_pc_'.$v['id_request']],
					'web' => $arrPost['cbo_result_clients_web_'.$v['id_request']],
					'events' => $arrPost['cbo_result_clients_events_'.$v['id_request']],
					'systems' => $arrPost['cbo_result_clients_systems_'.$v['id_request']],
					'orther' => $arrPost['cbo_result_clients_orther_'.$v['id_request']],
					'notes_clients_android' => $arrPost['notes_clients_android_'.$v['id_request']],
					'notes_clients_ios' => $arrPost['notes_clients_ios_'.$v['id_request']],
					'notes_clients_wp' => $arrPost['notes_clients_wp_'.$v['id_request']],
					'notes_clients_pc' => $arrPost['notes_clients_pc_'.$v['id_request']],
					'notes_clients_web' => $arrPost['notes_clients_web_'.$v['id_request']],
					'notes_clients_events' => $arrPost['notes_clients_events_'.$v['id_request']],
					'notes_clients_systems' => $arrPost['notes_clients_systems_'.$v['id_request']],
					'notes_clients_orther' => $arrPost['notes_clients_orther_'.$v['id_request']],
					'result_admin_android' => $arrPost['cbo_result_admin_android_'.$v['id_request']],
					'result_admin_ios' => $arrPost['cbo_result_admin_ios_'.$v['id_request']],
					'result_admin_wp' => $arrPost['cbo_result_admin_wp_'.$v['id_request']],
					'result_admin_pc' => $arrPost['cbo_result_admin_pc_'.$v['id_request']],
					'result_admin_web' => $arrPost['cbo_result_admin_web_'.$v['id_request']],
					'result_admin_events' => $arrPost['cbo_result_admin_events_'.$v['id_request']],
					'result_admin_systems' => $arrPost['cbo_result_admin_systems_'.$v['id_request']],
					'result_admin_orther' => $arrPost['cbo_result_admin_orther_'.$v['id_request']],
					'notes_admin_android' => $arrPost['notes_admin_android_'.$v['id_request']],
					'notes_admin_ios' => $arrPost['notes_admin_ios_'.$v['id_request']],
					'notes_admin_wp' => $arrPost['notes_admin_wp_'.$v['id_request']],
					'notes_admin_pc' => $arrPost['notes_admin_pc_'.$v['id_request']],
					'notes_admin_web' => $arrPost['notes_admin_web_'.$v['id_request']],
					'notes_admin_events' => $arrPost['notes_admin_events_'.$v['id_request']],
					'notes_admin_systems' => $arrPost['notes_admin_systems_'.$v['id_request']],
					'notes_admin_orther' => $arrPost['notes_admin_orther_'.$v['id_request']],
					'datecreate' => date('y-m-d H:i:s'),
					'daterequest' => date('y-m-d H:i:s'),
					'userlog' => $_SESSION['account']['id']
				   );
				   $this->CI->GamechecklistModel->addresult($arrP);
			   }
			   $mess="Đã cập nhật thông tin thành công";
			   redirect('?control=gamechecklist&func=index&id_template='.$_GET['id_template'].'&id_game='.$_GET['id_game'].'&mess='.base64_encode($mess));
		   }else{
			   $mess="Không có dữ liệu, vui lòng cập nhật thông tin.";
			   redirect('?control=gamechecklist&func=index&id_template='.$_GET['id_template'].'&id_game='.$_GET['id_game'].'&mess='.base64_encode($mess));
		   }
		   
	}
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('cbo_categories', $arrParam['cbo_categories']);
        }
    }
	public function ajaxupdateresult(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id_game']>0){
			$where = array(
                'id_game'=>$arr_p['id_game'],
                'id_template'=>$arr_p['id_temp'],
				'id_categories'=>$arr_p['id_cate'],
				'id_request'=>$arr_p['id_request']
            );
			$reults = $this->CI->GamechecklistModel->updateresultchecklist($where,$arr_p);
			if($reults){
				$f = array(
					'error'=>'0',
					'messg'=>'OK'
				);
			}else{
				$f = array(
					'error'=>'1',
					'messg'=>'Error'
				);
				
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Error'
            );
			
        }
		/*$this->CI->template->write_view('content', 'gamechecklist/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/
        echo json_encode($f);
        exit();
	}
	
	//cap nhat 07/04/2016
	public function search_plus(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id_game']>0){
			$data = array(
                'id_game'=>$arr_p['id_game'],
				'id_group'=>$arr_p['group'],
				'id_categories'=>$arr_p['cate'],
				'status'=>$arr_p['status'],
				'loai'=>$arr_p['loai']
            );
			
			$f = array(
                'error'=>'0',
                'messg'=>'Success',
				'html'=>$this->CI->load->view('gamechecklisttemp/search/index', $data, true)
            );
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Error System',
				'html'=>''
            );
			
        }
		/*$this->CI->template->write_view('content', 'gamechecklist/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/
        echo json_encode($f);
        exit();
	}//end func
	
    public function getResponse() {
        return $this->_response;
    }
}
