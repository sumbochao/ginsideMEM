<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.game.mobo.vn/tieuhiep/index.php';
    }else{
        $url_service = 'http://game.mobo.vn/tieuhiep';
    }
?>
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
            width: 22%;
        }
        .form-group input {
            width: 70%;
        }
        .form-horizontal .form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .form-horizontal .listItem .control-label{
            padding-right: 5px;
            width: 27% !important;
            color: green;
        }
        .form-horizontal .listItem .sublistItem .control-label{
            color: #f36926;
        }
        .form-horizontal .sublistItem{
            margin-left: 15px;
        }
        .remove_field,.remove_field_receive{
            cursor: pointer;
            color: green;
        }
        .input_fields_wrap .control-group,.input_fields_wrap_receive .control-group{
            padding-top: 15px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; padding-top:15px; padding-bottom: 15px; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group,.input_fields_wrap_receive .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
        .input_fields_wrap .control-group .sublistItem,.input_fields_wrap_receive .control-group .sublistItem{
            border: 0px;
            margin-bottom: 0px;
            padding-bottom: 0px;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub{
            top:4px;
        }
        .loadContent{
            text-align: center;
            color: red;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
            color: #f36926 !important;
        }
        .form-horizontal .control-label{
            text-align: center;
        }
        .form-group.remove{
            width: 10%;
            position: relative;
            top:6px;
        }
        .subItems{
            margin-left: 20px;
        }
    </style>
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
                    url: "<?php echo $url_service;?>/cms/awardvip/<?php echo $_GET['id']>0?'edit_item?id='.$_GET['id']:'add_item';?>",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    console.log(result);
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
            <?php include APPPATH . 'views/game/tieuhiep/Events/awardvip/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                            <?php
                                $statusOn = 'checked';
                                if($_GET['id']>0){
                                    $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                    $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                }
                            ?>
                            <div class="control-group">
                                <label class="control-label">Tên:</label>
                                <div class="controls">
                                    <input name="itemname" id="itemname" value="<?php echo $items['itemname'];?>" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="rows">	
                                <div class="input_fields_wrap">
                                    <div class="btn_morefield">
                                        <button class="add_field_button btn btn-success">Thêm Items</button>
                                    </div>
                                    <?php
                                        if($_GET['id']>0){
                                            $listItems = json_decode($items['items'],true);
                                            if(count($listItems)>0){
                                                $i=0;
                                                foreach($listItems as $v){
                                                    $i++;
                                    ?>
                                    <div class="control-group listItem">
                                        <div class="group1">
                                            <div class="form-group">
                                                <label class="control-label">Item ID:</label>
                                                <input id="item_id" name="item_id[]" type="text" value="<?php echo $v['item_id'];?>" class="span3 validate[required]">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Name:</label>
                                                <input id="name" name="name[]" type="text" value="<?php echo $v['name'];?>" class="span3 validate[required]">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Count:</label>
                                                <input id="count" name="count[]" type="text" value="<?php echo $v['count'];?>" class="span3 validate[required]">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Rate:</label>
                                                <input id="rate" name="rate[]" type="text" value="<?php echo $v['rate'];?>" class="span3 validate[required]">
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
                                        }
                                    ?>
                                </div>
                                <div class="clr"></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="status" id="status" value="1" <?php echo $statusOn;?>/>
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="status" id="status" value="0" <?php echo $statusOff;?>/>
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
<script>
    $('input[name=start]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
    $('input[name=end]').datetimepicker({
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
                             xhtml +='<label class="control-label">Item ID:</label>';
                             xhtml +='<input id="item_id" name="item_id[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Name:</label>';
                             xhtml +='<input id="name" name="name[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Count:</label>';
                             xhtml +='<input id="count" name="count[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Rate:</label>';
                             xhtml +='<input id="rate" name="rate[]" type="text" value="1">';
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
