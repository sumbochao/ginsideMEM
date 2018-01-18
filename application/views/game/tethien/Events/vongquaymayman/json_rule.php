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
                foreach($json_rule as $keyRule => $v){
                    $i++;
                    ?>
        <div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Item ID:</label>
                    <input id="alias" name="item_id[]" type="text" value="<?php echo $v['item_id'];?>"/>
                </div>
                <div class="form-group">
                    <label class="control-label">Name:</label>
                    <input id="name" name="item_name[]" type="text" value="<?php echo $v['name'];?>">
                </div>
                <div class="form-group count">
                    <label class="control-label">Count:</label>
                   <input id="count" name="count[]" type="text" value="<?php echo $v['count'];?>">
                </div>
                <div class="form-group count">
                    <label class="control-label">Rate:</label>
                   <input id="count" name="rate[]" type="text" value="<?php echo $v['rate'];?>">
                </div>
                <div class="form-group count">
                    <label class="control-label">Type:</label>
                   <input id="count" name="type[]" type="text" value="<?php echo $v['type'];?>">
                </div>
                <div class="form-group remove">
                    <span class="remove_field ">Remove</span>
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
<script>
    $(document).ready(function() {
        var max_fields      = 100; //maximum input boxes allowed
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
                             xhtml +='<label class="control-label">Item ID:</label>';
                             xhtml +='<input name="item_id[]" type="text" value="a">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Name:</label>';
                             xhtml +='<input name="item_name[]" type="text" value="a">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Count:</label>';
                             xhtml +='<input name="count[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Rate:</label>';
                             xhtml +='<input name="rate[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Type:</label>';
                             xhtml +='<input name="type[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field ">Remove</span>';
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