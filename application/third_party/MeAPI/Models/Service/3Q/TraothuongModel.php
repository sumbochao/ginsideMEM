<?php
class TraothuongModel extends CI_Model {
    private $_db_slave;
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => '3q', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function saveItem($arrParam){
        if(count($arrParam)>0){
            foreach($arrParam as $v){
                $arrData['msi']         = $v['msi'];
                $arrData['type']        = $v['type'];
                $arrData['item']        = $v['item'];
                $this->_db_slave->insert('event_traothuong_user',$arrData);
            }
        }
    }
}