<?php

class Ulti {

    private $CI;

    public function __construct() {
        
    }

    public function _cleanDir($dir, $type, $all = true) {
        foreach ($dir as $key => $value) {
            if ($value === '.' || $value === '..') {
                unset($dir[$key]);
            } else {
                $result[] = $value;
            }
        }
        if ($all)
            $result[''] = 'Chose ' . $type;

        ksort($result);
        return $result;
    }

    public function _downloadcsv($csv_header, $csv_output, $csv_title, $csv_type) {
        if ($csv_output) {
            include('Font.php');
            $Font = new Font();

            $csv_outputs = json_decode($csv_output, true);
            $csv_headers = json_decode($csv_header, true);
            $csv_titles = json_decode($csv_title, true);
            foreach ($csv_outputs as $key => $csv_output) {
                $csv_header = $csv_headers[$key];
                $csv_title = $csv_titles[$key];
                $res['csv_title'] = strip_tags($csv_title) . ",\n";
                $res['csv_header'] = $this->_csv_header($csv_header);
                $res['csv_output'] = explode("\n", $csv_output);
                unset($res['csv_output'][0]);
                $res['csv_output'] = implode("\n", $res['csv_output']);
                $result .= implode("", $res) . "\n\n\n\n";
            }
            $result = $Font->uni2str($result);
            $filename = PRIVATE_PATH . '/tmp/' . $csv_type . '.csv';

            $this->_writefile($filename, $result);
            chmod($filename, 0777);
            // Download File
            $fsize = filesize($filename);
            $path_parts = pathinfo($filename);

            return array('result' => $result, 'path_parts' => $path_parts["basename"], 'fsize' => $fsize);
        } else {
            return false;
        }

        die;
    }

    public function _split_content($tag_start, $tag_end, $str) {
        $temp = '';
        $temp1 = '';
        $result = '';
        $temp = explode($tag_start, $str);
        if (count($temp) > 2) {
            for ($i = 1; $i < count($temp); $i++) {
                $temp1 = explode($tag_end, $temp[$i]);
                $result[] = $temp1[0];
            }
        } else {
            $temp1 = explode($tag_end, $temp[1]);
            $result = $temp1[0];
        }


        return $result;
    }

    private function _csv_header($str) {
        $list_hd = $this->_split_content('<tr>', '</tr>', $str);

        if (!is_array($list_hd)) {
            $list_hd = array($list_hd);
        }

        foreach ($list_hd as $key => $value) {
            $list = explode("\n", trim($value));
            if (count($list) == 1) {
                $value = str_replace('</th>', "</th>\n", $value);
                $list = explode("\n", trim($value));
            }
            foreach ($list as $k => $v) {
                $str = trim(strip_tags($v));
                if (!empty($str)) {
                    $pure_text[$key][$k] = '"' . str_replace(array('%', '‰'), '', html_entity_decode(trim(strip_tags($v)))) . '"';
                    if (preg_match('/colspan=/is', $v)) {
                        $max_col[$key]['sum_col'] += intval($this->_split_content('colspan="', "'", $v));
                        $max_col[$key]['col'][$k] += intval($this->_split_content('colspan="', "'", $v));
                    } else {
                        $max_col[$key]['col'][$k]++;
                        $max_col[$key]['sum_col']++;
                    }

                    if (preg_match('/rowspan=/is', $v)) {
                        $max_col[$key]['row'][$k] += intval($this->_split_content('rowspan="', "'", $v) - 1);
                    }
                }
            }
        }

        foreach ($max_col as $key => $value) {
            foreach ($pure_text[$key] as $k => $v) {
                if ($key == 0) {
                    $row[$key][] = $v;
                    for ($j = 1; $j < $max_col[0]['col'][$k]; $j++) {
                        $row[$key][] = '';
                    }


                    foreach ($value['row'] as $k2 => $v2) {
                        $row[$key + 1][$k2] = '';
                    }
                }
                if ($key == 1) {
                    for ($i = 0; $i < $max_col[0]['sum_col']; $i++) {
                        if (!array_key_exists($i, $row[$key])) {
                            $row[$key][$i] = $v;
                            for ($j = 1; $j < $max_col[1]['col'][$k]; $j++) {
                                $row[$key][] = '';
                            }
                            break;
                        }
                    }
                }
            }
        }
        foreach ($row as $key => $value) {
            $str_csv .= implode(',', $value) . "\n";
        }
        return $str_csv;
    }

    public function _sendSms_tech($url) {
        @file_get_contents($url);
    }
    public function _sendmail_tech($msg) {
        return false;
        include_once('SendMail.php');
        $sender = new SendMail();

        try {
            $email_info = $this->_GM_MODEL->getListMail('GMTool.' . $this->_APP);
        } catch (Exception $exc) {
            
        }

        if (empty($email_info)) {
            $arr_mail = array('khoapm@MECORP.VN', 'huylbt@MECORP.VN');
            $subject = 'INSIDE ' . $msg['subject'];
            $content = $msg['content'];
        } else {
            $arr_mail = $email_info['email'];
            $subject = $email_info['title'] . $msg['subject'];
            $content = $email_info['content'] . $msg['content'];
        }

        $mail_info = array(
            'receiver' => $arr_mail,
            'senderName' => 'INSIDE',
            'content' => $msg['content'],
            'subject' => $subject
        );
        $sender->send($mail_info);
    }

    public function _paramlink($arr) {
        $result = '?';
        foreach ($arr as $key => $value) {
            if ($value && $value != 'undefined' || $value == 0) {
                $result .= $key . '=' . $value . '&';
            }
        }
        return $result;
    }

    public function _pagination_top($limit = 500) {
        include_once('Pagination.php');
        $start_at = $this->_request->getParam('segment');
        $this->view->segment = $start_at;
        if (empty($start_at))
            $start_at = 0;
        $limit = $limit;
        return array('limit' => $limit, 'start_at' => $start_at);
    }

    public function _pagination_bot($url, $param, $numpage, $limit = 500) {
        $pagination = new Pagination(array(
            'base_url' =>
            $this->view->url($url, 'default', TRUE) . $param,
            'cur_tag_open' => '<a class="dangchon" href="#">',
            'cur_tag_close' => '</a>',
            'total_rows' => $numpage,
            'per_page' => $limit,
            'next_tag_open' => '<div class="next-nav">',
            'next_tag_close' => '</div>',
            'prev_tag_open' => '<div class="prev-nav">',
            'prev_tag_close' => '</div>'
        ));
        $pagination->initialize();
        $this->view->assign('pagination', $pagination->create_links());
    }

    private function _writefile($filename, $content) {
        $fh = fopen($filename, "w");
        fwrite($fh, $content);
        fclose($fh);
    }

    public function _toMysqlDate($str = null) {
        if ($str) {
            list($sday, $smonth, $syear) = explode("/", $str);
            return "$syear-$smonth-$sday";
        } else {
            return NULL;
        }
    }

    public function _toMysqlDatetime($str = null) {
        if ($str) {
            $tmp = explode(' ', $str);

            list($sday, $smonth, $syear) = explode("/", $tmp[0]);
            list($hour, $min, $ss) = explode(':', $tmp[1]);
            return "$syear-$smonth-$sday $hour:$min:$ss";
        }
    }

    public function _modifyActiveLevel($active_level) {
        $arr = array('1-9' => '0', '10-19' => '0', '20-29' => '0', '30-39' => '0', '40-49' => '0', '50-59' => '0', '60-69' => '0', '70-79' => '0', '80-89' => '0', '90-99' => '0', '100-109' => '0', '110-119' => '0', '120+' => '0');
        foreach ($active_level as $server => $accounts) {
            if (empty($result[$server])) {
                $result[$server] = $arr;
                $total_server[$server] = 0;
            }

            foreach ($accounts as $level => $total) {
                $level = ceil(($level + 1) / 10);
                switch ($level) {
                    case 0:
                    case 1:
                        $result[$server]['1-9'] += $total;
                        break;
                    case 2:
                        $result[$server]['10-19']+= $total;
                        break;
                    case 3:
                        $result[$server]['20-29']+= $total;
                        break;
                    case 4:
                        $result[$server]['30-39']+= $total;
                        break;
                    case 5:
                        $result[$server]['40-49']+= $total;
                        break;
                    case 6:
                        $result[$server]['50-59']+= $total;
                        break;
                    case 7:
                        $result[$server]['60-69']+= $total;
                        break;
                    case 8:
                        $result[$server]['70-79']+= $total;
                        break;
                    case 9:
                        $result[$server]['80-89']+= $total;
                        break;
                    case 10:
                        $result[$server]['90-99']+= $total;
                        break;
                    case 11:
                        $result[$server]['100-109']+= $total;
                        break;
                    case 12:
                        $result[$server]['110-119']+= $total;
                        break;
                    default:
                        $result[$server]['120+']+= $total;
                        break;
                }
                $total_server[$server] += $total;
            }
        }

        return $result;
    }

    // Convert seconds into months, days, hours, minutes, and seconds.
    public function _secondsToTime($ss) {
        $s = $ss % 60;
        $m = floor(($ss % 3600) / 60);
        $h = floor(($ss % 86400) / 3600);
        $d = floor(($ss % 2592000) / 86400);
        $M = floor($ss / 2592000);

        // Ensure all values are 2 digits, prepending zero if necessary.
        $s = $s < 10 ? '0' . $s : $s;
        $m = $m < 10 ? '0' . $m : $m;
        $h = $h < 10 ? '0' . $h : $h;
        $d = $d < 10 ? '0' . $d : $d;
        $M = $M < 10 ? '0' . $M : $M;

        return "$M:$d $h:$m:$s";
    }

}

?>
