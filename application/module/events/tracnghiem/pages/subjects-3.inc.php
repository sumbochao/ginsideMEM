<?php
$f_subjectid = (int)$func->readGetVar('subjectid');
 
$f_subject_parent_subjectid = (int)$func->readPostVar('subject_parent_subjectid');
$f_subject_name = $func->readPostVar('subject_name');
$f_subject_game = $func->readPostVar('alias_app');
$f_subject_name = $func->qstr($f_subject_name, get_magic_quotes_gpc());
$f_subject_description = $func->readPostVar('subject_description');
$f_subject_description = $func->qstr($f_subject_description, get_magic_quotes_gpc());
      
 
if($g_vars['page']['errors']) {
	include_once($DOCUMENT_PAGES."subjects-2.inc.php");
} else {
	if($func->m_bd->update("UPDATE tbl_listevents SET link_event='http://m-app.mobo.vn/events/tracnghiem/?eventid=$f_subjectid&' ,alias_app='$f_subject_game',parent_id=$f_subject_parent_subjectid, name=$f_subject_name, description=$f_subject_description WHERE id=$f_subjectid")===false)
        showDBError(__FILE__, 2);
$func->gotoLocation('/?control=mobo_event_tracnghiem&func=subjects');
}
?>
