<?php
class FacebookConfigValidate{
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
        if(empty($arrParam['name'])){
            $this->_arrError['name'] = '<div class="error">Vui lòng nhập tên</div>';
            $arrParam['name'] = '';
        }
        if(empty($arrParam['client_id'])){
            $this->_arrError['client_id'] = '<div class="error">Vui lòng nhập Client ID</div>';
            $arrParam['client_id'] = '';
        }
        if(empty($arrParam['client_secret'])){
            $this->_arrError['client_secret'] = '<div class="error">Vui lòng nhập Client Secret</div>';
            $arrParam['client_secret'] = '';
        }
        if(empty($arrParam['server_id'])){
            $this->_arrError['server_id'] = '<div class="error">Vui lòng nhập Server</div>';
            $arrParam['server_id'] = '';
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