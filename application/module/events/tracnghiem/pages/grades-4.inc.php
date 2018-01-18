<?php
 $insertid = $func->m_bd->insert("INSERT INTO ".$srv_settings['table_prefix']."gscales (gscale_name) VALUES ('')");
if($insertid==false)
 showDBError(__FILE__, 1);
$i_gscaleid = (int)$insertid;
$func->gotoLocation('/?control=mobo_event_tracnghiem&func=grades&gscaleid='.$i_gscaleid.'&action=settings');
?>
