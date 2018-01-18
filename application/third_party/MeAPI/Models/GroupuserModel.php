<?php
class GroupuserModel extends CI_Model {
    private $_db_slave;
    public $_table='tbl_group_users';
	 public $_table_grand='tbl_grand_request_group';
	 public $_table_grand_support='tbl_grand_request_group_support';
	 public $_table_user_on='tbl_user_on_group';
	 
	 public $_table_grand_game='tbl_grand_request_group_game';
	 public $_table_grand_support_game='tbl_grand_request_group_support_game';
	
	 
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
	//hàm trả về nhóm của user account
	public function ReturnGroup($userid){
		$sql="select id_group from ".$this->_table_user_on." where id_user=".$userid;
		$data=$this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
	}
	
    public function listUser(){
        $data = $this->_db_slave->select(array('*'))
                        ->where('status',1)
                        ->from('account_name')
                        ->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if(count($result)>0){
                foreach($result as $v){
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }
    public function deleteItem($arrParam,$options=NULL){
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $arrDelete = array();
                foreach($arrParam['cid'] as $v){
                    $filename = $this->getItem($v);
                    $this->_db_slave->delete($this->_table,array('id' => $v)); 
                }
            }
        }else{
            $filename = $this->getItem($arrParam['id']);
            @unlink(FILE_PATH . '/'.$filename['ipa_file']);
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
        }
    }
	 public function deletelistitem($id){
        $rs=$this->_db_slave->delete($this->_table,array('id' => $id));
		return $rs;
    }
	 public function deleteUserOnGroup($arrParam,$id_group){
            if(count($arrParam['chk_user'])>0){
                foreach($arrParam['chk_user'] as $v){
                    $this->_db_slave->delete($this->_table_user_on,array('id_user' => $v,'id_group' => $id_group)); 
                }
            }
    }
	public function checkgroupexist($names){
		$data = $this->_db_slave->select(array('*'))
        				->from($this->_table)
						->where('names', $names)
       					->get();
		$result = $data->result_array();
		if(count($result)==0){
        	return false;
		}else{
			return true;
		}
		return true;
	}
	public function checkexistuser($arr){
		$data = $this->_db_slave->select(array('*'))
        				->from($this->_table_user_on)
						->where('id_user', $arr['id_user'])
						->where('id_group', $arr['id_group'])
       					->get();
		$result = $data->result_array();
		if(count($result)==0){
        	return false;
		}else{
			return true;
		}
		return true;
	}
	
    public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
		if($arrParam['names']!=""){
			$this->_db_slave->where('names',$arrParam['names']);
		}
		
        $this->_db_slave->from($this->_table);
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	public function listUserOnGroup($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
		if($arrParam['id_group']!=""){
			$this->_db_slave->where('id_group',$arrParam['id_group']);
		}
		
        $this->_db_slave->from($this->_table_user_on);
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	 public function listItemInnerJoin($arrParam=NULL,$options=null){
		if($options==0){
        	$sql="select * from ".$this->_table." as gr inner join ".$this->_table_grand." as grand on(gr.id=grand.id_group) where grand.id_request=".$arrParam['id_request'];
		}else{
			$sql="select * from ".$this->_table." where id not in(select gr.id from ".$this->_table." as gr inner join ".$this->_table_grand." as grand on(gr.id=grand.id_group) where grand.id_request=".$arrParam['id_request'].")";
		}
		$data=$this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->result_array();
			
            return $result;
        }
        return FALSE;
    }
	public function listItemInnerJoinSupport($arrParam=NULL,$options=null){
		if($options==0){
        	$sql="select * from ".$this->_table." as gr inner join ".$this->_table_grand_support." as grand on(gr.id=grand.id_group) where grand.id_request=".$arrParam['id_request'];
		}else{
			$sql="select * from ".$this->_table." where id not in(select gr.id from ".$this->_table." as gr inner join ".$this->_table_grand_support." as grand on(gr.id=grand.id_group) where grand.id_request=".$arrParam['id_request'].")";
		}
		$data=$this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->result_array();
			
            return $result;
        }
        return FALSE;
    }
	public function getItemId(){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table)
						->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if(count($result)>0){
                foreach($result as $v){
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }
    public function getItem($id){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table)
                        ->where('id', $id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }

	public function listPlatform(){
	   $arrResult=array("ios"=>"IOS","android"=>"Android","wp"=>"Winphone");
       return $arrResult;
     
    }
    public function add_new($arrParam) {
		$id=$this->_db_slave->insert($this->_table,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
    }
	public function add_user_to_group($arrParam) {
		$id=$this->_db_slave->insert($this->_table_user_on,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
    }
	public function edit_new($arrParam,$id) {
		$this->_db_slave->where('id', $id);
		$id=$this->_db_slave->update($this->_table,$arrParam);
		
		return $id;
		
    }
	public function edit_rows_item($arrParam,$id){
		$this->_db_slave->where('id', $id);
		$id=$this->_db_slave->update($this->_table_c,$arrParam);
		return $id;
	}
	
	// here game todo
	public function listItemInnerJoinGame($arrParam=NULL,$options=null){
		if($options==0){
        	$sql="select * from ".$this->_table." as gr inner join ".$this->_table_grand_game." as grand on(gr.id=grand.id_group) where grand.id_request=".$arrParam['id_request']." and grand.id_game=".$arrParam['id_game'];
		}else{
			$sql="select * from ".$this->_table." where id not in(select gr.id from ".$this->_table." as gr inner join ".$this->_table_grand_game." as grand on(gr.id=grand.id_group) where grand.id_request=".$arrParam['id_request']." and grand.id_game=".$arrParam['id_game'].")";
		}
		$data=$this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->result_array();
			
            return $result;
        }
        return FALSE;
    }
	public function listItemInnerJoinSupportGame($arrParam=NULL,$options=null){
		if($options==0){
        	$sql="select * from ".$this->_table." as gr inner join ".$this->_table_grand_support_game." as grand on(gr.id=grand.id_group) where grand.id_request=".$arrParam['id_request']." and grand.id_game=".$arrParam['id_game'];
		}else{
			$sql="select * from ".$this->_table." where id not in(select gr.id from ".$this->_table." as gr inner join ".$this->_table_grand_support_game." as grand on(gr.id=grand.id_group) where grand.id_request=".$arrParam['id_request']." and grand.id_game=".$arrParam['id_game'].")";
		}
		$data=$this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->result_array();
			
            return $result;
        }
        return FALSE;
    }
	
	public function searchuser($arrParam=NULL){
		$sql="select * from account_name where username='".$arrParam['username']."'";
		$data=$this->_db_slave->query($sql);
		if (is_object($data)) {
			$result = $data->row_array();
			if(count($result) > 0){
				$sql_g="select * from tbl_user_on_group where id_user=".$result['id'];
				$r=$this->_db_slave->query($sql_g);
				if(count($r)>0){
					$rc=$r->row_array();
					$name_g=$this->getItemId();
					return "Thuộc nhóm : ".$name_g[$rc['id_group']]['names'];
				}else{
					return "User không thuộc Group nào";
				}
			}else{
				return "Không tồn tại User";
			}
		}else{
			return "Không tồn tại User";
		}
	} //end searchuser
   
}