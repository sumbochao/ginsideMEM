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

        .frmedit .form-group {
            float: left;
            width: 25%;
        }

            .frmedit .form-group label {
                width: 35%;
            }

            .frmedit .form-group input {
                width: 50%;
            }

        .contronls-lab label {
            color: red;
            font-weight: bold;
        }

        .totalchest > div {
            margin-bottom: 10px;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .clear {
            clear: both;
        }

        .percent {
            color: blue;
            font-weight: bold;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
    </style>
    <script type="text/javascript" src="/libraries/jqwidgets32/jqx-all.js"></script>
    <link href='/libraries/jqwidgets32/styles/jqx.base.css' rel='stylesheet' type='text/css'>
    <link href='/libraries/jqwidgets32/styles/jqx.classic.css' rel='stylesheet' type='text/css'>
    <link href='/libraries/pannonia/pannonia/css/plugins.css' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
    <script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="/libraries/cms/jquery.form.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#comeback').on('click', function () {
                window.location.href = '/?control=event_lato&func=index';
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
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });

        });

        function disableStatus(data) {
            inputvalue = $(data).parent().find('input');
            classdiv = $(data).val();
            if (classdiv == 1) {
                $(data).removeClass('base_green');
                $(data).addClass('base_red');
                $(data).text('Off');
                $(data).val('0');
                inputvalue.val('0');
            } else {
                $(data).val('1');
                $(data).text('On');
                $(data).addClass('base_green');
                $(data).removeClass('base_red');
                inputvalue.val('1');
            }
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <!--BEGIN CONTROL ADD CHEST-->
            <?php include APPPATH . 'views/game/lk/Events/LatO/tab.php'; ?>
            <form id="frmSendChest" action="/?control=event_lato&func=add_new_item" method="POST" enctype="multipart/form-data">
                <div class="widget row-fluid">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <i class=" ico-th-large"></i>THÊM MỚI ITEM LẬT Ô
                        </h5>
                        <div class="control-group">
                            <label class="control-label">Tên Item:</label>
                            <div class="controls">
                                <input name="item_name" id="item_name" type="text" value="" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hình ảnh:</label>
                            <div class="controls">
                                <input type="file" name="picture" /> (Ảnh không được lớn hơn 700KB)
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="catstatus" id="cat_enable" value="1" checked />
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="catstatus" id="cat_disable" value="0" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Item Id:</label>
                            <div class="controls">                                
                                <input id="item_id" name="item_id" type="text" value="" class="span3 validate[required,custom[onlyNumberSp]]">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Số lượng:</label>
                            <div class="controls">                                
                                <input id="item_count" name="item_count" type="text" value="" class="span3 validate[required,custom[onlyNumberSp]]">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Tỷ lệ:</label>
                            <div class="controls">                                
                                <input id="current_rate" name="current_rate" type="text" value="" class="span3 validate[required,custom[onlyNumberSp]]"> (Tỷ lệ 1000 = 1%)
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <input id="submit" type="submit" value="Thực hiện" class="btn btn-primary" />
                                <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            <!--END CONTROL ADD CHEST-->
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
