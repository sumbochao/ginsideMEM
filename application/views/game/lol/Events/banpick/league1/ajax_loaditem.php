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
    <div class="name"><?php echo $v['name'];?></div> 
</li> 
<?php
        }
    }
?>