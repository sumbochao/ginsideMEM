<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.game.mobo.vn/tieuhiep/index.php';
    }else{
        $url_service = 'http://game.mobo.vn/tieuhiep';
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
        input.span3, textarea.span3, .uneditable-input.span3{
            width: 160px;
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
                    url: "<?php echo $url_service;?>/cms/awardvip/<?php echo $_GET['id']>0?'edit_config?id='.$_GET['id']:'add_config';?>",
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
            <?php include APPPATH . 'views/game/tieuhiep/Events/awardvip/tab.php'; ?>
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
                                <label class="control-label">Item:</label>
                                <div class="controls">
                                    <select name="item_id" class="validate[required,custom[onlyNumberSp]]">
                                        <option value="">Chọn Item</option>
                                        <?php
                                            if(count($slbItem)>0){
                                                foreach($slbItem as $v){
                                        ?>
                                        <option value="<?php echo $v['id'];?>" <?php echo ($v['id']==$items['item_id'])?'selected="selected"':'';?>><?php echo $v['itemname'];?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Điền kiện:</label>
                                <div class="controls">
                                    <?php
                                        if($_GET['id']>0){
                                            $conditions = json_decode($items['conditions'],true);
                                        }
                                    ?>
                                    Gold: <input name="gold" id="gold" value="<?php echo $conditions['gold'];?>" type="text" class="span3 validate[required]" />
                                    From: <input name="from" id="from" value="<?php echo $conditions['from'];?>" type="text" class="span3 validate[required]" />
                                    To: <input name="to" id="to" value="<?php echo $conditions['to'];?>" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Sự kiện:</label>
                                <div class="controls">
                                    <select name="event_id" class="validate[required,custom[onlyNumberSp]]">
                                        <option value="">Chọn sự kiện</option>
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
