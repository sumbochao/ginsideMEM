<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.game.mobo.vn/hiepkhach/index.php';
    }else{
        $url_service = 'http://game.mobo.vn/hiepkhach';
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
                    url: "<?php echo $url_service;?>/cms/awardvip/<?php echo $_GET['id']>0?'edit_event?id='.$_GET['id']:'add_event';?>",
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
            <?php include APPPATH . 'views/game/lk/Events/awardvip/tab.php'; ?>
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
                                    <input name="name" id="name" value="<?php echo $items['name'];?>" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nội dung:</label>
                                <div class="controls">
                                    <input name="content_id" id="content_id" value="<?php echo $items['content_id'];?>" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tiêu đề Mail:</label>
                                <div class="controls">
                                    <input name="mail_title" id="mail_title" value="<?php echo $items['mail_title'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nội dung Mail:</label>
                                <div class="controls">
                                    <textarea style="width: 50%;" name="mail_content"><?php echo $items['mail_content'];?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Server:</label>
                                <div class="controls">
                                    <input name="server_ids" id="server_ids" value="<?php echo $items['server_ids'];?>" type="text"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ngày bắt đầu:</label>
                                <div class="controls">
                                    <?php
                                        if(!empty($items['start'])){
                                            $date=date_create($items['start']);
                                            $start = date_format($date,"d-m-Y G:i:s");
                                        }else{
                                            $start = date('d-m-Y G:i:s');
                                        }
                                    ?>
                                    <input type="text" name="start" placeholder="Ngày bắt đầu" value="<?php echo $start;?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ngày kết thúc:</label>
                                <div class="controls">
                                    <?php
                                        if(!empty($items['end'])){
                                            $date=date_create($items['end']);
                                            $end = date_format($date,"d-m-Y G:i:s");
                                        }else{
                                            $end = date('d-m-Y G:i:s');
                                        }
                                    ?>
                                    <input type="text" name="end" placeholder="Ngày kết thúc" value="<?php echo $end;?>"/>
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
$('input[name=start]').datetimepicker({
    dateFormat: 'dd-mm-yy',
    timeFormat: 'hh:mm:ss'//
});
$('input[name=end]').datetimepicker({
    dateFormat: 'dd-mm-yy',
    timeFormat: 'hh:mm:ss'//HH:mm:ss
});
</script>
