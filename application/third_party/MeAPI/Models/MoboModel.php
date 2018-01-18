<?php

/**
 * @property CI_DB_active_record $db
 */
class MoboModel extends CI_Model {

    private $_db;
    private $_db_slave;

    public function __construct() {
        
    }

    public function getActiveMoboGameAccount($type, $start = 1) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'mobo_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->select(array('provider_id as provider', 'COUNT(DISTINCT(game_account)) as account'));
        $this->_db_slave->where('game_account IS NOT NULL');
        $this->_db_slave->where('game_account != "0"');



        switch ($type) {
            case 1:
                $end = $start;
                break;
            case 7:
                $end = $start + 6;
                break;
            case 30:
                $end = $start + 29;
                break;
        }
        $this->_db_slave->where('(last_access) >= (' . strtotime(date('Y-m-d 00:00:00', strtotime("-{$end} day"))) . ')');
        $this->_db_slave->where('(last_access) <= (' . strtotime(date('Y-m-d 23:59:59', strtotime("-{$start} day"))) . ')');
        $this->_db_slave->group_by('provider_id');
        $data = $this->_db_slave->get('account');

        if (is_object($data)) {
            $result = $data->result_array();
            foreach ($result as $key => $value) {
                $rs[$value['provider']] = $value['account'];
            }

            return $rs;
        }
        return FALSE;
    }

    public function getActiveMoboAccount($type, $start = 1) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'mobo_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->select(array('provider_id as provider', 'COUNT(DISTINCT(mobo_account)) as account'));
        $this->_db_slave->where('mobo_account IS NOT NULL');
        $this->_db_slave->where('mobo_account != "0"');



        switch ($type) {
            case 1:
                $end = $start;
                break;
            case 7:
                $end = $start + 6;
                break;
            case 30:
                $end = $start + 29;
                break;
        }
        $this->_db_slave->where('(last_access) >= (' . strtotime(date('Y-m-d 00:00:00', strtotime("-{$end} day"))) . ')');
        $this->_db_slave->where('(last_access) <= (' . strtotime(date('Y-m-d 23:59:59', strtotime("-{$start} day"))) . ')');
        $this->_db_slave->group_by('provider_id');
        $data = $this->_db_slave->get('account');

        if (is_object($data)) {
            $result = $data->result_array();
            foreach ($result as $key => $value) {
                $rs[$value['provider']] = $value['account'];
            }

            return $rs;
        }
        return FALSE;
    }

    public function getNewRegGameAccount($date) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'mobo_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->select(array('DISTINCT(game_account) as username', 'provider_id as provider'));
        $this->_db_slave->where('game_account IS NOT NULL');
        $this->_db_slave->where('game_account != "0"');

        $this->_db_slave->where('(created) >= (' . strtotime(date('Y-m-d 00:00:00', strtotime("-{$date} day"))) . ')');
        $this->_db_slave->where('(created) <= (' . strtotime(date('Y-m-d 23:59:59', strtotime("-{$date} day"))) . ')');
        $data = $this->_db_slave->get('account');

        if (is_object($data)) {
            return $data->result_array();
        }
        return FALSE;
    }

    public function getNewRegMoboAccount($date = 1) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'mobo_info', 'type' => 'slave'), TRUE);

        $sql = "
            Select `provider_id` , COUNT(DISTINCT(mobo_account)) as total  
            FROM (SELECT DISTINCT(`mobo_account`),`provider_id`,MIN(`created`) as min_date FROM `account` where `mobo_account` IS NOT NULL GROUP BY `mobo_account` ) as a 
            WHERE (a.min_date) >= '" . date('Y-m-d 00:00:00', strtotime("-{$date} day")) . "'  
            AND (a.min_date) <= '" . date('Y-m-d 23:59:59', strtotime("-{$date} day")) . "'  
            GROUP BY `provider_id`  
        ";
        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->result_array();
            foreach ($result as $key => $value) {
                $rs[$value['provider_id']] += $value['total'];
            }
            return $rs;
        }
        return FALSE;
    }

    public function getTRUMoboAccount($date = 1) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'mobo_info', 'type' => 'slave'), TRUE);


        $sql = "
            Select `provider_id` , COUNT(DISTINCT(mobo_account)) as total  
            FROM (SELECT DISTINCT(`mobo_account`),`provider_id`,MIN(`created`) as min_date FROM `account` where `mobo_account` IS NOT NULL GROUP BY `mobo_account` ) as a 
            WHERE (a.min_date) <= '" . date('Y-m-d 23:59:59', strtotime("-{$date} day")) . "'  
            GROUP BY `provider_id`  
        ";

        $data = $this->_db_slave->query($sql);
        if (is_object($data)) {
            $result = $data->result_array();
            foreach ($result as $key => $value) {
                $rs[$value['provider_id']] += $value['total'];
            }
            return $rs;
        }
        return FALSE;
    }

    public function getTRUGameAccount($date = 1) {
        if (!$this->_db_slave)
            $this->_db_slave = $this->load->database(array('db' => 'mobo_info', 'type' => 'slave'), TRUE);

        $this->_db_slave->select(array('provider_id as provider', 'count(DISTINCT(game_account)) as total'));
        $this->_db_slave->where('(created) <= (' . strtotime(date('Y-m-d 23:59:59', strtotime("-{$date} day"))) . ')');
        $this->_db_slave->group_by('provider_id');
        $data = $this->_db_slave->get('account');
        if (is_object($data)) {
            $result = $data->result_array();
            foreach ($result as $key => $value) {
                $rs[$value['provider_id']] += $value['total'];
            }
            return $rs;
        }
        return FALSE;
    }

}