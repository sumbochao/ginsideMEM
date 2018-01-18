<?php
class VicamboModel extends CI_Model {
    private $_db_slave;
    
    public function __construct() {
        parent::__construct();
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'vicamobo', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function accountWallet($arrParam){
        $this->_db_slave->select(array('p.*'));
        $this->_db_slave->from('account_wallet as p');
        $this->_db_slave->order_by('p.id','DESC');
        if(!empty($arrParam['mobo_service_id'])){
            $this->_db_slave->where('p.mobo_service_id', $arrParam['mobo_service_id']);
        }
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    public function cashIn($arrParam){
        $this->_db_slave->select(array('p.*'));
        $this->_db_slave->from('cash_in as p');
        $this->_db_slave->order_by('p.id','DESC');
        if(!empty($arrParam['mobo_service_id'])){
            $this->_db_slave->where('p.mobo_service_id', $arrParam['mobo_service_id']);
        }
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    public function cashOut($arrParam){
        $this->_db_slave->select(array('p.*'));
        $this->_db_slave->from('cash_out as p');
        $this->_db_slave->order_by('p.id','DESC');
        if(!empty($arrParam['mobo_service_id'])){
            $this->_db_slave->where('p.mobo_service_id', $arrParam['mobo_service_id']);
        }
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
}