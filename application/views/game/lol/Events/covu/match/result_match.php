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
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#comeback').on('click', function () {
                window.history.go(-1); return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;
                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "<?php echo $url_service;?>/cms/covu/update_match?id=<?php echo $_GET['id'];?>",
                    data: $("#frmSendChest").serializeArray(),
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
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/lol/Events/covu/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <?php
                        $capDau = json_decode($items['capdau'],true);
                    ?>
                    <table style="width: 90%; margin: auto; font-size: 11px; font-weight: bold; margin-top: 10px; margin-bottom: 10px; border: 1px solid #7F7F7F; padding: 10px;" cellspacing="0" cellpadding="3">
                        <tbody>
                            <tr>
                                <td style="text-align: right; color: #D2143B; font-size: 13px;">
                                    <img id="match_team_img_a" width="100px" src="<?php echo $capDau['hinh_teama'];?>"><br>
                                </td>
                                <td style="width: 100px; text-align: center;">
                                    <img src="http://service.mgh.mobo.vn/assets/events/cacuoc/images/vs.png">
                                </td>
                                <td style="text-align: left; color: #D2143B; font-size: 13px;">
                                    <img id="match_team_img_b" width="100px" src="<?php echo $capDau['hinh_teamb'];?>"><br>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">
                                    Tỷ lệ thắng: <span id="match_team_win_rate_a"><?php echo $capDau['tyle_teama'];?></span>
                                </td>
                                <td style="text-align: center;">Kết thúc: <span id="match_end_date" style="color: #963810;"><?php echo date_format(date_create($items['end_covu']),"d-m-Y G:i:s");?></span></td>
                                <td style="text-align: left;">
                                    Tỷ lệ thắng: <span id="match_team_win_rate_b"><?php echo $capDau['tyle_teamb'];?></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">
                                    <input style="text-align: right;" name="result_teama" id="result_teama" value="<?php echo $capDau['result_teama'];?>" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                </td>
                                <td style="text-align: center;width: 200px;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                    <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                    <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                </td>
                                <td style="text-align: left;">
                                    <input name="result_teamb" id="result_teamb" type="text" value="<?php echo $capDau['result_teamb'];?>" class="span3 validate[required,custom[onlyNumberSp]]" />
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