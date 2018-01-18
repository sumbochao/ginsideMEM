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
            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/fish/cms/tooliwin/edit_iwin_config",
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
            
            //Load Iwin Config
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/fish/cms/tooliwin/iwin_config_get_by_id?id=1",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var start_date = null;;
                    if (data[0]["start_date"] != "" && data[0]["start_date"] != null) {
                        start_date = new Date(data[0]["start_date"]);
                    }
                    
                    var end_date = null;;
                    if (data[0]["end_date"] != "" && data[0]["end_date"] != null) {
                        end_date = new Date(data[0]["end_date"]);
                    }

                    $("#startdate").jqxDateTimeInput('setDate', start_date);
                    $("#enddate").jqxDateTimeInput('setDate', end_date);                    
              

                    $("#shell_limit_exchange").val(data[0]["shell_limit_exchange"]);                    
                    $("#win_rate").val(data[0]["win_rate"]);
                    
                     if (data[0]["iwin_status"] == 1) {
                        $('#iwin_status_enable').prop('checked', true);
                    }
                    else {
                        $('#iwin_status_disable').prop('checked', true);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
           
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/fish/Events/iwin/tab.php'; ?>
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
                            <label class="control-label">Giới hạn sò:</label>
                            <div class="controls">
                                <input name="shell_limit_exchange" id="shell_limit_exchange" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Tỷ giá:</label>
                            <div class="controls">
                                <input name="win_rate" id="win_rate" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                       
                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="catstatus" id="iwin_status_enable" value="1" <?php //echo $statusOn;?>>
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="catstatus" id="iwin_status_disable" value="0" <?php //echo $statusOff; ?>>
                            </div>
                        </div>                        

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input type="hidden" name='id' id="id" value="1">
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
