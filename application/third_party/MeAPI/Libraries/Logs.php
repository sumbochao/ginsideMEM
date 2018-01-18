<?php

class Logs {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Model('LogsModel');
    }

    /*
     * Thêm logs mỗi ngày
     */
    public function putlogs($table, $name, $data, $time = false) {

        if (empty($time))
            $time = date("Y-m-d", strtotime("-1 day"));

        $check = $this->CI->LogsModel->getLatestLogs($table, $name, $time);
        if (empty($check)) {
            return $this->CI->LogsModel->saveLogs($table, $name, json_encode($data, true), $time);
        } else {
            return $this->CI->LogsModel->UpdateLogs($table, $name, json_encode($data, true), $check['id']);
        }
    }

    /*
     * Thêm logs mỗi giờ
     */
    public function putlogsCurrentHour($table, $name, $data, $time = false) {
        if (empty($time))
            $time = date("Y-m-d H:i:s");
        try {
            $check = $this->CI->LogsModel->getLatestLogsHour($table, $name, $time);
            if (!$check) {
                return $this->CI->LogsModel->saveLogs($table, $name, json_encode($data, true), $time);
            } else {
                return $this->CI->LogsModel->UpdateLogs($table, $name, json_encode($data, true), $check['id']);
            }
        } catch (Exception $exc) {
            $msg['content'] = $exc->getTraceAsString();
            $this->_sendmail_tech($msg);
        }
    }

    public function getlogs($table, $name, $time = false) {

        try {
            $data = $this->CI->LogsModel->getLatestLogs($table, $name, $time);
            if (!empty($data)) {
                return $data;
            }
        } catch (Exception $exc) {
            $msg['content'] = $exc->getTraceAsString();
            $this->_sendmail_tech($msg);
        }
        return false;
    }

    public function getlogsHour($table, $name, $time = false) {

        try {
            $data = $this->CI->LogsModel->getLatestLogsHour($table, $name, $time);
            if (!empty($data)) {
                return $data;
            }
        } catch (Exception $exc) {
            $msg['content'] = $exc->getTraceAsString();
            $this->_sendmail_tech($msg);
        }
        return false;
    }

    public function getListLogs($table, $name, $time = false) {
        try {
            $data = $this->CI->LogsModel->getAll_Logs_byTime($table, $name, $time);
            if (!empty($data)) {
                return $data;
            }
        } catch (Exception $exc) {
            $msg['content'] = $exc->getTraceAsString();
            $this->_sendmail_tech($msg);
        }
        return false;
    }

}