<?php
class TableAppValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        
        if(empty($arrParam['version_name'])){
            $this->_arrError['version_name'] = '<div class="error">Vui lòng nhập tên</div>';
            $arrParam['version_name'] = '';
        }
        if(empty($arrParam['cert_name'])){
            $this->_arrError['cert_name'] = '<div class="error">Vui lòng nhập cert name</div>';
            $arrParam['cert_name'] = '';
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