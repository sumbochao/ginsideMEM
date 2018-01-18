<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/25/2015
 * Time: 9:44 PM
 */

class MongoModel extends CI_Model {

    private $db_mongo;

    public function __construct(){
        parent::__construct();
        $this->load->library('cimongo/cimongo','cimongo');
    }

    public function get($collection, $where,$limit=0){
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        $result = $this->db_mongo->get_where($collection,$where,$limit);
        return is_object($result)?$result->result_array():FALSE;
    }
    
    public function insert($collection, $params){
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        return $this->db_mongo->insert($collection,$params);        
    }
    
    public function insert_batch($collection, $params) {
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        return $this->db_mongo->insert_batch($collection,$params); 
    }
    public function update($collection,$params, $where){
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        $this->db_mongo->where($where);
        return $this->db_mongo->update($collection,$params);
    }
    public function getid_increment($collection,$limit,$desc ="id"){
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        $this->db_mongo->order_by(array("{$desc}"=>-1));
        $result = $this->db_mongo->get($collection,$limit);
        return is_object($result)?$result->row_array():FALSE;
    }
	public function getid_incrementtest($collection,$limit,$desc ="id"){
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        $this->db_mongo->order_by(array("{$desc}"=>"desc"));
        $result = $this->db_mongo->get($collection,$limit);
        return is_object($result)?$result->result_array():FALSE;
    }
	
    public function order_by($array){
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        $this->db_mongo->order_by($array);
    }
    public function where_in($field,$array){
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        $this->db_mongo->where_in($field,$array);
    }
	public function where($array){
        if(!$this->db_mongo){
            $this->db_mongo = new Cimongo();
        }
        $this->db_mongo->where($array);
    }

} 