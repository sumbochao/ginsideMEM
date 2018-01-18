<?php
class ViewGroup extends GroupuserModel{
						private $id_request=0;
						private $is=0;
						static public $arr_id_group="";
						static public $type_user_log="admin";
						static public $where_search="";
						static public $where_search_cate="";
						
						//gia tri nay dung de show phan tim kiem neu =-1 tuc la admin
						static public $group_admin=0;
						//loc theo hang muc
						static public $filter_types_categories="";
						
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
										ViewGroup::$group_admin=-1;
										$typeu="admin";
								}
								ViewGroup::$type_user_log=$typeu;
								$Gn=$this->GroupuserModel->getItemId();
								echo "Bạn thuôc nhóm : ".$Gn[$d[0]]['names'];
								
						}
						public function array_isearch($str, $array) {
						  $found = array();
						  foreach($array as $k => $v)
							if(strtolower($v) == strtolower($str)) $found[] = $k;
						  return $found;
						}
						//tao select control
						public function CreateControlGroupSearch(){
								
								$this->db_slave->select(array('*'));
								$this->db_slave->where('id <>',-1);
								$data = $this->db_slave->get('tbl_group_users');
								if (is_object($data)) {
									$result = $data->result_array();
								}
								if(count($result)>0){
									
									echo "<select name='cbo_group' id='cbo_group'>";
										 echo "<option value='-10'>-- Tất cả các nhóm --</option>";
									 foreach($result as $v){
										 $check=$_POST['cbo_group']==$v['id']?"selected":"";
										 echo "<option value='".$v['id']."'  ".$check.">".$v['names']."</option>";
									 }//en for
									 echo "</select>";
								}
						}
						public function CreateControlGroup($id_game,$id_request,$is){
								$Gn=$this->GroupuserModel->getItemId();
								
								$this->db_slave->select(array('*'));
								$this->db_slave->where('id_request',$id_request);
								$this->db_slave->where('id_game',$id_game);
								if($is==0){
									$data = $this->db_slave->get('tbl_grand_request_group_game');
								}else{
									$data = $this->db_slave->get('tbl_grand_request_group_support_game');
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
						
						//hiển thị danh mục cao nhất 1
						public function ShowCategoriesParent($id_game){
							if(ViewGroup::$type_user_log=="user"){
								$arr="";
								$arr0="";
								/******************************/
								//$sql_con1="select gr.id_request from tbl_grand_request_group_game as gr LEFT JOIN tbl_grand_request_group_support_game as support on (gr.id_group=support.id_group) where gr.id_group in(".ViewGroup::$arr_id_group.") or support.id_group in(".ViewGroup::$arr_id_group.") GROUP BY gr.id_request ";
								if(ViewGroup::$arr_id_group=="" || empty(ViewGroup::$arr_id_group)){
									ViewGroup::$arr_id_group=0;
								}
								
								/*$sql_con1="select DISTINCT id_request from(select 1 as tb,a.* from tbl_grand_request_group_game as a union select 2,b.* from tbl_grand_request_group_support_game as b ) as t
where id_group in(".ViewGroup::$arr_id_group.")";*/
								$sql_con1="select DISTINCT id_request from(select 1 as tb,a.* from tbl_grand_request_group_game as a) as t where id_group in(".ViewGroup::$arr_id_group.")";
								$data1 = $this->db_slave->query($sql_con1);
								$result1 = $data1->result_array();
								foreach($result1 as $it1){
									$arr0=$arr0.$it1['id_request'].",";
								}
								//chuyen thang mang
								$arr10=explode(',',$arr0);
								//xoa phan tu cuoi
								unset($arr10[count($arr10)-1]);
								$mang=implode(',',$arr10)==""?0:implode(',',$arr10);
								/*****************************/
								$sql_con="select cate.id_parrent from tbl_categories_game as cate INNER JOIN tbl_request_game as res on(cate.id=res.id_categories) where res.id in(".$mang.") and cate.id_parrent <>'na' and cate.id_game=".$id_game." and cate.status=0 GROUP BY cate.id ORDER BY cate.`order` asc";
								$data = $this->db_slave->query($sql_con);
								
								$result = $data->result_array();
								foreach($result as $it){
									$arr=$arr.$it['id_parrent'].",";
								}
								//chuyen thanh mang
								$arr1=explode(',',$arr);
								//xoa phan tu cuoi
								unset($arr1[count($arr1)-1]);
								/*******************************/
								$sql="select cate.* from tbl_categories_game as cate where cate.id in(".implode(',',$arr1).") and cate.id_game=".$id_game." ".ViewGroup::$filter_types_categories." and id_template=".$_GET['id_template']." and status=0 ORDER BY `order` asc";
						
							
							}else{
								//view of admin
								$sql="select cate.* from tbl_categories_game as cate where cate.id_parrent='na' and cate.id_game=".$id_game." ".ViewGroup::$filter_types_categories." and id_template=".$_GET['id_template']." and status=0 ORDER BY `order` asc";
								
							}
							//echo $sql;
							$data = $this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->result_array();
								return $result;
							}else{
								return FALSE;
							}
						}
						
						//hiển thị danh mục con 2
						public function ShowCategoriesChild($id_game,$id_parent){
							if(ViewGroup::$type_user_log=="user"){
								//$sql_con="select gr.id_request from tbl_grand_request_group_game as gr LEFT JOIN tbl_grand_request_group_support_game as support on (gr.id_group=support.id_group) where gr.id_group in(".ViewGroup::$arr_id_group.") or support.id_group in(".ViewGroup::$arr_id_group.") GROUP BY gr.id_request";
								if(ViewGroup::$arr_id_group=="" || empty(ViewGroup::$arr_id_group)){
									ViewGroup::$arr_id_group=0;
								}
								/*$sql_con="select DISTINCT id_request from(select 1 as tb,a.* from tbl_grand_request_group_game as a union select 2,b.* from tbl_grand_request_group_support_game as b ) as t
where id_group in(".ViewGroup::$arr_id_group.")";*/
								$sql_con="select DISTINCT id_request from(select 1 as tb,a.* from tbl_grand_request_group_game as a) as t where id_group in(".ViewGroup::$arr_id_group.")";
								$data = $this->db_slave->query($sql_con);
								$result = $data->result_array();
								foreach($result as $it){
									$arr=$arr.$it['id_request'].",";
								}
								//chuyen thanh mang
								$arr1=explode(',',$arr);
								//xoa phan tu cuoi
								unset($arr1[count($arr1)-1]);
								
								$sql="select DISTINCT cate.* from tbl_categories_game as cate INNER JOIN tbl_request_game as res on(cate.id=res.id_categories) where res.id in(".implode(',',$arr1).") ".ViewGroup::$where_search_cate." and cate.id_parrent='".$id_parent."' and cate.id_game=".$id_game." and cate.status=0 GROUP BY cate.id ORDER BY cate.`order` asc";
							
							}else{
								//view of admin
								if(ViewGroup::$where_search_cate==""){
									$sql="select DISTINCT cate.* from tbl_categories_game as cate where cate.id_parrent='".$id_parent."' and cate.id_game=".$id_game." and status=0 ORDER BY `order` asc";
								}else{
									$sql="select DISTINCT cate.* from tbl_categories_game as cate INNER JOIN tbl_request_game as res on(cate.id=res.id_categories) where cate.id_parrent='".$id_parent."' and cate.id_game=".$id_game." ".ViewGroup::$where_search_cate." and status=0 ORDER BY `order` asc";
								}
							}
							$data = $this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->result_array();
								return $result;
							}else{
								return FALSE;
							}
						}
						//show yeu cau theo hang muc, phan quyen hien thi user va admin
						public function ShowRequestofCate($id_game,$id_catelogries){
							//phân quyền admin va user
							if(ViewGroup::$type_user_log=="user"){
								
								//$sql_con="select gr.id_request from tbl_grand_request_group_game as gr LEFT JOIN tbl_grand_request_group_support_game as support on (gr.id_group=support.id_group) where gr.id_group in(".ViewGroup::$arr_id_group.") or support.id_group in(".ViewGroup::$arr_id_group.") GROUP BY gr.id_request";
								if(ViewGroup::$arr_id_group=="" || empty(ViewGroup::$arr_id_group)){
									ViewGroup::$arr_id_group=0;
								}
								/*$sql_con="select DISTINCT id_request from(select 1 as tb,a.* from tbl_grand_request_group_game as a union select 2,b.* from tbl_grand_request_group_support_game as b ) as t
where id_group in(".ViewGroup::$arr_id_group.")";*/
								$sql_con="select DISTINCT id_request from(select 1 as tb,a.* from tbl_grand_request_group_game as a) as t where id_group in(".ViewGroup::$arr_id_group.")";
								$data = $this->db_slave->query($sql_con);
								$result = $data->result_array();
								foreach($result as $it){
									$arr=$arr.$it['id_request'].",";
								}
								//chuyen thanh mang
								$arr1=explode(',',$arr);
								//xoa phan tu cuoi
								unset($arr1[count($arr1)-1]);
								
								$sql="select * from tbl_request_game where id_categories=".$id_catelogries." and id_game=".$id_game." and id in(".implode(',',$arr1).") ".ViewGroup::$where_search." ORDER BY sort asc";
							}else{
								$sql="select * from tbl_request_game where id_categories=".$id_catelogries." and id_game=".$id_game." ".ViewGroup::$where_search." ORDER BY sort asc";
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
							
							$sql="select * from tbl_request_game where id=".$id;
							$data=$this->db_slave->query($sql);
							//$data=$this->db_slave->get();
							
							if (is_object($data)) {
								$result = $data->row_array();
								return $result;
							}
						 }
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
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/exclamation.gif' style='width:14px;height:14px' />"; 
									break;
									case "Pending":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/wait.png' style='width:14px;height:14px' />"; 
									break;
									case "Cancel":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png'>"; 
									break;
									case "InProccess":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/process.png'>"; 
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
									echo "<img boder='0' id='admin_img_status_$id' src='".base_url()."assets/img/exclamation.gif' style='width:14px;height:14px' />"; 
									break;
									default:
									echo "<img boder='0' id='admin_img_status_$id' src='".base_url()."assets/img/tick2.png'>"; 
									break;
									case "Pending":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/wait.png' style='width:14px;height:14px' />"; 
									break;
									case "Cancel":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png'>"; 
									break;
									case "InProccess":
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/process.png'>"; 
									break;
								}
							}
						}
						
						 public static function ShowTypes($num){
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
						 
						  public function ShowGroupOnCate($id_game,$id_cate_child){
							$arr="";
							$sql_res="select id from tbl_request_game where id_categories=".$id_cate_child." and id_game=".$id_game;
							$data_r=$this->db_slave->query($sql_res);
							$result1=$data_r->result_array();
							foreach($result1 as $it){
									$arr=$arr.$it['id'].",";
							}
							//chuyen thang mang
							$arr_plus=explode(',',$arr);
							//xoa phan tu cuoi
							unset($arr_plus[count($arr_plus)-1]);
							$mang=implode(',',$arr_plus)==""?0:implode(',',$arr_plus);
							
							//sau khi tim dc id_request
							$str="";
							$Gn=$this->GroupuserModel->getItemId();
							$sql_group="select id_group from tbl_grand_request_group_game where id_request in(".$mang.") and id_game=".$id_game." GROUP BY id_group";
							$data=$this->db_slave->query($sql_group);
							$result=$data->result_array();
							foreach($result as $v){
									$str=$str.$Gn[$v['id_group']]['names'].",";
							}
							return $str;
						} //end func ShowGroupOnCate
						
						public function CountRequest($id_game,$id_categories){
							$this->db_slave->select(array('*'));
							$this->db_slave->from('tbl_request_game');
							$this->db_slave->where('id_game', $id_game);
							$this->db_slave->where('id_categories', $id_categories);
							$data = $this->db_slave->get();
							$result = $data->result_array();
							return count($result);
						} //end func CountRequest
						
						public function statisticalsub($id_game,$id_categories,$filter){
							if($filter=="" || $filter==-10){
								$sql="select * from tbl_request_game where id_game=".$id_game." and id_categories=".$id_categories;
							}else{
								$sql="select req.* from tbl_request_game as req INNER JOIN tbl_grand_request_group_game as gr on req.id=gr.id_request
where req.id_game=".$id_game." and req.id_categories=".$id_categories." and gr.id_group=".$filter." and gr.id_game=".$id_game;
							}
							
							$data = $this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->result_array();
							}
							return $result;
						} //end func statisticalsub
						
						public function statisticalsub_parent($id_game,$id_categories_parent,$filter){
							
							$sql_parent="select id from tbl_categories_game where id_parrent='".$id_categories_parent."' and id_game=".$id_game;
							
							
							$data_r=$this->db_slave->query($sql_parent);
							$result1=$data_r->result_array();
							foreach($result1 as $it){
									$arr=$arr.$it['id'].",";
							}
							//chuyen thang mang
							$arr_plus=explode(',',$arr);
							//xoa phan tu cuoi
							unset($arr_plus[count($arr_plus)-1]);
							$mang=implode(',',$arr_plus)==""?0:implode(',',$arr_plus);
							
							if($filter=="" || $filter==-10){
								$sql="select * from tbl_request_game where id_game=".$id_game." and id_categories in(".$mang.") ";
							}else{
								$sql="select req.* from tbl_request_game as req INNER JOIN tbl_grand_request_group_game as gr on req.id=gr.id_request
where req.id_game=".$id_game." and req.id_categories in(".$mang.") and gr.id_group=".$filter." and gr.id_game=".$id_game;
							}
							$data = $this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->result_array();
							}
							return $result;
						} //end func statisticalsub_parent
						
						public function CountRequestOfType($id_game,$id_categories,$is,$filter){
						if($id_game>0){
							$where = array(
								'id_game'=>$id_game,
								'id_categories'=>$id_categories
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
							
							if($is==0){
								$kq = $this->statisticalsub($id_game,$id_categories,$filter);
							}else{
								$kq = $this->statisticalsub_parent($id_game,$id_categories,$filter);
							}
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
									
									}
									//ket qua admin
									if($item['result_admin_android']==""){
										//chưa checklist
										$work_admin_android = "<i style='color:#E00449'>NOTWORK</i>";
									}else{
										//đã checklist
										$dem_admin++;
						
									}
									
									
									
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
								
									}
									//ket qua admin
									if($item['result_admin_ios']==""){
										//chưa checklist
										$work_admin_ios = "<i style='color:#E00449'>NOTWORK</i>";
									}else{
										//đã checklist
										$dem_admin++;
										
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
										
									}
									//ket qua admin
									if($item['result_admin_wp']==""){
										//chưa checklist
										$work_admin_wp = "<i style='color:#E00449'>NOTWORK</i>";
									}else{
										//đã checklist
										$dem_admin++;
										
									}
									
									
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
										
									}
									//ket qua admin
									if($item['result_admin_pc']==""){
										//chưa checklist
										$work_admin_pc = "<i style='color:#E00449'>NOTWORK</i>";
									}else{
										//đã checklist
										$dem_admin++;
										
									}
									
									
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
									
									}
									//ket qua admin
									if($item['result_admin_web']==""){
										//chưa checklist
										$work_admin_web = "<i style='color:#E00449'>NOTWORK</i>";
									}else{
										//đã checklist
										$dem_admin++;
										
									}
									
									
									
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
										
									}
									//ket qua admin
									if($item['result_admin_events']==""){
										//chưa checklist
										$work_admin_events = "<i style='color:#E00449'>NOTWORK</i>";
									}else{
										//đã checklist
										$dem_admin++;
										
									}
									
									
									
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
									
									}
									//ket qua admin
									if($item['result_admin_systems']==""){
										//chưa checklist
										$work_admin_systems = "<i style='color:#E00449'>NOTWORK</i>";
									}else{
										//đã checklist
										$dem_admin++;
										
									}
									
									
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
										
									}
									//ket qua admin
									if($item['result_admin_orther']==""){
										//chưa checklist
										$work_admin_orther = "<i style='color:#E00449'>NOTWORK</i>";
									}else{
										//đã checklist
										$dem_admin++;
										
									}
									
									
								}
								$i++;
								
							}//end for

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
									'html_compact'=>'User :'.$dem_user.'/'.$count.' <strong style="color:#FF6B12">Admin : '.$dem_admin.'/'.$count.'</strong>'
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
						return $f['html_compact'];
						
					} //end func CountRequestOfType
						 
						
} //end class
					
$catego = new ViewGroup(0,0);

function getstatus(){
	$val="";
	$none=$_POST['chk_status_none'];
	$pass=$_POST['chk_status_pass'];
	$fail=$_POST['chk_status_fail'];
	$cancel=$_POST['chk_status_cancel'];
	$pending=$_POST['chk_status_pending'];
	$inproccess=$_POST['chk_status_inproccess'];
	$arr=array(
		'n'=>$none,
		'ps'=>$pass,
		'f'=>$fail,
		'c'=>$cancel,
		'pe'=>$pending,
		'i'=>$inproccess
	);
	$arr=array_filter($arr);
	$i=0;
	if(count($arr)>0){
		foreach($arr as $key=>$value){
			if($i == (count($arr)-1)){
				$val.="'".$value."'";
			}else{
				$val.="'".$value."',";
			}
			$i++;
		}
	}
	return $val;
}
function getstatusfrm(){
	$val="";
	$none=$_GET['chk_status_none'];
	$pass=$_GET['chk_status_pass'];
	$fail=$_GET['chk_status_fail'];
	$cancel=$_GET['chk_status_cancel'];
	$pending=$_GET['chk_status_pending'];
	$inproccess=$_GET['chk_status_inproccess'];
	$arr=array(
		'n'=>$none,
		'ps'=>$pass,
		'f'=>$fail,
		'c'=>$cancel,
		'pe'=>$pending,
		'i'=>$inproccess
	);
	$arr=array_filter($arr);
	$i=0;
	if(count($arr)>0){
		foreach($arr as $key=>$value){
			if($i == (count($arr)-1)){
				$val.="'".$value."'";
			}else{
				$val.="'".$value."',";
			}
			$i++;
		}
	}
	return $val;
}
$get_statusfrm=getstatusfrm();
$get_status=getstatus();
$btn_filter=0;
//lọc theo nhóm
if($_GET['iframe']==1){
    $where=getstatusfrm();
    $btn_filter=1;
    //echo $_POST['cbo_group'];
    if($_GET['cbo_group']!=-10){

            ViewGroup::$type_user_log="user";
            ViewGroup::$arr_id_group=$_GET['cbo_group'];
    }else{
            //load hạng mục cha
            //$catego = new ViewGroup(0,0);
    }

    if($where!=""){
            if($where=="'NULL'"){
                    ViewGroup::$where_search="and( ISNULL(result_android) and ISNULL(result_ios) and ISNULL(result_wp) and ISNULL(result_pc) and ISNULL(result_web) and ISNULL(result_events) and ISNULL(result_systems) and ISNULL(result_orther) )";
                    ViewGroup::$where_search_cate="and( ISNULL(res.result_android) and ISNULL(res.result_ios) and ISNULL(res.result_wp) and ISNULL(res.result_pc) and ISNULL(res.result_web) and ISNULL(res.result_events) and ISNULL(res.result_systems) and ISNULL(res.result_orther) )";
            }else{
                    ViewGroup::$where_search="and(result_android in($where) or result_ios in($where) or result_wp in($where) or result_pc in($where) or result_web in($where) or result_events in($where) or result_systems in($where) or result_orther in($where))";
                    ViewGroup::$where_search_cate="and(res.result_android in($where) or res.result_ios in($where) or res.result_wp in($where) or res.result_pc in($where) or res.result_web in($where) or res.result_events in($where) or res.result_systems in($where) or res.result_orther in($where))";
            }
    }else{
            ViewGroup::$where_search="";
            ViewGroup::$where_search_cate="";
    }

    //lof theo hạng mục
    if($_GET['cbo_categories']!=""){
            $cbo_categories=$_GET['cbo_categories'];
            ViewGroup::$filter_types_categories=" and id=".$cbo_categories."";

    }else{
            ViewGroup::$filter_types_categories="";
    }
}
if(isset($_POST['btnfilter'])){
	$where=getstatus();
	$btn_filter=1;
	//echo $_POST['cbo_group'];
	if($_POST['cbo_group']!=-10){
		
		ViewGroup::$type_user_log="user";
		ViewGroup::$arr_id_group=$_POST['cbo_group'];
	}else{
		//load hạng mục cha
		//$catego = new ViewGroup(0,0);
	}
	
	if($where!=""){
		if($where=="'NULL'"){
			ViewGroup::$where_search="and( ISNULL(result_android) and ISNULL(result_ios) and ISNULL(result_wp) and ISNULL(result_pc) and ISNULL(result_web) and ISNULL(result_events) and ISNULL(result_systems) and ISNULL(result_orther) )";
			ViewGroup::$where_search_cate="and( ISNULL(res.result_android) and ISNULL(res.result_ios) and ISNULL(res.result_wp) and ISNULL(res.result_pc) and ISNULL(res.result_web) and ISNULL(res.result_events) and ISNULL(res.result_systems) and ISNULL(res.result_orther) )";
		}else{
			ViewGroup::$where_search="and(result_android in($where) or result_ios in($where) or result_wp in($where) or result_pc in($where) or result_web in($where) or result_events in($where) or result_systems in($where) or result_orther in($where))";
			ViewGroup::$where_search_cate="and(res.result_android in($where) or res.result_ios in($where) or res.result_wp in($where) or res.result_pc in($where) or res.result_web in($where) or res.result_events in($where) or res.result_systems in($where) or res.result_orther in($where))";
		}
	}else{
		ViewGroup::$where_search="";
		ViewGroup::$where_search_cate="";
	}
	
	//lof theo hạng mục
	if($_POST['cbo_categories']!=""){
		$cbo_categories=$_POST['cbo_categories'];
		ViewGroup::$filter_types_categories=" and id=".$cbo_categories."";
		
	}else{
		ViewGroup::$filter_types_categories="";
	}
}

//loc kết quả đánh giá Admin
if(isset($_POST['btnfilter_admin'])){
	$where=getstatus();
	$btn_filter=2;
	if($_POST['cbo_group']!=-10){
		//$catego = new ViewGroup(0,0);
		ViewGroup::$type_user_log="user";
		ViewGroup::$arr_id_group=$_POST['cbo_group'];
	}else{
		//load hạng mục cha
		//$catego = new ViewGroup(0,0);
	}
	
	if($where!=""){
		if($where=="'NULL'"){
			ViewGroup::$where_search="and( ISNULL(result_admin_android) and ISNULL(result_admin_ios) and ISNULL(result_admin_wp) and ISNULL(result_admin_pc) and ISNULL(result_admin_web) and ISNULL(result_admin_events) and ISNULL(result_admin_systems) and ISNULL(result_admin_orther) )";
			ViewGroup::$where_search_cate="and(ISNULL(res.result_admin_android) and ISNULL(res.result_admin_ios) and ISNULL(res.result_admin_wp) and ISNULL(res.result_admin_pc) and ISNULL(res.result_admin_web) and ISNULL(res.result_admin_events) and ISNULL(res.result_admin_systems) and ISNULL(res.result_admin_orther) )";
		}else{
			ViewGroup::$where_search="and(result_admin_android in($where) or result_admin_ios in($where) or result_admin_wp in($where) or result_admin_pc in($where) or result_admin_web in($where) or result_admin_events in($where) or result_admin_systems in($where) or result_admin_orther in($where))";
			ViewGroup::$where_search_cate="and(res.result_admin_android in($where) or res.result_admin_ios in($where) or res.result_admin_wp in($where) or res.result_admin_pc in($where) or res.result_admin_web in($where) or res.result_admin_events in($where) or res.result_admin_systems in($where) or res.result_admin_orther in($where))";
		}
		
	}else{
		ViewGroup::$where_search="";
		ViewGroup::$where_search_cate="";
	}
	
	//lof theo hạng mục
	if($_POST['cbo_categories']!=""){
		$cbo_categories=$_POST['cbo_categories'];
		ViewGroup::$filter_types_categories=" and id=".$cbo_categories."";
		
	}else{
		ViewGroup::$filter_types_categories="";
	}
	
}
//echo ViewGroup::$where_search;
?>