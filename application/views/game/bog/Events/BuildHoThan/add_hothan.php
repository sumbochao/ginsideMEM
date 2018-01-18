<?php
$collection = array();
if(isset($hon->collection) && $hon->collection != '')
    $collection = explode(',',$hon->collection);
// echo '<pre>';print_r($related_hon);
?>
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
        .relationship{
            border: 1px solid #428bca;
            padding: 0;
            margin: 10px;
            border-radius: inherit;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            //neu type = hon thi tat cac skill fields di
            var key = $('#key').val();
            if(key == 'hon'){
                $('#ho-than-skills').hide();
            }else if(key == 'ho-than'){
                $('#relationship').hide();
            }else{
				$('#ho-than-skills').hide();
				$('#relationship').hide();
			}

            $('#key').change(function(){
                var key = $('#key').val();
                if(key == 'hon'){
                    $('#ho-than-skills').hide();
                    $('#relationship').show();
                }else if(key == 'ho-than'){
                    $('#ho-than-skills').show();
                    $('#relationship').hide();
                }else{
					$('#ho-than-skills').hide();
					$('#relationship').hide();
				}
            });


            $('#comeback').on('click', function () {
                window.history.go(-1);
                return false;
            });


            $('#frmSendChest').ajaxForm({
                success: function (data) {
                    if ($('#frmSendChest').validationEngine('validate') === false)
                        return false;

                    $(".loading").fadeIn("fast");
//                    json_data = $.parseJSON(data);
                    $(".modal-body #messgage").html(data);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");
                    //$('#frmSendChest').clearForm();
                }
            });




            $('#add-item').click(function(){
                var clone = $('.relationship:last').clone();
                clone.find('input[type=hidden]').val(0);
                clone.appendTo('#relationship');
            });

            $('#remove-item').click(function(){
                if($('.relationship').length > 1)
                    $('.relationship:last').remove();
            });
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

                <form id="frmSendChest" action="/?control=build_hothan&func=add_hothan" method="POST"
                      enctype="multipart/form-data">
                    <div class="well form-horizontal">

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Information</h3>
                            </div>

                            <div class="panel-body">
                                <div class="control-group frmedit">
                                    <label class="control-label">Tên:</label>

                                    <div class="controls">
                                        <input value="<?php echo $hon->name; ?>" name="name" id="name" type="text"
                                               class="span3 validate[required]"/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Type:</label>

                                    <div class="controls">
                                        <select name="key" id="key">
                                            <option <?php if($hon->key == '') echo 'selected'; ?>  value=''>----Select----</option>
                                            <option <?php if($hon->key == 'hon') echo 'selected'; ?>  value='hon'>Hồn</option>
                                            <option <?php if($hon->key == 'ho-than') echo 'selected'; ?> value='ho-than'>Hộ Thần</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Nhóm hồn:</label>

                                    <div class="controls">
                                        <select size="10" multiple name="collection[]" class="form-control input-large">
                                            <?php foreach($listHon as $value): ?>
                                                <option <?php if(in_array($value->id,$collection)) echo 'selected';?> value='<?php echo $value->id;?>'><?php echo $value->name;?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Image:</label>

                                    <div class="controls">
                                        <input type="file" name="image"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Thumb:</label>

                                    <div class="controls">
                                        <input type="file" name="thumb"/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Brief:</label>

                                    <div class="controls">
                                        <textarea class="form-control" rows="3" name="brief"><?php echo $hon->brief;?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" id="ho-than-skills">
                                <div class="control-group">
                                    <label class="control-label">Description:</label>

                                    <div class="controls">
                                        <textarea class="form-control" rows="3" name="desc"><?php echo $hon->desc;?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Skill chủ động:</label>

                                    <div class="controls">
                                        <input type="text" name="active_skill" value="<?php echo $hon->active_skill;?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Image:</label>

                                    <div class="controls">
                                        <input type="file" name="active_skill_image" value="">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Skill bị động 1:</label>

                                    <div class="controls">
                                        <input type="text" name="passive_skill_1" value="<?php echo $hon->passive_skill_1;?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Image:</label>

                                    <div class="controls">
                                        <input type="file" name="passive_skill1_image" value="">
                                        <?php if(isset($hon->passive_skill1_image) &&  $hon->passive_skill1_image != ''): ?>
                                            <img src="/assets/img/hothan/<?php echo $hon->passive_skill1_image; ?>" width="50" height="50">
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Skill bị động 2:</label>

                                    <div class="controls">
                                        <input type="text" name="passive_skill_2" value="<?php echo $hon->passive_skill_2;?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Image:</label>

                                    <div class="controls">
                                        <input type="file" name="passive_skill2_image" value="">
                                        <?php if(isset($hon->passive_skill2_image) &&  $hon->passive_skill2_image != ''): ?>
                                            <img src="/assets/img/hothan/<?php echo $hon->passive_skill2_image; ?>" width="50" height="50">
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Skill bị động 3:</label>
                                    <div class="controls">
                                        <input type="text" name="passive_skill_3" value="<?php echo $hon->passive_skill_3;?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Image:</label>

                                    <div class="controls">
                                        <input type="file" name="passive_skill3_image" value="">
                                        <?php if(isset($hon->passive_skill3_image) &&  $hon->passive_skill3_image != ''): ?>
                                        <img src="/assets/img/hothan/<?php echo $hon->passive_skill3_image; ?>" width="50" height="50">
                                        <?php endif ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="panel panel-primary" id="relationship">
                            <div class="panel-heading">
                                <h3 class="panel-title">Relationship</h3>
                            </div>
                            <?php if($id == '' || count($related_hon) == 0):?>
                                <div class="panel-body relationship">
                                    <div class="control-group">
                                        <label class="control-label">Ra trận với hồn:</label>

                                        <div class="controls">
                                            <select name="hon_id_2[]">
                                                <option value=''>--Chọn Hồn--</option>
                                                <?php foreach($listHon as $value): ?>
                                                    <option value='<?php echo $value->id;?>'><?php echo $value->name;?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Kĩ năng kích hoạt:</label>

                                        <div class="controls">
                                            <textarea class="form-control" rows="3" name="effect[]"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Tên gọi:</label>

                                        <div class="controls">
                                            <input type="text" name="chien_hon[]" value="">
                                        </div>
                                    </div>
									<input type="hidden" name="hon_id[]" value="0">
                                </div>
                            <?php else:?>
                                <?php foreach($related_hon as $r): ?>
                                    <div class="panel-body relationship">
                                        <div class="control-group">
                                            <label class="control-label">Ra trận với hồn:</label>

                                            <div class="controls">
                                                <select name="hon_id_2[]">
                                                    <option value=''>--Chọn Hồn--</option>
                                                    <?php foreach($listHon as $value): ?>
                                                        <option <?php if($r->hon_id_2 == $value->id) echo 'selected'; ?> value='<?php echo $value->id;?>'><?php echo $value->name;?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Kĩ năng kích hoạt:</label>

                                            <div class="controls">
                                                <textarea class="form-control" rows="3" name="effect[]"><?php echo $r->effect;?></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Tên gọi:</label>

                                            <div class="controls">
                                                <input type="text" name="chien_hon[]" value="<?php echo $r->chien_hon;?>">
                                            </div>
                                        </div>
                                        <input type="hidden" name="hon_id[]" value="<?php echo $r->id;?>">
                                    </div>
                                <?php endforeach?>
                            <?php endif?>
                        </div>
                        <div class="control-group">
                            <input type="button" id="add-item" class="btn btn-primary" value="Add Item">
                            <input type="button" id="remove-item" class="btn btn-primary" value="Remove Item">
                            <input type="submit" style="margin-bottom: 10px;" class="btn btn-primary" value="Thực hiện">
                            <input type="button" id="comeback" class="btn btn-primary" value="Quay lại">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
