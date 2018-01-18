<style>
    .listserver .rows{
        float: left;
        width: 245px;
        margin-right:10px;
        margin-bottom: 10px;
    }
    
</style>
<div class="listserver">
    <?php
        if(count($listServer)>0){
            foreach ($listServer as $v){
    ?>
    <div class="rows">
        <input type="checkbox" serverid="<?php echo $v['server_id'];?>" servername="<?php echo $v['server_name'];?>" <?php  echo in_array($v['id'], $s_id)?"checked":"" ?> name="cid[]" id="cid" class="add_checkbox" value="<?php echo $v['id'];?>"/>
        <?php echo $v['server_name'];?>
    </div>
    <?php
            }
        }
    ?>
</div>