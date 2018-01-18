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

            //Load User Details
            load_approval_history_detail(getParameterByName("id"));


            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                data_post = $("#frmSendChest").serializeArray();
                data_post.push({name: 'last_approved_salary', value: '<?php echo $_SESSION['account']['username'] ?>'});

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://mem.net.vn/cms/toolsalarycollaborator/editsalary",
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
                url: "http://mem.net.vn/cms/toolsalarycollaborator/get_approval_history_detail?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    console.log(data);
                    $("#id").val(data["id"]);
                    $("#salary_colloborator_id").val(data["salary_colloborator_id"]);
                    $("#mobo_id").val(data["mobo_id"]);
                    $("#name").val(data["name"]);
                    $("#last_propose").val(data["last_propose"]);
                    $("#created_date").val(data["created_date"]);
                    $("#info_propose").val(data["info_propose"]);
                    $("#salary_change").val(data["salary_change"]);
                    $("#game_name").val(data["game_name"]);
                    type_propose = data["type_propose"];
                    if (type_propose == 0) {
                        $("#type_propose_text").val('Tăng lương');
                        $("#type_propose").val(0);
                    } else {
                        $("#type_propose_text").val('Trừ lương');
                        $("#type_propose").val(1);
                    }
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
            <?php include APPPATH . 'views/salarycontributor/managercontributor/salary/tab_managesalary.php'; ?>
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
                            <label class="control-label">Mobo ID:</label>
                            <div class="controls">
                                <input name="mobo_id" id="mobo_id" type="text" class="span3 validate[required,custom[onlyNumberSp]]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Tên CTV:</label>
                            <div class="controls">
                                <input name="name" id="name" type="text" class="span3 validate[required]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Số Điểm Đề Xuất:</label>
                            <div class="controls">
                                <input name="salary_change" id="salary_change" type="text" class="span3 validate[required,custom[onlyNumberSp]]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Game Đề Xuất:</label>
                            <div class="controls">
                                <input name="game_name" id="game_name" type="text" class="span3 validate[required]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kiểu đề Xuất:</label>
                            <div class="controls">
                                <input name="type_propose_text" id="type_propose_text" type="text" class="span3 validate[required]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Người Đề Xuất:</label>
                            <div class="controls">
                                <input name="last_propose" id="last_propose" type="text" class="span3 validate[required]]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Ngày Đề Xuất:</label>
                            <div class="controls">
                                <input name="created_date" id="created_date" type="text" class="span3 validate[required]" readonly style="background: cornsilk;"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Thông tin đề xuất:</label>
                            <div class="controls">
                                <textarea readonly name="info_propose" id="info_propose" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;" style="background: cornsilk;"></textarea>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái duyệt:</label>
                            <div class="controls">
                                Duyệt lần 1:<input type="radio" name="approval_salary_status" id="approval_salary_status" value="1" checked="">
                                &nbsp;&nbsp;
                                Từ chối:<input type="radio" name="approval_salary_status" id="approval_salary_status" value="2">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Thông tin duyệt hoặc không :</label>
                            <div class="controls">
                                <textarea name="info_approved" id="info_approved" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;"></textarea>
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                <input type="hidden" name='id' id="id">
                                <input type="hidden" name='type_propose' id="type_propose">
                                <input type="hidden" name='salary_colloborator_id' id="salary_colloborator_id">
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
