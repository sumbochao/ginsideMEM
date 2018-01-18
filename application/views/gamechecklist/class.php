<?php
class ViewGroup extends GroupuserModel{
						private $id_request=0;
						private $is=0;
						static private $arr_id_group="";
						static public $type_user_log="admin";
						
						
						public function __construct($id_request,$is) {
							$this->id_request=$id_request;
							$this->is=$is;
							if (!$this->db_slave)
								$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
								//kiem tra quyen user
								$record['data']=$this->GroupuserModel->ReturnGroup($_SESSION['account']['id']);							
								foreach($record['data'] as $val){
									$r.=$val['id_group'].",";
								}
								
								$d=explode(',',$r);
								
								unset($d[count($d)-1]);
								$typeu="";
								//nhóm có id = -1 là Administrator
								$key_admin=$this->array_isearch("-1",$d);
								
								if(count($key_admin)==0){
									// khac 1 là user 1 la admin
										$typeu="user";
										ViewGroup::$arr_id_group=implode(',',$d);
								}else{
										$typeu="admin";
								}
								 
								echo ViewGroup::$type_user_log=$typeu;
								
						}
						public function array_isearch($str, $array) {
						  $found = array();
						  foreach($array as $k => $v)
							if(strtolower($v) == strtolower($str)) $found[] = $k;
						  return $found;
						}
						//tao select control
						public function CreateControlGroup($id_request,$is){
								$Gn=$this->GroupuserModel->getItemId();
								
								$this->db_slave->select(array('*'));
								$this->db_slave->where('id_request',$id_request);
								if($is==0){
									$data = $this->db_slave->get('tbl_grand_request_group');
								}else{
									$data = $this->db_slave->get('tbl_grand_request_group_support');
								}
								if (is_object($data)) {
											$result = $data->result_array();
								}
								if(count($result)>0){
									echo "<select name='cbo_group_main_$id_request' id='cbo_group_main_$id_request' style='width:80px;height:100px;border:none;background:transparent;font-size:9px;' multiple='multiple'>";
									 foreach($result as $v){
										 echo "<option value='".$v['id_group']."'>".$Gn[$v['id_group']]['names']."</option>";
									 }//en for
									 echo "</section>";
								}
						}
						//hàm lấy thông tin bảng result
						public function getResultCheckList($id_template,$id_game,$id_categories,$id_request){
							$sql="select * from tbl_result_game_template_checklist where  id_template=$id_template and id_game=$id_game and id_categories=$id_categories and id_request=$id_request limit 1";
							$data=$this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->row_array();
								return $result;
							}
						}//end func
						public function showimg($value,$id,$type){
							if($type=="user"){
								switch($value){
									case "None":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick2.png'>"; 
									break;
									case "Pass":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick.png' style='width:14px;height:14px' />"; 
									break;
									case "Fail":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png' style='width:14px;height:14px' />"; 
									break;
									case "Pending":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/wait.png' style='width:14px;height:14px' />"; 
									break;
									case "Cancel":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png'>"; 
									break;
									case "InProccess":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/ajax-loader.gif'>"; 
									break;
									default:
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick2.png'>"; 
									break;
								}
							}else{
								switch($value){
									case "None":
									echo "<img boder='0' id='admin_img_status_$id' src='".base_url()."assets/img/tick2.png'>"; 
									break;
									case "Pass":
									echo "<img boder='0' id='admin_img_status_$id' src='".base_url()."assets/img/tick.png' style='width:14px;height:14px' />"; 
									break;
									case "Fail":
									echo "<img boder='0' id='admin_img_status_$id' src='".base_url()."assets/img/error.png' style='width:14px;height:14px' />"; 
									break;
									default:
									echo "<img boder='0' id='admin_img_status_$id' src='".base_url()."assets/img/tick2.png'>"; 
									break;
								}
							}
						}
						//show hang muc con, theo hang muc cha
						public function ShowCateloriesChild($id){
							
							if(ViewGroup::$type_user_log=="user"){
								$sql_store="call showcatechildUser('".$id."','".ViewGroup::$arr_id_group."')";
								$sql="select cate.* from tbl_categories as cate INNER JOIN tbl_request as res on(cate.id=res.id_categories) where res.id in(select gr.id_request from tbl_grand_request_group as gr JOIN tbl_grand_request_group_support as support on (gr.id_request = support.id_request) where gr.id_group in(".ViewGroup::$arr_id_group.") or support.id_group in(".ViewGroup::$arr_id_group.") ) and cate.id_parrent='".$id."' and cate.id_template=".$_GET['id_template']." and cate.status=0 GROUP BY cate.id ORDER BY cate.`order` asc";
								/*$sql="select cate.* 
from tbl_categories as cate INNER JOIN tbl_request as res on(cate.id=res.id_categories) 
where EXISTS (select 1  from tbl_grand_request_group as gr JOIN tbl_grand_request_group_support as support 
on (gr.id_request = support.id_request) where (gr.id_group in(".$arr_id_group.") or support.id_group in(".$arr_id_group.")) and res.id= gr.id_request limit 1) and cate.id_parrent='".$id."' and status=0 ORDER BY `order` asc";*/
							
							}else{
								$sql_store="call showcatechild('".$id."')";
								$sql="select cate.* from tbl_categories as cate where cate.id_parrent='".$id."' and cate.id_template=".$_GET['id_template']." and status=0 ORDER BY `order` asc";
								
							}
							
							$data = $this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->result_array();
								return $result;
							}else{
								return FALSE;
							}
						}//end func
						
						//show yeu cau theo hang muc, phan quyen hien thi user va admin
						public function listC1($idcatelogries){
							//phân quyền admin va user
							if(ViewGroup::$type_user_log=="user"){
								//$sql="select cl.* from tbl_template_checklist as cl INNER JOIN tbl_categories as cate on(cl.id_categories = cate.id) where cl.id_request in(select gr.id_request from tbl_grand_request_group as gr JOIN tbl_grand_request_group_support as support on (gr.id_request = support.id_request) where gr.id_group in(".ViewGroup::$arr_id_group.") or support.id_group in(".ViewGroup::$arr_id_group.") GROUP BY gr.id_request) and cl.id_categories=".$idcatelogries." and cate.id_template=".$_GET['id_template']." GROUP BY cl.id_request ORDER BY cate.`order` asc";
								$sql="select cl.* from tbl_template_checklist as cl INNER JOIN tbl_categories as cate on(cl.id_categories = cate.id) INNER JOIN tbl_request as res  where cl.id_request in(select gr.id_request from tbl_grand_request_group as gr JOIN tbl_grand_request_group_support as support on (gr.id_request = support.id_request) where gr.id_group in(".ViewGroup::$arr_id_group.") or support.id_group in(".ViewGroup::$arr_id_group.") GROUP BY gr.id_request) and cl.id_categories=".$idcatelogries." and cate.id_template=".$_GET['id_template']." and res.id_categories=".$idcatelogries." and res.id=cl.id_request GROUP BY cl.id_request ORDER BY cate.`order` asc";
							}else{
								//$sql_store="CALL showrequest(".$idcatelogries.")";
								$sql="select cl.* from tbl_template_checklist as cl INNER JOIN tbl_categories as cate on(cl.id_categories = cate.id) INNER JOIN tbl_request as res where cl.id_categories=".$idcatelogries." and cate.id_template=".$_GET['id_template']." and res.id_categories=".$idcatelogries." and res.id=cl.id_request ORDER BY cate.`order` asc";
							}
							//echo $sql;
							$data=$this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->result_array();
								return $result;
							}
							return FALSE;
						}
						
						//lay thong tin loại yêu cầu vd: ios, android , wp, pc ...
						 public function GetTypesRequest($id){
							
							$sql="select res.* from tbl_template_checklist as cl INNER JOIN tbl_request as res on(cl.id_request = res.id)  where cl.id_request=".$id." limit 1";
							$data=$this->db_slave->query($sql);
							//$data=$this->db_slave->get();
							
							if (is_object($data)) {
								$result = $data->row_array();
								return $result;
							}
						 }
						 public function ShowTypes($num){
							 switch($num){
								case 0:
								 	return "<strong style='color:#096AE6'>android</strong> <br> <img boder='0' src='".base_url()."assets/img/icon/android.png'>";
									break;
								case 1:
								 	return "<strong style='color:#C514BF'>ios</strong> <br> <img boder='0' src='".base_url()."assets/img/icon/ios.jpg'>";
									break;
								case 2:
									return "<strong style='color:#0E7777'>wp</strong> <br> <img boder='0' src='".base_url()."assets/img/icon/wp.png'>";
									break;
								case 3:
									return "<strong style='color:#000'>pc</strong> <br> <img boder='0' src='".base_url()."assets/img/icon/pc.png'>";
									break;
								case 4:
									return "<strong style='color:#000'>config</strong> <br> <img boder='0' src='".base_url()."assets/img/icon/web.png'>";
									break;
								case 5:
									return "<strong style='color:#000'>events</strong> <br> <img boder='0' src='".base_url()."assets/img/icon/events.png'>";
									break;
								case 6:
									return "<strong style='color:#000'>systems</strong> <br> <img boder='0' src='".base_url()."assets/img/icon/systems.png'>";
									break;
								case 7:
									return "<strong style='color:#000'>other</strong> <br> <img boder='0' src='".base_url()."assets/img/icon/orther.png'>";
									break;
							 }
						 }
						 
						 public function ShowTypesControl($num){
							 switch($num){
								case 0:
								 	return "android";
									break;
								case 1:
								 	return "ios";
									break;
								case 2:
									return "wp";
									break;
								case 3:
									return "pc";
									break;
								case 4:
									return "web";
									break;
								case 5:
									return "events";
									break;
								case 6:
									return "systems";
									break;
								case 7:
									return "orther";
									break;
							 }
						 } //end ShowTypesControl
						 
						 //thiet lap ket qua tong the của yêu cầu là PASS hay Fail
						 public function SetTotalResultRequest($idgame,$idtemp,$idcate,$idrequest,$result){
							 $this->db_slave->where('id_game',$idgame);
							 $this->db_slave->where('id_template',$idtemp);
							 $this->db_slave->where('id_categories',$idcate);
							 $this->db_slave->where('id_request',$idrequest);
							 $this->db_slave->update("tbl_result_game_template_checklist",array('totalresult'=>$result));
						 }
						 //thiet lap ket qua user tong the của yêu cầu là PASS hay Fail
						 public function SetTotalResultRequestUser($idgame,$idtemp,$idcate,$idrequest,$result){
							 $this->db_slave->where('id_game',$idgame);
							 $this->db_slave->where('id_template',$idtemp);
							 $this->db_slave->where('id_categories',$idcate);
							 $this->db_slave->where('id_request',$idrequest);
							 $this->db_slave->update("tbl_result_game_template_checklist",array('totalresultuser'=>$result));
						 }
						 //tinh ket qua cua hang muc 
						 public function CalResultRequestInCategories($idgame,$idtemp,$idcate){
							 $sql="select totalresult from tbl_result_game_template_checklist where id_game=$idgame and id_template=$idtemp and id_categories=$idcate";
							 $data=$this->db_slave->query($sql);
							 $result = $data->result_array();
							 return $result;
						 }
						 //tinh ket qua cua hang muc cua user
						 public function CalResultRequestInCategoriesUser($idgame,$idtemp,$idcate){
							 $sql="select totalresultuser from tbl_result_game_template_checklist where id_game=$idgame and id_template=$idtemp and id_categories=$idcate";
							 $data=$this->db_slave->query($sql);
							 $result = $data->result_array();
							 return $result;
						 }
						 
						 //tính tổng số Pass hay Fail 28/12/2015
						 //thiet lap tổng số của yêu cầu là PASS hay Fail
						 public function SetCountUser($idgame,$idtemp,$idcate,$idrequest,$cp,$cf,$is){
							 $this->db_slave->where('id_game',$idgame);
							 $this->db_slave->where('id_template',$idtemp);
							 $this->db_slave->where('id_categories',$idcate);
							 $this->db_slave->where('id_request',$idrequest);
							 if($is=="Pass"){
							 	$this->db_slave->update("tbl_result_game_template_checklist",array('count_pass_user'=>$cp));
							 }else{
								$this->db_slave->update("tbl_result_game_template_checklist",array('count_fail_user'=>$cf));
							 }
						 } //end func
						 
						 //thiet  tổng số yêu cầu là PASS hay Fail
						 public function SetCountAdmin($idgame,$idtemp,$idcate,$idrequest,$cp,$cf,$is){
							 $this->db_slave->where('id_game',$idgame);
							 $this->db_slave->where('id_template',$idtemp);
							 $this->db_slave->where('id_categories',$idcate);
							 $this->db_slave->where('id_request',$idrequest);
							 if($is=="Pass"){
							   $this->db_slave->update("tbl_result_game_template_checklist",array('count_pass_admin'=>$cp));
							 }else{
							   $this->db_slave->update("tbl_result_game_template_checklist",array('count_fail_admin'=>$cf));
							 }
						 } //end func
						 
						
					} //end class
?>