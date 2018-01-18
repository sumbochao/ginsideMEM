<?php
class PromotionModel extends CI_Model {
    private $_db_slave;
    private $_table='defined_promotion';
    
    public function __construct() {
        parent::__construct();
       if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
       date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function deleteItem($arrParam,$options=NULL){
        $items = $this->listItem();
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $arrDelete = array();
                foreach($arrParam['cid'] as $v){
                    $this->_db_slave->delete($this->_table,array('id' => $v)); 
                }
            }
        }else{
            $this->_db_slave->delete($this->_table,array('id' => $arrParam['id'])); 
        }
    }
    public function listItem($arrParam){
		if($_SESSION['account']['id_group']==2 || $_SESSION['account']['id_group']==3){
            $arrGameAll = array();
            if(is_array($this->slbScopes())){
                foreach($this->slbScopes() as $v){
                    $arrGameAll[$v['app_name']] = $v['app_name'];
                }
                
            }
            $arrGame = array_intersect($arrGameAll,$_SESSION['permission']);
        }
        $this->_db_slave->select(array('p.*','g.app_fullname'));
        $this->_db_slave->from($this->_table.' as p LEFT JOIN scopes as g ON p.game=g.app_name');
        $this->_db_slave->order_by('id','DESC');
        if(!empty($arrParam['game'])){
            $this->_db_slave->where("(`game` LIKE '%{$arrParam['game']}%')", '', false); 
        }
		if($_SESSION['account']['id_group']==2 || $_SESSION['account']['id_group']==3){ 
            $this->_db_slave->where_in("game",$arrGame, false);
        }
        $data=$this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }
    public function getItem($id){
        $data = $this->_db_slave->select(array('*'))
                        ->from($this->_table)
                        ->where('id', $id)
                        ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
    public function saveItem($arrParam,$option= NULL){
        $promotion = '';
        if(count($arrParam['key'])>0){
            $j=0;
            foreach($arrParam['key'] as $key=> $value){
                $j++;
                if(count($arrParam['keysub'][$j])>0){
                    $i=0;
                    foreach($arrParam['keysub'][$j] as $k=>$v){
                        $arrPromotion[$value][$v] = $arrParam['namesub'][$j][$i];
                        $i++;
                    }
                }
            }
            $promotion = json_encode($arrPromotion);
        }
        $start = date_format(date_create($arrParam['start']),"Y-m-d G:i:s");
        $end = date_format(date_create($arrParam['end']),"Y-m-d G:i:s");
        
        $arrServer = json_decode($arrParam['content_server'],true);
        $strServer = '';
        if(count($arrServer)>0){
            foreach($arrServer as $v){
                $resultServer[] = $v['server_id'];
            }
            $strServer = implode(',', $resultServer);
        }
	
        if($option['task']=='edit'){
            $items = $this->getItem($arrParam['id']);
            $arrData['game']                = $arrParam['game'];
            $arrData['server_ids']          = $strServer;
            $arrData['promotion']           = $promotion;
            $arrData['is_first']            = !empty($arrParam['is_first'])?$arrParam['is_first']:0;
            $arrData['is_reset']            = !empty($arrParam['is_reset'])?$arrParam['is_reset']:0;
            $arrData['amount']              = $arrParam['content_amount']!='[]'?$arrParam['content_amount']:'';;
            $arrData['none_recharge']       = !empty($arrParam['none_recharge'])?$arrParam['none_recharge']:0;
            $arrData['start']               = $start;
            $arrData['end']                 = $end;
            $arrData['type']                = $arrParam['content_type']!='[]'?$arrParam['content_type']:'';
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
            $arrData['tester']              = ($arrParam['tester']!='[]')?str_replace('.','',$arrParam['tester']):'';
            if($_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==2){
                $arrData['publisher']           = !empty($arrParam['publisher'])?$arrParam['publisher']:0;
            }
            $arrData['priority']            = $arrParam['priority'];
            
            if($_SESSION['account']['id_group']==1){
                $arrData['approved']            = !empty($arrParam['approved'])?$arrParam['approved']:0;
            }
            if($_SESSION['account']['id_group']!=3 || ($items['publisher']==1 && $_SESSION['account']['id_group']==3)){
                $arrData['doned']            = !empty($arrParam['doned'])?$arrParam['doned']:0;
            }
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$arrData);
            $id = $arrParam['id'];
        }
        if($option['task']=='add'){
            $arrData['game']                = $arrParam['game'];
            $arrData['server_ids']          = $strServer;
            $arrData['promotion']           = $promotion;
            $arrData['is_first']            = !empty($arrParam['is_first'])?$arrParam['is_first']:0;
            $arrData['is_reset']            = !empty($arrParam['is_reset'])?$arrParam['is_reset']:0;
            $arrData['amount']              = $arrParam['content_amount']!='[]'?$arrParam['content_amount']:'';
            $arrData['none_recharge']       = !empty($arrParam['none_recharge'])?$arrParam['none_recharge']:0;
            $arrData['start']               = $start;
            $arrData['end']                 = $end;
            $arrData['type']                = $arrParam['content_type']!='[]'?$arrParam['content_type']:'';
            $arrData['status']              = !empty($arrParam['status'])?$arrParam['status']:0;
            $arrData['tester']              = ($arrParam['tester']!='[]')?str_replace('.','',$arrParam['tester']):'';
            $arrData['publisher']           = !empty($arrParam['publisher'])?$arrParam['publisher']:0;
            $arrData['priority']            = $arrParam['priority'];
            $arrData['approved']            = !empty($arrParam['approved'])?$arrParam['approved']:0;
            $arrData['doned']            = !empty($arrParam['doned'])?$arrParam['doned']:0;
            $this->_db_slave->insert($this->_table,$arrData);
            $id = $this->_db_slave->insert_id();
        }
        return $id;
    }
    public function statusItem($arrParam,$options=NULL){
        if($options['task']=='multi'){
            if(count($arrParam['cid'])>0){
                $data= array('status'=>$arrParam['s']);
                $this->_db_slave->where_in('id', $arrParam['cid']);
                $this->_db_slave->update($this->_table,$data);
            }
        }else{
            $status = ($arrParam['s']== 0 )? 1:0;
            $data= array('status'=>$status);
            $this->_db_slave->where('id', $arrParam['id']);
            $this->_db_slave->update($this->_table,$data);
        }
    }public function slbScopes(){
        $data = $this->_db_slave->select(array('*'))
                        ->from('scopes')
                        ->where('app_type', 0)
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
	public function insertLog($arrParam){
        $promotion = array();
        if(count($arrParam['key'])>0){
            $j=0;
            foreach($arrParam['key'] as $key=> $value){
                $j++;
                if(count($arrParam['keysub'][$j])>0){
                    $i=0;
                    foreach($arrParam['keysub'][$j] as $k=>$v){
                        $arrPromotion[$value][$v] = $arrParam['namesub'][$j][$i];
                        $i++;
                    }
                }
            }
            $promotion = $arrPromotion;
        }
        $start = date_format(date_create($arrParam['start']),"Y-m-d G:i:s");
        $end = date_format(date_create($arrParam['end']),"Y-m-d G:i:s");
        
        $arrServer = json_decode($arrParam['content_server'],true);
        $strServer = '';
        if(count($arrServer)>0){
            foreach($arrServer as $v){
                $resultServer[] = $v['server_id'];
            }
            $strServer = implode(',', $resultServer);
        }
        
        $logData['id'] = $arrParam['id'];
        $logData['game'] = $arrParam['game'];
        $logData['server_ids'] = $strServer;
        $logData['promotion'] = $promotion;
        $logData['is_first'] = !empty($arrParam['is_first'])?$arrParam['is_first']:0;
        $logData['is_reset'] = !empty($arrParam['is_reset'])?$arrParam['is_reset']:0;
        $logData['amount'] = $arrParam['content_amount']!='[]'?$arrParam['content_amount']:'';
        $logData['start'] = $start;
        $logData['end'] = $end;
        $logData['type'] = $arrParam['content_type']!='[]'?$arrParam['content_type']:'';
        $logData['status'] = !empty($arrParam['status'])?$arrParam['status']:'0';
        $logData['tester'] = ($arrParam['tester']!='[]')?json_decode(str_replace('.','',$arrParam['tester']),true):'';
        
        if($_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==2){
            $logData['publisher'] = !empty($arrParam['publisher'])?$arrParam['publisher']:'0';
        }
        
        $logData['priority'] = $arrParam['priority'];
        if($_SESSION['account']['id_group']==1){
            $logData['approved'] = !empty($arrParam['approved'])?$arrParam['approved']:'0';
        }
        if($_SESSION['account']['id_group']!=3 || ($items['publisher']==1 && $_SESSION['account']['id_group']==3)){
            $logData['doned'] = !empty($arrParam['doned'])?$arrParam['doned']:'0';
        }
        
        $arrData['controller']      = $arrParam['control'];
        $arrData['action']          = $arrParam['func'];
        $arrData['id_user']         = $_SESSION['account']['id'];
        $arrData['username']        = $_SESSION['account']['username'];
        $arrData['log']             = json_encode($logData);
        $arrData['created_date']    = date('Y-m-d G:i:s');
        $this->_db_slave->insert($this->_table.'_log',$arrData);
    }
}

