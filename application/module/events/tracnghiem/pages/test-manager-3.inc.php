<?php
$f_testid = (int)$func->readGetVar('testid');

$f_test_enabled = (int)(boolean)$func->readPostVar('test_enabled');
$f_test_type = (int)(boolean)$func->readPostVar('test_type');
$f_subjectid = (int)$func->readPostVar('subjectid');
$f_gscaleid = (int)$func->readPostVar('gscaleid');
$f_test_name = $func->readPostVar('test_name');
$f_test_name = $func->qstr($f_test_name, get_magic_quotes_gpc());
$f_test_code = $func->readPostVar('test_code');
$f_test_code = $func->qstr($f_test_code, get_magic_quotes_gpc());
$f_test_datestart = $func->readPostVar('test_datestart');
if (empty($f_test_datestart))
    $f_test_datestart = 0;
else $f_test_datestart = (int)strtotime($f_test_datestart);
$f_test_dateend = $func->readPostVar('test_dateend');
if (empty($f_test_dateend))
    $f_test_dateend = 0;
else $f_test_dateend = (int)strtotime($f_test_dateend);
$f_test_time_donotuse = (boolean)$func->readPostVar('test_time_donotuse');
if ($f_test_time_donotuse) {
    $nTestTime = 0;
} else {
    $f_strTestTime = $func->readPostVar('test_time');
    $arrTestTime = explode(':', $f_strTestTime);
    $nTestTime = 0;
    if (!empty($arrTestTime))
        $nTestTime += (int)array_pop($arrTestTime);
    if (!empty($arrTestTime))
        $nTestTime += (int)(array_pop($arrTestTime) * 60);
    if (!empty($arrTestTime))
        $nTestTime += (int)(array_pop($arrTestTime) * 3600);
    if ($nTestTime < 0)
        $nTestTime = 0;
}
$f_test_timeforceout = (int)(boolean)$func->readPostVar('test_timeforceout');
$f_test_attempts = (int)$func->readPostVar('test_attempts');
$f_test_contentprotection = (int)$func->readPostVar('test_contentprotection');
$f_test_qsperpage = (int)$func->readPostVar('test_qsperpage');
if ($f_test_qsperpage < 0)
    $f_test_qsperpage = 0;
$f_test_canreview = (int)$func->readPostVar('test_canreview');
if ($f_test_canreview < 0)
    $f_test_canreview = 0;
$f_test_shuffleq = (int)(boolean)$func->readPostVar('test_shuffleq');
$f_test_shufflea = (int)(boolean)$func->readPostVar('test_shufflea');
$f_test_showqfeedback = (int)(boolean)$func->readPostVar('test_showqfeedback');
$f_test_result_showgrade = (int)(boolean)$func->readPostVar('test_result_showgrade');
$f_test_result_showgradefeedback = (int)(boolean)$func->readPostVar('test_result_showgradefeedback');
$f_test_result_showanswers = (int)(boolean)$func->readPostVar('test_result_showanswers');
$f_test_result_showpoints = (int)(boolean)$func->readPostVar('test_result_showpoints');
$f_test_result_rtemplateid = (int)$func->readPostVar('test_result_rtemplateid');
$f_rtemplateid = (int)$func->readPostVar('rtemplateid');
$f_test_reportgradecondition = (int)$func->readPostVar('test_reportgradecondition');
$f_test_result_showhtml = (int)(boolean)$func->readPostVar('test_result_showhtml');
$f_test_result_showpdf = (int)(boolean)$func->readPostVar('test_result_showpdf');
$f_test_result_email = $func->readPostVar('test_result_email');
$f_test_result_email = $func->qstr($f_test_result_email, get_magic_quotes_gpc());
$f_result_etemplateid = (int)$func->readPostVar('result_etemplateid');
$f_test_result_emailtouser = (int)(boolean)$func->readPostVar('test_result_emailtouser');
$f_test_description = $func->readPostVar('test_description');
$f_test_description = $func->qstr($f_test_description, get_magic_quotes_gpc());
$f_test_instructions = $func->readPostVar('test_instructions');

if ($func->isHTMLAreaEmpty($f_test_instructions))
    $f_test_instructions = '';
$f_test_instructions = $func->qstr($f_test_instructions, get_magic_quotes_gpc());
$f_test_prevtestid = (int)$func->readPostVar('test_prevtestid');
$f_test_nexttestid = (int)$func->readPostVar('test_nexttestid');
$f_test_price = (float)$func->readPostVar('test_price');
$f_test_price = (int)($f_test_price * 100);
$f_test_other_repeatuntilcorrect = (int)(boolean)$func->readPostVar('test_other_repeatuntilcorrect');
$f_test_notes = $func->readPostVar('test_notes');
$f_test_notes = $func->qstr($f_test_notes, get_magic_quotes_gpc());
$f_test_forall = (int)(boolean)$func->readPostVar('test_forall');
$f_group = isset($_POST['group']) ? $_POST['group'] : array();

if ($i_rSet2 = $func->m_bd->Execute("SELECT id as subjectid FROM tbl_listevents WHERE typeevent = 1 AND id=$f_subjectid"))
    $sql_subject_exists = count($i_rSet2) > 0;
else $sql_subject_exists = false;
if (!$sql_subject_exists)
    $g_vars['page']['errors'] .= $lngstr['err_subject_doesnotexist'];


$strQrySet = "test_type=" . $f_test_type . ",eventid=".$f_subjectid.",  subjectid=" . $f_subjectid . ", gscaleid=" . $f_gscaleid . ", rtemplateid=" . $f_rtemplateid . ", test_reportgradecondition=" . $f_test_reportgradecondition . ", result_etemplateid=" . $f_result_etemplateid . ", test_name=" . $f_test_name . ", test_code=" . $f_test_code . ", test_description=" . $f_test_description . ", test_time=" . $nTestTime . ", test_timeforceout=$f_test_timeforceout, test_attempts=$f_test_attempts, test_contentprotection=$f_test_contentprotection, test_shuffleq=$f_test_shuffleq, test_shufflea=$f_test_shufflea, test_qsperpage=$f_test_qsperpage, test_canreview=$f_test_canreview, test_showqfeedback=$f_test_showqfeedback, test_result_showgrade=$f_test_result_showgrade, test_result_showgradefeedback=$f_test_result_showgradefeedback, test_result_showanswers=$f_test_result_showanswers, test_result_showpoints=$f_test_result_showpoints, test_result_rtemplateid=$f_test_result_rtemplateid, test_result_showhtml=$f_test_result_showhtml, test_result_showpdf=$f_test_result_showpdf, test_result_email=$f_test_result_email, test_result_emailtouser=$f_test_result_emailtouser, test_datestart=$f_test_datestart, test_dateend=$f_test_dateend, test_instructions=$f_test_instructions, test_prevtestid=$f_test_prevtestid, test_nexttestid=$f_test_nexttestid, test_price=$f_test_price, test_other_repeatuntilcorrect=$f_test_other_repeatuntilcorrect, test_notes=$f_test_notes, test_forall=$f_test_forall, test_enabled=$f_test_enabled";

if ($g_vars['page']['errors']) {
    include_once($DOCUMENT_PAGES . "test-manager-2.inc.php");
} else {

    if ($func->m_bd->update("UPDATE " . $srv_settings['table_prefix'] . "tests SET " . $strQrySet . " WHERE testid=$f_testid") === false)
        showDBError(__FILE__, 1);

    if ($func->m_bd->update("DELETE FROM " . $srv_settings['table_prefix'] . "groups_tests WHERE testid=" . $f_testid) === false)
        showDBError(__FILE__, 2);
    foreach ($f_group as $i_groupid => $i_ischecked) {
        if ($i_ischecked)
            $func->m_bd->insert("INSERT INTO " . $srv_settings['table_prefix'] . "groups_tests (groupid, testid) VALUES (" . $i_groupid . ", " . $f_testid . ")");
    }
    if (isset($_POST['bsubmit2']))
        $func->gotoLocation('?control=mobo_event_tracnghiem&func=test_manager&' . $func->getURLAddon('?action=editt', array('action')));
    else $func->gotoLocation('?control=mobo_event_tracnghiem&func=test_manager&' . $func->getURLAddon('', array('action', 'testid')));
}
?>