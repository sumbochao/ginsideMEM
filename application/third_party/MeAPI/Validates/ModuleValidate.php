<?php
class ModuleValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        
        if(empty($arrParam['name'])){
            $this->_arrError['name'] = '<div class="error">Vui lòng nhập tên chức năng</div>';
            $arrParam['name'] = '';
        }
        if($arrParam['parents']>0 && $arrParam['id_type']!=1){
            if(empty($arrParam['controller'])){
                $this->_arrError['controller'] = '<div class="error">Vui lòng nhập tên controller</div>';
                $arrParam['controller'] = '';
            }
            if(empty($arrParam['action'])){
                $this->_arrError['action'] = '<div class="error">Vui lòng nhập tên action</div>';
                $arrParam['action'] = '';
            }
        }elseif($arrParam['parents']>0 && $arrParam['id_type']==1){
            if(empty($arrParam['game'])){
                $this->_arrError['game'] = '<div class="error">Vui lòng nhập game</div>';
                $arrParam['game'] = '';
            }
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