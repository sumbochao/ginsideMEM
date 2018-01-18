<?php
class MeAPI_Config_ResponseCode {

    public static function getCode() {
        return array(
            'INVALID_PARAMS' => -1,
            'INVALID_REMOTE_SERVER' => -2,
            'PERMISSION_DENY' => -3,
            'INVALID_TOKEN' => -4,
            
            'LOGIN_SUCCESS' => 1000,
            'LOGIN_INVALID_ACCOUNT' => 1000,
            'LOGIN_WRONG_CAPTCHA' => 1001,
            'SUCCESS' => 1000,
			"FALIED" => 10002,
			"EXIXTS"=>10003
        );
    }

}