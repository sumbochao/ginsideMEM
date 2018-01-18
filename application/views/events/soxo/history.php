<!-- Content container -->
<div id="container">
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
           

            <style type="text/css" media="screen">
                .tabs a{float: left;color: #000;font-size: 14px;width: 15%;}
                .clearboth{clear:both;width: 100%;height:0;display: block;content:"";}
                .green,.red{font-weight: bold;}
                .green{color:green;}
                .red{color:red;}
            </style>

            <?php include APPPATH . '/views/events/soxo/nav.php'; ?>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">                
                <div class="table-overflow">
                    <table class="table table-striped table-bordered" id="data_table">
                    </table>
                </div>
                 <div class="table-overflow">
                    <table class="table table-striped table-bordered" id="data_table_send">
                    </table>
                </div>
                </br>
                <button class="pull-right btn btn-primary" onclick="tableToExcel('<table>' + $('#data_table').html() + '</table>', 'log_event_csmm');">Xuất Excel</button>
            </div>

        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<!-- /content container -->
<script type="text/javascript">

    //xuất excel
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(data, name) {
            var ctx = {worksheet: name || 'Worksheet', table: data}
            window.location.href = uri + base64(format(template, ctx))
        }
    })();
    getData();
    function getData() {
        $.ajax({
            url: "http://service.mgh.mobo.vn/cms/toolconsomayman2/getHistory",
            dataType: 'jsonp',
            method: "POST",
            bRetrieve: true,
            bDestroy: true,
            error: function (jqXHR, textStatus, errorThrown) {
            },
            success: function (data, textStatus, jqXHR) {
                $('#data_table').dataTable({
                    "aaData": data.rows,
                    aoColumns: [
                        {
                            sTitle: "Mã GD",
                            mData: "id"
                        },
                        {
                            sTitle: "Server Id",
                            mData: "server_id"

                        },
                        {
                            sTitle: "Character ID",
                            mData: "character_id"

                        },
                        {
                            sTitle: "Tên Nhân Vật",
                            mData: "character_name"
                        },
                        {
                            sTitle: "Số",
                            mData: "so"
                        },
                        {
                            sTitle: "Giải",
                            mData: "giai"
                        },

                        {
                            sTitle: "Cược điểm",
                            mData: "datcuoc"
                        },
                        {
                            sTitle: "Ngày sổ",
                            mData: "createdDate"
                        },
                        {
                            sTitle: "Kết quả",
                            mData: "result"
                        },
                        {
                            sTitle: "Ngày cập nhật",
                            mData: "updatedDate"
                        }
                    ],
                    bProcessing: true,

                    bPaginate: true,

                    bJQueryUI: false,

                    bAutoWidth: false,

                    bSort: false,
                    bRetrieve: true,
                    bDestroy: true,

                    sPaginationType: "full_numbers",
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
                });
            }
        });
    }
</script>







