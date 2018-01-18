<?php
$f_gscaleid = (int)$func->readGetVar('gscaleid');
$f_gscale_gradeid = (int)$func->readGetVar('gscale_gradeid');

$f_grade_name = $func->readPostVar('grade_name');
$f_grade_name = $func->qstr($f_grade_name, get_magic_quotes_gpc());
$f_grade_description = $func->readPostVar('grade_description');
$f_grade_description = $func->qstr($f_grade_description, get_magic_quotes_gpc());
$f_grade_feedback = $func->readPostVar('grade_feedback');
$f_grade_feedback = $func->qstr($f_grade_feedback, get_magic_quotes_gpc());
$f_grade_from = (float)$func->readPostVar('grade_from');
if($f_grade_from < 0)
 $f_grade_from = 0;
if($f_grade_from > 100)
 $f_grade_from = 100;
$f_grade_to = (float)$func->readPostVar('grade_to');
if($f_grade_to < 0)
 $f_grade_to = 0;
if($f_grade_to > 100)
 $f_grade_to = 100;
 
  
if($func->m_bd->update("UPDATE ".$srv_settings['table_prefix']."gscales_grades SET grade_name=$f_grade_name, grade_description=$f_grade_description, grade_feedback=$f_grade_feedback, grade_from='$f_grade_from', grade_to='$f_grade_to' WHERE gscaleid=$f_gscaleid AND gscale_gradeid=$f_gscale_gradeid")===false)
    showDBError(__FILE__, 2);
$func->gotoLocation('/?control=mobo_event_tracnghiem&func=grades&action=edit&gscaleid='.$f_gscaleid);
?>
