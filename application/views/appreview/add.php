<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<style>
    .error{
        padding-left: 15%;
    }
    .chosen-container.chosen-container-single{
        width: 360px !important;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="rows">	
                <label for="menu_group_id">Loại</label>
                <select name="type" onchange="loadPackage(this.value)">
                    <option value="">Chọn Loại</option>
                    <option value="ios" <?php echo $items['type']=='ios'?'selected="selected"':'';?>>IOS</option>
                    <option value="android" <?php echo $items['type']=='android'?'selected="selected"':'';?>>Android</option>
                </select>
                <?php if(!empty($errors['type'])){ ?>
                <div class="error"><?php echo $errors['type'];?></div>
                <?php } ?>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Package</label>
                <span class='load_package'>
                    <select name="id_projects" class=chosen-select tabindex='2' data-placeholder='Chọn danh mục' onchange='visibleParents(this.value)'>
                        <option value="0">Chọn package</option>
                        <?php
                            if($slbProjects==true){
                                foreach($slbProjects as $v){
                        ?>
                        <option value="<?php echo $v['id'];?>" <?php echo $v['id']==$items['id_projects']?'selected="selected"':'';?>><?php echo $v['package_name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <script type="text/javascript">
                        var config = {
                          '.chosen-select'           : {},
                          '.chosen-select-deselect'  : {allow_single_deselect:true},
                          '.chosen-select-no-single' : {disable_search_threshold:10},
                          '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                          '.chosen-select-width'     : {width:"100%"}
                        }
                        for (var selector in config) {
                          $(selector).chosen(config[selector]);
                        }
                  </script>
                </span>
                
                <?php if(!empty($errors['id_projects'])){ ?>
                  <div class="error" style="margin-top:4px;"><?php echo $errors['id_projects'];?></div>
                <?php } ?>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Version</label>
                <input type="text" name="version" class="textinput" value="<?php echo $items['version'];?>"/>
                <?php if(!empty($errors['version'])){ ?>
                <div class="error"><?php echo $errors['version'];?></div>
                <?php } ?>
            </div>
            <div class="rows">	
                <label for="menu_group_id">Tình trạng</label>
                <select name="status">
                    <option value="0" <?php echo $items['status']=='0'?'selected="selected"':'';?>>Approving</option>
                    <option value="1" <?php echo $items['status']=='1'?'selected="selected"':'';?>>Approved</option>
                    <option value="2" <?php echo $items['status']=='2'?'selected="selected"':'';?>>Reject</option>
                    <option value="3" <?php echo $items['status']=='3'?'selected="selected"':'';?>>Cancel</option>
                </select>
            </div>
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
            <div class="clr"></div>
        </div>
    </form>
</div>
<script>
    function loadPackage(platform){
        $.ajax({
            url:baseUrl+'?control=app_review&func=getplatform',
            type:"POST",
            data:{platform:platform},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                $('.loading_warning').hide();
                if(typeof f.error!="undefined" && f.error==0){
                    $(".load_package").html(f.html);
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                }
            }
        });
    }
</script>