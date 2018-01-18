<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<!-- ck editor -->
<script src="<?php echo base_url('assets/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/ckfinder/ckfinder.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<style>
.rows{
	width:800px;
}
</style>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
            	<div class="rows">	
                    <label for="menu_group_id">Chọn hạng mục</label>
                    <select name="cbo_categories" id="cbo_categories">
                        <option value="0"> -- Hạng Mục -- </option>
                        <?php
                            if(count($categories)>0){
                                foreach($categories as $v){
                        ?>
                        <option value="<?php echo $v['id'];?>" <?php echo $item['id_categories']==$v['id']?"selected":"";?>><?php echo $v['names'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
               <!-- <div class="rows">	
                    <label for="menu_group_id">Platform</label>
                    <select name="cbo_platform" id="cbo_platform">
                        <option value="0">Chọn Platform</option>
                        <?php
                            if(count($loadplatform)>0){
                                foreach($loadplatform as $key=>$value){
                        ?>
                        <option value="<?php echo $value;?>"><?php echo $value;?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    
                </div>-->
                <div class="rows">	
                    <label for="menu_group_id">Tiêu đề</label>
                    <input type="text" name="titles" id="titles" class="textinput" style="width:500px;" value="<?php echo $item['titles'] ?>"/>
                </div>
                 <div class="rows">	
                    <label for="menu_group_id">Thuộc nhóm</label>
                    <input type="checkbox" name="chk_ios" value="true" <?php echo $item['ios']=="true"?"checked":"";?> />IOS
                    <input type="checkbox" name="chk_android" value="true" <?php echo $item['android']=="true"?"checked":"";?> />Android
                    <input type="checkbox" name="chk_wp" value="true" <?php echo $item['wp']=="true"?"checked":"";?> />WinPhone
                    <input type="checkbox" name="chk_orther" value="true" <?php echo $item['orther']=="true"?"checked":"";?> />None Client(System/inside/web)
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" id="notes" id="notes" cols="30" rows="5" style="width:500px;height:150px;resize:none;"><?php echo stripslashes($item['notes']) ?></textarea>
                     <?php //echo $this->CKEditor->editor("notes",stripslashes($item['notes'])); ?>
                     <script type="text/javascript">
					$(function() {				    				    
						var editor = CKEDITOR.replace('notes',
							{
								filebrowserBrowseUrl : '<?php echo base_url("assets/ckfinder/ckfinder.html"); ?>',
								filebrowserImageBrowseUrl : '<?php echo base_url("assets/ckfinder/ckfinder.html?Type=Images");?>',
								filebrowserFlashBrowseUrl : '<?php echo base_url("assets/ckfinder/ckfinder.html?Type=Flash") ?>',
								filebrowserUploadUrl : '<?php echo base_url("assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files")?>',
								filebrowserImageUploadUrl : '<?php echo base_url("assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images");?>',
								filebrowserFlashUploadUrl : '<?php echo base_url("assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash");?>',
								filebrowserWindowWidth : '800',
								filebrowserWindowHeight : '480'
							});
						CKFinder.setupCKEditor( editor, "<?php echo base_url('assets/ckfinder/')?>" );
					})
				</script>
                </div>
               
                <div class="option_error">
                       <strong style="color:#F00"><?php echo $errors;?></strong>
                </div>
            </div>
          
            <div class="clr"></div>
        </div>
        
        <div id="adminfieldset" style="padding-bottom:70px;padding-left:30px;">
            <div class="adminheader">Group thực hiện chính</div>
            <div class="group_left" style="width:100% !important;">
            	 <div class="rows">
            	<?php
				
                            if(count($groupActive)>0){
                                foreach($groupActive as $v){
									
                        ?>
                        <input type="checkbox" name="chk_group_actice[<?php echo $v['id_group'];?>]" id="chk_group_actice_<?php echo $v['id_group'];?>" value="<?php echo $v['id_group'];?>" checked="checked" onchange="calljavascript(2,<?php echo $v['id_group'];?>)" /><?php echo $v['names'];?>
                    <?php
									
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                     <div class="rows">
            	<?php
				
                            if(count($groupNotActive)>0){
                                foreach($groupNotActive as $v){
									
                        ?>
                        <input type="checkbox" name="chk_group[<?php echo $v['id'];?>]" id="chk_group_<?php echo $v['id'];?>" value="<?php echo $v['id'];?>" /><?php echo $v['names'];?>
                    <?php
									
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                    
            </div> <!--group_left-->
            
       </div> <!--adminfieldset-->
       
       <div id="adminfieldset" style="padding-bottom:70px;padding-left:30px;">
            <div class="adminheader">Group hỗ trợ</div>
            <div class="group_left" style="width:100% !important;">
            	 <div class="rows">
            	<?php
				
                            if(count($groupActiveSupport)>0){
                                foreach($groupActiveSupport as $v){
									
                        ?>
                        <input type="checkbox" name="chk_group_actice_support[<?php echo $v['id_group'];?>]" id="chk_group_actice_support_<?php echo $v['id_group'];?>" value="<?php echo $v['id_group'];?>" checked="checked" onchange="calljavascript(2,<?php echo $v['id_group'];?>)" /><?php echo $v['names'];?>
                    <?php
									
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                     <div class="rows">
            	<?php
				
                            if(count($groupNotActiveSupport)>0){
                                foreach($groupNotActiveSupport as $v){
									
                        ?>
                        <input type="checkbox" name="chk_group_support[<?php echo $v['id'];?>]" id="chk_group_support_<?php echo $v['id'];?>" value="<?php echo $v['id'];?>" /><?php echo $v['names'];?>
                    <?php
									
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                    
            </div> <!--group_left-->
            
       </div> <!--adminfieldset-->
    </form>
</div>
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_request.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i,id){
		switch(i){
			 case 1: //save
			 		checkemptyrequest();
			 break;
			 case 2: // deleted group
			 		
			 break;
			 default:
			 break;
		} //end switch
		
}
</script>