<?php
class ViewGroup extends GroupuserModel{
						private $id_request=0;
						private $is=0;
						
						public function __construct($id_request,$is) {
							if (!$this->db_slave)
								$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
							$this->id_request=$id_request;
							$this->is=$is;
						}
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
									echo "<select name='cbo_group_main_$id_request' id='cbo_group_main_$id_request' style='width:150px;border:none;background:transparent;' multiple='multiple' >";
									 foreach($result as $v){
										 echo "<option value='".$v['id_group']."' ondblclick='calljavascript(5,".$v['id_group'].");'>".$Gn[$v['id_group']]['names']."</option>";
									 }//en for
									 echo "</section>";
								}
						}
						
						public function listC($idcatelogries){
							
							$sql="select cl.* from tbl_template_checklist as cl INNER JOIN tbl_categories as cate on(cl.id_categories = cate.id)  where cl.id_categories in(select id from tbl_categories where id_parrent='".$idcatelogries."') ORDER BY cate.`order` asc";
							$data=$this->db_slave->query($sql);
							//$data=$this->db_slave->get();
							
							if (is_object($data)) {
								$result = $data->result_array();
								return $result;
							}
							return FALSE;
						}
						public function listC1($idcatelogries){
							
							$sql="select cl.* from tbl_template_checklist as cl INNER JOIN tbl_categories as cate on(cl.id_categories = cate.id)  where cl.id_categories=".$idcatelogries." ORDER BY cate.`order` asc";
							$data=$this->db_slave->query($sql);
							//$data=$this->db_slave->get();
							
							if (is_object($data)) {
								$result = $data->result_array();
								return $result;
							}
							return FALSE;
						}
						 public function GetTypesRequest($id){
							
							$sql="select res.* from tbl_template_checklist as cl INNER JOIN tbl_request as res on(cl.id_request = res.id)  where cl.id_request=".$id;
							$data=$this->db_slave->query($sql);
							//$data=$this->db_slave->get();
							
							if (is_object($data)) {
								$result = $data->row_array();
								return $result;
							}
						 }
						 public function ShowCateloriesChild($id){
							
							$sql="select * from tbl_categories where id_parrent='".$id."' ORDER BY `order` asc";
							$data=$this->db_slave->query($sql);
							//$data=$this->db_slave->get();
							
							if (is_object($data)) {
								$result = $data->result_array();
								return $result;
							}
							return FALSE;
						}
						
						//update 11/01/2016
						public function ShowGroupOnGame($id_game,$t){
							if($t=="main"){
								$sql="select * from tbl_grand_request_group_game where id_game=$id_game GROUP BY id_group";
							}else{
								$sql="select * from tbl_grand_request_group_support_game where id_game=$id_game GROUP BY id_group";
							}
							$val="";
							$Gn=$this->GroupuserModel->getItemId();
							$data=$this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->result_array();
								foreach($result as $v){
									$val=$val."<strong>".$Gn[$v['id_group']]['names']."</strong> ; ";
								}//end for
							} //end if
							return $val;
						}//end func
						
					} //end class
?>