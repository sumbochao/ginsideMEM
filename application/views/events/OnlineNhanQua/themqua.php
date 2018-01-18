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


            $('#onSubmit').click(function(){
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $(".loading").fadeIn("fast");
                $('#frmSendChest').ajaxForm(function (data) {
                    $(".modal-body #messgage").html(data);
                    $('.bs-example-modal-sm').modal('show');
                    $('#frmSendChest').clearForm();
                    $(".loading").fadeOut("fast");
                });
            })

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
                                    +'<input value="" name="count[]" id="count" type="text" class="span3 validate[required]" />'
                                +'</div>'
                                +'<label class="control-label">Type:</label>'
                                +'<div class="controls">'
                                    +'<input value="" name="type[]" id="type" type="text" class="span3" />'
                                +'</div>'
                            +'</div>';
                $('#items').append(html);
            });

            $('#removeItem').click(function(){
                if($('#items .control-group').length > 1)
                    $('#items .control-group').last().remove();
            })
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" action="/?control=<?php echo $control;?>&func=add_gift" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <div class="control-group frmedit">
                            <label class="control-label">Điều kiện:</label>
                            <div class="controls">
                                <input value="<?php echo $condition;?>" name="condition" id="condition" type="text" class="span3 validate[required]" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Thời gian cách lần nhận trước:</label>
                            <div class="controls">
                                <input value="<?php echo $key;?>" name="key"  type="text" class="span3 validate[required,custom[integer]]" />
                                (Tính bằng phút)
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Chọn cấu hình sự kiện:</label>
                            <div class="controls">
                                <select name="config_id">
                                    <?php foreach($configs as $cfg):?>
                                    <option <?php if($cfg->id == $config_id) echo 'selected';?> value="<?php echo $cfg->id;?>"><?php echo $cfg->name;?></option>
                                    <?php endforeach?>
                                </select>
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
                                        <input value="<?php echo $item->count; ?>" name="count[]" id="count" type="text" class="span3 validate[required]" />
                                    </div>
                                    <label class="control-label">Type:</label>
                                    <div class="controls">
                                        <input value="<?php echo $item->type; ?>" name="type[]" id="type" type="text" class="span3" />
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
                                            <input value="<?php echo $item->count; ?>" name="count[]" id="count" type="text" class="span3 validate[required]" />
                                        </div>
                                        <label class="control-label">Type:</label>
                                        <div class="controls">
                                            <input value="<?php echo $item->type; ?>" name="type[]" id="type" type="text" class="span3" />
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
                                <input type="hidden" name="game" id="game" value="<?php echo $game;?>">
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
