<select name="gamereceiveID">
    <option value="0">Chọn game receive</option>
    <?php
        if(count($slbReceiveGame)>0){
            foreach($slbReceiveGame as $vs){
    ?>
    <option value="<?php echo $vs['gameID'];?>"><?php echo $vs['name'];?></option>
    <?php
            }
        }
    ?>
</select>