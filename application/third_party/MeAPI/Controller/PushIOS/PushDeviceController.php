<?php
error_reporting(0);

class MeAPI_Controller_PushDeviceController implements MeAPI_Controller_PushDeviceInterface
{
    /* @var $cache_user CI_Cache */
    /* @var $cache CI_Cache */
    protected $_response;
    /**
     *
     * @var CI_Controller
     */
    private $CI;

    private $app_key = 'agiU7J0A';

    public function __construct()
    {
        $this->CI = &get_instance();
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

    public function index(MeAPI_RequestInterface $request)
    {

    }

    public function addCategory(MeAPI_RequestInterface $request)
    {
        $params = $request->input_request();

        if (empty($request) === TRUE) {
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
        }
        $isneed = array("time", "game", "platform", "message","packageName");

        //isneedSub
        if (!$this->isneedSub($params, $isneed)) {
            return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
        }


        $this->CI->load->MeAPI_Model('PushModel');

        $params_insert = array(
            "insertDate"=>date('Y-m-d H:i:s',time()),
            "time"=>$params['time'],
            "game"=>$params['game'],
            "platform"=>$params['platform'],
            "message"=>$params['message']
        );
        $status = $this->CI->PushModel->addCategory($params_insert);
        if($status){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS');
        }else{
            return $this->_response = new MeAPI_Response_APIResponse($request, 'FAILED');
        }

    }

    public function processqueue(MeAPI_RequestInterface $request)
    {

        /*
         * bước 1 : khi thực hiện việc push từ tool : là sẽ tạo 1 category với điều kiện tương ứng như GO order
           khi thực hiện xong, thì cron tab sẽ chạy 5s 1 lần vào api của em
           api này thực hiện kiểm tra catetory với điều kiện gì
           xong nó lấy bên table push  vs dk tương ứng , chỉ lấy 1k row ra
           30row sẽ nén thành 1 json
           và thực hiện đẩy qua queue
           sau khi đẩy xong, cứ mỗi tệp json nén này sẽ dc insert vào table logs kèm với id cateory và id_push device sau cùng
        */
        //insert category
        //where time,game,platform,message


        $this->CI->config->load('mq_setting');
        $mq_config = $this->CI->config->item('mq');
        $config['routing'] = $mq_config['payment_mq_routing'];
        $config['exchange'] = $mq_config['payment_mq_exchange'];

        //get category not is _finish
        $getcat = $this->CI->PushModel->listCategoris();
        if($getcat){
            //get last history with cath
            $where_last_device = array("id_push_cat"=>$getcat['id']);
            $getDevicelat = $this->CI->PushModel->getLastIdDevice($where_last_device);
            $id_list = 0;
            if($getDevicelat){
                $id_list = $getDevicelat['id_push_cat'];
            }

            $where_params_device = array(
                "id > "=> $id_list,
                "game" => $getcat['game'],
                "platform" => $getcat['platform'],
            );

            $getListDevice = $this->CI->PushModel->getListDevice($where_params_device);
            if($getListDevice){
                $ik = 1;
                $array_device=  array();
                foreach ($getListDevice  as $k=>$v) {

                    array_push($array_device,array($v['deviceToken']));

                    if($ik >= 30 || empty($getListDevice[$k+1]) == TRUE  ){

                        $array_push = array(
                            "devices"=>$array_device,
                            "message"=>$getcat['message'],
                            "env"=>"ginside",
                            "os"=>$getcat['platform'],
                            "app"=>$getcat['game'],
                            "reportEnable"=>true,
                            "options"=> array("data"=>array(),"type"=>1)
                        );
                        $mq_message = json_encode($array_push);

                        MEAPI_Mq::push_rabbitmq($config, $mq_message);

                        $ik = 1;
                        $array_device = array();
                    }


                    $ik++;
                }


                MEAPI_Mq::close_rabbitmq();
            }else{
                //update finish
                $params_update = array(
                    "is_finish"=>1
                );
                $where_update_params_device = array(
                    "id"=>$getcat['id_push_cat']
                );
                $this->CI->PushModel->editFinish($params_update,$where_update_params_device);
            }

        }


        $this->CI->template->write_view('content', 'giftcodemanager/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }


    public function execute()
    {

        //Establish connection AMQP
        $this->CI->config->load('mq_setting');
        $mq_config = $this->CI->config->item('mq');
        $config['routing'] = $mq_config['payment_mq_routing'];


        $getdata = MEAPI_Mq::pull_rabbitmq($config);

        if($getdata)
        {
            $parseData = json_encode($getdata,true);
            $where_params_device = array("deviceToken"=>$parseData['deviceToken']);
            $this->CI->PushModel->getListDevice($where_params_device);
        }

        MEAPI_Mq::close_rabbitmq();

    }

    public function isneedSub($array, $need)
    {
        foreach ($need as $key => $val) {
            if (!isset($array[$val])) {
                return false;
            }
        }
        return true;
    }

    function isneed($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && isneed($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

}