<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('scripts/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('scripts/ckfinder/ckfinder.js'); ?>" type="text/javascript"></script>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <?php include APPPATH . 'views/mem/tab.php'; ?>
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
        .form-group {
            float: left;
            width: 22%;
        }
        .form-group input {
            width: 70%;
        }
        .form-horizontal .form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .form-horizontal .listItem .control-label{
            padding-right: 5px;
            width: 27% !important;
            color: green;
        }
        .form-horizontal .listItem .sublistItem .control-label{
            color: #f36926;
        }
        .form-horizontal .sublistItem{
            margin-left: 15px;
        }
        .remove_field,.remove_field_receive{
            cursor: pointer;
            color: green;
        }
        .input_fields .control-group{
            padding-top: 23px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
        
        .input_fields_wrap .control-group .sublistItem .remove_sub{
            top:4px;
        }
        .loadContent{
            text-align: center;
            color: red;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
            color: #f36926 !important;
        }
        .form-horizontal .control-label{
            text-align: center;
        }
        .form-group.remove{
            width: 10%;
            position: relative;
            top:6px;
        }
        .subItems{
            margin-left: 20px;
        }
        .well{
            background: none;
        }
        .error{
            margin-top: 1px;
        }
    </style>
    <!-- Content -->
    
    <script>
        $(function(){
            $("#comeback").click(function(){
                window.location.href='<?php echo base_url()."?control=".$_GET['control']."&func=index&view=".$_GET['view']."&module=all";?>';
            });
        });
        function loadPageImage(area, url){
            $(area).load(url);
	}
        function loadPageAvatar(area, url){
            $(area).load(url);
	}
    </script>
    <link rel="stylesheet" href="<?php echo base_url('assets/tab/bootstrap.min.css'); ?>">
    <script src="<?php echo base_url('assets/tab/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/tab/bootstrap.min.js'); ?>"></script>
    <div id="content" style="margin-top:10px;">
        <!-- Content wrapper -->
        <div class="wrapper">
            
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="appForm" name="appForm" action="" method="POST" enctype="multipart/form-data">
                    <?php include_once 'include/toolbar.php'; ?>
                    <div class="well form-horizontal">
                        <ul class="nav nav-tabs">
                            <?php
                                if(count($slbLanguage)>0){
                                    $i=0;
                                    foreach($slbLanguage as $lang){
                                        $i++;
                            ?>
                            <li class="<?php echo $i==1?'active':'';?>"><a data-toggle="tab" href="#<?php echo $lang['code'];?>"><?php echo $lang['name'];?></a></li>
                            <?php
                                    }
                                }
                            ?>
                        </ul>
                        <div class="tab-content">
                            <?php
                                $name = json_decode($items['name'],true);
                                if(count($slbLanguage)>0){
                                    $i=0;
                                    foreach($slbLanguage as $lang){
                                        $i++;
                            ?>
                            <div id="<?php echo $lang['code'];?>" class="tab-pane fade in <?php echo $i==1?'active':'';?>">
                                <div class="control-group">
                                    <label class="control-label">Tên (<?php echo $lang['name'];?>):</label>
                                    <div class="controls">
                                        <input name="name_<?php echo $lang['code'];?>" value="<?php echo $name['name_'.$lang['code']];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Picture:</label>
                            <div class="controls">
                                <input type="file" name="image"/>
                                <?php
                                    if($_GET['id']>0){
                                ?>
                                <div id="load-content-image" style="margin-top:10px;">
                                    <?php
                                        if(!empty($items['image'])){
                                            $removeLink = $url_service.'/cms/mem/remove_gallery_image?id='.$items['id'];
                                    ?>
                                    <img src="<?php echo $url_image.'/'.$items['image'];?>" height="57px"/>
                                    <div style="padding-top:5px;"><a href="javascript:loadPageImage('div#load-content-image','<?php echo $removeLink;?>')">remove</a></div>
                                    <?php
                                        }
                                    ?>

                                    <input type="hidden" class="span12" name="current_image" value="<?php echo $items['image'];?>"/>
                                </div>
                                <?php
                                    }
                                ?>
                                <?php echo $error['image'];?>
                            </div>
                        </div>
                        <div class="control-group wrap_avatar" <?php echo ($items['type']==2)?'style="display:block"':'style="display:none"';?>>
                            <label class="control-label">Avatar:</label>
                            <div class="controls">
                                <input type="file" name="avatar"/>
                                <?php
                                    if($_GET['id']>0){
                                ?>
                                <div id="load-content-avatar" style="margin-top:10px;">
                                    <?php
                                        if(!empty($items['avatar'])){
                                            $removeLinkAvatar = $url_service.'/cms/mem/remove_gallery_avatar?id='.$items['id'];
                                    ?>
                                    <img src="<?php echo $url_image.'/'.$items['avatar'];?>" height="57px"/>
                                    <div style="padding-top:5px;"><a href="javascript:loadPageAvatar('div#load-content-avatar','<?php echo $removeLinkAvatar;?>')">remove</a></div>
                                    <?php
                                        }
                                    ?>

                                    <input type="hidden" class="span12" name="current_avatar" value="<?php echo $items['avatar'];?>"/>
                                </div>
                                <?php
                                    }
                                ?>
                                <?php echo $error['avatar'];?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Loại:</label>
                            <div class="controls">
                                <select name="type" class="type">
                                    <option value="0">Chọn loại</option>
                                    <option value="1" <?php echo $items['type']==1?'selected="selected"':'';?>>Giới thiệu</option>
                                    <option value="2" <?php echo $items['type']==2?'selected="selected"':'';?>>Sản phẩm</option>
                                    <option value="3" <?php echo $items['type']==3?'selected="selected"':'';?>>Đối tác</option>
									<option value="4" <?php echo $items['type']==4?'selected="selected"':'';?>>Sinh nhật</option>
                                </select>
                                <?php echo $error['type'];?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Đường dẫn:</label>
                            <div class="controls">
                                <input type="text" name="link" value="<?php echo $items['link'];?>" style="width: 80%"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <?php
                                    if($_GET['id']>0){
                                ?>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    $(function(){
        $(".type").change(function(){
            if($(this).val()=='2'){
                $(".wrap_avatar").show();
            }else{
                $(".wrap_avatar").hide();
            }
        });
    });
</script>