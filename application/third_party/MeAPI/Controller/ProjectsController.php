<?php

class MeAPI_Controller_ProjectsController {

    protected $_response;
    private $CI;
    private $_mainAction;
    private $limit;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Library('TOTP');
        $this->CI->load->MeAPI_Library('Curl');
        $this->CI->load->MeAPI_Library("Graph_Inside_API");
        $this->CI->load->MeAPI_Library('Libcommon');
        $this->CI->load->MeAPI_Model('ProjectsModel');
        $this->CI->load->MeAPI_Model('SignHistoryAppModel');
        $this->limit = 100;
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        /* if($session['id_group']!=1){
          $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=noaccess';
          } */
        if ($_GET['page'] > 0) {
            $page = '&page=' . $_GET['page'];
        }


        $this->data['loaditem'] = $this->CI->ProjectsModel->listItem();
        $this->data['loadplatform'] = $this->CI->ProjectsModel->listPlatform();

        $this->_mainAction = base_url() . '?control=' . $_GET['control'] . '&func=index' . $page;
    }

    public function noaccess(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Noaccess';
        $this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'projects/noaccess', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
	public function api_payment(MeAPI_RequestInterface $request){
        $getServiceKey = $this->CI->ProjectsModel->getStatusTuneProjects($_GET['service_id']);
        $idprojects = $getServiceKey['id'];
        if($idprojects>0){
            $arrGet['id_projects'] = $idprojects;
            $data['getitem'] = $this->CI->ProjectsModel->getItem($arrGet['id_projects']);
            $data['getrate'] = $this->CI->ProjectsModel->getRate($arrGet['id_projects']);
            $json_payment = '{"game_title": {"en": "' . $data['getitem']['namesetup'] . '","vi": "' . $data['getitem']['namesetup'] . '"},"game_currency": {"en": "' . $data['getrate']['units'] . '","vi": "' . $data['getrate']['units'] . '"},"money_currency": {"en": "VND","vi": "VND"},"rate_list": {';
            $json_str_type = "";
            $json_str_item = "";
            $json_str_item_inapp = "";
            $json_str_type_platform = "";
            $name_code_compa = "";
            $items_inapp = "";
            $t_c_p = "";
            $j = 0;
            //loc loai payment
            $data['arr_type'] = $this->CI->ProjectsModel->FilterTypePayment($arrGet['id_projects']);

            foreach ($data['arr_type'] as $type) {
                if ($type['type'] == "inapp") {
                    //nếu là inapp
                    //kiem tra platform
                    $data['arr_payment_platform'] = $this->CI->ProjectsModel->ReturnJsonInappFilterPlatform($arrGet['id_projects'], $type['type']);
                    //loc theo platform
                    foreach ($data['arr_payment_platform'] as $platform) {
                        $data['arr_payment_t'] = $this->CI->ProjectsModel->ReturnJsonInapp($arrGet['id_projects'], $type['type'], $platform['platform']);
                        foreach ($data['arr_payment_t'] as $items) {
                            $t = "";
                            $arrcode = explode(".", $items['code']);
                            //lấy phần tử cuối mảng
                            $usd = $arrcode[count($arrcode) - 1];
                            $usd = $usd - 0.01;
                            //sau đó xóa phần tử cuối mảng
                            unset($arrcode[count($arrcode) - 1]);
                            //sau đó biến mảng thành 1 cuỗi
                            $knb = (int) $items['gem'] + (int) $items['promotion_gem'];
                            $name_code = implode(".", $arrcode);


                            if ($platform['platform'] == "ios") {
                                $t = "apple";
                            } elseif ($platform['platform'] == "android") {
                                $t = "google";
                            } else {
                                $t = "winphone";
                            }

                            if ($j > 0) {
                                if ($t_c_p == $t) {
                                    if ($name_code_compa == $name_code) {
                                        $json_str_item_inapp = $json_str_item_inapp . '{"identify": "' . $usd . '","message": "' . $usd . ' {money_currency}","description": "' . $knb . ' {game_currency}"},';
                                        //$json_str_type_platform=$json_str_type_platform.'"'.$type['type'].'_'.$t.'": { "title": {"vi": "'.$name_code.'","en": "'.$name_code.'"},"items": ['.$json_str_item_inapp.'{}]},';
                                        //sau đó gán tên vào bien de so sanh
                                        $name_code_compa = $name_code;
                                        $t_c_p = $t;
                                        $j++;
                                    } else {
                                        $name_code_compa = ""; //xóa biến so sánh name
                                    }
                                } else {
                                    $t_c_p = $t; // xóa biết so sánh platform
                                    $j = 0; // trở về trạng thái ban đầu
                                }//end if
                            }//end if
                            //lần đầu chạy vòng for
                            if ($j == 0) {
                                $json_str_item_inapp = $json_str_item_inapp . '{"identify": "' . $usd . '","message": "' . $usd . ' {money_currency}","description": "' . $knb . ' {game_currency}"},';
                                //$json_str_type_platform=$json_str_type_platform.'"'.$type['type'].'_'.$t.'": { "title": {"vi": "'.$name_code.'","en": "'.$name_code.'"},"items": ['.$json_str_item_inapp.'{}]},';
                                //sau đó gán tên vào bien de so sanh
                                $name_code_compa = $name_code;
                                $t_c_p = $t;
                                $j++;
                            }
                        }//end for
                        $j = 0;
                        $name_code_compa = "";
                        $json_str_type_platform = $json_str_type_platform . '"' . $type['type'] . '_' . $t . '": { "title": {"vi": "' . $name_code . '","en": "' . $name_code . '"},"items": [' . $json_str_item_inapp . '{}]},';
                        $json_str_item_inapp = "";
                    }//end for

                    $t_c_p = "";
                }//end if inapp
            }//end for


            foreach ($data['arr_type'] as $type) {

                if ($type['type'] != "inapp") {

                    $data['arr_payment'] = $this->CI->ProjectsModel->ReturnJson($arrGet['id_projects'], $type['type']);
                    foreach ($data['arr_payment'] as $items) {
                        $knb1 = (int) $items['gem'] + (int) $items['promotion_gem'];
                        $json_str_item = $json_str_item . '{"identify": "' . $items['vnd'] . '","message": "' . $items['vnd'] . ' {money_currency}","description": "' . $knb1 . ' {game_currency}"},';
                    }//end for
                    $json_str_type = $json_str_type . '"' . $type['type'] . '": { "title": {"vi": "' . $type['code'] . '","en": "' . $type['code'] . '"},"items": [' . $json_str_item . '{}]},';
                    $json_str_item = "";
                }//end if
            }//end for

            $json_payment = $json_payment . $json_str_type_platform . $json_str_type . "\"\": \"\"}}";
            //$_POST['btn_json']=json_decode($json_payment);


            $post_array = array(
                    "content" => str_replace(',{}', '', $json_payment),
                    "game_id" => $data['getitem']['servicekeyapp'],
                    "game_name" => $data['getitem']['names'],
                );
            echo json_encode($post_array);
        }
        exit();
    }
    public function get_link_cdn_client() {
        $get_link = $this->CI->ProjectsModel->LinkCDN($_GET);
        echo json_encode($get_link);
        exit();
    }

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Quản lý dự án Game';

        $this->filter();

        $arrFilter = array(
            'names' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'names' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }

        $per_page = 100;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->ProjectsModel->listItem($arrFilter);

        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=' . $_GET['control'] . '&func=index';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if (empty($listItems) !== TRUE) {
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
        $this->data['slbUser'] = $this->CI->ProjectsModel->listUser();

        $this->CI->template->write_view('content', 'projects/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function logupdate(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Nhật ký cập nhật';


        $this->filter();

        $arrFilter = array(
            'actions' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'actions' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }

        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $options = array(
            'username' => $_SESSION['account']['id'],
            'id_actions' => $_GET['id'],
            'tables' => $_GET['table']
        );
        $listItems = $this->CI->ProjectsModel->listItemLog($arrFilter, $options);

        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=' . $_GET['control'] . '&func=logupdate&table=' . $_GET['table'] . '&id=' . $_GET['id'];
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if (empty($listItems) !== TRUE) {
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
        $this->data['slbUser'] = $this->CI->ProjectsModel->listUser();

        $this->CI->template->write_view('content', 'projects/logupdate', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function logupdate1(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Nhật ký cập nhật';


        $this->filter();

        $arrFilter = array(
            'actions' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'actions' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }

        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $options = array(
            'username' => $_SESSION['account']['id'],
            'id_actions' => $_GET['id'],
            'tables' => $_GET['table']
        );
        $listItems = $this->CI->ProjectsModel->listItemLog($arrFilter, $options);

        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=' . $_GET['control'] . '&func=logupdate1&table=' . $_GET['table'] . '&id=' . $_GET['id'];
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if (empty($listItems) !== TRUE) {
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
        $this->data['slbUser'] = $this->CI->ProjectsModel->listUser();

        $this->CI->template->write_view('content', 'projects/logupdate1', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function listlog(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Nhật ký user thao tác Xóa trên dự án Game';


        $this->filter();

        $arrFilter = array(
            'names' => $this->CI->Session->get_session('keyword')
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'names' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }

        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->ProjectsModel->listItemLog($arrFilter);

        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=' . $_GET['control'] . '&func=listlog';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if (empty($listItems) !== TRUE) {
            $listData = array_slice($listItems, $start, $per_page);
        }
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
        $this->data['slbUser'] = $this->CI->ProjectsModel->listUser();

        $this->CI->template->write_view('content', 'projects/log', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function getdevice() {
        $device = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $_SERVER['HTTP_USER_AGENT']) == 0 ? "desktop" : "mobile";
        return $device;
    }

    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm dự án Game';
        $this->CI->load->library('form_validation');
        $this->CI->template->write_view('content', 'projects/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật thông tin dự án Game';
        $this->CI->load->library('form_validation');
        $this->data['getitem'] = $this->CI->ProjectsModel->getItem($_GET['id']);

        $this->CI->template->write_view('content', 'projects/edit', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function popupinapp(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'In App Items';
        $this->CI->load->library('form_validation');
        $arr_p = $this->CI->security->xss_clean($_GET);
        $arrFilter = array(
            'type' => 'inapp',
            'id_projects' => $arr_p['id_projects'],
            'id_projects_property' => $arr_p['id_projects_property']
        );
        $this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
        $listData = $this->CI->ProjectsModel->listPayment($arrFilter);
        $this->data['listItems'] = $listData;
        $this->data['getrate'] = $this->CI->ProjectsModel->getRate($arr_p['id_projects']);
        $this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'projects/popupinappplus', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function updatefiles(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Cập nhật file Certificates';
        $this->CI->load->library('form_validation');
        $arr_p = $this->CI->security->xss_clean($_GET);
        $this->CI->template->set_template('blank');
        $this->CI->template->write_view('content', 'projects/updatefiles', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function updatefiledatabase() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['id'] > 0) {
            $arrParam = array(
                'files_certificates' => "files/certificates/" . $arr_p['files_certificates']
            );

            $result = $this->CI->ProjectsModel->edit_field_filename($arrParam, $arr_p['id']);
            if ($result) {
                echo "ok";
            } else {
                echo "false";
            }
        } else {
            echo "false id " . $arr_p['id'];
        }
        exit();
    }

    public function updaterowsitem() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['id'] > 0) {
            $arrParam = array(
                'id' => $arr_p['id'],
                //'platform'=>$arr_p['cbo_platform_e'],
                'app_id' => $arr_p['app_id_e'],
				'store_id' => $arr_p['store_id_e'],
                'park_id' => $arr_p['park_id_e'],
                'package_name' => $arr_p['package_name_e'],
                'inapp_items' => $arr_p['inapp_items_e'],
                'public_key' => $arr_p['public_key_e'],
                'wp_p1' => $arr_p['wp_p1_e'],
                'wp_p2' => $arr_p['wp_p2_e'],
                'notes' => $arr_p['notes_p_e'],
                'pass_certificates' => $arr_p['pass_certificates_e'],
                'api_key' => $arr_p['api_key_e'],
                'client_key' => $arr_p['client_key_e'],
                'url_scheme' => $arr_p['url_scheme_e'],
                'client_secret' => $arr_p['client_secret_e'],
                'userlog' => $_SESSION['account']['id'],
                'cert_name' => $arr_p['cert_name'],
                'fb_appid' => $arr_p['fb_appid'],
                'fb_appsecret' => $arr_p['fb_appsecret'],
                'fb_schemes' => $arr_p['fb_schemes'],
                'link_cnd_client' => $arr_p['link_cnd_client'],
                'googleproductapi' => $arr_p['googleproductapi'],
                'protocol' => $arr_p['protocol']
            );

            $result = $this->CI->ProjectsModel->edit_rows_item($arrParam, $arr_p['id']);
            $arrParam['keys_name'];
            $arrParam['platform'] = $arr_p['cbo_platform_e'];

            $getservice_id = $this->CI->ProjectsModel->getItem($_GET['id_projects']);
			$a_package_name_e = json_encode(array($arr_p['package_name_e']));
			$cbo_platform_e  =json_encode(array($arr_p['cbo_platform_e']));
            $linkInfo = 'http://misc.mobo.vn/api/clearcache?key=get_link_cdn_client&package=' . $a_package_name_e . '&service_id=' . $getservice_id['servicekeyapp'] . '&platform=' . $cbo_platform_e;
            
			$j_items = file_get_contents($linkInfo);
            // save log database
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "Cập nhật",
                "logs" => json_encode($arrParam),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id(),
                "tables" => "tbl_projects_property",
                "id_actions" => $arr_p['id']
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            // end log
            //send email
            $data['slbUser'] = $this->CI->ProjectsModel->listUser();
            $data['slProjects'] = $this->CI->ProjectsModel->getItem($arr_p['id_projects']);
            $arrParam['names'] = $data['slProjects']['names'];
            $arrParam['user'] = $data['slbUser'][$_SESSION['account']['id']]['username'];
            $arrParam['log'] = 'logupdate1&amp;table=tbl_projects_property&id=' . $arr_p['id'];

            $this->CI->Libcommon->SendAlert($arr_p['id'], $arrParam);
            //end send mail

            if ($result) {
                echo "ok";
            } else {
                echo "false";
            }
        } else {
            echo "false id " . $arr_p['id'];
        }
        exit();
    }

    public function editajax() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if (!empty($arr_p['status_app'])) {
            $otp = $this->CI->TOTP->getCode($arr_p['servicekey']);
            $arrURL = array(
                'control' => 'inside',
                'func' => 'ip_protection',
                'app' => $arr_p['servicekeyapp'],
                'action' => $arr_p['status_app'],
                'otp' => $otp,
            );
            $token = md5(implode("", $arrURL) . $arr_p['servicekey']);
            $strURL = "http://service.mobo.vn/?control=inside&func=ip_protection&" . http_build_query($arrURL) . '&token=' . $token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $strURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            MeAPI_Log::writeCsv(array("request" => $strURL, "result" => $result, "data" => json_encode($arrURL)), 'mobo_banned_ip_payment_' . date('H'));
        }
        if (isset($arr_p['code'])) {
            //lu log rows cu truoc khi cap nhat len
            $this->data['gethistory'] = $this->CI->ProjectsModel->getItem($arr_p['id']);
            $arrParam = array(
                'code' => $arr_p['code'],
                'names' => $arr_p['names'],
                'namesetup' => $arr_p['namesetup'],
                'servicekeyapp' => $arr_p['servicekeyapp'],
                'servicekey' => $arr_p['servicekey'],
                'facebookapp' => $arr_p['facebookapp'],
                'facebookappid' => $arr_p['facebookappid'],
                'facebookappsecret' => $arr_p['facebookappsecret'],
                'itunesconnect' => $arr_p['itunesconnect'],
                'appleid' => $arr_p['appleid'],
                'gacode' => $arr_p['gacode'],
                'appsflyerid' => $arr_p['appsflyerid'],
                'googleproductapi' => $arr_p['googleproductapi'],
                'urlschemes' => $arr_p['urlschemes'],
                'facebookurlschemes' => $arr_p['facebookurlschemes'],
                'googlesenderid' => $arr_p['googlesenderid'],
                'googleapikey' => $arr_p['googleapikey'],
                'facebookfanpagelink' => $arr_p['facebookfanpagelink'],
                'request_per' => $arr_p['request_per'],
                'accept_per' => $arr_p['accept_per'],
                'notes' => $arr_p['notes'],
                'screens' => $arr_p['screens'],
                'servicekey_second' => $arr_p['servicekey_second'],
                'config_logout' => $arr_p['config_logout'],
                'language_sdk' => $arr_p['language_sdk'],
                'folder' => $arr_p['folder'],
                //'tune' => $arr_p['tune'],
                'source_type' => $arr_p['sourcetype'],
                //'tune_status' => $arr_p['tune_status'],
                //'tuneconversionkey' => $arr_p['TuneConversionKey'],
                //'tunepackagename' => $arr_p['TunePackageName'],
                
                'link_android' => $arr_p['link_android'],
                'link_ios' => $arr_p['link_ios'],
                'link_wp' => $arr_p['link_wp'],
                
                'pixel_app' => $arr_p['pixel_app'],
                'pixel_key' => $arr_p['pixel_key'],
                'status_app' => $arr_p['status_app'],
                'color' => $arr_p['color'],
                'url_landing_page' => $arr_p['url_landing_page'],
            );

            $result = $this->CI->ProjectsModel->edit_new($arrParam, $arr_p['id']);
            MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'), "Edit:" . json_encode($arrParam), "Uid:" . $_SESSION['account']['id'], "Update:Ok"), "Projects_Log_" . date('H'));
            
            $getDetail = $this->CI->ProjectsModel->detailProject($arr_p['id']);
            $platform='';
            $package_name ='';
            if(count($getDetail)>0 && is_array($getDetail)){
                foreach($getDetail as $v){
                    $platform[] = $v['platform'];
                    $package_name[] = $v['package_name'];
                }
                $j_platform = json_encode(array_unique($platform));
                $j_package_name = json_encode($package_name);
            }
            $linkInfo = 'http://misc.mobo.vn/api/clearcache?key=get_link_cdn_client&package=' . $j_package_name . '&service_id=' . $arr_p['servicekeyapp'] . '&platform=' . $j_platform;
            $j_items = file_get_contents($linkInfo);
            // save log database
            array_unshift($arrParam, 'id');
            $arrParam['googleproductapi'] = base64_encode($arr_p['googleproductapi']);
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "Cập nhật",
                "logs" => json_encode($arrParam),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id(),
                "tables" => "tbl_projects",
                "id_actions" => $arr_p['id']
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            // end log
            //send email
            $data['slbUser'] = $this->CI->ProjectsModel->listUser();
            $arrParam['user'] = $data['slbUser'][$_SESSION['account']['id']]['username'];
            $arrParam['log'] = 'logupdate&table=tbl_projects&id=' . $arr_p['id'];

            $this->CI->Libcommon->SendAlert($arr_p['id'], $arrParam);
            //end send mail
            //25/02/2016 goi api clear cache
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
            curl_setopt($ch, CURLOPT_URL, 'http://graph.mobo.vn/?control=init&func=clear_tracking_tune&service_id=' . $arr_p['servicekeyapp']);
            $reponse = curl_exec($ch);
            curl_close($ch);
            //end call api

            if ($result) {
                $f = array(
                    'error' => '0',
                    'messg' => 'Cập nhật thành công ' . $result . $var
                );
            } else {
                $f = array(
                    'error' => '1',
                    'messg' => 'Thất bại ' . $result
                );
            }
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại'
            );
        }

        echo json_encode($f);
        exit();
    }

    public function addajax() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if (isset($arr_p['code'])) {
            $arrParam = array(
                'code' => $arr_p['code'],
                'names' => $arr_p['names'],
                'namesetup' => $arr_p['namesetup'],
                'servicekeyapp' => $arr_p['servicekeyapp'],
                'servicekey' => $arr_p['servicekey'],
                'facebookapp' => $arr_p['facebookapp'],
                'facebookappid' => $arr_p['facebookappid'],
                'facebookappsecret' => $arr_p['facebookappsecret'],
                'itunesconnect' => $arr_p['itunesconnect'],
                'appleid' => $arr_p['appleid'],
                'gacode' => $arr_p['gacode'],
                'appsflyerid' => $arr_p['appsflyerid'],
                'googleproductapi' => $arr_p['googleproductapi'],
                'urlschemes' => $arr_p['urlschemes'],
                'facebookurlschemes' => $arr_p['facebookurlschemes'],
                'googlesenderid' => $arr_p['googlesenderid'],
                'googleapikey' => $arr_p['googleapikey'],
                'facebookfanpagelink' => $arr_p['facebookfanpagelink'],
                'request_per' => $arr_p['request_per'],
                'accept_per' => $arr_p['accept_per'],
                'notes' => $arr_p['notes'],
                'datecreate' => date('Y-m-d H:i:s'),
                'status' => 1,
                'userlog' => $_SESSION['account']['id'],
                'screens' => $arr_p['screens'],
                'config_logout' => $arr_p['config_logout'],
                'language_sdk' => $arr_p['language_sdk'],
                'folder' => $arr_p['folder'],
                //'tune' => $arr_p['tune'],
                'source_type' => $arr_p['sourcetype'],
                //'tuneconversionkey' => $arr_p['TuneConversionKey'],
                //'tunepackagename' => $arr_p['TunePackageName'],
                'pixel_app' => $arr_p['pixel_app'],
                'pixel_key' => $arr_p['pixel_key'],
                'link_android' => $arr_p['link_android'],
                'link_ios' => $arr_p['link_ios'],
                'link_wp' => $arr_p['link_wp'],
            );

            $result = $this->CI->ProjectsModel->add_new($arrParam);
            MeAPI_Log::writeCsv(array(date('Y-m-d H:i:s'), "Add:" . json_encode($arrParam), "Uid:" . $_SESSION['account']['id'], "Add:OK"), "Projects_Log_" . date('H'));
            // save log database
            array_unshift($arrParam, 'id');
            $arrParam['googleproductapi'] = base64_encode($arr_p['googleproductapi']);
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "Cập nhật",
                "logs" => json_encode($arrParam),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id(),
                "tables" => "tbl_projects",
                "id_actions" => $result
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            // end log
            if ($result) {
                $f = array(
                    'error' => '0',
                    'messg' => 'Thành công ' . $result
                );
            } else {
                $f = array(
                    'error' => '1',
                    'messg' => 'Thất bại ' . $result
                );
            }
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại'
            );
        }

        echo json_encode($f);
        exit();
    }

    public function addajaxstep2() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if (isset($arr_p['cbo_platform'])) {
            $arrParam = array(
                'platform' => $arr_p['cbo_platform'],
                //'app_id'=>$arr_p['app_id'],
                'package_name' => $arr_p['package_name'],
                //'version_type'=>$arr_p['version_type'],
                'public_key' => $arr_p['public_key'],
                //'inapp_product'=>$arr_p['inapp_product'],
                'appstore_inapp_items' => $arr_p['appstore_inapp_items'],
                'gp_inapp_items' => $arr_p['gp_inapp_items'],
                'notes' => $arr_p['notes_p'],
                'datecreate' => date('Y-m-d H:i:s'),
                'status' => 1,
                'userlog' => $_SESSION['account']['id']
            );

            $result = $this->CI->ProjectsModel->add_new_proper($arrParam, $arr_p['id_projects']);
            // save log database
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "Tạo mới [2]",
                "logs" => json_encode($arrParam),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id()
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            // end log
            if ($result) {
                $f = array(
                    'error' => '0',
                    'messg' => 'Thành công ' . $result
                );
            } else {
                $f = array(
                    'error' => '1',
                    'messg' => 'Thất bại ' . $result
                );
            }
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại'
            );
        }

        echo json_encode($f);
        exit();
    }

    public function addinapp() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if (isset($arr_p['id_projects'])) {
            //insert payment (type inapp)
            $arrinapp = explode('|', $arr_p['code']);
            if (count($arrinapp) > 0) {
                for ($i = 0; $i < count($arrinapp); $i++) {
                    if ($i == (count($arrinapp) - 1))
                        break;
                    $arrParam_payment = array(
                        'id_projects' => $arr_p['id_projects'],
                        'id_projects_property' => $arr_p['id_projects_property'],
                        'type' => 'inapp',
                        'code' => $arrinapp[$i],
                        'datecreate' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'userlog' => $_SESSION['account']['id']
                    );
                    $pay = $this->CI->ProjectsModel->add_payment($arrParam_payment, $arr_p['id_projects']);
                }//end for
            }
            $f = array(
                'error' => '0',
                'messg' => 'Thành công '
            );
        }else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại '
            );
        }
        echo json_encode($f);
        exit();
    }

    public function addinappplus() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if (isset($arr_p['id_projects'])) {
            //insert payment (type inapp)
            $arrinapp = explode('|', $arr_p['code']);

            if (count($arrinapp) > 0) {
                for ($i = 0; $i < count($arrinapp); $i++) {
                    if ($i == (count($arrinapp) - 1))
                        break;
                    // phan ra phan tu $arrinapp
                    $item = explode(';', $arrinapp[$i]);

                    $arrParam_payment = array(
                        'id_projects' => $arr_p['id_projects'],
                        'id_projects_property' => $arr_p['id_projects_property'],
                        'type' => 'inapp',
                        'code' => $item[0],
                        'promotion_gem' => $item[1],
                        'gem' => $item[2],
                        'mcoin' => $item[3],
                        'vnd' => $item[4],
                        'datecreate' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'userlog' => $_SESSION['account']['id']
                    );
                    $pay = $this->CI->ProjectsModel->add_payment($arrParam_payment, $arr_p['id_projects']);
                }//end for
            }
            $f = array(
                'error' => '0',
                'messg' => 'Thành công '
            );
        }else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại '
            );
        }
        echo json_encode($f);
        exit();
    }

    public function addpaymentplus() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if (isset($arr_p['code'])) {
            //insert payment (type inapp)
            $arrinapp = explode('|', $arr_p['code']);

            if (count($arrinapp) > 0) {
                for ($i = 0; $i < count($arrinapp); $i++) {
                    if ($i == (count($arrinapp) - 1))
                        break;
                    // phan ra phan tu $arrinapp
                    $item = explode(';', $arrinapp[$i]);
                    $v_type = explode(':', $item[0]);
                    $v_code = explode(':', $item[1]);
                    $v_vnd = explode(':', $item[2]);
                    $v_mcoin = explode(':', $item[3]);
                    $v_gem = explode(':', $item[4]);
                    $v_promotion_gem = explode(':', $item[5]);
                    $v_notes = explode(':', $item[6]);
                    $arrParam_payment = array(
                        'id_projects' => $arr_p['id_projects'],
                        'id_projects_property' => -1,
                        'type' => trim($v_type[1]),
                        'code' => $v_code[1],
                        'promotion_gem' => trim(str_replace(array(',', '.'), '', $v_promotion_gem[1])),
                        'gem' => trim(str_replace(array(',', '.'), '', $v_gem[1])),
                        'mcoin' => trim(str_replace(array(',', '.'), '', $v_mcoin[1])),
                        'vnd' => trim(str_replace(array(',', '.'), '', $v_vnd[1])),
                        'notes' => $v_notes[1],
                        'datecreate' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'userlog' => $_SESSION['account']['id']
                    );
                    $pay = $this->CI->ProjectsModel->add_payment_plus($arrParam_payment);
                }//end for
            } //end if
            // dong bo data payment
            $this->callapipayment($arr_p['id_projects']);

            $f = array(
                'error' => '0',
                'messg' => 'Thành công '
            );
        }else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại '
            );
        }
        echo json_encode($f);
        exit();
    }

    public function addpaymentplusforinapp() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if (isset($arr_p['code'])) {
            //insert payment (type inapp)
            $arrinapp = explode('|', $arr_p['code']);

            if (count($arrinapp) > 0) {
                for ($i = 0; $i < count($arrinapp); $i++) {
                    if ($i == (count($arrinapp) - 1))
                        break;
                    // phan ra phan tu $arrinapp
                    $item = explode(';', $arrinapp[$i]);
                    $v_type = explode(':', $item[0]);
                    $v_code = explode(':', $item[1]);
                    $v_vnd = explode(':', $item[2]);
                    $v_mcoin = explode(':', $item[3]);
                    $v_gem = explode(':', $item[4]);
                    $v_promotion_gem = explode(':', $item[5]);
                    $v_notes = explode(':', $item[6]);
                    $v_id_projects_property = explode(':', $item[7]);
                    $arrParam_payment = array(
                        'id_projects' => $arr_p['id_projects'],
                        'id_projects_property' => $v_id_projects_property[1],
                        'type' => trim($v_type[1]),
                        'code' => $v_code[1],
                        'promotion_gem' => trim(str_replace(array(',', '.'), '', $v_promotion_gem[1])),
                        'gem' => trim(str_replace(array(',', '.'), '', $v_gem[1])),
                        'mcoin' => trim(str_replace(array(',', '.'), '', $v_mcoin[1])),
                        'vnd' => trim(str_replace(array(',', '.'), '', $v_vnd[1])),
                        'notes' => $v_notes[1],
                        'datecreate' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'userlog' => $_SESSION['account']['id']
                    );
                    $pay = $this->CI->ProjectsModel->add_payment_plus($arrParam_payment);
                }//end for
            } //end if
            // dong bo data payment
            $this->callapipayment($arr_p['id_projects']);

            $f = array(
                'error' => '0',
                'messg' => 'Thành công '
            );
        }else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại '
            );
        }
        echo json_encode($f);
        exit();
    }

    public function addajaxstep2new() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if (isset($arr_p['cbo_platform'])) {
            $arrParam = array(
                'platform' => $arr_p['cbo_platform'],
                'package_name' => $arr_p['package_name'],
                'public_key' => $arr_p['public_key'],
                'inapp_items' => $arr_p['inapp_items'],
                'wp_p1' => $arr_p['wp_p1'],
                'wp_p2' => $arr_p['wp_p2'],
                'notes' => $arr_p['notes_p'],
                'datecreate' => date('Y-m-d H:i:s'),
                'status' => 1,
                'userlog' => $_SESSION['account']['id'],
                'files_certificates' => "files/certificates/" . $arr_p['files_certificates'],
                'pass_certificates' => $arr_p['pass_certificates'],
                'api_key' => $arr_p['api_key'],
                'client_key' => $arr_p['client_key'],
                'url_scheme' => $arr_p['url_scheme'],
                'client_secret' => $arr_p['client_secret'],
                'app_id' => $arr_p['app_id'],
				'store_id' => $arr_p['store_id'],
                'park_id' => $arr_p['park_id'],
                'cert_name' => $arr_p['cert_name'],
                'fb_appid' => $arr_p['facebookappid'],
                'fb_appsecret' => $arr_p['facebookappsecret'],
                'fb_schemes' => $arr_p['facebookurlschemes'],
                'link_cnd_client' => $arr_p['link_cnd_client'],
                'googleproductapi' => $arr_p['googleproductapi'],
                'protocol' => $arr_p['protocol']
            );

            $result = $this->CI->ProjectsModel->add_new_proper_new($arrParam, $arr_p['id_projects']);
            $getservice_id = $this->CI->ProjectsModel->getItem($_GET['id_projects']);
			
			$package_name_e = json_encode(array($arr_p['package_name_e']));
			$cbo_platform_e = json_encode(array($arr_p['cbo_platform_e']));
            $linkInfo = 'http://misc.mobo.vn/api/clearcache?key=get_link_cdn_client&package=' . $package_name_e . '&service_id=' . $getservice_id['servicekeyapp'] . '&platform=' . $cbo_platform_e;
            $j_items = file_get_contents($linkInfo);
            //insert payment (type inapp)
            $arrinapp = explode('|', $arr_p['inapp_items']);
            if (count($arrinapp) > 0) {
                for ($i = 0; $i < count($arrinapp); $i++) {
                    if ($i == (count($arrinapp) - 1))
                        break;
                    $arrParam_payment = array(
                        'type' => 'inapp',
                        'code' => $arrinapp[$i],
                        'datecreate' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'userlog' => $_SESSION['account']['id']
                    );
                    $pay = $this->CI->ProjectsModel->add_payment($arrParam_payment, $arr_p['id_projects']);
                }//end for
            }
            // save log database
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "Tạo mới [2]",
                "logs" => json_encode($arrParam),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id()
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            // end log
            if ($result) {
                //update 08/01/2016 add bundle ios ban Appstore vao tbl_sign_ios_keys_queries_schemes
                if ($arr_p['cbo_platform'] == "ios") {
                    $bool = $this->CI->SignHistoryAppModel->checkexitskeyvalues($arr_p['package_name']);
                    if (count($bool) == 0) {
                        $arrFilter = array(
                            'notes' => $arr_p['package_name'],
                            'datecreate' => date('Y-m-d H:i:s'),
                            'userlog' => $_SESSION['account']['id']
                        );
                        $id = $this->CI->SignHistoryAppModel->addkeyvalues($arrFilter);
                    } //end if
                }//end if
                // end add bundle
                $f = array(
                    'error' => '0',
                    'messg' => 'Thành công '
                );
            } else {
                $f = array(
                    'error' => '1',
                    'messg' => 'Thất bại ' . $result
                );
            }
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại'
            );
        }

        echo json_encode($f);
        exit();
    }

// end 2 new

    public function deleteoneitemrow() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['id'] > 0) {
            //lu log rows cu truoc khi cap nhat len
            $this->data['gethistory'] = $this->CI->ProjectsModel->getItem($arr_p['id']);
            
            $getDetail = $this->CI->ProjectsModel->detailProject($arr_p['id']);
            $platform='';
            $package_name ='';
            if(count($getDetail)>0 && is_array($getDetail)){
                foreach($getDetail as $v){
                    $platform[] = $v['platform'];
                    $package_name[] = $v['package_name'];
                }
                $j_platform = json_encode(array_unique($platform));
                $j_package_name = json_encode($package_name);
            }
            $linkInfo = 'http://misc.mobo.vn/api/clearcache?key=get_link_cdn_client&package=' . $j_package_name . '&service_id=' . $this->data['gethistory']['servicekeyapp'] . '&platform=' . $j_platform;
            $j_items = file_get_contents($linkInfo);
            
            
            // save log database
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "Xóa dữ liệu [1]",
                "logs" => json_encode($this->data['gethistory']),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id()
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            $result = $this->CI->ProjectsModel->deleteoneitem($arr_p['id']);
            // end log
            if ($result != NULL) {
                $data['info'] = 'Xóa thành công';
            } else {
                $data['info'] = 'Không thể xóa dòng này, đang có dữ liệu tham chiếu đến';
            }
        } else {
            $data['info'] = 'Xóa thất bại';
        }
        redirect($this->_mainAction . "&info=" . base64_encode($data['info']));
    }

    public function loadlist() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['isok'] > 0) {
            $data['list'] = $this->CI->ProjectsModel->loadlist();
            $f = array(
                'error' => '0',
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('projects/list', $data, true)
            );
        } else {
            $data['list'] = array();
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại',
                'html' => $this->CI->load->view('projects/list', $data, true)
            );
        }
        echo json_encode($f);
        exit();
    }

    public function loadlistplus() {
        if ($_GET['id_project'] > 0) {
            $fillter = isset($_GET['fillter']) ? $_GET['fillter'] : "";
            //phan trang ajax
            $this->CI->load->MeAPI_Library('Pgt');
            if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $per_page = 15;
            $pa = $page - 1;
            $start = $pa * $per_page;

            //$data['start'] = $start;
            $listItems = $this->CI->ProjectsModel->loadlistplus($_GET['id_project'], $fillter);

            $total = count($listItems);
            $config = array();
            $config['cur_page'] = $page;
            $config['base_url'] = base_url() . '?control=projects&func=loadlistplus';
            $config['total_rows'] = $total;
            $config['per_page'] = $per_page;
            $this->CI->Pgt->cfig($config);
            $data['pages'] = $this->CI->Pgt->create_links_ajax();
            $listData = FALSE;
            if (empty($listItems) !== TRUE) {
                $listData = array_slice($listItems, $start, $per_page);
            }
            $data['slbUser'] = $this->CI->ProjectsModel->listUser();
            $data['list'] = $listData;
            $data['total'] = $total;
            if ($data['list'] != 0) {
                $f = array(
                    'error' => '0',
                    'messg' => 'Thành công',
                    'html' => $this->CI->load->view('projects/list', $data, true)
                );
            } else {
                $data['list'] = array();
                $f = array(
                    'error' => '1',
                    'messg' => 'Thất bại',
                    'html' => $this->CI->load->view('projects/list', $data, true)
                );
            }
        } else {
            $data['list'] = array();
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại',
                'html' => $this->CI->load->view('projects/list', $data, true)
            );
        }
        echo json_encode($f);
        exit();
    }

    //xoa 1 phan tu in app item
    public function deletedinappitem() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['id'] > 0) {
            $arrParam = array(
                'id' => $arr_p['id']
            );
            $reults = $this->CI->ProjectsModel->deletePayment($arrParam, 0);
            if ($reults) {
                $f = array(
                    'error' => '0',
                    'messg' => 'Thành công '
                );
            } else {
                $f = array(
                    'error' => '1',
                    'messg' => 'Thất bại '
                );
            }
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại '
            );
        }
        echo json_encode($f);
        exit();
    }

    //ham xoa payment theo cap cha
    public function deleteListPayment($id_projects, $id_projects_property, $type) {
        $isok = true;
        $arrParam = array(
            'id_projects' => $id_projects,
            'id_projects_property' => $id_projects_property
        );
        $reults = $this->CI->ProjectsModel->deletePayment($arrParam, $type);
        if ($reults) {
            $isok = true;
        } else {
            $isok = false;
        }
        return $isok;
    }

    public function deletelistinappitem() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        $this->data['gethistory'] = $this->CI->ProjectsModel->getPayment($arr_p['id']);
        if ($arr_p['id'] > 0) {
            $getitem = $this->CI->ProjectsModel->getItem($this->data['gethistory']['id_projects']);
            $linkInfo = 'http://misc.mobo.vn/api/clearcache?key=exchangeratelist&service_id='.$getitem['servicekeyapp'];
            file_get_contents($linkInfo);
            $arrParam = array(
                'id' => $arr_p['id']
            );
            $reults = $this->CI->ProjectsModel->deletePayment($arrParam, 0);
            //ghi nhat ky
            // save log database
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "Xóa Payment",
                "logs" => json_encode($this->data['gethistory']),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id(),
                "tables" => "tbl_projects_payment"
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            if ($reults) {
                $f = array(
                    'error' => '0',
                    'messg' => 'Thành công ' . $reults
                );
            } else {
                $f = array(
                    'error' => '1',
                    'messg' => 'Thất bại ' . $reults
                );
            }
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại'
            );
        }
        echo json_encode($f);
        exit();
    }

    public function deletelist() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['id'] > 0) {
            //lu log rows cu truoc khi cap nhat len
            $this->data['gethistory'] = $this->CI->ProjectsModel->getItemChild($arr_p['id']);
            // save log database
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "Xóa dữ liệu [2]",
                "logs" => json_encode($this->data['gethistory']),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id()
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            $getservice_id = $this->CI->ProjectsModel->getItem($_GET['id_projects']);
			
			$package_name_e = json_encode(array($arr_p['package_name_e']));
			$cbo_platform_e = json_encode(array($arr_p['cbo_platform_e']));
            $linkInfo = 'http://misc.mobo.vn/api/clearcache?key=get_link_cdn_client&package=' . $package_name_e . '&service_id=' . $getservice_id['servicekeyapp'] . '&platform=' .$cbo_platform_e ;
            $j_items = file_get_contents($linkInfo);
            // end log
            //kiem tra xem co payment hay khong
            $pay = $this->deleteListPayment($arr_p['id_projects'], $arr_p['id'], 1);
            if ($pay) {
                $reults = $this->CI->ProjectsModel->deletelistitem($arr_p['id']);
                if ($reults) {
                    $f = array(
                        'error' => '0',
                        'messg' => 'Thành công ' . $reults
                    );
                } else {
                    $f = array(
                        'error' => '1',
                        'messg' => 'Thất bại ' . $reults
                    );
                }
            } else {
                $f = array(
                    'error' => '1',
                    'messg' => 'Không xóa được Payment' . $pay
                );
            }
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại'
            );
        }
        echo json_encode($f);
        exit();
    }

    public function checkpayment() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        $reults = $this->CI->ProjectsModel->checkListPayment($arr_p['id_projects'], $arr_p['id_projects_property']);
        if ($reults == true) {
            $f = array(
                'error' => '0',
                'messg' => 'Có paymnet'
            );
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Không có payment'
            );
        }
        echo json_encode($f);
        exit();
    }

    /* kiểm tra trùng mã Projects */

    public function checkcodeexist() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        $reults = $this->CI->ProjectsModel->checkcodeexist($arr_p['code']);
        if ($reults == true) {
            $f = array(
                'error' => '0',
                'messg' => 'Mã đã tồn tại'
            );
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Chưa có mã này'
            );
        }
        echo json_encode($f);
        exit();
    }

    /* kiểm tra trùng mã Bundle/Package */

    public function checkbundleisexit() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['types'] == "edit") {
            $reults = $this->CI->ProjectsModel->bundleisexit($arr_p, "edit");
        } else {
            $reults = $this->CI->ProjectsModel->bundleisexit($arr_p, "add");
        }

        if ($reults == true) {
            $f = array(
                'error' => '0',
                'messg' => 'Bundle/Package đã tồn tại'
            );
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Chưa có Bundle/Package này'
            );
        }
        echo json_encode($f);
        exit();
    }

    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('msv_id', $arrParam['code']);
            $this->CI->Session->unset_session('platform', $arrParam['cbo_platform']);
            $this->CI->Session->unset_session('status', $arrParam['cbo_status']);
            $this->CI->Session->unset_session('service_id', $arrParam['cbo_app']);
        }
    }

    //add 22_09_2015
    public function viewpayment(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['error'] = '';
        $this->CI->load->library('form_validation');
        $arrPost = $this->CI->security->xss_clean($_POST);
        $arrGet = $this->CI->security->xss_clean($_GET);
        $this->data['getitem'] = $this->CI->ProjectsModel->getItem($arrGet['id_projects']);
        $this->data['title'] = 'Thông tin Payment của Game <strong style="color:#BB25AE">' . $this->data['getitem']['names'] . '</strong>';
        //đồng bộ data payment
        if (isset($_POST['btn_update_system_payment'])) {
            $this->callapipayment($arrGet['id_projects']);
        }
        if (isset($_POST['btn_update_rate'])) {
            $linkInfo = 'http://misc.mobo.vn/api/clearcache?key=exchangeratelist&service_id='.$this->data['getitem']['servicekeyapp'];
            file_get_contents($linkInfo);
            $arr_param = array(
                "id_projects" => $arrGet['id_projects'],
                "mcoin" => $arrPost['rate_mcoin'],
                "gem" => $arrPost['rate_gem'],
                "units" => $arrPost['units'],
                "datecreate" => date('Y-m-d H:i:s'),
                "userlog" => $_SESSION['account']['id']
            );
            $rate = $this->CI->ProjectsModel->update_rate($arr_param);
            //cap nhat lai tat ca ty gia trong bang payment theo projects
            if ($arrPost['rate_mcoin'] != 0 && $arrPost['rate_gem'] != 0) {
                $rate_payment = $this->CI->ProjectsModel->update_rate_payment($arr_param, 1);
            }
            //send data payment
            $this->callapipayment($arrGet['id_projects']);
        }
        $this->data['getrate'] = $this->CI->ProjectsModel->getRate($arrGet['id_projects']);
        if (isset($arrGet['action']) && $arrGet['action'] == "add") {
            $arr_param = array(
                "id_projects" => $arrGet['id_projects'],
                "type" => $arrPost['cbo_type'],
                "code" => $arrPost['code'],
                "promotion_gem" => $arrPost['promotion_gem'],
                "gem" => $arrPost['gem'],
                "mcoin" => $arrPost['mcoin'],
                "vnd" => $arrPost['vnd'],
                "notes" => $arrPost['notes'],
                "datecreate" => date('Y-m-d H:i:s'),
                "status" => 1,
                "userlog" => $_SESSION['account']['id']
            );
            $result = $this->CI->ProjectsModel->add_payment_plus($arr_param);
            if ($result) {
                $this->data['error'] = "Thêm mới Payment thành công";
            } else {
                $this->data['error'] = "Không thêm được";
            }
        }
        //load danh sách
        //$arrFilter = array();
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter = array(
                'id_projects' => $arrGet['id_projects'],
                'page' => $page
            );
            //$arrFilter["page"] = $page;
        } else {
            $arrFilter = array(
                'id_projects' => $arrGet['id_projects'],
                'page' => 1
            );
            $page = 1;
        }
        //get platform on tbl_projects_property1
        $this->data['tpp1'] = $this->CI->ProjectsModel->getListChildByIdparrent($arrGet['id_projects']);


        $per_page = 100000;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;
        $listItems = $this->CI->ProjectsModel->listPaymentView($arrFilter);

        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=' . $_GET['control'] . '&func=viewpayment&id_projects=' . $_GET['id_projects'];
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if (empty($listItems) !== TRUE) {
            $listData = array_slice($listItems, $start, $per_page);
        }
        //$listData = $this->CI->ProjectsModel->listPaymentView($arrFilter);
        $this->data['property'] = $this->CI->ProjectsModel->listProjectsProperty(intval($_GET['id_projects']));
        $this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
        $this->data['listData'] = $listData;
        $this->CI->template->write_view('content', 'projects/viewpayment', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function paymentlist(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['getitem'] = $this->CI->ProjectsModel->getItem($_GET['id_projects']);
        $this->data['title'] = 'Thông tin Payment [<strong style="color:#090">' . $_GET['info_package'] . '</strong>] thuộc Projects [<strong style="color:#090">' . $this->data['getitem']['names'] . '</strong>]';
        $this->data['error'] = '';
        $this->CI->load->library('form_validation');
        $arrPost = $this->CI->security->xss_clean($_POST);
        $arrGet = $this->CI->security->xss_clean($_GET);
        if (isset($arrGet['action']) && $arrGet['action'] == "add") {
            $arr_param = array(
                "id_projects" => $arrGet['id_projects'],
                "id_projects_property" => $arrGet['id_projects_property'],
                "type" => $arrPost['cbo_type'],
                "code" => $arrPost['code'],
                "promotion_gem" => trim(str_replace(array(',', '.'), '', $arrPost['promotion_gem'])),
                "gem" => trim(str_replace(array(',', '.'), '', $arrPost['gem'])),
                "mcoin" => trim(str_replace(array(',', '.'), '', $arrPost['mcoin'])),
                "vnd" => trim(str_replace(array(',', '.'), '', $arrPost['vnd'])),
                "notes" => $arrPost['notes'],
                "datecreate" => date('Y-m-d H:i:s'),
                "status" => 1,
                "userlog" => $_SESSION['account']['id']
            );
            $result = $this->CI->ProjectsModel->add_payment_plus($arr_param);
            if ($result) {
                $this->data['error'] = "Thêm mới Payment thành công";
            } else {
                $this->data['error'] = "Không thêm được";
            }
            redirect(base_url() . "?control=projects&func=paymentlist&id_projects=" . $_GET['id_projects'] . "&id_projects_property=" . $_GET['id_projects_property'] . "&info_package=" . $_GET['info_package']);
        }
        //load danh sách InAppItem
        $arrFilter = array(
            'type' => 'inapp',
            'id_projects' => $arrGet['id_projects'],
            'id_projects_property' => $arrGet['id_projects_property']
        );
        $this->data['getrate'] = $this->CI->ProjectsModel->getRate($arrGet['id_projects']);
        $this->data['slbUser'] = $this->CI->ProjectsModel->listUser();
        $listData = $this->CI->ProjectsModel->listPayment($arrFilter);
        $this->data['listData'] = $listData;
        $this->CI->template->write_view('content', 'projects/paymentlist', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

// end function

    public function updaterowsinappitem() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['id'] > 0) {
            $getitem = $this->CI->ProjectsModel->getItem($arr_p['id_projects']);
            $linkInfo = 'http://misc.mobo.vn/api/clearcache?key=exchangeratelist&service_id='.$getitem['servicekeyapp'];
            file_get_contents($linkInfo);
            
            $arrParam = array(
                'id' => $arr_p['id'],
                'code' => $arr_p['code_e'],
                'promotion_gem' => trim(str_replace(array(',', '.'), '', $arr_p['promotion_gem_e'])),
                'gem' => trim(str_replace(array(',', '.'), '', $arr_p['gem_e'])),
                'mcoin' => trim(str_replace(array(',', '.'), '', $arr_p['mcoin_e'])),
                'vnd' => trim(str_replace(array(',', '.'), '', $arr_p['vnd_e'])),
                'notes' => $arr_p['notes_e'],
                "datecreate" => date('Y-m-d H:i:s'),
                "userlog" => $_SESSION['account']['id']
            );

            $result = $this->CI->ProjectsModel->edit_rows_item_payment($arrParam, $arr_p['id']);

            // save log database
            $arrParam['type'] = "inapp";
            $arr_log = array(
                "username" => $_SESSION['account']['id'],
                "timesmodify" => date('Y-m-d H:i:s'),
                "actions" => "update_payment_inapp",
                "logs" => json_encode($arrParam),
                "urls" => $_SERVER['REQUEST_URI'],
                "ipaddress" => $_SERVER['REMOTE_ADDR'],
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "device" => $this->getdevice(),
                "sessionuser" => session_id(),
                "tables" => "tbl_projects_payment",
                "id_actions" => $arr_p['id']
            );
            $log = $this->CI->ProjectsModel->savelogdaily($arr_log);
            // end log
            //call data payment
            $this->callapipayment($arr_p['id_projects']);

            if ($result) {
                echo "ok";
            } else {
                echo "false";
            }
        } else {
            echo "false id " . $arr_p['id'];
        }
        exit();
    }

//end function

    public function updaterate() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['id_projects'] > 0) {
            $arrParam = array(
                'id_projects' => $arr_p['id_projects'],
                'mcoin' => $arr_p['mcoin'],
                'gem' => $arr_p['gem'],
                "datecreate" => date('Y-m-d H:i:s'),
                'userlog' => $_SESSION['account']['id']
            );

            $rate = $this->CI->ProjectsModel->update_rate($arrParam);
            //cap nhat lai tat ca ty gia trong bang payment theo projects
            $rate_payment = $this->CI->ProjectsModel->update_rate_payment($arrParam, 1);
            //đồng bộ data payment
            $this->callapipayment($arr_p['id_projects']);

            if ($rate_payment) {
                echo "ok";
            } else {
                echo "false";
            }
        } else {
            echo "false id " . $arr_p['id'];
        }
        exit();
    }

//end function

    public function getpackage() {
        if (isset($_GET['id_projects'])) {
            $data['package'] = $this->CI->ProjectsModel->getpackagename($_GET['id_projects'], $_GET['platform']);
            $f = array(
                'error' => '0',
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('projects/cbo_pakage', $data, true)
            );
        } else {
            $data['package'] = array();
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại',
                'html' => $this->CI->load->view('projects/cbo_pakage', $data, true)
            );
        }

        echo json_encode($f);
        exit();
    }

    //send data to system payment
    public function callapipayment($idprojects) {
        //$arrGet = $this->CI->security->xss_clean($_GET);
        $arrGet['id_projects'] = $idprojects;
        if (isset($arrGet['id_projects'])) {

            try {
                $data['getitem'] = $this->CI->ProjectsModel->getItem($arrGet['id_projects']);
                $data['getrate'] = $this->CI->ProjectsModel->getRate($arrGet['id_projects']);
                $json_payment = '{"game_title": {"en": "' . $data['getitem']['namesetup'] . '","vi": "' . $data['getitem']['namesetup'] . '"},"game_currency": {"en": "' . $data['getrate']['units'] . '","vi": "' . $data['getrate']['units'] . '"},"money_currency": {"en": "VND","vi": "VND"},"rate_list": {';
                $json_str_type = "";
                $json_str_item = "";
                $json_str_item_inapp = "";
                $json_str_type_platform = "";
                $name_code_compa = "";
                $items_inapp = "";
                $t_c_p = "";
                $j = 0;
                //loc loai payment
                $data['arr_type'] = $this->CI->ProjectsModel->FilterTypePayment($arrGet['id_projects']);

                foreach ($data['arr_type'] as $type) {
                    if ($type['type'] == "inapp") {
                        //nếu là inapp
                        //kiem tra platform
                        $data['arr_payment_platform'] = $this->CI->ProjectsModel->ReturnJsonInappFilterPlatform($arrGet['id_projects'], $type['type']);
                        //loc theo platform
                        foreach ($data['arr_payment_platform'] as $platform) {
                            $data['arr_payment_t'] = $this->CI->ProjectsModel->ReturnJsonInapp($arrGet['id_projects'], $type['type'], $platform['platform']);
                            foreach ($data['arr_payment_t'] as $items) {
                                $t = "";
                                $arrcode = explode(".", $items['code']);
                                //lấy phần tử cuối mảng
                                $usd = $arrcode[count($arrcode) - 1];
                                $usd = $usd - 0.01;
                                //sau đó xóa phần tử cuối mảng
                                unset($arrcode[count($arrcode) - 1]);
                                //sau đó biến mảng thành 1 cuỗi
                                $knb = (int) $items['gem'] + (int) $items['promotion_gem'];
                                $name_code = implode(".", $arrcode);


                                if ($platform['platform'] == "ios") {
                                    $t = "apple";
                                } elseif ($platform['platform'] == "android") {
                                    $t = "google";
                                } else {
                                    $t = "winphone";
                                }

                                if ($j > 0) {
                                    if ($t_c_p == $t) {
                                        if ($name_code_compa == $name_code) {
                                            $json_str_item_inapp = $json_str_item_inapp . '{"identify": "' . $usd . '","message": "' . $usd . ' {money_currency}","description": "' . $knb . ' {game_currency}"},';
                                            //$json_str_type_platform=$json_str_type_platform.'"'.$type['type'].'_'.$t.'": { "title": {"vi": "'.$name_code.'","en": "'.$name_code.'"},"items": ['.$json_str_item_inapp.'{}]},';
                                            //sau đó gán tên vào bien de so sanh
                                            $name_code_compa = $name_code;
                                            $t_c_p = $t;
                                            $j++;
                                        } else {
                                            $name_code_compa = ""; //xóa biến so sánh name
                                        }
                                    } else {
                                        $t_c_p = $t; // xóa biết so sánh platform
                                        $j = 0; // trở về trạng thái ban đầu
                                    }//end if
                                }//end if
                                //lần đầu chạy vòng for
                                if ($j == 0) {
                                    $json_str_item_inapp = $json_str_item_inapp . '{"identify": "' . $usd . '","message": "' . $usd . ' {money_currency}","description": "' . $knb . ' {game_currency}"},';
                                    //$json_str_type_platform=$json_str_type_platform.'"'.$type['type'].'_'.$t.'": { "title": {"vi": "'.$name_code.'","en": "'.$name_code.'"},"items": ['.$json_str_item_inapp.'{}]},';
                                    //sau đó gán tên vào bien de so sanh
                                    $name_code_compa = $name_code;
                                    $t_c_p = $t;
                                    $j++;
                                }
                            }//end for
                            $j = 0;
                            $name_code_compa = "";
                            $json_str_type_platform = $json_str_type_platform . '"' . $type['type'] . '_' . $t . '": { "title": {"vi": "' . $name_code . '","en": "' . $name_code . '"},"items": [' . $json_str_item_inapp . '{}]},';
                            $json_str_item_inapp = "";
                        }//end for

                        $t_c_p = "";
                    }//end if inapp
                }//end for


                foreach ($data['arr_type'] as $type) {

                    if ($type['type'] != "inapp") {

                        $data['arr_payment'] = $this->CI->ProjectsModel->ReturnJson($arrGet['id_projects'], $type['type']);
                        foreach ($data['arr_payment'] as $items) {
                            $knb1 = (int) $items['gem'] + (int) $items['promotion_gem'];
                            $json_str_item = $json_str_item . '{"identify": "' . $items['vnd'] . '","message": "' . $items['vnd'] . ' {money_currency}","description": "' . $knb1 . ' {game_currency}"},';
                        }//end for
                        $json_str_type = $json_str_type . '"' . $type['type'] . '": { "title": {"vi": "' . $type['code'] . '","en": "' . $type['code'] . '"},"items": [' . $json_str_item . '{}]},';
                        $json_str_item = "";
                    }//end if
                }//end for

                $json_payment = $json_payment . $json_str_type_platform . $json_str_type . "\"\": \"\"}}";
                //$_POST['btn_json']=json_decode($json_payment);


                $otp = $this->CI->Graph_Inside_API->get_otp_payment();
                $token = md5('commonginsideupdate_payment_rate' . str_replace(',{}', '', $json_payment) . $data['getitem']['servicekeyapp'] . $data['getitem']['names'] . 'lechinh' . $otp . $this->CI->Graph_Inside_API->get_Secretkey_payment());
                $post_array = array(
                    "control" => 'common',
                    "app" => 'ginside',
                    "func" => 'update_payment_rate',
                    "content" => str_replace(',{}', '', $json_payment),
                    "game_id" => $data['getitem']['servicekeyapp'],
                    "game_name" => $data['getitem']['names'],
                    "user_edit" => 'lechinh',
                    "otp" => $otp,
                    "token" => $token
                );
                //$token=md5('commonginsideupdate_payment_rate'.$data['getitem']['servicekeyapp'].$data['getitem']['names'].'lechinh'.$otp.$this->CI->Graph_Inside_API->get_Secretkey_payment());
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 1024);
                //curl_setopt($ch, CURLOPT_URL, 'http://service.mobo.vn/?control=common&app=ginside&func=update_payment_rate&content='.$post_array['content'].'&game_id='.$data['getitem']['servicekeyapp'].'&game_name='.$data['getitem']['names'].'&user_edit=lechinh&otp='.$otp.'&token='.$token);
				
				if ($data['getitem']['servicekeyapp'] >= 1000)
					curl_setopt($ch, CURLOPT_URL, 'http://misc.dllglobal.net/app/payment_list_store'); // game global banca888, bai88
				else
					curl_setopt($ch, CURLOPT_URL, 'http://service.mobo.vn/'); // game nhập china
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                $reponse = curl_exec($ch);
                //$arrReponse = json_decode($reponse,true);
                curl_close($ch);
                //echo 'http://service.mobo.vn/?control=common&app=ginside&func=update_payment_rate&content='.$post_array['content'].'&game_id='.$data['getitem']['servicekeyapp'].'&game_name='.$data['getitem']['names'].'&user_edit=lechinh&otp='.$otp.'&token='.$token;
                //exit();
                $f = array(
                    'error' => '0',
                    'messg' => 'Successfull ' . $reponse
                );
            } catch (Exception $e) {
                $f = array(
                    'error' => '0',
                    'messg' => 'Error API: ' . $reponse
                );
            }
        } else {
            $data['package'] = array();
            $f = array(
                'error' => '1',
                'messg' => 'UnSuccessfull !Please try again'
            );
        }

        $if = json_decode($reponse);
        $code = $if->{'code'};
        if ($code != "1000") {
            echo "Không đồng bộ được Payment. Error API";
            echo "<br>" . $reponse;
        }
        //ghi log
        $link = 'http://service.mobo.vn/?control=common&app=ginside&func=update_payment_rate&content=' . $post_array['content'] . '&game_id=' . $data['getitem']['servicekeyapp'] . '&game_name=' . $data['getitem']['names'] . '&user_edit=lechinh&otp=' . $otp . '&token=' . $token;
        $arrPay = array(
            'projects_id' => $idprojects,
            'data_values' => $reponse,
            'links_url' => $link,
            "dateupdate" => date('Y-m-d H:i:s'),
            'user_id' => $_SESSION['account']['id']
        );
        $this->CI->ProjectsModel->save_log_payment($arrPay);

        //echo 'commonginsideupdate_payment_ratejson'.$data['getitem']['servicekeyapp'].$data['getitem']['names'].'lechinh'.$otp
        //echo $link='http://service.mobo.vn/?control=common&app=ginside&func=update_payment_rate&content='.$post_array['content'].'&game_id='.$data['getitem']['servicekeyapp'].'&game_name='.$data['getitem']['names'].'&user_edit=lechinh&otp='.$otp.'&token='.$token;
        //echo $rs=file_get_contents($link);
        //echo $post_array['content'];
        /* $this->CI->template->write_view('content', 'projects/viewpayment', $this->data);
          $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML()); */
        //echo json_encode($f);
        //exit();
    }

    public function updatestatus() {
        $arr_p = $this->CI->security->xss_clean($_GET);
        if ($arr_p['id'] > 0) {
            $arrFill = array(
                'id' => intval($arr_p['id']),
                'status' => intval($arr_p['status'])
            );
            $result = $this->CI->ProjectsModel->updatestatus($arrFill);
            $data['status'] = $this->CI->ProjectsModel->getItem(intval($arr_p['id']));
            $f = array(
                'error' => '0',
                'messg' => 'Thành công',
                'html' => $this->CI->load->view('projects/status', $data, true)
            );
        } else {
            $f = array(
                'error' => '1',
                'messg' => 'Thất bại',
                'html' => 'Fail'
            );
        }
        echo json_encode($f);
        exit();
    }

    public function getResponse() {
        return $this->_response;
    }

}
