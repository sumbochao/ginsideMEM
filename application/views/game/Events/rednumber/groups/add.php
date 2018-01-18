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
            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo $url_service;?>/cms/rednumber/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
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
                            $statusOn = 'checked';
                            $enddate = date('d-m-Y G:i:s',time());
                            $resulthour  =date('G:i:s',time());
                            if($_GET['id']>0){
                                $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                if(!empty($items['enddate'])){
                                    $enddate = date_format(date_create($items['enddate']),"d-m-Y G:i:s");
                                }else{
                                    $enddate = date('d-m-Y G:i:s',time());
                                }
                                if(!empty($items['resulthour'])){
                                    $resulthour = $items['resulthour'];
                                }else{
                                    $resulthour = date('G:i:s',time());
                                }
                            }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input name="name" id="name" value="<?php echo $items['name'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">	
                            <label class="control-label">Game</label>
                            <div class="controls">
                                <select name="game" class="validate[required]">
                                    <option value="">Chọn game</option>
                                    <?php 
                                        if(count($slbGame)>0){
                                            foreach($slbGame as $v){
                                                if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || (@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==3) || $_SESSION['account']['id_group']==1){
                                    ?>
                                    <option value="<?php echo $v['service_id'];?>" <?php echo $v['service_id']==$items['game_id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php include_once 'common/server.php';?>
                        <?php include_once 'common/prizes.php';?>
                        <div class="control-group">
                            <label class="control-label">Giờ:</label>
                            <div class="controls">
                                <input type="text" class="times" name="resulthour" value="<?php echo $resulthour;?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Kết thúc:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="enddate" value="<?php echo $enddate;?>"/>
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
                            <label class="control-label">Option:</label>
                            <div class="controls">
                                <select name="option">
                                    <option value="0" <?php echo $items['option']=='0'?'selected="selected"':'';?>>Bình thường</option>
                                    <option value="1" <?php echo $items['option']=='1'?'selected="selected"':'';?>>Bao lô</option>
									<option value="2" <?php echo $items['option']=='2'?'selected="selected"':'';?>>Tự nhập</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group" style="display:none">
                            <label class="control-label">Chiều dài:</label>
                            <div class="controls">
                                <input name="length" value="<?php echo isset($items['length'])?$items['length']:2;?>" type="text" class="span3 validate[required]" style="width: 80%"/>
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
    $('.times').timepicker({
        timeFormat: 'hh:mm:ss'//
    });
</script>
