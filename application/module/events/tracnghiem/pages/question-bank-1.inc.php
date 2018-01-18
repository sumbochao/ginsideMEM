<?php
$html = '';
$g_vars['page']['location'] = array('question_bank', 'question_bank');
//$g_smarty->assign('g_vars', $g_vars);
//displayTemplate('_header');

$this->_tpl_vars['lngstr'] = $lngstr;
//$this->CI->template->write_view('content', 'events/tracnghiem/_header.tpl.html', $this->data);
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);
$g_vars['page']['selected_section'] = 'questionbank';
$g_vars['page']['selected_tab'] = 'questionbank';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'],$lngstr);

$html.=  $func->writePanel2($g_vars, $g_vars['page']['menu_2_items']);

$html.= '<h2>' . $lngstr['page_header_questionbank'] . '</h2>';
//$func->writeErrorsWarningsBar();
//$func->swriteInfoBar($lngstr['tooltip_questionbank']);
$i_pagewide_id = 0;

$i_subjectid_addon = '';
$i_sql_where_addon = '';
if (isset($_GET['subjectid']) && $_GET['subjectid'] != '') {
    $i_subjectid_addon .= '&subjectid=' . (int)$func->readGetVar('subjectid');
    $i_sql_where_addon .= $srv_settings['table_prefix'] . 'questions.subjectid=' . (int)$func->readGetVar('subjectid') . ' AND ';
}

$i_direction = "";
$i_order_addon = "";
$i_sql_order_addon = "";
$i_tablefields = array(
    array($lngstr["label_editquestions_hdr_questionid"], $lngstr["label_editquestions_hdr_questionid_hint"], $srv_settings['table_prefix'] . "questions.questionid"),
    array($lngstr["label_editquestions_hdr_subjectid"], $lngstr["label_editquestions_hdr_subjectid_hint"], $srv_settings['table_prefix'] . "questions.subjectid"),
    array($lngstr["label_editquestions_hdr_question_text"], $lngstr["label_editquestions_hdr_question_text_hint"], ""),
    array($lngstr["label_editquestions_hdr_question_type"], $lngstr["label_editquestions_hdr_question_type_hint"], $srv_settings['table_prefix'] . "questions.question_type"),
    array($lngstr["label_editquestions_hdr_question_points"], $lngstr["label_editquestions_hdr_question_points_hint"], $srv_settings['table_prefix'] . "questions.question_points"),
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
    $i_recordcount = $func->getRecordCount($srv_settings['table_prefix'] . 'questions', $i_sql_where_addon . "1=1");
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

$html.= '<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="">';
$html.= '<tr valign=top><td class=rowhdr2 colspan=2><a class=rowhdr2 href="javascript:void(0)" onclick="javascript:toggleSection(\'div_filter_questionbank\')">' . $lngstr['label_filter_header'] . '</td></tr>';
$html.= '<tr valign=top><td class=rowone colspan=2><div id=div_filter_questionbank style="display:' . (isset($_COOKIE['div_filter_questionbank']) && $_COOKIE['div_filter_questionbank'] == 'Y' ? 'block' : 'none') . '"><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';


$i_subjects = array('' => $lngstr['label_none']);

$i_rSet2 = $func->m_bd->getsubjects();
if (!$i_rSet2) {
    showDBError(__FILE__, 2);
} else {
    foreach($i_rSet2 as $key=>$value){
        $i_subjects[$value['id']] = $value['name'];
    }
}
$f_subjectid = isset($_GET['subjectid']) ? (int)$func->readGetVar('subjectid') : '';
$html.= $func->writeTR2($lngstr['page_editquestion_subjectid'], $func->getSelectElement('subjectid', $f_subjectid, $i_subjects, ' onchange="document.location.href=\'?control=mobo_event_tracnghiem&func=question_bank&module=all&subjectid=\'+this.value+\'' . $i_order_addon . $i_url_limit_addon . '\';"'));


$html.= '</table>';

$html.= '</div></td></tr>';
$html.= '</table></p>';

$html.= '<p><form name=qbankForm class=iactive method=post><table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>';
$html.= '<table cellpadding=0 cellspacing=0 border=0 width="100%" style="background: url(images/toolbar-background.gif) repeat-x"><tr vAlign=center><td width=2><img src="/events/p_tracnghiem/images/toolbar-left.gif" width=2 height=32></td><td width=32><a href="/?control=mobo_event_tracnghiem&func=question_bank&action=createq&module=all"><img src="/events/p_tracnghiem/images/button-new-big.gif" border=0 title="' . $lngstr['label_action_create_question'] . '"></a></td><td width=3><img src="/events/p_tracnghiem/simages/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-stats-big.gif" border=0 title="' . $lngstr['label_action_questions_stats'] . '" style="cursor: hand;" onclick="f=document.qbankForm;f.action=\'?control=mobo_event_tracnghiem&func=question_bank&action=statsq\';f.submit();"></td><td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td><td width=32><img src="/events/p_tracnghiem/images/button-cross-big.gif" border=0 title="' . $lngstr['label_action_questions_delete'] . '" style="cursor: hand;" onclick="f=document.qbankForm;if (confirm(\'' . $lngstr['qst_delete_questions'] . '\')) { f.action=\'?control=mobo_event_tracnghiem&func=question_bank&action=deleteq&confirmed=1\';f.submit();}"></td>';

$html.= '<td width="100%">&nbsp;</td>';

if ($i_limitcount > 0) {
    $i_url_pages_addon = $i_url_limitto_addon . $i_order_addon . $i_subjectid_addon;
    $html.= '<td vAlign=middle width=32><nobr>&nbsp;' . sprintf($lngstr['label']['KtoLofN'], $nRecordFrom, $nRecordTo, $i_recordcount) . '&nbsp;</nobr></td>';
    $html.= '<td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td>';
    $html.= '<td vAlign=middle width=32><nobr>&nbsp;';

    for ($i = $nStartPage; $i <= $nEndPage; $i++) {
        if ($i != $i_pageno)
            $html.= '&nbsp;<a href="/?control=mobo_event_tracnghiem&func=question_bank&pageno=' . $i . $i_url_pages_addon . '">' . $i . '</a>&nbsp;';
        else $html.= '<span class=currentitem>&nbsp;' . $i . '&nbsp;</span> ';
    }
    $html.= '</nobr></td>';
    $html.= '<td width=3><img src="/events/p_tracnghiem/images/toolbar-separator.gif" width=3 height=32 border=0></td>';
    if ($i_pageno > 1) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=question_bank&pageno=1' . $i_url_pages_addon . '"><img src="/events/p_tracnghiem/images/button-first-big.gif" border=0 title="' . $lngstr['button_first_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=question_bank&pageno=' . max(($i_pageno - 1), 1) . $i_url_pages_addon . '"><img src="/events/p_tracnghiem/images/button-prev-big.gif" border=0 title="' . $lngstr['button_prev_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-first-big-inactive.gif" border=0 title="' . $lngstr['button_first_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-prev-big-inactive.gif" border=0 title="' . $lngstr['button_prev_page'] . '"></td>';
    }
    if ($i_pageno < $i_pageno_count) {
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=question_bank&pageno=' . min(($i_pageno + 1), $i_pageno_count) . $i_url_pages_addon . '"><img src="/events/p_tracnghiem/images/button-next-big.gif" border=0 title="' . $lngstr['button_next_page'] . '"></a></td>';
        $html.= '<td width=32><a href="/?control=mobo_event_tracnghiem&func=question_bank&pageno=' . $i_pageno_count . $i_url_pages_addon . '"><img src="/events/p_tracnghiem/images/button-last-big.gif" border=0 title="' . $lngstr['button_last_page'] . '"></a></td>';
    } else {
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-next-big-inactive.gif" border=0 title="' . $lngstr['button_next_page'] . '"></td>';
        $html.= '<td width=32><img src="/events/p_tracnghiem/images/button-last-big-inactive.gif" border=0 title="' . $lngstr['button_last_page'] . '"></td>';
    }
}
$html.= '<td width=2><img src="/events/p_tracnghiem/images/toolbar-right.gif" width=2 height=32></td></tr></table>';
$html.= '</td></tr><tr><td>';
$html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
$html.= '<tr vAlign=top><td class=rowhdr1 title="' . $lngstr['label_hdr_select_hint'] . '" width=22><input type=checkbox name=toggleAll onclick="toggleCBs(this);"></td>';
$html.= $func->writeQryTableHeaders('?control=mobo_event_tracnghiem&func=question_bank&action=' . $i_subjectid_addon . $i_url_limit_addon, $i_tablefields, $i_order_no, $i_direction);
$html.= '<td class=rowhdr1 colspan=3>' . $lngstr['label_hdr_action'] . '</td></tr>';
$i_rSet1 = $func->m_bd->SelectLimit("SELECT " . $srv_settings['table_prefix'] . "questions.questionid, " . $srv_settings['table_prefix'] . "questions.subjectid, " . $srv_settings['table_prefix'] . "questions.question_text, " . $srv_settings['table_prefix'] . "questions.question_time, " . $srv_settings['table_prefix'] . "questions.question_type, " . $srv_settings['table_prefix'] . "questions.question_points, tbl_listevents.name FROM " . $srv_settings['table_prefix'] . "questions, tbl_listevents WHERE " . $i_sql_where_addon . "" . $srv_settings['table_prefix'] . "questions.subjectid=tbl_listevents.id and tbl_listevents.typeevent = 1" . $i_sql_order_addon, $i_limitcount, $i_limitfrom);

if ($i_rSet1) {
    $i_counter = 0;
    foreach($i_rSet1 as $key=>$val) {
        $rowname = ($i_counter % 2) ? "rowone" : "rowtwo";
        $html.= '<tr id=tr_' . $i_pagewide_id . ' class=' . $rowname . ' onmouseover="rollTR(' . $i_pagewide_id . ',1);"
        onmouseout="rollTR(' . $i_pagewide_id . ',0);"><td align=center width=22><input id=cb_' . $i_pagewide_id . '
        type=checkbox name=box_questions[] value="' . $val["questionid"] . '" onclick="toggleCB(this);"></td>
        <td align=right>' . $val["questionid"] . '</td><td>
        <a href="/?control=mobo_event_tracnghiem&func=question_bank&action=editt' . (isset($_GET["subjectid"]) && $_GET["subjectid"] != "" ? "" : '
        &subjectid=' . $val["subjectid"]) . $i_order_addon . $i_url_limit_addon . '">' . $func->convertTextValue($val["subject_name"]) . '</a></td>
        <td>' . $func->getTruncatedHTML($val["question_text"]) . '</td><td>';
        switch ($val["question_type"]) {
            case QUESTION_TYPE_MULTIPLECHOICE:
                $html.= $lngstr['label_atype_multiple_choice'];
                break;
            case QUESTION_TYPE_TRUEFALSE:
                $html.= $lngstr['label_atype_truefalse'];
                break;
            case QUESTION_TYPE_MULTIPLEANSWER:
                $html.= $lngstr['label_atype_multiple_answer'];
                break;
            case QUESTION_TYPE_FILLINTHEBLANK:
                $html.= $lngstr['label_atype_fillintheblank'];
                break;
            case QUESTION_TYPE_ESSAY:
                $html.= $lngstr['label_atype_essay'];
                break;
            case QUESTION_TYPE_RANDOM:
                $html.= $lngstr['label_atype_random'];
                break;
        }
        $html.= '</td><td align=right>' . ($val["question_type"] <> QUESTION_TYPE_RANDOM ? $val["question_points"] : '') . '</td>
        <td align=center width=22>' . ($val["question_type"] <> QUESTION_TYPE_RANDOM ? '
        <a href="/?control=mobo_event_tracnghiem&func=question_bank&questionid=' . $val["questionid"] . '&action=statsq&module=all">
        <img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-stats.gif" title="' . $lngstr['label_action_question_stats'] . '">
        </a>' : '<img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-stats-inactive.gif">') . '</td>
        <td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=question_bank&questionid=' . $val["questionid"] . '&action=editq&module=all">
        <img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_question_edit'] . '"></a>
        </td><td align=center width=22><a href="/?control=mobo_event_tracnghiem&func=question_bank&questionid=' . $val["questionid"] . $i_subjectid_addon . $i_order_addon . $i_url_limit_addon . '&action=deleteq" onclick="return confirmMessage(this, \'' . $lngstr['qst_delete_question'] . '\')"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-cross.gif" title="' . $lngstr['label_action_question_delete'] . '"></a></td></tr>';
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
