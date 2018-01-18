<?php
class SignConfigAppValidate{
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
            $provision = $this->CI->SignConfigAppModel->getItem($arrParam['id']);
        }
        if($arrParam['id_game']==0){
            $this->_arrError['id_game'] = '<div class="error">Vui lòng nhập game</div>';
            $arrParam['id_game'] = '';
        }
		if($arrParam['cbo_platform']=="0"){
            $this->_arrError['cbo_platform'] = '<div class="error">Vui lòng chọn Platform</div>';
            $arrParam['cbo_platform'] = '';
        }
		if($arrParam['cbo_platform']=="ios"){
			if($arrParam['cert_id']==0){
				$this->_arrError['cert_id'] = '<div class="error">Vui lòng nhập bảng app</div>';
				$arrParam['cert_id'] = '';
			}
		}elseif($arrParam['cbo_platform']=="android" || $arrParam['cbo_platform']=="wp"){
			if($arrParam['cert_id_a_wp']==0){
				$this->_arrError['cert_id_a_wp'] = '<div class="error">Vui lòng nhập bảng app</div>';
				$arrParam['cert_id'] = '';
			}
		}
        if(empty($arrParam['cbo_bundleidentifier'])){
            $this->_arrError['bundleidentifier'] = '<div class="error">Vui lòng nhập bundle id</div>';
            $arrParam['bundleidentifier'] = '';
        }
        
		if($arrParam['cbo_platform']=="ios"){
				$this->fileInfo = $fileInfo;
				//kiem tra upload file mobileprovision
				$fileName = $fileInfo['provision']['name'];
				$options = array('.mobileprovision');
				if(!empty($fileName)){
					preg_match('#\.[^.]+$#', $fileName,$match);
					if(!in_array($match[0],$options)){
						$this->_arrError['provision'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
						$arrParam['provision'] = $arrParam['current_provision'];
					}
				}else{
					if($_GET['func']=='add'){
						$this->_arrError['provision'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
					}
					if(!empty($provision['provision'])){
						$arrParam['provision'] = $arrParam['current_provision'];
					}else{
						$this->_arrError['provision'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
					}
				}
				//kiem tra upload file entitlements plist
				$fileNameEntitlements = $fileInfo['entitlements']['name'];
				$options = array('.plist');
				if(!empty($fileNameEntitlements)){
					preg_match('#\.[^.]+$#', $fileNameEntitlements,$match);
					if(!in_array($match[0],$options)){
						$this->_arrError['entitlements'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
						$arrParam['entitlements'] = $arrParam['current_entitlements'];
					}
				}else{
					if($_GET['func']=='add'){
						$this->_arrError['entitlements'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
					}
					if(!empty($provision['entitlements'])){
						$arrParam['entitlements'] = $arrParam['current_entitlements'];
					}else{
						$this->_arrError['entitlements'] = '<div class="error error_file">Vui lòng up file '.$options[0].'</div>';
					}
				}
		}//end if
        $this->_arrData = $arrParam;
        return 0;
    }
    public function getData(){
        if(!$this->isVaild()){
			if($this->_arrData['cbo_platform']=="ios"){
            	$arrFile = $this->upload();
				if(count($arrFile)>0){
					$this->_arrData = array_merge($arrFile,$this->_arrData);
				}
			}
        }
        if(!$this->isVaild()){
			if($this->_arrData['cbo_platform']=="ios"){
				$arrFileEntitlements = $this->uploadEntitlements();
				if(count($arrFileEntitlements)>0){
					$this->_arrData = array_merge($arrFileEntitlements,$this->_arrData);
				}
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
        $fileName = $this->fileInfo['provision']['name'];
        if(!empty($fileName)){
            preg_match('#\.[^.]+$#', $fileName,$match);
            $rename_file = time().$match[0];
            if($_GET['func'] == 'edit'){
                @unlink($dirUpload.'/'.$this->_arrData['current_provision']);
            }
            move_uploaded_file($this->fileInfo['provision']['tmp_name'],$dirUpload."/".$fileName);
            $arrFile['provision'] = $fileName;
        }
        return $arrFile;	
    }
    public function uploadEntitlements(){
        $dirUpload = FILE_PATH;
        $fileName = $this->fileInfo['entitlements']['name'];
        if(!empty($fileName)){
            preg_match('#\.[^.]+$#', $fileName,$match);
            $rename_file = time().$match[0];
            if($_GET['func'] == 'edit'){
                @unlink($dirUpload.'/'.$this->_arrData['current_entitlements']);
            }
            move_uploaded_file($this->fileInfo['entitlements']['tmp_name'],$dirUpload."/".$fileName);
            $arrFile['entitlements'] = $fileName;
        }
        return $arrFile;	
    }
}