<?php
class Memcacher {
    private $CI;
    private $cfg_cache;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->config->load('cache');
        $this->cfg_cache = & $this->CI->config->item('cache');
    }
    public static function configMemcache(){
        if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") {
            $config["memcache"] = array("host" => "127.0.0.1", "port" => 11211);
        } else {
            $config["memcache"] = array("host" => "10.10.20.121", "port" => 11211);
        }
        $host = $config["memcache"]["host"];
        $port = $config["memcache"]["port"];
        
        
        $memcache = new Memcache;
        $status = @$memcache->connect($host,$port);
        if($status == false){
            Logs::writeCsv(array(
                            'connect' =>'Kết nối không thành công',
                            'localhost'=>'Localhost: '.$host,
                            'port'=>'Post: '.$port,
                            ),'cache_' . date('H'));
            return null;
        }
        return $memcache;
    }
    public static function Set($key, $value, $cachetime = 3600){
        $mkey = md5($key);
        $mem = Memcacher::configMemcache();
        $return = false;
        if($mem != null){
            $return = $mem->set($mkey, $value, false, $cachetime);
            $mem->close();
        }        
        return false;
    }
    public static function Get($key){
        $mkey = md5($key);
        $mem = Memcacher::configMemcache();
        $value = "";
        if($mem != null){
            $value = $mem->get($mkey);
            $mem->close();
        }        
        return $value;
    }
    public static function Delete($key){
        $mkey = md5($key);
        $mem = Memcacher::configMemcache();
        $value = "";
        if($mem != null){
            $value = $mem->delete($mkey);
            $mem->close();
        }        
        return $value;
    }
}

?>