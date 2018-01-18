<?php
class GamechecklistModel extends CI_Model {
    private $_db_slave;
    public $_table = 'tbl_template_checklist';
	public $_table_checklist = 'tbl_game_template_checklist';
	public $_table_result = 'tbl_result_game_template_checklist';
	 public $_table_cate = 'tbl_categories';
	 
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
	
	 public function updateresultchecklist($arrWhere,$arrParam){
		 $arr=array();
		 switch($arrParam['types']){
				case 'android':
				     if($arrParam['is_account']=="user"){
						 $arr=array(
							'android'=>$arrParam['client_result'],
							'notes_clients_android'=>$arrParam['client_notes'],
							'result_admin_android'=>$arrParam['admin_result'],
							'notes_admin_android'=>$arrParam['admin_note'],
							'datecreate' => date('y-m-d H:i:s'),
							'daterequest' => date('y-m-d H:i:s'),
							'userlog' => $_SESSION['account']['id']
						 );
					 }else{
						  $arr=array(
							'android'=>$arrParam['client_result'],
							'notes_clients_android'=>$arrParam['client_notes'],
							'result_admin_android'=>$arrParam['admin_result'],
							'notes_admin_android'=>$arrParam['admin_note'],
							'dateadmincheck' => date('y-m-d H:i:s'),
							'admincheck' => $_SESSION['account']['id']
						 );
					 }
				break;
				case 'ios':
					if($arrParam['is_account']=="user"){
						 $arr=array(
							'ios'=>$arrParam['client_result'],
							'notes_clients_ios'=>$arrParam['client_notes'],
							'result_admin_ios'=>$arrParam['admin_result'],
							'notes_admin_ios'=>$arrParam['admin_note'],
							'datecreate' => date('y-m-d H:i:s'),
							'daterequest' => date('y-m-d H:i:s'),
							'userlog' => $_SESSION['account']['id']
						 );
					}else{
						$arr=array(
							'ios'=>$arrParam['client_result'],
							'notes_clients_ios'=>$arrParam['client_notes'],
							'result_admin_ios'=>$arrParam['admin_result'],
							'notes_admin_ios'=>$arrParam['admin_note'],
							'dateadmincheck' => date('y-m-d H:i:s'),
							'admincheck' => $_SESSION['account']['id']
						 );
					}
				break;
				case 'wp':
					if($arrParam['is_account']=="user"){
						 $arr=array(
							'wp'=>$arrParam['client_result'],
							'notes_clients_wp'=>$arrParam['client_notes'],
							'result_admin_wp'=>$arrParam['admin_result'],
							'notes_admin_wp'=>$arrParam['admin_note'],
							'datecreate' => date('y-m-d H:i:s'),
							'daterequest' => date('y-m-d H:i:s'),
							'userlog' => $_SESSION['account']['id']
						 );
					}else{
						$arr=array(
							'wp'=>$arrParam['client_result'],
							'notes_clients_wp'=>$arrParam['client_notes'],
							'result_admin_wp'=>$arrParam['admin_result'],
							'notes_admin_wp'=>$arrParam['admin_note'],
							'dateadmincheck' => date('y-m-d H:i:s'),
							'admincheck' => $_SESSION['account']['id']
						 );
					}
				break;
				case 'pc':
					if($arrParam['is_account']=="user"){
						 $arr=array(
							'pc'=>$arrParam['client_result'],
							'notes_clients_pc'=>$arrParam['client_notes'],
							'result_admin_pc'=>$arrParam['admin_result'],
							'notes_admin_pc'=>$arrParam['admin_note'],
							'datecreate' => date('y-m-d H:i:s'),
							'daterequest' => date('y-m-d H:i:s'),
							'userlog' => $_SESSION['account']['id']
						 );
					}else{
						 $arr=array(
							'pc'=>$arrParam['client_result'],
							'notes_clients_pc'=>$arrParam['client_notes'],
							'result_admin_pc'=>$arrParam['admin_result'],
							'notes_admin_pc'=>$arrParam['admin_note'],
							'dateadmincheck' => date('y-m-d H:i:s'),
							'admincheck' => $_SESSION['account']['id']
						 );
					}
				break;
				case 'web':
					if($arrParam['is_account']=="user"){
						 $arr=array(
							'web'=>$arrParam['client_result'],
							'notes_clients_web'=>$arrParam['client_notes'],
							'result_admin_web'=>$arrParam['admin_result'],
							'notes_admin_web'=>$arrParam['admin_note'],
							'datecreate' => date('y-m-d H:i:s'),
							'daterequest' => date('y-m-d H:i:s'),
							'userlog' => $_SESSION['account']['id']
						 );
					}else{
						 $arr=array(
							'web'=>$arrParam['client_result'],
							'notes_clients_web'=>$arrParam['client_notes'],
							'result_admin_web'=>$arrParam['admin_result'],
							'notes_admin_web'=>$arrParam['admin_note'],
							'dateadmincheck' => date('y-m-d H:i:s'),
							'admincheck' => $_SESSION['account']['id']
						 );
					}
				break;
				case 'events':
					if($arrParam['is_account']=="user"){
						 $arr=array(
							'events'=>$arrParam['client_result'],
							'notes_clients_events'=>$arrParam['client_notes'],
							'result_admin_events'=>$arrParam['admin_result'],
							'notes_admin_events'=>$arrParam['admin_note'],
							'datecreate' => date('y-m-d H:i:s'),
							'daterequest' => date('y-m-d H:i:s'),
							'userlog' => $_SESSION['account']['id']
						 );
					}else{
						$arr=array(
							'events'=>$arrParam['client_result'],
							'notes_clients_events'=>$arrParam['client_notes'],
							'result_admin_events'=>$arrParam['admin_result'],
							'notes_admin_events'=>$arrParam['admin_note'],
							'dateadmincheck' => date('y-m-d H:i:s'),
							'admincheck' => $_SESSION['account']['id']
						 );
					}
				break;
				case 'systems':
					if($arrParam['is_account']=="user"){
						 $arr=array(
							'systems'=>$arrParam['client_result'],
							'notes_clients_systems'=>$arrParam['client_notes'],
							'result_admin_systems'=>$arrParam['admin_result'],
							'notes_admin_systems'=>$arrParam['admin_note'],
							'datecreate' => date('y-m-d H:i:s'),
							'daterequest' => date('y-m-d H:i:s'),
							'userlog' => $_SESSION['account']['id']
						 );
					}else{
						 $arr=array(
							'systems'=>$arrParam['client_result'],
							'notes_clients_systems'=>$arrParam['client_notes'],
							'result_admin_systems'=>$arrParam['admin_result'],
							'notes_admin_systems'=>$arrParam['admin_note'],
							'dateadmincheck' => date('y-m-d H:i:s'),
							'admincheck' => $_SESSION['account']['id']
						 );
					}
				break;
				case 'orther':
					if($arrParam['is_account']=="user"){
						 $arr=array(
							'orther'=>$arrParam['client_result'],
							'notes_clients_orther'=>$arrParam['client_notes'],
							'result_admin_orther'=>$arrParam['admin_result'],
							'notes_admin_orther'=>$arrParam['admin_note'],
							'datecreate' => date('y-m-d H:i:s'),
							'daterequest' => date('y-m-d H:i:s'),
							'userlog' => $_SESSION['account']['id']
						 );
					}else{
						 $arr=array(
							'orther'=>$arrParam['client_result'],
							'notes_clients_orther'=>$arrParam['client_notes'],
							'result_admin_orther'=>$arrParam['admin_result'],
							'notes_admin_orther'=>$arrParam['admin_note'],
							'dateadmincheck' => date('y-m-d H:i:s'),
							'admincheck' => $_SESSION['account']['id']
						 );
					}
				break;
			}
			
		$sql_exist="select * from tbl_result_game_template_checklist where id_game=".$arrWhere['id_game']." and id_template=".$arrWhere['id_template']." and id_categories=".$arrWhere['id_categories']." and id_request=".$arrWhere['id_request']." limit 1";
        $data = $this->_db_slave->query($sql_exist);
        if($data->num_rows() > 0) {
           //update
		    $this->_db_slave->where('id_game', $arrWhere['id_game']);
			$this->_db_slave->where('id_template', $arrWhere['id_template']);
			$this->_db_slave->where('id_categories', $arrWhere['id_categories']);
			$this->_db_slave->where('id_request', $arrWhere['id_request']);
			$id=$this->_db_slave->update("tbl_result_game_template_checklist",$arr);
			return $id;
        }else{
		  // add new
			$arr['id_game']=$arrParam['id_game'];
			$arr['id_template']=$arrParam['id_temp'];
			$arr['id_categories']=$arrParam['id_cate'];
			$arr['id_request']=$arrParam['id_request'];
		  	$id=$this->_db_slave->insert("tbl_result_game_template_checklist",$arr);
			return $id;
		}
        return FALSE;
        
    }


   
}