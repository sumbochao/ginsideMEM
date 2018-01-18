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
    </style>
    <script type="text/javascript">

        $(document).ready(function () {


            //Set DateTime Format
            $("#start_time").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#end_time").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            var start_time = '<?php echo $pack->start_time; ?>';
            $('#start_time').jqxDateTimeInput('setDate', start_time);
            var end_time = '<?php echo $pack->end_time; ?>';
            $('#end_time').jqxDateTimeInput('setDate', end_time);

            $('#comeback').on('click', function () {
                window.history.go(-1); return false;
            });

            $('#onSubmit').click(function(){
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                $('#frmSendChest').ajaxForm(function (data) {
                    $(".modal-body #messgage").html(data);
                    $('.bs-example-modal-sm').modal('show');
                    $('#frmSendChest').clearForm();
                    $(".loading").fadeOut("fast");
                });
            })
        });

    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">

            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=shopuydanh&func=addConfigBangDiem&module=all" method="POST" enctype="multipart/form-data">
                        <div class="control-group">
                            <label class="control-label">Bắt đầu:</label>
                            <div class="controls">
                                <div id="start_time" name="start_time"></div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kết thúc:</label>
                            <div class="controls">
                                <div id="end_time" name="end_time"></div>
                            </div>
                        </div>
						
                        <div class="control-group">
                            <label class="control-label">Danh sách Server:</label>
                            <div class="controls">
                                <textarea name="server_list" id="server_list" type="text" class="span3 validate[required]" style="margin: 0px; width: 295px; height: 60px;"><?php echo $pack->server_list ?></textarea>
                                (ID Server cách nhau dấu ",")
                            </div>
                        </div>


                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button type="button" id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>

