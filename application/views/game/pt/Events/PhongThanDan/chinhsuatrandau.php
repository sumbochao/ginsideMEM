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
            $("#match_start_date").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#match_end_date").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#match_end_pet_date").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            $('#comeback').on('click', function () {
                window.location.href = '/cms/ep/toolphongthandan/trandau';
            });

            //Load tournament list
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/phongthan/cms/toolphongthandan/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament_id").html(tourlist);
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            load_match_details();

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
                    load_match_details();
                    $(".loading").fadeOut("fast");
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });

        function load_match_details() {
            //Load Match Details
            var id = getParameterByName("id");
            if (id != null && id != "") {
                $.ajax({
                    method: "GET",
                    url: "http://game.mobo.vn/phongthan/cms/toolphongthandan/load_match_details?id=" + id,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#tournament_id").val(data[0]["tournament_id"]);
                        $("#id").val(data[0]["id"]);

                        var match_start_date = null;
                        if (data[0]["match_start_date"] != "" && data[0]["match_start_date"] != null) {
                            match_start_date = new Date(data[0]["match_start_date"]);
                        }
                        var match_end_date = null;;
                        if (data[0]["match_end_date"] != "" && data[0]["match_end_date"] != null) {
                            match_end_date = new Date(data[0]["match_end_date"]);
                        }
                        var match_end_pet_date = null;;
                        if (data[0]["match_end_pet_date"] != "" && data[0]["match_end_pet_date"] != null) {
                            match_end_pet_date = new Date(data[0]["match_end_pet_date"]);
                        }

                        $("#match_start_date").jqxDateTimeInput('setDate', match_start_date);
                        $("#match_end_date").jqxDateTimeInput('setDate', match_end_date);
                        $("#match_end_pet_date").jqxDateTimeInput('setDate', match_end_pet_date);

                        $("#match_team_name_a").val(data[0]["match_team_name_a"]);

                        $("#match_team_img_a_text").val(data[0]["match_team_img_a"]);
                        $("#match_team_img_a").attr('src', data[0]["match_team_img_a"]);

                        $("#match_team_chap_a").val(data[0]["match_team_chap_a"]);
                        $("#match_team_win_rate_a").val(data[0]["match_team_win_rate_a"]);

                        $("#match_team_name_b").val(data[0]["match_team_name_b"]);

                        $("#match_team_img_b_text").val(data[0]["match_team_img_b"]);
                        $("#match_team_img_b").attr('src', data[0]["match_team_img_b"]);

                        $("#match_team_chap_b").val(data[0]["match_team_chap_b"]);
                        $("#match_team_win_rate_b").val(data[0]["match_team_win_rate_b"]);

                        if (data[0]["match_status"] == 1) {
                            $('#match_status_enable').prop('checked', true);
                        }
                        else {
                            $('#match_status_disable').prop('checked', true);
                        }

                        $("#match_pet_max").val(data[0]["match_pet_max"]);

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
            <?php include APPPATH . 'views/game/pt/Events/PhongThanDan/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=event_covu_pt&func=edit_match_details" method="POST" enctype="multipart/form-data">
                    <div class="widget row-fluid">
                        <div class="well form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Giải đấu:</label>
                                <div class="controls">
                                    <select id="tournament_id" name="tournament_id" class="span4 validate[required]" />
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Đội A:</label>
                                <div class="controls">
                                    <input name="match_team_name_a" id="match_team_name_a" type="text" class="span3 validate[required]" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Chấp:</label>
                                <div class="controls">
                                    <input name="match_team_chap_a" id="match_team_chap_a" type="text" class="span3 validate[required,custom[number]]" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Tỷ lệ thắng:</label>
                                <div class="controls">
                                    <input name="match_team_win_rate_a" id="match_team_win_rate_a" type="text" class="span3 validate[required,custom[number]]" />
                                </div>
                            </div>
                            <div class="control-group">
                            <label class="control-label">Hình ảnh đội A đang sử dụng:</label>
                            <div class="controls">
                                <img id="match_team_img_a" src="/assets/img/loading_large.gif" height="100px" />
                                <input type="hidden" class="span12" id="match_team_img_a_text" name="match_team_img_a_text" />   
                            </div>
                        </div>
                            <div class="control-group">
                                <label class="control-label">Cập nhật hình đội A:</label>
                                <div class="controls">
                                   <input type="file" name="match_team_img_a" /> (Ảnh không được lớn hơn 700KB) 
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Đội B:</label>
                                <div class="controls">
                                    <input name="match_team_name_b" id="match_team_name_b" type="text" class="span3 validate[required]" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Chấp:</label>
                                <div class="controls">
                                    <input name="match_team_chap_b" id="match_team_chap_b" type="text" class="span3 validate[required,custom[number]]" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Tỷ lệ thắng:</label>
                                <div class="controls">
                                    <input name="match_team_win_rate_b" id="match_team_win_rate_b" type="text" class="span3 validate[required,custom[number]]" />
                                </div>
                            </div>

                            <div class="control-group">
                            <label class="control-label">Hình ảnh đội B đang sử dụng:</label>
                            <div class="controls">
                                <img id="match_team_img_b" src="/assets/img/loading_large.gif" height="100px" />
                                <input type="hidden" class="span12" id="match_team_img_b_text" name="match_team_img_b_text" />   
                            </div>
                        </div>

                            <div class="control-group">
                                <label class="control-label">Cập nhật hình đội B:</label>
                                <div class="controls">
                                    <input type="file" name="match_team_img_b" /> (Ảnh không được lớn hơn 700KB) 
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Bắt đầu:</label>
                                <div class="controls">
                                    <div id="match_start_date" name="match_start_date"></div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Kết thúc:</label>
                                <div class="controls">
                                    <div id="match_end_date" name="match_end_date"></div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Kết thúc cỗ vũ:</label>
                                <div class="controls">
                                    <div id="match_end_pet_date" name="match_end_pet_date"></div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="match_status" id="match_status_enable" value="1" checked="">
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="match_status" id="match_status_disable" value="0">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Cược tối đa:</label>
                                <div class="controls">
                                    <input name="match_pet_max" id="match_pet_max" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">                                  
                                    <input type="hidden" name='id' id="id">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                    <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                    <button id="comeback" type="button" class="btn btn-primary"><span>Quay lại</span></button>
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
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
