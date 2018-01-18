<?php

/**
 * sms model
 *
 * @author thuonghh
 */
class AccountModel extends CI_Model {

    private $_db;
    private $_db_slave;
    private $_db_mobo_master;
    private $_db_mobo_slave;
    
    protected $_total;

    public function __construct() {
        
    }

    public function getMoboInfoByMoboAccount($server, $mobo_acc) {

        $this->_db_mobo_slave = $this->load->database(array('db' => 'mobo_info', 'type' => 'master'), TRUE);
        $sql = $this->db_slave->select()
                ->from('account')
                ->where('mobo_account = (?)', $mobo_acc)
                ->limit(1)
        ;
        return $this->db_slave->fetchAll($sql);
    }

    public function getMoboInfoByAccountID($id) {

        $this->_db_mobo_slave = $this->load->database(array('db' => 'mobo_info', 'type' => 'slave'), TRUE);


        $this->_db_mobo_slave->where('id', $id);
        $this->_db_mobo_slave->limit(1);
        $data = $this->_db_mobo_slave->get('account');

        if (is_object($data)) {
            return $data->row_array();
        }
    }

    public function AccountInfoByUserID($userID = false, $worldID = false) {
        $this->_db_slave = $this->load->mongodb(array('db' => 'account', 'type' => 'slave'), TRUE);
       
        $where = array('userID' => $userID, 'worldID' => $worldID);
        $where = array_filter($where);
        $data = $this->_db_slave->where($where)->get('actorlist');

        if (is_array($data)) {
            foreach ($data as $value) {
                $result[$value['actorID']] = $value;
            }
            return $result;
        }
        return false;
    }

    public function getCharInf($accountid, $userid, $username, $server = false) {
        $this->_db_slave = $this->load->mongodb(array('db' => $server, 'type' => 'master'), TRUE);
        $where = array('userID' => $accountid, 'actorID' => $userid, 'name' => $username);
        $where = array_filter($where);
        $data = $this->_db_slave->where($where)->get('actor');

        if (is_array($data)) {
            foreach ($data as $value) {
                $result[$value['actorID']] = $value;
            }
            return $result;
        }
        return false;
    }

    public function getCharInfByID($accountid, $userid, $username, $server = false) {
        $db = mdb::get($server, 'slave', 'manhthuDBConfig');
        $where = array('userID' => $accountid, 'actorID' => $userid, 'name' => $username);
        $where = array_filter($where);
        $data = $this->_db_slave->where($where)->get('actor');

        echo '<pre>';
        print_r($data);
        exit;
        if (is_array($data)) {
            foreach ($data as $value) {
                $result[$value['actorID']] = $value;
            }
            return $result;
        }
        return false;
    }

    public function getActiveCharacterUser($server, $date) {
        $db = mdb::get($server, 'slave', 'manhthuDBConfig');

        switch ($date) {
            case 1:
                $start = strtotime(date('Y-m-d 00:00:00', strtotime("-1 day")));
                $end = strtotime(date('Y-m-d 23:59:59', strtotime("-1 day")));
                break;
            case 7:
                $start = strtotime(date('Y-m-d 00:00:00', strtotime("-7 day")));
                $end = strtotime(date('Y-m-d 23:59:59', strtotime("-1 day")));
                break;
            case 30:
                $start = strtotime(date('Y-m-d 00:00:00', strtotime("-30 day")));
                $end = strtotime(date('Y-m-d 23:59:59', strtotime("-1 day")));
                break;
        }
        return $this->_db_slave->where_between('actor_login_time', $start, $end)->count('actor');
    }

    public function getNRUServer($server, $date = '1') {
        $db = mdb::get($server, 'slave', 'manhthuDBConfig');

        $start = strtotime(date('Y-m-d 00:00:00', strtotime("-{$date} day")));
        $end = strtotime(date('Y-m-d 23:59:59', strtotime("-{$date} day")));

        $data = $this->_db_slave->select(array('userID'))
                ->where(array('level' => array('$gt' => 1)))
                ->where_between('actor_create_time', $start, $end)
                ->get('actor');

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $result[$value['userID']] = $value['userID'];
            }
            return array_keys($result);
        }
        return false;
    }

    public function getNRUCharacterServer($server, $sdate = 1, $edate = 1) {
        $db = mdb::get($server, 'slave', 'manhthuDBConfig');
        $start = strtotime(date('Y-m-d 00:00:00', strtotime("-{$edate} day")));
        $end = strtotime(date('Y-m-d 23:59:59', strtotime("-{$sdate} day")));

        return $this->_db_slave->where_between('actor_login_time', $start, $end)->count('actor');
    }

    public function getTRUCharacterServer($server, $date = '1') {
        $db = mdb::get($server, 'slave', 'manhthuDBConfig');
        return $this->_db_slave->count('actor');
    }

    public function testGroup($server, $date) {
        $db = mdb::get($server, 'slave', 'manhthuDBConfig');

        $arr['keys'] = array("sex" => 1);
        $arr['initial'] = array("total" => 0);
        $arr['reduce'] = "function (curr, result ) { result.total ++; }";
        $arr['condition'] = array("actor_login_time" => array('$gte' => strtotime("-30 day")), "actor_login_time" => array('$lte' => strtotime("-1 day")));

        $data = $this->_db_slave->group('actor', $arr);
        echo '<pre>';
        print_r($data);
        exit;
    }
    
    public function getAccount($start, $per_page) {

         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            
            
            $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                   * 
                   FROM `account_name` 
                   ORDER BY id ASC LIMIT ".$start.",".$per_page;

            $result1 = $this->_db_slave->query($strQuery);

            $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
            $resultTotal = $this->_db_slave->query($totalQuery);

            $rows = $resultTotal->result();
            $this->_total = $rows[0]->found_rows;

            if (is_object($result1)) {
                return $result1->result_array();
            }
       
    }
    
    public function getAccounts($start, $per_page) {

         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            
            $arruser = array('thuonghh','khoapm','tailm','phuongnt','trungphc');
            $str = '';
            foreach($arruser as $val){
                if($str == ''){
                    $str .= "'" . $val . "'";
                }else{
                    $str .= ",'" . $val . "'";
                }
            }
            $info = $this->Session->get_session('account');
            
            if(in_array($info['username'],$arruser)){
                $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                       * 
                       FROM `account_name` 
                       WHERE status = 1 
                       ORDER BY id ASC LIMIT ".$start.",".$per_page;
            }else{
                $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                       * 
                       FROM `account_name` 
                       WHERE username NOT IN (" . $str . ") AND status = 1 
                       ORDER BY id ASC LIMIT ".$start.",".$per_page;
            }
            $result1 = $this->_db_slave->query($strQuery);

            $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
            $resultTotal = $this->_db_slave->query($totalQuery);

            $rows = $resultTotal->result();
            $this->_total = $rows[0]->found_rows;

            if (is_object($result1)) {
                return $result1->result_array();
            }
       
    }
	public function updateQr(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $arrParam = $this->input->post();
        
         $strQuery="UPDATE account_name SET 
                           `security_code` = '".trim($arrParam['secret'])."' 
                           WHERE username = '".$arrParam['username']."'";
         return $this->_db_slave->query($strQuery);
        
    }
    public function getAccountApi($username) {
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->where('username',$username);
        $this->_db_slave->limit(1);
        $data = $this->_db_slave->get('account_name');

        if (is_object($data)) {
            return $data->row_array();
        }
    }
    public function getAccountStatusApi($status){
        if (!$this->_db_slave)
          $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->where('status',$status);
        $data = $this->_db_slave->get('account_name');

        if (is_object($data)) {
            return $data->result_array();
        }
    }
    public function getAccountsApi($page, $limit=50){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $cur = $page*$limit - $limit;
        $strQuery="SELECT SQL_CALC_FOUND_ROWS 
                   * 
                   FROM `account_name` ORDER BY id ASC LIMIT ".$cur.",".$limit;
        $result1 = $this->_db_slave->query($strQuery);
        
        $totalQuery = "SELECT FOUND_ROWS() AS `found_rows`";
        $resultTotal = $this->_db_slave->query($totalQuery);

        $rows = $resultTotal->result();
        $this->_total = $rows[0]->found_rows;
        
        if (is_object($result1)) {
            return $result1->result_array();
        }
    }
    public function getTotal(){
        return $this->_total;
    }
    public function get_menu($groupId){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('id', 'display_name','menu_cp_parent','permission'));
        $this->_db_slave->where('menu_group_id',$groupId);
        $sql = $this->_db_slave->get('menu_cp');
        return $sql->result_array();
    }
    public function get_groupmenu(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('id', 'display_name'));
        $sql = $this->_db_slave->get('menu_group');
        return $sql->result_array();
    }
    public function get_adminmenu($id){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('menu_id'));
        $this->_db_slave->where('account_id',$id);
        $sql = $this->_db_slave->get('account_has_menu');
        return $sql->result_array();
    }
    public function get_admin($id){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('username', 'fullname', 'ips','id_group'));
        $this->_db_slave->where('id',$id);
        $data = $this->_db_slave->get('account_name');
        if (is_object($data))
            return $data->row_array();
    }
    public function saveItem(){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
        $arrParam = $this->input->post();
         
        $arrAc = array();
        
        
        if(isset($arrParam['adminid'])){
            
                if(empty($arrParam['ips']) === FALSE){
                    $strip = implode(",", $arrParam['ips']);
                    
                    if(strpos($strip,'all') !== false){
                        $ips = 'all';
                    }else{
                        $ips = $strip;
                    }
                }else{
                    $ips = null;
                }
                
                $strQuery="UPDATE account_name SET 
                           username = '".trim($arrParam['username'])."', 
                           fullname = '".trim($arrParam['fullname'])."', 
						   id_group = '".trim($arrParam['id_group'])."',
                           ips = '".$ips."' 
                           WHERE id = '".$arrParam['adminid']."'";
                $this->_db_slave->query($strQuery);
                //delete admin_has_menu and reupdate
                $this->_db_slave->delete('account_has_menu', array('account_id' => $arrParam['adminid']));
				//$this->_db_slave->delete('module_user', array('id_user' => $arrParam['adminid']));
                if(empty($arrParam['mid']) === FALSE){
                    foreach($arrParam['mid'] as $val){
                            $arr = array();
                            $arr['account_id'] = $arrParam['adminid'];
                            $arr['menu_id'] = $val;
                            $this->_db_slave->insert('account_has_menu',$arr);
                    }
                }
        }else{
                if(empty($arrParam['ips']) === FALSE){
                    $strip = implode(",", $arrParam['ips']);
                    
                    if(strpos($strip,'all') !== false){
                        $ips = 'all';
                    }else{
                        $ips = $strip;
                    }
                }else{
                    $ips = null;
                }
                
                $arrAc['username'] = trim($arrParam['username']);
                $arrAc['fullname'] = trim($arrParam['fullname']);
                $arrAc['password'] = md5(trim($arrParam['username']));
                $arrAc['partner_id'] = 1;
                $arrAc['partner_name'] = 'ME';
                $arrAc['ips'] = $ips;
				$arrAc['id_group'] = $arrParam['id_group'];
                $this->_db_slave->insert('account_name',$arrAc);
                $id = $this->_db_slave->insert_id();
                foreach($arrParam['mid'] as $val){
                        $arr = array();
                        $arr['account_id'] = $id;
                        $arr['menu_id'] = $val;
                        $this->_db_slave->insert('account_has_menu',$arr);
                }
        }

    }
    public function saveItemApi($username, $fullname, $strip){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
                                
                $arrAc['username'] = trim($username);
                $arrAc['fullname'] = trim($fullname);
                $arrAc['password'] = md5(trim($username));
                $arrAc['partner_id'] = 1;
                $arrAc['partner_name'] = 'ME';
                $arrAc['status'] = 1;
                $arrAc['ips'] = $strip;
                
                $this->_db_slave->insert('account_name',$arrAc);
                $id = $this->_db_slave->insert_id();
                if(isset($id) && empty($id) === FALSE){
                    //cap quyen co ban
                    $mid = array(7,8);
                    foreach($mid as $val){
                        $arr = array();
                        $arr['account_id'] = $id;
                        $arr['menu_id'] = $val;
                        $this->_db_slave->insert('account_has_menu',$arr);
                    }
                }
    }
    public function status(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $id = $_GET['id'];
        $st = $_GET['st'];
        if($st == 0){
                $status = 1;
        }else{
                $status = 0;
        }
        $strQuery="UPDATE account_name SET status = '".$status."' WHERE id = '".$id."'";
        $this->_db_slave->query($strQuery);
    }
    public function delete(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $id = $_GET['iddelete'];
        
        $this->_db_slave->delete('account_has_menu', array('account_id' => $id));
        
        $this->_db_slave->delete('account_name', array('id' => $id));
		$this->_db_slave->delete('module_user', array('id_user' => $id));
        
    }
    public function statusApi($username,$status){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $strQuery="UPDATE account_name SET status = '".$status."' WHERE username = '".$username."'";
        $this->_db_slave->query($strQuery);
    }
    public function getMenuApi($userId){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
            $this->_db_slave->select(array('menu_cp.*','menu_group.display_name as groupp'));
            $this->_db_slave->join('menu_group', 'menu_cp.menu_group_id = menu_group.id', 'left');
            $this->_db_slave->join('account_has_menu', 'account_has_menu.menu_id = menu_cp.id', 'left');
            $this->_db_slave->where('account_has_menu.account_id', $userId);
            $this->_db_slave->order_by('menu_cp.order ASC');
            $data = $this->_db_slave->get('menu_cp');
            $arrResult = array();
            if (is_object($data)){
                return $data->result_array();
            }
    }
    public function getAccountMenuApi($menuid){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
            $this->_db_slave->select(array('account_name.*'));
            $this->_db_slave->join('account_name', 'account_has_menu.account_id = account_name.id', 'left');
            $this->_db_slave->where('account_has_menu.menu_id', $menuid);
            $data = $this->_db_slave->get('account_has_menu');
            $arrResult = array();
            if (is_object($data)){
                return $data->result_array();
            }
    }
	
	public function listModule(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from('module');
        $this->_db_slave->where('status',1);
        $this->_db_slave->order_by('order','ASC');
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $result = process($result,0);
            return $result;
        }
        return FALSE;
    }
    public function listPermissionById($parents){
		$items = $this->listModule();
        $data = process($items,$parents);
        $cid = array();
        if(count($data)>0){			
            foreach ($data as $key => $val){
                $cid[] = $val['id'];
            }
        }
		
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('id'));
        $this->_db_slave->from('module');
        $this->_db_slave->where('status',1);
		$this->_db_slave->where_in('id',$cid);
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    public function savePermisssion($arrParam){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        if($arrParam['type']=='multi'){
            $listPermissionById = $this->listPermissionById($arrParam['id_permisssion']);
            if(count($listPermissionById)>0){
                foreach($listPermissionById as $v){
                    $arrData['id_user'] = $arrParam['id_user'];
                    $arrData['id_permisssion'] = $v['id'];
                    $this->_db_slave->delete('module_user',array('id_user' => $arrParam['id_user'],'id_permisssion'=>$v['id']));
                    $this->_db_slave->insert('module_user',$arrData);
                }
            }
        }else{
            $arrData['id_user']         = $arrParam['id_user'];
            $arrData['id_permisssion']  = $arrParam['id_permisssion'];
			$arrData['id_game']         = $arrParam['id_game'];
            $this->_db_slave->insert('module_user',$arrData);
        }
    }
    public function deletePermisssion($arrParam){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        if($arrParam['type']=='multi'){
            $listPermissionById = $this->listPermissionById($arrParam['id_permisssion']);
            if(count($listPermissionById)>0){
                foreach($listPermissionById as $v){
                    $this->_db_slave->delete('module_user',array('id_user' => $arrParam['id_user'],'id_permisssion'=>$v['id']));
                }
            }
        }else{
			if($arrParam['id_permisssion']>0 && $arrParam['id_game']>0){
                $this->_db_slave->delete('module_user',array('id_user' => $arrParam['id_user'],'id_permisssion'=>$arrParam['id_permisssion'],'id_game'=>$arrParam['id_game']));
            }else{
				$this->_db_slave->delete('module_user',array('id_user' => $arrParam['id_user'],'id_permisssion'=>$arrParam['id_permisssion']));
			}
        }
    }
    public function userPermission($id_user){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from('module_user');
        $this->_db_slave->where('id_user',$id_user);
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
	public function checkUserPermission($id_user,$id_permisssion,$id_game){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from('module_user');
        $this->_db_slave->where('id_user',$id_user);
        $this->_db_slave->where('id_permisssion',$id_permisssion);
		if($id_game>0){
            $this->_db_slave->where('id_game',$id_game);
        }
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->row_array();
            if(count($result)>0){
                $flag = 'co';
            }else{
                $flag = 'khong';
            }
            return $flag;
        }
        return '1';
    }
	public function listGamePermission(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $this->_db_slave->select(array('id','name','game'));
        $this->_db_slave->from('module');
        $this->_db_slave->where('parents',67);
        $this->_db_slave->where('id_type',1);
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
}