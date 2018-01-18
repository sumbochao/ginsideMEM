<?php
class SignHistoryAppValidatePlus{
    private $_arrError;
    private $_arrData;
    private $CI;
    private $fileInfo;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function validateForm($fileInfo) {
        $this->fileInfo = $fileInfo;
        return 0;
    }
	
    public function getData($arrParam){
		
		$this->_arrData = $arrParam;
        return $this->_arrData;
    }
	
    public function isVaild($id_game,$file_upload){
        $flag = true;
        if($id_game==0){
		   $this->_arrError['id_game'] = '<div class="error">Vui lòng nhập game</div>';
           $flag=false;
        }
		$fileName = $file_upload['ipa_file']['name'];
		if($fileName == "" || $fileName == NULL){
			$flag=false;
		}
        $options = array('.ipa');
        if(!empty($fileName)){
            preg_match('#\.[^.]+$#', $fileName,$match);
            if(!in_array($match[0],$options)){
				 $this->_arrError['ipa_file'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
               $flag=false;
            }
        }else{
			$this->_arrError['ipa_file'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
               $flag=false;
		}
        return $flag;
    }
    public function getMessageErrors(){
        return $this->_arrError;
    }
    public function upload(){
        $dirUpload = FILE_PATH;
        $fileName = $this->fileInfo['ipa_file']['name'];
        if(!empty($this->_arrData['cbo_sdk']) || $this->_arrData['cbo_sdk']!=""){
        	$sdk_name=explode("|",$this->_arrData['cbo_sdk']);
		}else{
			$sdk_name=explode("|","0|client");
		}
        if(!empty($fileName)){
            preg_match('#\.[^.]+$#', $fileName,$match);
			$fn=explode(".",$fileName);
			$nf=str_replace(".".$fn[count($fn)-1],"",$fileName);
            $rename_file = $nf."_".str_replace(".","-",$sdk_name[1]).$match[0];
            if($_GET['func'] == 'edit'){
                @unlink($dirUpload.'/'.$this->_arrData['current_certificate']);
            }
            move_uploaded_file($this->fileInfo['ipa_file']['tmp_name'],$dirUpload."/".$rename_file);
			
            $arrFile['certificate'] = $rename_file;
			$this->_arrData['certificate']=$arrFile['certificate'];
        }
         return $arrFile['certificate'];	
    }
	
	
}