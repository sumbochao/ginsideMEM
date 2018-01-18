<style>
    .form-group.remove{
        top: 5px;
    }
    .form-group.url_picture{
        width: 61%;
    }
    .form-group #url_receive,.form-group #url{
        width: 84% !important;
    }
    .form-horizontal .listItem .form-group.url_picture .control-label{
        width: 13.5% !important;
    }
    .add_field_button_rule{
        margin-bottom: 5px;
    }
    .input_fields_wrap_rule .form-group{
        margin-bottom: 0px;
    }
    .remove_field_rule{
        color: green;
        cursor: pointer;
    }
    .form-group.valuerule{
        width: 60%;
    }
</style>
<div class="rows">	
    <div class="input_fields_wrap">
        <div class="btn_morefield">
            <button class="add_field_button btn btn-success">Thêm Items</button>
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
                    <input id="name" name="item_name[]" type="text" value="<?php echo $v['item_name'];?>" class="span3 validate[required]">
                </div>
                <div class="form-group">
                    <label class="control-label">Count:</label>
                    <input id="count" name="count[]" type="text" value="<?php echo $v['count'];?>" class="span3 validate[required]">
                </div>
                <div class="form-group url_picture">
                    <label class="control-label">URL:</label>
                    <input id="url" name="url[]" type="text" value="<?php echo $v['url'];?>" class="span3 validate[required]">
                </div>
                <div class="form-group remove">
                    <span class="remove_field">Remove</span>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php
                    }
                }
            }
        ?>
    </div>
    <div class="clr"></div>
</div>
<script>
    $(document).ready(function() {
        var max_fields      = 10000; //maximum input boxes allowed
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
                             xhtml +='<label class="control-label">Items name:</label>';
                             xhtml +='<input id="item_name" name="item_name[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Count:</label>';
                             xhtml +='<input id="count" name="count[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group url_picture">';
                             xhtml +='<label class="control-label">URL:</label>';
                             xhtml +='<input id="url" name="url[]" type="text" value="1">';
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
    });
</script>
<div class="rows" style="margin-top:10px;">	
    <div class="input_fields_wrap_receive">
        <div class="btn_morefield">
            <button class="add_field_button_receive btn btn-success">Thêm Items Receive</button>
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
                    <input id="item_id_receive" name="item_id_receive[]" type="text" value="<?php echo $v['item_id'];?>" class="span3 validate[required]">
                </div>
                <div class="form-group">
                    <label class="control-label">Items name:</label>
                    <input id="name_receive" name="item_name_receive[]" type="text" value="<?php echo $v['item_name'];?>" class="span3 validate[required]">
                </div>
                <div class="form-group">
                    <label class="control-label">Count:</label>
                    <input id="count_receive" name="count_receive[]" type="text" value="<?php echo $v['count'];?>" class="span3 validate[required]">
                </div>
                <div class="form-group url_picture">
                    <label class="control-label">URL:</label>
                    <input id="url_receive" name="url_receive[]" type="text" value="<?php echo $v['url'];?>" class="span3 validate[required]">
                </div>
                <div class="form-group remove">
                    <span class="remove_field_receive">Remove</span>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php
                    }
                }
            }
        ?>
    </div>
    <div class="clr"></div>
</div>
<script>
    $(document).ready(function() {
        var max_fields      = 100000; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap_receive"); //Fields wrapper
        var add_button      = $(".add_field_button_receive"); //Add button ID
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
                             xhtml +='<input id="item_id_receive" name="item_id_receive[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Items name:</label>';
                             xhtml +='<input id="item_name_receive" name="item_name_receive[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Count:</label>';
                             xhtml +='<input id="count_receive" name="count_receive[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group url_picture">';
                             xhtml +='<label class="control-label">URL:</label>';
                             xhtml +='<input id="url_receive" name="url_receive[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field_receive">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clear"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper).append(xhtml); //add input box
            }
        });

        $(wrapper).on("click",".remove_field_receive", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
    });
</script>
<div class="rows" style="margin-top:10px;">	
    <div class="input_fields_wrap_rule">
        <div class="btn_morefield">
            <button class="add_field_button_rule btn btn-success">Thêm Rule</button>
        </div>
        <?php
            if($_GET['id']>0){
                $jsonRule = json_decode($items['jsonRule'],true); 
                if(count($jsonRule)>0){
                    $i=0;
                    foreach($jsonRule as $k=>$v){
                        $i++;
        ?>
        <div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Key:</label>
                    <input id="rule_key" name="rule_key[]" type="text" value="<?php echo $k;?>" class="span3 validate[required]">
                </div>
                <div class="form-group valuerule">
                    <label class="control-label">Value:</label>
                    <input id="name_receive" name="rule_value[]" type="text" value="<?php echo $v;?>" class="span3 validate[required]">
                </div>
                <div class="form-group remove">
                    <span class="remove_field_rule">Remove</span>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php
                    }
                }
            }
        ?>
    </div>
    <div class="clr"></div>
</div>
<script>
    $(document).ready(function() {
        var max_fields      = 10000; //maximum input boxes allowed
        var wrapper_rule         = $(".input_fields_wrap_rule"); //Fields wrapper
        var add_button_rule      = $(".add_field_button_rule"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button_rule).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                xhtml += '<div class="control-group listItem">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Key:</label>';
                             xhtml +='<input id="rule_key" name="rule_key[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group valuerule">';
                             xhtml +='<label class="control-label">Value:</label>';
                             xhtml +='<input id="rule_value" name="rule_value[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field_rule">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clear"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper_rule).append(xhtml); //add input box
            }
        });

        $(wrapper_rule).on("click",".remove_field_rule", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
    });
</script>