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
                window.location.href = '/?control=managercontributor&func=manageitem&view=addedititem#themitem';
            });

            $("#game_filter").change(function () {
                window.location.href = "/?control=managercontributor&func=manageitem&view=approvalitem&game_id=" + $("#game_filter").val() + "#duyetitem";
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
            url = "http://mem.net.vn/cms/toolsalarycollaborator/get_item_by_game_id_not_approval?game_id=" + game_id + "&gamelistId=" + $gamelistId;
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
<?php if ((@in_array('managercontributor-manageitem-approvalitem', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>
                                {
                                    sTitle: "Duyệt Item",
                                    mData: "id",
                                    mRender: function (data, type, full) {
                                        return "<a class='btn btn-success btn-xs' href='/?control=managercontributor&func=manageitem&view=approvalitem&id=" + data + "&game_id=" + full.game_id + "#duyetitem'>Duyệt</a>";
                                    }
                                },
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
                            Chọn Game: <select id="game_filter" name="game_filter" class="span4" /></select>
                            <?php if ((@in_array('managercontributor-manageitem-addedititem', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>                        
                                <button id="create_reward"  class="btn btn-primary"><span>THÊM ITEM</span></button>
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