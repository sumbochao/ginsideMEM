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
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Mã server</label>
                    <input type="text" name="server_id" class="textinput" value="<?php echo $items['server_id'];?>"/>
                    <?php echo $errors['server_id'];?>
                </div>
				<?php
                    if($_GET['id']>0){
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Server ID Merge</label>
                    <input type="text" name="server_id_merge" class="textinput" value="<?php echo $items['server_id_merge'];?>"/>
                    <?php echo $errors['server_id_merge'];?>
                </div>
                <?php } ?>
                <div class="rows">	
                    <label for="menu_group_id">Tên server</label>
                    <input type="text" name="server_name" class="textinput" value="<?php echo $items['server_name'];?>"/>
					<div style="margin-left:153px;width:100%;font-style:italic;color:#999">Vui lòng nhập tên máy chủ như sau ví dụ: Bạch Cốt Tinh[60021]</div>
                    <?php echo $errors['server_name'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Địa chỉ server</label>
                    <input type="text" name="server_game_address" class="textinput" value="<?php echo $items['server_game_address'];?>"/>
                    <?php echo $errors['server_game_address'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ngày tạo</label>
                    <?php
                        if(!empty($items['create_date'])){
                            $date = new DateTime($items['create_date']);
                            $create_date = $date->format('d-m-Y G:i:s');
                        }else{
                            $create_date = date('d-m-Y G:i:s');
                        }
                    ?>
                    <input type="text" name="create_date" placeholder="Ngày tạo" value="<?php echo $create_date;?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="game">
                        <option value="">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                                    if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                        ?>
                        <option value="<?php echo $v['app_name'];?>" <?php echo $v['app_name']==$items['game']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                        <?php
                                    }
                                }
                            }
                        ?>
                    </select>
                    <?php echo $errors['game'];?>
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
<script type="text/javascript">
    $('input[name=create_date]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss'
    });
</script>