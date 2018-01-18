<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            var date_start_default = yyyy + '-' + mm + '-' + dd + " 00:00:00";
            var date_end_default = yyyy + '-' + mm + '-' + dd + " 23:59:59";

            $("#startdate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss', value: date_start_default });
            $("#enddate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss', value: date_end_default });

            if (getParameterByName("startdate") != "" && getParameterByName("enddate") != "") {
                $("#startdate").val(getParameterByName("startdate"));
                $("#enddate").val(getParameterByName("enddate"));
            }

            $('#create_boxitem').on('click', function () {
                window.location.href = "/?control=shopkimbai_bog&func=lichsu&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val() + "&module=all#lichsu";
            });

            //Load Total Point Exchage Gift
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/bog/cms/toolshopkimbai/get_total_point_gift_pakage_exchange_history?startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val(),
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#Total").html(data[0]["Total"]);
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            getData();
        });
        
        function getData() {
            $("#loading_img").show();
            $.ajax({
                url: "http://game.mobo.vn/bog/cms/toolshopkimbai/get_gift_pakage_exchange_history?startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val(),
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows
                        ,
                        aoColumns: [
                                 {
                                     sTitle: "Mã GD",
                                     mData: "id"
                                 },
                                {
                                    sTitle: "Server Id",
                                    mData: "server_id",

                                },
                                {
                                    sTitle: "Character ID",
                                    mData: "char_id",

                                },
                                {
                                    sTitle: "Mobo Service ID",
                                    mData: "mobo_service_id",

                                },
                                {
                                    sTitle: "Tên Nhân Vật",
                                    mData: "char_name",
                                },
                                {
                                    sTitle: "Điểm",
                                    mData: "exchange_gift_point",
                                },
                                {
                                    sTitle: "Quà",
                                    mData: "gift_name",
                                },
                                {
                                    sTitle: "Thời Gian",
                                    mData: "exchange_gift_date",
                                }
                        ],
                        bProcessing: true,

                        bPaginate: true,

                        bJQueryUI: false,

                        bAutoWidth: false,

                        bSort: false,
                        bRetrieve: true,
                        bDestroy: true,

                        sPaginationType: "full_numbers"
                    });
                    $("#loading_img").hide();
                }
            });
        }

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/bog/Events/ShopKimBai/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">                        
                        <table style="margin-bottom: 10px; font-size: 11px;" cellspacing="0" cellpadding="4">
                        <tr>
                            <td>Từ ngày:  </td>
                            <td><div id="startdate" name="startdate"></div></td>
                            <td>Đến ngày: </td>
                            <td><div id="enddate" name="enddate"></div></td>
                            <td><button id="create_boxitem" class="btn btn-primary"><span>Thực Hiện</span></button></td>
                            <!--<td><button id="export_excel" class="btn btn-success"><span>EXPORT EXCEL</span></button></td>-->
                        </tr>                       
                    </table>
                <div class="table-overflow"> 
                    <div style="border-top:1px solid #d5d5d5;padding: 4px 8px">Tổng điểm đổi quà game: <span id="Total" style="font-weight: bold; color: #27A800"></span>
                    </div>                                  
                    <table class="table table-striped table-bordered" id="data_table">      
                    </table>
                </div>
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
