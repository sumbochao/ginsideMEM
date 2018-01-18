<?php
class SignConfigAppModel extends CI_Model {
    private $_db_slave;
    private $_table='sign_config_app';
	private $_table_projects='tbl_projects';
	private $_table_projects_pro='tbl_projects_property1';
    
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function listPlatform(){
	   $arrResult=array("ios"=>"IOS","android"=>"Android","wp"=>"Winphone");
       return $arrResult;
     
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
			
        }elseif($arrParam['cert_id']<0){
			 if($arrParam['cert_id']=="-1" || $arrParam['cert_id']=="-2"){
				 //-1 : GooglePlay, -2: Inhouse , dành cho Android
				 $platform="android";
				 $cert_id=$arrParam['cert_id']=="-1"?"1":"3";
			 }elseif($arrParam['cert_id']=="-3" || $arrParam['cert_id']=="-4"){
				 //-3 : GooglePlay, -4: Inhouse , dành cho Winphone
				 $platform="wp";
				 $cert_id=$arrParam['cert_id']=="-3"?"1":"3";
			 }
			 
			 $this->_db_slave->where('platform',$platform);
			  $this->_db_slave->where('cert_id',$cert_id);
		}
		
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	public function listItemPlus($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('DISTINCT(cert_id)'));
        $this->_db_slave->from($this->_table);
        if($arrParam['id_game']>0){
            $this->_db_slave->where('id_game',$arrParam['id_game']);
        }
		if(isset($arrParam['platform']) && $arrParam['platform']!=""){
            $this->_db_slave->where('platform',$arrParam['platform']);
        }
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	public function listItemPlusNotDISTINCT($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        if($arrParam['id_game']>0){
            $this->_db_slave->where('id_game',$arrParam['id_game']);
        }
		if(isset($arrParam['platform']) && $arrParam['platform']!=""){
            $this->_db_slave->where('platform',$arrParam['platform']);
        }
		$this->_db_slave->group_by('cert_id');
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	public function listItemForMsv($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        $this->_db_slave->where('id_game',$arrParam['id_game']);
      	$this->_db_slave->where('cert_id',$arrParam['cert_id']);
        $this->_db_slave->where('platform',$arrParam['platform']);
		
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
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
		$cert_name=($arrParam['cert_name']=="AppstoreDev") || ($arrParam['cert_name']=="GooglePlay/WinStore")?"Appstore":$arrParam['cert_name'];
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
	//hàm lấy thông tin Google G+ , trả về 1 record
	public function GetGoogleInfoProjects($arrParam=NULL){
		//b1. lấy id bảng Projects thông qua khóa servicekeyapp
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table_projects);
        $this->_db_slave->where('servicekeyapp',$arrParam['service']);
        $data=$this->_db_slave->get();
        $record=$data->row_array();
		$id_projects=$record['id']; // lấy id bảng projects
		
		//b2. lấy thông tin bảng con của projects 
		$cert_name=$arrParam['cert_name']=="AppstoreDev"?"Appstore":$arrParam['cert_name'];
		$this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table_projects_pro);
        $this->_db_slave->where('id_projects',$id_projects);
		$this->_db_slave->where('platform',$arrParam['platform']);
		$this->_db_slave->where('cert_name',$cert_name);
		$this->_db_slave->where('package_name',$arrParam['package_name']);
		$data1=$this->_db_slave->get();
        if (is_object($data1)) {
            $result = $data1->row_array();
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
			$id_game=explode('|',$arrParam['id_game']);
			$part=explode("|",$arrParam['cbo_partner']);
            $arrData['id_game']                 = $id_game[0];
			$arrData['idpartner']                 = $part[0];
			$arrData['platform']                = $arrParam['cbo_platform'];
            $arrData['cert_id']                = $arrParam['cert_id'];
            $arrData['provision']               = $arrParam['provision'];
            $arrData['entitlements']            = $arrParam['entitlements'];
            $arrData['bundleidentifier']        = $arrParam['cbo_bundleidentifier'];
			$arrData['clientid_google']        = $arrParam['clientid_google'];
			$arrData['url_scheme_google']        = $arrParam['url_scheme_google'];
            //$arrData['order']                   = $arrParam['order'];
            $arrData['modified']                = time();
            //$arrData['status']                  = !empty($arrParam['status'])?$arrParam['status']:0;
			$arrData['status']      = 1;
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
			$id_game=explode('|',$arrParam['id_game']);
			$part=explode("|",$arrParam['cbo_partner']);
			$c=$arrParam['cbo_platform']=="ios"?"cert_id":"cert_id_a_wp";
            $arrData['id_game']                 = $id_game[0];
			$arrData['idpartner']                 = $part[0];
			$arrData['platform']                = $arrParam['cbo_platform'];
            $arrData['cert_id']                = $arrParam[$c];
            $arrData['provision']               = $arrParam['provision'];
            $arrData['entitlements']            = $arrParam['entitlements'];
            $arrData['bundleidentifier']        = $arrParam['cbo_bundleidentifier'];
            $arrData['clientid_google']        = $arrParam['clientid_google'];
			$arrData['url_scheme_google']        = $arrParam['url_scheme_google'];
            $arrData['created']     = time();
            $arrData['modified']    = time();
            //$arrData['status']      = !empty($arrParam['status'])?$arrParam['status']:0;
			$arrData['status']      = 1;
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
	public function checkisexitconfigapp($arrParam){
		$data = $this->_db_slave->select(array('*'))
        				->from($this->_table)
						->where('idpartner', $arrParam['idpartner'])
						->where('platform', $arrParam['platform'])
						->where('id_game', $arrParam['id_game'])
						->where('cert_id', $arrParam['cert_id'])
						->where('bundleidentifier', $arrParam['bundleidentifier'])
       					->get();
		$result = $data->result_array();
		if(count($result)==0){
        	return false; //chưa tồn tại
		}else{
			return true; // đã tồn tại
		}
		return true;
	}
	
	//13/01/2016
	public function GetFolderInProjects($keys){
		//b1. lấy folder bảng Projects thông qua khóa servicekeyapp
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table_projects);
        $this->_db_slave->where('servicekeyapp',$keys);
        $data=$this->_db_slave->get();
        $record=$data->row_array();
		$folder=$record['folder']; // lấy id bảng projects
		return $folder;
    }
}

