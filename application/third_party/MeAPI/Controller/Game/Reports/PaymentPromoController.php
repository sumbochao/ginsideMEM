<?php
class MeAPI_Controller_Game_Reports_PaymentPromoController implements MeAPI_Controller_Game_Reports_PaymentPromoInterface {
    protected $_response;
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');

        $this->CI->load->MeAPI_Model('Game/PaymentPromoModel');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->filter();
        $arrGame = explode('-',$this->CI->Session->get_session('slbGame'));
        $arrFilter = array(
            'slbGame' => $arrGame['0'],
            'keyword' => $this->CI->Session->get_session('keyword'),
            'date_from' => $this->CI->Session->get_session('date_from'),
            'date_to' => $this->CI->Session->get_session('date_to'),
            'slbStatus' => $this->CI->Session->get_session('slbStatus'),
            'server_id' => $this->CI->Session->get_session('server_id'),
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'slbGame' => $arrGame['0'],
                'keyword' => $arrParam['keyword'],
                'date_from' => $arrParam['date_from'],
                'date_to' => $arrParam['date_to'],
                'slbStatus' => $arrParam['slbStatus'],
                'server_id' => $arrParam['server_id'],
                'page' => 1
            );
            $page = 1;
        }

        $per_page = 20;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->PaymentPromoModel->listTable($arrFilter);

        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control=payment_promo&func=index&module=all';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
		
        $this->data['listItems'] = $listData;
        $this->data['arrFilter'] = $arrFilter;

        
        $slbScopes = $this->CI->PaymentPromoModel->listScopes();
        $this->data['slbScopes'] = $slbScopes;
        if (!empty($arrGame['0'])) {
            $slbServer = $this->CI->PaymentPromoModel->listServerByGame($arrGame['0']);
            $this->data['slbServer'] = $slbServer;
        }
        $this->CI->template->write_view('content', 'game/reports/paymentpromo/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $arrGame = explode('-', $_REQUEST['game']);
        $game = $arrGame['0'];
        $listServer = $this->CI->PaymentPromoModel->listServerByGame($game);
        
        if(!empty($game)){
            $xhtml = '<select name="server_id" class="textinput"><option value="0">Chọn server</option>';
            if(empty($listServer) !== TRUE){
                foreach($listServer as $v){
                    $xhtml .='<option value="'.$v['server_id'].'">'.$v['server_name'].'</option>';
                }
            }
            $xhtml .= '</select>';
            $f = array(
                'status'=>0,
                'messg'=>'Thành công',
                'html'=>$xhtml
            );
        }else{
            $xhtml = '<select name="server_id" class="textinput"><option value="0">Chọn server</option></select>';
            $f = array(
                'status'=>1,
                'messg'=>'Thất bại',
                'html'=>$xhtml
            );
        }
        echo json_encode($f);
        exit();
    }
    public function getvalidate(){
        $resultDate = strtotime($_REQUEST['dateTo'])-strtotime($_REQUEST['dateForm']);
        $resultDate = $resultDate/(3600*24);
        if($resultDate<=0 || $resultDate>14){
            $reponse = array(
                'error' => 1,
                'messg' => 'Bạn hãy chọn lại thời gian (trong khoảng 14 ngày)'
            );
        }else{
            $reponse = array(
                'error' => 0,
                'messg' => 'Thành công'
            );
        }
        echo json_encode($reponse);
        exit();
    }
    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('slbGame', $arrParam['slbGame']);
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('date_from', $arrParam['date_from']);
            $this->CI->Session->unset_session('date_to', $arrParam['date_to']);
            $this->CI->Session->unset_session('slbStatus', $arrParam['slbStatus']);
            $this->CI->Session->unset_session('server_id', $arrParam['server_id']);
        }
    }
    public function getResponse() {
        return $this->_response;
    }
}