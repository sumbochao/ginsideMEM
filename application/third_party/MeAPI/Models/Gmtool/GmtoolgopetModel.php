<?php
class GmtoolgopetModel extends CI_Model {
    private $_db_slave;
	protected $db_gopet;
    private $_table='tbl_log_gmtool';
    
    public function __construct() {
		if(!$this->db_gopet)
            $this->db_gopet = $this->load->database(array('db' => 'db_gopet_4', 'type' => 'master'), TRUE);
        $this->db_gopet->query("SET collation_connection = utf8_general_ci");
		
		
	   if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
	function freeDBResource($dbh){
        while(mysqli_next_result($dbh)){
            if($l_result = mysqli_store_result($dbh)){
                mysqli_free_result($l_result);
            }
        }
    }
	function loadConfigByServer($serverid){
		$this->db_gopet->reconnect();
		$this->db_gopet = $this->load->database(array('db' => 'db_gopet_'.$serverid, 'type' => 'master'), TRUE);
	}
	function loadConfigByServer_sub($user='',$pass='',$host='',$db = ''){
        $this->db2->reconnect();
        $dsn = 'mysql://'.$user.':'.$pass.'@'.$host.'/'.$db;
        $this->db2 = $this->load->database($dsn,true);
        
    }
	
    public function call_procedure($sp_name,$params){
		$this->loadConfigByServer($params['serverid']);
       $this->freeDBResource($this->db_gopet->conn_id);
        $sql = "CALL $sp_name(?)";
		$insertlog['manager'] = $params['email'];
		$insertlog['data_firstchange'] = json_encode($params);
        $insertlog['table_name']  = $sp_name;
		$insertlog['insertDate'] =  date('Y-m-d H:i:s',time());
		if(isset($params['email'])){
			unset($params['email']);
		}
		if(isset($params['serverid'])){
			unset($params['serverid']);
		}
		$query = $this->db_gopet->query($sql, $params);
		
		
		$this->insertLog($insertlog);
		
//        echo $this->db_gopet->last_query();die;
        if ($query){
            return $query->result_array();
        }
        else{
            return false;
        }
    }
	
	public function call_procedure_not_params($sp_name){
       $this->freeDBResource($this->db_gopet->conn_id);
        $sql = "CALL $sp_name()";
		$query = $this->db_gopet->query($sql);
        if ($query){
            return $query->result_array();
        }
        else{
            return false;
        }
    }
	public function insertLog($data){
		$query = FALSE;
		if (is_array($data)) {
            $query = $this->_db_slave->insert($this->_table, $data);
        }
        return (empty($query) == FALSE) ? $this->_db_slave->insert_id() : 0;
	}
	
	public function insert_batch($table,$data){
        $this->_db_slave = $this->load->database(array('db' => 'system_info', 'type' => 'master'), TRUE);
        $this->_db_slave->insert_batch($table,$data);
//        echo $this->_db_slave->last_query();
        return $this->_db_slave->affected_rows();
    }
	public function insert($table, $data) {
        $query = FALSE;
        //var_dump($data);
        if (is_array($data)) {
            $query = $this->_db_slave->insert($table, $data);
            //var_dump($this->_db_slave->last_query());die;
        }
        return (empty($query) == FALSE) ? $this->_db_slave->insert_id() : 0;
    }

    //c?p nh?t s? lu?t
    public function update($table, $data, $where) {

        $sql = $this->_db_slave->update($table, $data, $where);
        // var_dump($this->_db_slave->last_query());die;
        return $this->_db_slave->affected_rows();
    }
	
}

