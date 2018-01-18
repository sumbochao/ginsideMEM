<?php
class CategoriesGameModel extends CI_Model {
    private $_db_slave;
    public $_table='tbl_categories_game';
	public $_table_request='tbl_request_game';
	
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
		$sql="delete from tbl_grand_request_group_game where id_request in(select id from tbl_request_game where id_categories=".$arrParam['id'].")";
		$sqlsupport="delete from tbl_grand_request_group_support_game where id_request in(select id from tbl_request_game where id_categories=".$arrParam['id'].")";
		
		
		$this->_db_slave->query($sql);
		$this->_db_slave->query($sqlsupport);
		
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
						->where('names', trim($array['names']))
						->where('id_game', $array['id_game'])
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
	public function listCategorisParentInTempRequest($idgame){
		$this->_db_slave->select(array('*'));
		$this->_db_slave->where("id_game",$idgame);
		$this->_db_slave->where("id_parrent","na");
		$this->_db_slave->where("status","0");
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
	public function listCategorisParentInTemp($idgame,$id_template){
        $this->_db_slave->select(array('*'));
		$this->_db_slave->where("id_game",$idgame);
		if($id_template>0){
			$this->_db_slave->where("id_template",$id_template,false);
		}
		$this->_db_slave->where("id_parrent","na");
		$this->_db_slave->where("status","0");
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
	
	public function listItemGrand($arr_id_group,$id_template){
		$sql_con="select cate.id_parrent from tbl_categories as cate INNER JOIN tbl_request as res on(cate.id=res.id_categories) where res.id in(select gr.id_request from tbl_grand_request_group as gr JOIN tbl_grand_request_group_support as support on (gr.id_request = support.id_request) where gr.id_group in(".$arr_id_group.") or support.id_group in(".$arr_id_group.") ) and cate.id_template=".$id_template." and cate.id_parrent in(select id from tbl_categories where id_parrent='na') and cate.status=0  and cate.status=0 GROUP BY cate.id ORDER BY cate.`order` asc";
		$sql_cha="select * from tbl_categories where id in(".$sql_con.") and id_parrent='na' and id_template=".$id_template." order by `order` asc";
		$data=$this->_db_slave->query($sql_cha);
		$result = $data->result_array();
		return $result;
	}
    public function listItem($arrParam=NULL,$options=null){
		
        $this->_db_slave->select(array('*'));
		if($arrParam['names']!=""){
			$this->_db_slave->like('names',$arrParam['names']);
		}
		if($arrParam['id_game']!=""){
			$this->_db_slave->where('id_game',$arrParam['id_game']);
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
        
        $data=$this->_db_slave->get();//echo $this->_db_slave->last_query();die();
       
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
	public function GetCateChildGame($id_game,$idparent){
		$this->_db_slave->select(array('*'));
		$this->_db_slave->where('id_game',$id_game);
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
		$sql="select res.* from tbl_request as res inner join tbl_categories as cate on(res.id_categories=cate.id) where cate.id_template=".$id_template." cate.id_parrent <>'na'";
		$data=$this->_db_slave->query($sql);
		$result = $data->result_array();
		return $result;
	}
	
	//tìm kiếm hãng mục theo Goup
	public function listItemSerachOnGroup($id_game=NULL,$id_group=null){
		//buoc 1 lay id_request trong Group
		$arr="";
		$sql_b1="select id_request from tbl_grand_request_group_game 
where id_group=$id_group and id_game=$id_game";
		$data=$this->_db_slave->query($sql_b1);
		$result = $data->result_array();
		foreach($result as $it){
			$arr=$arr.$it['id_request'].",";
		}
		//chuyen thang mang
		$arr_plus=explode(',',$arr);
		//xoa phan tu cuoi
		unset($arr_plus[count($arr_plus)-1]);
		$mang_idrequest=implode(',',$arr_plus)==""?0:implode(',',$arr_plus);
		
		//buoc 2 lay id_cate trong bang request
		
		$sql_b2="select id_categories from tbl_request_game where id in(".$mang_idrequest.") and id_game=$id_game";
		
		$arr="";
		$arr_plus="";
		$data=NULL;
		$result=NULL;
		$arr_plus=NULL;
		
		$data=$this->_db_slave->query($sql_b2);
		$result = $data->result_array();
		foreach($result as $it){
			$arr=$arr.$it['id_categories'].",";
		}
		//chuyen thang mang
		$arr_plus=explode(',',$arr);
		//xoa phan tu cuoi
		unset($arr_plus[count($arr_plus)-1]);
		$mang_idcate=implode(',',$arr_plus)==""?0:implode(',',$arr_plus);
		
		//buoc 3 lay dc id_parrent 
		$sql_b3="select * from tbl_categories_game where id in(".$mang_idcate.") and id_game=$id_game";
		$arr="";
		$arr_plus="";
		$data=NULL;
		$result=NULL;
		$arr_plus=NULL;
		
		$data=$this->_db_slave->query($sql_b3);
		$result = $data->result_array();
		
		foreach($result as $it){
			$arr=$arr.$it['id_parrent'].",";
		}
		//chuyen thang mang
		$arr_plus=explode(',',$arr);
		//xoa phan tu cuoi
		unset($arr_plus[count($arr_plus)-1]);
		$mang_idparrent=implode(',',$arr_plus)==""?0:implode(',',$arr_plus);
		
		//buoc 4. finally 
		
		$sql_b4="select * from tbl_categories_game where id in(".$mang_idparrent.") and id_game=$id_game and id_parrent='na'";
		$data=NULL;
		$result=NULL;
		$data=$this->_db_slave->query($sql_b4);
		$result = $data->result_array();
		return $result;

    }
   
}