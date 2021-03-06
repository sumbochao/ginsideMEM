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
            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;
                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                $(".modal-body #messgage").html(json_data.msg);
                $('.bs-example-modal-sm').modal('show');
                $(".loading").fadeOut("fast");
            });
        });

        $(document).ready(function () {
            //Set DateTime Format
//            $("#tournament_date_start").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
//            $("#tournament_date_end").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
//
//            $("#startdate_reward").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
//            $("#enddate_reward").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

        });

    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">

            <?php include APPPATH . 'views/game/pt/Events/DauCoLV1/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=event_dau_co_lv_1&func=config_event" method="POST" enctype="multipart/form-data">
<!--                        <div class="control-group">-->
<!--                            <label class="control-label">Bắt đầu:</label>-->
<!--                            <div class="controls">-->
<!--                                <div id="tournament_date_start" name="tournament_date_start"></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="control-group">-->
<!--                            <label class="control-label">Kết thúc:</label>-->
<!--                            <div class="controls">-->
<!--                                <div id="tournament_date_end" name="tournament_date_end"></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
						<div class="control-group">
                            <label class="control-label">Server:</label>
                            <div class="controls">
                                <textarea name="server_list" id="server_list" type="text" class="span3 validate[required]" style="margin: 0px; width: 295px; height: 60px;"><?php echo $dclv_config[0]->server_list; ?></textarea>
                                (ID Server cách nhau dấu ";")
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" <?php if($dclv_config[0]->status == 1): ?> checked <?php endif?> name="status"  value="1" >
                                &nbsp;&nbsp;
                                Disable:<input type="radio" <?php if($dclv_config[0]->status == 0): ?> checked <?php endif?>  name="status" value="0" >
                            </div>
                        </div>

<!--                        <div class="control-group">-->
<!--                            <label class="control-label">Nhóm IP:</label>-->
<!--                            <div class="controls">-->
<!--                                <textarea name="tournament_ip_list" id="tournament_ip_list" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;"></textarea>-->
<!--                                (Dãy IP cách nhau dấu ";")-->
<!--                            </div>-->
<!--                        </div>-->

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
