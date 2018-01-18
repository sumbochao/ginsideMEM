<?php
$f_testid = (int)$func->readGetVar('testid');
if (isset($_POST["box_qlinks"]) && is_array($_POST["box_qlinks"])) {

    $i_qlinks = $_POST["box_qlinks"];
    rsort($i_qlinks, SORT_NUMERIC);
    foreach ($i_qlinks as $f_test_questionid) {

        $func->deleteQuestionLink($f_testid, (int)$f_test_questionid,$srv_settings);
    }
} else {
    $f_test_questionid = (int)$func->readGetVar('test_questionid');

    $func->deleteQuestionLink($f_testid, $f_test_questionid,$srv_settings);
}

$func->gotoLocation('/?control=mobo_event_tracnghiem&func=test_manager&' . $func->getURLAddon('action=editt', array('action', 'confirmed', 'test_questionid')));
?>
