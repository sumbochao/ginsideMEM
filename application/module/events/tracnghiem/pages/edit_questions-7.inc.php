<?php
$f_testid = (int)$func->readGetVar('testid');
if ($f_testid) {
    $i_subjectid = 0;
    $i_rSet1 = $func->m_bd->Execute("SELECT subjectid FROM " . $srv_settings['table_prefix'] . "tests WHERE testid={$f_testid}");
    if ($i_rSet1) {
        foreach ($i_rSet1 as $key1 => $value1) {
            $i_subjectid = (int)$value1['subjectid'];
        }
    }
    $statusinsert = $func->m_bd->insert("INSERT INTO " . $srv_settings['table_prefix'] . "questions (subjectid, question_pre, question_post, question_text, question_solution) VALUES(" . $i_subjectid . ", '', '', '', '')");
    if ($statusinsert== false)
        showDBError(__FILE__, 2);

    $i_questionid = (int)$statusinsert;
    $func->createQuestionLink($f_testid, $i_questionid, $srv_settings);
    $func->gotoLocation('/?control=mobo_event_tracnghiem&func=question_bank&' . $func->getURLAddon('action=editq&questionid=' . $i_questionid, array('action', 'questionid')));
} else {
    $statusinsert = $func->m_bd->insert("INSERT INTO " . $srv_settings['table_prefix'] . "questions (question_pre, question_post, question_text, question_solution) VALUES('', '', '', '')");
    if ($statusinsert == false)
        showDBError(__FILE__, 3);
    $i_questionid = (int)$statusinsert;
    $func->gotoLocation('/?control=mobo_event_tracnghiem&func=question_bank&' . $func->getURLAddon('action=editq&questionid=' . $i_questionid, array('action', 'questionid')));
}
?>
