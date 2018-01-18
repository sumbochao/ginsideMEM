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

            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            //Load item Details
            load_approval_history_detail(getParameterByName("id"));


            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                data_post = $("#frmSendChest").serializeArray();
                data_post.push({name: 'approved', value: '<?php echo $_SESSION['account']['username'] ?>'});

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://mem.net.vn/cms/toolsalarycollaborator/approved_item",
                    data: data_post,
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

        function load_approval_history_detail(id) {
            $.ajax({
                method: "GET",
                url: "http://mem.net.vn/cms/toolsalarycollaborator/get_approval_item_detail?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#id").val(data["id"]);
                    $("#salary_item_name").val(data["item_name"]);
                    $("#author").val(data["author"]);
                    $("#operation_date").val(data["create_date"]);

                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        }

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
            return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/salarycontributor/managercontributor/item/tab_manageitem.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <i class=" ico-th-large"></i><?php echo $title ?></h5>
                        <div class="control-group">
                            <label class="control-label">Tên Vật Phẩm:</label>
                            <div class="controls">
                                <input name="salary_item_name" id="salary_item_name" type="text" class="span3 validate[required]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Tên Người Tạo:</label>
                            <div class="controls">
                                <input name="author" id="author" type="text" class="span3 validate[required]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Ngày Tạo:</label>
                            <div class="controls">
                                <input name="operation_date" id="operation_date" type="text" class="span3 validate[required]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                <input type="hidden" name='id' id="id">
                                <button id="onSubmit" class="btn btn-primary"><span>Duyệt Item</span></button>
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
