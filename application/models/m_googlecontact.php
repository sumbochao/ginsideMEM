<?php
class m_googlecontact extends CI_Model {
	
	private $_db_slave;
	protected $db_cache;
    public function __construct() {
        parent::__construct();
		if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
    }
	
	public function getaccount(){
		$date=date('Y-m-d H:i:s');
		$d1=strtotime($date);
		$d2=date('Y-m-d',date(strtotime('today - 4 days')));
		
		$this->_db_slave->where('date(`insertdate`)<=',$d2);
        $this->_db_slave->or_where('insertdate IS NULL');
		$this->_db_slave->limit(1);
        $data = $this->_db_slave->get("push_top_google_contacts");

        if (is_object($data)) {
            return $data->result_array();
        }
        return false;
	}
	public function getaccountreg(){
		$this->_db_slave->where('status',0);
		$this->_db_slave->limit(1);
        $data = $this->_db_slave->get("account_sample");

        if (is_object($data)) {
            return $data->row_array();
        }
        return false;
	}
	public function getaccountreglist(){
		$data = $this->_db_slave->get("accoung_gg_sample");
        if (is_object($data)) {
            return $data->result_array();
        }
        return false;
	}
    public function insert($table,$data) {
        $query = $this->_db_slave->insert($table, $data);
        return (empty($query) == FALSE) ? $this->_db_slave->insert_id() : 0;
    }

    public function update($table,$data,$where) {
        $this->_db_slave->update($table, $data , $where);
        return ($this->_db_slave->affected_rows() >= 0)?true:false;
    }

    
}
