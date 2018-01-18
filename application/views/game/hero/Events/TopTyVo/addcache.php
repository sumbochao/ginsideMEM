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
            $("#starttime").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#stoptime").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            $('#comeback').on('click', function () {               
                window.history.go(-1); return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/hero/cms/tooltoptyvo/SP_EventConfig_AddEvent",
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
            
             //Load Event List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/hero/cms/tooltoptyvo/SP_EventConfig_GetEventID",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data;
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["eventid"] + '" >' + value["eventname"] + '</option>';
                    });
                    $("#eventid").html(tourlist);
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
            <?php include APPPATH . 'views/game/hero/Events/TopTyVo/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                                <i class=" ico-th-large"></i>ADD CACHE</h5>
                                <div class="control-group">
                            <label class="control-label">Event:</label>
                            <div class="controls">
                                <select id="eventid" name="eventid" class="span4 validate[required]" /></select>                                
                            </div>
                        </div> 
                            <div class="control-group">
                                <label class="control-label">Server ID:</label>
                                <div class="controls">
                                    <input name="server_id" id="server_id" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Start Time:</label>
                                <div class="controls">
                                    <div id="starttime" name="starttime"></div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Stop Time:</label>
                                <div class="controls">
                                    <div id="stoptime" name="stoptime"></div>
                                </div>
                            </div>
                            
                           <div class="control-group">
                                <label class="control-label">Week:</label>
                                <div class="controls">
                                    <input name="week" id="week" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                </div>
                            </div>
                            
                             <div class="control-group">
                            <label class="control-label">Descriptions:</label>
                            <div class="controls">
                                <textarea name="descriptions" id="descriptions" type="text" class="span3 validate[required]" style="margin: 0px; width: 295px; height: 60px;"></textarea>                                
                            </div>
                        </div>

                            <div class="control-group">
                                <label class="control-label">Status:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="status" id="cache_enable" value="1" checked="">
                                    &nbsp;&nbsp;
                                Disable:<input type="radio" name="status" id="cache_disable" value="0">
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                    <button id="onSubmit" class="btn btn-primary"><span>Add</span></button>
                                    <button id="comeback" class="btn btn-primary"><span>Back</span></button>
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
