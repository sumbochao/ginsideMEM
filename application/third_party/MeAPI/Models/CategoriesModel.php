<?php
class CategoriesModel extends CI_Model {
    private $_db_slave;
    public $_table='tbl_categories';
	public $_table_request='tbl_request';
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
       
	    //kiểm tra hạng mục cha hay con
		$sql_check="select * from ".$this->_table." where id_parrent='".$arrParam['id']."'";
		$r=$this->_db_slave->query($sql_check);
		$f=$r->result_array();
		if(count($f)>0){
			return;
		}
		//xóa group và yêu cầu trong template liên quan đến yêu cầu của hạng mục này
		$sql="delete from tbl_grand_request_group where id_request in(select id from tbl_request where id_categories=".$arrParam['id'].")";
		$sqlsupport="delete from tbl_grand_request_group_support where id_request in(select id from tbl_request where id_categories=".$arrParam['id'].")";
		$sqltemplate="delete from tbl_template_checklist where id_request in(select id from tbl_request where id_categories=".$arrParam['id'].")";
		//xóa Hạng mục nếu có trong bảng kết quả tbl_result_game_template_checklist
		$sqlresult="delete from tbl_result_game_template_checklist where id_template=".$arrParam['id_template']." and id_categories=".$arrParam['id']."";
		
		$this->_db_slave->query($sql);
		$this->_db_slave->query($sqlsupport);
		$this->_db_slave->query($sqltemplate);
		$this->_db_slave->query($sqlresult);
		
		//xóa yêu cầu nếu có trong hạng mục này
		$this->_db_slave->delete($this->_table_request,array('id_categories' => $arrParam['id']));
		//cuối cùng xóa hạng mục
		$this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
       
    }
	 public function deletelistitem($id){
        $rs=$this->_db_slave->delete($this->_table,array('id' => $id));
		return $rs;
    }

	public function checknamesexist($array){
		$data = $this->_db_slave->select(array('*'))
        				->from($this->_table)
						->where('names', $array['names'])
						->where('id_template', $array['id_template'])
       					->get();
		$result = $data->result_array();
		if(count($result)==0){
        	return false;
		}else{
			return true;
		}
		return true;
	}
	public function listCategorisParent(){
        $this->_db_slave->select(array('*'));
		$this->_db_slave->where("id_parrent","na");
        $this->_db_slave->from($this->_table);
		$this->_db_slave->order_by('order','ASC');
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	public function listCategorisParentInTemp($idtemp){
        $this->_db_slave->select(array('*'));
		$this->_db_slave->where("id_template",$idtemp);
		$this->_db_slave->where("id_parrent","na");
        $this->_db_slave->from($this->_table);
		$this->_db_slave->order_by('order','ASC');
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
		if($arrParam['names']!=""){
			$this->_db_slave->like('names',$arrParam['names']);
		}
		if($arrParam['id_template']!=""){
			$this->_db_slave->where('id_template',$arrParam['id_template']);
		}
		if($options=="c"){
			$this->_db_slave->where('id_parrent !=','na');
		}else{
			$this->_db_slave->where('id_parrent','na');
		}
        $this->_db_slave->from($this->_table);
		$this->_db_slave->order_by('order','ASC');
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
		
		//echo "<pre>";print_r($arrParam);echo "</pre>";
		//echo $this->_db_slave->last_query();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
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

	public function listPlatform(){
	   $arrResult=array("ios"=>"IOS","android"=>"Android","wp"=>"Winphone");
       return $arrResult;
     
    }
    public function add_new($arrParam) {
		$id=$this->_db_slave->insert($this->_table,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
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
	public function updatestatus($arr){
		$t=$arr['status']==0?1:0;
		$sql="update ".$this->_table." set `status`=".$t." where id=".$arr['id'];
		$data=$this->_db_slave->query($sql);
		return $data;
	}
	public function updatesort($arrParam,$id){
		$this->_db_slave->where('id', $id);
		$id=$this->_db_slave->update($this->_table,$arrParam);
		return $id;
	}
	
	//tranfer data
	public function GetCateParent($id_template){
		$this->_db_slave->select(array('*'));
		$this->_db_slave->where('id_template',$id_template);
		$this->_db_slave->where('id_parrent','na');
        $this->_db_slave->from($this->_table);
		$this->_db_slave->order_by('order','ASC');
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
	}
	public function GetCateChild($id_template,$idparent){
		$this->_db_slave->select(array('*'));
		$this->_db_slave->where('id_template',$id_template);
		$this->_db_slave->where('id_parrent',$idparent);
        $this->_db_slave->from($this->_table);
		$this->_db_slave->order_by('order','ASC');
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
	}
	
	public function ShowRequestTemp($id_template){
		$sql="select res.* from tbl_request as res inner join tbl_categories as cate on(res.id_categories=cate.id) where cate.id_template=".$id_template;
		$data=$this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	}
	
	public function listGameChecklist($id_temp){
        $this->_db_slave->select(array('*'));
		$this->_db_slave->where("id_template",$id_temp);
        $this->_db_slave->from("tbl_game_template_checklist");
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
   
}