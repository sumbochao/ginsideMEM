<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script type="text/javascript" src="/libraries/jqwidgets32/jqx-all.js"></script>
<link href='/libraries/jqwidgets32/styles/jqx.base.css' rel='stylesheet' type='text/css'>
<link href='/libraries/jqwidgets32/styles/jqx.classic.css' rel='stylesheet' type='text/css'>
<link href='/libraries/pannonia/pannonia/css/plugins.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/libraries/cms/jquery.form.js"></script>
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
                    url: "<?php echo $url_service;?>/cms/toppay/<?php echo $_GET['id']>0?'edit?id='.$_GET['id']:'add';?>",
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
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                                <i class=" ico-th-large"></i><?php echo $title; ?></h5>
                            <?php
                                $statusOn = 'checked';
                                $start = date('d-m-Y G:i:s',time());
                                $end = date('d-m-Y G:i:s',time());
                                $close = date('d-m-Y G:i:s',time());
                                if($_GET['id']>0){
                                    if(!empty($items['start'])){
                                        $start = date_format(date_create($items['start']),"d-m-Y G:i:s");
                                    }
                                    if(!empty($items['end'])){
                                        $end = date_format(date_create($items['end']),"d-m-Y G:i:s");
                                    }
                                    if(!empty($items['close'])){
                                        $close = date_format(date_create($items['close']),"d-m-Y G:i:s");
                                    }
                                    $statusOn =  $items['status']==1 ? 'checked="checked"':'';
                                    $statusOff =  $items['status']==0 ? 'checked="checked"':'';
                                }
                            ?>
                            <div class="control-group">
                                <label class="control-label">Máy chủ ID:</label>
                                <div class="controls">
                                    <input name="server_id" id="server_id" value="<?php echo $items['server_id'];?>" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tên:</label>
                                <div class="controls">
                                    <input name="name" id="name" value="<?php echo $items['name'];?>" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nội dung:</label>
                                <div class="controls">
                                    <input name="content_id" value="<?php echo $items['content_id'];?>" id="content_id" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Top:</label>
                                <div class="controls">
                                    <input name="top" id="top" value="<?php echo $items['top'];?>" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bắt đầu:</label>
                                <div class="controls">
                                    <input type="text" class="datetime" name="start" value="<?php echo $start;?>"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Kết thúc:</label>
                                <div class="controls">
                                    <input type="text" class="datetime" name="end" value="<?php echo $end;?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Đóng:</label>
                                <div class="controls">
                                    <input type="text" class="datetime" name="close" value="<?php echo $close;?>"/>
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
        timeFormat: 'hh:mm:ss'
    });
</script>
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