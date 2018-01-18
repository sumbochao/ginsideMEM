<style>
    .modal{
        top:5%;left: 10%;right: 10%;
        background: #FFF;
        overflow: visible;
        border-radius: 5px;
        height: 517px;
    }
    .modal-header{
        padding: 0px 0px 0px 10px;
    }
    .modal-footer{
        padding:10px 20px 20px 19px;
    }
    .modal-header .close{
        margin-right: 10px;
    }
    @media (max-width:999px){
        .modal-footer{
            margin-top: 0px;
        }
    }
</style>
<script>
    function loadIframecontentServer() {
        var game_id = $(".slbgame").val();
        var lid = "";
        jQuery("#divservercontent").find(".contentServer").each(function(){
            lid += ","+jQuery(this).find(".icon-remove").attr("itemid");
        });
        if(lid != ""){
            lid = lid.substring(1);
        }
        jQuery("#ifmserver").html('<iframe style="width:100%;height:350px;border:0px;" id="ifmservercontent" src="<?php echo APPLICATION_URL;?>?control=search_info&func=loadserver&iframe=1&game_id='+game_id+'&lid='+lid+'"></iframe>');
    } 
    function update_source_server(){
        var data = [];
        jQuery("#divservercontent").find(".contentServer").each(function(){
            var json = {
                'id':jQuery(this).find(".icon-remove").attr("itemid"),
                'server_id':jQuery(this).find(".icon-remove").attr("itemserverid"),
                'server_name':jQuery(this).find(".icon-remove").parent().find('.icon-view').html()
            };
            data.push(json);
        });
        jQuery("#content_server").val(JSON.stringify(data));
    }
</script>
<div class="wrapper_list">
    <div class="listserver" id="divservercontent">
        <div class="rows contentServertemp" style="display: none;">
            <span itemid="" itemserverid="" class="icon-remove"></span>
            <span class="contentservertext"><a data-toggle="modal" href="#addviewserver" itemid="" class="icon-view">Server</a></span>
        </div>
        <?php
            $content_server = json_decode($arrFilter['content_server'],true);
            if(count($content_server)>0){
                foreach($content_server as $v){
        ?>
        <div class="rows contentServer" id="listItem_<?php echo $v['id'];?>">
            <span itemid="<?php echo $v['id'];?>" itemserverid="<?php echo $v['server_id'];?>" class="icon-remove"></span>
            <span class="contentservertext"><a data-toggle="modal" href="#addviewserver" itemid="<?php echo $v['id'];?>" class="icon-view"><?php echo $v['server_name'];?></a></span>
        </div>
        <?php
                }
            }
        ?>
    </div>
    <div class="clr"></div>
</div>
<input type="hidden" name="content_server" id="content_server" value='<?php echo $arrFilter['content_server'];?>'/>
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
            a_checked[j] = jQuery(this).find(".icon-remove").attr("itemid");
        });
        $("#ifmservercontent").contents().find(".add_checkbox").each(function(){
            // add new
            if(jQuery(this).is(":checked") && $.inArray(jQuery(this).val(),a_checked) < 0){
                var html = jQuery("#divservercontent").find(".contentServertemp").html();
                var newevent = jQuery("<div class='rows contentServer'></div>").html(html);
                jQuery(newevent).find(".contentservertext > a").html(jQuery(this).attr("servername"));
                jQuery(newevent).find(".icon-remove").attr("itemid",jQuery(this).val());
                jQuery(newevent).find(".icon-remove").attr("itemserverid",jQuery(this).attr("serverid"));
                jQuery(newevent).find(".icon-view").attr("itemid",jQuery(this).val());
                jQuery("#divservercontent").append(newevent);
            }
        });
        //remove
        jQuery("#divservercontent").find(".contentServer").each(function(j){
            var checked = jQuery(this).find(".icon-remove").attr("itemid");
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