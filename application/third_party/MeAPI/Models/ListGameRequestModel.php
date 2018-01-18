<?php
class ListGameRequestModel extends CI_Model {
    private $_db_slave;
    private $_table='tbl_listgame';
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function deleteItem($arrParam,$options=NULL){
        $items = $this->listItem();
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $arrDelete = array();
                foreach($arrParam['cid'] as $v){
                    $this->_db_slave->delete($this->_table,array('idx' => $v)); 
                }
            }
        }else{
            $this->_db_slave->delete($this->_table,array('idx' => $arrParam['id'])); 
        }
    }
    public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        $this->_db_slave->order_by('idx','DESC');
        if(!empty($arrParam['keyword'])){
            $this->_db_slave->where("(`name` LIKE '%{$arrParam['keyword']}%' or `alias` = '{$arrParam['keyword']}' or `gameID` = '{$arrParam['keyword']}' )", '', false); 
        }
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    public function getItem($id){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table)
                        ->where('idx', $id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
    public function saveItem($arrParam,$option= NULL){
        if($option['task']=='edit'){
            $arrData['gameID']              = $arrParam['gameID'];
            $arrData['name']                = $arrParam['name'];
            $arrData['alias']               = $arrParam['alias'];
            $arrData['url']                 = $arrParam['url'];
            $arrData['linkandroid']         = $arrParam['linkandroid'];
            $arrData['linkios']             = $arrParam['linkios'];
            $arrData['linkwp']              = $arrParam['linkwp'];
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
            $arrData['createDate']          = gmdate('Y-m-d G:i:s',time());
            $this->_db_slave->where('idx', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
            $arrData['gameID']              = $arrParam['gameID'];
            $arrData['name']                = $arrParam['name'];
            $arrData['alias']               = $arrParam['alias'];
            $arrData['url']                 = $arrParam['url'];
            $arrData['linkandroid']         = $arrParam['linkandroid'];
            $arrData['linkios']             = $arrParam['linkios'];
            $arrData['linkwp']              = $arrParam['linkwp'];
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
            $arrData['createDate']          = gmdate('Y-m-d G:i:s',time());
            $this->_db_slave->insert($this->_table,$arrData);
            $id = $this->_db_slave->insert_id();
        }
        return $id;
    }
    public function statusItem($arrParam,$options=NULL){
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $data= array('status'=>$arrParam['s']);
                $this->_db_slave->where_in('idx', $arrParam['cid']);
                $this->_db_slave->update($this->_table,$data);
            }
        }else{
            $status = ($arrParam['s']== 0 )? 1:0;
            $data= array('status'=>$status);
            $this->_db_slave->where('idx', $arrParam['id']);
            $this->_db_slave->update($this->_table,$data);
        }
    }
}

