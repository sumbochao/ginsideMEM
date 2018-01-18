
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
    .item_rule .rows{
        margin-right: 10px;
        float: left;
    }
    .item_rule .rows > .title,.sub_item_rule > .rows > .title{
        float: left;
        margin-right: 10px;
        margin-top:5px;
    }
    .item_rule .rows > .input,.sub_item_rule > .rows > .input{
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
    .btn_addsubsub{
        margin-right: 10px;
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
                subhtml += '<div class="rows">'; 
                    subhtml += '<div class="title">Item ID</div>'; 
                    subhtml += '<div class="input">';
                        subhtml += '<input type="text" id="p_scnt" size="20" name="item_id['+idSub+']['+countSub+']" value="1" placeholder="Nhập Item ID" />';
                    subhtml += '</div>';
                subhtml += '</div>';
                subhtml += '<div class="rows">'; 
                    subhtml += '<div class="title">Name</div>'; 
                    subhtml += '<div class="input">';
                        subhtml += '<input type="text" id="p_scnt" size="20" name="name['+idSub+']['+countSub+']" value="1" placeholder="Nhập Tên" />';
                    subhtml += '</div>';
                subhtml += '</div>';
                subhtml += '<div class="rows">'; 
                    subhtml += '<div class="title">Count</div>'; 
                    subhtml += '<div class="input">';
                        subhtml += '<input type="text" id="p_scnt" size="20" name="count['+idSub+']['+countSub+']" value="1" placeholder="Nhập Count" />';
                    subhtml += '</div>';
                subhtml += '</div>';
                subhtml += '<div class="rows">'; 
                    subhtml += '<div class="title">Rate</div>'; 
                    subhtml += '<div class="input">';
                        subhtml += '<input type="text" id="p_scnt" size="20" name="rate['+idSub+']['+countSub+']" value="1" placeholder="Nhập Rate" />';
                    subhtml += '</div>';
                subhtml += '</div>';
             subhtml += '<div id="remVar" class="btn_remove">Remove</div>';
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
            $rules = json_decode($items['rules'],true);
            $countRule = count($rules);
            if(count($rules)>0){
                $i=0;
                foreach($rules as $krule=>$vrule){
                    $i++;
        ?>
        <div class="item_rule" id="item_rule_<?php echo $i;?>">
            <div class="rows">
                <div class="title">Số đợt:</div>
                <div class="input"><input type="text" id="p_scnt" size="20" value="<?php echo $vrule['key'];?>" name="keyrule[<?php echo $i;?>]"  placeholder="Nhập số đợt"></div>
            </div>
            <div class="rows">
                <div class="title">Name:</div>
                <div class="input"><input type="text" id="p_scnt" size="20" value="<?php echo $vrule['name'];?>" name="keyname[<?php echo $i;?>]"  placeholder="Nhập tên đợt"></div>
            </div>
            <div class="rows">
                <div class="title">Bắt đầu:</div>
                <div class="input"><input type="text" class="datetime" size="20" value="<?php echo date_format(date_create($vrule['start']),"d-m-Y G:i:s");?>" name="keystart[<?php echo $i;?>]" placeholder="Ngày bắt đầu" /></div>
            </div>
           <div class="rows">
                <div class="title">Kết thúc:</div>
                <div class="input"><input type="text" class="datetime" size="20" value="<?php echo date_format(date_create($vrule['end']),"d-m-Y G:i:s");?>" name="keyend[<?php echo $i;?>]" placeholder="Ngày Kết thúc" /></div>
            </div>
            <div class="btn_remove" id="remScnt">Remove</div>
            <div class="clr"></div>
            <div class="btn_addsub btn btn-warning createdSub" dataID="<?php echo $i;?>" keyrule_<?php echo $i;?>="<?php echo $i;?>">Thêm loại</div>
            <div class="sublist countSublist_<?php echo $i;?>">
                <?php
                    if(count($vrule['items'])>0){
                        $j=0;
                        foreach($vrule['items'] as $kcon=>$v){
                            $j++;
                ?>
                <div class="sub_item_rule" id="sub_item_rule">
                    <div class="rows">
                        <div class="title">Item ID</div>
                        <div class="input"><input type="text" placeholder="Nhập Item ID" value="<?php echo $v['item_id'];?>" name="item_id[<?php echo $i;?>][<?php echo $j;?>]" size="20" id="p_scnt"></div>
                    </div>
                    <div class="rows">
                        <div class="title">Name</div>
                        <div class="input"><input type="text" placeholder="Nhập Item Name" value="<?php echo $v['name'];?>" name="name[<?php echo $i;?>][<?php echo $j;?>]" size="20" id="p_scnt"></div>
                    </div>
                    <div class="rows">
                        <div class="title">Count</div>
                        <div class="input"><input type="text" placeholder="Nhập Count" value="<?php echo $v['count'];?>" name="count[<?php echo $i;?>][<?php echo $j;?>]" size="20" id="p_scnt"></div>
                    </div>
                    <div class="rows">
                        <div class="title">Rate</div>
                        <div class="input"><input type="text" placeholder="Nhập Rate" value="<?php echo $v['rate'];?>" name="rate[<?php echo $i;?>][<?php echo $j;?>]" size="20" id="p_scnt"></div>
                    </div>
                    <div class="btn_remove" id="remVar">Remove</div>
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
                html +='<div class="rows">';
                    html +='<div class="title">Số đợt:</div>';
                    html +='<div class="input"><input type="text" id="p_scnt" size="20" name="keyrule['+x+']" value="1" placeholder="Nhập số đợt" /></div>';
                html +='</div>';
                html +='<div class="rows">';
                    html +='<div class="title">Name:</div>';
                    html +='<div class="input"><input type="text" id="p_scnt" size="20" name="keyname['+x+']" value="1" placeholder="Nhập tên đợt" /></div>';
                html +='</div>';
                html +='<div class="rows">';
                    html +='<div class="title">Bắt đầu:</div>';
                    html +='<div class="input"><input type="text" class="datetime" size="20" name="keystart['+x+']" value="<?php echo date('d-m-Y G:i:s');?>" placeholder="Ngày bắt đầu" /></div>';
                html +='</div>';
                html +='<div class="rows">';
                    html +='<div class="title">Kết thúc:</div>';
                    html +='<div class="input"><input type="text" class="datetime" size="20" name="keyend['+x+']" value="<?php echo date('d-m-Y G:i:s');?>" placeholder="Ngày Kết thúc" /></div>';
                html +='</div>';
                html +='<div id="remScnt" class="btn_remove">Remove</div>';
                    html +='<div class="clr"></div>';
                    html +='<div id="addVar" keyrule="'+x+'" class="btn_addsub btn btn-warning">Thêm Items</div><div class="sublist"></div>';
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
                    subhtml += '<div class="rows">'; 
                        subhtml += '<div class="title">Item ID</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="item_id['+keyrule+']['+y+']" value="1" placeholder="Nhập Item ID" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                    subhtml += '<div class="rows">'; 
                        subhtml += '<div class="title">Name</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="name['+keyrule+']['+y+']" value="1" placeholder="Nhập Tên" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                    subhtml += '<div class="rows">'; 
                        subhtml += '<div class="title">Count</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="count['+keyrule+']['+y+']" value="1" placeholder="Nhập Count" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                    subhtml += '<div class="rows">'; 
                        subhtml += '<div class="title">Rate</div>'; 
                        subhtml += '<div class="input">';
                            subhtml += '<input type="text" id="p_scnt" size="20" name="rate['+keyrule+']['+y+']" value="1" placeholder="Nhập Rate" />';
                        subhtml += '</div>';
                    subhtml += '</div>';
                 subhtml += '<div id="remVar" class="btn_remove">Remove</div>';
                 subhtml +='<div class="clr"></div>';
             subhtml += '</div>';
            $(subhtml).appendTo($(this).next());
            return false;
        });
        $('#remVar').live('click', function() { 
            $(this).parent('div#sub_item_rule').remove();  
            return false;
        });
    });
</script>