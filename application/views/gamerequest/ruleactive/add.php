<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/multiselect/js/bootstrap-multiselect.js') ?>"></script>
<script src="<?php echo base_url('assets/multiselect/js/prettify.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/bootstrap-multiselect.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/prettify.css') ?>"/>
<style>
    .error.item{
        padding-left: 0%;
        margin-top: 0px;
    }
    .receivegame{
        padding-top: 10px;
    }
    .remove_field{
        cursor: pointer;
    }
    .form-group{
        float: left;
        width: 23%;
    }
    .form-group.remove{
        width: 5%;
        color: green;
        cursor: pointer;
    }
    .form-group label{
        width: 35%;
    }
    .form-group input{
        width: 56%;
    }
    .listItem{
        margin-top: 10px;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Config</label>
                    <select name="configID">
                        <option value="0">Chọn config</option>
                        <?php
                            if(count($slbConfig)>0){
                                foreach($slbConfig as $v){
                        ?>
                        <option value="<?php echo $v['idx'];?>" <?php echo ($v['idx']==$items['configID'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <?php echo $errors['configID'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">jsonRule</label>
                    <textarea cols="50" rows="5" style="width: 60%;" name="jsonRule"><?php echo $items['jsonRule'];?></textarea>
                    <?php echo $errors['jsonRule'];?>
                </div>
            </div>
            <div class="group_right">
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="gameID" onchange="getReceiveGame(this.value)">
                        <option value="0">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                        ?>
                        <option value="<?php echo $v['gameID'];?>" <?php echo ($v['gameID']==$items['gameID'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <?php echo $errors['gameID'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">List Game</label>
                    <span class="loadReceiveGame">
                        <select name="gamereceiveID">
                            <option value="0">Chọn game receive</option>
                            <?php
                                if(count($slbReceiveGame)>0){
                                    foreach($slbReceiveGame as $vs){
                            ?>
                            <option value="<?php echo $vs['gameID'];?>" <?php echo ($vs['gameID']==$items['gamereceiveID'])?'selected="selected"':'';?>><?php echo $vs['name'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                        <?php echo $errors['gamereceiveID'];?>
                    </span>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Status Rule</label>
                    <input type="radio" name="statusRule" value="0" <?php echo ($items['statusRule']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="statusRule" value="1" <?php echo ($items['statusRule']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
                </div>
            </div>
            <div class="clr"></div>
            <div class="rows">	
                <div class="input_fields_wrap">
                    <div class="btn_morefield">
                        <button class="add_field_button btn btn-success">Thêm Items</button>
                        <?php echo $errors['items'];?>
                    </div>
                    <?php
                        if($_GET['id']>0){
                            $listItems = json_decode($items['items'],true);
                            if(count($listItems)>0){
                                $i=0;
                                foreach($listItems as $v){
                                    $i++;
                    ?>
                    <div class="control-group listItem">
                        <div class="group1">
                            <div class="form-group">
                                <label class="control-label">Items ID:</label>
                                <input id="item_id" name="item_id[]" type="text" value="<?php echo $v['item_id'];?>" class="span3 validate[required]">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Items name:</label>
                                <input id="name" name="name[]" type="text" value="<?php echo $v['name'];?>" class="span3 validate[required]">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Count:</label>
                                <input id="count" name="count[]" type="text" value="<?php echo $v['count'];?>" class="span3 validate[required]">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Rate:</label>
                                <input id="rate" name="rate[]" type="text" value="<?php echo $v['rate'];?>" class="span3 validate[required]">
                            </div>
                            <?php
                                if($i!=1){
                            ?>
                            <div class="form-group remove">
                                <span class="remove_field">Remove</span>
                            </div>
                            <?php } ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php
                                }
                            }
                        }else{
                    ?>
                    <div class="control-group listItem">
                        <div class="group1">
                            <div class="form-group">
                                <label class="control-label">Items ID:</label>
                                <input id="item_id" name="item_id[]" type="text" value="1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Items Name:</label>
                                <input id="name" name="name[]" type="text" value="1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Count:</label>
                                <input id="count" name="count[]" type="text" value="1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Rate:</label>
                                <input id="rate" name="rate[]" type="text" value="1">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="clr"></div>
            </div>
            <!-- item receive-->
            <div class="rows">	
                <div class="input_fields_wrap_receive">
                    <div class="btn_morefield">
                        <button class="add_field_button_receive btn btn-success">Thêm Items Receive</button>
                        <?php echo $errors['items_receive'];?>
                    </div>
                    <?php
                        if($_GET['id']>0){
                            $listItems = json_decode($items['items_receive'],true);
                            if(count($listItems)>0){
                                $i=0;
                                foreach($listItems as $v){
                                    $i++;
                    ?>
                    <div class="control-group listItem">
                        <div class="group1">
                            <div class="form-group">
                                <label class="control-label">Items ID:</label>
                                <input id="item_id" name="item_id_receive[]" type="text" value="<?php echo $v['item_id'];?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Items name:</label>
                                <input id="name" name="name_receive[]" type="text" value="<?php echo $v['name'];?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Count:</label>
                                <input id="count" name="count_receive[]" type="text" value="<?php echo $v['count'];?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Rate:</label>
                                <input id="rate" name="rate_receive[]" type="text" value="<?php echo $v['rate'];?>">
                            </div>
                            <?php
                                if($i!=1){
                            ?>
                            <div class="form-group remove">
                                <span class="remove_field_receive">Remove</span>
                            </div>
                            <?php } ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php
                                }
                            }
                        }else{
                    ?>
                    <div class="control-group listItem">
                        <div class="group1">
                            <div class="form-group">
                                <label class="control-label">Items ID:</label>
                                <input id="item_id" name="item_id_receive[]" type="text" value="1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Items Name:</label>
                                <input id="name" name="name_receive[]" type="text" value="1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Count:</label>
                                <input id="count" name="count_receive[]" type="text" value="1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Rate:</label>
                                <input id="rate" name="rate_receive[]" type="text" value="1">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="clr"></div>
            </div>
            
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                xhtml += '<div class="control-group listItem">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Items ID:</label>';
                             xhtml +='<input id="item_id" name="item_id[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Items Name:</label>';
                             xhtml +='<input id="name" name="name[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Count:</label>';
                             xhtml +='<input id="count" name="count[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Rate:</label>';
                             xhtml +='<input id="rate" name="rate[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clear"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper).append(xhtml); //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
        //receive
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper_receive         = $(".input_fields_wrap_receive"); //Fields wrapper
        var add_button_receive      = $(".add_field_button_receive"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button_receive).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                xhtml += '<div class="control-group listItem">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Items ID:</label>';
                             xhtml +='<input id="item_id" name="item_id_receive[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Items Name:</label>';
                             xhtml +='<input id="name" name="name_receive[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Count:</label>';
                             xhtml +='<input id="count" name="count_receive[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Rate:</label>';
                             xhtml +='<input id="rate" name="rate_receive[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field_receive">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clear"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper_receive).append(xhtml); //add input box
            }
        });

        $(wrapper_receive).on("click",".remove_field_receive", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
    });
</script>
<script type="text/javascript">
    $('input[name=startDate]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss'
    });
    $('input[name=endDate]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss',
        /*onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }*/
    });
    function getReceiveGame(id){
        $.ajax({
            url:baseUrl+'/?control=rule_active&func=ajax_receive',
            type:"POST",
            data:{id:id},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.status!="undefined"&&f.status==0){
                    $(".loadReceiveGame").html(f.html);
                    $('.loading_warning').hide();
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $('.loading_warning').hide();
                }
            }
        });
    }
</script>