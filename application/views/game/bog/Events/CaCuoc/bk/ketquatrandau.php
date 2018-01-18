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
                window.location.href = '/cms/ep/toolcacuoc/trandau';
            });

            //Load Match Details
            var id = getParameterByName("id");
            if (id != null && id != "") {
                $(".loading").fadeIn("fast");
                $.ajax({
                    method: "GET",
                    url: "http://game.mobo.vn/phongthan/cms/toolcacuoc/load_match_details?id=" + id,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#id").val(data[0]["id"]);

                        $("#match_team_img_a").attr('src', data[0]["match_team_img_a"]);
                        $("#match_team_img_b").attr('src', data[0]["match_team_img_b"]);

                        $("#match_team_name_a").html(data[0]["match_team_name_a"]);
                        $("#match_team_name_b").html(data[0]["match_team_name_b"]);

                        $("#match_team_chap_a").html(data[0]["match_team_chap_a"]);
                        $("#match_team_chap_b").html(data[0]["match_team_chap_b"]);

                        $("#match_team_win_rate_a").html(data[0]["match_team_win_rate_a"]);
                        $("#match_team_win_rate_b").html(data[0]["match_team_win_rate_b"]);

                        $("#match_result_team_a").val(data[0]["match_result_team_a"])
                        $("#match_result_team_b").val(data[0]["match_result_team_b"])

                        $("#match_end_date").html(data[0]["match_end_date"]);

                        if (data[0]["match_result_status"] == "1") {
                            $('#onSubmit').hide();
                        }

                        $(".loading").fadeOut("fast");
                    },
                    error: function (data) {
                        var obj = $.parseJSON(data);
                    }
                });
            }
        });

        $(function () {
            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/phongthan/cms/toolcacuoc/update_match_result",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');                  
                    $(".loading").fadeOut("fast");

                    $('#onSubmit').hide();
                });
            });
        });

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
            <?php include APPPATH . 'views/game/pt/Events/CaCuoc/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <table style="width: 90%; margin: auto; font-size: 11px; font-weight: bold; margin-top: 10px; margin-bottom: 10px; border: 1px solid #7F7F7F; padding: 10px;" cellspacing="0" cellpadding="3">
                        <tbody>
                            <tr style="">
                                <td style="text-align: right; color: #D2143B; font-size: 13px;">
                                    <img id="match_team_img_a" width="100px" src="/assets/img/loading_large.gif"><br>
                                    <span id="match_team_name_a"></span></td>
                                <td style="width: 100px; text-align: center;">
                                    <img src="http://service.mgh.mobo.vn/assets/events/cacuoc/images/vs.png"></td>
                                <td style="text-align: left; color: #D2143B; font-size: 13px;">
                                    <img id="match_team_img_b" width="100px" src="/assets/img/loading_large.gif"><br>
                                    <span id="match_team_name_b"></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Chấp: <span id="match_team_chap_a"></span>
                                    <br>
                                    Tỷ lệ thắng: <span id="match_team_win_rate_a"></span></td>
                                <td style="text-align: center;">Kết thúc: <span id="match_end_date" style="color: #963810;"></span></td>
                                <td style="text-align: left;">Chấp: <span id="match_team_chap_b"></span>
                                    <br>
                                    Tỷ lệ thắng: <span id="match_team_win_rate_b"></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">
                                    <input style="text-align: right;" name="match_result_team_a" id="match_result_team_a" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                </td>
                                <td style="text-align: center;width: 200px;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                    <input type="hidden" name='id' id="id">
                                    <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                    <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button></td>
                                <td style="text-align: left;">
                                    <input name="match_result_team_b" id="match_result_team_b" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
