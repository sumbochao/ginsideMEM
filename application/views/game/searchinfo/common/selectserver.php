<script>
    jQuery('.dropdown input, .dropdown label').click(function (event) {
        event.stopPropagation();
    });
    jQuery(document).ready(function () {
        jQuery('.groupserver').multiselect({
            includeSelectAllOption: true,
            enableCaseInsensitiveFiltering: true
        });
    });
</script>
<select class="groupserver" name="groupserver">
    <option value="">Chọn cụm</option>
    <?php
        if(count($mappingserver)>0){
            foreach($mappingserver as $k=>$v){
    ?>
    <option value="<?php echo $k;?>" <?php echo $arrFilter['groupserver']==$k?'selected="selected"':'';?>><?php echo $v['title'];?></option>
    <?php
            }
        }
    ?>
</select>