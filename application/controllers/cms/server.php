<?php
class server extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_server');
    }
    public function index(){
        $data = $this->m_server->listServerByServiceID($_GET['service_id']);
        $R=$data;
        if(isset($_GET['callback'])){
            echo $_GET['callback']."(".json_encode($R).")";
        }else{
            $this->output->set_header('Content-type: application/json');
            $this->output->set_output(json_encode($R));
        }
    }
}