<?php

/*
  Developed by Luctt on 10 May 2010
  Class ID Valide
 */

class SnsValidate {

    public function isEmail($email) {
        if (preg_match('/^[_a-z0-9]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
            return TRUE;
        }
        return FALSE;
    }

    public function isFullname($fullname) {
        return strlen($fullname) > 2 && strlen($fullname) < 200;
    }

    public function isValidAccount($account, $min = 6, $max = 20) {
        $pattern = '/^[a-zA-Z0-9]{' . $min . ',' . $max . '}$/';
        if (preg_match($pattern, $account)) {
            return TRUE;
        }
    }

    public function isExist($value=null) {
        return $value != null && trim($value) != '';
    }

    public function isDigit($value) {
        if (preg_match('/^[0-9]+$/', $value)) {
            return TRUE;
        }
        return FALSE;
    }
    
    public function isNumber($value) {
        if (is_numeric($value)) {
            return TRUE;
        }
        return FALSE;
    }

    public function validLen($str, $min, $max) {
        return (strlen($str) >= $min) && (strlen($str) <= $max);
    }

    public function isUserName($username, $min = 6, $max = 20) {
        $pattern = '/^[a-zA-Z0-9]{' . $min . ',' . $max . '}$/';
        if (preg_match($pattern, $username)) {
            return TRUE;
        }
        return FALSE;
    }

    public function isEmailRFC($value) {
        $oValidate_NotEmpty = new Zend_Validate_NotEmpty();
        $oValidate_StringLength = new Zend_Validate_StringLength();
        $oValidate_StringLength->setMax(100);
        $_options = array(
            'mx' => FALSE,
            'deep' => FALSE,
            'breakChainOnFailure' => FALSE,
            'domain' => FALSE,
            'hostname' => NULL
        );
        $oValidate_EmailAddress = new Zend_Validate_EmailAddress($_options);
        $aValidators = array(
            'email' => array($oValidate_NotEmpty, $oValidate_StringLength, $oValidate_EmailAddress, 'breakChainOnFailure' => TRUE)
        );
        $aData = array('email' => trim($value));
        $aFilter = array();
        $oFilterInput = new Zend_Filter_Input($aFilter, $aValidators, $aData);
        if ($oFilterInput->hasInvalid() === FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * parse check Date
     * Created by Luctt
     * @param string Date dd-mm-yyyy
     * @return Boolean
     */
    public function checkDate($sInput, $bCurrentDate = TRUE, $sDeter = '-') {
        if ($sInput) {
            $aTemp = ($sInput) ? explode('-', $sInput) : array();
            if (count($aTemp) > 2) {
                $day = $aTemp[0];
                $month = $aTemp[1];
                $year = $aTemp[2];
                if (checkdate(intval($month), intval($day), intval($year)) && (strlen($month) == 2) && (strlen($day) == 2) && (strlen($year) == 4) && (intval($year) >= 1900)) {
                    if ($bCurrentDate) {
                        if (intval($year) >= 1970) {
                            if (intval($year) <= date("Y")) {
                                $iNow = time();
                                $iBirthday = mktime(0, 0, 0, $month, $day, $year);
                                if ($iBirthday < $iNow) {
                                    return TRUE;
                                } else {
                                    return FALSE;
                                }
                            }
                        } else {
                            return TRUE;
                        }
                    } else {
                        return TRUE;
                    }
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function validPassword($password) {
        return (strlen($password) >= 6);
    }

    public function validCaptcha($captcha) {
        $session = Zend_Registry::get('session');
        return $captcha == $session->captcha;
    }

    public function validGroup($arr) {
        
        foreach ($arr as $key => $value) {
            foreach ($value as $k => $v) {
                if (preg_match('/\|/is', $key)) {
                    $arr_valid  =   explode('|',$key);
                    foreach($arr_valid as   $k2=>$v2){
                        $error[$k]  .=   $this->checkvalid($v2, $k, $v) ;
                    }
                } else {
                        $error[$k]  .=   $this->checkvalid($key, $k, $v);
                }
            }
        }
        
        if(is_array($error))
            foreach($error as   $key=>$value){
                if(!empty($value)){
                    $error[$key]  = substr($value, 0, -1);
                }else{
                    unset($error[$key]);
                }
            }
        
        return $error;
    }

    public function checkvalid($key, $k, $v) {
        
        $str_valid['isExist'] = ' không được để trống';
        $str_valid['isDigit'] = ' phải là số 0->9';
        $str_valid['isNumber'] = ' phải là số ';
        $str_valid['validLen_1'] = ' chỉ cho phép từ ';
        $str_valid['validLen_2'] = ' đến ';
        $str_valid['validLen_3'] = ' ký tự ';
        
        $str_valid['isUserName_1'] = ' chỉ cho phép từ ';
        $str_valid['isUserName_2'] = ' đến ';
        $str_valid['isUserName_3'] = ' ký tự ';
        
        $str_valid['isValidAccount_1'] = ' chỉ cho phép từ ';
        $str_valid['isValidAccount_2'] = ' đến ';
        $str_valid['isValidAccount_3'] = ' ký tự ';
        
        
        if ($key == 'validLen' || $key=='isUserName' || $key=='isValidAccount') {
            if (!$this->$key($v['key'], $v['min'], $v['max'])) {
                $error = $this->errSpan(ucfirst(str_replace('_', ' ', $k)) . $str_valid[$key.'_1'] . $v['min'] . $str_valid[$key.'_2'] . $v['max'] . $str_valid[$key.'_3']). ' ,';
            }
        } else {
            if (!$this->$key($v)) {
                $error = $this->errSpan(ucfirst(str_replace('_', ' ', $k)) . $str_valid[$key]). ' ,';
            }
        }
        return $error;
    }
    public function errSpan($msg) {
        return <<<EOF
        <span class="error_string">$msg</span>
EOF;
    }
    public function errDiv($msg) {
        return <<<EOF
        <div class="signup-error">
            <div class="fieldWithErrors">$msg<br>
            </div>
            </div>
EOF;
    }

}
