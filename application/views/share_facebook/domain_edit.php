<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css'); ?>">
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="?<?php echo $_SERVER["QUERY_STRING"] ?>" method="post" name="appForm">

        <div class="filter">  
            <a href="?control=sharefacebook&func=domain_list" class="btnB btn-primary">Quay lại</a><br><br>
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
                    <label for="menu_group_id">Game</label>
                    <input type="text" name="game" class="textinput" value="<?php echo!empty($data) ? $data['game'] : $_POST["game"]; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Domain</label>
                    <input type="text" name="domain" class="textinput" value="<?php echo!empty($data) ? $data['domain'] : $_POST["domain"] ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Alias</label>
                    <input type="text" name="alias" class="textinput" value="<?php echo!empty($data) ? $data['alias'] : $_POST["alias"]; ?>"/>
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