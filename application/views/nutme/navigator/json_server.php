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
        padding-top: 15px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; padding-top:15px; padding-bottom: 15px; margin-top: 10px; margin-bottom: 10px;
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
        top:4px;
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
        top:-17px;
    }
    .subItems{
        margin-left: 20px;
    }
    .form-group.remove{
        top: 5px;
    }
    .listItem label{
        width: 87px;
        float: left;
        margin-top: 5px;
    }
    .listItem input{
        width: 175px;
    }
    .listItem .group1{
        padding: 0 10px;
    }
</style>
<div class="rows">	
    <div class="input_fields_wrap">
        <div class="btn_morefield">
            <button class="add_field_button btn btn-success">Thêm Server</button>
        </div>
        <?php
            if($_GET['id']>0){
                $listItems = json_decode($items['jsonRule'],true);
                
                if(count($listItems)>0){
                    $i=0;
                    foreach($listItems as $v){
                        $i++;
                        $service_starts = gmdate('Y-m-d G:i:s',time()+7*3600);
                        $service_ends = gmdate('Y-m-d G:i:s',time()+7*3600);
                        if($_GET['id']>0){
                            if(!empty($v['service_start'])){
                                $service_starts = $v['service_start'];
                            }
                            if(!empty($v['service_end'])){
                                $service_ends = $v['service_end'];
                            }
                        }
        ?>
        <div class="control-group listItem">
            <div class="group1">
                <div class="form-group">
                    <label class="control-label">Server ID:</label>
                    <input id="server_id" name="server_id[]" type="text" value="<?php echo $v['server_id'];?>" class="span3 validate[required]">
                </div>
                <div class="form-group">
                    <label class="control-label">Service Start:</label>
                    <input class="service_starts" name="service_starts[]" type="text" value="<?php echo $service_starts;?>" />
                </div>
                <div class="form-group">
                    <label class="control-label">Service End:</label>
                    <input class="service_ends" name="service_ends[]" type="text" value="<?php echo $service_ends;?>" />
                </div>
                <div class="form-group remove">
                    <span class="remove_field">Remove</span>
                </div>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
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
    $('.service_starts').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss'
    });
    $('.service_ends').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss'
    });
</script>
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
                             xhtml +='<label class="control-label">Server ID:</label>';
                             xhtml +='<input id="server_id" name="server_id[]" type="text" value="1">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Service Start:</label>';
                             xhtml +='<input class="timepicker2" name="service_starts[]" type="text" value="<?php echo gmdate('Y-m-d G:i:s',time()+7*3600);?>">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group">';
                             xhtml +='<label class="control-label">Service End:</label>';
                             xhtml +='<input class="timepicker2" name="service_ends[]" type="text" value="<?php echo gmdate('Y-m-d G:i:s',time()+7*3600);?>">';
                         xhtml +='</div>';
                         xhtml +='<div class="form-group remove">';
                             xhtml +='<span class="remove_field">Remove</span>';
                         xhtml +='</div>';
                         xhtml +='<div class="clr"></div>';
                     xhtml +='</div>';
                 xhtml +='</div>';
                $(wrapper).append(xhtml); //add input box
                $('.timepicker2').datetimepicker({
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'hh:mm:ss'
                });
            }
        });
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        });
    });
</script>