<?php
$g_vars['page']['location'] = array('question_bank', 'question_bank');
//$g_smarty->assign('g_vars', $g_vars);
$html= '';
$this->_tpl_vars['g_vars'] = $g_vars;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);
//displayTemplate('_header');
$g_vars['page']['selected_section'] = 'questionbank';
$g_vars['page']['selected_tab'] = 'questionbank-2';
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'],$lngstr);
$html.=$func->writePanel2($g_vars,$g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_question_stats'] . '</h2>';
$html.=$func->writeErrorsWarningsBar();
function getGauge($i_percentage, $i_color = 'blue')
{
    return '<img src="/events/p_tracnghiem/images/gauge-' . $i_color . '-left.gif" width=3 height=12><img src="/events/p_tracnghiem/images/gauge-' . $i_color . '.gif" width=' . round($i_percentage * 300 / 100) . ' height=12><img src="/events/p_tracnghiem/images/gauge-' . $i_color . '-right.gif" width=3 height=12>';
}
function writeQuestionStats($func,$i_questionid,$srv_settings,$lngstr)
{
    global $i_counter;
    $i_questionid = (int)$i_questionid;
    $i_rSet1 = $func->m_bd->SelectLimit("SELECT * FROM " . $srv_settings['table_prefix'] . "questions WHERE questionid=" . $i_questionid, 1);
    if (!$i_rSet1) {
        showDBError(__FILE__, 1);
    } else {
        foreach($i_rSet1 as  $key=>$value) {
            $i_question_text = $value["question_text"];
            $i_question_type = $value["question_type"];
        }
    }

    $i_answers_text = array();
    $i_answercount = 0;
    $i_answers_correct = array();
    $answers_clicks = array();
    $answers_clicks_total = 0;
    $question_views_total = 0;
    $question_correct = 0;
    $question_incorrect = 0;
    $question_partially = 0;
    $question_undefined = 0;
    $i_rSet2 = $func->m_bd->Execute("SELECT * FROM " . $srv_settings['table_prefix'] . "answers WHERE questionid=" . $i_questionid . " ORDER BY answerid");
    if (!$i_rSet2) {
        showDBError(__FILE__, 2);
    } else {
        foreach($i_rSet2 as $key=>$value) {
            $i_answercount++;
            $i_answers_text[$i_answercount] = $value["answer_text"];
            $i_answers_correct[$i_answercount] = $value["answer_correct"];
            $answers_clicks[$i_answercount] = 0;
        }
    }

    $i_rSet3 = $func->m_bd->Execute("SELECT * FROM " . $srv_settings['table_prefix'] . "results_answers WHERE questionid=" . $i_questionid . " ORDER BY result_answerid");
    if (!$i_rSet2) {
        showDBError(__FILE__, 3);
    } else {
        switch ($i_question_type) {
            case QUESTION_TYPE_MULTIPLECHOICE:
            case QUESTION_TYPE_TRUEFALSE:
                foreach ($i_rSet3 as $key=>$value) {
                    $answers_clicks[(int)$value["result_answer_text"]]++;
                    switch ($value["result_answer_iscorrect"]) {
                        case IGT_ANSWER_IS_INCORRECT:
                            $question_incorrect++;
                            break;
                        case IGT_ANSWER_IS_PARTIALLYCORRECT:
                            $question_partially++;
                            break;
                        case IGT_ANSWER_IS_CORRECT:
                            $question_correct++;
                            break;
                    }
                    $answers_clicks_total++;
                    $question_views_total++;
                }
                break;
            case QUESTION_TYPE_MULTIPLEANSWER:
                foreach ($i_rSet3 as $key=>$value) {
                    if ($value["result_answer_text"]) {
                        $i_answers_given = explode(QUESTION_TYPE_MULTIPLEANSWER_BREAK, $value["result_answer_text"]);
                        foreach ($i_answers_given as $i_answer_given) {
                            $answers_clicks[(int)$i_answer_given]++;
                            $answers_clicks_total++;
                        }
                    }
                    switch ($value["result_answer_iscorrect"]) {
                        case IGT_ANSWER_IS_INCORRECT:
                            $question_incorrect++;
                            break;
                        case IGT_ANSWER_IS_PARTIALLYCORRECT:
                            $question_partially++;
                            break;
                        case IGT_ANSWER_IS_CORRECT:
                            $question_correct++;
                            break;
                    }
                    $question_views_total++;
                }
                break;
            case QUESTION_TYPE_FILLINTHEBLANK:
                $i_fillintheblank_text = array();
                $i_fillintheblank_clicks = array();
                $i_fillintheblank_count = 0;
                foreach ($i_rSet3 as $key=>$value) {
                    $i_found = array_search($value["result_answer_text"], $i_fillintheblank_text);
                    if (!$i_found) {
                        $i_fillintheblank_count++;
                        $i_fillintheblank_text[$i_fillintheblank_count] = $value["result_answer_text"];
                        $i_fillintheblank_clicks[$i_fillintheblank_count] = 1;
                    } else {
                        $i_fillintheblank_clicks[$i_found]++;
                    }
                    switch ($value["result_answer_iscorrect"]) {
                        case IGT_ANSWER_IS_INCORRECT:
                            $question_incorrect++;
                            break;
                        case IGT_ANSWER_IS_PARTIALLYCORRECT:
                            $question_partially++;
                            break;
                        case IGT_ANSWER_IS_CORRECT:
                            $question_correct++;
                            break;
                    }
                    $answers_clicks_total++;
                    $question_views_total++;
                }
                break;
            case QUESTION_TYPE_ESSAY:
                foreach ($i_rSet3 as $key=>$value) {
                    switch ($value["result_answer_iscorrect"]) {
                        case IGT_ANSWER_IS_INCORRECT:
                            $question_incorrect++;
                            break;
                        case IGT_ANSWER_IS_PARTIALLYCORRECT:
                            $question_partially++;
                            break;
                        case IGT_ANSWER_IS_CORRECT:
                            $question_correct++;
                            break;
                        case IGT_ANSWER_IS_UNDEFINED:
                            $question_undefined++;
                            break;
                    }
                    $answers_clicks_total++;
                    $question_views_total++;
                }
                break;
        }
    }

    switch ($i_question_type) {
        case QUESTION_TYPE_MULTIPLECHOICE:
        case QUESTION_TYPE_TRUEFALSE:
        case QUESTION_TYPE_MULTIPLEANSWER:
        case QUESTION_TYPE_ESSAY:

            $html.= '<tr id=tr_' . $i_counter . ' class=rowone>';
            $html.= '<td rowspan=' . ($i_answercount + 5 + ($i_question_type == QUESTION_TYPE_ESSAY ? 1 : 0)) . ' align=right>' . $i_questionid . '</td>';
            $html.= '<td colspan=4><b>' . $func->getTruncatedHTML($i_question_text, SYSTEM_TRUNCATED_LENGTH_LONG) . '</b></td>';
            $html.= '<td rowspan=' . ($i_answercount + 5 + ($i_question_type == QUESTION_TYPE_ESSAY ? 1 : 0)) . ' align=center><a href="question-bank.php?questionid=' . $i_questionid . '&action=editq"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_question_edit'] . '"></a></td>';
            $html.= '</tr>';

            foreach ($i_answers_text as $key => $val) {
                $html.= '<tr class=rowone>';
                $html.= '<td>' . $func->getTruncatedHTML($val, SYSTEM_TRUNCATED_LENGTH_LONG) . '</td>';
                if ($answers_clicks_total <> 0) {
                    $i_answers_clicks_percentage = $answers_clicks[(int)$key] * 100 / $answers_clicks_total;
                    $html.= '<td>' . getGauge($i_answers_clicks_percentage) . '</td>';
                    $html.= '<td align=right>' . $answers_clicks[(int)$key] . '</td>';
                    $html.= '<td align=right>' . sprintf("%.2f", $i_answers_clicks_percentage) . '%</td>';
                } else {
                    $html.= '<td colspan=3 align=center class=gray>' . $lngstr['label_notapplicable'] . '</td>';
                }
                $html.= '</tr>';
            }
            break;
        case QUESTION_TYPE_FILLINTHEBLANK:

            $i_sort_order_1 = SORT_DESC;
            $i_sort_type_1 = SORT_NUMERIC;
            $i_sort_order_2 = SORT_ASC;
            $i_sort_type_2 = SORT_STRING;
            array_multisort($i_fillintheblank_clicks, $i_sort_order_1, $i_sort_type_1, $i_fillintheblank_text, $i_sort_order_2, $i_sort_type_2);
            $i_answercount = min(sizeof($i_fillintheblank_clicks), MAX_STATS_ANSWERS_FILLINTHEBLANK) + 1;

            $html.= '<tr id=tr_' . $i_counter . ' class=rowone>';
            $html.= '<td rowspan=' . ($i_answercount + 5) . ' align=right>' . $i_questionid . '</td>';
            $html.= '<td colspan=4><b>' . getTruncatedHTML($i_question_text, SYSTEM_TRUNCATED_LENGTH_LONG) . '</b></td>';
            $html.= '<td rowspan=' . ($i_answercount + 5) . ' align=center><a href="question-bank.php?questionid=' . $i_questionid . '&action=editq"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_question_edit'] . '"></a></td>';
            $html.= '</tr>';

            $i = 0;
            $i_others_clicks = 0;
            $i_others_count = 0;
            foreach ($i_fillintheblank_clicks as $key => $val) {
                $i++;

                if ($i <= MAX_STATS_ANSWERS_FILLINTHEBLANK) {
                    $html.= '<tr class=rowone>';
                    $html.= '<td>' . getTruncatedHTML($i_fillintheblank_text[$key], SYSTEM_TRUNCATED_LENGTH_LONG) . '</td>';
                    if ($answers_clicks_total <> 0) {
                        $i_answers_clicks_percentage = $val * 100 / $answers_clicks_total;
                        $html.= '<td>' . getGauge($i_answers_clicks_percentage) . '</td>';
                        $html.= '<td align=right>' . $val . '</td>';
                        $html.= '<td align=right>' . sprintf("%.2f", $i_answers_clicks_percentage) . '%</td>';
                    } else {
                        $html.= '<td colspan=3 align=center class=gray>' . $lngstr['label_notapplicable'] . '</td>';
                    }
                    $html.= '</tr>';
                } else {

                    $i_others_clicks += $val;
                    $i_others_count++;
                }
            }
            $html.= '<tr class=rowone>';
            $html.= '<td>' . sprintf($lngstr['page_questionstats_fillintheblank_others'], $i_others_count) . '</td>';
            if ($answers_clicks_total <> 0) {
                $i_answers_clicks_percentage = $i_others_clicks * 100 / $answers_clicks_total;
                $html.= '<td>' . getGauge($i_answers_clicks_percentage) . '</td>';
                $html.= '<td align=right>' . $i_others_clicks . '</td>';
                $html.= '<td align=right>' . sprintf("%.2f", $i_answers_clicks_percentage) . '%</td>';
            } else {
                $html.= '<td colspan=3 align=center class=gray>' . $lngstr['label_notapplicable'] . '</td>';
            }
            $html.= '</tr>';
            break;
        case QUESTION_TYPE_RANDOM:

            $html.= '<tr id=tr_' . $i_counter . ' class=rowone>';
            $html.= '<td rowspan=5 align=right>' . $i_questionid . '</td>';
            $html.= '<td colspan=4><b></b></td>';
            $html.= '<td rowspan=5 align=center><a href="question-bank.php?questionid=' . $i_questionid . '&action=editq"><img width=20 height=20 border=0 src="/events/p_tracnghiem/images/button-edit.gif" title="' . $lngstr['label_action_question_edit'] . '"></a></td>';
            $html.= '</tr>';
            break;
    }
    $html.= '<tr class=rowone><td colspan=4><img src="/events/p_tracnghiem/images/1x1.gif" width=1 height=5></td></tr>';

    $html.= '<tr class=rowone>';
    $html.= '<td>' . $lngstr['page_questionstats_correct_count'] . '</td>';
    if ($question_views_total <> 0) {
        $question_correct_percentage = $question_correct * 100 / $question_views_total;
        $html.= '<td>' . getGauge($question_correct_percentage, 'green') . '</td>';
        $html.= '<td align=right>' . $question_correct . '</td>';
        $html.= '<td align=right>' . sprintf("%.2f", $question_correct_percentage) . '%</td>';
    } else {
        $html.= '<td colspan=3 align=center class=gray>' . $lngstr['label_notapplicable'] . '</td>';
    }
    $html.= '</tr>';

    $html.= '<tr class=rowone>';
    $html.= '<td>' . $lngstr['page_questionstats_partially_count'] . '</td>';
    if ($question_views_total <> 0) {
        $question_partially_percentage = $question_partially * 100 / $question_views_total;
        $html.= '<td>' . getGauge($question_partially_percentage, 'yellow') . '</td>';
        $html.= '<td align=right>' . $question_partially . '</td>';
        $html.= '<td align=right>' . sprintf("%.2f", $question_partially_percentage) . '%</td>';
    } else {
        $html.= '<td colspan=3 align=center class=gray>' . $lngstr['label_notapplicable'] . '</td>';
    }
    $html.= '</tr>';

    $html.= '<tr class=rowone>';
    $html.= '<td>' . $lngstr['page_questionstats_incorrect_count'] . '</td>';
    if ($question_views_total <> 0) {
        $question_incorrect_percentage = $question_incorrect * 100 / $question_views_total;
        $html.= '<td>' . getGauge($question_incorrect_percentage, 'red') . '</td>';
        $html.= '<td align=right>' . $question_incorrect . '</td>';
        $html.= '<td align=right>' . sprintf("%.2f", $question_incorrect_percentage) . '%</td>';
    } else {
        $html.= '<td colspan=3 align=center class=gray>' . $lngstr['label_notapplicable'] . '</td>';
    }
    $html.= '</tr>';
    if ($i_question_type == QUESTION_TYPE_ESSAY) {

        $html.= '<tr class=rowone>';
        $html.= '<td>' . $lngstr['page_questionstats_undefined_count'] . '</td>';
        if ($question_views_total <> 0) {
            $question_undefined_percentage = $question_undefined * 100 / $question_views_total;
            $html.= '<td>' . getGauge($question_undefined_percentage, 'gray') . '</td>';
            $html.= '<td align=right>' . $question_undefined . '</td>';
            $html.= '<td align=right>' . sprintf("%.2f", $question_undefined_percentage) . '%</td>';
        } else {
            $html.= '<td colspan=3 align=center class=gray>' . $lngstr['label_notapplicable'] . '</td>';
        }
        $html.= '</tr>';
    }
	return $html;
}

$html.= '<p><form name=qbankForm class=iactive method=post><table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>';
$html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
$html.= '<tr vAlign=top>';
$html.= '<td class=rowhdr1 title="' . $lngstr['label_questionstats_hdr_questionid_hint'] . '">' . $lngstr['label_questionstats_hdr_questionid'] . '</td>';
$html.= '<td class=rowhdr1 title="' . $lngstr['label_questionstats_hdr_questiondata_hint'] . '" colspan=2>' . $lngstr['label_questionstats_hdr_questiondata'] . '</td>';
$html.= '<td class=rowhdr1 title="' . $lngstr['label_questionstats_hdr_answerclicks_hint'] . '">' . $lngstr['label_questionstats_hdr_answerclicks'] . '</td>';
$html.= '<td class=rowhdr1 title="' . $lngstr['label_questionstats_hdr_answerpercent_hint'] . '">' . $lngstr['label_questionstats_hdr_answerpercent'] . '</td>';
$html.= '<td class=rowhdr1 colspan=2>' . $lngstr['label_hdr_action'] . '</td></tr>';
$i_counter = 0;
$i_questions = isset($_POST['box_questions']) ? $func->readPostVar('box_questions') : array($func->readGetVar('questionid'));

foreach ($i_questions as $i_questionid)
   $html.= writeQuestionStats($func,$i_questionid,$srv_settings,$lngstr);
$html.= '</table>';
$html.= '</td></tr></table></form>';

$html.= $this->CI->load->view('events/tracnghiem/_footer.tpl.html', $this->_tpl_vars, true);
//die;
//displayTemplate('_footer');
$this->data['content_view'] = $html;
//$this->CI->template->write_view('content', 'game/eden/Events/LoanDauVoDai/logxephang', $this->data);
$this->CI->template->write_view('content', 'events/tracnghiem/views.tpl.html', $this->data);
?>
