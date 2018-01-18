<?php
 
$i_now = time();
$i_dateend = $i_now + 60 * 60 * 24 * 365 * 10 + 60 * 60 * 24 * 3;
$insertid = $func->m_bd->insert("INSERT INTO ".$srv_settings['table_prefix']."tests (test_createdate, test_datestart, test_dateend, test_instructions, test_notes) VALUES(".$i_now.", ".$i_now.", ".$i_dateend.", '', '')");
if($insertid ==false)
 showDBError(__FILE__, 1);
$i_testid = (int)$insertid;
$func->gotoLocation('/?control=mobo_event_tracnghiem&func=test_manager&testid='.$i_testid.'&action=settings');
?>
