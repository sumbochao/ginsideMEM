<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('scripts/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('scripts/ckfinder/ckfinder.js'); ?>" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url('scripts/colorpicker/js/colorpicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('scripts/colorpicker/js/eye.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('scripts/colorpicker/js/utils.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('scripts/colorpicker/js/layout.js?ver=1.0.2'); ?>"></script>
<link href="<?php echo base_url('scripts/colorpicker/css/colorpicker.css'); ?>" media="screen" rel="stylesheet" type="text/css" >
<link href="<?php echo base_url('scripts/colorpicker/css/layout.css'); ?>" media="screen" rel="stylesheet" type="text/css" >
<style>
    input[type="text"], input[type="color"]{
        box-shadow:none;
    }
    .colorpicker input, .colorpicker textarea, .colorpicker .uneditable-input{
        width: auto !important;
    }
</style>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <?php
            $start = gmdate('d-m-Y G:i:s',time()+7*3600);
            $end = gmdate('d-m-Y G:i:s',time()+7*3600);
            if($_GET['id']>0){
                if(!empty($items['start'])){
                    $start = date_format(date_create($items['start']),"d-m-Y G:i:s");
                }
                if(!empty($items['end'])){
                    $end = date_format(date_create($items['end']),"d-m-Y G:i:s");
                }
            }
        ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="rows">	
                <label for="menu_group_id">Tên</label>
                <input type="text" style="width: 70%;" name="name" class="textinput" value="<?php echo $items['name'];?>"/>
                <?php echo $errors['name'];?>
            </div>
            <div class="rows picker">	
                <label for="menu_group_id">Màu tiêu đề</label>
                <input type="hidden" name="bg_title" class="bg_color" value="<?php echo $items['bg_title'];?>" />
                <span id="colorSelector" style="padding-bottom:10px;"><div style="background-color: <?php echo $items['bg_title'];?>;"></div></span>
                <script>
                    var set_color = "<?php echo $items['bg_title'];?>";
                </script>   
                <div class="clr"></div>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Nội dung</label>
                <span style="display: inline-block">
                <textarea style="height:350px; width:50%;"  id="content_popup" name="content" ><?php echo $items['content'];?></textarea>
                </span>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Bắt đầu</label>
                <input type="text" class="datetime" name="start" value="<?php echo $start;?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Kết thúc</label>
                <input type="text" class="datetime" name="end" value="<?php echo $end;?>"/>
            </div>
            <div class="rows">	
                <label for="menu_group_id">IP</label>
                <textarea name="ip" style="width:30%; height:200px;"><?php echo $items['ip'];?></textarea>
            </div>
            <div class="rows">	
                <?php include_once 'json_rule.php'; ?>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Tình trạng</label>
                <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>
<script>
 $(function(){
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
    });
    /*CKEDITOR.replace("mota",{toolbar :
        [
            ['Source'],
            ['Bold','Italic','Underline','Strike'],
        ],
        height: 200,
        width: 400
    });*/
	CKEDITOR.replace("content_popup",{height:300});
    })
</script>