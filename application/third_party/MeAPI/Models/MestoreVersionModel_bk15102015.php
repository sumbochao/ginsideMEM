<?php
class MestoreVersionModel extends CI_Model {
    private $_db_slave;
    private $_table='sign_history_app';
	 private $_table_msv='tbl_get_msv';
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            date_default_timezone_set("Asia/Ho_Chi_Minh");
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
    public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        $this->_db_slave->order_by('id','DESC');
        
        $this->_db_slave->where('cert_id',$arrParam['cert_id']);
        
        $data=$this->_db_slave->get();
        
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
	public function getItemGame($service_id){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('service_id','app_fullname'));
        $this->db_slave->where('service_id',$service_id);
        $data = $this->db_slave->get('scopes');
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
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }
	public function listTableApp(){
        $data = $this->_db_slave->select(array('*'))
                        ->where('status',1)
                        ->from('sign_config_cert')
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
	public function listPlatform(){
	   $arrResult=array("ios"=>"IOS","android"=>"Android","wp"=>"Winphone");
       return $arrResult;
     
    }
	public function listStatus(){
	   $arrResult=array("approving"=>"Approving","approved"=>"Approved","rejected"=>"Rejected","cancel"=>"Cancel");
       return $arrResult;
     
    }
    public function add_new($arrParam) {
		 
		$id=$this->_db_slave->insert($this->_table_msv,$arrParam);
		return $id;
    }
	
	public function edit_new($arrParam,$arrWhere) {
		//kiem tra xem table tbl_get_msv ton tai row cap nhat hay chua
		
		$this->_db_slave->where('msv_id', $arrWhere['msv_id']);
		$this->_db_slave->where('platform', $arrWhere['platform']);
		$this->_db_slave->where('service_id', $arrWhere['service_id']);
		$sql="select * from ".$this->_table_msv." where msv_id='".$arrWhere['msv_id']."' and service_id='".$arrWhere['service_id']."' and platform='".$arrWhere['platform']."'";
		$result1 = $this->_db_slave->query($sql);
		$c = $result1->result();
		if(count($c)>0){
			$id=$this->_db_slave->update($this->_table_msv,$arrParam);
		}else{
			$arrParam['service_id']=$arrWhere['service_id'];
			$arrParam['msv_id']=$arrWhere['msv_id'];
			$arrParam['platform']=$arrWhere['platform'];
			$arrParam['days']=date('d-m-y');
			$id=$this->add_new($arrParam);
		}
		return $id;
    }


   
}