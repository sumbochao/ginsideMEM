<?php
class ListGameRequestValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        if(empty($arrParam['gameID'])){
            $this->_arrError['gameID'] = '<div class="error">Vui lòng nhập gameID</div>';
            $arrParam['gameID'] = '';
        }
        if(empty($arrParam['name'])){
            $this->_arrError['name'] = '<div class="error">Vui lòng nhập tên</div>';
            $arrParam['name'] = '';
        }
        if(empty($arrParam['alias'])){
            $this->_arrError['alias'] = '<div class="error">Vui lòng nhập alias</div>';
            $arrParam['alias'] = '';
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