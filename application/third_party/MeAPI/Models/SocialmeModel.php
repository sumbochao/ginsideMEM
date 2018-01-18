<?php

/**
 * @property CI_DB_active_record $db
 */
class SocialmeModel extends CI_Model {

    private $_db;
    private $_db_slave;
	private $tbl_navigator ="share_facebook_game";
	private $tbl_language ="tbl_language";
    public function __construct() {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
    }
   
    public function getError() {
        return $this->_db->_error_message();
    }

    /**
     * @param $id_event
     * @return mixed
     */

    public function update($table, $data, $where){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
       
        $sql = $this->_db_slave->update($table, $data, $where);
        return $this->_db_slave->affected_rows();
    }
    public function insert_id($table, $data){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $query = $this->_db_slave->insert($table, $data);
        $idinsert =  $this->_db_slave->insert_id();
        if ($this->_db_slave->affected_rows() > 0) {
            return $idinsert;
        } else {
            return false;
        }
    }
	
	function getalllanguage(){
        $data = $this->_db_slave->get($this->tbl_language);
        if (is_object($data)){
            $returnData = $data->result_array();
            return $returnData;
        }
    }
    function getlanguage($id){
        $data = $this->_db_slave->where('id',$id)->get($this->tbl_language);
        if (is_object($data)){
            $returnData = $data->row_array();
            return $returnData;
        }
    }
	
	function getnavigatorall(){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->get($this->tbl_navigator);
        if (is_object($data)){
            $returnData = $data->result_array();
            return $returnData;
        }
    }
	
    function getnavigator($id){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->where('id',$id)->get($this->tbl_navigator);
        if (is_object($data)){
            $returnData = $data->row_array();
            return $returnData;
        }
    }
    public function getmapp($idmapp){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->where('tbl_m_app.id', $idmapp);
        $this->_db_slave->limit(1);
        $data = $this->_db_slave->get('tbl_m_app');

        if (is_object($data)){
            return $data->row_array();
        }
    }
    public function getallappbyid($idmapp,$id_event){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data =$this->_db_slave->query("SELECT * FROM tbl_m_app WHERE id_app = ".$idmapp." AND id_event <> ".$id_event);
        if (is_object($data)){
            return $data->result_array();
        }else{
            return false;
        }
    }
    public function getallapp($idmap){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data =$this->_db_slave->where("id_app",$idmap)->get('tbl_m_app');
        if (is_object($data)){
            return $data->result_array();
        }else{
            return false;
        }
    }
    public function listapibygame($alias_app){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data =$this->_db_slave->where("alias_app",$alias_app)->get('tbl_m_app');
        if (is_object($data)){
            return $data->result_array();
        }else{
            return false;
        }
    }
	public function getlistgame(){
		$data =$this->_db_slave->get('share_facebook_game');
        if (is_object($data)){
            return $data->result_array();
        }else{
            return false;
        }
	}

}