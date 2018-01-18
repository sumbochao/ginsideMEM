<?php
class MeAPI_Controller_RequestgametemplateController{
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
		$this->CI->load->MeAPI_Library('CKEditor');
		$this->CI->load->MeAPI_Library('CKFinder');
		$this->CI->load->MeAPI_Library('Libcommon');
		$this->CI->load->MeAPI_Model('RequestGameModel');
		$this->CI->load->MeAPI_Model('CategoriesGameModel');
		$this->CI->load->MeAPI_Model('GroupuserModel');
		$this->CI->load->MeAPI_Model('GrandRequestUserGameModel');
		$this->CI->load->MeAPI_Model('TemplatechecklistModel');
		$this->CI->load->MeAPI_Model('GamechecklistModel');
		$this->CI->load->MeAPI_Model('TemplateModel');
		
		
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
		$this->data['categories']=$this->CI->CategoriesGameModel->listCategorisParentInTempRequest(intval($_GET['id_game']));
		$this->data['group']=$this->CI->GroupuserModel->listItem();
		$this->data['groupsupport']=$this->CI->GroupuserModel->listItem();
		 //load ckeditor
		$this->CI->Libcommon->CreateCKeditor();
		$this->data['sTemps'] = $this->CI->TemplateModel->getItemId();
		$this->data['loadgame']=$this->CI->TemplatechecklistModel->listGame();
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'requestgametemplate/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý yêu cầu';
		
		$this->filter();
		
        $arrFilter = array(
            'titles' => $this->CI->Session->get_session('titles'),
			'id_categories' => $this->CI->Session->get_session('cbo_categories'),
			'id_game' => $this->CI->Session->get_session('id_game')
        );

        if (isset($_GET['type']) && $_GET['type']=="filter") {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_GET);
            $arrFilter = array(
				'id_game' => $arrParam['id_game'],
				'id_categories' => $arrParam['id_categories'],
                'page' => 1
            );
            $page = 1;
        }
		
        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->RequestGameModel->listItem($arrFilter);
		
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
		$this->data['slbUser'] = $this->CI->RequestGameModel->listUser();
		$this->data['slbCategories'] = $this->CI->CategoriesGameModel->getItemId();
		
 
        $this->CI->template->write_view('content', 'requestgametemplate/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function addnew(){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		
		$t=0;
		if($arr_p['chk_ios']=="true") $t++;
		if($arr_p['chk_android']=="true") $t++;
		if($arr_p['chk_wp']=="true") $t++;
		if($arr_p['chk_pc']=="true") $t++;
		if($arr_p['chk_web']=="true") $t++;
		if($arr_p['chk_event']=="true") $t++;
		if($arr_p['chk_system']=="true") $t++;
		if($arr_p['chk_orther']=="true") $t++;
		
		$arrParam = array(
			"id_game"=>$arr_p['id_game'],
			"id_categories"=>$arr_p['cbo_categories'],
			"titles"=>$arr_p['titles'],
			"types"=>$t,
			"ios"=>$arr_p['chk_ios'],
			"android"=>$arr_p['chk_android'],
			"wp"=>$arr_p['chk_wp'],
			"pc"=>$arr_p['chk_pc'],
			"web"=>$arr_p['chk_web'],
			"events"=>$arr_p['chk_event'],
			"systems"=>$arr_p['chk_system'],
			"orther"=>$arr_p['chk_orther'],
			"notes"=>addslashes($arr_p['notes']),
			"datecreate"=>date('y-m-d H:i:s'),
			"admin_request"=>addslashes($arr_p['admin_request']),
			"userlog"=>$_SESSION['account']['id'],
			"sort"=>0		
		);
		
		$bool=$this->CI->RequestGameModel->checktitleexist($arr_p['cbo_categories'],$arr_p['titles']);
		if(!$bool){
			$idadd = $this->CI->RequestGameModel->add_new_id($arrParam);
			return $idadd;
		}else{
			return false;
		}
	}
	public function addgroup($id_request){
		$arr_p=$this->CI->security->xss_clean($_POST);
		$bool=false;
		if(count($arr_p['chk_group'])>0){
			foreach($arr_p['chk_group'] as $key=>$value){
				$arrParam = array(
					"id_game"=>intval($_GET['id_game']),
					"id_request"=>$id_request,
					"id_group"=>$value,
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$bool=$this->CI->GrandRequestUserGameModel->add_new($arrParam);
			}
		}
		return $bool;
	}
	public function addgroupsupport($id_request){
		$arr_p=$this->CI->security->xss_clean($_POST);
		$bool=false;
		if(count($arr_p['chk_group_support'])>0){
			foreach($arr_p['chk_group_support'] as $key=>$value){
				$arrParam = array(
					"id_game"=>intval($_GET['id_game']),
					"id_request"=>$id_request,
					"id_group"=>$value,
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$bool=$this->CI->GrandRequestUserGameModel->add_new_support($arrParam);
			}
		}
		return $bool;
	}
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Tạo yêu cầu hạng mục';
		if($this->CI->input->post()){
			if(count($_POST['chk_group'])>0 && count($_POST['chk_group_support'])>0){
				$id=$this->addnew();
				
				if($id!=FALSE){
					//add group
					$idg=$this->addgroup($id);
					$idg_support=$this->addgroupsupport($id);
				
					if($idg!=FALSE && $idg_support!=FALSE){
						$this->data['errors']="<strong style='color:#008000'>Tạo mới thành công</strong>";
					}else{
						$this->data['errors']="Không thêm được group ".$idg;
					}
						
				}else{
					$this->data['errors']="Yêu cầu này đã tồn tại trong hạng mục này.Vui lòng nhập tên yêu cầu khác";
				}
			}else{
				$this->data['errors']="Vui lòng chọn Group thự  hiện và Group hỗ trợ";
			}
		}
		

        $this->CI->template->write_view('content', 'requestgametemplate/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	//thêm hoặc xóa group
	public function checkgroup($arrChkActive){
		$bool=false;
		$arrActive=$_POST['chk_group_actice'];
		$arrNon=$_POST['chk_group'];
		
		//kiểm tra group active trong bảng Grand
		if(count($arrActive)==0){
			//xóa tất cả group đã active theo id_request
			$bool=$this->CI->GrandRequestUserGameModel->deletewhere(intval($_GET['id']),1);
		}else{
			if(count($arrActive) <  count($arrChkActive)){
				$bool=$this->CI->GrandRequestUserGameModel->deleteinarray(implode(',',$arrActive),intval($_GET['id']));
			}else{
				$bool=true;
			}
		}
		
		
		//kiểm tra group mới có được active hay không
		if(count($arrNon)>0){
			foreach($arrNon as $key=>$value){
				$arrParam = array(
					"id_game"=>intval($_GET['id_game']),
					"id_request"=>intval($_GET['id']),
					"id_group"=>$value,
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$bool=$this->CI->GrandRequestUserGameModel->add_new($arrParam);
			}
		}else{
			$bool=true;
		}
		return $bool;
	}
	//thêm hoặc xóa group
	public function checkgroupsupport($arrChkActive){
		$bool=false;
		$arrActive=$_POST['chk_group_actice_support'];
		$arrNon=$_POST['chk_group_support'];
		
		//kiểm tra group active trong bảng Grand
		if(count($arrActive)==0){
			//xóa tất cả group đã active theo id_request
			$bool=$this->CI->GrandRequestUserGameModel->deletewheresupport(intval($_GET['id']),1);
		}else{
			if(count($arrActive) <  count($arrChkActive)){
				$bool=$this->CI->GrandRequestUserGameModel->deleteinarraysupport(implode(',',$arrActive),intval($_GET['id']));
			}else{
				$bool=true;
			}
		}
		
		
		//kiểm tra group mới có được active hay không
		if(count($arrNon)>0){
			foreach($arrNon as $key=>$value){
				$arrParam = array(
					"id_game"=>intval($_GET['id_game']),
					"id_request"=>intval($_GET['id']),
					"id_group"=>$value,
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$bool=$this->CI->GrandRequestUserGameModel->add_new_support($arrParam);
			}
		}else{
			$bool=true;
		}
		return $bool;
		
	}
	
	
	public function editnew(){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$t=0;
		if($arr_p['chk_ios']=="true") $t++;
		if($arr_p['chk_android']=="true") $t++;
		if($arr_p['chk_wp']=="true") $t++;
		if($arr_p['chk_pc']=="true") $t++;
		if($arr_p['chk_web']=="true") $t++;
		if($arr_p['chk_event']=="true") $t++;
		if($arr_p['chk_system']=="true") $t++;
		if($arr_p['chk_orther']=="true") $t++;
		
		$arrParam = array(
			"id_game"=>$arr_p['id_game'],
			"id_categories"=>$arr_p['cbo_categories'],
			"titles"=>$arr_p['titles'],
			"types"=>$t,
			"ios"=>$arr_p['chk_ios'],
			"android"=>$arr_p['chk_android'],
			"wp"=>$arr_p['chk_wp'],
			"pc"=>$arr_p['chk_pc'],
			"web"=>$arr_p['chk_web'],
			"events"=>$arr_p['chk_event'],
			"systems"=>$arr_p['chk_system'],
			"orther"=>$arr_p['chk_orther'],
			"notes"=>$arr_p['notes'],
			"datecreate"=>date('y-m-d H:i:s'),
			"admin_request"=>addslashes($arr_p['admin_request']),
			"userlog"=>$_SESSION['account']['id']		
		);

		$rs = $this->CI->RequestGameModel->edit_new($arrParam,$arr_p['id']);
		return $rs;
	}
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật yêu cầu hạng mục';
		$arrFill=array(
			'id_request'=>intval($_GET['id']),
			'id_game'=>intval($_GET['id_game'])
		);
		$this->data['groupActive1']=$this->CI->GroupuserModel->listItemInnerJoinGame($arrFill,0);
		$this->data['groupActiveSupport1']=$this->CI->GroupuserModel->listItemInnerJoinSupportGame($arrFill,0);
		
		if($this->CI->input->post()){
			if($this->editnew()){
				$b1=$this->checkgroup($this->data['groupActive1']);
				$b2=$this->checkgroupsupport($this->data['groupActiveSupport1']);
				if($b1!=false && $b2!=false){
					$this->data['errors']="<strong style='color:#008000'>Cập nhật thành công</strong>";
				}else{
					$this->data['errors']="Cập nhật thất bại";
				}
				//redirect($this->_mainAction);
			}else{
				$this->data['errors']="Không thực hiện được";
			}
			
		}
		
		$this->data['groupActive']=$this->CI->GroupuserModel->listItemInnerJoinGame($arrFill,0);
		$this->data['groupNotActive']=$this->CI->GroupuserModel->listItemInnerJoinGame($arrFill,1);
		
		$this->data['groupActiveSupport']=$this->CI->GroupuserModel->listItemInnerJoinSupportGame($arrFill,0);
		$this->data['groupNotActiveSupport']=$this->CI->GroupuserModel->listItemInnerJoinSupportGame($arrFill,1);
		
		$this->data['item']=$this->CI->RequestGameModel->getItem(intval($_GET['id']));
		
		//syn
		$this->SynDataOnRequest(intval($_GET['id']),"android",$this->data['item']['android']);
		$this->SynDataOnRequest(intval($_GET['id']),"ios",$this->data['item']['ios']);
		$this->SynDataOnRequest(intval($_GET['id']),"wp",$this->data['item']['wp']);
		$this->SynDataOnRequest(intval($_GET['id']),"pc",$this->data['item']['pc']);
		$this->SynDataOnRequest(intval($_GET['id']),"web",$this->data['item']['web']);
		$this->SynDataOnRequest(intval($_GET['id']),"events",$this->data['item']['events']);
		$this->SynDataOnRequest(intval($_GET['id']),"systems",$this->data['item']['systems']);
		$this->SynDataOnRequest(intval($_GET['id']),"orther",$this->data['item']['orther']);
		// end syn
		
        $this->CI->template->write_view('content', 'requestgametemplate/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	//hàm đồng bộ kết quả user va admin
	public function SynDataOnRequest($id,$platform,$val){
		 if($val==""){
			   $arrParam = array(
				"result_$platform"=>NULL,
				"notes_$platform"=>NULL,
				"result_admin_$platform"=>NULL,
				"notes_admin_$platform"=>NULL		
			   );
			   $rs = $this->CI->RequestGameModel->edit_new($arrParam,$id);
		 }//end if
	}//end func
	
	public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->RequestGameModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->RequestGameModel->deleteItem($arrParam);
        }
        redirect("?control=requestgametemplate&func=index&id_categories=".$_GET['id_categories']."&id_game=".$arrParam['id_game']);
    }
	public function deletelist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$reults = $this->CI->RequestGameModel->deletelistitem($arr_p['id']);
			if($reults){
				$f = array(
					'error'=>'0',
					'messg'=>'Thành công '.$reults
				);
			}else{
				$f = array(
					'error'=>'1',
					'messg'=>'Thất bại '.$reults
				);
				
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
			
        }
        echo json_encode($f);
        exit();
	}
	
	public function filter() {
        $arrParam = $this->CI->security->xss_clean(array_merge($_POST,$_GET));
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('titles', $arrParam['keyword']);
            $this->CI->Session->unset_session('cbo_categories', $arrParam['cbo_categories']);
			$this->CI->Session->unset_session('id_game', $arrParam['id_game']);
        }else{
			$this->CI->Session->unset_session('cbo_categories', $arrParam['id_categories']);
			$this->CI->Session->unset_session('id_game', $arrParam['id_game']);
		}
    }
	
	public function updatesort(){
		$arr_p = $this->CI->security->xss_clean($_GET);
		if($arr_p['id'] > 0){
			$arrFill=array(
				'sort'=>intval($arr_p['values'])
			);
			$result=$this->CI->RequestGameModel->updatesort($arrFill,intval($arr_p['id']));
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
	
    public function getResponse() {
        return $this->_response;
    }
}
