<?php
class SignHistoryAppModel extends CI_Model {
    private $_db_slave;
    private $_table='sign_history_app';
    
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
                    $filename = $this->getItem($v);
                    @unlink(FILE_PATH . '/'.$filename['ipa_file']);
                    $this->_db_slave->delete($this->_table,array('id' => $v)); 
                }
            }
        }else{
            $filename = $this->getItem($arrParam['id']);
            @unlink(FILE_PATH . '/'.$filename['ipa_file']);
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
        }
    }
    public function listItem($arrParam=NULL,$options=null){
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table);
        $this->_db_slave->order_by('id','DESC');
		$id_game=explode("|",$arrParam['id_game']);
        if($id_game[0]>0){
            $this->_db_slave->where('id_game',$id_game[0]);
        }
        if($arrParam['cert_id']>0){
            $this->_db_slave->where('cert_id',$arrParam['cert_id']);
        }
		if($arrParam['keyword']!=""){
			$this->_db_slave->like('ipa_name_sign', $arrParam['keyword']);
        }
        $data=$this->_db_slave->get();
        
        if (is_object($data)) {
            $result = $data->result_array();
			if(count($result)>0){
            	return $result;
			}else{
					$this->_db_slave->select(array('*'));
					$this->_db_slave->from($this->_table);
					$this->_db_slave->order_by('id','DESC');
					$id_game=explode("|",$arrParam['id_game']);
					if($id_game[0]>0){
						$this->_db_slave->where('id_game',$id_game[0]);
					}
					if($arrParam['cert_id']>0){
						$this->_db_slave->where('cert_id',$arrParam['cert_id']);
					}
					if($arrParam['keyword']!=""){
						$this->_db_slave->like('notes', $arrParam['keyword']);
					}
					$data1=$this->_db_slave->get();
					if(is_object($data1)){
						 $result1 = $data1->result_array();
						 return $result1;
					}//end if
			}//end if
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
	
	/*
	 TUNG 10/07/2015
	*/
	public function savelog($log,$id){
		$val=strpos($log,"Process complete");
		$flag=$val==true?"Complete":"Uncomplete";
		$arrData['informations']= $log;
		$arrData['isok']= $flag;
		$this->_db_slave->where('id', $id);
		$this->_db_slave->update($this->_table,$arrData);
	}
	/*
	 End Tung
	*/
	public function updatepublished($msvid,$idipa,$published){
		if($published!="cancel"){
			//cap nhat bang msv
			$arrData['published']= $published;
			$this->_db_slave->where('id', $msvid);
			$this->_db_slave->update("tbl_get_msv",$arrData);
			//cap nhat bang sign
			$arrData1['published']= $published;
			$this->_db_slave->where('id', $idipa);
			$this->_db_slave->update($this->_table,$arrData1);
			return true;
			
		}else{
			//cap nhat bang sign
			$arrData1['published']= $published;
			$this->_db_slave->where('id', $idipa);
			$this->_db_slave->update($this->_table,$arrData1);
			return true;
		}
	}
	public function updatenotes($idipa,$notes){
		//cap nhat bang sign
		$arrData['notes']= $notes;
		$this->_db_slave->where('id', $idipa);
		$this->_db_slave->update($this->_table,$arrData);
		return true;
		
	}
	public function saveItemi($arrParam,$option= NULL){
		 $id_game=explode("|",$arrParam['id_game']);
		 $msv_id=explode("|",$arrParam['cbo_p5_msv']);
		 if($arrParam['cbo_sdk']!="0"){
		 	$sdk_arr=explode("|",$arrParam['cbo_sdk']);
			if($option['task']=='add'){
				$arrData['id_game']                 = $id_game[0];
				$arrData['cert_id']                = 2;
				$arrData['ipa_file']             = $arrParam['certificate'];
				$arrData['bundleidentifier']        = $arrParam['bundleidentifier_appstore'];
				$arrData['channel']                 = $arrParam['channel'];
				$arrData['version']                 = $arrParam['version'];
				$arrData['bundle_version']          = $arrParam['bundle_version'];
				$arrData['url_scheme']              = $arrParam['url_scheme_appstore'];
				$arrData['minimum_os_version']      = $arrParam['minimum_os_version'];
				$arrData['status']                  = !empty($arrParam['status'])?$arrParam['status']:0;
				$arrData['created']                 = time();
				$arrData['id_user']                 = $_SESSION['account']['id'];
				$arrData['notes']      = $arrParam['notes'];
				$arrData['sdk']      = $sdk_arr[1];
				$arrData['sdk_id']      = $sdk_arr[0];
				$arrData['msv_id']      = $msv_id[0];
				$arrData['published']      = "no";
				$this->_db_slave->insert($this->_table,$arrData);
				$id = $this->_db_slave->insert_id();
			}
		 }else{
			 if($option['task']=='add'){
				$arrData['id_game']                 = $id_game[0];
				$arrData['cert_id']                = 2;
				$arrData['ipa_file']             = $arrParam['certificate'];
				$arrData['bundleidentifier']        = $arrParam['bundleidentifier_appstore'];
				$arrData['channel']                 = $arrParam['channel'];
				$arrData['version']                 = $arrParam['version'];
				$arrData['bundle_version']          = $arrParam['bundle_version'];
				$arrData['url_scheme']              = $arrParam['url_scheme_appstore'];
				$arrData['minimum_os_version']      = $arrParam['minimum_os_version'];
				$arrData['status']                  = !empty($arrParam['status'])?$arrParam['status']:0;
				$arrData['created']                 = time();
				$arrData['id_user']                 = $_SESSION['account']['id'];
				$arrData['notes']      = $arrParam['notes'];
				$arrData['sdk']      = "";
				$arrData['sdk_id']      = "";
				$arrData['msv_id']      = $msv_id[0];
				$arrData['published']      = "no";
				$this->_db_slave->insert($this->_table,$arrData);
				$id = $this->_db_slave->insert_id();
			}
		 }
        if($option['task']=='updateversion'){
			
            $arrData['version']                 = $arrParam['version'];
            $arrData['bundle_version']          = $arrParam['bundle_version'];
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
        }
        if($option['task']=='updatelink'){
            $arrData['log_file_path']                 = $arrParam['log_file_path'];
            $arrData['signed_file_path']          = $arrParam['signed_file_path'];
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
        }
		//update cahnnel
		if($option['task']=='updatechannel'){
			$items_arr=$this->getItem($arrParam['id']);
			$arr_channel=explode("|",$items_arr['channel']);
			$arr_channel[2]=$arrParam['version'];
			$channel_new=$arr_channel[0]."|".$arr_channel[1]."|".$arr_channel[2]."|".$arr_channel[3]."|".$arr_channel[4];
			
			$arrData['channel']          = $channel_new;
			$arrData['ipa_name_sign']    = $arrParam['ipa_name_sign'];
			$this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
		}
		
		
        return $id;
    }
    public function saveItem($arrParam,$option= NULL){
		 $id_game=explode("|",$arrParam['id_game']);
		 $msv_id=explode("|",$arrParam['cbo_p5_msv']);
		 if($arrParam['cbo_sdk']!="0"){
			 $sdk_arr=explode("|",$arrParam['cbo_sdk']);
				if($option['task']=='add'){
					$arrData['id_game']                 = $id_game[0];
					$arrData['cert_id']                = $arrParam['cert_id'];
					$arrData['ipa_file']             = $arrParam['certificate'];
					$arrData['bundleidentifier']        = $arrParam['bundleidentifier'];
					$arrData['channel']                 = $arrParam['channel'];
					$arrData['version']                 = $arrParam['version'];
					$arrData['bundle_version']          = $arrParam['bundle_version'];
					$arrData['url_scheme']              = $arrParam['url_scheme'];
					$arrData['minimum_os_version']      = $arrParam['minimum_os_version'];
					$arrData['status']                  = !empty($arrParam['status'])?$arrParam['status']:0;
					$arrData['created']                 = time();
					$arrData['id_user']                 = $_SESSION['account']['id'];
					$arrData['notes']      = $arrParam['notes'];
					$arrData['sdk']      = $sdk_arr[1];
					$arrData['sdk_id']      = $sdk_arr[0];
					$arrData['msv_id']      = $msv_id[0];
					$arrData['published']      = "no";
					$this->_db_slave->insert($this->_table,$arrData);
					$id = $this->_db_slave->insert_id();
				}
		 }else{
			 if($option['task']=='add'){
					$arrData['id_game']                 = $id_game[0];
					$arrData['cert_id']                = $arrParam['cert_id'];
					$arrData['ipa_file']             = $arrParam['certificate'];
					$arrData['bundleidentifier']        = $arrParam['bundleidentifier'];
					$arrData['channel']                 = $arrParam['channel'];
					$arrData['version']                 = $arrParam['version'];
					$arrData['bundle_version']          = $arrParam['bundle_version'];
					$arrData['url_scheme']              = $arrParam['url_scheme'];
					$arrData['minimum_os_version']      = $arrParam['minimum_os_version'];
					$arrData['status']                  = !empty($arrParam['status'])?$arrParam['status']:0;
					$arrData['created']                 = time();
					$arrData['id_user']                 = $_SESSION['account']['id'];
					$arrData['notes']      = $arrParam['notes'];
					$arrData['sdk']      = "";
					$arrData['sdk_id']      = "";
					$arrData['msv_id']      = $msv_id[0];
					$arrData['published']      = "no";
					$this->_db_slave->insert($this->_table,$arrData);
					$id = $this->_db_slave->insert_id();
				}
		 }
        if($option['task']=='updateversion'){
			
            $arrData['version']                 = $arrParam['version'];
            $arrData['bundle_version']          = $arrParam['bundle_version'];
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
        }
        if($option['task']=='updatelink'){
            $arrData['log_file_path']                 = $arrParam['log_file_path'];
            $arrData['signed_file_path']          = $arrParam['signed_file_path'];
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
        }
		//update cahnnel
		if($option['task']=='updatechannel'){
			$items_arr=$this->getItem($arrParam['id']);
			$arr_channel=explode("|",$items_arr['channel']);
			$arr_channel[2]=$arrParam['version'];
			$channel_new=$arr_channel[0]."|".$arr_channel[1]."|".$arr_channel[2]."|".$arr_channel[3]."|".$arr_channel[4];
			
			$arrData['channel']          = $channel_new;
			$arrData['ipa_name_sign']    = $arrParam['ipa_name_sign'];
			$this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
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
    public function listGame(){
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('id','app_fullname','service_id'));
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
	public function listSdk(){
        $data = $this->_db_slave->select(array('*'))
						->where('platform','IOS')
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
    public function listMsv($id_game,$type_app){
		// tim msv_id da public
		$type_app=$type_app=="AppstoreDev"?"Appstore":$type_app;
		$sql="select msv_id,SUBSTRING(msv_id,5) as MSVID from tbl_get_msv where service_id=".$id_game." and published in('yes','waiting') and type_app='".$type_app."' and platform='ios' ORDER BY SUBSTRING(msv_id,5) desc limit 1";
		
		$data1=$this->_db_slave->query($sql);
		$rs=$data1->result_array();
		$msvid=$rs[0]['MSVID']==""?0:$rs[0]['MSVID'];
		
        $data = $this->_db_slave->select(array('*'))
                        ->where('service_id',$id_game)
						->where('published','no')
						->where('type_app',$type_app)
						->where('platform','ios')
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
    public function removeFile($arrParam){
        $data = array(
            'ipa_file'=>''
        );
        $this->_db_slave->where_in('id',$arrParam['id']);
        $this->_db_slave->update($this->_table,$data);
    }
    public function getValueBundleID($arrParam){
		//$id_game=explode("|",$arrParam['id_game']);
        $data = $this->_db_slave->select(array('*'))
                        ->where('status',1)
						->where('idpartner',$arrParam['idpartner'])
                        ->where('id_game',$arrParam['id_game'])
                        ->where('cert_id',$arrParam['cert_id'])
                        ->from('sign_config_app')
                        ->get();
        if (is_object($data)) {
            $result = $data->row_array();
            return $result;
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
                        ->where('id',$id)
                        ->from('tbl_sign_config_cert')
                        ->get();
        if (is_object($data)) {
            $result = $data->row_array();
            return $result;
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
}