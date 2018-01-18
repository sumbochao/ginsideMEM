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
                                $value = json_decode($items['value'],true);
                                if(count($slbLanguage)>0){
                                    $i=0;
                                    foreach($slbLanguage as $lang){
                                        $i++;
                            ?>
                            <div id="<?php echo $lang['code'];?>" class="tab-pane fade in <?php echo $i==1?'active':'';?>">
                                <div class="control-group">
                                    <label class="control-label">Nôi dung (<?php echo $lang['code'];?>):</label>
                                    <div class="controls">
                                        <textarea style="width: 100%;height:200px;" id="<?php echo 'value_'.$lang['code'];?>" name="<?php echo 'value_'.$lang['code'];?>"><?php echo $value['value_'.$lang['code']];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tên key:</label>
                            <div class="controls">
                                <input type="text" name="name" value="<?php echo $items['name'];?>" style="width: 80%"/>
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