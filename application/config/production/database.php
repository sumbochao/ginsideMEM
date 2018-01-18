<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$db['inside_info'] = array(
    'cfg' => array('master' => 1, 'master_random' => false, 'slave_random' => false),
    'db' => array(
        gen_cfg_db('10.10.20.122', 'ginside', 'FXO7T2wL2U', 'ginside_mobo_vn'),
        gen_cfg_db('10.10.20.122', 'ginside', 'FXO7T2wL2U', 'ginside_mobo_vn')
    )
);
