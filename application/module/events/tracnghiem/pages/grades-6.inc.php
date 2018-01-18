<?php
$html ='';
$g_vars['page']['location'] = array('test_manager', 'grading_systems', 'grading_scale');

$this->_tpl_vars['lngstr'] = $lngstr;
$this->_tpl_vars['g_vars'] = $g_vars;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);

$f_gscaleid = (int)$func->readGetVar('gscaleid');
$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'grades-6';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'], $lngstr);
$html.=$func->writePanel2($g_vars, $g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_gradescales'] . '</h2>';
$html.=$func->writeErrorsWarningsBar();
//$func->writeInfoBar($lngstr['tooltip_gscales_grades']);
$i_pagewide_id = 0;

$i_direction = "";
$i_order_addon = "";
$i_sql_order_addon = "";
$i_tablefields = array(
    array($lngstr["label_gradescales_hdr_gscale_gradeid"], $lngstr["label_gradescales_hdr_gscale_gradeid_hint"], "gscale_gradeid"),
    array($lngstr["label_gradescales_hdr_grade_from"], $lngstr["label_gradescales_hdr_grade_from_hint"], "grade_from"),
    array($lngstr["label_gradescales_hdr_grade_to"], $lngstr["label_gradescales_hdr_grade_to_hint"], "grade_to"),
    array($lngstr["label_gradescales_hdr_grade_name"], $lngstr["label_gradescales_hdr_grade_name_hint"], "grade_name"),
    array($lngstr["label_gradescales_hdr_grade_description"], $lngstr["label_gradescales_hdr_grade_description_hint"], "grade_description"),
);
$i_order_no = isset($_GET["order"]) ? (int)$_GET["order"] : 0;
if ($i_order_no >= count($i_tablefields))
    $i_order_no = -1;
if ($i_order_no >= 0) {
    $i_direction = (isset($_GET["direction"]) && $_GET["direction"]) ? "DESC" : "";
    $i_order_addon = "&order=" . $i_order_no . "&direction=" . $i_direction;
    $i_sql_order_addon = " ORDER BY " . $i_tablefields[$i_order_no][2] . " " . $i_direction;
}

$i_url_limitto_addon = "";
$i_url_pageno_addon = "";
$i_url_limit_addon = "";
$i_pageno = 0;
$i_limitcount = isset($_GET["limitto"]) ? (int)$_GET["limitto"] : $G_SESSION['config_itemsperpage'];
if ($i_limitcount > 0) {
    $i_recordcount = $func->getRecordCount($srv_settings['table_prefix'] . 'gscales_grades', "gscaleid=" . $f_gscaleid);
    $i_pageno = isset($_GET["pageno"]) ? (int)$_GET["pageno"] : 1;
    if ($i_pageno < 1)
        $i_pageno = 1;
    $i_limitfrom = ($i_pageno - 1) * $i_limitcount;
    $i_pageno_count = floor(($i_recordcount - 1) / $i_limitcount) + 1;
    if ($i_limitfrom > $i_recordcount) {
        $i_pageno = $i_pageno_count;
        $i_limitfrom = ($i_pageno - 1) * $i_limitcount;
    }
    $i_url_limitto_addon .= "&limitto=" . $i_limitcount;
    $i_url_pageno_addon .= "&pageno=" . $i_pageno;
    $i_url_limit_addon .= $i_url_limitto_addon . $i_url_pageno_addon;
} else {
    $i_url_limitto_addon = "&limitto=";
    $i_url_limit_addon .= $i_url_limitto_addon;
    $i_limitfrom = -1;
    $i_limitcount = -1;
}

$html.= '<p><form name=gradescalesForm class=iactive method=post><table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>';
$html.= '<table cellpadding=0 cellspacing=0 border=0 width="100%" style="background: url(/events/p_tracnghiem/images/images/toolbar-background.gif) repeat-x"><tr vAlign=center><td width=2><img src="/events/p_tracnghiem/images/toolbar-left.gif" width=2 height=32></td><td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $f_gscaleid . '&action=creates"><img src="/events/p_tracnghiem/images/button-new-big.gif" border=0 title="' . $lngstr['label_action_create_gradescale'] . '"></a></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-cross-big.gif" border=0 title="' . $lngstr['label_action_gradescales_delete'] . '" style="cursor: hand;" onclick="f=document.gradescalesForm;if (confirm(\'' . $lngstr['qst_delete_gradescales'] . '\')) { f.action=\'/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $f_gscaleid . '&action=deletes&confirmed=1\';f.submit();}"></td><td width="100%">&nbsp;</td>';
if ($i_limitcount > 0) {
    if ($i_pageno > 1) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&action=edit&gscaleid=' . $f_gscaleid . '&pageno=1' . $i_url_limitto_addon . $i_order_addon . '"><img src="/events/p_tracnghiem/images/button-first-big.gif" border=0 title="' . $lngstr['button_first_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&action=edit&gscaleid=' . $f_gscaleid . '&pageno=' . max(($i_pageno - 1), 1) . $i_url_limitto_addon . $i_order_addon . '"><img src="/events/p_tracnghiem/images/button-prev-big.gif" border=0 title="' . $lngstr['button_prev_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-first-big-inactive.gif" border=0 title="' . $lngstr['button_first_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-prev-big-inactive.gif" border=0 title="' . $lngstr['button_prev_page'] . '"></td>';
    }
    if ($i_pageno < $i_pageno_count) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&action=edit&gscaleid=' . $f_gscaleid . '&pageno=' . min(($i_pageno + 1), $i_pageno_count) . $i_url_limitto_addon . $i_order_addon . '"><img src="/events/p_tracnghiem/images/button-next-big.gif" border=0 title="' . $lngstr['button_next_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&action=edit&gscaleid=' . $f_gscaleid . '&pageno=' . $i_pageno_count . $i_url_limitto_addon . $i_order_addon . '"><img src="/events/p_tracnghiem/images/button-last-big.gif" border=0 title="' . $lngstr['button_last_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-next-big-inactive.gif" border=0 title="' . $lngstr['button_next_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-last-big-inactive.gif" border=0 title="' . $lngstr['button_last_page'] . '"></td>';
    }
}
$html.= '<td width=2><img src="/events/p_tracnghiem/images/toolbar-right.gif" width=2 height=32></td></tr></table>';
$html.= '</td></tr><tr><td>';
$html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
$html.= '<tr vAlign=top><td class=rowhdr1 title="' . $lngstr['label_hdr_select_hint'] . '" width=22><input type=checkbox name=toggleAll onclick="toggleCBs(this);"></td>';
$func->writeQryTableHeaders('/?control=mobo_event_tracnghiem&func=grades&action=edit&gscaleid=' . $f_gscaleid . $i_url_limit_addon, $i_tablefields, $i_order_no, $i_direction);
$html.= '<td class=rowhdr1 colspan=3>' . $lngstr['label_hdr_action'] . '</td></tr>';
$i_rSet1 = $func->m_bd->SelectLimit("SELECT * FROM " . $srv_settings['table_prefix'] . "gscales_grades WHERE gscaleid=" . $f_gscaleid . $i_sql_order_addon, $i_limitcount, $i_limitfrom);
if ($i_rSet1) {
    $i_counter = 0;
    foreach($i_rSet1 as $key=>$value) {
        $rowname = ($i_counter % 2) ? "rowone" : "rowtwo";
        $html.= '<tr id=tr_' . $i_pagewide_id . ' class=' . $rowname . ' onmouseover="rollTR(' . $i_pagewide_id . ',1);" onmouseout="rollTR(' . $i_pagewide_id . ',0);"><td align=center width=22><input id=cb_' . $i_pagewide_id . ' type=checkbox name=box_gradescales[] value="' . $i_rSet1->fields["gscale_gradeid"] . '" onclick="toggleCB(this);"></td><td align=right>' . $i_rSet1->fields["gscale_gradeid"] . '</td><td align=right>' . sprintf("%.2f", $i_rSet1->fields["grade_from"]) . '%</td><td align=right>' . sprintf("%.2f", ($i_rSet1->fields["grade_to"] == 100 || $i_rSet1->fields["grade_to"] == 0) ? $i_rSet1->fields["grade_to"] : $i_rSet1->fields["grade_to"] - 0.01) . '%</td><td>' . $func->getTruncatedHTML($i_rSet1->fields["grade_name"]) . '</td><td>' . $i_rSet1->fields["grade_description"] . '</td>';
        $html.= '<td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $f_gscaleid . '&gscale_gradeid=' . $i_rSet1->fields["gscale_gradeid"] . '&action=edits"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_gradescale_edit'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $f_gscaleid . '&gscale_gradeid=' . $i_rSet1->fields["gscale_gradeid"] . '&action=moveup"><img width=20 height=10 border=0 src="/events/p_tracnghiem/images/button-up.gif" title="' . $lngstr['label_action_grade_moveup'] . '"></a><br><a href="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $f_gscaleid . '&gscale_gradeid=' . $i_rSet1->fields["gscale_gradeid"] . '&action=movedown"><img width=20 height=10 border=0 src="/events/p_tracnghiem/images/button-down.gif" title="' . $lngstr['label_action_grade_movedown'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $f_gscaleid . '&gscale_gradeid=' . $i_rSet1->fields["gscale_gradeid"] . $i_url_limit_addon . '&action=deletes" onclick="return confirmMessage(this, \'' . $lngstr['qst_delete_gradescale'] . '\')"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross.gif" title="' . $lngstr['label_action_gradescale_delete'] . '"></a></td></tr>';
        $i_counter++;
        $i_pagewide_id++;
    }
}
$html.= '</table>';
$html.= '</td></tr></table></form>';


$html.= $this->CI->load->view('events/tracnghiem/_footer.tpl.html', $this->_tpl_vars, true);
//die;
//displayTemplate('_footer');
$this->data['content_view'] = $html;
//$this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
$this->CI->template->write_view('content', 'events/tracnghiem/views.tpl.html', $this->data);
?>
