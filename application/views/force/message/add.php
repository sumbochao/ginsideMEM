<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="rows">	
                <label for="menu_group_id">Platform</label>
                <select name="platform">
                    <option value="">Chọn Platform</option>
                    <option value="android" <?php echo $items['platform']=='android'?'selected="selected"':'';?>>Android</option>
                    <option value="ios" <?php echo $items['platform']=='ios'?'selected="selected"':'';?>>Ios</option>
                    <option value="wp" <?php echo $items['platform']=='wp'?'selected="selected"':'';?>>Wp</option>
                </select>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Service ID</label>
                <select name="service_id">
                    <option value="">Chọn game</option>
                    <?php
                        if(count($listgame)>0){
                            foreach($listgame as $v){
                    ?>
                    <option value="<?php echo $v['service_id'];?>" <?php echo $v['service_id']==$items['service_id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <?php
                if(!empty($items['msg_link'])){
                    $msg_link = json_decode($items['msg_link'],true);
                }else{
                    $msg_link = array('link'=>'','message'=>'');
                }
            ?>
            <div class="rows">	
                <label for="menu_group_id">Link</label>
                <input type="text" name="link" class="textinput" value="<?php echo $msg_link['link'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Message</label>
                <textarea name="message" style="width: 70%; height: 150px;"><?php echo $msg_link['message'];?></textarea>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>