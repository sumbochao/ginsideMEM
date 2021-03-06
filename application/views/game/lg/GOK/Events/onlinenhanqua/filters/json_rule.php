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
        margin-top: 10px;
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
    .btncoppy{
        margin-right: 10px;
    }
</style>

<script type="text/javascript">

    $(function () {
        //cap 2
        $(".createdSub").click(function () {
            var idSub = $(this).attr('dataID');
            var idSubSub = $(this).attr('dataID');
            var countSubSub = $(".countSublist_" + idSub + " .countSubSublist_" + idSubSub + " #subsub_item_rule").length;
            countSubSub++;
            var subhtml = '<div id="subsub_item_rule" class="sub_item_rule">';
            subhtml += '<div class="rows">';
            subhtml += '<div class="title">Item ID</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="item_id[' + idSub + '][' + idSubSub + '][' + countSubSub + ']" value="1" placeholder="Nhập Item ID" />';
            subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div class="rows">';
            subhtml += '<div class="title">Name</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="name[' + idSub + '][' + idSubSub + '][' + countSubSub + ']" value="1" placeholder="Nhập Item Name" />';
            subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div class="rows">';
            subhtml += '<div class="title">Count</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="count[' + idSub + '][' + idSubSub + '][' + countSubSub + ']" value="1" placeholder="Nhập Count" />';
            subhtml += '</div>';
            subhtml += '</div>';

            subhtml += '<div class="rows" style="display:none">';
            subhtml += '<div class="title">Rate</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="rate[' + idSub + '][' + idSubSub + '][' + countSubSub + ']" value="1" placeholder="Nhập Rate" />';
            subhtml += '</div>';
            subhtml += '</div>';

            subhtml += '<div class="rows" style="display:none">';
            subhtml += '<div class="title">Type</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="type[' + idSub + '][' + idSubSub + '][' + countSubSub + ']" value="1" placeholder="Nhập Type" />';
            subhtml += '</div>';
            subhtml += '</div>';
//            subhtml += '<div id="remVarSub" class="btn_remove">Remove</div>';
            subhtml += '<div id="remVar" class="btn_remove">Remove</div>';
            subhtml += '<div class="clr"></div>';
            subhtml += '</div>';
            $(subhtml).appendTo($(this).next());
            return false;
        });
        
        //coppy list items
        $(".btncoppy").click(function () {
            var idSub = $(this).attr('dataID');
            var idSubSub = $(this).attr('dataSubSub');
            var countSub = $(".countSublist_" + idSub + " #sub_item_rule").length;
            countSub++;
            var subhtml = '<div id="sub_item_rule" class="sub_item_rule">';
            subhtml += '<div class="rows" style="display:none">';
            subhtml += '    <div class="title">From</div>';
            subhtml += '    <div class="input">';
            subhtml += '        <input type="text" id="p_scnt" size="20" name="from[' + idSub + '][' + countSub + ']" value="1" placeholder="Nhập from" />';
            subhtml += '    </div>';
            subhtml += '</div>';
            subhtml += '<div class="rows" style="display:none">';
            subhtml += '    <div class="title">To</div>';
            subhtml += '    <div class="input">';
            subhtml += '        <input type="text" id="p_scnt" size="20" name="to[' + idSub + '][' + countSub + ']" value="1" placeholder="Nhập to" />';
            subhtml += '    </div>';
            subhtml += '</div>';
            subhtml += '<div id="remVar" class="btn btn-danger">Remove</div>';
            subhtml += '<div class="clr" style="display:none"></div>';
            subhtml += '<div dataID="' + idSub + '" dataSubSub="' + countSub + '" rulecondition="' + idSub + '" condition="' + countSub + '"  class="createdSubSub btn_addsubsub btn btn-info">Thêm items add</div>';
            subhtml += '<div class="subsublist countSubSublist_' + countSub + ' coppygroup_' + idSub + countSub + '">';
            subhtml += $('.coppygroup_' + idSub + idSubSub).html();
            subhtml += '</div>';
            subhtml += '</div>';
            while (subhtml.indexOf('[' + idSub + '][' + idSubSub + '][') > 0) {
                subhtml = subhtml.replace('[' + idSub + '][' + idSubSub + '][', '[' + idSub + '][' + countSub + '][');
            }
            $(subhtml).appendTo($(this).next().parent().parent());
        });
    });
</script>
<div class="rule_item">
    <div id="addScnt" class="btn btn-success">Thêm Promotion</div>
    <div id="p_scents">
        <?php
        $rules = json_decode($items['promotion'], true);
        $countRule = count($rules);
        if (count($rules) > 0) {
            $i = 0;
            foreach ($rules as $krule => $vrule) {
                $i++;
                ?>
                <div class="item_rule" id="item_rule_<?php echo $i; ?>">
                    <div class="clr"></div>
                    <div id="addVar" class="btn_addsub btn btn-warning createdSub" dataID="<?php echo $i; ?>" keyrule="<?php echo $i; ?>">Thêm Item</div>
                    <div class="sublist countSublist_<?php echo $i; ?>">
                        <?php
                        if (count($vrule) > 0) {
                            $j = 0;
                            foreach ($vrule as $kcon => $vcon) {
                                $j++;
                                ?>
                                    <div class="sub_item_rule" id="subsub_item_rule">
                                        <div class="rows">
                                            <div class="title">Item ID</div>
                                            <div class="input"><input type="text" placeholder="Nhập Item ID" value="<?php echo $vcon['item_id']; ?>" name="items[item_id[<?php echo $i; ?>][<?php echo $i; ?>][<?php echo $j; ?>]]" size="20" id="p_scnt"></div>
                                        </div>
                                        <div class="rows">
                                            <div class="title">Name</div>
                                            <div class="input"><input type="text" placeholder="Nhập Item Name" value="<?php echo $vcon['name']; ?>" name="items[name[<?php echo $i; ?>][<?php echo $i; ?>][<?php echo $j; ?>]]" size="20" id="p_scnt"></div>
                                        </div>
                                        <div class="rows">
                                            <div class="title">Count</div>
                                            <div class="input"><input type="text" placeholder="Nhập Count" value="<?php echo $vcon['count']; ?>" name="items[count[<?php echo $i; ?>][<?php echo $i; ?>][<?php echo $j; ?>]]" size="20" id="p_scnt"></div>
                                        </div>
                                        <div class="rows" style="display:none">
                                            <div class="title">Rate</div>
                                            <div class="input"><input type="text" placeholder="Nhập Rate" value="<?php echo $vcon['rate']; ?>" name="items[rate[<?php echo $i; ?>][<?php echo $i; ?>][<?php echo $j; ?>]]" size="20" id="p_scnt"></div>
                                        </div>
                                        <div class="rows" style="display:none">
                                            <div class="title">Type</div>
                                            <div class="input"><input type="text" placeholder="Nhập Type" value="<?php echo $vcon['type']; ?>" name="items[type[<?php echo $i; ?>][<?php echo $i; ?>][<?php echo $j; ?>]]" size="20" id="p_scnt"></div>
                                        </div>
                                        <!--<div class="btn_remove" id="remVarSub">Remove</div>-->
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
    $(function () {
        var scntDiv = $('#p_scents');
        //cap 1
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
            x++;
            var html = '<div class="item_rule">';
            html += '<div class="clr"></div>';
            html += '<div id="addVar" keyrule="' + x + '" class="btn_addsub btn btn-warning">Thêm item</div><div class="sublist"></div>';
            html += '</div>';
            $(html).appendTo(scntDiv);
            return false;
        });
        $('#remScnt').live('click', function () {
            $(this).parents('div.item_rule').remove();
            return false;
        });
        //cap 2
        var y = 0;
        var z = 0;
        $('#addVar').live('click', function () {
            var rulecondition = $(this).attr('keyrule');
            var condition = $(this).attr('keyrule');
            z++;
            var subhtml = '<div id="subsub_item_rule" class="sub_item_rule">';
            subhtml += '<div class="rows">';
            subhtml += '<div class="title">Item ID</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="items[item_id[' + rulecondition + '][' + condition + '][' + z + ']]" value="1" placeholder="Nhập Item ID" />';
            subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div class="rows">';
            subhtml += '<div class="title">Name</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="items[name[' + rulecondition + '][' + condition + '][' + z + ']]" value="1" placeholder="Nhập Item Name" />';
            subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div class="rows">';
            subhtml += '<div class="title">Count</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="items[count[' + rulecondition + '][' + condition + '][' + z + ']]" value="1" placeholder="Nhập Count" />';
            subhtml += '</div>';
            subhtml += '</div>';

            subhtml += '<div class="rows" style="display:none">';
            subhtml += '<div class="title">Rate</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="items[rate[' + rulecondition + '][' + condition + '][' + z + ']]" value="1" placeholder="Nhập Rate" />';
            subhtml += '</div>';
            subhtml += '</div>';

            subhtml += '<div class="rows" style="display:none">';
            subhtml += '<div class="title">Type</div>';
            subhtml += '<div class="input">';
            subhtml += '<input type="text" id="p_scnt" size="20" name="items[type[' + rulecondition + '][' + condition + '][' + z + ']]" value="1" placeholder="Nhập Type" />';
            subhtml += '</div>';
            subhtml += '</div>';
            subhtml += '<div id="remVar" class="btn_remove">Remove</div>';
            subhtml += '<div class="clr"></div>';
            subhtml += '</div>';
            $(subhtml).appendTo($(this).next());
            return false;
        });
        $('#remVar').live('click', function () {
            $(this).parent('div#subsub_item_rule').remove();
            return false;
        });

    });
</script>