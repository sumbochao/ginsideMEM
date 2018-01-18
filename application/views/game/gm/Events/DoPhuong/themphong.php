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

            $('#comeback').on('click', function () {
                window.location.href = '/?control=dophuong_gm&func=quanlyphong#quanlyphong';
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/giangma/cms/tooldophuong/add_room",
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
                                <i class=" ico-th-large"></i>THÊM MỚI PHÒNG</h5>
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
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
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
