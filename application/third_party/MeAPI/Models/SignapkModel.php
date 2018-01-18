<?php
class SignapkModel extends CI_Model {
    private $_db_slave;
    private $_table='tbl_sign_apk';
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
	 
	public function listSdk(){
        $data = $this->_db_slave->select(array('*'))
						->where('platform','Android')
                        ->where('status',1)
                        ->from('tbl_sdk')
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
    public function saveItem($arrParam,$option= NULL){
		 if($arrParam['cbo_sdk']!="0"){
			 $id_game=explode("|",$arrParam['cbo_game']);
			 $msv_id=explode("|",$arrParam['cbo_p5_msv']);
			 $type_app_id=0;
		 	$sdk_arr=explode("|",$arrParam['cbo_sdk']);
			if($option['task']=='add'){
				$arrData['id_game']                 = $id_game[0];
				$arrData['games']                = $id_game[1];
				$arrData['type_app']             = $arrParam['cbo_type_app_h'];
				$arrData['type_app_id']             =$arrParam['cbo_type_app_id_h'];
				$arrData['filenames_notsign']        = $arrParam['apk'];
				$arrData['filenames_signed']                 = '';
				$arrData['channels']                 = $arrParam['channel'];
				$arrData['links_signed']          = '';
				$arrData['logs']              = '';
				$arrData['status']                  = '';
				$arrData['published']                 = 'no';
				$arrData['sdk_id']      = $sdk_arr[0];
				$arrData['sdk_name']      = $sdk_arr[1];
				$arrData['msv_id']      = $msv_id[0];
				$arrData['userid']                 = $_SESSION['account']['id'];
				$arrData['datecreate']      = date('y-m-d H:i:s');
				$arrData['notes']      = $arrParam['notes'];
				$this->_db_slave->insert($this->_table,$arrData);
				$id = $this->_db_slave->insert_id();
			}
		 }else{
			 $id_game=explode("|",$arrParam['cbo_game']);
			 $msv_id=explode("|",$arrParam['cbo_p5_msv']);
			 $type_app_id=0;
			 if($option['task']=='add'){
				$arrData['id_game']                 = $id_game[0];
				$arrData['games']                = $id_game[1];
				$arrData['type_app']             = $arrParam['cbo_type_app_h'];
				$arrData['type_app_id']             = $arrParam['cbo_type_app_id_h'];
				$arrData['filenames_notsign']        = $arrParam['apk'];
				$arrData['filenames_signed']                 = '';
				$arrData['channels']                 = $arrParam['channel'];
				$arrData['links_signed']          = '';
				$arrData['logs']              = '';
				$arrData['status']                  = '';
				$arrData['published']                 = 'no';
				$arrData['sdk_id']      = '';
				$arrData['sdk_name']      = '';
				$arrData['msv_id']      = $msv_id[0];
				$arrData['userid']                 = $_SESSION['account']['id'];
				$arrData['datecreate']      = date('y-m-d H:i:s');
				$arrData['notes']      = $arrParam['notes'];
				$this->_db_slave->insert($this->_table,$arrData);
				$id = $this->_db_slave->insert_id();
			}
		 }
        if($option['task']=='updatelink'){
            $arrData['filenames_signed']          = $arrParam['filenames_signed'];
            $arrData['links_signed']          = $arrParam['links_signed'];
			$arrData['logs']          = $arrParam['logs'];
			$arrData['package_name']          = $arrParam['package_name'];
			$arrData['version_name']          = $arrParam['version_name'];
			$arrData['version_code']          = $arrParam['version_code'];
			$arrData['notes']      = $arrParam['notes'];
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
			$id=1;
			//update cahnnel
			$r=$this->getItem($arrParam['id']);
			$c=str_replace("null",$arrParam['version_name'],$r['channels']);
			$arrData['channels']          = $c;
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
        }
        return $id;
    }
	public function savelog($log,$id){
		$arrData['log']= $log;
		$this->_db_slave->where('id', $id);
		$this->_db_slave->update($this->_table,$arrData);
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
            $filename = $this->getItem($arrParam['id']);
            @unlink(FILE_PATH . '/'.$filename['apk_file']);
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
        }
    }
	public function updatepublished($msvid,$idapk,$published){
		if($published!="cancel"){
			//cap nhat bang msv
			$arrData['published']= $published;
			$this->_db_slave->where('id', $msvid);
			$this->_db_slave->update("tbl_get_msv",$arrData);
			//cap nhat bang sign
			$arrData1['published']= $published;
			$this->_db_slave->where('id', $idapk);
			$this->_db_slave->update($this->_table,$arrData1);
			return true;
			
		}else{
			//cap nhat bang sign
			$arrData1['published']= $published;
			$this->_db_slave->where('id', $idapk);
			$this->_db_slave->update($this->_table,$arrData1);
			return true;
		}
	}
	public function updatenotes($idapk,$notes){
		//cap nhat bang sign
		$arrData['notes']= $notes;
		$this->_db_slave->where('id', $idapk);
		$this->_db_slave->update($this->_table,$arrData);
		return true;
		
	}
    public function listItem($arrParam=NULL,$options=null){
		if($options==1){
			$this->_db_slave->select(array('*'));
			$this->_db_slave->from($this->_table);
			$this->_db_slave->order_by('id','DESC');
			if($arrParam['id_game'] > 0){
            	$this->_db_slave->where('id_game',$arrParam['id_game']);
			}
			if($arrParam['type_app_id'] > 0){
				$this->_db_slave->where('type_app_id',$arrParam['type_app_id']);
			}
			if($arrParam['keyword']!=""){
				$this->_db_slave->like('filenames_signed', $arrParam['keyword']);
			}
			
			$data=$this->_db_slave->get();
			
			if (is_object($data)) {
				$result = $data->result_array();
				return $result;
			}
		}else{
			$this->_db_slave->select(array('*'));
			$this->_db_slave->from($this->_table);
			$this->_db_slave->order_by('id','DESC');
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
	public function getItemGame($service_id){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('*'));
		$this->db_slave->from('scopes');
        $this->db_slave->where('service_id',$service_id);
        $data = $this->db_slave->get();
        if (is_object($data)) {
            $result = $data->row_array();
			return $result;
        }
		return FALSE;
    }
	public function getItemGamenew($service_id){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('*'));
		$this->db_slave->from('scopes');
        $this->db_slave->where('service_id',$service_id);
        $data = $this->db_slave->get();
        if (is_object($data)) {
            $result = $data->row_array();
			return $result;
        }
		return FALSE;
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
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }
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
	public function listMsv($id_game,$type_app){
		// tim msv_id da public
		$sql="select msv_id,SUBSTRING(msv_id,5) as MSVID from tbl_get_msv where service_id=".$id_game." and published in('yes','waiting')  and type_app='".$type_app."' and platform='android' ORDER BY SUBSTRING(msv_id,5) desc limit 1";
		
		$data1=$this->_db_slave->query($sql);
		$rs=$data1->result_array();
		$msvid=$rs[0]['MSVID']==""?0:$rs[0]['MSVID'];
		
        $data = $this->_db_slave->select(array('*'))
                        ->where('service_id',$id_game)
						->where('published','no')
						->where('type_app',$type_app)
						->where('platform','android')
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
	public function listMsvPlus($id_game,$type_app,$packagename,$cert_id){
		// tim msv_id da public
		$sql="select msv_id,SUBSTRING(msv_id,5) as MSVID from tbl_get_msv where service_id=".$id_game." and published in('yes','waiting')  and type_app='".$type_app."' and platform='android' and bunlderid='".$packagename."' and cert_id=".$cert_id." ORDER BY SUBSTRING(msv_id,5) desc limit 1";
		
		$data1=$this->_db_slave->query($sql);
		$rs=$data1->result_array();
		$msvid=$rs[0]['MSVID']==""?0:$rs[0]['MSVID'];
		
        $data = $this->_db_slave->select(array('*'))
                        ->where('service_id',$id_game)
						->where('published','no')
						->where('type_app',$type_app)
						->where('platform','android')
						->where('bunlderid',$packagename)
						->where('cert_id',$cert_id)
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
	public function listMsvWp($id_game,$type_app,$package_identity,$cert_id){
		// tim msv_id da public
		$sql="select msv_id,SUBSTRING(msv_id,5) as MSVID from tbl_get_msv where service_id=".$id_game." and published in('yes','waiting') and type_app='".$type_app."' and bunlderid='".$package_identity."' and cert_id=".$cert_id." and platform='wp' ORDER BY SUBSTRING(msv_id,5) desc limit 1";
		
		$data1=$this->_db_slave->query($sql);
		$rs=$data1->result_array();
		$msvid=$rs[0]['MSVID']==""?0:$rs[0]['MSVID'];
		
        $data = $this->_db_slave->select(array('*'))
                        ->where('service_id',$id_game)
						->where('published','no')
						->where('type_app',$type_app)
						->where('platform','wp')
						->where('bunlderid',$package_identity)
						->where('cert_id',$cert_id)
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
	public function listPlatform(){
	   $arrResult=array("ios"=>"IOS","android"=>"Android","wp"=>"Winphone");
       return $arrResult;
     
    }
	public function listStatus(){
	   $arrResult=array("approving"=>"Approving","approved"=>"Approved","rejected"=>"Rejected","cancel"=>"Cancel");
       return $arrResult;
     
    }
    public function add_new($arrParam) {
		 
		$id=$this->_db_slave->insert($this->_table_msv,$arrParam);
		return $id;
    }
	
	public function edit_new($arrParam,$arrWhere) {
		//kiem tra xem table tbl_get_msv ton tai row cap nhat hay chua
		
		$this->_db_slave->where('msv_id', $arrWhere['msv_id']);
		$this->_db_slave->where('platform', $arrWhere['platform']);
		$this->_db_slave->where('service_id', $arrWhere['service_id']);
		$sql="select * from ".$this->_table_msv." where msv_id='".$arrWhere['msv_id']."' and service_id='".$arrWhere['service_id']."' and platform='".$arrWhere['platform']."'";
		$result1 = $this->_db_slave->query($sql);
		$c = $result1->result();
		if(count($c)>0){
			$id=$this->_db_slave->update($this->_table_msv,$arrParam);
		}else{
			$arrParam['service_id']=$arrWhere['service_id'];
			$arrParam['msv_id']=$arrWhere['msv_id'];
			$arrParam['platform']=$arrWhere['platform'];
			$arrParam['days']=date('d-m-y');
			$id=$this->add_new($arrParam);
		}
		return $id;
    }


   
}