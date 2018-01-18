<style>
    #addserver.modal{
        top:5%;left: 25%;right:25%;
        background: #FFF;
        overflow: visible;
        border-radius: 5px;
        height: 517px;
    }
    #addserver .modal-header{
        padding: 0px 0px 0px 10px;
    }
    #addserver .modal-footer{
        padding:10px 20px 20px 19px;
    }
    #addserver .modal-header .close{
        margin-right: 10px;
    }
    @media (max-width:999px){
        .modal-footer{
            margin-top: 0px;
        }
    }
    .listserver {
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
    .listserver .rows{
        display: inline-block;
        margin-bottom: 7px;
        margin-right: 10px;
        background: #5bc0de;
        border-radius: 0.25em;
        color: #FFF;
        padding:0.2em 0.6em 0.1em;
    }
    .listserver .icon-view{
        white-space: nowrap;
        display: inline-block;
        text-decoration: none;
    }
    .modal-footer{
        margin-top: 32px;
    }
    .contentServer .contentservertext a{
        width: auto;
        color: #FFF;
        margin-top: 0px;
        font-weight: bold;
        font-size: 12px;
    }
    .contentServer .icon-remove{
        margin-top: -1px;
    }
</style>
<script>
    function loadIframecontentServer() {
        var lid = "";
        jQuery("#divservercontent").find(".contentServer").each(function(){
            lid += ","+jQuery(this).find(".icon-remove").attr("itemserverid");
        });
        if(lid != ""){
            lid = lid.substring(1);
        }
        jQuery("#ifmserver").html('<iframe style="width:100%;height:350px;border:0px;" id="ifmservercontent" src="<?php echo APPLICATION_URL;?>?control=quayso_lg&func=listserver&iframe=1&game_id=10000&lid='+lid+'"></iframe>');
    } 
    function update_source_server(){
        var data = [];
        jQuery("#divservercontent").find(".contentServer").each(function(){
            var json = {
                'server_id':jQuery(this).find(".icon-remove").attr("itemserverid")
            };
            data.push(json);
        });
        jQuery("#content_server").val(JSON.stringify(data));
    }
</script>
<div class="control-group">
    <label class="control-label">Server:</label>
    <div class="controls">
        <a href="#addserver" onclick="loadIframecontentServer();" class="btn btn-primary"  data-toggle="modal">Thêm server</a>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Server đã chọn</label>
    <div class="listserver controls" id="divservercontent">
        <div class="rows contentServertemp" style="display: none;">
            <span class="contentservertext"><a data-toggle="modal" href="#addviewserver" itemid="" class="icon-view">Server</a></span>
            <span itemserverid="" class="icon-remove"></span>
        </div>
        <?php
            $j_arrValue = '';
            if(!empty($items['server_id'])){
                $content_server = explode(',', $items['server_id']);
                if(count($content_server)>0){
                    $i=0;
                    foreach($content_server as $v){
        ?>
        <div class="rows contentServer">
            <span class="contentservertext"><a data-toggle="modal" href="#addviewserver" class="icon-view"><?php echo $v;?></a></span>
            <span itemserverid="<?php echo $v;?>" class="icon-remove"></span>
        </div>
        <?php
                        $arrValue[$i]['server_id'] = $v;
                        $i++;
                    }
                    $j_arrValue = json_encode($arrValue);
                }
            }
        ?>
    </div>
    <div class="clr"></div>
</div>
<input type="hidden" name="content_server" id="content_server" value='<?php echo $j_arrValue;?>'/>
<div id="addserver" class="modal">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button" id="ifr">×</button>
        <h3>Thêm server</h3>
    </div>
    <div class="modal-body" id="ifmserver"></div>
    <div class="modal-footer">
        <a class="btn btn-default btn-primary cmdAddItemServer" href="javascript:;">Thêm</a>
        <a data-dismiss="modal" class="btn btn-default btn_cancel" href="#">Bỏ qua</a>
    </div>
</div>
<script>
    
    jQuery(".cmdAddItemServer").click(function(){
        //get value in checkbox (all)
        var a_chekcbox = [];
        $("#ifmservercontent").contents().find(".add_checkbox").each(function(i){
            a_chekcbox[i] = jQuery(this).val();
        })
        var a_checked = [];
        //get value checked in Content
        jQuery("#divservercontent").find(".contentServer").each(function(j){
            a_checked[j] = jQuery(this).find(".icon-remove").attr("itemserverid");
        });
        $("#ifmservercontent").contents().find(".add_checkbox").each(function(){
            // add new
            if(jQuery(this).is(":checked") && $.inArray(jQuery(this).val(),a_checked) < 0){
                var html = jQuery("#divservercontent").find(".contentServertemp").html();
                var newevent = jQuery("<div class='rows contentServer'></div>").html(html);
                jQuery(newevent).find(".contentservertext > a").html(jQuery(this).attr("serverid"));
                jQuery(newevent).find(".icon-remove").attr("itemserverid",jQuery(this).val());
                jQuery(newevent).find(".icon-view").attr("itemserverid",jQuery(this).val());
                jQuery("#divservercontent").append(newevent);
            }
        });
        //remove
        jQuery("#divservercontent").find(".contentServer").each(function(j){
            var checked = jQuery(this).find(".icon-remove").attr("itemserverid");
            if($.inArray(checked,a_chekcbox) >= 0 
                && !$("#ifmservercontent").contents().find(".add_checkbox[value="+checked+"]").is(":checked")){
                jQuery(this).remove();          
            }
        });
        jQuery(".btn_cancel").click();
        delete_server();
        update_source_server();
    });
    
    function delete_server(){
        jQuery(".contentServer .icon-remove").click(function () {
            jQuery(this).parent().remove();
            update_source_server();
        });
    }
    delete_server();
</script>