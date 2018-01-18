<div class="rows rows_json" style="margin-top:10px;">	
    <div class="input_fields_style input_fields_wrap_tester">
        <div class="btn_morefield">
            <button class="add_field_button_tester btn btn-success">Thêm Tester</button>
        </div>
        <?php
            if($_GET['id']>0){
                $jsonTester = json_decode($items['tester'],true); 
                if(count($jsonTester)>0){
                    $i=0;
                    foreach($jsonTester as $v){
                        $i++;
        ?>
        <div class="control-group listItem stylelist">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Tester:</label>
                    <input name="tester[]" type="text" value="<?php echo $v;?>" class="span3 validate[required]">
                </div>
                <div class="form-group remove">
                    <span class="color_remove remove_field_tester">Remove</span>
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
        var wrapper_tester         = $(".input_fields_wrap_tester"); //Fields wrapper
        var add_button_tester      = $(".add_field_button_tester"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button_tester).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var xhtml="";
                xhtml += '<div class="control-group listItem stylelist">';
                    xhtml +='<div class="group1">';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Tester:</label>';
                             xhtml +='<input name="tester[]" type="text" value="123"/>';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="color_remove remove_field_tester">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clr"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper_tester).append(xhtml); //add input box
            }
        });

        $(wrapper_tester).on("click",".remove_field_tester", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
    });
</script>