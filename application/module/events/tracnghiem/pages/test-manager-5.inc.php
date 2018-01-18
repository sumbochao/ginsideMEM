<?php
if(isset($_POST["box_tests"])) {
	foreach($_POST["box_tests"] as $f_testid) {
 deleteTest($func,(int)$f_testid,$srv_settings);
}
} else {
	$f_testid = (int)$func->readGetVar('testid');
deleteTest($func,$f_testid,$srv_settings);
}
 
$func->gotoLocation('?control=mobo_event_tracnghiem&func=test_manager&'.$func->getURLAddon('action=', array('action','testid')));
function deleteTest($func,$i_testid,$srv_settings) {
	$func->m_bd->update("DELETE FROM ".$srv_settings['table_prefix']."tests_attempts WHERE testid=".$i_testid);
if($func->m_bd->update("DELETE FROM ".$srv_settings['table_prefix']."groups_tests WHERE testid=".$i_testid)===false)
 showDBError(__FILE__, 1);
if($func->m_bd->update("DELETE FROM ".$srv_settings['table_prefix']."tests_questions WHERE testid=".$i_testid)===false)
 showDBError(__FILE__, 2);
if($func->m_bd->update("DELETE FROM ".$srv_settings['table_prefix']."tests WHERE testid=".$i_testid)===false)
 showDBError(__FILE__, 3);
}
?>
