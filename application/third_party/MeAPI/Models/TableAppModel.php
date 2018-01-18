<?php
class TableAppModel extends CI_Model {
    private $_db_slave;
    private $_table='sign_config_cert';
    
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
                    $this->_db_slave->delete($this->_table,array('id' => $v)); 
                }
            }
        }else{
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
        }
    }
    public function listItem($arrParam=NULL,$options=null){  
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        if(!empty($arrParam['colm']) && !empty($arrParam['order'])){
            $this->_db_slave->order_by($arrParam['colm'] , $arrParam['order']);
        }
        if(!empty($arrParam['keyword'])){
            $this->_db_slave->where("(`version_name` LIKE '%{$arrParam['keyword']}%')", '', false); 
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
                        ->where('id', $id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
    public function saveItem($arrParam,$option= NULL){
        if($option['task']=='edit'){
            $arrData['version_name']    = $arrParam['version_name'];
            $arrData['cert_name']       = $arrParam['cert_name'];
            $arrData['order']           = $arrParam['order'];
            $arrData['modified']        = time();
            $arrData['status']          = !empty($arrParam['status'])?$arrParam['status']:0;
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
            $arrData['version_name']    = $arrParam['version_name'];
            $arrData['cert_name']       = $arrParam['cert_name'];
            $arrData['created']         = time();
            $arrData['modified']        = time();
            $arrData['status']          = !empty($arrParam['status'])?$arrParam['status']:0;
            $this->_db_slave->insert($this->_table,$arrData);
            $id = $this->_db_slave->insert_id();
        }
        return $id;
    }
    public function statusItem($arrParam,$options=NULL){
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $data= array('status'=>$arrParam['s']);
                $this->_db_slave->where_in('id', $arrParam['cid']);
                $this->_db_slave->update($this->_table,$data);
            }
        }else{
            $status = ($arrParam['s']== 0 )? 1:0;
            $data= array('status'=>$status);
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$data);
        }
    }
    
    public function sortItem($arrParam){
        $countlist = count($arrParam['listid']);
        for ($i = 0; $i < $countlist ; $i ++){
            $data = array('order'=>$arrParam['listorder'][$i]);
            $this->_db_slave->where('id', $arrParam['listid'][$i]);
            $this->_db_slave->update($this->_table,$data);
        }
    }
    public function updateOrder($arrParam){
        $data = array(
            'order'=>(-1)*$arrParam['id']
        );
        $this->_db_slave->where('id',$arrParam['id']);
        $this->_db_slave->update($this->_table,$data);
    }
}

