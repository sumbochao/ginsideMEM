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
            <div class="adminheader">Nhập thông tin chung</div>
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
            <div class="rows">	
                <label for="menu_group_id">Forget</label>
                <input type="text" name="forgot" class="textinput" value="<?php echo $items['forgot'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Event</label>
                <input type="text" name="event" class="textinput" value="<?php echo $items['event'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Support</label>
                <input type="text" name="support" class="textinput" value="<?php echo $items['support'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Privacypolicy</label>
                <input type="text" name="privacypolicy" class="textinput" value="<?php echo $items['privacypolicy'];?>"/>
            </div>
            <div class="clr"></div>
        </div>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin guide</div>
            <?php
                $guide  =  json_decode($items['guide'],true);
            ?>
            <div class="rows">	
                <label for="menu_group_id">Tiêu đề</label>
                <input type="text" name="guide_title" class="textinput" value="<?php echo $guide['title'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Url</label>
                <input type="text" name="guide_url" class="textinput" value="<?php echo $guide['url'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Icon</label>
                <input type="text" name="guide_icon" class="textinput" value="<?php echo $guide['icon'];?>"/>
            </div>
            <div class="clr"></div>
        </div>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin payplist</div>
            <?php
                $payplist  =  json_decode($items['payplist'],true);
            ?>
            <div class="rows">	
                <label for="menu_group_id">Tiêu đề</label>
                <input type="text" name="payplist_title" class="textinput" value="<?php echo $payplist['title'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Url</label>
                <input type="text" name="payplist_url" class="textinput" value="<?php echo $payplist['url'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Icon</label>
                <input type="text" name="payplist_icon" class="textinput" value="<?php echo $payplist['icon'];?>"/>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>