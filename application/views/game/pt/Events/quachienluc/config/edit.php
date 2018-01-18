
<script type="text/javascript">
    $(document).ready(function() {
        $('#onSubmitUpdate').on('click',function(){
            if( $('.popupFrmSendChest').validationEngine('validate') === false) 
                return false;
            $.ajax({
                type: "POST",
                dataType: 'jsonp',
                url: "<?php echo $url; ?>/cms/quachienluc/edit_config",
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
                    window.location.href='<?php echo $url; ?>/cms/ep/quachienluc/edit?view=wheel&ids=<?php echo $wheel;?>';
                    //enable button
                    $('#searchuid').removeAttr('disabled');

                });
        });
    });
</script>
<div class="well form-horizontal">
    <div class="control-group frmedit totalchest">
        <div class="group1">
            <div class="form-group">
                <label class="control-label">Items:</label>
                <select name="item_id" class="span7">
                    <option value="0">Chọn Items</option>
                    <?php
                        if(count($slbItem)>0){
                            foreach($slbItem as $v){
                    ?>
                    <option value="<?php echo $v['id'];?>" <?php echo ($v['id']==$item_id)?'selected="selected"':'';?>><?php echo $v['itemname'];?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Level:</label>
                <input name="wheel" type="hidden" value="<?php echo $wheel;?>"/>
                <input name="ids" type="hidden" value="<?php echo $ids;?>"/>
                <input id="day" name="day" type="text" value="<?php echo $day;?>" class="span3 validate[required]">
            </div>
            <div class="form-group" style="width:30%">
                <label class="control-label">Status:</label>
                <span class="loadStatus">
                    Enable:<input type="radio" name="status" class="substatus" id="cat_enable" value="1" <?php echo ($status==1)?'checked="checked"':'';?> style="display:inline; width: 10%;"/>
                    &nbsp;&nbsp;
                    Disable:<input type="radio" name="status" class="substatus" id="cat_disable" value="0" <?php echo ($status==0)?'checked="checked"':'';?> style="display:inline; width: 10%;"/>
                </span>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="control-group">
        <div style="padding-left: 20%; text-align:left;">
            <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
            <span class="loadButton">
                <button id="onSubmitUpdate" class="base_button base_green base-small-border-radius"><span>Cập nhật</span></button>
            </span>
            <div style="display: inline-block">
                <span id="messagePopup" style="color: green"></span>
            </div>
        </div>
    </div>
</div>