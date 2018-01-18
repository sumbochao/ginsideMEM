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
                    url: "<?php echo $url_service;?>/cms/bangdau/edit_bangdauv1?id=1",
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
                                <label class="control-label">Team 9:</label>
                                <div class="controls">
                                    <input name="team9" value="<?php echo $items['team9'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 10:</label>
                                <div class="controls">
                                    <input name="team10" value="<?php echo $items['team10'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 11:</label>
                                <div class="controls">
                                    <input name="team11" value="<?php echo $items['team11'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 12:</label>
                                <div class="controls">
                                    <input name="team12" value="<?php echo $items['team12'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 13:</label>
                                <div class="controls">
                                    <input name="team13" value="<?php echo $items['team13'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 14:</label>
                                <div class="controls">
                                    <input name="team14" value="<?php echo $items['team14'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 15:</label>
                                <div class="controls">
                                    <input name="team15" value="<?php echo $items['team15'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 16:</label>
                                <div class="controls">
                                    <input name="team16" value="<?php echo $items['team16'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 1:</label>
                                <div class="controls">
                                    <input name="vongloai1" value="<?php echo $items['vongloai1'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 2:</label>
                                <div class="controls">
                                    <input name="vongloai2" value="<?php echo $items['vongloai2'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 3:</label>
                                <div class="controls">
                                    <input name="vongloai3" value="<?php echo $items['vongloai3'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 4:</label>
                                <div class="controls">
                                    <input name="vongloai4" value="<?php echo $items['vongloai4'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 5:</label>
                                <div class="controls">
                                    <input name="vongloai5" value="<?php echo $items['vongloai5'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 6:</label>
                                <div class="controls">
                                    <input name="vongloai6" value="<?php echo $items['vongloai6'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 7:</label>
                                <div class="controls">
                                    <input name="vongloai7" value="<?php echo $items['vongloai7'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 8:</label>
                                <div class="controls">
                                    <input name="vongloai8" value="<?php echo $items['vongloai8'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bán kết 1:</label>
                                <div class="controls">
                                    <input name="banket1" value="<?php echo $items['banket1'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bán kết 2:</label>
                                <div class="controls">
                                    <input name="banket2" value="<?php echo $items['banket2'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bán kết 3:</label>
                                <div class="controls">
                                    <input name="banket3" value="<?php echo $items['banket3'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bán kết 4:</label>
                                <div class="controls">
                                    <input name="banket4" value="<?php echo $items['banket4'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tứ kết 1:</label>
                                <div class="controls">
                                    <input name="tuket1" value="<?php echo $items['tuket1'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tứ kết 2:</label>
                                <div class="controls">
                                    <input name="tuket2" value="<?php echo $items['tuket2'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Chung kết 1:</label>
                                <div class="controls">
                                    <input name="chungket1" value="<?php echo $items['chungket1'];?>" type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="group_right">
                            <div class="control-group">
                                <label class="control-label">Team 17:</label>
                                <div class="controls">
                                    <input name="team17" value="<?php echo $items['team17'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 18:</label>
                                <div class="controls">
                                    <input name="team18" value="<?php echo $items['team18'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 19:</label>
                                <div class="controls">
                                    <input name="team19" value="<?php echo $items['team19'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 20:</label>
                                <div class="controls">
                                    <input name="team20" value="<?php echo $items['team20'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 21:</label>
                                <div class="controls">
                                    <input name="team21" value="<?php echo $items['team21'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 22:</label>
                                <div class="controls">
                                    <input name="team22" value="<?php echo $items['team22'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 23:</label>
                                <div class="controls">
                                    <input name="team23" value="<?php echo $items['team23'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 24:</label>
                                <div class="controls">
                                    <input name="team24" value="<?php echo $items['team24'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 25:</label>
                                <div class="controls">
                                    <input name="team25" value="<?php echo $items['team25'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 26:</label>
                                <div class="controls">
                                    <input name="team26" value="<?php echo $items['team26'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 27:</label>
                                <div class="controls">
                                    <input name="team27" value="<?php echo $items['team27'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 28:</label>
                                <div class="controls">
                                    <input name="team28" value="<?php echo $items['team28'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 29:</label>
                                <div class="controls">
                                    <input name="team29" value="<?php echo $items['team29'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 30:</label>
                                <div class="controls">
                                    <input name="team30" value="<?php echo $items['team30'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 31:</label>
                                <div class="controls">
                                    <input name="team31" value="<?php echo $items['team31'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Team 32:</label>
                                <div class="controls">
                                    <input name="team32" value="<?php echo $items['team32'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 9:</label>
                                <div class="controls">
                                    <input name="vongloai9" value="<?php echo $items['vongloai9'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 10:</label>
                                <div class="controls">
                                    <input name="vongloai10" value="<?php echo $items['vongloai10'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 11:</label>
                                <div class="controls">
                                    <input name="vongloai11" value="<?php echo $items['vongloai11'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 12:</label>
                                <div class="controls">
                                    <input name="vongloai12" value="<?php echo $items['vongloai12'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 13:</label>
                                <div class="controls">
                                    <input name="vongloai13" value="<?php echo $items['vongloai13'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 14:</label>
                                <div class="controls">
                                    <input name="vongloai14" value="<?php echo $items['vongloai14'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 15:</label>
                                <div class="controls">
                                    <input name="vongloai15" value="<?php echo $items['vongloai15'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vòng loại 16:</label>
                                <div class="controls">
                                    <input name="vongloai16" value="<?php echo $items['vongloai16'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bán kết 5:</label>
                                <div class="controls">
                                    <input name="banket5" value="<?php echo $items['banket5'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bán kết 6:</label>
                                <div class="controls">
                                    <input name="banket6" value="<?php echo $items['banket6'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bán kết 7:</label>
                                <div class="controls">
                                    <input name="banket7" value="<?php echo $items['banket7'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bán kết 8:</label>
                                <div class="controls">
                                    <input name="banket8" value="<?php echo $items['banket8'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tứ kết 3:</label>
                                <div class="controls">
                                    <input name="tuket3" value="<?php echo $items['tuket3'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tứ kết 4:</label>
                                <div class="controls">
                                    <input name="tuket4" value="<?php echo $items['tuket4'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Chung kết 2:</label>
                                <div class="controls">
                                    <input name="chungket2" value="<?php echo $items['chungket2'];?>" type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                        <div class="control-group">
                            <label class="control-label">Vô địch:</label>
                            <div class="controls">
                                <input name="vodich" value="<?php echo $items['vodich'];?>" type="text" style="width:80%;"/>
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