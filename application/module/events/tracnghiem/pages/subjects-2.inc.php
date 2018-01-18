<?php
$html= '';
$g_vars['page']['location'] = array('question_bank', 'subjects', 'edit_subject');

$this->_tpl_vars['g_vars'] = $g_vars;
$this->_tpl_vars['lngstr'] = $lngstr;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);

$f_subjectid = (int)$func->readGetVar('subjectid');
$g_vars['page']['selected_section'] = 'questionbank';
$g_vars['page']['selected_tab'] = 'subjects-2';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'],$lngstr);
$html.=$func->writePanel2($g_vars,$g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_subjects_settings'] . '</h2>';
//$func->writeErrorsWarningsBar();

$i_rSet1 = $func->m_bd->Execute("SELECT * FROM tbl_listevents WHERE id=$f_subjectid");

$listgame = array();
$i_game = $func->m_bd->Execute("SELECT * FROM app");
if ($i_game) {
	foreach($i_game as $key=>$value){
		$listgame[$value['alias_app']] = $value['name_app'];
	}
}
if ($i_rSet1) {
    foreach($i_rSet1 as $key=>$value) {

        $i_subjects = array('' => $lngstr['label_none']);
        $i_rSet2 = $func->m_bd->Execute("SELECT * FROM tbl_listevents");
        if ($i_rSet2) {
            foreach($i_rSet2 as $key2=>$value2) {
                if ($value2['id'] != $f_subjectid)
                    $i_subjects[$value2['id']] = $value2['name'];
                //$i_rSet2->MoveNext();
            }
        }
        $html.= '<p><form method=post action="/?control=mobo_event_tracnghiem&func=subjects&subjectid=' . $f_subjectid . '&action=edit">';
        $html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $i_rowno = 0;
        $html.=$func->writeTR2($lngstr['page_subjects_subjectid'], $value['id']);
		
		$html.=$func->writeTR2($lngstr['page_subjects_game'], $func->getSelectElement('alias_app', $value['alias_app'],$listgame));
		
        $html.=$func->writeTR2($lngstr['page_subjects_subjectname'], $func->getInputElement('subject_name', $value['name']));
        $html.=$func->writeTR2($lngstr['page_subjects_subjectdescription'], $func->getTextArea('subject_description', $value['description']));
        $html.= '</table>';

        $html.= '<p class=center><input class=btn type=submit name=bsubmit value=" ' . $lngstr['button_update'] . ' "> <input class=btn type=submit name=bcancel value=" ' . $lngstr['button_cancel'] . ' "></form>';
    }
}
//displayTemplate('_footer');
$html.= $this->CI->load->view('events/tracnghiem/_footer.tpl.html', $this->_tpl_vars, true);
//die;
//displayTemplate('_footer');
$this->data['content_view'] = $html;
//$this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
$this->CI->template->write_view('content', 'events/tracnghiem/views.tpl.html', $this->data);
?>
