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

                var rules = {};
                $(".item_rule").each(function(e, item) {
                    var rule = $(item).children().find("input[name^=keyrule]").val(); 
					if(rule!=undefined){
						rules[rule] = []; 
						$(item).find("#sub_item_rule.sub_item_rule").each(function(ies, sitems){
							rules[rule][ies] = [];
							$(sitems).find("#subsub_item_rule.sub_item_rule").each(function(ie, sitem){                            
								rules[rule][ies][ie] = {};
								rules[rule][ies][ie].item_id = $($(sitem).find("input")[0]).val();
								rules[rule][ies][ie].name = $($(sitem).find("input")[1]).val();
								rules[rule][ies][ie].count = $($(sitem).find("input")[2]).val();
								rules[rule][ies][ie].rate = $($(sitem).find("input")[3]).val();
								rules[rule][ies][ie].type = $($(sitem).find("input")[4]).val();
							});
						});
					}
                });
                var promotion = JSON.stringify(rules);
                //rules
                var keyrule = $("select[name=keyrule]").val();
                var valuerule = $("input[name=valuerule]").val();
                var arrRules = {};
                arrRules[keyrule] = valuerule;
                var strRule = JSON.stringify(arrRules);
                //paytype
                var data = [];
                $(".item_ruleType").each(function(e, item) {
                    data.push($(item).children().find("input[name^=paytype]").val());
                });
                var paytype = JSON.stringify(data);
                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "<?php echo $url_service;?>/cms/accumulation/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
                    data:{
                        event_id:$("select[name=event_id]").val(),
                        server_id:$("input[name=server_id]").val(),
                        promotion:promotion,
                        rules:strRule,
                        is_reset:$("input:radio[name='is_reset']:checked").val(),
                        start:$("input[name=start]").val(),
                        end:$("input[name=end]").val(),
                        closedate:$("input[name=closedate]").val(),
                        type:$("select[name=type]").val(),
                        paytype:paytype,
                        status:$("input:radio[name='status']:checked").val(),
                        },
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
            <?php include APPPATH . 'views/game/Events/accumulation/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <?php
                            $statusOn = 'checked';
                            $testerOn = 'checked';
                            $is_resetOn = 'checked';
                            $start = date('d-m-Y G:i:s',time());
                            $end = date('d-m-Y G:i:s',time());
                            $closedate = date('d-m-Y G:i:s',time());
                            if($_GET['id']>0){
                                $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                $testerOn =  $items['tester']==1 ? 'checked="checked"':'';
                                $testerOff =  $items['tester']==0 ? 'checked="checked"':'';
                                $is_resetOn =  $items['is_reset']==1 ? 'checked="checked"':'';
                                $is_resetOff =  $items['is_reset']==0 ? 'checked="checked"':'';
                                if(!empty($items['start'])){
                                    $start = date_format(date_create($items['start']),"d-m-Y G:i:s");
                                }else{
                                    $start = date('d-m-Y G:i:s',time());
                                }
                                if(!empty($items['end'])){
                                    $end = date_format(date_create($items['end']),"d-m-Y G:i:s");
                                }else{
                                    $end = date('d-m-Y G:i:s',time());
                                }
                                if(!empty($items['closedate'])){
                                    $closedate = date_format(date_create($items['closedate']),"d-m-Y G:i:s");
                                }else{
                                    $closedate = date('d-m-Y G:i:s',time());
                                }
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
                                                if($v['game_id']==$_GET['game']){
                                    ?>
                                    <option value="<?php echo $v['id'];?>" <?php echo ($v['id']==$items['event_id'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                                    <?php
                                                }
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
                        <div class="control-group">
                            <label class="control-label">Rule:</label>
                            <div class="controls">
                                <?php
                                    $rules  =  json_decode($items['rules'],true);
                                ?>
                                Key : <select name="keyrule">
								    <option value="award_by_create" <?php echo (@key($rules)=='award_by_create')?'selected="selected"':''; ?>>Award by create</option>
                                    <option value="normal" <?php echo (@key($rules)=='normal')?'selected="selected"':''; ?>>Normal</option>
                                    <option value="first" <?php echo (@key($rules)=='first')?'selected="selected"':''; ?>>First</option>
                                    <option value="create" <?php echo (@key($rules)=='create')?'selected="selected"':''; ?>>Create</option>
                                    <option value="server" <?php echo (@key($rules)=='server')?'selected="selected"':''; ?>>Server</option>
                                </select>
                                Value : <input type="text" name="valuerule" value="<?php echo $rules[@key($rules)];?>">
                            </div>
                        </div>    
                        
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
                            <label class="control-label">Ngày đóng:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="closedate" value="<?php echo $closedate;?>"/>
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
                                    <option value="amount" <?php echo ($items['type']=='amount')?'selected="selected"':'';?>>Amount</option>
                                </select>
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
                        <?php
                            include_once 'paytype.php';
                        ?>
                        <?php include_once 'json_rule.php'; ?>
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
