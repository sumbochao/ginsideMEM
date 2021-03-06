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
//            $("#start_time").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
//            $("#end_time").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
//
//            var start_time = '<?php //echo $date_start; ?>//';
//            $('#start_time').jqxDateTimeInput('setDate', start_time);
//            var end_time = '<?php //echo $date_end; ?>//';
//            $('#end_time').jqxDateTimeInput('setDate', end_time);

            
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
//                clone.find('input[type=hidden]').val(0);
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
                <form id="frmSendChest" action="/?control=maymanmoingay&func=add_gift&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <div id="items">
                            <?php if($id == ''): ?>
                            <div class = "panel panel-default">
                                <div class = "panel-body">
                                <div class="control-group frmedit">
                                    <label class="control-label">Name:</label>
                                    <div class="controls">
                                        <input value="<?php echo $pack->reward_name;?>" name="reward_name[]" type="text" class="span3 validate[required]" />
                                    </div>
                                </div>

                                <div class="control-group frmedit">
                                    <label class="control-label">Item ID:</label>
                                    <div class="controls">
                                        <input value="<?php echo $pack->reward_item_code;?>" name="reward_item_code[]" type="text" class="span3 validate[required]" />
                                    </div>
                                </div>

                                <div class="control-group frmedit">
                                    <label class="control-label">Type:</label>
                                    <div class="controls">
                                        <input value="<?php echo $pack->reward_item_type;?>" name="reward_item_type[]" type="text" class="span3 validate[required]" />
                                    </div>
                                </div>

                                <div class="control-group frmedit">
                                    <label class="control-label">Number:</label>
                                    <div class="controls">
                                        <input value="<?php echo $pack->reward_item_number;?>" name="reward_item_number[]" type="text" class="span3 validate[required]" />
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Image:</label>

                                    <div class="controls">
										<input value="<?php echo $pack->reward_img;?>" name="reward_img[]" type="text" class="span3 validate[required]" />
									</div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Rate:</label>

                                    <div class="controls">
										<input value="<?php echo $pack->reward_point;?>" name="reward_point[]" type="text" class="span3 validate[required]" />
									</div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Time:</label>

                                    <div class="controls">
										<input value="<?php echo $pack->time;?>" name="time[]" type="text" class="span3 validate[required]" />
									</div>
                                </div>

                            </div>
                            </div>
                            <?php else:?>
                                <div class = "panel panel-default">
                                    <div class = "panel-body">
                                        <div class="control-group frmedit">
                                            <label class="control-label">Name:</label>
                                            <div class="controls">
                                                <input value="<?php echo $pack->reward_name;?>" name="reward_name[]" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>

                                        <div class="control-group frmedit">
                                            <label class="control-label">Item ID:</label>
                                            <div class="controls">
                                                <input value="<?php echo $pack->reward_item_code;?>" name="reward_item_code[]" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>

                                        <div class="control-group frmedit">
                                            <label class="control-label">Type:</label>
                                            <div class="controls">
                                                <input value="<?php echo $pack->reward_item_type;?>" name="reward_item_type[]" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>

                                        <div class="control-group frmedit">
                                            <label class="control-label">Number:</label>
                                            <div class="controls">
                                                <input value="<?php echo $pack->reward_item_number;?>" name="reward_item_number[]" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <label class="control-label">Image:</label>

                                            <div class="controls">
                                                <input value="<?php echo $pack->reward_img;?>" name="reward_img[]" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Rate:</label>

                                            <div class="controls">
                                                <input value="<?php echo $pack->reward_point;?>" name="reward_point[]" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Time:</label>

                                            <div class="controls">
                                                <input value="<?php echo $pack->time;?>" name="time[]" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <?php endif?>

                        </div>



                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <?php if($id == ''): ?>
                                <input id="add-item" class="btn btn-primary" type="button" value="Add Item">
                                <input id="remove-item" class="btn btn-primary" type="button" value="Remove Item">
                                <?php endif?>
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
