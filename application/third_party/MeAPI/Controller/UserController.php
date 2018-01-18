<?php

class MeAPI_Controller_UserController implements MeAPI_Controller_UserInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;
    protected $_GM_CONFIG;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('cache');
        $this->CI->load->library('SnsValidate', FALSE, 'SnsValidate');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $this->CI->config->load('admin');
        $this->_GM_CONFIG = $this->CI->config->item('admin');
    }

    public function authorize(MeAPI_RequestInterface $request) {
        $this->CI->load->helper('url');
        $this->CI->load->library('Template');
        
        /*
        $params = $_REQUEST;
        */
        echo $request->input_get('username');
        /*
        echo '<pre>';
        print_r($request);
        echo '</pre>';
       */
        $this->CI->template->write_view('content', 'login', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML()) ;
        
	$this->_response = new MeAPI_Response_APIResponse($request, 'invalid', $data);
    }

    public function userInfomation(MeAPI_RequestInterface $request) {
        if ($this->authorize->validateAuthorizeApi($request) === FALSE) {
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }

        $params = $request->input_request();
        $result = $this->_check_input($params);


        if (empty($result) === FALSE) {
            $this->CI->load->MeAPI_Model('AccountModel');



            if (empty($result['accountname']) === FALSE) {
                $mobo_account[] = $this->CI->AccountModel->getMoboInfoByMoboAccount($this->_APP, $result['accountname']);
            } elseif (empty($result['userid']) === FALSE || empty($result['nickname']) === FALSE || empty($result['account_id']) === FALSE) {
                try {
                    $players = $this->CI->AccountModel->getCharInf($result['account_id'], $result['userid'], $result['nickname'], $result['server']);

                    if (empty($players) === FALSE) {
                        $frist_key = key($players);
                        $mobo_account[] = $this->CI->AccountModel->getMoboInfoByAccountID($players[$frist_key]['userID']);
                    }
                } catch (Exception $exc) {
                    //$msg['content'] = $exc->getTraceAsString();
                    //$this->_sendmail_tech($msg);
                }
            }

            if (empty($mobo_account) === FALSE) {
                $mobo_account[0]['last_access'] = date('Y-m-d H:i:s', $mobo_account[0]['last_access']);
                $mobo_account[0]['access_before'] = date('Y-m-d H:i:s', $mobo_account[0]['access_before']);

                $worldID = $this->_GM_CONFIG['config']['serverID'][$result['server']];
                if (empty($worldID) === FALSE) {

                    $accounts = $this->CI->AccountModel->AccountInfoByUserID($mobo_account[0]['id'], intval($worldID));

                    $list_char = $players;
                    if (empty($list_char) === TRUE) {
                        $list_char = $this->CI->AccountModel->getCharInf($mobo_account[0]['id'], FALSE, FALSE, $result['server']);
                    }

                    foreach ($accounts as $key => $value) {
                        $rs[$key]['name'] = $value['name'];
                        $rs[$key]['account'] = $value;

                        if (!empty($list_char[$key])) {
                            $list_char[$key]['actor_create_time'] = date('Y-m-d H:i:s', $list_char[$key]['actor_create_time']);
                            $list_char[$key]['actor_lasttime_water_tree'] = date('Y-m-d H:i:s', $list_char[$key]['actor_lasttime_water_tree']);
                            $list_char[$key]['actor_leave_time'] = date('Y-m-d H:i:s', $list_char[$key]['actor_leave_time']);
                            $list_char[$key]['actor_login_time'] = date('Y-m-d H:i:s', $list_char[$key]['actor_login_time']);

                            $list_char[$key]['actor_total_online_time'] = date('Y-m-d H:i:s', $list_char[$key]['actor_total_online_time']);
                            $list_char[$key]['curSceneCreateTime'] = date('Y-m-d H:i:s', $list_char[$key]['curSceneCreateTime']);
                            $list_char[$key]['ext_LastGoBackMainCityTime'] = date('Y-m-d H:i:s', $list_char[$key]['ext_LastGoBackMainCityTime']);
                            $list_char[$key]['ext_enProp_Actor_Online_lasttimes'] = date('Y-m-d H:i:s', $list_char[$key]['ext_enProp_Actor_Online_lasttimes']);

                            $list_char[$key]['ext_enProp_Actor_Online_times'] = date('Y-m-d H:i:s', $list_char[$key]['ext_enProp_Actor_Online_times']);
                            $list_char[$key]['last1SceneCreateTime'] = date('Y-m-d H:i:s', $list_char[$key]['last1SceneCreateTime']);


                            $task = base64_encode(json_encode($list_char[$key]['task']));
                            $list_char[$key]['task'] = "<span style=\"cursor: pointer;\" class=\"abc\" title='Task Detail' content='{$task}'>Detail</span>";

                            $ride = base64_encode(json_encode($list_char[$key]['ride']));
                            $list_char[$key]['ride'] = "<span style=\"cursor: pointer;\" class=\"abc\" title='Ride Detail' content='{$ride}'>Detail</span>";

                            $skill = base64_encode(json_encode($list_char[$key]['skill']));
                            $list_char[$key]['skill'] = "<span style=\"cursor: pointer;\" class=\"abc\" title='Skill Detail' content='{$skill}'>Detail</span>";

                            $title = base64_encode(json_encode($list_char[$key]['title']));
                            $list_char[$key]['title'] = "<span style=\"cursor: pointer;\" class=\"abc\" title='Title Detail' content='{$title}'>Detail</span>";

                            $relation = base64_encode(json_encode($list_char[$key]['relation']));
                            $list_char[$key]['relation'] = "<span style=\"cursor: pointer;\" class=\"abc\" title='Relation Detail' content='{$relation}'>Detail</span>";


                            foreach ($list_char[$key]['pet']['pet_list'] as $kpet => &$vpet) {
                                $skill_list = '';
                                $skill_list = base64_encode(json_encode($vpet['skill_list']));
                                $vpet['skill_list'] = "<span style=\"cursor: pointer;\" class=\"abc\" title='Relation Detail' content='{$skill_list}'>Detail</span>";

                                $goods = '';
                                $goods = base64_encode(json_encode($vpet['goods']));
                                $vpet['goods'] = "<span style=\"cursor: pointer;\" class=\"abc\" title='Relation Detail' content='{$goods}'>Detail</span>";
                            }
                            foreach ($list_char[$key]['goods'] as $k => $v) {
                                unset($v['uid']);
                                foreach ($v as $k2 => $v2) {
                                    $goods_arr[$k2] = $k2;
                                }
                            }
                            $rs[$key]['char'] = $list_char[$key];
                        }
                    }
                    $data = array('error_string' => $error_string, 'success_string' => $success_string, 'result' => array('mobo_info' => $mobo_account, 'list_char' => $rs, 'goods_arr' => array_keys($goods_arr)));
                    $this->_response = new MeAPI_Response_APIResponse($request, '', $data);
                }
            }
        } else {
            /*
             * Return false
             */
            $this->_response = new MeAPI_Response_APIResponse($request, 'invalid', $data);
        }
        return;
    }

    public function getResponse() {
        return $this->_response;
    }

    private function _check_input($params) {
        if ($this->CI->SnsValidate->isExist($params['server'])) {
            $this->server = trim($params['server']);
        }
        if ($this->CI->SnsValidate->isExist($params['accountname'])) {
            $this->accountname = trim($params['accountname']);
        }
        if ($this->CI->SnsValidate->isExist($params['account_id'])) {
            $this->account_id = trim($params['account_id']);
        }

        if ($this->CI->SnsValidate->isExist($params['userid'])) {
            $this->userid = trim($params['userid']);
        }

        if ($this->CI->SnsValidate->isExist($params['nickname'])) {
            $this->nickname = trim($params['nickname']);
        }

        if (!isset($this->accountname) && !isset($this->nickname) && !isset($this->account_id) && !isset($this->userid)) {
            return false;
        }

        return array(
            'account_id' => $this->account_id,
            'userid' => $this->userid,
            'nickname' => $this->nickname,
            'accountname' => $this->accountname,
            'server' => $this->server,
        );
        break;
    }

}