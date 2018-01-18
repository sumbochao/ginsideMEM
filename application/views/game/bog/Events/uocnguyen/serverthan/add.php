<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
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
        .form-group {
            float: left;
            width: 22%;
        }
        .form-group input {
            width: 70%;
        }
        .form-horizontal .form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .form-horizontal .listItem .control-label{
            padding-right: 5px;
            width: 27% !important;
            color: green;
        }
        .form-horizontal .listItem .sublistItem .control-label{
            color: #f36926;
        }
        .form-horizontal .sublistItem{
            margin-left: 15px;
        }
        .remove_field,.remove_field_receive{
            cursor: pointer;
            color: green;
        }
        .input_fields .control-group{
            padding-top: 23px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
        
        .input_fields_wrap .control-group .sublistItem .remove_sub{
            top:4px;
        }
        .loadContent{
            text-align: center;
            color: red;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
            color: #f36926 !important;
        }
        .form-horizontal .control-label{
            text-align: center;
        }
        .form-group.remove{
            width: 10%;
            position: relative;
            top:6px;
        }
        .subItems{
            margin-left: 20px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
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
                    $(".loading").fadeOut("fast");
                    <?php
                        if($_GET['id']>0){
                    ?>
                    window.location.href='<?php echo $_SERVER['REQUEST_URI'];?>';
                    <?php
                        }
                    ?>
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/bog/Events/uocnguyen/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="/?control=uocnguyen_bog&func=post_serverthan" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Thần:</label>
                            <div class="controls">
                                <select name="than_id" class="chosen-select validate[required,custom[onlyNumberSp]]" tabindex="2">
                                    <option value="">Chọn thần</option>
                                    <?php
                                        if(count($slbThan)>0){
                                            foreach($slbThan as $v){
                                    ?>
                                    <option value="<?php echo $v['id'];?>" <?php echo ($v['id']==$items['than_id'])?'selected="selected"':''; ?>><?php echo $v['name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    var config = {
                                      '.chosen-select'           : {},
                                      '.chosen-select-deselect'  : {allow_single_deselect:true},
                                      '.chosen-select-no-single' : {disable_search_threshold:10},
                                      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                                      '.chosen-select-width'     : {width:"95%"}
                                    }
                                    for (var selector in config) {
                                      $(selector).chosen(config[selector]);
                                    }
                              </script>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Server:</label>
                            <div class="controls">
                                <input name="server_id" id="server_id" value="<?php echo $items['server_id'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Event:</label>
                            <div class="controls">
                                <select name="event_id" class="validat/e[required,custom[onlyNumberSp]]">
                                    <option value="">Chọn event</option>
                                    <?php
                                        if(count($slbEvent)>0){
                                            foreach($slbEvent as $v){
                                    ?>
                                    <option value="<?php echo $v['event_id'];?>" <?php echo ($v['event_id']==$items['event_id'])?'selected="selected"':''; ?>><?php echo $v['event_name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                            include_once 'json_rule.php';
                        ?>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <?php
                                    if($_GET['id']>0){
                                ?>
								<input type="hidden" name="action" value="edit"/>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
                                <input type="hidden" name="data_items" value="<?php echo base64_encode($items['item_id']);?>"/>
                                <?php
                                    }else{
                                ?>
								<input type="hidden" name="action" value="add"/>
								<?php } ?>
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
<script>
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>
