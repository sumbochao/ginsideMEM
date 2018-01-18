<?php
$html = '';
$g_vars['page']['location'] = array('test_manager', 'grading_systems');

$this->_tpl_vars['lngstr'] = $lngstr;
$this->_tpl_vars['g_vars'] = $g_vars;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);

$g_vars['page']['selected_section'] = 'testmanager';
$g_vars['page']['selected_tab'] = 'grades';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'],$lngstr);
$html.= $func->writePanel2($g_vars, $g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_grades'] . '</h2>';
$html.= $func->writeErrorsWarningsBar();
//$func->writeInfoBar($lngstr['tooltip_gscales']);
$i_pagewide_id = 0;

$i_direction = "";
$i_order_addon = "";
$i_sql_order_addon = "";
$i_tablefields = array(
    array($lngstr["label_grades_hdr_gscaleid"], $lngstr["label_grades_hdr_gscaleid_hint"], "gscaleid"),
    array($lngstr["label_grades_hdr_gscale_name"], $lngstr["label_grades_hdr_gscale_name_hint"], "gscale_name"),
    array($lngstr["label_grades_hdr_gscale_description"], $lngstr["label_grades_hdr_gscale_description_hint"], "gscale_description"),
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
    $i_recordcount = $func->getRecordCount($srv_settings['table_prefix'] . 'gscales');
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

$nPageWindow = IGT_CONFIG_NAVIGATION_WINDOW;
if (!IGT_CONFIG_NAVIGATION_SHOW_ALWAYS) {
    if ($i_recordcount == 0 || ($i_pageno_count == 1 && $this->NavShowAll == false))
        return;
}

if ($i_pageno > floor($nPageWindow / 2) + 1 && $i_pageno_count > $nPageWindow)
    $nStartPage = $i_pageno - floor($nPageWindow / 2);
else
    $nStartPage = 1;

if ($i_pageno <= $i_pageno_count - floor($nPageWindow / 2) && $nStartPage + $nPageWindow - 1 <= $i_pageno_count)
    $nEndPage = $nStartPage + $nPageWindow - 1;
else {
    $nEndPage = $i_pageno_count;
    if ($nEndPage - $nPageWindow + 1 >= 1)
        $nStartPage = $nEndPage - $nPageWindow + 1;
}
$nRecordFrom = ($i_pageno - 1) * $i_limitcount + 1;
if ($i_pageno != $i_pageno_count)
    $nRecordTo = $i_pageno * $i_limitcount;
else $nRecordTo = $i_recordcount;

$html.= '<p><form name=gradesForm class=iactive method=post><table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>';
$html.= '<table cellpadding=0 cellspacing=0 border=0 width="100%" style="background: url(/events/p_tracnghiem/images/toolbar-background.gif) repeat-x"><tr vAlign=center><td width=2><img src="/events/p_tracnghiem/images/toolbar-left.gif" width=2 height=32></td><td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&action=create"><img src="/events/p_tracnghiem/images/button-new-big.gif" border=0 title="' . $lngstr['label_action_create_grade'] . '"></a></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-cross-big.gif" border=0 title="' . $lngstr['label_action_grades_delete'] . '" style="cursor: hand;" onclick="f=document.gradesForm;if (confirm(\'' . $lngstr['qst_delete_grades'] . '\')) { f.action=\'/?control=mobo_event_tracnghiem&func=grades&action=delete&confirmed=1\';f.submit();}"></td><td width="100%">&nbsp;</td>';
if ($i_limitcount > 0) {
    $i_url_pages_addon = $i_url_limitto_addon . $i_order_addon;
    $html.= '<td vAlign=middle width=32><nobr>&nbsp;' . sprintf($lngstr['label']['KtoLofN'], $nRecordFrom, $nRecordTo, $i_recordcount) . '&nbsp;</nobr></td>';
    $html.= '<td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td>';
    $html.= '<td vAlign=middle width=32><nobr>&nbsp;';
    for ($i = $nStartPage; $i <= $nEndPage; $i++) {
        if ($i != $i_pageno)
            $html.= '&nbsp;<a href="/?control=mobo_event_tracnghiem&func=grades&pageno=' . $i . $i_url_pages_addon . '">' . $i . '</a>&nbsp;';
        else $html.= '<span class=currentitem>&nbsp;' . $i . '&nbsp;</span> ';
    }
    $html.= '</nobr></td>';
    $html.= '<td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td>';
    if ($i_pageno > 1) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&pageno=1' . $i_url_pages_addon . '"><img src="/events/p_tracnghiem/images/button-first-big.gif" border=0 title="' . $lngstr['button_first_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&pageno=' . max(($i_pageno - 1), 1) . $i_url_pages_addon . '"><img src="/events/p_tracnghiem/images/button-prev-big.gif" border=0 title="' . $lngstr['button_prev_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-first-big-inactive.gif" border=0 title="' . $lngstr['button_first_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-prev-big-inactive.gif" border=0 title="' . $lngstr['button_prev_page'] . '"></td>';
    }
    if ($i_pageno < $i_pageno_count) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&pageno=' . min(($i_pageno + 1), $i_pageno_count) . $i_url_pages_addon . '"><img src="/events/p_tracnghiem/images/button-next-big.gif" border=0 title="' . $lngstr['button_next_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=grades&pageno=' . $i_pageno_count . $i_url_pages_addon . '"><img src="/events/p_tracnghiem/images/button-last-big.gif" border=0 title="' . $lngstr['button_last_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-next-big-inactive.gif" border=0 title="' . $lngstr['button_next_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-last-big-inactive.gif" border=0 title="' . $lngstr['button_last_page'] . '"></td>';
    }
}
$html.= '<td width=2><img src="/events/p_tracnghiem/images/toolbar-right.gif" width=2 height=32></td></tr></table>';
$html.= '</td></tr><tr><td>';
$html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
$html.= '<tr vAlign=top><td class=rowhdr1 title="' . $lngstr['label_hdr_select_hint'] . '" width=22><input type=checkbox name=toggleAll onclick="toggleCBs(this);"></td>';
$html.= $func->writeQryTableHeaders('/?control=mobo_event_tracnghiem&func=grades&action=' . $i_url_limit_addon, $i_tablefields, $i_order_no, $i_direction);
$html.= '<td class=rowhdr1 colspan=3>' . $lngstr['label_hdr_action'] . '</td></tr>';
$i_rSet1 = $func->m_bd->SelectLimit("SELECT * FROM " . $srv_settings['table_prefix'] . "gscales" . $i_sql_order_addon, $i_limitcount, $i_limitfrom);
if ($i_rSet1) {
    $i_counter = 0;
    foreach($i_rSet1 as $key1=>$value1) {
        $rowname = ($i_counter % 2) ? "rowone" : "rowtwo";
        $html.= '<tr id=tr_' . $i_pagewide_id . ' class=' . $rowname . ' onmouseover="rollTR(' . $i_pagewide_id . ',1);" onmouseout="rollTR(' . $i_pagewide_id . ',0);"><td align=center width=22' . ($value1["gscaleid"] > SYSTEM_GRADES_MAX_INDEX ? '' : ' class=system') . '><input id=cb_' . $i_pagewide_id . ' type=checkbox name=box_grades[] value="' . $value1["gscaleid"] . '" onclick="toggleCB(this);"></td><td align=right>' . $value1["gscaleid"] . '</td><td>' . $func->getTruncatedHTML($value1["gscale_name"]) . '</td><td>' . $value1["gscale_description"] . '</td>';
        $html.= '<td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $value1["gscaleid"] . '&action=settings"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-gear.gif" title="' . $lngstr['label_action_grade_settings'] . '"></a></td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $value1["gscaleid"] . '&action=edit"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_gradescales_edit'] . '"></a></td><td align=center width=22>' . ($value1["gscaleid"] > SYSTEM_GRADES_MAX_INDEX ? '<a href="/?control=mobo_event_tracnghiem&func=grades&gscaleid=' . $value1["gscaleid"] . $i_url_limit_addon . '&action=delete" onclick="return confirmMessage(this, \'' . $lngstr['qst_delete_grade'] . '\')"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross.gif" title="' . $lngstr['label_action_grade_delete'] . '"></a>' : '<img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross-inactive.gif">') . '</td></tr>';
        $i_counter++;
        $i_pagewide_id++;
    }
}
$html.= '</table>';
$html.= '</td></tr></table></form>';
//displayTemplate('_footer');


$html.= $this->CI->load->view('events/tracnghiem/_footer.tpl.html', $this->_tpl_vars, true);
//die;
//displayTemplate('_footer');
$this->data['content_view'] = $html;
//$this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
$this->CI->template->write_view('content', 'events/tracnghiem/views.tpl.html', $this->data);
?>
