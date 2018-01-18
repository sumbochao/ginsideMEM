<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$db['system_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('127.0.0.1', 'root', '', 'api.mobo.vn'),
        gen_cfg_db('127.0.0.1', 'root', '', 'api.mobo.vn')
    )
);


$db['inside_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.122', 'ginside', 'FXO7T2wL2U', 'ginside_mobo_vn'),
        gen_cfg_db('10.10.20.122', 'ginside', 'FXO7T2wL2U', 'ginside_mobo_vn')
    )
);


$db['gapi'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.235', 'gapimobo', '768CAKLmcx', 'gapi_mobo_vn'),
        gen_cfg_db('10.10.20.235', 'gapimobo', '768CAKLmcx', 'gapi_mobo_vn')
    )
);

$db['lucgioi'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.134', 'service_lucgioi', 'BE1iJItq9WCu', 'service_lucgioi_mobo_vn'),
        gen_cfg_db('10.10.20.134', 'service_lucgioi', 'BE1iJItq9WCu', 'service_lucgioi_mobo_vn')
    )
);
$db['hkgh'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.134', 'ser_thichkhach', 'zrD7McgDlAbp', 'service_thichkhach_mobo_vn'),
        gen_cfg_db('10.10.20.134', 'ser_thichkhach', 'zrD7McgDlAbp', 'service_thichkhach_mobo_vn')
    )
);
$db['3q'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.134', 'service_3q', 'dDZSTfNMcocF', 'service_3q_mobo_vn'),
        gen_cfg_db('10.10.20.134', 'service_3q', 'dDZSTfNMcocF', 'service_3q_mobo_vn'),
    )
);

$db['mu'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.134', 'service_mu', '6X7JMFqjC4Ri', 'service_mu_mobo_vn'),
        gen_cfg_db('10.10.20.134', 'service_mu', '6X7JMFqjC4Ri', 'service_mu_mobo_vn')
    )
);

$db['app_mobo'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('203.162.79.44', 'm.app.mobo', 'zdQ3q4YfUgUMEkMd2h1q', 'm.app.mobo'),
        gen_cfg_db('203.162.79.44', 'm.app.mobo', 'zdQ3q4YfUgUMEkMd2h1q', 'm.app.mobo')
    )
);


$db['miniapp'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.134', 'mapp_mobo', 'zdQ3q4YfUgUMEkMd2h1q', 'm_app_mobo_vn'),
        gen_cfg_db('10.10.20.134', 'mapp_mobo', 'zdQ3q4YfUgUMEkMd2h1q', 'm_app_mobo_vn')
    )
);

$db['service_mgh_mobo_vn'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.122', 'servicemgh', 'jSiOf3hnAwEf', 'service_mgh_mobo_vn'),
        gen_cfg_db('10.10.20.122', 'servicemgh', 'jSiOf3hnAwEf', 'service_mgh_mobo_vn')
    )
);

$db['service_acdau_mobo_vn'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.134', 'service_acdau', 'lfAW479qSMyZ', 'service_acdau_mobo_vn')
    )
);

$db['active_eden_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_eden'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_eden')
    )
);
$db['active_mgh_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_mgh'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_mgh')
    )
);
$db['active_mgh2_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_mgh2'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_mgh2')
    )
);
$db['active_langkhach_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_langkhach'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_langkhach')
    )
);
$db['active_tethien3d_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_tethien3d'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_tethien3d')
    )
);
$db['active_bog_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_fa'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_fa')
    )
);
$db['active_koa_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_koa'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_koa')
    )
);

$db['db_gopet_4'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.21.19', 'dev_gopet', 'devgopet@@@', 'gopet3'),
        gen_cfg_db('10.10.21.19', 'dev_gopet', 'devgopet@@@', 'gopet3')
    )
);
$db['active_giangma_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_giangma'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'inside_giangma')
    )
);
$db['active_ifish_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('iFish_Slave_DB', 'inside', 'wtAXMNJySMBCebl', 'ReportDataDB', '', false, 'sqlsrv'),
        gen_cfg_db('iFish_Slave_DB', 'inside', 'wtAXMNJySMBCebl', 'ReportDataDB', '', false, 'sqlsrv')
    )
);
$db['active_vicamobo_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'vicamobo'),
        gen_cfg_db('10.10.32.2', 'inside', 'wtAXMNJySMBCebl', 'vicamobo')
    )
);

$db['vicamobo'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.235', 'vicamobo', 'ad82cdc6f597', 'vicamobo'),
        gen_cfg_db('10.10.20.235', 'vicamobo', 'ad82cdc6f597', 'vicamobo')
    )
);

$db['inside_3k'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.134', 'service_3cay', 'KqolGIexmUzK', 'service_3cay_mobo_vn'),
        gen_cfg_db('10.10.20.134', 'service_3cay', 'KqolGIexmUzK', 'service_3cay_mobo_vn'),
    )
);
$db['db_cache'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.32.2', 'eventacc', 'dfNcsODJVoEbKXX', 'fa_cache'),
        gen_cfg_db('10.10.32.2', 'eventacc', 'dfNcsODJVoEbKXX', 'fa_cache')
    )
);

$db['ttkt_push'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.35.13', 'mig', 'zYOsnvMwaQZUatiTmpKQ', 'ttkt_push'),
        gen_cfg_db('10.10.35.13', 'mig', 'zYOsnvMwaQZUatiTmpKQ', 'ttkt_push')
    )
);

/* End of file database.php */
/* Location: ./application/config/database.php */