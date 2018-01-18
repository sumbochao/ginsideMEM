
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
        padding:10px 10px 0px 10px;
    }
    .btn_addsubsub{
        margin-right: 10px;
        float: left;
    }
    .btncoppy{
        margin-right: 10px;
    }
    .subsublist{
        margin-top: 10px;
    }
</style>

<script type="text/javascript">
    function htmlItem(keyrule,y){
        var subhtml = '<div id="sub_item_rule" class="sub_item_rule">';
        subhtml += '<div class="rows">';
        subhtml += '    <div class="title">Key</div>';
        subhtml += '    <div class="input">';
        subhtml += '        <input type="text" size="20" name="item_id[' + keyrule + '][' + y + ']" value="1" placeholder="Nhập Key" />';
        subhtml += '    </div>';
        subhtml += '</div>';
        subhtml += '<div class="rows">';
        subhtml += '    <div class="title">Value</div>';
        subhtml += '    <div class="input">';
        subhtml += '        <input type="text" size="20" name="name[' + keyrule + '][' + y + ']" value="1" placeholder="Nhập Value" />';
        subhtml += '    </div>';
        subhtml += '</div>';
        subhtml += '<div id="remVar" class="btn_remove">Remove</div>';
        subhtml += '<div class="clr"></div>';
        subhtml += '</div>';
        return subhtml;
    }
    $(function () {
        //cap 2
        $(".createdSub").click(function () {
            var idSub = $(this).attr('dataID');
            var countSub = $(".countSublist_" + idSub + " #sub_item_rule").length;
            countSub++;
            var subhtml = htmlItem(idSub,countSub);
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
            subhtml += '<div class="subsublist countSubSublist_'+countSub+' coppygroup_'+idSub+countSub+'">';
            subhtml += $('.coppygroup_' + idSub + idSubSub).html();
            subhtml += '</div>';
            subhtml += '</div>';
            while (subhtml.indexOf('[' + idSub + '][' + idSubSub + '][') > 0){
                subhtml = subhtml.replace('[' + idSub + '][' + idSubSub + '][', '[' + idSub + '][' + countSub + '][');
            }
            $(subhtml).appendTo($(this).next().parent().parent());
        });
    });
</script>


<div class="rule_item">
    <div id="addScnt" class="btn btn-success">Thêm rule</div>
    <div id="p_scents">
        <?php
            $rules = json_decode($getitem['extend_rules'], true);
            $countRule = count($rules);
            if (count($rules) > 0) {
                $i = 0;
                foreach ($rules as $krule => $vrule) {
                    $i++;
        ?>
        <div class="item_rule" id="item_rule_<?php echo $i; ?>">
            <div class="title">Loại shop:</div>
            <div class="input">
                <select name="keyrule[<?php echo $i; ?>]">
                    <option value="1" <?php echo $krule=='1'?'selected="selected"':''; ?>>Vàng</option>
                    <option value="2" <?php echo $krule=='2'?'selected="selected"':''; ?>>Bạc</option>
                </select>
            </div>
            <div class="btn_remove" id="remScnt">Remove</div>
            <div class="clr"></div>
            <div class="btn_addsub btn btn-warning createdSub" dataID="<?php echo $i; ?>">Thêm data</div>
            <div class="sublist countSublist_<?php echo $i; ?>">
            <?php
                if (count($vrule) > 0) {
                    $j = 0;
                    foreach ($vrule as $k => $v) {
                        $j++;
            ?>
                <div class="sub_item_rule" id="sub_item_rule">
                    <div class="rows">
                        <div class="title">Key</div>
                        <div class="input"><input type="text" placeholder="Nhập Key" value="<?php echo $k; ?>" name="item_id[<?php echo $i; ?>][<?php echo $j; ?>]" size="20"/></div>
                    </div>
                    <div class="rows">
                        <div class="title">Value</div>
                        <div class="input"><input type="text" placeholder="Nhập Value" value="<?php echo $v; ?>" name="name[<?php echo $i; ?>][<?php echo $j; ?>]" size="20"/></div>
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
    $(function () {
        var scntDiv = $('#p_scents');
        //cap 1
        <?php if ($_GET['id'] > 0) { ?>
        var x = '<?php echo $countRule; ?>';
        <?php } else { ?>
        var x = 0;
        <?php } ?>
        $('#addScnt').live('click', function () {
            x++;
            var html = '<div class="item_rule">';
            html += '<div class="title">Loại shop:</div>';
            html += '<div class="input"><select name="keyrule[' + x + ']"><option value="1">Vàng</option><option value="2">Bạc</option></select></div>';
            html += '<div id="remScnt" class="btn_remove">Remove</div>';
            html += '<div class="clr"></div>';
            html += '<div id="addVar" keyrule="' + x + '" class="btn_addsub btn btn-warning">Thêm data</div><div class="sublist"></div>';
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
        $('#addVar').live('click', function () {
            y++;
            var keyrule = $(this).attr('keyrule');
            var subhtml = htmlItem(keyrule,y);
            $(subhtml).appendTo($(this).next());
            return false;
        });
        $('#remVar').live('click', function () {
            $(this).parent('div#sub_item_rule').remove();
            return false;
        });
    });
</script>