<?php
class AccessLog{
	 /**
     * Author: tailm
     * @var CI_Controller
     */
	private $CI;
	
	function __construct(){
		$this->CI = & get_instance();
	}
	public static function writeCsv($fields, $filename, $date = 'Y/m/d', $timefield = 'H:i:s') {
               
        $config = APPPATH . 'logs';
          
        try {
            $fields[] = date($timefield);
            if ($date)
                $path = $config . '/' . date($date);
            else
                $path = $config . '/';
            if (!file_exists($path))
                @mkdir($path, 0777, TRUE);
            $fh = @fopen($path . '/' . $filename . '.csv', 'a');
            @fputcsv($fh, $fields);
            @fclose($fh);
        } catch (Exception $ex) {
            
        }
    }
}