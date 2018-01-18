<?php
$f_testid = (int)$func->readGetVar('testid');
if(isset($_POST["box_questions"])) {
	foreach($_POST["box_questions"] as $f_questionid) {

        $func->createQuestionLink($f_testid, (int)$f_questionid,$srv_settings);
}
} else {
	$f_questionid = (int)$func->readGetVar('questionid');

    $func->createQuestionLink($f_testid, $f_questionid,$srv_settings);
}

$func->gotoLocation('/?control=mobo_event_tracnghiem&func=test_manager&'.$func->getURLAddon('action=editt', array('action')));
?>