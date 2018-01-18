<?php
class ReportSocialModel extends CI_Model {

    private $_db;
    private $_db_slave;

    private $table_fanpage = "tbl_fanpage";
    private $table_report_social = "tbl_report_social";

    public function __construct() {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
    }
    public function getlastdate(){
        $query = $this->_db_slave->query("SELECT * FROM ".$this->table_report_social." ORDER BY `insertdate` DESC LIMIT 1");
        if (is_object($query)) {
            return $query->row_array();
        }
        return FALSE;
    }
    public function loadHistoryByDate($daynow){
        $query = $this->_db_slave->query("SELECT * FROM `tbl_report_social` WHERE  `insertdate` >= '".$daynow."' ORDER BY game,`insertdate` ASC");
        //echo $this->_db_slave->last_query();die;
        if (is_object($query)) {
            return $query->result_array();
        }
        return FALSE;
    }
    public function getlistfanpage(){
        $query = $this->_db_slave->query("SELECT * FROM ".$this->table_fanpage." ORDER BY `idx` DESC");
        if (is_object($query)) {
            return $query->result_array();
        }
        return FALSE;
    }
    public function getlistfanpageActive(){
        $query = $this->_db_slave->query("SELECT * FROM ".$this->table_fanpage." WHERE status =1 ORDER BY `idx` DESC");
        if (is_object($query)) {
            return $query->result_array();
        }
        return FALSE;
    }
    public function getfanpagebyid($idfanpage){
        $query = $this->_db_slave->query("SELECT * FROM ".$this->table_fanpage." WHERE idx ='".$idfanpage."' ORDER BY `idx` DESC");
        if (is_object($query)) {
            return $query->row_array();
        }
        return FALSE;
    }
    public function update($table, $data, $where){
        $sql = $this->_db_slave->update($table, $data, $where);
        return $this->_db_slave->affected_rows();
    }
    public function insert_id($table, $data){
        $query = $this->_db_slave->insert($table, $data);
        //echo $this->_db_slave->last_query();die;
        $idinsert =  $this->_db_slave->insert_id();
        if ($this->_db_slave->affected_rows() > 0) {
            return $idinsert;
        } else {
            return false;
        }
    }
}