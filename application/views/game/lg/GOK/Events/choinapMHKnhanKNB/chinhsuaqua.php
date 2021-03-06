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
        $(function () {
            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            $("#tournament").change(function () {

            });

            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    var id = getParameterByName("id");
                    if (id !== null && id !== "") {
                        get_doivatpham_gift_details(id);
                    }
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                } else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });

        $(document).ready(function () {
            $("#start").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});
            $("#end").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});
            $("#set_create_DPTK").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});
            $("#end_date_get_card_MHK").jqxDateTimeInput({width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss'});

            //Load Tournament List
            $.ajax({
                method: "GET",
                dataType: 'jsonp',
                url: "https://sev-cok.addgold.net/ToolchoinapMHKnhanKNB/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data;
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    var tournament_id = getParameterByName("tournament_id");
                    if (tournament_id !== null && tournament_id !== "") {
                        $("#tournament").val(tournament_id);
                    }

                    var id = getParameterByName("id");
                    if (id !== null && id !== "") {
                        get_doivatpham_gift_details(id);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });

        //Load Gift VIP Details
        function get_doivatpham_gift_details(id) {
            $.ajax({
                method: "GET",
                dataType: 'jsonp',
                url: "https://sev-cok.addgold.net/ToolchoinapMHKnhanKNB/get_doivatpham_gift_details?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    //Load Reward Details  
                    if (data.length > 0) {
                        $("#id").val(data[0]["id"]);
                        $("#event_id").val(data[0]["event_id"]);
                        $("#server_id").val(data[0]["server_id"]);

                        var start = null;
                        if (data[0]["start"] != "" && data[0]["start"] != null) {
                            start = new Date(data[0]["start"]);
                        }
                        var end = null;
                        if (data[0]["end"] != "" && data[0]["end"] != null) {
                            end = new Date(data[0]["end"]);
                        }
                        var set_create_KOK = null;
                        if (data[0]["set_create_KOK"] != "" && data[0]["set_create_KOK"] != null) {
                            set_create_KOK = new Date(data[0]["set_create_KOK"]);
                        }
                        var end_date_get_card_MHK = null;
                        if (data[0]["end_date_get_card_MHK"] != "" && data[0]["end_date_get_card_MHK"] != null) {
                            end_date_get_card_MHK = new Date(data[0]["end_date_get_card_MHK"]);
                        }

                        $("#start").jqxDateTimeInput('setDate', start);
                        $("#end").jqxDateTimeInput('setDate', end);
                        $("#set_create_KOK").jqxDateTimeInput('setDate', set_create_KOK);
                        $("#end_date_get_card_MHK").jqxDateTimeInput('setDate', end_date_get_card_MHK);

                        if (data[0]["status"] == 1) {
                            $('#status_enable').prop('checked', true);
                        } else {
                            $('#status_disable').prop('checked', true);
                        }
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
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/lg/GOK/Events/choinapMHKnhanKNB/tab.php'; ?>
            <div class="widget-name">              
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=choinapmhknhanknb_gok&module=all&func=edit_doivatpham_gift" method="POST" enctype="multipart/form-data">
                        <div class="widget row-fluid">
                            <div class="well form-horizontal">
                                <h5 class="widget-name">
                                    <i class=" ico-th-large"></i>CHỈNH SỬA QUÀ</h5>
                                <div class="control-group">
                                    <label class="control-label">Sự kiện:</label>
                                    <div class="controls">
                                        <select id="tournament" name="tournament" class="span4 validate[required]" />										
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Server Id:</label>
                                    <div class="controls">
                                        <input name="server_id" id="server_id" type="text" class="span3" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Bắt đầu:</label>
                                    <div class="controls">
                                        <div id="start" name="startdate"></div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Kết thúc:</label>
                                    <div class="controls">
                                        <div id="end" name="enddate"></div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Điều kiện - Thời gian tạo nhân vật trong game KOK:</label>
                                    <div class="controls">
                                        <div id="set_create_KOK" name="set_create_KOK"></div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Điều kiện - Ngày cuối cùng tính thẻ nạp trong MHK:</label>
                                    <div class="controls">
                                        <div id="end_date_get_card_MHK" name="end_date_get_card_MHK"></div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Trạng thái:</label>
                                    <div class="controls">
                                        Enable:<input type="radio" name="status" id="status_enable" value="1" checked="">
                                        &nbsp;&nbsp;
                                        Disable:<input type="radio" name="status" id="status_disable" value="0">
                                    </div>
                                </div>



                                <div class="control-group">
                                    <div style="padding-left: 20%; text-align: left;">
                                        <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                        <input type="hidden" name='id' id="id">
                                        <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                        <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>                                        
                                        <div style="display: inline-block">
                                            <span id="message" style="color: green"></span>
                                        </div>
                                    </div>
                                </div>
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
