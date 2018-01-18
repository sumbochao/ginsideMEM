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
        }elseif(count($getExistWall)>0 && !isset($getExistWall['id_team'])){
            echo '<div class="closewall"></div>';
        }
    ?>
    <div class="thumb">
        <img src="<?php echo $strPicture;?>" alt="<?php echo $Item['name'];?>"> 
    </div>
</div>
<div class="function"> 
    <?php
        if($getExistWall['id_wall']==$id_wall){
    ?>
        <a class="button default">Cấm</a>
        <?php
            foreach($listTeam as $team){
                $active = '';
                if($team['id']==$getExistWall['id_team']){
                    $active = 'active';
                }
        ?>
        <a class="button default <?php echo $active;?>"><?php echo $team['name'];?></a> 
        <?php
            }
        ?>
    <?php
        }else{
    ?>
        <a class="button" onclick="debarLeague(<?php echo $id_wall;?>)">Cấm</a>
        <?php
            foreach($listTeam as $team){
        ?>
        <a class="button" onclick="addLeague(<?php echo $id_wall;?>,<?php echo $team['id'];?>)"><?php echo $team['name'];?></a> 
        <?php
            }
        ?>
    <?php
        }
    ?>
    <a class="button" onclick="resetLeague(<?php echo $id_wall;?>)">Reset</a> 
</div> 
<div class="name"><?php echo $Item['name'];?></div> 