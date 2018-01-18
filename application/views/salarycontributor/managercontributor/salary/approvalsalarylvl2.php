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

            $("#game_filter").change(function () {
                window.location.href = "/?control=managercontributor&func=managesalary&view=approvalsalarylvl2&game_id=" + $("#game_filter").val() + "#duyetluong2";
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
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        function getData(game_id) {
            $.ajax({
                url: "http://mem.net.vn/cms/toolsalarycollaborator/get_approval_history_lvl2?game_id="+ game_id +"&gamelistId=" +$gamelistId,
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
                                sTitle: "Số dư hiện tại",
                                mData: "balance"
                            },
                            {
                                sTitle: "Số điểm đề xuất",
                                mData: "salary_change"
                            },
                            {
                                sTitle: "Người đề xuất",
                                mData: "last_propose"
                            },
                            {
                                sTitle: "Ngày đề xuất",
                                mData: "created_date"
                            },
                            {
                                sTitle: "Game đề xuất",
                                mData: "game_name"
                            },
                            {
                                sTitle: "Thông tin đề xuất",
                                mData: "info_propose"
                            },
                            {
                                sTitle: "Người duyệt lần 1",
                                mData: "last_approved_salary"
                            },
                            {
                                sTitle: "Ngày duyệt lần 1",
                                mData: "update_date"
                            },
                            {
                                sTitle: "Thông tin duyệt lần 1",
                                mData: "info_approved"
                            },
                            {
                                sTitle: "Loại đề xuất",
                                mData: "type_propose",
                                mRender: function (data) {
                                    var html = "";
                                    if (data == 0) {
                                        html = "<span style='color:green'>Cộng lương</span>";
                                    } else {
                                        html = "<span style='color:red'>Trừ lương</span>";
                                    }
                                    return html;
                                }
                            },
                            //
                            {
                                sTitle: "Duyệt Cấp 2",
                                mData: "id",
                                mRender: function (data) {
                                    var button = "";
<?php if ((@in_array('managercontributor-managesalary-approvalsalarylvl2', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>
                                        button += "<a class='btn btn-success btn-xs' href='/?control=managercontributor&func=managesalary&view=approvalsalarylvl2&id=" + data + "#duyetluong2'>Duyệt chi tiết</a>";
<?php endif; ?>
                                    return button;

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
                }
            });
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">          
            <?php include APPPATH . 'views/salarycontributor/managercontributor/salary/tab_managesalary.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">                           
                            Chọn Game: <select id="game_filter" name="game_filter" class="span4" /></select>
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