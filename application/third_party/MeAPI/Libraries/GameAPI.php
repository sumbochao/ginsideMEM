<?php
class GameAPI {
    private $api_url_data = 'http://gapi.mobo.vn/';
    private $service_id = 0;
    private $last_link_request;
    private $api_app = 'game';
    private $api_secret = 'IDpCJtb6Go10vKGRy5DQ';  
    public function get_user_info($service_name, $mobo_service_id, $server_id) {
        //$wallet_info = $this->CI->GameAPI->query_wallet_info('1021488227995350684', 1, '2014-12-04 15:00:00');
        /*
          http://gapi.mobo.vn/?control=game&func=get_game_account_info&mobo_service_id=1061495523104478231&
          server_id=1&service_name=hiepkhach&service_id=107&
          time_stamp=2015-03-17 11:05:00&app=hiepkhach&token=abc
         */
        $time_stamp = date('Y-m-d H:i:s', time());
        $params = array();
        //$params['control'] = 'game';
        //$params['func'] = 'get_game_account_info';
        $params['mobo_service_id'] = $mobo_service_id;
        $params['server_id'] = $server_id;
        $params['service_name'] = $service_name;
        $params['service_id'] = $this->service_id;
        $params['time_stamp'] = $time_stamp;
        $result = $this->call_api($this->api_url_data, "game", "get_game_account_info", $params, '');

        if (!empty($result) && isset($result)) {
            $result = json_decode($result, true);
            if ($result["code"] == 0 && array_key_exists("code", $result)) {
                if(is_string($result["data"])){
                    $data = json_decode($result["data"], true);
                }else{$data = $result["data"];}

                return $this->mapping($data);
            } else {
                return null;
            }
        }
        return null;
    }
    private function call_api($url, $control, $func, $params, $log_file_name = 'call_api') {
        $this->last_link_request = $url . '?control=' . $control . "&func=" . $func . "&" . http_build_query($params) . '&app=' . $this->api_app . '&token=' . md5(implode('', $params) . $this->api_secret);
        //echo $this->last_link_request.'<br>';
        $ch = curl_init();
        //echo $this->last_link_request ;die;
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $result = curl_exec($ch);
        if (!empty($log_file_name)) {
            MeAPI_Log::writeCsv(array($this->last_link_request, $result), $log_file_name);
        }
        return $result;
    }
    function mapping($sources){
        $destination = $sources;
        $characternames = array("role_name", "name");
        $levels = array("level", "lv","role_level");
        $golds = array("gold",'coin');
        $silvers = array("silver");
        $create_times = array("create_time");
        $last_login_times = array("last_login_time");
        $vips = array("vip");
        foreach ($sources as $key => $value) {
           if(in_array($key, $characternames)){
               unset($destination[$key]);
               $destination["character_name"] = $value;
           }
           if(in_array($key, $levels)){
               unset($destination[$key]);
               $destination["level"] = $value;
           }
           if(in_array($key, $golds)){
               unset($destination[$key]);
               $destination["gold"] = $value;
           }
           if(in_array($key, $silvers)){
               unset($destination[$key]);
               $destination["silver"] = $value;
           }
           if(in_array($key, $create_times)){
               unset($destination[$key]);
               $destination["create_time"] = $value;
           }
           if(in_array($key, $last_login_times)){
               unset($destination[$key]);
               $destination["last_login"] = $value;
           }
           if(in_array($key, $vips)){
               unset($destination[$key]);
               $destination["vip"] = $value;
           }
        }
        return $destination;
    }
}