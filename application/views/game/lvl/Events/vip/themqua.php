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
            $('#comeback').on('click', function () {               
                window.history.go(-1); return false;
            });
            
            $("#tournament").change(function () {
                
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

        $(document).ready(function () {
            //Load Tournament List
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/volam/cms/toolvip/tournament_list",
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
                    
                    get_vip_gift_pakage($("#tournament").val());
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });
        
        //Load VIP Gift Pakage
        function get_vip_gift_pakage(tournament_id) {
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/volam/cms/toolvip/get_vip_gift_pakage?tournament_id=" + tournament_id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {                  
                    var obj = data["rows"];
                    var tourlist = "";
                    $.each(obj, function (key, value) {                       
                        tourlist += '<option value="' + value["id"] + '" >' + value["pakage_name"] + '</option>';
                    });

                    $("#vip_gift_pakage").html(tourlist);

                    var pakage_id = getParameterByName("pakage_id");
                    if (pakage_id !== null && pakage_id !== "") {                      
                        $("#vip_gift_pakage").val(pakage_id);
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
            <?php include APPPATH . 'views/game/lvl/Events/vip/tab.php'; ?>
            <div class="widget-name">              
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=vip_lvl&module=all&func=add_vip_gift" method="POST" enctype="multipart/form-data">
                        <div class="widget row-fluid">
                            <div class="well form-horizontal">
                                <h5 class="widget-name">
                                <i class=" ico-th-large"></i>THÊM QUÀ MỚI</h5>
                                <div class="control-group">
                                    <label class="control-label">Giải đấu:</label>
                                    <div class="controls">
                                        <select id="tournament" name="tournament" class="span4 validate[required]" />										
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Gói Quà:</label>
                                    <div class="controls">
                                        <div id="reward_ok"><select id="vip_gift_pakage" name="vip_gift_pakage" class="span4 validate[required]" />										
                                            </select>                                                                                      
                                        </div>                                       
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                        <label class="control-label">Tên Quà:</label>
                                        <div class="controls">
                                            <input name="gift_name" id="gift_name" type="text" class="span4 validate[required]" />
                                        </div>
                                    </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Hình ảnh:</label>
                                    <div class="controls">
                                        <input type="file" name="gift_img" /> (Ảnh không được lớn hơn 700KB)
                                    </div>
                                </div> 
                               
                                    <div class="control-group">
                                        <label class="control-label">Item ID:</label>
                                        <div class="controls">
                                            <input name="item_id" id="item_id" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                        </div>
                                    </div>
                                
                                    <div class="control-group">
                                        <label class="control-label">Số lượng:</label>
                                        <div class="controls">
                                            <input name="gift_quantity" id="gift_quantity" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                        </div>
                                    </div>  
                                
                                <div class="control-group">
                                    <label class="control-label">Trạng thái:</label>
                                    <div class="controls">
                                        Enable:<input type="radio" name="gift_status" id="gift_status_enable" value="1" checked="">
                                        &nbsp;&nbsp;
                                        Disable:<input type="radio" name="gift_status" id="gift_status_disable" value="0">
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <div style="padding-left: 20%; text-align: left;">
                                        <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username; ?>">
                                        <input type="hidden" name='id' id="id">
                                        <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                         <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>                                        
                                        <div style="display: inline-block">
                                            <span id="message" style="color: green"></span>
                                        </div>
                                    </div>
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
