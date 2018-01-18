<?php
class GroupModel extends CI_Model {
    private $_db_slave;
	private $_db_slave_3k;
	public $_table_group='tbl_group';
	public $_table_grant_group='tbl_grant_group';
	
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
    } // end func
	
	 public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave_3k->select(array('*'));
		if($arrParam['group_name']!=""){
			$this->_db_slave->where('group_name',$arrParam['group_name']);
		}
		
        $this->_db_slave_3k->from($this->_table_group);
        $this->_db_slave_3k->order_by('id','DESC');
        
        $data=$this->_db_slave_3k->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    } //end fucn
	
	public function checkgroupexist($names){
		$data = $this->_db_slave_3k->select(array('*'))
        				->from($this->_table_group)
						->where('group_name', $names)
       					->get();
		$result = $data->result_array();
		if(count($result)==0){
        	return false;
		}else{
			return true;
		}
		return true;
	} //end func
	
	public function add_new($arrParam) {
		$id=$this->_db_slave_3k->insert($this->_table_group,$arrParam);
		$id = $this->_db_slave_3k->insert_id();
		return $id;
    }//end func
	

}