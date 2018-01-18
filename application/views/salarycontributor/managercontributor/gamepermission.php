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

            $('#comeback').on('click', function () {
                //window.location.href = '/?control=event_covu_pt&func=giaidau#giaidau';
                window.history.go(-1);
                return false;
            });

            //Load Games List
            $.ajax({
                method: "GET",
//                url: "/?control=managercontributor&func=loadgamelist",
                url: "http://mem.net.vn/cms/toolsalarycollaborator/games_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
//                    var obj = $.parseJSON(data);
                    var obj = (data);
                    var gameslist = "";
                    $.each(obj, function (key, value) {
                        gameslist += '<label><li><input type="checkbox" id="game_ids_' + value["id"] + '" value="' + value["id"] + '" name=game_ids[]> ' + value["name"] + '</li></label></br>';
                    });
                    $("#game_id").html(gameslist);
                    load_user_detail();
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            function load_user_detail() {
                $.ajax({
                    method: "GET",
                    url: "http://mem.net.vn/cms/toolsalarycollaborator/check_game_permission?id=" + $.urlParam('id'),
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        console.log(data["game_ids"]);
//                        obj2 = jQuery.parseJSON(data["game_ids"]);
                        obj = "[" + data["game_ids"] + "]";
                        obj2 = JSON.parse(obj);
                        $.each(obj2, function (key2, value2) {
//                        $('input:checkbox[id^="game_ids_"'+value2['id']+']').prop('checked', true);
                            $('#game_ids_' + value2).prop('checked', true);
                        });
                    },
                    error: function (data) {
                        var obj = $.parseJSON(data);
                    }
                });
            }
            $('#onSubmit').on('click', function () {
                data_post = $("#frmSendChest").serializeArray();
                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://mem.net.vn/cms/toolsalarycollaborator/userpermission",
                    data: data_post,
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    //console.log(result);
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");

                });
            });

            $.urlParam = function (name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                return results[1] || 0;
            }
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <div class="header_title icon48-install"><?php echo 'Phân quyền <span class="red">' . $user_permission . '</span>'; ?></div>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <div class="control-group">
                                <label class="control-label">Game Thao Tác:</label>
                                <div class="controls">
                                    <ul id="game_id">
                                    </ul>
                                </div>
                            </div>

                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                    <input type="hidden" name='name_user' value="<?php echo $user_permission ?>">
                                    <input type="hidden" name='id_user' value="<?php echo $_GET['id'] ?>">
                                    <button id="onSubmit" class="btn btn-primary"><span>Duyệt</span></button>
                                    <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                    <div style="display: inline-block">
                                        <span id="message" style="color: green"></span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
