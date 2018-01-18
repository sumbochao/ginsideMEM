<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Tên</label>
                    <input type="text" name="version_name" class="textinput" value="<?php echo $items['version_name'];?>"/>
                    <?php echo $errors['version_name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Key App</label>
                    <textarea class="textarea" name="cert_name"><?php echo $items['cert_name'];?></textarea>
                    <?php echo $errors['cert_name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <?php
                    if($_GET['func']=='edit'){
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Sắp xếp</label>
                    <input type="text" name="order" class="textinput" value="<?php echo $items['order'];?>"/>
                </div>
                <?php } ?>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>