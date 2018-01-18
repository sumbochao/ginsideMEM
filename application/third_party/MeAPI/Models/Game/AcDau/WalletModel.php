<?php
/**
 * Wallet model
 *
 * @author thanhnt
 */
class WalletModel extends CI_Model{
	private $db;
	
	public function __construct() {
        if (!$this->db)
            $this->db = $this->load->database(array('db' => 'service_acdau_mobo_vn', 'type' => 'master'), TRUE);
    }
	
	public function getEventsByGame($game){
		if($game == 108){
			$service_name = 'bog';
		}else{
			$service_name = $game;
		}
		$query = $this->db->select("DISTINCT(event)")
                ->from("event_wallet_pay_logs")
                ->where("service_name", $service_name)
                ->get();
		// echo $this->db->last_query();die;
        return $query->result_array();
	}
	
	public function getServers($game){
		if($game == 108){
			$service_name = 'bog';
		}else{
			$service_name = $game;
		}
		$query = $this->db->select("DISTINCT(server_id)")
                ->from("event_wallet_pay_logs")
                ->where("service_name", $service_name)
                ->get();
		// echo $this->db->last_query();die;
        return $query->result_array();
	}
	
	
	public function filter_payment($post){
		$game = $post['game'];
		if($game != -1){
			if($game == 108){
				$service_name = 'bog';
			}else{
				$service_name = $game;
			}
			
			$query = "SELECT event,server_id,sum(value) as money,create_date
						FROM event_wallet_pay_logs
						WHERE service_name = '$service_name'
						";
			if($post['event'] != ''){
				$event = $post['event'];
				$query .= " AND event = '$event'";
			}
			if($post['server'] != ''){
				$server = $post['server'];
				$query .= " AND server_id = '$server'";
			}
			if($post['start'] != ''){
				$start = date('Y-m-d',strtotime($post['start'])) ;
				$query .= " AND create_date >= '$start'";
			}
			if($post['end'] != ''){
				$end = date('Y-m-d',strtotime($post['end'])) ;
				$query .= " AND create_date <= '$end'";
			}
			$query .= " GROUP BY(DATE_FORMAT(create_date, '%Y-%m-%d'))" ;
			$rs =  $this->db->query($query);
			// echo $this->db->last_query();die;
			// echo '<pre>';print_r($rs->result_array());die;
			return $rs->result_array();
		}
		return array();
	}
}
?>