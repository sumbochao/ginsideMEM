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


            //Set DateTime Format
            $("#date_start").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#date_end").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            var date_start = '<?php echo $date_start; ?>';
            $('#date_start').jqxDateTimeInput('setDate', date_start);
            var date_end = '<?php echo $date_end; ?>';
            $('#date_end').jqxDateTimeInput('setDate', date_end);

            $('#comeback').on('click', function () {
                window.history.go(-1); return false;
            });

            $('#onSubmit').click(function(){
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                $('#frmSendChest').ajaxForm(function (data) {
                    $(".modal-body #messgage").html(data);
                    $('.bs-example-modal-sm').modal('show');
                    $('#frmSendChest').clearForm();
                    $(".loading").fadeOut("fast");
                });
            })
        });

    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">

            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=event_gio_vang&func=addConfig&module=all" method="POST" enctype="multipart/form-data">
                        <div class="control-group">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input name="name" value="<?php echo $name; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Bắt đầu:</label>
                            <div class="controls">
                                <div id="date_start" name="date_start"></div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kết thúc:</label>
                            <div class="controls">
                                <div id="date_end" name="date_end"></div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" <?php if($status == 1): ?> checked <?php endif?> name="status"  value="1" >
                                &nbsp;&nbsp;
                                Disable:<input type="radio" <?php if($status == 0): ?> checked <?php endif?>  name="status" value="0" >
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Server:</label>
                            <div class="controls">
                                <textarea name="server_list" id="server_list" type="text" class="span3 validate[required]" style="margin: 0px; width: 295px; height: 60px;"><?php echo $server_list ?></textarea>
                                (ID Server cách nhau dấu ",")
                            </div>
                        </div>

<!--                        <div class="control-group">-->
<!--                            <label class="control-label">Nhóm IP:</label>-->
<!--                            <div class="controls">-->
<!--                                <textarea name="ip_list" id="ip_list" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;">--><?php //echo $ip_list ?><!--</textarea>-->
<!--                                (Dãy IP cách nhau dấu ";")-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="control-group">-->
<!--                            <label class="control-label">Gói quà:</label>-->
<!--                            <div class="controls">-->
<!--                                <select class="validate[required]" name="packages[]" multiple>-->
<!--                                    --><?php //if(count($packages) > 0): ?>
<!--                                        --><?php //foreach($packages as $package): ?>
<!--                                            <option --><?php //if(is_array($package_id_array) && in_array($package->id, $package_id_array)) echo 'selected'; ?><!--  value="--><?php //echo $package->id; ?><!--">--><?php //echo $package->name; ?><!--</option>-->
<!--                                        --><?php //endforeach ?>
<!--                                    --><?php //endif ?>
<!--                                </select>-->
<!--                                (Nhấn giữ Shift để có thể chọn nhiều gói quà)-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button type="button" id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                <input type="hidden" name="game" value="<?php echo $game;?>">
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>

