<?php
class MeAPI_Controller_GamechecklisttempController{
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
		$this->CI->load->MeAPI_Library('Libcommon');
		$this->CI->load->MeAPI_Model('CategoriesGameModel');
		$this->CI->load->MeAPI_Model('GroupuserModel');
		$this->CI->load->MeAPI_Model('GrandRequestUserGameModel');
		$this->CI->load->MeAPI_Model('RequestGameModel');
		$this->CI->load->MeAPI_Model('GamechecklisttempModel');
		$this->CI->load->MeAPI_Model('TemplatechecklistModel');
		
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
		$this->data['loadgame']=$this->CI->TemplatechecklistModel->listGame();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
		$this->data['obj_categories']=$this->CI->CategoriesGameModel;
    }
	public function noaccess(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
		$this->data['title'] = 'Noaccess';
        $this->CI->template->write_view('content', 'gamechecklisttemp/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$arr_p = $this->CI->security->xss_clean($_GET);
        $this->data['title'] = 'CHECK LIST';
		$this->filter();
		$this->data['slbUser'] = $this->CI->TemplatechecklistModel->listUser(); 
		//$this->data['categories_parent'] = $this->CI->CategoriesGameModel->listCategorisParentInTemp($arr_p['id_game']);
		//$this->CI->template->set_template('blank');
		$status=$this->CI->GamechecklisttempModel->CheckStatusGame($arr_p['id_game']);
		if($status==1){
			//$this->CI->template->set_template('blank');
			$this->CI->template->write_view('content', 'gamechecklisttemp/noaccess_status', $this->data);
        	$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
			return;
		}
        $this->CI->template->write_view('content', 'gamechecklisttemp/index', $this->data);
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
	public function ajaxupdateresultuser(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id_game']>0){
			$where = array(
                'id_game'=>$arr_p['id_game'],
				'id_categories'=>$arr_p['id_cate'],
				'id_request'=>$arr_p['id_request']
            );
			$reults = $this->CI->GamechecklisttempModel->updateresultchecklistuser($where,$arr_p);
			//save history user
			$arr=array(
				'id_request'=>$arr_p['id_request'],
				'id_game'=>$arr_p['id_game'],
				'type'=>$arr_p['types'],
				'type_account'=>'user',
				'status_user'=>$arr_p['client_result'],
				'notes_user'=>$arr_p['client_notes'],
				'status_admin'=>'',
				'notes_admin'=>'',
				'user_check'=>$arr_p['user_check'],
				'admin_check'=>'',
				'date_user_update'=>date('y-m-d H:i:s'),
				'date_admin_update'=>'',
			);
			$log=$this->CI->GamechecklisttempModel->SaveHistory($arr);
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
	
	public function ajaxupdateresultadmin(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id_game']>0){
			$where = array(
                'id_game'=>$arr_p['id_game'],
				'id_categories'=>$arr_p['id_cate'],
				'id_request'=>$arr_p['id_request']
            );
			$reults = $this->CI->GamechecklisttempModel->updateresultchecklistadmin($where,$arr_p);
			//save history admin
			$arr=array(
				'id_request'=>$arr_p['id_request'],
				'id_game'=>$arr_p['id_game'],
				'type'=>$arr_p['types'],
				'type_account'=>'admin',
				'status_user'=>'',
				'notes_user'=>'',
				'status_admin'=>$arr_p['admin_result'],
				'notes_admin'=>$arr_p['admin_notes'],
				'user_check'=>'',
				'admin_check'=>$arr_p['admin_check'],
				'date_user_update'=>'',
				'date_admin_update'=>date('y-m-d H:i:s'),
			);
			$log=$this->CI->GamechecklisttempModel->SaveHistory($arr);
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
	
	public function refeshresultuser(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id_game']>0){
			$where = array(
                'id_game'=>$arr_p['id_game'],
				'id_categories'=>$arr_p['id_cate'],
				'id_request'=>$arr_p['id_request']
            );
			$data['result_client'] = $this->CI->GamechecklisttempModel->getItem($where);
			$data['types']=$arr_p['types'];
			$data['idunique']=$arr_p['idunique'];
			$data['slbUser'] = $this->CI->TemplatechecklistModel->listUser(); 
			if($data['result_client']){
				$f = array(
					'error'=>'0',
					'info_status'=>$this->CI->load->view('gamechecklisttemp/cbo_result_clients', $data, true),
					'info_img'=>$this->CI->load->view('gamechecklisttemp/show_img_user', $data, true),
					'info_notes'=>$data['result_client']['notes_'.$arr_p['types']],
					'info_date'=>$data['result_client']['dateusercheck_'.$arr_p['types']],
					'info_user'=>"<strong>".$data['slbUser'][$data['result_client']['usercheck_'.$arr_p['types']]]['username']."</strong>",'info_admin_status'=>$this->CI->load->view('gamechecklisttemp/cbo_result_admin', $data, true),'info_admin_img'=>$this->CI->load->view('gamechecklisttemp/show_img_admin', $data, true),'info_admin_notes'=>$data['result_client']['notes_admin_'.$arr_p['types']],'info_admin_log'=>$data['slbUser'][$data['result_client']['admincheck']]['username'],'info_admin_date'=>$data['result_client']['dateadmincheck_'.$arr_p['types']]);
					
			}else{
				$f = array(
					'error'=>'1',
					'messg'=>'Error'
				);
				
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Error System'
            );
			
        }
		/*$this->CI->template->write_view('content', 'gamechecklist/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/
        echo json_encode($f);
        exit();
	}
	
	public function statisticalsub(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		if($arr_p['id_game']>0){
			$where = array(
                'id_game'=>$arr_p['id_game'],
				'id_categories'=>$arr_p['id_cate']
            );
			$count=0;
			$i=0;
			
			$count_android=0;
			$count_ios=0;
			$count_wp=0;
			$count_pc=0;
			$count_web=0;
			$count_events=0;
			$count_systems=0;
			$count_orther=0;
			
			$status_pass= "<i style='color:#008000'>PASS</i>";
			$status_fail= "<i style='color:#E00449'>FAIL</i>";
			
			$kq = $this->CI->GamechecklisttempModel->statisticalsub($where);
			$html_view="";
			
			// biến tính tổng số user đã check
			$dem_user=0;
			// biến tính tổng số admin đã check
			$dem_admin=0;
			
			foreach($kq as $item){
				$c=$item['types']=="" || $item['types']==NULL?0:(int)$item['types'];
				$count=$c+$count;
				$html="";
				//tinh loai yeu cau
				if($item['android']=="true"){
					$count_android = $item['android']=="true"?1:0;
					$count_android = $i + $count_android;
					
					if($item['result_android']==""){
						//chưa checklist
						$work_android = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_user++;
						if($item['result_android']=="Pass"){
							$work_android = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_android']=="Fail"){
							$work_android = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}else{
							$work_android = "<i style='color:#076FBB'>DONE WORK</i> -> ???";
						}
					}
					//ket qua admin
					if($item['result_admin_android']==""){
						//chưa checklist
						$work_admin_android = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_admin++;
						if($item['result_admin_android']=="Pass"){
							$work_admin_android = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_android']=="Fail"){
							$work_admin_android = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}
					}
					$html=$html."<strong>Android</strong>_$count_android  [ User : $work_android  ] [ Admin: $work_admin_android ]<br/>";
					
					
				}
				
				if($item['ios']=="true"){
					$count_ios = $item['ios']=="true"?1:0;
					$count_ios = $i + $count_ios;
					if($item['result_ios']==""){
						//chưa checklist
						$work_ios = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_user++;
						if($item['result_ios']=="Pass"){
							$work_ios = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_ios']=="Fail"){
							$work_ios = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}else{
							$work_ios = "<i style='color:#076FBB'>DONE WORK</i> -> ???";
						}
					}
					//ket qua admin
					if($item['result_admin_ios']==""){
						//chưa checklist
						$work_admin_ios = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_admin++;
						if($item['result_admin_ios']=="Pass"){
							$work_admin_ios = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_ios']=="Fail"){
							$work_admin_ios = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}
					}
					$html=$html."<strong>IOS</strong>_$count_ios  [ User : $work_ios ] [ Admin: $work_admin_ios ]<br/>";
					
				}
				
				if($item['wp']=="true"){
					$count_wp = $item['wp']=="true"?1:0;
					$count_wp = $i + $count_wp;
					
					if($item['result_wp']==""){
						//chưa checklist
						$work_wp = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_user++;
						if($item['result_wp']=="Pass"){
							$work_wp = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_wp']=="Fail"){
							$work_wp = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}else{
							$work_wp = "<i style='color:#076FBB'>DONE WORK</i> -> ???";
						}
					}
					//ket qua admin
					if($item['result_admin_wp']==""){
						//chưa checklist
						$work_admin_wp = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_admin++;
						if($item['result_admin_wp']=="Pass"){
							$work_admin_wp = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_wp']=="Fail"){
							$work_admin_wp = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}
					}
					$html=$html."<strong>WP</strong>_$count_wp  [ User : $work_wp] [ Admin : $work_admin_wp ]<br/>";
					
				}
				
				if($item['pc']=="true"){
					$count_pc = $item['pc']=="true"?1:0;
					$count_pc = $i + $count_pc;
					
					if($item['result_pc']==""){
						//chưa checklist
						$work_pc = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_user++;
						if($item['result_pc']=="Pass"){
							$work_pc = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_pc']=="Fail"){
							$work_pc = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}else{
							$work_pc = "<i style='color:#076FBB'>DONE WORK</i> -> ???";
						}
					}
					//ket qua admin
					if($item['result_admin_pc']==""){
						//chưa checklist
						$work_admin_pc = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_admin++;
						if($item['result_admin_pc']=="Pass"){
							$work_admin_pc = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_admin_pc']=="Fail"){
							$work_admin_pc = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}
					}
					$html=$html."<strong>PC</strong>_$count_pc   [ User : $work_pc ] [ Admin: $work_admin_pc ]<br/>";
					
				}
				
				if($item['web']=="true"){
					$count_web = $item['web']=="true"?1:0;
					$count_web = $i + $count_web;
					
					if($item['result_web']==""){
						//chưa checklist
						$work_web = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_user++;
						if($item['result_web']=="Pass"){
							$work_web = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_web']=="Fail"){
							$work_web = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}else{
							$work_web = "<i style='color:#076FBB'>DONE WORK</i> -> ???";
						}
					}
					//ket qua admin
					if($item['result_admin_web']==""){
						//chưa checklist
						$work_admin_web = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_admin++;
						if($item['result_admin_web']=="Pass"){
							$work_admin_web = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_admin_web']=="Fail"){
							$work_admin_web = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}
					}
					$html=$html."<strong>Web</strong>_$count_web  [ User : $work_web ] [ Admin : $work_admin_web ]<br/>";
					
					
				}
				if($item['events']=="true"){
					$count_events = $item['events']=="true"?1:0;
					$count_events = $i + $count_events;
					
					if($item['result_events']==""){
						//chưa checklist
						$work_events = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_user++;
						if($item['result_events']=="Pass"){
							$work_events = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_events']=="Fail"){
							$work_events = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}else{
							$work_events = "<i style='color:#076FBB'>DONE WORK</i> -> ???";
						}
					}
					//ket qua admin
					if($item['result_admin_events']==""){
						//chưa checklist
						$work_admin_events = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_admin++;
						if($item['result_admin_events']=="Pass"){
							$work_admin_events = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_admin_events']=="Fail"){
							$work_admin_events = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}
					}
					$html=$html."<strong>Events</strong>_$count_events   [ User : $work_events ] [ Admin : $work_admin_events ]<br/>";
					
					
				}
				if($item['systems']=="true"){
					$count_systems = $item['systems']=="true"?1:0;
					$count_systems = $i + $count_systems;
					
					if($item['result_systems']==""){
						//chưa checklist
						$work_systems = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_user++;
						if($item['result_systems']=="Pass"){
							$work_systems = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_systems']=="Fail"){
							$work_systems = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}else{
							$work_systems = "<i style='color:#076FBB'>DONE WORK</i> -> ???";
						}
					}
					//ket qua admin
					if($item['result_admin_systems']==""){
						//chưa checklist
						$work_admin_systems = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_admin++;
						if($item['result_admin_systems']=="Pass"){
							$work_admin_systems = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_admin_systems']=="Fail"){
							$work_admin_systems = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}
					}
					$html=$html."<strong>Systems</strong>_$count_systems   [ User : $work_systems ] [ Admin : $work_admin_systems ]<br/>";
					
				}
				if($item['orther']=="true"){
					$count_orther = $item['orther']=="true"?1:0;
					$count_orther = $i + $count_orther;
					
					if($item['result_orther']==""){
						//chưa checklist
						$work_orther = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_user++;
						if($item['result_orther']=="Pass"){
							$work_orther = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_orther']=="Fail"){
							$work_orther = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}else{
							$work_orther = "<i style='color:#076FBB'>DONE WORK</i> -> ???";
						}
					}
					//ket qua admin
					if($item['result_admin_orther']==""){
						//chưa checklist
						$work_admin_orther = "<i style='color:#E00449'>NOTWORK</i>";
					}else{
						//đã checklist
						$dem_admin++;
						if($item['result_admin_orther']=="Pass"){
							$work_admin_orther = "<i style='color:#076FBB'>DONE WORK</i> -> $status_pass";
						}elseif($item['result_admin_orther']=="Fail"){
							$work_admin_orther = "<i style='color:#076FBB'>DONE WORK</i> -> $status_fail";
						}
					}
					$html=$html."<strong>Other</strong>_$count_orther   [ User : $work_orther ] [ Admin: $work_admin_orther ]<br/>";
					
				}
				$i++;
				$html_view=$html_view."<strong style='color:#8A4343;'>".$item['titles']."</strong><br/>".$html."<hr/>";
			}//end for
			
			//"Android:$count_android $status_android , IOS:$count_ios $status_ios, WP:$count_wp $status_wp, PC:$count_pc $status_pc, Config:$count_web $status_web, Events:$count_events $status_events, Systems:$count_systems $status_systems, Other:$count_orther $status_orther";
			
			$count_u=$count_android + $count_ios + $count_wp + $count_pc + $count_web + $count_events + $count_orther;
			if($kq){
				$f = array(
					'error'=>'0',
					'count_tt'=>$count,
					'count_android'=>$count_android,
					'count_ios'=>$count_ios,
					'count_wp'=>$count_wp,
					'count_pc'=>$count_pc,
					'count_web'=>$count_web,
					'count_events'=>$count_events,
					'count_systems'=>$count_systems,
					'count_orther'=>$count_orther,
					'html'=>"<h1>Số yêu cầu:$count</h1>".$html_view,
					'html_compact'=>'User :'.$dem_user.'/'.$count.' Admin : '.$dem_admin.'/'.$count
				);
			}else{
				$f = array(
					'error'=>'1',
					'messg'=>'Error:'.$count
				);
				
			}
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Error System'
            );
			
        }
		/*echo "<h1>Total:$count</h1>".$html_view;
		$this->CI->template->write_view('content', 'gamechecklisttemp/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());*/
        echo json_encode($f);
        exit();
	} //end func statisticalsub
	
	//google charts
	public function googlecharts(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$arr_p = $this->CI->security->xss_clean($_GET);
        $this->data['title'] = 'BIỂU ĐỒ THỐNG KÊ HẠNG MỤC';
		$this->data['slbUser'] = $this->CI->TemplatechecklistModel->listUser(); 
		$this->data['categories_child'] = $this->CI->CategoriesGameModel->GetCateChildGame($arr_p['id_game'],$arr_p['id_parent']);
		$this->data['namecate']=$arr_p['name'];
		$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'gamechecklisttemp/googlecharts', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	
	//thông ke ?:Pass,?Fail,?:Pending,?:Cancel,?:Inprocess,?:None
	// của User và Admin
	public function report_request(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		
		// dem user
		$c_pass=0;
		$c_fail=0;
		$c_cancel=0;
		$c_inprocess=0;
		$c_pending=0;
		$c_none=0;
		//dem admin
		$c_pass_ad=0;
		$c_fail_ad=0;
		$c_none_ad=0;
		
		if($arr_p['id_game']>0){
			$where = array(
                'id_game'=>$arr_p['id_game'],
				'id_categories'=>$arr_p['id_cate'],
				'group'=>$arr_p['cbo_group']
            );
			$kq = $this->CI->GamechecklisttempModel->statisticalsub($where);
			foreach($kq as $item){
				if($item['android']=="true"){
					switch($item['result_android']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_android']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if android
				if($item['ios']=="true"){
					switch($item['result_ios']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_ios']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if ios
				if($item['wp']=="true"){
					switch($item['result_wp']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_wp']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if wp
				if($item['pc']=="true"){
					switch($item['result_pc']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_pc']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if pc
				if($item['web']=="true"){
					switch($item['result_web']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_web']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if web
				if($item['events']=="true"){
					switch($item['result_events']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_events']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if events
				if($item['systems']=="true"){
					switch($item['result_systems']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_systems']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if systems
				if($item['orther']=="true"){
					switch($item['result_orther']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_orther']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if orther
				
			}//end for
			
			if($kq){
				$f = array(
					'error'=>'0',
					'Pass_User'=>$c_pass,
					'Fail_User'=>$c_fail,
					'Cancel_User'=>$c_cancel,
					'Pending_User'=>$c_pending,
					'Inprocess_User'=>$c_inprocess,
					'None_User'=>$c_none,
					'Pass_Admin'=>$c_pass_ad,
					'Fail_Admin'=>$c_fail_ad,
					'None_Admin'=>$c_none_ad,
					'html'=>"<strong>User</strong> (<i style='color:#215A1E'>$c_pass:Pass</i>, <i style='color:#AB0606'>$c_fail:Fail</i>, <i style='color:#0E060C'>$c_cancel:Cancel</i>, $c_pending:Pending, <i style='color:#655A09'>$c_inprocess:Inprocess</i>, $c_none:None) - <strong>Admin</strong> (<i style='color:#215A1E'>$c_pass_ad:Pass</i>, <i style='color:#AB0606'>$c_fail_ad:Fail</i>, $c_none_ad:None)"
				);
			}else{
				$f = array(
					'error'=>'1',
					'messg'=>'Error:'
				);
				
			}
			
		}else{
			$f = array(
					'error'=>'1',
					'messg'=>'Error:'
				);
		}//end if
		
		echo json_encode($f);
        exit();
		
	}//end func
	
	public function report_request_plus(){
		$arr_p=$this->CI->security->xss_clean($_GET);
		
		// dem user
		$c_pass=0;
		$c_fail=0;
		$c_cancel=0;
		$c_inprocess=0;
		$c_pending=0;
		$c_none=0;
		//dem admin
		$c_pass_ad=0;
		$c_fail_ad=0;
		$c_none_ad=0;
		
		if($arr_p['id_game']>0){
			$where = array(
                'id_game'=>$arr_p['id_game'],
				'id_categories'=>$arr_p['id_cate'],
				'group'=>$arr_p['cbo_group']
            );
			$kq = $this->CI->GamechecklisttempModel->statisticalsub_plus($where);
			foreach($kq as $item){
				if($item['android']=="true"){
					switch($item['result_android']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_android']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if android
				if($item['ios']=="true"){
					switch($item['result_ios']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_ios']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if ios
				if($item['wp']=="true"){
					switch($item['result_wp']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_wp']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if wp
				if($item['pc']=="true"){
					switch($item['result_pc']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_pc']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if pc
				if($item['web']=="true"){
					switch($item['result_web']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_web']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if web
				if($item['events']=="true"){
					switch($item['result_events']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_events']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if events
				if($item['systems']=="true"){
					switch($item['result_systems']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_systems']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if systems
				if($item['orther']=="true"){
					switch($item['result_orther']){
						case "Pass": $c_pass++; break;
						case "Fail": $c_fail++; break;
						case "Cancel": $c_cancel++; break;
						case "Pending": $c_pending++; break;
						case "InProccess": $c_inprocess++; break;
						default: $c_none++; break;
					}//end switch
					switch($item['result_admin_orther']){
						case "Pass": $c_pass_ad++; break;
						case "Fail": $c_fail_ad++; break;
						default: $c_none_ad++; break;
					}//end switch
				}//end if orther
				
			}//end for
			
			if($kq){
				$f = array(
					'error'=>'0',
					'Pass_User'=>$c_pass,
					'Fail_User'=>$c_fail,
					'Cancel_User'=>$c_cancel,
					'Pending_User'=>$c_pending,
					'Inprocess_User'=>$c_inprocess,
					'None_User'=>$c_none,
					'Pass_Admin'=>$c_pass_ad,
					'Fail_Admin'=>$c_fail_ad,
					'None_Admin'=>$c_none_ad,
					'html'=>"<strong>User</strong> (<i style='color:#16CA0C'>$c_pass:Pass</i>, <i style='color:#BF7676'>$c_fail:Fail</i>, <i style='color:#0E060C'>$c_cancel:Cancel</i>, $c_pending:Pending, <i style='color:#D8C113'>$c_inprocess:Inprocess</i>, $c_none:None) - <strong>Admin</strong> (<i style='color:#16CA0C'>$c_pass_ad:Pass</i>, <i style='color:#BF7676'>$c_fail_ad:Fail</i>, $c_none_ad:None)"
				);
			}else{
				$f = array(
					'error'=>'1',
					'messg'=>'Error:'
				);
				
			}
			
		}else{
			$f = array(
					'error'=>'1',
					'messg'=>'Error:'
				);
		}//end if
		
		echo json_encode($f);
        exit();
		
	}//end func
	
	//ghi nhat ky
	public function logchecklist(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$arr_p = $this->CI->security->xss_clean($_GET);
        $this->data['title'] = 'NHẬT KÝ CHECKLIST';
		$this->data['slbUser'] = $this->CI->TemplatechecklistModel->listUser(); 
		
		//show
		$arr_p=$this->CI->security->xss_clean($_GET);
			$arr=array(
				'id_request'=>$arr_p['id_request'],
				'id_game'=>$arr_p['id_game'],
				'type'=>$arr_p['type'],
				'type_account'=>$arr_p['type_account']
			);
		$this->data['listLog'] = $this->CI->GamechecklisttempModel->listLogChecklist($arr);
		$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'gamechecklisttemp/log', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }//end func
	
	
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
	
	
	//send mail
	public function sendmail(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
		$arr_p = $this->CI->security->xss_clean(array_merge($_GET,$_POST));
        $this->data['title'] = 'GỬI MAIL';
		$this->data['slbUser'] = $this->CI->TemplatechecklistModel->listUser(); 
		$this->data['loadgame']=$this->CI->TemplatechecklistModel->listGame();
		$this->data['Game']=$this->data['loadgame'][$arr_p['id_game']]['app_fullname'];
		//show
			$arr=array(
				'id_request'=>$arr_p['id_request'],
				'id_game'=>$arr_p['id_game'],
				'id_template'=>$arr_p['id_template'],
				'type'=>$arr_p['type'],
				'type_account'=>$arr_p['type_account'],
				'idp1'=>$arr_p['idp1'],
				'idp2'=>$arr_p['idp2'],
				'c1'=>base64_decode($arr_p['c1']),
				'c2'=>base64_decode($arr_p['c2']),
				'c3'=>base64_decode($arr_p['c3'])
			);
			$nhomthuchien = $this->CI->TemplatechecklistModel->CreateControlGroup($arr_p['id_game'],$arr_p['id_request'],0);
			$nhomhotro = $this->CI->TemplatechecklistModel->CreateControlGroup($arr_p['id_game'],$arr_p['id_request'],1);
			$this->data['nhomthuchien'] = $nhomthuchien;
			$this->data['nhomhotro'] = $nhomhotro;
			$this->data['urls'] = "http://ginside.mobo.vn/?control=gamechecklisttemp&func=index&id_game=".$arr['id_game']."&module=all#".$arr['idp1']."-".$arr['idp2'];
			$this->data['body']="<table border=1 cellpadding='20' cellspacing='0' height='100%' width='100%'>
				<tr>
					<td><strong style='color:#8206A9'>Hạng mục</strong></td>
					<td>".$arr['c1']." <br/> __ ".$arr['c2']."</td>
				</tr>
				<tr>
					<td><strong style='color:#8206A9'>Yêu cầu (".$arr['type'].")</strong></td>
					<td>".$arr['c3']."</td>
				</tr>
				<tr>
					<td><strong style='color:#8206A9'>Nội dung</strong></td>
					<td>".nl2br($arr_p['txt_body'])."</td>
				</tr>
				<tr>
					<td><strong style='color:#8206A9'>Nhóm thực hiện</strong></td>
					<td>" . $nhomthuchien . "</td>
				</tr>
                                <tr>
					<td><strong style='color:#8206A9'>Nhóm hỗ trợ</strong></td>
					<td>" . $nhomhotro . "</td>
				</tr>
				<tr>
					<td colspan='2'><i style='color:#07A924'><a href='http://ginside.mobo.vn/?control=gamechecklisttemp&func=index&id_game=".$arr['id_game']."&id_template=".$arr['id_template']."&module=all#".$arr['idp1']."-".$arr['idp2']."-".$arr['id_request']."-".$arr['type']."'>Bấm vào đây để vào Checklist</a></i></td>
				</tr>
			</table>";
		//submit
		if(isset($arr_p['action']) && $arr_p['action']=="send"){
			$rs_user=$this->CI->GamechecklisttempModel->GetUserSendMail($arr_p['id_request'],$arr_p['id_game']);
			$a_rs = array();
            if($rs_user==true && is_array($rs_user)){
                foreach($rs_user as $v){
                    $a_rs[$this->data['slbUser'][$v['id_user']]['username']] = $this->data['slbUser'][$v['id_user']]['username'];
                }
            }
			$a_userOnGroupCC = array();
			if(count($arr_p['chk_groupcc'])>0){
				$userOnGroupCC = $this->CI->GamechecklisttempModel->userOnGroup($arr_p['chk_groupcc']);
				if($userOnGroupCC==true && is_array($userOnGroupCC)){
					foreach($userOnGroupCC as $v){
						$a_userOnGroupCC[$this->data['slbUser'][$v['id_user']]['username'].'@mecorp.vn'] = $this->data['slbUser'][$v['id_user']]['username'].'@mecorp.vn';
					}
				}
			}
			
            $a_userOnGroup = array();
			if(count($arr_p['chk_group'])>0){
				$userOnGroup = $this->CI->GamechecklisttempModel->userOnGroup($arr_p['chk_group']);
				if($userOnGroup==true && is_array($userOnGroup)){
					foreach($userOnGroup as $v){
						$a_userOnGroup[$this->data['slbUser'][$v['id_user']]['username']] = $this->data['slbUser'][$v['id_user']]['username'];
					}
				}
			}
            $rs = array_merge($a_rs,$a_userOnGroup);
			$json="";
			if(count($rs) > 0){
				foreach($rs as $item){
					$useraccount = $item;//$this->data['slbUser'][$item['id_user']]['username'];
					
					$json=$this->CI->Libcommon->SendAlertCheclist($arr_p['id_request'],$_POST['txt_sub'],$this->data['body'],"$useraccount@mecorp.vn",json_encode($a_userOnGroupCC));
					
				}//end for
			}//end if
			if(!empty($json) || $json!=""){
				$ifo=json_decode($json); //{"code":3,"message":1}
				if($ifo->{'code'}==0){
					$str_info="<strong style='color:#0AA017'>Gửi mail thành công</strong>";
				}else{
					$str_info="<strong style='color:red'>Error Send mail !!!</strong><br/>".$json;
				} //end if
			}//end if
			
			$this->data['Mess']=$str_info;
		}
		$this->data['groups']= $this->CI->GroupuserModel->listItem(NULL);
		$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'gamechecklisttemp/sendmail', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }//end func
	
	
    public function getResponse() {
        return $this->_response;
    }
}
