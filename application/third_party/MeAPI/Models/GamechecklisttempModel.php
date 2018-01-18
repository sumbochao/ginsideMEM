<?php
class GamechecklisttempModel extends CI_Model {
    private $_db_slave;
    public $_table_request = 'tbl_request_game';
	public $_table_request_history='tbl_request_history';
	/*public $_table_checklist = 'tbl_game_template_checklist';
	public $_table_result = 'tbl_result_game_template_checklist';
	 public $_table_cate = 'tbl_categories';*/
	 
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

    public function listItem($arrParam=NULL,$options=null){
		if($options=="user"){
			$sqlgetrequset="select gr.id_request from tbl_grand_request_group as gr JOIN tbl_grand_request_group_support as support 
	on (gr.id_request = support.id_request) where gr.id_group in(".$arrParam['id_group'].") or support.id_group in(".$arrParam['id_group'].")";
			
			$sql="select gm.*,temp.id_request,temp.id_categories,temp.id_template from ".$this->_table_checklist." as gm inner join ".$this->_table." as temp on(gm.id_template = temp.id_template) inner join ".$this->_table_cate." as cate on(temp.id_categories=cate.id) where  gm.id_game=".$arrParam['id_game']." and gm.id_template=".$arrParam['id_template']." and temp.id_request in (".$sqlgetrequset.") and cate.`status`=0 order by temp.id_categories";
		}else{
			$sql="select gm.*,temp.id_request,temp.id_categories,temp.id_template from ".$this->_table_checklist." as gm inner join ".$this->_table." as temp on(gm.id_template = temp.id_template) inner join ".$this->_table_cate." as cate on(temp.id_categories=cate.id) where  gm.id_game=".$arrParam['id_game']." and gm.id_template=".$arrParam['id_template']." and cate.`status`=0 order by temp.id_categories";
		}
		
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
        
    }
	
	public function delresultold($arrParam=NULL,$options=null){
		$isok=true;
		try{
			//đầu tiên xóa rows với điều kiện id_template và id_game
			$sql_del="delete from ".$this->_table_result." where id_game=".$arrParam['id_game']." and  id_template=".$arrParam['id_template'];
			$del = $this->_db_slave->query($sql_del);
			$isok=true;
		}catch(Exception $e){
			$isok=false;
		}
		return $isok;
	}
	public function addresult($arrParam=NULL,$options=null){
		$isok=true;
		try{
			$rs=$this->_db_slave->insert($this->_table_result,$arrParam);
			$isok=true;
		}catch(Exception $e){
			$isok=false;
		}
		return $isok;
	}
	public function listItemGameChecklist($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
		$this->_db_slave->where('id_template',$arrParam['id_template']);
        $this->_db_slave->from($this->_table_checklist);
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
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
    public function getItem($param){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table_request)
                        ->where('id',$param['id_request'])
						->where('id_game', $param['id_game'])
						->where('id_categories',$param['id_categories'])
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
	public function edit_new($arrParam,$id) {
		$this->_db_slave->where('id', $id);
		$id=$this->_db_slave->update($this->_table,$arrParam);
		
		return $id;
		
    }
	public function edit_idcategories($arrParam,$arrWhere) {
		$this->_db_slave->where('id_template', $arrWhere['id_template']);
		$this->_db_slave->where('id_categories', $arrWhere['id_categories']);
		$this->_db_slave->where('id_request', $arrWhere['id_request']);
		$id=$this->_db_slave->update($this->_table_result,$arrParam);
		
		return $id;
		
    }
	public function listGame(){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('id','service_id','app_fullname'));
       $this->db_slave->where('app_type',0);
       $this->db_slave->or_where('app_type',1);
        $this->db_slave->order_by('id','DESC');
        $data = $this->db_slave->get('scopes');
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if(count($result)>0){
                foreach($result as $v){
                    $arrResult[$v['service_id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }
	
	 public function updateresultchecklistuser($arrWhere,$arrParam){
		 $arr=array();
		 switch($arrParam['types']){
				case 'android':
				     $arr=array(
							'result_android'=>$arrParam['client_result'],
							'notes_android'=>$arrParam['client_notes'],
							'dateusercheck_android' => date('y-m-d H:i:s'),
							'usercheck_android' => $arrParam['user_check']
						 );
				break;
				case 'ios':
					$arr=array(
							'result_ios'=>$arrParam['client_result'],
							'notes_ios'=>$arrParam['client_notes'],
							'dateusercheck_ios' => date('y-m-d H:i:s'),
							'usercheck_ios' => $arrParam['user_check']
						 );
				break;
				case 'wp':
					$arr=array(
							'result_wp'=>$arrParam['client_result'],
							'notes_wp'=>$arrParam['client_notes'],
							'dateusercheck_wp' => date('y-m-d H:i:s'),
							'usercheck_wp' => $arrParam['user_check']
						 );
				break;
				case 'pc':
					$arr=array(
							'result_pc'=>$arrParam['client_result'],
							'notes_pc'=>$arrParam['client_notes'],
							'dateusercheck_pc' => date('y-m-d H:i:s'),
							'usercheck_pc' => $arrParam['user_check']
						 );
				break;
				case 'web':
					$arr=array(
							'result_web'=>$arrParam['client_result'],
							'notes_web'=>$arrParam['client_notes'],
							'dateusercheck_web' => date('y-m-d H:i:s'),
							'usercheck_web' => $arrParam['user_check']
						 );
				break;
				case 'events':
					$arr=array(
							'result_events'=>$arrParam['client_result'],
							'notes_events'=>$arrParam['client_notes'],
							'dateusercheck_events' => date('y-m-d H:i:s'),
							'usercheck_events' => $arrParam['user_check']
						 );
				break;
				case 'systems':
					$arr=array(
							'result_systems'=>$arrParam['client_result'],
							'notes_systems'=>$arrParam['client_notes'],
							'dateusercheck_systems' => date('y-m-d H:i:s'),
							'usercheck_systems' => $arrParam['user_check']
						 );
				break;
				case 'orther':
					$arr=array(
							'result_orther'=>$arrParam['client_result'],
							'notes_orther'=>$arrParam['client_notes'],
							'dateusercheck_orther' => date('y-m-d H:i:s'),
							'usercheck_orther' => $arrParam['user_check']
						 );
				break;
			}
			
           //update
		    $this->_db_slave->where('id_game', $arrWhere['id_game']);
			$this->_db_slave->where('id_categories', $arrWhere['id_categories']);
			$this->_db_slave->where('id', $arrWhere['id_request']);
			$id=$this->_db_slave->update($this->_table_request,$arr);
			return $id;
        
    }
	
	public function updateresultchecklistadmin($arrWhere,$arrParam){
		 $arr=array();
		 switch($arrParam['types']){
				case 'android':
				     $arr=array(
							'result_admin_android'=>$arrParam['admin_result'],
							'notes_admin_android'=>$arrParam['admin_notes'],
							'dateadmincheck_android' => date('y-m-d H:i:s'),
							'admincheck' => $arrParam['admin_check']
						 );
				break;
				case 'ios':
					$arr=array(
							'result_admin_ios'=>$arrParam['admin_result'],
							'notes_admin_ios'=>$arrParam['admin_notes'],
							'dateadmincheck_ios' => date('y-m-d H:i:s'),
							'admincheck' => $arrParam['admin_check']
						 );
				break;
				case 'wp':
					$arr=array(
							'result_admin_wp'=>$arrParam['admin_result'],
							'notes_admin_wp'=>$arrParam['admin_notes'],
							'dateadmincheck_wp' => date('y-m-d H:i:s'),
							'admincheck' => $arrParam['admin_check']
						 );
				break;
				case 'pc':
					$arr=array(
							'result_admin_pc'=>$arrParam['admin_result'],
							'notes_admin_pc'=>$arrParam['admin_notes'],
							'dateadmincheck_pc' => date('y-m-d H:i:s'),
							'admincheck' => $arrParam['admin_check']
						 );
				break;
				case 'web':
					$arr=array(
							'result_admin_web'=>$arrParam['admin_result'],
							'notes_admin_web'=>$arrParam['admin_notes'],
							'dateadmincheck_web' => date('y-m-d H:i:s'),
							'admincheck' => $arrParam['admin_check']
						 );
				break;
				case 'events':
					$arr=array(
							'result_admin_events'=>$arrParam['admin_result'],
							'notes_admin_events'=>$arrParam['admin_notes'],
							'dateadmincheck_events' => date('y-m-d H:i:s'),
							'admincheck' => $arrParam['admin_check']
						 );
				break;
				case 'systems':
					$arr=array(
							'result_admin_systems'=>$arrParam['admin_result'],
							'notes_admin_systems'=>$arrParam['admin_notes'],
							'dateadmincheck_systems' => date('y-m-d H:i:s'),
							'admincheck' => $arrParam['admin_check']
						 );
				break;
				case 'orther':
					$arr=array(
							'result_admin_orther'=>$arrParam['admin_result'],
							'notes_admin_orther'=>$arrParam['admin_notes'],
							'dateadmincheck_orther' => date('y-m-d H:i:s'),
							'admincheck' => $arrParam['admin_check']
						 );
				break;
			}
			
           //update
		    $this->_db_slave->where('id_game', $arrWhere['id_game']);
			$this->_db_slave->where('id_categories', $arrWhere['id_categories']);
			$this->_db_slave->where('id', $arrWhere['id_request']);
			$id=$this->_db_slave->update($this->_table_request,$arr);
			return $id;
        
    }
	
	public function statisticalsub($param){
		if($param['group']!="" && $param['group']!=-10){
			$sql="select * from ".$this->_table_request." where id_game=".$param['id_game']." and id in(select id_request from tbl_grand_request_group_game where id_game=".$param['id_game']." and id_group=".$param['group']." and id_request in(select id from tbl_request_game where id_game=".$param['id_game']." and id_categories=".$param['id_categories']."))";
			$data = $this->_db_slave->query($sql);
			if (is_object($data)) {
				$result = $data->result_array();
			}
		}else{
			$sql="select * from ".$this->_table_request." where id_game=".$param['id_game']." and id_categories=".$param['id_categories'];
			$data = $this->_db_slave->query($sql);
			if (is_object($data)) {
				$result = $data->result_array();
			}
		}//end if
		
		return $result;
	}//end func
	
	public function statisticalsub_plus($param){
		if($param['group']!="" && $param['group']!=-10){
			/*$sql_gr="select DISTINCT r.id_categories from tbl_request_game as r INNER JOIN tbl_categories_game as c on (r.id_categories=c.id) where r.id_game=".$param['id_game']." and r.id in(select DISTINCT id_request from tbl_grand_request_group_game where id_game=".$param['id_game']." and id_group=".$param['group'].") and c.id_parrent='".$param['id_categories']."'";*/
			$sql="select id_request from tbl_grand_request_group_game where id_group=".$param['group']." and id_request in(
select id from tbl_request_game where id_game=".$param['id_game']." and id_categories in(
select id from tbl_categories_game where id_game=".$param['id_game']." and id_parrent='".$param['id_categories']."'))";
			$d = $this->_db_slave->query($sql);
			$r = $d->result_array();
			foreach($r as $it){
				$arr_n=$arr_n.$it['id_request'].",";
			}
			//chuyen thang mang
			$arr00=explode(',',$arr_n);
			//xoa phan tu cuoi
			unset($arr00[count($arr00)-1]);
			$mang0=implode(',',$arr00)==""?0:implode(',',$arr00);
			//buoc 2
			// loc hang muc co hang muc cha la $param['id_categories']
			$sql="select * from ".$this->_table_request." where id_game=".$param['id_game']." and id in(".$mang0.")";
			$data = $this->_db_slave->query($sql);
			if (is_object($data)) {
				$result = $data->result_array();
			}
		}else{
			// loc hang muc co hang muc cha la $param['id_categories']
			$sql_filter="select id from tbl_categories_game where id_game=".$param['id_game']." and id_parrent='".$param['id_categories']."' ";
			$data1 = $this->_db_slave->query($sql_filter);
			$result1 = $data1->result_array();
			foreach($result1 as $it1){
				$arr0=$arr0.$it1['id'].",";
			}
			//chuyen thang mang
			$arr10=explode(',',$arr0);
			//xoa phan tu cuoi
			unset($arr10[count($arr10)-1]);
			$mang=implode(',',$arr10)==""?0:implode(',',$arr10);
			
			$sql="select * from ".$this->_table_request." where id_game=".$param['id_game']." and id_categories in(".$mang.")";
			$data = $this->_db_slave->query($sql);
			if (is_object($data)) {
				$result = $data->result_array();
			}
		}//end if
		
		
		return $result;
	} //end func
	
	public function CheckStatusGame($id_game){
		$sql="select * from tbl_game_template_checklist where id_game=$id_game";
		$data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->row_array();
            return $result['status'];
        }
		
	}
	
	//29/02/2016
	//hàm ghi nhật ký đánh checklist
	public function SaveHistory($arrParam){
		$id=$this->_db_slave->insert($this->_table_request_history,$arrParam);
		$id = $this->_db_slave->insert_id();
		return $id;
	}
	
	public function listLogChecklist($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
		$this->_db_slave->where('id_request',$arrParam['id_request']);
		$this->_db_slave->where('id_game',$arrParam['id_game']);
		$this->_db_slave->where('type',$arrParam['type']);
		$this->_db_slave->where('type_account',$arrParam['type_account']);
        $this->_db_slave->from($this->_table_request_history);
        $this->_db_slave->order_by('id','DESC');
        
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	
	//12/04/2016
	public function GetUserSendMail($id_request,$id_game){
			$sql="select id_group from tbl_grand_request_group_game where id_game=".$id_game." and id_request=".$id_request."";
			$data = $this->_db_slave->query($sql);
			if (is_object($data)) {
				$result = $data->result_array();
			}
			
			foreach($result as $v){
				$arr0=$arr0.$v['id_group'].",";
			}
			
			//chuyen thang mang
			$arr10=explode(',',$arr0);
			//xoa phan tu cuoi
			unset($arr10[count($arr10)-1]);
			$mang=implode(',',$arr10)==""?0:implode(',',$arr10);
			
			$sql_f="select * from tbl_user_on_group where id_group in(".$mang.")";
			$data_f = $this->_db_slave->query($sql_f);
			if (is_object($data_f)) {
				return $data_f->result_array();
			}
			return false;
	}//end func
    public function userOnGroup($group){
        $sql = $this->_db_slave->select(array('*'))
                        ->from('tbl_user_on_group as g')
                        ->where_in('id_group', $group)
                        ->get();
        if (is_object($sql)) {
            return $sql->result_array();
        }
        return false;
    }
}