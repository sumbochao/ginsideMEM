    <option value="0">Chọn Msv...</option>
    <?php
        if(count($slbMsv)>0){
            foreach($slbMsv as $v){
    ?>
    <option value="<?php echo $v['msv_id'];?>" <?php echo $itemview['msv']==$v['msv_id']?"selected":"";?>><?php echo $v['msv_id'];?></option>
    <?php
            }
        }
    ?>
