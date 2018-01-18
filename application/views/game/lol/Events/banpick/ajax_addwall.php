<?php
    $strPicture = $Item['picture'];
    $outhover = '';
    if($Item['status']==1){
        $strPicture = str_replace('icon_mau','den_trang', $Item['picture']);
        $outhover = 'class="outhover" onclick="outhover('.$wallid.','.$teamid.','."'".md5($wallid.$teamid.'banpick')."'".')"';
    }
    switch ($Item['color']){
        case 'green':
           $activeColor = '<div class="active_green"></div>';
            break;
        case 'red':
           $activeColor = '<div class="active_red"></div>';
            break;
    }
?>
<div <?php echo $outhover;?>>
    <?php echo ($Item['status']==0)?'<div class="closewall"></div>':'';?>
    <?php echo $activeColor;?>
    <img height="71px" src="<?php echo $strPicture;?>" alt="<?php echo $Item['name'];?>">
</div>