<?php
class NavigatorValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        if(empty($arrParam['slbgame'])){
            $this->_arrError['slbgame'] = '<div class="error">Vui lòng chọn game</div>';
            $arrParam['slbgame'] = '';
        }
        if(empty($arrParam['service_url'])){
            $this->_arrError['service_url'] = '<div class="error">Vui lòng nhập đường dẫn</div>';
            $arrParam['service_url'] = '';
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