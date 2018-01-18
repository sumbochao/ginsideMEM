<label for="menu_group_id">Chọn Msv_</label>
<select name="cbo_p5_msv" id="cbo_p5_msv" style="width:150px;" onchange="getChannel();">
    <option value="0">Chọn Msv...</option>
    <?php
        if(count($slbMsv)>0){
            foreach($slbMsv as $v){
    ?>
    <option value="<?php echo $v['id']."|".$v['msv_id'];?>"><?php echo $v['msv_id'];?></option>
    <?php
            }
        }
    ?>
</select>
 <a href="<?php echo base_url()."?control=mestoreversion&func=add&service_id=".$_GET['service_id']; ?>" title="Thêm Msv" target="_blank"> Tạo mới Msv</a>