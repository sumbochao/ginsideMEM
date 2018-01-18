<?php
$html = '';
$g_vars['page']['location'] = array('test_manager', 'grading_systems', 'grading_scale', 'edit_grade');
$func->initTextEditor($G_SESSION['config_editortype'], array('grade_feedback'));

$this->_tpl_vars['lngstr'] = $lngstr;
$this->_tpl_vars['g_vars'] = $g_vars;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);

$f_gscaleid = (int)$func->readGetVar('gscaleid');
$f_gscale_gradeid = (int)$func->readGetVar('gscale_gradeid');
$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'grades-7';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'], $lngstr);
$html.=$func->writePanel2($g_vars, $g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_grade_settings'] . '</h2>';
$html.=$func->writeErrorsWarningsBar();

$i_rSet1 = $func->m_bd->Execute("SELECT * FROM " . $srv_settings['table_prefix'] . "gscales_grades WHERE gscaleid=" . $f_gscaleid . " AND gscale_gradeid=" . $f_gscale_gradeid);
if ($i_rSet1) {
    foreach ($i_rSet1 as $key1 => $value1) {
        $html.= '<p><form method=post action="/?control=mobo_event_tracnghiem&func=grades&action=edits&gscaleid=' . $f_gscaleid . '&gscale_gradeid=' . $f_gscale_gradeid . '">';
        $html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $i_rowno = 0;
        $html.=$func->writeTR2Fixed($lngstr['page_grade_gscaleid'], $value1['gscale_gradeid']);
        $html.=$func->writeTR2Fixed($lngstr['page_grade_gradename'], $func->getInputElement('grade_name', $value1['grade_name']));
        $html.=$func->writeTR2Fixed($lngstr['page_grade_gradefrom'], $func->getInputElement('grade_from', $value1['grade_from']));
        $html.=$func->writeTR2Fixed($lngstr['page_grade_gradeto'], $func->getInputElement('grade_to', $value1['grade_to']));
        $html.=$func->writeTR2Fixed($lngstr['page_grade_gradedescription'], $func->getTextArea('grade_description', $value1['grade_description']));
        $html.= '<tr valign=top><td class=rowhdr2 colspan=2><a class=rowhdr2 href="javascript:void(0)" onclick="javascript:toggleSection(\'div_grades_advanced\')">' . $lngstr['page_grade']['section_advanced'] . '</td></tr>';
        $html.= '<tr valign=top><td class=rowone colspan=2><div id=div_grades_advanced style="display:' . (!isset($_COOKIE['div_grades_advanced']) || $_COOKIE['div_grades_advanced'] == 'Y' ? 'block' : 'none') . '"><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $html.=$func->writeTR2Fixed($lngstr['page_grade']['feedback'], $func->getTextEditor($G_SESSION['config_editortype'], 'grade_feedback', $value1['grade_feedback']));
        $html.= '</table></div></td></tr>';
        $html.= '</table>';

        $html.= '<p class=center><input class=btn type=submit name=bsubmit value=" ' . $lngstr['button_update'] . ' "> <input class=btn type=submit name=bcancel value=" ' . $lngstr['button_cancel'] . ' "></form>';
    }
}

$html.= $this->CI->load->view('events/tracnghiem/_footer.tpl.html', $this->_tpl_vars, true);
//die;
//displayTemplate('_footer');
$this->data['content_view'] = $html;
//$this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
$this->CI->template->write_view('content', 'events/tracnghiem/views.tpl.html', $this->data);
?>
