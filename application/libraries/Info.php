<?php
class Info {

    public function extractparam($params)
    {
        $datadecode = json_decode(base64_decode($params["access_token"]), true);
        $userdata = json_decode($params["info"], true);
        $character_id = $userdata["character_id"];
        $character_name = $userdata["character_name"];
        $server_id = $userdata["server_id"];
        $mobo_service_id = $datadecode["mobo_service_id"];
        $mobo_id = $datadecode['mobo_id'];
        return array('mobo_id'=>$mobo_id, 'mobo_service_id' => $mobo_service_id, 'server_id' => $server_id, 'character_id' => $character_id, 'character_name' => $character_name);
    }

    function checksign($params)
    {
        $token = trim($params['token']);
        unset($params['token']);
        $valid = md5(implode('', $params) . $this->config->item("oauth_key"));
        $_SESSION["oauthtoken"] = base64_encode(json_encode($params));
        $_SESSION["redirect"] = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        if ($valid != $token) {
            return false;
        }
        return true;
    }

    function proper_parse_str($str)
    {
        # result array
        $arr = array();
        # split on outer delimiter
        $pairs = explode('&', $str);
        # loop through each pair
        foreach ($pairs as $i) {
            # split into name and value
            list($name, $value) = explode('=', $i, 2);

            # if name already exists
            if (isset($arr[$name])) {
                # stick multiple values into an array
                if (is_array($arr[$name])) {
                    $arr[$name][] = $value;
                } else {
                    $arr[$name] = array($arr[$name], $value);
                }
            } # otherwise, simply stick it in a scalar
            else {
                $arr[$name] = urldecode($value);
            }
        }
        # return result array
        return $arr;
    }

    function identical_values($arrayA, $arrayB)
    {
        sort($arrayA);
        sort($arrayB);
        return $arrayA == $arrayB;
    }
    function stripUnicode($sStr){
        if(!$sStr)
            return false;
        $aUnicode = array(
            'a'=>'á|à|?|ã|?|a|?|?|?|?|?|â|?|?|?|?|?',
            'A'=>'Á|À|?|Ã|?|A|?|?|?|?|?|Â|?|?|?|?|?',
            'd'=>'d',
            'D'=>'Ð',
            'e'=>'é|è|?|?|?|ê|?|?|?|?|?',
            'E'=>'É|È|?|?|?|Ê|?|?|?|?|?',
            'i'=>'í|ì|?|i|?',
            'I'=>'Í|Ì|?|I|?',
            'o'=>'ó|ò|?|õ|?|ô|?|?|?|?|?|o|?|?|?|?|?',
            'O'=>'Ó|Ò|?|Õ|?|Ô|?|?|?|?|?|O|?|?|?|?|?',
            'u'=>'ú|ù|?|u|?|u|?|?|?|?|?',
            'U'=>'Ú|Ù|?|U|?|U|?|?|?|?|?',
            'y'=>'ý|?|?|?|?',
            'Y'=>'Ý|?|?|?|?'
        );
        foreach($aUnicode as $key=>$value){
            $aValue = explode("|",$value);
            $sStr = str_replace($aValue,$key,$sStr);
        }
        return $sStr;
    }
    function insert_remove_accents($string) {

        if(is_array($string))
            $str=$string["string"];
        else
            $str=$string;

        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);

        $str = trim($str);
        $RemoveChars  = array( "([\40])" , "([^a-zA-Z0-9-])", "(-{2,})" );
        $ReplaceWith = array("-", "", "-");
        $str =preg_replace($RemoveChars, $ReplaceWith, $str);
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));

        return strtolower($str);
    }
    function changeTitle($sStr){
        //$sStr = $this->stripUnicode($sStr);
        $sStr = $this->insert_remove_accents($sStr);
        $sStr = mb_convert_case($sStr,MB_CASE_LOWER,'utf-8');
        $sStr = trim($sStr);
        /*
        $sStr = str_replace(array('-','?','&',"'", ":", '“', '”', '"', '!', '@', '#', '$', '%', '*', '(', ')', '<', '>', '/', ';', '{', '}', '[', ']', '|', '+', '=', ','),'',$sStr);
        $sStr = str_replace('   ','-',$sStr);
        $sStr = str_replace('  ','-',$sStr);
        $sStr = str_replace(' ','-',$sStr);
        */
        return $sStr;
    }


}
?>