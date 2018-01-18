<?php
class SignHistoryAppValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    private $fileInfo;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($arrParam = null,$fileInfo) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        if($arrParam['id']>0){
            $certificate = $this->CI->SignHistoryAppModel->getItem($arrParam['id']);
        }
        if($arrParam['id_game']==0){
            $this->_arrError['id_game'] = '<div class="error">Vui lòng nhập game</div>';
            $arrParam['id_game'] = '';
        }
        if($arrParam['id_table']==0){
            $this->_arrError['id_table'] = '<div class="error">Vui lòng nhập bảng app</div>';
            $arrParam['id_table'] = '';
        }
        $this->fileInfo = $fileInfo;
        //kiem tra upload file certificate
        $fileName = $fileInfo['certificate']['name'];
        $options = array('.ipa');
        if(!empty($fileName)){
            preg_match('#\.[^.]+$#', $fileName,$match);
            if(!in_array($match[0],$options)){
                $this->_arrError['certificate'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
                $arrParam['certificate'] = $arrParam['current_certificate'];
            }
        }else{
            if($_GET['func']=='add'){
                $this->_arrError['certificate'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
            }
            if(!empty($certificate['certificate'])){
                $arrParam['certificate'] = $arrParam['current_certificate'];
            }else{
                $this->_arrError['certificate'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
            }
        }
        $this->_arrData = $arrParam;
        return 0;
    }
    public function getData(){
        if(!$this->isVaild()){
            $arrFile = $this->upload();
            if(count($arrFile)>0){
                $this->_arrData = array_merge($arrFile,$this->_arrData);
            }
        }
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
    public function upload(){
        $dirUpload = FILE_PATH;
        $fileName = $this->fileInfo['certificate']['name'];
       
        if(!empty($fileName)){
            preg_match('#\.[^.]+$#', $fileName,$match);
            $rename_file = time().$match[0];
            if($_GET['func'] == 'edit'){
                @unlink($dirUpload.'/'.$this->_arrData['current_certificate']);
            }
            move_uploaded_file($this->fileInfo['certificate']['tmp_name'],$dirUpload."/".$rename_file);
            $arrFile['certificate'] = $rename_file;
        }
        return $arrFile;	
    }
}