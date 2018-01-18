<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.game.mobo.vn/hiepkhach/index.php';
        $url_pciture = 'http://localhost.game.mobo.vn/hiepkhach';
    }else{
        $url_service = 'http://game.mobo.vn/hiepkhach';
        $url_pciture = $url_service;
    }
    $url_redirect = $_SERVER['REQUEST_URI'];
?>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
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

        label {
            width: auto !important;
            color: #f36926;
        }
        .form-group {
            float: left;
            width: 30%;
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
            top:-17px;
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
                    url: "<?php echo $url_service;?>/cms/crosssale/<?php echo $_GET['id']>0?'edit_requestcat?id='.$_GET['id']:'add_requestcat';?>",
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
            <?php include APPPATH . 'views/game/lk/Events/crosssale/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Config:</label>
                            <div class="controls">
                                <input name="configID" id="configID" value="<?php echo $items['configID'];?>" type="text"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Cấu hình Filter:</label>
                            <div class="controls">
                                <select name="configFitter" class="validate[required,custom[onlyNumberSp]]">
                                    <option value="">Chọn cấu hình</option>
                                    <?php
                                        if(count($configFitter)>0){
                                            foreach($configFitter as $v){
                                    ?>
                                    <option value="<?php echo $v['idx'];?>" <?php echo $v['idx']==$items['configFitter']?'selected="selected"':''; ?>><?php echo $v['name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="content_json_rule">
                            <?php
                                include_once 'common/json_item.php';
                            ?>  
                        </div>
                        <?php
                            $statusOn = 'checked';
                            if($_GET['id']>0){
                                $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                            }
                        ?>
                        <div class="control-group">	
                            <label class="control-label">Game:</label>
                            <div class="controls">
                                <select name="gameID" onchange="getReceiveGame(this.value)" class="validate[required,custom[onlyNumberSp]]">
                                    <option value="">Chọn game</option>
                                    <?php
                                        if(count($slbGame)>0){
                                            foreach($slbGame as $v){
                                    ?>
                                    <option value="<?php echo $v['gameID'];?>" <?php echo ($v['gameID']==$items['gameID'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">	
                            <label class="control-label">Game Receive:</label>
                            <div class="controls loadReceiveGame">
                                <select name="receiveGame" class="validate[required,custom[onlyNumberSp]]">
                                    <option value="">Chọn game receive</option>
                                    <?php
                                        if(count($slbGameReceive)>0){
                                            foreach($slbGameReceive as $v){
                                    ?>
                                    <option value="<?php echo $v['gameID'];?>" <?php echo ($v['gameID']==$items['receiveGame'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input name="namecat" id="namecat" value="<?php echo $items['name'];?>" type="text"/><!-- class="span3 validate[required]" -->
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">URL:</label>
                            <div class="controls">
                                <input name="url_pic" id="url_pic" value="<?php echo $items['url'];?>" type="text"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Order:</label>
                            <div class="controls">
                                <input name="order" id="order" value="<?php echo $items['order'];?>" type="text"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Link Android:</label>
                            <div class="controls">
                                <input name="linkandroid" id="linkandroid" value="<?php echo $items['linkandroid'];?>" type="text"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Link IOS:</label>
                            <div class="controls">
                                <input name="linkios" id="linkios" value="<?php echo $items['linkios'];?>" type="text"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Link WP:</label>
                            <div class="controls">
                                <input name="linkwp" id="linkwp" value="<?php echo $items['linkwp'];?>" type="text"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Mô tả:</label>
                            <div class="controls">
                                <textarea style="width: 50%;" name="desc"><?php echo $items['desc'];?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Date Start:</label>
                            <div class="controls">
                                <?php
                                    if(!empty($items['startDate'])){
                                        $date=date_create($items['startDate']);
                                        $start_date = date_format($date,"d-m-Y G:i:s");
                                    }else{
                                        $start_date = date('d-m-Y G:i:s');
                                    }
                                ?>
                                <input type="text" name="startDate" placeholder="Ngày bắt đầu" value="<?php echo $start_date;?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Date End:</label>
                            <div class="controls">
                                <?php
                                    if(!empty($items['endDate'])){
                                        $date=date_create($items['endDate']);
                                        $end_date = date_format($date,"d-m-Y G:i:s");
                                    }else{
                                        $end_date = date('d-m-Y G:i:s');
                                    }
                                ?>
                                <input type="text" name="endDate" placeholder="Ngày kết thúc" value="<?php echo $end_date;?>"/>
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
    $('input[name=startDate]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
    $('input[name=endDate]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//HH:mm:ss
    });
    function getReceiveGame(id){
        $.ajax({
            url:baseUrl+'/?control=crosssale&func=ajax_receive',
            type:"POST",
            data:{id:id},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.status!="undefined"&&f.status==0){
                    $(".loadReceiveGame").html(f.html);
                    $('.loading_warning').hide();
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $('.loading_warning').hide();
                }
            }
        });
    }
</script>