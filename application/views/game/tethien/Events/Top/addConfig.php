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
            $("#end_date").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd' });
            var end_date = '<?php echo $end_date; ?>';
            $('#end_date').jqxDateTimeInput('setDate', end_date);

            $('#comeback').on('click', function () {
                window.history.go(-1); return false;
            });

            $('#onSubmit').click(function(){
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;
                $('#frmSendChest').ajaxForm(function (data) {
                    $(".loading").fadeIn("fast");
                    json_data = $.parseJSON($.parseJSON(data));
                    $(".modal-body #messgage").html(json_data.msg);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                    $('#frmSendChest').clearForm();
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
                    <form id="frmSendChest" action="/?control=event_top&func=addConfig" method="POST" enctype="multipart/form-data">

                        <div class="control-group">
                            <label class="control-label">Ngày kết thúc sự kiện:</label>
                            <div class="controls">
                                <div id="end_date" name="end_date"></div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Server ID:</label>
                            <div class="controls">
                                <input name="server_id" value="<?php echo $server_id; ?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Top:</label>
                            <div class="controls">
                                <select name="top">
                                    <option <?php if($top == 'chienluc'){ echo 'selected';}  ?>  value="chienluc">Chiến Lực</option>
                                </select>
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

