<?php
class PopupButtonModel extends CI_Model {
    private $_db_slave;
    private $_table='sign_history_app';
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    
    public function getItem($id){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table)
                        ->where('id', $id)
                        ->get();
		
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
}

