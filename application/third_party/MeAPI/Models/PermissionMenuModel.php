<?php
include_once 'Recursive.php';
class PermissionMenuModel extends CI_Model {
    public function __construct() {
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function getIdMenu($url){
        $sql = $this->_db_slave->select(array('m.id','m.name','m.parents'))
                        ->from('menu as m')
                        ->where('m.url',$url)
                        ->get();
        if (is_object($sql)) {
            return $sql->row_array();
        }
        return 0;
    }
    public function categoryAll(){
        $sql = $this->_db_slave->select(array('m.id','m.name','m.parents'))
                        ->from('menu as m')
                        ->get();
        if (is_object($sql)) {
            return $sql->result_array();
        }
        return 0;
    }
    public function moduleByUser($id_user){
        $sql = $this->_db_slave->select(array('m.controller','m.action','m.report_game','m.module','m.layout','m.game','u.id_user','u.id_permisssion'))
                        ->from('module_user as u')
                        ->join('module as m', 'm.id = u.id_permisssion')
                        ->where('u.id_user',$id_user)
                        ->get();
        if (is_object($sql)) {
            $data = $sql->result_array();
           //echo "<pre>";print_r($data);
            $cid = array();
            $i=0;
            foreach($data as $v){
				$i++;
                if((!empty($v['controller'])&& !empty($v['action']) && empty($v['report_game'])) || (!empty($v['controller'])&& !empty($v['action']) && empty($v['layout']))){
                    $url = '?control='.$v['controller'].'&func='.$v['action'];
                } 
				if(!empty($v['controller'])&& !empty($v['action']) && !empty($v['report_game'])){
                    $url = '?control='.$v['controller'].'&func='.$v['action'].'&game='.$v['report_game'];
                }
				//layout
                if(!empty($v['controller'])&& !empty($v['action']) && !empty($v['layout'])){
                    $url = '?control='.$v['controller'].'&func='.$v['action'].'&view='.$v['layout'];
                }
				//start module 11/12/2015
				
				if(!empty($v['controller'])&& !empty($v['action']) && !empty($v['layout']) && !empty($v['report_game']) && !empty($v['module'])){
                    $url = '?control='.$v['controller'].'&func='.$v['action'].'&view='.$v['layout'].'&module='.$v['module'].'&game='.$v['report_game'];			
                }
				if(!empty($v['controller'])&& !empty($v['action']) && empty($v['layout']) && !empty($v['report_game']) && !empty($v['module'])){
                    $url = '?control='.$v['controller'].'&func='.$v['action'].'&module='.$v['module'].'&game='.$v['report_game'];			
                }
                if(!empty($v['controller'])&& !empty($v['action']) && empty($v['layout']) && empty($v['report_game']) && !empty($v['module'])){
                    $url = '?control='.$v['controller'].'&func='.$v['action'].'&module='.$v['module'];			
                }
				if(!empty($v['controller'])&& !empty($v['action']) && !empty($v['layout']) && empty($v['report_game']) && !empty($v['module'])){
                    $url = '?control='.$v['controller'].'&func='.$v['action'].'&view='.$v['layout'].'&module='.$v['module'];			
                }
				//end update
                $resultCategory = $this->getIdMenu($url);
                // echo "<pre>";print_r($resultCategory);
                if(count($resultCategory)>0){
                    $items = $this->categoryAll();
                    $recursive = new Recursive($items);
                    $cid[$i] = $recursive->getParentsIdArray($resultCategory['id']);
                    $cid[$i][] = $resultCategory['id'];
                }
            }
			//echo "<pre>";print_r($resultCategory);
			//die();
            $resultC = array();
            if(count($cid)>0){
                foreach($cid as $kc=>$vc){
                    foreach($vc as $ks=>$kv){
                        $resultC[$kv] = $kv;
                    }
                }
            }
            return $resultC;
        }
        return 0;
    }
}