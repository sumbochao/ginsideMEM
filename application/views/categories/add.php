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
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
            	<div class="rows">	
                    <label for="menu_group_id">Chọn Template</label>
                    <select name="cbo_template" id="cbo_template" onchange="showcategories(this.value,'cbo_categories',0);">
                        <option value="0"> -- Template -- </option>
						<?php
                            if(count($slbtemplate)>0){
                                foreach($slbtemplate as $item){
                        ?>
                        <option value="<?php echo $item['id'];?>" <?php echo (intval($_GET['id_template'])==$item['id']) || ($_POST['cbo_template']==$item['id'])?"selected":""; ?>><?php echo $item['template_name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
               <!--chon nhóm-->
               <div class="rows">	
                    <label for="menu_group_id">Chọn cấp danh mục</label>
                    <select name="cbo_categories" id="cbo_categories">
                       
                    </select>
                </div>
                <!--end chon nhóm-->
                <div class="rows">	
                    <label for="menu_group_id">Tiêu đề</label>
                    <input type="text" name="names" id="names" class="textinput" style="width:500px;"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" id="notes" id="notes" cols="30" rows="5" style="width:500px;height:150px;resize:none;"></textarea>
                </div>
				<div class="rows">	
                    <label for="menu_group_id">Sắp xếp</label>
                    <input type="text" name="order" id="order" class="textinput" style="width:500px;" value=""/>
                </div>
                <div class="option_error">
                       <strong style="color:#F00"><?php echo $errors;?></strong>
                </div>
            </div>
          
            <div class="clr"></div>
        </div>
        
      
    </form>
</div>
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_categories.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
<?php
	if($_GET['id_categories']>0){
		$id_categories = $_GET['id_categories'];
	}else{
		$id_categories = $_POST['cbo_categories'];
	}
?>
showcategories($('#cbo_template').val(),'cbo_categories',<?php echo intval($id_categories); ?>,'add');
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