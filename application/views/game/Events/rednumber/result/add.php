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
    .item_rule > .rows > .title{
        float: left;
        margin-right: 10px;
        margin-top:5px;
    }
    .item_rule > .rows > .input{
        float: left;
        padding-right: 5px;
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
                url: "<?php echo $url_service;?>/cms/rednumber/add_result",
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
                            $create_date = date('d-m-Y G:i:s',time());
                            if($_GET['id']>0){
                                if(!empty($items['create_date'])){
                                    $create_date = date_format(date_create($items['create_date']),"d-m-Y G:i:s");
                                }else{
                                    $create_date = date('d-m-Y G:i:s',time());
                                }
                            }
                        ?>
                        <div class="control-group">
                            <label class="control-label">Giải thưởng:</label>
                            <div class="controls">
                                <?php
                                    if(count($listPrizes)>0){
                                        foreach($listPrizes as $v){

                                ?>
                                <div class="item_rule">
                                    <div class="rows">
                                        <div class="title">Giải thưởng</div>
                                        <div class="input"><input type="text" placeholder="Nhập Giải thưởng" value="<?php echo $v['id'];?>" name="id_prizes[<?php echo $v['id'];?>]" disabled="disabled"/></div>
                                    </div>
                                    <div class="rows">
                                        <div class="title">Kết quả</div>
                                        <div class="input"><input type="text" placeholder="Nhập Kết quả" value="" name="result[<?php echo $v['id'];?>]" size="20"/></div>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='turn' value="<?php echo $_GET['tid'];?>">
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
