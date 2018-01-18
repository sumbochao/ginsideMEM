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
.group_left{
	width:100%;
}
.group_left .rows{
	margin-bottom:0;
}
.group_left label{
	width:200px;
}
.group_left .rows input[type='text']{
	width:500px;
}
.groupsignios{
	clear:both;
	float:left;
}
.header_toolbar{
	width:100%;
}
.scroolbar{
	width:1500px;
}
#adminfieldset.groupsignios {
    width: 100%;
}
.textinputplus{
	border:none !important;
}
.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
	vertical-align:top;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:1000px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
        <?php include_once 'include/toolbar.php'; ?>
        <form id="appForm" name="appForm" action="<?php echo base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&action=add"; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div id="adminfieldset" class="groupsignios" style="width:100%;">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <div class="rows">
                	<table class="table table-striped table-bordered table-condensed table-hover">
                    	<thead>
                            <th style="width:150px;">Tên nhóm</th>
                            <th style="width:150px;">Quyền</th>
                            <th></th> 
                		</thead>
                        <tbody>
                        <tr>
                        	
                        	<td style="vertical-align:top;">
                            <input type="text" name="group_name" id="group_name" class="textinput" value="<?php echo $_POST['group_name']; ?>" style="width:250px;" />
                            </td>
                            <td>
                            <input type="radio" name="chk_type" id="chk_create_items" value="1" checked="checked" /> -Tạo Items<br />
                            <input type="radio" name="chk_type" id="chk_approved_items" value="2" /> - Duyệt Items<br />
                            <input type="radio" name="chk_type" id="chk_public_items" value="3" /> - Public Items
                            </td>
                            <!--<td style="vertical-align:top;">
                             <input type="text" name="notes" id="notes" class="textinput" value="<?php echo $_POST['notes']; ?>" style="width:250px;" />
                            <textarea name="notes" id="notes" style="height:50px;width:600px"><?php echo $_POST['notes']; ?></textarea>
                            </td>-->
                            <td> <input type="button" name="btnadd" id="btnadd" value="Lưu lại" class="btnB btn-primary" onclick="checkempty();"/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
               
                <div class="rows">
                	<div id="mess" style="color:#F00;font-size:20px;font-weight:bold"><?php echo $Mess; ?></div>
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
      
            </form>
           
        
        </div> <!--content_form-->
        
       
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
         <!--<input type="text" name="txt_u" id="txt_u" placeholder="Nhập account" />
         <input type="button" name="btns" value="Tìm" class="btnB btn-primary" onclick="searchgroup();" />
         <strong id="kq"></strong>-->
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                	<!--<th align="center" width="80px">Chức năng</th>-->
                    <th align="center" width="80px">User</th>
                    <th align="center" width="80px">Nhóm</th>
                    <th align="center" width="70px">Quyền</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					$i=0;
                    if(count($listItems)>0){
                        foreach($listItems as $j=>$v){
							$i++;
                ?>
                <tr id="row_<?php echo $v['id'];?>" class="row_tab">
                	<!--<td>
                    <div style="float:left;width:95px;margin:0px;" id="divfunc">
                    <a href="javascript:void(0);" onclick="showhide(<?php echo $v['id'];?>);" id="edit_<?php echo $v['id'];?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url()?>assets/img/icon_edit.png"></a>
                    <a href="javascript:void(0);" onclick="updaterows(<?php echo $v['id'];?>,$('#names_e_<?php echo $v['id'];?>').val(),$('#notes_e_<?php echo $v['id'];?>').val())" title="Sửa" id="save_row_<?php echo $v['id'];?>" style="display:none;"><img border="0" width="16" height="16" title="Lưu" src="<?php echo base_url()?>assets/img/icon/save.png"></a>
                    <a href="javascript:void(0);" onclick="showhidei(<?php echo $v['id'];?>);" id="cancel_<?php echo $v['id'];?>" title="Hủy" style="display:none;"><img border="0" title="Hủy" src="<?php echo base_url()?>assets/img/icon/inactive.png"></a>
                    <a onclick="calljavascript(0,<?php echo $v['id'];?>);" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>  
                   
                    </div>
                    </td>-->
                    <td><a href="<?php echo base_url();?>?control=groupuser&func=userongroup&id_group=<?php echo $v['id'];?>" target="_blank" title="Xem user" style="color:#903;font-style:italic;">Add user</a> </td>
                    <td>
                    <input type="text" name="names_e_<?php echo $v['id'];?>" id="names_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['group_name'];?>" style="width:250px;" />
                   </td>
                   <td>
                    <input type="radio" name="chk_type_<?php echo $v['id'];?>" id="chk_create_items" value="1" <?php echo $v['type']==1?"checked":""; ?> /> -Tạo Items<br />
                            <input type="radio" name="chk_type_<?php echo $v['id'];?>" id="chk_approved_items" value="2" <?php echo $v['type']==2?"checked":""; ?> /> - Duyệt Items<br />
                            <input type="radio" name="chk_type_<?php echo $v['id'];?>" id="chk_public_items" value="3" <?php echo $v['type']==3?"checked":""; ?> /> - Public Items
                   </td>
                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </form>
         
            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
<script type="text/javascript" language="javascript">
function checkempty(){
	var _names=$('#group_name').val();
	if(_names==''){
		alert('Không bỏ trống !');
		$('#names').focus();
		return false;
	}
	document.getElementById('appForm').submit();
}
</script>
