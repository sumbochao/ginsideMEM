<?php
$html = '';
$g_vars['page']['location'] = array('test_manager', 'test_manager', 'test_settings');
$func->initTextEditor($G_SESSION['config_editortype'], array('test_instructions'));
$g_vars['page']['meta'] .= '<style type="text/css">@import url(' . $srv_settings['url_root'] . 'events/p_tracnghiem/calendar/skins/aqua/theme.css);</style>
<script type="text/javascript" src="' . $srv_settings['url_root'] . 'events/p_tracnghiem/calendar/calendar.js"></script>
<script type="text/javascript" src="' . $srv_settings['url_root'] . 'events/p_tracnghiem/calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="' . $srv_settings['url_root'] . 'events/p_tracnghiem/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="' . $srv_settings['url_root'] . 'events/p_tracnghiem/calendar/calendar-helper.js"></script>';


$this->_tpl_vars['lngstr'] = $lngstr;
$this->_tpl_vars['g_vars'] = $g_vars;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);

$f_testid = (int)$func->readGetVar('testid');
$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'testmanager-2';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'], $lngstr);
$html.=$func->writePanel2($g_vars, $g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_test_settings'] . '</h2>';
$html.=$func->writeErrorsWarningsBar();

$i_rSet1 = $func->m_bd->SelectLimit("SELECT * FROM " . $srv_settings['table_prefix'] . "tests WHERE testid=$f_testid", 1);
if ($i_rSet1) {
    foreach ($i_rSet1 as $key => $value) {
        $i_subjects = array();
        $i_rSet2 = $func->m_bd->Execute("SELECT * FROM tbl_listevents WHERE typeevent = 1");
        if ($i_rSet2) {
            foreach($i_rSet2 as $key1=>$value1) {
                $i_subjects[$value1['id']] = $value1['name'];
            }
        }
        $html.= '<p><form method=post action="/?control=mobo_event_tracnghiem&func=test_manager&testid=' . $f_testid . '&action=settings" onsubmit="return submitForm();">';
        $html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $html.= '<tr class=rowtwo valign=top><td colspan=2>' . $func->getCheckbox('test_enabled', $value['test_enabled'], $lngstr['page_edittests_testenabled']) . '</td></tr>';
        $i_rowno = 1;

        $html.=$func->writeTR2Fixed($lngstr['page_edittests_subjectid'], $func->getSelectElement('subjectid', $value['subjectid'], $i_subjects) . ' <a href="?control=mobo_event_tracnghiem&func=subjects&testid=' . $f_testid . '">' . $lngstr['label_subjects_edit'] . '</a>');
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_testname'], $func->getInputElement('test_name', $value['test_name']));
        $html.=$func->writeTR2Fixed($lngstr['page_testmanager']['test_code'], $func->getInputElement('test_code', $value['test_code']));
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_testdescription'], $func->getInputElement('test_description', $value['test_description']));
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_testinstructions'], $func->getTextEditor($G_SESSION['config_editortype'], 'test_instructions', $value['test_instructions']));
        $strTestDateStartFormatted = ($value['test_datestart'] > 0) ? $func->getDateLocal($lngstr['language']['calendar']['date_format'], $value['test_datestart']) : '';
        $strTestDateStart = '<input name="test_datestart" id="test_datestart" value="' . $strTestDateStartFormatted . '" class=inp type=text size=20><a href="javascript:void(0);" title="' . $lngstr['calendar']['hint'] . '"><img src="/events/p_tracnghiem/images/button-calendar.gif" alt="' . $lngstr['calendar']['hint'] . '" class="calendar-icon" onclick="return showCalendar(\'test_datestart\', \'' . $lngstr['language']['calendar']['date_format'] . '\', \'24\', true);" onmouseover="this.className+=\' calendar-icon-hover\';" onmouseout="this.className = this.className.replace(/\s*calendar-icon-hover/ig, \'\');"></a>';
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_teststart'], $strTestDateStart);
        $strTestDateEndFormatted = ($value['test_dateend'] > 0) ? $func->getDateLocal($lngstr['language']['calendar']['date_format'], $value['test_dateend']) : '';
        $strTestDateEnd = '<input name="test_dateend" id="test_dateend" value="' . $strTestDateEndFormatted . '" class=inp type=text size=20><a href="javascript:void(0);" title="' . $lngstr['calendar']['hint'] . '"><img src="/events/p_tracnghiem/images/button-calendar.gif" alt="' . $lngstr['calendar']['hint'] . '" class="calendar-icon" onclick="return showCalendar(\'test_dateend\', \'' . $lngstr['language']['calendar']['date_format'] . '\', \'24\', true);" onmouseover="this.className+=\' calendar-icon-hover\';" onmouseout="this.className = this.className.replace(/\s*calendar-icon-hover/ig, \'\');"></a>';
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_testend'], $strTestDateEnd);
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_testtime'], $func->getTimeElement('test_time', $value['test_time']) . '<br>' . $func->getCheckbox('test_timeforceout', $value['test_timeforceout'], $lngstr['page_edittests_testtimeforceout']));
        $html.=$func->writeTR2Fixed($lngstr['page-testmanager']['attempts_allowed'], $func->getSelectElement('test_attempts', $value['test_attempts'], $lngstr['page-testmanager']['attempts_allowed_list']));

        $i_gradingsystems = array();
        $i_rSet5 = $func->m_bd->Execute("SELECT gscaleid, gscale_name FROM " . $srv_settings['table_prefix'] . "gscales ORDER BY gscaleid");
        if ($i_rSet5) {
            foreach ($i_rSet5 as $key5=>$value5) {
                $i_gradingsystems[$value5['gscaleid']] = $value5['gscale_name'];
            }
        }
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_gradingsystem'], $func->getSelectElement('gscaleid', $value['gscaleid'], $i_gradingsystems));
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_showquestions'], $func->getSelectElement('test_qsperpage', $value['test_qsperpage'], $lngstr['page_testmanager']['showquestions_items']));
        $html.=$func->writeTR2Fixed($lngstr['page_testmanager']['review_options'], $func->getSelectElement('test_canreview', $value['test_canreview'], $lngstr['page_testmanager']['review_list']));
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_shuffle'], $func->getCheckbox('test_shuffleq', $value['test_shuffleq'], $lngstr['page_edittests_shuffleq']) . '<br>' . $func->getCheckbox('test_shufflea', $value['test_shufflea'], $lngstr['page_edittests_shufflea']));

        $i_rtemplates_text = array(0 => $lngstr['label_none']);
        $i_rSet6 = $func->m_bd->Execute("SELECT rtemplateid, rtemplate_name FROM " . $srv_settings['table_prefix'] . "rtemplates ORDER BY rtemplateid");
        if ($i_rSet6) {
            foreach($i_rSet6 as $key6=>$value6) {
                $i_rtemplates_text[$value6['rtemplateid']] = $value6['rtemplate_name'];
            }
        }
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_resultsettings'], $func->getCheckbox('test_showqfeedback', $value['test_showqfeedback'], $lngstr['page_edittests_result_showqfeedback']) . '<br>' . $func->getCheckbox('test_result_showgrade', $value['test_result_showgrade'], $lngstr['page_edittests_result_showgrade']) . '<br>' . $func->getCheckbox('test_result_showgradefeedback', $value['test_result_showgradefeedback'], $lngstr['page_testmanager']['result_showgradefeedback']) . '<br>' . $func->getCheckbox('test_result_showanswers', $value['test_result_showanswers'], $lngstr['page_edittests_result_showanswers']) . '<br>' . $func->getCheckbox('test_result_showpoints', $value['test_result_showpoints'], $lngstr['page_edittests_result_showpoints']) . '<br>' . $lngstr['page_testsettings']['custom_report'] . ' ' . $func->getSelectElement('test_result_rtemplateid', $value['test_result_rtemplateid'], $i_rtemplates_text));

        $i_gradeconditions = array(0 => $lngstr['page-testsettings']['no_condition']);
        $i_rSet7 = $func->m_bd->Execute("SELECT gscale_gradeid, grade_name FROM " . $srv_settings['table_prefix'] . "gscales_grades WHERE gscaleid=" . $value['gscaleid']);
        if ($i_rSet7) {
            foreach($i_rSet7 as $key7=>$value7) {
                $i_gradeconditions[$value7['gscale_gradeid']] = $value7['grade_name'];
            }
        }

        $html.=$func->writeTR2Fixed($lngstr['page_edittests_advancedreport'], $lngstr['page-testsettings']['report_template'] . ' ' . $func->getSelectElement('rtemplateid', $value['rtemplateid'], $i_rtemplates_text) . '<br>' . $lngstr['page-testsettings']['report_grade_condition'] . ' ' . $func->getSelectElement('test_reportgradecondition', $value['test_reportgradecondition'], $i_gradeconditions) . '<br>' . $func->getCheckbox('test_result_showpdf', $value['test_result_showpdf'], $lngstr['page_edittests_advancedreport_showpdf']) . '<br>' . $func->getCheckbox('test_result_showhtml', $value['test_result_showhtml'], $lngstr['page_edittests_advancedreport_showhtml']));


        $i_etemplates_text = array(0 => $lngstr['label_do_not_send_email']);
        $i_rSet4 = $func->m_bd->Execute("SELECT etemplateid, etemplate_name FROM " . $srv_settings['table_prefix'] . "etemplates ORDER BY etemplateid");
        if ($i_rSet4) {
            foreach($i_rSet4 as $key4=>$value4) {
                $i_etemplates_text[$value4['etemplateid']] = $value4['etemplate_name'];
            }
        }
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_sendresultsbyemail'], $lngstr['page_edittests_sendresultsbyemail_template'] . ' ' . $func->getSelectElement('result_etemplateid', $value['result_etemplateid'], $i_etemplates_text) . '<br>' . $lngstr['page_edittests_sendresultsbyemail_to'] . ' ' . $func->getInputElement('test_result_email', $value['test_result_email']) . ', ' . $func->getCheckbox('test_result_emailtouser', $value['test_result_emailtouser'], $lngstr['page_edittests_result_emailtouser']));

        $i_groups_text = '';
        $i_rSet3 = $func->m_bd->Execute("SELECT " . $srv_settings['table_prefix'] . "groups.groupid, " . $srv_settings['table_prefix'] . "groups.group_name, " . $srv_settings['table_prefix'] . "groups_tests.groupid as isingroup FROM " . $srv_settings['table_prefix'] . "groups LEFT JOIN " . $srv_settings['table_prefix'] . "groups_tests ON testid=" . $f_testid . " AND " . $srv_settings['table_prefix'] . "groups.groupid=" . $srv_settings['table_prefix'] . "groups_tests.groupid");
        if ($i_rSet3) {
            foreach($i_rSet3 as $key3=>$value3) {
                if ($i_groups_text)
                    $i_groups_text .= '<br>';
                $i_groups_text .= $func->getCheckbox('group[' . $value3['groupid'] . ']', ($value3['isingroup'] <> NULL), $value3['group_name']);

            }
        }

        $html.=$func->writeTR2Fixed($lngstr['page_testmanager']['testprice'], $func->getInputElement('test_price', sprintf("%.2f", ($value['test_price'] / 100)), 5));
        $html.= '<tr valign=top><td class=rowhdr2 colspan=2><a class=rowhdr2 href="javascript:void(0)" onclick="javascript:toggleSection(\'div_testmanager_settings_groups\')">' . $lngstr['page_testmanager']['settings']['section_groups'] . '</td></tr>';
        $html.= '<tr valign=top><td class=rowone colspan=2><div id=div_testmanager_settings_groups style="display:' . (isset($_COOKIE['div_testmanager_settings_groups']) && $_COOKIE['div_testmanager_settings_groups'] == 'Y' ? 'block' : 'none') . '"><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_assignedto'], '<p>' . $i_groups_text . '<p>' . $func->getCheckbox('test_forall', $value['test_forall'], $lngstr['page_edittests_assignto_everybody']));

        $i_tests_items = array(0 => $lngstr['label_none']);
        $i_rSet3 = $func->m_bd->Execute("SELECT " . $srv_settings['table_prefix'] . "tests.testid, " . $srv_settings['table_prefix'] . "tests.test_name FROM " . $srv_settings['table_prefix'] . "tests ORDER BY testid");
        if ($i_rSet3) {
            foreach($i_rSet3 as $key3=>$value3) {
                $i_tests_items[$value3['testid']] = $value3['test_name'];
            }
        }
        $html.= '</table></div></td></tr>';
        $html.= '<tr valign=top><td class=rowhdr2 colspan=2><a class=rowhdr2 href="javascript:void(0)" onclick="javascript:toggleSection(\'div_testmanager_settings_advanced\')">' . $lngstr['page_testmanager']['settings']['section_advanced'] . '</td></tr>';
        $html.= '<tr valign=top><td class=rowone colspan=2><div id=div_testmanager_settings_advanced style="display:' . (!isset($_COOKIE['div_testmanager_settings_advanced']) || $_COOKIE['div_testmanager_settings_advanced'] == 'Y' ? 'block' : 'none') . '"><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $html.=$func->writeTR2Fixed($lngstr['page_testmanager']['content_protection'], $func->getSelectElement('test_contentprotection', $value['test_contentprotection'], $lngstr['page_testmanager']['content_protection_list']));
        $html.=$func->writeTR2Fixed($lngstr['page-testmanager']['prevtest'], $func->getSelectElement('test_prevtestid', $value['test_prevtestid'], $i_tests_items));
        $html.=$func->writeTR2Fixed($lngstr['page-testmanager']['nexttest'], $func->getSelectElement('test_nexttestid', $value['test_nexttestid'], $i_tests_items));
        $html.=$func->writeTR2Fixed($lngstr['page_testmanager']['other_options'], $func->getCheckbox('test_other_repeatuntilcorrect', $value['test_other_repeatuntilcorrect'], $lngstr['page_testmanager']['repeat_until_answered_correctly']));
        $html.= '</table></div></td></tr>';
        $html.= '<tr valign=top><td class=rowhdr2 colspan=2><a class=rowhdr2 href="javascript:void(0)" onclick="javascript:toggleSection(\'div_testmanager_settings_notes\')">' . $lngstr['page_testmanager']['settings']['section_notes'] . '</td></tr>';
        $html.= '<tr valign=top><td class=rowone colspan=2><div id=div_testmanager_settings_notes style="display:' . (isset($_COOKIE['div_testmanager_settings_notes']) && $_COOKIE['div_testmanager_settings_notes'] == 'Y' ? 'block' : 'none') . '"><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $html.=$func->writeTR2Fixed($lngstr['page_edittests_testnotes'], $func->getTextArea('test_notes', $value['test_notes']));
        $html.= '</table></div></td></tr>';
        $html.= '</table>';

        $html.= '<p class=center><input class=btn type=submit name=bsubmit value=" ' . $lngstr['button_update'] . ' "> <input class=btn type=submit name=bsubmit2 value=" ' . $lngstr['button_update_and_edit_questions'] . ' "> <input class=btn type=submit name=bcancel value=" ' . $lngstr['button_cancel'] . ' "></form>';
    }
}


//displayTemplate('_footer');
$html.= $this->CI->load->view('events/tracnghiem/_footer.tpl.html', $this->_tpl_vars, true);
//die;
//displayTemplate('_footer');
$this->data['content_view'] = $html;
//$this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
$this->CI->template->write_view('content', 'events/tracnghiem/views.tpl.html', $this->data);
//displayTemplate('_footer');
?>