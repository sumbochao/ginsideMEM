<?php

class MeAPI_Controller_PopupButtonController {

    protected $_response;
    private $CI;
    private $_mainAction;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Library('TOTP');
        $this->CI->load->MeAPI_Library('Curl');
        $this->CI->load->MeAPI_Library("Graph_Inside_API");
        $this->CI->load->MeAPI_Model('PopupButtonModel');
        $this->CI->load->MeAPI_Model('MestoreVersionModel');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');

        $this->_mainAction = base_url() . '?control=' . $_GET['control'] . '&func=index';
    }

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->library('form_validation');
        $this->CI->load->helper('form');
        $this->data['loadstatus'] = $this->CI->MestoreVersionModel->listStatus();
        //$this->CI->template->set_template('blank');
        //get msv_id viewone
        //$arrParam = $this->CI->security->xss_clean($_POST);
        // lay so OTP
        $serviceid = $this->CI->input->get('service_id');
        if ($serviceid == "124") {
            $otp = $this->CI->Graph_Inside_API->get_otp_thai();
            $arrPurl = array(
                'control' => "inside", // msv_id
                'func' => "msv_get",
                'app' => "inside",
                'msv_id' => $this->CI->input->get('msv_id'), // msv_id
                'service_id' => $this->CI->input->get('service_id'), //service_id
                'platform' => $this->CI->input->get('platform'),
                'status' => $this->CI->input->get('status'),
                'otp' => $otp
            );
        } else {
            $otp = $this->CI->Graph_Inside_API->get_otp();
            if($this->CI->input->get('type_game')=='global'){
                $arrPurl = array(
                    'control' => "inside", // msv_id
                    'func' => "gsv_get",
                    'app' => "ginside",
                    'gsv_id' => $this->CI->input->get('msv_id'), // msv_id
                    'service_id' => $this->CI->input->get('service_id'), //service_id
                    'platform' => $this->CI->input->get('platform'),
                    'status' => $this->CI->input->get('status'),
                    'otp' => $otp
                );
            }else{
                $arrPurl = array(
                    'control' => "inside", // msv_id
                    'func' => "msv_get",
                    'app' => "ginside",
                    'msv_id' => $this->CI->input->get('msv_id'), // msv_id
                    'service_id' => $this->CI->input->get('service_id'), //service_id
                    'platform' => $this->CI->input->get('platform'),
                    'status' => $this->CI->input->get('status'),
                    'otp' => $otp
                );
            }
        }
        $param = $this->CI->Graph_Inside_API->get_param_url($arrPurl);
        // tao chuoi ma hoa md5 Token
        if ($serviceid == "124") {
            $token = md5(implode("", $param) . $this->CI->Graph_Inside_API->get_Secretkey_thai());
        } else {
            $token = md5(implode("", $param) . $this->CI->Graph_Inside_API->get_Secretkey());
        }
        $param["token"] = $token;
        //cac tham so va gia tri cua url
        $url_param = http_build_query($param, true);
        //du lieu tra ve 
        if($this->CI->input->get('type_game')=='global'){
            $reponse = $this->CI->Graph_Inside_API->view_gsv($url_param);
        }else{
            $reponse = $this->CI->Graph_Inside_API->view_msv($url_param);
        }
        $this->data['api_view_msv'] = $reponse;
        //$this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'popupbutton/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->library('form_validation');
        $this->CI->load->helper('form');
        $this->CI->load->MeAPI_Library('Pgt');
        //get json
        $links = $this->CI->input->post('link') == "" ? "null" : $this->CI->input->post('link');
        $mess = $this->CI->input->post('message') == "" ? "null" : $this->CI->input->post('message');

        $msg = array('link' => $links, 'message' => $mess);
        $jsonmsg = json_encode($msg);
        $this->CI->form_validation->run();

        $otp = $this->CI->Graph_Inside_API->get_otp();
        $param = array(
            "control" => "inside",
            "func" => "msv_update",
            "id" => $this->CI->input->get('id'),
            "me_button" => $this->CI->input->post('mebutton'),
            "me_chat" => $this->CI->input->post('mechat'),
            "me_game" => $this->CI->input->post('megame'),
            "me_event" => $this->CI->input->post('meevent'),
            "me_login" => $this->CI->input->post('melogin'),
            "msg_login" => $jsonmsg,
            "me_gm" => $this->CI->input->post('megm'),
            "app" => "ginside",
            "otp" => $otp,
        );

        //Tham so url 
        $param_url = $this->CI->Graph_Inside_API->get_param_url($param);
        // tao chuoi ma hoa md5 Token
        $token = md5(implode("", $param_url) . $this->CI->Graph_Inside_API->get_Secretkey());
        $param["token"] = $token;

        $kq = $this->CI->Graph_Inside_API->msv_update_button($param);
        if ($kq['status'] != FALSE) {
            $this->data['error'] = "Thông báo : Cập nhật thành công";
        } else {
            $this->data['error'] = "Thông báo : Không cập nhật được Me button, vui lòng thử lại";
        }

        $this->CI->template->write_view('content', 'popupbutton/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function actionajax(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->library('form_validation');
        $this->CI->load->helper('form');
        $this->CI->load->MeAPI_Library('Pgt');
        //get json
        $links = $this->CI->input->post('linktext') == "" ? "" : $this->CI->input->post('linktext');
        $mess = $this->CI->input->post('mess') == "" ? "" : $this->CI->input->post('mess');

        $msg = array('link' => $links, 'message' => $mess);
        $jsonmsg = json_encode($msg);
        $this->CI->form_validation->run();
        $serviceid = $this->CI->input->post('service_id');
        if ($serviceid == "124") {
            $otp = $this->CI->Graph_Inside_API->get_otp_thai();
            $param = array(
                "control" => "inside",
                "func" => "msv_update",
                "id" => $this->CI->input->post('id'),
                "me_button" => $this->CI->input->post('mebutton'),
                "me_chat" => $this->CI->input->post('mechat'),
                "me_game" => $this->CI->input->post('megame'),
                "me_event" => $this->CI->input->post('meevent'),
                "me_login" => $this->CI->input->post('melogin'),
                "msg_login" => $jsonmsg,
                "status" => $this->CI->input->post('status'),
                "state" => $this->CI->input->post('state'),
                "me_gm" => $this->CI->input->post('megm'),
                "app" => "inside",
                "otp" => $otp,
            );
        } else {
            $otp = $this->CI->Graph_Inside_API->get_otp();
            if($_POST['type_game']=='global'){
                $param = array(
                    "control" => "inside",
                    "func" => "gsv_update",
                    "id" => $this->CI->input->post('id'),
                    "me_button" => $this->CI->input->post('mebutton'),
                    "me_chat" => $this->CI->input->post('mechat'),
                    "me_game" => $this->CI->input->post('megame'),
                    "me_event" => $this->CI->input->post('meevent'),
                    "me_login" => $this->CI->input->post('melogin'),
                    "msg_login" => $jsonmsg,
                    "status" => $this->CI->input->post('status'),
                    "state" => $this->CI->input->post('state'),
                    "me_gm" => $this->CI->input->post('megm'),
                    "app" => "ginside",
                    "otp" => $otp,
                );
            }else{
                $param = array(
                    "control" => "inside",
                    "func" => "msv_update",
                    "id" => $this->CI->input->post('id'),
                    "me_button" => $this->CI->input->post('mebutton'),
                    "me_chat" => $this->CI->input->post('mechat'),
                    "me_game" => $this->CI->input->post('megame'),
                    "me_event" => $this->CI->input->post('meevent'),
                    "me_login" => $this->CI->input->post('melogin'),
                    "msg_login" => $jsonmsg,
                    "status" => $this->CI->input->post('status'),
                    "state" => $this->CI->input->post('state'),
                    "me_gm" => $this->CI->input->post('megm'),
                    "app" => "ginside",
                    "otp" => $otp,
                );
            }
        }
       
        //Tham so url 
        $param_url = $this->CI->Graph_Inside_API->get_param_url($param);
        // tao chuoi ma hoa md5 Token
        if ($serviceid == "124") {
            $token = md5(implode("", $param_url) . $this->CI->Graph_Inside_API->get_Secretkey_thai());
        } else {
            $token = md5(implode("", $param_url) . $this->CI->Graph_Inside_API->get_Secretkey());
        }
        $param["token"] = $token;
        if ($serviceid == "124") {
            $kq = $this->CI->Graph_Inside_API->msv_update_button_thai($param);
        } else {
            if($_POST['type_game']=='global'){
                $kq = $this->CI->Graph_Inside_API->gsv_update_button($param);
            }else{
                $kq = $this->CI->Graph_Inside_API->msv_update_button($param);
            }
        }
        if ($kq['status'] != FALSE) {
            //cập nhật msv bên ginside
            $param_c = array(
                "status" => $this->CI->input->post('cbo_status')
            );
            if($_POST['type_game']=='global'){
                $param_where = array(
                    "msv_id" => "gsv_" . $this->CI->input->get('msv_id'),
                    "platform" => $this->CI->input->get('platform'),
                    "service_id" => $this->CI->input->get('service_id'),
                );
            }else{
                $param_where = array(
                    "msv_id" => "msv_" . $this->CI->input->get('msv_id'),
                    "platform" => $this->CI->input->get('platform'),
                    "service_id" => $this->CI->input->get('service_id'),
                );
            }
            $this->CI->MestoreVersionModel->edit_new($param_c, $param_where);
            $f = array(
                'error' => '0',
                'messg' => 'Thông báo : Cập nhật thành công ' . $kq['status'] . $serviceid,
            );
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thông báo : Không cập nhật được Me button, vui lòng thử lại' . $kq['status'],
            );
        }
        echo json_encode($f);
        exit();
    }

    public function getResponse() {
        return $this->_response;
    }

}

?>