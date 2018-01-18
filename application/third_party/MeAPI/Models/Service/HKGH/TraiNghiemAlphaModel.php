<?php
class TraiNghiemAlphaModel extends CI_Model {
    private $_db_slave;
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'hkgh', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function saveItem($arrParam){
        if(count($arrParam)>0){
            foreach($arrParam as $v){
                $arrData['msi']         = $v['msi'];
                $arrData['lvl']        = $v['lvl'];
                $this->_db_slave->insert('event_trainghiemalpha_user',$arrData);
            }
        }
    }
}