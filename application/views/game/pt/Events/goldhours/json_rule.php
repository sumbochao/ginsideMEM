<div class="rows">	
    <div class="input_fields_wrap">
        <div class="btn_morefield">
            <button class="add_field_button btn btn-success">Thêm Rule Items</button>
        </div>
        <?php
            $json_rule = json_decode($items['rules'],true);
            if(count($json_rule)>0){
                $i=0;
                foreach($json_rule as $rule){
                    $i++;
                    ?>
        <div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">From:</label>
                    <input id="from" name="from[<?php echo $i;?>]" type="text" value="<?php echo $rule['from'];?>">
                </div>
                <div class="form-group">
                    <label class="control-label">To:</label>
                    <input id="to" name="to[<?php echo $i;?>]" type="text" value="<?php echo $rule['to'];?>">
                </div>
                <div class="form-group remove">
                    <span class="remove_field ">Remove</span>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="input_fields_wrap_sub_<?php echo $i;?>">
                <div class="btn_morefield subItems">
                    <button onclick="listSubButton(1,<?php echo $i;?>)" class="add_field_button_sub btn btn-warning">Thêm Sub Rule Items</button>
                </div>
                <?php
                    if(count($rule['items'])>0){
                        foreach($rule['items'] as $v){
                ?>
                <div class="control-group sublistItem">
                    <div class="group1">
                         <div class="form-group">
                             <label class="control-label">Item ID:</label>
                             <input id="item_id" name="item_id[<?php echo $i;?>][]" type="text" value="<?php echo $v['item_id'];?>">
                         </div>
                         <div class="form-group">
                             <label class="control-label">Name:</label>
                             <input id="item_name" name="name[<?php echo $i;?>][]" type="text" value="<?php echo $v['name'];?>">
                         </div>
                         <div class="form-group">
                              <label class="control-label">Count:</label>
                             <input id="count" name="count[<?php echo $i;?>][]" type="text" value="<?php echo $v['count'];?>">
                         </div>
                        <div class="form-group">
                              <label class="control-label">Rate:</label>
                             <input id="count" name="rate[<?php echo $i;?>][]" type="text" value="<?php echo $v['rate'];?>">
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
        }
    ?>
    </div>
</div>
<script>
    //sub item
    var x=1;
    function listSubButton(x,xsub){
        if(x < 100){ //max input box allowed
            x++; //text box increment
            var xhtml="";
            xhtml += '<div class="control-group sublistItem">';
                xhtml +='<div class="group1">';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Item ID:</label>';
                         xhtml +='<input id="item_id" name="item_id['+xsub+'][]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Name:</label>';
                         xhtml +='<input id="name" name="name['+xsub+'][]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Count:</label>';
                         xhtml +='<input id="count" name="count['+xsub+'][]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Rate:</label>';
                         xhtml +='<input id="rate" name="rate['+xsub+'][]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group remove remove_sub">';
                         xhtml +='<span class="remove_field">Remove</span>';
                     xhtml +='</div>';
                     xhtml +='<div class="clear"></div>';
                 xhtml +='</div>';
             xhtml +='</div>';
            $('.input_fields_wrap_sub_'+xsub).append(xhtml); //add input box
        }
    }
    
    $(document).ready(function() {
        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        <?php
            if($_GET['id']>0){
        ?>
        var x = <?php echo $i+1;?>;
        <?php
            }else{
        ?>
        var x = 1; //initlal text box count
        <?php
            }
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
                             xhtml +='<label class="control-label">From:</label>';
                             xhtml +='<input id="from" name="from['+xsub+']" type="text" value="15:00:00">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">To:</label>';
                             xhtml +='<input id="to" name="to['+xsub+']" type="text" value="16:00:00">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field ">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clear"></div>';
                     xhtml +='</div>';
                    xhtml +='<div class="input_fields_wrap_sub_'+xsub+'">';
                        xhtml +='<div class="btn_morefield subItems">';
                            xhtml +='<button onclick="listSubButton(1,'+xsub+')" class="add_field_button_sub btn btn-warning">Thêm Sub Rule Items</button>';
                        xhtml +='</div>';
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