<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<!-- ck editor -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript" type="text/javascript"></script>
<script src="<?php echo base_url('assets/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/ckfinder/ckfinder.js'); ?>" type="text/javascript"></script>
<style>
.rows{
	width:1000px;
}
.group_left{
	width:100%;
}
.lbl{
	display:inline;
}
</style>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php';include('class.php'); ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
            	<div class="option_error">
                       <strong style="color:#F00"><?php echo $errors;?></strong>
                </div>
            	<div class="rows">	
                    <label for="menu_group_id">Chọn hạng mục</label>
                    <select name="cbo_categories" id="cbo_categories">
                        <option value="0"> -- Hạng Mục -- </option>
                        <?php
                            if(count($categories)>0){
                                foreach($categories as $item){
								$child = $cate->ShowCateChild($item['id_game'],$item['id']);
                        ?>
                        <optgroup label="<?php echo $item['names'];?>">
                        	<?php
									foreach($child as $items){
							?>
                            <option value="<?php echo $items['id'];?>" <?php echo (isset($_GET['id_categories']) && $_GET['id_categories']==$items['id'])?"selected":""; ?>><?php echo $items['names'];?></option>
                            <?php 	}//end for  ?>
                        </optgroup>
                        
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            
                <div class="rows">	
                    <label for="menu_group_id">Tên yêu cầu</label>
                    <textarea name="titles" id="titles" cols="30" rows="5" style="width:500px;height:100px;resize:none;"></textarea>
                </div>
                 <div class="rows">	
                    <label for="menu_group_id">Loại yêu cầu</label>
                   <input type="checkbox" name="chk_ios" id="chk_ios" value="true" />
                   <label class="lbl" for="chk_ios" style="color:#333;width:25px;margin:0;">IOS</label>
                   
                    <input type="checkbox" name="chk_android" id="chk_android" value="true" />
                    <label class="lbl" for="chk_android" style="color:#333;width:25px;margin:0;">Android</label>
                    
                    <input type="checkbox" name="chk_wp" id="chk_wp" value="true" />
                    <label class="lbl" for="chk_wp" style="color:#333;width:25px;margin:0;">WinPhone</label>
                    
                    <input type="checkbox" name="chk_event" id="chk_event" value="true" />
                    <label class="lbl" for="chk_event" style="color:#333;width:25px;margin:0;">Event</label>
                    
                    <input type="checkbox" name="chk_pc" id="chk_pc" value="true" />
                    <label class="lbl" for="chk_pc" style="color:#333;width:35px;margin:0;">PC Platform</label>
                    
                    <input type="checkbox" name="chk_system" id="chk_system" value="true" />
                    <label class="lbl" for="chk_system" style="color:#333;width:25px;margin:0;">System</label>
                    
                    <input type="checkbox" name="chk_web" id="chk_web" value="true" />
                    <label class="lbl" for="chk_web" style="color:#333;width:25px;margin:0;">Config</label>
                    
                    <input type="checkbox" name="chk_orther" id="chk_orther" value="true" />
                    <label class="lbl" for="chk_orther" style="color:#333;width:25px;margin:0;">Other</label>
                </div>
                 <div class="rows">	
                    <label for="menu_group_id">Kết quả mong muốn</label>
                    <textarea name="admin_request" id="admin_request" cols="30" rows="5" style="width:500px;height:100px;resize:none;"></textarea>
                </div>
              
            	 <div class="rows">
                 <label for="menu_group_id">Group thực hiện chính</label>
            	<?php
                            if(count($group)>0){
                                foreach($group as $item){
									if($item['id'] != -1){
                        ?>
                        <input type="checkbox" name="chk_group[<?php echo $item['id'];?>]" id="chk_group_<?php echo $item['id'];?>" value="<?php echo $item['id'];?>" <?php echo $item['id']==1?"checked":"";?>  /><label class="lbl" for="chk_group_<?php echo $item['id'];?>" style="color:#333;margin:0;"><?php echo $item['names'];?></label>
						<?php
									}//end if
								
								} //end for
							}//end if
					?>
                    </div> <!--rows-->
                    
             <div class="rows">
             <label for="menu_group_id">Group hỗ trợ</label>
            <?php
                        if(count($groupsupport)>0){
                            foreach($groupsupport as $item){
                                    if($item['id'] != -1){
                    ?>
                    <input type="checkbox" name="chk_group_support[<?php echo $item['id'];?>]" id="chk_group_support_<?php echo $item['id'];?>" value="<?php echo $item['id'];?>" <?php echo $item['id']==5?"checked":"";?> /><label class="lbl" for="chk_group_support_<?php echo $item['id'];?>" style="color:#333;margin:0;"><?php echo $item['names'];?></label>
                <?php
                                    }//end if
                            } //end for
                        }//end if
                ?>
                </div> <!--rows-->
                    

                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" id="notes" cols="30" rows="5" style="width:500px;height:150px;resize:none;"></textarea>
                    <?php  //echo $this->CKEditor->editor("notes",""); ?>
                    
                </div>
               
                
            </div>
          
            <div class="clr"></div>
        </div>
        
        
    </form>
</div>
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_request_new.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i){
		switch(i){
			 case 1: //save
			 		checkemptyrequest();
			 break;
			 default:
			 break;
		} //end switch
		
}
</script>