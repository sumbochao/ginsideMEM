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
        $(function () {
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
            <?php include APPPATH . 'views/game/mu/Events/TangQuaBanBe/tab.php'; ?>
            <div class="widget-name">              
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=tangquabanbe_mu&module=all&func=add_tangquabanbe_gift_send" method="POST" enctype="multipart/form-data">
                        <div class="widget row-fluid">
                            <div class="well form-horizontal">
                                <h5 class="widget-name">
                                <i class=" ico-th-large"></i>THÊM QUÀ MỚI</h5>
                                
                                <div class="control-group">
                                    <label class="control-label">Tên Item:</label>
                                    <div class="controls">
                                        <input name="item_name" id="item_name" type="text" class="span4 validate[required] use_for_count_input" />
                                    </div>
                                </div>
                               
                                <div class="control-group">
                                    <label class="control-label">Item ID:</label>
                                    <div class="controls">
                                        <input name="item_id" id="item_id" type="text" class="span3 validate[required]" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Số lượng:</label>
                                    <div class="controls">
                                        <input name="item_quantity" id="item_quantity" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Trạng thái:</label>
                                    <div class="controls">
                                    Enable:<input type="radio" name="catstatus" id="enable" value="1" checked="">
                                        &nbsp;&nbsp;
                                    Disable:<input type="radio" name="catstatus" id="disable" value="0">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div style="padding-left: 20%; text-align: left;">
                                        <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                        <input type="hidden" name='id' id="id">
                                        <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                         <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>                                        
                                        <div style="display: inline-block">
                                            <span id="message" style="color: green"></span>
                                        </div>
                                    </div>
                                </div>
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
