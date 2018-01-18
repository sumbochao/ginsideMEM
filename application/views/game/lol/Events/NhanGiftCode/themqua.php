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
                <form id="frmSendChest" action="/?control=event_nhan_giftcode&func=add_gift&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <?php if($id != ''):?>
                        <div class="control-group frmedit">
                            <label class="control-label">Gift code:</label>
                            <div class="controls">
                                <input value="<?php echo $pack->giftcode;?>" name="giftcode" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Chưa sử dụng:<input type="radio" <?php if($pack->status == 1): ?> checked <?php endif?> name="status"  value="1" >
                                &nbsp;&nbsp;
                                Đã sử dụng:<input type="radio" <?php if($pack->status == 0): ?> checked <?php endif?>  name="status" value="0" >
                            </div>
                        </div>
                        <?php endif?>

                        <div class="control-group frmedit">
                            <label class="control-label">Type:</label>
                            <div class="controls">
                                <input value="<?php echo $pack->type;?>" name="type" type="text" class="span3 validate[required]" />
                            </div>
                        </div>



                        <?php if($id == ''):?>
                        <div class="control-group">
                            <label class="control-label">Upload gift code:</label>

                            <div class="controls">
                                <input type="file" name="listGiftCode"/>
                            </div>
                        </div>
                        <?php endif?>


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
