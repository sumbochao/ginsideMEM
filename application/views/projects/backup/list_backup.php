<style>
.textinputplus{
	border:none !important;
}
</style>
<div id="delok">
<div id="pages" style="margin-top:15px;float:left;">
<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="BundleID or PackageName ..." title="BundleID or PackageName ..." maxlength="100" style="width:250px;"/>
<input type="button" name="btnsearch" id="search" value="Tìm" class="btnB btn-primary" onclick="loadlistproperty1(<?php echo $_GET['id_project'] ?>,0,$('#keyword').val());" /> &nbsp;&nbsp; 
<?php echo $pages; ?>
</div>
<form name="frm" id="frm" enctype="multipart/form-data" method="post">
<table style="float:left;" width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                	 <th align="center" width="130px">Chức năng</th>
                    <th align="center" width="50px">STT</th>
                    <!--<th align="center" width="50px">ID</th>-->
                    <th align="center" width="80px">Platform</th>
                   <!-- <th align="center" width="80px">AppID/SenderID</th>-->
                     <th align="center" width="100px">BundleID or PackageName</th> 
                    <!-- <th align="center" width="100px">Version Type</th>-->
                    <th align="center" width="100px">Public Key</th>
                    <!--<th align="center" width="70px">InApp Product</th>-->
                    <th align="center" width="100px">Appstore In-App Items</th>
                    <th align="center" width="100px">GP In-App Items</th>
                    <th align="center" width="70px">Notes</th>
                   
                    
                </tr>
            </thead>
            <tbody>
                <?php
				$i=0;
                    if(count($list)>0){
                        foreach($list as $i=>$v){
							$i++;
                ?>
                <tr id="row_<?php echo $v['id'];?>" class="row_tab">
                	<td>
                    <div style="float:left;width:125px;margin:10px;" id="divfunc">
                     <?php  if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){ ?>
                    <a href="<?php echo base_url(); ?>?control=projects&func=logupdate1&table=tbl_projects_property&id=<?php echo $v['id'];?>"  target="_blank" id="log_<?php echo $v['id'];?>" title="Log"><img border="0" width="16" height="16" title="Log" src="<?php echo base_url()?>assets/img/icon/log.jpg"></a>
                    <a href="javascript:void(0);" onclick="showhide(<?php echo $v['id'];?>);" id="edit_<?php echo $v['id'];?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url()?>assets/img/icon_edit.png"></a>
                    <a href="javascript:void(0);" onclick="updaterows(<?php echo $v['id'];?>,$('#cbo_platform_e_<?php echo $v['id'];?>').val(),$('#app_id_e_<?php echo $v['id'];?>').val(),$('#package_name_e_<?php echo $v['id'];?>').val(),$('#version_type_e_<?php echo $v['id'];?>').val(),$('#public_key_e_<?php echo $v['id'];?>').val(),$('#inapp_product_e_<?php echo $v['id'];?>').val(),$('#notes_p_e_<?php echo $v['id'];?>').val())" title="Sửa" id="save_row_<?php echo $v['id'];?>" style="display:none;"><img border="0" width="16" height="16" title="Lưu" src="<?php echo base_url()?>assets/img/icon/save.png"></a>
                    <a href="javascript:void(0);" onclick="showhidei(<?php echo $v['id'];?>);" id="cancel_<?php echo $v['id'];?>" title="Hủy" style="display:none;"><img border="0" title="Hủy" src="<?php echo base_url()?>assets/img/icon/inactive.png"></a>
                    <a onclick="deleteitem(<?php echo $v['id'];?>,<?php echo $v['id_projects'];?>);" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>  
                    <?php }else{ echo "Không có quyền";} ?>
                    </div>
                    </td>
                    <td><?php echo $i;?></td>
                    <!--<td><?php echo $v['id'];?></td>-->
                    <td>
                    <input type="text" name="cbo_platform_e_text_<?php echo $v['id'];?>" id="cbo_platform_e_text_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['platform'];?>" style="width:80px;" readonly="readonly" />
                    <select name="cbo_platform_e_<?php echo $v['id'];?>" id="cbo_platform_e_<?php echo $v['id'];?>" style="width:70px;display:none;">
 							<option value="ios" <?php echo $v['platform']=="ios"?"selected":"";?>>ios</option>
                            <option value="android" <?php echo $v['platform']=="android"?"selected":"";?>>android</option>
                            <option value="wp" <?php echo $v['platform']=="wp"?"selected":"";?>>wp</option>
                        </select></td>
                    <!--<td><input type="text" name="app_id_e_<?php echo $v['id'];?>" id="app_id_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['app_id'];?>" maxlength="1000" /></td>-->
                    <td><input type="text" name="package_name_e_<?php echo $v['id'];?>" id="package_name_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['package_name'];?>" maxlength="1000" /></td>
                    <!--<td><input type="text" name="version_type_e_<?php echo $v['id'];?>" id="version_type_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['version_type'];?>" maxlength="1000" /></td>-->
                    <td><input type="text" name="public_key_e_<?php echo $v['id'];?>" id="public_key_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['public_key'];?>" maxlength="1000" /></td>
                    <!--<td><input type="text" name="inapp_product_e_<?php echo $v['id'];?>" id="inapp_product_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['inapp_product'];?>" maxlength="1000" /></td>-->
                    <td><input type="text" name="appstore_inapp_items_e_<?php echo $v['id'];?>" id="appstore_inapp_items_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['appstore_inapp_items'];?>" /></td>
                    <td><input type="text" name="gp_inapp_items_e_<?php echo $v['id'];?>" id="gp_inapp_items_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['gp_inapp_items'];?>" /></td>
                    
                    <td><input maxlength="1000" type="text" name="notes_p_e_<?php echo $v['id'];?>" id="notes_p_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['notes'];?>" /></td>
                    
                    
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
 </div>
 
<script language="javascript">
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
}
function updaterows(id,cbo_platform_e,app_id_e,package_name_e,version_type_e,public_key_e,inapp_product_e,notes_p_e){
	c=confirm('Bạn có muốn lưu không ?');
	if(c){
		$.ajax({
                url:baseUrl+'?control=projects&func=updaterowsitem',
                type:"GET",
                data:{id:id,cbo_platform_e:cbo_platform_e,app_id_e:app_id_e,package_name_e:package_name_e,version_type_e:version_type_e,public_key_e:public_key_e,inapp_product_e:inapp_product_e,notes_p_e:notes_p_e},
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
function deleteitem(id,id_projects){
	c=confirm('Bạn có muốn xóa không ?');
	if(c){
		$.ajax({
                url:baseUrl+'?control=projects&func=deletelist',
                type:"GET",
                data:{id:id},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
                  		$('.loading_warning').hide();
						loadlistproperty1(id_projects,0,'');
						
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

function loadlistproperty1(id_project,pages,searchfillter){
			$.ajax({
                url:baseUrl+'?control=projects&func=loadlistplus&page='+pages,
                type:"GET",
                data:{id_project:id_project,fillter:searchfillter},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    //$('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
						 $("#delok").html(f.html);
						 //$('.loading_warning').hide();
                    }else{
						$("#delok").html(f.html);
                        //$('.loading_warning').hide();
                    }
                }
            });
	};
</script>