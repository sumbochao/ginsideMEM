<!--fancybox-->
<script src="<?php echo base_url('assets/fancybox/lib/jquery-1.10.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/source/jquery.fancybox.js?v=2.1.5'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/jquery.fancybox.css?v=2.1.5'); ?>" type="text/css" media="screen"/>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5'); ?>" type="text/css" media="screen"/>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7'); ?>" type="text/css" media="screen"/>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6'); ?>"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$(".various").fancybox({
				title:'In App Items',
				maxWidth	: 800,
				maxHeight	: 400,
				fitToView	: false,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
			$(".various_apn").fancybox({
				title:'APN Certificates',
				maxWidth	: 500,
				maxHeight	: 200,
				fitToView	: false,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
	</script>
<!--end fancybox-->
<style>
.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
}

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
                    <th style="display:none"></th>
                    <th style="display:none"></th>
                    <th align="center" width="80px"><select name="cbofp" id="cbofp" onchange="setrowsplatform(this.value);" style="width:80px">
                        <option value="all">Platform</option>
                        <option value="ios">IOS</option>
                        <option value="android">Android</option>
                        <option value="wp">WinPhone</option>
                    </select></th>
                    <th align="center" width="100px">BundleID/PackageName/PackageIdentity</th>
                    <th align="center" width="50px" class="ios">Loại</th>
                    <th align="center" width="80px" class="wp_ios">Apple ID</th>
                    <th align="center" width="100px">In-App Items</th>
                     <th align="center" width="100px" class="android">Public Key</th>
                    <th align="center" width="100px" class="wp">Wp(Publisher)</th>
                    <th align="center" width="100px" class="wp">Wp(Properties)</th>
                     <th align="center" width="100px" class="ios">APN Certificates</th>
                     <th align="center" width="100px" class="ios">APN Password</th>
                     <th align="center" width="100px">API Key G+</th>
                     <th align="center" width="100px">Client ID G+</th>
                     <th align="center" width="100px" class="wp">Client Secret G+</th>
                     <th align="center" width="100px" class="ios">Url Scheme G+</th>
					 <th align="center" width="70px">Facebook AppID</th>
                     <th align="center" width="70px">Facebook AppSecret</th>
                     <th align="center" width="70px">Facebook Schemes</th>
                    <th align="center" width="70px">Notes</th>
                    <th align="center" width="70px">User</th>
                   
                    
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
                     <?php  if($_SESSION['account']['id_group']==2|| $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==64 || $_SESSION['account']['id_group']==61 || $_SESSION['account']['id_group']==71 || $_SESSION['account']['id_group']==69 || $_SESSION['account']['id_group']==80 || $_SESSION['account']['id_group']==72){ ?>
                    <a href="<?php echo base_url(); ?>?control=projects&func=logupdate1&table=tbl_projects_property&id=<?php echo $v['id'];?>"  target="_blank" id="log_<?php echo $v['id'];?>" title="Log"><img border="0" width="16" height="16" title="Log" src="<?php echo base_url()?>assets/img/icon/log.jpg"></a>
                    <a href="javascript:void(0);" onclick="showhide(<?php echo $v['id'];?>);" id="edit_<?php echo $v['id'];?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url()?>assets/img/icon_edit.png"></a>
                    <a href="javascript:void(0);" onclick="updaterows(<?php echo $v['id_projects'];?>,<?php echo $v['id'];?>,$('#cbo_platform_e_<?php echo $v['id'];?>').val(),$('#package_name_e_<?php echo $v['id'];?>').val(),$('#public_key_e_<?php echo $v['id'];?>').val(),$('#inapp_items_e_<?php echo $v['id'];?>').val(),$('#wp_p1_e_<?php echo $v['id'];?>').val(),$('#wp_p2_e_<?php echo $v['id'];?>').val(),$('#notes_p_e_<?php echo $v['id'];?>').val(),$('#pass_certificates_e_<?php echo $v['id'];?>').val(),$('#api_key_e_<?php echo $v['id'];?>').val(),$('#client_key_e_<?php echo $v['id'];?>').val(),$('#url_scheme_e_<?php echo $v['id'];?>').val(),$('#client_secret_e_<?php echo $v['id'];?>').val(),$('#app_id_e_<?php echo $v['id'];?>').val(),$('#cbo_cert_name_e_<?php echo $v['id'];?>').val(),$('#fb_appid_e_<?php echo $v['id'];?>').val(),$('#fb_appsecret_e_<?php echo $v['id'];?>').val(),$('#fb_schemes_e_<?php echo $v['id'];?>').val())" title="Sửa" id="save_row_<?php echo $v['id'];?>" style="display:none;"><img border="0" width="16" height="16" title="Lưu" src="<?php echo base_url()?>assets/img/icon/save.png"></a>
                    <a href="javascript:void(0);" onclick="showhidei(<?php echo $v['id'];?>);setinterface('na');" id="cancel_<?php echo $v['id'];?>" title="Hủy" style="display:none;"><img border="0" title="Hủy" src="<?php echo base_url()?>assets/img/icon/inactive.png"></a>
                    <a onclick="deleteitem(<?php echo $v['id'];?>,<?php echo $v['id_projects'];?>);" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>  
                    <?php }else{ echo "Không có quyền";} ?>
                    </div>
                    </td>
                    <td><?php echo $i;?></td>
                    <td style="display:none"><?php echo $v['platform'];?></td>
                    <td style="display:none"><?php echo $v['id'];?></td>
                    <td>
                    <input type="text" name="cbo_platform_e_text_<?php echo $v['id'];?>" id="cbo_platform_e_text_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['platform'];?>" style="width:80px;" readonly="readonly" />
                    <select name="cbo_platform_e_<?php echo $v['id'];?>" id="cbo_platform_e_<?php echo $v['id'];?>" style="width:70px;display:none;" onchange="setinterface(this.value);" disabled="disabled">
 							<option value="ios" <?php echo $v['platform']=="ios"?"selected":"";?>>ios</option>
                            <option value="android" <?php echo $v['platform']=="android"?"selected":"";?>>android</option>
                            <option value="wp" <?php echo $v['platform']=="wp"?"selected":"";?>>wp</option>
                        </select></td>
                 
                    <td><input type="text" name="package_name_e_<?php echo $v['id'];?>" id="package_name_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['package_name'];?>" maxlength="1000" onkeyup="checkbundleisexit1(<?php echo $v['id'];?>,<?php echo $v['platform']; ?>,this.value,'package_name_e_<?php echo $v['id'];?>');" /></td>
                    <td class="ios">
                    <?php if($v['platform']=="ios"){ ?>
                    <input type="text" name="cbo_cert_name_e_text_<?php echo $v['id'];?>" id="cbo_cert_name_e_text_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['cert_name'];?>" style="width:80px;" readonly="readonly" />
                    <select name="cbo_cert_name_e_<?php echo $v['id'];?>" id="cbo_cert_name_e_<?php echo $v['id'];?>" data-placeholder="Chọn loại" style="width:130px;display:none;">
                        <option value="Appstore" <?php echo $v['cert_name']=="Appstore"?"selected":""?>>Appstore</option>
                        <option value="Inhouse" <?php echo $v['cert_name']=="Inhouse"?"selected":""?>>Inhouse</option>
                    </select>
                    <?php } ?>
                    </td>
                   
                    <td class="wp_ios"><input type="text" name="app_id_e_<?php echo $v['id'];?>" id="app_id_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['app_id'];?>" maxlength="1000" /></td>
                   <td>
                   	<a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=projects&func=popupinapp&id_projects=<?php echo $v['id_projects'];?>&id_projects_property=<?php echo $v['id'];?>" style="color:#930;">XemNhanh</a>
                    <!--<a href="<?php echo base_url(); ?>?control=projects&func=paymentlist&id_projects=<?php echo $v['id_projects'];?>&id_projects_property=<?php echo $v['id'];?>&info_package=<?php echo $v['package_name']; ?>" target="_blank">Chỉnh sửa</a> -->
                    <!--<a href="javascript:void(0);" onclick="popitup('<?php echo base_url(); ?>?control=projects&func=popupinapp&id_projects=<?php echo $v['id_projects'];?>&id_projects_property=<?php echo $v['id'];?>','Open');">Xem InApp</a>-->
                   <input type="hidden" name="inapp_items_e_<?php echo $v['id'];?>" id="inapp_items_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['inapp_items'];?>" />
                   </td>
                    <td class="android"><input type="text" name="public_key_e_<?php echo $v['id'];?>" id="public_key_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['public_key'];?>" maxlength="1000" /></td>
                    <td class="wp"><input type="text" name="wp_p1_e_<?php echo $v['id'];?>" id="wp_p1_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['wp_p1'];?>" /></td>
                    <td class="wp"><input type="text" name="wp_p2_e_<?php echo $v['id'];?>" id="wp_p2_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['wp_p2'];?>" /></td>
                    <td class="ios">
                    <?php 
					if($_SESSION['account']['id_group']==2|| $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==68 || $_SESSION['account']['id_group']==64 || $_SESSION['account']['id_group']==61 || $_SESSION['account']['id_group']==71 || $_SESSION['account']['id_group']==69 || $_SESSION['account']['id_group']==80 || $_SESSION['account']['id_group']==72){
					if($v['platform']=="ios"){
						if($v['files_certificates']!="files/certificates/" && $v['files_certificates']!=""){
							$filename=explode("/",$v['files_certificates']);
					 ?>
                    <a href="<?php echo base_url().$v['files_certificates'];?>"><?php echo $filename[2]; ?></a> / 
                    <a style="color:#900" class="various_apn" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=projects&func=updatefiles&id=<?php echo $v['id'];?>&filename=<?php echo $v['files_certificates'] ?>">Cập nhật file</a>
                    <?php }else{ ?>
                     <a style="color:#900" class="various_apn" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=projects&func=updatefiles&id=<?php echo $v['id'];?>&filename=<?php echo $v['files_certificates'] ?>">Thêm file</a>
                    <?php }//end if ?>
                    <?php
						}//end if platform
					}//end if permission
					?>
                    </td>
                    <td class="ios"><input type="text" name="pass_certificates_e_<?php echo $v['id'];?>" id="pass_certificates_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['pass_certificates'];?>" /></td>
                    <td><input type="text" name="api_key_e_<?php echo $v['id'];?>" id="api_key_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['api_key'];?>" /></td>
                    <td><input type="text" name="client_key_e_<?php echo $v['id'];?>" id="client_key_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['client_key'];?>" /></td>
                    <td class="wp"><input type="text" name="client_secret_e_<?php echo $v['id'];?>" id="client_secret_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['client_secret'];?>" /></td>
                    <td class="ios"><input type="text" name="url_scheme_e_<?php echo $v['id'];?>" id="url_scheme_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['url_scheme'];?>" /></td>
                    <td><input type="text" name="fb_appid_e_<?php echo $v['id'];?>" id="fb_appid_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['fb_appid'];?>" /></td>
                    <td><input type="text" name="fb_appsecret_e_<?php echo $v['id'];?>" id="fb_appsecret_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['fb_appsecret'];?>" /></td>
                    <td><input type="text" name="fb_schemes_e_<?php echo $v['id'];?>" id="fb_schemes_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['fb_schemes'];?>" /></td>
					<td><input maxlength="1000000" type="text" name="notes_p_e_<?php echo $v['id'];?>" id="notes_p_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['notes'];?>" /></td>
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
 </div>
 
<script language="javascript">
function setinterface(platform){
	//thiet lap control theo platform
	$('.android').css('display','none');
	$('.wp').css('display','none');
	$('.ios').css('display','none');
	switch(platform){
		case 'ios':
			$('.android').css('display','none');
			$('.wp').css('display','none');
			$('.ios').css('display','table-cell');
			$('.wp_ios').css('display','table-cell');
		break;
		case 'android':
			$('.android').css('display','table-cell');
			$('.wp').css('display','none');
			$('.ios').css('display','none');
			$('.wp_ios').css('display','none');
		break;
		case 'wp':
			$('.android').css('display','none');
			$('.wp').css('display','table-cell');
			$('.ios').css('display','none');
			$('.wp_ios').css('display','table-cell');
		break;
		default:
			$('.android').css('display','table-cell');
			$('.wp').css('display','table-cell');
			$('.ios').css('display','table-cell');
			$('.wp_ios').css('display','table-cell');
		break;
	}
}
function popitup(url,windowName) {
		var left = (screen.width/2)-(500/2);
  		var top = (screen.height/2)-(400/2);
       newwindow=window.open(url,windowName,'height=400,width=500,menubar=no,scrollbars=no, resizable=no,toolbar=no,location=no, directories=no, status=no, menubar=no,top='+top+', left='+left);
       if (window.focus) {newwindow.focus()}
       return false;
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
	$('#cbo_platform_e_'+id).val($('#cbo_platform_e_text_'+id).val());
	
	//
	$('#cbo_cert_name_e_text_'+id).css('display','none');
	$('#cbo_cert_name_e_'+id).css('display','block');
	$('#cbo_cert_name_e_'+id).val($('#cbo_cert_name_e_text_'+id).val());
	//setinterface($('#cbo_cert_name_e_'+id).val());
	setinterface($('#cbo_platform_e_'+id).val());
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
	$('#cbo_cert_name_e_text_'+id).css('display','block');
	$('#cbo_cert_name_e_'+id).css('display','none');
	
}
function updaterows(id_projects,id,cbo_platform_e,package_name_e,public_key_e,inapp_items_e,wp_p1_e,wp_p2_e,notes_p_e,pass_certificates_e,api_key_e,client_key_e,url_scheme_e,client_secret_e,app_id,cert_name,fb_appid,fb_appsecret,fb_schemes){
	if(package_name_e==''){
		alert('Không bỏ trống giá trị Bundle/Package');
		return false;
	}
	c=confirm('Bạn có muốn lưu không ?');
	if(c){
		$.ajax({
                url:baseUrl+'?control=projects&func=updaterowsitem',
                type:"GET",
				data:{id:id,cbo_platform_e:cbo_platform_e,package_name_e:package_name_e,public_key_e:public_key_e,inapp_items_e:inapp_items_e,wp_p1_e:wp_p1_e,wp_p2_e:wp_p2_e,notes_p_e:notes_p_e,pass_certificates_e:pass_certificates_e,api_key_e:api_key_e,client_key_e:client_key_e,url_scheme_e:url_scheme_e,client_secret_e:client_secret_e,app_id_e:app_id,cert_name:cert_name,id_projects:id_projects,fb_appid:fb_appid,fb_appsecret:fb_appsecret,fb_schemes:fb_schemes},
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
						$('.android').css('display','table-cell');
						$('.wp').css('display','table-cell');
						$('.ios').css('display','table-cell');
						//
						$('#cbo_cert_name_e_text_' + id).css('display','table-cell');
						$('#cbo_cert_name_e_'+ id).css('display','none');
						$('#cbo_platform_e_text_' + id).css('display','table-cell');
						$('#cbo_platform_e_' + id).css('display','none');
						$('#cbo_cert_name_e_text_'+id).val($('#cbo_cert_name_e_'+id).val());
						
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
function payment(id_projects,id_projects_property){
	var _flag=true;
	$.ajax({
                url:baseUrl+'?control=projects&func=checkpayment',
                type:"GET",
                data:{id_projects:id_projects,id_projects_property:id_projects_property},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    //$('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
                  		c=confirm('Dữ liệu này đang có các hình thức Payment.Bạn có muốn xóa không ?');
						if(c){
							//$('.loading_warning').hide();
							_flag=true;
						}else{
							//$('.loading_warning').hide();
							_flag=false;
						}
						
                    }else{
						//$('.loading_warning').hide();
                        _flag=true;
                    }
                }
            });
   return _flag;
}
function deleteitem(id,id_projects){
	c=confirm('Bạn có muốn xóa không ?');
	if(c){
		//truoc khi xoa Bundle,Packege, kiem tra xem co payment khong
		var _f=payment(id_projects,id);
		if(_f){
			$.ajax({
					url:baseUrl+'?control=projects&func=deletelist',
					type:"GET",
					data:{id:id,id_projects:id_projects},
					async:false,
					dataType:"json",
					beforeSend:function(){
						$('.loading_warning').show();
					},
					success:function(f){
						if(f.error==0){
							//loadlistproperty1(id_projects,0,'');
							window.location.href='<?php echo base_url();?>?control=projects&func=edit&id=<?php echo $_GET['id_project'];?>';
							$('.loading_warning').hide();
						}else{
							Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
							$('.loading_warning').hide();
						}
					}
				});
		}//end if
		return true;
	}else{
		return false;
	}
}
//kiểm tra Bundle/Package đã tồn tại hay chưa
	function checkbundleisexit1(id,_platform,_values,_idcontrol){
		_isok=true;
		_types='edit';
		try{
			$.ajax({
				url:baseUrl+'?control=projects&func=checkbundleisexit',
				type:'GET',
				data:{id:id,platform:_platform,values:_values,types:_types},
				async:false,
                dataType:"json",
                success:function(f){
                    if(f.error==0){
						_isok=false;
						alert('Giá trị này đã tồn tại.Vui lòng nhập giá trị khác');
						$('#'+_idcontrol).val('');
						$('#'+_idcontrol).focus();
                    }else{
                       _isok=true;
                    }
                }
			});
		}catch(e){
			_isok=false;
		}
		return _isok;
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
function setrowsplatform(_val){
	var t = document.getElementById('tblsort');
	var rows = t.rows;
	var sval=_val;
	for (var i=0; i<rows.length; i++) {
		 var cells = rows[i].cells; 
		 var f1 = cells[2].innerHTML;
		 var id = cells[3].innerHTML;
		 $('#row_'+id).css('display','table-row');
		 if(f1 != sval){
			$('#row_'+id).css('display','none');
		 }
		 if(_val=='all'){
			$('.row_tab').css('display','table-row');
			
		 }
    }
}
</script>
