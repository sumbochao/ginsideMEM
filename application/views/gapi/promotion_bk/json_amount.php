<div class="rows rows_json" style="margin-top:10px;">	
    <div class="input_fields_style input_fields_wrap_amount">
        <div class="btn_morefield">
            <button class="add_field_button_amount btn btn-success">Thêm Amount</button>
        </div>
        <?php
            if($_GET['id']>0){
                $jsonAmount = json_decode($items['amount'],true); 
                if(count($jsonAmount)>0){
                    $i=0;
                    foreach($jsonAmount as $v){
                        $i++;
        ?>
        <div class="control-group listItem stylelist">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Amount:</label>
                    <input name="amount[]" type="text" onKeyUp="this.value = FormatNumber(this.value);" onfocusout="ConvertPriceText(this.value)" onblur="ConvertPriceText(this.value)" value="<?php echo ($v>0)?number_format($v,0,',','.'):'0';?>" class="span3 validate[required]">
                </div>
                <div class="form-group remove">
                    <span class="color_remove remove_field_amount">Remove</span>
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
        var wrapper_amount         = $(".input_fields_wrap_amount"); //Fields wrapper
        var add_button_amount      = $(".add_field_button_amount"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button_amount).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                xhtml += '<div class="control-group listItem stylelist">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Amount:</label>';
                             xhtml +='<input name="amount[]" type="text" value="1" onKeyUp="this.value = FormatNumber(this.value);" onfocusout="ConvertPriceText(this.value)" onblur="ConvertPriceText(this.value)"/>';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="color_remove remove_field_amount">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clr"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper_amount).append(xhtml); //add input box
            }
        });

        $(wrapper_amount).on("click",".remove_field_amount", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
    });
</script>