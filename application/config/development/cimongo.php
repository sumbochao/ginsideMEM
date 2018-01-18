<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['link'] = 'mongodb://10.10.20.176:27017,10.10.20.177:27017';
$config['db_flag'] = TRUE;
$config['db'] = 'giftcode';

/*
$config['link'] = 'mongodb://giftcode:ha89wH3aKaf@10.10.20.176:27017,10.10.20.177:27017';
// Generally localhost
$config['host'] = "10.10.20.176";
// Generally 27017
$config['port'] = 27017;
// The database you want to work on
$config['db'] = "giftcode";
// Required if Mongo is running in auth mode
$config['user'] = "giftcode";
$config['pass'] = "ha89wH3aKaf";


$config['query_safety'] = TRUE;

//If running in auth mode and the user does not have global read/write then set this to true
$config['db_flag'] = TRUE;

//consider these config only if you want to store the session into mongoDB
//They will be used in MY_Session.php
$config['sess_use_mongo'] = FALSE;
$config['sess_collection_name']	= 'ci_sessions';

 */
