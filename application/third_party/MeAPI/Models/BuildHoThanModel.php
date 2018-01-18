<?php

class BuildHoThanModel extends CI_Model {

    protected $_db;

    public function __construct() {
        if (!$this->_db)
            $this->_db = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
    }
	//lay selectbox uoc nguyen
	function slbBuildHoThanModel($key){
        $data = $this->_db->select(array('id','name'))
                        ->from('build_hothan_hon')
                        ->where('key', $key)
                        ->get();
		if (is_object($data)) {
            $data = $data->result_array();
            $result = array();
            if(count($data)>0){
                foreach ($data as $v){
                    $result[$v['id']] = $v;
                }
            }
            return $result;
        }
        return FALSE;
    }
    function insert($table, $params){
        if(empty($params)){
            return 0;
        }
        $this->_db->insert($table,$params);
//        echo $this->_db->last_query();
        return $this->_db->insert_id();
    }


    function insert_batch($table, $data){
        $this->_db->insert_batch($table, $data);
        return $this->_db->affected_rows();
    }


    function update_batch($table, $data, $column){
        return $this->_db->update_batch($table, $data, $column);
    }


    function update($table, $data, $where) {
        $rs = $this->_db->update($table, $data, $where);
//        echo $this->_db->last_query();
        return $rs;
    }


    function getList($select ,$from, $join = array() , $where = array(), $order_by = '' )
    {
        $this->_db->select($select)->from($from);
        if(count($join) > 0){
            foreach($join as $el){
                $this->_db->join($el['table'], $el['where'], $el['direction']);
            }
        }

        if(is_array($where) && count($where) > 0)
            $this->_db->where($where);
        elseif(is_string($where) && $where != ''){
            $this->_db->where($where);
        }

        if($order_by != '')
            $this->_db->order_by($order_by);

        $query = $this->_db->get();
//         echo $this->_db->last_query();
        return $query->result_array();
    }


    function delete($table,$where){
        $rs = $this->_db->delete($table, $where);
//        echo $this->_db->last_query();
        return $rs;
    }
}
