<?php
class SignConfigAppModel extends CI_Model {
    private $_db_slave;
    private $_table='sign_config_app';
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    
    public function deleteItem($arrParam,$options=NULL){
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $arrDelete = array();
                foreach($arrParam['cid'] as $v){
                    $filename = $this->getItem($v);
                    @unlink(FILE_PATH . '/'.$filename['provision']);
                    @unlink(FILE_PATH . '/'.$filename['entitlements']);
                    $this->_db_slave->delete($this->_table,array('id' => $v)); 
                }
            }
        }else{
            $filename = $this->getItem($arrParam['id']);
            @unlink(FILE_PATH . '/'.$filename['provision']);
            @unlink(FILE_PATH . '/'.$filename['entitlements']);
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
        }
    }
    public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        if(!empty($arrParam['colm']) && !empty($arrParam['order'])){
            $this->_db_slave->order_by($arrParam['colm'] , $arrParam['order']);
        }
        if($arrParam['id_game']>0){
            $this->_db_slave->where('id_game',$arrParam['id_game']);
        }
        if($arrParam['cert_id']>0){
            $this->_db_slave->where('cert_id',$arrParam['cert_id']);
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
			$part=explode("|",$arrParam['cbo_partner']);
            $arrData['id_game']                 = $arrParam['id_game'];
			$arrData['idpartner']                 = $part[0];
            $arrData['cert_id']                = $arrParam['cert_id'];
            $arrData['provision']               = $arrParam['provision'];
            $arrData['entitlements']            = $arrParam['entitlements'];
            $arrData['bundleidentifier']        = $arrParam['bundleidentifier'];
            $arrData['order']                   = $arrParam['order'];
            $arrData['modified']                = time();
            $arrData['status']                  = !empty($arrParam['status'])?$arrParam['status']:0;
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
			$part=explode("|",$arrParam['cbo_partner']);
            $arrData['id_game']                 = $arrParam['id_game'];
			$arrData['idpartner']                 = $part[0];
            $arrData['cert_id']                = $arrParam['cert_id'];
            $arrData['provision']               = $arrParam['provision'];
            $arrData['entitlements']            = $arrParam['entitlements'];
            $arrData['bundleidentifier']        = $arrParam['bundleidentifier'];
            
            $arrData['created']     = time();
            $arrData['modified']    = time();
            $arrData['status']      = !empty($arrParam['status'])?$arrParam['status']:0;
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
    public function listGame(){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('id','app_fullname'));
        $this->db_slave->where('app_type',0);
        $this->db_slave->or_where('app_type',1);
        $this->db_slave->order_by('id','DESC');
        $data = $this->db_slave->get('scopes');
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if(count($result)>0){
                foreach($result as $v){
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }
   /* public function listTableApp(){
        $data = $this->_db_slave->select(array('*'))
                        ->where('status',1)
                        ->from('sign_config_cert')
                        ->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if(count($result)>0){
                foreach($result as $v){
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }*/
	 public function listTableApp(){
        $data = $this->_db_slave->select(array('*'))
                        ->from('tbl_sign_config_cert')
                        ->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if(count($result)>0){
                foreach($result as $v){
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }
    
    public function removeFile($arrParam){
        $data = array(
            'provision'=>'',
        );
        $this->_db_slave->where_in('id',$arrParam['id']);
        $this->_db_slave->update($this->_table,$data);
    }
    public function removeEntitlements($arrParam){
        $data = array(
            'entitlements'=>'',
        );
        $this->_db_slave->where_in('id',$arrParam['id']);
        $this->_db_slave->update($this->_table,$data);
    }
}

