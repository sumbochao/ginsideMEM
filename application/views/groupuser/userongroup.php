<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
	
</script>
<style>
.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
	vertical-align:top;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1100px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
    <?php //include_once 'include/toolbar.php'; ?>
</div> <!--content_form-->

 <div id="adminfieldset">
    <div class="adminheader">Thêm User vào Group: <strong style="color:#903"><?php echo $slbGroup[$_GET['id_group']]['names']; ?></strong></div>
        <div class="rows">	
         <form id="appFormGame" name="appFormGame" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=adduser&id_group=<?php echo intval($_GET['id_group']); ?>" method="post" >
         <select name="cbo_user" id="cbo_user" class="chosen-select" tabindex="2" data-placeholder="Chọn game">
                <option value="0"> -- Chọn User -- </option>
                <?php
                    if(count($slbUser)>0){
                        foreach($slbUser as $v){
                ?>
                <option value="<?php echo $v['id'];?>"><?php echo $v['username'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
             <input type="button" onclick="calljavascript(1,0);" value="Add User" class="btnB btn-primary"/> 			 <div class="rows">
                	<div id="mess" style="color:#008000;font-size:20px;font-weight:bold">
					<?php echo base64_decode($_GET['mess']); ?>
                    </div>
             </div>
         </form>
        </div>
    <div class="clr"></div>
</div>
 <div id="adminfieldset">
    <div class="adminheader">Danh sách user ở trong Group: <strong style="color:#903"><?php echo $slbGroup[$_GET['id_group']]['names']; ?></strong></div>
    <form id="appFormRemove" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=removeuser&id_group=<?php echo intval($_GET['id_group']);?>" method="post" name="appFormRemove" enctype="multipart/form-data">
        <div class="rows">	
         <?php
                    if(count($listUserOnGroup)>0){
                        foreach($listUserOnGroup as $v){
                ?>
                <input type="checkbox" name="chk_user[<?php echo $v['id_user'];?>]" id="chk_user_<?php echo $v['id_user'];?>" value="<?php echo $v['id_user'];?>" style="margin-left:10px;" />
				<a href="javascript:void(0);" onClick="$('#chk_user_<?php echo $v['id_user'];?>').prop('checked',!document.getElementById('chk_user_<?php echo $v['id_user'];?>').checked);" style="color:#E81287;text-decoration:none;"> <?php echo $slbUser[$v['id_user']]['username']; ?></a>
                <?php
                        }
                    }
                ?>
        </div>
        <div class="rows" style="margin-top:15px;margin-left:15px;">
        	<input type="button" onclick="calljavascript(2);" value="Remove User" style="font-size:10px;color:#98225D"/>
            
        </div>
        <div class="rows">
        <label style="width:100%;margin-left:15px;">Click vào ô checkbox sau đó nhấn nút "Remove User" sẽ xóa user khỏi Group này.</label>
        </div>
    </form>
    <div class="clr"></div>
</div>

            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_groupuser.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i,id){
		switch(i){
			 case 1:
			 	var _u = $('#cbo_user').val();
				if(_u==0){
					alert('Vui lòng chọn User');
					$('#cbo_user').focus();
					return;
				}
			 	document.forms.appFormGame.submit();
			 break;
			 case 2: //xóa user
				 c=confirm('bạn có muốn Remove những user này ra khỏi Group');
				if(c){
					document.forms.appFormRemove.submit();
				}
			 break;
			 default:
			 break;
		}
	}
</script>
