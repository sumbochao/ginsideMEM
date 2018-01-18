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
                    url: "<?php echo $url_service;?>/cms/tambao/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
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
            <?php include APPPATH . 'views/game/tank/Events/tambao/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                            <?php
                                $create_date = date('d-m-Y H:i:s',time());
                                if($_GET['id']>0){
                                    $create_date = date_format(date_create($items['create_date']),"d-m-Y H:i:s");
                                }
                            ?>
                            <div class="control-group">
                                <label class="control-label">Mobo ID:</label>
                                <div class="controls">
                                    <input name="moboid" id="moboid" value="<?php echo $items['moboid'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Character ID:</label>
                                <div class="controls">
                                    <input name="character_id" id="character_id" value="<?php echo $items['character_id'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Mobo Service ID:</label>
                                <div class="controls">
                                    <input name="mobo_service_id" id="mobo_service_id" value="<?php echo $items['mobo_service_id'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Character name:</label>
                                <div class="controls">
                                    <input name="character_name" id="character_name" value="<?php echo $items['character_name'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Server ID:</label>
                                <div class="controls">
                                    <input name="server_id" id="server_id" value="<?php echo $items['server_id'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Event ID:</label>
                                <div class="controls">
                                    <input name="event_id" id="event_id" value="<?php echo $items['event_id'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Money:</label>
                                <div class="controls">
                                    <input name="money" id="money" value="<?php echo $items['money'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Turn:</label>
                                <div class="controls">
                                    <input name="turn" id="turn" value="<?php echo $items['turn'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Flag money:</label>
                                <div class="controls">
                                    <input name="flag_money" id="flag_money" value="<?php echo $items['flag_money'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ngày tạo:</label>
                                <div class="controls">
                                    <input type="text" class="datetime" name="create_date" value="<?php echo $create_date;?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Num add:</label>
                                <div class="controls">
                                    <input type="text" class="num_add" name="num_add" value="<?php echo $items['num_add'];?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Check Ngày:</label>
                                <div class="controls">
                                    <input type="text" class="unique_day" name="unique_day" value="<?php echo $items['unique_day'];?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
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
<script>
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
    });
</script>