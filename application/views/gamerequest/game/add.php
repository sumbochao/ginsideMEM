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
                    <label for="menu_group_id">Game ID</label>
                    <input type="text" name="gameID" class="textinput" value="<?php echo $items['gameID'];?>"/>
                    <?php echo $errors['gameID'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Name</label>
                    <input type="text" name="name" class="textinput" value="<?php echo $items['name'];?>"/>
                    <?php echo $errors['name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Alias</label>
                    <input type="text" name="alias" class="textinput" value="<?php echo $items['alias'];?>"/>
                    <?php echo $errors['alias'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Url</label>
                    <input type="text" name="url" class="textinput" value="<?php echo $items['url'];?>"/>
                    <?php echo $errors['url'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Link Android</label>
                    <input type="text" name="linkandroid" class="textinput" value="<?php echo $items['linkandroid'];?>"/>
                    <?php echo $errors['linkandroid'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Link Ios</label>
                    <input type="text" name="linkios" class="textinput" value="<?php echo $items['linkios'];?>"/>
                    <?php echo $errors['linkios'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Link Wp</label>
                    <input type="text" name="linkwp" class="textinput" value="<?php echo $items['linkwp'];?>"/>
                    <?php echo $errors['linkwp'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>