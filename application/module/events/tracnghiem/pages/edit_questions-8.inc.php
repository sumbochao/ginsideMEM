<?php
$f_testid = (int)$func->readGetVar('testid');
$f_test_questionid = (int)$func->readGetVar('test_questionid');
if($f_test_questionid > 0) {
 
	$func->m_bd->update("LOCK TABLES ".$srv_settings['table_prefix']."tests_questions WRITE");
    $func->m_bd->update("UPDATE ".$srv_settings['table_prefix']."tests_questions SET test_questionid=0 WHERE test_questionid=".($f_test_questionid-1)." AND testid=".$f_testid);
    $func->m_bd->update("UPDATE ".$srv_settings['table_prefix']."tests_questions SET test_questionid=test_questionid-1 WHERE test_questionid=".$f_test_questionid." AND testid=".$f_testid);
    $func->m_bd->update("UPDATE ".$srv_settings['table_prefix']."tests_questions SET test_questionid=".$f_test_questionid." WHERE test_questionid=0 AND testid=".$f_testid);
    $func->m_bd->update("UNLOCK TABLES");
}

$func->gotoLocation('/?control=mobo_event_tracnghiem&func=test_manager&'.$func->getURLAddon('action=editt', array('action')));
?>
