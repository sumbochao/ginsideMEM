<?php

class MeAPI_Controller_BOG_Events_BuildHoThanController implements MeAPI_Controller_BOG_Events_BuildHoThanInterface
{
    /* @var $cache_user CI_Cache */
    /* @var $cache CI_Cache */
    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
	// private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $link_curl = "http://game.mobo.vn/bog/cms/build_hothan";

    public function __construct()
    {
        $this->CI = &get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');

        // $this->CI->load->MeAPI_Model('BuildHoThanModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request)
    {

		$listOfHon =  $this->curlPostAPI(array(),$this->link_curl.'/getAll');
		// echo '<pre>';print_r($listOfHon);die;
        if (isset($_SESSION['listOfHon']))
            unset($_SESSION['listOfHon']);

        $_SESSION['listOfHon'] = json_decode($listOfHon);

        
        $this->data['listOfHon'] = $listOfHon;

        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/bog/Events/BuildHoThan/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }


    public function edit_hothan(MeAPI_RequestInterface $request)
    {
		$listHon = array();
        if (isset($_SESSION['listOfHon'])) {
            //lay danh sach hon lam du lieu cho combobox
			$list = $_SESSION['listOfHon'];
			foreach($list as $obj){
				if($obj->key == 'hon'){
					$listHon[] = $obj;
				}
			}
        }else{
			$listHon =  $this->CI->BuildHoThanModel->getList('*', 'build_hothan_hon', array(), array('key' => 'hon'));
			$listHon = json_decode($listHon);
		}
		
		$this->data['listHon'] = $listHon;

		// echo '<pre>';print_r($listHon);die;
		//edit
		$hon = array();
		$related_hon = array();
		if (isset($_GET['id']) && $_GET['id'] != ''){
			$this->data['id'] = $_GET['id'];

			$listOfHon = $_SESSION['listOfHon'];
//                echo '<pre>';print_r($listOfHon);die;
			foreach($listOfHon as $value){
				if($value->id == $_GET['id']){
					$hon = $value;
					break;
				}
			}

			//lay danh sach cac hon lien wan
			$related_hon =  $this->curlPostAPI(array('hon_id_1' => $_GET['id']),$this->link_curl.'/getRelationships');
			$this->data['related_hon'] = json_decode($related_hon) ; 
		}
		// echo '<pre>';print_r($related_hon);die;
		$this->data['hon'] = $hon;
		
		$this->authorize->validateAuthorizeRequest($request, 0);
		$this->CI->template->write_view('content', 'game/bog/Events/BuildHoThan/add_hothan', $this->data);
		$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function add_hothan()
    {
        //cau hinh upload hinh
        $config['upload_path'] = FCPATH.'assets/img/hothan/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->CI->load->library('upload', $config);

        $id = $_POST['id'];
        $data = array();

        $collection = '';
        if(is_array($_POST['collection']) && count($_POST['collection'] > 0))
            $collection = implode(',',$_POST['collection']);

        $data['name'] = $_POST['name'];
        $data['key'] = $_POST['key'];
        $data['collection'] = $collection;
        $data['brief'] = $_POST['brief'];
        //xu ly upload hinh
        $files = array('image','thumb');
        foreach($files as $file){
            if(isset($_FILES[$file])){
                $data[$file] = $_FILES[$file]['name'];
                $this->CI->upload->do_upload($file);
            }
        }

        if($_POST['key'] == 'ho-than'){
            $data['desc'] = $_POST['desc'];
            $data['active_skill'] = $_POST['active_skill'];
            $data['passive_skill_1'] = $_POST['passive_skill_1'];
            $data['passive_skill_2'] = $_POST['passive_skill_2'];
            $data['passive_skill_3'] = $_POST['passive_skill_3'];

            //xu ly upload hinh
            $files = array('active_skill_image','passive_skill1_image','passive_skill2_image','passive_skill3_image');
            foreach($files as $file){
                if(isset($_FILES[$file])){
                    $data[$file] = $_FILES[$file]['name'];
                    $this->CI->upload->do_upload($file);
                }
            }
        }


        if($id == ''){ //insert
            $data['created_date'] = date('Y-m-d H:i:s',time());
			echo $this->curlPostAPI(array('data' => json_encode($data) , 'POST' => json_encode($_POST) ), $this->link_curl.'/add_hothan');die;
        }else{ //update
            $data['updated_date'] = date('Y-m-d H:i:s',time());
			echo $this->curlPostAPI(array('data' => json_encode($data), 'POST' => json_encode($_POST), 'id' => $id), $this->link_curl.'/update_hothan');die;
        }







        if($_POST['id'] == '')
            $_POST['created_date'] = date('Y-m-d H:i:s',time());
        else
            $_POST['updated_date'] = date('Y-m-d H:i:s',time());

        if($_POST['id'] == ''){ //insert
            if($this->CI->BuildHoThanModel->insert('build_hothan_hon',$_POST) > 0){
                echo  'ADD NEW SUCCESS';die;
            }else{
                echo  'ADD NEW FAIL';die;
            }
        }else{ //update
            if($this->CI->BuildHoThanModel->update('build_hothan_hon',$_POST, array('id' => $_POST['id'])) > 0){
                echo  'UPDATE SUCCESS';die;
            }else{
                echo  'UPDATE FAIL';die;
            }
        }


    }

    public function delete_hothan(){
		echo $this->curlPostAPI($_POST,$this->link_curl.'/delete');die;
        /* if($this->CI->BuildHoThanModel->delete('build_hothan_hon',array('id' => $_POST['id']))) {
            if($_POST['key'] == 'hon'){
                if($this->CI->BuildHoThanModel->delete('build_hothan_hon_relationship',array('hon_id_1' => $_POST['id']))){
                    echo '1';
                    die;
                }
            }

        }
        else {echo '0';die;} */
    }
    public function getResponse()
    {
        return $this->_response;
    }


    public function curlPostAPI($params, $link = '')
    {
		$this->last_link_request = /* empty($link)?$this->api_m_app."returnpathimg": */$link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        return $result;
    }


    
}
