<style>
    .btn{
        cursor:pointer;
        border-radius: 5px;
    }
    .item_rule input{
        height: auto !important;
        width: 160px;
    }
    .item_rule .input.picture{
        margin-top: 4px;
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
            $rules = json_decode($items['item_id'], true);
            $countRule = count($rules);
            if (is_array($rules)) {
                $i = 0;
                foreach ($rules as $k => $v) {
                    $i++;
        ?>
            <div class="item_rule">
                <div class="rows">
                    <div class="title">Item ID:</div>
                    <div class="input"><input type="text" placeholder="Nhập Item ID" value="<?php echo $v['item_id']; ?>" name="item_id[<?php echo $k;?>]" class="width20"/></div>
                </div>
                <div class="rows">
                    <div class="title">Name:</div>
                    <div class="input"><input type="text" placeholder="Nhập Name" value="<?php echo $v['name']; ?>" name="name[<?php echo $k;?>]" size="20"/></div>
                </div>
                <div class="rows">
                    <div class="title">Picture:</div>
                    <div class="input picture">
                        <input type="file" name="images[<?php echo $k;?>]"/>
                        <?php
                            if($_GET['id']>0){
                        ?>
                        <div id="load-content" style="margin-top:10px;">
                            <?php
                                if(!empty($v['images'])){
                                    $removeLink = $url_service.'/cms/uocnguyen/remove_image?id='.$v['item_id'];
                            ?>
                            <img src="<?php echo $url_picture.'/'.$v['images'];?>" height="50px"/>
                            <div style="padding-top:5px;display: none"><a href="javascript:loadPage('div#load-content','<?php echo $removeLink;?>')">remove</a></div>
                            <?php
                                }
                            ?>

                            <input type="hidden" id="current_images" name="current_images[<?php echo $k;?>]" value="<?php echo $v['images'];?>"/>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="rows">
                    <div class="title">Count:</div>
                    <div class="input"><input type="text" placeholder="Nhập Count" value="<?php echo $v['count']; ?>" name="count[<?php echo $k;?>]" class="width20"/></div>
                </div>
                <div class="rows">
                    <div class="title">Quantity:</div>
                    <div class="input"><input type="text" placeholder="Nhập Quantity" value="<?php echo $v['quantity']; ?>" name="quantity[<?php echo $k;?>]" class="width20"/></div>
                </div>
				<input type="hidden" name="current_quantity[<?php echo $k;?>]" value="<?php echo $v['current_quantity']; ?>"/>
                <div class="rows">
                    <div class="title">Rate:</div>
                    <div class="input"><input type="text" placeholder="Nhập Rate" value="<?php echo $v['rate']; ?>" name="rate[<?php echo $k;?>]" class="width20"/></div>
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
            html += '           <div class="input"><input type="text" class="width20" name="item_id['+x+']" value="1" placeholder="Nhập Item ID" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Name:</div>';
            html += '           <div class="input"><input type="text" size="20" name="name['+x+']" value="1" placeholder="Nhập Name" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Picture:</div>';
            html += '           <div class="input picture"><input type="file" name="images['+x+']"/></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Count:</div>';
            html += '           <div class="input"><input type="text" class="width20" name="count['+x+']" value="1" placeholder="Nhập Count" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Quantity:</div>';
            html += '           <div class="input"><input type="text" class="width20" name="quantity['+x+']" value="1" placeholder="Nhập Quantity" /></div>';
            html += '       </div>';
            html += '       <div class="rows">';
            html += '           <div class="title">Rate:</div>';
            html += '           <div class="input"><input type="text" class="width20" name="rate['+x+']" value="1" placeholder="Nhập Rate" /></div>';
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