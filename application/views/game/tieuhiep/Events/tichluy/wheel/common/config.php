<style>
    #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
    #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
</style>


<script type="text/javascript">
    $(document).ready(function() {
        $('#onSubmitPopup').on('click',function(){
            if( $('.popupFrmSendChest').validationEngine('validate') === false) 
                return false;
            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo $url; ?>/cms/accumulation_weekly/add_config",
                data: $(".popupFrmSendChest").serializeArray(),
                beforeSend: function(  ) {
                    
                     // load your loading fiel here
                     $('#messagePopup').attr("style","color:green");
                     $('#messagePopup').html('Đang xử lý ...');
                     //disable button
                     $('#searchuid').attr("disabled","disabled");
                }
              }).done(function(result) {
                    console.log(result);
                    //hide your loading file here
                    if (result.status == false)
                        $('#messagePopup').attr("style","color:red");

                    $('#messagePopup').html(result.message);
                    window.location.href='?control=accumulation_weekly&func=edit&view=wheel&&ids=<?php echo $_GET['ids'];?>';
                    //enable button
                    $('#searchuid').removeAttr('disabled');

                });
        });
        $('#onSubmitUpdate').on('click',function(){alert('345');
            if( $('.popupFrmSendChest').validationEngine('validate') === false) 
                return false;
            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo $url; ?>/cms/accumulation_weekly/edit_config",
                data: $(".popupFrmSendChest").serializeArray(),
                beforeSend: function(  ) {
                    
                     // load your loading fiel here
                     $('#messagePopup').attr("style","color:green");
                     $('#messagePopup').html('Đang xử lý ...');
                     //disable button
                     $('#searchuid').attr("disabled","disabled");
                }
              }).done(function(result) {
                    console.log(result);
                    //hide your loading file here
                    if (result.status == false)
                        $('#messagePopup').attr("style","color:red");

                    $('#messagePopup').html(result.message);
                    window.location.href='?control=accumulation_weekly&func=edit&view=wheel&ids=<?php echo $_GET['ids'];?>';
                    //enable button
                    $('#searchuid').removeAttr('disabled');

                });
        });
    });
    
     getData();
    function getData(){
        $.ajax({
                url: "<?php echo $url;?>/cms/accumulation_weekly/index_config?iditems=<?php echo $_GET['ids']; ?>",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true, 
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {                        
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                    "aaData": data.rows                
                        ,
                    aoColumns: [   
                             {
                                sTitle: "Id",
                                mData: "id"
                            },                            
                           {
                                sTitle: "Item ID",
                                mData: "itemname",
                            },
                            {
                                sTitle: "Wheel",
                                mData: "wheel",
                            },
                            {
                                sTitle: "Day",
                                mData: "day",
                            },
                             {
                                sTitle: "Status", 
                                mData: "status",
                                mRender: function(data){
                                    return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                }

                             },
                             { 
                                sTitle: "Action", 
                                mData: "id",
                                mRender: function(data){
                                    return "<a href='javascript:;' onclick='editConfig("+data+")'>Edit</a> <span style='padding-left:10px'><a href='?control=accumulation_weekly&func=deleteconfig&view=wheel&ids="+data+"&wheel=<?php echo $_GET['ids'];?>'>Delete</a></span>";
                                }

                             }

                        ],
                        bProcessing: true,

                        bPaginate: true,

                        bJQueryUI: false,

                        bAutoWidth: false,

                        bSort: false,
                        bRetrieve: true, 
                        bDestroy: true,

                        sPaginationType: "full_numbers"       
                    });
                    
                }
            });
            
    }

</script>
<div class="widget" id="viewport">
    <div class="table-overflow">
        <div style="border-top:1px solid #d5d5d5;padding: 4px 8px" id="popupFrmSendChest">
            
            <form id="frmSendChest" class="popupFrmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                <div class="widget row-fluid load_edit" style="margin-top:8px;">
                    <div class="well form-horizontal">
                        <div class="control-group frmedit totalchest">
                            <div class="group1">
                                <div class="form-group">
                                    <label class="control-label">Items:</label>
                                    <span class="load_item">
                                        <select name="item_id" class="span7">
                                            <option value="0">Chọn Items</option>
                                            <?php
                                                if(count($slbItem)>0){
                                                    foreach($slbItem as $v){
                                            ?>
                                            <option value="<?php echo $v['id'];?>"><?php echo $v['itemname'];?></option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Day:</label>
                                    <input name="wheel" type="hidden" value="<?php echo $_GET['ids'];?>"/>
                                    <input id="day" name="day" type="text" value="" class="span3 validate[required]">
                                </div>
                                <div class="form-group" style="width:30%">
                                    <label class="control-label">Status:</label>
                                    <span class="loadStatus">
                                        Enable:<input type="radio" name="status" class="substatus" id="cat_enable" value="1" checked="checked" style="display:inline; width: 10%;"/>
                                        &nbsp;&nbsp;
                                        Disable:<input type="radio" name="status" class="substatus" id="cat_disable" value="0" style="display:inline; width: 10%;"/>
                                    </span>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align:left;">
                                <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                <span class="loadButton">
                                    <button id="onSubmitPopup" class="add_field_button base_button base_green base-small-border-radius btn btn-primary btn-sm base_button base_green base-small-border-radius"><span>Thêm mới</span></button>
                                </span>
                                <div style="display: inline-block">
                                    <span id="messagePopup" style="color: green"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>                   
        <table class="table table-striped table-bordered" id="data_table">      
        </table>
    </div>    
</div>
<div class="loadPopup"></div>
<script>
    function editConfig(ids){
        $.ajax({
            url: "<?php echo $urlConfig;?>/cms/ep/accumulation_weekly/edit_config",
            type:"GET",
            data:{ids:ids},
            dataType:"json",
            success:function(f){
                if(typeof f.error!="undefined"&&f.error==0){
                    $(".load_edit").html(f.htmlEdit);
                }
            }
        });
    }
</script>