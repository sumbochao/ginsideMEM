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
            $("#tournament").change(function () {
                load_tournament_detail($(this).val());
            });
            
            $('#create_tournament').on('click', function () {
                window.location.href = '/?control=trianvip_koa&func=themgiaidau&module=all#giaidau';
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/lucgioi/cms/tooltrianvip/edit_tournament_details",
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

        $(document).ready(function () {
            //Set DateTime Format
            $("#startdate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#enddate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            //Load Tournament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/lucgioi/cms/tooltrianvip/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["id"] + '" >' + value["name"] + '</option>';
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
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/lucgioi/cms/tooltrianvip/tournament_get_by_id?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#id").val(data[0]["id"]);

                    var start = null;
                    if (data[0]["start"] != "" && data[0]["start"] != null ) {
                        start = new Date(data[0]["start"]);
                    } 
                    var end = null;;
                    if (data[0]["end"] != "" && data[0]["end"] != null) {
                        end = new Date(data[0]["end"]);
                    }                    

                    $("#startdate").jqxDateTimeInput('setDate', start);
                    $("#enddate").jqxDateTimeInput('setDate', end);
                    $("#game_id").val(data[0]["game_id"]);                    
                
                    if (data[0]["status"] == 1) {
                        $('#tournament_enable').prop('checked', true);
                    }
                    else {
                        $('#tournament_disable').prop('checked', true);
                    }

                    $("#content_id").val(data[0]["content_id"]);
                    
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
            <?php include APPPATH . 'views/game/koa/Events/TriAnVip/tab.php'; ?>
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
                    <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="control-group">
                            <label class="control-label">Giải đấu:</label>
                            <div class="controls">
                                <select id="tournament" name="tournament" class="span4 validate[required]" /></select> 
                                <button type="button" id="create_tournament" class="btn btn-primary btn-sm" style="margin-bottom: 10px"><span>THÊM MỚI GIẢI ĐẤU</span></button>
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
                            <label class="control-label">Game ID:</label>
                            <div class="controls">
                                <input name="game_id" id="game_id" type="text" />
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Content ID:</label>
                            <div class="controls">
                                <input name="content_id" id="content_id" type="text" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="catstatus" id="tournament_enable" value="1" <?php //echo $statusOn;?>>
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="catstatus" id="tournament_disable" value="0" <?php //echo $statusOff; ?>>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
