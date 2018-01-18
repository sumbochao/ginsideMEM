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
        $(document).ready(function() { 
            $("#startdate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#enddate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/giangma/cms/tooldophuong/room_get_by_id?id=" + getParameterByName("id"),
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#id").val(data[0]["id"]);
                    
                    $("#room_name").val(data[0]["room_name"]);

                    var room_date_start = null;
                    if (data[0]["room_date_start"] != "" && data[0]["room_date_start"] != null) {
                        room_date_start = new Date(data[0]["room_date_start"]);
                    }
                    var room_date_end = null;
                    ;
                    if (data[0]["room_date_end"] != "" && data[0]["room_date_end"] != null) {
                        room_date_end = new Date(data[0]["room_date_end"]);
                    }

                    $("#startdate").jqxDateTimeInput('setDate', room_date_start);
                    $("#enddate").jqxDateTimeInput('setDate', room_date_end);                 

                    if (data[0]["room_status"] == 1) {
                        $('#room_enable').prop('checked', true);
                    }
                    else {
                        $('#room_disable').prop('checked', true);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });

            $('#comeback').on('click', function () {
                window.location.href = '/?control=dophuong_gm&func=quanlyphong#quanlyphong';
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/giangma/cms/tooldophuong/edit_room",
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
                        <h5 class="widget-name">
                                <i class=" ico-th-large"></i>CHỈNH SỬA PHÒNG</h5>
                        <div class="control-group">
                            <label class="control-label">Tên phòng:</label>
                            <div class="controls">
                                <input name="room_name" id="room_name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>                         
                        <div class="control-group">                               
                            <label class="control-label">Bắt đầu:</label>
                            <div class="controls">    
                                <div id="startdate" name="startdate"></div>
                            </div>                                                             
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kết thúc:</label>
                            <div class="controls"> 
                                <div id="enddate" name="enddate"></div>
                            </div>
                        </div> 
                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="catstatus" id="room_enable" value="1" checked="">
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="catstatus" id="room_disable" value="0" >
                            </div>
                        </div>

                        <div class="control-group">
                            <span class="error"></span>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align:left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='id' id="id">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                        </div>                   
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /content wrapper -->
</div>
<!-- /content -->
</div>
