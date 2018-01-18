
<style>
    .btn{
        cursor:pointer;
        border-radius: 5px;
    }
    .item_rule input{
        height: auto !important;
        width: 100%;
        margin-bottom: 0px;
    }
    .rule_item{
        margin:0px 10px;
    }
    .item_rule .rows{
        margin-right: 10px;
        float: left;
        margin-bottom: 0px;
        width: 50%;
    }
    .item_rule .rows > .title{
        float: left;
        margin-right: 10px;
        margin-top:5px;
        width: 18%;
    }
    .item_rule .rows > .input{
        float: left;
        padding-right: 5px;
        width: 77%;
    }
    .item_rule > .btn_remove{
        float: left;
        margin-top: 5px;
        cursor: pointer;
        color: green;
    }
    .item_rule{
        margin-bottom: 10px;
        margin-top: 10px;
        
    }
</style>
<div class="rule_item">
    <div id="addScnt" class="btn btn-success">Thêm domain</div>
        <div id="p_scents">
        <?php
            $rules = json_decode($items['domain'],true);
            $countRule = count($rules);
            if(count($rules)>0){
                $i=0;
                foreach($rules as $krule=>$vrule){
                    $i++;
        ?>
        <div class="item_rule">
            <div class="rows">
                <div class="title"><?php echo $i;?>) Tên miền:</div>
                <div class="input"><input type="text" value="<?php echo $vrule;?>" name="domain[]"  placeholder="domain.mobo.vn"></div>
            </div>
            <div class="btn_remove" id="remScnt">Remove</div>
            <div class="clr"></div>            
        </div>
        <?php
                }
            }
        ?>
    </div>
    <div class="clr"></div>
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
                    html +='<div class="title">Tên miền:</div>';
                    html +='<div class="input"><input type="text" size="20" name="domain[]" value="" placeholder="domain.mobo.vn" /></div>';
                html +='</div>';
                html +='<div id="remScnt" class="btn_remove">Remove</div>';
                html +='<div class="clr"></div>';
                html +='</div>';
            $(html).appendTo(scntDiv);
            return false;
        });
        $('#remScnt').live('click', function() { 
            $(this).parents('div.item_rule').remove();
            return false;
        });
    });
</script>