<?php
class RequestModel extends CI_Model {
    private $_db_slave;
    public $_table='tbl_request';
	public $_table_group='tbl_grand_request_group';
	public $_table_group_support='tbl_grand_request_group_support';
	public $_table_template='tbl_template_checklist';
	public $_table_result_checklist='tbl_result_game_template_checklist';
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function listUser(){
        $data = $this->_db_slave->select(array('*'))
                        ->where('status',1)
                        ->from('account_name')
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
    public function deleteItem($arrParam,$options=NULL){
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $arrDelete = array();
                foreach($arrParam['cid'] as $v){
                    $filename = $this->getItem($v);
                    $this->_db_slave->delete($this->_table,array('id' => $v)); 
                }
            }
        }else{
			//xoa group thuoc yeu cau can xoa
			$this->_db_slave->delete($this->_table_group,array('id_request' => $arrParam['id']));
			$this->_db_slave->delete($this->_table_group_support,array('id_request' => $arrParam['id'])); 
			//xóa yêu cầu trong template, không cần đến id_template vì id yêu cầu không trùng với template khác
			$this->_db_slave->delete($this->_table_template,array('id_request' => $arrParam['id'])); 
			//xóa bảng kết quả tbl_result_game_template_checklist 
			$this->_db_slave->delete($this->_table_result_checklist,array('id_request' => $arrParam['id'],'id_template'=>$arrParam['id_template'],'id_categories'=>$arrParam['id_categories'])); 
			
			//cuối cùng xóa yêu cầu
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id']));
			
        }
    }
	 public function deletelistitem($id){
        $rs=$this->_db_slave->delete($this->_table,array('id' => $id));
		return $rs;
    }
	
	public function deleteoneitem($id){
		//kiem tra bang con co tham chieu den bang cha hay khong
		$data = $this->_db_slave->select(array('*'))
        				->from($this->_table_c)
						->where('id_projects', $id)
       					->get();
		$result = $data->result_array();
		if(count($result)==0){
        	$rs=$this->_db_slave->delete($this->_table,array('id' => $id));
		}else{
			$rs=NULL;
		}
		return $rs;
    }
	public function checktitleexist($id_categories,$titles){
		$data = $this->_db_slave->select(array('*'))
        				->from($this->_table)
						->where('id_categories', $id_categories)
						->where('titles', $titles)
       					->get();
		$result = $data->result_array();
		if(count($result)==0){
        	return false;
		}else{
			return true;
		}
		return true;
	}
    public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
		if($arrParam['titles']!=""){
			$this->_db_slave->like('titles',$arrParam['titles']);
		}
		if($arrParam['id_categories']!=""){
			$this->_db_slave->where('id_categories',$arrParam['id_categories']);
		}
        $this->_db_slave->from($this->_table);
		$this->_db_slave->order_by('sort','ASC');
        $this->_db_slave->order_by('id','DESC');
        
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
	public function getItemId(){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table)
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
	public function listPlatform(){
	   $arrResult=array("ios"=>"IOS","android"=>"Android","wp"=>"Winphone","none"=>"None Client(System/Inside/Web)");
       return $arrResult;
     
    }
    public function add_new($arrParam) {
		$id=$this->_db_slave->insert($this->_table,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
    }
	public function add_new_id($arrParam) {
		$id=$this->_db_slave->insert($this->_table,$arrParam);
		$id = $this->_db_slave->insert_id();
		//get id vừa add
		$sql="select max(id) as id from ".$this->_table."";
		$query=$this->_db_slave->query($sql);
		$r=$query->row_array();
		
		return $r['id'];
    }
	public function edit_new($arrParam,$id) {
		$this->_db_slave->where('id', $id);
		$id=$this->_db_slave->update($this->_table,$arrParam);
		return $id;
		
    }
	public function edit_rows_item($arrParam,$id){
		$this->_db_slave->where('id', $id);
		$id=$this->_db_slave->update($this->_table_c,$arrParam);
		return $id;
	}
	public function updatesort($arrParam,$id){
		$this->_db_slave->where('id', $id);
		$id=$this->_db_slave->update($this->_table,$arrParam);
		return $id;
	}
	
	//tranfer data
	public function GetRequestTranfer($id_categories){
        $this->_db_slave->select(array('*'));
		$this->_db_slave->where('id_categories',$id_categories);
        $this->_db_slave->from($this->_table);
		$this->_db_slave->order_by('sort','ASC');
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
   
}