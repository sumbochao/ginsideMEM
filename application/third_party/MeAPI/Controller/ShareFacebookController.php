<?php

class MeAPI_Controller_ShareFacebookController implements MeAPI_Controller_ShareFacebookInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    const NUM_ROWS = 20;
    const DOMAIN = "http://service.mong.mobo.vn";
    const TABLE_DOMAIN = "share_facebook_game";

    private $domain;

    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        //var_dump(geoip_country_name_by_name($_SERVER['REMOTE_ADDR']));die;
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');

        $this->db = $this->CI->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        //$this->CI->load->MeAPI_Model('ReportModel');
        //$this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');

        $this->view_data = new stdClass();

        /* $acc = array("vietbl","hoangpc", "tuanhq", "nghiapq", "quannt","phuongnt","phuongnt2","hiennv","thinhndn");
          if (in_array($session['username'], $acc) === false) {
          echo 'Bạn không được phép truy cập!'; die;
          } */
    }

    /*
     * Get Data Group
     */

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');

        $page = 1;
        if (isset($_GET["per_page"]) && is_numeric($_GET["per_page"])) {
            $page = $_GET["per_page"];
        }

        $this->data["domain_list"] = $this->get_domain_list();

        $id = 0;
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id = $_GET["id"];

            $domain_detail = $this->get_domain_detail($id);
            //var_dump($domain_detail);die;
            if ($domain_detail != NULL) {
                $this->domain = $domain_detail["domain"];

                $config['base_url'] = "?control=sharefacebook&func=index&id=".$id;
                $config['total_rows'] = $this->get_total();
                $config['per_page'] = self::NUM_ROWS;
                $config['page_query_string'] = TRUE;
                $config['use_page_numbers'] = TRUE;

                $config['cur_tag_open'] = '<a tabindex="0" class="paginate_active">';
                $config['cur_tag_close'] = '</a>';
                //$config['num_tag_open'] = '<a tabindex="0" class="paginate_button">';
                //$config['num_tag_close'] = '</a>';

                $this->CI->pagination->initialize($config);

                $paging = $this->CI->pagination->create_links();
                $this->data["paging"] = $paging;

                $this->data["data"] = $this->get_list($page, self::NUM_ROWS);

                if (count($this->data["data"]) > 0 && !isset($this->data["data"]) && count($this->data["data"]) <= 0) {
                    redirect("?control=sharefacebook&func=index&per_page=" . ($page - 1));
                }
            }
        }
        //$this->load->view('cms/ep/toolvip/user', $this->view_data);

        $this->CI->template->write_view('content', 'share_facebook/share_index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function validate() {
        $message = "";

        if (empty($_POST["caption"])) {
            $message .= "Nhập caption<br>";
        }

        if (empty($_POST["name"])) {
            $message .= "Nhập tên<br>";
        }

        if (empty($_POST["message"])) {
            $message .= "Nhập message<br>";
        }

        if (empty($_POST["link"])) {
            $message .= "Nhập link<br>";
        }

        if (empty($_POST["photo"])) {
            $message .= "Nhập photo<br>";
        }

        return $message;
    }

    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');

        $id = -1;
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id = $_GET["id"];
        }

        $domain = 0;
        if (isset($_GET["domain"]) && is_numeric($_GET["domain"])) {
            $domain = $_GET["domain"];
        }

        $domain_detail = $this->get_domain_detail($domain);
		if ($domain_detail != NULL) {
            $this->domain = $domain_detail["domain"];
        }
        if (isset($_POST["edit"]) || isset($_POST["add"])) {
            $message = $this->validate();
			if (empty($message)) {
                if (isset($_POST["edit"])) {
                    $array = array(
                        id => $id,
                        caption => $_POST["caption"],
                        name => $_POST["name"],
                        message => $_POST["message"],
                        photo => $_POST["photo"],
                        link => $_POST["link"],
                        status => $_POST["status"]);

                    //$data = json_encode($array);

                    $this->update($array);

                    $this->data["error_msg"] = "Cập nhật thành công";
                    $this->data["valid"] = TRUE;
                } elseif (isset($_POST["add"])) {
                    $array = array(
                        caption => $_POST["caption"],
                        name => $_POST["name"],
                        message => $_POST["message"],
                        photo => $_POST["photo"],
                        link => $_POST["link"],
                        status => $_POST["status"]);

                    //$data = json_encode($array);

                    $this->insert($array);
                    redirect("/?control=sharefacebook&func=index&id=" . $domain);
                }
            } else {
                $this->data["error_msg"] = $message;
                $this->data["valid"] = FALSE;
            }
        }

        if ($id > 0 || isset($_POST)) {
            $this->data["data"] = $this->get_detail($id);
        } else {
            $this->data["data"] = null;
        }

        $this->CI->template->write_view('content', 'share_facebook/share_edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    // <editor-fold defaultstate="collapsed" desc="Share">
    function delete() {
        $id = -1;
        $page = $_GET["per_page"];

        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id = $_GET["id"];
        }

        $domain = 0;
        if (isset($_GET["domain"]) && is_numeric($_GET["domain"])) {
            $domain = $_GET["domain"];
        }

        $domain_detail = $this->get_domain_detail($domain);
        if ($domain_detail != NULL) {
            $this->domain = $domain_detail["domain"];
        }

        if ($id > 0) {
            $this->delete_item($id);
        }

        redirect("?control=sharefacebook&func=index&per_page=" . $page . "&id=" . $domain);
    }

    public function getResponse() {
        return $this->_response;
    }

    function insert($data) {
        $link = $this->domain . "/facebook/facebook_share/insert?data=" . $data;
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = '';
        if (($result = curl_exec($ch) ) === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            //echo 'Operation completed without any errors';
        }

        curl_close($ch);
		//var_dump($result);die;

        //$result = file_get_contents($link);
        return json_decode($result, true);
    }

    function get_list($page, $num_rows) {
        $link = $this->domain . "/facebook/facebook_share/get_list?page=" . $page . "&num_rows=" . $num_rows;

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = '';
        if (($result = curl_exec($ch) ) === false) {
            //echo 'Curl error: ' . curl_error($ch);
        } else {
            //echo 'Operation completed without any errors';
        }

        curl_close($ch);
        //$result = file_get_contents($link);
        return json_decode($result, true);
    }

    function get_total() {
        $link = $this->domain . "/facebook/facebook_share/get_total";
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = '';
        if (($result = curl_exec($ch) ) === false) {
            //echo 'Curl error: ' . curl_error($ch);
        } else {
            //echo 'Operation completed without any errors';
        }

        curl_close($ch);

        //$result = file_get_contents($link);
        //var_dump($link);die;
        return json_decode($result, true);
    }

    function get_detail($id) {
        $link = $this->domain . "/facebook/facebook_share/get_detail?id=" . $id;
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = '';
        if (($result = curl_exec($ch) ) === false) {
            //echo 'Curl error: ' . curl_error($ch);
        } else {
            //echo 'Operation completed without any errors';
        }

        curl_close($ch);

        //$result1 = file_get_contents($link);
        //var_dump($result1);die;
        return json_decode($result, true);
    }

    function delete_item($id) {
        $link = $this->domain . "/facebook/facebook_share/delete?id=" . $id;
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = '';
        if (($result = curl_exec($ch) ) === false) {
            //echo 'Curl error: ' . curl_error($ch);
        } else {
            //echo 'Operation completed without any errors';
        }

        curl_close($ch);

        //$result = file_get_contents($link);
        return json_decode($result, true);
    }

    function update($data) {
        $link = $this->domain . "/facebook/facebook_share/update";
		$ch = curl_init();
        //var_dump(http_build_query($data));die;
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = '';
        if (($result = curl_exec($ch) ) === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            //echo 'Operation completed without any errors';
        }

        curl_close($ch);

        //$result = file_get_contents($link);
        return json_decode($result, true);
    }

// </editor-fold>

    function domain_list(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');

        $this->data["data"] = $this->get_domain_list();

        $this->CI->template->write_view('content', 'share_facebook/domain_list', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    function domain_edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');

        $id = -1;
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (isset($_POST["edit"]) || isset($_POST["add"])) {
            $message = $this->validate_domain();
            if (empty($message)) {
                if (isset($_POST["edit"])) {
                    $array = array(
                        id => $id,
                        game => $_POST["game"],
                        domain => $_POST["domain"],
                        alias => $_POST["alias"]);

                    $this->update_domain($array);

                    $this->data["error_msg"] = "Cập nhật thành công";
                    $this->data["valid"] = TRUE;
                } elseif (isset($_POST["add"])) {
                    $array = array(
                        game => $_POST["game"],
                        domain => $_POST["domain"],
                        alias => $_POST["alias"]);

                    $this->insert_domain($array);
                    redirect("/?control=sharefacebook&func=domain_list");
                }
            } else {
                $this->data["error_msg"] = $message;
                $this->data["valid"] = FALSE;
            }
        }

        if ($id > 0 || isset($_POST)) {
            $this->data["data"] = $this->get_domain_detail($id);
        } else {
            $this->data["data"] = null;
        }

        $this->CI->template->write_view('content', 'share_facebook/domain_edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    function domain_delete(MeAPI_RequestInterface $request) {
        $id = -1;
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id = $_GET["id"];
        }

        if ($id > 0) {
            $this->delete_domain($id);
        }

        redirect("?control=sharefacebook&func=domain_list");
    }

    public function validate_domain() {
        $message = "";

        if (empty($_POST["game"])) {
            $message .= "Nhập tên<br>";
        }

        if (empty($_POST["domain"])) {
            $message .= "Nhập domain<br>";
        }

        return $message;
    }

    // <editor-fold defaultstate="collapsed" desc="Domain">

    function get_domain_list() {
        $query = $this->db->select("*")
                ->from(self::TABLE_DOMAIN)
                ->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        } else {
            $result = null;
        }

        return $result;
    }

    function get_domain_detail($id) {
        $query = $this->db->select("*")
                ->from(self::TABLE_DOMAIN)
                ->where("id", $id)
                ->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
        } else {
            $result = null;
        }

        return $result;
    }

    function insert_domain($array) {
        $flag = false;

        if (count($array) > 0) {
            $data = array(
                game => $array["game"],
                domain => $array["domain"],
                alias => $array["alias"]);

            $this->db->insert(self::TABLE_DOMAIN, $data);
            //var_dump($this->db->last_query()); die;
            $id = $this->db->insert_id();

            $flag = ($id > 0);
        }

        return $flag;
    }

    function update_domain($array) {
        $flag = false;

        if (count($array) > 0) {

            $data = array(
                game => $array["game"],
                domain => $array["domain"],
                alias => $array["alias"]);

            $this->db->where('id', $array["id"]);
            $this->db->update(self::TABLE_DOMAIN, $data);

            $rows = $this->db->affected_rows();
            $flag = ($rows > 0);
        }

        return $flag;
    }

    function delete_domain($id) {
        $this->db->delete(self::TABLE_DOMAIN, array('id' => $id));

        echo json_encode(array(
            valid => true
        ));
    }

    // </editor-fold>
}
