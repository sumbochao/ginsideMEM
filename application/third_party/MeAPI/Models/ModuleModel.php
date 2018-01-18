<?php
class ModuleModel extends CI_Model {
    private $_db_slave;
    private $_table='module';
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
    }
    public function deleteItem($arrParam,$options=NULL){
        $items = $this->listItem();
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $arrDelete = array();
                foreach($arrParam['cid'] as $v){
                    $result = process($items,$v);
                    $arrDelete[] = $v;
                    if(count($result)>0){
                        foreach ($result as $val_1){
                            $arrDelete[] = $val_1['id'];
                        }
                    }
                }
                $arrDelete = array_unique($arrDelete);
                if(count($arrDelete)>0){
                    foreach ($arrDelete as $val){
                        $this->_db_slave->delete($this->_table,array('id' => $val)); 
                        $this->_db_slave->delete('module_user',array('id_permisssion' => $val)); 
                    }
                }
            }
        }else{
            $result = process($items,$arrParam['id']);
            $arrDelete = array($arrParam['id']);
            if(count($result)>0){
                foreach($result as $v){
                    $arrDelete[] = $v['id'];
                }
            }
            if(count($arrDelete)>0){
                foreach($arrDelete as $v){
                    $this->_db_slave->delete($this->_table,array('id' => $v));
                    $this->_db_slave->delete('module_user',array('id_permisssion' => $v)); 
                }
            }
        }
    }
    public function listItem($arrParam=NULL,$options=null){  
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        if(!empty($arrParam['colm']) && !empty($arrParam['order'])){
            $this->_db_slave->order_by($arrParam['colm'] , $arrParam['order']);
        }
        if(!empty($arrParam['keyword'])){
            $this->_db_slave->where("(`name` LIKE '%{$arrParam['keyword']}%' or `controller` LIKE '%{$arrParam['keyword']}%' OR `action` LIKE '%{$arrParam['keyword']}%')", '', false); 
        }
        if($options['task'] == 'remove-id'){
            $this->_db_slave->where('id !=',$arrParam['id']);
        }
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            if($options['task'] == 'delete'){
                $result = process($result,$arrParam['id']);
            }else{
                $result = process($result,0);
            }
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
            $arrData['name']        = $arrParam['name'];
            $arrData['parents']     = $arrParam['parents'];
            
        if($arrParam['id_type']==1){
            $arrData['game']    = $arrParam['game'];
            $arrData['controller']  = '';
            $arrData['action']      = '';
        }elseif($arrParam['id_type']==3){
            $arrData['controller']    = $arrParam['controller'];
            $arrData['action']  = $arrParam['action'];
            $arrData['report_game']      = $arrParam['report_game'];
        }else{
            $arrData['game']    = '';
            $arrData['controller']  = $arrParam['controller'];
            $arrData['action']      = $arrParam['action'];
			$arrData['report_game']      ='';
        }
			$arrData['layout']       = $arrParam['layout'];
			$arrData['module']      = $arrParam['module'];
            $arrData['order']       = $arrParam['order'];
            $arrData['modified']    = time();
			$arrData['status']     = 1;
            $arrData['id_type']     = $arrParam['id_type'];
			$arrData['per_game']     = $arrParam['per_game'];
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
            $arrData['name']        = $arrParam['name'];
            $arrData['parents']     = $arrParam['parents'];
            $arrData['controller']  = $arrParam['controller'];
            $arrData['action']      = $arrParam['action'];
            $arrData['game']        = $arrParam['game'];
            $arrData['report_game'] = $arrParam['report_game'];
			$arrData['layout']       = $arrParam['layout'];
			$arrData['module']      = $arrParam['module'];
            $arrData['created']     = time();
            $arrData['modified']    = time();
            $arrData['id_type']     = $arrParam['id_type'];
			$arrData['per_game']     = $arrParam['per_game'];
			$arrData['status']     = 1;
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
	public function deleteItemGame($arrParam){
        $this->_db_slave->delete('module_user',array('id_permisssion' => $arrParam['id_permisssion'],'id_game'=>$arrParam['id_game'])); 
    }
}

