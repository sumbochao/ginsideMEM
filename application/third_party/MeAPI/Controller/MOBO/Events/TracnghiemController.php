<?php
class MeAPI_Controller_MOBO_Events_TracnghiemController implements MeAPI_Controller_MOBO_Events_TracnghiemInterface
{
    /* @var $cache_user CI_Cache */
    /* @var $cache CI_Cache */
    protected $_response;
    private $CI;

    private $api_m_app = "http://m-app.mobo.vn/responsetool/";
    private $url_process = "http://service.eden.mobo.vn/cms/promotion_lato/";

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');

        //$this->CI->load->MeAPI_Model('ReportModel');
        //$this->CI->load->MeAPI_Model('PaymentModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();

        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
    }

    //Load Template
    public function index(MeAPI_RequestInterface $request)
    {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/eden/Events/LatO/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    /*****QUESTION_BANK*****/
    public function question_bank(MeAPI_RequestInterface $request)
    {
        require_once APPPATH . 'module/events/tracnghiem/init.inc.php';

        $this->authorize->validateAuthorizeRequest($request, 0);

        switch($_GET['action']) {
            case 'createq':
                    include_once($DOCUMENT_PAGES."edit_questions-7.inc.php");
                /*} else {
                    if(isset($_GET['testid']))
                        gotoLocation('test-manager.php'.getURLAddon('?action=editt', array('action')));
                    else gotoLocation('question-bank.php'.getURLAddon('', array('action')));
                }*/
                break;
            case 'deleteq':
                    $f_confirmed = $func->readGetVar('confirmed');

                    if($f_confirmed==1) {
                        if(isset($_GET['questionid']) || isset($_POST["box_questions"])) {

                            include_once($DOCUMENT_PAGES."edit_questions-6.inc.php");
                        } else {
                            $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=question_bank&'.$func->getURLAddon('', array('action', 'confirmed', 'questionid')));
                        }
                    } else if($f_confirmed=='0') {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=question_bank&'.$func->getURLAddon('', array('action', 'questionid')));
                    } else {

                        $i_confirm_header = $lngstr['page_edittests_delete_question'];
                        $i_confirm_request = $lngstr['qst_delete_question'];
                        $i_confirm_url = '/?control=mobo_event_tracnghiem&module=all&func=question_bank&'.$func->getURLAddon();
                        include_once($DOCUMENT_PAGES."confirm.inc.php");
                    }
                /*} else {
                    if(isset($_GET['testid']))
                        gotoLocation('test-manager.php'.getURLAddon('?action=editt', array('action', 'questionid', 'confirmed')));
                    else gotoLocation('question-bank.php'.getURLAddon('', array('action', 'questionid', 'confirmed')));
                }*/
                break;
            case 'editq':
                $g_vars['page']['title'] = $lngstr['page_title_edit_question'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['questionid'])) {
                    if(isset($_POST['bsubmit']) || isset($_POST['bsubmit2'])) {
                        //if($G_SESSION['access_questionbank'] > 1) {
							include_once($DOCUMENT_PAGES."edit_questions-3.inc.php");
                        /*} else {
                            if(isset($_GET['testid']))
                                $func->gotoLocation('/?control=mobo_event_tracnghiem&func=test_manager&'.$func->getURLAddon('?action=editt', array('action', 'questionid')));
                            else $func->gotoLocation('question-bank.php'.getURLAddon('', array('action')));
                        }*/
                    } else if(isset($_POST['bcancel'])) {
                        if(isset($_GET['testid']))
                            $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager&'.$func->getURLAddon('?action=editt', array('action', 'questionid')));
                        else $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=question_bank&'.$func->getURLAddon('', array('action')));
                    } else {
                        include_once($DOCUMENT_PAGES."edit_questions-2.inc.php");
                    }
                }
                break;
            case 'statsq':
                $g_vars['page']['title'] = $lngstr['page_title_question_stats'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['questionid']) || isset($_POST["box_questions"])) {
					include_once($DOCUMENT_PAGES."question-bank-2.inc.php");
                } else {
                    $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=question_bank');
                }
                break;
            default:

              include_once($DOCUMENT_PAGES."question-bank-1.inc.php");
			  
        }
		
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    /********SUBJECTS****************/
    public function subjects(MeAPI_RequestInterface $request)
    {
        require_once APPPATH . 'module/events/tracnghiem/init.inc.php';
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['action']) {
            case 'create':
                    include_once($DOCUMENT_PAGES . "subjects-4.inc.php");
                /*} else {
                    $func->gotoLocation('subjects.php' . getURLAddon('', array('action')));
                }*/
                break;
            case 'delete':
                //if ($G_SESSION['access_subjects'] > 1) {
                    $f_confirmed = $func->readGetVar('confirmed');

                    if ($f_confirmed == 1) {
                        if (isset($_GET['subjectid']) || isset($_POST["box_subjects"])) {

                            include_once($DOCUMENT_PAGES . "subjects-5.inc.php");
                        } else {
                            $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=subjects');
                        }
                    } else if ($f_confirmed == '0') {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=subjects');
                    } else {

                        $i_confirm_header = $lngstr['page_subjects_delete_subject'];
                        $i_confirm_request = $lngstr['qst_delete_subject'];
                        $i_confirm_url = '/?control=mobo_event_tracnghiem&module=all&func=subjects&subjectid=' . (int)$_GET['subjectid'] . '&action=delete';
                        include_once($DOCUMENT_PAGES . "confirm.inc.php");
                    }
                /*} else {
                    gotoLocation('subjects.php' . getURLAddon('', array('action', 'confirmed')));
                }*/
                break;
            case 'edit':
                $g_vars['page']['title'] = $lngstr['page_title_subjects_settings'] . $lngstr['item_separator'] . $g_vars['page']['title'];
                if (isset($_GET['subjectid'])) {
                    if (isset($_POST['bsubmit'])) {
                        //if ($G_SESSION['access_subjects'] > 1) {
                            include_once($DOCUMENT_PAGES . "subjects-3.inc.php");
                        /*} else {
                            gotoLocation('subjects.php' . getURLAddon('', array('action')));
                        }*/
                    } else if (isset($_POST['bcancel'])) {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=subjects');
                    } else {
                        include_once($DOCUMENT_PAGES . "subjects-2.inc.php");
                    }
                }
                break;
            default:
                include_once($DOCUMENT_PAGES . "subjects-1.inc.php");
        }
		$this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    /********TEST MANAGER ****************/
    public function test_manager(MeAPI_RequestInterface $request)
    {
        require_once APPPATH . 'module/events/tracnghiem/init.inc.php';

        $this->authorize->validateAuthorizeRequest($request, 0);

        switch($_GET['action']) {

            case 'create':
                //if($G_SESSION['access_testmanager'] > 1) {

                    include_once($DOCUMENT_PAGES.'test-manager-4.inc.php');
               /* } else {
                    gotoLocation('test-manager.php'.getURLAddon('', array('action')));
                }
               */
                break;
            case 'delete':
                //if($G_SESSION['access_testmanager'] > 1) {
                    $f_confirmed = $func->readGetVar('confirmed');

                    if($f_confirmed==1) {
                        if(isset($_GET['testid']) || isset($_POST['box_tests'])) {

                            include_once($DOCUMENT_PAGES.'test-manager-5.inc.php');
                        } else {
                            $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager');
                        }
                    } else if($f_confirmed=='0') {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager');
                    } else {

                        $i_confirm_header = $lngstr['page_edittests_delete_test'];
                        $i_confirm_request = $lngstr['qst_delete_test'];
                        $i_confirm_url = '/?control=mobo_event_tracnghiem&module=all&func=test_manager&testid='.(int)$_GET['testid'].'&action=delete';
                        include_once($DOCUMENT_PAGES.'confirm.inc.php');
                    }
                /*} else {
                    gotoLocation('test-manager.php'.getURLAddon('', array('action', 'testid', 'confirmed')));
                }*/
                break;
            case 'enable':
                //if($G_SESSION['access_testmanager'] > 1) {
                    if(isset($_GET['testid'])) {
                        include_once($DOCUMENT_PAGES.'test-manager-6.inc.php');
                    }
                /*} else {
                    gotoLocation('test-manager.php'.getURLAddon('', array('action', 'testid', 'confirmed', 'set')));
                }*/
                break;
            case 'notes':
                if(isset($_GET['testid'])) {
                    include_once($DOCUMENT_PAGES.'test-manager-7.inc.php');
                }
                break;
            case 'editt':
                $g_vars['page']['title'] = $lngstr['page_title_test_questions'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['testid'])) {
                    include_once($DOCUMENT_PAGES.'edit_questions-1.inc.php');
                }
                break;
            case 'edits':
                $g_vars['page']['title'] = $lngstr['page_title_test_sections'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['testid'])) {
                    include_once($DOCUMENT_PAGES.'test-manager-sections-1.inc.php');
                }
                break;
            case 'settings':
                $g_vars['page']['title'] = $lngstr['page_title_test_settings'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['testid'])) {
                    if(isset($_POST['bsubmit']) || isset($_POST['bsubmit2'])) {
                        //if($G_SESSION['access_testmanager'] > 1) {
                            include_once($DOCUMENT_PAGES.'test-manager-3.inc.php');
                        /*} else {
                            if(isset($_POST['bsubmit2']))
                                gotoLocation('test-manager.php'.getURLAddon('?action=editt', array('action')));
                            else gotoLocation('test-manager.php'.getURLAddon('', array('action', 'testid')));
                        }*/
                    } else if(isset($_POST['bcancel'])) {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager');
                    } else {
                        include_once($DOCUMENT_PAGES.'test-manager-2.inc.php');
                    }
                }
                break;
            case 'groups':
                $g_vars['page']['title'] = $lngstr['page_title_test_assignto'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['testid']) || isset($_POST['box_tests']) || isset($_GET['testids'])) {
                    include_once($DOCUMENT_PAGES.'test-manager-8.inc.php');
                } else {
                    $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager');
                }
                break;
            case 'assignto':
                //if($G_SESSION['access_testmanager'] > 1) {
                    if(isset($_GET['groupid']) && isset($_GET['testids'])) {
                        include_once($DOCUMENT_PAGES.'test-manager-9.inc.php');
                    } else {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager&'.$func->getURLAddon('action=groups', array('action', 'groupid')));
                    }
                /*} else {
                    gotoLocation('test-manager.php'.getURLAddon('?action=groups', array('action', 'groupid', 'set')));
                }*/
                break;
            case 'statst':
                $g_vars['page']['title'] = $lngstr['page_testmanager_stats']['title'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['testids']) || isset($_POST['box_tests'])) {
                    include_once($DOCUMENT_PAGES.'test-manager-stats.inc.php');
                } else {
                    gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager&'.$func->getURLAddon('', array('action', 'testid')));
                }
                break;
            case 'import':
                if(isset($_GET['testid'])) {
                    if(isset($_POST['bsubmit'])) {
                        //if(($G_SESSION['access_testmanager'] > 1) && ($G_SESSION['access_questionbank'] > 1)) {
                            include_once($DOCUMENT_PAGES.'test-manager-11.inc.php');
                        /*} else {
                            gotoLocation('test-manager.php'.getURLAddon('?action=editt', array('action')));
                        }*/
                    } else if(isset($_POST['bcancel'])) {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager&'.$func->getURLAddon('action=editt', array('action')));
                    } else {
                        include_once($DOCUMENT_PAGES.'test-manager-10.inc.php');
                    }
                }
                break;

            case 'moveup':
                //if($G_SESSION['access_testmanager'] > 1) {
                    if(isset($_GET['testid']) && isset($_GET['test_questionid']))
                        include_once($DOCUMENT_PAGES.'edit_questions-8.inc.php');
                /*} else {
                    gotoLocation('test-manager.php'.getURLAddon('?action=editt', array('action')));
                }*/
                break;
            case 'movedown':
                //if($G_SESSION['access_testmanager'] > 1) {
                    if(isset($_GET['testid']) && isset($_GET['test_questionid']))
                        include_once($DOCUMENT_PAGES.'edit_questions-9.inc.php');
                /*} else {
                    gotoLocation('test-manager.php'.getURLAddon('?action=editt', array('action')));
                }*/
                break;

            case 'append':
                //if($G_SESSION['access_testmanager'] > 1) {
                    if(isset($_GET['testid']) && (isset($_GET['questionid']) || isset($_POST['box_questions']))) {
                        include_once($DOCUMENT_PAGES.'edit_questions-4.inc.php');
                    } else {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager&'.$func->getURLAddon('action=editt', array('action')));
                    }
                /*} else {
                    gotoLocation('test-manager.php'.getURLAddon('?action=editt', array('action')));
                }*/
                break;
            case 'deleteq':
                //if($G_SESSION['access_testmanager'] > 1) {
                    $f_confirmed = $func->readGetVar('confirmed');

                    if($f_confirmed==1) {
                        if(isset($_GET['testid']) && (isset($_GET['test_questionid']) || isset($_POST['box_qlinks']))) {
                            include_once($DOCUMENT_PAGES.'edit_questions-5.inc.php');
                        } else {
                            $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager&'.$func->getURLAddon('', array('action', 'confirmed', 'test_questionid')));
                        }
                    } else if($f_confirmed=='0') {
                        $func->gotoLocation('/?control=mobo_event_tracnghiem&module=all&func=test_manager'.$func->getURLAddon('action=editt', array('action', 'test_questionid')));
                    } else {
                        $i_confirm_header = $lngstr['page_edittests_delete_question_link'];
                        $i_confirm_request = $lngstr['qst_delete_question_link'];
                        $i_confirm_url = '/?control=mobo_event_tracnghiem&module=all&func=test_manager&'.$func->getURLAddon('');
                        include_once($DOCUMENT_PAGES.'confirm.inc.php');
                    }
                /*} else {
                    gotoLocation('test-manager.php'.getURLAddon('?action=editt', array('action', 'confirmed')));
                }*/
                break;
            default:
                include_once($DOCUMENT_PAGES.'test-manager-1.inc.php');
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function grades(MeAPI_RequestInterface $request){
        require_once APPPATH . 'module/events/tracnghiem/init.inc.php';

        switch($_GET['action']) {
            case 'create':
                //if($G_SESSION['access_gradingsystems'] > 1) {

                    include_once($DOCUMENT_PAGES.'grades-4.inc.php');
                /*} else {
                    gotoLocation('grades.php');
                }*/
                break;
            case 'delete':
                //if($G_SESSION['access_gradingsystems'] > 1) {
                    $f_confirmed = $func->readGetVar('confirmed');

                    if($f_confirmed==1) {
                        if(isset($_GET['gscaleid']) || isset($_POST['box_grades'])) {

                            include_once($DOCUMENT_PAGES.'grades-5.inc.php');
                        } else {
                            $func->gotoLocation('grades.php');
                        }
                    } else if($f_confirmed=='0') {
                        $func->gotoLocation('grades.php');
                    } else {

                        $i_confirm_header = $lngstr['page_grades_delete_grade'];
                        $i_confirm_request = $lngstr['qst_delete_grade'];
                        $i_confirm_url = 'grades.php'.$func->getURLAddon();
                        include_once($DOCUMENT_PAGES.'confirm.inc.php');
                    }
                /*} else {
                    gotoLocation('grades.php');
                }*/
                break;
            case 'settings':
                $g_vars['page']['title'] = $lngstr['page_title_grades_edit'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['gscaleid'])) {
                    if(isset($_POST['bsubmit'])) {
                        //if($G_SESSION['access_gradingsystems'] > 1) {
                            include_once($DOCUMENT_PAGES.'grades-3.inc.php');
                        /*} else {
                            gotoLocation('grades.php');
                        }*/
                    } else if(isset($_POST['bcancel'])) {
                        $func->gotoLocation('grades.php');
                    } else {
                        include_once($DOCUMENT_PAGES.'grades-2.inc.php');
                    }
                }
                break;
            case 'edit':
                $g_vars['page']['title'] = $lngstr['page_title_gradescales'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['gscaleid'])) {
                    include_once($DOCUMENT_PAGES.'grades-6.inc.php');
                }
                break;
            case 'creates':
                //if($G_SESSION['access_gradingsystems'] > 1) {

                    include_once($DOCUMENT_PAGES.'grades-9.inc.php');
                /*} else {
                    gotoLocation('grades.php?action=edit&gscaleid='.(int)$_GET['gscaleid']);
                }*/
                break;
            case 'deletes':
                //if($G_SESSION['access_gradingsystems'] > 1) {
                    $f_confirmed = $func->readGetVar('confirmed');

                    if($f_confirmed==1) {
                        if(isset($_GET['gscale_gradeid']) || isset($_POST['box_gradescales'])) {

                            include_once($DOCUMENT_PAGES.'grades-10.inc.php');
                        } else {
                            $func->gotoLocation('grades.php'.$func->getURLAddon('action=edit', array('action')));
                        }
                    } else if($f_confirmed=='0') {
                        $func->gotoLocation('grades.php'.$func->getURLAddon('action=edit', array('action')));
                    } else {

                        $i_confirm_header = $lngstr['page_gradescales_delete_grade'];
                        $i_confirm_request = $lngstr['qst_delete_gradescale'];
                        $i_confirm_url = 'grades.php'.$func->getURLAddon();
                        include_once($DOCUMENT_PAGES.'confirm.inc.php');
                    }
                /*} else {
                    gotoLocation('grades.php'.getURLAddon('?action=edit', array('action', 'confirmed')));
                }*/
                break;
            case 'moveup':
                //if($G_SESSION['access_gradingsystems'] > 1) {
                    if(isset($_GET['gscaleid']) && isset($_GET['gscale_gradeid']))
                        include_once($DOCUMENT_PAGES.'grades-11.inc.php');
                /*} else {
                    gotoLocation('grades.php'.getURLAddon('?action=edit', array('action')));
                }*/
                break;
            case 'movedown':
                //if($G_SESSION['access_gradingsystems'] > 1) {
                    if(isset($_GET['gscaleid']) && isset($_GET['gscale_gradeid']))
                        include_once($DOCUMENT_PAGES.'grades-12.inc.php');
                /*} else {
                    gotoLocation('grades.php'.getURLAddon('?action=edit', array('action')));
                }*/
                break;
            case 'edits':
                $g_vars['page']['title'] = $lngstr['page_title_grade_settings'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['gscaleid']) && isset($_GET['gscale_gradeid'])) {
                    if(isset($_POST['bsubmit'])) {
                        //if($G_SESSION['access_gradingsystems'] > 1) {
                            include_once($DOCUMENT_PAGES.'grades-8.inc.php');
                        /*} else {
                            gotoLocation('grades.php'.getURLAddon('?action=edit', array('action')));
                        }*/
                    } else if(isset($_POST['bcancel'])) {
                        $func->gotoLocation('grades.php'.$func->getURLAddon('?action=edit', array('action')));
                    } else {
                        include_once($DOCUMENT_PAGES.'grades-7.inc.php');
                    }
                }
                break;
            default:
                include_once($DOCUMENT_PAGES.'grades-1.inc.php');
                break;
        }
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    public function reports_manager(MeAPI_RequestInterface $request){
        /*
        switch(readGetVar('action')) {
            case 'viewq':
                $g_vars['page']['title'] = $lngstr['page_title_results_questions'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['resultid'])) {
                    include_once($DOCUMENT_PAGES.'reports-manager-2.inc.php');
                }
                break;
            case 'viewa':
                $g_vars['page']['title'] = $lngstr['page_title_results_answers'].$lngstr['item_separator'].$g_vars['page']['title'];
                if(isset($_GET['resultid']) && isset($_GET['answerid'])) {
                    include_once($DOCUMENT_PAGES.'reports-manager-3.inc.php');
                }
                break;
            case 'delete':
                if($G_SESSION['access_reportsmanager'] > 2) {

                    $f_confirmed = readGetVar('confirmed');
                    if($f_confirmed==1) {
                        if(isset($_GET['resultid']) || isset($_POST['box_results'])) {

                            include_once($DOCUMENT_PAGES.'reports-manager-4.inc.php');
                        } else {
                            gotoLocation('reports-manager.php');
                        }
                    } else if($f_confirmed=='0') {
                        gotoLocation('reports-manager.php');
                    } else {

                        $i_confirm_header = $lngstr['page_results_delete_record'];
                        $i_confirm_request = $lngstr['qst_delete_record'];
                        $i_confirm_url = 'reports-manager.php'.getURLAddon();
                        include_once($DOCUMENT_PAGES.'confirm.inc.php');
                    }
                } else {
                    gotoLocation('reports-manager.php'.getURLAddon('', array('action', 'resultid')));
                }
                break;
            case 'setpoints':
                if($G_SESSION['access_reportsmanager'] > 2) {
                    if(isset($_GET['resultid']) && isset($_GET['answerid'])) {
                        include_once($DOCUMENT_PAGES.'reports-manager-5.inc.php');
                    }
                } else {
                    gotoLocation('reports-manager.php'.getURLAddon('?action=viewa', array('action', 'resultid', 'answerid', 'set')));
                }
                break;
            case 'attempts':
                if($G_SESSION['access_reportsmanager'] > 2) {
                    if(isset($_GET['testid']) && isset($_GET['userid'])) {
                        include_once($DOCUMENT_PAGES.'reports-manager-6.inc.php');
                    }
                } else {
                    gotoLocation('reports-manager.php'.getURLAddon('?action=', array('action', 'testid', 'userid', 'set')));
                }
                break;
            case 'filter':
                if(!empty($_POST['bsetfilter'])) {
                    setCookieVar('filter_reportsmanager_result_date', readPostVar('result_date', readGetVar('result_date')));
                    $f_result_datestart = readPostVar('result_datestart', readGetVar('result_datestart'));
                    if(!empty($f_result_datestart))
                        $f_result_datestart = strtotime($f_result_datestart);
                    setCookieVar('filter_reportsmanager_result_datestart', $f_result_datestart);
                    $f_result_dateend = readPostVar('result_dateend', readGetVar('result_dateend'));
                    if(!empty($f_result_dateend))
                        $f_result_dateend = strtotime($f_result_dateend);
                    setCookieVar('filter_reportsmanager_result_dateend', $f_result_dateend);
                    setCookieVar('filter_reportsmanager_userid', readPostVar('userid', readGetVar('userid')));
                    setCookieVar('filter_reportsmanager_testid', readPostVar('testid', readGetVar('testid')));
                    setCookieVar('filter_reportsmanager_user_lastname', readPostVar('user_lastname', readGetVar('user_lastname')));
                    setCookieVar('filter_reportsmanager_user_department', readPostVar('user_department', readGetVar('user_department')));
                    setCookieVar('filter_reportsmanager_subjectid', readPostVar('subjectid', readGetVar('subjectid')));
                    gotoLocation('reports-manager.php'.getURLAddon('?action=', array('action')));
                } else {
                    setCookieVar('filter_reportsmanager_result_date', 0);
                    setCookieVar('filter_reportsmanager_result_datestart', 0);
                    setCookieVar('filter_reportsmanager_result_dateend', 0);
                    setCookieVar('filter_reportsmanager_userid', '');
                    setCookieVar('filter_reportsmanager_testid', '');
                    setCookieVar('filter_reportsmanager_user_lastname', '');
                    setCookieVar('filter_reportsmanager_user_department', '');
                    setCookieVar('filter_reportsmanager_subjectid', '');
                    gotoLocation('reports-manager.php'.getURLAddon('?action=', array('action', 'userid', 'user_lastname', 'user_department', 'testid')));
                }
                break;
            case 'exportcsv':
                if($G_SESSION['access_reportsmanager'] > 1) {
                    include_once($DOCUMENT_PAGES.'reports-manager-exportcsv.inc.php');
                } else {
                    gotoLocation('reports-manager.php'.getURLAddon('?action=', array('action')));
                }
                break;
            case 'preview':
            case 'print':
                include_once($DOCUMENT_PAGES.'reports-manager-report-1.inc.php');
                break;
            default:
                include_once($DOCUMENT_PAGES.'reports-manager-1.inc.php');
        }
        */
    }
    public function getResponse()
    {
        return $this->_response;
    }

    public function curlPost($params, $link = '')
    {
        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        if ($result) {
            $result = json_decode($result, true);
            if ($result['code'] == 0) {
                $result = $result['data'];
            }
        }
        return $result;
    }

    public function curlPostAPI($params, $link = '')
    {
        //http://sl.hw.mobo.vn/dc/auth/request/sky/mobo/role.html
        $this->last_link_request = empty($link) ? $this->api_m_app . "returnpathimg" : $link;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->last_link_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        return $result;
    }

    private function call_api_get($api_url)
    {
        set_time_limit(30);
        $urlrequest = $api_url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlrequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $result = curl_exec($ch);
        $err_msg = "";

        if ($result === false)
            $err_msg = curl_error($ch);

        //var_dump($result);
        //die;
        curl_close($ch);
        return $result;
    }
}
