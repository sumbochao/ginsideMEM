<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.service.phongthan.mobo.vn';
    }else{
        $url_service = 'http://service.phongthan.mobo.vn';
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
    </style>
    <style>
    .error.item{
        padding-left: 0%;
        margin-top: 0px;
    }
    .receivegame{
        padding-top: 10px;
    }
    .remove_field{
        cursor: pointer;
    }
    .form-group{
        float: left;
        width: 20%;
    }
    .form-group.remove{
        width: 5%;
        color: green;
        cursor: pointer;
    }
    .form-group label{
        width: 35%;
    }
    .form-group input{
        width: 56%;
    }
    .listItem{
        margin-top: 10px;
    }
    .form-horizontal .form-group{
        margin-left: 0px;margin-right: 0px;
    }
</style>
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
            top:7px;
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
				var rules = {};
                $(".item_rule").each(function(e, item) {
                    var rule = $(item).children().find("input[name^=keyrule]").val();                        
                    rules[rule] = []; 
                    $(item).find("#sub_item_rule.sub_item_rule").each(function(ies, sitems){
                        rules[rule][ies] = [];
                        $(sitems).find("#subsub_item_rule.sub_item_rule").each(function(ie, sitem){                            
                            rules[rule][ies][ie] = {};
                            rules[rule][ies][ie].item_id = $($(sitem).find("input")[0]).val();
                            rules[rule][ies][ie].name = $($(sitem).find("input")[1]).val();
                            rules[rule][ies][ie].count = $($(sitem).find("input")[2]).val();
                            rules[rule][ies][ie].rate = $($(sitem).find("input")[3]).val();                            
                        });
                    });
                });
                var stringJson = JSON.stringify(rules);
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo $url_service;?>/cms/accumulation/<?php echo $_GET['id']>0?'edit_filters?id='.$_GET['id']:'add_filters';?>",
                    data:{
                        event_id:$("select[name=event_id]").val(),
                        server_id:$("input[name=server_id]").val(),
                        start:$("input[name=start]").val(),
                        end:$("input[name=end]").val(),
                        is_first:$("input:radio[name ='is_first']:checked").val(),
                        is_reset:$("input:radio[name ='is_reset']:checked").val(),
                        status:$("input:radio[name ='status']:checked").val(),
                        promotion:stringJson},
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
			$('#onCoppySubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo $url_service;?>/cms/accumulation/coppy_filters",
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
            <?php include APPPATH . 'views/game/pt/Events/accumulation/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                                <i class=" ico-th-large"></i><?php echo $title; ?></h5>
                            <?php
								$is_firstOn = 'checked';
                                $is_resetOn = 'checked';
                                $statusOn = 'checked';
                                $start = gmdate('d-m-Y G:i:s',time()+7*3600);
                                $end = gmdate('d-m-Y G:i:s',time()+7*3600);
                                if($_GET['id']>0){
                                    if(!empty($items['start'])){
                                        $startc = DateTime::createFromFormat('Y-m-d G:i:s',trim($items['start']));
                                        $start = $startc->format('d-m-Y G:i:s');
                                    }
                                    if(!empty($items['end'])){
                                        $endc = DateTime::createFromFormat('Y-m-d G:i:s',trim($items['end']));
                                        $end = $endc->format('d-m-Y G:i:s');
                                    }
									$is_firstOn =  $items['is_first']==1 ? 'checked="checked"':'';
                                    $is_firstOff =  $items['is_first']==0 ? 'checked="checked"':'';
                                    
                                    $is_resetOn =  $items['is_reset']==1 ? 'checked="checked"':'';
                                    $is_resetOff =  $items['is_reset']==0 ? 'checked="checked"':'';
									
                                    $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                    $statusOff =  $items['status']==0 ? 'checked="checked"':'';
									$server_id = $items['server_id'];
                                }
                            ?>
                            <?php
                                include_once 'json_rule.php';
                            ?>
							<div class="control-group">
                                <label class="control-label">Sự kiện:</label>
                                <div class="controls">
                                    <select name="event_id">
                                        <?php
                                            if(count($slbEvent['rows'])>0){
                                                foreach($slbEvent['rows'] as $v){
                                        ?>
                                        <option value="<?php echo $v['id'];?>" <?php echo $v['id']==$items['event_id']?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">Máy chủ:</label>
                                <div class="controls">
                                    <input type="text" id="server_id" name="server_id" value="<?php echo $server_id;?>"/> Ví dụ : [1][2][3]...
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bắt đầu:</label>
                                <div class="controls">
                                    <input type="text" id="start" name="start" value="<?php echo $start;?>"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Kết thúc:</label>
                                <div class="controls">
                                    <input type="text" id="end" name="end" value="<?php echo $end;?>"/>
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">is_first:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="is_first" id="is_first" value="1" <?php echo $is_firstOn;?>/>
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="is_first" id="is_first" value="0" <?php echo $is_firstOff;?>/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">is_reset:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="is_reset" id="is_reset" value="1" <?php echo $is_resetOn;?>/>
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="is_reset" id="is_reset" value="0" <?php echo $is_resetOff;?>/>
                                </div>
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
									<?php
                                        if($_GET['func']=='edit_filters'){
                                    ?>
                                    <button id="onCoppySubmit" class="btn btn-primary"><span>Nhân bản</span></button>
                                    <?php
                                        }
                                    ?>
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
        timeFormat: 'hh:mm:ss'
    });
    $('input[name=end]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
    });
	<?php
        if($_GET['id']>0){
    ?>
		/*
    jQuery("#server_id").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 32 || (event.keyCode == 65 && event.ctrlKey === true) ||(event.keyCode >= 35 && event.keyCode <= 39)){
            jQuery(this).val(jQuery.trim(jQuery(this).val()));
            return;
        }else{
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	*/
    <?php
        }
    ?>
</script>