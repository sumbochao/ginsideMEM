<?php
class MeAPI_Controller_categoriesController{
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
		$this->CI->load->MeAPI_Model('TranferDataChecklistModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
		$this->data['loadplatform']=$this->CI->CategoriesModel->listPlatform();
		$this->data['categories']=$this->CI->CategoriesModel->listItem();
		$this->data['group']=$this->CI->GroupuserModel->listItem();
		$this->data['slbtemplate']=$this->CI->TemplateModel->listItem();
		
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'categories/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý hạng mục';
		
		$this->filter();
      	
		//02/03/2016
		$this->data['ListGame']=$this->CI->TemplatechecklistModel->listGame();
		$this->data['obj']=$this->CI->CategoriesModel;
		//tranfer data
		/*if(isset($_POST['btn_tranfer'])){
			
			$data['idrequest'] = $this->CI->CategoriesModel->ShowRequestTemp(3);
			foreach($data['idrequest'] as $item){
				$arrParam = array(
					"id_template"=>3,
					"id_categories"=>$item['id_categories'],
					"id_request"=>$item['id'],
					"datecreate"=>date('y-m-d H:i:s'),
					"userlog"=>$_SESSION['account']['id']		
				);
				$idadd = $this->CI->TemplatechecklistModel->add_new($arrParam);
			}
			
		}//end tranfer
		*/
        $arrFilter = array(
            'names' => $this->CI->Session->get_session('names'),
			'id_template' => $this->CI->Session->get_session('id_template')
        );
		
		
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean(array_merge($_POST,$_GET));
            $arrFilter = array(
                'names' => $arrParam['keyword'],
				'id_template' => $arrParam['id_template'],
                'page' => 1
            );
            $page = 1;
        }
        
        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->CategoriesModel->listItem($arrFilter);
		
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
		$this->data['slbTemp']=$this->CI->TemplateModel->getItemId();
		$this->data['slbUser'] = $this->CI->CategoriesModel->listUser();
		$this->data['slbCategories'] = $this->CI->CategoriesModel->getItemId();
 
        $this->CI->template->write_view('content', 'categories/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function addnew(){
		$arr_p=$this->CI->security->xss_clean($_POST);
		$arrParam = array(
			"id_template"=>$arr_p['cbo_template'],
			"id_parrent"=>$arr_p['cbo_categories'],
			"names"=>$arr_p['names'],
			"notes"=>addslashes($arr_p['notes']),
			"datecreate"=>date('y-m-d H:i:s'),
			"order"=>$arr_p['order'],
			"userlog"=>$_SESSION['account']['id']		
		);
		$arrfilter= array(
			"id_template"=>$arr_p['cbo_template'],
			"names"=>$arr_p['names']
		);
		$bool=$this->CI->CategoriesModel->checknamesexist($arrfilter);
		if(!$bool){
			$idadd = $this->CI->CategoriesModel->add_new($arrParam);
			return $idadd;
		}else{
			return false;
		}
	}
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Tạo hạng mục';
        if($this->CI->input->post()){
            $id=$this->addnew();
            if($id!=FALSE){
                    $this->data['errors']="<strong style='color:#008000'>Tạo mới thành công</strong>";
                    /*if($_GET['type_link']==1){
                        redirect(base_url().'?control='.$_GET['control'].'&func=edit&id_template='.$_GET['id_template'].'&id='.(int)$id);
                    }else{
                        redirect(base_url().'?control='.$_GET['control'].'&func=index&id_template='.$_GET['id_template']);
                    }*/
            }else{
                    $this->data['errors']="Hạng mục này đã tồn tại!";
            }
        }
        $this->data['parent']=$this->CI->CategoriesModel->listCategorisParent();
        $this->CI->template->write_view('content', 'categories/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function editnew(){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			"id_template"=>$arr_p['cbo_template'],
			"id_parrent"=>$arr_p['cbo_categories'],
			"names"=>$arr_p['names'],
			"notes"=>addslashes($arr_p['notes']),
			"order"=>$arr_p['order'],
			"datecreate"=>date('y-m-d H:i:s'),
			"userlog"=>$_SESSION['account']['id']	
		);

		$rs = $this->CI->CategoriesModel->edit_new($arrParam,$arr_p['id']);
		return $rs;
	}
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật hạng mục';
		
		if($this->CI->input->post()){
			if($this->editnew()){
				$this->data['errors']="<strong style='color:#008000'>Cập nhật thành công</strong>";
				//redirect($this->_mainAction);
			}else{
				$this->data['errors']="Không thực hiện được";
			}
			
		}
		$this->data['parent']=$this->CI->CategoriesModel->listCategorisParent();
		$this->data['item']=$this->CI->CategoriesModel->getItem(intval($_GET['id']));
        $this->CI->template->write_view('content', 'categories/edit', $this->data);
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
		$this->data['item']=$this->CI->CategoriesModel->getItem(intval($_GET['idcategories']));
        $this->CI->template->write_view('content', 'categories/checklist', $this->data);
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
                'html'=>$this->CI->load->view('categories/ajaxrequest', $data, true)
            );
        }else{
            $data['item'] = array();
			$data['groupActive']=array();
			$data['groupActiveSupport']=array();
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>$this->CI->load->view('categories/ajaxrequest', $data, true)
            );
        }
        echo json_encode($f);
        exit();
	}
	
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('names', $arrParam['keyword']);
            $this->CI->Session->unset_session('cbo_template', $arrParam['cbo_template']);
        }
    }
	public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->CategoriesModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->CategoriesModel->deleteItem($arrParam);
        }
        redirect("?control=categories&func=index&id_template=".$arrParam['id_template']);
    }
	public function updatestatus(){
		$arr_p = $this->CI->security->xss_clean($_GET);
		if($arr_p['id'] > 0){
			$arrFill=array(
				'id'=>intval($arr_p['id']),
				'status'=>intval($arr_p['status'])
			);
            $result=$this->CI->CategoriesModel->updatestatus($arrFill);
			$data['status']=$this->CI->CategoriesModel->getItem(intval($arr_p['id']));
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('categories/status', $data, true)
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
            $result=$this->CI->CategoriesModel->updatesort($arrFill,intval($arr_p['id']));
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
        if(isset($arr_p['idtemp'])){
            $data['parent'] = $this->CI->CategoriesModel->listCategorisParentInTemp($arr_p['idtemp']);
			$data['item']=$this->CI->CategoriesModel->getItem(intval($arr_p['idedit']));
            $f = array(
                'error'=>'0',
                'messg'=>'OK',
                'html'=>$this->CI->load->view('categories/cbocate', $data, true)
            );
        }else{
            $data['parent'] = array();
			$data['item'] = array();
            $f = array(
                'error'=>'1',
                'messg'=>'Error',
                'html'=>$this->CI->load->view('categories/cbocate', $data, true)
            );
        }
		
        echo json_encode($f);
        exit();
    }
	
	
	//update 01/03/2016
	//Tranfer Data Checklist
	public function transferdata(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
		$post=$_POST['cbo_template_source'];
		$r_post=explode('|',$post);
		$id_game=$r_post[0];
		$id_temp=$r_post[1];
		
		$param_where=array(
			'id_game'=>$id_game,
			'id_template'=>$id_temp
		);
		//kiểm tra data của Template
		$cgame = $this->CI->TranferDataChecklistModel->CheckGameExist($param_where['id_game'],intval($_POST['cbo_temp']));
		if($cgame>0){
			
			$mess="Template đã có dữ liệu, chỉ Copy khi Template không có dữ liệu";
			redirect('?control='.$_GET['control'].'&func=index&cbo_template='.intval($_POST['cbo_temp']).'&c='.$cgame.'&mess='.base64_encode($mess));
			return;
		}//end if
		
		//b1 chuyển hang muc theo idgame va idtemplate tu bang tbl_categories_game sang tbl_categories
			$source_cate_na=$this->CI->TranferDataChecklistModel->GetCateNASource($param_where['id_game'],$param_where['id_template']);
			if(count($source_cate_na)>0){
				foreach($source_cate_na as $item){
					
					//bắt đầu tranfer data sang tbl_categories
					//b1 tranfer cate na
					$aParam = array(
						'id_source'=>$item['id'],
						'id_template'=>$_POST['cbo_temp'],
						'id_parrent'=>$item['id_parrent'],
						'names'=>$item['names'],
						'notes'=>$item['notes'],
						'datecreate'=>date('Y-m-d H:i:s'),
						'userlog'=>$_SESSION['account']['id'],
						'status'=>$item['status'],
						'order'=>$item['order']
					);
					$add=$this->CI->CategoriesModel->add_new($aParam);
					$aParam=NULL;
					
				}//end for
			}//end if
			
		//b2. duyệt hangh muc na bang tbl_categories vua moi duoc insert vao tu bang tbl_categories_game
		$destination_cate_na=$this->CI->TranferDataChecklistModel->GetCateNADestination($_POST['cbo_temp']);
		$source_cate= array();
			$i=0;
			if(count($destination_cate_na)>0){
				foreach($destination_cate_na as $items){
					$source_cate[$i]=$this->CI->TranferDataChecklistModel->GetCateSource($param_where['id_game'],$param_where['id_template'],$items['id_source']);
			
					foreach($source_cate[$i] as $v){
						$bParam = array(
							'id_source'=>$v['id'],
							'id_template'=>$_POST['cbo_temp'],
							'id_parrent'=>$items['id'],
							'names'=>$v['names'],
							'notes'=>$v['notes'],
							'datecreate'=>date('Y-m-d H:i:s'),
							'userlog'=>$_SESSION['account']['id'],
							'status'=>$v['status'],
							'order'=>$v['order']
						);
						$add=$this->CI->CategoriesModel->add_new($bParam);
						$bParam=NULL;
					}//end for
					$i++;
				}//end for
			}//end if
			
			//b3. sau khi copy het cac hang muc, bat dau copy yeu cau theo hang muc
			//lay danh muc tu bang Des
			$cate = $this->CI->TranferDataChecklistModel->GetCateDestination($_POST['cbo_temp']);
			if(count($cate)>0){
				//lặp bảng đích danh mục
				foreach($cate as $item){
					
					$res=$this->CI->TranferDataChecklistModel->GetRequestSource($param_where['id_game'],$item['id_source']);
					//lặp bảng request source theo id_categories bang des
					foreach($res as $v){
							$bParam = array(
								'id_source'=>$v['id'],
								'id_categories'=>$item['id'],
								'titles'=>$v['titles'],
								'types'=>$v['types'],
								"ios"=>$v['ios'],
								"android"=>$v['android'],
								"wp"=>$v['wp'],
								"pc"=>$v['pc'],
								"web"=>$v['web'],
								"events"=>$v['events'],
								"systems"=>$v['systems'],
								"orther"=>$v['orther'],
								"notes"=>addslashes($v['notes']),
								"datecreate"=>date('y-m-d H:i:s'),
								"admin_request"=>$v['admin_request'],
								"userlog"=>$v['userlog'],
								"sort"=>$v['sort']	
							);
							$add=$this->CI->TranferDataChecklistModel->add_new_request($bParam);
							$bParam=NULL;
					}//end for
					
				}//end if
				
			}//end if
			
		    //b4. copy Group
			$add_group=$this->CI->TranferDataChecklistModel->TranferGroup($param_where['id_template'],$param_where['id_game']);
			//kết thúc
			redirect('?control='.$_GET['control'].'&func=index&cbo_template='.intval($_POST['cbo_temp']));
		
	}//end function TranferGroupToDes
	
    public function getResponse() {
        return $this->_response;
    }
}
