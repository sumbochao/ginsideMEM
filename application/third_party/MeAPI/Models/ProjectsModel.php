<?php

class ProjectsModel extends CI_Model {

    private $_db_slave;
    public $_table = 'tbl_projects';
    private $_table_c = 'tbl_projects_property1';
    private $_table_lg = 'tbl_log';
    private $_table_payment = 'tbl_projects_payment';
    private $_table_rate = 'tbl_rate';

    public function __construct() {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    public function removeGoogleServiceInfo($id){
        $this->_db_slave->set('google_service_info', '')
                ->where("id", $id);
        $this->_db_slave->update('tbl_projects_property1');
    }
    public function removeJson($id){
        $this->_db_slave->set('google_json', '')
                ->where("id", $id);
        $this->_db_slave->update('tbl_projects_property1');
    }
    public function update_google_json($id,$file_json){
        $this->_db_slave->set('google_json', $file_json)
                ->where("id", $id);
        $this->_db_slave->update('tbl_projects_property1');
    }
    public function update_google_service_info($id,$google_service_info){
        $this->_db_slave->set('google_service_info', $google_service_info)
                ->where("id", $id);
        $this->_db_slave->update('tbl_projects_property1');
    }
    public function getItemCDN($servicekeyapp) {
        $data = $this->_db_slave->select(array('namesetup as title', 'color', 'url_landing_page as url'))
                ->from($this->_table)
                ->where('servicekeyapp', $servicekeyapp)
                ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }

    public function LinkCDN($arrParam) {
        $data = $this->_db_slave->select(array('p.namesetup as title', 'p.color', 'p.url_landing_page as url', 'pp.link_cnd_client as apk'))
                ->from('tbl_projects_property1 as pp')
                ->join('tbl_projects as p', 'p.id=pp.id_projects', 'left')
                ->where('p.servicekeyapp', $arrParam['service_id'])
                ->where('pp.platform', $arrParam['platform'])
                ->where('pp.package_name', $arrParam['packagename'])
                ->get();
        if (is_object($data)) {
            if (count($data->row_array()) > 0) {
                $result = $data->row_array();
            } else {
                $result = $this->getItemCDN($arrParam['service_id']);
            }
            return $result;
        }
        return false;
    }
    public function detailProject($id_projects){
        $data = $this->_db_slave->select(array('id','package_name', 'platform'))
                ->from('tbl_projects_property1')
                ->where('id_projects', $id_projects)
                ->get();
        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }
    // save log history
    public function savelogdaily($arr_param) {
        /* $arrData['username']             = $arr_param['username'];
          $arrData['timesmodify']        = $arr_param['timesmodify'];
          $arrData['actions']                 = $arr_param['actions'];
          $arrData['logs']                 = $arr_param['logs'];
          $arrData['urls']                 = $arr_param['urls'];
          $arrData['ipaddress']                 = $arr_param['ipaddress'];
          $arrData['browser']                 = $arr_param['browser'];
          $arrData['device']                 = $arr_param['device'];
          $arrData['sessionuser']                 = $arr_param['sessionuser']; */
        $id = $this->_db_slave->insert($this->_table_lg, $arr_param);
        return $id;
    }

    public function listUser() {
        $data = $this->_db_slave->select(array('*'))
                ->where('status', 1)
                ->from('account_name')
                ->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if (count($result) > 0) {
                foreach ($result as $v) {
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }

    public function deleteItem($arrParam, $options = NULL) {
        if ($options['task'] == 'multi') {
            if (count($arrParam['cid']) > 0) {
                $arrDelete = array();
                foreach ($arrParam['cid'] as $v) {
                    $filename = $this->getItem($v);
                    $this->_db_slave->delete($this->_table, array('id' => $v));
                }
            }
        } else {
            $filename = $this->getItem($arrParam['id']);
            @unlink(FILE_PATH . '/' . $filename['ipa_file']);
            $this->_db_slave->delete($this->_table, array('id' => $arrParam['id']));
        }
    }

    public function deletelistitem($id) {
        $rs = $this->_db_slave->delete($this->_table_c, array('id' => $id));
        return $rs;
    }

    public function deletePayment($param, $type) {
        if ($type == 0) {
            $rs = $this->_db_slave->delete($this->_table_payment, array('id' => $param['id']));
        } else {
            $rs = $this->_db_slave->delete($this->_table_payment, array('id_projects' => $param['id_projects'], 'id_projects_property' => $param['id_projects_property']));
        }
        return $rs;
    }

    public function deleteoneitem($id) {
        //kiem tra bang con co tham chieu den bang cha hay khong
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_c)
                ->where('id_projects', $id)
                ->get();
        $result = $data->result_array();
        if (count($result) == 0) {
            $rs = $this->_db_slave->delete($this->_table, array('id' => $id));
        } else {
            $rs = NULL;
        }
        return $rs;
    }

    public function checkcodeexist($code) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table)
                ->where('code', $code)
                ->get();
        $result = $data->result_array();
        if (count($result) == 0) {
            return false;
        } else {
            return true;
        }
        return true;
    }

    public function bundleisexit($values, $c) {
        if ($c == "add") {
            $data = $this->_db_slave->select(array('*'))
                    ->from($this->_table_c)
                    ->where('package_name', $values['values'])
                    ->where('platform', $values['platform'])
                    ->get();
            $result = $data->result_array();
        } else {
            $r = $this->_db_slave->select(array('*'))
                    ->from($this->_table_c)
                    ->where('id', $values['id'])
                    ->get();
            $rw = $r->row_array();
            $data = $this->_db_slave->select(array('*'))
                    ->from($this->_table_c)
                    ->where('package_name', $values['values'])
                    ->where('package_name <>', $rw['package_name'])
                    ->where('platform', $values['platform'])
                    ->get();
            $result_kq = $data->row_array();
            $result = $result_kq['id'] == "" ? false : true;
            return $result;
        }
        if (count($result) == 0) {
            return false;
        } else {
            return true;
        }
        return true;
    }

    public function checkListPayment($id_projects, $id_projects_property) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_payment)
                ->where('id_projects', $id_projects)
                ->where('id_projects_property', $id_projects_property)
                ->get();
        $result = $data->result_array();
        if (count($result) == 0) {
            return false;
        } else {
            return true;
        }
        return true;
    }

    public function listItem($arrParam = NULL, $options = null) {
        $this->_db_slave->select(array('*'));
        if ($arrParam['names'] != "") {
            $this->_db_slave->like('names', $arrParam['names']);
        }
        $this->_db_slave->from($this->_table);
        $this->_db_slave->order_by('id', 'DESC');

        $data = $this->_db_slave->get();

        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }

    public function listItemLog($arrParam = NULL, $options = NULL) {
        if ($options != NULL) {
            $this->_db_slave->select(array('*'));
            $this->_db_slave->from($this->_table_lg);
            //$this->_db_slave->where('username',$options['username']);
            $this->_db_slave->where('id_actions', $options['id_actions']);
            $this->_db_slave->where('tables', $options['tables']);
            $this->_db_slave->order_by('id', 'DESC');
            $data = $this->_db_slave->get();
        } else {
            $this->_db_slave->select(array('*'));
            $this->_db_slave->like('actions', 'Xóa');
            $this->_db_slave->from($this->_table_lg);
            $this->_db_slave->order_by('id', 'DESC');
            $data = $this->_db_slave->get();
        }

        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }

    public function listPayment($arrParam = NULL, $options = NULL) {
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table_payment);
        $this->_db_slave->where('id_projects', $arrParam['id_projects']);
        $this->_db_slave->where('id_projects_property', $arrParam['id_projects_property']);
        $this->_db_slave->where('type', $arrParam['type']);
        $this->_db_slave->order_by('id', 'DESC');
        $data = $this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }

    public function listPaymentView($arrParam) {
        $this->_db_slave->select(array('*'));
        $this->_db_slave->from($this->_table_payment);
        $this->_db_slave->where('id_projects', $arrParam['id_projects']);
        $this->_db_slave->order_by('type', 'DESC');
        $this->_db_slave->order_by('code', 'DESC');
        $this->_db_slave->order_by('vnd', 'DESC');
        //$this->_db_slave->order_by('mcoin','DESC');
        $data = $this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            return $result;
        }
        return FALSE;
    }

    public function getItem($id) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table)
                ->where('id', $id)
                ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
    public function getSubItem($id) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_c)
                ->where('id', $id)
                ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }

    public function getPayment($id) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_payment)
                ->where('id', $id)
                ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }

    public function getRate($id_projects) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_rate)
                ->where('id_projects', $id_projects)
                ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }

	public function getProjectsByKeyApp($app) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table)
                ->where('servicekeyapp', $app)
                ->where('status', 1)
                ->get();
//        if($_SERVER['REMOTE_ADDR'] == '113.161.93.54'){
//            echo $this->_db_slave->last_query();die;
//        }
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }
	
    public function getProjectsByCode($code) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table)
                ->where('code', $code)
                ->where('status', 1)
                ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }

    public function getItemChildByIdparrent($id_projects) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_c)
                ->where('id_projects', $id_projects)
                ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }

    public function getListChildByIdparrent($id_projects) {
        $data = $this->_db_slave->select(array('DISTINCT(platform)'))
                ->from($this->_table_c)
                ->where('id_projects', $id_projects)
                ->get();
        $result = $data->result_array();
        return $result;
    }

    public function getpackagename($id_projects, $platform) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_c)
                ->where('id_projects', $id_projects)
                ->where('platform', $platform)
                ->get();
        $result = $data->result_array();
        return $result;
    }

    public function getpackagenameinapp($id_projects, $platform) {
        if ($platform == "ios") {
            $data = $this->_db_slave->select(array('*'))
                    ->from($this->_table_c)
                    ->where('id_projects', $id_projects)
                    ->where('cert_name', 'Appstore')
                    ->where('platform', $platform)
                    ->get();
        } else {
            $data = $this->_db_slave->select(array('*'))
                    ->from($this->_table_c)
                    ->where('id_projects', $id_projects)
                    ->where('platform', $platform)
                    ->get();
        }
        return $result;
    }

    public function getProjectsList() {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table)
                ->where('status', 1)
                ->get();
        $result = $data->result_array();
        return $result;
    }

    public function getProjectsListWhere($platform) {
        $sql = "select p.* from tbl_projects as p join tbl_projects_property1 as pr on (p.id = pr.id_projects) where pr.platform='$platform' and p.status=1 group by p.code";
        $result = $this->_db_slave->query($sql);
        $r = $result->result_array();
        return $r;
    }
    
    public function getItemChild($id) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_c)
                ->where('id', $id)
                ->get();
        if (is_object($data)) {
            return $data->row_array();
        }
        return FALSE;
    }

    public function getItemGame($service_id) {
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('service_id', 'app_fullname'));
        $this->db_slave->where('service_id', $service_id);
        $data = $this->db_slave->get('scopes');
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if (count($result) > 0) {
                foreach ($result as $v) {
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }

    public function listGame() {
        if (!$this->db_slave)
            $this->db_slave = $this->load->database(array('db' => 'gapi', 'type' => 'slave'), TRUE);
        $this->db_slave->select(array('id', 'service_id', 'app_fullname'));
        $this->db_slave->where('app_type', 0);
        $this->db_slave->or_where('app_type', 1);
        $this->db_slave->order_by('id', 'DESC');
        $data = $this->db_slave->get('scopes');
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if (count($result) > 0) {
                foreach ($result as $v) {
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }

    public function loadlist() {
        //lay id_projects
        $sql = "select max(id) as idpro from " . $this->_table;
        $query = $this->_db_slave->query($sql);
        $id_projects = '';
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $id_projects = $row->idpro;
            }
        }
        $data = $this->_db_slave->select(array('*'))
                ->where('id_projects', $id_projects)
                ->from($this->_table_c)
                ->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if (count($result) > 0) {
                foreach ($result as $v) {
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }

    public function loadlistplus($id_projects, $fillter) {

        $this->_db_slave->select(array('*'));
        $this->_db_slave->where('id_projects', $id_projects);
        if ($fillter != "") {
            $this->_db_slave->like('package_name', $fillter);
        }
        $this->_db_slave->order_by('platform');
        $this->_db_slave->order_by('id desc');
        $this->_db_slave->from($this->_table_c);
        $data = $this->_db_slave->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if (count($result) > 0) {
                foreach ($result as $v) {
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }

    public function listPlatform() {
        $arrResult = array("ios" => "IOS", "android" => "Android", "wp" => "Winphone");
        return $arrResult;
    }

    public function listStatus() {
        $arrResult = array("approving" => "Approving", "approved" => "Approved", "rejected" => "Rejected", "cancel" => "Cancel");
        return $arrResult;
    }

    public function add_new($arrParam) {
        $id = $this->_db_slave->insert($this->_table, $arrParam);
        $id = $this->_db_slave->insert_id();
        return $id;
    }

    public function add_new_proper($arrParam, $idprojects) {
        if ($idprojects > 0) {
            $id_projects = $idprojects;
        } else {
            //lay id_projects
            $sql = "select max(id) as idpro from " . $this->_table;
            $query = $this->_db_slave->query($sql);
            $id_projects = '';
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $id_projects = $row->idpro;
                }
            }
        }

        $arrData['id_projects'] = $id_projects;
        $arrData['platform'] = $arrParam['platform'];
        //$arrData['app_id']        = $arrParam['app_id'];
        $arrData['package_name'] = $arrParam['package_name'];
        //$arrData['version_type']                 = $arrParam['version_type'];
        $arrData['public_key'] = $arrParam['public_key'];
        $arrData['appstore_inapp_items'] = $arrParam['appstore_inapp_items'];
        $arrData['gp_inapp_items'] = $arrParam['gp_inapp_items'];
        $arrData['notes'] = $arrParam['notes'];
        $arrData['datecreate'] = $arrParam['datecreate'];
        $arrData['status'] = $arrParam['status'];
        $arrData['userlog'] = $arrParam['userlog'];
        $id = $this->_db_slave->insert($this->_table_c, $arrData);
        return $id;
    }

    public function add_new_proper_new($arrParam, $idprojects) {
        if ($idprojects > 0) {
            $id_projects = $idprojects;
        } else {
            //lay id_projects
            $sql = "select max(id) as idpro from " . $this->_table;
            $query = $this->_db_slave->query($sql);
            $id_projects = '';
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $id_projects = $row->idpro;
                }
            }
        }
        $arrParam['id_projects'] = $id_projects;
        $id = $this->_db_slave->insert($this->_table_c, $arrParam);
        $insert_id = $this->_db_slave->insert_id();
        $result = array('id'=>$id,'insert_id'=>$insert_id);
        return $result;
    }

    public function add_payment($arrParam, $idprojects) {
        if ($idprojects > 0) {
            $id_projects = $idprojects;
            //lay id_projects_pro
            $sql = "select max(id) as idprop from " . $this->_table_c;
            $query = $this->_db_slave->query($sql);
            $id_projects_p = '';
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $id_projects_p = $row->idprop;
                }
            }
            //$id_projects_p=$arrParam['id_projects_property'];
        } else {
            //lay id_projects
            $sql = "select max(id) as idpro from " . $this->_table;
            $query = $this->_db_slave->query($sql);
            $id_projects = '';
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $id_projects = $row->idpro;
                }
            }
            //lay id_projects_pro
            $sql = "select max(id) as idprop from " . $this->_table_c;
            $query = $this->_db_slave->query($sql);
            $id_projects_p = '';
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $id_projects_p = $row->idprop;
                }
            }
        }
        $arrParam['id_projects'] = $id_projects;
        $arrParam['id_projects_property'] = $id_projects_p;
        $id = $this->_db_slave->insert($this->_table_payment, $arrParam);
        return $id;
    }

    public function add_payment_plus($arrParam) {
        $id = $this->_db_slave->insert($this->_table_payment, $arrParam);
        return $id;
    }

    public function edit_new($arrParam, $id) {
        $this->_db_slave->where('id', $id);
        $id = $this->_db_slave->update($this->_table, $arrParam);

        return $id;
    }

    public function edit_rows_item($arrParam, $id) {
        $this->_db_slave->where('id', $id);
        $id = $this->_db_slave->update($this->_table_c, $arrParam);
        return $id;
    }

    public function update_rate($arrParam) {
        //kiem tra tygia cua id_projects da ton tai chua
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_rate)
                ->where('id_projects', $arrParam['id_projects'])
                ->get();
        $result = $data->result_array();
        if (count($result) == 0) {
            //chua co , add new
            $id = $this->_db_slave->insert($this->_table_rate, $arrParam);
        } else {
            //co roi , update
            $this->_db_slave->where('id_projects', $arrParam['id_projects']);
            $id = $this->_db_slave->update($this->_table_rate, $arrParam);
        }
        return $id;
    }

    public function update_rate_payment($arrParam) {
        $rate_mcoin = $arrParam['mcoin'];
        $rate_gem = $arrParam['gem'];
        $id_projects = $arrParam['id_projects'];
        $sql = "update " . $this->_table_payment . " set gem=(mcoin*$rate_gem)/$rate_mcoin where id_projects=" . $id_projects;
        $query = $this->_db_slave->query($sql);
    }

    public function edit_rows_item_payment($arrParam, $id) {
        $this->_db_slave->where('id', $id);
        $id = $this->_db_slave->update($this->_table_payment, $arrParam);
        return $id;
    }

    public function edit_field_filename($arrParam, $id) {
        $this->_db_slave->where('id', $id);
        $id = $this->_db_slave->update($this->_table_c, $arrParam);
        return $id;
    }

    public function listProjectsProperty($id_projects) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table_c)
                ->where('id_projects', $id_projects)
                ->get();
        if (is_object($data)) {
            $result = $data->result_array();
            $arrResult = array();
            if (count($result) > 0) {
                foreach ($result as $v) {
                    $arrResult[$v['id']] = $v;
                }
            }
            return $arrResult;
        }
        return FALSE;
    }

    //API send Payment
    public function FilterTypePayment($id_projects) {
        $sql = "select type,code from tbl_projects_payment where id_projects=" . $id_projects . "  GROUP BY type";
        $data = $this->_db_slave->query($sql);
        $result = $data->result_array();
        return $result;
    }

    public function ReturnJson($id_projects, $type) {
        $sql_p = "select * from tbl_projects_payment where id_projects=" . $id_projects . " and type='" . trim($type) . "' order by id asc";
        $data = $this->_db_slave->query($sql_p);
        $result = $data->result_array();
        return $result;
    }

    public function ReturnJsonInapp($id_projects, $type, $platform) {
        $sql_p = "select pay.*,pro.platform from tbl_projects_payment as pay INNER JOIN tbl_projects_property1 as pro on(pay.id_projects_property = pro.id)
 where pay.id_projects=" . $id_projects . " and pay.type='" . trim($type) . "' and pro.platform='" . trim($platform) . "' ORDER BY pay.code desc";//ORDER BY pro.platform desc
        $data = $this->_db_slave->query($sql_p);
        $result = $data->result_array();
        return $result;
    }

    public function ReturnJsonInappFilterPlatform($id_projects, $type) {
        $sql_p = "select pay.type,pay.code,pro.platform from tbl_projects_payment as pay INNER JOIN tbl_projects_property1 as pro on(pay.id_projects_property = pro.id) where pay.id_projects=" . $id_projects . " and pay.type='" . trim($type) . "' Group by pro.platform";
        $data = $this->_db_slave->query($sql_p);
        $result = $data->result_array();
        return $result;
    }

    public function updatestatus($arr) {
        $t = $arr['status'] == 0 ? 1 : 0;
        $sql = "update " . $this->_table . " set `status`=" . $t . " where id=" . $arr['id'];
        $data = $this->_db_slave->query($sql);
        return $data;
    }

    //24/2/2016
    public function getStatusTuneProjects($servicekeyapp) {
        $data = $this->_db_slave->select(array('*'))
                ->from($this->_table)
                ->where('servicekeyapp', $servicekeyapp)
                ->get();
        $result = $data->row_array();
        return $result;
    }

    //ghi nhat ky syn payment
    public function save_log_payment($arrParam) {
        $id = $this->_db_slave->insert("tbl_log_payment", $arrParam);
        return $id;
    }
}
