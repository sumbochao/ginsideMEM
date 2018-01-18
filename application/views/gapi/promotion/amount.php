<style>
    #addamount.modal{
        top:5%;left: 25%;right:25%;
        background: #FFF;
        overflow: visible;
        border-radius: 5px;
        height: 517px;
    }
    #addamount .modal-header{
        padding: 0px 0px 0px 10px;
    }
    #addamount .modal-footer{
        padding:10px 20px 20px 19px;
    }
    #addamount .modal-header .close{
        margin-right: 10px;
    }
    @media (max-width:999px){
        .modal-footer{
            margin-top: 0px;
        }
    }
    .listamount {
        border: 1px solid #ccc;
        float: left;
        margin-top: 10px;
        min-height: 35px;
        padding: 7px 5px 0;
        width: 100%;
        margin-bottom: 10px;
    }
    .icon-remove::after{
        content: "x";
        width: 16px;
        height: 16px;
        cursor: pointer;
        margin-left: 8px;
    }
    .listamount .rows{
        display: inline-block;
        margin-bottom: 7px;
        margin-right: 10px;
        background: #5bc0de;
        border-radius: 0.25em;
        color: #FFF;
        padding:0.2em 0.6em 0.1em;
    }
    .listamount .icon-view{
        white-space: nowrap;
        display: inline-block;
        text-decoration: none;
    }
    .modal-footer{
        margin-top: 32px;
    }
    .contentAmount .contentamounttext a{
        width: auto;
        color: #FFF;
        margin-top: 0px;
        font-weight: bold;
        font-size: 12px;
    }
    .contentAmount .icon-remove{
        margin-top: -1px;
    }
</style>
<script>
    function loadIframecontentAmount() {
        var aid = "";
        jQuery("#divamountcontent").find(".contentAmount").each(function(){
            aid += ","+jQuery(this).find(".icon-remove").attr("itemamountid");
        });
        if(aid != ""){
            aid = aid.substring(1);
        }
        jQuery("#ifmamount").html('<iframe style="width:100%;height:350px;border:0px;" id="ifmamountcontent" src="<?php echo APPLICATION_URL;?>?control=promotion_gapi&func=loadamount&iframe=1&aid='+aid+'"></iframe>');
    } 
    function update_source_amount(){
        var data = [];
        jQuery("#divamountcontent").find(".contentAmount").each(function(){
            data.push(jQuery(this).find(".icon-remove").attr("itemamountid"));
        });
        jQuery("#content_amount").val(JSON.stringify(data));
    }
</script>
<div class="rows">	
    <label for="menu_group_id">Amount</label>
    <a href="#addamount" onclick="loadIframecontentAmount();" class="btn btn-primary"  data-toggle="modal">Thêm amount</a>
</div>
<div class="wrapper_list">
     <label for="menu_group_id">Amount đã chọn</label>
    <div class="listamount" id="divamountcontent">
        <div class="rows contentAmounttemp" style="display: none;">
            <span class="contentamounttext"><a data-toggle="modal" href="#addviewamount" itemid="" class="icon-view">Amount</a></span>
			<span itemamountid="" class="icon-remove"></span>
        </div>
        <?php
            $j_arrAmount = '';
            if(!empty($items['amount'])){
                $content_amount = json_decode($items['amount'],true);
                if(count($content_amount)>0){
                    $i=0;
                    foreach($content_amount as $v){
        ?>
        <div class="rows contentAmount">
            <span class="contentamounttext"><a data-toggle="modal" href="#addviewamount" class="icon-view"><?php echo $v>0?number_format($v,0,',','.'):'0';?></a></span>
			<span itemamountid="<?php echo $v;?>" class="icon-remove"></span>
        </div>
        <?php
                        $arrAmount[$i] = $v;
                        $i++;
                    }
                    $j_arrAmount = json_encode($arrAmount);
                }
            }
        ?>
    </div>
    <div class="clr"></div>
</div>
<input type="hidden" name="content_amount" id="content_amount" value='<?php echo $j_arrAmount;?>'/>
<div id="addamount" class="modal">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button" id="ifr">×</button>
        <h3>Thêm amount</h3>
    </div>
    <div class="modal-body" id="ifmamount"></div>
    <div class="modal-footer">
        <a class="btn btn-default btn-primary cmdAddItemAmount" href="javascript:;">Thêm</a>
        <a data-dismiss="modal" class="btn btn-default btn_cancel" href="#">Bỏ qua</a>
    </div>
</div>
<script>
    
    jQuery(".cmdAddItemAmount").click(function(){
        //get value in checkbox (all)
        var a_chekcbox = [];
        $("#ifmamountcontent").contents().find(".add_checkbox").each(function(i){
            a_chekcbox[i] = jQuery(this).val();
        })
        var a_checked = [];
        //get value checked in Content
        jQuery("#divamountcontent").find(".contentAmount").each(function(j){
            a_checked[j] = jQuery(this).find(".icon-remove").attr("itemamountid");
        });
        $("#ifmamountcontent").contents().find(".add_checkbox").each(function(){
            // add new
            if(jQuery(this).is(":checked") && $.inArray(jQuery(this).val(),a_checked) < 0){
                var html = jQuery("#divamountcontent").find(".contentAmounttemp").html();
                var newevent = jQuery("<div class='rows contentAmount'></div>").html(html);
                jQuery(newevent).find(".contentamounttext > a").html(FormatNumber(jQuery(this).attr("amountid")));
                jQuery(newevent).find(".icon-remove").attr("itemamountid",jQuery(this).val());
                jQuery(newevent).find(".icon-view").attr("itemamountid",jQuery(this).val());
                jQuery("#divamountcontent").append(newevent);
            }
        });
        //remove
        jQuery("#divamountcontent").find(".contentAmount").each(function(j){
            var checked = jQuery(this).find(".icon-remove").attr("itemamountid");
            if($.inArray(checked,a_chekcbox) >= 0 
                && !$("#ifmamountcontent").contents().find(".add_checkbox[value="+checked+"]").is(":checked")){
                jQuery(this).remove();          
            }
        });
        jQuery(".btn_cancel").click();
        delete_amount();
        update_source_amount();
    });
    
    function delete_amount(){
        jQuery(".contentAmount .icon-remove").click(function () {
            jQuery(this).parent().remove();
            update_source_amount();
        });
    }
    delete_amount();
</script>