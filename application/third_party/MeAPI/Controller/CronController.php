<?php

class MeAPI_Controller_CronController implements MeAPI_Controller_CronInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->MeAPI_Library('Meemail');
        $this->CI->load->MeAPI_Library('Logs');


        $this->CI->load->library('cache');

        $this->CI->config->load('admin');
        $this->admin_config = $this->CI->config->item('admin');
    }

    public function newRegisterMobo(MeAPI_RequestInterface $request) {
        $params = $request->input_request();
        $this->CI->load->MeAPI_Model('MoboModel');

        $this->_default_date = $params['cron_date'] ? $params['cron_date'] : date('Y-m-d');
        $this->_default_start_time = intval((strtotime(date('Y-m-d')) - strtotime($this->_default_date)) / 86400) + 1;

        if ($this->_default_start_time <= 0) {
            $this->_default_start_time = 1;
        }

        /*
         * NRU Account
         */
        try {
            $Temp_NRU_Account = $this->CI->MoboModel->getNewRegGameAccount($this->_default_start_time);
            if (!empty($Temp_NRU_Account)) {
                foreach ($Temp_NRU_Account as $value) {
                    $NRU_account['account'][$value['username']] = $value['username'];
                    $NRU_account['provider'][$value['provider']]++;
                    $NRU_account['total']++;
                }
            }
        } catch (Exception $exc) {
            $msg['content'] .= $exc->getTraceAsString() . '<hr />';
        }
        $NRU_MOBOAccount = $this->CI->MoboModel->getNewRegMoboAccount($this->_default_start_time);
        $TRU_MOBOAccount = $this->CI->MoboModel->getTRUMoboAccount($this->_default_start_time);
        $TRU_GameAccount = $this->CI->MoboModel->getTRUGameAccount($this->_default_start_time);

        
        
        $result['NRU_MOBO']['total'] = array_sum($NRU_MOBOAccount);
        $result['NRU_MOBO']['provider'] = $NRU_MOBOAccount;
        
        $result['TRU_GA']['total'] = array_sum($TRU_GameAccount);
        $result['TRU_GA']['provider'] = $TRU_GameAccount;

        $result['TRU_MOBO']['total'] = array_sum($TRU_MOBOAccount);
        $result['TRU_MOBO']['provider'] = $TRU_MOBOAccount;

        $this->_response = new MeAPI_Response_APIResponse($request, 'CRON_NEWREGISTERMOBO');
    }

    public function activeMobo(MeAPI_RequestInterface $request) {
        $params = $request->input_request();

        $this->CI->load->MeAPI_Model('MoboModel');

        $this->_default_date = $params['cron_date'] ? $params['cron_date'] : date('Y-m-d');
        $this->_default_start_time = intval((strtotime(date('Y-m-d')) - strtotime($this->_default_date)) / 86400) + 1;

        if ($this->_default_start_time <= 0) {
            $this->_default_start_time = 1;
        }
        try {
            $data['GA_A1'] = $this->CI->MoboModel->getActiveMoboGameAccount(1, $this->_default_start_time);
            $data['GA_A7'] = $this->CI->MoboModel->getActiveMoboGameAccount(7, $this->_default_start_time);
            $data['GA_A30'] = $this->CI->MoboModel->getActiveMoboGameAccount(30, $this->_default_start_time);

            $data['MOBO_A1'] = $this->CI->MoboModel->getActiveMoboAccount(1, $this->_default_start_time);
            $data['MOBO_A7'] = $this->CI->MoboModel->getActiveMoboAccount(7, $this->_default_start_time);
            $data['MOBO_A30'] = $this->CI->MoboModel->getActiveMoboAccount(30, $this->_default_start_time);
        } catch (Exception $exc) {
            $send_mail_str .= $exc->getTraceAsString();
        }

        ////////// Send Mail to Tech & NOC
        if (!empty($send_mail_str)) {
            $msg['content'] = $send_mail_str;
            $this->CI->Meemail->sendMail($msg);
        }

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                foreach ($value as $k => $v) {
                    $k = str_replace(array('test', "", 'null'), 0, $k);
                    if (empty($k))
                        $k = 0;
                    $result[$key]['total'] += $v;
                    $result[$key]['provider'][$k] += $v;
                }
            }

            try {
                ////////////// Put logs
                $this->CI->Logs->putlogs($this->admin_config['logs'], "active_user_{$this->admin_config['inside']['app']}", $result);
            } catch (Exception $exc) {
                $msg['content'] = $exc->getTraceAsString();
                $this->CI->Meemail->sendMail($msg);
            }
        }
        $this->_response = new MeAPI_Response_APIResponse($request, 'CRON_ACTIVEMOBO');
    }

    public function activeCharacter(MeAPI_RequestInterface $request) {
        $this->_response = new MeAPI_Response_APIResponse($request, 'CRON_ACTIVECHARACTER');
    }

    public function activeGameAccount(MeAPI_RequestInterface $request) {
        
    }

    public function inactiveCharacter(MeAPI_RequestInterface $request) {
        
    }

    public function newRegisterGameAccount(MeAPI_RequestInterface $request) {
        
    }

    public function newRegisterCharacter(MeAPI_RequestInterface $request) {
        
    }

    public function CCU(MeAPI_RequestInterface $request) {
        
    }

    public function payment(MeAPI_RequestInterface $request) {
        
    }

    public function download(MeAPI_RequestInterface $request) {
        
    }

    public function topLevel(MeAPI_RequestInterface $request) {
        
    }

    public function getResponse() {
        return $this->_response;
    }

}