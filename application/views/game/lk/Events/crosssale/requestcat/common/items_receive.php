<style>
    .form-group.remove{
        top: 5px;
    }
</style>
<div class="rows">	
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
                <div class="form-group">
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
        var max_fields      = 10; //maximum input boxes allowed
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
                         xhtml +='<div class="form-group">';
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