<?php
if (isset($_POST["box_subjects"])) {
    foreach ($_POST["box_subjects"] as $f_subjectid) {
        deletesubject($func,(int)$f_subjectid,$srv_settings);
    }
} else {
    $f_subjectid = (int)$func->readGetVar('subjectid');
    deletesubject($func,$f_subjectid,$srv_settings);
}

$func->gotoLocation('/?control=mobo_event_tracnghiem&func=subjects' . $func->getURLAddon('', array('action', 'confirmed')));
function deletesubject($func,$i_subjectid,$srv_settings)
{
    if ($i_subjectid > SYSTEM_SUBJECTS_MAX_INDEX) {

        if ($func->m_bd->update("UPDATE " . $srv_settings['table_prefix'] . "tests SET subjectid=1 WHERE subjectid=" . $i_subjectid) === false)
            showDBError(__FILE__, 1);
        if ($func->m_bd->update("UPDATE " . $srv_settings['table_prefix'] . "questions SET subjectid=1 WHERE subjectid=" . $i_subjectid) === false)
            showDBError(__FILE__, 2);
        if ($func->m_bd->update("DELETE FROM " . $srv_settings['table_prefix'] . "subjects WHERE subjectid=$i_subjectid") === false)
            showDBError(__FILE__, 3);
    }
}

?>
