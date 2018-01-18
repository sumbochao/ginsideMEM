<?php
class ViewGroup extends GroupuserModel{
						private $id_request=0;
						private $is=0;
						
						public function __construct() {
							if (!$this->db_slave)
								$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
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
						public function CountRequest($id_game,$id_categories){
							$this->db_slave->select(array('*'));
							$this->db_slave->from('tbl_request_game');
							$this->db_slave->where('id_game', $id_game);
							$this->db_slave->where('id_categories', $id_categories);
							$data = $this->db_slave->get();
							$result = $data->result_array();
							return count($result);
						}
						
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
						}
						
} //end class
$cate=new ViewGroup();
?>