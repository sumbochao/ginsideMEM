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
            $('#create_tournament').on('click', function () {
                window.location.href = '/?control=event_bongda_bog&func=themgiaidau&module=all#giaidau';
            });

            $("#tournament").change(function () {
                load_tournament_detail($(this).val());
            });

            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");

                    //Load Tournament Details
                    load_tournament_detail($("#tournament").val());
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });

        $(document).ready(function () {
            //Set DateTime Format
            $("#tournament_date_start").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#tournament_date_end").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            $("#startdate_reward").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#enddate_reward").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            //Load Tournament List
            $.ajax({
                method: "GET",
                url: "<?php echo $url_service;?>/cms/toolbongda/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    //Load Tournament Details
                    load_tournament_detail($("#tournament").val());
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

        });

        function load_tournament_detail(id) {
            $("#tournament_img").attr('src', '/assets/img/loading_large.gif');
            $.ajax({
                method: "GET",
                url: "<?php echo $url_service;?>/cms/toolbongda/tournament_get_by_id?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#id").val(data[0]["id"]);
                    var tournament_date_start = null;
                    if (data[0]["tournament_date_start"] != "" && data[0]["tournament_date_start"] != null) {
                        tournament_date_start = new Date(data[0]["tournament_date_start"]);
                    }
                    var tournament_date_end = null;
                    if (data[0]["tournament_date_end"] != "" && data[0]["tournament_date_end"] != null) {
                        tournament_date_end = new Date(data[0]["tournament_date_end"]);
                    }
                    var tournament_date_start_reward = null;;
                    if (data[0]["tournament_date_start_reward"] != "" && data[0]["tournament_date_start_reward"] != null) {
                        tournament_date_start_reward = new Date(data[0]["tournament_date_start_reward"]);
                    }
                    var tournament_date_end_reward = null;;
                    if (data[0]["tournament_date_end_reward"] != "" && data[0]["tournament_date_end_reward"] != null) {
                        tournament_date_end_reward = new Date(data[0]["tournament_date_end_reward"]);
                    }

                    $("#tournament_img_text").val(data[0]["tournament_img"]);
                    $("#tournament_img").attr('src', data[0]["tournament_img"]);
                    $(".date_start").text(data[0]["tournament_date_start"]);
                    $(".date_end").text(data[0]["tournament_date_end"]);
                    $("#tournament_date_start").jqxDateTimeInput('setDate', tournament_date_start);
                    $("#tournament_date_end").jqxDateTimeInput('setDate', tournament_date_end);
                    $("#startdate_reward").jqxDateTimeInput('setDate', tournament_date_start_reward);
                    $("#enddate_reward").jqxDateTimeInput('setDate', tournament_date_end_reward);

                    $("#tournament_server_list").val(data[0]["tournament_server_list"]);

                    if (data[0]["tournament_status"] == 1) {
                        $('#tournament_enable').prop('checked', true);
                    }
                    else {
                        $('#tournament_disable').prop('checked', true);
                    }

                    $("#tournament_ip_list").val(data[0]["tournament_ip_list"]);

                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/bog/Events/BongDa/tab.php'; ?>
            <div class="widget-name">

                <!-- <div class="tabs">
                   <a href="/cms/ep/promotion_lato/thongke"><i class=" ico-th-large"></i>THỐNG KÊ</a> 
                   <a href="/cms/ep/promotion_lato/tralogdoiqua"><i class=" ico-th-large"></i>TRA LOG ĐỔI QUÀ</a>
				   <a href="javascript:void(0);" class="clearcached"><i class=" ico-th-large"></i>CLEAR MENCACHED</a>
                </div>-->
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=event_bongda_bog&func=edit_tournament_details&module=all" method="POST" enctype="multipart/form-data">
                        <div class="control-group">
                            <label class="control-label">Giải đấu:</label>
                            <div class="controls">
                                <select id="tournament" name="tournament" class="span4 validate[required]" /></select> 
                                <button type="button" id="create_tournament" class="btn btn-primary btn-sm" style="margin-bottom: 10px"><span>THÊM MỚI GIẢI ĐẤU</span></button>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hình ảnh đang sử dụng:</label>
                            <div class="controls">
                                <img id="tournament_img" src="/assets/img/loading_large.gif" height="100px" />
                                <input type="hidden" class="span12" id="tournament_img_text" name="tournament_img_text" />   
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Cập nhật hình ảnh:</label>
                            <div class="controls">
                                <input type="file" name="tournament_img" /> (Ảnh không được lớn hơn 700KB)
                            </div>
                        </div>                        
                        <div class="control-group">
                            <label class="control-label">Bắt đầu:</label>
                            <div class="controls">
                                <div id="tournament_date_start" class="tournament_date_start" name="tournament_date_start"></div>
                                <div class="date_start"></div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kết thúc:</label>
                            <div class="controls">
                                <div id="tournament_date_end" class="tournament_date_end" name="tournament_date_end"></div>
                                <div class="date_end"></div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Server:</label>
                            <div class="controls">
                                <textarea name="tournament_server_list" id="tournament_server_list" type="text" class="span3 validate[required]" style="margin: 0px; width: 295px; height: 60px;"></textarea>
                                (ID Server cách nhau dấu ";")
                            </div>
                        </div>

                        <div class="control-group frmedit" style="display: none;">
                            <div class="form-group">
                                <label class="control-label">Bắt đầu nhận thưởng:</label>
                                <div id="startdate_reward" name="startdate_reward"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kết thúc nhận thưởng:</label>
                                <div id="enddate_reward" name="enddate_reward"></div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="tournament_status" id="tournament_enable" value="1" <?php //echo $statusOn;?>>
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="tournament_status" id="tournament_disable" value="0" <?php //echo $statusOff; ?>>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Nhóm IP:</label>
                            <div class="controls">
                                <textarea name="tournament_ip_list" id="tournament_ip_list" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;"></textarea>
                                (Dãy IP cách nhau dấu ";")
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='id' id="id">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
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
