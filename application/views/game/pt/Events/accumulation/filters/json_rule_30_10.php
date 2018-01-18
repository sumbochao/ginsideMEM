
<style>
    .btn{
        cursor:pointer;
        border-radius: 5px;
    }
    .item_rule input{
        height: auto !important;
        width: 160px;
    }
    .rule_item{
        margin:0px 10px;
    }
    .item_rule > .title,.sub_item_rule > .rows > .title{
        float: left;
        margin-right: 10px;
        margin-top:5px;
    }
    .item_rule > .input,.sub_item_rule > .rows > .input{
        float: left;
        padding-right: 5px;
    }
    .item_rule > .btn_remove,.sub_item_rule > .btn_remove{
        float: left;
        margin-top: 5px;
        cursor: pointer;
        color: green;
    }
    .item_rule > .btn_addsub{
        margin-top: 5px;
        cursor: pointer;
        margin-bottom:5px;
    }
    .item_rule,.sub_item_rule{
        margin-bottom: 10px;
    }
    .item_rule{
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
    }
    .sub_item_rule{
        margin-left: 10px;
    }
    .clr{
        clear: both;
    }
    .sub_item_rule .rows{
        float: left;
        margin-right: 10px;
    }
    #sub_item_rule{
        border:1px solid #CCC;
        padding:10px;
    }
    .btn_addsubsub{
        margin-right: 10px;
        float: left;
    }
</style>

<script type="text/javascript">
    
     $(function() {
        //cap 2
        $(".createdSub").click(function(){
            var idSub = $(this).attr('dataID');
            var countSub = $(".countSublist_"+idSub+" #sub_item_rule").length;
            countSub++;
            var subhtml = '<div id="sub_item_rule" class="sub_item_rule">';
                subhtml += '<div class="rows" style="display:none">'; 
                    subhtml += '<div class="title">From</div>'; 
                    subhtml += '<div class="input">';
                        subhtml += '<input type="text" id="p_scnt" size="20" name="from['+idSub+']['+countSub+']" value="1" placeholder="Nhập from" />';
                    subhtml += '</div>';
                subhtml += '</div>';
                subhtml += '<div class="rows" style="display:none">'; 
                    subhtml += '<div class="title">To</div>'; 
                    subhtml += '<div class="input">';
                        subhtml += '<input type="text" id="p_scnt" size="20" name="to['+idSub+']['+countSub+']" value="1" placeholder="Nhập to" />';
                    subhtml += '</div>';
                subhtml += '</div>';
             subhtml += '<div id="remVar" class="btn btn-danger">Remove</div>';
             subhtml +='<div class="clr" style="display:none"></div>';
             subhtml +='<div id="addVarSub" rulecondition="'+idSub+'" condition="'+countSub+'"  class="btn_addsubsub btn btn-info">Thêm items add</div><div class="subsublist"></div>';
         subhtml += '</div>';
        $(subhtml).appendTo($(this).next());
            return false;
        });
        //cap 3
        $(".createdSubSub").click(function(){
            var idSub = $(this).attr('dataID');
            var idSubSub = $(this).attr('dataSubSub');
            var countSubSub = $(".countSublist_"+idSub+" .countSubSublist_"+idSubSub+" #subsub_item_rule").length;
            countSubSub++;
            var subhtml = '<div id="subsub_item_rule" class="sub_item_rule">';
            subhtml += '<div class="rows">'; 
                subhtml += '<div class="title">Item ID</div>'; 
                subhtml += '<div class="input">';
                    subhtml += '<input type="text" id="p_scnt" size="20" name="item_id['+idSub+']['+idSubSub+']['+countSubSub+']" value="1" placeholder="Nhập Item ID" />';
                subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div class="rows">'; 
                subhtml += '<div class="title">Name</div>'; 
                subhtml += '<div class="input">';
                    subhtml += '<input type="text" id="p_scnt" size="20" name="name['+idSub+']['+idSubSub+']['+countSubSub+']" value="1" placeholder="Nhập Item Name" />';
                subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div class="rows">'; 
                subhtml += '<div class="title">Count</div>'; 
                subhtml += '<div class="input">';
                    subhtml += '<input type="text" id="p_scnt" size="20" name="count['+idSub+']['+idSubSub+']['+countSubSub+']" value="1" placeholder="Nhập Count" />';
                subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div class="rows">'; 
                subhtml += '<div class="title">Rate</div>'; 
                subhtml += '<div class="input">';
                    subhtml += '<input type="text" id="p_scnt" size="20" name="rate['+idSub+']['+idSubSub+']['+countSubSub+']" value="1" placeholder="Nhập Rate" />';
                subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div id="remVarSub" class="btn_remove">Remove</div>';
            subhtml +='<div class="clr"></div>';
            subhtml += '</div>';
            $(subhtml).appendTo($(this).next());
            return false;
        });
     });
</script>
        
        
<div class="rule_item">
    <div id="addScnt" class="btn btn-success">Thêm rule</div>
        <div id="p_scents">
        <?php
            $rules = json_decode($items['promotion'],true);
            $countRule = count($rules);
            if(count($rules)>0){
                $i=0;
                foreach($rules as $krule=>$vrule){
                    $i++;
        ?>
        <div class="item_rule" id="item_rule_<?php echo $i;?>">
            <div class="title">Key rule:</div>
            <div class="input"><input type="text" placeholder="Nhập Rule" value="<?php echo $krule;?>" name="keyrule[<?php echo $i;?>]" size="20" id="p_scnt"></div>
            <div class="btn_remove" id="remScnt">Remove</div>
            <div class="clr"></div>
            <div class="btn_addsub btn btn-warning createdSub" dataID="<?php echo $i;?>" keyrule_<?php echo $i;?>="<?php echo $i;?>">Thêm loại</div>
            <div class="sublist countSublist_<?php echo $i;?>">
                <?php
                    if(count($vrule)>0){
                        $j=0;
                        foreach($vrule as $kcon=>$vcon){
                            $j++;
                ?>
                <div class="sub_item_rule" id="sub_item_rule">
                    <div class="rows" style="display:none">
                        <div class="title">From</div>
                        <div class="input"><input type="text" placeholder="Nhập from" value="<?php echo $vcon['from'];?>" name="from[<?php echo $i;?>][<?php echo $j;?>]" size="20" id="p_scnt"></div>
                    </div>
                    <div class="rows" style="display:none">
                        <div class="title">To</div>
                        <div class="input"><input type="text" placeholder="Nhập to" value="<?php echo $vcon['to'];?>" name="to[<?php echo $i;?>][<?php echo $j;?>]" size="20" id="p_scnt"></div>
                    </div>
                    <div class="btn btn-danger" id="remVar">Remove</div>
                    <div class="clr" style="display:none"></div>
                    <div class="btn_addsubsub btn btn-info createdSubSub" dataID="<?php echo $i;?>" dataSubSub="<?php echo $j;?>" condition_<?php echo $j;?>="<?php echo $j;?>" rulecondition_<?php echo $j;?>="<?php echo $j;?>">Thêm items</div>
                    <div class="subsublist countSubSublist_<?php echo $j;?>">
                        <?php
                            if(count($vcon)>0){
                                $z=0;
                                foreach($vcon as $k=>$v){
                                    $z++;
                        ?>
                        <div class="sub_item_rule" id="subsub_item_rule">
                            <div class="rows">
                                <div class="title">Item ID</div>
                                <div class="input"><input type="text" placeholder="Nhập Item ID" value="<?php echo $v['item_id'];?>" name="item_id[<?php echo $i;?>][<?php echo $j;?>][<?php echo $z;?>]" size="20" id="p_scnt"></div>
                            </div>
                            <div class="rows">
                                <div class="title">Name</div>
                                <div class="input"><input type="text" placeholder="Nhập Item Name" value="<?php echo $v['name'];?>" name="name[<?php echo $i;?>][<?php echo $j;?>][<?php echo $z;?>]" size="20" id="p_scnt"></div>
                            </div>
                            <div class="rows">
                                <div class="title">Count</div>
                                <div class="input"><input type="text" placeholder="Nhập Count" value="<?php echo $v['count'];?>" name="count[<?php echo $i;?>][<?php echo $j;?>][<?php echo $z;?>]" size="20" id="p_scnt"></div>
                            </div>
                            <div class="rows">
                                <div class="title">Rate</div>
                                <div class="input"><input type="text" placeholder="Nhập Rate" value="<?php echo $v['rate'];?>" name="rate[<?php echo $i;?>][<?php echo $j;?>][<?php echo $z;?>]" size="20" id="p_scnt"></div>
                            </div>
                            <div class="btn_remove" id="remVarSub">Remove</div>
                            <div class="clr"></div> 
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
        <?php
                }
            }
        ?>
    </div>
</div>
<script>
   $(function() {
        var scntDiv = $('#p_scents');
        //cap 1
        <?php
            if($_GET['id']>0){
        ?>
        var x = '<?php echo $countRule;?>';
        <?php
            }else{
        ?>
        var x = 0;      
        <?php } ?>
        $('#addScnt').live('click', function() {
            x++;
            var html = '<div class="item_rule">';
                    html +='<div class="title">Key rule:</div>';
                    html +='<div class="input"><input type="text" id="p_scnt" size="20" name="keyrule['+x+']" value="1" placeholder="Nhập Rule" /></div>';
                    html +='<div id="remScnt" class="btn_remove">Remove</div>';
                    html +='<div class="clr"></div>';
                    html +='<div id="addVar" keyrule="'+x+'" class="btn_addsub btn btn-warning">Thêm loại</div><div class="sublist"></div>';
                html +='</div>';
            $(html).appendTo(scntDiv);
            return false;
        });
        $('#remScnt').live('click', function() { 
            $(this).parents('div.item_rule').remove();
            return false;
        });
        //cap 2
        var y=0;
        $('#addVar').live('click', function() { 
            y++;
            var keyrule = $(this).attr('keyrule');
             var subhtml = '<div id="sub_item_rule" class="sub_item_rule">';
                    subhtml += '<div class="rows" style="display:none">'; 
                        subhtml += '<div class="title">From</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="from['+keyrule+']['+y+']" value="1" placeholder="Nhập from" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                    subhtml += '<div class="rows" style="display:none">'; 
                        subhtml += '<div class="title">To</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="to['+keyrule+']['+y+']" value="1" placeholder="Nhập to" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                 subhtml += '<div id="remVar" class="btn btn-danger">Remove</div>';
                 subhtml +='<div class="clr" style="display:none"></div>';
                 subhtml +='<div id="addVarSub" rulecondition="'+keyrule+'" condition="'+y+'"  class="btn_addsubsub btn btn-info">Thêm items</div><div class="subsublist"></div>';
             subhtml += '</div>';
            $(subhtml).appendTo($(this).next());
            return false;
        });
        $('#remVar').live('click', function() { 
            $(this).parent('div#sub_item_rule').remove();  
            return false;
        });
        //cap 3
        var z=0;
        $('#addVarSub').live('click', function() { 
            var rulecondition = $(this).attr('rulecondition');
            var condition = $(this).attr('condition');
            z++;
             var subhtml = '<div id="subsub_item_rule" class="sub_item_rule">';
                    subhtml += '<div class="rows">'; 
                        subhtml += '<div class="title">Item ID</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="item_id['+rulecondition+']['+condition+']['+z+']" value="1" placeholder="Nhập Item ID" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                    subhtml += '<div class="rows">'; 
                        subhtml += '<div class="title">Name</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="name['+rulecondition+']['+condition+']['+z+']" value="1" placeholder="Nhập Item Name" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                    subhtml += '<div class="rows">'; 
                        subhtml += '<div class="title">Count</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="count['+rulecondition+']['+condition+']['+z+']" value="1" placeholder="Nhập Count" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                    subhtml += '<div class="rows">'; 
                        subhtml += '<div class="title">Rate</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="rate['+rulecondition+']['+condition+']['+z+']" value="1" placeholder="Nhập Rate" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                 subhtml += '<div id="remVarSub" class="btn_remove">Remove</div>';
                 subhtml +='<div class="clr"></div>';
             subhtml += '</div>';
            $(subhtml).appendTo($(this).next());
            return false;
        });
        $('#remVarSub').live('click', function() { 
            $(this).parent('div#subsub_item_rule').remove();  
            return false;
        });
    });
</script>