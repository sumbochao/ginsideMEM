<?php

class Graph_Inside_API {

    /**
     * @var CI_Controller
     */
    private $CI;
    private $url = 'http://graph.mobo.vn';
	private $url_thai = 'https://graph-aow.i3play.com';
    protected $secret_key = 'TWVHQDNSVXDEHVNN';
	protected $secret_key_thai = 'AM7USEUBC4NQQQY3';
    private $app = 'ginside';
	private $app_thai = 'inside';
	//key payment
	protected $secret_key_payment = 'KVQAXYN6YYPDC4IH';
	
	private $libcurl;
	private $libtotp;
    public function __construct() {
        $this->CI = & get_instance();
		$this->libcurl=new curl();
		$this->libtotp=new TOTP();
    }
	/* public function __construct($link,$secret_key,$app) {
        $this->CI = & get_instance();
		$this->libcurl=new curl();
		$this->libtotp=new TOTP();
		//param
		$this->url=$link;
		$this->secret_key=$secret_key;
		$this->app=$app;
    }*/
	
	public function get_Secretkey() {
		return $this->secret_key;
    }
	public function get_Secretkey_thai() {
		return $this->secret_key_thai;
    }
	public function get_param_url($arr_param){
		if(is_array($arr_param)){
			return $arr_param;
		}else{
			return false;
		}
	}
	public function get_Secretkey_payment() {
		return $this->secret_key_payment;
    }
	public function get_otp_payment(){
		$otp=$this->libtotp->getCode($this->get_Secretkey_payment());
		return $otp;
	}
	public function get_otp(){
		$otp=$this->libtotp->getCode($this->get_Secretkey());
		return $otp;
	}
	public function get_otp_thai(){
		$otp=$this->libtotp->getCode($this->get_Secretkey_thai());
		return $otp;
	}
	public function checkgamepartner($url_param){
		$arr=explode("&",$url_param);
		$arr1=explode("=",$arr[4]);
		return $arr1[1];
	}
	public function view_msv($url_param){
		if($this->checkgamepartner($url_param)=="124"){
			$json=$this->libcurl->get($this->url_thai ."/?". $url_param);
			//echo $this->url_thai ."/?". $url_param;
		}else{
			$json=$this->libcurl->get($this->url ."/?". $url_param);
			//echo $this->url ."/?". $url_param;
		}
		$data=json_decode($json,TRUE);
		//MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'),$this->url ."/?". $url_param, $json), "{$params['control']}_{$params['func']}_" . date('H'));
		return is_array($data) ? $data : FALSE;
	}
    public function msv_get($where, $games , $page) {
        if (is_array($where) === TRUE) {
            foreach ($where as $key => $value) {
                $params[$value['col']] = $value['value'];
                if ($value['col'] == 'service_id') {
                    $params[$value['col']] = $games[$value['value']];
                }
            }
        }
        if (empty($params['service_id'])) {
            $params['service_id'] = reset($games);
        }
        $params['control'] = 'inside';
        $params['func'] = 'msv_get';
        $params['page'] = $page;

        $result = $this->_call_api($params);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 700010) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
    
    public function msv_get_row($params) {
        $params['control'] = 'inside';
        $params['func'] = 'msv_get';
        $result = $this->_call_api($params);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 700010) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }

    public function msv_add($arrParam) {
        //insert db ginside
		/*$arrUrl['control'] = $arrParam['control'];
		$arrUrl['func'] = $arrParam['func'];
		$arrUrl['msv_id'] = $arrParam['msv_id'];
		$arrUrl['status'] = $arrParam['status'];
		$arrUrl['platform'] = $arrParam['platform'];
		$arrUrl['service_id'] = $arrParam['service_id'];
		$arrUrl['app'] = $arrParam['app'];
		$arrUrl['otp'] = $arrParam['otp'];
		$arrUrl['token'] = $arrParam['token'];*/
        $result = $this->_call_api($arrParam);
		//var_dump($result);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 3000010) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
	public function msv_add_thai($arrParam) {
        //insert db ginside
		/*$arrUrl['control'] = $arrParam['control'];
		$arrUrl['func'] = $arrParam['func'];
		$arrUrl['msv_id'] = $arrParam['msv_id'];
		$arrUrl['status'] = $arrParam['status'];
		$arrUrl['platform'] = $arrParam['platform'];
		$arrUrl['service_id'] = $arrParam['service_id'];
		$arrUrl['app'] = $arrParam['app'];
		$arrUrl['otp'] = $arrParam['otp'];
		$arrUrl['token'] = $arrParam['token'];*/
        $result = $this->_call_api_thai($arrParam);
		//var_dump($result);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 3000010) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
	public function msv_edit($arrParam) {
		$result = $this->_call_api($arrParam);
		//var_dump($result);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 3000020) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
	public function msv_edit_thai($arrParam) {
		$result = $this->_call_api_thai($arrParam);
		//var_dump($result);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 3000020) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
	public function msv_update_button($arrParam) {
        $result = $this->_call_api($arrParam);
		//var_dump($result);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 3000030) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
	public function msv_update_button_thai($arrParam) {
        $result = $this->_call_api_thai($arrParam);
		//var_dump($result);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 3000030) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
	
    public function msv_approve($params) {
        $params['control'] = 'inside';
        $params['func'] = 'msv_approve';
        $result = $this->_call_api($params);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 3000020) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }

    public function msv_update($params) {
        $params['control'] = 'inside';
        $params['func'] = 'msv_update';
        $result = $this->_call_api($params);
        if (is_array($result) == TRUE) {
            if ($result['code'] == 3000030) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
   

    private function _call_api($params) {
        $get_opt = $this->libtotp->getCode($this->secret_key);
        $params['otp'] = $get_opt;
        $params['app'] = $this->app;
        //$token = $this->make_token($params);
        //$link = $this->url . "/?" . http_build_query($params) . "&token={$token}";
		$link = $this->url . "/?" . http_build_query($params);
        $json = $this->CI->Curl->get($link);
        $data = json_decode($json, TRUE);
        MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'), $link, $json), "{$params['control']}_{$params['func']}_" . date('H'));
        return is_array($data) ? $data : FALSE;
    }
	private function _call_api_thai($params) {
        $get_opt = $this->libtotp->getCode($this->secret_key_thai);
        $params['otp'] = $get_opt;
        $params['app'] = $this->app_thai;
        //$token = $this->make_token($params);
        //$link = $this->url . "/?" . http_build_query($params) . "&token={$token}";
		$link = $this->url_thai . "/?" . http_build_query($params);
        $json = $this->CI->Curl->get($link);
        $data = json_decode($json, TRUE);
        MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'), $link, $json), "Thai {$params['control']}_{$params['func']}_" . date('H'));
        return is_array($data) ? $data : FALSE;
    }

    public function make_token($params) {
        $md5_string = implode('', $params) . $this->secret_key;
        $token = md5($md5_string);
        MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'), 'test token', $md5_string . '-md5:' . $token), "test_token_graph" . date('H'));
        return $token;
    }

    
    /*
     * @date 03/06/2015
     */
    public function create_active_code($params){
        $params['control'] = 'inside';
        $params['func'] = 'create_active_code';                
        $result = $this->_call_api($params);       
        if (is_array($result) == TRUE) {
            if ($result['code'] == 500030) {
                $response['status'] = TRUE;
                $response['data'] = $result['data'];
            } else {
                $response['status'] = FALSE;
            }
            return $response;
        }
        return FALSE;
    }
}
