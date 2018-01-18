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

    public function execute($invoiceNum)
    {

//Establish connection AMQP
        $connection = new AMQPConnection();
        $connection->setHost('127.0.0.1');
        $connection->setLogin('guest');
        $connection->setPassword('guest');
        $connection->connect();

//Create and declare channel
        $channel = new AMQPChannel($connection);

//AMQPC Exchange is the publishing mechanism
        $exchange = new AMQPExchange($channel);


        $callback_func = function(AMQPEnvelope $message, AMQPQueue $q) use (&$max_consume) {
            echo PHP_EOL, "------------", PHP_EOL;
            echo " [x] Received ", $message->getBody(), PHP_EOL;
            echo PHP_EOL, "------------", PHP_EOL;

            //delete devie

            $q->nack($message->getDeliveryTag());
            sleep(1);
        };

        try{
            $routing_key = 'hello';

            $queue = new AMQPQueue($channel);
            $queue->setName($routing_key);
            $queue->setFlags(AMQP_NOPARAM);
            $queue->declareQueue();

            echo ' [*] Waiting for messages. To exit press CTRL+C ', PHP_EOL;
            $queue->consume($callback_func);
        }catch(AMQPQueueException $ex){
            print_r($ex);
        }catch(Exception $ex){
            print_r($ex);
        }

        echo 'Close connection...', PHP_EOL;
        $queue->cancel();
        $connection->disconnect();

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