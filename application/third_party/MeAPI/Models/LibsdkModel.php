<?php
class LibsdkModel extends CI_Model {
    private $_db_slave;
    private $_table='tbl_libsdk_info';
	private $_table_projects='tbl_projects';
	private $_table_projects_pro='tbl_projects_property1';
    
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
    public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        $this->_db_slave->order_by('id','DESC');
		if(isset($arrParam['cbo_platform']) || isset($arrParam['keyword']) || isset($arrParam['game_code'])){
			if($arrParam['cbo_platform']!="0" && $arrParam['cbo_platform']!=""){
				$this->_db_slave->where('platform',$arrParam['cbo_platform']);
			}
			if($arrParam['keyword']!=""){
				$this->_db_slave->like('sdkversion', $arrParam['keyword']);
			}
			if($arrParam['game_code']!=""){
				$this->_db_slave->like('game_code', $arrParam['game_code']);
			}
			$data=$this->_db_slave->get();
			
			if (is_object($data)) {
				$result = $data->result_array();
				return $result;
			}
		}
        return FALSE;
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
    public function saveItem($arrParam){
		//kiểm tra trùng thông tin
		//$sql="select * from ".$this->_table." where game_code='".$arrParam['game_code']."' and platform='".$arrParam['platform']."' and sdkversion='".$arrParam['sdkversion']."'";
	    $sql="select * from ".$this->_table." where game_code='".$arrParam['game_code']."' and platform='".$arrParam['platform']."' and sdkversion='".$arrParam['sdkversion']."' and story_stype='".$arrParam['story_stype']."' and package_name='".$arrParam['package_name']."'";
		$r=$this->_db_slave->query($sql);
		$count=$r->num_rows();
		if($count==0){
			$rs = $this->_db_slave->insert($this->_table,$arrParam);
			return TRUE;
		}else{
			return FALSE;
		}
    }
	 public function updateItem($arrParam,$option= NULL){
		$this->_db_slave->where('id',$option);
		$rs=$this->_db_slave->update($this->_table,$arrParam);
		return $rs;
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
    public function listGame(){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('id','app_fullname','service_id','service'));
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
    public function listTableApp(){
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
    }
   
    public function getGame($id){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $data = $this->db_slave->select(array('*'))
                        ->from('scopes')
                        ->where('id', $id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
    public function getApp($id){
        $data = $this->_db_slave->select(array('*'))
                        ->where('status',1)
                        ->where('id',$id)
                        ->from('sign_config_cert')
                        ->get();
        if (is_object($data)) {
            $result = $data->row_array();
            return $result;
        }
        return FALSE;
    }
	
	public function GetBundleProjects($arrParam=NULL){
		//b1. lấy id bảng Projects thông qua khóa servicekeyapp
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table_projects);
        $this->_db_slave->where('servicekeyapp',$arrParam['service']);
        $data=$this->_db_slave->get();
        $record=$data->row_array();
		$id_projects=$record['id']; // lấy id bảng projects
		//b2. lấy thông tin bảng con của projects 
		$cert_name=$arrParam['cert_name']=="Inhouse"?$arrParam['cert_name']:"Appstore";
		$this->_db_slave->select(array('*'));
			$this->_db_slave->from($this->_table_projects_pro);
		if($arrParam['platform']=="ios"){	
			$this->_db_slave->where('id_projects',$id_projects);
			$this->_db_slave->where('platform',$arrParam['platform']);
			$this->_db_slave->where('cert_name',$cert_name);
		}else{
			$this->_db_slave->where('id_projects',$id_projects);
			$this->_db_slave->where('platform',$arrParam['platform']);
		}
		$data1=$this->_db_slave->get();
        if (is_object($data1)) {
            $result = $data1->result_array();
            return $result;
        }
        return FALSE;
    }
	//hàm lấy MeStoreVersion
	public function listMsvforLibsdk($arrParam){
		// tim msv_id da public
		//do msv không có bản GooglePlay,WinStore nên sẽ lấy msv thoe bản Appstore
		$type_app=$arrParam['type_app']=="Inhouse"?$arrParam['type_app']:"Appstore";
		
		$sql="select msv_id,SUBSTRING(msv_id,5) as MSVID from tbl_get_msv where service_id=".$arrParam['service_id']." and published in('yes','waiting') and type_app='".$type_app."' and platform='".$arrParam['platform']."' and bunlderid='".$arrParam['bunlde_name']."' ORDER BY SUBSTRING(msv_id,5) desc limit 1";
		
		$data1=$this->_db_slave->query($sql);
		$rs=$data1->result_array();
		$msvid=$rs[0]['MSVID']==""?0:$rs[0]['MSVID'];
		
        $data = $this->_db_slave->select(array('*'))
                        ->where('service_id',$arrParam['service_id'])
						->where('published','no')
						->where('type_app',$type_app)
						->where('platform',$arrParam['platform'])
						->where('bunlderid',$arrParam['bunlde_name'])
						->where('SUBSTRING(msv_id,5) >= '.$msvid)
                        ->from('tbl_get_msv')
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

}