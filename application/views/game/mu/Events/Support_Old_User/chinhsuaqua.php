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
            
            $('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                json_data = $.parseJSON($.parseJSON(data));
                if (data.result != "-1") {
                    var id = getParameterByName("id");
                    if (id !== null && id !== "") {
                        get_support_old_user_gift_details(id);
                    }
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
            var id = getParameterByName("id");
            if (id !== null && id !== "") {
                get_support_old_user_gift_details(id);
            }
        });
        
        //Load Gift VIP Details
        function get_support_old_user_gift_details(id) {
            $.ajax({
                method: "GET",
                url: "http://game.mobo.vn/mu/cms/toolsupport_old_user/get_support_old_user_gift_details?id=" + id,
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    console.log(data);
                    //Load Reward Details  
                    if (data.length > 0) {
                        $("#id").val(data[0]["id"]);  
                        $("#name").val(data[0]["name"]);  
                        $("#conditions_receiving_gifts").val(data[0]["conditions_receiving_gifts"]);
                        var item = $.parseJSON(data[0]["json_item"]);
                        len = item.length;
                        if(len > 1){
                        }
                        for (var i = 0; i < len; ++i) {
                            if(i>0){
                                $( ".add_more_item" ).after('<div class="control-group"><label class="control-label">Tên Item:</label><div class="controls"><input name="item_name['+i+']" id="item_name'+i+'" type="text" class="span4 validate[required]" /></div></div><div class="control-group"><label class="control-label">Hình ảnh đang sử dụng:</label><div class="controls"><img style="width: 100px" id="item_img'+i+'" src="/assets/img/loading_large.gif" /><input type="hidden" class="span12" id="item_img_text'+i+'" name="item_img_text['+i+']" />   </div></div><div class="control-group"><label class="control-label">Cập nhật hình ảnh:</label><div class="controls"><input type="file" name="item_img['+i+']" /> (Ảnh không được lớn hơn 700KB)</div></div> <div class="control-group"><label class="control-label">Item ID:</label><div class="controls"><input name="item_id['+i+']" id="item_id'+i+'" type="text" class="span3 validate[required]" /></div></div><div class="control-group"><label class="control-label">Số lượng:</label><div class="controls"><input name="item_quantity['+i+']" id="item_quantity'+i+'" type="text" class="span3 validate[required,custom[onlyNumberSp]]" /></div></div>');
                                $("#item_name"+i).val(item[i].item_name);
                                $("#item_img"+i).attr('src', item[i].image);
                                $("#item_img_text"+i).val(item[i].image);                       
                                $("#item_id"+i).val(item[i].item_id);
                                $("#item_quantity"+i).val(item[i].count);
                            }else{
                                $("#item_name").val(item[i].item_name);
                                $("#item_img").attr('src', item[i].image);
                                $("#item_img_text").val(item[i].image);                       
                                $("#item_id").val(item[i].item_id);
                                $("#item_quantity").val(item[i].count);
                            }
                        }
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
            <?php include APPPATH . 'views/game/mu/Events/Support_Old_User/tab.php'; ?>
            <div class="widget-name">              
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->

            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="/?control=support_old_user_mu&module=all&func=edit_support_old_user_gift" method="POST" enctype="multipart/form-data">
                        <div class="widget row-fluid">
                            <div class="well form-horizontal">
                                <h5 class="widget-name">
                                <i class=" ico-th-large"></i>CHỈNH SỬA QUÀ</h5>
                                
                                <div class="control-group">
                                    <label class="control-label">Tên Gói Quà:</label>
                                    <div class="controls">
                                        <input name="name" id="name" type="text" class="span4 validate[required]" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Tên Item:</label>
                                    <div class="controls">
                                        <input name="item_name[0]" id="item_name" type="text" class="span4 validate[required]" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Hình ảnh đang sử dụng:</label>
                                    <div class="controls">
                                        <img style="width: 100px" id="item_img" src="/assets/img/loading_large.gif" />
                                        <input type="hidden" class="span12" id="item_img_text" name="item_img_text[0]" />   
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Cập nhật hình ảnh:</label>
                                    <div class="controls">
                                        <input type="file" name="item_img[0]" /> (Ảnh không được lớn hơn 700KB)
                                    </div>
                                </div> 
                               
                                    <div class="control-group">
                                        <label class="control-label">Item ID:</label>
                                        <div class="controls">
                                            <input name="item_id[0]" id="item_id" type="text" class="span3 validate[required]" />
                                        </div>
                                    </div>
                                
                                    <div class="control-group">
                                        <label class="control-label">Số lượng:</label>
                                        <div class="controls">
                                            <input name="item_quantity[0]" id="item_quantity" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
                                        </div>
                                    </div>  
                                    
                                    <div class="add_more_item"></div>
                                
                                    <div class="control-group">
                                        <label class="control-label">Level (điều kiện nhận quà):</label>
                                        <div class="controls">
                                            <input name="conditions_receiving_gifts" id="conditions_receiving_gifts" type="text" class="span3 validate[required,custom[onlyNumberSp]]" />
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
