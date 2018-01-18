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
            var mobo_service_id = getParameterByName("mobo_service_id");
            $('#export_excel').on('click', function () {               
                window.location.href = '/?control=vangdaykho_mt&func=excel_lichnhanqua&mobo_service_id=' + mobo_service_id + "&module=all";
            });
            
            $('#back_button').on('click', function () {               
               history.go(-1);
            });
            getData(mobo_service_id);
        });

        function getData(mobo_service_id) {          
            $("#loading_img").show();
            $.ajax({
                url: "http://game.mobo.vn/mathan/cms/toolvangdaykho/get_calendar_bonus?mobo_service_id=" + mobo_service_id,
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
                                sTitle: "ID",
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
                                sTitle: "Tên Nhân Vật",
                                mData: "char_name",
                            },
                            {
                                sTitle: "Mobo Service ID",
                                mData: "mobo_service_id",
                            },
                            {
                                sTitle: "Mobo ID",
                                mData: "mobo_id",
                            },
                            {
                                sTitle: "Ngọc Nhận",
                                mData: "poin_bonus",
                            },
                            {
                                sTitle: "Ngày Nhận",
                                mData: "bonus_date",
                            },
                            {
                                    sTitle: "Trạng Thái",
                                    mData: "status_received",
                                    mRender: function (data) {
                                        return (data == 1) ? "<span style='color:green'>Đã Nhận</span>" : (data == 2) ? "<span style='color:green'>Bỏ Qua</span>" : "<span style='color:red'>Chưa Nhận</span>";
                                    }
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
            <?php include APPPATH . 'views/game/mt/Events/VangDayKho/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">                        
                        <table style="margin-bottom: 10px; font-size: 11px;" cellspacing="0" cellpadding="4">
                            <tr>                                                              
                                <td><button id="back_button" class="btn btn-success"><span>QUAY LẠI</span></button> <button id="export_excel" class="btn btn-success"><span>EXPORT EXCEL</span></button></td>
                            </tr>                       
                        </table>
                        <div class="table-overflow">                                                     
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
