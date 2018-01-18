<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    $url_redirect = $_SERVER['REQUEST_URI'];
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

            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                    <?php
                        if($_GET['id']>0){
                    ?>
                    //window.location.href='<?php echo $url_redirect;?>';
                    <?php
                        }
                    ?>
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });
        function loadPage(area, url){
            $(area).load(url);
	}
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/koa/Events/uocnguyen/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="/?control=uocnguyen_koa&func=post_item" method="POST" enctype="multipart/form-data">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                            <div class="control-group">
                                <label class="control-label">Tên:</label>
                                <div class="controls">
                                    <input name="item_name" id="item_name" value="<?php echo $items['item_name'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Picture:</label>
                                <div class="controls">
                                    <input type="file" name="image"/>
                                    <?php
                                        if($_GET['id']>0){
                                    ?>
                                    <div id="load-content" style="margin-top:10px;">
                                        <?php
                                            if(!empty($items['image'])){
                                                $removeLink = $url_service.'/cms/uocnguyen/remove_image?id='.$items['item_id'];
                                        ?>
                                        <img src="<?php echo $url_picture.'/'.$items['image'];?>" height="100px"/>
                                        <div style="padding-top:5px;"><a href="javascript:loadPage('div#load-content','<?php echo $removeLink;?>')">remove</a></div>
                                        <?php
                                            }
                                        ?>

                                        <input type="hidden" class="span12" id="current_image" name="current_image" value="<?php echo $items['image'];?>"/>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Số lượng:</label>
                                <div class="controls">
                                    <input name="quantity" id="quantity" value="<?php echo $items['quantity'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <?php
                                        if($_GET['id']>0){
                                    ?>
                                    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
                                    <?php
                                        }
                                    ?>
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
