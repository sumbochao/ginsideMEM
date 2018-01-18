<?php
if(file_exists(APPPATH ."../application/core/Backend_Model.php")){
    include APPPATH ."../application/core/Backend_Model.php";
}
class m_module extends Backend_Model {
    function __construct(){
        parent::__construct();
        $this->db = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), true);
    }
    function listItems(){
        $where = "WHERE  true";
        $this->datatables_config=array(
                "table"=>"module",
                "select"=>"
                    SELECT * FROM module as m",
                "where"     =>$where,
                "order_by"=>"Order By m.`id` DESC  ",
                "columnmaps"=>array(
                )
        );
        $arrRows = $this->_bindingdata();
        $arrData = json_decode(json_encode($arrRows['rows']),TRUE);
        $result = process($arrData,0);
        $j_result = json_decode(json_encode($result));
        $arrRows['rows'] = $j_result;
        return $arrRows;
    }
}