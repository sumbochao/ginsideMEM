<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . 'third_party/MeAPI/Autoloader.php';

class Service extends CI_Controller {

    public function index() {
        $this->benchmark->mark('api_start');
        parent::__construct();
        MeAPI_Autoloader::register();
        $api = new MeAPI_Server();
        $api->start();
		
		$this->load->MeAPI_Library('Session');
        $account = $this->Session->get_session('account');
		
		if(count($_GET)==0){
            header("location:".APPLICATION_URL.'/?control=login&func=index');
        }
		
		$permission = $this->Session->get_session('permission');
        
		//start module 11/12/2015
		if (count($account) > 0 && ($account['id_group'] == 2 || $account['id_group'] == 3)) {
            if (isset($_GET['control']) && isset($_GET['module']) && isset($_GET['game'])) {
                if (!in_array($_GET['control'] . '-' . $_GET['module']. '-' . $_GET['game'], $permission)) {
                    header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');
                }
            }else{
                if (isset($_GET['control']) && isset($_GET['module'])) {
                    if (!in_array($_GET['control'] . '-' . $_GET['module'], $permission)) {
                        header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');
                    }
                }else{
                    if (isset($_GET['control']) && isset($_GET['func']) && isset($_GET['game'])) {//phan quyen tren tham so la game
                        if (!in_array($_GET['control'] . '-' . $_GET['func'] . '-' . $_GET['game'], $permission)) {
                            header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');
                        }
                    } else {
                        if (isset($_GET['control']) && isset($_GET['func']) && isset($_GET['view'])) {
                            if (!in_array($_GET['control'] . '-' . $_GET['func'] . '-' . $_GET['view'], $permission)) {
                                header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');
                            }
                        }else{
                            if (isset($_GET['control']) && isset($_GET['func'])) {// phan quyen controller, action bo cac param phia sau
                                if (!in_array($_GET['control'] . '-' . $_GET['func'], $permission)) {
                                    header("location:" . APPLICATION_URL . '/?control=account&func=noaccess');
                                }
                            }
                        }
                    }
                }
            }
        }
		//end module
		/*if(count($account)>0 && $account['id_group']==2){
			if(isset($_GET['control']) && isset($_GET['func']) && isset($_GET['game'])){//phan quyen tren tham so la game
				if(!in_array($_GET['control'].'-'.$_GET['func'].'-'.$_GET['game'], $permission)){
					header("location:".APPLICATION_URL.'/?control=account&func=noaccess');
				}
			}else{
				if(isset($_GET['control']) && isset($_GET['func'])){// phan quyen controller, action bo cac param phia sau
					if(!in_array($_GET['control'].'-'.$_GET['func'], $permission)){
						header("location:".APPLICATION_URL.'/?control=account&func=noaccess');
					}
				}
			}
        }*/
		
        if (is_object($api->getResponse())) {
            $output = $api->getResponse()->getJson();
            if (empty($output) === TRUE) {
                $output = 'HTML';
                $api->getResponse()->send('html');
            } else {
                $api->getResponse()->send();
            }
        } else {
            $response = new MeAPI_Response(array('Welcome to Service ( System Error ) !!!'));
            $output = $response->getJson();
            $response->send();
        }
        
        
        $username = null;
        if(empty($account) === FALSE){
            $username = $account['username'];
        }
        $arrParam = $api->request->input_request();
        if($arrParam['control'] == 'login'){
            if(isset($arrParam['password'])){
                unset($arrParam['password']);
            }
        }
        $query = '?' . http_build_query($arrParam);
        $this->benchmark->mark('api_end');
        $time_execute = $this->benchmark->elapsed_time('api_start', 'api_end');
              
        MeAPI_Log::writeCsv(array($time_execute, $query, $output,$username), 'request_' . date('H'));
        exit;
    }

}