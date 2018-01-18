<?php

class Session {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        if (empty($_SESSION) === TRUE)
            session_start();
    }

    public function get_session($name) {
        if (empty($name) === FALSE) {
            return $_SESSION[$name];
        }
        return FALSE;
    }

    public function set_session($name, $data) {
        if (empty($name) === FALSE && empty($data) === FALSE) {
            $_SESSION[$name] = $data;
            return TRUE;
        }
        return FALSE;
    }

    public function clear_session() {
        if (empty($_SESSION) === FALSE) {
            session_destroy();
        }
        return TRUE;
    }
	public function unset_session($name, $data){
        $_SESSION[$name] = $data;
        return TRUE;
    }
}