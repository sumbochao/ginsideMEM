<div class="rows rows_json" style="margin-top:10px;">	
    <div class="input_fields_style input_fields_wrap_type">
        <div class="btn_morefield">
            <button class="add_field_button_type btn btn-success">Thêm Card</button>
        </div>
        <?php
            if($_GET['id']>0){
                $jsonType = json_decode($items['type'],true); 
                if(count($jsonType)>0){
                    $i=0;
                    foreach($jsonType as $v){
                        $i++;
        ?>
        <div class="control-group listItem stylelist">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Card:</label>
                    <input name="type[]" type="text" value="<?php echo $v;?>" class="span3 validate[required]">
                </div>
                <div class="form-group remove">
                    <span class="color_remove remove_field_type">Remove</span>
                </div>
                <div class="clr"></div>
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
        var wrapper_type         = $(".input_fields_wrap_type"); //Fields wrapper
        var add_button_type      = $(".add_field_button_type"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button_type).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                xhtml += '<div class="control-group listItem stylelist">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Card:</label>';
                             xhtml +='<input name="type[]" type="text" value="card"/>';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="color_remove remove_field_type">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clr"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper_type).append(xhtml); //add input box
            }
        });

        $(wrapper_type).on("click",".remove_field_type", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
    });
</script>