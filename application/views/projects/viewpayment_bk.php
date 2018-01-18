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
	width:70%;
}
.scroolbar{
	width:1500px;
}
#tblsort tr td{
	text-align:left;
}
td .textinputplus{
	display:none;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar">
            <div class="scroolbar">
<a href="javascript:void(0);" onClick="$('#content-t').css('display','block');" style="text-decoration:none;">Tạo Payment</a>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px;display:none;">
        <?php include_once 'include/toolbar.php'; ?>
 		<!--<a href="javascript:void(0);" onclick="javaQ();">BundleID PackageName PackageIdentity</a>-->
        <form id="appForm" name="appForm" action="<?php echo base_url()."?control=projects&func=viewpayment&action=add"; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div id="adminfieldset" class="groupsignios">
            <div class="adminheader">Nhập thông tin Payment</div>
            <div class="group_left">
            	<div class="rows">
               			<label for="menu_group_id">Hình thức</label>
               			<select name="cbo_type" id="cbo_type" onchange="settypeapp(this.value);">
                            <!--<option value="inapp">InAppItem</option>-->
                            <option value="sms">SMS</option>
                            <option value="card">Card</option>
                            <option value="banking">Banking</option>
                            <option value="paymentindo">PaymnetIndo</option>
                        </select>
               </div>
            	<div class="rows">	
                    <label for="menu_group_id">Tên payment</label>
                    <input type="text" name="code" id="code" class="textinput" maxlength="200" value="" />             
                </div>
				<div class="rows">	
                    <label for="menu_group_id">VND Price</label>
                    <input type="text" name="vnd" id="vnd" class="textinput" value=""/>             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">MCOIN</label>
                    <input type="text" name="mcoin" id="mcoin" class="textinput" value=""/>             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">GEM</label>
                    <input type="text" name="gem" id="gem" class="textinput" value=""/>             
                </div>
                 <div class="rows">	
                    <label for="menu_group_id">Promotion GEM</label>
                    <input type="text" name="promotion_gem" id="promotion_gem" class="textinput" value=""/>             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" id="notes" role="5" cols="30" style="height:150px;width:500px"></textarea>
                </div>
                <div class="rows">	
                    <label for="menu_group_id"></label>
                   <label for="menu_group_id"></label>
                    <input type="button" name="btnadd" id="btnadd" value="Lưu lại" class="btnB btn-primary" onclick="checkempty();"/>
                   
                </div>
                <div class="rows">
                	<div id="mess" style="color:#F00;font-size:14px"><?php echo $error; ?></div>
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
      
            </form>
           
        
        </div> <!--content_form-->
        
       
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                	 <th align="left" width="50px">Chức năng</th>
                    <th align="left" width="50px">Type</th>
                    <th align="left" width="100px">Names</th>
                    <th align="left" width="100px">Vnd</th>
                    <th align="left" width="100px">Mcoin</th>
                    <th align="left" width="100px">Gem</th>
                     <th align="left" width="80px">Promotion Gem</th>
                    <th align="left" width="70px">Notes</th>
                   	<th align="left" width="70px">User</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					$i=0;
                    if(count($listData)>0){
                        foreach($listData as $j=>$v){
							$i++;
                ?>
                <tr id="row_<?php echo $v['id'];?>" class="row_tab">
                	<td>
                    <div style="float:left;width:80px;margin:0px;" id="divfunc">
                     <?php  if($_SESSION['account']['id_group']==2|| $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==64 || $_SESSION['account']['id_group']==61 || $_SESSION['account']['id_group']==71){ ?>
                    <!--<a href="<?php echo base_url(); ?>?control=projects&func=logupdate1&table=tbl_projects_property&id=<?php echo $v['id'];?>"  target="_blank" id="log_<?php echo $v['id'];?>" title="Log"><img border="0" width="16" height="16" title="Log" src="<?php echo base_url()?>assets/img/icon/log.jpg"></a>-->
                    <a href="javascript:void(0);" onclick="showhide(<?php echo $v['id'];?>);" id="edit_<?php echo $v['id'];?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url()?>assets/img/icon_edit.png"></a>
                    <a href="javascript:void(0);" onclick="updaterows(<?php echo $v['id'];?>,$('#code_e_<?php echo $v['id'];?>').val(),$('#promotion_gem_e_<?php echo $v['id'];?>').val(),$('#gem_e_<?php echo $v['id'];?>').val(),$('#mcoin_e_<?php echo $v['id'];?>').val(),$('#vnd_e_<?php echo $v['id'];?>').val(),$('#notes_e_<?php echo $v['id'];?>').val())" title="Sửa" id="save_row_<?php echo $v['id'];?>" style="display:none;"><img border="0" width="16" height="16" title="Lưu" src="<?php echo base_url()?>assets/img/icon/save.png"></a>
                    <a href="javascript:void(0);" onclick="showhidei(<?php echo $v['id'];?>);" id="cancel_<?php echo $v['id'];?>" title="Hủy" style="display:none;"><img border="0" title="Hủy" src="<?php echo base_url()?>assets/img/icon/inactive.png"></a>
                    <a onclick="deleteitem(<?php echo $v['id'];?>);" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>  
                    <?php }else{ echo "Không có quyền";} ?>
                    </div>
                    </td>
                    <td>
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['type'];?></div>
                    <input type="text" name="cbo_type_e_<?php echo $v['id'];?>" id="cbo_type_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['type'];?>" style="width:50px;" readonly="readonly" />
                   </td>
                   	
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['code'];?></div>
                    <input type="text" name="code_e_<?php echo $v['id'];?>" id="code_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['code'];?>" style="width:100px;" /></td>
                    
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['vnd'];?></div>
                    <input type="text" name="vnd_e_<?php echo $v['id'];?>" id="vnd_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['vnd'];?>" style="width:80px;" /></td>
                   
                 <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                 <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['mcoin'];?></div>
                 <input type="text" name="mcoin_e_<?php echo $v['id'];?>" id="mcoin_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['mcoin'];?>" style="width:80px;" /></td>
                 
                 <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                 <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['gem'];?></div>
                 <input type="text" name="gem_e_<?php echo $v['id'];?>" id="gem_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['gem'];?>"style="width:80px;" /></td>
                 
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['promotion_gem'];?></div>
                    <input type="text" name="promotion_gem_e_<?php echo $v['id'];?>" id="promotion_gem_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['promotion_gem'];?>" style="width:80px;" /></td>
                     
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['notes'];?></div> 
                    <!--<textarea name="notes_e_" id="notes_e_"><?php echo $v['notes'];?></textarea>-->
                    <input maxlength="1000" type="text" name="notes_e_<?php echo $v['id'];?>" id="notes_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['notes'];?>" /></td>
                    <td><?php echo $slbUser[$v['userlog']]['username'];?></td>
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
	var _code=$('#code').val();
	var _vnd=$('#vnd').val();
	var _gem=$('#gem').val();
	var _mcoin=$('#mcoin').val();
	var _promotion_gem=$('#promotion_gem').val();
			
	if(_code==''){
		alert('Không bỏ trống !');
		$('#code').focus();
		return false;
	}
	document.getElementById('appForm').submit();
}

function showbutton(){
	var _android=document.getElementById('chk_android').checked;
	var _ios=document.getElementById('chk_ios').checked;
	var _wp=document.getElementById('chk_wp').checked;
	if(_ios==false && _android == false && _wp == false){
		$('#btn_add').css('display','none');
	}
	if(_ios == true || _android == true || _wp == true){
		$('#btn_add').css('display','block');
	}
}
function updaterows(id,code_e,promotion_gem_e,gem_e,mcoin_e,vnd_e,notes_e){
	c=confirm('Bạn có muốn lưu không ?');
	if(c){
		if(code_e==''){
			alert('Không bỏ trống cột Names');
			return false;
		}
		$.ajax({
                url:baseUrl+'?control=projects&func=updaterowsinappitem',
                type:"GET",
				data:{id:id,code_e:code_e,promotion_gem_e:promotion_gem_e,gem_e:gem_e,mcoin_e:mcoin_e,vnd_e:vnd_e,notes_e:notes_e},
                async:false,
				dataType:"html",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(response){
                    if(response=='ok'){
						Lightboxt.showemsg('Thông báo','Đã lưu ...', 'Đóng');
						$('.row_tab').css('display','table-row');
						$('#save_row_'+id).css('display','none');
						$('#edit_'+id).css('display','block');
						$('#cancel_'+id).css('display','none');
						$('#log_'+id).css('display','block');
						$('.loading_warning').hide();
						//
						$('.cText').css('display','block');
						$('td .textinputplus').css('display','none');
					}else{
						Lightboxt.showemsg('Thông báo', response, 'Đóng');
						 $('.loading_warning').hide();
					}
                }
            });
		return true;
	}else{
		$('#save_row_'+id).css('display','none');
		$('#edit_'+id).css('display','block');
		$('.row_tab').css('display','table-row');
		$('.loading_warning').hide();
		return false;
	}
}
function showhidei(id){
	$('#divfunc a').css('margin-left','10px');
	$('#divfunc a').css('float','left');
	
	$('#save_row_'+id).css('display','none');
	$('#cancel_'+id).css('display','none');
	$('#edit_'+id).css('display','table-row');
	$('.row_tab').css('display','table-row');
	$('#log_'+id).css('display','table-row');
	//
	$('#cbo_platform_e_text_'+id).css('display','block');
	$('#cbo_platform_e_'+id).css('display','none');
	//
	$('.cText').css('display','block');
	$('td .textinputplus').css('display','none');
}
function showhide(id){
	
	
	$('#divfunc a').css('margin-left','10px');
	$('#divfunc a').css('float','left');
	
	$('#save_row_'+id).css('display','table-row');
	$('#cancel_'+id).css('display','table-row');
	$('#edit_'+id).css('display','none');
	$('.row_tab').css('display','none');
	$('#row_'+id).css('display','table-row');
	$('#log_'+id).css('display','none');
	//
	$('#cbo_platform_e_text_'+id).css('display','none');
	$('#cbo_platform_e_'+id).css('display','block');
	//
	$('.cText').css('display','none');
	$('td .textinputplus').css('display','block');
}
function deleteitem(id){
	c=confirm('Bạn có muốn xóa không ?');
	if(c){
			$.ajax({
					url:baseUrl+'?control=projects&func=deletelistinappitem',
					type:"GET",
					data:{id:id},
					async:false,
					dataType:"json",
					beforeSend:function(){
						$('.loading_warning').show();
					},
					success:function(f){
						if(f.error==0){
							window.location.href='<?php echo base_url();?>?control=projects&func=viewpayment';
							$('.loading_warning').hide();
						}else{
							Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
							$('.loading_warning').hide();
						}
					}
				});
		return true;
	}else{
		return false;
	}
}
</script>
