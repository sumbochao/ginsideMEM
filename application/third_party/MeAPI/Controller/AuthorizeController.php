<?php
class MeAPI_Controller_AuthorizeController implements MeAPI_Controller_AuthorizeInterface {

    protected $_response;
    private $CI;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
    }
	public function checkPermisstion(MeAPI_RequestInterface $request){
        //phan quyen truy cap
        $params = $request->input_request();
        $account = $this->CI->Session->get_session('account');
        $permission = $this->CI->Session->get_session('permission');
		if (count($account) > 0 && ($account['id_group'] == 2 || $account['id_group'] == 3)) {
            if (isset($params['control']) && isset($params['module']) && isset($params['game'])) {
                if (!in_array($params['control'] . '-' . $params['module']. '-' . $params['game'], $permission)) {
                    header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');die();
                }
            }else{
                if (isset($params['control']) && isset($params['module'])) {
                    if (!in_array($params['control'] . '-' . $params['module'], $permission)) {
                        header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');die();
                    }
                }else{
                    if (isset($params['control']) && isset($params['func']) && isset($params['game'])) {//phan quyen tren tham so la game
                        if (!in_array($params['control'] . '-' . $params['func'] . '-' . $params['game'], $permission)) {
                            header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');die();
                        }
                    } else {
                        if (isset($params['control']) && isset($params['func'])) {// phan quyen controller, action bo cac param phia sau
                            if (!in_array($params['control'] . '-' . $params['func'], $permission)) {
                                header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');die();
                            }
                        }
                    }
                }
            }
        }
    }
    public function validateAuthorizeRequest(MeAPI_RequestInterface $request, $require_permission = 1) {
        $params = $request->input_request();
        $account = $this->CI->Session->get_session('account');
        $menu = $this->CI->Session->get_session('menu');
        $login_url = $this->CI->config->base_url('?control=login&func=index');
        if (empty($account) === TRUE) {
            echo("<script> top.location.href='" . $login_url . "'</script>");
            exit;
        }
        if ($require_permission != 0) {
            $check = $menu['default'][$params['control']][$params['func']];
            if (empty($check) === TRUE) {
                echo("<script> top.location.href='" . $login_url . "'</script>");
                exit;
            }
        }

        return TRUE;
    }

    public function validateAuthorizeApi(MeAPI_RequestInterface $request) {
        $mykey = 'bT!@$75CwAcD5O7ik80nLA4';
        $params = $request->input_request();
        /*
         * Check IP
         */
        /*$arr_host = array('123.30.104.14', '127.0.0.1');
        if (in_array($_SERVER['REMOTE_ADDR'], $arr_host) === FALSE) {
            return FALSE;
        }*/
        $token = $params['token'];
        if (empty($token)) {
            return FALSE;
        }
        unset($params['control'], $params['func'], $params['token']);
        /*
         * Build token
         */
        $mytoken = md5(implode('', $params) . $mykey);
        /*
         * Check Token
         */
        if ($mytoken != $token) {
            return FALSE;
        }

        return TRUE;
    }

    private function _check_ips($ip) {
        $ip = strtolower($ip);

        return FALSE;
    }

    public function getResponse() {
        return $this->_response;
    }
    public function validateAuthorizeMenu(MeAPI_RequestInterface $request) {
              
        $flag = FALSE;
        $user_info = $this->CI->Session->get_session('account');
                        
        if ($user_info === FALSE) {
            $flag = FALSE;
        }
        $uri = $_SERVER["QUERY_STRING"];
        
        $menu_list = $this->CI->Session->get_session('menu');
        if (empty($menu_list)) {
            $flag = FALSE;
        } else {
            if ($uri == 'control=welcome&func=index') {
                $flag = TRUE;
            }
			
            foreach ($menu_list as $items) {
                foreach ($items as $item) {
                    $str = '?'.$uri;
					if(isset($item['subtree']) && !empty($item['subtree'])){
						foreach ($item['subtree'] as $item_sub) {
							if(strpos($str,$item_sub['relative_url']) !== false){
								$flag = TRUE;
							}
						}
					}elseif(strpos($str,$item['relative_url']) !== false){
                        $flag = TRUE;
                    }
                }
            }
        }



        if ($flag === FALSE) {
            $url = $this->CI->config->base_url('?control=welcome&func=index');
            //echo("<script> top.location.href='" . $url . "'</script>");
            redirect($url);
            exit;
        }
    }
}

?>
