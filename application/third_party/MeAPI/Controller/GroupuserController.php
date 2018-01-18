<?php
class MeAPI_Controller_GroupuserController{
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
		$this->CI->load->MeAPI_Model('GroupuserModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'groupuser/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý Nhóm';
		
		$this->filter();
      	//add new
		if(isset($_GET['action']) && $_GET['action']=="add"){
			if($this->addnew()){
				redirect($this->_mainAction);
			}else{
				$this->data['Mess']="Nhóm này đã tồn tại";
			}
		}
		
        $arrFilter = array(
            'names' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'names' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->GroupuserModel->listItem($arrFilter);
		
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
		$this->data['slbUser'] = $this->CI->GroupuserModel->listUser();
 
        $this->CI->template->write_view('content', 'groupuser/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function addnew(){
		$arr_p=$this->CI->security->xss_clean($_POST);
		$arrParam = array(
			'names'=>$arr_p['names'],
			'notes'=>$arr_p['notes'],
			'datecreate'=>date('Y-m-d H:i:s'),
			'userlog'=>$_SESSION['account']['id']
		);
		$bool=$this->CI->GroupuserModel->checkgroupexist($arr_p['names']);
		if(!$bool){
			$this->CI->GroupuserModel->add_new($arrParam);
			return true;
		}else{
			return false;
		}
	}

	public function deletelist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$reults = $this->CI->GroupuserModel->deletelistitem($arr_p['id']);
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
	
	public function userongroup(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý User';
		
		if(isset($_GET['action']) && $_GET['action']=="add"){
			if($this->addnew()){
				redirect($this->_mainAction);
			}else{
				$this->data['Mess']="Hạng mục này đã tồn tại";
			}
		}
		
        $arrFilter = array(
            'names' => $this->CI->Session->get_session('keyword')
        );

     
        $listItems = $this->CI->GroupuserModel->listItem($arrFilter);
		
   
        $this->data['listItems'] = $listItems;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
		$this->data['slbUser'] = $this->CI->GroupuserModel->listUser();
 		$this->data['slbGroup']=$this->CI->GroupuserModel->getItemId();
		$arrU = array(
            'id_group' => intval($_GET['id_group'])
        );
		$this->data['listUserOnGroup']=$this->CI->GroupuserModel->listUserOnGroup($arrU);
		
        $this->CI->template->write_view('content', 'groupuser/userongroup', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
	}
	public function adduser(){
		$arr_p=$this->CI->security->xss_clean(array_merge($_POST,$_GET));
		$arrParam = array(
			'id_group'=>$arr_p['id_group'],
			'id_user'=>$arr_p['cbo_user'],
			'datecreate'=>date('Y-m-d H:i:s'),
			'status'=>0
		);
		$bool=$this->CI->GroupuserModel->checkexistuser($arrParam);
		if(!$bool){
			$this->CI->GroupuserModel->add_user_to_group($arrParam);
			$mess="Thành công";
			redirect('?control='.$_GET['control'].'&func=userongroup&id_group='.intval($arr_p['id_group']).'&mess='.base64_encode($mess));
		}else{
			$mess="User này đã có trong Group. Vui lòng chọn user khác";
			redirect('?control='.$_GET['control'].'&func=userongroup&id_group='.intval($arr_p['id_group']).'&mess='.base64_encode($mess));
		}
	}
	public function removeuser(MeAPI_RequestInterface $request){
		$arrParam = $this->CI->security->xss_clean(array_merge($_POST,$_GET));
        $this->CI->GroupuserModel->deleteUserOnGroup($arrParam,intval($arrParam['id_group']));
        redirect('?control='.$_GET['control'].'&func=userongroup&id_group='.intval($arrParam['id_group']));
	}
	public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('msv_id', $arrParam['code']);
            $this->CI->Session->unset_session('platform', $arrParam['cbo_platform']);
            $this->CI->Session->unset_session('status', $arrParam['cbo_status']);
			$this->CI->Session->unset_session('service_id', $arrParam['cbo_app']);
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
						
			$result = $this->CI->GroupuserModel->edit_new($arrParam,$arr_p['id']);
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
	
	public function searchgroup(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if(isset($arr_p['account_val']) && $arr_p['account_val']!=""){
			$arrParam = array(
							'username'=>$arr_p['account_val']
                        );
						
			$reults = $this->CI->GroupuserModel->searchuser($arrParam);
			if($reults!=""){
				$f = array(
					'error'=>'0',
					'messg'=>$reults
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
					'messg'=>'Không bỏ trống'
				);
		}
        echo json_encode($f);
        exit();
	}//end function
	
    public function getResponse() {
        return $this->_response;
    }
}
