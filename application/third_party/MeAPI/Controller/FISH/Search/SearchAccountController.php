<?php
class MeAPI_Controller_FISH_Search_SearchAccountController implements MeAPI_Controller_FISH_Search_SearchAccountInterface {
    protected $_response;
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');

        $this->CI->load->MeAPI_Model('Vicambo/VicamboModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        
        $session = $this->CI->Session->get_session('account');
    }
    public function accountwallet(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/fish/search/accountwallet',$this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_accountwallet(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $mobo_service_id = $_REQUEST['mobo_service_id'];
        if(empty($mobo_service_id)){
            $reponse = array(
                'error' => 1,
                'messg' => 'Vui lòng nhập Mobo Service ID'
            );
        }else{
            if(strlen($mobo_service_id)!=19){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Mobo Service ID không hợp lệ'
                );
            }else{
                $listItems = $this->CI->VicamboModel->accountWallet($_REQUEST);
                $this->data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html'=>$this->CI->load->view('game/fish/search/ajax_accountwallet', $this->data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    public function cashin(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/fish/search/cashin',$this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function ajax_cashin(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $mobo_service_id = $_REQUEST['mobo_service_id'];
        if(empty($mobo_service_id)){
            $reponse = array(
                'error' => 1,
                'messg' => 'Vui lòng nhập Mobo Service ID'
            );
        }else{
            if(strlen($mobo_service_id)!=19){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Mobo Service ID không hợp lệ'
                );
            }else{
                $listItems = $this->CI->VicamboModel->cashIn($_REQUEST);
                $this->data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html'=>$this->CI->load->view('game/fish/search/ajax_cashin', $this->data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    public function ajax_cashout(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $mobo_service_id = $_REQUEST['mobo_service_id'];
        if(empty($mobo_service_id)){
            $reponse = array(
                'error' => 1,
                'messg' => 'Vui lòng nhập Mobo Service ID'
            );
        }else{
            if(strlen($mobo_service_id)!=19){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Mobo Service ID không hợp lệ'
                );
            }else{
                $listItems = $this->CI->VicamboModel->cashOut($_REQUEST);
                $this->data['listItems'] = $listItems;
                $reponse = array(
                    'error' => 0,
                    'messg' => 'Thành công',
                    'html'=>$this->CI->load->view('game/fish/search/ajax_cashout', $this->data, true)
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    public function cashout(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->template->write_view('content', 'game/fish/search/cashout',$this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}

