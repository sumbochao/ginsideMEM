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
            $("#startdate").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss', value: date_start_default});
            $("#enddate").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss', value: date_end_default});
            if (getParameterByName("startdate") !== "" && getParameterByName("enddate") !== "") {
                $("#startdate").val(getParameterByName("startdate"));
                $("#enddate").val(getParameterByName("enddate"));
            }

            $('#create_boxitem').on('click', function () {
                window.location.href = "/?control=managercontributor&func=manageitem&view=history_item&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val() + "#lichsu";
            });

            //Load Game List
            $.ajax({
                method: "GET",
                url: "/?control=managercontributor&func=loadgamelist",
//                url: "http://mem.net.vn/cms/toolsalarycollaborator/games_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = $.parseJSON(data);
                    var gamelistId = "";
                    $.each(obj, function (key, value) {
                        gamelistId += value["id"] + ',';
                    });
                    getData(gamelistId);
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });


        function getData(gamelistId) {
            $("#loading_img").show();
            $.ajax({
                url: "http://mem.net.vn/cms/toolsalarycollaborator/get_log_approved_item?startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val() + "&gamelistId=" +gamelistId+  "&pagesize=10000",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data
                        ,
                        aoColumns: [
                            {
                                sTitle: "Mã",
                                mData: "id"
                            },
                            {
                                sTitle: "Người Thao Tác",
                                mData: "author",
                            },
                            {
                                sTitle: "Ngày Thao Tác",
                                mData: "operation_date",
                            },
                            {
                                sTitle: "Tên Game",
                                mData: "name",
                            },
                            {
                                sTitle: "Tên Item",
                                mData: "item_name",
                            },
                            {
                                sTitle: "Kiểu Thao Tác",
                                mData: "type_status",
                                mRender: function (data) {
                                    if (data == 0) {
                                        return "<span style='color:green'>Tạo</span>";
                                    } else if (data == 1) {
                                        return "<span style='color:red'>Chỉnh</span>";
                                    } else {
                                        return "<span style='color:red'>Duyệt</span>";
                                    }
                                }
                            },
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

                }
            });

            $(".loading").fadeOut("fast");

        }

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/salarycontributor/managercontributor/item/tab_manageitem.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">                        
                        <table style="margin-bottom: 10px;" cellspacing="0" cellpadding="4">
                            <tr>
                                <td>Từ ngày:  </td>
                                <td><div id="startdate" name="startdate"></div></td>
                                <td>Đến ngày: </td>
                                <td><div id="enddate" name="enddate"></div></td>
                                <td><button id="create_boxitem" class="btn btn-primary"><span>THỰC HIỆN</span></button></td>
                                <!-- <td><button id="export_excel" class="btn btn-success"><span>EXPORT EXCEL</span></button></td> -->
                            </tr>                       
                        </table>
                        <table class="table table-striped table-bordered" id="data_table">
                        </table>
                    </div>
                    <div class="table-overflow">
                        <table class="table table-striped table-bordered" id="data_table_send">
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
