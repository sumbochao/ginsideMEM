<?php

class MeAPI_Log {

    public static function writeCsv($fields, $filename, $group = 'request', $date = 'Y/m/d', $timefield = 'H:i:s') {

        $CI = &get_instance();
        $CI->config->load('log');
        $config = $CI->config->item('log');
        $config = $config[$group];

        if (empty($config) === TRUE)
            die('Empty config log ' . $group);

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

?>
