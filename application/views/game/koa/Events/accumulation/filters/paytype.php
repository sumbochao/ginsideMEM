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
    <div id="addScntType" class="btn btn-success">Thêm rule</div>
    <div id="p_scentsType">
        <?php
        $rules = json_decode($items['paytype'], true);
        $countRule = count($rules);
        if (count($rules) > 0) {
            $i = 0;
            foreach ($rules as $k => $v) {
                $i++;
                ?>
                <div class="item_rule item_ruleType">
                    <div class="rows">
                        <div class="title">Item ID:</div>
                        <div class="input"><input type="text" placeholder="Nhập Paytye" value="<?php echo $v; ?>" name="paytype[]" size="20"></div>
                    </div>
                    <div class="btn_remove" id="remScntType">Remove</div>
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
        var scntDiv = $('#p_scentsType');
        //cap 1
        var x = 0;
        $('#addScntType').on('click', function () {
            x++;
            var html = '<div class="item_rule item_ruleType">';
            html += '       <div class="rows">';
            html += '           <div class="title">Paytype:</div>';
            html += '           <div class="input"><input type="text" name="paytype[]" value="1" placeholder="Nhập Paytype" /></div>';
            html += '       </div>';
            html += '       <div id="remScntType" class="btn_remove">Remove</div>';
            html += '       <div class="clr"></div>';
            html += '   </div>';
            $(html).appendTo(scntDiv);
            return false;
        });
        $('#remScntType').on('click', function () {
            $(this).parents('div.item_ruleType').remove();
            return false;
        });
    });
</script>