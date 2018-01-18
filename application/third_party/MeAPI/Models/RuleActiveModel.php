<?php
class RuleActiveModel extends CI_Model {
    private $_db_slave;
    private $_table='tbl_user_rule_active';
    
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
        $this->_db_slave->select(array("q.*,DATE_FORMAT(q.createDate,'%d-%m-%Y %H:%i:%S') as createDate"));
        $this->_db_slave->from($this->_table.' as q');
        $this->_db_slave->order_by('idx','DESC');
        if($arrParam['configID']>0){
            $this->_db_slave->where("configID",$arrParam['configID'], false); 
        }
        if($arrParam['gameID']>0){
            $this->_db_slave->where("gameID",$arrParam['gameID'], false); 
        }
        if(!empty($arrParam['keyword'])){
            $this->_db_slave->where("(`items` LIKE '%{$arrParam['keyword']}%')", '', false); 
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
        $arrItems = array();
        for($i=0;$i<count($arrParam['item_id']);$i++){
            $arrItems[] = array(
                'item_id' =>$arrParam['item_id'][$i],
                'name'=>$arrParam['name'][$i],
                'count'=>$arrParam['count'][$i],
                'rate'=>$arrParam['rate'][$i],
            );
        }
        $arrItemsReceive = array();
        for($i=0;$i<count($arrParam['item_id_receive']);$i++){
            $arrItemsReceive[] = array(
                'item_id' =>$arrParam['item_id_receive'][$i],
                'name'=>$arrParam['name_receive'][$i],
                'count'=>$arrParam['count_receive'][$i],
                'rate'=>$arrParam['rate_receive'][$i],
            );
        }
        if($option['task']=='edit'){
            $arrData['configID']            = $arrParam['configID'];
            $arrData['gameID']              = $arrParam['gameID'];
            $arrData['gamereceiveID']       = $arrParam['gamereceiveID'];
            $arrData['items']               = json_encode($arrItems);
            $arrData['items_receive']       = json_encode($arrItemsReceive);
            $arrData['statusRule']          = !empty($arrParam['statusRule'])?$arrParam['statusRule']:0;
            $arrData['jsonRule']            = $arrParam['jsonRule'];
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
            $arrData['createDate']          = gmdate('Y-m-d G:i:s',time());
            $this->_db_slave->where('idx', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
            $arrData['configID']            = $arrParam['configID'];
            $arrData['gameID']              = $arrParam['gameID'];
            $arrData['gamereceiveID']       = $arrParam['gamereceiveID'];
            $arrData['items']               = json_encode($arrItems);
            $arrData['items_receive']       = json_encode($arrItemsReceive);
            $arrData['statusRule']          = !empty($arrParam['statusRule'])?$arrParam['statusRule']:0;
            $arrData['jsonRule']            = $arrParam['jsonRule'];
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
    public function listConfig(){
        $data = $this->_db_slave->select(array('*'))
                        ->from('tbl_config_request')
                        ->get();
        if (is_object($data)) {
            $result = array();
            foreach($data->result_array() as $v){
                $result[$v['idx']] = $v;
            }
            return $result;
        }
        return 0;
    }
    public function listGame(){
        $data = $this->_db_slave->select(array('*'))
                        ->from('tbl_listgame')
                        ->where('status',1)
                        ->get();
        if (is_object($data)) {
            $result = array();
            foreach($data->result_array() as $v){
                $result[$v['gameID']] = $v;
            }
            return $result;
        }
        return 0;
    }
    public function listReceiveGame($gameID){
        $data = $this->_db_slave->select(array('*'))
                        ->from('tbl_listgame')
                        ->where('status',1)
                        ->where('gameID !=',$gameID)
                        ->get();
        if (is_object($data)) {
            $result = array();
            foreach($data->result_array() as $v){
                $result[$v['gameID']] = $v;
            }
            return $result;
        }
        return 0;
    }
}

