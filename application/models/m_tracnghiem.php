<?php
class m_tracnghiem extends CI_Model {
	
	private $_db;
	private $table_prefix = "tracnghiem_";
    public function __construct() {
        parent::__construct();
		if (!$this->_db)
            $this->_db = $this->load->database(array('db' => 'miniapp', 'type' => 'slave'), TRUE);
    }
	public function getRecordCount($i_table,$i_where){
		$query = $this->_db->query("SELECT COUNT(*) FROM " . $i_table . (($i_where != '') ? " WHERE " . $i_where : '') );
        return ($query != FALSE) ? $query->row_array() : FALSE;
	}
	public function getsubjects(){
		$query = $this->_db->query("SELECT * FROM tbl_listevents WHERE typeevent = 1" );
		return ($query != FALSE) ? $query->result_array() : FALSE;
	}
	public function getsubjectsNo($typeevent){
		$query = $this->_db->query("SELECT * FROM tbl_listevents WHERE typeevent = ".$typeevent );
		return ($query != FALSE) ? $query->result_array() : FALSE;
	}
	public function getEventConfig(){
		$query = $this->_db->query("SELECT c.eventid FROM `event_consomayman_config` as c where c.startdate <= NOW() AND c.enddate >= NOW() and c.status = 1 and c.eventid not in(SELECT eventid FROM event_consomayman_lottery)");
		return ($query != FALSE) ? $query->result_array() : FALSE;
	}
	public function SelectLimit($sql){
		$query = $this->_db->query($sql);
        return ($query != FALSE) ? $query->result_array() : FALSE;
	}
    public function Execute($sql){
        $query = $this->_db->query($sql);
        return ($query != FALSE) ? $query->result_array() : FALSE;
    }
    public function insert($sql) {
        $query = FALSE;
        $query = $this->_db->query($sql);
        return (empty($query) == FALSE) ? $this->_db->insert_id() : 0;
    }

    //cập nhật số lượt
    public function update($sql) {
        $sql = $this->_db->query($sql);
        // var_dump($this->_db->last_query());die;
        return $this->_db->affected_rows();
    }

    
}
