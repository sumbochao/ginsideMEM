<?php
class PaymentValidate{
    private $_arrError;
    private $_arrData;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($arrParam = null) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        
        if(empty($arrParam['service_id'])){
            $this->_arrError['service_id'] = '<div class="errors">Vui lòng chọn 1 danh mục</div>';
            $arrParam['service_id'] = '';
        }
        
        if(empty($arrParam['transaction_id'])){
            $this->_arrError['transaction_id'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['transaction_id'] = '';
        }
        
        if(empty($arrParam['mobo_id'])){
            $this->_arrError['mobo_id'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['mobo_id'] = '';
        }else if(!is_numeric($arrParam['mobo_id'])){
            $this->_arrError['mobo_id'] = '<div class="errors">Giá trị này phải là số</div>';
            $arrParam['mobo_id'] = "";
        }
        
        if(empty($arrParam['mobo_service_id'])){
            $this->_arrError['mobo_service_id'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['mobo_service_id'] = '';
        }else if(!is_numeric($arrParam['mobo_service_id'])){
            $this->_arrError['mobo_service_id'] = '<div class="errors">Giá trị này phải là số</div>';
            $arrParam['mobo_service_id'] = "";
        }
        
        if(empty($arrParam['money'])){
            $this->_arrError['money'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['money'] = '';
        }else if(!is_numeric($arrParam['money'])){
            $this->_arrError['money'] = '<div class="errors">Giá trị này phải là số</div>';
            $arrParam['money'] = "";
        }
        
        if(empty($arrParam['mcoin'])){
            $this->_arrError['mcoin'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['mcoin'] = '';
        }else if(!is_numeric($arrParam['mcoin'])){
            $this->_arrError['mcoin'] = '<div class="errors">Giá trị này phải là số</div>';
            $arrParam['mcoin'] = "";
        }
        
        if(empty($arrParam['credit'])){
            $this->_arrError['credit'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['credit'] = '';
        }else if(!is_numeric($arrParam['credit'])){
            $this->_arrError['credit'] = '<div class="errors">Giá trị này phải là số</div>';
            $arrParam['credit'] = "";
        }
        
        if(empty($arrParam['credit_original'])){
            $this->_arrError['credit_original'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['credit_original'] = '';
        }else if(!is_numeric($arrParam['credit_original'])){
            $this->_arrError['credit_original'] = '<div class="errors">Giá trị này phải là số</div>';
            $arrParam['credit_original'] = "";
        }
        
        if(empty($arrParam['payment_type'])){
            $this->_arrError['payment_type'] = '<div class="errors">Vui lòng chọn 1 danh mục</div>';
            $arrParam['payment_type'] = '';
        }
        
        if(empty($arrParam['game_platform'])){
            $this->_arrError['game_platform'] = '<div class="errors">Vui lòng chọn 1 danh mục</div>';
            $arrParam['game_platform'] = '';
        }
        
        if(empty($arrParam['game_character_id'])){
            $this->_arrError['game_character_id'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['game_character_id'] = '';
        }
        
        if(empty($arrParam['game_character_name'])){
            $this->_arrError['game_character_name'] = '<div class="errors">Giá trị này không được rỗng</div>';
            $arrParam['game_character_name'] = '';
        }
        
        if($arrParam['game_server_id']==0){
            $this->_arrError['game_server_id'] = '<div class="errors">Vui lòng chọn 1 server</div>';
            $arrParam['game_server_id'] = 0;
        }
		
		if(empty($arrParam['source_value'])){
            $this->_arrError['source_value'] = '<div class="errors error_pay">Giá trị này không được rỗng</div>';
            $arrParam['source_value'] = '';
        }
        if($arrParam['source_type']==''){
            $this->_arrError['source_type'] = '<div class="errors error_pay">Vui lòng chọn 1 hình thức</div>';
            $arrParam['source_type'] = '';
        }
        $this->_arrData = $arrParam;
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