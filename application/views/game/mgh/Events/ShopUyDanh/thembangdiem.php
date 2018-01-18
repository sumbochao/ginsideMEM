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
            });

            $('#add-item').click(function(){
                var clone = $('.panel:last').clone();
                clone.appendTo('#items');
            });

            $('#remove-item').click(function(){
                if($('.panel').length > 1)
                    $('.panel:last').remove();
            });
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
                <form id="frmSendChest" action="/?control=shopuydanh&func=add_bangdiem&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <?php if($type == 'level'):?>
                        <div id="items">
                            <div class = "panel panel-default">
                                <div class = "panel-body">
                                    <div class="control-group frmedit">
                                        <label class="control-label">Start Level:</label>
                                        <div class="controls">
                                            <input value="<?php echo $pack->start_level;?>" name="start_level[]" type="text" class="span3 validate[required]" />
                                        </div>
                                    </div>
                                    <div class="control-group frmedit">
                                        <label class="control-label">End Level:</label>
                                        <div class="controls">
                                            <input value="<?php echo $pack->end_level;?>" name="end_level[]" type="text" class="span3 validate[required]" />
                                        </div>
                                    </div>
                                    <div class="control-group frmedit">
                                        <label class="control-label">Point:</label>
                                        <div class="controls">
                                            <input value="<?php echo $pack->point;?>" name="point[]" type="text" class="span3 validate[required]" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif?>
                        <?php if($type == 'tuong'):?>
                        <div id="items">
                            <div class = "panel panel-default">
                                <div class = "panel-body">
                                    <div class="control-group frmedit">
                                        <label class="control-label">ID Card:</label>
                                        <div class="controls">
                                            <input value="<?php echo $pack->IDCard;?>" name="IDCard[]" type="text" class="span3 validate[required]" />
                                        </div>
                                    </div>
                                    <div class="control-group frmedit">
                                        <label class="control-label">Name:</label>
                                        <div class="controls">
                                            <input value="<?php echo $pack->name;?>" name="name[]" type="text" class="span3 validate[required]" />
                                        </div>
                                    </div>
                                    <div class="control-group frmedit">
                                        <label class="control-label">Point:</label>
                                        <div class="controls">
                                            <input value="<?php echo $pack->point;?>" name="point[]" type="text" class="span3 validate[required]" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif?>





                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input id="add-item" class="btn btn-primary" type="button" value="Add Item">
                                <input id="remove-item" class="btn btn-primary" type="button" value="Remove Item">
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
