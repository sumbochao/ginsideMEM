<style>
    .well{
        min-height: 500px;
    }
    .team_img{
        margin-top: 5px;
        margin-bottom: 10px;
    }
</style>
<div class="team">
    <div class="title">Team 1</div>
    <?php
        if(count($team_user)>0){
            foreach($team_user as $v){
                if($v['team']==1){
    ?>
    <div class="team_img"><img src="http://cms.mobo.vn/assets/upload/lol.mobo.vn/res/Ban-pick/icon_mau/<?php echo $v['key'];?>.png"/></div>
    <?php
                }
            }
        }
    ?>
</div>
<div class="team">
    <div class="title">Team 2</div>
    <?php
        if(count($team_user)>0){
            foreach($team_user as $v){
                if($v['team']==2){
    ?>
    <div class="team_img"><img src="http://cms.mobo.vn/assets/upload/lol.mobo.vn/res/Ban-pick/icon_mau/<?php echo $v['key'];?>.png"/></div>
    <?php
                }
            }
        }
    ?>
</div>
<div class="team">
    <div class="title">Team 3</div>
    <?php
        if(count($team_user)>0){
            foreach($team_user as $v){
                if($v['team']==3){
    ?>
    <div class="team_img"><img src="http://cms.mobo.vn/assets/upload/lol.mobo.vn/res/Ban-pick/icon_mau/<?php echo $v['key'];?>.png"/></div>
    <?php
                }
            }
        }
    ?>
</div>