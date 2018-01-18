<?php
class TemplatechecklistModel extends CI_Model {
    private $_db_slave;
    public $_table='tbl_template_checklist';
	public $_table_checklist='tbl_game_template_checklist';
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            date_default_timezone_set("Asia/Ho_Chi_Minh");
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
     
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
        }
    }
	 public function deleteGameChecklist($arrParam){
            if(count($arrParam['chk_game'])>0){
                foreach($arrParam['chk_game'] as $v){
                    $this->_db_slave->delete($this->_table_checklist,array('id_game' => $v)); 
                }
            }
    }
	 public function deletelistitem($id){
        $rs=$this->_db_slave->delete($this->_table,array('id' => $id));
		return $rs;
    }

	public function checkexist($arrp){
		$data = $this->_db_slave->select(array('*'))
        				->from($this->_table)
						->where('id_template', $arrp['id_template'])
						->where('id_categories', $arrp['id_categories'])
						->where('id_request', $arrp['id_request'])
       					->get();
		$result = $data->result_array();
		if(count($result)==0){
        	return false;
		}else{
			return true;
		}
		return true;
	}
	public function checkexistgamechecklist($arrp){
		$data = $this->_db_slave->select(array('*'))
        				->from($this->_table_checklist)
						->where('id_template', $arrp['id_template'])
						->where('id_game', $arrp['id_game'])
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
		if($arrParam['id_template']!=""){
			$this->_db_slave->where('id_template',$arrParam['id_template']);
		}
		if($arrParam['id_categories']!=""){
			$this->_db_slave->where('id_categories',$arrParam['id_categories']);
		}
		if($arrParam['id_request']!=""){
			$this->_db_slave->where('id_request',$arrParam['id_request']);
		}
        $this->_db_slave->from($this->_table);
        $this->_db_slave->order_by('id_categories','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	public function listItemGameChecklist($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
		$this->_db_slave->where('id_template',$arrParam['id_template']);
        $this->_db_slave->from($this->_table_checklist);
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
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

    public function add_new($arrParam) {
		$id=$this->_db_slave->insert($this->_table,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
    }
	public function add_game_checklist($arrParam) {
		$id=$this->_db_slave->insert($this->_table_checklist,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
    }
	public function edit_new($arrParam,$arrWhere) {
		$this->_db_slave->where('id_template', $arrWhere['id_template']);
		$this->_db_slave->where('id_categories', $arrWhere['id_categories']);
		$this->_db_slave->where('id_request', $arrWhere['id_request']);
		$id=$this->_db_slave->update($this->_table,$arrParam);
		return $id;
		
    }
	public function edit_rows_item($arrParam,$id){
		$this->_db_slave->where('id', $id);
		$id=$this->_db_slave->update($this->_table_c,$arrParam);
		return $id;
	}
	public function listGame(){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('id','service_id','app_fullname'));
       $this->db_slave->where('app_type',0);
       $this->db_slave->or_where('app_type',1);
        $this->db_slave->order_by('id','DESC');
        $data = $this->db_slave->get('scopes');
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if(count($result)>0){
                foreach($result as $v){
                    $arrResult[$v['service_id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }
	public function ShowGroupOnGame($id_game,$t){
		if($t=="main"){
			$sql="select * from tbl_grand_request_group_game where id_game=$id_game GROUP BY id_group";
		}else{
			$sql="select * from tbl_grand_request_group_support_game where id_game=$id_game GROUP BY id_group";
		}
		$data=$this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	}//end func
	
   	public function ChangeGroupOnGame($id_game,$cur_group,$change_group,$t){
		if($t=="main"){
			$sql="update tbl_grand_request_group_game set id_group=$change_group where id_group=$cur_group and id_game=$id_game";
		}else{
			$sql="update tbl_grand_request_group_support_game set id_group=$change_group where id_group=$cur_group and id_game=$id_game";
		}
		$data=$this->_db_slave->query($sql);
		return $data;
	}//end func
	
	public function updatestatus($arr){
		$t=$arr['status']==0?1:0;
		$sql="update tbl_game_template_checklist set `status`=".$t." where id=".$arr['id'];
		$data=$this->_db_slave->query($sql);
		return $data;
	}
	public function getItemGame($id){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table_checklist)
                        ->where('id', $id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
	public function CreateControlGroup($id_game,$id_request,$is){
        $Gn=$this->GroupuserModel->getItemId();		
        $this->_db_slave->select(array('*'));
        $this->_db_slave->where('id_request',$id_request);
        $this->_db_slave->where('id_game',$id_game);
        if($is==0){
                $data = $this->_db_slave->get('tbl_grand_request_group_game');
        }else{
                $data = $this->_db_slave->get('tbl_grand_request_group_support_game');
        }
        if (is_object($data)) {
            $result = $data->result_array();
        }
        
        if(count($result)>0){
            foreach($result as $v){
                $name[] = $Gn[$v['id_group']]['names'];
            }
        }
        $str_name = implode(', ', $name);
        return $str_name;
    }
}