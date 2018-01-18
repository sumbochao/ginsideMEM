<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Quick_CSV_import
{
    var $table_name; //where to import to
    var $file_name;  //where to import from
    var $use_csv_header; //use first line of file OR generated columns names
    var $field_separate_char; //character to separate fields
    var $field_enclose_char; //character to enclose fields, which contain separator char into content
    var $field_escape_char;  //char to escape special symbols
    var $error; //error message
    var $arr_csv_columns; //array of columns
    var $table_exists; //flag: does table for import exist
    var $encoding; //encoding table, used to parse the incoming file. Added in 1.5 version

    function Quick_CSV_import($file_name="")
    {
        $this->file_name = $file_name;
        $this->arr_csv_columns = array();
        $this->use_csv_header = true;
        $this->field_separate_char = ",";
        $this->field_enclose_char  = "\"";
        $this->field_escape_char   = "\\";
        $this->table_exists = false;
    }


    function import()
    {
        if($this->table_name=="")
            $this->table_name = "temp_".date("d_m_Y_H_i_s");

        $this->table_exists = false;
        $this->create_import_table();

        if(empty($this->arr_csv_columns))
            $this->get_csv_header_fields();

        /* change start. Added in 1.5 version */
        if("" != $this->encoding && "default" != $this->encoding)
            $this->set_encoding();
        /* change end */


        if($this->table_exists)
        {
            $sql = "LOAD DATA INFILE '".@mysql_escape_string($this->file_name).
                    "' INTO TABLE `".$this->table_name.
                    "` FIELDS TERMINATED BY '".@mysql_escape_string($this->field_separate_char).
                        "' OPTIONALLY ENCLOSED BY '".@mysql_escape_string($this->field_enclose_char).
                            "' ESCAPED BY '".@mysql_escape_string($this->field_escape_char).
                                "' ".
                                ($this->use_csv_header ? " IGNORE 1 LINES " : "")
                                ."(`".implode("`,`", $this->arr_csv_columns)."`)";
            $res = @mysql_query($sql);
            $this->error = mysql_error();
        }
    }


    //returns array of CSV file columns
    function get_csv_header_fields()
    {
        $this->arr_csv_columns = array();
        $fpointer = fopen($this->file_name, "r");
        if ($fpointer)
        {
            $arr = fgetcsv($fpointer, 10*1024, $this->field_separate_char);
            if(is_array($arr) && !empty($arr))
            {
                if($this->use_csv_header)
                {
                    foreach($arr as $val)
                        if(trim($val)!="")
                            $this->arr_csv_columns[] = $val;
                }
                else
                {
                    $i = 1;
                    foreach($arr as $val)
                        if(trim($val)!="")
                            $this->arr_csv_columns[] = "column".$i++;
                }
            }
            unset($arr);
            fclose($fpointer);
        }

        else
            $this->error = "file cannot be opened: (".$this->file_name ? "[empty]" :"".")";

        return $this->arr_csv_columns;
    }
    function get_csv_all_fields()
    {
        $this->arr_csv_columns = array();
        $fpointer = fopen($this->file_name, "r");
        if ($fpointer)
        {
            while($arr = fgetcsv($fpointer, 10*1024, $this->field_separate_char)) {
                if (is_array($arr) && !empty($arr)) {
                     $this->arr_csv_columns[] = $arr;

                }
            }
            unset($arr);
            fclose($fpointer);
        }

        else
            $this->error = "file cannot be opened: (".$this->file_name ? "[empty]" :"".")";

        return $this->arr_csv_columns;
    }


    function create_import_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS ".$this->table_name." (";

        if(empty($this->arr_csv_columns))
            $this->get_csv_header_fields();

        if(!empty($this->arr_csv_columns))
        {
            $arr = array();
            for($i=0; $i<sizeof($this->arr_csv_columns); $i++)
                $arr[] = "`".$this->arr_csv_columns[$i]."` TEXT";
            $sql .= implode(",", $arr);
            $sql .= ")";
            $res = @mysql_query($sql);
            $this->error = mysql_error();
            $this->table_exists = ""==mysql_error();
        }
    }


    /* change start. Added in 1.5 version */
    //returns recordset with all encoding tables names, supported by your database
    function get_encodings()
    {
        $rez = array();
        $sql = "SHOW CHARACTER SET";
        $res = @mysql_query($sql);
        if(mysql_num_rows($res) > 0)
        {
            while ($row = mysql_fetch_assoc ($res))
            {
                $rez[$row["Charset"]] = ("" != $row["Description"] ? $row["Description"] : $row["Charset"]); //some MySQL databases return empty Description field
            }
        }
        return $rez;
    }


    //defines the encoding of the server to parse to file
    function set_encoding($encoding="")
    {
        if("" == $encoding)
            $encoding = $this->encoding;
        $sql = "SET SESSION character_set_database = " . $encoding; //'character_set_database' MySQL server variable is [also] to parse file with rigth encoding
        $res = @mysql_query($sql);
        return mysql_error();
    }
    /* change end */

	
	/**
     * Export Excel Don't Use Lib
     * @author		ThanhNT
     * @access	public
     * @param	array header (Should use English because Unicode Error)
     * @param	array data with format json array
     * For Example: [{"id":"31","created_date":"2015-10-07 17:12:20","character_id":"2-1-1442475595-26","character_name":"ThanhNT","server_id":"2","mobo_service_id":"1191512545155480893"}]

     * @param	array $css_tr : format css for <tr> with row index
     * For Example:
     * $css_tr = array(
        '0' => 'style="background-color: red;"',
        '1' => 'style="background-color: blue;"',
        );
     *
     * @param	$css_td css for <td> with row & column index
     * * For Example:
     * $css_td = array(
        '0-0' => 'style="background-color: red;"',
        '0-1' => 'style="background-color: blue;"',
        );
     *
     *
     * @param	$add_excel_comment use for values is long integer with column index
     *  * * For Example:
         *  $add_excel_comment = array(
        '5' => "'"
        );
     *
     * @return	excel file
     * $NOTE: position of header array and data must mapping together
     */
    public function export($header, $data,$add_excel_comment = array(),$css_tr = array(),$css_td = array() )
    {
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"filename.xls\"");
        header("Cache-Control: max-age=0");

        $tr_style = 'style="border: 1px solid;"';
        $th_style = 'style="border-right: 1px solid #3232BD; text-align: center;background-color: #3232BD;color: #fff; font-weight: bold; "';
        $td_style = 'style="border-right: 1px solid;text-align: center;"';
        $table_style = 'style="width: 100%;border-collapse: collapse"';

        $th = '';

        $content = '';
        //generate th tag
        foreach($header as $h){
            $th .= "<th $th_style>$h</th>";
        }
        //generate data
        $data  = json_decode($data);
        for($i = 0; $i < count($data); $i++){
            $row = get_object_vars($data[$i]);
            if(isset($css_tr[$i])){
                $style = $css_tr[$i];
                $tr = "<tr $style>";
            }else{
                $tr = "<tr $tr_style>";
            }

            $j = 0;
            $td = '';
            foreach($row as $col){
                if(isset($add_excel_comment[$j])){
                    $col = "'$col'";
                }
                if(isset($css_td[$i.'-'.$j])){
                    $style = $css_td[$i.'-'.$j];
                    $td .= "<td $style>$col</td>";
                }else{
                    $td .= "<td $td_style>$col</td>";
                }
                $j++;
            }
            $tr .= $td . '</tr>';
            $content .= $tr;
        }
        echo '<table '.$table_style.'>
                <tr '.$tr_style.'>'.$th.'</tr>
                '.$content.'
            </table>';
        exit;
    }
}