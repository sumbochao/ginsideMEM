<?php
$f_gscaleid = (int)$func->readGetVar('gscaleid');
 
$f_gscale_name = $func->readPostVar('gscale_name');
$f_gscale_name = $func->qstr($f_gscale_name, get_magic_quotes_gpc());
$f_gscale_description = $func->readPostVar('gscale_description');
$f_gscale_description = $func->qstr($f_gscale_description, get_magic_quotes_gpc());
 
  
if($func->m_bd->update("UPDATE ".$srv_settings['table_prefix']."gscales SET gscale_name=$f_gscale_name, gscale_description=$f_gscale_description WHERE gscaleid=$f_gscaleid")===false)
 showDBError(__FILE__, 1);
$func->gotoLocation('/?control=mobo_event_tracnghiem&func=grades');
?>
