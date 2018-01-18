<?php
class ListPackModel extends CI_Model {
    private $_db_slave;
	private $_db_slave_3k;
    public $_table_pack='tbl_pack';
	public $_table_shop_type='tbl_shop_type';
	public $_table_group='tbl_group';
	public $_table_grant_group='tbl_grant_group';
	public $_table_history='event_shop_historys';
	
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
	   if (!$this->_db_slave_3k)
            $this->_db_slave_3k = $this->load->database(array('db' => 'inside_3k', 'type' => 'slave'), TRUE);
			
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
	public function listGameAccess($inParam){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
			$this->db_slave->select(array('id','service_id','app_fullname'));
			$this->db_slave->where_in('service_id',$inParam);
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
	 public function listShop(){
        $this->_db_slave_3k->select(array('*'));
        $this->_db_slave_3k->from($this->_table_shop_type);
        $this->_db_slave_3k->order_by('id','DESC');
        
        $data=$this->_db_slave_3k->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    } //end fucn
	 public function listItem($arrParam=NULL){
        $this->_db_slave_3k->select(array('*'));
		if($arrParam['game_id']!=""){
			$this->_db_slave_3k->where('game_id',$arrParam['game_id']);
		}
		if($arrParam['values_query']!=""){
            $this->_db_slave_3k->where('values_query',$arrParam['values_query']);
        }
        $this->_db_slave_3k->from($this->_table_pack);
        $this->_db_slave_3k->order_by('id','DESC');
        $data=$this->_db_slave_3k->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    } //end fucn
	
	public function getItem($id){
        $data = $this->_db_slave_3k->select(array('*'))
                        ->from($this->_table_pack)
                        ->where('id', $id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
	
	public function add_new($arrParam) {
		$id=$this->_db_slave_3k->insert($this->_table_pack,$arrParam);
		$id = $this->_db_slave_3k->insert_id();
		return $id;
    }//end func
	
	public function edit_new($arrParam,$id) {
		$this->_db_slave_3k->where('id', $id);
		$id=$this->_db_slave_3k->update($this->_table_pack,$arrParam);
		
		return $id;
		
    }//end func
	
	public function deleteItem($arrParam,$options=NULL){
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $arrDelete = array();
                foreach($arrParam['cid'] as $v){
                    $filename = $this->getItem($v);
                    $this->_db_slave_3k->delete($this->_table_pack,array('id' => $v)); 
                }
            }
        }else{
            $this->_db_slave_3k->delete($this->_table_pack,array('id' => $arrParam['id'])); 
        }
    }
	public function deletelistitem($id){
        $rs=$this->_db_slave_3k->delete($this->_table_pack,array('id' => $id));
		return $rs;
    }
	
	//phan quyen
	public function checkuseringroup($arrParam){
		 $data = $this->_db_slave_3k->select(array('*'))
                        ->from($this->_table_grant_group)
                        ->where('user_id',$arrParam['user_id'])
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }      
    }//end func
	
	public function listHistory($arrParam=NULL){
        $this->_db_slave_3k->select(array('*'));
		if($arrParam['game_id']!=""){
			$this->_db_slave_3k->where('game_id',$arrParam['game_id']);
		}
		if($arrParam['create_date']!=""){
			$this->_db_slave_3k->like('create_date',$arrParam['create_date'],'after');
		}
		if($arrParam['mobo_service_id']!=""){
			$this->_db_slave_3k->where('mobo_service_id',$arrParam['mobo_service_id']);
		}
        $this->_db_slave_3k->from($this->_table_history);
        $this->_db_slave_3k->order_by('id','DESC');
        $data=$this->_db_slave_3k->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    } //end fucn

}