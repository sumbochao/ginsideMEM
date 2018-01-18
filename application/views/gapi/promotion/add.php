<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script type="text/javascript" src="/libraries/jqwidgets32/jqx-all.js"></script>
<link href='/libraries/jqwidgets32/styles/jqx.base.css' rel='stylesheet' type='text/css'>
<link href='/libraries/jqwidgets32/styles/jqx.classic.css' rel='stylesheet' type='text/css'>
<link href='/libraries/pannonia/pannonia/css/plugins.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/libraries/cms/jquery.form.js"></script>
<script type="text/javascript" src="/assets/js/currency.js"></script>

<link rel="stylesheet" href="assets/tags/css/bootstrap-tagsinput.css">
<link rel="stylesheet" href="assets/tags/css/app.css">

<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="mySmallModalLabel">Thông báo</h4>
        </div>
        <div class="modal-body"><div id="messgage" style="text-align: center;"></div></div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<style>
    input, textarea, .uneditable-input{
        width: 65%;
    }
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
    .listItem label {
        width: 155px !important;
        color: #f36926;
        float: left;
        margin-top: 4px;
    }
    .sublistItem label{
        width: 75px !important;
    }
    .listItem .form-group {
        float: left;
        width: 40%;
        padding-top:10px;
    }
    .sublistItem .form-group{
        padding-top: 0px;
    }
    .form-group input {
        width: 70%;
    }
    .form-horizontal .form-group{
        margin-left: 0px;
        margin-right: 10px;
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
    .color_remove{
        cursor: pointer;
        color: green;
    }
    .input_fields_style .control-group{
        padding-top: 0px; padding-bottom: 0px;margin-left: 0px; padding-left: 10px;border: 1px solid #ccc;padding-bottom: 15px; margin-top: 10px; margin-bottom: 10px;
    }
    .input_fields_style .control-group .form-group{
        padding-bottom: 0px; margin-bottom: 0px;
    }
    .control-group.listItem.stylelist{
        padding-bottom: 0px;
        padding-top: 0px;
        border: 0px;
    }
    .rows.rows_json{
        border-top: 1px solid #eee;
        padding-top: 10px;
    }
    .input_fields_style .control-group .sublistItem{
        border: 0px;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }
    .input_fields_style .control-group .sublistItem .remove_sub{
        top:4px;
    }
    .loadContent{
        text-align: center;
        color: red;
    }
    .input_fields_style .control-group .sublistItem .remove_sub .remove_field{
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
        $('.comeback').on('click', function () {
            window.history.go(-1); return false;
        });

        $('.onSubmit').on('click', function () {
            if ($('#frmSendChest').validationEngine('validate') === false)
                return false;

            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo base_url().'?'.$_SERVER['QUERY_STRING'];?>",
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
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div> 
            <div class="control-group">
                <div align="center">
                    <?php 
                        //($_SESSION['account']['id_group']==3 && $items['approved']==0) || ($_SESSION['account']['id_group']==2 && $items['approved']==0) ||
                        if((@in_array('approved_gapi', $_SESSION['permission']) && $items['approved']==0 && $_SESSION['account']['id_group']==2) ||  $_SESSION['account']['id_group']==1){
                    ?>
                    <button class="btn btn-primary onSubmit"><span>Thực hiện</span></button>
                    <?php } ?>
                    <button class="btn btn-primary comeback"><span>Quay lại</span></button>
                    <div style="display: inline-block">
                        <span id="message" style="color: green"></span>
                    </div>
                </div>
            </div>
            
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="game" class="validate[required]">
                        <option value="">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                                    if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || (@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==3) || $_SESSION['account']['id_group']==1){
                        ?>
                        <option value="<?php echo $v['app_name'];?>" <?php echo $v['app_name']==$items['game']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                        <?php
                                    }
                                }
                            }
                        ?>
                    </select>
                    <?php echo $errors['game'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ngày bắt đầu</label>
                    <?php
                        if(!empty($items['start'])){
                            $start = date_format(date_create($items['start']),"d-m-Y G:i:s");
                        }else{
                            $start = date('d-m-Y G:i:s');
                        }
                    ?>
                    <input type="text" name="start" class="datetime" placeholder="Ngày bắt đầu" value="<?php echo $start;?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ngày kết thúc</label>
                    <?php
                        if(!empty($items['end'])){
                            $end = date_format(date_create($items['end']),"d-m-Y G:i:s");
                        }else{
                            $end = date('d-m-Y G:i:s');
                        }
                    ?>
                    <input type="text" name="end" class="datetime" placeholder="Ngày kết thúc" value="<?php echo $end;?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ưu tiên</label>
                    <input type="text" name="priority" placeholder="Priority" value="<?php echo (!empty($items['priority']))?$items['priority']:0;?>"/>
                </div>
            </div>
            <div class="group_right">
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">None recharge</label>
                    <input type="radio" name="none_recharge" value="0" <?php echo ($items['none_recharge']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="none_recharge" value="1" <?php echo ($items['none_recharge']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">Is first</label>
                    <input type="radio" name="is_first" value="0" <?php echo ($items['is_first']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="is_first" value="1" <?php echo ($items['is_first']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Qua ngày reset</label>
                    <input type="radio" name="is_reset" value="0" <?php echo ($items['is_reset']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="is_reset" value="1" <?php echo ($items['is_reset']==1)?'checked="checked"':'';?>/> Bật
                </div>
				
				<?php
                    if($_GET['func']=='add'){
                        $items['status']=1;
                    }
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Trạng thái</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <?php
                    //$_SESSION['account']['id_group']==2 || $_SESSION['account']['id_group']==1 (full)
                    if((@in_array('publisher_gapi', $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || $_SESSION['account']['id_group']==1){
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt Test</label>
                    <input type="radio" name="publisher" value="0" <?php echo ($items['publisher']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="publisher" value="1" <?php echo ($items['publisher']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <?php } ?>
                <?php
                    //$_SESSION['account']['id_group']!=3 || ($items['publisher']==1 && $_SESSION['account']['id_group']==3)
                //echo "<pre>";print_r($_SESSION['permission']);echo "</pre>";
                    if((@in_array('doned_gapi', $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || (@in_array('doned_3_gapi', $_SESSION['permission']) && $items['publisher']==1 && $_SESSION['account']['id_group']==2) || $_SESSION['account']['id_group']==1){
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Hoàn tất</label>
                    <input type="radio" name="doned" value="0" <?php echo ($items['doned']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="doned" value="1" <?php echo ($items['doned']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <?php } ?>
                <?php
                        if($_SESSION['account']['id_group']==1){
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt public</label>
                    <input type="radio" name="approved" value="0" <?php echo ($items['approved']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="approved" value="1" <?php echo ($items['approved']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <?php } ?>
            </div>
            <div class="clr"></div>
            <?php include_once 'server.php';?>
            <?php include_once 'json_promotion.php';?>
            <?php include_once 'amount.php';?>
            <?php include_once 'type.php';?>
            <div class="rows">	
                <label for="menu_group_id">Tester : </label>
                <span class="tagsinput_tester">
                    <?php
                        if(!empty($items['tester'])){
                            $j_tester = json_decode($items['tester'],true);
                            $str_tester = implode(',', $j_tester);
                        }else{
                            $str_tester = '';
                        }
                    ?>
                    <input type="text" value="<?php echo $str_tester;?>" data-role="tagsinput" />
                    <input type="hidden" name="tester" class="content_tags_tester" value='<?php echo $items['tester'];?>'/>
                </span>
				<div style="color:#666;font-style: italic">Tài khoản mobo 1900... </div>
            </div>
            <div class="clr"></div>
            <div class="control-group">
                <div align="center">
                    <?php 
                        //($_SESSION['account']['id_group']==3 && $items['approved']==0) || ($_SESSION['account']['id_group']==2 && $items['approved']==0) ||
                        if((@in_array('approved_gapi', $_SESSION['permission']) && $items['approved']==0 && $_SESSION['account']['id_group']==2) || $_SESSION['account']['id_group']==1){
                    ?>
                    <button class="btn btn-primary onSubmit"><span>Thực hiện</span></button>
                    <?php 
                        } 
                    ?>
                    <button class="btn btn-primary comeback"><span>Quay lại</span></button>
                    <div style="display: inline-block">
                        <span id="message" style="color: green"></span>
                    </div>
                </div>
            </div> 
        </div>
    </form>
</div>
<script type="text/javascript">
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
    });
</script>
<script src="assets/tags/js/bootstrap-tagsinput.js"></script>
<script src="assets/tags/js/bootstrap-tagsinput-number.js"></script>
<script src="assets/tags/js/app.js"></script>