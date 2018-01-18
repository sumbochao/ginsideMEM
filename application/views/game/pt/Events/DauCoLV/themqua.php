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
                window.history.go(-1); return false;
            });

            $('#frmSendChest').ajaxForm({
                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function (data) {
                    if ($('#frmSendChest').validationEngine('validate') === false)
                        return false;

                    $(".loading").fadeIn("fast");
                    json_data = $.parseJSON(data);
                    if (json_data.status == 0) {
                        $(".modal-body #messgage").html(json_data.msg);
                        $('.bs-example-modal-sm').modal('show');
                        $(".loading").fadeOut("fast");
                    }else if (json_data.status == 1) {
                        $(".modal-body #messgage").html(json_data.msg);
                        $('.bs-example-modal-sm').modal('show');
                        $(".loading").fadeOut("fast");
                    }
                }
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/pt/Events/DauCoLV/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=event_dau_co_lv&func=add_gift" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <div class="control-group frmedit">
                            <label class="control-label">Level:</label>
                            <div class="controls">
                                <input value="<?php echo $level;?>" name="level" id="level" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Vàng:</label>
                            <div class="controls">
                                <input value="<?php echo $vang;?>" name="vang" id="vang" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button type="button" id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id;?>">
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
