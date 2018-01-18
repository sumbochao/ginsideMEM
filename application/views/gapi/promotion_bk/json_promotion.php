<div class="rows rows_json">	
    <div class="input_fields_style input_fields_wrap">
        <div class="btn_morefield">
            <button class="add_field_button btn btn-success">Thêm Promotion</button>
        </div>
        <?php
            $json_promotion = json_decode($items['promotion'],true);
            
            if(count($json_promotion)>0){
                $i=0;
                foreach($json_promotion as $key=>$value){
                    $i++;
                    ?>
        <div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Key:</label>
                    <input name="key[<?php echo $key;?>]" type="text" value="<?php echo $key;?>">
                </div>
                <div class="form-group remove">
                    <span class="color_remove remove_field ">Remove</span>
                </div>
                <div class="clr"></div>
            </div>
            
            <div class="input_fields_wrap_sub_<?php echo $i;?>">
                <div class="btn_morefield subItems">
                    <button onclick="listSubButton(1,<?php echo $i;?>)" class="add_field_button_sub btn btn-warning">Thêm Sub Rule Items</button>
                </div>
                <?php
                    if(count($value)>0){
                        foreach($value as $k=>$v){
                ?>
                <div class="control-group sublistItem">
                    <div class="group1">
                         <div class="form-group">
                             <label class="control-label">Key Sub:</label>
                             <input name="keysub[<?php echo $i;?>][]" type="text" value="<?php echo $k;?>">
                         </div>
                         <div class="form-group">
                             <label class="control-label">Name Sub:</label>
                             <input name="namesub[<?php echo $i;?>][]" type="text" value="<?php echo $v;?>">
                         </div>
                         <div class="form-group remove remove_sub">
                             <span class="remove_field color_remove">Remove</span>
                         </div>
                         <div class="clr"></div>
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
                         xhtml +='<label class="control-label">Key Sub:</label>';
                         xhtml +='<input name="keysub['+xsub+'][]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group">';
                         xhtml +='<label class="control-label">Name Sub:</label>';
                         xhtml +='<input name="namesub['+xsub+'][]" type="text" value="1">';
                     xhtml +='</div>';
                     xhtml +='<div class="form-group remove remove_sub">';
                         xhtml +='<span class="color_remove remove_field">Remove</span>';
                     xhtml +='</div>';
                     xhtml +='<div class="clr"></div>';
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
                             xhtml +='<label class="control-label">Key:</label>';
                             xhtml +='<input name="key['+xsub+']" type="text" value="a">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="color_remove remove_field ">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clr"></div>';
                     xhtml +='</div>';
                    xhtml +='<div class="input_fields_wrap_sub_'+xsub+'">';
                        xhtml +='<div class="btn_morefield subItems">';
                            xhtml +='<button onclick="listSubButton(1,'+xsub+')" class="add_field_button_sub btn btn-warning">Thêm Sub Promotion</button>';
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