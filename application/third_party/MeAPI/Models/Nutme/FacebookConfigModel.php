<?php
class FacebookConfigModel extends CI_Model {
    private $_db_slave;
    private $_table_share_facebook_game = 'share_facebook_game';
    
    public function __construct() {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function slbGame(){
        $data = $this->_db_slave->select(array('*'))
                        ->from('share_facebook_game')
                        ->order_by('id DESC')
                        ->get();
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    public function getItemByGame($aliasgame){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table_share_facebook_game)
                        ->where('alias',$aliasgame)
                        ->order_by('id DESC')
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
}