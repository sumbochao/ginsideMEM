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
                //window.location.href = '/?control=event_covu_pt&func=giaidau#giaidau';
                window.history.go(-1); return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "https://sev-cok.addgold.net/ToolchoinapMHKnhanKNB/add_tournament",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    //console.log(result);
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
            <?php include APPPATH . 'views/game/lg/GOK/Events/choinapMHKnhanKNB/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                                <i class=" ico-th-large"></i>THÊM MỚI SỰ KIỆN</h5>
                            <div class="control-group">
                                <label class="control-label">Tên sự kiện:</label>
                                <div class="controls">
                                    <input name="tournament_name" id="tournament_name" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Content ID:</label>
                                <div class="controls">
                                    <input name="content_id" id="content_id" type="text" class="span3" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Mail Title:</label>
                                <div class="controls">
                                    <input name="mail_title" id="mail_title" type="text" class="span3" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Mail content:</label>
                                <div class="controls">
                                    <input name="mail_content" id="mail_content" type="text" class="span3" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="catstatus" id="tournament_enable" value="1" checked="">
                                    &nbsp;&nbsp;
                                Disable:<input type="radio" name="catstatus" id="tournament_disable" value="0">
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
