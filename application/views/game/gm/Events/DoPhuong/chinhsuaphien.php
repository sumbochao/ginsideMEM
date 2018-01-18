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
            var room_id = getParameterByName("room_id");

            $("#session_time_start").jqxDateTimeInput({width: '100px', height: '28px', formatString: 'HH:mm:ss'});
            $("#session_time_end").jqxDateTimeInput({width: '100px', height: '28px', formatString: 'HH:mm:ss'});

            $('#comeback').on('click', function () {
                if (room_id != null && room_id != "") {
                    window.location.href = '/?control=dophuong_gm&func=quanlyphien&room_id=' + room_id + '#quanlyphien';
                }
                else {
                    window.location.href = '/?control=dophuong_gm&func=quanlyphien#quanlyphien';
                }
            });

            //Load Room List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/giangma/cms/tooldophuong/room_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["room_name"] + '</option>';
                    });

                    $("#room_id").html(tourlist);

                    if (room_id != null && room_id != "") {
                        $("#room_id").val(room_id);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            //Load Session Details
            var id = getParameterByName("id");
            if (id != null && id != "") {
                $.ajax({
                    method: "GET",
                    url: "http://game.mobo.vn/giangma/cms/tooldophuong/load_session_details?id=" + id,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#id").val(data[0]["id"]);

                        var session_time_start = null;
                        if (data[0]["session_time_start"] != "" && data[0]["session_time_start"] != null) {
                            session_time_start = new Date("2015-10-21 " + data[0]["session_time_start"]);
                        }
                        var session_time_end = null;
                        ;
                        if (data[0]["session_time_end"] != "" && data[0]["session_time_end"] != null) {
                            session_time_end = new Date("2015-10-21 " + data[0]["session_time_end"]);
                        }

                        $("#session_time_start").jqxDateTimeInput('setDate', session_time_start);
                        $("#session_time_end").jqxDateTimeInput('setDate', session_time_end);

                        $("#session_name").val(data[0]["session_name"]);

                        if (data[0]["session_status"] == 1) {
                            $('#session_enable').prop('checked', true);
                        }
                        else {
                            $('#session_disable').prop('checked', true);
                        }

                        $("#session_bonus_rate").val(data[0]["session_bonus_rate"]);
                        
                        $("#max_user").val(data[0]["max_user"]);

                    },
                    error: function (data) {
                        var obj = $.parseJSON(data);
                    }
                });
            }

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/giangma/cms/tooldophuong/edit_session",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        // load your loading fiel here
                        $('#message').attr("style", "color:green");
                        $('#message').html('Đang xử lý ...');
                    }
                }).done(function (result) {
                    console.log(result);
                    //hide your loading file here
                    if (result.status == false)
                        $('#message').attr("style", "color:red");

                    $('#message').html(result.message);
                });
            });
        });

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
            <?php include APPPATH . 'views/game/gm/Events/DoPhuong/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="widget row-fluid">
                            <div class="well form-horizontal">   
                                <div class="control-group">
                                    <label class="control-label">Phòng:</label>
                                    <div class="controls">
                                        <select id="room_id" name="room_id" class="span4 validate[required]" />										
                                        </select>
                                    </div>
                                </div>  
                                <div class="control-group">
                                    <label class="control-label">Tên phiên:</label>
                                    <div class="controls">
                                        <input name="session_name" id="session_name" type="text" class="span3 validate[required]" />
                                    </div>
                                </div>                         
                                <div class="control-group">                                   
                                    <label class="control-label">Bắt đầu:</label>
                                    <div class="controls">
                                        <div id="session_time_start" name="session_time_start"></div>
                                    </div>                                                                                   
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Kết thúc:</label>
                                    <div class="controls">
                                        <div id="session_time_end" name="session_time_end"></div>
                                    </div>
                                </div>    

                                <div class="control-group">
                                    <label class="control-label">Trạng thái:</label>
                                    <div class="controls">
                                        Enable:<input type="radio" name="session_status" id="session_enable" value="1" checked="">
                                        &nbsp;&nbsp;
                                        Disable:<input type="radio" name="session_status" id="session_disable" value="0" >
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Tỷ lệ thưởng:</label>
                                    <div class="controls">
                                        <input name="session_bonus_rate" id="session_bonus_rate" type="text" class="span3 validate[required]" /> %
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Tham gia tối đa:</label>
                                    <div class="controls">
                                        <input name="max_user" id="max_user" type="text" class="span3 validate[required]" /> Người (0: Không giới hạn)
                                    </div>
                                </div>                               

                                <div class="control-group">
                                    <div style="padding-left: 20%; text-align:left;">
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
