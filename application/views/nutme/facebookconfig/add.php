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
                
                <div class="rows">	
                    <label for="menu_group_id">Name</label>
                    <input type="text" name="name" class="textinput" value="<?php echo $items['name'];?>"/>
                    <?php echo $errors['name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Client ID</label>
                    <input type="text" name="client_id" class="textinput" value="<?php echo $items['client_id'];?>"/>
                    <?php echo $errors['client_id'];?>
                </div>
            </div>
            <div class="group_right">
                <div class="rows">	
                    <label for="menu_group_id">Client Secret</label>
                    <input type="text" name="client_secret" class="textinput" value="<?php echo $items['client_secret'];?>"/>
                    <?php echo $errors['client_secret'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Server</label>
                    <input type="text" name="server_id" class="textinput" value="<?php echo $items['server_id'];?>"/>
                    <?php echo $errors['server_id'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Status</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']=='0')?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']=='1')?'checked="checked"':'';?>/> Bật
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>