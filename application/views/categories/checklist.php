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
        <div class="option_error">
               <strong style="color:#F00"><?php echo $errors;?></strong>
        </div>
        <div id="adminfieldset">
            <div class="adminheader">Tên Template</div>
                <div class="rows">	
                        <label for="menu_group_id" style="font-size: 20px;color: #E80D0D;margin-left: 23px;margin-bottom: 0;width:100%;"><?php echo $slbTemp[intval($_GET['idtemplate'])]['template_name']; ?></label>
                </div>
            <div class="clr"></div>
        </div>
        <div id="adminfieldset">
            <div class="adminheader">Thông tin hạng mục</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Hạng mục</label>
                    <input type="text" name="txt_categories" id="txt_categories" class="textinput" style="width:500px;" value="<?php echo $item['names'] ?>" readonly />
                   
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" id="notes" id="notes" cols="30" rows="5" style="width:500px;height:150px;resize:none;" readonly ><?php echo $item['notes'] ?></textarea>
                </div>
            </div>
          
            <div class="clr"></div>
        </div>
        
        <div class="rows">	
                    <label for="menu_group_id">Chọn yêu cầu</label>
                    <select name="cbo_request" id="cbo_request" onChange="calljavascript(2);">
                        <option value="0"> -- Yêu cầu -- </option>
                       	 <?php
                            if(count($request)>0){
                                foreach($request as $v){
                        ?>
                       <option value="<?php echo $v['id'];?>"><?php echo $v['titles'];?></option>
                           
                        <?php
                                }
                            }
                        ?>
                    </select>
     </div>
                
        <div id="adminfieldset">
            <div class="adminheader">Thông tin yêu cầu</div>
            <div class="group_left" id="ajax_load_request">
                
            </div> <!--group_left-->
          
            <div class="clr"></div>
        </div>
       
       <div id="adminfieldset" style="padding-bottom:0;padding-left:30px;">
            <div class="adminheader">Ghi chú tổng quát</div>
            <div class="group_left">
                <div class="rows">
                <textarea name="notes" id="notes" id="notes" cols="30" rows="5" style="width:900px;height:150px;resize:none;"></textarea>
                </div>
                   
            </div> <!--group_left-->
            <div class="clr"></div>
       </div> <!--adminfieldset-->
    </form>
</div>
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_categories.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i){
		switch(i){
			 case 1: //save
			 		isemptychecklist();
			 break;
			 case 2://load requset
			 		var idrequest=$('#cbo_request').val();
			 		LoadRequestForCheckList(idrequest);
			 break;
			 default:
			 break;
		} //end switch
		
}
</script>