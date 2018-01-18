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
        function loadPage(area, url){
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
                                $title = json_decode($items['title'],true);
                                $summary = json_decode($items['summary'],true);
                                $content = json_decode($items['content'],true);
                                if(count($slbLanguage)>0){
                                    $i=0;
                                    foreach($slbLanguage as $lang){
                                        $i++;
                            ?>
                            <div id="<?php echo $lang['code'];?>" class="tab-pane fade in <?php echo $i==1?'active':'';?>">
                                <div class="control-group">
                                    <label class="control-label">Tiêu đề (<?php echo $lang['name'];?>):</label>
                                    <div class="controls">
                                        <input name="title_<?php echo $lang['code'];?>" value="<?php echo $title['title_'.$lang['code']];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Mô tả (<?php echo $lang['name'];?>):</label>
                                    <div class="controls">
                                        <textarea style="width: 100%;height:200px;" id="<?php echo 'summary_'.$lang['code'];?>" name="<?php echo 'summary_'.$lang['code'];?>"><?php echo $summary['summary_'.$lang['code']];?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Nội dung (<?php echo $lang['name'];?>):</label>
                                    <div class="controls">
                                        <textarea id="<?php echo 'content_mem_'.$lang['code'];?>" name="<?php echo 'content_mem_'.$lang['code'];?>"><?php echo $content['content_'.$lang['code']];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                            <?php
                                $is_activeOn = 'checked';//
                                if($_GET['id']>0){
                                    $is_activeOn =  $items['is_active']==1 ? 'checked="checked"':'';
                                    $is_activeOff =  $items['is_active']==0 ? 'checked="checked"':'';
                                }
                            ?>
                            <div class="control-group">
                                <label class="control-label">Picture:</label>
                                <div class="controls">
                                    <input type="file" name="image"/>
                                    <?php
                                        if($_GET['id']>0){
                                    ?>
                                    <div id="load-content" style="margin-top:10px;">
                                        <?php
                                            if(!empty($items['image'])){
                                                $removeLink = $url_service.'/cms/mem/remove_image?id='.$items['id'];
                                        ?>
                                        <img src="<?php echo $url_image.'/'.$items['image'];?>" height="57px"/>
                                        <div style="padding-top:5px;"><a href="javascript:loadPage('div#load-content','<?php echo $removeLink;?>')">remove</a></div>
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
                            <div class="control-group">
                                <label class="control-label">Trang:</label>
                                <div class="controls">
                                    <select name="page">
                                        <option value="0">Chọn trang</option>
                                        <option value="1" <?php echo $items['page'] == 1 ? 'selected="selected"' : ''; ?>>GT - Work - Play</option>
										<option value="2" <?php echo $items['page'] == 2 ? 'selected="selected"' : ''; ?>>GT - Giá trị cốt lõi</option>
										<option value="4" <?php echo $items['page'] == 4 ? 'selected="selected"' : ''; ?>>GT - Sứ mệnh</option>
										<option value="3" <?php echo $items['page'] == 3 ? 'selected="selected"' : ''; ?>>SP - Game</option>
										<option value="5" <?php echo $items['page'] == 5 ? 'selected="selected"' : ''; ?>>SP - Niềm vui</option>
										<option value="6" <?php echo $items['page'] == 6 ? 'selected="selected"' : ''; ?>>SP - Giới thiệu MEM</option>
										<option value="7" <?php echo $items['page'] == 7 ? 'selected="selected"' : ''; ?>>SP - Lịch sử MEM</option>
                                    </select>
                                    <?php echo $error['page'];?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Đường dẫn:</label>
                                <div class="controls">
                                    <input type="text" name="link" value="<?php echo $items['link'];?>" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="is_active" id="is_active" value="1" <?php echo $is_activeOn;?>/>
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="is_active" id="is_active" value="0" <?php echo $is_activeOff;?>/>
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label">Status:</label>
                                <div class="controls">
                                    <select name="status">
										<option value="0" <?php echo $items['status']=='0'?'selected="selected"':'';?>>Bình thường</option>
										<option value="1" <?php echo $items['status']=='1'?'selected="selected"':'';?>>Hot</option>
										<option value="2" <?php echo $items['status']=='2'?'selected="selected"':'';?>>New</option>
									</select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Hình thức:</label>
                                <div class="controls">
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('.mobile_android').click(function(){
                                                $('.mobile_android').val($(this).is(':checked') ? '1' : '0' );
                                            });
                                            $('.mobile_ios').click(function(){
                                                $('.mobile_ios').val($(this).is(':checked') ? '1' : '0' );
                                            });
                                            $('.mobile_wp').click(function(){
                                                $('.mobile_wp').val($(this).is(':checked') ? '1' : '0' );
                                            });
                                        });
                                    </script>
                                    <?php
                                        $mobile = json_decode($items['mobile'],true);
                                    ?>
                                    <input type="checkbox" class="mobile_android" name="mobile_android" value="<?php echo $mobile['android']==1?'1':'0';?>" <?php echo $mobile['android']==1?'checked="checked"':'';?>/> Android
                                    <input type="checkbox" class="mobile_ios" name="mobile_ios" value="<?php echo $mobile['ios']==1?'1':'0';?>" <?php echo $mobile['ios']==1?'checked="checked"':'';?>/> IOS
                                    <input type="checkbox" class="mobile_wp" name="mobile_wp" value="<?php echo $mobile['wp']==1?'1':'0';?>" <?php echo $mobile['wp']==1?'checked="checked"':'';?>/> WP
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
     
    <?php
        if(count($slbLanguage)>0){
            foreach($slbLanguage as $lang){
    ?>
    /*CKEDITOR.replace("summary_<?php echo $lang['code'];?>",{toolbar :
        [
            ['Source'],
            ['Bold','Italic','Underline','Strike'],
        ],
        height: 300,
    });*/
    CKEDITOR.replace("content_mem_<?php echo $lang['code'];?>",{height:300});
    <?php
            }
        }
    ?>
});
</script>