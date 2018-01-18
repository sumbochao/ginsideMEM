<style>
    #addtype.modal{
        top:5%;left: 25%;right:25%;
        background: #FFF;
        overflow: visible;
        border-radius: 5px;
        height: 517px;
    }
    #addtype .modal-header{
        padding: 0px 0px 0px 10px;
    }
    #addtype .modal-footer{
        padding:10px 20px 20px 19px;
    }
    #addtype .modal-header .close{
        margin-right: 10px;
    }
    @media (max-width:999px){
        .modal-footer{
            margin-top: 0px;
        }
    }
    .listtype {
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
    .listtype .rows{
        display: inline-block;
        margin-bottom: 7px;
        margin-right: 10px;
        background: #5bc0de;
        border-radius: 0.25em;
        color: #FFF;
        padding:0.2em 0.6em 0.1em;
    }
    .listtype .icon-view{
        white-space: nowrap;
        display: inline-block;
        text-decoration: none;
    }
    .modal-footer{
        margin-top: 32px;
    }
    .contentType .contenttypetext a{
        width: auto;
        color: #FFF;
        margin-top: 0px;
        font-weight: bold;
        font-size: 12px;
    }
    .contentType .icon-remove{
        margin-top: -1px;
    }
</style>
<script>
    function loadIframecontentType() {
        var tid = "";
        jQuery("#divtypecontent").find(".contentType").each(function(){
            tid += ","+jQuery(this).find(".icon-remove").attr("itemtypeid");
        });
        if(tid != ""){
            tid = tid.substring(1);
        }
        jQuery("#ifmtype").html('<iframe style="width:100%;height:350px;border:0px;" id="ifmtypecontent" src="<?php echo APPLICATION_URL;?>?control=promotion_gapi&func=loadtype&iframe=1&tid='+tid+'"></iframe>');
    } 
    function update_source_type(){
        var data = [];
        jQuery("#divtypecontent").find(".contentType").each(function(){
            data.push(jQuery(this).find(".icon-remove").attr("itemtypeid"));
        });
        jQuery("#content_type").val(JSON.stringify(data));
    }
</script>
<div class="rows">	
    <label for="menu_group_id">Type</label>
    <a href="#addtype" onclick="loadIframecontentType();" class="btn btn-primary"  data-toggle="modal">Thêm type</a>
</div>
<div class="wrapper_list">
     <label for="menu_group_id">Type đã chọn</label>
    <div class="listtype" id="divtypecontent">
        <div class="rows contentTypetemp" style="display: none;">
            <span class="contenttypetext"><a data-toggle="modal" href="#addviewtype" itemid="" class="icon-view">Type</a></span>
			<span itemtypeid="" class="icon-remove"></span>
        </div>
        <?php
            $j_arrType = '';
            if(!empty($items['type'])){
                $content_type = json_decode($items['type'],true);
                if(count($content_type)>0){
                    $i=0;
                    foreach($content_type as $v){
        ?>
        <div class="rows contentType">
            <span class="contenttypetext"><a data-toggle="modal" href="#addviewtype" class="icon-view"><?php echo ucwords($v);?></a></span>
			<span itemtypeid="<?php echo $v;?>" class="icon-remove"></span>
        </div>
        <?php
                        $arrType[$i] = $v;
                        $i++;
                    }
                    $j_arrType = json_encode($arrType);
                }
            }
        ?>
    </div>
    <div class="clr"></div>
</div>
<input type="hidden" name="content_type" id="content_type" value='<?php echo $j_arrType;?>'/>
<div id="addtype" class="modal">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button" id="ifr">×</button>
        <h3>Thêm type</h3>
    </div>
    <div class="modal-body" id="ifmtype"></div>
    <div class="modal-footer">
        <a class="btn btn-default btn-primary cmdAddItemType" href="javascript:;">Thêm</a>
        <a data-dismiss="modal" class="btn btn-default btn_cancel" href="#">Bỏ qua</a>
    </div>
</div>
<script>
    
    jQuery(".cmdAddItemType").click(function(){
        //get value in checkbox (all)
        var a_chekcbox = [];
        $("#ifmtypecontent").contents().find(".add_checkbox").each(function(i){
            a_chekcbox[i] = jQuery(this).val();
        })
        var a_checked = [];
        //get value checked in Content
        jQuery("#divtypecontent").find(".contentType").each(function(j){
            a_checked[j] = jQuery(this).find(".icon-remove").attr("itemtypeid");
        });
        $("#ifmtypecontent").contents().find(".add_checkbox").each(function(){
            // add new
            if(jQuery(this).is(":checked") && $.inArray(jQuery(this).val(),a_checked) < 0){
                var html = jQuery("#divtypecontent").find(".contentTypetemp").html();
                var newevent = jQuery("<div class='rows contentType'></div>").html(html);
                jQuery(newevent).find(".contenttypetext > a").html(jQuery(this).attr("typeid"));
                jQuery(newevent).find(".icon-remove").attr("itemtypeid",jQuery(this).val());
                jQuery(newevent).find(".icon-view").attr("itemtypeid",jQuery(this).val());
                jQuery("#divtypecontent").append(newevent);
            }
        });
        //remove
        jQuery("#divtypecontent").find(".contentType").each(function(j){
            var checked = jQuery(this).find(".icon-remove").attr("itemtypeid");
            if($.inArray(checked,a_chekcbox) >= 0 
                && !$("#ifmtypecontent").contents().find(".add_checkbox[value="+checked+"]").is(":checked")){
                jQuery(this).remove();          
            }
        });
        jQuery(".btn_cancel").click();
        delete_type();
        update_source_type();
    });
    
    function delete_type(){
        jQuery(".contentType .icon-remove").click(function () {
            jQuery(this).parent().remove();
            update_source_type();
        });
    }
    delete_type();
</script>