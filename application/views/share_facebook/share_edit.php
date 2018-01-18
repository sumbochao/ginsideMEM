<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css'); ?>">
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="?<?php echo $_SERVER["QUERY_STRING"] ?>" method="post" name="appForm">

        <div class="filter">  
            <a href="?control=sharefacebook&func=index&id=<?php echo $_GET["domain"] ?>" class="btnB btn-primary">Quay lại</a><br><br>
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
                    <label for="menu_group_id">Caption</label>
                    <input type="text" name="caption" class="textinput" value="<?php echo!empty($data) ? $data['caption'] : $_POST["caption"] ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Message</label>
                    <input type="text" name="message" class="textinput" value="<?php echo!empty($data) ? $data['message'] : $_POST["message"]; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Photo</label>
                    <input type="text" name="photo" class="textinput" value="<?php echo!empty($data) ? $data['photo'] : $_POST["photo"]; ?>"/><br>
                    <label for="menu_group_id"></label>
                    <img src="<?php echo $data['photo'] ?>" width="140px" />
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Link</label>
                    <input type="text" name="link" class="textinput" value="<?php echo!empty($data) ? $data['link'] : $_POST["link"]; ?>"/>
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