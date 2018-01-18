<style>
    .btn{
        cursor:pointer;
        border-radius: 5px;
    }
    .item_rule input{
        height: auto !important;
        width: 160px;
    }
    .item_rule input.img{
        height: auto !important;
        width: 390px;
    }
    .rule_item{
        margin:0px 10px;
    }
    .item_rule input.width20{
        width: 80px;
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
    .item_rule > .btn_remove{
        float: left;
        margin-top: 12px;
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
    .item_rule > .rows{
        margin-right: 10px;
        float: left;
        margin-top: 10px;
    }
    .item_rule{
        border: 1px solid #ccc;
        padding: 0px 10px;
        margin-top: 10px;
    }
    .clr{
        clear: both;
    }
</style>
<div class="rule_item">
    <div id="addScnt" class="btn btn-success">Thêm giá trị</div>
    <div id="p_scents">
        <?php
            if (count($_POST['key'])>0) {
                $i = 0;
                foreach ($_POST['key'] as $key) {
        ?>
            <div class="item_rule">
                <div class="rows">
                    <div class="title">Key:</div>
                    <div class="input"><input type="text" placeholder="Nhập Key" value="<?php echo $key; ?>" name="key[]" class="width20"/></div>
                </div>
                <div class="rows">
                    <div class="title">Value:</div>
                    <div class="input"><input type="text" placeholder="Nhập Value" value="<?php echo $_POST['value'][$i]; ?>" name="value[]" size="20"/></div>
                </div>
                <div class="btn_remove" id="remScnt">Remove</div>
                <div class="clr"></div>
            </div>
        <?php
                    $i++;
                }
            }
        ?>
        
    </div>
</div>
<script>
    $(function () {
        var scntDiv = $('#p_scents');
        var x = 0;
        $('#addScnt').on('click', function () {
            var html = '<div class="item_rule">';
            html += '       <div class="rows">';
            html += '           <div class="title">Key:</div>';
            html += '           <div class="input"><input type="text" class="width20" name="key[]" value="1" placeholder="Nhập Key" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Value:</div>';
            html += '           <div class="input"><input type="text" size="20" name="value[]" value="1" placeholder="Nhập Value" /></div>';
            html += '       </div>';
            html += '       <div id="remScnt" class="btn_remove">Remove</div>';
            html += '       <div class="clr"></div>';
            html += '   </div>';
            x++;
            $(html).appendTo(scntDiv);
            return false;
        });
        $('.rule_item').on('click',"#remScnt", function () {
            $(this).parents('div.item_rule').remove();
            return false;
        });
    });
</script>