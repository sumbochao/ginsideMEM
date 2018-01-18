<?php

/**
 * @property CI_DB_active_record $db
 */
class MiniappModel extends CI_Model {

    private $_db;
    private $_db_slave;

    public function __construct() {
        
    }

    //////////// Menu //////////////
    public function get_menu($uid, $control) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->join('menu', 'menu.menu_id = menu_privileges.menu_id', 'left');
        $this->_db_slave->where('menu_privileges.uid', $uid);
        $this->_db_slave->where('menu.controller', $control);
        $this->_db_slave->order_by('menu.order ASC');
        $data = $this->_db_slave->get('menu_privileges');
        if (is_object($data))
            return $data->result_array();
    }
    public function get_menu_cp($user_id){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
            /*$this->_db_slave->select(array('menu_cp.*','menu_group.display_name as groupp'));
            $this->_db_slave->join('menu_group', 'menu_cp.menu_group_id = menu_group.id', 'left');
            $this->_db_slave->join('account_has_menu', 'account_has_menu.menu_id = menu_cp.id', 'left');
            $this->_db_slave->where('account_has_menu.account_id', $user_id);
            $this->_db_slave->order_by('menu_cp.order ASC');
            $data = $this->_db_slave->get('menu_cp');
            echo $this->_db_slave->last_query();die;
            */
            $this->_db_slave->select(array('menu_cp.*','menu_group.display_name as groupp'));
            $this->_db_slave->join('menu_group', 'menu_cp.menu_group_id = menu_group.id', 'left');
            $this->_db_slave->where('menu_cp.relative_url IS NOT NULL', false ,false);
            $this->_db_slave->where('menu_cp.relative_url != "" ', false ,false);
            $this->_db_slave->order_by('menu_cp.id ASC');
            $data = $this->_db_slave->get('menu_cp');
            $arrResult = array();
            if (is_object($data)){
                $arrResult = $data->result_array();
            }
            return $arrResult;
    }
    public function getMenuApi($user_id,$idmenu,$app=null){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            $this->_db_slave->select(array('menu_cp.*','menu_group.display_name as groupp'));
            $this->_db_slave->join('menu_group', 'menu_cp.menu_group_id = menu_group.id', 'left');
            $this->_db_slave->join('account_has_menu', 'account_has_menu.menu_id = menu_cp.id', 'left');
            $this->_db_slave->where('account_has_menu.account_id', $user_id);
            $this->_db_slave->where('menu_cp.menu_cp_parent',0);
            $this->_db_slave->where('menu_cp.is_display',1);
            $this->_db_slave->where('menu_group.id',$idmenu);
            $this->_db_slave->order_by('menu_cp.order ASC');
            $data = $this->_db_slave->get('menu_cp');
            
            $arrResult = array();
            if (is_object($data)){
                $arrResult = $data->result_array();
            }
            return $arrResult;
    }
    public function getMenuApi2($user_id,$idmenu,$app){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

       /* $data = $this->_db_slave->query("SELECT `alias` FROM `menu_cp` WHERE `menu_cp_parent` IN (SELECT `menu_cp`.`id` 
            FROM (`menu_cp`) LEFT JOIN `menu_group` ON `menu_cp`.`menu_group_id` = `menu_group`.`id` 
            LEFT JOIN `account_has_menu` ON `account_has_menu`.`menu_id` = `menu_cp`.`id` 
            WHERE `account_has_menu`.`account_id` = '".$user_id."'                 
            AND `menu_cp`.`display_name` = '".$app."'
            AND `menu_cp`.`is_display` = 1 AND `menu_group`.`id` = ".$idmenu." ORDER BY `menu_cp`.`order` ASC )
            AND permission = 1");
        */
        $data = $this->_db_slave->query("SELECT `alias` FROM (`menu_cp`) LEFT JOIN `menu_group` ON `menu_cp`.`menu_group_id` = `menu_group`.`id` 
        LEFT JOIN `account_has_menu` ON `account_has_menu`.`menu_id` = `menu_cp`.`id` 
        WHERE `account_has_menu`.`account_id` = '".$user_id."' 
        AND menu_cp.menu_cp_parent = (SELECT menu_cp.id FROM (`menu_cp`) LEFT JOIN `menu_group` ON `menu_cp`.`menu_group_id` = `menu_group`.`id` WHERE `menu_group`.`id` = ".$idmenu." AND `menu_cp`.`display_name` = '".$app."')
        AND `menu_cp`.`is_display` = 1 AND `menu_group`.`id` = ".$idmenu." ORDER BY `menu_cp`.`order` ASC");

        $arrResult = array();
        if (is_object($data)){
            $arrResult = $data->result_array();
        }
        return $arrResult;
    }
    public function addMenuApi($menuid, $userid){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
        $this->_db_slave->where('account_has_menu.account_id', $userid);
        $this->_db_slave->where('account_has_menu.menu_id', $menuid);
        $data = $this->_db_slave->get('account_has_menu');
        $arrResult = array();
        if (is_object($data)){
            $arrResult = $data->result_array();
            if(empty($arrResult) === TRUE){
                $arr = array();
                $arr['account_id'] = $userid;
                $arr['menu_id'] = $menuid;
                $this->_db_slave->insert('account_has_menu',$arr);
            }
        }
        
    }
    public function removeMenuApi($menuid, $userid){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        
         $this->_db_slave->delete('account_has_menu', array('account_id' => $userid, 'menu_id' => $menuid));
    }
    public function getAllMenuApi(){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
            $this->_db_slave->select('*');
            $data = $this->_db_slave->get('menu_category');

            if (is_object($data)){
                return $data->result_array();
            }
            
    }
    public function getMenu($menuId){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
            $this->_db_slave->where('menu_category.id', $menuId);
            $this->_db_slave->limit(1);
            $data = $this->_db_slave->get('menu_category');
            
            if (is_object($data)){
                return $data->row_array();
            }
    }

    public function getGroupMenu(){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            //$data = $this->_db_slave->query('SELET mg.id,mg.display_name,m.id,m.display_name,m.relative_url,m.note,m.menu_group_id FROM menu_cp as m ,menu_group as mg WHERE  mg.id = m.menu_group_id m.is_display =1 AND m.menu_cp_parent =0 ');
            //echo $this->_db_slave->last_query();die;
            $data = $this->_db_slave->get('menu_category');
            
            if (is_object($data)){
                return $data->result_array();
            }
    }
    public function getSubGroupMenu(){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
            $data = $this->_db_slave->where('is_display',1)->where('menu_cp_parent',0)->get('menu_cp');
            if (is_object($data)){
                $returnData = $data->result_array();
                $datafinish = array();
                foreach ($returnData as $value) {
                    $datafinish[$value['menu_group_id']][] = $value;
                }
                return $datafinish;
            }
            
    }


    function insert_remove_accents($string) {
    
        if(is_array($string))
            $str=$string["string"];
        else
            $str=$string;
                
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);

        $str = trim($str);
        $RemoveChars  = array( "([\40])" , "([^a-zA-Z0-9-])", "(-{2,})" );
        $ReplaceWith = array("-", "", "-"); 
        $str =preg_replace($RemoveChars, $ReplaceWith, $str); 
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));

        return strtolower($str);
    }
    function changeTitle($sStr){
        $sStr = $this->insert_remove_accents($sStr);
        $sStr = mb_convert_case($sStr,MB_CASE_LOWER,'utf-8');
        $sStr = trim($sStr); 
        return $sStr;
    }

    public function saveItem(){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $arrParam = $this->input->post();

        $arrAc = array();
        
        if(isset($arrParam['menuId'])){
            $permission = ($arrParam['permission'] == "on")? 1:0;
            $strQuery="UPDATE menu_cp SET 
                       display_name = '".trim($arrParam['display_name'])."', 
                       alias = '".trim($this->changeTitle($arrParam['display_name']))."', 
                       relative_url = '".trim($arrParam['relative_url'])."', 
                       menu_group_id = '".trim($arrParam['menu_group_id'])."', 
                       menu_cp_parent = '".trim($arrParam['menu_cp_parent'])."', 
                       permission = '".$permission."' 
                       WHERE id = '".$arrParam['menuId']."'";
            
            $this->_db_slave->query($strQuery);
        }else{
                $arrAc['isactive'] = ($arrParam['permission'] == "on")? 1:0;
                $arrAc['id_app'] = $arrParam['id_app'];
                $arrAc['id_event'] = $arrParam['id_event'];
                $arrAc['type_event'] = trim($arrParam['type_event']);
                $arrAc['menu_group_id'] = trim($arrParam['menu_group_id']);
                $arrAc['menu_cp_parent'] = trim($arrParam['menu_cp_parent']);
                $arrAc['order'] = $arrParam['order'];
                $arrAc['note'] = trim($arrParam['display_name']);
                $arrAc['is_display'] = 1;

                $this->_db_slave->insert('menu_cp',$arrAc);
        }

    }
    public function saveGroupItem(){
         if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
        $arrParam = $this->input->post();
        
        $arrAc = array();
        if(isset($arrParam['groupId'])){
             
            $strQuery="UPDATE menu_category SET
                       menu_name = '".trim($arrParam['display_name'])."',
                       alias = '".trim($arrParam['alias'])."'
                       WHERE id = '".$arrParam['groupId']."'";
            
            $this->_db_slave->query($strQuery);
        }else{
                $arrAc['menu_name'] = trim($arrParam['display_name']);
                $arrAc['order'] = $arrParam['order'];
                $arrAc['alias'] = $arrParam['alias'];
                $arrAc['create_date'] = date('Y-m-d H:i:s',time());
                $arrAc['isactive'] = 1;
                $this->_db_slave->insert('menu_category',$arrAc);
            //echo $this->_db_slave->last_query();die;

        }

    }
    public function getGroup($groupId){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
         
            $this->_db_slave->where('menu_category.id', $groupId);
            $this->_db_slave->limit(1);
            $data = $this->_db_slave->get('menu_category');
            
            if (is_object($data)){
                return $data->row_array();
            }
    }
    public function getError() {
        return $this->_db->_error_message();
    }

    /**
     * @param $id_event
     * @return mixed
     */

    public function update($table, $data, $where){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        /*
        $arrAc['isactive'] = ($arrParam['permission'] == "on")? 1:0;
        $arrAc['id_app'] = $arrParam['id_app'];
        $arrAc['id_event'] = $arrParam['id_event'];
        $arrAc['type_event'] = trim($arrParam['type_event']);
        if($arrParam['type_event'] =='like'){
            $arrAc['like_fanpage_id'] = trim($arrParam['like_fanpage_id']);
        }elseif($arrParam['type_event'] =='share'){
            $arrAc['share_link'] = trim($arrParam['share_link']);
            $arrAc['share_picture'] = trim($arrParam['share_picture']);
            $arrAc['share_caption'] = trim($arrParam['share_caption']);
            $arrAc['share_title'] = trim($arrParam['share_title']);
            $arrAc['share_description'] = trim($arrParam['share_description']);
        }
        $arrAc['picture'] = trim($arrParam['picture']);
        $arrAc['event'] = trim($arrParam['event']);
        $arrAc['order'] = $arrParam['order'];
        $arrAc['note'] = trim($arrParam['note']);
        $arrAc['iconimg'] = trim($arrParam['iconimg']);
        $arrAc['insertDate'] = date('Y-m-d H:i:s',time());
        */
        $sql = $this->_db_slave->update($table, $data, $where);
        return $this->_db_slave->affected_rows();
    }
    public function insert_id($table, $data){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $query = $this->_db_slave->insert($table, $data);
        $idinsert =  $this->_db_slave->insert_id();
        if ($this->_db_slave->affected_rows() > 0) {
            return $idinsert;
        } else {
            return false;
        }
    }

    function getconttentevent($id_event){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data = $this->_db_slave->where('id_app',$id_event)->get('tbl_m_app');
        if (is_object($data)){
            $returnData = $data->result_array();
            return $returnData;
        }
    }
    public function getmapp($idmapp){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->where('tbl_m_app.id', $idmapp);
        $this->_db_slave->limit(1);
        $data = $this->_db_slave->get('tbl_m_app');

        if (is_object($data)){
            return $data->row_array();
        }
    }
    public function getallappbyid($idmapp,$id_event){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data =$this->_db_slave->query("SELECT * FROM tbl_m_app WHERE id_app = ".$idmapp." AND id_event <> ".$id_event);
        if (is_object($data)){
            return $data->result_array();
        }else{
            return false;
        }
    }
    public function getallapp($idmap){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data =$this->_db_slave->where("id_app",$idmap)->get('tbl_m_app');
        if (is_object($data)){
            return $data->result_array();
        }else{
            return false;
        }
    }
    public function listapibygame($alias_app){
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
        $data =$this->_db_slave->where("alias_app",$alias_app)->get('tbl_m_app');
        if (is_object($data)){
            return $data->result_array();
        }else{
            return false;
        }
    }

}