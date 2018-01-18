<?php
class module extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_module','m_bd');
        $this->load->helper('cmsselect_helper');
        $this->load->helper('recursive_helper');
    }
    public function index(){
        $data = $this->m_bd->listItems();
        $R=$data;
        if(isset($_GET['callback'])){
            echo $_GET['callback']."(".json_encode($R).")";
        }else{
            $this->output->set_header('Content-type: application/json');
            $this->output->set_output(json_encode($R));
        }
    }
}