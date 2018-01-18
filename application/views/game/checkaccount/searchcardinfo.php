<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-modal.js') ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-transition.js') ?>"></script>

<script type="text/javascript">
    $(function(){
        $(".navmenu").addClass("classArrow");
    });
</script>
<link href="<?php echo base_url('assets/ddsmoothcontent/css/ddsmoothcontent.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/ddsmoothcontent/css/font.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/ddsmoothcontent/js/ddsmoothcontent.js') ?>" type="text/javascript"></script>
<style>
    span input[type='submit']{
        margin-top: -10px;
    }
    .content_search .title_search{
        color: red;
        font-weight: bold;
        font-size: 13px;
    }
    .main_search{
        margin-top: 10px;
    }
    .textinput{
        width: 200px;
    }
    .error{
        color: red;
    }
    .widget_content{
        margin-top: 15px;
    }
    h4.widget-name{
        font-size: 17px;
        text-transform: uppercase;
        margin-top: 0px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    .group_level2 li{
        position: relative;
    }
    .group_level2 li.stt{
        position: absolute;
        right: 5px;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include APPPATH . 'views/game/checkaccount/tab.php'; ?>
    <div class="widget_content">
        <form id="appForm" action="" method="post" name="appForm">
            <div class="filter">
                <input type="text" name="playerid" value="<?php echo $_POST['playerid'];?>" style="width: 145px;" placeholder="Mã người chơi" title="Mã người chơi"/>
                <span>
                    <select name="game_server_id">
                        <option value="0">Chọn server</option>
                        <?php
                            if(empty($slbServer) !== TRUE){
                                foreach($slbServer as $v){
                        ?>
                        <option value="<?php echo $v['server_id'];?>" <?php echo ($v['server_id']==$_POST['game_server_id'])?'selected="selected"':'';?>><?php echo $v['server_name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </span>
                <input type="text" name="zoneid" value="<?php echo $_POST['zoneid'];?>" style="width: 145px;" placeholder="Zone ID" title="Zone ID"/>
                <span><input type="submit" value="Tìm" class="btn btn-primary"/></span>
            </div>
            <div class="content_search">
                <div class="title_search">Kết quả tìm kiếm: </div>
                <div class="main_search">
                    <?php
                        //echo "<pre>";print_r($item);echo "</pre>";
                        if(count($item)>0){
                    ?>
                    <div id="smoothmenu1" class="ddsmoothmenu">
                        <ul class="navmenu active">
                            <?php
                                $namekey = array('playerId'=>'ID nhân vật (playerId)',
                                                    'playerName'=>'Tên nhân vật (playerName)',
                                                    'cardGroup'=>'Tướng đội ngũ (cardGroup)',
                                                    'hufacard'=>'Tướng Hộ PHáp (hufaCard)',
                                                    'cards'=>'Tướng chưa ra trận (cards)',
                                                    'star'=>'Cấp sao tướng (star)',
                                                    'lv'=>'Cấp tướng (lv)',
                                                    'skill'=>'Tuyệt kỹ tướng (skill)',
                                                    'shenTong'=>'Thuộc tính thần thông (shenTong)',
                                                    'equipment'=>'Trang bị (equipment)',
                                                    'battleScore'=>'Chiến Lực (battleScore)',
                                                    'signNum'=>'Số Nguyên Thần (signNum)',
                                                    'cardName'=>'Tên Tướng (cardName)'
                                        );
                                foreach($item as $k1=>$v1){
                                    $name1 = is_array($v1)?' ...':$v1;
                                    
                            ?>
                            <li><a><?php echo $namekey[$k1].' : '.$name1;?></a>
                                <?php
                                    if(is_array($v1)){
                                ?>
                                <ul>
                                <?php
                                    $i2=0;
                                    foreach($v1 as $k2=>$v2){
                                        $i2++;
                                        if($i2<10){
                                            $i2 = '0'.$i2;
                                        }
                                ?>
                                    <div class="group_level2">
                                        <li class="stt"><a><?php echo $i2;?>)</a></li>
                                <?php
                                        foreach($v2 as $k3=>$v3){
                                            $name3 = is_array($v3)?implode(', ', $v3):$v3;
                                ?>
                                    <li><a style="padding-left:60px;"><?php echo $namekey[$k3].' : '.$name3;?></a></li>
                                <?php 
                                        }
                                ?>
                                    </div>
                                <?php
                                    } 
                                ?>
                                </ul>
                                <?php } ?>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="error" style="margin-top: 10px;">Không tìm thấy kết quả nào !!!</div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>