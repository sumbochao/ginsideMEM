<?php
class RequestCatModel extends CI_Model {
    private $_db_slave;
    private $_table='tbl_request_cat';
    
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
        $this->_db_slave->select(array("q.*,DATE_FORMAT(q.startDate,'%d-%m-%Y %H:%i:%S') as startDate,DATE_FORMAT(q.endDate,'%d-%m-%Y %H:%i:%S') as endDate"));
        $this->_db_slave->from($this->_table.' as q');
        if(!empty($arrParam['colm']) && !empty($arrParam['order'])){
            $this->_db_slave->order_by($arrParam['colm'] , $arrParam['order']);
        }
        if($arrParam['configID']>0){
            $this->_db_slave->where("configID",$arrParam['configID'], false); 
        }
        if($arrParam['gameID']>0){
            $this->_db_slave->where("gameID",$arrParam['gameID'], false); 
        }
        if(!empty($arrParam['keyword'])){
            $this->_db_slave->where("(`name` LIKE '%{$arrParam['keyword']}%')", '', false); 
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
        $newStartdate = new DateTime($arrParam['startDate']);
        $startDate = $newStartdate->format('Y-m-d H:i:s');
        
        $newEnddate = new DateTime($arrParam['endDate']);
        $endDate = $newEnddate->format('Y-m-d H:i:s');
        
        if(count($arrParam['receiveGame'])>0){
            if($arrParam['receiveGame']['0']=='multiselect-all'){
                array_shift($arrParam['receiveGame']);
                $receiveGame = implode(',', $arrParam['receiveGame']);
            }else{
                $receiveGame = implode(',', $arrParam['receiveGame']);
            }
        }else{
            $receiveGame = '';
        }
        if($option['task']=='edit'){
            $arrData['configID']            = $arrParam['configID'];
            $arrData['name']                = $arrParam['name'];
            $arrData['url']                 = $arrParam['url'];
            $arrData['desc']                = $arrParam['desc'];
            $arrData['startDate']           = $startDate;
            $arrData['endDate']             = $endDate;
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
            $arrData['gameID']              = $arrParam['gameID'];
            $arrData['receiveGame']         = $receiveGame;
            $this->_db_slave->where('idx', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
            
            $arrData['configID']            = $arrParam['configID'];
            $arrData['name']                = $arrParam['name'];
            $arrData['url']                 = $arrParam['url'];
            $arrData['desc']                = $arrParam['desc'];
            $arrData['startDate']           = $startDate;
            $arrData['endDate']             = $endDate;
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
            $arrData['gameID']              = $arrParam['gameID'];
            $arrData['receiveGame']         = $receiveGame;
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
    public function sortItem($arrParam){
        $countlist = count($arrParam['listid']);
        for ($i = 0; $i < $countlist ; $i ++){
            $data = array('order'=>$arrParam['listorder'][$i]);
            $this->_db_slave->where('idx', $arrParam['listid'][$i]);
            $this->_db_slave->update($this->_table,$data);
        }
    }
    public function updateOrder($arrParam){
        $data = array(
            'order'=>(-1)*$arrParam['id']
        );
        $this->_db_slave->where('idx',$arrParam['id']);
        $this->_db_slave->update($this->_table,$data);
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

