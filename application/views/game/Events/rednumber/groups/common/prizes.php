<style>
    #addprizes.modal{
        top:5%;left: 25%;right:25%;
        background: #FFF;
        overflow: visible;
        border-radius: 5px;
        height: 517px;
    }
    #addprizes .modal-header{
        padding: 0px 0px 0px 10px;
    }
    #addprizes .modal-footer{
        padding:10px 20px 20px 19px;
    }
    #addprizes .modal-header .close{
        margin-right: 10px;
    }
    @media (max-width:999px){
        .modal-footer{
            margin-top: 0px;
        }
    }
    .listprizes {
        border: 1px solid #ccc;
        min-height: 35px;
        padding: 7px 5px 0;
    }
    .icon-remove::after{
        content: "x";
        width: 16px;
        height: 16px;
        cursor: pointer;
        margin-left: 8px;
    }
    .listprizes .rows{
        display: inline-block;
        margin-bottom: 7px;
        margin-right: 10px;
        background: #5bc0de;
        border-radius: 0.25em;
        color: #FFF;
        padding:0.2em 0.6em 0.1em;
    }
    .listprizes .icon-view{
        white-space: nowrap;
        display: inline-block;
        text-decoration: none;
    }
    .modal-footer{
        margin-top: 32px;
    }
    .contentPrizes .contentprizestext a{
        width: auto;
        color: #FFF;
        margin-top: 0px;
        font-weight: bold;
        font-size: 12px;
    }
    .contentPrizes .icon-remove{
        margin-top: -1px;
    }
</style>
<script>
    function loadIframecontentPrizes() {
        var lid = "";
        jQuery("#divprizescontent").find(".contentPrizes").each(function(){
            lid += ","+jQuery(this).find(".icon-remove").attr("itemprizesid");
        });
        if(lid != ""){
            lid = lid.substring(1);
        }
        jQuery("#ifmprizes").html('<iframe style="width:100%;height:350px;border:0px;" id="ifmprizescontent" src="<?php echo APPLICATION_URL;?>?control=rednumber&func=listprizes&iframe=1&lid='+lid+'"></iframe>');
    } 
    function update_source_prizes(){
        var data = [];
        jQuery("#divprizescontent").find(".contentPrizes").each(function(){
            var json = {
                'prizes_id':jQuery(this).find(".icon-remove").attr("itemprizesid")
            };
            data.push(json);
        });
        jQuery("#content_prizes").val(JSON.stringify(data));
    }
</script>
<div class="control-group">
    <label class="control-label">Giải thưởng:</label>
    <div class="controls">
        <a href="#addprizes" onclick="loadIframecontentPrizes();" class="btn btn-primary"  data-toggle="modal">Thêm Giải thưởng</a>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Giải thưởng đã chọn</label>
    <div class="listprizes controls" id="divprizescontent">
        <div class="rows contentPrizestemp" style="display: none;">
            <span class="contentprizestext"><a data-toggle="modal" href="#addviewprizes" itemid="" class="icon-view">Giải thưởng</a></span>
            <span itemprizesid="" class="icon-remove"></span>
        </div>
        <?php
            $j_arrValuePrizes = '';
            if(!empty($items['prizes'])){
                $content_prizes = str_replace('[', '', $items['prizes']);
                $content_prizes = str_replace(']', '', $content_prizes);
                $content_prizes = explode(',', $content_prizes);
                if(count($content_prizes)>0){
                    $i=0;
                    foreach($content_prizes as $v){
        ?>
        <div class="rows contentPrizes">
            <span class="contentprizestext"><a data-toggle="modal" href="#addviewprizes" class="icon-view"><?php echo $v;?></a></span>
            <span itemprizesid="<?php echo $v;?>" class="icon-remove"></span>
        </div>
        <?php
                        $arrValuePrizes[$i]['prizes_id'] = $v;
                        $i++;
                    }
                    $j_arrValuePrizes = json_encode($arrValuePrizes);
                }
            }
        ?>
    </div>
    <div class="clr"></div>
</div>
<input type="hidden" name="content_prizes" id="content_prizes" value='<?php echo $j_arrValuePrizes;?>'/>
<div id="addprizes" class="modal">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button" id="ifr">×</button>
        <h3>Thêm giải thưởng</h3>
    </div>
    <div class="modal-body" id="ifmprizes"></div>
    <div class="modal-footer">
        <a class="btn btn-default btn-primary cmdAddItemPrizes" href="javascript:;">Thêm</a>
        <a data-dismiss="modal" class="btn btn-default btn_cancel" href="#">Bỏ qua</a>
    </div>
</div>
<script>
    
    jQuery(".cmdAddItemPrizes").click(function(){
        //get value in checkbox (all)
        var a_chekcbox = [];
        $("#ifmprizescontent").contents().find(".add_checkbox").each(function(i){
            a_chekcbox[i] = jQuery(this).val();
        })
        var a_checked = [];
        //get value checked in Content
        jQuery("#divprizescontent").find(".contentPrizes").each(function(j){
            a_checked[j] = jQuery(this).find(".icon-remove").attr("itemprizesid");
        });
        $("#ifmprizescontent").contents().find(".add_checkbox").each(function(){
            // add new
            if(jQuery(this).is(":checked") && $.inArray(jQuery(this).val(),a_checked) < 0){
                var html = jQuery("#divprizescontent").find(".contentPrizestemp").html();
                var newevent = jQuery("<div class='rows contentPrizes'></div>").html(html);
                jQuery(newevent).find(".contentprizestext > a").html(jQuery(this).attr("prizesid"));
                jQuery(newevent).find(".icon-remove").attr("itemprizesid",jQuery(this).val());
                jQuery(newevent).find(".icon-view").attr("itemprizesid",jQuery(this).val());
                jQuery("#divprizescontent").append(newevent);
            }
        });
        //remove
        jQuery("#divprizescontent").find(".contentPrizes").each(function(j){
            var checked = jQuery(this).find(".icon-remove").attr("itemprizesid");
            if($.inArray(checked,a_chekcbox) >= 0 
                && !$("#ifmprizescontent").contents().find(".add_checkbox[value="+checked+"]").is(":checked")){
                jQuery(this).remove();          
            }
        });
        jQuery(".btn_cancel").click();
        delete_prizes();
        update_source_prizes();
    });
    
    function delete_prizes(){
        jQuery(".contentPrizes .icon-remove").click(function () {
            jQuery(this).parent().remove();
            update_source_prizes();
        });
    }
    delete_prizes();
</script>