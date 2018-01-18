<?php

class FacebookAdsModel extends CI_Model {

    protected $db;
    public function __construct() {
        if (!$this->db)
            $this->db = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
    }

    function insert($table, $params){
        $rs = $this->db->insert($table,$params);
//        echo $this->db->last_query();
        return $rs;

    }


    function insert_batch($table, $params){
        $rs = $this->db->insert_batch($table,$params);
//        echo $this->db->last_query();
        return $rs;

    }


    function insert_id($table, $params){
        $this->db->insert($table,$params);
//        echo $this->db->last_query();
        return $this->db->insert_id();
    }


    function update($table, $data, $where) {
        $rs = $this->db->update($table, $data, $where);
        //echo $this->db->last_query();
        return $rs;
    }

    function update_batch($table, $data, $where) {
        $rs = $this->db->update_batch($table, $data, $where);
        //echo $this->db->last_query();
        return $rs;
    }


    function getList($select ,$from, $where = array(),$join = array() ,  $order_by = '' )
    {
        $this->db->select($select)->from($from);
        if(count($join) > 0){
            foreach($join as $el){
                $this->db->join($el['table'], $el['where'], $el['direction']);
            }
        }

        if(count($where) > 0)
            $this->db->where($where);

        if($order_by != '')
            $this->db->order_by($order_by);

        $query = $this->db->get();
//        echo $this->db->last_query();
        return $query->result_array();
    }



    function query($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
