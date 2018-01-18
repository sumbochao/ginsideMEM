<?php
class ReportActiveModel extends CI_Model {
    public function __construct() {
       
    }
    function freeDBResource($dbh){
        while(mysqli_next_result($dbh)){
            if($l_result = mysqli_store_result($dbh)){
                mysqli_free_result($l_result);
            }
        }
    }
    public function listServer($game){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->select(array('server_id','server_name'))
                        ->from('server_list')
                        ->where('game',$game)
                        ->where('status',1)
                        ->get();
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    public function listByServer($arrServer,$game){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->select(array('server_id','server_name'))
                        ->from('server_list')
                        ->where('game',$game)
                        ->where_in('server_id',$arrServer)
                        ->where('status',1)
                        ->get();
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    
    public function userActiveByServer($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_user_active_byserver('".$arrParam['server']."','".$arrParam['date_from']."','".$arrParam['date_to']."')";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	
    public function userActiveByDate($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_user_active_bydate('".$arrParam['date']."')";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    public function levelActiveByServer($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_level_active_byserver('".$arrParam['server']."','".$arrParam['date_from']."','".$arrParam['date_to']."')";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    public function levelActiveByDate($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_level_active_bydate('".$arrParam['date']."')";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    
    public function levelStatisticsByDate($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_level_statistics_bydate('".$arrParam['date']."')";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    
    public function topupByServer($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_topup_byserver('".$arrParam['server']."','".$arrParam['date_from']."','".$arrParam['date_to']."')";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    
    public function money($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_money_statistics()";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    public function moneyByDate($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_money_statistics_bydate('".$arrParam['date']."')";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	public function moneyByServer($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_money_statistics_byserver('".$arrParam['server']."','".$arrParam['date_from']."','".$arrParam['date_to']."')";       
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	public function cardStatisticsGame($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $data = $this->_db_slave->select(array('*'))
                        ->from('card_statistics')
                        ->get();
        }else{
            $this->freeDBResource($this->_db_slave->conn_id);
            $sql = "CALL sp_get_card_statistics()";       
            $data = $this->_db_slave->query($sql);
        }
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	public function listVipByserver($arrParam,$database){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_list_vip_byserver('".$arrParam['server']."','".$arrParam['vip']."')";    
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	//BOG
	public function roleActiveByServer($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_role_active_byserver('".$arrParam['server']."','".$arrParam['date_from']."','".$arrParam['date_to']."')";
        $data = $this->_db_slave->query($sql);
		
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    
    public function roleActiveByDate($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_role_active_bydate('".$arrParam['date']."')";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	//bluegem
	public function bluegemStatisticsByServer($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_bluegem_statistics_byserver('".$arrParam['server']."','".$arrParam['date_from']."','".$arrParam['date_to']."')";
        $data = $this->_db_slave->query($sql);
		
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    
    public function bluegemStatisticsByDate($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_bluegem_statistics_bydate('".$arrParam['date']."')";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	//te thien thống kê VIP
    public function vipStatisticsByDate($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_vip_statistics_bydate('".$arrParam['date']."')";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    public function vipStatisticsByServer($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_vip_statistics_byserver('".$arrParam['server']."','".$arrParam['date_from']."','".$arrParam['date_to']."')";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    //tề thiên thống kê card tướng
    public function cardStatisticsByDate($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_card_statistics_bydate('".$arrParam['date']."',".$arrParam['Is5Start'].")";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    public function cardStatisticsByServer($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_card_statistics_byserver('".$arrParam['server']."','".$arrParam['date_from']."','".$arrParam['date_to']."',".$arrParam['Is5Start'].")";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	public function moneyStatisticsActiveUserAll($database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_money_statistics_activeuser_all()";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    public function moneyStatisticsActiveUserDetails($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_money_statistics_activeuser_details('".$arrParam['server']."')";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	public function topBattleScore($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL sp_get_top_battlescore('".$arrParam['server']."')";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	//game ban ca
    public function getDataUserIngot($arrParam){
		$server="iFish_Slave_DB";
		$username="inside";
		$password="wtAXMNJySMBCebl";
		$conn = mssql_connect($server, $username, $password) or die("Couldn'tt connect to SQL Server on"); 
		mssql_select_db('ReportDataDB', $conn);
		switch($arrParam['type']){
			case "tatca":
				$result = mssql_query('exec sp_get_data_user_ingot', $conn);
				break;
			case "ngay":
				$result = mssql_query('exec sp_get_data_user_ingot "'.$arrParam['date'].'"', $conn);
				break;
			case "khoangngay":
				$result = mssql_query('exec sp_get_data_user_ingot "'.$arrParam['date_from'].'","'.$arrParam['date_to'].'"' , $conn);
				break;
		}
		$row = mssql_num_rows($result);
		$data = array();
		while($row = mssql_fetch_assoc($result)){
			$data[] = $row;
		}
        return $data;
    }
	public function getDataUserIngotDetail($arrParam){
		$server="iFish_Slave_DB";
		$username="inside";
		$password="wtAXMNJySMBCebl";
		$conn = mssql_connect($server, $username, $password) or die("Couldn'tt connect to SQL Server on"); 
		mssql_select_db('ReportDataDB', $conn);
		switch($arrParam['type']){
			case "tatca":
				$result = mssql_query('exec sp_get_data_user_ingot_detail', $conn);
				break;
			case "userid":
				$result = mssql_query('exec sp_get_data_user_ingot_detail '.$arrParam['userid'], $conn);
				break;
		}
		$row = mssql_num_rows($result);
		$data = array();
		while($row = mssql_fetch_assoc($result)){
			$data[] = $row;
		}
        return $data;
	}
	public function getRptAccountInfo($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        switch($arrParam['type']){
            case "all":
                $sql = "CALL sp_get_rpt_account_info()";
                break;
            case "msi":
                $sql = "CALL sp_get_rpt_account_info_by_msi('".$arrParam['msi']."')";
                break;
        }
		
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
    public function getRptServerInfoDaily($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        switch($arrParam['type']){
            case "ngay":
                $sql = "CALL sp_get_rpt_server_info_daily_bydate('".$arrParam['date']."')";
                break;
            case "khoangngay":
                $sql = "CALL sp_get_rpt_server_info_daily('".$arrParam['date_from']."','".$arrParam['date_to']."')";
                break;
        }
		
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
	public function getTopupHourly($arrParam,$database){
        $this->_db_slave = $this->load->database(array('db' =>$database, 'type' => 'slave'), TRUE);
        $this->freeDBResource($this->_db_slave->conn_id);
        $sql = "CALL `inside_koa`.`sp_report_topup_hourly`('".$arrParam['server']."','".$arrParam['platform']."','".$arrParam['date_from']."','".$arrParam['date_to']."')";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
}