<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
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
        .group_left,.group_right{
            width: 45%;
        }
        .group_left input,.group_right input{
            width: 80%;
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
                    url: "<?php echo $url_service;?>/cms/bangdau/edit_bangdau?id=1",
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
            <?php include APPPATH . 'views/game/lol/Events/bangdau/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <div class="group_left">
                            <div class="control-group">
                                <label class="control-label">Team 1:</label>
                                <div class="controls">
                                    <input name="team1" value="<?php echo $items['team1'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 2:</label>
                                <div class="controls">
                                    <input name="team2" value="<?php echo $items['team2'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 3:</label>
                                <div class="controls">
                                    <input name="team3" value="<?php echo $items['team3'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 4:</label>
                                <div class="controls">
                                    <input name="team4" value="<?php echo $items['team4'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Semifinal 1:</label>
                                <div class="controls">
                                    <input name="semifinal1" value="<?php echo $items['semifinal1'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Semifinal 2:</label>
                                <div class="controls">
                                    <input name="semifinal2" value="<?php echo $items['semifinal2'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Final 1:</label>
                                <div class="controls">
                                    <input name="final1" value="<?php echo $items['final1'];?>" type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="group_right">
                            <div class="control-group">
                                <label class="control-label">Team 5:</label>
                                <div class="controls">
                                    <input name="team5" value="<?php echo $items['team5'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 6:</label>
                                <div class="controls">
                                    <input name="team6" value="<?php echo $items['team6'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 7:</label>
                                <div class="controls">
                                    <input name="team7" value="<?php echo $items['team7'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 8:</label>
                                <div class="controls">
                                    <input name="team8" value="<?php echo $items['team8'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Semifinal 3:</label>
                                <div class="controls">
                                    <input name="semifinal3" value="<?php echo $items['semifinal3'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Semifinal 4:</label>
                                <div class="controls">
                                    <input name="semifinal4" value="<?php echo $items['semifinal4'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Final 2:</label>
                                <div class="controls">
                                    <input name="final2" value="<?php echo $items['final2'];?>" type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                        <div class="control-group">
                            <label class="control-label">Championship:</label>
                            <div class="controls">
                                <input name="championship" value="<?php echo $items['championship'];?>" type="text" style="width:80%;"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
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
    </div>
</div>