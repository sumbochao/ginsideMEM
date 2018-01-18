<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<style>
    .error{
        padding-left: 15%;
    }
</style>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="rows">	                
                <label for="menu_group_id">App</label>
                <select name="app">
                    <?php
                        if(count($appGame['data'])>0){
                            foreach($appGame['data'] as $v){
                                if($v['app']==$_GET['app']){
                    ?>
                    <option value="<?php echo $v['app'];?>" <?php echo ($v['app']==$_GET['app'])?'selected="selected"':'';?>><?php echo $v['description'];?></option>
                    <?php
                                }
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Money</label>
                <input type="text" name="money" class="textinput" value="<?php echo $items['money'];?>"/>
                <?php echo $errors['money'];?>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Silver</label>
                <input type="text" name="silver" class="textinput" value="<?php echo $items['silver'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Alias</label>
                <input type="text" name="alias" class="textinput" value="<?php echo $items['alias'];?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Status</label>
                <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>
