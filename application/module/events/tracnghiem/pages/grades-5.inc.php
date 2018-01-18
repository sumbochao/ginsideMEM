<?php
if (isset($_POST["box_grades"])) {
    foreach ($_POST["box_grades"] as $f_gscaleid) {
        deleteGrade($func,(int)$f_gscaleid,$srv_settings);
    }
} else {
    $f_gscaleid = (int)$func->readGetVar('gscaleid');
    deleteGrade($func,$f_gscaleid,$srv_settings);
}

$func->gotoLocation('/?control=mobo_event_tracnghiem&func=grades&' . $func->getURLAddon('', array('action', 'confirmed', 'gscaleid')));
function deleteGrade($func,$i_gscaleid,$srv_settings)
{
    global $g_db;

    if ($i_gscaleid > SYSTEM_GRADES_MAX_INDEX) {
        if ($func->m_bd->update("UPDATE " . $srv_settings['table_prefix'] . "tests SET gscaleid=1 WHERE gscaleid=" . $i_gscaleid) === false)
            showDBError(__FILE__, 1);
        if ($func->m_bd->update("DELETE FROM " . $srv_settings['table_prefix'] . "gscales_grades WHERE gscaleid=$i_gscaleid") === false)
            showDBError(__FILE__, 2);
        if ($func->m_bd->update("DELETE FROM " . $srv_settings['table_prefix'] . "gscales WHERE gscaleid=$i_gscaleid") === false)
            showDBError(__FILE__, 3);
    }
}

?>
