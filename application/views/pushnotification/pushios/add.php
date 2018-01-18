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
        .form-group {
            float: left;
            width: 22%;
        }
        .form-group input {
            width: 70%;
        }
        .form-horizontal .form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .form-horizontal .listItem .control-label{
            padding-right: 5px;
            width: 27% !important;
            color: green;
        }
        .form-horizontal .listItem .sublistItem .control-label{
            color: #f36926;
        }
        .form-horizontal .sublistItem{
            margin-left: 15px;
        }
        .remove_field,.remove_field_receive{
            cursor: pointer;
            color: green;
        }
        .input_fields .control-group{
            padding-top: 23px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }

        .input_fields_wrap .control-group .sublistItem .remove_sub{
            top:4px;
        }
        .loadContent{
            text-align: center;
            color: red;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
            color: #f36926 !important;
        }
        .form-horizontal .control-label{
            text-align: center;
        }
        .form-group.remove{
            width: 10%;
            position: relative;
            top:6px;
        }
        .subItems{
            margin-left: 20px;
        }
        .form-control[readonly]{
            cursor: not-allowed;
            background-color: #eee;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            if (/func=([^&]+)/.exec(window.location.href)[1] == "edit") {
                if (window.location.search.indexOf("id") != -1) {
                    add_option_package_name();
                }
            } else {
                $("#starttime").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});
            }

            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            $("#gameselect").on("change", function () {
                var data = $("#gameselect").val();
                var arr = data.split('-');
                $("#game").val(arr[0]);
                $("#id_projects").val(arr[1]);
                add_option_package_name();

            })

            $("#platform").on("change", function () {
                add_option_package_name();
            })

            function add_option_package_name() {
                var id_project = $("#id_projects").val();
                var platform = $("#platform").val();

                if (id_project == "" || platform == "") {
                    return false;
                }

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "/?control=push_notification&func=get_package_name&module=all",
                    data: {id_projects: id_project, platform: platform},
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    $('#package_name').empty();
                    $.each(result, function (i, item) {
                        $('#package_name').append($('<option>', {
                            value: item,
                            text: item
                        }));
                    });
                    $(".loading").fadeOut("fast");
                    if (/func=([^&]+)/.exec(window.location.href)[1] == "edit") {
                        if (window.location.search.indexOf("id") != -1) {
                            var package_name = "<?php echo $items['packageName']; ?>";
                            $("#package_name").val(package_name);
                        }
                    }
                })
            }

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;
                if (/func=([^&]+)/.exec(window.location.href)[1] == "edit") {
                    if (window.location.search.indexOf("id") != -1) {
                        var url = "/?control=push_notification&func=updateCategory&id=" + /id=([^&]+)/.exec(window.location.href)[1] +"&module=all";
                    }
                } else {
                    var url = "/?control=tool_push_notification&func=addCategory";
                }
                
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: url,
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    var message = result.message ? result.message:"Done";
                    $(".modal-body #messgage").html(message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                });
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/pushnotification/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <?php
                    if ($_GET['id'] > 0) {
                        $insertDate = date_format(date_create($items['insertDate']), "d-m-Y H:i:s");
                        $time = date_format(date_create($items['time']), "d-m-Y H:i:s");
//                            $game =  $items['game'] ? 'checked="checked"':'';
                        $game = $items['game'];
                        $message = $items['message'];
                        $platform = $items['platform'];
                        $packageName = $items['packageName'];
                    }
                    ?>

                    <div class="well form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Thời gian gửi:</label>
                            <div class="controls">
                                <?php if ($_GET['id'] > 0): ?>
                                    <div name="time"><?php echo $insertDate; ?></div>
                                <?php else: ?>
                                    <div id="starttime" name="time"><?php echo $insertDate; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Ứng dụng:</label>
                            <div class="controls">
                                <?php if ($_GET['id'] > 0): ?>
                                    <input name="game" type="hidden" value="<?php echo $slbScopes['servicekeyapp'] . "-" . $slbScopes['id'] ?>">
                                    <input value="<?php echo $slbScopes['namesetup']; ?>" type="text" disabled />
                                <?php else: ?>
                                    <select name="game" id="gameselect">
                                        <option value="">Chọn Ứng Dụng</option>
                                        <?php if (empty($slbScopes) !== TRUE): ?>
                                            <?php foreach ($slbScopes as $v): ?>
                                                <?php if ((@in_array($v['servicekeyapp'], $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>
                                                    <option value="<?php echo $v['servicekeyapp'] . "-" . $v['id']; ?>"><?php echo $v['namesetup']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hệ Điều Hành:</label>
                            <div class="controls">
                                <select name="platform" id="platform">
                                    <option value="">Chọn Hệ Điều Hành</option>
                                    <option value="android" <?php echo $platform == 'android' ? 'selected="selected"' : ''; ?>>Android</option>
                                    <option value="ios" <?php echo $platform == 'ios' ? 'selected="selected"' : ''; ?>>Ios</option>
                                    <option value="wp" <?php echo $platform == 'wp' ? 'selected="selected"' : ''; ?>>Wp</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Package Name:</label>
                            <div class="controls">
                                <select name="package_name" id="package_name">
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Tiêu đề thông điệp:</label>
                            <div class="controls">
                                <input name="message" class="form-control" value="<?php echo $items['message']; ?>" type="text" style="width: 80%" />
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                <input type="hidden" name='id_projects' value="<?php echo $slbScopes['id']; ?>" id="id_projects">
                                <input type="hidden" name='game' value="<?php echo $slbScopes['servicekeyapp']; ?>" id="game">
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