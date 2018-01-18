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

            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/lol/Events/BongDa/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=event_bongda_lol&func=add_gift&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Tên quà:</label>
                            <div class="controls">
                                <input name="gift_name" id="gift_name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hình ảnh:</label>
                            <div class="controls">
                                <input type="file" name="gift_img" />
                                (Ảnh không được lớn hơn 700KB)                            
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">ID quà:</label>
                            <div class="controls">
                                <input name="item_id" id="item_id" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Số lượng:</label>
                            <div class="controls">
                                <input name="item_count" id="item_count" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        
                        <div class="control-group frmedit">
                            <label class="control-label">Activity:</label>
                            <div class="controls">
                                <input name="gift_activity" id="gift_activity" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Position:</label>
                            <div class="controls">
                                <input name="gift_position" id="gift_position" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Điểm đổi:</label>
                            <div class="controls">
                                <input name="gift_price" id="gift_price" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="gift_status" id="gift_status_enable" value="1" checked="">
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="gift_status" id="gift_status_disable" value="0">
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button type="button" id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
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
