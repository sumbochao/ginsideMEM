<?php
    if(count($listWall)>0){
        $i=0;
        foreach($listWall as $v){
            $i++;
            $linkGetExistWall = $url_service.'/cms/banpick/get_existwall?id_wall='.$v['id'];
            $j_getExistWall = file_get_contents($linkGetExistWall);
            $getExistWall = json_decode($j_getExistWall,true);
            $strPicture = $v['picture'];
            if($getExistWall['id_wall']==$v['id']){
                $strPicture = str_replace('icon_mau','den_trang', $v['picture']);
            }
?>
<li class="rowwall_<?php echo $v['id'];?> <?php echo ($i%5==0)?'last':'';?>" id="<?php echo $v['id'];?>">
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
            <img src="<?php echo $strPicture;?>" alt="<?php echo $v['name'];?>"> 
        </div>
    </div>
    <div class="function">
        <?php
            if($getExistWall['id_wall']==$v['id']){
        ?>
        <a class="button default <?php echo $getExistWall['id_wall']==$v['id'] && $getExistWall['id_team']==NULL?'active':'';?>">Cấm</a>
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
        <a class="button" onclick="debarLeague(<?php echo $v['id'];?>)">Cấm</a>
        <?php
            foreach($listTeam as $team){
        ?>
        <a class="button" onclick="addLeague(<?php echo $v['id'];?>,<?php echo $team['id'];?>)"><?php echo $team['name'];?></a> 
        <?php
            }
        ?>
        <?php } ?>
        <a class="button" onclick="resetLeague(<?php echo $v['id'];?>)">Reset</a> 
    </div>
    <div class="name"><?php echo $v['name'];?></div> 
</li> 
<?php
        }
    }
?>