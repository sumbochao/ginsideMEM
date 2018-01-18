<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .listwall{
            text-align: center;
        }
        .listwall .rows{
            display: inline-block;
            margin-right: 20px;
            margin-top: 25px;
            position: relative;
        }
        .listwall .rows .hover,.listwall .rows .outhover{
            cursor: pointer;
        }
        .listwall .rows .active_green{
            position: absolute;
            background: url("../assets/img/char_hoder_xanh.png");
            width: 69px;
            height: 41px;
            left: 0px;
            bottom: -25px;
        }
        .listwall .rows .active_red{
            position: absolute;
            background: url("../assets/img/char_hoder_do.png");
            width: 69px;
            height: 41px;
            left: 0px;
            bottom: -25px;
        }
        .listwall .rows .closewall{
            position: absolute;
            background: url("../assets/img/close.jpg");
            width: 55px;
            height: 40px;
            left: 10%;
            top: 26%;
        }
        .clr{
            clear: both;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#create').on('click', function () {
                window.location.href = '/?control=banpick_lol&func=index&view=<?php echo $_GET['view'];?>&module=<?php echo $_GET['module'];?>#<?php echo $_GET['view'];?>';
            });
        });
    </script>
    <div class="loading_warning"></div>
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
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                         <div style="margin-top: 10px; margin-bottom: 10px;">
                            <button id="create"  class="btn btn-primary"><span>QUAY LẠI</span></button>
                        </div>
                        <input type="hidden" class="teamid" value="<?php echo $_GET['id'];?>"/>
                        <div class="listwall">
                            <?php
                                if(is_array($listWall)){
                                    foreach($listWall as $v){
                                        $strPicture = $v['picture'];
                                        $hover = 'class="hover" onclick="hover('.$v['id'].','.$_GET['id'].','."'".md5($v['id'].$_GET['id'].'banpick')."'".')"';
                                        if($v['status']==0){
                                            $strPicture = str_replace('icon_mau','den_trang', $v['picture']);
                                            $hover = '';
                                        }
                            ?>
                            <div class="rows rowwall_<?php echo $v['id'];?>" id="<?php echo $v['id'];?>">
                                <?php
                                    $linkGetExistWall = $url_service.'/cms/banpick/get_existwall?id_wall='.$v['id'];
                                    $j_getExistWall = file_get_contents($linkGetExistWall);
                                    $getExistWall = json_decode($j_getExistWall,true);
                                    if($getExistWall['id_wall']==$v['id']){
                                        $strPicture = str_replace('icon_mau','den_trang', $v['picture']);
                                        switch ($getExistWall['color']){
                                            case 'green':
                                               $activeColor = '<div class="active_green"></div>';
                                                break;
                                            case 'red':
                                               $activeColor = '<div class="active_red"></div>';
                                                break;
                                        }
                                ?>
                                <div <?php echo $getExistWall['id_team']==$_GET['id'] && $v['status']==1?'class="outhover" onclick="outhover('.$v['id'].','.$_GET['id'].','."'".md5($v['id'].$_GET['id'].'banpick')."'".')"':'';?>>
                                    <?php echo ($v['status']==0)?'<div class="closewall"></div>':'';?>
                                    <?php echo $activeColor; ?>
                                    <img height="71px" src="<?php echo $strPicture;?>" alt="<?php echo $v['name'];?>"/>
                                </div>
                                <?php
                                    }else{
                                ?>
                                <div <?php echo $hover;?>>
                                    <?php echo ($v['status']==0)?'<div class="closewall"></div>':'';?>
                                    <img height="71px" src="<?php echo $strPicture;?>" alt="<?php echo $v['name'];?>"/>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                            <div class="clr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    function hover(wallid,teamid,token){
        ajaxLoad('ajax_addwall',wallid,teamid,token);
    }
    function outhover(wallid,teamid,token){
        ajaxLoad('ajax_removewall',wallid,teamid,token);
    }
    function ajaxLoad(action,wallid,teamid,token){
        $.ajax({
            url:baseUrl+'/?control=banpick_lol&func='+action+'&module=all',
            type:"POST",
            data:{wallid:wallid,teamid:teamid,token:token},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                $('.loading_warning').hide();
                if(typeof f.error!="undefined"&&f.error==0){
                    $(".rowwall_"+wallid).html(f.html);
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                }
            }
        });
    }
</script>