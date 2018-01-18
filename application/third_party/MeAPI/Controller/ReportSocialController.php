<?php
session_start();
require_once APPPATH . 'third_party/MeAPI/Autoloader.php';
class MeAPI_Controller_ReportSocialController implements MeAPI_Controller_ReportSocialInterface {
    protected $_response;
    private $CI;
    private $table_fanpage = "tbl_fanpage";
    private $table_report_social = "tbl_report_social";
    public function __construct() {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->CI = &get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('ReportSocialModel');

        /*$acc = array("vietbl","hoangpc", "tuanhq", "nghiapq", "quannt","phuongnt","phuongnt2","hiennv","thinhndn");
        if (in_array($session['username'], $acc) === false) {
            echo 'Bạn không được phép truy cập!'; die;
        }*/
        MeAPI_Autoloader::register();

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
    }

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        //get model kiem tra ngay hien ta da co trong danh sach chua
        //neu chua co thi tien hanh get data va insert ngay sau cung
        $daynow = date('Y-m-d',strtotime(date('Y-m-d',time())."-6day"));
        $checkinfo = $this->CI->ReportSocialModel->loadHistoryByDate($daynow);

        if($checkinfo){
            // tien hanh get link
            foreach($checkinfo as $key=>$val){
                $this->data['inforule'][$val['type']][] = $val;

            }

        }
        $this->CI->template->write_view('content', 'reportsocial/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getdata(MeAPI_RequestInterface $request){
        $access_token = $request->input_post('access_token');
        $params = $this->CI->ReportSocialModel->getlistfanpageActive();
        //get last date
        $lastdate = $this->CI->ReportSocialModel->getlastdate();

        $this->page_fans($params,$access_token);
        $this->page_impressions_organic($params,$access_token);
        $this->page_positive_feedback_by_type($params,$access_token);
        echo json_decode(array('code'=>0,'message'=>'Thành công'));
        die;

    }
    function page_fans($params,$access_token){
        $datareturn = array();
        foreach($params as $key=>$val) {
           $datareturn[$val['alias']] = $this->curlFB(__FUNCTION__, urlencode($val['fanpage']), $access_token);
        }
        if($datareturn) {
            foreach ($datareturn as $key => $val) {
                foreach ($val['data'] as $key1 => $val1) {
                    $arrayInsert = array('game'=>$key,'type' => __FUNCTION__, "day_likefanpage" => $val1['value'], 'insertdate' => date('Y-m-d H:i:s', strtotime($val1['end_time'])));
                    $this->CI->ReportSocialModel->insert_id($this->table_report_social, $arrayInsert);
                    //insert data
                }
            }
        }
    }
    function page_impressions_organic($params,$access_token){
        $datareturn = array();
        foreach($params as $key=>$val) {
            $datareturn[$val['alias']] = $this->curlFB(__FUNCTION__, urlencode($val['fanpage']), $access_token);
        }
        if($datareturn) {
            foreach ($datareturn as $key => $val) {
                foreach ($val['data'] as $key1 => $val1) {
                    //$whereUpdate = array('insertdate'=>date('Y-m-d H:i:s',strtotime($val1['end_time'])));
                    $arrayInsert = array('game'=>$key,'type' => __FUNCTION__, "day_reseach" => $val1['value'], 'insertdate' => date('Y-m-d H:i:s', strtotime($val1['end_time'])));
                    $this->CI->ReportSocialModel->insert_id($this->table_report_social, $arrayInsert);
                    //insert data
                }
            }
        }
    }
    function page_positive_feedback_by_type($params,$access_token){
        $datareturn = array();
        foreach($params as $key=>$val) {
            $datareturn[$val['alias']] = $this->curlFB(__FUNCTION__, urlencode($val['fanpage']), $access_token);
        }
        if($datareturn) {
            foreach ($datareturn as $key => $val) {
                foreach ($val['data'] as $key1 => $val1) {
                    // = array('insertdate'=>date('Y-m-d H:i:s',strtotime($val1['end_time'])));
                    $arrayInsert = array('game'=>$key,'type' => __FUNCTION__, "day_like" => $val1['value']['like']
                    , "day_comment" => $val1['value']['comment'], "day_share" => $val1['value']['link']
                    , 'insertdate' => date('Y-m-d H:i:s', strtotime($val1['end_time'])));
                    $this->CI->ReportSocialModel->insert_id($this->table_report_social, $arrayInsert);
                    //insert data
                }
            }
        }
    }


    public function configmenu(MeAPI_RequestInterface $request){
        $loadnavigators = $this->CI->ReportSocialModel->getlistfanpage();

        $this->data['listconfig'] = $loadnavigators;
        $this->CI->template->write_view('content', 'reportsocial/toolconfig_index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function configmenuadd(MeAPI_RequestInterface $request){
        $getconfig = "";
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $idget = $_GET['id'];
            $getconfig = $this->CI->ReportSocialModel->getfanpagebyid($idget);
        }

        if ($this->CI->input->post() && count($this->CI->input->post())>=1) {
            $id = $request->input_post('id');
            $name = $request->input_post('fanpage');
            $alias = $request->input_post('alias');
            $desc = $request->input_post('desc');

            $paramsinsert= array(
                "fanpage"=>$name,
                "alias"=>$alias,
                "description"=>$desc,
                "insertdate"=>date('Y-m-d H:i:s',time()),
            );
            if(!empty($id) && $id >=1){
                $whereUpdate=  array('idx'=>$id);
                $statusupdate = $this->CI->ReportSocialModel->update($this->table_fanpage,$paramsinsert,$whereUpdate);
                if($statusupdate)
                    $this->data['error']='Cập nhât thành công';
                else
                    $this->data['error']='Cập nhât thất bại';
            }else{
                //kiem tra da ton tai id_app va note nay` chua...neu ton tai thi hok cho insert
                $statusinsert = $this->CI->ReportSocialModel->insert_id($this->table_fanpage,$paramsinsert);
                if($statusinsert != false)
                    $this->data['error']='Thêm thành công';
                else
                    $this->data['error']='Thêm thất bại';
            }


        }
        $this->data['configid'] = $getconfig;
        $this->CI->template->write_view('content', 'reportsocial/toolconfig_add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function getResponse() {
        return $this->_response;
    }

    /*
     * Get Data Group
     */
    /*
     * Bieu do 1
https://graph.facebook.com/v2.2/665726200221998/insights/page_fans?access_token=CAACEdEose0cBAPMvQur2SMlk0QncFqfG7obxZCkAgf8AJvVZCAWEKZBiP5yPLk9ihJGkbU6gZCVUyZCogUnAqh0hMt3UxynxtOg9bm3xQtXIJZCets12d7xI3guKTzzuLi0vebKYLQ7ABkBVjbZBYyZBskRdlPqKfU5OBnqgkryee4DWfh6W9nbpGWOQFVGfqZCOlEwCV6VHXFAZDZD

Bieu do 3
https://graph.facebook.com/v2.2/665726200221998/insights/page_impressions_organic?access_token=CAACEdEose0cBAPMvQur2SMlk0QncFqfG7obxZCkAgf8AJvVZCAWEKZBiP5yPLk9ihJGkbU6gZCVUyZCogUnAqh0hMt3UxynxtOg9bm3xQtXIJZCets12d7xI3guKTzzuLi0vebKYLQ7ABkBVjbZBYyZBskRdlPqKfU5OBnqgkryee4DWfh6W9nbpGWOQFVGfqZCOlEwCV6VHXFAZDZD

Bieu do 2
https://graph.facebook.com/v2.2/665726200221998/insights/page_positive_feedback_by_type_unique?until=now&access_token=CAACEdEose0cBAPMvQur2SMlk0QncFqfG7obxZCkAgf8AJvVZCAWEKZBiP5yPLk9ihJGkbU6gZCVUyZCogUnAqh0hMt3UxynxtOg9bm3xQtXIJZCets12d7xI3guKTzzuLi0vebKYLQ7ABkBVjbZBYyZBskRdlPqKfU5OBnqgkryee4DWfh6W9nbpGWOQFVGfqZCOlEwCV6VHXFAZDZD

https://graph.facebook.com/v2.2/665726200221998/insights/page_positive_feedback_by_type?until=now&access_token=CAACEdEose0cBAPMvQur2SMlk0QncFqfG7obxZCkAgf8AJvVZCAWEKZBiP5yPLk9ihJGkbU6gZCVUyZCogUnAqh0hMt3UxynxtOg9bm3xQtXIJZCets12d7xI3guKTzzuLi0vebKYLQ7ABkBVjbZBYyZBskRdlPqKfU5OBnqgkryee4DWfh6W9nbpGWOQFVGfqZCOlEwCV6VHXFAZDZD
     */
    public function curlFB($func ='',$pageid,$access_token){
        $since = strtotime(date('Y-m-d',time())."-6day");
        $until = strtotime(date('Y-m-d',time())."+1day");
        $graph_url= "https://graph.facebook.com/v2.2/".$pageid."/insights/".$func."?access_token=".$access_token."&since=".$since."&until=".$until;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output,true);
        $return  =array('data'=>$result['data'][0]['values'],'paging'=>$result['paging']);
        return $return;
    }

}
