<?php
class ViewGroup extends GroupuserModel{
						private $id_request=0;
						private $is=0;
						
						public function __construct() {
							if (!$this->db_slave)
								$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
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
									echo "<select name='cbo_group_main_$id_request' id='cbo_group_main_$id_request' style='width:70px;border:none;background:transparent;' multiple='multiple' >";
									 foreach($result as $v){
										 echo "<option value='".$v['id_group']."' ondblclick='calljavascript(5,".$v['id_group'].");'>".$Gn[$v['id_group']]['names']."</option>";
									 }//en for
									 echo "</section>";
								}
						}
						
						public function ShowCateChild($id_game,$id_parent){
							$this->db_slave->select(array('*'));
							$this->db_slave->from('tbl_categories_game');
							$this->db_slave->where('id_game', $id_game);
							$this->db_slave->where('id_parrent', $id_parent);
							$this->db_slave->order_by('order','ASC');
							$this->db_slave->order_by('id','DESC');
							$cate_child = $this->db_slave->get();
							 if (is_object($cate_child)) {
									$child = $cate_child->result_array();
								}
								return $child;
						}
						
					} //end class
					$cate=new ViewGroup();
?>