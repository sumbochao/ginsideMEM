<?php

/**
 * @property CI_DB_active_record $db
 */
class EmailModel extends CI_Model {

    private $_db;
    private $_db_slave;

    public function __construct() {
        
    }

    //////////// Menu //////////////
    public function getListMail($name) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);


        $this->_db_slave->select('LOWER(email) as email');
        $this->_db_slave->where('key', $name);
        $this->_db_slave->limit(1);
        $data = $this->_db_slave->get('sys_mail');
        if (is_object($data)) {
            return $data->row_array();
        }
    }

    public function getError() {
        return $this->_db->_error_message();
    }

}