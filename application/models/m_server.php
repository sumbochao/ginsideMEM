<?php
if(file_exists(APPPATH ."../application/core/Backend_Model.php")){
    include APPPATH ."../application/core/Backend_Model.php";
}
class m_server extends Backend_Model {
    function __construct(){
        parent::__construct();
        $this->db = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), true);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function listServerByServiceID($service_id){
        $data = $this->db->select(array('s.app_name','se.server_id','se.server_name'))
                        ->from('scopes as s')
                        ->join('server_list as se','s.app_name=se.game','left')
                        ->where('s.service_id',$service_id)
                        ->where('se.status',1)
                        ->get();
        if (is_object($data)) {
            return $data->result_array();
        }
        return 0;
    }
}