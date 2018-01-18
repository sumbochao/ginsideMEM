<div class="images">
    <div class="thumb">
        <img src="<?php echo $Item['picture'];?>" alt="<?php echo $Item['name'];?>"> 
    </div>
</div>
<div class="function"> 
    <a class="button" onclick="debarLeague(<?php echo $id_wall;?>)">Cấm</a>
    <?php
        foreach($listTeam as $team){
    ?>
    <a class="button" onclick="addLeague(<?php echo $id_wall;?>,<?php echo $team['id'];?>)"><?php echo $team['name'];?></a> 
    <?php
        }
    ?>
    <a class="button" onclick="resetLeague(<?php echo $id_wall;?>)">Reset</a> 
</div> 
<div class="name"><?php echo $Item['name'];?></div> 