<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            //Load Server List
            $.ajax({
                method: "GET",
                url: "/?control=event_loandauvodai_eden&func=get_server_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = $.parseJSON(data);
                    var serverlist = "";
                    $.each(obj, function (key, value) {
                        serverlist += '<option value="' + value["server_id"] + '" >' + value["server_name"] + '</option>';
                    });

                    $("#server_list").html(serverlist);

                    getData($("#server_list").val());
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            $('#export_excel').on('click', function () {
               tableToExcel('<table>' + $('#customers').html() + '</table>', 'log_event_loandauvodai_xephang');
            });
            
            $("#server_list").change(function () {
                getData($(this).val());
            });            
            //getData();
        });

        function getData(server_id) {
           $(".loading").fadeIn("fast");
              $.ajax({
                method: "GET",
                url: "/?control=event_loandauvodai_eden&func=get_top_100&server_id=" + server_id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $('#customers').html(data);    
                    $(".loading").fadeOut("fast");
                },
                error: function (data) {
                    console.log(data);
                    $(".loading").fadeOut("fast");
                }
            });  
        }

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
            return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
        
        //xuất excel
        var tableToExcel = (function () {
            var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
                , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
                , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
            return function (data, name) {
                var ctx = { worksheet: name || 'Worksheet', table: data }
                window.location.href = uri + base64(format(template, ctx))
            }
        })();

    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
<?php include APPPATH . 'views/game/eden/Events/LoanDauVoDai/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <table style="margin-bottom: 10px;" cellspacing="0" cellpadding="4">
                        <tr>
                            <td>Server:  </td>
                            <td><select style="width: 160px" id="server_list" name="server_list"></select></td>
                            <td><button id="export_excel" class="btn btn-success"><span>EXPORT EXCEL</span></button></td>
                        </tr>                       
                    </table>

                    <div class="table-overflow">    
                        <table id="customers" style="width: 100%; text-align: center;">
                            <tr> 
                                <th>Hạng</th> 
                                <th>Nhân vật</th> 
                                <th>Server</th>  
                                <th>Tổng Điểm</th>
                                <th>Trận Thắng</th>                
                            </tr>           
                        </table>                    
                    </div>                
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>