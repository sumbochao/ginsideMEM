<?php
class TestModel extends CI_Model {
    public function __construct() {
       
    }
    function freeDBResource($dbh){
        while(mysqli_next_result($dbh)){
            if($l_result = mysqli_store_result($dbh)){
                mysqli_free_result($l_result);
            }
        }
    }
    public function listItems(){
        $this->_db_slave = $this->load->database(array('db' =>'db_cache', 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL `sog_cache`.`sp_event_top_config_getinfo`(0)";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
}