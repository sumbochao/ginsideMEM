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
    .item_rule > .rows{
        margin-right: 10px;
        float: left;
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
<script>
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<div class="rule_item">
    <div id="addScnt" class="btn btn-success">Thêm rule</div>
    <div id="p_scents">
        <?php
            $rules = json_decode($items['items'], true);
            $countRule = count($rules);
            if (is_array($rules)) {
                $i = 0;
                foreach ($rules as $k => $v) {
                    $i++;
        ?>
            <div class="item_rule">
                <div class="rows">
                    <div class="title">Item ID:</div>
                    <div class="input"><input type="text" placeholder="Nhập Item ID" value="<?php echo $v['item_id']; ?>" name="item_id[]" class="width20"/></div>
                </div>
                <div class="rows">
                    <div class="title">Name:</div>
                    <div class="input"><input type="text" placeholder="Nhập Name" value="<?php echo $v['name']; ?>" name="name[]" size="20"/></div>
                </div>
                <div class="rows">
                    <div class="title">Picture:</div>
                    <div class="input"><input type="text" placeholder="Nhập Picture" value="<?php echo $v['img']; ?>" name="img[]" class="img"/></div>
                </div>
                <div class="rows">
                    <div class="title">Count:</div>
                    <div class="input"><input type="text" placeholder="Nhập Count" value="<?php echo $v['count']; ?>" name="count[]" class="width20"/></div>
                </div>
                <div class="rows">
                    <div class="title">Rate:</div>
                    <div class="input"><input type="text" placeholder="Nhập Rate" value="<?php echo $v['rate']; ?>" name="rate[]" class="width20"/></div>
                </div>
                <div class="rows">
                    <div class="title">Type:</div>
                    <div class="input"><input type="text" placeholder="Nhập Type" value="<?php echo $v['type']; ?>" name="rate[]" class="width20"/></div>
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
        <?php
            if ($_GET['id'] > 0) {
        ?>
            var x = '<?php echo $countRule; ?>';
        <?php
            } else {
        ?>
            var x = 0;
        <?php } ?>
        $('#addScnt').live('click', function () {
            var html = '<div class="item_rule">';
            html += '       <div class="rows">';
            html += '           <div class="title">Item ID:</div>';
            html += '           <div class="input"><input type="text" class="width20" name="item_id[]" value="1" placeholder="Nhập Item ID" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Name:</div>';
            html += '           <div class="input"><input type="text" size="20" name="name[]" value="1" placeholder="Nhập Name" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Image:</div>';
            html += '           <div class="input"><input type="text" class="img" name="img[]" value="1" placeholder="Nhập Images" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Count:</div>';
            html += '           <div class="input"><input type="text" class="width20" name="count[]" value="1" placeholder="Nhập Count" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Rate:</div>';
            html += '           <div class="input"><input type="text" class="width20" name="rate[]" value="1" placeholder="Nhập Rate" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Type:</div>';
            html += '           <div class="input"><input type="text" class="width20" name="type[]" value="1" placeholder="Nhập Type" /></div>';
            html += '       </div>';
            html += '       <div id="remScnt" class="btn_remove">Remove</div>';
            html += '       <div class="clr"></div>';
            html += '   </div>';
            x++;
            $(html).appendTo(scntDiv);
            return false;
        });
        $('#remScnt').live('click', function () {
            $(this).parents('div.item_rule').remove();
            return false;
        });
    });
</script>