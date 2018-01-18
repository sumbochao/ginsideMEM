<?php
class MeAPI_Controller_TemplateController{
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
		$this->CI->load->MeAPI_Model('TemplateModel');
		$this->CI->load->MeAPI_Model('ProjectsModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
	public function getdevice(){
		$device=preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$_SERVER['HTTP_USER_AGENT'])==0?"desktop":"mobile";
		return $device;
	}
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'template/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý hạng mục';
		
		$this->filter();
      	//add new
		if(isset($_GET['action']) && $_GET['action']=="add"){
			if($this->addnew()){
				$mess="Thành công";
				redirect('?control='.$_GET['control'].'&func=index&mess='.base64_encode($mess));
				//$this->data['Mess']="OK";
			}else{
				$mess="Template này đã tồn tại";
				redirect('?control='.$_GET['control'].'&func=index&mess='.base64_encode($mess));
				//$this->data['Mess']="Template này đã tồn tại";
			}
		}
		
        $arrFilter = array(
            'template_name' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'template_name' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->TemplateModel->listItem($arrFilter);
		
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
 
        $this->CI->template->write_view('content', 'template/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function addnew(){
		$arr_p=$this->CI->security->xss_clean($_POST);
		$arrParam = array(
			'template_name'=>$arr_p['template_name'],
			'notes'=>$arr_p['notes'],
			'datecreate'=>date('Y-m-d H:i:s'),
			'userlog'=>$_SESSION['account']['id']
		);
		
		$bool=$this->CI->TemplateModel->checknamesexist($arr_p['template_name']);
		if(!$bool){
			$this->CI->TemplateModel->add_new($arrParam);
			return true;
		}else{
			return false;
		}
	}

	public function deletelist(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id']>0){
			$reults = $this->CI->TemplateModel->deletelistitem($arr_p['id']);
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
                            'template_name'=>$arr_p['template_name'],
							'notes'=>$arr_p['notes_e']
                        );
						
			$result = $this->CI->TemplateModel->edit_new($arrParam,$arr_p['id']);
			$arr_log=array(
						"username"=>$_SESSION['account']['id'],
						"timesmodify"=>date('Y-m-d H:i:s'),
						"actions"=>"update_categories",
						"logs"=>json_encode($arrParam),
						"urls"=>$_SERVER['REQUEST_URI'],
						"ipaddress"=>$_SERVER['REMOTE_ADDR'],
						"browser"=>$_SERVER['HTTP_USER_AGENT'],
						"device"=>$this->getdevice(),
						"sessionuser"=>session_id(),
						"tables"=>"tbl_template",
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
	
	public function updatestatus(){
		$arr_p = $this->CI->security->xss_clean($_GET);
		if($arr_p['id'] > 0){
			$arrFill=array(
				'id'=>intval($arr_p['id']),
				'status'=>intval($arr_p['status'])
			);
            $result=$this->CI->TemplateModel->updatestatus($arrFill);
			$data['status']=$this->CI->TemplateModel->getItem(intval($arr_p['id']));
            $f = array(
                'error'=>'0',
                'messg'=>'OK',
                'html'=>$this->CI->load->view('template/status', $data, true)
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
