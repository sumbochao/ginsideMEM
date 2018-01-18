<?php
    $linkGetExistWall = $url_service.'/cms/banpick/get_existwall?id_wall='.$id_wall;
    $j_getExistWall = file_get_contents($linkGetExistWall);
    $getExistWall = json_decode($j_getExistWall,true);
    $strPicture = $Item['picture'];
    if($getExistWall['id_wall']==$id_wall){
        $strPicture = str_replace('icon_mau','den_trang', $Item['picture']);
    }
?>
<div class="images">
    <?php
        if($getExistWall['id_team']=='1'){
            echo '<div class="active_red"></div>';
        }elseif($getExistWall['id_team']=='2'){
            echo '<div class="active_green"></div>';
        }elseif($getExistWall['id_team']=='0'){
            echo '<div class="closewall"></div>';
        }
    ?>
    <div class="thumb">
        <img src="<?php echo $strPicture;?>" alt="<?php echo $Item['name'];?>"> 
    </div>
</div>
<div class="function"> 
    <a class="button default <?php echo $getExistWall['id_wall']==$id_wall?'active':'';?>">Cấm</a>
    <?php
        foreach($listTeam as $team){
    ?>
    <a class="button default"><?php echo $team['name'];?></a> 
    <?php
        }
    ?>
    <a class="button" onclick="resetLeague(<?php echo $id_wall;?>)">Reset</a> 
</div> 
<div class="name"><?php echo $Item['name'];?></div> 