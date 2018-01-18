<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<style> 
    #char_list ul{ margin: 0; padding: 0; list-style-type: none; font-family: arial; font-size: 13px; padding-top: 9px;} 
    #char_list li{ float:left; margin-right: 35px; margin-bottom: 20px; position: relative;}
    #char_list .images{
        float: left; 
    }
    #char_list .images .thumb{
        width: 113px; 
        height: 113px;
        vertical-align: middle;
        display: table-cell;
        max-width: 113px;
        text-align: center;
    } 
    #char_list .function{ float: right; margin-left: 5px; margin-top: 5px; } 
    #char_list .function a{ 
        background-color: red; 
        padding: 4px; 
        color: white; 
        display: block; 
        margin-bottom: 5px; 
        text-align: center; 
        cursor:pointer;
        text-decoration: none;
    }
    #char_list .function a.default{
        cursor: default;
    }
    #char_list .function a:hover{
        background-color: green !important;
    }
    #char_list .last{ margin-right: 0px !important; } 
    #char_list .active{ background-color: green !important; } 
    .nextleague{ 
        text-align: center; 
        background-color: red; 
        color: white; 
        padding: 5px; 
        margin-bottom: 10px; 
        display: block; 
        width: 100px; 
        margin-top: 10px;
        border: 0px;
    } 
    #char_list li .name{
        color: red; 
        font-weight: bold; 
        font-size: 15px;
        text-align: center;
    }
    #char_list li .images .active_green{
        position: absolute;
        background: url("../assets/img/char_hoder_xanh.png");
        width: 69px;
        height: 41px;
        left: 11%;
        top: 30%;
    }
    #char_list li .images .active_red{
        position: absolute;
        background: url("../assets/img/char_hoder_do.png");
        width: 69px;
        height: 41px;
        left: 11%;
        top: 30%;
    }
    #char_list li .images .closewall{
        position: absolute;
        background: url("../assets/img/close.jpg");
        width: 55px;
        height: 40px;
        left: 17%;
        top: 30%;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/lol/Events/banpick/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div id="container"> 
                    <button class="nextleague" onclick="deleteAll()">Qua lượt</button> 
                    <div id="char_list"> 
                        <ul> 
                            <?php
                                if(count($listWall)>0){
                                    $i=0;
                                    foreach($listWall as $v){
                                        $i++;
                                        $strPicture = $v['picture'];
                                        if($v['id_wall']==$v['id']){
                                            $strPicture = str_replace('icon_mau','den_trang', $v['picture']);
                                        }
                            ?>
                            <li class="rowwall_<?php echo $v['id'];?> <?php echo ($i%5==0)?'last':'';?>" id="<?php echo $v['id'];?>">
                                <div class="images">
                                    <?php
                                        $team ='';
                                        if($v['id_team']=='1' && $v['status']==1){
                                            $team =  '<div class="active_red"></div>';
                                        }elseif($v['id_team']=='2' && $v['status']==1){
                                            $team = '<div class="active_green"></div>';
                                        }elseif($v['id_team']=='0' && $v['status']=='0'){
                                            $team = '<div class="closewall"></div>';
                                        }
                                        echo $team;
                                    ?>
                                    <div class="thumb">
                                        <img src="<?php echo $strPicture;?>" alt="<?php echo $v['name'];?>"> 
                                    </div>
                                </div>
                                <div class="function">
                                    <?php
                                        if($v['id_wall']==$v['id']){
                                    ?>
                                    <a class="button default <?php echo $v['id_wall']==$v['id'] && $v['id_team']==0?'active':'';?>">Cấm</a>
                                    <?php
                                        foreach($listTeam as $team){
                                            $active = '';
                                            if($team['id']==$v['id_team']){
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
                        </ul> 
                    </div> 
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    function deleteAll(){
        ajaxLoad('delete_league');
    }
    function debarLeague(id_wall){
        ajaxLoad('debar_league',id_wall,0,0);
    }
    function addLeague(id_wall,id_team){
        ajaxLoad('add_league',id_wall,id_team,1);
    }
    function resetLeague(id_wall){
        ajaxLoad('reset_league',id_wall);
    }
    function ajaxLoad(action,id_wall,id_team,status){
        $.ajax({
            url:baseUrl+'/?control=banpick_lol&func='+action+'&module=all',
            type:"POST",
            data:{id_team:id_team,id_wall:id_wall,status:status},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                $('.loading_warning').hide();
                if(typeof f.error!="undefined"&&f.error==0){
                    if(action=='delete_league'){
                        $("#char_list ul").html(f.html);
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    }else{
                        $(".rowwall_"+id_wall).html(f.html);
                    }
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                }
            }
        });
    }
</script>