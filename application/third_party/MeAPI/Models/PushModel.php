<?php

class PushModel extends CI_Model {

    private $_db_slave;
    private $_db_slave_push;
    public $_tbl_device = 'device';
    public $_table_category = 'push_notication';
    public $_table_logs = 'push_logs';

    public function __construct() {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        if (!$this->_db_slave_push)
            $this->_db_slave_push = $this->load->database(array('db' => 'ttkt_push', 'type' => 'slave'), TRUE);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
    }

    public function addCategory($arrParam) {
        $this->_db_slave->insert($this->_table_category, $arrParam);
        $id = $this->_db_slave->insert_id();
        return $id;
    }

    public function deleteDevice($arrParam) {
        //check exits device token
        return $this->_db_slave->delete($this->_tbl_device, array('deviceToken' => $arrParam['deviceToken']));
    }

    public function getLastIdDevice($array) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_logs)
                ->where('id_push_cat', $array['id_push_cat'])
                ->order_by("id", "desc")
                ->limit(1)
                ->get();
        $result = $data->row_array();
        return $result;
    }

    public function listCategoris() {

        $this->_db_slave->select(array('*'));
        $this->_db_slave->where("is_finish", 0);
        $this->_db_slave->where("NOW() >= `time` ");
        $this->_db_slave->from($this->_table_category);
        $this->_db_slave->order_by('id', 'ASC');
        $this->_db_slave->limit(1);
        $data = $this->_db_slave->get();

        //echo $this->_db_slave->last_query();die;
        if (is_object($data)) {
            $result = $data->row_array();
            return $result;
        }
        return FALSE;
    }

    public function getAllCategoris() {

        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table_category);
        $this->_db_slave->order_by('id', 'ASC');
        $data = $this->_db_slave->get();

        //echo $this->_db_slave->last_query();die;
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    
    public function getDetailCategoris($id){
		
        $this->_db_slave->select(array('*'));
        $this->_db_slave->where("id", $id);
        $this->_db_slave->from($this->_table_category);
        $this->_db_slave->limit(1);
        $data=$this->_db_slave->get();
        
		//echo $this->_db_slave->last_query();die;
        if (is_object($data)) {
            $result = $data->row_array();
            return $result;
        }
        return FALSE;
    }

    public function getListDevice($arrParam = NULL, $options = null) {
        $this->_db_slave_push->select(array('*'));
        $this->_db_slave_push->where($arrParam);
        $this->_db_slave_push->from($this->_tbl_device);
        $this->_db_slave_push->order_by('deviceToken', 'ASC');
        $this->_db_slave_push->limit(1000);
        $data = $this->_db_slave_push->get();

        echo $this->_db_slave_push->last_query();
        die;
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }

    public function editFinish($data, $where) {
        $this->_db_slave->where($where);
        return $this->_db_slave->update($this->_table_category, $data);
    }

}
