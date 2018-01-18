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
                    url: "<?php echo $url_service;?>/cms/covu/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
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
            <?php include APPPATH . 'views/game/lol/Events/covu/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <?php
                                $statusOn = 'checked';
                                $start = date('d-m-Y G:i:s',time());
                                $end = date('d-m-Y G:i:s',time());
                                $end_covu = date('d-m-Y G:i:s',time());
                                if($_GET['id']>0){
                                    $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                    $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                    if(!empty($items['start'])){
                                        $start = date_format(date_create($items['start']),"d-m-Y G:i:s");
                                    }
                                    if(!empty($items['end'])){
                                        $end = date_format(date_create($items['end']),"d-m-Y G:i:s");
                                    }
                                    if(!empty($items['end_covu'])){
                                        $end_covu = date_format(date_create($items['end_covu']),"d-m-Y G:i:s");
                                    }
                                }
                                $capdau = json_decode($items['capdau'],true);
                            ?>
                        <div class="control-group">
                            <label class="control-label">Giải đấu:</label>
                            <div class="controls">
                                <select name="id_giaidau" class="validate[required,custom[onlyNumberSp]]">
                                    <option value="">Chọn giải đấu</option>
                                    <?php
                                        if(count($slbTournaments)>0){
                                            foreach($slbTournaments as $v){
                                    ?>
                                    <option value="<?php echo $v['id'];?>" <?php echo ($v['id']==$items['id_giaidau'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Tên (Team A):</label>
                            <div class="controls">
                                <input type="text" name="ten_teama" value="<?php echo $capdau['ten_teama'];?>" style="width:80%;"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hình (Team A):</label>
                            <div class="controls">
                                <input type="text" name="hinh_teama" value="<?php echo $capdau['hinh_teama'];?>" style="width:80%;"/>
                                <div>
                                    <?php
                                        if(!empty($capdau['hinh_teama'])){
                                    ?>
                                    <img src="<?php echo $capdau['hinh_teama'];?>" height="100"/>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tỷ lệ (Team A):</label>
                            <div class="controls">
                                <input type="text" name="tyle_teama" value="<?php echo $capdau['tyle_teama'];?>" style="width:80%;"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tên (Team B):</label>
                            <div class="controls">
                                <input type="text" name="ten_teamb" value="<?php echo $capdau['ten_teamb'];?>" style="width:80%;"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hình (Team B):</label>
                            <div class="controls">
                                <input type="text" name="hinh_teamb" value="<?php echo $capdau['hinh_teamb'];?>" style="width:80%;"/>
                                <div>
                                    <?php
                                        if(!empty($capdau['hinh_teamb'])){
                                    ?>
                                    <img src="<?php echo $capdau['hinh_teamb'];?>" height="100"/>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tỷ lệ (Team B):</label>
                            <div class="controls">
                                <input type="text" name="tyle_teamb" value="<?php echo $capdau['tyle_teamb'];?>" style="width:80%;"/>
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
                            <label class="control-label">Kết thúc đặt cược:</label>
                            <div class="controls">
                                <input type="text" class="datetime" name="end_covu" value="<?php echo $end_covu;?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Mức cược:</label>
                            <div class="controls">
                                <input type="text" name="betting" value="<?php echo $items['betting'];?>"/>
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