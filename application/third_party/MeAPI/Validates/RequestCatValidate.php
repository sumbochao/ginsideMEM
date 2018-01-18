<?php
class RequestCatValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        if(empty($arrParam['name'])){
            $this->_arrError['name'] = '<div class="error">Vui lòng nhập tên</div>';
            $arrParam['name'] = '';
        }
        if(empty($arrParam['url'])){
            $this->_arrError['url'] = '<div class="error">Vui lòng nhập url</div>';
            $arrParam['url'] = '';
        }
        if(empty($arrParam['desc'])){
            $this->_arrError['desc'] = '<div class="error">Vui lòng nhập desc</div>';
            $arrParam['desc'] = '';
        }
        if($arrParam['configID']==0){
            $this->_arrError['configID'] = '<div class="error">Vui lòng chọn config</div>';
            $arrParam['configID'] = '';
        }
        if($arrParam['gameID']==0){
            $this->_arrError['gameID'] = '<div class="error">Vui lòng chọn game</div>';
            $arrParam['gameID'] = '';
        }
        
        if(!is_array($arrParam['receiveGame'])){
            $this->_arrError['receiveGame'] = '<div class="error receivegame">Vui lòng chọn receive game</div>';
            $arrParam['receiveGame'] = '';
        }else{
            if($arrParam['receiveGame']['0']=='multiselect-all'){
                array_shift($arrParam['receiveGame']);
                if(count($arrParam['receiveGame'])==0){
                    $this->_arrError['receiveGame'] = '<div class="error receivegame">Vui lòng chọn receive game</div>';
                    $arrParam['receiveGame'] = '';
                }
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