<style>
    .form-group.remove{
        top: 5px;
    }
</style>
<div class="rows">	
    <div class="input_fields_wrap">
        <div class="btn_morefield">
            <button class="add_field_button btn btn-success">Thêm Rule Login</button>
        </div>
        <?php
            $json_rule = json_decode($items['jsonRule'],true);
            if(count($json_rule)>0){
                $i=0;
                    ?>
        <div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Login:</label>
                    <input id="alias" name="login" type="text" value="<?php echo $json_rule['login'];?>">
                </div>
                <div class="form-group remove">
                    <span class="remove_field ">Remove</span>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="input_fields_wrap_sub">
                <div class="btn_morefield subItems">
                    <button onclick="listSubButton(1,<?php echo $i;?>)" class="add_field_button_sub btn btn-warning">Thêm Sub Items</button>
                </div>
                <?php
                    if(count($json_rule['items'])>0){
                        foreach($json_rule['items'] as $v){
                ?>
                <div class="control-group sublistItem">
                    <div class="group1">
                         <div class="form-group">
                             <label class="control-label">Item ID:</label>
                             <input id="item_id" name="item_id[]" type="text" value="<?php echo $v['item_id'];?>">
                         </div>
                         <div class="form-group">
                             <label class="control-label">Item Name:</label>
                             <input id="item_name" name="item_name[]" type="text" value="<?php echo $v['item_name'];?>">
                         </div>
                         <div class="form-group">
                              <label class="control-label">Count:</label>
                             <input id="count" name="count[]" type="text" value="<?php echo $v['count'];?>">
                         </div>
                         <div class="form-group remove remove_sub">
                             <span class="remove_field">Remove</span>
                         </div>
                         <div class="clear"></div>
                     </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>    
    <?php
            }
    ?>
    </div>
</div>
<script>
    //sub item
    function listSubButton(x,xsub){
        if(x < 100){ //max input box allowed
            x++; //text box increment
            var xhtml="";
            xhtml += '<div class="control-group sublistItem">';
                xhtml +='<div class="group1">';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Item ID:</label>';
                         xhtml +='<input id="item_id" name="item_id[]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Item Name:</label>';
                         xhtml +='<input id="item_name" name="item_name[]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Count:</label>';
                         xhtml +='<input id="count" name="count[]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group remove">';
                         xhtml +='<span class="remove_field">Remove</span>';
                     xhtml +='</div>';
                     xhtml +='<div class="clear"></div>';
                 xhtml +='</div>';
             xhtml +='</div>';
            $('.input_fields_wrap_sub').append(xhtml); //add input box
        }
    }
    $(document).ready(function() {
        var max_fields      = 2; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        <?php
            if(empty($json_rule['login'])){
        ?>
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                var xsub = x;
                xsub--;
                xhtml += '<div class="control-group listItem">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Login:</label>';
                             xhtml +='<input id="alias" name="login" type="text" value="a">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field remove_field_login">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clear"></div>';
                     xhtml +='</div>';
                    xhtml +='<div class="input_fields_wrap_sub">';
                        xhtml +='<div class="btn_morefield subItems">';
                            xhtml +='<button onclick="listSubButton(1,'+xsub+')" class="add_field_button_sub btn btn-warning">Thêm Sub Items</button>';
                        xhtml +='</div>';
                    xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper).append(xhtml); //add input box
            }
        });
        <?php
            }
        ?>
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove();
        });
        $(wrapper).on("click",".remove_field_login", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove();x--;
        });
    });
</script>