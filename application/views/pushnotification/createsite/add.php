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
    <script type="text/javascript">
        var certP12file = '';
        var certPushfile = '';
        var iconfile = '';

        $(document).ready(function () {

            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;
                if ($('#fileuploadcertP12').prop('files')[0] == undefined) {
                    alert("certP12 file can't empty");
                    return false;
                }
                if ($('#fileuploadcertPush').prop('files')[0] == undefined) {
                    alert("certPush file can't empty");
                    return false;
                }
                if ($('#fileuploadicon').prop('files')[0] == undefined) {
                    alert("icon file can't empty");
                    return false;
                }
                if (iconfile == '') {
                    iconfile = new Promise((resolve, reject) => {
                        var get_img = uploadfile($('#fileuploadicon').prop('files')[0], "uploadIcon");
                        resolve(get_img);
                    }).then(function(result){
                        return result
                    });
                }
                if (certP12file == '') {
                    certP12file = new Promise((resolve, reject) => {
                        var get_img = uploadfile($('#fileuploadcertP12').prop('files')[0], "uploadcert");
                        resolve(get_img);
                    });
                }
                if (certPushfile == '') {
                    certPushfile = new Promise((resolve, reject) => {
                        var get_img = uploadfile($('#fileuploadcertPush').prop('files')[0], "uploadcert");
                        resolve(get_img);
                        
                    });
                }

                Promise.all([iconfile, certP12file, certPushfile])
                .then(function(result) {
                    if (iconfile != '' && certP12file != '' && certPushfile != '') {
                      saveNewSite(result);
                  }
                }) 

            });
        });


        function uploadfile(file, uploadfuntext) {
            
            return new Promise((resolve, reject) => {
                var data = new FormData();
                data.append('domain', $("#notification-domain").val());
                data.append('file', file);
                var url = "<?php echo $url_service; ?>/" + uploadfuntext;
                var temp = "";
                // append other variables to data if you want: data.append('field_name_x', field_value_x);
                $.ajax({
                    type: 'POST',
                    processData: false, // important
                    contentType: false, // important
                    data: data,
                    url: url,
                    dataType: 'json',
                    success: function (jsonData) {
                        console.log(jsonData);
                        if (jsonData.code) {
                            temp = jsonData.filename;
                            resolve(temp);
                        }else{
                            reject("Error");
                        }
                    }
                });
                
            });
        }

        function saveNewSite(arrayfilenames) {
            var saveData = $('#frmSendChest').serializeArray();
            var result = {};
            $.each(saveData, function () {
                result[this.name] = this.value;
            });
            result["certP12file"] = arrayfilenames[1];
            result["certPushfile"] = arrayfilenames[2];
            result["iconfile"] = arrayfilenames[0];

            console.log(result);
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo $url_service; ?>/api/saveNewSite",
                data: result,
                beforeSend: function () {
                    $(".loading").fadeIn("fast");
                }
            }).done(function (data) {
                console.log(data);
                $(".modal-body #messgage").html(data.message);
                $('.bs-example-modal-sm').modal('show');
                $(".loading").fadeOut("fast");

            });
        }

    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/pushnotification/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Domain:</label>
                            <div class="controls">
                                <input name="domain" value="" type="text" style="width: 80%" id="notification-domain"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Web Push ID (safari):</label>
                            <div class="controls">
                                <input name="webpushid" value="" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Website Name:</label>
                            <div class="controls">
                                <input name="websiteName" value="" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Allowed Domains:</label>
                            <div class="controls">
                                <input name="allowedDomains" value="" type="text" style="width: 80%"/>
                                <div style="font-style: italic;color: #999;margin-top: 5px;">Cách nhau dấu ,</div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Web Service URL:</label>
                            <div class="controls">
                                <input name="webServiceURL" value="" type="text" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">certP12 file's:</label>
                            <div class="controls">
                                <input name="certP12file" id="fileuploadcertP12" type="file" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">certPush file:</label>
                            <div class="controls">
                                <input name="certPushfile" id="fileuploadcertPush" type="file" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Notification icon:</label>
                            <div class="controls">
                                <input name="icon" id="fileuploadicon" type="file" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">cert Password:</label>
                            <div class="controls">
                                <input name="certPasswd" value="" type="text" style="width: 80%"/>
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