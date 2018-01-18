<?php

/**
 * @property CI_DB_active_record $this->_db_slave
 */
class LogsModel extends CI_Model {

    private $_db;
    private $_db_slave;

    public function __construct() {
        
    }

    public function saveLogs($table = false, $type = false, $content = false, $datecreate = false) {
        if (!$this->_db)
            $this->_db = $this->load->database(array('db' => 'inside_info', 'type' => 'master'), TRUE);
        $data = array('type' => $type, 'content' => $content);
        if ($datecreate) {
            $data['datecreate'] = $datecreate;
        }
        $this->_db->insert($table, $data);
        return $this->_db->insert_id();
    }

    public function UpdateLogs($table = false, $type = false, $content = false, $id = false, $datecreate = false) {
        if (!$this->_db)
            $this->_db = $this->load->database(array('db' => 'inside_info', 'type' => 'master'), TRUE);

        if ($datecreate) {
            $data['datecreate'] = $datecreate;
        }
        $data['type'] = $type;
        $data['content'] = $content;

        $this->_db->where('id', $id);
        $this->_db->update($table, $data);
        return $this->_db->affected_rows();
    }

    public function getAll_Logs_byTime($table = false, $type = false, $time = false) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->select(array('content', 'date' => 'DATE(datecreate)', 'id', 'type'));
        $this->_db_slave->where('DATE(datecreate) = (' . $time . ')');
        $this->_db_slave->where('type', $type);
        $this->_db_slave->order_by('datecreate desc');
        $data = $this->_db_slave->get($table);
        if (is_object($data)) {
            return $data->result_array();
        }
        return false;
    }

    public function getLatestLogs($table = false, $type = false, $time = false) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);


        $this->_db_slave->where('DATE(datecreate) = (' . $time . ')');
        $this->_db_slave->where('type', $type);
        $this->_db_slave->order_by('datecreate desc');
        $data = $this->_db_slave->get($table);
        if (is_object($data)) {
            return $data->row_array();
        }
        return false;
    }

    public function getLatestLogsHour($table = false, $type = false, $time = false) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);


        $this->_db_slave->where('DATE(datecreate) = (' . $time . ')');
        $this->_db_slave->where('HOUR(datecreate) = HOUR(' . $time . ')');
        $this->_db_slave->where('type', $type);
        $this->_db_slave->order_by('datecreate desc');
        $data = $this->_db_slave->get($table);

        if (is_object($data)) {
            return $data->row_array();
        }
        return false;
    }

    public function getLatestLogs_rangeTime($table = false, $type = false, $form_time = false, $to_time = false) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->where('DATE(datecreate) >= (' . $form_time . ')');
        $this->_db_slave->where('DATE(datecreate) <= (' . $to_time . ')');
        $this->_db_slave->where('type', $type);
        $this->_db_slave->order_by('datecreate desc');
        $data = $this->_db_slave->get($table);

        if (is_object($data)) {
            return $data->result_array();
        }
        return false;
    }

}