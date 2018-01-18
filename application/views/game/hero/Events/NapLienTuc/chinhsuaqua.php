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
        var type = getParameterByName("type");
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

            //Load Tournament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/hero/cms/toolnaplientuc/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    //Load Gift Details
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
                    url: "http://game.mobo.vn/hero/cms/toolnaplientuc/load_gift_details?id=" + id,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#id").val(data[0]["id"]);
                        $("#item_name").val(data[0]["item_name"]);
                        $("#tournament").val(data[0]["tournament_id"]);
                        $("#condition_date_send").val(data[0]["condition_date_send"]);
                        $("#condition_send_gift").val(data[0]["condition_send_gift"]);
                        if (data[0]["status"] == 1) {
                            $('#gift_status_enable').prop('checked', true);
                        } else {
                            $('#gift_status_disable').prop('checked', true);
                        }
                        var item = $.parseJSON(data[0]["json_item"]);
                        console.log(item);

                        len = item.length;
                        if (len > 1) {
                        }
                        for (var i = 0; i < len; ++i) {
                            console.log(i);
                            if (i > 0) {
                                if (!$('#item_div' + i).length) {
                                    $(".add_more_item").before('<div class="control-group frmedit" id="item_div' + i + '">\n\
                <div class="form-group">\n\
<label class="control-label">Item ' + (i + 1) + ':</label>\n\
<div class="controls">\n\
ID <input name="item_id[' + i + ']" id="item_id' + i + '" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> \n\
Số lượng <input name="count[' + i + ']" id="count' + i + '" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> \n\
Type <input name="type[' + i + ']" id="type' + i + '" type="text" class="span3 validate[required]" />\n\
</div>\n\
</div>\n\
</div>');
                                }
                                $("#item_id" + i).val(item[i].item_id);
                                $("#count" + i).val(item[i].count);
                                $("#type" + i).val(item[i].type);
                            } else {
                                $("#item_id" + i).val(item[i].item_id);
                                $("#count" + i).val(item[i].count);
                                $("#type" + i).val(item[i].type);
                            }
                        }

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

        $(document).on('click', '#btn_add_more_item', function () {
            k = $('.frmedit').length;
            $(".add_more_item").before('<div class="control-group frmedit">\n\
    <div class="form-group">\n\
<label class="control-label">Item ' + (k + 1) + ':</label>\n\
<div class="controls">\n\
ID <input name="item_id[' + k + ']" id="item_id_' + k + '" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> \n\
Số lượng <input name="count[' + k + ']" id="count_' + k + '" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> \n\
Type <input name="type[' + k + ']" id="type_' + k + '" type="text" class="span3 validate[required]" />\n\
</div>\n\
</div>\n\
</div>');
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/hero/Events/NapLienTuc/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=naplientuc_hero&func=edit_gift&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <i class=" ico-th-large"></i>CHỈNH SỬA QUÀ</h5>
                        <div class="control-group">
                            <label class="control-label">Event:</label>
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

                        <div class="control-group">
                            <label class="control-label">Thứ tự ngày trong chuỗi ngày liên tục:</label>
                            <div class="controls">
                                <input name="condition_date_send" id="condition_date_send" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Điều kiện nạp để nhận quà:</label>
                            <div class="controls">
                                <input name="condition_send_gift" id="condition_send_gift" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>

                        <div class="control-group frmedit" id="item_div0">
                            <div class="form-group">
                                <label class="control-label">Item 1:</label>
                                <div class="controls">
                                    ID <input name="item_id[0]" id="item_id0" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Số lượng <input name="count[0]" id="count0" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Type <input name="type[0]" id="type0" type="text" class="span3 validate[required]" /> 
                                </div>
                            </div>                            
                        </div>

                        <div class="add_more_item"></div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="button" id="btn_add_more_item" value="Thêm Item">
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="gift_status" id="gift_status_enable" value="1" checked="">
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="gift_status" id="gift_status_disable" value="0">
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
