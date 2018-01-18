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
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar">
            <div class="scroolbar">
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
        <?php include_once 'include/toolbar.php'; ?>
 		<!--<a href="javascript:void(0);" onclick="javaQ();">BundleID PackageName PackageIdentity</a>-->
        <form id="appForm1" name="appForm1" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div id="adminfieldset" class="groupsignios">
            <div class="adminheader">Nhập thông tin chung</div>
            <div class="group_left">
            	<div class="rows">	
                    <label for="menu_group_id">Mã dự án</label>
                    <input type="text" name="code" id="code" class="textinput" maxlength="200" value="<?php echo $getitem['code'] ?>" readonly="readonly" />             
                </div>
				<div class="rows">	
                    <label for="menu_group_id">Tên Dự án</label>
                    <input type="text" name="names" id="names" class="textinput" value="<?php echo $getitem['names'] ?>"/>             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Tên cài đặt</label>
                    <input type="text" name="namesetup" id="namesetup" class="textinput" value="<?php echo $getitem['namesetup'] ?>"/>             
                </div>
                <div class="rows">
                	<label for="menu_group_id">Loại màn hình</label>
                	<select name="cbo_screens" id="cbo_screens" data-placeholder="Chọn loại màn hình" style="width:130px;">
                        <option value="landscape" <?php echo $getitem['screens']=="landscape"?"selected":""; ?> >Landscape</option>
                        <option value="portrait" <?php echo $getitem['screens']=="portrait"?"selected":""; ?>>Portrait</option>
                        <option value="both" <?php echo $getitem['screens']=="both"?"selected":""; ?>>Both</option>
                    </select>
                </div>
                <div class="rows">
                	<label for="menu_group_id">Cấu hình Logout</label>
                	<select name="cbo_config_logout" id="cbo_config_logout"  data-placeholder="Chọn Cấu hình Logout" style="width:130px;">
                        <option value="false" <?php echo $getitem['config_logout']=="false"?"selected":""; ?>>False</option>
                        <option value="true" <?php echo $getitem['config_logout']=="true"?"selected":""; ?>>True</option>
                    </select> (logout sdk thành công thì sẽ hiển thị form login của sdk)
                </div>
                <div class="rows">
                	<label for="menu_group_id">Default Language SDK</label>
                	<select name="cbo_language_sdk" id="cbo_language_sdk" data-placeholder="Default Language SDK" style="width:130px;">
                        <option value="vi" <?php echo $getitem['language_sdk']=="vi"?"selected":""; ?> >VI</option>
                        <option value="en" <?php echo $getitem['language_sdk']=="en"?"selected":""; ?> >EN</option>
                        <option value="device" <?php echo $getitem['language_sdk']=="device"?"selected":""; ?> >DEVICE</option>
                    </select>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Folder</label>
                    <input type="text" name="folder" id="folder" class="textinput" value="<?php echo $getitem['folder'] ?>"/>             
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       <div id="adminfieldset" class="groupsignios">
            <div class="adminheader">Thông tin Service API</div>
            <div class="group_left">
             	 <div class="rows">	
                    <label for="menu_group_id">Service Key App</label>
                    <?php if($_SESSION['account']['id_group']==2 || $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==68){ ?>
                    <input type="text" name="servicekeyapp" id="servicekeyapp" class="textinput" value="<?php echo $getitem['servicekeyapp'] ?>" /> 
                    <?php }else{ echo "*****************"; } ?>           
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Service Key</label>
                    <?php if($_SESSION['account']['id_group']==2 || $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==68){ ?>
                    <input type="text" name="servicekey" id="servicekey" class="textinput" value="<?php echo $getitem['servicekey'] ?>" />
                    <?php }else{ echo "*****************"; } ?>         
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Service Key Second</label>
                    <?php if($_SESSION['account']['id_group']==2 || $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==68){ ?>
                    <input type="text" name="servicekey_second" id="servicekey_second" class="textinput" value="<?php echo $getitem['servicekey_second']==""?$getitem['servicekey']:$getitem['servicekey_second'] ?>" />
                    <?php }else{ echo "*****************"; } ?>         
                </div>
         </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       <div id="adminfieldset" class="groupsignios" style="display:none;">
            <div class="adminheader">Tạo dự án Facebook App</div>
            <div class="group_left">
                <div class="rows" style="display:none;">	
                    <label for="menu_group_id">Facebook Apps</label>
                    <input type="text" name="facebookapp" id="facebookapp" class="textinput" value="<?php echo $getitem['facebookapp'] ?>" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">FacebookAppID</label>
                    <input type="text" name="facebookappid" id="facebookappid" class="textinput" value="<?php echo $getitem['facebookappid'] ?>" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook AppSecret</label>
                    <input type="text" name="facebookappsecret" id="facebookappsecret" class="textinput" value="<?php echo $getitem['facebookappsecret'] ?>" />             
                </div>
         </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       <div id="adminfieldset" class="groupsignios" style="display:none;">
    <div class="adminheader">Tạo dự án trên itunes connect</div>
    <div class="group_left">
                <div class="rows" style="display:none;">	
                    <label for="menu_group_id">IOS trên Itunesconnect</label>
                    <input type="text" name="itunesconnect" id="itunesconnect" class="textinput" value="<?php echo $getitem['itunesconnect'] ?>" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">AppleID</label>
                    <input type="text" name="appleid" id="appleid" class="textinput" value="<?php echo $getitem['appleid'] ?>" />             
                </div>
    </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       
  <div id="adminfieldset" class="groupsignios">
    <div class="adminheader">Tạo chỉ số Marketing</div>
    <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">GA Code</label>
                    <input type="text" name="gacode" id="gacode" class="textinput" value="<?php echo $getitem['gacode'] ?>" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Appsflyer ID</label>
                    <input type="text" name="appsflyerid" id="appsflyerid" class="textinput" value="<?php echo $getitem['appsflyerid'] ?>" />             
                </div>
                <div class="rows" style="padding-top:20px;padding-bottom:20px;">	
                    <label for="menu_group_id" style="width:330px;">Google AdWords Conversion Tracking Code IOS</label>
                    <input type="hidden" name="googleproductapi" id="googleproductapi" value="<?php echo $getitem['googleproductapi'] ?>" />
                    <!--<textarea name="googleproductapi" id="googleproductapi" role="5" cols="30" style="height:150px;width:500px"><?php echo $getitem['googleproductapi'] ?></textarea>-->
                    <div class="rows_child" style="padding-left:205px;">
                    <?php
						$google=$getitem['googleproductapi']!=""?$getitem['googleproductapi']:"";
						$GoogleProductApi=explode(";",$google);
					?>
                     	<table>
                        	<tr>
                            	<td>ReportWithConversionID</td>
                                <td><input type="text" name="ReportWithConversionID" id="ReportWithConversionID" class="textinput" style="width:336px;" value="<?php echo $GoogleProductApi[0]; ?>" /></td>
                            </tr>
                            <tr>
                            	<td>Label</td>
                                <td><input type="text" name="label" id="label" class="textinput" style="width:336px;" value="<?php echo $GoogleProductApi[1]; ?>" /></td>
                            </tr>
                            <tr>
                            	<td>Value</td>
                                <td><input type="text" name="value" id="value" class="textinput" style="width:336px;" value="<?php echo $GoogleProductApi[2]; ?>"  /></td>
                            </tr>
                            <tr>
                            	<td>IsRepeatable</td>
                                <td><input type="text" name="isRepeatable" id="isRepeatable" class="textinput" style="width:336px;" value="<?php echo $GoogleProductApi[3]; ?>"  /></td>
                            </tr>
                        </table>
                     </div>       
                </div>
                <div class="rows">	
                    <label for="menu_group_id">URL Schemes</label>
                    <input type="text" name="urlschemes" id="urlschemes" class="textinput" value="<?php echo $getitem['urlschemes'] ?>" />             
                </div>
                <div class="rows" style="display:none;">	
                    <label for="menu_group_id">Facebook URL Schemes</label>
                    <input type="text" name="facebookurlschemes" id="facebookurlschemes" class="textinput" value="<?php echo $getitem['facebookurlschemes'] ?>" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook Fanpage Link</label>
                    <input type="text" name="facebookfanpagelink" id="facebookfanpagelink" class="textinput" value="<?php echo $getitem['facebookfanpagelink'] ?>" />             
                </div>
               
    </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       <div id="adminfieldset" class="groupsignios">
    <div class="adminheader">Tạo Google Service</div>
    <div class="group_left"> 
       			 <div class="rows">	
                    <label for="menu_group_id">Google Sender_ID (GCM)</label>
                    <input type="text" name="googlesenderid" id="googlesenderid" class="textinput"  value="<?php echo $getitem['googlesenderid'] ?>" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Google API key (GCM)</label>
                    <input type="text" name="googleapikey" id="googleapikey" class="textinput" value="<?php echo $getitem['googleapikey'] ?>" />             
                </div>
                
    </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       <div id="adminfieldset" class="groupsignios">
    <div class="adminheader">Ghi chú</div>
    <div class="group_left"> 
                
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">Người yêu cầu</label>
                    <input type="text" name="request_per" id="request_per" class="textinput" value="<?php echo $getitem['request_per'] ?>" />             
                </div>
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">Người tạo</label>
                    <input type="text" name="accept_per" id="accept_per" class="textinput" value="<?php echo $getitem['accept_per'] ?>" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea maxlength="2000" name="notes" id="notes" role="5" cols="30" style="height:150px;width:500px"><?php echo $getitem['notes'] ?></textarea>
                </div>
              
       			<div class="rows">
                	<a href="<?php echo base_url(); ?>?control=projects&func=viewpayment&id_projects=<?php echo $_GET['id']; ?>" target="_blank" style="color:#f36989;font-size:16px;font-weight:bold;">Click vào đây để khai báo Payment</a>
                </div>
                <div class="rows" style="display:none;">	
                <?php  if($_SESSION['account']['id_group']==2|| $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==64 || $_SESSION['account']['id_group']==61 || $_SESSION['account']['id_group']==71){ ?>
                    <label for="menu_group_id"></label>
                   <label for="menu_group_id"></label>
                    <input type="button" name="btnadd" id="btnadd" value="Lưu lại" class="btnB btn-primary" onclick="addstep1();"/>
                    <?php } ?>
                    <!--<input type="button" name="btncancel" id="btncancel" value="Ẩn đi" class="btnB btn-primary" onclick="$('#appForm1').css('display','none');"/>-->
                    <!--<input type="button" name="btncancel" id="btncancel" value="Thoát" class="btnB btn-primary" onclick="window.location.href='<?php echo base_url();?>?control=projects&func=index'"/>-->
                </div>
                
                </div> <!--group_left-->
       </div> <!--groupsignios-->
       
            </div>
           
            <div class="clr"></div>
            </form>
        </div>
        
        
        <!--<form id="appForm2" name="appForm2" action="" method="post" enctype="multipart/form-data" style="display:none;">
        <div id="adminfieldset" class="groupsignios space" style="clear:both;margin-left:0;width:70%;">
            <div class="adminheader">BundleID PackageName</div>
            <div class="group_left" id="div_proper">
               <div class="rows">
               			<label for="menu_group_id">Platform</label>
               			<select name="cbo_platform" id="cbo_platform" onchange="settypeapp(this.value);">
                            <option value="0">Chọn Platform</option>
                            <?php
                                if(count($loadplatform)>0){
                                    foreach($loadplatform as $key=>$value){
                            ?>
                            <option value="<?php echo $key;?>"><?php echo $value;?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
               </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_package_name">BundleID/Package/Identity</label>
                    <input type="text" name="package_name" id="package_name" class="textinput" value="" maxlength="200" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">In-App Items</label>
                    <input type="text" name="inapp_items_show_old" id="inapp_items_show_old" class="textinput" value="" maxlength="200" style="width:250px;" />
                    <input type="hidden" name="inapp_items_old" id="inapp_items_old" class="textinput" value="" maxlength="200" style="width:250px;" />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addtext();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" />
                    </a> 
                </div>
                <div class="rows" id="in_app" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ol class="payment" style="margin-left:185px;"></ol>
                    
                </div>
                <div class="rows" style="display:none" id="div_public_key">	
                    <label for="menu_group_id">Public Key</label>
                    <textarea class="notes" name="public_key_old" id="public_key_old" role="5" cols="30" style="height:150px;width:500px"></textarea>          
                </div>
                <div class="rows" style="display:none" id="div_wp_1">	
                    <label for="menu_group_id">Publisher</label>
                    <input type="text" name="wp_p1_old" id="wp_p1_old" class="textinput" value="" maxlength="200" />
                </div>
                <div class="rows" style="display:none" id="div_wp_2">	
                    <label for="menu_group_id">Properties</label>
                    <input type="text" name="wp_p2_old" id="wp_p2_old" class="textinput" value="" maxlength="200" />
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea class="notes" maxlength=500 name="notes_p_old" id="notes_p_old" role="5" cols="30" style="height:150px;width:500px"></textarea>
                </div>
                <div class="rows">	
                    <label for="menu_group_id"></label>
                    <input type="button" name="btnadd1" id="btnadd1" value="Thêm" class="btnB btn-primary" onclick="addstep2new();"/>
                   <input type="button" name="btncancel" id="btncancel" value="Ẩn đi" class="btnB btn-primary" onclick="$('#appForm2').css('display','none');"/>
                    
                </div>
            </div>
            
            
            
            <div class="clr"></div>
        </div>
        </form>-->
        
         <div id="adminfieldset" class="groupsignios space" style="margin-left:0 !important;width:inherit !important;">
                <div class="adminheader"><a href="javascript:void(0);" id="pbottom">BundleID PackageName PackageIdentity</a></div>
                <?php  if($_SESSION['account']['id_group']==2 || $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==64 || $_SESSION['account']['id_group']==61 || $_SESSION['account']['id_group']==71 || $_SESSION['account']['id_group']==69 || $_SESSION['account']['id_group']==80 || $_SESSION['account']['id_group']==72){ ?>
                    <div class="group_left" id="div_proper" style="margin-left:22px;">
<input type="checkbox" name="chk_ios" id="chk_ios" value="" onchange="if(this.checked){$('#step2').css('display','block');}else {$('#step2').css('display','none');}" />IOS
<input type="checkbox" name="chk_android" id="chk_android" value="" onchange="if(this.checked){$('#step3').css('display','block');}else { $('#step3').css('display','none');}"/>Android
<input type="checkbox" name="chk_wp" id="chk_wp" value="" onchange="if(this.checked){ $('#step4').css('display','block');}else{ $('#step4').css('display','none');}"/>WindowPhone
				
        	</div>
                    <?php } ?>
                    <div id="step2" style="display:none;">
        <div id="adminfieldset" class="groupsignios space" style="width:70% !important;margin-left:1% !important;">
            <div class="adminheader" >IOS</div>
            <div class="group_left" id="div_proper">
               <div class="rows">
               			<label for="menu_group_id"></label>
                      <input type="hidden" name="cbo_platform_ios" id="cbo_platform_ios" class="textinput" value="ios" />
               </div>
               <div class="rows">	
                    <label for="menu_group_id">Apple ID</label>
                    <input type="text" name="app_id_ios" id="app_id_ios" class="textinput" value="" maxlength="200" />
                </div>
                <div class="rows">
                	<label for="menu_group_id">Loại App</label>
                	<select name="cbo_cert_name" id="cbo_cert_name" data-placeholder="Chọn Loại" style="width:130px;">
                        <option value="Appstore">Appstore</option>
                        <option value="Inhouse">Inhouse</option>
                    </select>
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_package_name">BundleID</label>
                    <input type="text" name="package_name_ios" id="package_name_ios" class="textinput" value="" maxlength="200" />             
                </div>
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">In-App Items</label>
                    <input type="text" name="inapp_items_show_ios" id="inapp_items_show_ios" class="textinput" value="" maxlength="200" style="width:250px;" onkeypress="runScript_ios(event);" />
                    <input type="hidden" name="inapp_items_ios" id="inapp_items_ios" class="textinput" value="" maxlength="200" style="width:250px;" />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addtext_ios();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a> 
                </div>
                
                <div class="rows" id="in_app_ios" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ol class="payment_ios" style="margin-left:185px;"><li></li></ol>
                    
                </div>
                <div class="rows">
                	<form name="frmupload" enctype="multipart/form-data" method="post">
                	<label for="menu_group_id">Files Certificates (.zip)</label>
                    <input type="hidden" name="files_certificates_h" id="files_certificates_h"  />
                    <input type="file" name="files_certificates" id="files_certificates" accept=".*" />
                    <input type="button" name="btnupload" value="Upload" onclick="uploadajax();" />
                    <div id="messinfo" class="proccess" style="padding-left:205px;font-size:14px;color:#002099;"></div>
                    </form>
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_pass_certificates">Password Certificates</label>
                    <input type="text" name="pass_certificates" id="pass_certificates" class="textinput" value="" maxlength="64" style="width:250px;" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_pass_certificates">API Key G+</label>
                    <input type="text" name="api_key_ios" id="api_key_ios" class="textinput" value="" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_pass_certificates">Client ID G+</label>
                    <input type="text" name="client_key_ios" id="client_key_ios" class="textinput" value="" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_pass_certificates">Url Scheme G+</label>
                    <input type="text" name="url_scheme_ios" id="url_scheme_ios" class="textinput" value="" />             
                </div>
                <!--Facebook-->
                <div class="rows">	
                    <label for="menu_group_id">Facebook AppID</label>
                    <input type="text" name="facebookappid_ios" id="facebookappid_ios" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook AppSecret</label>
                    <input type="text" name="facebookappsecret_ios" id="facebookappsecret_ios" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook URL Schemes</label>
                    <input type="text" name="facebookurlschemes_ios" id="facebookurlschemes_ios" class="textinput" />             
                </div>
                <!--endfacebook-->
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea class="notes" name="notes_p_ios" id="notes_p_ios" role="5" cols="30" style="height:150px;width:500px"></textarea>
                </div>
                
            </div>
           
            <div class="clr"></div>
        </div>
      </div> <!--step2-->
      
      <div id="step3" style="display:none;">
        <div id="adminfieldset" class="groupsignios space" style="width:70% !important;margin-left:1% !important;">
            <div class="adminheader" >Android</div>
            <div class="group_left" id="div_proper">
               <div class="rows">
               			<label for="menu_group_id"></label>
                      <input type="hidden" name="cbo_platform_android" id="cbo_platform_android" class="textinput" value="android" />
               </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_package_name">PackageName</label>
                    <input type="text" name="package_name_android" id="package_name_android" class="textinput" value="" maxlength="200" />             
                </div>
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">In-App Items</label>
                    <input type="text" name="inapp_items_show_android" id="inapp_items_show_android" class="textinput" value="" maxlength="200" style="width:250px;" onkeypress="runScript_android(event);" />
                    <input type="hidden" name="inapp_items_android" id="inapp_items_android" class="textinput" value="" maxlength="200" style="width:250px;" />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addtext_android();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a> 
                </div>
                <div class="rows" id="in_app_android" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ol class="payment_android" style="margin-left:185px;"><li></li></ol>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Public Key</label>
                    <textarea class="notes" name="public_key" id="public_key" role="5" cols="30" style="height:150px;width:500px"></textarea>          
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_pass_certificates">API Key G+</label>
                    <input type="text" name="api_key_android" id="api_key_android" class="textinput" value="" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_pass_certificates">Client ID G+</label>
                    <input type="text" name="client_key_android" id="client_key_android" class="textinput" value="" />             
                </div>
                <div class="rows" style="display:none">	
                    <label for="menu_group_id" id="label_pass_certificates">Url Scheme G+</label>
                    <input type="text" name="url_scheme_androi" id="url_scheme_androi" class="textinput" value="" />             
                </div>
                <!--Facebook-->
                <div class="rows">	
                    <label for="menu_group_id">Facebook AppID</label>
                    <input type="text" name="facebookappid_android" id="facebookappid_android" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook AppSecret</label>
                    <input type="text" name="facebookappsecret_android" id="facebookappsecret_android" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook URL Schemes</label>
                    <input type="text" name="facebookurlschemes_android" id="facebookurlschemes_android" class="textinput" />             
                </div>
                <!--endfacebook-->
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea class="notes" name="notes_p_android" id="notes_p_android" role="5" cols="30" style="height:150px;width:500px"></textarea>
                </div>
                
            </div>
           
            <div class="clr"></div>
        </div>
      </div> <!--step3-->
      <div id="step4" style="display:none;">
        <div id="adminfieldset" class="groupsignios space" style="width:70% !important;margin-left:1% !important;">
            <div class="adminheader" >Window Phone</div>
            <div class="group_left" id="div_proper">
               <div class="rows">
               			<label for="menu_group_id"></label>
                      <input type="hidden" name="cbo_platform_wp" id="cbo_platform_wp" class="textinput" value="wp" />
               </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_package_name">Package Identity</label>
                    <input type="text" name="package_name_wp" id="package_name_wp" class="textinput" value="" maxlength="200" />             
                </div>
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">In-App Items</label>
                    <input type="text" name="inapp_items_show_wp" id="inapp_items_show_wp" class="textinput" value="" maxlength="200" style="width:250px;" onkeypress="runScript_wp(event);" />
                    <input type="hidden" name="inapp_items_wp" id="inapp_items_wp" class="textinput" value="" maxlength="200" style="width:250px;" />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addtext_wp();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a> 
                </div>
                <div class="rows" id="in_app_wp" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ol class="payment_wp" style="margin-left:185px;"><li></li></ol>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">App ID</label>
                    <input type="text" name="app_id" id="app_id" class="textinput" value="" maxlength="200" />
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Publisher</label>
                    <input type="text" name="wp_p1" id="wp_p1" class="textinput" value="" maxlength="200" />
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Names for this app</label>
                    <input type="text" name="wp_p2" id="wp_p2" class="textinput" value="" maxlength="200" />
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_pass_certificates">Client ID G+</label>
                    <input type="text" name="client_key_wp" id="client_key_wp" class="textinput" value="" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id" id="label_pass_certificates">Client Secret G+</label>
                    <input type="text" name="client_secret" id="client_secret" class="textinput" value="" />             
                </div>
                <!--Facebook-->
                <div class="rows">	
                    <label for="menu_group_id">Facebook AppID</label>
                    <input type="text" name="facebookappid_wp" id="facebookappid_wp" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook AppSecret</label>
                    <input type="text" name="facebookappsecret_wp" id="facebookappsecret_wp" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook URL Schemes</label>
                    <input type="text" name="facebookurlschemes_wp" id="facebookurlschemes_wp" class="textinput" />             
                </div>
                <!--endfacebook-->
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea class="notes" name="notes_p_wp" id="notes_p_wp" role="5" cols="30" style="height:150px;width:500px"></textarea>
                </div>
                
            </div>
           
            <div class="clr"></div>
        </div>
      </div> <!--step4-->
      <div class="rows" id="btn_add" style="float:left;clear:both;">	
                    <label for="menu_group_id"></label>
                    <input type="button" name="btnadd" id="btnadd" value="Lưu" class="btnB btn-primary" onclick="addstep1();" style="width:200px;float:left;"/>
        </div>
                    <!-- <a href="javascript:void(0);" onclick="$('#appForm2').css('display','none');">Hủy</a>-->
                    
                    <!--||  <a href="javascript:void(0);" onclick="$('#appForm1').css('display','none');" style="color:#903;">  Ẩn step1 </a> / <a href="javascript:void(0);" onclick="$('#appForm1').css('display','block');" style="color:#390;">  Hiện step1 </a>-->
                    <div class="group_left" id="div_list_proper" style="width:100% !important;">
                    	
                    </div>
        </div>
            
        <div class="clr"></div>
        <strong style="color:#F00">
        <?php
			echo $error;
		 ?>
         </strong>
    
</div>
</div>
</div>

<script type="text/javascript" language="javascript">
function uploadajax(){
	var _file=document.getElementById('files_certificates');
	var i=0;
	if(_file.files.length === 0){
        return;
    }
    var data = new FormData();
    data.append('files_certificates', _file.files[0]);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4){
            try {
                var resp = JSON.parse(request.response);
            } catch (e){
                var resp = {
                    status: 'error',
                    data: 'Unknown error occurred: [' + request.responseText + ']'
                };
            }
			$('#messinfo').text(resp.status)
            //console.log(resp.status + ': ' + resp.data);
        }
    };
	request.upload.addEventListener('progress', function(e){
		i++;
		document.getElementById('messinfo').innerHTML = i + '%';
    }, false);
	request.open('POST', 'upload.php');
    request.send(data);
    /*request.upload.addEventListener('progress', function(e){
        _progress.style.width = Math.ceil(e.loaded/e.total) * 100 + '%';
    }, false);*/

    
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
function callfunc(){
	var isok=true;
		try{
			//step2
			var _android=document.getElementById('chk_android').checked;
			var _ios=document.getElementById('chk_ios').checked;
			var _wp=document.getElementById('chk_wp').checked;
			if(_ios){
				var _package_name=$('#package_name_ios').val();
				var _inapp_items=$('#inapp_items_ios').val();
				var list_array='';
				$(".payment_ios li").each(function( index ) {
					list_array += $(this).text();
				});
				if(_package_name==''){
					alert('Khong bo trong');
					$('#package_name_ios').focus();
					isok=false;
					return isok;
				}
				//check bundle ios
				if(!checkbundleisexit('ios',_package_name,'package_name_ios')){
					return;
				}
				/*if(list_array==''){
					alert('Khong bo trong');
					$('#inapp_items_show_ios').focus();
					isok=false;
					return isok;
				}*/
				
			} // end if
			if(_android){
				var _package_name=$('#package_name_android').val();
				var _inapp_items=$('#inapp_items_android').val();
				var list_array='';
				$(".payment_android li").each(function( index ) {
					list_array += $(this).text();
				});
				if(_package_name==''){
					alert('Khong bo trong');
					$('#package_name_android').focus();
					isok=false;
					return isok;
				}
				//check packagename 
				if(!checkbundleisexit('android',_package_name,'package_name_android')){
					return;
				}
				/*if(list_array==''){
					alert('Khong bo trong');
					$('#inapp_items_show_android').focus();
					isok=false;
					return isok;
				}*/
				
			} // end if
			if(_wp){
				var _package_name=$('#package_name_wp').val();
				var _inapp_items=$('#inapp_items_wp').val();
				var list_array='';
				$(".payment_wp li").each(function( index ) {
					list_array += $(this).text();
				});
				if(_package_name==''){
					alert('Khong bo trong');
					$('#package_name_wp').focus();
					isok=false;
					return isok;
				}
				//check package Identity
				if(!checkbundleisexit('wp',_package_name,'package_name_wp')){
					return;
				}
				/*if(list_array==''){
					alert('Khong bo trong');
					$('#inapp_items_show_wp').focus();
					isok=false;
					return isok;
				}*/
				
			} // end if
			if(isok==true){
				if(_ios){addstep2new(1);}
				if(_android){addstep2new(2);}
				if(_wp){addstep2new(3);}
				$("ol li").remove();
				$('.loading_warning').hide();
				isok=true;
			}
			
		}catch(e){
			isok=false;
		}
		return isok;
	}
	var j=0;
	function runScript_ios(e) {
		if (e.keyCode == 13) {
			addtext_ios();
			return false;
		}
	}
	function addtext_ios(){
		_ival=$('#inapp_items_show_ios').val();
		j++;
		if(_ival!=''){
			$('#in_app_ios').css('display','block');
			$('.payment_ios').prepend("<li id='" + j +"'>" + _ival + " | <a href='javascript:void(0);' onclick='removetext_ios(" + j +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
		}
	}
	function removetext_ios(j){
		$(".payment_ios li").remove("#"+ j +"");
	}
	
	var j1=0;
	function runScript_android(e) {
		if (e.keyCode == 13) {
			addtext_android();
			return false;
		}
	}
	function addtext_android(){
		_ival=$('#inapp_items_show_android').val();
		j1++;
		if(_ival!=''){
			$('#in_app_android').css('display','block');
			$('.payment_android').prepend("<li id='" + j1 +"'>" + _ival + " | <a href='javascript:void(0);' onclick='removetext_android(" + j1 +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
		}
	}
	function removetext_android(j1){
		$(".payment_android li").remove("#"+ j1 +"");
	}
	
	var j2=0;
	function runScript_wp(e) {
		if (e.keyCode == 13) {
			addtext_wp();
			return false;
		}
	}
	function addtext_wp(){
		_ival=$('#inapp_items_show_wp').val();
		j2++;
		if(_ival!=''){
			$('#in_app_wp').css('display','block');
			$('.payment_wp').prepend("<li id='" + j2 +"'>" + _ival + " | <a href='javascript:void(0);' onclick='removetext_wp(" + j2 +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
		}
	}
	function removetext_wp(j2){
		$(".payment_wp li").remove("#"+ j2 +"");
	}
	function settypeapp(val){
		switch(val){
			case 'ios':
				$('#label_package_name').text('BundleID');
				$('#div_public_key').css('display','none');
				$('#div_wp_1').css('display','none');
				$('#div_wp_2').css('display','none');
				
			break;
			case 'android':
				$('#label_package_name').text('PackageName');
				$('#div_public_key').css('display','block');
				$('#div_wp_1').css('display','none');
				$('#div_wp_2').css('display','none');
				
			break;
			case 'wp':
				$('#label_package_name').text('Package Identity');
				$('#div_public_key').css('display','none');
				$('#div_wp_1').css('display','block');
				$('#div_wp_2').css('display','block');
				
			break;
			default:
				$('#label_package_name').text('BundleID');
				$('#div_public_key').css('display','none');
				$('#div_wp_1').css('display','none');
				$('#div_wp_2').css('display','none');
				
			break;
		}
	}
	
	var chk=false;
	loadlistproperty(<?php echo $_GET['id']; ?>);
	function showform(){
		chk=!chk;
		if(chk){
			$('html,body').scrollTop(0);
			$('#appForm2').css('display','block');
			$('.scroolbar').css('display','none');
			$('#lbl_them').text('Hủy bỏ');
			//document.getElementById('imgact').src='<?php echo base_url()?>assets/img/icon/tru.png';
		}else{
			$('#appForm2').css('display','none');
			$('.scroolbar').css('display','block');
			$('#lbl_them').text('Thêm mới');
			//document.getElementById('imgact').src='<?php echo base_url()?>assets/img/icon/cong.png';
			
		}
	}
	/*var j=0;
	function addtext(){
		_ival=$('#inapp_items_show').val();
		j++;
		if(_ival!=''){
			$('#in_app').css('display','block');
			$('ol').prepend("<li id='" + j +"'>" + _ival + " | <a href='javascript:void(0);' onclick='removetext(" + j +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
		}
	}
	function removetext(j){
		$("li").remove("#"+ j +"");
	}*/
	function addstep1(){
		var isok=true;
		var _code=$('#code').val();
		var _names=$('#names').val();
		var _namesetup=$('#namesetup').val();
		var _servicekeyapp=$('#servicekeyapp').val();
		var _servicekey=$('#servicekey').val();
		var _facebookapp=$('#facebookapp').val();
		var _facebookappid=$('#facebookappid').val();
		var _facebookappsecret=$('#facebookappsecret').val();
		var _itunesconnect=$('#itunesconnect').val();
		var _appleid=$('#appleid').val();
		var _gacode=$('#gacode').val();
		var _appsflyerid=$('#appsflyerid').val();
		//ghep googleproductapi
		 _gReportWithConversionID=$('#ReportWithConversionID').val();
		 _gLabel=$('#label').val();
		 _gValue=$('#value').val();
		 _gIsRepeatable=$('#isRepeatable').val();
		 _gGoogleProductApi=_gReportWithConversionID + ';' + _gLabel + ';' + _gValue + ';' + _gIsRepeatable;
		 document.getElementById('googleproductapi').value = _gGoogleProductApi;
		 
		var _googleproductapi=$('#googleproductapi').val();
		
		var _urlschemes=$('#urlschemes').val();
		var _facebookurlschemes=$('#facebookurlschemes').val();
		var _googlesenderid=$('#googlesenderid').val();
		var _googleapikey=$('#googleapikey').val();
		var _facebookfanpagelink=$('#facebookfanpagelink').val();
		var _request_per=$('#request_per').val();
		var _accept_per=$('#accept_per').val();
		var notes=$('#notes').val();
		
		var screens=$('#cbo_screens').val();
		var servicekey_second=$('#servicekey_second').val();
		
		var config_logout=$('#cbo_config_logout').val();
		var language_sdk=$('#cbo_language_sdk').val();
		var folder=$('#folder').val();
		
		if(_code==''){
			alert('Không bỏ trống !');
			$('#code').focus();
			isok=false;
		}
		if(_names==''){
			alert('Không bỏ trống !');
			$('#names').focus();
			isok=false;
		}
		//add 
		if(isok){
				$.ajax({
						url:baseUrl+'?control=projects&func=editajax',
						type:"GET",
						data:{id:<?php echo $_GET['id'];?>,code:_code,names:_names,namesetup:_namesetup,servicekeyapp:_servicekeyapp,servicekey:_servicekey,facebookapp:_facebookapp,facebookappid:_facebookappid,facebookappsecret:_facebookappsecret,itunesconnect:_itunesconnect,appleid:_appleid,gacode:_gacode,appsflyerid:_appsflyerid,googleproductapi:_googleproductapi,urlschemes:_urlschemes,facebookurlschemes:_facebookurlschemes,googlesenderid:_googlesenderid,googleapikey:_googleapikey,facebookfanpagelink:_facebookfanpagelink,request_per:_request_per,accept_per:_accept_per,notes:notes,screens:screens,servicekey_second:servicekey_second,config_logout:config_logout,language_sdk:language_sdk,folder:folder},
						async:false,
						dataType:"json",
						beforeSend:function(){
							$('.loading_warning').show();
						},
						success:function(f){
							if(f.error==0){
								// Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
								 $('.loading_warning').hide();
								 if(callfunc()){
									window.location.href='<?php echo base_url();?>?control=projects&func=edit&id=<?php echo $_GET['id'];?>';
								 }
									/*var hash = window.location.hash;
									if(hash){
										$(window).scroll(function() {
										   if($(window).scrollTop() + $(window).height() == getDocHeight()) {
										   }
									   });
									}*/
							}else{
								Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
								$('.loading_warning').hide();
							}
						}
					});
		}//end if
		
	};
	function addstep2new(_type){
		switch(_type){
			case 1:
				var _cbo_platform=$('#cbo_platform_ios').val();
				var _package_name=$('#package_name_ios').val();
				var _public_key='';
				var _inapp_items=$('#inapp_items_ios').val();
				var _wp_p1='';
				var _wp_p2='';
				var notes_p=$('#notes_p_ios').val();
				//get in app array
				var list_array='';
				$(".payment_ios li").each(function( index ) {
					list_array += $(this).text();
				});
				_inapp_items=list_array.replace('undefined','');
				
				var _files_certificates=$('#files_certificates_h').val();
				var _pass_certificates=$('#pass_certificates').val();
				// api google G+
				var _api_key=$('#api_key_ios').val();
				var _client_key=$('#client_key_ios').val();
				var _url_scheme=$('#url_scheme_ios').val();
				var _client_secret='';
				var _app_id=$('#app_id_ios').val();
				var _cert_name=$('#cbo_cert_name').val();
				
				//facebook
				var _facebookappid=$('#facebookappid_ios').val();
				var _facebookappsecret=$('#facebookappsecret_ios').val();
				var _facebookurlschemes=$('#facebookurlschemes_ios').val();
				
			break;
			case 2:
				var _cbo_platform=$('#cbo_platform_android').val();
				var _package_name=$('#package_name_android').val();
				var _public_key=$('#public_key').val();
				var _inapp_items=$('#inapp_items_android').val();
				var _wp_p1='';
				var _wp_p2='';
				var notes_p=$('#notes_p_android').val();
				//get in app array
				var list_array='';
				$(".payment_android li").each(function( index ) {
					list_array += $(this).text();
				});
				_inapp_items=list_array.replace('undefined','');
				
				var _files_certificates='';
				var _pass_certificates='';
				// api google G+
				var _api_key=$('#api_key_android').val();
				var _client_key=$('#client_key_android').val();
				var _url_scheme='';
				var _client_secret='';
				var _app_id='';
				var _cert_name='';
				
				//facebook
				var _facebookappid=$('#facebookappid_android').val();
				var _facebookappsecret=$('#facebookappsecret_android').val();
				var _facebookurlschemes=$('#facebookurlschemes_android').val();
				
			break;
			case 3:
				var _cbo_platform=$('#cbo_platform_wp').val();
				var _package_name=$('#package_name_wp').val();
				var _public_key='';
				var _inapp_items=$('#inapp_items_wp').val();
				var _wp_p1=$('#wp_p1').val();
				var _wp_p2=$('#wp_p2').val();
				var notes_p=$('#notes_p_wp').val();
				//get in app array
				var list_array='';
				$(".payment_wp li").each(function( index ) {
					list_array += $(this).text();
				});
				_inapp_items=list_array.replace('undefined','');
				
				var _files_certificates='';
				var _pass_certificates='';
				// api google G+
				var _api_key='';
				var _client_key=$('#client_key_wp').val();
				var _url_scheme='';
				var _client_secret=$('#client_secret').val();
				var _app_id=$('#app_id').val();
				var _cert_name='';
				
				//facebook
				var _facebookappid=$('#facebookappid_wp').val();
				var _facebookappsecret=$('#facebookappsecret_wp').val();
				var _facebookurlschemes=$('#facebookurlschemes_wp').val();
				
			break;
		}
		//add 
		$.ajax({
                url:baseUrl+'?control=projects&func=addajaxstep2new',
                type:"GET",
                data:{id_projects:<?php echo $_GET['id'] ?>,cbo_platform:_cbo_platform,package_name:_package_name,public_key:_public_key,inapp_items:_inapp_items,wp_p1:_wp_p1,wp_p2:_wp_p2,notes_p:notes_p,files_certificates:_files_certificates,pass_certificates:_pass_certificates,api_key:_api_key,client_key:_client_key,url_scheme:_url_scheme,client_secret:_client_secret,app_id:_app_id,cert_name:_cert_name,facebookappid:_facebookappid,facebookappsecret:_facebookappsecret,facebookurlschemes:_facebookurlschemes},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    //$('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
                        //Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
						//$('.loading_warning').hide();
						//$("ol li").remove();
						//$('.textinput').val('');
						//$('.notes').val('');
						// load list ajax
						//loadlistproperty(<?php echo $_GET['id'];?>);
						//window.location.href='<?php echo base_url();?>?control=projects&func=edit&id=<?php echo $_GET['id'];?>';
						
						
                    }else{
                       // Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                        //$('.loading_warning').hide();
                    }
                }
            });
		
	}// end step 2 new
    function addstep2(){
		var _cbo_platform=$('#cbo_platform').val();
		//var _app_id=$('#app_id').val();
		var _package_name=$('#package_name').val();
		//var _version_type=$('#version_type').val();
		var _public_key=$('#public_key').val();
		//var _inapp_product=$('#inapp_product').val();
		var _appstore_inapp_items=$('#appstore_inapp_items').val();
		var _gp_inapp_items=$('#gp_inapp_items').val();
		var notes_p=$('#notes_p').val();
		
		if(_cbo_platform==0){
			alert('Vui lòng chọn Platform !');
			$('#cbo_platform').focus();
			return false;
		}
		if(_appstore_inapp_items==''){
			alert('Không bỏ trống In App Item !');
			$('#inapp_items_show').focus();
			return false;
		}
		if(_gp_inapp_items==''){
			alert('Không bỏ trống !');
			$('#gp_inapp_items').focus();
			return false;
		}
		
		/*
		if(_version_type==''){
			alert('Không bỏ trống !');
			$('#version_type').focus();
			return false;
		}
		if(_public_key==''){
			alert('Không bỏ trống !');
			$('#public_key').focus();
			return false;
		}*/
		//add 
		$.ajax({
                url:baseUrl+'?control=projects&func=addajaxstep2',
                type:"GET",
                data:{id_projects:<?php echo $_GET['id']; ?>,cbo_platform:_cbo_platform,package_name:_package_name,public_key:_public_key,appstore_inapp_items:_appstore_inapp_items,gp_inapp_items:_gp_inapp_items,notes_p:notes_p},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
                        //Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
						$('.loading_warning').hide();
						//$('#app_id').val('');
						//$('#version_type').val('');
						$('#package_name').val('');
						$('#public_key').val('');
						$('#appstore_inapp_items').val('');
						$('#gp_inapp_items').val('');
						$('#notes_p').val('');
						// load list ajax
						loadlistproperty(<?php echo $_GET['id'];?>);
						
                    }else{
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                        $('.loading_warning').hide();
                    }
                }
            });
		
	};
	//kiểm tra Bundle/Package đã tồn tại hay chưa
	function checkbundleisexit(_platform,_values,_idcontrol){
		_isok=true;
		_types='add';
		try{
			$.ajax({
				url:baseUrl+'?control=projects&func=checkbundleisexit',
				type:'GET',
				data:{platform:_platform,values:_values,types:_types},
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
	function loadlistproperty(id_project){
			$.ajax({
                url:baseUrl+'?control=projects&func=loadlistplus',
                type:"GET",
                data:{id_project:id_project},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
						 $("#div_list_proper").html(f.html);
						 $('.loading_warning').hide();
                    }else{
						$("#div_list_proper").html(f.html);
                        $('.loading_warning').hide();
                    }
                }
            });
	};
    
</script>
