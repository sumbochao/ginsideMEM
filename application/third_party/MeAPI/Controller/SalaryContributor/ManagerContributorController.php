<?php

//MeAPI_Controller_ManagerContributorController
class MeAPI_Controller_SalaryContributor_ManagerContributorController implements MeAPI_Controller_SalaryContributor_ManagerContributorInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://mem.net.vn/cms/toolsalarycollaborator/";

    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');

        //$this->CI->load->MeAPI_Model('ReportModel');
        //$this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');


        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function managepermission(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        if (!empty($_GET['view'])) {
            if ($_GET['view'] == "gamepermission") {
                $this->CI->load->MeAPI_Model('AccountModel');
                $admin = $this->CI->AccountModel->get_admin($_GET['id']);
                $this->data['user_permission'] = $admin['username'];
                $this->CI->template->write_view('content', 'salarycontributor/managercontributor/gamepermission', $this->data);
            }
        } else {
            //echo $_SERVER["REMOTE_ADDR"];
            $this->CI->load->MeAPI_Library('Pgt');

            if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $per_page = 500;
            $pa = $page - 1;
            $start = $pa * $per_page;

            $this->data['start'] = $start;

            $this->CI->load->MeAPI_Model('AccountModel');
            $accounts = $this->CI->AccountModel->getAccount($start, $per_page);
            $this->data['result'] = $accounts;

            $total = $this->CI->AccountModel->getTotal();
            $config = array();
            $config['cur_page'] = $page;
            $config['base_url'] = base_url() . '?control=managercontributor&func=managepermission';
            $config['total_rows'] = $total;
            $config['per_page'] = $per_page;
            /* Initialize the pagination library with the config array */
            $this->CI->Pgt->cfig($config);
            $this->data['pages'] = $this->CI->Pgt->create_links();
            $this->CI->template->write_view('content', 'salarycontributor/managercontributor/managepermission', $this->data);
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //managepermission
    public function adduser(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/adduser', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function edituser(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/edituser', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function historyuser(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/historyuser', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function historycontributor(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/historycontributor', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function managesalary(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        if (!empty($_GET['view'])) {
            switch ($_GET['view']) {
                case 'addsalary':
                    $this->data['title'] = 'ĐỀ XUẤT CỘNG LƯƠNG CTV';
                    $this->data['action'] = "add";
                    $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/editsalary', $this->data);
                    break;
                case 'minussalary':
                    $this->data['title'] = 'ĐỀ XUẤT TRỪ LƯƠNG CTV';
                    $this->data['action'] = "sub";
                    $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/editsalary', $this->data);
                    break;
                case 'statementsalary':
                    $this->data['title'] = 'SAO KÊ LƯƠNG CTV';
                    $this->data['action'] = "statement";
                    $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/statementsalary', $this->data);
                    break;
                case 'approvalsalary':
                    if (!empty($_GET['id'])) {
                        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/approvalsalarydetail', $this->data);
                    } else {
                        $this->data['title'] = 'DANH SÁCH DUYỆT LƯƠNG CTV';
                        $this->data['action'] = "approval";
                        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/approvalsalary', $this->data);
                    }
                    break;
                case 'approvalsalarylvl2':
                    if (!empty($_GET['id'])) {
                        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/approvalsalarydetaillvl2', $this->data);
                    } else {
                        $this->data['title'] = 'DANH SÁCH DUYỆT LƯƠNG CTV';
                        $this->data['action'] = "approval";
                        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/approvalsalarylvl2', $this->data);
                    }
                    break;
                case 'history':
                    $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/history', $this->data);
            }
        } else {
            $this->CI->template->write_view('content', 'salarycontributor/managercontributor/salary/managesalary', $this->data);
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function manageitem(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        if (!empty($_GET['view'])) {
            if ($_GET['view'] == 'addedititem') {
                if (!empty($_GET['id'])) {
                    $this->data['title'] = 'CHỈNH SỬA ITEM';
                    $this->data['action'] = "edit";
                    $this->CI->template->write_view('content', 'salarycontributor/managercontributor/item/edititem', $this->data);
                } else {
                    $this->data['title'] = 'THÊM MỚI ITEM';
                    $this->data['action'] = "add";
                    $this->CI->template->write_view('content', 'salarycontributor/managercontributor/item/additem', $this->data);
                }
            } else if ($_GET['view'] == 'approvalitem') {
                if (!empty($_GET['id']) && !empty($_GET['game_id'])) {
                    $this->data['title'] = 'DUYỆT ITEM';
                    $this->data['action'] = "approvalitemdetail";
                    $this->CI->template->write_view('content', 'salarycontributor/managercontributor/item/approvalitemdetail', $this->data);
                } else {
                    $this->data['title'] = 'DUYỆT ITEM';
                    $this->data['action'] = "approvalitem";
                    $this->CI->template->write_view('content', 'salarycontributor/managercontributor/item/approvalitem', $this->data);
                }
            } else if ($_GET['view'] == 'history_item') {
                $this->CI->template->write_view('content', 'salarycontributor/managercontributor/item/history_item', $this->data);
            }
        } else {
            $this->CI->template->write_view('content', 'salarycontributor/managercontributor/item/manageitem', $this->data);
        }
        if (!empty($_POST)) {
            $this->additem($request);
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    //Process
    public function additem(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $picture = 'http://ginside.mobo.vn/assets/img/no-image.png';
        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $picture = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);
            }
        }

        $array = array(
            'game_id' => $_POST["game_id"],
            'item_name' => $_POST["item_name"],
            'type' => $_POST["type"],
            'item_count' => $_POST["item_count"],
            'item_rate' => $_POST["item_rate"],
            'limit_buy_user' => $_POST["limit_buy_user"],
            'price' => $_POST["price"],
            'icon' => $picture,
            'creator' => $_POST["creator"],
//            'active' => $_POST["item_active"],
        );
        $arrayItem = array();
        for ($index = 0; $index < count($_POST["type1"]); $index++) {
            $arrayItem[$_POST["type1"][$index]] = $_POST["type2"][$index];
        }
        if ($_POST["type"] == 0) {//item
            $arrayItem['count'] = 1;
        }

        $array['item_elements'] = json_encode(array($arrayItem));
        $rsjson = $this->_call($array, "additem");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function edititem(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $picture = $_POST["gift_img_text"];
        if (isset($_FILES['gift_img']['tmp_name']) && !empty($_FILES['gift_img']['tmp_name'])) {
            if ($_FILES['gift_img']['size'] > 716800) {
                $result["result"] = -1;
                $result["message"] = "Dung lượng ảnh không được lớn hơn 700KB";
                $result = json_encode($result);
                $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($result));
                return;
            } else {
                $_FILES['gift_img']['encodefile'] = $this->data_uri($_FILES['gift_img']['tmp_name'], $_FILES['gift_img']['type']);
                $picture = "http://m-app.mobo.vn" . $this->curlPost($_FILES['gift_img']);

                if (empty($picture)) {
                    $picture = $_POST["gift_img_text"];
                }
            }
        }

        if ($_POST["status"] == "") {
            $status = 0;
        } else {
            $status = $_POST["status"];
        }

        $array = array(
            'id' => $_POST["id"],
            'game_id' => $_POST["game_id"],
            'item_name' => $_POST["item_name"],
            'type' => $_POST["type"],
            'item_count' => $_POST["item_count"],
            'item_rate' => $_POST["item_rate"],
            'limit_buy_user' => $_POST["limit_buy_user"],
            'price' => $_POST["price"],
            'icon' => $picture,
            'updated' => $_POST["updated"],
            'status' => $status,
        );

        $arrayItem = array();
        for ($index = 0; $index < count($_POST["type1"]); $index++) {
            $arrayItem[$_POST["type1"][$index]] = $_POST["type2"][$index];
        }
        if ($_POST["type"] == 0) {//item
            $arrayItem['count'] = 1;
        }
        $array['item_elements'] = json_encode(array($arrayItem));
        $rsjson = $this->_call($array, "edititem");
        $this->_response = new MeAPI_Response_HTMLResponse($request, json_encode($rsjson));
    }

    public function loadgamelist() {
        $rsjson = $this->_call($array = array('user_id' => $_SESSION['account']['id']), "games_list");
        $array_rsjson = json_decode($rsjson);
        foreach ($array_rsjson as $key => $value) {
            if ($value->active != 1) {
                unset($array_rsjson[$key]);
            }
//            if (!((@in_array($value->id, $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1)) {
//                unset($array_rsjson[$key]);
//            }
        }
        $rsjson = json_encode($array_rsjson);
        echo $rsjson;
        die;
        //$this->_response = new MeAPI_Response_HTMLResponse($request, ($rsjson));
    }

    public function getResponse() {
        return $this->_response;
    }

    //Function
    protected function _call($params, $function_name) {
        set_time_limit(120);
        $last_link_request = $this->url_process . $function_name . "/?" . http_build_query($params);
//        var_dump($last_link_request);die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $result = curl_exec($ch);
//        var_dump($result);die;
        return $result;
    }

    function data_uri($file, $mime = 'image/jpeg') {
        if (empty($file)) {
            return "";
        }
        $contents = file_get_contents($file);
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }

    public function curlPost($params, $link = '') {
        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        if ($result) {
            $result = json_decode($result, true);
            if ($result['code'] == 0) {
                $result = $result['data'];
            }
        }
        return $result;
    }

    public function history_item(MeAPI_RequestInterface $request) {
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'salarycontributor/managercontributor/item/history_item', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

}
