<?php
class TopEventModel extends CI_Model {
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'db_cache', 'type' => 'slave'), TRUE);
    }
    function freeDBResource($dbh){
        while(mysqli_next_result($dbh)){
            if($l_result = mysqli_store_result($dbh)){
                mysqli_free_result($l_result);
            }
        }
    }
    public function listItems(){
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL `sog_cache`.`sp_event_top_config_getinfo`(0)";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	public function getItems($serverid){
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL `sog_cache`.`sp_event_top_config_getinfo`($serverid)";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	public function saveItem($arrParam){
		$startdate = date_format(date_create($arrParam['startdate']),"Y-m-d G:i:s");
		$enddate = date_format(date_create($arrParam['enddate']),"Y-m-d G:i:s");
		$this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL `sog_cache`.`sp_event_top_config`(".$arrParam['serverid'].",'".$startdate."','".$enddate."',".$arrParam['status'].")";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return 1;
        }
        return 0;
	}
}