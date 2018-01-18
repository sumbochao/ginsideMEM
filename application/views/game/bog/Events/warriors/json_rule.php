<style>
    input, textarea, .uneditable-input{
        width: 65%;
    }
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
    .form-group {
        float: left;
        width: 30%;
    }
    .form-group input {
        width: 70%;
    }
    .form-horizontal .form-group{
        margin-left: 0px;
        margin-right: 0px;
    }
    .form-horizontal .listItem .control-label{
        padding-right: 5px;
        width: 27% !important;
        color: green;
    }
    .form-horizontal .listItem .sublistItem .control-label{
        color: #f36926;
    }
    .form-horizontal .sublistItem{
        margin-left: 15px;
    }
    .remove_field,.remove_field_receive{
        cursor: pointer;
        color: green;
    }
    .input_fields_wrap .control-group,.input_fields_wrap_receive .control-group{
        padding-top: 15px; 
        padding-bottom: 0px;
        margin-left: 0px; 
        padding-left: 0px;
        border: 1px solid #ccc; 
        padding-top:15px; 
        padding-bottom: 15px; 
        margin-top: 10px; 
        margin-bottom: 10px;
    }
    .input_fields_wrap .control-group .form-group,.input_fields_wrap_receive .control-group .form-group{
        padding-bottom: 0px; margin-bottom: 0px;
    }
    .input_fields_wrap .control-group .sublistItem,.input_fields_wrap_receive .control-group .sublistItem{
        border: 0px;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }
    .input_fields_wrap .control-group .sublistItem .remove_sub{
        top:8px;
    }
    .loadContent{
        text-align: center;
        color: red;
    }
    .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
        color: #f36926 !important;
    }
    .form-horizontal .control-label{
        text-align: center;
    }
    .form-group.remove{
        width: 10%;
        position: relative;
        top:7px;
    }
    .sublistItem .form-group.remove_sub{
        width: 6%;
    }
    .sublistItem .form-group{
        width: 22%;
    }
    .subItems{
        margin-left: 20px;
    }
    .control-group{
        padding: 18px 0px 18px 10px;
        box-shadow: 0 1px 0 #ddd inset;
    }
    .control-group.listItem{
        box-shadow: 0 1px 0 #FFF inset;
    }
</style>
<div class="rows">	
    <div class="input_fields_wrap">
        <div class="btn_morefield">
            <button class="add_field_button btn btn-success">Thêm Rule Items</button>
        </div>
        <?php
            $json_rule = json_decode($items['rules'],true);
            if(count($json_rule)>0){
                $i=0;
                foreach($json_rule as $keyRule => $rule){
                    $i++;
                    ?>
        <div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Key:</label>
                    <input id="alias" name="key[<?php echo $i;?>]" type="text" value="<?php echo $keyRule;?>">
                </div>
                <div class="form-group">
                    <label class="control-label">Name:</label>
                    <input id="name" name="name[<?php echo $i;?>]" type="text" value="<?php echo $rule['name'];?>">
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
                         <div class="form-group item_name">
                             <label class="control-label">Name:</label>
                             <input id="item_name" name="item_name[<?php echo $i;?>][]" type="text" value="<?php echo $v['name'];?>">
                         </div>
                         <div class="form-group count">
                              <label class="control-label">Count:</label>
                             <input id="count" name="count[<?php echo $i;?>][]" type="text" value="<?php echo $v['count'];?>">
                         </div>
                        <div class="form-group count">
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
                         xhtml +='<input id="item_name" name="item_name['+xsub+'][]" type="text" value="1">';
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
                             xhtml +='<label class="control-label">Key:</label>';
                             xhtml +='<input id="key" name="key['+xsub+']" type="text" value="a">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Name:</label>';
                             xhtml +='<input id="name" name="name['+xsub+']" type="text" value="a">';
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