<?php
class MeAPI_Controller_TemplatechecklistController{
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
		$this->CI->load->MeAPI_Model('TranferDataModel');
		
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
        $this->CI->template->write_view('content', 'templatechecklist/noaccess', $this->data);
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
		
        $arrFilter = array(
            'id_categories' => $this->CI->Session->get_session('cbo_categories')
        );

               
		$arrParam = $this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrFilter = array(
			'id_template' => $arrParam['id_template'],
			'id_categories' => $arrParam['cbo_categories'],
			'page' => 1
		);
         
       
        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->TemplatechecklistModel->listItem($arrFilter);
		
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
		
		//load game checklist
		$arrFilterG = array(
			'id_template' => intval($_GET['id_template'])
        );
		$this->data['listGameChecklist'] = $this->CI->TemplatechecklistModel->listItemGameChecklist($arrFilterG);
		//load categories cha id_parent=na
		$this->data['categories']=$this->CI->CategoriesModel->listItem($arrFilterC);
        $this->CI->template->write_view('content', 'templatechecklist/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function TranferCate($id_template,$id_game){
			$arrParam = array(
				'id_game'=>$id_game,
				'id_template'=>$id_template
			);
			$source_cate_na=$this->CI->TranferDataModel->GetCateNASource($arrParam['id_template']);
			if(count($source_cate_na)>0){
				foreach($source_cate_na as $item){
					
					//bắt đầu tranfer data
					//b1 tranfer cate na
					$aParam = array(
						'id_source'=>$item['id'],
						'id_game'=>$arrParam['id_game'],
						'id_template'=>$item['id_template'],
						'id_parrent'=>$item['id_parrent'],
						'names'=>$item['names'],
						'notes'=>$item['notes'],
						'datecreate'=>date('Y-m-d H:i:s'),
						'userlog'=>$_SESSION['account']['id'],
						'status'=>$item['status'],
						'order'=>$item['order']
					);
					$add=$this->CI->TranferDataModel->add_new($aParam);
					
				}//end for
			}//end if
			
			//b2 tranfer data cate
			$destination_cate_na=$this->CI->TranferDataModel->GetCateNADestination($arrParam['id_game'],$arrParam['id_template']);
			$source_cate= array();
			$i=0;
			if(count($destination_cate_na)>0){
				foreach($destination_cate_na as $items){
					$source_cate[$i]=$this->CI->TranferDataModel->GetCateSource($items['id_template'],$items['id_source']);
			
					foreach($source_cate[$i] as $v){
						$bParam = array(
							'id_source'=>$v['id'],
							'id_game'=>$items['id_game'],
							'id_template'=>$items['id_template'],
							'id_parrent'=>$items['id'],
							'names'=>$v['names'],
							'notes'=>$v['notes'],
							'datecreate'=>date('Y-m-d H:i:s'),
							'userlog'=>$_SESSION['account']['id'],
							'status'=>$v['status'],
							'order'=>$v['order']
						);
						$add=$this->CI->TranferDataModel->add_new($bParam);
						$bParam=NULL;
					}//end for
					$i++;
				}//end for
			}//end if
			
	} //end TranferCate
	public function TranferRequest($id_template,$id_game){
		$arrParam = array(
				'id_game'=>$id_game,
				'id_template'=>$id_template
		);
		//lay danh muc tu bang Des
		$cate = $this->CI->TranferDataModel->GetCateDestination($arrParam['id_game'],$arrParam['id_template']);
		if(count($cate)>0){
			//lặp bảng đích danh mục
			foreach($cate as $item){
				
				$res=$this->CI->TranferDataModel->GetRequestSource($item['id_source']);
				//lặp bảng request source theo id_categories bang des
				foreach($res as $v){
						$bParam = array(
							'id_source'=>$v['id'],
							'id_game'=>$item['id_game'],
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
							"admin_request"=>addslashes($v['admin_request']),
							"userlog"=>$_SESSION['account']['id'],
							"sort"=>$v['sort']	
						);
						$add=$this->CI->TranferDataModel->add_new_request($bParam);
						$bParam=NULL;
				}//end for
				
			}//end if
			
		}//end if
	}//end function TranferRequest
	
	//Tranfer Group
	public function TranferGroupToDes($id_template,$id_game){
		$add=$this->CI->TranferDataModel->TranferGroup($id_template,$id_game);
	}//end function TranferGroupToDes
	
	public function addgame(){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			'id_game'=>$arr_p['cbo_game'],
			'id_template'=>$arr_p['id_template'],
			'datecreate'=>date('Y-m-d H:i:s'),
			'userlog'=>$_SESSION['account']['id']
		);
		$cgame = $this->CI->TranferDataModel->CheckGameExist($arrParam['id_game'],$arrParam['id_template']);
		
		if($cgame>0){
			
			$mess="Game này đã được tạo Checklist. Vui lòng chọn game khác";
			redirect('?control='.$_GET['control'].'&func=index&id_template='.intval($arrParam['id_template']).'&mess='.base64_encode($mess));
			
		}else{
			try{
				//ad game
				$this->CI->TemplatechecklistModel->add_game_checklist($arrParam);
				
				$this->TranferCate($arrParam['id_template'],$arrParam['id_game']);
				//sau khi Tranfer danh mục thành công
				//bắt đầu Tranfer yêu cầu
				$this->TranferRequest($arrParam['id_template'],$arrParam['id_game']);
				
				//sau khi Tranfer yeu cau thanh cong
				//bat dau Tranfer Group theo yeu cau
				$this->TranferGroupToDes($arrParam['id_template'],$arrParam['id_game']);
				//sau khi add thanh cong
				redirect('?control='.$_GET['control'].'&func=index&id_template='.intval($arrParam['id_template']));
			}catch(Exception $ex){
				echo 'Caught exception: ',  $ex->getMessage(), "\n";
				exit();
			}
			
		}//end if count game
		
		
		
		/*$bool=$this->CI->TemplatechecklistModel->checkexistgamechecklist($arrParam);
		if(!$bool){
			$this->CI->TemplatechecklistModel->add_game_checklist($arrParam);
			$mess="Thành công";
			redirect('?control='.$_GET['control'].'&func=index&id_template='.intval($arr_p['id_template']).'&mess='.base64_encode($mess));
		}else{
			$mess="Game này đã được tạo Checklist. Vui lòng chọn game khác";
			redirect('?control='.$_GET['control'].'&func=index&id_template='.intval($arr_p['id_template']).'&mess='.base64_encode($mess));
		}*/
	}
	public function removegame(MeAPI_RequestInterface $request){
		$arrParam = array_merge($_POST,$_GET);
        $this->CI->TemplatechecklistModel->deleteGameChecklist($arrParam,array('task'=>'multi'));
        redirect('?control='.$_GET['control'].'&func=index&id_template='.intval($arrParam['id_template']));
	}
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('cbo_categories', $arrParam['cbo_categories']);
        }
    }
	
	//update 11/01/2016
	public function popup_group(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật Group';
		$this->CI->load->library('form_validation');
		$arr_p=$this->CI->security->xss_clean($_GET);
		$this->data['listItems'] = $this->CI->TemplatechecklistModel->ShowGroupOnGame($arr_p['id_game'],$arr_p['type']);
		$this->data['slbGroup']=$this->CI->GroupuserModel->getItemId();
		$this->data['Group'] = $this->CI->GroupuserModel->listItem(NULL);
		$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'templatechecklist/popup_group', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function ChangeGroup(){
		$arr_p=$this->CI->security->xss_clean($_GET);
        if(isset($arr_p['id_game'])){
			$bool=$this->CI->TemplatechecklistModel->ChangeGroupOnGame($arr_p['id_game'],$arr_p['id_gr_current'],$arr_p['id_gr_change'],$arr_p['type']);
			if($bool){
				$f = array(
					'error'=>'0',
					'messg'=>'OK'
				);
			}else{
				$f = array(
					'error'=>'-1',
					'messg'=>'Error'.$bool
				);
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'System error'
            );
        }
		
       echo json_encode($f);
       exit();
    }
	
	public function updatestatus(){
		$arr_p = $this->CI->security->xss_clean($_GET);
		if($arr_p['id'] > 0){
			$arrFill=array(
				'id'=>intval($arr_p['id']),
				'status'=>intval($arr_p['status'])
			);
            $result=$this->CI->TemplatechecklistModel->updatestatus($arrFill);
			$data['status']=$this->CI->TemplatechecklistModel->getItemGame(intval($arr_p['id']));
            $f = array(
                'error'=>'0',
                'messg'=>'OK',
                'html'=>$this->CI->load->view('templatechecklist/status', $data, true)
            );
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại',
                'html'=>'Fail'
            );
        }
        echo json_encode($f);
        exit();
	}
	
    public function getResponse() {
        return $this->_response;
    }
}
