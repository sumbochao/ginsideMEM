<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>

<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="slbgame">
                        <option value="">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                                    if($v['alias']==$_GET['idgame']){
                        ?>
                        <option value="<?php echo $v['alias'];?>" <?php echo ($v['alias']==$_GET['idgame'])?'selected="selected"':'';?>><?php echo $v['game'];?></option>
                        <?php
                                    }
                                }
                            }
                        ?>
                    </select>
                    <?php echo $errors['slbgame'];?>
                </div>
                <?php
                    if(count($listLang)>0){
                        foreach($listLang as $v){
                            if($_GET['id']>0){
                                $linkService = $urlService.'/navigator_ginside/titlelang?id='.$_GET['id'].'&lang='.$v['alias'];
                                $j_itemsTitle = file_get_contents($linkService);
                                $itemsTitle = json_decode($j_itemsTitle,true);
                                if(!empty($itemsTitle['title'])){
                                    $titleEvent  = $itemsTitle['title'];
                                }else{
                                    $linkEvent = $urlService.'/navigator_ginside/getItem?id='.$items['service_id'];
                                    $j_itemsTitle = file_get_contents($linkEvent);
                                    $itemsTitle = json_decode($j_itemsTitle,true);
                                    $titleEvent = $itemsTitle['service_title'];
                                }
                            }
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Title (<?php echo $v['name'];?>)</label>
                    <input type="text" name="title_<?php echo $v['alias'];?>" class="textinput" value="<?php echo $titleEvent;?>"/>
                </div>
                <?php
                        }
                    }
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Link</label>
                    <input type="text" name="service_url" class="textinput" value="<?php echo $items['service_url'];?>"/>
                    <?php echo $errors['service_url'];?>
                </div>
                <div class="rows">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('.service_android').click(function(){
                                $('.service_android').val($(this).is(':checked') ? '1' : '0' );
                            });
                            $('.service_ios').click(function(){
                                $('.service_ios').val($(this).is(':checked') ? '1' : '0' );
                            });
                            $('.service_wp').click(function(){
                                $('.service_wp').val($(this).is(':checked') ? '1' : '0' );
                            });
                        });
                    </script>
                    <label for="menu_group_id">Platform</label>
                    <input type="checkbox" class="service_android" name="service_android" value="<?php echo ($items['service_android']=='1')?'1':'0';?>" <?php echo ($items['service_android']==1)?'checked="checked"':'';?>/> Android
                    <input type="checkbox" class="service_ios" name="service_ios" value="<?php echo ($items['service_ios']=='1')?'1':'0';?>" <?php echo ($items['service_ios']==1)?'checked="checked"':'';?>/> IOS
                    <input type="checkbox" class="service_wp" name="service_wp" value="<?php echo ($items['service_wp']=='1')?'1':'0';?>" <?php echo ($items['service_wp']==1)?'checked="checked"':'';?>/> WP
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Images</label>
                    <input type="text" name="service_img" class="textinput" value="<?php echo $items['service_img'];?>"/>
                </div>
            </div>
            <div class="group_right">
                <div class="rows">	
                    <label for="menu_group_id">Promotion</label>
                    <select name="service_ishot">
                        <option value="is_hot" <?php echo ($items['service_ishot']=='is_hot')?'selected="selected"':'';?>>IS_HOT</option>
                        <option value="is_new" <?php echo ($items['service_ishot']=='is_new')?'selected="selected"':'';?>>IS_NEW</option>
                        <option value="is_norml" <?php echo ($items['service_ishot']=='is_norml')?'selected="selected"':'';?>>IS_NORMAL</option>
                    </select>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">TRUST IP</label>
                    <textarea style="width: 65%; height: 150px;" name="service_trustip"><?php echo $items['service_trustip'];?></textarea>
                </div>
                <?php  
                    $service_start = gmdate('Y-m-d G:i:s',time()+7*3600);
                    $service_end = gmdate('Y-m-d G:i:s',time()+7*3600);
                    if($_GET['id']>0){
                        if(!empty($items['service_start'])){
                            $service_start = $items['service_start'];
                        }
                        if(!empty($items['service_end'])){
                            $service_end = $items['service_end'];
                        }
                    }
                   
                ?>
                <?php
                    if($_GET['id']>0){
                ?>
                <input type="hidden" name="service_order" value="<?php echo $items['service_order'];?>"/>
                <?php } ?>
                <div class="rows">
                    <label>START DATE:</label>
                    <input type="text" id="service_start" class="service_start" name="service_start" value="<?php echo $service_start;?>"/>
                </div>

                <div class="rows">
                    <label>END DATE:</label>
                    <input type="text" id="service_end" class="service_end" name="service_end" value="<?php echo $service_end;?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Status</label>
                    <input type="radio" name="service_status" value="false" <?php echo ($items['service_status']=='false')?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="service_status" value="true" <?php echo ($items['service_status']=='true')?'checked="checked"':'';?>/> Bật
                </div>
            </div>
            <div class="clr"></div>
            <?php include_once 'json_server.php'; ?>
        </div>
    </form>
</div>

<script>
    jQuery('.service_start').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss'
    });
    jQuery('.service_end').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss'
    });
</script>

