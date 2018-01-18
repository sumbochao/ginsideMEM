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
        width: 70px !important;
        color: #f36926;
        float: left;
        margin-top: 4px;
    }
    .sublistItem label{
        width: 75px !important;
    }
    .listItem .form-group {
        float: left;
        width: 30%;
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
        $('#comeback').on('click', function () {
            window.history.go(-1); return false;
        });

        $('#onSubmit').on('click', function () {
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
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="game" class="validate[required,custom[onlyLetterSp]]">
                        <option value="">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                                    if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
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
                    <label for="menu_group_id">Server ID</label>
                    <input type="text" name="server_ids" class="textinput" value="<?php echo $items['server_ids'];?>"/>
                    <?php echo $errors['server_ids'];?>
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
                
            </div>
            <div class="group_right">
                <div class="rows">	
                    <label for="menu_group_id">None recharge</label>
                    <input type="radio" name="none_recharge" value="0" <?php echo ($items['none_recharge']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="none_recharge" value="1" <?php echo ($items['none_recharge']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Is first</label>
                    <input type="radio" name="is_first" value="0" <?php echo ($items['is_first']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="is_first" value="1" <?php echo ($items['is_first']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Is reset</label>
                    <input type="radio" name="is_reset" value="0" <?php echo ($items['is_reset']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="is_reset" value="1" <?php echo ($items['is_reset']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Publisher</label>
                    <input type="radio" name="publisher" value="0" <?php echo ($items['publisher']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="publisher" value="1" <?php echo ($items['publisher']==1)?'checked="checked"':'';?>/> Bật
                </div>
            </div>
            <div class="clr"></div>
            <?php include_once 'json_promotion.php';?>
            <div class="rows">	
                <label for="menu_group_id">Amount : </label>
                <span class="tagsinput_amount">
                    <?php
                        if(!empty($items['amount'])){
                            $j_amount = json_decode($items['amount'],true);
                            $str_amount = implode(',', $j_amount);
                        }else{
							$str_amount = '';
						}
                    ?>
                    <input type="text" value="<?php echo $str_amount;?>" data-role="tagsinput" />
                    <input type="hidden" name="amount" class="content_tags_amount" value='<?php echo $items['amount'];?>'/>
                </span>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Type : </label>
                <span class="tagsinput_type">
                    <?php
                        if(!empty($items['type'])){
                            $j_type = json_decode($items['type'],true);
                            $str_type = implode(',', $j_type);
                        }else{
							$str_type = '';
						}
                    ?>
                    <input type="text" value="<?php echo $str_type;?>" data-role="tagsinput" />
                    <input type="hidden" name="type" class="content_tags_type" value='<?php echo $items['type'];?>'/>
                </span>
            </div>
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
            </div>
            <div class="clr"></div>
            <div class="control-group">
                <div align="center">
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
<script type="text/javascript">
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
    });
</script>
<script src="assets/tags/js/bootstrap-tagsinput.js"></script>
<script src="assets/tags/js/app.js"></script>