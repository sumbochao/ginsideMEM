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
        .error.item{
            padding-left: 0%;
            margin-top: 0px;
        }
        .receivegame{
            padding-top: 10px;
        }
        .remove_field{
            cursor: pointer;
        }
        .form-group{
            float: left;
            width: 20%;
        }
        .form-group.remove{
            width: 5%;
            color: green;
            cursor: pointer;
        }
        .form-group label{
            width: 35%;
        }
        .form-group input{
            width: 56%;
        }
        .listItem{
            margin-top: 10px;
        }
        .form-horizontal .form-group{
            margin-left: 0px;margin-right: 0px;
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
        .input_fields_wrap .control-group,.input_fields_wrap_receive .control-group{
            padding-top: 15px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; padding-top:15px; padding-bottom: 15px; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group,.input_fields_wrap_receive .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
        .input_fields_wrap .control-group .sublistItem,.input_fields_wrap_receive .control-group .sublistItem{
            border: 0px;
            margin-bottom: 0px;
            padding-bottom: 0px;
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
            top:7px;
        }
        .subItems{
            margin-left: 20px;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo $url_service; ?>/ToolnapKOKnhanKNB/<?php echo $_GET['id'] > 0 ? 'edit_filters?id=' . $_GET['id'] : 'add_filters'; ?>",
                                    data: {
                                        event_id: $("select[name=event_id]").val(),
                                        server_id: $("input[name=server_id]").val(),
                                        start: $("input[name=start]").val(),
                                        end: $("input[name=end]").val(),
                                        start_date_get_card_kok: $("input[name=start_date_get_card_kok]").val(),
                                        end_date_get_card_kok: $("input[name=end_date_get_card_kok]").val(),
                                        status: $("input:radio[name='status']:checked").val(),
                                    },
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
            <?php include APPPATH . 'views/game/lg/DPTK/Events/napKOKnhanKNB/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <h5 class="widget-name"><i class=" ico-th-large"></i><?php echo $title; ?></h5>
                        <?php
                        $statusOn = 'checked';
                        $start = date('d-m-Y H:i:s', time());
                        $end = date('d-m-Y H:i:s', time());
                        if ($_GET['id'] > 0) {
                            $start = date_format(date_create($items['start']), "d-m-Y H:i:s");
                            $end = date_format(date_create($items['end']), "d-m-Y H:i:s");
                            
                            $start_date_get_card_kok = date_format(date_create($items['start_date_get_card_kok']), "d-m-Y H:i:s");
                            $end_date_get_card_kok = date_format(date_create($items['end_date_get_card_kok']), "d-m-Y H:i:s");

                            $statusOn = $items['status'] == 1 ? 'checked="checked"' : '';
                            $statusOff = $items['status'] == 0 ? 'checked="checked"' : '';

                            $server_id = $items['server_id'];
                        }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Sự kiện:</label>
                            <div class="controls">
                                <select name="event_id" class="validate[required,custom[onlyNumberSp]]">
                                    <option value="">Chọn sự kiện</option>
                                    <?php
                                    if (count($slbEvent) > 0) {
                                        foreach ($slbEvent as $v) {
                                            ?>
                                            <option value="<?php echo $v['id']; ?>" <?php echo $v['id'] == $items['event_id'] ? 'selected="selected"' : ''; ?>><?php echo $v['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Máy chủ:</label>
                            <div class="controls">
                                <input name="server_id" id="server_id" value="<?php echo $items['server_id']; ?>" type="text" style="width: 80%"/>
                                </br>Cách nhau bởi dấu ','
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Bắt đầu:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="start" value="<?php echo $start; ?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kết thúc:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="end" value="<?php echo $end; ?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Áp dụng nạp thẻ bắt đầu:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="start_date_get_card_kok" value="<?php echo $start_date_get_card_kok; ?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Áp dụng nạp thẻ kết thúc:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="end_date_get_card_kok" value="<?php echo $end_date_get_card_kok; ?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="status" id="status" value="1" <?php echo $statusOn; ?>/>
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="status" id="status" value="0" <?php echo $statusOff; ?>/>
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
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
    $('.date').datepicker({
        dateFormat: 'dd-mm-yy',
    });
</script>