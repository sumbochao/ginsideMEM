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
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1000px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
        <?php //include_once 'include/toolbar.php'; ?>
        <form id="appForm" name="appForm" action="<?php echo base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&action=add"; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div id="adminfieldset" class="groupsignios" style="width:106%;">
            <div class="adminheader">Tạo Template</div>
            <div class="group_left">
            	 <div class="rows">	
                    <label for="menu_group_id">Tên template</label>
                    <input type="text" name="template_name" id="template_name" class="textinput" style="width:500px;" value="<?php echo $_POST['template_name']; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Notes</label>
                    <input type="text" name="notes" id="notes" class="textinput" style="width:500px;" value="<?php echo $_POST['notes']; ?>"/>
                </div>
                <div class="rows">
                <input type="button" name="btnadd" id="btnadd" value="Lưu lại" class="btnB btn-primary" onclick="checkempty();"/>
                </div>
               
                <div class="rows">
                	<div id="mess" style="color:#090;font-size:20px;font-weight:bold">
					<?php echo isset($_GET['mess'])?base64_decode($_GET['mess']):$Mess; ?>
                    </div>
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
      
            </form>
           
        
        </div> <!--content_form-->
        
       
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                	<th align="center" width="80px">Chức năng</th>
                    <th align="center" width="180px">Game</th>
                     <th align="center" width="180px">Hạng mục</th>
                    <th align="center" width="80px">Template</th>
                    <th align="center" width="70px">Notes</th>
                    <th align="center" width="160px">Date</th>
                   	<th align="center" width="70px">User</th>
                     <th align="center" width="70px">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
					$i=0;
                    if(count($listItems)>0 && $listItems!= NULL){
                        foreach($listItems as $j=>$v){
							$i++;
                ?>
                <tr id="row_<?php echo $v['id'];?>" class="row_tab">
                	<td>
                    <div style="float:left;width:95px;margin:0px;" id="divfunc">
                    <a href="javascript:void(0);" onclick="showhide(<?php echo $v['id'];?>);" id="edit_<?php echo $v['id'];?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url()?>assets/img/icon_edit.png"></a>
                    <a href="javascript:void(0);" onclick="updaterows(<?php echo $v['id'];?>,$('#template_name_e_<?php echo $v['id'];?>').val(),$('#notes_e_<?php echo $v['id'];?>').val())" title="Sửa" id="save_row_<?php echo $v['id'];?>" style="display:none;"><img border="0" width="16" height="16" title="Lưu" src="<?php echo base_url()?>assets/img/icon/save.png"></a>
                    <a href="javascript:void(0);" onclick="showhidei(<?php echo $v['id'];?>);" id="cancel_<?php echo $v['id'];?>" title="Hủy" style="display:none;"><img border="0" title="Hủy" src="<?php echo base_url()?>assets/img/icon/inactive.png"></a>
                    <a onclick="calljavascript(0,<?php echo $v['id'];?>);" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>  
                   
                    </div>
                    </td>
                    <td><a href="<?php echo base_url()."?control=templatechecklist&func=index&id_template=".$v['id']; ?>" title="Khai báo">Add game</a></td>
                    <td><a href="<?php echo base_url()."?control=categories&func=index&id_template=".$v['id']; ?>" title="Khai báo">Xem</a></td>
                    <td>
                    <input type="text" name="template_name_e_<?php echo $v['id'];?>" id="template_name_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['template_name'];?>" style="width:300px;" />
                   </td>
                    <td>
                    <input type="text" name="notes_e_<?php echo $v['id'];?>" id="notes_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['notes'];?>" style="width:300px;" /></td>
                    <td><?php echo $v['datecreate'];?></td>
                    <td><?php echo $slbUser[$v['userlog']]['username'];?></td>
                    <td>
                    <div id="divstatus_<?php echo $v['id'] ?>">
                    <a href="javascript:void(0)" onclick="UpStatusCate(<?php echo $v['id'] ?>,<?php echo $v['status']; ?>);"><?php echo $v['status']==0?"<strong style='color:green'>On</strong>":"<strong style='color:red'>Off</strong>";?></a>
                    </div>
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
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_template.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function UpStatusCate(id,status){
	$.ajax({
			url:baseUrl+'?control=template&func=updatestatus',
			type:"GET",
			data:{id:id,status:status},
			async:false,
			dataType:"json",
			beforeSend:function(){
				$('.loading_warning').show();
			},
			success:function(f){
				if(f.error==0){
					$('#divstatus_'+id).html(f.html);
					$('.loading_warning').hide();
				}else{
					$('#divstatus_' + id).html(f.html);
					$('.loading_warning').hide();
				}
			}
		});
}
function calljavascript(i,id){
		switch(i){
			 case 0: // xóa
			 	deleteitem(id,'<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>')
			 
			 break;
			 default:
			 break;
		}
	}
</script>
