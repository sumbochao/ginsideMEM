<?php
class AppReviewModel extends CI_Model {
    private $_db_slave;
    private $_table='app_review';
    
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
                    $this->_db_slave->delete($this->_table,array('id' => $v)); 
                }
            }
        }else{
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
        }
    }
    public function listPackage($platform){
        $data = $this->_db_slave->select(array('p.id','p.platform','p.package_name'))
                        ->from('tbl_projects_property1 as p')
                        ->where('p.platform',$platform)
                        ->where('p.id_projects',29)
                        ->order_by('p.id' ,'ASC')
                        ->get();
        if (is_object($data)){
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    public function listItem($arrParam=NULL,$options=null){
        $data = $this->_db_slave->select(array('a.*','p.package_name'))
                        ->from($this->_table.' as a')
                        ->join('tbl_projects_property1 as p', 'p.id = a.id_projects', 'left')
                        ->order_by('a.status' ,'ASC')
                        ->get();
        if (is_object($data)){
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
            $arrData['type']            = $arrParam['type'];
            $arrData['id_projects']     = $arrParam['id_projects'];
            $arrData['version']         = $arrParam['version'];
            $arrData['status']          = $arrParam['status'];
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
            $arrData['type']            = $arrParam['type'];
            $arrData['id_projects']     = $arrParam['id_projects'];
            $arrData['version']         = $arrParam['version'];
            $arrData['status']          = $arrParam['status'];
            $this->_db_slave->insert($this->_table,$arrData);
            $id = $this->_db_slave->insert_id();
        }
        return $id;
    }
    public function listData(){
        $data = $this->_db_slave->select(array('a.*','p.package_name'))
                        ->from($this->_table.' as a')
                        ->join('tbl_projects_property1 as p', 'p.id = a.id_projects', 'left')
                        ->where('a.status' ,'0')
                        ->order_by('a.id' ,'DESC')
                        ->get();
        if (is_object($data)){
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    public function checkValidate($arrParam){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        $this->_db_slave->where('version', $arrParam['version']);
        $this->_db_slave->where('id_projects', $arrParam['id_projects']);
        if($arrParam['id']>0){
            $this->_db_slave->where('id !=', $arrParam['id']);
        }
        $data  = $this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->row_array();
            if($result['id_projects']>0){
                return 1;
            }else{
                return 2;
            }
        }
        return FALSE;
    }
}