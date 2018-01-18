<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Name</label>
                    <input type="text" name="name" class="textinput" value="<?php echo $items['name'];?>"/>
                    <?php echo $errors['name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Func</label>
                    <input type="text" name="funcs" class="textinput" value="<?php echo $items['func'];?>"/>
                    <?php echo $errors['func'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Dict</label>
                    <input type="text" name="dict" class="textinput" value="<?php echo $items['dict'];?>"/>
                    <?php echo $errors['dict'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Active Type</label>
                    <input type="radio" name="activeType" value="0" <?php echo ($items['activeType']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="activeType" value="1" <?php echo ($items['activeType']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Type</label>
                    <input type="radio" name="type" value="0" <?php echo ($items['type']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="type" value="1" <?php echo ($items['type']==1)?'checked="checked"':'';?>/> Bật
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>