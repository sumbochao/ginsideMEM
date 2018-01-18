<?php
// lay thong tin tra ve mobo service id ei_controller
class InfoMobo{
    private $_control = 'inside';
    private $_getinfo_func = 'search_graph';
    private $_app = 'mobo';
    private $_api_url;
    private $CI;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('GeneralOTPCode');
        if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") {
            $this->_api_url = 'http://graph.mobo.vn/';
        }else{
            $this->_api_url = 'http://graph.mobo.vn/';
        }
    }
    public function get_mobo_account($mobo_id) {
        $otp = GeneralOTPCode::getCode($secret);
        $params['control'] = $this->_control;
        $params['func'] = $this->_getinfo_func;
        $params['app'] = $this->_app;
        $params['otp'] = $otp;
        $params['mobo'] = $mobo_id;
        $needle = array('control', 'func', 'access_token', 'user_agent', 'app', 'otp');
        $params['token'] = md5(implode('', $params) . $this->_key);
        $url = $this->_api_url . '?' . http_build_query($params);
        /*if ($_SERVER['REMOTE_ADDR'] !== "127.0.0.1") {
            $response = '{"code":900000,"desc":"SEARCH_GRAPH_SUCCESS","data":{"114":[{"mobo_id":"128147013","mobo_service_id":"1141502494438423506","fullname":"S\u00e1u Ngh\u0129a","device_id":"e0d97aa278c0faf39c743f1d83121cac02eca72e321dsf","channel":"1|no-cookie","date_create":"2015-05-29 16:05:56","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"}],"108":[{"mobo_id":"128147013","mobo_service_id":"1081501741760312010","fullname":"S\u00e1u Ngh\u0129a","device_id":"1646-e619-0eb1-a8d1-0000-0030-00f0-0ca8","channel":"1|me|1.0.0|File|msv_1_file","date_create":"2015-05-21 08:42:26","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"}],"107":[{"mobo_id":"128147013","mobo_service_id":"1071500395737754192","fullname":"S\u00e1u Ngh\u0129a","device_id":"1646-e619-0eb1-a8d1-0000-0030-00f0-0ca8","channel":"1|me|1.0.0|File|msv_1_file","date_create":"2015-05-06 12:15:54","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"},{"mobo_id":"128147013","mobo_service_id":"1071500395973232102","fullname":"S\u00e1u Ngh\u0129a","device_id":"1646-e619-0eb1-a8d1-0000-0030-00f0-0ca8","channel":"1|me|1.0.0|File|msv_1_file","date_create":"2015-05-06 12:15:55","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"}],"106":[{"mobo_id":"128147013","mobo_service_id":"1061495878891844701","fullname":"S\u00e1u Ngh\u0129a","device_id":"34cf08865d7ed7495a322ba23c0afd8d9b0e6482","channel":"1|me|1.0.2|Ent|msv_1","date_create":"2015-03-17 15:34:39","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"}],"105":[{"mobo_id":"128147013","mobo_service_id":"1051490237959950717","fullname":"S\u00e1u Ngh\u0129a","device_id":"1646-e619-0eb1-a8d1-0000-0030-00f0-0ca8","channel":"empty","date_create":"2015-01-14 09:12:35","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"},{"mobo_id":"128147013","mobo_service_id":"1051496965128263014","fullname":"Giang H\u1ed3","device_id":"3c534d15cdbd360b353483a8c1f044e4b3886b6c","channel":"2|me|1.0.4|Appstore|msv_2","date_create":"2015-03-29 15:19:55","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"}],"103":[{"mobo_id":"128147013","mobo_service_id":"1031488979058916215","fullname":"S\u00e1u Ngh\u0129a","device_id":"2b18-d5b3-6a4e-3e4f-9f6c-0c17-a1c8-bfc6","channel":"1|mobo|1.0.0","date_create":"2014-12-31 11:43:08","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"}],"102":[{"mobo_id":"128147013","mobo_service_id":"1021492806371063290","fullname":"server 2","device_id":"933957fe427b847ce321c53f4878044012b25577","channel":"2|me|2.0.3|Appstore","date_create":"2015-02-11 17:35:52","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"},{"mobo_id":"128147013","mobo_service_id":"1021492771838807056","fullname":"S\u00e1u Ngh\u0129a","device_id":"933957fe427b847ce321c53f4878044012b25577","channel":"2|me|2.0.3|Appstore","date_create":"2015-02-11 08:27:00","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"}],"101":[{"mobo_id":"128147013","mobo_service_id":"1011489789116512995","fullname":"S\u00e1u Ngh\u0129a","device_id":"34cf08865d7ed7495a322ba23c0afd8d9b0e6482","channel":"3|me|1.0.0","date_create":"2015-01-09 10:18:36","status":"actived","phone":"0909968087","facebook_id":null,"facebook_orgin_id":"","status_mobo":"actived"}]},"message":"SEARCH_GRAPH_SUCCESS"}';
        } else {
            $response = $this->get($url);
        }*/
        $response = $this->get($url);
        return json_decode($response, TRUE);
    }

    public function parse_mobo($data, $service_id = "") {
        if ($data["code"] == 900000) {
            if (empty($service_id))
                return $data["data"];
            else
                return $data["data"][$service_id];
        }
        return null;
    }

    public function get($url) {
        if (empty($url)) {
            return false;
        }
        return $this->request('GET', $url, 'NULL');
    }
    private function request($method, $url, $vars) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER["REMOTE_ADDR"]);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->followlocation);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);
        //curl_setopt($ch, CURLOPT_COOKIEJAR, $this->pathcookie);
        //curl_setopt($ch, CURLOPT_COOKIEFILE, $this->pathcookie);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        }
        $data = curl_exec($ch);
        
        curl_close($ch);
        if ($data) {
            return $data;
        } else {
            return @curl_error($ch);
        }
    }
}