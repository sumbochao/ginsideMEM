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
        var $gamelistfullpermission = [];
        var $gamelistofcollaborator = [];

        $(document).ready(function () {

            $('#comeback').on('click', function () {
                //window.location.href = '/?control=event_covu_pt&func=giaidau#giaidau';
                window.history.go(-1);
                return false;
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
                        $gamelistfullpermission.push(value["id"]);
                    });

                    $("#game_filter").html(gamelist);

//                    var game_id = getParameterByName("game_id");
//                    if (game_id !== null && game_id !== "") {
//                        $("#game_filter").val(game_id);
//                    }

                    //Load User Details
                    load_user_detail(getParameterByName("id"));

                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                var checkgamelistcollaborator = false;
                for (var i = 0; i < $gamelistofcollaborator.length; i++) {
                    if ($("#game_filter").val() == $gamelistofcollaborator[i]) {
                        checkgamelistcollaborator = true;
                        break;
                    }
                }

                if (checkgamelistcollaborator == false) {
                    $(".modal-body #messgage").html("Cộng Tác Viên không cộng tác game này");
                    $('.bs-example-modal-sm').modal('show');
                    return false;
                }

                data_post = $("#frmSendChest").serializeArray();
                data_post.push({name: 'last_propose', value: '<?php echo $_SESSION['account']['username'] ?>'});

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://mem.net.vn/cms/toolsalarycollaborator/proposeeditsalary",
                    data: data_post,
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    console.log(result);
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                });
            });
        });

        function load_user_detail(id) {
            $.ajax({
                method: "GET",
                url: "http://mem.net.vn/cms/toolsalarycollaborator/get_user_by_id?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#id").val(data["id"]);
                    $("#mobo_id").val(data["mobo_id"]);
                    $("#name").val(data["name"]);

                    var obj2 = jQuery.parseJSON(data["game_ids"]);

                    $.each(obj2, function (key2, value2) {
                        $gamelistofcollaborator.push(value2['id']);
                    });

                    if (data["status"] == 1) {
                        $('#status_enable').prop('checked', true);
                    } else if (data["status"] == 0) {
                        $('#status_disable').prop('checked', true);
                    } else {
                        $('#status_lock').prop('checked', true);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
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
            <?php include APPPATH . 'views/salarycontributor/managercontributor/salary/tab_managesalary.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <i class=" ico-th-large"></i><?php echo $title ?></h5>
                        <div class="control-group">
                            <label class="control-label">Mobo ID:</label>
                            <div class="controls">
                                <input name="mobo_id" id="mobo_id" type="text" class="span3 validate[required,custom[onlyNumberSp]]" readonly/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Số Điểm Đề Xuất:</label>
                            <div class="controls">
                                <input name="salary_change" id="salary_change" type="text" class="span3 validate[required,custom[onlyNumberSp]]"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Chọn Game Đề Xuất:</label>
                            <div class="controls">
                                <select id="game_filter" name="game_filter" class="span3 validate[required]">
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Lý do:</label>
                            <div class="controls">
                                <textarea name="info_change" id="info_change" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;"></textarea>
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                <input type="hidden" name='id' id="id">
                                <input type="hidden" name='action' id="action" value="<?php echo $action ?>">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
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
