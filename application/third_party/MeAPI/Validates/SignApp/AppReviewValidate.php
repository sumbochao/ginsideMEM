<?php
class AppReviewValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        if(empty($arrParam['type'])){
            $this->_arrError['type'] = 'Chọn loại';
            $arrParam['type'] = '';
        }
        if($arrParam['id_projects']==0){
            $this->_arrError['id_projects'] = 'Chọn package';
            $arrParam['id_projects'] = '';
        }
        if(empty($arrParam['version'])){
            $this->_arrError['version'] = 'Nhập version';
            $arrParam['version'] = '';
        }
        $checkVersion = $this->CI->AppReviewModel->checkValidate($arrParam);
        if($checkVersion==1){
            $this->_arrError['id_projects'] = 'Package và vesrion đã tồn tại !';
            $arrParam['id_projects'] = '';
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