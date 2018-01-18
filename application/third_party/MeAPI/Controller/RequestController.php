<?php
class MeAPI_Controller_RequestController{
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
		$this->CI->load->MeAPI_Model('RequestModel');
		$this->CI->load->MeAPI_Model('CategoriesModel');
		$this->CI->load->MeAPI_Model('GroupuserModel');
		$this->CI->load->MeAPI_Model('GrandRequestUserModel');
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
		$this->data['loadplatform']=$this->CI->RequestModel->listPlatform();
		$arrFilterC = array(
			'id_template' => intval($_GET['id_template'])
        );
		$this->data['categories']=$this->CI->CategoriesModel->listItem($arrFilterC,"n");
		$this->data['group']=$this->CI->GroupuserModel->listItem();
		$this->data['groupsupport']=$this->CI->GroupuserModel->listItem();
		
		
		$this->data['listCategories'] = $this->CI->CategoriesModel->listItem($arrFilterC);
		 //load ckeditor
		$this->CI->Libcommon->CreateCKeditor();
		$this->data['sTemps'] = $this->CI->TemplateModel->getItemId();
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'projects/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý yêu cầu';
		
		$this->filter();
		
        $arrFilter = array(
            'titles' => $this->CI->Session->get_session('keyword'),
			'id_categories' => $this->CI->Session->get_session('cbo_categories')
        );

        if (isset($_GET['type']) && $_GET['type']=="filter") {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_GET);
            $arrFilter = array(
                'titles' => $arrParam['keyword'],
				'id_categories' => $arrParam['id_categories'],
                'page' => 1
            );
            $page = 1;
        }
		
        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->RequestModel->listItem($arrFilter);
		
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
		$this->data['slbUser'] = $this->CI->RequestModel->listUser();
		$this->data['slbCategories'] = $this->CI->CategoriesModel->getItemId();
		
 
        $this->CI->template->write_view('content', 'request/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function addnew(){
		$arr_p=$this->CI->security->xss_clean($_POST);
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
			"sort"=>$arr_p['sort'],
			"notes"=>addslashes($arr_p['notes']),
			"datecreate"=>date('y-m-d H:i:s'),
			"admin_request"=>addslashes($arr_p['admin_request']),
			"userlog"=>$_SESSION['account']['id']		
		);
		$bool=$this->CI->RequestModel->checktitleexist($arr_p['cbo_categories'],$arr_p['titles']);
		if(!$bool){
			$idadd = $this->CI->RequestModel->add_new_id($arrParam);
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
					"id_request"=>$id_request,
					"id_group"=>$value,
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$bool=$this->CI->GrandRequestUserModel->add_new($arrParam);
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
					"id_request"=>$id_request,
					"id_group"=>$value,
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$bool=$this->CI->GrandRequestUserModel->add_new_support($arrParam);
			}
		}
		return $bool;
	}
	public function addchecklisttemplate($id_request){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			"id_template"=>$arr_p['id_template'],
			"id_categories"=>$arr_p['cbo_categories'],
			"id_request"=>$id_request,
			//"notes"=>addslashes($arr_p['notes']),
			"datecreate"=>date('y-m-d H:i:s'),
			"userlog"=>$_SESSION['account']['id']		
		);
		$arrfilter= array(
			"id_template"=>$arr_p['id_template'],
			"id_categories"=>$arr_p['cbo_categories'],
			"id_request"=>$id_request
		);
		$bool=$this->CI->TemplatechecklistModel->checkexist($arrfilter);
		if(!$bool){
			$idadd = $this->CI->TemplatechecklistModel->add_new($arrParam);
			return $idadd;
		}else{
			return false;
		}
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
					//add template
					$temp = $this->addchecklisttemplate($id);
					if($temp){
				
						if($idg){
							$this->data['errors']="<strong style='color:#008000'>Tạo mới thành công</strong>";
						}else{
							$this->data['errors']="Không thêm được group ".$idg;
						}
						
					}else{
						$this->data['errors']="Yêu cầu này đã được khai báo ".$temp;
					}
				}else{
					$this->data['errors']="Yêu cầu này đã tồn tại trong hạng mục này.Vui lòng nhập tên yêu cầu khác";
				}
			}else{
				$this->data['errors']="Vui lòng chọn Group thự  hiện và Group hỗ trợ";
			}
		}
		

        $this->CI->template->write_view('content', 'request/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	//thêm hoặc xóa group
	public function checkgroup($arrChkActive){
		$arrActive=$_POST['chk_group_actice'];
		$arrNon=$_POST['chk_group'];
		
		//kiểm tra group active trong bảng Grand
		if(count($arrActive)==0){
			//xóa tất cả group đã active theo id_request
			$bool=$this->CI->GrandRequestUserModel->deletewhere(intval($_GET['id']),1);
		}else{
			if(count($arrActive) <  count($arrChkActive)){
				$bool=$this->CI->GrandRequestUserModel->deleteinarray(implode(',',$arrActive),intval($_GET['id']));
			}
		}
		
		
		//kiểm tra group mới có được active hay không
		if(count($arrNon)>0){
			foreach($arrNon as $key=>$value){
				$arrParam = array(
					"id_request"=>intval($_GET['id']),
					"id_group"=>$value,
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$bool=$this->CI->GrandRequestUserModel->add_new($arrParam);
			}
		}
		
	}
	//thêm hoặc xóa group
	public function checkgroupsupport($arrChkActive){
		$arrActive=$_POST['chk_group_actice_support'];
		$arrNon=$_POST['chk_group_support'];
		
		//kiểm tra group active trong bảng Grand
		if(count($arrActive)==0){
			//xóa tất cả group đã active theo id_request
			$bool=$this->CI->GrandRequestUserModel->deletewheresupport(intval($_GET['id']),1);
		}else{
			if(count($arrActive) <  count($arrChkActive)){
				$bool=$this->CI->GrandRequestUserModel->deleteinarraysupport(implode(',',$arrActive),intval($_GET['id']));
			}
		}
		
		
		//kiểm tra group mới có được active hay không
		if(count($arrNon)>0){
			foreach($arrNon as $key=>$value){
				$arrParam = array(
					"id_request"=>intval($_GET['id']),
					"id_group"=>$value,
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$bool=$this->CI->GrandRequestUserModel->add_new_support($arrParam);
			}
		}
		
	}
	
	public function editchecklisttemplate($id_request,$id_categories){
		//nếu request thay đổi categories , cập nhật lại id_categories trong bảng templatechecklist
		//cho đồng bộ dữ liệu
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			"id_categories"=>$arr_p['cbo_categories'],
			"datecreate"=>date('y-m-d H:i:s'),
			"userlog"=>$_SESSION['account']['id']		
		);
		$arrWhere= array(
			"id_template"=>$arr_p['id_template'],
			"id_categories"=>$id_categories,
			"id_request"=>$id_request
		);
			$bool = $this->CI->TemplatechecklistModel->edit_new($arrParam,$arrWhere);
		if($bool){
			return true;
		}else{
			return false;
		}
	}
	public function editresultgamechecklist($id_request,$id_categories){
		//nếu request thay đổi categories , cập nhật lại id_categories trong bảng tbl_result_game_template_checklist
		//cho đồng bộ dữ liệu
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			"id_categories"=>$arr_p['cbo_categories'],
			"datecreate"=>date('y-m-d H:i:s'),
			"userlog"=>$_SESSION['account']['id']		
		);
		$arrWhere= array(
			"id_template"=>$arr_p['id_template'],
			"id_categories"=>$id_categories,
			"id_request"=>$id_request
		);
			$bool = $this->CI->GamechecklistModel->edit_idcategories($arrParam,$arrWhere);
		if($bool){
			return true;
		}else{
			return false;
		}
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
			"sort"=>$arr_p['sort'],
			"datecreate"=>date('y-m-d H:i:s'),
			"admin_request"=>addslashes($arr_p['admin_request']),
			"userlog"=>$_SESSION['account']['id']		
		);

		$rs = $this->CI->RequestModel->edit_new($arrParam,$arr_p['id']);
		return $rs;
	}
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật yêu cầu hạng mục';
		$arrFill=array(
			'id_request'=>intval($_GET['id'])
		);
		$this->data['groupActive1']=$this->CI->GroupuserModel->listItemInnerJoin($arrFill,0);
		$this->data['groupActiveSupport1']=$this->CI->GroupuserModel->listItemInnerJoinSupport($arrFill,0);
		
		if($this->CI->input->post()){
			if($this->editnew()){
				$this->checkgroup($this->data['groupActive1']);
				$this->checkgroupsupport($this->data['groupActiveSupport1']);
				$b = $this->editchecklisttemplate(intval($_GET['id']),intval($_GET['id_categories']));
				$b1 = $this->editresultgamechecklist(intval($_GET['id']),intval($_GET['id_categories']));
				if($b){
					$this->data['errors']="<strong style='color:#008000'>Cập nhật thành công</strong>";
				}else{
					$this->data['errors']="Cập nhật template thất bại";
				}
				//redirect($this->_mainAction);
			}else{
				$this->data['errors']="Không thực hiện được";
			}
			
		}
		
		$this->data['groupActive']=$this->CI->GroupuserModel->listItemInnerJoin($arrFill,0);
		$this->data['groupNotActive']=$this->CI->GroupuserModel->listItemInnerJoin($arrFill,1);
		
		$this->data['groupActiveSupport']=$this->CI->GroupuserModel->listItemInnerJoinSupport($arrFill,0);
		$this->data['groupNotActiveSupport']=$this->CI->GroupuserModel->listItemInnerJoinSupport($arrFill,1);
		
		$this->data['item']=$this->CI->RequestModel->getItem(intval($_GET['id']));
        $this->CI->template->write_view('content', 'request/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->RequestModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->RequestModel->deleteItem($arrParam);
        }
        redirect("?control=request&func=index&id_categories=".$_GET['id_categories']."&id_template=".$arrParam['id_template']);
    }
	public function deletelist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$reults = $this->CI->RequestModel->deletelistitem($arr_p['id']);
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
        }else{
			$this->CI->Session->unset_session('cbo_categories', $arrParam['id_categories']);
		}
    }
	
	public function updaterow(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$arrParam = array(
							'id'=>$arr_p['id'],
                            'names'=>$arr_p['names_e'],
							'notes'=>$arr_p['notes_e']
                        );
						
			$result = $this->CI->RequestModel->edit_new($arrParam,$arr_p['id']);
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"update_request",
						"logs"=>json_encode($arrParam),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id(),
						"tables"=>"tbl_request",
						"id_actions"=>$arr_p['id']
			);
			$log=$this->CI->ProjectsModel->savelogdaily($arr_log);
			// end log
			if($result){
				echo "ok";
			}else{
				echo "false";
			}
        }else{
           		echo "false id ".$arr_p['id'];
		}
        exit();
	}//end function
	
	public function updatesort(){
		$arr_p = $this->CI->security->xss_clean($_GET);
		if($arr_p['id'] > 0){
			$arrFill=array(
				'sort'=>intval($arr_p['values'])
			);
			$result=$this->CI->RequestModel->updatesort($arrFill,intval($arr_p['id']));
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
