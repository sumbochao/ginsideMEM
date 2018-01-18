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
                window.history.go(-1); return false;
            });

           $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/tank/cms/toolvip/edit_vip_gift_pakage",
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
            
              //Load Tournament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/tank/cms/toolvip/tournament_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["id"] + '" >' + value["tournament_name"] + '</option>';
                    });

                    $("#tournament").html(tourlist);

                    var tournament_id = getParameterByName("tournament_id");
                    if (tournament_id !== null && tournament_id !== "") {                      
                        $("#tournament").val(tournament_id);
                    }  
                    
                    var id = getParameterByName("id");
                    load_vip_gift_pakage_details(id);
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });
        
        function load_vip_gift_pakage_details(id) {
            $("#tournament_img").attr('src', '/assets/img/loading_large.gif');
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/tank/cms/toolvip/get_vip_gift_pakage_details?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    $("#id").val(data[0]["id"]);
                    $("#pakage_name").val(data[0]["pakage_name"]);
                    $("#pakage_price").val(data[0]["pakage_price"]);
                    $("#vip_required").val(data[0]["vip_required"]);                   

                    if (data[0]["pakage_status"] == 1) {
                        $('#pakage_status_enable').prop('checked', true);
                    }
                    else {
                        $('#pakage_status_disable').prop('checked', true);
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
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/tank/Events/vip/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                                <i class=" ico-th-large"></i>CHỈNH SỬA GÓI QUÀ</h5>
                         <div class="control-group">                           
                            <label class="control-label">Giải đấu:</label>
                            <div class="controls">
                            <select id="tournament" name="tournament" class="span4 validate[required]" /></select> 
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tên Gói quà:</label>
                            <div class="controls">
                                <input name="pakage_name" id="pakage_name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Ngân Lượng:</label>
                            <div class="controls">
                                <input name="pakage_price" id="pakage_price" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Yêu cầu VIP:</label>
                            <div class="controls">
                                <input name="vip_required" id="vip_required" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Trạng thái:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="pakage_status" id="pakage_status_enable" value="1" checked="">
                                &nbsp;&nbsp;
                                Disable:<input type="radio" name="pakage_status" id="pakage_status_disable" value="0">
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
