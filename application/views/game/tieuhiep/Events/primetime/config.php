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
        .form-group {
            float: left;
            width: 23%;
        }
        .form-group input {
            width: 56%;
        }
        .form-horizontal .form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .form-horizontal .control-label{
            padding-right: 5px;
        }
        .remove_field{
            cursor: pointer;
            color: green;
        }
        .input_fields_wrap .control-group{
            padding-top: 15px; padding-bottom: 0px;
        }
        .input_fields_wrap .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
    </style>
    <?php
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $url_service = 'http://localhost.game.mobo.vn/tieuhiep/index.php';
        }else{
            $url_service = 'http://game.mobo.vn/tieuhiep';
        }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#comeback').on('click', function () {
                window.history.go(-1); return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "<?php echo $url_service;?>/cms/primetime/config",
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
            <?php include APPPATH . 'views/game/tieuhiep/Events/primetime/tab.php'; ?>
            <div class="widget-name">

                <!-- <div class="tabs">
                   <a href="/cms/ep/promotion_lato/thongke"><i class=" ico-th-large"></i>THỐNG KÊ</a> 
                   <a href="/cms/ep/promotion_lato/tralogdoiqua"><i class=" ico-th-large"></i>TRA LOG ĐỔI QUÀ</a>
				   <a href="javascript:void(0);" class="clearcached"><i class=" ico-th-large"></i>CLEAR MENCACHED</a>
                </div>-->
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="control-group">
                            <label class="control-label">Item ID:</label>
                            <div class="controls">
                                <input type="text" name="item_id" value="<?php echo $infodetail['item_id'];?>" id="item_id" class="span3 validate[required]"/>
                            </div>
                        </div>
                        <div class="rows">	
                            <div class="input_fields_wrap">
                                <div class="btn_morefield">
                                    <button class="add_field_button btn btn-success">Thêm Items</button>
                                    <?php echo $errors['items'];?>
                                </div>
                                <?php
									$listItems = json_decode($infodetail['rule'],true);
									if(count($listItems)>0){
										$i=0;
										foreach($listItems as $v){
											$i++;
                                ?>
                                <div class="control-group listItem">
                                    <div class="group1">
                                        <div class="form-group">
                                            <label class="control-label">From:</label>
                                            <input id="item_id" name="from[]" type="text" value="<?php echo $v['from'];?>" class="span3 validate[required]">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">To:</label>
                                            <input id="name" name="to[]" type="text" value="<?php echo $v['to'];?>" class="span3 validate[required]">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Value:</label>
                                            <input id="count" name="value[]" type="text" value="<?php echo $v['value'];?>" class="span3 validate[required]">
                                        </div>
                                        <div class="form-group remove">
                                            <span class="remove_field">Remove</span>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <?php
										}
									}
                                ?>
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Date Start:</label>
                            <div class="controls">
                                <?php
                                    if(!empty($infodetail['start_date'])){
                                        $date=date_create($infodetail['start_date']);
                                        $start_date = date_format($date,"d-m-Y G:i:s");
                                    }else{
                                        $start_date = date('d-m-Y G:i:s');
                                    }
                                ?>
                                <input type="text" name="start_date" placeholder="Ngày bắt đầu" value="<?php echo $start_date;?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Date End:</label>
                            <div class="controls">
                                <?php
                                    if(!empty($infodetail['end_date'])){
                                        $date=date_create($infodetail['end_date']);
                                        $end_date = date_format($date,"d-m-Y G:i:s");
                                    }else{
                                        $end_date = date('d-m-Y G:i:s');
                                    }
                                ?>
                                <input type="text" name="end_date" placeholder="Ngày kết thúc" value="<?php echo $end_date;?>"/>
                            </div>
                        </div>
                        <div class="control-group" style="display:none">
                            <label class="control-label">Start Time:</label>
                            <div class="controls">
                                <?php
                                    if(!empty($infodetail['start_time'])){
                                        $time=date_create($infodetail['start_time']);
                                        $start_time = date_format($time,"G:i:s");
                                    }else{
                                        $start_time = date('G:i:s');
                                    }
                                ?>
                                <input type="text" name="start_time" placeholder="Thời gian bắt đầu" value="<?php echo $start_time;?>"/>
                            </div>
                        </div>
                        <div class="control-group" style="display:none">
                            <label class="control-label">End Time:</label>
                            <div class="controls">
                                <?php
                                    if(!empty($infodetail['end_time'])){
                                        $time=date_create($infodetail['end_time']);
                                        $end_time = date_format($time,"G:i:s");
                                    }else{
                                        $end_time = date('G:i:s');
                                    }
                                ?>
                                <input type="text" name="end_time" placeholder="Thời gian kết thúc" value="<?php echo $end_time;?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Giờ vàng</label>
                            <div class="controls">
                                <textarea cols="25" rows="5" name="time"><?php echo $infodetail['time'];?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">is_first</label>
                            <div class="controls">
                                <input type="radio" name="is_first" value="0" <?php echo ($infodetail['is_first']==0)?'checked="checked"':'';?>/> 0 
                                <input type="radio" name="is_first" value="1" <?php echo ($infodetail['is_first']==1)?'checked="checked"':'';?>/> 1
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">is_reset</label>
                            <div class="controls">
                                <input type="radio" name="is_reset" value="0" <?php echo ($infodetail['is_reset']==0)?'checked="checked"':'';?>/> 0 
                            <input type="radio" name="is_reset" value="1" <?php echo ($infodetail['is_reset']==1)?'checked="checked"':'';?>/> 1
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Duyệt</label>
                            <div class="controls">
                                <input type="radio" name="status" value="0" <?php echo ($infodetail['status']==0)?'checked="checked"':'';?>/> Tắt 
                                <input type="radio" name="status" value="1" <?php echo ($infodetail['status']==1)?'checked="checked"':'';?>/> Bật
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='id' id="id" value="<?php echo $infodetail['id'];?>"/>
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
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
    $('input[name=start_date]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
    $('input[name=end_date]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//HH:mm:ss
    });
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                xhtml += '<div class="control-group listItem">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">From:</label>';
                             xhtml +='<input id="from" name="from[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">To:</label>';
                             xhtml +='<input id="to" name="to[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Value:</label>';
                             xhtml +='<input id="value" name="value[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clear"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper).append(xhtml); //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
    });
</script>