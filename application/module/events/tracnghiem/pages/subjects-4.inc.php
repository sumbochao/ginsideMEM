<?php
$getid = $func->m_bd->insert("INSERT INTO tbl_listevents(id_app,alias_app,type,name,push_title,description,typeevent,insertDate,startdate,enddate) VALUES (106,'mgh',0,'','','',1,NOW(),NOW(),NOW())");
if(!$getid) {
    showDBError(__FILE__, 1);
}else{
    $i_subjectid = $getid;
}
$func->gotoLocation('/?control=mobo_event_tracnghiem&func=subjects&subjectid='.$i_subjectid.'&action=edit');
?>
