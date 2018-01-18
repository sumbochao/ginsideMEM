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
        var id = getParameterByName("id");
        var type = getParameterByName("type");
        
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
         
        $(document).ready(function() { 
            $('#comeback').on('click', function () {
                if (type != null && type != "") {
                   window.location.href = '/?control=tulinhdan_dht&func=quanlyqua&type=' + type + "&module=all#quanlyqua"; 
                }
                else{
                window.location.href = '?control=tulinhdan_dht&func=quanlyqua&module=all#quanlyqua';
                }
            });
            
            //Load Gift Type
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/onepiece/cms/tooltulinhdan/gift_type_list",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    var obj = data["rows"];
                    var tourlist = '';
                    $.each(obj, function (key, value) {
                        tourlist += '<option value="' + value["id"] + '" >' + value["type_name"] + '</option>';
                    });

                    $("#gift_type").html(tourlist); 
                    
                    if (type != null && type != "") {
                    $("#gift_type").val(type);
                    }
                },
                error: function (data) {
                    var obj = $.parseJSON(data);
                }
            });
        });
        
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
            <?php include APPPATH . 'views/game/dht/Events/TuLinhDan/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">               
                    <form id="frmSendChest" action="/?control=tulinhdan_dht&func=add_gift&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                                <i class=" ico-th-large"></i>THÊM QUÀ MỚI</h5>
                        <div class="control-group">
                            <label class="control-label">Loại quà:</label>
                            <div class="controls">
                                <select id="gift_type" name="gift_type" class="span4 validate[required]"></select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tên quà:</label>
                            <div class="controls">
                                <input name="gift_name" id="gift_name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hình ảnh:</label>
                            <div class="controls">
                                <input type="file" name="gift_img" />
                                (Ảnh không được lớn hơn 700KB)                            
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Item ID:</label>
                            <div class="controls">
                                <input name="item_id" id="item_id" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Số lượng:</label>
                            <div class="controls">
                                <input name="gift_quantity" id="gift_quantity" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        <div class="control-group frmedit">
                            <label class="control-label">Type:</label>
                            <div class="controls">
                                <input name="gift_send_type" id="gift_send_type" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Server:</label>
                            <div class="controls">
                                <textarea name="server_list" id="server_list" type="text" class="span3" style="margin: 0px; width: 295px; height: 60px;"></textarea> (ID Server cách nhau dấu ";")
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Điểm đổi:</label>
                            <div class="controls">
                                <input name="gift_price" id="gift_price" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                            </div>
                        </div>
                        
                         <div class="control-group">                            
                                <label class="control-label">Số lượng mua tối đa:</label>
                                <div class="controls">
                                    <input name="gift_buy_max" id="gift_buy_max" type="text" class="span3 validate[required,custom[onlyNumberSp]]" value="0" /> (Nhập 0 nếu không hạng chế số lượng)
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
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button type="button" id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
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
