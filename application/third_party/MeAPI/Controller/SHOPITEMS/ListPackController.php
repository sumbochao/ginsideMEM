<?php
class MeAPI_Controller_SHOPITEMS_ListPackController{
	
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
		$this->CI->load->MeAPI_Model('SHOPITEMS/ListPackModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
		
		$this->data['slbGame']=$this->CI->ListPackModel->listGame();
		$this->data['slbUser']=$this->CI->ListPackModel->listUser();
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function PermissionUser(){
		//phan quyen
		 $arracc = array(
			'user_id' => $_SESSION['account']['id']
		 );
		$this->data['access'] = $this->CI->ListPackModel->checkuseringroup($arracc);
		if(count($this->data['access'])==0){
			redirect(base_url().'?control='.$_GET['control'].'&func=noaccess');
			return;
		}else{
			$this->data['access_group_id']=$this->data['access']['group_id'];
			$this->data['access_game_id']=$this->data['access']['game_id'];
		}
	}
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'toolsgame/shopitems/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản Lý Gói Quà (SHOP 3CAY)';
		$arr_p=$this->CI->security->xss_clean($_GET);
		//$this->PermissionUser();
		 $arrFilter = array(
			'game_id' => ""
		 );
		 if(isset($_POST['btn_search'])){
			 $arrFilter['game_id']=$_POST['game_id'];
                         $arrFilter['values_query']=$_POST['values_query'];
		 }
		 
		$this->data['listItems'] = $this->CI->ListPackModel->listItem($arrFilter);
		
		$arr=array($this->data['access_game_id']);
		$this->data['slbGameAccess']=$this->CI->ListPackModel->listGameAccess($arr);
		
        $this->CI->template->write_view('content', 'toolsgame/shopitems/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Tạo gói quà';
		$this->CI->load->library('form_validation');
		$this->data['slbShop']=$this->CI->ListPackModel->listShop();
		$arr_p=$this->CI->security->xss_clean($_POST);
		$bool=true;
		$path=APPLICATION_PATH.'/public/shop_img/';
		if(isset($_POST['btn_add'])){
			if($arr_p['game_id']==0){
				$this->data['Mess']="Vui lòng chọn Game";
				$bool=false;
			}
			if(trim($arr_p['titles_pack'])==""){
				$this->data['Mess']="Vui lòng nhập tên gói quà";
				$bool=false;
			}
			if($bool){
				
				//uphinh
				
				//preg_match('#\.[^.]+$#', $_FILES['img_file']['name'],$match);
				//$filename=explode(".",$_FILES['img_file']['name']);
				//$fn=str_replace(".".$filename[count($filename)-1],"",$_FILES['img_file']['name']);
				//move_uploaded_file($_FILES['img_file']['tmp_name'],$path.$_FILES['img_file']['name']);
				$j_extend_rules = '';
                if(count($arr_p['keyrule'])>0){
                    $extend_rules  =array();
                    foreach($arr_p['keyrule'] as $key=>$val){
                        if(count($arr_p['item_id'][$key])>0){
                            foreach($arr_p['item_id'][$key] as $key1=>$val1){
                               $extend_rules[$val][$val1] = $arr_p['name'][$key][$key1];
                            }
                        }
                    }
                    $j_extend_rules = json_encode($extend_rules);
                }
				$arrParam = array(
							'game_id'=>$arr_p['game_id'],
							'titles_pack'=>$arr_p['titles_pack'],
							'desc_pack'=>$arr_p['desc_pack'],
							'img_pack'=>$arr_p['img_pack'],
							'items'=>$arr_p['js_list_array_items'],
							'cost_pack'=>$arr_p['js_list_array_cost'],
							'extend_rules'=>$j_extend_rules,
							'values_query'=>$arr_p['values_query'],
							'start_date_pack'=>date('Y-m-d H:i:s',strtotime($arr_p['start_date_pack'])),
							'expired_date_pack'=>date('Y-m-d H:i:s',strtotime($arr_p['expired_date_pack'])),
							'num_pack'=>$arr_p['num_pack'],
							'limit_buy_day'=>$arr_p['limit_buy_day'],
							'datecreate'=>date('Y-m-d H:i:s'),
							'user_log'=>$_SESSION['account']['id'],
							'status_publish'=>0
							);
				$rs=$this->CI->ListPackModel->add_new($arrParam);
				if($rs){
					$this->data['Mess']="Thêm thành công";
				}else{
					$this->data['Mess']="Không thêm được";
				}
			}//end if
		}//end if
		
        $this->CI->template->write_view('content', 'toolsgame/shopitems/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		//$this->PermissionUser();
        $this->data['title'] = 'Tạo gói quà';
		$this->CI->load->library('form_validation');
		$this->data['slbShop']=$this->CI->ListPackModel->listShop();
		$arr_p=$this->CI->security->xss_clean($_POST);
		$bool=true;
		$path=APPLICATION_PATH.'/public/shop_img/';
		
		//duyệt
		if(isset($_POST['btn_approved'])){
			$arrParam = array(
							'status_publish'=>1
							);
			$rs=$this->CI->ListPackModel->edit_new($arrParam,$_GET['id']);
			if($rs){
				$this->data['Mess']="Duyệt thành công";
			}else{
				$this->data['Mess']="Không duyệt được";
			}
		}//end if
		//public
		if(isset($_POST['btn_public'])){
			$arrParam = array(
							'status_publish'=>2
							);
			$rs=$this->CI->ListPackModel->edit_new($arrParam,$_GET['id']);
			if($rs){
				$this->data['Mess']="Public thành công";
			}else{
				$this->data['Mess']="Không public được";
			}
		}//end if
		
		if(isset($_POST['btn_add'])){
			if($arr_p['game_id']==0){
				$this->data['Mess']="Vui lòng chọn Game";
				$bool=false;
			}
			if(trim($arr_p['titles_pack'])==""){
				$this->data['Mess']="Vui lòng nhập tên gói quà";
				$bool=false;
			}
			if($bool){
				
				//uphinh
				
				//preg_match('#\.[^.]+$#', $_FILES['img_file']['name'],$match);
				//$filename=explode(".",$_FILES['img_file']['name']);
				//$fn=str_replace(".".$filename[count($filename)-1],"",$_FILES['img_file']['name']);
				$j_extend_rules = '';
                if(count($arr_p['keyrule'])>0){
                    $extend_rules  =array();
                    foreach($arr_p['keyrule'] as $key=>$val){
                        if(count($arr_p['item_id'][$key])>0){
                            foreach($arr_p['item_id'][$key] as $key1=>$val1){
                               $extend_rules[$val][$val1] = $arr_p['name'][$key][$key1];
                            }
                        }
                    }
                    $j_extend_rules = json_encode($extend_rules);
                }
				$arrParam = array(
							'game_id'=>$arr_p['game_id'],
							'titles_pack'=>$arr_p['titles_pack'],
							'desc_pack'=>$arr_p['desc_pack'],
							'img_pack'=>$arr_p['img_pack'],
							'items'=>$arr_p['js_list_array_items'],
							'cost_pack'=>$arr_p['js_list_array_cost'],
							'extend_rules'=>$j_extend_rules,
							'values_query'=>$arr_p['values_query'],
							'start_date_pack'=>date('Y-m-d H:i:s',strtotime($arr_p['start_date_pack'])),
							'expired_date_pack'=>date('Y-m-d H:i:s',strtotime($arr_p['expired_date_pack'])),
							'num_pack'=>$arr_p['num_pack'],
							'limit_buy_day'=>$arr_p['limit_buy_day'],
							'datecreate'=>date('Y-m-d H:i:s'),
							'user_log'=>$_SESSION['account']['id'],
							'status_publish'=>0
							);
				/*if($_FILES['img_file']['name']!=""){
					move_uploaded_file($_FILES['img_file']['tmp_name'],$path.$_FILES['img_file']['name']);
					$arrParam['img_pack']=$_FILES['img_file']['name'];
				}*/
				$rs=$this->CI->ListPackModel->edit_new($arrParam,$_GET['id']);
				if($rs){
					$this->data['Mess']="Cập nhật thành công";
				}else{
					$this->data['Mess']="Không cập nhật được";
				}
			}//end if
		}//end if
		
		$this->data['getitem'] = $this->CI->ListPackModel->getItem($_GET['id']);
		
        $this->CI->template->write_view('content', 'toolsgame/shopitems/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        $this->CI->ListPackModel->deleteItem($arrParam);
		MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),"Deleted pack ".$arrParam['id'],"user_id:".$_SESSION['account']['id']), "Deleted_pack_game3cay" . date('H'));
        redirect($this->_mainAction);
    }
	
	//show history
	public function history(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$arr_p=$this->CI->security->xss_clean($_GET);
		//$this->data['slbGame']=$this->CI->ListPackModel->listGame();
        $this->data['title'] = 'Lịch sử giao dịch game <i style="color:#093">'.$this->data['slbGame'][$arr_p['game_id']]['app_fullname'].'</i>';
		
		//$this->PermissionUser();
		 $arrFilter = array(
			'game_id' => $arr_p['game_id']
		 );
		 if(isset($_POST['btn_search'])){
			 $arrFilter['mobo_service_id']=$_POST['keyword'];
			 $arrFilter['create_date']=$_POST['date_tracsac'];
			 $this->data['getitem'] = $this->CI->ListPackModel;
			$this->data['listItems'] = $this->CI->ListPackModel->listHistory($arrFilter);
		 }
		
        $this->CI->template->write_view('content', 'toolsgame/shopitems/history', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    } //end func
	
    public function getResponse() {
        return $this->_response;
    }
}