<?php
class MeAPI_Controller_ApiProjectsController{
    protected $_response;
    private $CI;
    private $_mainAction;
	private $limit;
	private $keys="YBHGINSIDEBKLUYTFJMECORP";
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
		$this->CI->load->MeAPI_Model('ProjectsModel');
        $this->limit = 100;
    }
	//lay thong tin projects
	public function AuthorizeRequestToken($param_request) {
		//?control=apirojects&func=getinfo&project=demo&token=jghbvhv
		$value_data= array();
		$secret_key=$this->keys;
        $params=$param_request;
		$token=trim($params['token']);
		$is_check_token = TRUE;
		//unset($params['project'], $params['token'], $params['control'], $params['func']);
		 if($is_check_token == TRUE){
			  if(count($params) < 4){
				  $value_data=array(
						"code"=>"-2",
						"Desc"=>"INVALID_PARAMS",
						"Data"=>"null",
						"Message "=>"Tham số không đầy đủ"
					);
					return $value_data;
			  }//end if
			  if(!isset($params['project']) || !isset($params['token']) || !isset($params['control']) || !isset($params['func']) || !isset($params['platform'])){
				  $value_data=array(
						"code"=>"-3",
						"Desc"=>"INVALID_PARAMS",
						"Data"=>"null",
						"Message "=>"Tham số không đúng"
					);
					return $value_data;
			  }//end if
			  unset($params['token']);
			  $valid = md5(implode('', $params) . $secret_key);
			  if($valid != $token && $is_check_token){
                    $value_data=array(
						"code"=>"-1",
						"Desc"=>"INVALID_TOKEN",
						"Data"=>"null",
						"Message "=>"Chuỗi chứng thực không đúng"
					);
					return $value_data;
              }
			  //end if
			  if(isset($params['project']) && isset($token) && isset($params['control']) && isset($params['func']) && isset($params['platform'])){
				  $this->data['getitem'] = $this->CI->ProjectsModel->getProjectsByCode($params['project']);
				  if(empty($this->data['getitem'])){
					  $f = array(
							'messg'=>'Dịch vụ GINSIDE'
					   );
					   echo json_encode($f);
					   exit();
				  }
				  //lay thong tin bang tbl_projects_property1 (BundleID PackageName PackageIdentity)
				  $bpp= array();
				  $i=0;
				  $listItems= $this->CI->ProjectsModel->loadlistplus($this->data['getitem']['id'],"");
				  if(count($listItems)>0){
					  foreach($listItems as $k=>$v){
						  if($params['platform']!=""){
							  if($v['platform']==$params['platform']){
								$i++;
								// định dạng format json GoogleProductApi
								if($v['googleproductapi']!=""){
									  $GoogleproductApi=explode(";",$v['googleproductapi']);
									  $_gReportWithConversionID='"reportwithconversionid":"'.trim($GoogleproductApi[0]).'"';
									  $_gLabel='"label":"'.trim($GoogleproductApi[1]).'"';
									  $_gValue='"value":"'.trim($GoogleproductApi[2]).'"';
									  $_gIsRepeatable='"isrepeatable":"'.trim($GoogleproductApi[3]).'"';
									  $jSon_Google='{'.$_gReportWithConversionID.",".$_gLabel.",".$_gValue.",".$_gIsRepeatable.'}';
									  //sau đó gán lại vào cho googleproductapi
									  $googleadword=$jSon_Google;
								}else{
									$googleadword="\"No Data\"";
								}
								  
								 if($v['platform']=="ios" && $v['cert_name']!="Inhouse"){
									$bpp["ios_".$i]=json_decode('{"bundleid":"'.$v['package_name'].'","apple_id":"'.$v['app_id'].'","apn_certificates":"'.$v['files_certificates'].'","apn_password":"'.$v['pass_certificates'].'","api_key_google":"'.$v['api_key'].'","client_id_google":"'.$v['client_key'].'","url_scheme_google":"'.$v['url_scheme'].'","facebook_app_id":"'.$v['fb_appid'].'","facebook_app_secret":"'.$v['fb_appsecret'].'","facebook_urlschemes":"'.$v['fb_schemes'].'","googleproductapi":'.$googleadword.'}');
									
									
								  }
									if($v['platform']=="android"){
										$bpp["android_".$i]=json_decode('{"package_name":"'.$v['package_name'].'","public_key":"'.$v['public_key'].'","api_key_google":"'.$v['api_key'].'","client_id_google":"'.$v['client_key'].'","facebook_app_id":"'.$v['fb_appid'].'","facebook_app_secret":"'.$v['fb_appsecret'].'","facebook_urlschemes":"'.$v['fb_schemes'].'","googleproductapi":'.$googleadword.'}');
										
								  }
								  if($v['platform']=="wp"){
										$bpp["wp_".$i]=json_decode('{"package_identity":"'.$v['package_name'].'","app_id":"'.$v['app_id'].'","publisher":"'.$v['wp_p1'].'","names_for_this_app":"'.$v['wp_p2'].'","client_id_google":"'.$v['client_key'].'","client_secret":"'.$v['client_secret'].'","facebook_app_id":"'.$v['fb_appid'].'","facebook_app_secret":"'.$v['fb_appsecret'].'","facebook_urlschemes":"'.$v['fb_schemes'].'","googleproductapi":'.$googleadword.',"protocol":"'.$v['protocol'].'"}');
										
									
								  }
							  
							  }//end if
						  }else{
							  $a=1;$o=1;$w=1;
							  if($v['platform']=="ios"){
								  $o++;
								  $plf=$o>2?"ios_".$i:"ios";
									$bpp[$plf]=json_decode('{"bundleid":"'.$v['package_name'].'","apple_id":"'.$v['app_id'].'","apn_certificates":"'.$v['files_certificates'].'","apn_password":"'.$v['pass_certificates'].'","api_key_google":"'.$v['api_key'].'","client_id_google":"'.$v['client_key'].'","url_scheme_google":"'.$v['url_scheme'].'","facebook_app_id":"'.$v['fb_appid'].'","facebook_app_secret":"'.$v['fb_appsecret'].'","facebook_urlschemes":"'.$v['fb_schemes'].'"}');
							  }//end if
							  if($v['platform']=="android"){
									$a++;
									$plf=$a>2?"android_".$i:"android";
									$bpp[$plf]=json_decode('{"package_name":"'.$v['package_name'].'","public_key":"'.$v['public_key'].'","api_key_google":"'.$v['api_key'].'","client_id_google":"'.$v['client_key'].'","facebook_app_id":"'.$v['fb_appid'].'","facebook_app_secret":"'.$v['fb_appsecret'].'","facebook_urlschemes":"'.$v['fb_schemes'].'"}');
							  } //end if
							  if($v['platform']=="wp"){
									$w++;
									$plf=$w>2?"wp_".$i:"wp";
									$bpp[$plf]=json_decode('{"package_identity":"'.$v['package_name'].'","app_id":"'.$v['app_id'].'","publisher":"'.$v['wp_p1'].'","names_for_this_app":"'.$v['wp_p2'].'","client_id_google":"'.$v['client_key'].'","client_secret":"'.$v['client_secret'].'","facebook_app_id":"'.$v['fb_appid'].'","facebook_app_secret":"'.$v['fb_appsecret'].'","facebook_urlschemes":"'.$v['fb_schemes'].'","protocol":"'.$v['protocol'].'"}');
							  } //end if
							  
						  }//end if
						  
					  } //end for
				  } // end if
				  try
				  {
						  $arr= array();
						  $arr=$this->data['getitem'];
						  try{
							  //lấy sercurity của Service Key, bằng url: http://log.sdk.mobo.vn:6868/sdk-web-api/api/security/encrypt?key=realkey
							  $http="http://log.sdk.mobo.vn:6868/sdk-web-api/api/security/encrypt?key=".trim($arr['servicekey']);
							  $val=file_get_contents($http);
							  $val_json=json_decode($val);
							  //sau đó gán lại vào servicekey
							  $arr['servicekey']=$val_json->{'data'};
							  
							  //lấy sercurity của Service Key Second, bằng url: http://log.sdk.mobo.vn:6868/sdk-web-api/api/security/encrypt?key=realkey
							  $httpc="http://log.sdk.mobo.vn:6868/sdk-web-api/api/security/encrypt?key=".trim($arr['servicekey_second']);
							  $valc=file_get_contents($httpc);
							  $val_jsonc=json_decode($valc);
							  //sau đó gán lại vào servicekey_second
							  $arr['servicekey_second']=$val_jsonc->{'data'};
						  
							  //lấy sercurity của Appsflyer Id, bằng url: http://log.sdk.mobo.vn:6868/sdk-web-api/api/security/encrypt?key=realkey
							  if($arr['appsflyerid']!="" || $arr['appsflyerid']!=NULL){
								  $http1="http://log.sdk.mobo.vn:6868/sdk-web-api/api/security/encrypt?key=".trim($arr['appsflyerid']);
								  $val1=file_get_contents($http1);
								  $val_json1=json_decode($val1);
								  //sau đó gán lại vào servicekey
								  $arr['appsflyerid']=$val_json1->{'data'};
							  }
						  }catch(Exception $e){
							   $value_data=array(
								"code"=>"-10",
								"Desc"=>"SOS",
								"Data"=>"null",
								"Message "=>"SYSTEM ERROR"
								);
							  return $value_data;
						  }
						  
						  // định dạng format json GoogleProductApi
						  /*$GoogleproductApi=explode(";",$arr['googleproductapi']);
						  $_gReportWithConversionID='"reportwithconversionid":"'.trim($GoogleproductApi[0]).'"';
						  $_gLabel='"label":"'.trim($GoogleproductApi[1]).'"';
						  $_gValue='"value":"'.trim($GoogleproductApi[2]).'"';
						  $_gIsRepeatable='"isrepeatable":"'.trim($GoogleproductApi[3]).'"';
						  $jSon_Google='{'.$_gReportWithConversionID.",".$_gLabel.",".$_gValue.",".$_gIsRepeatable.'}';
						  //sau đó gán lại vào cho googleproductapi
						  $arr['googleproductapi']=json_decode($jSon_Google);*/
						  
						  //xóa những trường ko cần thiết
						  unset($arr['id'],$arr['status'],$arr['datecreate'],$arr['userlog'],$arr['request_per'],$arr['accept_per'],$arr['notes'],$arr['appleid'],$arr['facebookappid'],$arr['facebookappsecret'],$arr['facebookurlschemes'],$arr['googleproductapi']);
						  
						  $value_data=array(
								"project"=>$arr,
								"clientInfo"=>array_values($bpp)
							);
							return $value_data;
				  
				  }catch(Exception $e){
					   $value_data=array(
						"code"=>"-10",
						"Desc"=>"SOS",
						"Data"=>"null",
						"Message "=>"SYSTEM ERROR"
						);
					  return $value_data;
				  }
				  
			  }//end if
			  
		 }
		 return $value_data;
    }
    public function getinfo(MeAPI_RequestInterface $request) {
		$arr_p=$this->CI->security->xss_clean($_GET);
		$output=$this->AuthorizeRequestToken($arr_p);
		MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),http_build_query($arr_p),$_SERVER['REQUEST_URI'],"API_GINSIDE_GETINFO"), "API_GINSIDE_" . date('H'));
		if(isset($output)){
			echo json_encode($output);
       	    exit();
        }else{
            $f = array(
                'messg'=>'Dịch vụ GINSIDE'
            );
        }
		
        echo json_encode($f);
        exit();
    }
	
	//lay danh sach ma projects
	public function AuthorizeRequestToken1($param_request) {
		//?control=apirojects&func=getcodeprojects&token=jghbvhv
		$value_data= array();
		$secret_key=$this->keys;
        $params=$param_request;
	
		$token=trim($params['token']);
		$is_check_token = TRUE;
		 if($is_check_token == TRUE){
			  if(count($params)<3){
				  $value_data=array(
						"code"=>"-2",
						"Desc"=>"INVALID_PARAMS",
						"Data"=>"null",
						"Message "=>"Tham số không đầy đủ"
					);
					return $value_data;
			  }//end if
			  if(!isset($params['token']) || !isset($params['control']) || !isset($params['func']) || !isset($params['platform'])){
				  $value_data=array(
						"code"=>"-3",
						"Desc"=>"INVALID_PARAMS",
						"Data"=>"null",
						"Message "=>"Tham số không đúng"
					);
					return $value_data;
			  }//end if
			  unset($params['token']);
			  $valid = md5(implode('', $params) . $secret_key);
			  if($valid != $token && $is_check_token){
                    $value_data=array(
						"code"=>"-1",
						"Desc"=>"INVALID_TOKEN",
						"Data"=>"null",
						"Message "=>"Chuỗi chứng thực không đúng"
					);
					return $value_data;
              }
			  //end if
			  if(isset($token) && isset($params['control']) && isset($params['func'])){
				 if(isset($params['platform']) && $params['platform']!=""){
					 $listItems = $this->CI->ProjectsModel->getProjectsListWhere($params['platform']);
				 }else{
				 	 $listItems = $this->CI->ProjectsModel->getProjectsList();
				 }
				  //lay thong tin bang tbl_projects_property1 (BundleID PackageName PackageIdentity)
				  $data=array();
				  if(count($listItems)>0){
					  foreach($listItems as $k=>$v){
						  		$data[$k]=json_decode('{"code":"'.$v['code'].'","name":"'.$v['names'].'"}');
					  }
				  }
				  $value_data=array(
						"ListInfo"=>$data
					);
					return $data;
			  }//end if
			  
		 }
		 return $value_data;
    }
	
	public function getcodeprojects(MeAPI_RequestInterface $request) {
		$arr_p=$this->CI->security->xss_clean($_GET);
		$output=$this->AuthorizeRequestToken1($arr_p);
		MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),http_build_query($arr_p),$_SERVER['REQUEST_URI'],"API_GINSIDE_GETCODEPROJECTS"), "API_GINSIDE_" . date('H'));
		if(isset($output)){
			echo json_encode($output);
       	    exit();
        }else{
            $f = array(
                'messg'=>'Dịch vụ GINSIDE'
            );
        }
		
        echo json_encode($f);
        exit();
    }
	
	//24/2/2016
	//lay danh sach ma projects
	public function AuthorizeRequestToken_Tune($param_request) {
		//?control=apirojects&func=gettunestatus&servicekeyapp=133&token=jghbvhv
		$value_data= array();
		$secret_key=$this->keys;
        $params=$param_request;
	
		$token=trim($params['token']);
		$is_check_token = TRUE;
		 if($is_check_token == TRUE){
			  if(count($params)<3){
				  $value_data=array(
						"code"=>"-2",
						"Desc"=>"INVALID_PARAMS",
						"Data"=>"null",
						"Message "=>"Tham số không đầy đủ"
					);
					return $value_data;
			  }//end if
			  if(!isset($params['token']) || !isset($params['control']) || !isset($params['func']) || !isset($params['servicekeyapp'])){
				  $value_data=array(
						"code"=>"-3",
						"Desc"=>"INVALID_PARAMS",
						"Data"=>"null",
						"Message "=>"Tham số không đúng"
					);
					return $value_data;
			  }//end if
			  unset($params['token']);
			  $valid = md5(implode('', $params) . $secret_key);
			  if($valid != $token && $is_check_token){
                    $value_data=array(
						"code"=>"-1",
						"Desc"=>"INVALID_TOKEN",
						"Data"=>"null",
						"Message "=>"Chuỗi chứng thực không đúng"
					);
					return $value_data;
              }
			  //end if
			  if(isset($token) && isset($params['control']) && isset($params['func']) && isset($params['servicekeyapp'])){
				 if($params['servicekeyapp']!=""){
					 $Items = $this->CI->ProjectsModel->getStatusTuneProjects($params['servicekeyapp']);
				 }else{
				 	 $Items = NULL;
				 }
				  //lay thong tin bang tbl_projects
				  $data=array();
				  if($Items!=NULL){
					  $data[0]=json_decode('{"servicekeyapp":"'.$Items['servicekeyapp'].'","trackingTune":"'.$Items['tune_status'].'"}');
				  }
				  $value_data=array(
						"Info"=>$data
					);
					return $data;
			  }//end if
			  
		 }
		 return $value_data;
    }//end fucn
	public function gettunestatus(MeAPI_RequestInterface $request) {
		$arr_p=$this->CI->security->xss_clean($_GET);
		$output=$this->AuthorizeRequestToken_Tune($arr_p);
		MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),http_build_query($arr_p),$_SERVER['REQUEST_URI'],"API_GINSIDE_GETTUNESTATUS"), "API_GINSIDE_" . date('H'));
		if(isset($output)){
			echo json_encode($output);
       	    exit();
        }else{
            $f = array(
                'messg'=>'Dịch vụ GINSIDE'
            );
        }
		
        echo json_encode($f);
        exit();
    } //end func
	
    public function getResponse() {
        return $this->_response;
    }
}
