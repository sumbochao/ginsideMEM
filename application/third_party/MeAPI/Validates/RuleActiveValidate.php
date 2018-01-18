<?php
class RuleActiveValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        if($arrParam['configID']==0 || $arrParam['configID']==""){
            $this->_arrError['configID'] = '<div class="error">Vui lòng nhập config</div>';
            $arrParam['configID'] = '';
        }
        if($arrParam['gameID']==0 || $arrParam['gameID']==""){
            $this->_arrError['gameID'] = '<div class="error">Vui lòng nhập game id</div>';
            $arrParam['gameID'] = '';
        }
        if($arrParam['gamereceiveID']==0 || $arrParam['gamereceiveID']==""){
            $this->_arrError['gamereceiveID'] = '<div class="error">Vui lòng nhập game id receive</div>';
            $arrParam['gamereceiveID'] = '';
        }
        if(empty($arrParam['jsonRule'])){
            $this->_arrError['jsonRule'] = '<div class="error">Vui lòng nhập jsonRule</div>';
            $arrParam['jsonRule'] = '';
        }
        if(count($arrParam['item_id'])==0){
            $this->_arrError['items'] = '<div class="error item">Vui lòng nhập items</div>';
        }
        if(count($arrParam['item_id_receive'])==0){
            $this->_arrError['items_receive'] = '<div class="error item">Vui lòng nhập items receive</div>';
        }
        $this->_arrData = $arrParam;
        return 0;
    }
    public function getData(){
        return $this->_arrData;
    }
    public function isVaild(){
        $flag = false;
        if(count($this->_arrError) > 0){
            $flag = true;
        }
        return $flag;
    }
    public function getMessageErrors(){
        return $this->_arrError;
    }
}