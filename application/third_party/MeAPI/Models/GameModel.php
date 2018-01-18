<?php

/**
 * sms model
 *
 * @author thuonghh
 */
class GameModel extends CI_Model {

    private $_db;
    private $_db_slave;
    private $_db_mobo_master;
    private $_db_mobo_slave;
    
    protected $_total;

    public function __construct() {
        
    }
   
    public function mobo_account($username,$server=null){
	
		$this->_db_mobo_slave = $this->load->database(array('db' => 'moboinfo', 'type' => 'slave'), TRUE);
        
        $this->_db_mobo_slave->where('account', $username);
        $this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('accounts');
		
        $game_account = null;
        if (is_object($data)) {
            $rss = $data->row_array();
			if(empty($rss) === FALSE){
                $uidmobo = $rss['id'];
				
				$this->_db_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
				//$strQuery = "SELECT k.key_, v.value_ FROM (SELECT * FROM cn_x6game_user_xuserprofile_mac WHERE value_ = '".$uidmobo."_12') AS k 
				//$strQuery = "SELECT k.key_, v.value_ FROM (SELECT * FROM cn_x6game_user_xuserprofile_mac WHERE value_ LIKE '".$uidmobo."\_%') AS k 
				$strQuery = "SELECT k.key_, v.value_ FROM (SELECT * FROM cn_x6game_user_xuserprofile_mac WHERE value_ REGEXP '^".$uidmobo."_.') AS k
							 LEFT JOIN cn_x6game_user_xuserprofile AS v ON k.key_ = v.key_
							";
						
				$result = $this->_db_slave->query($strQuery);
				$game_account = null;
				if(is_object($result)) {
					$rs = $result->row_array();
					
					if(empty($rs) === FALSE){
						$role = json_decode($rs['value_'], true);
						
						$game_account['user_key'] = $rs['key_'];
						$game_account['role_key'] = $rs['key_'];
						$game_account['role_id'] = $rs['key_'];
					}
					  
				}
            }
        }
		return $game_account;
		
	
       
		/*
		$this->_db_mobo_slave = $this->load->database(array('db' => 'account', 'type' => 'slave'), TRUE);
        
        $this->_db_mobo_slave->where('account', $username);
        $this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('accounts');

        $game_account = null;
        if (is_object($data)) {
            $rs = $data->row_array();
            if(empty($rs) === FALSE){
                $game_account = $rs['account'];
            }
        }
        return $game_account;
		*/
    }
    public function mobo_id($id,$server=null){
        $this->_db_mobo_slave = $this->load->database(array('db' => 'account', 'type' => 'slave'), TRUE);
        
        $this->_db_mobo_slave->where('id', $id);
        $this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('accounts');
        $game_account = null;
        if (is_object($data)) {
            $rs = $data->row_array();
            if(empty($rs) === FALSE){
                $game_account = $rs['account'];
            }
        }
        return $game_account;
    }
	public function getInfoByApp($app){
        $this->_db_mobo_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $date = date('Y-m-d',time());
        $this->_db_mobo_slave->where('app', $app);
		$this->_db_mobo_slave->where('date(startdate) <= "'.$date.'"',false,false);
		$this->_db_mobo_slave->where('date(enddate) >= "'.$date.'"',false,false);
        $data = $this->_db_mobo_slave->get('mfb');
        $rs = array();
        if (is_object($data)) {
            $rs = $data->result_array();
        }
        return $rs;
    }
	public function getDownloadApp($app,$status = false){
        $this->_db_mobo_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $date = date('Y-m-d',time());
        $this->_db_mobo_slave->where('app', $app);
		if($status == FALSE){
			$this->_db_mobo_slave->where('active', 1);
		}
        $data = $this->_db_mobo_slave->get('download');
        $rs = array();
        if (is_object($data)) {
            $rs = $data->row_array();
        }
        return $rs;
    }
	public function saveItemDownload(){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
        $arrParam = $_POST;
        
        $arrAc = array();
		//unset($arrParam['data']);
		$info = $this->getDownloadApp($arrParam['app'],true);
		$active = ($arrParam['active'] == 1)? 1:0;
        if(isset($arrParam['app']) && !empty($arrParam['app'])  && count($info) >=1  && !empty($info) ){
			
            $strQuery="UPDATE download SET 
                       ipi_api = '".trim($arrParam['ipi_api'])."', 
                       linki_api = '".trim($arrParam['linki_api'])."', 
                       linki_plist = '".trim($arrParam['linki_plist'])."', 
                       ipi_plist = '".trim($arrParam['ipi_plist'])."', 
                       linki_apple = '".trim($arrParam['linki_apple'])."', 
                       ipi_apple = '".trim($arrParam['ipi_apple'])."' ,
					   linka_apk = '".trim($arrParam['linka_apk'])."' ,
					   ipa_apk = '".trim($arrParam['ipa_apk'])."' ,
					   linka_gg = '".trim($arrParam['linka_gg'])."' ,
					   ipa_gg = '".trim($arrParam['ipa_gg'])."' ,
					   active = '".$active."'
                       WHERE app = '".$arrParam['app']."'";
			
          $this->_db_slave->query($strQuery);
        }else{
                $arrAc['ipi_api'] = trim($arrParam['ipi_api']);
                $arrAc['linki_api'] = trim($arrParam['linki_api']);
                $arrAc['linki_plist'] = trim($arrParam['linki_plist']);
                $arrAc['ipi_plist'] = trim($arrParam['ipi_plist']);
                $arrAc['linki_apple'] = trim($arrParam['linki_apple']);
                $arrAc['ipi_apple'] = trim($arrParam['ipi_apple']);
                $arrAc['linka_apk'] = $arrParam['linka_apk'];
                $arrAc['ipa_apk'] = trim($arrParam['ipa_apk']);
                $arrAc['linka_gg'] = trim($arrParam['linka_gg']);
                $arrAc['ipa_gg'] = trim($arrParam['ipa_gg']);
				$arrAc['insertdate'] = date('Y-m-d H:i:s',time());
				$arrAc['active'] = $active;
				$arrAc['app'] = trim($arrParam['app']);

         $this->_db_slave->insert('download',$arrAc);
        }
		
		unset($_POST);
		
    }
	public function getInfoByAppID($id,$app){
		$this->_db_mobo_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $date = date('Y-m-d',time());
        $this->_db_mobo_slave->where('app', $app);
		$this->_db_mobo_slave->where('idfb',$id);
		$this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('mfb');
        $rs = array();
        if (is_object($data)) {
            $rs = $data->row_array();
        }
        return $rs;
	}
	public function saveItem(){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
        $arrParam = $_POST;
        
        $arrAc = array();
		unset($arrParam['data']);
        if(isset($arrParam['idfb']) && !empty($arrParam['idfb']) ){
            $permission = ($arrParam['status'] == 1)? 1:0;
            $strQuery="UPDATE mfb SET 
                       message = '".trim($arrParam['message'])."', 
                       type = '".trim($arrParam['type'])."', 
                       photo = '".trim($arrParam['photo'])."', 
                       link = '".trim($arrParam['link'])."', 
                       startdate = '".trim($arrParam['startdate'])."', 
                       enddate = '".trim($arrParam['enddate'])."' ,
					   status = '".$permission."'
                       WHERE idfb = '".$arrParam['idfb']."'";
			
          $this->_db_slave->query($strQuery);
        }else{
                $arrAc['status'] = ($arrParam['status'] == 1)? 1:0;
                $arrAc['message'] = trim($arrParam['message']);
                $arrAc['type'] = trim($arrParam['type']);
                $arrAc['photo'] = trim($arrParam['photo']);
                $arrAc['link'] = trim($arrParam['link']);
                $arrAc['startdate'] = trim($arrParam['startdate']);
                $arrAc['enddate'] = $arrParam['enddate'];
                $arrAc['status'] = trim($arrParam['status']);
				$arrAc['insertdate'] = date('Y-m-d H:i:s',time());
				$arrAc['app'] = trim($arrParam['app']);

         $this->_db_slave->insert('mfb',$arrAc);
        }
		
		unset($_POST);
		
    }
	
    public function character_name($charname,$server){
        $this->_db_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $strQuery = "SELECT k.key_, v.value_ FROM (SELECT * FROM cn_x6game_model_roleinfo_rolename WHERE value_ = '".$charname."') AS k 
                     LEFT JOIN cn_x6game_model_roleinfo AS v ON k.key_ = v.key_
                    ";
					
        $result = $this->_db_slave->query($strQuery);
        $game_account = null;
        if(is_object($result)) {
            $rs = $result->row_array();
            if(empty($rs) === FALSE){
                $role = json_decode($rs['value_'], true);
                $game_account['user_key'] = $role['ownerId'];
                $game_account['role_key'] = $rs['key_'];
                $game_account['role_id'] = $role['roleId'];
            }
            return $game_account;  
        }
        
    }
    public function character_id($id,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        //$this->_db_mobo_slave->where('id', $id);
        //$this->_db_mobo_slave->limit(1);
        //$data = $this->_db_mobo_slave->get('role');
        $strQuery = "SELECT * FROM cn_x6game_model_roleinfo WHERE value_ LIKE '%".$id."%'";
        $data = $this->_db_game_slave->query($strQuery);
        
        $game_account = null;
        if (is_object($data)) {
           $rs = $data->row_array();
            if(empty($rs) === FALSE){
                $role = json_decode($rs['value_'], true);
                $game_account['user_key'] = $role['ownerId'];
                $game_account['role_key'] = $rs['key_'];
                $game_account['role_id'] = $role['roleId'];
            }
            return $game_account;  
        }
        
    }
    public function mobo_info($gameaccount,$server){
	
        
		$this->_db_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
		$strQuery = "SELECT * FROM cn_x6game_user_xuserprofile_mac WHERE key_ = '".$gameaccount."'";
					
		$result = $this->_db_slave->query($strQuery);
		$game_account = null;
		if(is_object($result)) {
			$rs = $result->row_array();
			
			
			if(empty($rs) === FALSE){
				$name = $rs['value_'];
				$arrN = explode('_',$name);
				$this->_db_mobo_slave = $this->load->database(array('db' => 'moboinfo', 'type' => 'slave'), TRUE);
       
				$this->_db_mobo_slave->where('id', $arrN[0]);
				$this->_db_mobo_slave->limit(1);
				$data = $this->_db_mobo_slave->get('accounts');
				
				if (is_object($data)) {
					return $data->result_array();
				}
			
			}
			
			  
		}
		
		
		
                
    }
    public function game_info($userKey,$server){
        
		$this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
		
        $this->_db_game_slave->where('key_', $userKey);
        $this->_db_game_slave->limit(1);
        $data = $this->_db_game_slave->get('cn_x6game_user_xuserprofile');
        
        if (is_object($data)) {
            return $data->row_array();
        }
                
    }
    public function char_info($userKey,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        //$this->_db_game_slave->where('key_', $roleKey);
        //$data = $this->_db_game_slave->get('cn_x6game_model_roleinfo');
        $arr = array();
        if(empty($userKey) === FALSE){
            $arr = array();
            //$strQuery = "SELECT value_ FROM game_service_user_userprofile WHERE value_ LIKE '%\"username\":\"".$userKey."%'";

			$strQuery = "SELECT value_ FROM game_service_user_userprofile WHERE value_ REGEXP '\"username\":\"".$userKey."'";
			
            $data = $this->_db_game_slave->query($strQuery);

            if (is_object($data)) {
               $rs = $data->result_array();
               if(empty($rs) === FALSE){
                   foreach($rs as $key => $val){
                       $arr[$key] = json_decode($val['value_'], true);
                   }                   
               }
            }
        }
        return $arr;
    }
    public function rolelevel($roleId,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $strQuery = "SELECT * FROM level WHERE role_id = '".$roleId."' ORDER BY role_level DESC LIMIT 1";
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            $rst = $result->row_array();
            return $rst['role_level'];
        }
    }
    public function rolegold($roleId,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $strQuery = "SELECT * FROM game_service_user_userprofile_gold WHERE key_ = '".$roleId."' LIMIT 1";
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            $rst = $result->row_array();
            return $rst['value_'];
        }
    }
    public function heartbeat($roleId,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $strQuery = "SELECT * FROM game_service_user_userprofile_heartbeat WHERE key_ = '".$roleId."' LIMIT 1";
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            $rst = $result->row_array();
            return $rst['value_'];
        }
    }
    
     public function heronum($roleId,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $strQuery = "SELECT * FROM game_service_user_userprofile_heronum WHERE key_ = '".$roleId."' LIMIT 1";
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            $rst = $result->row_array();
            return $rst['value_'];
        }
    }
    public function userbuy($strId, $server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $strQuery = "SELECT U.*, S.*  FROM (SELECT * FROM `userbuy101` WHERE rolename IN ('".$strId."')) AS U 
                     LEFT JOIN shoptbl AS S ON U.goodscode = S.goodscode";
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }       
    }
    public function usercard($strId,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $strQuery = "SELECT * FROM usercard101 WHERE rolename IN (".$strId.")";
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }
    }
    public function userfriend($strId,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $strQuery = "SELECT * FROM userfriend101 WHERE rolename IN (".$strId.")";
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }
    }
    
    /*
     * Model for logs
     */
    public function mobo_account_log($username,$server=null){
        $this->_db_mobo_slave = $this->load->database(array('db' => 'account', 'type' => 'slave'), TRUE);
        
        $this->_db_mobo_slave->where('account', $username);
        $this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('accounts');

        $game_account = null;
        if (is_object($data)) {
            $rs = $data->row_array();
            if(empty($rs) === FALSE){
                $game_account = $rs['account'];
            }
        }
        return $game_account;        
    }
    public function mobo_id_log($id,$server=null){
        $this->_db_mobo_slave = $this->load->database(array('db' => 'account', 'type' => 'slave'), TRUE);
        
        $this->_db_mobo_slave->where('id', $id);
        $this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('accounts');
        $game_account = null;
        if (is_object($data)) {
            $rs = $data->row_array();
            if(empty($rs) === FALSE){
                $game_account = $rs['account'];
            }
        }
        return $game_account;
    }
    public function character_name_log($charname,$server){
        $this->_db_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
       
        $strQuery = "SELECT * FROM role WHERE name = '".$charname."' ";
        $result = $this->_db_slave->query($strQuery);
        $rs = $result->row_array();
        $game_account = null;
        if(empty($rs) === FALSE){
            $game_account = $rs['username'];
        }
        return $game_account;  
    }
    public function character_id_log($id,$server){
        $this->_db_mobo_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_mobo_slave->where('roleId', $id);
        $this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('role');
        $game_account = null;
        if (is_object($data)) {
            $rs = $data->row_array();
            if(empty($rs) === FALSE){
                $game_account = $rs['username'];
            }
        }
        return $game_account;  
    }
   
    public function reportlog($table,$strId,$server,$date){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $strQuery = "SELECT ".$table.".* 
                     FROM ".$table." 
                     WHERE ".$table.".roleId IN (".$strId.") AND date(".$table.".createTime) = '".$date."' 
                    ";
        $result = $this->_db_log_slave->query($strQuery);
        $rs = $result->result_array();
        return $rs;
    }
    public function roleopenboxlog($username,$server,$date){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $strQuery = "SELECT role.name AS roleName, roleopenboxlog.* 
                     FROM roleopenboxlog 
                     LEFT JOIN role ON roleopenboxlog.roleId = role.roleId 
                     WHERE role.username = '".$username."' AND date(roleopenboxlog.date) = '".$date."' 
                    ";
        $result = $this->_db_log_slave->query($strQuery);
        $rs = $result->result_array();
        return $rs;
    }
    /*
    public function mission_log($username,$server,$date){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $strQuery = "SELECT role.name AS roleName, mission.* 
                     FROM mission 
                     LEFT JOIN role ON mission.roleId = role.roleId 
                     WHERE role.username = '".$username."' AND date(mission.createTime) = '".$date."' 
                    ";
        $result = $this->_db_log_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }
    }
     * 
     */
    public function mission_log($strId,$server,$date){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $strQuery = "SELECT mission.* 
                     FROM mission 
                     WHERE mission.roleId IN (".$strId.") AND date(mission.createTime) = '".$date."' 
                    ";
        $result = $this->_db_log_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }
    }
    /*
    public function chest_log($username,$server,$date){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $strQuery = "SELECT role.name AS roleName, chest.* 
                     FROM chest 
                     LEFT JOIN role ON chest.roleId = role.roleId 
                     WHERE role.username = '".$username."' AND date(chest.createTime) = '".$date."' 
                    ";
        $result = $this->_db_log_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }
    }
     * 
     */
    public function chest_log($strId,$server,$date){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $strQuery = "SELECT chest.* 
                     FROM chest 
                     WHERE chest.roleId IN (".$strId.") AND date(chest.createTime) = '".$date."' 
                    ";
        $result = $this->_db_log_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }
    }
    public function mission($server){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_log_slave->select(array('id','name'));
        $data = $this->_db_log_slave->get('mission');
        
        if (is_object($data)) {
            return $data->result_array();
        }
        
    }
    
    
    public function memberdata($server){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_log_slave->select(array('id','name'));
        $data = $this->_db_log_slave->get('memberdata');
        
        if (is_object($data)) {
            return $data->result_array();
        }
        
    }
        
    
    public function boxconfig($server){
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_log_slave->select(array('id','name'));
        $data = $this->_db_log_slave->get('boxconfig');
        
        if (is_object($data)) {
            return $data->result_array();
        }
    }

    public function missionid($id){
        $this->_db_log_slave = $this->load->database(array('db' => 'data_game', 'type' => 'slave'), TRUE);
        
        $this->_db_log_slave->where('id',$id);
        $data = $this->_db_log_slave->get('mission');
        
        if (is_object($data)) {
            return $data->result_array();
        }
        
    }
     public function get_char($server,$username){
        $this->_db_mobo_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_mobo_slave->where('username', $username);
        $this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('userroletbl');
        $arr = array();
        if (is_object($data)) {
            $rs = $data->row_array();
            if(empty($rs) === FALSE){
                $arr[$rs['rolename']] = $rs['rolename'];
            }
        }
        return $arr;
    }
    
   
    public function checkdb($server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_game_slave->select(array('value_'));
        $data = $this->_db_game_slave->get('game_service_user_userprofile_level');
        
        
        if (is_object($data)) {
            return $data->result_array();
                     
        }
        
    }
   
   public function check_db($server, $table){
		
        $this->_db_log_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
		//$this->_db_log_slave->where('name','18d1lel8b ');
        //$this->_db_log_slave->limit(100);
        //$data = $this->_db_log_slave->get('account');
        
		//$strQuery = "DESCRIBE aacount";
		
		$strQuery = "select * from `information_schema`.`tables`
		where table_name like 'cn_x6game_user_xuserprofile'";
		
		//$strQuery = "ALTER TABLE `account_name` ADD `ips` VARCHAR( 500 ) NULL AFTER `status`";
		
		$uid = $this->create_uid($id, 30);
				
		//$strQuery = "SELECT *, SUBSTR(uid,10) AS u FROM `".$table."` WHERE uid LIKE '%".$uid."'";
		
		$strQuery = "SELECT * FROM `".$table."` LIMIT 20000";
		
		//$strQuery = 'ALTER TABLE `account_name` ADD `security_code` VARCHAR( 255 ) NULL AFTER `ips`';
		
		/*
		$strQuery = "SELECT table_name,
					ENGINE
					FROM information_schema.tables
					ORDER BY table_name ASC
					LIMIT 0 , 300";
		*/
		$data = $this->_db_log_slave->query($strQuery);
		
        if (is_object($data)) {
            return $data->result_array();
        }
		 
    }
    
    public function role_all($server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_game_slave->select(array('value_'));
        $data = $this->_db_game_slave->get('cn_x6game_model_roleinfo');
        
        $arr = array();
        if (is_object($data)) {
            $rs = $data->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $a = json_decode($val['value_'], true);
                    $arr[$a['roleId']] = $a['roleName'];
                }
            }
            
        }
        return $arr;
    }
	public function username_all($server){
		$this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
		$date='2014-07-18';
		
		$sql = "SELECT "
		. "SUBSTRING_INDEX(SUBSTRING_INDEX(value_,'\"lastLoginTime\":',-1),',',1) as regTime,"
		. "SUBSTRING_INDEX(SUBSTRING_INDEX(value_,'\"level\":',-1),',',1) as level,"
		. "key_ "
		. "FROM game_service_user_userprofile "
		. "WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(value_,'\"lastLoginTime\":',-1),',',1) BETWEEN " . strtotime(date('Y-m-d 00:00:00', strtotime('2014-07-18 00:00:00'))) . '000' . " AND " . strtotime(date('Y-m-d 23:59:59', strtotime('2014-07-18 08:00:00'))) . '999';
		//echo $sql;exit;
		$data = $this->_db_game_slave->query($sql);
		
		return $data->result_array();
		
		/*
		$this->_db_game_slave->select(array('key_','value_'));
        $data = $this->_db_game_slave->get('game_service_user_userprofile');
        
        $arr = array();
        if (is_object($data)) {
            $rs = $data->result_array();
            
			if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
					$a = json_decode($val['value_'],true);
                    $arr[$val['key_']] = $a;
                }
            }
            
        }
        return $arr;
		*/
    }
	
	public function role_alll($server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_game_slave->select(array('value_'));
        $data = $this->_db_game_slave->get('cn_x6game_model_roleinfo');
        
        $arr = array();
        if (is_object($data)) {
            $rs = $data->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $a = json_decode($val['value_'], true);
                    $arr[$a['roleId']]['roleName'] = $a['roleName'];
                    $arr[$a['roleId']]['ownerId'] = $a['ownerId'];
                }
            }
            
        }
        return $arr;
    }
    public function shop_all($server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_game_slave->select(array('key_','value_'));
        $data = $this->_db_game_slave->get('game_service_shop_shopequip');
        
        $arr = array();
        if (is_object($data)) {
            $rs = $data->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $a = json_decode($val['value_'], true);
                    $arr[$val['key_']]['name'] = $a['name'];
                    $arr[$val['key_']]['money'] = $a['money'];
                }
            }
            
        }
        return $arr;
    }
    public function user_all($server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_game_slave->select(array('key_','value_'));
        $data = $this->_db_game_slave->get('cn_x6game_user_xuserprofile_regname');
        
        $arr = array();
        if (is_object($data)) {
            $rs = $data->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $arr[$val['key_']] = $val['value_'];
                }
            }
            
        }
        return $arr;
    }
    
    public function role_top($server,$top,$loaitop,$page){
        
		//echo $server; exit;
		
		$this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        if($loaitop == 'toplevel'){
            /*
			$srv = "game_log".substr($server, 4);
            $this->_db_game_slave = $this->load->database(array('db' => $srv, 'type' => 'slave'), TRUE);
            
            $cur = $page*$top - $top;
            $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                       role_id, account_id, MAX( role_level ) AS level  
                       FROM `level`
                       GROUP BY role_id 
                       ORDER BY level DESC LIMIT ".$cur.",".$top;
            
            $data = $this->_db_game_slave->query($strQuery);

            $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
            $resultTotal = $this->_db_game_slave->query($totalQuery);

            $rows = $resultTotal->result();
            $this->_total = $rows[0]->found_rows;
            */
			
			$cur = $page*$top - $top;
            $strQuery = "SELECT SQL_CALC_FOUND_ROWS 
                         key_, value_ 
                         FROM `game_service_user_userprofile_level` 
                         ORDER BY value_ DESC LIMIT ".$cur.",".$top;
            
            $data = $this->_db_game_slave->query($strQuery);

            $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
            $resultTotal = $this->_db_game_slave->query($totalQuery);

            $rows = $resultTotal->result();
            $this->_total = $rows[0]->found_rows;
            
            
        }else if($loaitop == 'topdanhvong'){
            /*
            $this->_db_game_slave->limit($top);
            $this->_db_game_slave->order_by('fame DESC');
            $data = $this->_db_game_slave->get('role');
            */
            $cur = $page*$top - $top;
            $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                       * 
                       FROM `role` ORDER BY fame DESC LIMIT ".$cur.",".$top;
            
            $data = $this->_db_game_slave->query($strQuery);

            $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
            $resultTotal = $this->_db_game_slave->query($totalQuery);

            $rows = $resultTotal->result();
            $this->_total = $rows[0]->found_rows;
            
        }else if($loaitop == 'topthucluc'){
            /*
            $this->_db_game_slave->limit($top);
            $this->_db_game_slave->order_by('exp DESC');
            $data = $this->_db_game_slave->get('role');
             * 
             */
            $cur = $page*$top - $top;
            $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                       * 
                       FROM `role` ORDER BY lastPushShili DESC LIMIT ".$cur.",".$top;
            
            $data = $this->_db_game_slave->query($strQuery);

            $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
            $resultTotal = $this->_db_game_slave->query($totalQuery);

            $rows = $resultTotal->result();
            $this->_total = $rows[0]->found_rows;
        }else if($loaitop == 'onlineMilliTime'){
            $cur = $page*$top - $top;
            $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                       * 
                       FROM `role` ORDER BY onlineMilliTime DESC LIMIT ".$cur.",".$top;
            
            $data = $this->_db_game_slave->query($strQuery);

            $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
            $resultTotal = $this->_db_game_slave->query($totalQuery);

            $rows = $resultTotal->result();
            $this->_total = $rows[0]->found_rows;
        }elseif ($loaitop == 'userbuy') {
            //$srvLog = "game_log".substr($server, 4);
            $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
            $cur = $page*$top - $top;
            
            $strQuery = "SELECT SQL_CALC_FOUND_ROWS U.*, S.*  FROM (SELECT * FROM `userbuy101`) AS U 
                         LEFT JOIN shoptbl AS S ON U.goodscode = S.goodscode ORDER BY S.buysum DESC LIMIT ".$cur.",".$top;
                      
            $data = $this->_db_game_slave->query($strQuery);

            $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
            $resultTotal = $this->_db_game_slave->query($totalQuery);

            $rows = $resultTotal->result();
            $this->_total = $rows[0]->found_rows;
        }
        if (is_object($data)) {
             if($loaitop != 'onlineMilliTime' || $loaitop != 'toplevel'){
                return $data->result_array();
             }else{
                $result = $data->result_array();
                foreach($result as $key => $val){
                    $result[$key]['onlineHourTime'] = $this->tinhGio($val['onlineMilliTime']/1000);
                }
                return $result;
            }
        }
    }
    public function getTotal(){
        return $this->_total;
    }
    public function infouserrole($role_id = NULL, $server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        if(empty($role_id) === FALSE){
            $this->_db_game_slave->select(array('value_'));
            $this->_db_game_slave->where('key_', $role_id);
            $data = $this->_db_game_slave->get('game_service_user_userprofile');
            if (is_object($data)) {
                $rs = $data->row_array();
                return json_decode($rs['value_'],true);
            }
        }else{
            $this->_db_game_slave->select(array('value_'));
            $data = $this->_db_game_slave->get('game_service_user_userprofile');
            $arr = array();
            if (is_object($data)) {
                $rs = $data->result_array();
                if(empty($rs) === FALSE){
                    foreach($rs as $key => $val){
                        $arr[$key] = json_decode($val['value_'],true);
                    }
                }
            }
            return $arr;
        }
        
        
    }
    public function getCollection($key, $server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        $this->_db_game_slave->select(array('value_'));
        $this->_db_game_slave->where('key_', $key);
        $data = $this->_db_game_slave->get('com_xingcloud_service_item_owneditemcollection');
        $arr = array();       
        if (is_object($data)) {
            $rs = $data->row_array();
            $r = json_decode($rs['value_'],true);
            if(empty($r['items']) === FALSE){
                $arr['tbl'] = str_replace('.','_',strtolower($r['items'][0]));
                $s = '';
                foreach($r['items'][1] as $v){
                    if($s == ''){
                        $s .= "'".$v."'";                        
                    }else{
                        $s .= ",'".$v."'";
                    }
                }
                $arr['keys'] = $s;
            }
        }
        return $arr;
    }
    public function getCollection_All($key, $server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        
        //$this->_db_game_slave->select(array('value_'));
        //$this->_db_game_slave->where('key_', $key);
        //$data = $this->_db_game_slave->get('com_xingcloud_service_item_owneditemcollection');
        
        $strQuery = "SELECT value_ 
                     FROM `com_xingcloud_service_item_owneditemcollection` 
                     WHERE key_ IN (".$key.")";
        $data = $this->_db_game_slave->query($strQuery);
        $arr = array();       
        if (is_object($data)) {
            $rs = $data->result_array();
            $s = '';
            
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $r = json_decode($val['value_'],true);

                    if(empty($r['items']) === FALSE){
                        $arr['tbl'] = str_replace('.','_',strtolower($r['items'][0]));

                        foreach($r['items'][1] as $v){
                            if($s == ''){
                                $s .= "'".$v."'";                        
                            }else{
                                $s .= ",'".$v."'";
                            }
                        }

                    }
            
                }
            }
            
            
            
            
            $arr['keys'] = $s;
            
            
            
        }
        return $arr;
    }
    public function getVls($collection = array(),$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $strQuery = "SELECT * 
                     FROM `".$collection['tbl']."` 
                     WHERE key_ IN (".$collection['keys'].") 
                    ";
        
        $result = $this->_db_game_slave->query($strQuery);
        $arr = array();
        if (is_object($result)) {
            $rs = $result->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $arr[$key] = json_decode($val['value_'], true);
                }
            }
        }
        return $arr;
    }
    public function level_log($account_id,$server,$per_page,$page,$date){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        //$strQuery = "SELECT SQL_CALC_FOUND_ROWS FROM_UNIXTIME(SUBSTR(log_time,1,10),'%Y-%m-%d %H:%i:%s') AS log_time, log_time2, role_level, channel, game_id, account_id   
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS log_time2, role_level, channel, game_id, account_id   
                     FROM level 
                     WHERE account_id = '".$account_id."' AND date(log_time2) = '".$date."' 
                     ORDER BY log_time2 ASC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        if (is_object($result)) {
            return $result->result_array();
        }
                   
    }
    public function accountlogin_log($account_id,$server,$per_page,$page,$date){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS log_time2,ip_address, channel, game_id, account_id, message_type    
                     FROM accountlogin 
                     WHERE account_id = '".$account_id."' AND date(log_time2) = '".$date."' 
                     ORDER BY log_time2 ASC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        if (is_object($result)) {
            return $result->result_array();
        }
        
    }
    public function accountregister_log($account_id,$server,$per_page,$page){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS log_time2,mac_address,channel,game_id,account_id,message_type    
                     FROM accountregister 
                     WHERE account_id = '".$account_id."' 
                     ORDER BY log_time2 ASC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        if (is_object($result)) {
            return $result->result_array();
        }
        
    }
	public function moneyremove_log($account_id,$server,$per_page,$page,$date){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS log_time2,before_num,after_num,role_level,way,channel,game_id,account_id,message_type    
                     FROM moneyremove 
                     WHERE account_id = '".$account_id."' AND date(log_time2) = '".$date."' 
                     ORDER BY log_time2 ASC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        if (is_object($result)) {
            return $result->result_array();
        }
    }
    public function rolelogin_log($account_id,$server,$per_page,$page,$date){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS log_time2,role_level,channel,game_id,account_id,message_type    
                     FROM rolelogin 
                     WHERE account_id = '".$account_id."' AND date(log_time2) = '".$date."' 
                     ORDER BY log_time2 ASC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        if (is_object($result)) {
            return $result->result_array();
        }
    }
    public function roleregister_log($account_id,$server,$per_page,$page){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS log_time2,role_id,channel,game_id,account_id,message_type    
                     FROM roleregister 
                     WHERE account_id = '".$account_id."' 
                     ORDER BY log_time2 ASC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        if (is_object($result)) {
            return $result->result_array();
        }
    }
    public function gold_top($server,$per_page,$page){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS * 
                     FROM `game_service_user_userprofile_gold` 
                     ORDER BY value_ DESC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        
        if (is_object($result)) {
            return $result->result_array();
        }
        
    }
    public function rmbamount_top($server,$per_page,$page){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS * 
                     FROM `game_service_user_userprofile_rmbamount` 
                     ORDER BY value_ DESC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        
        if (is_object($result)) {
            return $result->result_array();
        }
        
    }
    public function heronum_top($server,$per_page,$page){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS * 
                     FROM `game_service_user_userprofile_heronum` 
                     ORDER BY value_ DESC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        
        if (is_object($result)) {
            return $result->result_array();
        }
        
    }
    public function pvpwinning_top($server,$per_page,$page){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS * 
                     FROM `game_service_user_userprofile_pvpwinning` 
                     ORDER BY value_ DESC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        
        if (is_object($result)) {
            return $result->result_array();
        }
        
    }
    public function getVls_All($collection = array(),$server,$per_page,$page){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS * 
                     FROM `".$collection['tbl']."` 
                     WHERE key_ IN (".$collection['keys'].") 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        $arr = array();
        if (is_object($result)) {
            $rs = $result->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $arr[$key] = json_decode($val['value_'], true);
                }
            }
        }
        return $arr;
    }
    public function shopequip($strItem,$server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $strQuery = "SELECT * 
                     FROM `game_service_shop_shopequip` 
                     WHERE key_ IN (".$strItem.") 
                    ";
        
        $result = $this->_db_game_slave->query($strQuery);
        $arr = array();
        if (is_object($result)) {
            $rs = $result->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $arr[$key] = json_decode($val['value_'], true);
                }
            }
        }
        return $arr;
    }
    public function loginnum($server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $t = (time() - 86400*30).'999';
        
		/*
		$strQuery = "
                        SELECT DATE( FROM_UNIXTIME( SUBSTR( value_, 1, 10 ) ) ) AS d, COUNT( * ) AS v 
                        FROM `game_service_user_userprofile_lastlogintime` 
                        WHERE value_ > ".$t." 
                        GROUP BY d             
                    ";
        */
		$strQuery = "SELECT t.d, COUNT(*) AS v  
                        FROM (SELECT DATE( FROM_UNIXTIME( SUBSTR( log_time, 1, 10 ) ) ) AS d, account_id 
                        FROM `accountlogin` 
                        WHERE log_time > ".$t."
						GROUP BY d, account_id) AS t 
                        GROUP BY t.d
                    ";
		
		
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }        
    }
    public function quit7($server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $t = date('Y-m-d',(strtotime(date('Y-m-d')) - 86400*11));
       
        $strQuery = "
                        SELECT t.level, COUNT( * ) AS c 
                        FROM (
                        SELECT game_service_user_userprofile_level.value_ AS level,  FROM_UNIXTIME(SUBSTR(game_service_user_userprofile_lastlogintime.value_,1,10)) AS timelogin 
                        FROM game_service_user_userprofile_level
                        LEFT JOIN game_service_user_userprofile_lastlogintime ON game_service_user_userprofile_level.key_ = game_service_user_userprofile_lastlogintime.key_
                        ) AS t
                        WHERE DATE(t.timelogin) > '".$t."' 
                        GROUP BY t.level
                    ";
        
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }        
    }
    public function quit30($server){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $t = date('Y-m-d',(strtotime(date('Y-m-d')) - 86400*30));
       
        $strQuery = "
                        SELECT t.level, COUNT( * ) AS c 
                        FROM (
                        SELECT game_service_user_userprofile_level.value_ AS level,  FROM_UNIXTIME(SUBSTR(game_service_user_userprofile_lastlogintime.value_,1,10)) AS timelogin 
                        FROM game_service_user_userprofile_level
                        LEFT JOIN game_service_user_userprofile_lastlogintime ON game_service_user_userprofile_level.key_ = game_service_user_userprofile_lastlogintime.key_
                        ) AS t
                        WHERE DATE(t.timelogin) > '".$t."' 
                        GROUP BY t.level
                    ";
        
        $result = $this->_db_game_slave->query($strQuery);
        if (is_object($result)) {
            return $result->result_array();
        }        
    }
    public function get_mail($server, $role_id, $option){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        if($option == 'preceivemail'){
            $table = 'game_service_item_cn_iggame_player_preceivemail';
        }elseif($option == 'psendmail'){
            $table = 'game_service_item_cn_iggame_player_psendmail';
        }
        $strQuery = "SELECT *  
                     FROM `".$table."` 
                     WHERE value_ LIKE '%".$role_id."%'
                    ";
       
        $result = $this->_db_game_slave->query($strQuery);
        $arr = array();
        if (is_object($result)) {
            $rs = $result->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $v = json_decode($val['value_'],TRUE);
                    //$arr[$key]['role_id'] = $role_id;
                    $arr[$key]['sendTime'] = date('Y-m-d H:i:s',substr($v['sendTime'],0,10));
                    $arr[$key]['content'] = base64_decode($v['content']);
                    $arr[$key]['senderName'] = $v['senderName'];
                    $arr[$key]['className'] = $v['className'];
                }
            }
        }
        return $arr;
    }
    private function tinhGio($tongTg){
        $khoanphut = (int)($tongTg/60);
        $khoangiay = $tongTg%60;
        if($khoangiay > 0){
                $giay = $khoangiay . "'";
        }else{
                $giay = "";
        }
        if($khoanphut >= 60){
           $gio = (int)($khoanphut/60) . "H";
           $phutt = $khoanphut%60;
           if($phutt > 0){
                $phut = $phutt . "P";
           }else{
                $phut = "";
           }
        }else{
                if($khoanphut > 0){
                        $phut = $khoanphut . "P";
                }else{
                        $phut = "";
                }

                $gio = "";

        }
        $thoigian = $gio . $phut . $giay;
        return $thoigian;
    }
    private function create_uid($str,$len){
        $arrbs = array();

        for($i=0; $i < $len; $i++){
                if($i == 0){
                        $arrbs[$i] = '';
                }else{
                        $arrbs[$i] = $arrbs[$i-1] . '0';
                }
        }		
        $cStr = array_sum(count_chars($str));
        $uid = $arrbs[$len-$cStr].$str;

        return $uid;
    }
    public function item_all(){
       
        $this->_db_game_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_game_slave->select(array('id','name','type','coin','gold','color','shop','desc'));
        $data = $this->_db_game_slave->get('items');
        
        $arr = array();
        if (is_object($data)) {
            $rs = $data->result_array();
            if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $arr[$val['id']]['id'] = $val['id'];
                    $arr[$val['id']]['name'] = $val['name'];
                    $arr[$val['id']]['type'] = $val['type'];
                    $arr[$val['id']]['coin'] = $val['coin'];
                    $arr[$val['id']]['gold'] = $val['gold'];
                    $arr[$val['id']]['color'] = $val['color'];
                    $arr[$val['id']]['shop'] = $val['shop'];
                    $arr[$val['id']]['desc'] = $val['desc'];
                }
            }
            
        }
        
        return $arr;
       
       
    }
	
	public function accountlogin_logtime($server,$per_page,$page,$datedb){
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
        $cur = $page*$per_page - $per_page;
        $strQuery = "SELECT SQL_CALC_FOUND_ROWS log_time2,ip_address, channel, game_id, account_id, message_type    
                     FROM accountlogin 
                     WHERE log_time2 >= '2014-07-18 00:00:00' AND log_time2 <= '2014-07-18 08:00:00'  
					 GROUP BY account_id 
                     ORDER BY log_time2 ASC 
                     LIMIT ".$cur.",".$per_page;
        
        $result = $this->_db_game_slave->query($strQuery);
        
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_game_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        if (is_object($result)) {
            return $result->result_array();
        }
        
    }
	
	public function mobo_all(){
        $this->_db_game_slave = $this->load->database(array('db' => 'moboinfo', 'type' => 'slave'), TRUE);
        
        $this->_db_game_slave->select();
        $data = $this->_db_game_slave->get('accounts');
        
        $arr = array();
        if (is_object($data)) {
            $rs = $data->result_array();
            
			if(empty($rs) === FALSE){
                foreach($rs as $key => $val){
                    $arr[$val['id'].'_12'] = $val['account'];                    
                }
            }
            
        }
        return $arr;
    }
	public function top_level_cron($server,$top,$time,$page){
		
        $this->_db_game_slave = $this->load->database(array('db' => $server, 'type' => 'slave'), TRUE);
             
        //$srv = "game_log".substr($server, 4);
				
        //$this->_db_game_slave = $this->load->database(array('db' => $srv, 'type' => 'slave'), TRUE);
		
        $cur = $page*$top - $top;
        /*        
        $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                   role_id, account_id, MAX( role_level ) AS level, log_time2   
                   FROM `level` 
                   WHERE log_time2 < '".$time."'
                   GROUP BY role_id 
                   ORDER BY level DESC LIMIT ".$cur.",".$top;
		*/
		$strQuery = "SELECT key_, value_ 
                         FROM `game_service_user_userprofile_level` 
                         ORDER BY value_ DESC LIMIT ".$cur.",".$top;
						 

        $data = $this->_db_game_slave->query($strQuery);

        
        if (is_object($data)) {
            return $data->result_array();
        }
            
              
        
    }
    public function save_cron_level($data,$time){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => '3k_logs', 'type' => 'slave'), TRUE);
              
            $arr = array();
             $arr['create_time'] = $time;
            $arr['data'] = $data;
            
            $this->_db_slave->insert('cron_top_level',$arr);
        
    }
	
	
    
}