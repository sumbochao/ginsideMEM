<?php
class PermissionModel extends CI_Model {
    private $_db_slave;
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
    }
    
    public function listPermissionByUser($id_user){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from('module_user');
        $this->_db_slave->where('id_user',$id_user);
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    public function listPermissionById($id){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from('module');
        $this->_db_slave->where('id',$id);
        $this->_db_slave->where('status',1);
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
	public function getModuleItem($id){
        $data = $this->_db_slave->select(array('*'))
                        ->from('module')
                        ->where('id', $id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
    public function listPermissionByIdGame($id_game){
        $game = $this->getModuleItem($id_game);
        $this->_db_slave->select(array('game'));
        $this->_db_slave->from('module');
        $this->_db_slave->where('game',$game['game']);
        $this->_db_slave->where('status',1);
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
}
