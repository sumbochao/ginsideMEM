<?php
class apiappclient extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('m_googlecontact', "m_bd");
    }
	public function getaccountlogin(){
		$getinfo = $this->m_bd->getaccount();
		//update getinfo get
		if($getinfo){
			foreach($getinfo as $k=>$v){
				$dataupdate = array("insertdate"=>date('Y-m-d H:i:s',time()));
				$whereupdate = array("id"=>$v['id']);
				$this->m_bd->update("push_top_google_contacts",$dataupdate,$whereupdate);
			}
		}
		echo json_encode($getinfo);
		return;
	}
	public function getregacc(){
		$getinfo = $this->m_bd->getaccountreg();
		//update getinfo get
		if($getinfo){
			$dataupdate = array("status"=>1);
			$whereupdate = array("id"=>$getinfo['id']);
			$this->m_bd->update("account_sample",$dataupdate,$whereupdate);
		}
		echo json_encode($getinfo);
		return;
	}
	public function getsample(){
		$getinfo = $this->m_bd->getaccountreglist();
		echo json_encode($getinfo);
		return;
	}
	public function updateinfo(){
		$params = $_GET;
		$insertparams = array("firstname"=>$params['firstname'],"lastname"=>$params['lastname'],"birthday"=>$params['birthday'],"birthyear"=>$params['birthyear'],"birthmonth"=>$params['birthmonth'],"passwd"=>$params['password'],"email"=>$params['email'],"phone"=>$params['phone'],"insertdate"=>date('Y-m-d H:i:s',time()));
		$statusinsert = $this->m_bd->insert("account_sample",$insertparams);
	}
	
}
