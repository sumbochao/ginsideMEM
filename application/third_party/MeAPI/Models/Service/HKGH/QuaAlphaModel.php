<?php
class QuaAlphaModel extends CI_Model {
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
                $arrData['item_old']        = $v['item_old'];
                $arrData['item_new']        = $v['item_new'];
                $this->_db_slave->insert('event_quaalpha_user',$arrData);
            }
        }
    }
}