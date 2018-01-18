<?php 
    if ($userPermission=='co'){
?>
<a href="javascript:;" onclick="loadPermission(this,'<?php echo base_url().'?control=account&func=ajax_permisssion&option=inactive';?>',<?php echo $id_user;?>,<?php echo $id_permisssion;?>,'<?php echo $id_game;?>');">
    <img border="0" alt="Enable" src="<?php echo base_url().'assets/img/tick.png'?>">
</a>
<?php
    }else{
?>
<a href="javascript:;" onclick="loadPermission(this,'<?php echo base_url().'?control=account&func=ajax_permisssion&option=active';?>',<?php echo $id_user;?>,<?php echo $id_permisssion;?>,'<?php echo $id_game;?>');">
    <img border="0" alt="Enable" src="<?php echo base_url().'assets/img/tick2.png'?>">
</a>
<?php } ?>