<?php
class ReportModel extends CI_Model {

    private $_db;
    private $_db_slave;

    public function __construct() {
        
    }
    //public function listTable($arrParam,$limit=NULL,$start=NULL,$flag =false){
    //    if (!$this->_db_slave)
    //        $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        
    //    $this->_db_slave->select(array('*'));
        
    //    if(!empty($arrParam['keyword'])){
    //        $this->_db_slave->where("(`mobo_id` = '{$arrParam['keyword']}' or `mobo_service_id` = '{$arrParam['keyword']}' OR `transaction_id` = '{$arrParam['keyword']}' OR `character_id` = '{$arrParam['keyword']}' OR `character_name` = '{$arrParam['keyword']}' OR `payment_desc` = '{$arrParam['keyword']}')", '', false);
    //    }
    //    if(!empty($arrParam['date_from']) && !empty($arrParam['date_to'])){
    //        $date_from = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_from'])+7*3600);
    //        $date_to = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_to'])+7*3600);
    //        $this->_db_slave->where('date >=',$date_from);
    //        $this->_db_slave->where('date <=',$date_to);
    //    }
    //    if($arrParam['slbStatus']>0){
    //        $this->_db_slave->where('status =',$arrParam['slbStatus']-1);
    //    }
    //    if(!empty($arrParam['slbPlatform'])){
    //        $this->_db_slave->where('platform =',$arrParam['slbPlatform']);
    //    }
    //    if(!empty($arrParam['slbType'])){
    //        $this->_db_slave->where('type =',$arrParam['slbType']);
    //    }
    //    if($arrParam['game_server_id']>0){
    //        $this->_db_slave->where('server_id =',$arrParam['game_server_id']);
    //    }
    //    $this->_db_slave->order_by($arrParam['col'] , $arrParam['order']);
        
    //    if($flag){
    //        $this->_db_slave->limit($start,$limit);
    //    }
    //    $data = $this->_db_slave->get('cash_to_game_trans_'.$arrParam['slbGame']);
    //    //var_dump($this->_db_slave->last_query());die;
    //    if (is_object($data)) {
    //        return $data->result_array();
    //    }
    //    return FALSE;
    //}
    
    
    //SELECT *
    //FROM cash_to_game_trans_monggiangho t1 
    //LEFT JOIN 
    //    (SELECT max(id) mid FROM cash_to_game_trans_monggiangho WHERE ??? GROUP BY transaction_id) t2
    //ON t1.id = t2.mid
    //ORDER BY t1.id DESC LIMIT 0,20
	
	public function listTableApi($arrParam){
		//$strURL = 'http://gapi.dxglobal.net/?control=report&func=get_list_table&keyword=sdsd&date_to=2016-09-12&date_from=2016-02-12&service_name=140&slbStatus=3&slbPlatform=test&slbType=test&game_server_id=2&app=inside_mobo&token=62792786e77028685564ba2eb892a17b';
        $arrData = array(
            "keyword"=>$arrParam['keyword'],
            "date_to"=>date_format(date_create($arrParam['date_to']),"Y-m-d G:i:s"),
            "date_from"=>date_format(date_create($arrParam['date_from']),"Y-m-d G:i:s"),
            "service_name"=>$arrParam['slbGame'],
            "slbStatus"=>$arrParam['slbStatus'],
            "slbPlatform"=>$arrParam['slbPlatform'],
            "slbType"=>$arrParam['slbType'],
            "game_server_id"=>$arrParam['game_server_id']
        );
        $token = md5(implode('', $arrData) . 'jwT0wnGlQKROSLrj6aLc');
        $strURL = 'https://gapi.dllglobal.net/?control=report&func=get_list_table&'.  http_build_query($arrData).'&app=inside_mobo&token='.$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $strURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        $listItems = json_decode($result);
		if($listItems->code==500102){
			return $listItems->data;
		}
        return array();
    }
    public function listTable($arrParam){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        
        $table = "cash_to_game_trans_" . $arrParam['slbGame'];
        
        $sub_query_sql = "SELECT max(id) mid, count(transaction_id) recall FROM " . $table . " WHERE 1";
        
        if(!empty($arrParam['keyword']))
            $sub_query_sql .= " AND (mobo_id = '{$arrParam['keyword']}' OR mobo_service_id = '{$arrParam['keyword']}' OR transaction_id = '{$arrParam['keyword']}' OR character_id = '{$arrParam['keyword']}' OR character_name = '{$arrParam['keyword']}' OR payment_desc = '{$arrParam['keyword']}')";
        
        if(!empty($arrParam['date_from']) && !empty($arrParam['date_to'])){
            $date_from = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_from'])+7*3600);
            $date_to = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_to'])+7*3600);
            $sub_query_sql .= " AND date >='" . $date_from . "' AND date <='" . $date_to . "' ";
        }
        if($arrParam['slbStatus']>0){
            if ($arrParam['slbStatus'] == 3){ // status that bai th� l?y lu�n tr??ng h?p th�nh c�ng ?? t?ng h?p check gd l?n cu?i c�ng th?c hi?n l� success hay th?t b?i
                $sub_query_sql .= " AND status in (1,2) ";
            }else{
                $sub_query_sql .= " AND status =" . ($arrParam['slbStatus'] - 1);
            }
        }
        if(!empty($arrParam['slbPlatform'])){
            $sub_query_sql .= " AND platform ='" . $arrParam['slbPlatform'] . "' ";
        }
        if(!empty($arrParam['slbType'])){
            $sub_query_sql .= " AND type ='" . $arrParam['slbType'] . "' ";
        }
        if(!empty($arrParam['game_server_id'])){
            $sub_query_sql .= " AND server_id ='" . $arrParam['game_server_id']."'";
        }
        $sub_query_sql .= " GROUP BY transaction_id";
        
        $query_sql = "SELECT * FROM " . $table . " as t1 RIGHT JOIN (" . $sub_query_sql . ") as t2 ON t1.id = t2.mid ";
        
        if($arrParam['slbStatus'] > 0){
            if ($arrParam['slbStatus'] == 3){ // 
                $query_sql .= " WHERE status =" . ($arrParam['slbStatus'] - 1);
            }
        }
        
        $query_sql .= " ORDER BY t1.id DESC "; 
        
        $data = $this->_db_slave->query($query_sql);
		//echo $this->_db_slave->last_query();die();
        //var_dump($data);die;
        //var_dump($this->_db_slave->last_query());die;
        if (is_object($data)) {
            return $data->result_array();
        }
        
        return FALSE;
    }
	
	public function listExportDataByUser($arrParam,$start=NULL,$per_page=NULL,$flag =false){
		if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $query_str="SELECT `date`, count(0) as `amount` from (
            SELECT character_id, server_id, DATE_FORMAT(cash_to_game_trans_".$arrParam['slbGame'].".date,'%Y-%m-%d') as `date`, sum(cash_to_game_trans_".$arrParam['slbGame'].".amount) as `amount`
            from cash_to_game_trans_".$arrParam['slbGame']."
            where `status` = 1
            group by character_id, server_id, DATE_FORMAT(cash_to_game_trans_".$arrParam['slbGame'].".date,'%Y-%m-%d')
            ) a
            where 1=1 ";
        if(is_numeric($arrParam['price_from'])>=0 && isset($arrParam['price_from']) && !empty($arrParam['price_from'])){
            $query_str.=' and a.amount '.$arrParam['operator_from'].' '.$arrParam['price_from'].' ';
        }
        if(is_numeric($arrParam['price_to'])>=0 && isset($arrParam['price_to']) && !empty($arrParam['price_to'])){
            $query_str.=' and a.amount '.$arrParam['operator_to'].' '.$arrParam['price_to'].' ';
        }
        if(!empty($arrParam['date_from']) && !empty($arrParam['date_to'])){
            $date_from = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_from']));
            $date_to = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_to'])+7*3600);
            $query_str .="and a.date >='$date_from' and a.date <='$date_to' ";
        }
        $query_str.=" group by `date` order by date ASC ";
        if($flag){
            $query_str.=" LIMIT ".$start.",".$per_page;
        }//echo "<pre>";print_r($arrParam);echo $query_str;die();
        $data=$this->_db_slave->query($query_str);
                
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
	public function listViewHistoryByTransaction($arrParam){
		$arrGame = explode('-',$arrParam['table']);
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->_db_slave->select(array('*'));
        $this->_db_slave->where('transaction_id',$arrParam['transaction_id']);
        $this->_db_slave->order_by('date','DESC');
        $data = $this->_db_slave->get('cash_to_game_trans_'.$arrGame['0']);
		//echo $this->_db_slave->last_query();die();
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
	public function listTableGiftCode($arrParam){
        $aDate = explode('-', $arrParam['dategif']);
        $strDate = trim($aDate[2]).'-'.trim($aDate[1]).'-'.trim($aDate[0]);
        
        if(!empty($arrParam['slbDbGiftcode'])){
            if (!$this->_db_slave)
                $this->_db_slave = $this->load->database(array('db' => $arrParam['slbDbGiftcode'], 'type' => 'slave'), TRUE);

            $data = $this->_db_slave->select(array('character_id','character_name','server_id','type','DATE_FORMAT(create_date,"%Y-%m-%d") as date','count(0) as `soluong`'))
                            ->from('facebook_giftcode')
                            ->where("DATE_FORMAT(create_date,'%Y-%m-%d')",$strDate)
                            ->group_by(array("character_id", "character_name","server_id","type","DATE_FORMAT(create_date,'%Y-%m-%d')"))
                            ->get();
            //var_dump($this->_db_slave->last_query());die;
            if (is_object($data)) {
                return $data->result_array();
            }
        }
        return FALSE;
    }
	public function listScopes(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->_db_slave->select(array('app_name','app_fullname','type','status'));
        $this->_db_slave->where('app_type',0);
		$this->_db_slave->or_where('app_type',1);
        $this->_db_slave->order_by('id','DESC');
        $data = $this->_db_slave->get('scopes');
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    
    public function listScopes_Id(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->_db_slave->select(array('app_name','app_fullname','service_id','type','status'));
        $this->_db_slave->where('app_type',0);
        $this->_db_slave->or_where('app_type',1);
        $this->_db_slave->order_by('id','DESC');
        $data = $this->_db_slave->get('scopes');
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    
	public function listItemsPaycard($arrParam){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->_db_slave->select(array('*'))
                        ->from('paycard_logs as p')
                        ->where('status',1)
                        ->order_by('id','DESC');
        if(!empty($arrParam['keyword']))
            $this->_db_slave->where("(mobo_service_id = '{$arrParam['keyword']}' OR character_id = '{$arrParam['keyword']}' OR character_name = '{$arrParam['keyword']}' OR event = '{$arrParam['keyword']}' OR money = '{$arrParam['keyword']}')");
        if(!empty($arrParam['date_from']) && !empty($arrParam['date_to'])){
            $date_from = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_from'])+7*3600);
            $date_to = gmdate('Y-m-d G:i:s',strtotime($arrParam['date_to'])+7*3600);
            $this->_db_slave->where('date >=',$date_from)->where('date <=',$date_to);
        }
		if(!empty($arrParam['slbGame'])){
            $this->_db_slave->where('app',$arrParam['slbGame']);
        }
        if($arrParam['game_server_id']>0){
            $this->_db_slave->where('server_id',$arrParam['game_server_id']);
        }
        $data=$this->_db_slave->get();
        if (is_object($data) && !empty($arrParam['slbGame'])) {
            return $data->result_array();
        }
        
        return FALSE;
    }
}