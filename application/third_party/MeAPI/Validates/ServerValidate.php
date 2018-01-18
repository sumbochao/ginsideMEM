<?php
class ServerValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        
        if(!is_numeric($arrParam['server_id'])){
			$this->_arrError['server_id'] = '<div class="error">Server phải là số nguyên</div>';
			$arrParam['server_id'] = '';
		}
        if(empty($arrParam['server_name'])){
            $this->_arrError['server_name'] = '<div class="error">Vui lòng nhập tên server</div>';
            $arrParam['server_name'] = '';
        }
        if(empty($arrParam['game'])){
            $this->_arrError['game'] = '<div class="error">Vui lòng chọn game</div>';
            $arrParam['game'] = '';
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