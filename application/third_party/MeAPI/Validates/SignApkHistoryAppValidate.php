<?php
class SignApkHistoryAppValidate{
    private $_arrError;
    private $_arrData;
    private $CI;
    private $fileInfo;
	//private $FILE_PATH_APK="";
    
    public function __construct() {
        $this->CI = & get_instance();
		//$this->CI->load->MeAPI_Model('SignapkModel');
    }
    
    public function validateForm($arrParam = null,$fileInfo) {
        $arrParam = $this->CI->security->xss_clean($arrParam);
        if($arrParam['cbo_game']==0){
            $this->_arrError['cbo_game'] = '<div class="error">Vui lòng nhập game</div>';
            $arrParam['cbo_game'] = '';
        }
        if($arrParam['cbo_type_app']==0){
            $this->_arrError['cbo_type_app'] = '<div class="error">Vui lòng nhập bảng app</div>';
            $arrParam['cbo_type_app'] = '';
        }
        $this->fileInfo = $fileInfo;
        //kiem tra upload file certificate
        $fileName = $fileInfo['apk_files']['name'];
        $options = array('.apk');
        if(!empty($fileName)){
            preg_match('#\.[^.]+$#', $fileName,$match);
            if(!in_array($match[0],$options)){
                $this->_arrError['apk'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
                $arrParam['apk'] = $arrParam['current_apk'];
            }
        }else{
            if($_GET['func']=='add'){
                $this->_arrError['apk'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
            }
        }
        $this->_arrData = $arrParam;
        return 0;
    }
	public function getDatai(){
        $this->_arrData = array_merge(array(),$this->_arrData);
        return $this->_arrData;
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
        $fileName = $this->fileInfo['apk_files']['name'];
		$times=date('Y_m_d')."_".date('s')."_".date("H_i_s");
		$type_app=$this->_arrData['cbo_type_app']==1?"GooglePlay":"Inhouse";
		$name_game=explode("|",$this->_arrData['cbo_game']);
		$getGame = $this->CI->SignapkModel->getItemGamenew($name_game[0]);
        //$sdk_name=explode("|",$this->_arrData['cbo_sdk']);
        if(!empty($fileName)){
            preg_match('#\.[^.]+$#', $fileName,$match);
			$fn=explode(".",$fileName);
			$nf=str_replace(".".$fn[count($fn)-1],"",$fileName);
            $rename_file = str_replace(" ","_",$getGame['app_name'])."_".$type_app."_".$times.$match[0];
            if($_GET['func'] == 'edit'){
                @unlink($dirUpload.'/'.$this->_arrData['current_certificate']);
            }
            move_uploaded_file($this->fileInfo['apk_files']['tmp_name'],$dirUpload."/".$rename_file);
			
            $arrFile['apk'] = $rename_file;
        }
        return $arrFile;	
    }
}