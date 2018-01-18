<?php

/**
 * @property CI_DB_active_record $db
 */
class UserModel extends CI_Model {

    private $_db;
    private $_db_slave;

    public function __construct() {

    }

    //////////// Account //////////////
    public function get_account($account) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->where('username', $account);
        $this->_db_slave->where('status', 1);
        $this->_db_slave->limit(1);
        $data = $this->_db_slave->get('account_name');
        if (is_object($data))
            return $data->row_array();
    }

    public function getError() {
        return $this->_db->_error_message();
    }

}