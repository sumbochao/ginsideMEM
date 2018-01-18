<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.service.bog.mobo.vn/bog/index.php';
    }else{
        $url_service = 'http://game.mobo.vn/bog';
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
        .input_fields .control-group{
            padding-top: 23px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
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
                    url: "<?php echo $url_service;?>/cms/accumulation/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
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
            <?php include APPPATH . 'views/game/bog/Events/accumulation/tab.php'; ?>
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
                                $testerOn = 'checked';
                                $is_resetOn = 'checked';
                                $start = gmdate('d-m-Y G:i:s',time()+7*3600);
                                $end = gmdate('d-m-Y G:i:s',time()+7*3600);
                                $rule_start = gmdate('d-m-Y G:i:s',time()+7*3600);
                                $rule_end = gmdate('d-m-Y G:i:s',time()+7*3600);
                                if($_GET['id']>0){
                                    $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                    $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                    $testerOn =  $items['tester']==1 ? 'checked="checked"':'';
                                    $testerOff =  $items['tester']==0 ? 'checked="checked"':'';
                                    $is_resetOn =  $items['is_reset']==1 ? 'checked="checked"':'';
                                    $is_resetOff =  $items['is_reset']==0 ? 'checked="checked"':'';
                                    if(!empty($items['start'])){
                                        $startc = DateTime::createFromFormat('Y-m-d G:i:s',trim($items['start']));
                                        $start = $startc->format('d-m-Y G:i:s');
                                    }
                                    if(!empty($items['end'])){
                                        $endc = DateTime::createFromFormat('Y-m-d G:i:s',trim($items['end']));
                                        $end = $endc->format('d-m-Y G:i:s');
                                    }
                                    $rule_start = date_format(date_create($items['rule_start']),"d-m-Y H:i:s");
                                    $rule_end = date_format(date_create($items['rule_end']),"d-m-Y H:i:s");
                                }
                            ?>
                            <div class="control-group">
                                <label class="control-label">Event:</label>
                                <div class="controls">
                                    <select name="event_id" class="validate[required,custom[onlyNumberSp]]">
                                        <option value="">Chọn Event</option>
                                        <?php
                                            if(count($slbEvent)>0){
                                                foreach($slbEvent as $v){
                                        ?>
                                        <option value="<?php echo $v['id'];?>" <?php echo ($v['id']==$items['event_id'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
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
                                    <input name="server_id" id="server_id" value="<?php echo $items['server_id'];?>" type="text" style="width: 80%"/>
                                </div>
                            </div>
                            <?php include_once 'json_rule.php'; ?>
                            
                            <div class="control-group">
                                <label class="control-label">Bắt đầu sự kiện:</label>
                                <div class="controls">
                                    <input type="text" class="datetime" name="start" value="<?php echo $start;?>"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Kết thúc sự kiện:</label>
                                <div class="controls">
                                    <input type="text" class="datetime" name="end" value="<?php echo $end;?>"/>
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
                                <label class="control-label">Loại:</label>
                                <div class="controls">
                                    <select name="type">
                                        <option value="0" <?php echo ($items['type']=='0')?'selected="selected"':'';?>>Gold</option>
                                        <option value="1" <?php echo ($items['type']=='1')?'selected="selected"':'';?>>Amount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Rule:</label>
                                <div class="controls">
                                    <script>
                                        $(function(){
                                            if($('select[name=type]').val()==0){
                                                $(".textamount").text('Gold');
                                            }else{
                                                $(".textamount").text('Amount');
                                            }
                                            $("select[name=type]").change(function(){
                                                if($(this).val()==0){
                                                    $(".textamount").text('Gold');
                                                }else{
                                                    $(".textamount").text('Amount');
                                                }
                                            });
                                            
                                            switch($('select[name=type_rule_check]').val()){
                                                case "0":
                                                    $(".rule_amount").hide();
                                                    $(".rule_date").hide();
                                                    break;
                                                case "1":
                                                    $(".rule_amount").hide();
                                                    $(".rule_date").show();
                                                    break;
                                                case "2":
                                                    $(".rule_amount").show();
                                                    $(".rule_date").show();
                                                    break;
                                            }
                                            $("select[name=type_rule_check]").change(function(){
                                                switch($(this).val()){
                                                    case "0":
                                                        $(".rule_amount").hide();
                                                        $(".rule_date").hide();
                                                        break;
                                                    case "1":
                                                        $(".rule_amount").hide();
                                                        $(".rule_date").show();
                                                        break;
                                                    case "2":
                                                        $(".rule_amount").show();
                                                        $(".rule_date").show();
                                                        break;
                                                }
                                            });
                                        });
                                    </script>
                                    <select name="type_rule_check">
                                        <option value="0" <?php echo ($items['type_rule_check']=='0')?'selected="selected"':'';?>>Mật định</option>
                                        <option value="1" <?php echo ($items['type_rule_check']=='1')?'selected="selected"':'';?>>Chưa từng nạp</option>
                                        <option value="2" <?php echo ($items['type_rule_check']=='2')?'selected="selected"':'';?>>Từng nạp và mức tối thiểu</option>
                                    </select>
                                    <div class="rule_amount">
                                        <span class="textamount" style="margin-right:5px;position: relative;top:-5px;"></span><input type="text" name="type_rule_amount" value="<?php echo $items['type_rule_amount']>0?$items['type_rule_amount']:0;?>" style="width:100px;"/>
                                    </div>
                                    <div class="rule_date">
                                        <div>
                                            <span class="textstart" style="margin-right:5px;position: relative;top:-5px;">Bắt đầu</span><input type="text" name="rule_start" value="<?php echo $rule_start;?>" style="width:200px;" class="datetime"/>
                                        </div>
                                        <div>
                                            <span class="textend" style="margin-right:5px;position: relative;top:-5px;">Kết thúc</span><input type="text" name="rule_end" value="<?php echo $rule_end;?>" style="width:200px;" class="datetime"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Reset:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="is_reset" id="is_reset" value="1" <?php echo $is_resetOn;?>/>
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="is_reset" id="is_reset" value="0" <?php echo $is_resetOff;?>/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tester:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="tester" id="tester" value="1" <?php echo $testerOn;?>/>
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="tester" id="tester" value="0" <?php echo $testerOff;?>/>
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
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>
