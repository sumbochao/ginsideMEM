<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
$url_service = 'http://graph.mobo.vn/v2/';
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
            top:6px;
        }
        .subItems{
            margin-left: 20px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#startdate").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});
            $("#enddate").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});

            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });
//            document.getElementById("icon_mobo_floating").addEventListener("change", readFile);

//            $("input:file").on('change', readFile);
            $("#icon_mobo_floating").on('change', function () {
                if (this.files && this.files[0]) {

                    var FR = new FileReader();

                    FR.addEventListener("load", function (e) {
                        document.getElementById("icon_mobo_floating_img").src = e.target.result;
//                        document.getElementById("icon_mobo_floating_b64").innerHTML = e.target.result;
//                        document.getElementById("icon_mobo_floating_b64").value = e.target.result;
                        $("#icon_mobo_floating_img").attr('height', '150');
                    });

                    FR.readAsDataURL(this.files[0]);
                }
            });

            $("#icon_mobo_unactive").on('change', function () {
                if (this.files && this.files[0]) {

                    var FR = new FileReader();

                    FR.addEventListener("load", function (e) {
                        document.getElementById("icon_mobo_unactive_img").src = e.target.result;
//                        document.getElementById("icon_mobo_unactive_b64").innerHTML = e.target.result;
//                        document.getElementById("icon_mobo_unactive_b64").value = e.target.result;
                        $("#icon_mobo_unactive_img").attr('height', '150');
                    });

                    FR.readAsDataURL(this.files[0]);
                }
            });

            function getlink_img() {
                var formData = new FormData();
                var file = document.getElementById('icon_mobo_unactive').files[0];
                formData.append("FileUpload", file);

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "/?control=gmtoolapi&func=getlink_uri&module=all",
                    data: formData,
                    contentType: false,
                    processData: false,
                }).done(function (result) {
                    console.log(result);
                });
            }

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

//                var data = $("#frmSendChest").serializeArray();
                var data = new FormData($('#frmSendChest')[0]);

//                data.push({ name: "icon_mobo_floating_b64", value: $("#icon_mobo_floating_b64").val() });
//                data.push({ name: "icon_mobo_unactive_b64", value: $("#icon_mobo_unactive_b64").val() });

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "/?control=gmtoolapi&func=edit_init_icon_mobo&module=all",
                    data: data,
                    processData: false,
                    contentType: false,
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

//            function readFile() {
//                if (this.files && this.files[0]) {
//
//                    var FR = new FileReader();
//
//                    FR.addEventListener("load", function (e) {
//                        document.getElementById(this.id+"_img").src = e.target.result;
//                        document.getElementById(this.id+"_b64").innerHTML = e.target.result;
//                    });
//
//                    FR.readAsDataURL(this.files[0]);
//                }
//            }

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
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <div class="control-group">
                                <label class="control-label">Icon Mobo Floating:</label>
                                <div class="controls">
                                    <input type="file" name="icon_mobo_floating" id="icon_mobo_floating">
                                </div>
                                <img id="icon_mobo_floating_img" >
                                <input name="icon_mobo_floating_b64" id="icon_mobo_floating_b64" type="hidden"/>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Icon Mobo Unactive:</label>
                                <div class="controls">
                                    <input type="file" name="icon_mobo_unactive" id="icon_mobo_unactive">
                                </div>
                                <img id="icon_mobo_unactive_img" >
                                <input name="icon_mobo_unactive_b64" id="icon_mobo_unactive_b64" type="hidden"/>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Start date:</label>
                                <div class="controls">
                                    <div id="startdate" name="startdate"></div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">End date:</label>
                                <div class="controls">
                                    <div id="enddate" name="enddate"></div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Service ID (Mã Game):</label>
                                <div class="controls">
                                    <select name="service_id" id="menu_group_id" class="textinput" >
                                        <option value="">Chọn Game</option>
                                        <?php
                                        if (empty($listScopes) !== TRUE) {
                                            foreach ($listScopes as $v) {
                                                $selected = '';
                                                if ($v['service'] == $Item['service_id']) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $v['service']; ?>" <?php echo $selected; ?>><?php echo $v['app_fullname']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
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
        timeFormat: 'hh:mm:ss'//HH:mm:ss
    });
</script>
