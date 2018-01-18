<select name="cert_id" id="cert_id" class="chosen-select" tabindex="2" data-placeholder="Chọn bảng app" onchange="showValue(this.value)">
    <option value="0">Chọn bảng app</option>
    <?php
        if(count($slbTable)>0){
            foreach($slbTable as $v){
    ?>
    <option value="<?php echo $v['id'];?>" <?php echo $items['cert_id']==$v['id']?'selected="selected"':'';?>><?php echo $v['cert_type'];?></option>
    <?php
            }
        }
    ?>
</select>