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
            $("#startdate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#enddate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#server_time_open").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            $('#comeback').on('click', function () {
                //window.location.href = '/?control=event_covu_pt&func=giaidau#giaidau';
                window.history.go(-1); return false;
            });
            
            //Load Gift
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/mu/cms/toolsupport_old_user/get_all_support_old_user_gift",
                contentType: 'application/json; charset=utf-8',
                success: function (data) { 
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value2) {     
                        $('#gift_1').multiSelect('addOption', { value: value2["id"] , text: value2["name"] });
                        $('#gift_2').multiSelect('addOption', { value: value2["id"] , text: value2["name"] });
                    });
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
            

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/mu/cms/toolsupport_old_user/add_tournament",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    //console.log(result);
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");

                });
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/mu/Events/Support_Old_User/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                                <i class=" ico-th-large"></i>THÊM MỚI SỰ KIỆN</h5>
                            <div class="control-group">
                                <label class="control-label">Tên sự kiện:</label>
                                <div class="controls">
                                    <input name="tournament_name" id="tournament_name" type="text" class="span3 validate[required]" />
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
                                <label class="control-label">Ngày mở server:</label>
                                <div class="controls">
                                    <div id="server_time_open" name="server_time_open"></div>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Server:</label>
                                <div class="controls">
                                    <textarea name="server_list" id="server_list" type="text" class="span3" style="margin: 0px; width: 150px; height: 30px;"></textarea>
                                    (ID Server cách nhau dấu ";")
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Quà 1: (User tạo sau khi mở server 1-2 ngày)</label>
                                <select id='gift_1' multiple='multiple' name="gift_1[]">
                                </select>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Quà 2: (User tạo sau khi mở server sau 3 ngày)</label>
                                <select id='gift_2' multiple='multiple' name="gift_2[]">
                                </select>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="catstatus" id="tournament_enable" value="1" checked="">
                                    &nbsp;&nbsp;
                                Disable:<input type="radio" name="catstatus" id="tournament_disable" value="0">
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
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
<script type="text/javascript">
// run pre selected options
$('#gift_1').multiSelect();
$('#gift_2').multiSelect();
</script>