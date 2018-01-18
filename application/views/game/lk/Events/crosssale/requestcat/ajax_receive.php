<select name="receiveGame" class="validate[required,custom[onlyNumberSp]]">
    <option value="">Chọn game receive</option>
    <?php
        if(count($slbGameReceive)>0){
            foreach($slbGameReceive as $vs){
    ?>
    <option value="<?php echo $vs['gameID'];?>"><?php echo $vs['name'];?></option>
    <?php
            }
        }
    ?>
</select>