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
            $('#create_reward').on('click', function () {
                window.location.href = '/?control=managercontributor&func=adduser#themctv';
            });

            $("#game_id").change(function () {
                window.location.href = "/?control=managercontributor&func=index&game_id=" + $("#game_id").val() + "#index";
            });

            //Load Games List
            $.ajax({
                method: "GET",
                url: "/?control=managercontributor&func=loadgamelist",
//                url: "http://mem.net.vn/cms/toolsalarycollaborator/games_list?user_id=<?php echo $_SESSION['account']['username'] ?>",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = $.parseJSON(data);
                    var gameslist = "<option value='' >Chọn Game</option>";
                    $.each(obj, function (key, value) {
                        gameslist += '<option value="' + value["id"] + '" >' + value["name"] + '</option>';
                        $gamelistId += value["id"] + ',';
                    });

                    $("#game_id").html(gameslist);

                    var game_id = getParameterByName("game_id");
                    if (game_id !== null && game_id !== "") {
                        $("#game_id").val(game_id);
                    }

                    getData($("#game_id").val());

                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });


        function getData(game_id) {
            url = "http://mem.net.vn/cms/toolsalarycollaborator/get_user?game_id=" + game_id + "&gamelistId=" + $gamelistId;
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
                    "aaData": obj
                            ,
                            aoColumns: [
                            {
                            sTitle: "Mobo ID",
                                    mData: "mobo_id"
                            },
                            {
                            sTitle: "Tên",
                                    mData: "name"
                            },
                            {
                            sTitle: "Games List",
                                    mData: "game_ids",
                                    mRender: function (data) {
                                        obj2 = jQuery.parseJSON(data);
                                        var html = "";
                                        $.each(obj2, function (key2, value2) {
                                            html = html + value2["name"] + "(" + value2["id"] + ")</br>";
                                        });
                                        return html;
                                    }
                            },
                            {
                            sTitle: "Ngày Tạo",
                                    mData: "create_date"
                            },
                            {
                            sTitle: "Ngày Cập Nhật",
                                    mData: "update_date"
                            },
                            {
                            sTitle: "Trạng Thái",
                                    mData: "status",
                                    mRender: function (data) {
                                        var html = "";
                                        if (data == 1) {
                                            html = "<span style='color:green'>Hoạt Động</span>";
                                        } else if (data == 0) {
                                            html = "<span style='color:#8D38C9'>Chờ Duyệt</span>";
                                        } else {
                                            html = "<span style='color:red'>Đang Khóa</span>";
                                        }
                                        return html;
                                    }
                            },
                            {
                            sTitle: "Số dư hiện tại",
                                    mData: "balance"
                            },
                            {
                            sTitle: "Số dư trước",
                                    mData: "last_balance"
                            },
                            {
                            sTitle: "Người tạo",
                                    mData: "creator"
                            },
                            {
                            sTitle: "Người duyệt",
                                    mData: "last_approved"
                            },
                            {
                            sTitle: "Ngày Duyệt",
                                    mData: "date_approved",
                            },
<?php if ((@in_array('managercontributor-edituser', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>
                                {
                                sTitle: "Tùy Chọn",
                                        mData: "id",
                                        mRender: function (data) {
                                            return "<a class='btn btn-success btn-xs' href='/?control=managercontributor&func=edituser&id=" + data + "#chinhsuactv'>Chỉnh Sửa</a>";
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
            <?php include APPPATH . 'views/salarycontributor/managercontributor/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">                           
                            Games: 
                            <select id="game_id" name="game_id" class="span4 validate[required]" />

                            </select>
                            <?php if ((@in_array('managercontributor-adduser', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>                        
                                <button id="create_reward"  class="btn btn-primary"><span>ĐỀ XUẤT CỘNG TÁC VIÊN</span></button>
                            <?php endif; ?>
                        </div>                               
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