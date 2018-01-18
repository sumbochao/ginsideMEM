<?php
if (isset($_POST["box_questions"])) {
    foreach ($_POST["box_questions"] as $f_questionid) {
        deleteQuestion($func,(int)$f_questionid,$srv_settings);
    }
} else {
    $f_questionid = (int)$func->readGetVar('questionid');
    deleteQuestion($func,$f_questionid,$srv_settings);
}

if (isset($_GET["testid"])) {

    $func->gotoLocation('/?control=mobo_event_tracnghiem&func=test_manager&' . $func->getURLAddon('?action=editt', array('action', 'confirmed', 'questionid')));
} else {

    $func->gotoLocation('/?control=mobo_event_tracnghiem&func=question_bank&' . $func->getURLAddon('', array('action', 'confirmed', 'questionid')));
}
function deleteQuestion($func,$i_questionid,$srv_settings)
{
    $i_rSet1 = $func->m_bd->Execute("SELECT test_questionid, testid FROM " . $srv_settings['table_prefix'] . "tests_questions WHERE questionid=$i_questionid ORDER BY test_questionid DESC");
    if ($i_rSet1) {
        //showDBError(__FILE__, 1);
       foreach($i_rSet1 as $key=>$value) {
            $func->deleteQuestionLink($value["testid"], $value["test_questionid"],$srv_settings);
//            $i_rSet1->MoveNext();
        }
  //      $i_rSet1->Close();
    }

    if ($func->m_bd->update("DELETE FROM " . $srv_settings['table_prefix'] . "answers WHERE questionid=$i_questionid") === false)
        showDBError(__FILE__, 2);

    if ($func->m_bd->update("DELETE FROM " . $srv_settings['table_prefix'] . "questions WHERE questionid=$i_questionid") === false)
        showDBError(__FILE__, 3);
}

?>
