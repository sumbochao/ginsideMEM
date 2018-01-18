<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Generally localhost
$config['host'] = "10.10.20.176";
// Generally 27017
$config['port'] = 27017;
// The database you want to work on
$config['db'] = "giftcode";
// Required if Mongo is running in auth mode
$config['user'] = "giftcode";
$config['pass'] = "ha89wH3aKaf";

/*  
 * Defaults to FALSE. If FALSE, the program continues executing without waiting for a database response. 
 * If TRUE, the program will wait for the database response and throw a MongoCursorException if the update did not succeed.
*/
$config['query_safety'] = TRUE;

//If running in auth mode and the user does not have global read/write then set this to true
$config['db_flag'] = TRUE;

//consider these config only if you want to store the session into mongoDB
//They will be used in MY_Session.php
$config['sess_use_mongo'] = FALSE;
$config['sess_collection_name']	= 'ci_sessions';
 
 // Generally localhost
$default['host'] = "10.10.20.177";
// Generally 27017
$default['port'] = 27017;
// The database you want to work on
$default['db'] = "giftcode";
// Required if Mongo is running in auth mode
$default['user'] = "giftcode";
$default['pass'] = "ha89wH3aKaf";

$default['query_safety'] = TRUE;
$default['db_flag'] = TRUE;
$default['sess_use_mongo'] = FALSE;
$default['sess_collection_name']	= 'ci_sessions';