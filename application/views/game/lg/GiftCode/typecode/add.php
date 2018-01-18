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
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
             <?php include APPPATH . 'views/game/lg/GiftCode/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" >
                    <div class="well form-horizontal">
                        <h5 class="widget-name">                        
                        <div class="control-group">
                            <label class="control-label">Loại code:</label>
                            <div class="controls">
                                <input name="code_type" id="code_type" value="<?php echo $items['code_type'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                <div style="color:red"><?php echo $errors;?></div>
                            </div>
                        </div>                        
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='game_id' value="<?php echo $_GET['game'];?>">
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