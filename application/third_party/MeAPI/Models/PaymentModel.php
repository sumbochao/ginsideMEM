<?php
class PaymentModel extends CI_Model {

    private $_db;
    private $_db_slave;

    public function __construct() {
        
    }
    public function listScopes(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('service','app_fullname','app_name','service_id','id','app_secret'));
        $this->_db_slave->order_by('id DESC');
		$this->_db_slave->where('(app_type=0 OR app_type=1)');
        $data = $this->_db_slave->get('scopes');
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    public function listServerByGame($game){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('id','server_id','server_name'));
        $this->_db_slave->where('game',$game);
        $this->_db_slave->where('status',1);
        $this->_db_slave->order_by('id DESC');
        $data = $this->_db_slave->get('server_list');
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    public function listServerId($server_id){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('id','server_id','server_name'));
        $this->_db_slave->where('server_id',$server_id);
        $this->_db_slave->where('status',1);
        $this->_db_slave->order_by('id DESC');
        $data = $this->_db_slave->get('server_list');
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
}