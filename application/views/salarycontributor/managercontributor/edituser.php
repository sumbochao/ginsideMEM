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
        .plus-game{
            font-size: 25px;
            padding: 0 7px;
            text-decoration: none;
            border: 1px solid black;
            border-radius: 8px;
            cursor:pointer;
        }
        .plus-game:hover{
            text-decoration: none;
        }
        .minus-game{
            font-size: 25px;
            padding: 0 7px;
            text-decoration: none;
            border: 1px solid black;
            border-radius: 8px;
            cursor:pointer;
        }
        .minus-game:hover{
            text-decoration: none;
        }
        /*        .remove-game{
                    font-size: 25px;
                    padding: 0 7px;
                    text-decoration: none;
                    border: 1px solid black;
                    border-radius: 8px;
                    cursor:pointer;
                }
                .remove-game:hover{
                    text-decoration: none;
                }*/
    </style>
    <script type="text/javascript">
        var aGameslist;
        $(document).ready(function () {

            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });
            //Load Games List
            $.ajax({
                method: "GET",
                url: "/?control=managercontributor&func=loadgamelist",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = $.parseJSON(data);
                    aGameslist = obj;
                    //Load User Details
                    load_user_detail(getParameterByName("id"));
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            $(document).on('click', '.plus-game', function () {
                plusgame($(this));
            });

            function plusgame(e, removefisrtrow) {
                var count = e.data("count");
                if ($('#game_id' + count).val() == "") {
                    $(".modal-body #messgage").html("Vui lòng chọn game trước khi add thêm");
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                    return false;
                } else if ($("select[id^='game_id']").length == 1 || Object.keys(aGameslist).length == 0) {
                    $('#game_id' + count).prop("disabled", true);
                    if (e.parent().find('a.minus-game').length == 0) {
                        var remove = '<a class="minus-game" data-count="' + count + '">-</a>';
                        e.after(remove);
                    }
                }

                var valueIdName = e.parent().find('#game_id' + count).val();
                $('#game_id' + count).attr('disabled', 'disabled');
                var gameslist = '<option value="">Chọn Games</option>';
                $.each(aGameslist, function (key, value) {
                    if (typeof (value) == "undefined") {
                        return true;
                    }
                    if (valueIdName != value["id"] + '-' + value["name"]) {
                        gameslist += '<option value="' + value["id"] + '-' + value["name"] + '">' + value["name"] + '</option>';
                    } else {
                        delete(aGameslist[key]);
                    }
                });
                if (Object.keys(aGameslist).length != 0 || removefisrtrow) {
                    var count2 = count + 1;
                    var html = '<div class="controls">'
                            + '<select id="game_id' + (count2) + '" name="game_ids[]" class="span4" style="margin-right: 5px;"></select>'
                            + '<input name="quota[]" id="quota' + (count2) + '" type="text" placeholder="Quota" class="span3 validate[required]" style="margin-right: 5px;">'
                            + '<a class="minus-game" data-count="' + (count2) + '" style="margin-right: 5px;">-</a>'
                            + '<a class="plus-game" data-count="' + (count2) + '" style="margin-right: 5px;">+</a></div>';
                    $('.add-more-games').before(html);
                    $("#game_id" + count2).html(gameslist);
                }
                if (removefisrtrow) {
                    var check = e.parent().find('a.minus-game');
                    minusgame(check);
                }
                e.remove();
            }

            $(document).on('click', '.minus-game', function () {
                minusgame($(this));
            });

            function minusgame(e) {
                var count = e.data("count");
                var valueIdName = e.parent().find('#game_id' + count).val();

                var checkdropdowndisabled = e.parent().find("select[id^='game_id']").prop("disabled");
                if ($("select[id^='game_id']").length == 1) {
                    if (e.parent().find('a.plus-game').length == 0) {
                        e.text("+");
                        e.removeClass('minus-game');
                        e.addClass('plus-game');
                    } else {
                        e.remove();
                    }

                    if (checkdropdowndisabled) {
                        var check = $("select[id^='game_id']").parent().find('a.plus-game');
                        plusgame(check, removefisrtrow = true);
                    }
                    return false;
                } else {
                    $.ajax({
                        method: "GET",
                        url: "/?control=managercontributor&func=loadgamelist",
                        contentType: 'application/json; charset=utf-8',
                        success: function (data) {
                            var obj = $.parseJSON(data);
                            $.each(obj, function (key, value) {
                                if (valueIdName == value["id"] + '-' + value["name"]) {
                                    aGameslist[key] = value;
                                    var gameslist = '';
                                    gameslist += '<option value="' + value["id"] + '-' + value["name"] + '">' + value["name"] + '</option>';
                                    var flag_check_dropdown = false;
                                    $("select[id^='game_id']").each(function () {
                                        var $this = $(this);
                                        if ($this.prop("disabled") == false) {
                                            $this.append(gameslist);
                                            flag_check_dropdown = true;
                                            return false;
                                        }
                                    })

                                    return false;
                                }
                            });
                        },
                        error: function (data) {
                            var obj = $.parseJSON(data);
                        }
                    });
                }
                e.parent().remove();
                var count2 = $("select[id^='game_id']").last().parent().find("a.minus-game").data("count");
                if ($("select[id^='game_id']").last().parent().find("a.plus-game").length == 0) {
                    $("select[id^='game_id']").last().parent().find("a.minus-game").after('<a class="plus-game" data-count="' + (count2) + '" style="margin-right: 5px;">+</a>')
                }
                return false;

            }

            $('#onSubmit').on('click', function () {

                $("select[id^='game_id']").each(function () {
                    var $this = $(this);
                    if ($this.val() == "") {
                        $(".modal-body #messgage").html("Vui lòng chọn game");
                        $('.bs-example-modal-sm').modal('show');
                        $(".loading").fadeOut("fast");
                        return false;
                    }
                })
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $('select').removeAttr('disabled');
                data_post = $("#frmSendChest").serializeArray();
                data_post.push({name: 'last_approved', value: '<?php echo $_SESSION['account']['username'] ?>'});
                array_permission = [];
<?php if ($_SESSION['account']['id_group'] != 1): ?>
    <?php
    $php_array = $_SESSION['permission'];
    $js_array = json_encode($php_array, true);
    echo "obj = " . $js_array . ";\n";
    ?>
                    array_permission = Object.keys(obj).map(function (key) {
                        return obj[key];
                    });
<?php endif; ?>
                data_post.push({name: 'list_game_have_permission', value: array_permission});
                data_post.push({name: 'user_id', value: '<?php echo $_SESSION['account']['id'] ?>'});

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://mem.net.vn/cms/toolsalarycollaborator/edituser",
                    data: data_post,
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    $('select').attr('disabled', 'disabled');
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
                    obj2 = jQuery.parseJSON(data["game_ids"]);
                    $.each(obj2, function (key2, value2) {
                        if (typeof (value2) == "undefined") {
                            return true;
                        }
                        var checkgame = false;
                        $.each(aGameslist, function (key3, value3) {
                            if (value2['id'] == value3['id']) {
                                checkgame = true;
                                return false;
                            }
                        });
                        if (checkgame == false) {
                            delete(obj2[key2]);
                        }
                    });

                    var gameslist;
                    $.each(aGameslist, function (key3, value3) {
                        gameslist += '<option value="' + value3["id"] + '-' + value3["name"] + '">' + value3["name"] + '</option>';
                    });
                    $.each(obj2, function (key2, value2) {
                        if (typeof (value2) == "undefined") {
                            return true;
                        }
                        var count2 = key2;
                        var html = '<div class="controls"><select id="game_id' + (count2) + '" name="game_ids[]" class="span4" disabled="disabled" style="margin-right: 5px;"></select><input name="quota[]" id="quota' + (count2) + '" type="text" placeholder="Quota" class="span3 validate[required]" style="margin-right: 5px;"><a class="minus-game" data-count="' + (count2) + '" style="margin-right: 5px;">-</a></div>';
                        $('.add-more-games').before(html);
                        $("#game_id" + count2).html(gameslist);
                        $("#game_id" + count2).val('' + value2["id"] + '-' + value2["name"] + '');
                        $("#quota" + count2).val(value2["quota"]);
                        $.each(aGameslist, function (key3, value3) {
                            if (typeof (value3) == "undefined") {
                                return true;
                            }
                            if (value2['id'] == value3['id']) {
                                delete(aGameslist[key3]);
                            }
                        });
                    });
                    var count = $("select[id^='game_id']").last().parent().find('a').data('count');
                    $("select[id^='game_id']").last().parent().find('a').after('<a class="plus-game" data-count="' + (count) + '" style="margin-right: 5px;">+</a>');

                    if ($("select[id^='game_id']").length == 1) {
                        $("select[id^='game_id']").last().removeAttr('disabled');
                    }
//                    if (Object.keys(aGameslist).length <= 1) {
//                        var valueIdName = $("select[id^='game_id']").last().parent().find('#game_id' + count).val();
//                        $.each(aGameslist, function (key, value) {
//                            if (typeof (value) == "undefined") {
//                                return true;
//                            }
//                            if (valueIdName != value["id"] + '-' + value["name"]) {
//                                gameslist += '<option value="' + value["id"] + '-' + value["name"] + '">' + value["name"] + '</option>';
//                            } else {
//                                delete(aGameslist[key]);
//                            }
//                        });
//                        if (Object.keys(aGameslist).length != 0) {
//                            var count2 = count + 1;
//                            var html = '<div class="controls"><select id="game_id' + (count2) + '" name="game_ids[]" class="span4" style="margin-right: 5px;"></select><input name="quota[]" id="quota' + (count2) + '" type="text" placeholder="Quota" class="span3 validate[required]" style="margin-right: 5px;"><a class="remove-game" data-count="' + (count2) + '" style="margin-right: 5px;">-</a><a class="plus-game" data-count="' + (count2) + '" style="margin-right: 5px;">+</a></div>';
//                            $('.add-more-games').before(html);
//                            $("#game_id" + count2).html(gameslist);
//                        }
//                    }
//                    $("select[id^='game_id']").last().parent().find('a').text("+");

//                    $.each(obj2, function (key2, value2) {
////                        $('input:checkbox[id^="game_ids_"'+value2['id']+']').prop('checked', true);
//                        $('#game_ids_' + value2['id']).prop('checked', true);
//                    });

                    //check neu chi con 1 dropbox thi khong disable
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
            <?php include APPPATH . 'views/salarycontributor/managercontributor/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <i class=" ico-th-large"></i>CHỈNH SỬA THÔNG TIN CỘNG TÁC VIÊN</h5>
                        <div class="control-group">
                            <label class="control-label">Mobo ID:</label>
                            <div class="controls">
                                <input name="mobo_id" id="mobo_id" type="text" class="span3 validate[required,custom[onlyNumberSp]]" readonly/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Tên CTV:</label>
                            <div class="controls">
                                <input name="name" id="name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Game Cộng tác:</label>
                            <div class="add-more-games"></div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                ĐỀ XUẤT: <input type="radio" name="status" id="status_disable" value="0" checked="">
                                &nbsp;&nbsp;
                                DUYỆT: <input type="radio" name="status" id="status_enable" value="1">
                                &nbsp;&nbsp;
                                KHÓA: <input type="radio" name="status" id="status_lock" value="2">
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                <input type="hidden" name='id' id="id">
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
