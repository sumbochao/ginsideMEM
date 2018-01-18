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
            
            $('#comeback').on('click', function () {
                //window.location.href = '/?control=event_covu_pt&func=giaidau#giaidau';
                window.history.go(-1); return false;
            });

            //Load Tournament Details
            load_tournament_detail(getParameterByName("id"));

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/volam/cms/tooluudai/edit_items",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    console.log(result);                  
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                });
            });
        });

        function load_tournament_detail(id) {
            $("#tournament_img").attr('src', '/assets/img/loading_large.gif');
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/volam/cms/tooluudai/get_id_items?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#id").val(data[0]["id"]);
					$("#name").val(data[0]["name"]);
					$("#amount").val(data[0]["amount"]);
					$("#percent").val(data[0]["percent"]);
                    $("#percent_receive").val(data[0]["percent_receive"]);
					

                    if (data[0]["status"] == 1) {
                        $('#status_enable').prop('checked', true);
                    }
                    else {
                        $('#status_disable').prop('checked', true);
                    }                    
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        }

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
            <?php include APPPATH . 'views/game/lvl/Events/uudai/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                                <i class=" ico-th-large"></i>THÊM MỚI ITEMS</h5>
                            <div class="control-group">
                                <label class="control-label">Tên Items:</label>
                                <div class="controls">
                                    <input name="name" id="name" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Amount:</label>
                                <div class="controls">
                                    <input name="amount" id="amount" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">Percent:</label>
                                <div class="controls">
                                    <input name="percent" id="percent" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">Percent_receive:</label>
                                <div class="controls">
                                    <input name="percent_receive" id="percent_receive" type="text" class="span3 validate[required]" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="status" id="status_enable" value="1" checked="">
                                    &nbsp;&nbsp;
                                Disable:<input type="radio" name="status" id="status_disable" value="0">
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                    <input type="hidden" name='id' id="id">
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
