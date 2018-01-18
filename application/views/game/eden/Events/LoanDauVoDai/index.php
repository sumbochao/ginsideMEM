<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(function () {
            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;
                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
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
            
            load_sv_filters();

        });

        function load_sv_filters() {           
            $.ajax({
                method: "GET",
                url: "/?control=event_loandauvodai_eden&func=get_sv_filters",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = $.parseJSON(data);
                    console.log(obj[0]["start"]);
                    $("#id").val(obj[0]["id"]);

                    var tournament_date_start = null;
                    if (obj[0]["start"] != "" && obj[0]["start"] != null) {
                        tournament_date_start = new Date(obj[0]["start"]);
                    }
                    var tournament_date_end = null;
                    if (obj[0]["end"] != "" && obj[0]["end"] != null) {
                        tournament_date_end = new Date(obj[0]["end"]);
                    }

                    $("#tournament_date_start").jqxDateTimeInput('setDate', tournament_date_start);
                    $("#tournament_date_end").jqxDateTimeInput('setDate', tournament_date_end);                  

                    if (obj[0]["status"] == 1) {
                        $('#tournament_enable').prop('checked', true);
                    }
                    else {
                        $('#tournament_disable').prop('checked', true);
                    } 
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                    console.log(obj);
                }
            });
        }
    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/eden/Events/LoanDauVoDai/tab.php'; ?>
            <div class="widget-name"> 
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=event_loandauvodai_eden&func=edit_sv_filters" method="POST" enctype="multipart/form-data"> 
                        <div class="control-group">
                            <label class="control-label">Bắt đầu:</label>
                            <div class="controls">
                                <div id="tournament_date_start" name="tournament_date_start"></div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Kết thúc:</label>
                            <div class="controls">
                                <div id="tournament_date_end" name="tournament_date_end"></div>
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
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>