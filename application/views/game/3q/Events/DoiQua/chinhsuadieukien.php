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
        var type = getParameterByName("type");
        $(document).ready(function () {
            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });

            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    load_gift_details();
                    $(".loading").fadeOut("fast");
                }
                else {
                    $(".modal-body #messgage").html(json_data.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                }
            });
            
            load_gift_details();
        });

        function load_gift_details() {
            //Load Gift Details
            var id = getParameterByName("id");
            if (id != null && id != "") {
                $.ajax({
                    method: "GET",
                    url: "http://game.mobo.vn/3q/cms/tooldoiqua/load_gift_condition_details?id=" + id,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        $("#item_id").val(data[0]["item_id"]);
                        $("#id").val(data[0]["id"]);

                        $("#gift_name").val(data[0]["gift_name"]);                     
                        $("#gift_quantity").val(data[0]["gift_quantity"]);
                        $("#gift_img").attr('src', data[0]["gift_img"]);
                        $("#gift_img_text").val(data[0]["gift_img"]);
                        $("#gift_send_type").val(data[0]["gift_send_type"]);
//                        $("#gift_type").val(data[0]["gift_type"]);   
//                        
//                         $("#item_id_2").val(data[0]["item_id_2"]);
//                         $("#gift_quantity_2").val(data[0]["gift_quantity_2"]);
//                         $("#gift_send_type_2").val(data[0]["gift_send_type_2"]);
//                         
//                          $("#item_id_3").val(data[0]["item_id_3"]);
//                         $("#gift_quantity_3").val(data[0]["gift_quantity_3"]);
//                         $("#gift_send_type_3").val(data[0]["gift_send_type_3"]);

                        if (data[0]["gift_status"] == 1) {
                            $('#gift_status_enable').prop('checked', true);
                        }
                        else {
                            $('#gift_status_disable').prop('checked', true);
                        }

                    },
                    error: function (data) {
                        var obj = $.parseJSON(data);
                    }
                });
            }
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
<?php include APPPATH . 'views/game/3q/Events/DoiQua/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=doiqua_3q&func=edit_gift_condition&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <h5 class="widget-name">
                            <i class=" ico-th-large"></i>CHỈNH SỬA ĐIỀU KIỆN</h5>
                        <div class="control-group">
                            <label class="control-label">Tên quà:</label>
                            <div class="controls">
                                <input name="gift_name" id="gift_name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Hình ảnh đang sử dụng:</label>
                            <div class="controls">
                                <img style="width: 100px" id="gift_img" src="/assets/img/loading_large.gif" />
                                <input type="hidden" class="span12" id="gift_img_text" name="gift_img_text" />   
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Cập nhật hình ảnh:</label>
                            <div class="controls">
                                <input type="file" name="gift_img" /> (Ảnh không được lớn hơn 700KB)
                            </div>
                        </div> 
                        
                        <div class="control-group frmedit">
                            <div class="form-group">
                                <label class="control-label">Quà:</label>
                                <div class="controls">
                                    Item ID <input name="item_id" id="item_id" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Số lượng <input name="gift_quantity" id="gift_quantity" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /> 
                                    Type <input name="gift_send_type" id="gift_send_type" type="text" class="span3 validate[required]" /> 
                                </div>
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
