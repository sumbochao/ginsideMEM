<?php

class Meemail {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('email');
    }

    public function sendMail($msg = FALSE) {
        return false;
        if (empty($msg) === TRUE) {
            return FALSE;
        }
        $this->CI->config->load('admin');

        $this->CI->load->MeAPI_Model('EmailModel');

        $admin_config = $this->CI->config->item('admin');

        /*
         * Lấy danh sách email từ inside
         */

        $email_info = $this->CI->EmailModel->getListMail('GMInside.' . $admin_config['inside']['app']);
        if (empty($email_info)) {
            $arr_mail = array('khoapm@MECORP.VN', 'huylbt@MECORP.VN');
            $subject = 'INSIDE ' . $msg['subject'];
            $content = $msg['content'];
        } else {
            $email = array_map("trim", explode("\n", $email_info['email']));

            if (!in_array('khoapm@mecorp.vn', $email)) {
                $email[] = 'khoapm@mecorp.vn';
            }
            if (!in_array('huylbt@mecorp.vn', $email)) {
                $email[] = 'huylbt@mecorp.vn';
            }
            $arr_mail = $email_info['email'];
            $subject = $email_info['title'] . ' ' . $msg['subject'];
            $content = $email_info['content'] . ' ' . $msg['content'];
        }
        /*
         * Gởi mail
         */
        $config['protocol'] = "smtp";
        $config['smtp_host'] = $admin_config['smtp']['smtp'];
        $config['smtp_user'] = $admin_config['smtp']['user_email_inside'];
        $config['smtp_pass'] = $admin_config['smtp']['pass_email_inside'];
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->CI->email->initialize($config);
        $this->CI->email->from($admin_config['smtp']['account_email_inside'], $admin_config['smtp']['account_email_name']);
        $this->CI->email->to($arr_mail);
        $this->CI->email->subject($subject);
        $this->CI->email->message($content);
        $result = $this->CI->email->send();
        return $result;
    }

}