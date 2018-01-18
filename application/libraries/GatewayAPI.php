<?php

class GatewayAPI {

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api_url = 'http://sms.gateway.gomobi.vn:7777/';
    private $api_app = '12';
    private $api_secret = '';
    private $last_link_request;

    function __construct() {
        $this->CI = & get_instance();
    }

    public function send_mt($phone, $service, $message, $transaction = NULL, $telco = NULL, $type = 0) {
        if (empty($transaction) === TRUE)
            $transaction = time() . rand(1000, 9999);
        $this->CI->load->helper('phone');
        if (empty($telco) === TRUE) {
            $telco = get_telco_by_phone($phone);
            $telco = str_replace(array('mobifone', 'vinaphone'), array('mobi', 'vina'), $telco);
        }
        if (!in_array($telco, array('mobi', 'vina', 'viettel')))
            return FALSE;
        $token = md5($telco . $service . $phone . $message . $type . $this->api_app . $transaction . $this->api_secret);
        $url = $this->api_url . 'SMS_API_Outside/partner/mt_spam/send?telco=' . $telco . '&serviceNum=' . $service . '&phone=' . $phone . '&message=' . urlencode($message) . '&msgType=0&sendingTime=&partnerID=' . $this->api_app . '&requestID=' . urlencode($transaction) . '&token=' . $token;
        $result = $this->_call_api($url);
        if ($result == 0) {
            return TRUE;
        }
        return FALSE;
    }

    private function _call_api($url) {
        $this->CI->benchmark->mark('api_iwin_start');
        $this->last_link_request = $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $result = curl_exec($ch);
        $this->CI->benchmark->mark('api_iwin_end');
        MeAPI_Log::writeCsv(array($url,$this->CI->benchmark->elapsed_time('api_iwin_start', 'api_iwin_end')), 'Gateway');
        return $result;
    }

}

?>
