<?php
class SearchInfoModel extends CI_Model {
    private $_db_slave;
    public function __construct() {
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
	public function listServerByIDGame($game){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->select(array('id','service_id','service'))
                        ->from('scopes as s')
                        ->where('s.service_id',$game)
                        ->order_by('s.id','DESC')
                        ->get();       
        if (is_object($data)) {
            $row_data =  $data->row_array();
            if(!empty($row_data['service'])){
                $data_sub = $this->_db_slave->select(array('id','server_id','server_name'))
                        ->from('server_list as s')
                        ->where('s.game',$row_data['service'])
                        ->order_by('s.id','DESC')
                        ->get();
                if (is_object($data_sub)) {
                    $row_data =  $data_sub->result_array();
                    return $row_data;
                }
            }
        }
        return FALSE;
    }
	public function slbScopes(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->select(array('*'))
                        ->from('scopes')
                        ->where('(app_type=0 OR app_type=1)')
                        ->get();
        if (is_object($data)) {
            $result = array();
            foreach($data->result_array() as $v){
                $result[$v['app_name']] = $v;
            }
            return $result;
        }
        
        return 0;
    }
    public function listGamePermission(){
        if($_SESSION['account']['id_group']==2){
            $arrServerAll = array();
            if(is_array($this->slbScopes())){
                foreach($this->slbScopes() as $v){
                    $arrServerAll[$v['app_name']] = $v['app_name'];
                }
                
            }
            $arrServer = array_intersect($arrServerAll,$_SESSION['permission']);
        }
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('id','app_name','app_fullname','service_id'));
        $this->_db_slave->from('scopes');
        $this->_db_slave->where('(app_type=0 OR app_type=1)');
        $this->_db_slave->order_by('id','DESC');
                        
        if($_SESSION['account']['id_group']==2){
            $this->_db_slave->where_in("app_name",$arrServer, false);
        }
        $data = $this->_db_slave->get();
        
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
	public function listGamePermissionByController($arrParam){
        if($_SESSION['account']['id_group']==2){
            $scopes = array();
            if(is_array($this->slbScopes())){
                foreach($this->slbScopes() as $v){
                    if($_SESSION['permission'][$arrParam['control'].'-'.$v['app_name']]==$arrParam['control'].'-'.$v['app_name']){
                        $scopes[$v['app_name']] = $v['app_name'];
                    }
                }
            }
        }
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->select(array('id','app_name','app_fullname','service_id'));
        $this->_db_slave->from('scopes');
        $this->_db_slave->where('(app_type=0 OR app_type=1)');
        $this->_db_slave->order_by('id','DESC');
                        
        if($_SESSION['account']['id_group']==2){
            $this->_db_slave->where_in("app_name",$scopes, false);
        }
        
        $data = $this->_db_slave->get();
        
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    public function listGame(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->select(array('id','app_name','app_fullname','service_id'))
                        ->from('scopes')
                        ->where('(app_type=0 OR app_type=1)')
                        ->order_by('id','DESC')
                        ->get();
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    public function listServerByGame($game,$all=false){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->_db_slave->select(array('id','server_id','server_name'))
                        ->from('server_list')
                        ->where('game',$game);
		if($all == false)
            $this->_db_slave->where('status',1);
		
        $data = $this->_db_slave->order_by('id','DESC')
                ->get();
        
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    public function getGameById($service_id){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->select(array('id','app_name','app_fullname','service_id'))
                        ->from('scopes')
                        ->where('(app_type=0 OR app_type=1)')
                        ->where('service',$service_id)
                        ->order_by('id','DESC')
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
    public function getItemByServer($server_id,$game_id){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->select(array('id','server_id','server_name','server_game_address'))
                        ->from('server_list')
                        ->where('server_id',$server_id)
                        ->where('game',$game_id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
}
