<?php
class PaymentPromoModel extends CI_Model {
    private $_db_slave;
    private $_table='payment_promo_item_';
    
    public function __construct() {
        parent::__construct();
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function listTable($arrParam){
        $table = $this->_table;
        
        $sub_query_sql = "SELECT max(id) mid, count(transaction_id) recall FROM " . $table.$arrParam['slbGame'] . " WHERE 1";
        
        if(!empty($arrParam['keyword']))
            $sub_query_sql .= " AND (mobo_id = '{$arrParam['keyword']}' OR mobo_service_id = '{$arrParam['keyword']}' OR transaction_id = '{$arrParam['keyword']}' OR character_id = '{$arrParam['keyword']}' OR character_name = '{$arrParam['keyword']}')";
        
        if(!empty($arrParam['date_from']) && !empty($arrParam['date_to'])){
            $date_from = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_from'])+7*3600);
            $date_to = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_to'])+7*3600);
            $sub_query_sql .= " AND date >='" . $date_from . "' AND date <='" . $date_to . "' ";
        }
        if($arrParam['slbStatus']>0){
            $sub_query_sql .= " AND status =" . ($arrParam['slbStatus'] - 1);
        }
        if($arrParam['server_id']>0){
            $sub_query_sql .= " AND server_id =" . $arrParam['server_id'];
        }
        $sub_query_sql .= " GROUP BY transaction_id";
        
        $query_sql = "SELECT * FROM " . $table .$arrParam['slbGame']. " as t1 RIGHT JOIN (" . $sub_query_sql . ") as t2 ON t1.id = t2.mid ";
        
        $query_sql .= " ORDER BY t1.id DESC ";
        if(!empty($arrParam['date_from']) && !empty($arrParam['date_to'])){
            $data = $this->_db_slave->query($query_sql);
            if (is_object($data)) {
                return $data->result_array();
            }
        }
        return FALSE;
    }
    public function listScopes(){
        $this->_db_slave->select(array('service','app_fullname','app_name','service_id','id','app_secret','type'));
        $this->_db_slave->order_by('id DESC');
		$this->_db_slave->where('(app_type=0 OR app_type=1)');
        $data = $this->_db_slave->get('scopes');
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    public function listServerByGame($game){
        $data = $this->_db_slave->select(array('*'))
                        ->from('server_list as s')
                        ->where('status',1)
                        ->where('game',$game)
                        ->order_by('id','DESC')
                        ->get();
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
}