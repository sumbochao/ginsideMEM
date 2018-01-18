<?php
class TranferDataModel extends CI_Model {
    private $_db_slave;
	public $_table_cate_source='tbl_categories';
    public $_table_cate_destination='tbl_categories_game';
	public $_table_request_source='tbl_request';
	public $_table_request_destination='tbl_request_game';
	
	public $_table_group_source='tbl_grand_request_group';
    public $_table_group_destination='tbl_grand_request_group_game';
	
	public $_table_group_support_source='tbl_grand_request_group_support';
	public $_table_group_support_destination='tbl_grand_request_group_support_game';
	
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            date_default_timezone_set("Asia/Ho_Chi_Minh");
    } //end __construct()
	
	public function CheckGameExist($id_game,$id_template){
		$sql="select * from ".$this->_table_cate_destination." where id_template=".$id_template." and id_game=".$id_game;
		$data = $this->_db_slave->query($sql);
		$result = $data->result_array();
		return count($result);
	} //end GetCateNASource
	
	//hàm lấy danh mục NA theo Template
	public function GetCateNASource($id_template){
		$sql="select * from ".$this->_table_cate_source." where id_template=".$id_template." and id_parrent='na'";
		$data = $this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	} //end GetCateNASource
	
	//hàm lấy danh mục NA theo Template,Game tu bang da Tranfer
	public function GetCateNADestination($id_game,$id_template){
		$sql="select * from ".$this->_table_cate_destination." where id_template=".$id_template." and id_game=".$id_game;
		$data = $this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	} //end GetCateNADestination
	
	//hàm lấy danh mục NA theo Template
	public function GetCateSource($id_template,$id_parent){
		$sql="select * from ".$this->_table_cate_source." where id_template=".$id_template." and id_parrent='".$id_parent."'";
		$data = $this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	} //end GetCateSource
	
	//hàm lấy danh mục NA theo Template,Game tu bang da Tranfer
	public function GetCateDestination($id_game,$id_template){
		$sql="select * from ".$this->_table_cate_destination." where id_template=".$id_template." and id_game=".$id_game." and id_parrent <> 'na'";
		$data = $this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	} //end GetCateNADestination
	
	//hàm lấy yeu cầu từ bảng co template
	public function GetRequestSource($id_categories){
		$sql="select * from ".$this->_table_request_source." where id_categories=".$id_categories."";
		$data = $this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	} //end GetRequestSource
	
	//hàm lấy yeu cầu từ bảng game
	public function GetRequestDestination($id_categories){
		$sql="select * from ".$this->_table_request_destination." where id_categories=".$id_categories."";
		$data = $this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	} //end GetRequestDestination
	
	public function add_new($arrParam) {
		$id=$this->_db_slave->insert($this->_table_cate_destination,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
    }
	public function add_new_request($arrParam) {
		$id=$this->_db_slave->insert($this->_table_request_destination,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
    }
	
	//Group
	public function TranferGroup($id_template,$id_game){
		//b.1 
		$sql_cate_source="select * from tbl_categories where id_template=".$id_template." and id_parrent<>'na'";
		$s=$this->_db_slave->query($sql_cate_source);
		$data1 = $s->result_array();
		if(count($data1)>0){
			foreach($data1 as $v1){
				$sql_res_source="select * from tbl_request where id_categories=".$v1['id'];
				$ss=$this->_db_slave->query($sql_res_source);
				$data2 = $ss->result_array();
				//lấy dc id res
				foreach($data2 as $v2){
					$sql_res_group_1="select * from tbl_grand_request_group where id_request=".$v2['id'];
					$sql_res_group_2="select * from tbl_grand_request_group_support where id_request=".$v2['id'];
					$s1=$this->_db_slave->query($sql_res_group_1);
					$s2=$this->_db_slave->query($sql_res_group_2);
					
					$data_gr_1 = $s1->result_array();
					$data_gr_2 = $s2->result_array();
					
					if(count($data_gr_1)>0){
						foreach($data_gr_1 as $v3){
							$sql_res_des="select * from tbl_request_game where id_source=".$v3['id_request'];
							$s3=$this->_db_slave->query($sql_res_des);
							$data_res_group = $s3->result_array();
							if(count($data_res_group)>0){
								foreach($data_res_group as $v4){
									$arr=array(
										'id_game'=>$id_game,
										'id_request'=>$v4['id'],
										'id_group'=>$v3['id_group'],
										'datecreate'=>$v3['datecreate'],
										'userlog'=>$v3['userlog']
									);
									$id=$this->_db_slave->insert($this->_table_group_destination,$arr);
									$arr=NULL;
								}//end foreach($data_res_group as $v4)
							}//end if count
						}//end foreach($data_gr_1 as $v3)
					} //end if(count($data_gr_1)>0)
					
					/******************/
					if(count($data_gr_2)>0){
						foreach($data_gr_2 as $v3){
							$sql_res_des="select * from tbl_request_game where id_source=".$v3['id_request'];
							$s3=$this->_db_slave->query($sql_res_des);
							$data_res_group = $s3->result_array();
							if(count($data_res_group)>0){
								foreach($data_res_group as $v4){
									$arr1=array(
										'id_game'=>$id_game,
										'id_request'=>$v4['id'],
										'id_group'=>$v3['id_group'],
										'datecreate'=>$v3['datecreate'],
										'userlog'=>$v3['userlog']
									);
									$id1=$this->_db_slave->insert($this->_table_group_support_destination,$arr1);
									$arr1=NULL;
								}//end foreach($data_res_group as $v4)
							}//end if count
						}//end foreach($data_gr_1 as $v3)
					} //end if(count($data_gr_1)>0)
					/******************/
					
				} //end foreach($data2 as $v2)
			}//end foreach($data1 as $v1)
		}//end if(count($data1)>0)
		
		
	} //end function TranferGroup
   
}//end class