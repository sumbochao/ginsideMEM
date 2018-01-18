<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
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
            <div class="adminheader">Nhập thông tin GAME :<strong style="color:#906;"><?php echo $loadgame[intval($_GET['id_game'])]['app_fullname'] ?></strong></div>
            <div class="group_left">
            	
               <!--chon nhóm-->
               <div class="rows">	
                    <label for="menu_group_id">Chọn cấp danh mục</label>
                    <select name="cbo_categories" id="cbo_categories">
                       <option value="na"> Hạng mục chính </option>
							<?php
                                if(count($parent)>0){
                                    echo "<optgroup label='Thuộc nhóm'>";
                                    foreach($parent as $cate){
                            ?>
                            <option value="<?php echo $cate['id'];?>" <?php echo $item['id_parrent']==$cate['id']?"selected":""; ?> ><?php echo $cate['names'];?></option>
                            
                            <?php
                                    }
                                    echo " </optgroup>";
                                }
                            ?>
                    </select>
                </div>
                <!--end chon nhóm-->
                <div class="rows">	
                    <label for="menu_group_id">Tiêu đề</label>
                    <input type="text" name="names" id="names" class="textinput" style="width:500px;" value="<?php echo $item['names']; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" id="notes" id="notes" cols="30" rows="5" style="width:500px;height:150px;resize:none;"><?php echo stripslashes($item['notes']); ?></textarea>
                </div>
               
                <div class="option_error">
                       <strong style="color:#F00"><?php echo $errors;?></strong>
                </div>
            </div>
          
            <div class="clr"></div>
        </div>
        
      
    </form>
</div>
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_categories_new.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i){
		switch(i){
			 case 1: //save
			 		checkempty();
			 break;
			 default:
			 break;
		} //end switch
		
}
</script>