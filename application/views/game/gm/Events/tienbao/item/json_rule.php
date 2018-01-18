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
        margin:10px 10px;
        padding-top: 15px;
        border-top: 1px solid #eee;
        box-shadow: 0 1px 0 #fff inset;
    }
    .item_rule > .rows > .title{
        float: left;
        margin-right: 10px;
        margin-top:5px;
    }
    .item_rule > .rows > .input{
        float: left;
        padding-right: 5px;
    }
    .item_rule > .rows > .input input{
        margin-bottom: 0px;
    }
    .item_rule > .btn_remove{
        float: left;
        margin-top: 5px;
        cursor: pointer;
        color: green;
    }
    .item_rule .rows{
        float: left;
        margin-right: 10px;
    }
    .item_rule{
        margin-bottom: 10px;
    }
    .item_rule{
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
    }
    .clr{
        clear: both;
    }
</style>
<div class="rule_item">
    <div id="addScnt" class="btn btn-success">Thêm rule</div>
    <div id="p_scents">
        <?php
        $rules = json_decode($items['item'], true);
        $countRule = count($rules);
        if (count($rules) > 0) {
            $i = 0;
            foreach ($rules as $k => $v) {
                $i++;
                ?>
                <div class="item_rule">
                    <div class="rows">
                        <div class="title">Item ID:</div>
                        <div class="input"><input type="text" placeholder="Nhập Item ID" value="<?php echo $v['item_id']; ?>" name="item_id[]" size="20"></div>
                    </div>
                    <div class="rows">
                        <div class="title">Count:</div>
                        <div class="input"><input type="text" placeholder="Nhập Count" value="<?php echo $v['count']; ?>" name="item_count[]" size="20"></div>
                    </div>
                    <div class="rows">
                        <div class="title">Type:</div>
                        <div class="input"><input type="text" placeholder="Nhập Type" value="<?php echo $v['type']; ?>" name="item_type[]" size="20"></div>
                    </div>
                    <div class="btn_remove" id="remScnt">Remove</div>
                    <div class="clr"></div> 
                </div>
                <?php
            }
        }
        ?>
    </div>
    
</div>
<script>
    $(function () {
        var scntDiv = $('#p_scents');
        //cap 1
        var x = 0;
        $('#addScnt').live('click', function () {
            x++;
            var html = '<div class="item_rule">';
            html += '       <div class="rows">';
            html += '           <div class="title">Item ID:</div>';
            html += '           <div class="input"><input type="text" size="20" name="item_id[]" value="1" placeholder="Nhập Item ID" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Count:</div>';
            html += '           <div class="input"><input type="text" size="20" name="item_count[]" value="1" placeholder="Nhập Count" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Type:</div>';
            html += '           <div class="input"><input type="text" size="20" name="item_type[]" value="1" placeholder="Nhập Type" /></div>';
            html += '       </div>';
            html += '       <div id="remScnt" class="btn_remove">Remove</div>';
            html += '       <div class="clr"></div>';
            html += '   </div>';
            $(html).appendTo(scntDiv);
            return false;
        });
        $('#remScnt').live('click', function () {
            $(this).parents('div.item_rule').remove();
            return false;
        });
    });
</script>