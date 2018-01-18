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

            $('#frmSendChest').ajaxForm({
                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function (data) {
                    if ($('#frmSendChest').validationEngine('validate') === false)
                        return false;

                    $(".loading").fadeIn("fast");
                    json_data = $.parseJSON(data);
                    if (json_data.status == 0) {
                        $(".modal-body #messgage").html(json_data.msg);
                        $('.bs-example-modal-sm').modal('show');
                        
                    }else if (json_data.status == 1) {
                        $(".modal-body #messgage").html(json_data.msg);
                        $('.bs-example-modal-sm').modal('show');
                        
                    }
					$(".loading").fadeOut("fast");
					$('#frmSendChest').clearForm();
                }
            });

            $('#addItem').click(function(){
                var html = '<div class="control-group">'
                            +'<label class="control-label">ID:</label>'
                            +'<div class="controls">'
                            +'<input value="" name="item_id[]" id="item_id" type="text" class="span3 validate[required]" />'
                            +'</div>'
                            +'<label class="control-label">Tên:</label>'
                            +'<div class="controls">'
                            +'<input value="" name="item_name[]" id="vip" type="text" class="span3 validate[required]" />'
                            +'</div>'
                            +'<label class="control-label">Số lượng:</label>'
                            +'<div class="controls">'
                            +'<input value="" name="item_count[]" id="item_count" type="text" class="span3 validate[required]" />'
                            +'</div>'
                            +'</div>';
                $('#items').append(html);
            });

            $('#removeItem').click(function(){
                $('#items .control-group').last().remove();
            })
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/pt/Events/GoiQuaVip/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=event_goi_qua_vip&func=add_gift" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <div class="control-group frmedit">
                            <label class="control-label">Tên:</label>
                            <div class="controls">
                                <input value="<?php echo $name;?>" name="name" id="name" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Giá tiền:</label>
                            <div class="controls">
                                <input value="<?php echo $money;?>" name="money" id="money" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">VIP:</label>
                            <div class="controls">
                                <input value="<?php echo $vip;?>" name="vip" id="vip" type="text" class="span3 validate[required]" />
                            </div>
                        </div>

                        <div id="items">
                            <?php if($id == ''): ?>
                                <div class="control-group">
                                    <label class="control-label">ID:</label>
                                    <div class="controls">
                                        <input value="<?php echo $item->item_id; ?>" name="item_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                    </div>
                                    <label class="control-label">Tên:</label>
                                    <div class="controls">
                                        <input value="<?php echo $item->item_name; ?>" name="item_name[]" id="vip" type="text" class="span3 validate[required]" />
                                    </div>
                                    <label class="control-label">Số lượng:</label>
                                    <div class="controls">
                                        <input value="<?php echo $item->count; ?>" name="item_count[]" id="item_count" type="text" class="span3 validate[required]" />
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach($items as $item): ?>
                                    <div class="control-group">
                                        <label class="control-label">ID:</label>
                                        <div class="controls">
                                            <input value="<?php echo $item->item_id; ?>" name="item_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                        </div>
                                        <label class="control-label">Tên:</label>
                                        <div class="controls">
                                            <input value="<?php echo $item->item_name; ?>" name="item_name[]" id="vip" type="text" class="span3 validate[required]" />
                                        </div>
                                        <label class="control-label">Số lượng:</label>
                                        <div class="controls">
                                            <input value="<?php echo $item->count; ?>" name="item_count[]" id="item_count" type="text" class="span3 validate[required]" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <button type="button" id="addItem" class="btn btn-primary"><span>Thêm Item</span></button>
                                <button type="button" id="removeItem" class="btn btn-primary"><span>Xóa Item</span></button>
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <button type="button" id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id;?>">
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
