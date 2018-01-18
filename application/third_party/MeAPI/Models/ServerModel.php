<?php
class ServerModel extends CI_Model {
    private $_db_slave;
    private $_table='server_list';
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
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
		if($_SESSION['account']['id_group']==2){
            $arrServerAll = array();
            if(is_array($this->slbScopes())){
                foreach($this->slbScopes() as $v){
                    $arrServerAll[$v['app_name']] = $v['app_name'];
                }
                
            }
			$arrServer = array_intersect($arrServerAll,$_SESSION['permission']);
        }
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        $this->_db_slave->order_by('id','DESC');
        if(!empty($arrParam['keyword'])){
            $this->_db_slave->where("(`server_name` LIKE '%{$arrParam['keyword']}%')", '', false); 
        }
        if(!empty($arrParam['game'])){
            $this->_db_slave->where("(`game` LIKE '%{$arrParam['game']}%')", '', false); 
        }
		if($_SESSION['account']['id_group']==2){
            $this->_db_slave->where_in("game",$arrServer, false);
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
        $date = new DateTime($arrParam['create_date']);
        $create_date =  $date->format('Y-m-d G:i:s');
        if($option['task']=='edit'){
            $arrData['server_id']           = $arrParam['server_id'];
            $arrData['server_name']         = $arrParam['server_name'];
            $arrData['server_game_address'] = $arrParam['server_game_address'];
            $arrData['create_date']         = $create_date;
            $arrData['game']                = $arrParam['game'];
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
			$arrData['server_id_merge']     = $arrParam['server_id_merge'];
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
            $arrData['server_id']           = $arrParam['server_id'];
            $arrData['server_name']         = $arrParam['server_name'];
            $arrData['server_game_address'] = $arrParam['server_game_address'];
            $arrData['create_date']         = $create_date;
            $arrData['game']                = $arrParam['game'];
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
			$arrData['server_id_merge']     = $arrParam['server_id'];
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
    public function slbScopes(){
        $data = $this->_db_slave->select(array('*'))
                        ->from('scopes')
                        ->where('app_type', 0)
                        ->get();
        if (is_object($data)) {
            $result = array();
            foreach($data->result_array() as $v){
                $result[$v['app_name']] = $v;
            }
            return $result;
        }
        
        return 0;
    }
	public function slbServerByGame($game){
        $data = $this->_db_slave->select(array('server_id','server_name'))
                        ->from('server_list')
                        ->where('game',$game)
                        ->get();
        if (is_object($data)) {
            $result = array();
            foreach($data->result_array() as $v){
                $result[$v['server_id']] = $v;
            }
            return $result;
        }
        
        return 0;
    }
}

