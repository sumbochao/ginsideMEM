<?php

class MeAPI_Controller_WelcomeController implements MeAPI_Controller_WelcomeInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
    }

    /*
     * Get Data Group
     */
	public function test(){
        $this->CI->load->MeAPI_Model('Test/TestModel');
        $listItem = $this->CI->TestModel->listItems();
        echo "<pre>";print_r($listItem);die();
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->CI->load->MeAPI_Model('MenuModel');
        /*
        if (!empty($menus)) {
            $result = array();
            foreach ($menus as $m) {
                $result[$m['groupp']][] = $m;
            }

        }
                
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        * 
        */
        $this->authorize->validateAuthorizeRequest($request, 0);
         
        $this->CI->template->write_view('content', 'welcome_message', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }

    /*
     * Cron Group
     */

    public function getResponse() {
        return $this->_response;
    }

}