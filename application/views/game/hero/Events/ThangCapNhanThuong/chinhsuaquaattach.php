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
        var tounament_id = getParameterByName("tounament_id");
        $(document).ready(function () {
            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    load_gift_details();
                    $(".loading").fadeOut("fast");
                } else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });

            //Load Tounament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/hero/cms/toolthangcapnhanthuong/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = '';
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    if (tounament_id != null && tounament_id != "") {
                        $("#tournament").val(tounament_id);
                    }

                    load_gift_details();
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });

        function load_gift_details() {
            //Load Gift Details
            var id = getParameterByName("id");
            if (id != null && id != "") {
                $.ajax({
                    method: "GET",
                    url: "http://game.mobo.vn/hero/cms/toolthangcapnhanthuong/load_gift_attach_details?id=" + id,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#item_id").val(data[0]["item_id"]);
                        $("#id").val(data[0]["id"]);
                        $("#item_name").val(data[0]["item_name"]);
                        $("#item_type").val(data[0]["item_type"]);
                        $("#count").val(data[0]["count"]);
                        if (data[0]["status"] == 1) {
                            $('#item_enable').prop('checked', true);
                        } else {
                            $('#item_disable').prop('checked', true);
                        }
                        $("#lvl_group_send").val(data[0]["lvl_group_send"]);
                    },
                    error: function (data) {
                        var obj = $.parseJSON(data);
                    }
                });
            }
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
            <?php include APPPATH . 'views/game/hero/Events/ThangCapNhanThuong/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=thangcapnhanthuong_hero&func=edit_gift_attach&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <i class=" ico-th-large"></i>CHỈNH SỬA QUÀ</h5>
                        <div class="control-group">
                            <label class="control-label">Giải Đấu:</label>
                            <div class="controls">
                                <select id="tournament" name="tournament" class="span4 validate[required]"></select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tên quà:</label>
                            <div class="controls">
                                <input name="item_name" id="item_name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Item ID:</label>
                            <div class="controls">
                                <input name="item_id" id="item_id" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Item Type:</label>
                            <div class="controls">
                                <input name="item_type" id="item_type" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Số lượng:</label>
                            <div class="controls">
                                <input name="count" id="count" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Cấp nhận quà:</label>
                            <div class="controls">
                                <input name="lvl_group_send" id="lvl_group_send" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="catstatus" id="item_enable" value="1" checked="">
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="catstatus" id="item_disable" value="0">
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                <input type="hidden" name='id' id="id">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button type="button" id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
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
