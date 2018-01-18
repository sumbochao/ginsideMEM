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
                if($($(item).find("input")[1]).val()>0){
                    var id_prizes = $($(item).find("input")[0]).val();
                    rules[id_prizes] = {};
                    rules[id_prizes].price = $($(item).find("input")[1]).val();
                    rules[id_prizes].percent = $($(item).find("input")[2]).val();
                }
            });
            var prize_prices = JSON.stringify(rules);
            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo $url_service;?>/cms/rednumber/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
                data:{  prize_prices:prize_prices,
                        group_id:$("select[name=group_id]").val(),
                        day:$("input[name=day]").val(),
                        joinmax:$("input[name=joinmax]").val(),
                        result:$("input:radio[name='result']:checked").val(),
                        min:$("input[name=min]").val(),
                        max:$("input[name=max]").val(),
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
            <?php include APPPATH . 'views/game/Events/rednumber/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                        <?php
                            $resultOff = 'checked';
                            $day = date('d-m-Y',time());
                            if($_GET['id']>0){
                                $resultOn =  $items['result']==1 ? 'checked="checked"':'';
                                $resultOff =  $items['result']==0 ? 'checked="checked"':'';
                                if(!empty($items['day'])){
                                    $day = date_format(date_create($items['day']),"d-m-Y");
                                }else{
                                    $day = date('d-m-Y',time());
                                }
                            }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Nhóm:</label>
                            <div class="controls">
                                <select name="group_id" class="validate[required,custom[onlyNumberSp]]">
                                    <option value="">Chọn nhóm</option>
                                    <?php
                                        if(count($slbGroups)>0){
                                            foreach($slbGroups as $v){
                                    ?>
                                    <option value="<?php echo $v['id'];?>" <?php echo $v['id']==$items['group_id']?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Ngày:</label>
                            <div class="controls">
                                <input type="text" class="days" name="day" value="<?php echo $day;?>"/>
                            </div>
                        </div>
                            <?php include_once 'common/prizes.php'; ?>
                        <div class="control-group" style="display:none">
                            <label class="control-label">Liên kết tối đa:</label>
                            <div class="controls">
                                <input type="text" name="joinmax" value="<?php echo isset($items['joinmax'])?$items['joinmax']:'-1';?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Kết quả:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="result" id="result" value="1" <?php echo $resultOn;?>/>
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="result" id="result" value="0" <?php echo $resultOff;?>/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Min:</label>
                            <div class="controls">
                                <input type="text" name="min" value="<?php echo $items['min'];?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Max:</label>
                            <div class="controls">
                                <input type="text" name="max" value="<?php echo $items['max'];?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='game' value="<?php echo $_GET['game'];?>">
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
    $('.days').datepicker({
        dateFormat: 'dd-mm-yy',
    });
</script>
