<?php
$html= '';
$g_vars['page']['location'] = array('test_manager', 'grading_systems', 'edit_grading_system');
$this->_tpl_vars['lngstr'] = $lngstr;
$this->_tpl_vars['g_vars'] = $g_vars;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);

$f_gscaleid = (int)$func->readGetVar('gscaleid');
$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'grades-2';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'],$lngstr);
$html.=$func->writePanel2($g_vars,$g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_grades_edit'] . '</h2>';
$html.=$func->writeErrorsWarningsBar();

$i_rSet1 = $func->m_bd->Execute("SELECT * FROM " . $srv_settings['table_prefix'] . "gscales WHERE gscaleid=$f_gscaleid");
if ($i_rSet1) {
    foreach($i_rSet1 as $key1=>$value1) {
        $html.= '<p><form method=post action="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $f_gscaleid . '&action=settings">';
        $html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $i_rowno = 0;
        $html.=$func->writeTR2($lngstr['page_grades_gscaleid'], $value1["gscaleid"]);
        $html.=$func->writeTR2($lngstr['page_grades_gradename'], $func->getInputElement('gscale_name', $value1["gscale_name"]));
        $html.=$func->writeTR2($lngstr['page_grades_gradedescription'], $func->getTextArea('gscale_description', $value1["gscale_description"]));
        $i_scale_text = "";
        $i_rSet3 = $func->m_bd->Execute("SELECT gscale_gradeid, grade_name, grade_from, grade_to FROM " . $srv_settings['table_prefix'] . "gscales_grades WHERE gscaleid=" . $f_gscaleid);
        if ($i_rSet3) {
            foreach($i_rSet3 as $key3=>$value3) {
                $i_scale_text .= sprintf("%.1f", $value3['grade_from']) . '% - ' . sprintf("%.1f", $value3['grade_to']) . '% <b>' . $value3['grade_name'] . '</b> [<a href="/?control=mobo_event_tracnghiem&func=grades&action=edits&gscaleid=' . $f_gscaleid . '&gscale_gradeid=' . $value3['gscale_gradeid'] . '">' . $lngstr['page_grades']['edit_grade'] . '</a>]<br>';

            }
        }
        if ($i_scale_text)
            $i_scale_text .= '<br>';
        $html.=$func->writeTR2($lngstr['page_grades_gradescale'], $i_scale_text . '<a href="/?control=mobo_event_tracnghiem&func=grades&action=edit&gscaleid=' . $value1["gscaleid"] . '">' . $lngstr['page_grades_gradescale_text'] . '</a>');
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
//displayTemplate('_footer');
?>
