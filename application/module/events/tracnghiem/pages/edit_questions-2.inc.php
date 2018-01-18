<?php
$html = '';
$g_vars['page']['location'] = array('/?control=mobo_event_tracnghiem&func=question_bank', '/?control=mobo_event_tracnghiem&func=question_bank', 'edit_question');
$i_answers_editor = IGT_USE_EDITOR_FOR_ANSWERS ? $G_SESSION['config_editortype'] : 0;
$i_feedback_editor = IGT_USE_EDITOR_FOR_FEEDBACK ? $G_SESSION['config_editortype'] : 0;
$i_editor_boxes = array('question_text');
$func->initTextEditor($G_SESSION['config_editortype'], $i_editor_boxes);
/*$g_smarty->assign('g_vars', $g_vars);
displayTemplate('_header');
*/
$this->_tpl_vars['g_vars'] = $g_vars;
$html.= $this->CI->load->view('events/tracnghiem/_header.tpl.html', $this->_tpl_vars, true);
$html.="<style>table.rowtable2 tr>td{width:100px}</style>";

$f_testid = (int)$func->readGetVar('testid');
$f_questionid = (int)$func->readGetVar('questionid');
$f_answercount = (int)$func->readGetVar('answercount');
$f_question_type = $func->readGetVar('question_type');
if ($f_testid) {
    $g_vars['page']['selected_section'] = 'testmanager';
    $g_vars['page']['selected_tab'] = 'editquestions-2';
} else {
    $g_vars['page']['selected_section'] = 'questionbank';
    $g_vars['page']['selected_tab'] = 'editquestions-2';
}
$g_vars['page']['menu_2_items'] = $func->getMenu2Items($g_vars['page']['selected_section'],$lngstr);
$html.= $func->writePanel2($g_vars,$g_vars['page']['menu_2_items']);
$html.= '<h2>' . $lngstr['page_header_edit_question'] . '</h2>';
$html.=$func->writeErrorsWarningsBar();
$i_rSet1 = $func->m_bd->Execute("SELECT * FROM " . $srv_settings['table_prefix'] . "questions WHERE questionid=" . $f_questionid);
if (!$i_rSet1) {
    showDBError(__FILE__, 1);
} else {
    foreach ($i_rSet1 as $key=>$value) {
        if (!is_numeric($f_question_type) || $f_question_type < 0 || $f_question_type > QUESTION_TYPE_COUNT)
            $f_question_type = $value['question_type'];
        $html.= '<p><form method=post action="/?control=mobo_event_tracnghiem&func=question_bank'.$func->getURLAddon().'" onsubmit="return submitForm();">';
        $html.= '<table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">';
        $i_rowno = 0;
        $html.=$func->writeTR2($lngstr['page_editquestion_type'], $func->getSelectElement('question_type', $f_question_type, $m_question_types, ' onchange="updateQuestion();"'));

        $f_subjectid = isset($_GET['subjectid']) ? (int)$func->readGetVar('subjectid') : $value['subjectid'];

        $i_subjects = array();
        $i_rSet2 = $func->m_bd->Execute("SELECT * FROM tbl_listevents WHERE typeevent=1");
        if (!$i_rSet2) {
            showDBError(__FILE__, 2);
        } else {
            foreach ($i_rSet2 as $key1=>$value1) {
                $i_subjects[$value1['id']] = $value1['name'];
                //$i_rSet2->MoveNext();
            }
            //$i_rSet2->Close();
        }
        $html.=$func->writeTR2($lngstr['page_editquestion_subjectid'], $func->getSelectElement('subjectid', $f_subjectid, $i_subjects));
        $i = 0;
        $i_rSet3 = $func->m_bd->Execute("SELECT * FROM " . $srv_settings['table_prefix'] . "answers WHERE questionid=$f_questionid ORDER BY answerid");
        if (!$i_rSet1) {
            showDBError(__FILE__, 3);
        } else {
            $i_answercount = (int)count($i_rSet3);
            $i_answercount_nonempty = 0;
            if ($f_answercount > 0)
                $i_answercount_nonempty = min($i_answercount, $f_answercount);
            else $i_answercount_nonempty = $i_answercount;
            switch ($f_question_type) {
                case QUESTION_TYPE_MULTIPLECHOICE:
                case QUESTION_TYPE_MULTIPLEANSWER:
                    if ($f_answercount <= 0 && $i_answercount > 0)
                        $f_answercount = $i_answercount;
                    $m_answercount_items = array(0 => '');
                    for ($i = 2; $i <= MAX_ANSWER_COUNT; $i++)
                        $m_answercount_items[$i] = $i;
                $html.= $func->writeTR2($lngstr['page_editquestion_answer_count'], $func->getSelectElement('answercount', $f_answercount, $m_answercount_items, ' onchange="updateQuestion();"'));
                    if ($f_answercount <= 0 && $i_answercount <= 0)
                        $f_answercount = DEFAULT_ANSWER_COUNT;
                $html.= $func->writeTR2($lngstr['page_editquestion_question_text'], $func->getTextEditor($G_SESSION['config_editortype'], 'question_text', !empty($value['question_text']) ? $value['question_text'] : $lngstr['page_editquestion_emptyquestion']));
                    $i = 1;
                    foreach ($i_rSet3 as $key2=>$value2){
                        if($i <= $i_answercount_nonempty) {
                            $html.= $func->writeTR2(sprintf($lngstr['label_choice_no'], $i), '<table cellpadding=0 cellspacing=1 border=0 width="100%"><tr vAlign=top>
                                <td width="100%">' . $func->getTextEditor($i_answers_editor, 'answer_text[' . $i . ']', $value2['answer_text'], 3) . '</td>
                                <td vAlign=middle width=150><nobr>' . $func->getCheckbox('answer_correct[' . $i . ']', $value2['answer_correct'], $lngstr['label_accept_as_correct'], ' onclick="changeChoicePercents(this, ' . $i . ')"') . '</nobr><br>
                                <nobr>' . $func->getInputElement('answer_percents[' . $i . ']', $value2['answer_percents'], 3) . ' ' . $lngstr['label_answer_percents'] . '</nobr></td></tr></table>');
                            $i_rowno++;
                            $html.= $func->writeTR2(sprintf($lngstr['label_answer_feedback_no'], $i), $func->getTextEditor($i_feedback_editor, 'answer_feedback_' . $i, $value2['answer_feedback'], 3));
                            //$i_rSet3->MoveNext();
                            $i++;
                        }
                    }
                    for ($i = $i_answercount_nonempty + 1; $i <= $f_answercount; $i++) {
                       $html.=  $func->writeTR2(sprintf($lngstr['label_choice_no'], $i), '<table cellpadding=0 cellspacing=1 border=0 width="100%"><tr vAlign=top>
                        <td width="100%">' . $func->getTextEditor($i_answers_editor, 'answer_text[' . $i . ']', '', 3) . '</td>
                        <td vAlign=middle width=150><nobr>' . $func->getCheckbox('answer_correct[' . $i . ']', 0, $lngstr['label_accept_as_correct'], ' onclick="changeChoicePercents(this, ' . $i . ')"') . '</nobr><br>
                        <nobr>' . $func->getInputElement('answer_percents[' . $i . ']', '0', 3) . ' ' . $lngstr['label_answer_percents'] . '</nobr></td></tr></table>');
                        $i_rowno++;
                       $html.=  $func->writeTR2(sprintf($lngstr['label_answer_feedback_no'], $i), $func->getTextEditor($i_feedback_editor, 'answer_feedback_' . $i, '', 3));
                    }
               $html.=  $func->writeTR2($lngstr['page_editquestion']['shuffle_answers'], $func->getSelectElement('question_shufflea', $value['question_shufflea'], $lngstr['page_editquestion']['shuffle_answers_items']));
                    if ($f_question_type == QUESTION_TYPE_MULTIPLEANSWER)
                        $html.= $func->writeTR2($lngstr['page_editquestion']['advanced_settings'], $func->getCheckbox('question_type2', $value['question_type2'], $lngstr['page_editquestion']['allow_partial_answers']));
                    break;
                case QUESTION_TYPE_TRUEFALSE:
                   $html.= $func->writeTR2($lngstr['page_editquestion_answer_count'], '2');
                   $html.=   $func->writeTR2($lngstr['page_editquestion_question_text'], $func->getTextEditor($G_SESSION['config_editortype'], 'question_text', !empty($value['question_text']) ? $value['question_text'] : $lngstr['page_editquestion_emptyquestion']));
                    $i = 1;
                    $i_answer_text = $lngstr['label_atype_truefalse_true'];
                    $i_answer_feedback = '';
                    $i_answer_correct = false;
                    $i_answer_percents = 0;
					if($i_rSet3){
						foreach ($i_rSet3 as $key2=>$value2){
							$i_answer_text = $value2['answer_text'];
							$i_answer_feedback = $value2['answer_feedback'];
							$i_answer_correct = $value2['answer_correct'];
							$i_answer_percents = $value2['answer_percents'];
							//$i_rSet3->MoveNext();
						
							$html.= $func->writeTR2(sprintf($lngstr['label_choice_no'], $i), '<table cellpadding=0 cellspacing=1 border=0 width="100%">
							<tr vAlign=top><td width="100%">' . $func->getTextEditor($i_answers_editor, 'answer_text[' . $i . ']', $i_answer_text, 3) . '
							</td><td vAlign=middle width=150><nobr>' . $func->getCheckbox('answer_correct[' . $i . ']', $i_answer_correct, $lngstr['label_accept_as_correct'], ' onclick="changeChoicePercents(this, ' . $i . ')"') . '</nobr><br>
							<nobr>' . $func->getInputElement('answer_percents[' . $i . ']', $i_answer_percents, 3) . ' ' . $lngstr['label_answer_percents'] . '</nobr>
							</td></tr></table>');
							$i_rowno++;
							$i++;
						   $html.= $func->writeTR2(sprintf($lngstr['label_answer_feedback_no'], $i), $func->getTextEditor($i_feedback_editor, 'answer_feedback_' . $i, $i_answer_feedback, 3));
						}
					}else{
							$i_answer_text = $lngstr['label_atype_truefalse_true'];
							$html.= $func->writeTR2(sprintf($lngstr['label_choice_no'], $i), '<table cellpadding=0 cellspacing=1 border=0 width="100%">
							<tr vAlign=top><td width="100%">' . $func->getTextEditor($i_answers_editor, 'answer_text[' . $i . ']', $i_answer_text, 3) . '
							</td><td vAlign=middle width=150><nobr>' . $func->getCheckbox('answer_correct[' . $i . ']', $i_answer_correct, $lngstr['label_accept_as_correct'], ' onclick="changeChoicePercents(this, ' . $i . ')"') . '</nobr><br>
							<nobr>' . $func->getInputElement('answer_percents[' . $i . ']', $i_answer_percents, 3) . ' ' . $lngstr['label_answer_percents'] . '</nobr>
							</td></tr></table>');
							
						   $html.= $func->writeTR2(sprintf($lngstr['label_answer_feedback_no'], $i), $func->getTextEditor($i_feedback_editor, 'answer_feedback_' . $i, $i_answer_feedback, 3));		
							$i=2;
							$i_answer_text = $lngstr['label_atype_truefalse_false'];
							$html.= $func->writeTR2(sprintf($lngstr['label_choice_no'], $i), '<table cellpadding=0 cellspacing=1 border=0 width="100%">
							<tr vAlign=top><td width="100%">' . $func->getTextEditor($i_answers_editor, 'answer_text[' . $i . ']', $i_answer_text, 3) . '
							</td><td vAlign=middle width=150><nobr>' . $func->getCheckbox('answer_correct[' . $i . ']', $i_answer_correct, $lngstr['label_accept_as_correct'], ' onclick="changeChoicePercents(this, ' . $i . ')"') . '</nobr><br>
							<nobr>' . $func->getInputElement('answer_percents[' . $i . ']', $i_answer_percents, 3) . ' ' . $lngstr['label_answer_percents'] . '</nobr>
							</td></tr></table>');
							
						   
						   $html.= $func->writeTR2(sprintf($lngstr['label_answer_feedback_no'], $i), $func->getTextEditor($i_feedback_editor, 'answer_feedback_' . $i, $i_answer_feedback, 3));		
					}
                    break;
                case QUESTION_TYPE_FILLINTHEBLANK:
                  $html.=  $func->writeTR2($lngstr['page_editquestion_answer_count'], '1');
                  $html.=   $func->writeTR2($lngstr['page_editquestion_question_text'], $func->getTextEditor($G_SESSION['config_editortype'], 'question_text', !empty($value['question_text']) ? $value['question_text'] : $lngstr['page_editquestion_emptyquestion']));
                    $i = 1;
                    $i_answer_text = '';
                    foreach ($i_rSet3 as $key2=>$value2) {
                        $i_answer_text = $value2['answer_text'];
                    }
                 $html.=   $func->writeTR2(sprintf($lngstr['label_answer_text'], $i), $func->getTextEditor(0, 'answer_text[' . $i . ']', $i_answer_text, 3));
                    break;
                case QUESTION_TYPE_ESSAY:
                  $html.=  $func->writeTR2($lngstr['page_editquestion_answer_count'], $lngstr['label_notapplicable']);
                  $html.=  $func->writeTR2($lngstr['page_editquestion_question_text'], $func->getTextEditor($G_SESSION['config_editortype'], 'question_text', !empty($value['question_text']) ? $value['question_text'] : $lngstr['page_editquestion_emptyquestion']));
                    break;
                case QUESTION_TYPE_RANDOM:
                   $html.= $func->writeTR2($lngstr['page_editquestion_question_name'], $func->getInputElement('question_text', !empty($value['question_text']) ? $value['question_text'] : $lngstr['label_atype_random'] . ' (' . $i_subjects[$f_subjectid] . ')'));
                    break;
            }
            //$i_rSet3->Close();
        }
        if ($f_question_type <> QUESTION_TYPE_RANDOM) {
           $html.= $func->writeTR2($lngstr['page_editquestion_points'], $func->getInputElement('question_points', $value['question_points'], 3));
        }
        $html.= '</table>';
        $html.= '<p class=center><input class=btn type=submit name=bsubmit value=" ' . $lngstr['button_update'] . ' "> <input class=btn type=submit name=bsubmit2 value=" ' . $lngstr['button_update_and_create_new_question'] . ' "> <input class=btn type=submit name=bcancel value=" ' . $lngstr['button_cancel'] . ' "></form>';
        $html.= '<script language=JavaScript type="text/javascript">
function updateQuestion() {
ctlQuestionType = document.getElementById("question_type");
nQuestionType = ctlQuestionType ? document.getElementById("question_type").options[document.getElementById("question_type").selectedIndex].value : "";
ctlSubjectID = document.getElementById("subjectid");
nSubjectID = ctlSubjectID ? ctlSubjectID.options[ctlSubjectID.selectedIndex].value : "";
ctlAnswerCount = document.getElementById("answercount");
nAnswerCount = ctlAnswerCount ? ctlAnswerCount.options[ctlAnswerCount.selectedIndex].value : "";
window.open("/?control=mobo_event_tracnghiem&func=question_bank' . $func->getURLAddon('', array('question_type', 'subjectid', 'answercount')) . '&question_type="+nQuestionType+"&subjectid="+nSubjectID+"&answercount="+nAnswerCount,"_top");
}
</script>';
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
