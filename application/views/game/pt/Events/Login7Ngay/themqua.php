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
            color: #f36956;
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
                                    +'<input value="" name="item1_id[]" id="item_id" type="text" class="span3 validate[required]" />'
                                +'</div>'
                                +'<label class="control-label">Tên:</label>'
                                +'<div class="controls">'
                                    +'<input value="" name="item1_name[]" id="vip" type="text" class="span3 validate[required]" />'
                                +'</div>'
                                +'<label class="control-label">Số lượng:</label>'
                                +'<div class="controls">'
                                    +'<input value="" name="count1[]" id="count" type="text" class="span3 validate[required]" />'
                                +'</div>'
                            +'</div>';
                $('#items').append(html);
            });

            $('#removeItem').click(function(){
                if($('#items .control-group').length > 1)
                    $('#items .control-group').last().remove();
            })


            $('#addItem2').click(function(){
                var html = '<div class="control-group">'
                    +'<label class="control-label">ID:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item2_id[]" id="item_id" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Tên:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item2_name[]" id="vip" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Số lượng:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="count2[]" id="count" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Type:</label>'
                    +'</div>';
                $('#items2').append(html);
            });

            $('#removeItem2').click(function(){
                if($('#items2 .control-group').length > 1)
                    $('#items2 .control-group').last().remove();
            })


            $('#addItem3').click(function(){
                var html = '<div class="control-group">'
                    +'<label class="control-label">ID:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item3_id[]" id="item_id" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Tên:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item3_name[]" id="vip" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Số lượng:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="count3[]" id="count" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'</div>';
                $('#items3').append(html);
            });

            $('#removeItem3').click(function(){
                if($('#items3 .control-group').length > 1)
                    $('#items3 .control-group').last().remove();
            })


            $('#addItem4').click(function(){
                var html = '<div class="control-group">'
                    +'<label class="control-label">ID:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item4_id[]" id="item_id" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Tên:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item4_name[]" id="vip" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Số lượng:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="count4[]" id="count" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'</div>';
                $('#items4').append(html);
            });

            $('#removeItem4').click(function(){
                if($('#items4 .control-group').length > 1)
                    $('#items4 .control-group').last().remove();
            })


            $('#addItem5').click(function(){
                var html = '<div class="control-group">'
                    +'<label class="control-label">ID:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item5_id[]" id="item_id" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Tên:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item5_name[]" id="vip" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Số lượng:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="count5[]" id="count" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'</div>';
                $('#items5').append(html);
            });

            $('#removeItem5').click(function(){
                if($('#items5 .control-group').length > 1)
                    $('#items5 .control-group').last().remove();
            })


            $('#addItem6').click(function(){
                var html = '<div class="control-group">'
                    +'<label class="control-label">ID:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item6_id[]" id="item_id" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Tên:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item6_name[]" id="vip" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Số lượng:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="count6[]" id="count" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'</div>';
                $('#items6').append(html);
            });

            $('#removeItem6').click(function(){
                if($('#items6 .control-group').length > 1)
                    $('#items6 .control-group').last().remove();
            })


            $('#addItem7').click(function(){
                var html = '<div class="control-group">'
                    +'<label class="control-label">ID:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item7_id[]" id="item_id" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Tên:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="item7_name[]" id="vip" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'<label class="control-label">Số lượng:</label>'
                    +'<div class="controls">'
                    +'<input value="" name="count7[]" id="count" type="text" class="span3 validate[required]" />'
                    +'</div>'
                    +'</div>';
                $('#items7').append(html);
            });

            $('#removeItem7').click(function(){
                if($('#items7 .control-group').length > 1)
                    $('#items7 .control-group').last().remove();
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
                <form id="frmSendChest" action="/?control=event_login_7ngay&func=add_gift&module=all" method="POST" enctype="multipart/form-data">
                    <div class="well form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Chọn sự kiện:</label>
                            <div class="controls">
                                <select multiple name="config_id[]">
                                    <?php
                                    $config_id_arr = explode(',',$pack->config_id);
                                    foreach($configs as $cfg):?>
                                        <option <?php if(in_array($cfg->id,$config_id_arr)) echo 'selected';?> value="<?php echo $cfg->id;?>"><?php echo $cfg->name;?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                        </div>
                        <div class = "panel panel-primary">
                            <div class = "panel-heading">
                                Phần thưởng ngày 1
                            </div>

                            <div class = "panel-body">
                                <div id="items">
                                    <?php if($id == ''): ?>
                                        <div class="control-group">
                                            <label class="control-label">ID:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_id; ?>" name="item1_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Tên:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_name; ?>" name="item1_name[]" id="vip" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Số lượng:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->count; ?>" name="count1[]" id="count" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach(json_decode($pack->items_1) as $item): ?>
                                            <div class="control-group">
                                                <label class="control-label">ID:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_id; ?>" name="item1_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Tên:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_name; ?>" name="item1_name[]" id="vip" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Số lượng:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->count; ?>" name="count1[]" id="count" type="text" class="span3 validate[required]" />
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <button type="button" id="addItem" class="btn btn-primary"><span>Thêm Item</span></button>
                                <button type="button" id="removeItem" class="btn btn-primary"><span>Xóa Item</span></button>
                            </div>
                        </div>
                        <div class = "panel panel-primary">
                            <div class = "panel-heading">
                                Phần thưởng ngày 2
                            </div>

                            <div class = "panel-body">
                                <div id="items2">
                                    <?php if($id == ''): ?>
                                        <div class="control-group">
                                            <label class="control-label">ID:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_id; ?>" name="item2_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Tên:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_name; ?>" name="item2_name[]" id="vip" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Số lượng:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->count; ?>" name="count2[]" id="count" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach(json_decode($pack->items_2) as $item): ?>
                                            <div class="control-group">
                                                <label class="control-label">ID:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_id; ?>" name="item2_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Tên:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_name; ?>" name="item2_name[]" id="vip" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Số lượng:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->count; ?>" name="count2[]" id="count" type="text" class="span3 validate[required]" />
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <button type="button" id="addItem2" class="btn btn-primary"><span>Thêm Item</span></button>
                                <button type="button" id="removeItem2" class="btn btn-primary"><span>Xóa Item</span></button>
                            </div>
                        </div>


                        <div class = "panel panel-primary">
                            <div class = "panel-heading">
                                Phần thưởng ngày 3
                            </div>

                            <div class = "panel-body">
                                <div id="items3">
                                    <?php if($id == ''): ?>
                                        <div class="control-group">
                                            <label class="control-label">ID:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_id; ?>" name="item3_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Tên:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_name; ?>" name="item3_name[]" id="vip" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Số lượng:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->count; ?>" name="count3[]" id="count" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach(json_decode($pack->items_2) as $item): ?>
                                            <div class="control-group">
                                                <label class="control-label">ID:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_id; ?>" name="item3_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Tên:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_name; ?>" name="item3_name[]" id="vip" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Số lượng:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->count; ?>" name="count3[]" id="count" type="text" class="span3 validate[required]" />
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <button type="button" id="addItem3" class="btn btn-primary"><span>Thêm Item</span></button>
                                <button type="button" id="removeItem3" class="btn btn-primary"><span>Xóa Item</span></button>
                            </div>
                        </div>

                        <div class = "panel panel-primary">
                            <div class = "panel-heading">
                                Phần thưởng ngày 4
                            </div>

                            <div class = "panel-body">
                                <div id="items4">
                                    <?php if($id == ''): ?>
                                        <div class="control-group">
                                            <label class="control-label">ID:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_id; ?>" name="item4_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Tên:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_name; ?>" name="item4_name[]" id="vip" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Số lượng:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->count; ?>" name="count4[]" id="count" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach(json_decode($pack->items_4) as $item): ?>
                                            <div class="control-group">
                                                <label class="control-label">ID:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_id; ?>" name="item4_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Tên:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_name; ?>" name="item4_name[]" id="vip" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Số lượng:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->count; ?>" name="count4[]" id="count" type="text" class="span3 validate[required]" />
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <button type="button" id="addItem4" class="btn btn-primary"><span>Thêm Item</span></button>
                                <button type="button" id="removeItem4" class="btn btn-primary"><span>Xóa Item</span></button>
                            </div>
                        </div>


                        <div class = "panel panel-primary">
                            <div class = "panel-heading">
                                Phần thưởng ngày 5
                            </div>

                            <div class = "panel-body">
                                <div id="items5">
                                    <?php if($id == ''): ?>
                                        <div class="control-group">
                                            <label class="control-label">ID:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_id; ?>" name="item5_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Tên:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_name; ?>" name="item5_name[]" id="vip" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Số lượng:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->count; ?>" name="count5[]" id="count" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach(json_decode($pack->items_5) as $item): ?>
                                            <div class="control-group">
                                                <label class="control-label">ID:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_id; ?>" name="item5_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Tên:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_name; ?>" name="item5_name[]" id="vip" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Số lượng:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->count; ?>" name="count5[]" id="count" type="text" class="span3 validate[required]" />
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <button type="button" id="addItem5" class="btn btn-primary"><span>Thêm Item</span></button>
                                <button type="button" id="removeItem5" class="btn btn-primary"><span>Xóa Item</span></button>
                            </div>
                        </div>


                        <div class = "panel panel-primary">
                            <div class = "panel-heading">
                                Phần thưởng ngày 6
                            </div>

                            <div class = "panel-body">
                                <div id="items6">
                                    <?php if($id == ''): ?>
                                        <div class="control-group">
                                            <label class="control-label">ID:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_id; ?>" name="item6_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Tên:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_name; ?>" name="item6_name[]" id="vip" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Số lượng:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->count; ?>" name="count6[]" id="count" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach(json_decode($pack->items_6) as $item): ?>
                                            <div class="control-group">
                                                <label class="control-label">ID:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_id; ?>" name="item6_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Tên:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_name; ?>" name="item6_name[]" id="vip" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Số lượng:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->count; ?>" name="count6[]" id="count" type="text" class="span3 validate[required]" />
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <button type="button" id="addItem6" class="btn btn-primary"><span>Thêm Item</span></button>
                                <button type="button" id="removeItem6" class="btn btn-primary"><span>Xóa Item</span></button>
                            </div>
                        </div>

                        <div class = "panel panel-primary">
                            <div class = "panel-heading">
                                Phần thưởng ngày 7
                            </div>

                            <div class = "panel-body">
                                <div id="items7">
                                    <?php if($id == ''): ?>
                                        <div class="control-group">
                                            <label class="control-label">ID:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_id; ?>" name="item7_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Tên:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->item_name; ?>" name="item7_name[]" id="vip" type="text" class="span3 validate[required]" />
                                            </div>
                                            <label class="control-label">Số lượng:</label>
                                            <div class="controls">
                                                <input value="<?php echo $item->count; ?>" name="count7[]" id="count" type="text" class="span3 validate[required]" />
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach(json_decode($pack->items_7) as $item): ?>
                                            <div class="control-group">
                                                <label class="control-label">ID:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_id; ?>" name="item7_id[]" id="item_id" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Tên:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->item_name; ?>" name="item7_name[]" id="vip" type="text" class="span3 validate[required]" />
                                                </div>
                                                <label class="control-label">Số lượng:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $item->count; ?>" name="count7[]" id="count" type="text" class="span3 validate[required]" />
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <button type="button" id="addItem7" class="btn btn-primary"><span>Thêm Item</span></button>
                                <button type="button" id="removeItem7" class="btn btn-primary"><span>Xóa Item</span></button>
                            </div>
                        </div>

                        <div class="control-group">
                            <div style="padding-left: 50%; text-align: left;">
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
