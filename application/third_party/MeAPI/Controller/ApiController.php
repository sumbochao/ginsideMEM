<?php
class MeAPI_Controller_ApiController implements MeAPI_Controller_ApiInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;
    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $mykey = 'bT!@$75CwAcD5O7ik80nLA4';
    public function __construct() {
        $this->CI = & get_instance();
        //$this->CI->load->library('cache');
       // $this->CI->load->MeAPI_Library('Session');
		
		/*if ($_SERVER['PHP_AUTH_USER'] != 'bth' OR $_SERVER['PHP_AUTH_PW'] != 'admin') {
			header('WWW-Authenticate: Basic realm="Vui long nhap ten nguoi dung & mat khau"');
			header('HTTP/1.0 401 Unauthorized');
			echo "Access Denied";
			die;
		}*/
    }
    function Decrypt($input, $key_seed) 
    { 
        $input = base64_decode($input); 
        $key = substr(md5($key_seed),0,24); 
        $text=mcrypt_decrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB,'12345678'); 
        $block = mcrypt_get_block_size('tripledes', 'ecb'); 
        $packing = ord($text{strlen($text) - 1}); 
        if($packing and ($packing < $block)){ 
          for($P = strlen($text) - 1; $P >= strlen($text) - $packing; $P--){ 
           if(ord($text{$P}) != $packing){ 
            $packing = 0; 
           }
          }
        }
        $text = substr($text,0,strlen($text) - $packing); 
        return $text; 
    }
    public function apilogin(MeAPI_RequestInterface $request) {
        $authorize = new MeAPI_Controller_AuthorizeController();
        if ($authorize->validateAuthorizeApi($request) == TRUE) {
            $params = $request->input_request();
            $request_ip = $_SERVER['HTTP_REFERER'];
            //$account = $this->CI->Session->get_session('account');
            if (is_required($params, array('username','password','token')) == TRUE) {
                    /*
                     * Lấy thông tin account từ db inside
                     */
                    $this->CI->load->MeAPI_Model('UserModel');
                    $account = $this->CI->UserModel->get_account($params['username']);
                    if (empty($account) === FALSE && $account['status'] == TRUE) {
                        /*
                         * kiểm tra xem user đó có quyền xem app này hay không và có menu hay không và ip có hợp lệ hay không
                         */
                        // những request app được cho phép
                        $this->CI->load->MeAPI_Model('MenuModel');
                        $cateory = $this->CI->MenuModel->getMenuApi($account['id'],3,$params['app']);
                        $strApp =array();
                        if(empty($cateory)=== FALSE)
                        foreach ($cateory as $key => $value) {
                            $strApp[] = strtolower($value['display_name']);
                        }
                        $check_app = $this->_check_app($params['app'], $strApp);
                        $ip = $this->_check_ips($account['ips']);
                        if (empty($check_app) === FALSE && empty($ip) === FALSE ) {
                            unset($account['password']);
                            //write to check time and author access at time
                            //check ldap co trong csdl nhung khong co trong ldap thi false
                            /*
                             *Chung thuc bang LDAP
                             */
                            $username = $params['username'];
                            $password = $this->Decrypt($params['password'],$this->mykey);
                            $hostname = 'webmail.mecorp.vn:389';
                            
                            
                            $con =  ldap_connect($hostname);
                            if (!is_resource($con)) trigger_error("Unable to connect to $hostname",E_USER_WARNING);
                            ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
                            ldap_set_option($con, LDAP_OPT_REFERRALS, 0);
                            if (@ldap_bind($con,'mecorp\\'.$username, $password))
                            {
                                // Logged in
                                /*
                                 * Lấy thông tin account từ db inside
                                 */
                                //chung thuc thanh cong
                                //get permission for website local
                                $getPermistion = $this->CI->MenuModel->getMenuApi2($account['id'],3,$params['app']);
								
                                $account['category'] = $getPermistion;
                                return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS' , $account);
                              
                            }else{
                                // Không tìm thấy thông tin đăng nhập
                                //chung thuc ldap falied
                               return $this->_response = new MeAPI_Response_APIResponse($request, 'LOGIN_INVALID_ACCOUNT');
                            }
                            ldap_close($con);
                            
                            //default ldap 
                            return $this->_response = new MeAPI_Response_APIResponse($request, 'LOGIN_INVALID_ACCOUNT');
                        } else {
                            /*
                             * Không có quyền xem đăng nhập
                             */
                            $this->_response = new MeAPI_Response_APIResponse($request, 'PERMISSION_DENY_LDAP');
                        }
                    }else{
                        //chua kich hoat tren inside
                        $this->_response = new MeAPI_Response_APIResponse($request, 'PERMISSION_DENY');
                    }

                } else {
                    /*
                     * Token không hợp lệ
                     */
                    $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
                }
            return FALSE;
        }else{
            $this->_response = new MeAPI_Response_APIResponse($request, 'LOGIN_INVALID_ACCOUNT');
        } //end valitionauthor
        
    }

    public function apiloginauthen(MeAPI_RequestInterface $request) {
        $authorize = new MeAPI_Controller_AuthorizeController();
        if ($authorize->validateAuthorizeApi($request) == TRUE) {
            $params = $request->input_request();
            $request_ip = $_SERVER['HTTP_REFERER'];
            //$account = $this->CI->Session->get_session('account');
            if (is_required($params, array('username','password','token')) == TRUE) {
                    /*
                     * Lấy thông tin account từ db inside
                     */
                        /*
                         * kiểm tra xem user đó có quyền xem app này hay không và có menu hay không và ip có hợp lệ hay không
                         */
                        // những request app được cho phép
                        
                      
                            $username = $params['username'];
                            $password = $this->Decrypt($params['password'],$this->mykey);
                            $hostname = 'webmail.mecorp.vn:389';
                            
                            
                            $con =  ldap_connect($hostname);
                            if (!is_resource($con)) trigger_error("Unable to connect to $hostname",E_USER_WARNING);
                            ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
                            ldap_set_option($con, LDAP_OPT_REFERRALS, 0);
                            if (@ldap_bind($con,'mecorp\\'.$username, $password))
                            {
                                // Logged in
                                /*
                                 * Lấy thông tin account từ db inside
                                 */
                                //chung thuc thanh cong
                                //get permission for website local
                                /*
                                $filter="(sAMAccountName=hiennv)";
                                $result = ldap_search($con,"dc=MYDOMAIN,dc=COM",$filter);

                                $info = ldap_get_entries($con, $result);
                                */
                                return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
                              
                            }else{
                                // Không tìm thấy thông tin đăng nhập
                                //chung thuc ldap falied
                               return $this->_response = new MeAPI_Response_APIResponse($request, 'LOGIN_INVALID_ACCOUNT');
                            }
                            ldap_close($con);
                            
                            //default ldap 
                            return $this->_response = new MeAPI_Response_APIResponse($request, 'LOGIN_INVALID_ACCOUNT');
                } else {
                    /*
                     * Token không hợp lệ
                     */
                    $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
                }
            return FALSE;
        }else{
            $this->_response = new MeAPI_Response_APIResponse($request, 'LOGIN_INVALID_ACCOUNT');
        } //end valitionauthor
        
    }

    public function index(MeAPI_RequestInterface $request) {
		
    }

    public function getResponse() {
        return $this->_response;
    }

    private function _check_app($app, $admin_config) {
        if (empty($app) === FALSE) {
            if (in_array($app,$admin_config)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function _check_ips($ip) {
        $ip = strtolower($ip);
        if ($ip == 'all') {
            return TRUE;
        } else {
            $user_IP = $_SERVER['REMOTE_ADDR'];
            $allow_IP = explode(',', $ip);
            if (in_array($user_IP, $allow_IP) == TRUE || in_array('all', $allow_IP) == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function _check_time($start, $end) {
        if (isset($start) && isset($end)) {
            $hour = date('G', time());
            if ($start <= $hour && $end >= $hour) {
                return TRUE;
            }
        } else {
            return TRUE;
        }
        return FALSE;
    }

}