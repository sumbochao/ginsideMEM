<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css'); ?>">
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="?<?php echo $_SERVER["QUERY_STRING"] ?>" method="post" name="appForm">

        <div class="filter">  
            <a href="?control=configappfacebook&func=index&id=<?php echo $_GET["domain"] ?>" class="btnB btn-primary">Quay lại</a><br><br>
        </div>

        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <?php
                //var_dump($data["error_msg"]);
                if (!empty($error_msg)) {
                    ?>
                    <div class="rows alert <?php echo $valid ? "alert-success" : "alert-danger" ?>">
                        <?php echo $error_msg ?>
                    </div>
                    <?php
                }
                ?>

                <div class="rows">	
                    <label for="menu_group_id">Tên</label>
                    <input type="text" name="name" class="textinput" value="<?php echo!empty($data) ? $data['name'] : $_POST["name"]; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">ClientID</label>
                    <input type="text" name="client_id" class="textinput" value="<?php echo!empty($data) ? $data['client_id'] : $_POST["client_id"] ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Client_secret</label>
                    <input type="text" name="client_secret" class="textinput" value="<?php echo!empty($data) ? $data['client_secret'] : $_POST["client_secret"]; ?>"/>
                </div>
				<div class="rows">	
                    <label for="menu_group_id">ServerID</label>
                    <input type="text" name="server_id" class="textinput" value="<?php echo!empty($data) ? $data['server_id'] : $_POST["server_id"]; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Status</label>
                    <input type="radio" name="status" value="0" <?php echo (!empty($data) && $data['status'] == 0) ? 'checked="checked"' : ''; ?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo (!empty($data) && $data['status'] == 1) ? 'checked="checked"' : ''; ?>/> Bật
                </div>
                <div class="rows">	
                    <input type="submit" class="btnB btn-primary" 
                           value="<?php echo isset($_GET["id"]) ? "cập nhật" : "thêm" ?>" 
                           name="<?php echo isset($_GET["id"]) ? "edit" : "add" ?>" />
                </div>
            </div>

            <div class="clr"></div>
        </div>
    </form>
</div>