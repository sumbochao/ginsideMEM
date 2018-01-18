<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        var $gamelistId = "";

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

            $('#create_reward').on('click', function () {
                window.location.href = '/?control=managercontributor&func=manageitem&view=addedititem#themitem';
            });

            $("#game_filter").change(function () {
                if (window.location.href.indexOf("game_id") == -1) {
                    window.location.href = "/" + window.location.search + "&game_id=" + $("#game_filter").val() + "#quanlyqua";
                } else {
                    var link = location.href.replace(/&?game_id=([^&]$|[^&]*)/i, "&game_id=" + $("#game_filter").val());
                    if (link.indexOf("quanlyqua") == -1) {
                        link = link + "#quanlyqua";
                    }
                    window.location.href = link;
                }
            });

            $("#status_filter").change(function () {
                if (window.location.href.indexOf("status") == -1) {
                    window.location.href = "/" + window.location.search + "&status=" + $("#status_filter").val() + "#quanlyqua";
                } else {
                    var link = location.href.replace(/&?status=([^&]$|[^&]*)/i, "&status=" + $("#status_filter").val());
                    if (link.indexOf("quanlyqua") == -1) {
                        link = link + "#quanlyqua";
                    }
                    window.location.href = link;
                }
            });

            $('#create_boxitem').on('click', function () {
                if (window.location.href.indexOf("startdate") == -1) {
                    window.location.href = "/" + window.location.search + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val() + "#quanlyqua";
                } else {
                    var link = location.href.replace(/&?startdate=([^&]$|[^&]*)/i, "&startdate=" + $("#startdate").val());
                    link = link.replace(/&?enddate=([^&]$|[^&]*)/i, "&enddate=" + $("#enddate").val());
                    if (link.indexOf("quanlyqua") == -1) {
                        link = link + "#quanlyqua";
                    }
                    window.location.href = link;
                }
            });

            //Load Game List
            $.ajax({
                method: "GET",
                url: "/?control=managercontributor&func=loadgamelist",
//                url: "http://mem.net.vn/cms/toolsalarycollaborator/games_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = $.parseJSON(data);
                    var gamelist = "<option value='' >Chọn Game</option>";
                    $.each(obj, function (key, value) {
                        gamelist += '<option value="' + value["id"] + '" >' + value["name"] + '</option>';
                        $gamelistId += value["id"] + ',';
                    });


                    $("#game_filter").html(gamelist);

                    var game_id = getParameterByName("game_id");
                    if (game_id !== null && game_id !== "") {
                        $("#game_filter").val(game_id);
                    }
                    getData($("#game_filter").val());
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });


        function getData(game_id) {
            if (getParameterByName("status") !== "") {
                $("#status_filter").val(getParameterByName("status"));
            }
            url = "http://mem.net.vn/cms/toolsalarycollaborator/get_item_by_game_id?game_id=" + game_id + "&gamelistId=" + $gamelistId + "&status=" + $("#status_filter").val() + "&startdate=" + $("#startdate").val() + "&enddate=" + $("#enddate").val();
            $.ajax({
                url: url,
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    var obj = data;
                    $('#data_table').dataTable({
                    "aaData": data
                            ,
                            aoColumns: [
                            {
                            sTitle: "Tên Item",
                                    mData: "item_name"
                            },
                            {
                            sTitle: "Loại",
                                    mData: "type",
                                    mRender: function (data) {
                                        if (data == 0) {
                                            return "<span style='color:green'>ITEM</span>";
                                        } else {
                                            return "<span style='color:red'>GIFTCODE</span>";
                                        }
                                    }
                            },
                            {
                            sTitle: "Số lượng Item",
                                    mData: "item_count"
                            },
                            {
                            sTitle: "Tỷ lệ hiển thị",
                                    mData: "item_rate"
                            },
                            {
                            sTitle: "Giới hạn của một user",
                                    mData: "limit_buy_user"
                            },
                            {
                            sTitle: "Giá",
                                    mData: "price"
                            },
                            {
                            sTitle: "Game",
                                    mData: "name"
                            },
                            {
                            sTitle: "Ngày Tạo",
                                    mData: "create_date"
                            },
                            {
                            sTitle: "Trạng Thái",
                                    mData: "status",
                                    mRender: function (data) {
                                        if (data == 1) {
                                            return "<span style='color:green'>Đã Duyệt</span>";
                                        } else if (data == 2) {
                                            return "<span style='color:red'>Khóa</span>";
                                        } else {
                                            return "<span style='color:red'>Chưa Duyệt</span>";
                                        }
                                    }
                            },
<?php if ((@in_array('managercontributor-manageitem-addedititem', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>
                                {
                                sTitle: "Chỉnh sửa Item",
                                        mData: "id",
                                        mRender: function (data, type, full) {
                                            return "<a class='btn btn-success btn-xs' href='/?control=managercontributor&func=manageitem&view=addedititem&id=" + data + "&game_id=" + full.game_id + "#quanlyitem'>Chỉnh Sửa</a>";
                                            }
                                }
<?php endif; ?>

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
                        <div style="margin-top: 10px; margin-bottom: 10px;">                           
                            Filter Game: <select id="game_filter" name="game_filter" class="span4" /></select>
                            Trạng thái: 
                            <select id="status_filter" name="status_filter" class="span4" />
                            <option value="">Tất cả</option>
                            <option value="0">Chưa duyệt</option>
                            <option value="1">Đã duyệt</option>
                            <option value="2">Khóa</option>
                            </select>
                            <?php if ((@in_array('managercontributor-manageitem-addedititem', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>                        
                                <button id="create_reward"  class="btn btn-primary"><span>THÊM ITEM</span></button>
                            <?php endif; ?>
                        </div>      
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