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
                <form id="frmSendChest" action="/?control=taixiu&func=add_tiencuoc&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">

                        <div class="control-group frmedit">
                            <label class="control-label">Mốc 1:</label>
                            <div class="controls">
                                <input value="<?php echo $pack->milestone1;?>" name="milestone1" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Mốc 2:</label>
                            <div class="controls">
                                <input value="<?php echo $pack->milestone2;?>" name="milestone2" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Mốc 3:</label>
                            <div class="controls">
                                <input value="<?php echo $pack->milestone3;?>" name="milestone3" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Mốc 4:</label>
                            <div class="controls">
                                <input value="<?php echo $pack->milestone4;?>" name="milestone4" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Mốc 5:</label>
                            <div class="controls">
                                <input value="<?php echo $pack->milestone5;?>" name="milestone5" type="text" class="span3 validate[required]" />
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
