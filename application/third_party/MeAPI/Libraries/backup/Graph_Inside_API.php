<?php

class Graph_Inside_API {

    /**
     * @var CI_Controller
     */
    private $CI;
    private $url = 'http://graph.mobo.vn';
    protected $secret_key = 'TWVHQDNSVXDEHVNN';
    private $app = 'ginside';
	private $libcurl;
	private $libtotp;
    public function __construct() {
        $this->CI = & get_instance();
		$this->libcurl=new curl();
		$this->libtotp=new TOTP();
    }
	
	public function get_Secretkey() {
		return $this->secret_key;
    }
	public function get_param_url($arr_param){
		if(is_array($arr_param)){
			return $arr_param;
		}else{
			return false;
		}
	}
	public function get_otp(){
		$otp=$this->libtotp->getCode($this->get_Secretkey());
		return $otp;
	}
	public function view_msv($url_param){
		$json=$this->libcurl->get($this->url ."/?". $url_param);
		$data=json_decode($json,TRUE);
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
