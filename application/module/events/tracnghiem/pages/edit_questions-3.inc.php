<?php
$f_subjectid = (int)$func->readPostVar('subjectid');
$f_question_type = (int)$func->readPostVar('question_type');
if ($f_question_type < 0 || $f_question_type > QUESTION_TYPE_COUNT)
    $f_question_type = QUESTION_TYPE_MULTIPLECHOICE;
$f_question_text = $func->readPostVar('question_text');
$f_question_text = $func->qstr($f_question_text, get_magic_quotes_gpc());
$f_answer_correct = $func->readPostVar('answer_correct');
$f_answer_percents = $func->readPostVar('answer_percents');
$f_answer_text = $func->readPostVar('answer_text');
if (is_array($f_answer_text)) {
    foreach ($f_answer_text as $key => $val) {
        if ($f_answer_text[$key] != '') {
            $f_answer_text[$key] = $func->qstr(IGT_USE_EDITOR_FOR_ANSWERS ? $f_answer_text[$key] : $func->convertTextAreaHTML(true, $f_answer_text[$key]), get_magic_quotes_gpc());
        }
    }
}
$f_answer_feedback = array();
for ($i = 1; $i <= count($f_answer_text); $i++)
    $f_answer_feedback[$i] = $func->qstr(IGT_USE_EDITOR_FOR_FEEDBACK ? readPostVar('answer_feedback_' . $i) : $func->convertTextAreaHTML(true, $func->readPostVar('answer_feedback_' . $i)), get_magic_quotes_gpc());
$f_question_points = (float)$func->readPostVar('question_points');
$f_question_time_donotuse = (boolean)$func->readPostVar('question_time_donotuse');
if ($f_question_time_donotuse) {
    $f_question_time = 0;
} else {
    $f_question_time_hours = (int)$func->readPostVar('question_time_hours');
    $f_question_time_minutes = (int)$func->readPostVar('question_time_minutes');
    $f_question_time_seconds = (int)$func->readPostVar('question_time_seconds');
    $f_question_time = $f_question_time_seconds + $f_question_time_minutes * 60 + $f_question_time_hours * 3600;
    if ($f_question_time < 0)
        $f_question_time = 0;
}
$f_question_shufflea = (int)$func->readPostVar('question_shufflea');
$f_question_type2 = (int)(boolean)$func->readPostVar('question_type2');
$f_questionid = (int)$func->readGetVar('questionid');
switch ($f_question_type) {
    case QUESTION_TYPE_FILLINTHEBLANK:
        $f_answer_feedback = array(1 => $g_db->qstr('', 0));
        $f_answer_correct = array(1 => 1);
        $f_answer_percents = array(1 => 100);
        break;
}


include_once($DOCUMENT_PAGES . 'edit_questions-3-int.inc.php');
$f_answercount = (int)$func->readPostVar('answercount');

if (isset($_GET['resultid'])) {
    if (isset($_POST['bsubmit2'])) {
        $func->gotoLocation('/?control=mobo_event_tracnghiem&func=question_bank&' . $func->getURLAddon('action=createq&question_type=' . $f_question_type . '&subjectid=' . $f_subjectid . '&answercount=' . $f_answercount, array('action', 'questionid', 'question_type', 'subjectid', 'answercount')));
    } else {
        $func->gotoLocation('/?control=mobo_event_tracnghiem&func=reports_manager&' . $func->getURLAddon('action=viewq', array('action', 'questionid', 'question_type', 'subjectid', 'answercount')));
    }
} else if (isset($_GET['testid'])) {
    $f_testid = (int)$func->readGetVar('testid');
    if (isset($_POST['bsubmit2'])) {
        $func->gotoLocation('/?control=mobo_event_tracnghiem&func=question_bank&' . $func->getURLAddon('action=createq&question_type=' . $f_question_type . '&subjectid=' . $f_subjectid . '&answercount=' . $f_answercount, array('action', 'questionid', 'question_type', 'subjectid', 'answercount')));
    } else {
        $func->gotoLocation('/?control=mobo_event_tracnghiem&func=test_manager&' . $func->getURLAddon('action=editt', array('action', 'questionid', 'question_type', 'subjectid', 'answercount')));
    }
} else {
    if (isset($_POST['bsubmit2'])) {
        $func->gotoLocation('/?control=mobo_event_tracnghiem&func=question_bank&' . $func->getURLAddon('action=createq&question_type=' . $f_question_type . '&subjectid=' . $f_subjectid . '&answercount=' . $f_answercount, array('action', 'questionid', 'question_type', 'subjectid', 'answercount')));
    } else {
        $func->gotoLocation('/?control=mobo_event_tracnghiem&func=question_bank&' . $func->getURLAddon('', array('action', 'questionid', 'question_type', 'subjectid', 'answercount')));
    }
}
?>
