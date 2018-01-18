<div class="hover" onclick="hover(<?php echo $wallid; ?>,<?php echo $teamid; ?>,'<?php echo md5($wallid.$teamid.'banpick');?>')">
    <?php echo ($Item['status']==0)?'<div class="closewall"></div>':'';?>
    <img height="71px" src="<?php echo $Item['picture'];?>" alt="<?php echo $Item['name'];?>">
</div>