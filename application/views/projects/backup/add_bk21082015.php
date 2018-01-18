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
legend{
	font-size:14px !important;
}
</style>
<div class="loading_warning"></div>
<div class="wrapper_scroolbar_sss">
            <div class="scroolbar_sss">
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    
        <?php include_once 'include/toolbar.php'; ?>
        <form id="appForm1" name="appForm1" action="" method="post" enctype="multipart/form-data">
        
        <div id="adminfieldset" class="groupsignios" style="width:100% !important">
            <div class="adminheader">Nhập thông tin chung</div>
            <div class="group_left">
            	<div class="rows">	
                    <label for="menu_group_id">Mã dự án</label>
                    <input type="text" name="code" id="code" class="textinput" maxlength="200" />             
                </div>
				<div class="rows">	
                    <label for="menu_group_id">Tên Dự án</label>
                    <input type="text" name="names" id="names" class="textinput"/>             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Tên cài đặt</label>
                    <input type="text" name="namesetup" id="namesetup" class="textinput"/>             
                </div>
           </div> <!--group_left-->
       </div> <!--groupsignios-->
       
        <div id="adminfieldset" class="groupsignios" style="width:100% !important">
            <div class="adminheader">Thông tin Service API</div>
            <div class="group_left">
             	 <div class="rows">	
                    <label for="menu_group_id">Service Key App</label>
                    <input type="text" name="servicekeyapp" id="servicekeyapp" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Service Key</label>
                    <input type="text" name="servicekey" id="servicekey" class="textinput" />             
                </div>
       </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       
       <div id="adminfieldset" class="groupsignios" style="width:100% !important">
            <div class="adminheader">Tạo dự án Facebook App</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">FacebookAppID</label>
                    <input type="text" name="facebookappid" id="facebookappid" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook AppSecret</label>
                    <input type="text" name="facebookappsecret" id="facebookappsecret" class="textinput" />             
                </div>
                <div class="rows" style="display:none;">	
                    <label for="menu_group_id">Facebook Apps</label>
                    <input type="text" name="facebookapp" id="facebookapp" class="textinput" />             
                </div>
      </div> <!--group_left-->
       </div> <!--groupsignios-->

    <div id="adminfieldset" class="groupsignios" style="width:100% !important">
    <div class="adminheader">Tạo dự án trên itunes connect</div>
    <div class="group_left">
    			<div class="rows">	
                    <label for="menu_group_id">AppleID</label>
                    <input type="text" name="appleid" id="appleid" class="textinput" />             
                </div>
                
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">IOS trên Itunesconnect</label>
                    <input type="text" name="itunesconnect" id="itunesconnect" class="textinput" />             
                </div>
    </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       
    <div id="adminfieldset" class="groupsignios" style="width:100% !important">
    <div class="adminheader">Tạo chỉ số Marketing</div>
    <div class="group_left">         
                <div class="rows">	
                    <label for="menu_group_id">GA Code</label>
                    <input type="text" name="gacode" id="gacode" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Appsflyer ID</label>
                    <input type="text" name="appsflyerid" id="appsflyerid" class="textinput" />             
                </div>
                <div class="rows">	
               <label for="menu_group_id">Google AdWords <br />Conversion Tracking Code IOS</label>
                    <textarea name="googleproductapi" id="googleproductapi" role="5" cols="30" style="height:150px;width:500px"></textarea>        
                </div>
                <div class="rows">	
                    <label for="menu_group_id">URL Schemes</label>
                    <input type="text" name="urlschemes" id="urlschemes" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Facebook URL Schemes</label>
                    <input type="text" name="facebookurlschemes" id="facebookurlschemes" class="textinput" />             
                </div>
                
     </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       
   <div id="adminfieldset" class="groupsignios" style="width:100% !important">
    <div class="adminheader">Tạo Google Service</div>
    <div class="group_left">  
                <div class="rows">	
                    <label for="menu_group_id">Google Sender_ID (GCM)</label>
                    <input type="text" name="googlesenderid" id="googlesenderid" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Google API key (GCM)</label>
                    <input type="text" name="googleapikey" id="googleapikey" class="textinput" />             
                </div>
    </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       
       <div id="adminfieldset" class="groupsignios" style="width:100% !important">
    <div class="adminheader">Ghi chú</div>
    <div class="group_left"> 
                <div class="rows">	
                    <label for="menu_group_id">Facebook Fanpage Link</label>
                    <input type="text" name="facebookfanpagelink" id="facebookfanpagelink" class="textinput" />             
                </div>
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">Người yêu cầu</label>
                    <input type="text" name="request_per" id="request_per" class="textinput" />             
                </div>
                <div class="rows" style="display:none">	
                    <label for="menu_group_id">Người tạo</label>
                    <input type="text" name="accept_per" id="accept_per" class="textinput" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea maxlength="2000" name="notes" id="notes" role="5" cols="30" style="height:150px;width:500px"></textarea>
                </div>
                <div class="rows" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <input type="button" name="btnadd" id="btnadd" value="Lưu" class="btnB btn-primary" onclick="addstep1();" style="width:250px"/>
                </div>
    </div> <!--group_left-->
       </div> <!--groupsignios-->
       
       
                
            </div>
            <div class="clr"></div>
        </div>
        </form>
        
        <div id="step2">
        <div id="adminfieldset" class="groupsignios space" style="width:100% !important;margin-left:1% !important;">
            <div class="adminheader" >BundleID Or PackageName</div>
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
                    <label for="menu_group_id" id="label_package_name">BundleID</label>
                    <input type="text" name="package_name" id="package_name" class="textinput" value="" maxlength="200" />             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">In-App Items</label>
                    <input type="text" name="inapp_items_show" id="inapp_items_show" class="textinput" value="" maxlength="200" style="width:250px;" />
                    <input type="hidden" name="inapp_items" id="inapp_items" class="textinput" value="" maxlength="200" style="width:250px;" />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addtext();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a> 
                </div>
                <div class="rows" id="in_app" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ol class="payment" style="margin-left:185px;"></ol>
                    
                </div>
                <div class="rows" style="display:none" id="div_public_key">	
                    <label for="menu_group_id">Public Key</label>
                    <textarea name="public_key" id="public_key" role="5" cols="30" style="height:150px;width:500px"></textarea>          
                </div>
                <div class="rows" style="display:none" id="div_wp_1">	
                    <label for="menu_group_id">Wp(Publisher)</label>
                    <input type="text" name="wp_p1" id="wp_p1" class="textinput" value="" maxlength="200" />
                </div>
                <div class="rows" style="display:none" id="div_wp_2">	
                    <label for="menu_group_id">Wp(Properties)</label>
                    <input type="text" name="wp_p2" id="wp_p2" class="textinput" value="" maxlength="200" />
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes_p" id="notes_p" role="5" cols="30" style="height:150px;width:500px"></textarea>
                </div>
                <div class="rows">	
                    <label for="menu_group_id"></label>
                    <input type="button" name="btnadd1" id="btnadd1" value="Lưu" class="btnB btn-primary"  onclick="addstep2new();" style="width:250px;display:none;" />
                    <!--<input type="button" name="btncancel" id="btncancel" value="Thoát" class="btnB btn-primary" onclick="window.location.href='<?php echo base_url();?>?control=projects&func=index'"/>-->
                </div>
                
            </div>
           
            <div class="clr"></div>
        </div>
      </div> <!--step2-->
         <div class="rows">	
                    <label for="menu_group_id"></label>
                    <input type="button" name="btnadd" id="btnadd" value="Lưu" class="btnB btn-primary" onclick="callfunc();" style="width:200px;float:left;"/>
        </div>
        
        <div id="step3" style="display:none;">
         <div id="adminfieldset" class="groupsignios space" style="margin-left:1% !important;width:inherit !important;">
                <div class="adminheader">List BundleID PackageName</div>
                    <div class="group_left" id="div_list_proper" style="width:100% !important;">
                    
                    </div>
        </div>
        </div> <!--step3-->
            
        <div class="clr"></div>
        <strong style="color:#F00">
        <?php
			echo $error;
		 ?>
         </strong>
    
</div>
</div>
</div>
<script type="text/javascript">
function maxLength(el) {    
    if (!('maxLength' in el)) {
        var max = el.attributes.maxLength.value;
        el.onkeypress = function () {
            if (this.value.length >= max) return false;
        };
    }
}
maxLength(document.getElementById("notes"));
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	var j=0;
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
	function gettext(){
		var _tex=$('#cbo_app option:selected').text();
		document.getElementById('cbo_app_hiden').value=_tex;
	}
	function callfunc(){
		try{
			//step1
			var _code=$('#code').val();
			var _names=$('#names').val();
			var _namesetup=$('#namesetup').val();
			var _servicekeyapp=$('#servicekeyapp').val();
			var _servicekey=$('#servicekey').val();
			//step2
			var _cbo_platform=$('#cbo_platform').val();
			var _package_name=$('#package_name').val();
			
			//check step1
			if(_code==''){
			alert('Không bỏ trống !');
			$('#code').focus();
			return false;
			}
			if(_names==''){
				alert('Không bỏ trống !');
				$('#names').focus();
				return false;
			}
			if(_namesetup==''){
				alert('Không bỏ trống !');
				$('#namesetup').focus();
				return false;
			}
			if(_servicekeyapp==''){
				alert('Không bỏ trống !');
				$('#servicekeyapp').focus();
				return false;
			}
			if(_servicekey==''){
				alert('Không bỏ trống !');
				$('#servicekey').focus();
				return false;
			}
			//check step2
			if(_cbo_platform==0){
				alert('Vui lòng chọn Platform !');
				$('#cbo_platform').focus();
				return false;
			}
			if(_package_name==''){
			alert('Không bỏ trống !');
			$('#package_name').focus();
			return false;
			}
			
			addstep1();
		}catch(e){
		}
	}
	function addstep1(){
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
		var _googleproductapi=$('#googleproductapi').val();
		var _urlschemes=$('#urlschemes').val();
		var _facebookurlschemes=$('#facebookurlschemes').val();
		var _googlesenderid=$('#googlesenderid').val();
		var _googleapikey=$('#googleapikey').val();
		var _facebookfanpagelink=$('#facebookfanpagelink').val();
		var _request_per=$('#request_per').val();
		var _accept_per=$('#accept_per').val();
		var notes=$('#notes').val();
		if(_code==''){
			alert('Không bỏ trống !');
			$('#code').focus();
			return false;
		}
		if(_names==''){
			alert('Không bỏ trống !');
			$('#names').focus();
			return false;
		}
		//add 
		$.ajax({
                url:baseUrl+'?control=projects&func=addajax',
                type:"GET",
                data:{code:_code,names:_names,namesetup:_namesetup,servicekeyapp:_servicekeyapp,servicekey:_servicekey,facebookapp:_facebookapp,facebookappid:_facebookappid,facebookappsecret:_facebookappsecret,itunesconnect:_itunesconnect,appleid:_appleid,gacode:_gacode,appsflyerid:_appsflyerid,googleproductapi:_googleproductapi,urlschemes:_urlschemes,facebookurlschemes:_facebookurlschemes,googlesenderid:_googlesenderid,googleapikey:_googleapikey,facebookfanpagelink:_facebookfanpagelink,request_per:_request_per,accept_per:_accept_per,notes:notes},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
						addstep2new();
						$('.loading_warning').hide();
						//$('#btnadd1').css('display','inline-block');
						$('.textinput').val('');
					    //$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
						$('#notes').val('');
						Lightboxt.showemsg('Thông báo', '<b>Thêm thành công</b>', 'Đóng');
						
						
                    }else{
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                        $('.loading_warning').hide();
                    }
                }
            });
		
	}//end step 1
	function addstep2new(){
		var _cbo_platform=$('#cbo_platform').val();
		var _package_name=$('#package_name').val();
		var _public_key=$('#public_key').val();
		var _inapp_items=$('#inapp_items').val();
		var _wp_p1=$('#wp_p1').val();
		var _wp_p2=$('#wp_p2').val();
		var notes_p=$('#notes_p').val();
		
		if(_cbo_platform==0){
			alert('Vui lòng chọn Platform !');
			$('#cbo_platform').focus();
			return false;
		}
		if(_package_name==''){
			alert('Không bỏ trống !');
			$('#package_name').focus();
			return false;
		}
		//get in app array
		var list_array;
		$(".payment li").each(function( index ) {
			list_array += $(this).text();
		});
		_inapp_items=list_array.replace('undefined','');
		//add 
		$.ajax({
                url:baseUrl+'?control=projects&func=addajaxstep2new',
                type:"GET",
                data:{id_projects:0,cbo_platform:_cbo_platform,package_name:_package_name,public_key:_public_key,inapp_items:_inapp_items,wp_p1:_wp_p1,wp_p2:_wp_p2,notes_p:notes_p},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
                        //Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
						$('.loading_warning').hide();
						$('#public_key').val('');
						$('#inapp_items').val('');
						$('#notes_p').val('');
						$("ol li").remove();
						// load list ajax
						//loadlistproperty();
						
                    }else{
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                        $('.loading_warning').hide();
                    }
                }
            });
		
	}// end step 2 new
    function addstep2(){
		var _cbo_platform=$('#cbo_platform').val();
		var _app_id=$('#app_id').val();
		var _package_name=$('#package_name').val();
		var _version_type=$('#version_type').val();
		var _public_key=$('#public_key').val();
		var _inapp_product=$('#inapp_product').val();
		var _appstore_inapp_items=$('#appstore_inapp_items').val();
		var _gp_inapp_items=$('#gp_inapp_items').val();
		var notes_p=$('#notes_p').val();
		
		if(_cbo_platform==0){
			alert('Vui lòng chọn Platform !');
			$('#cbo_platform').focus();
			return false;
		}
		if(_appstore_inapp_items==''){
			alert('Không bỏ trống !');
			$('#appstore_inapp_items').focus();
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
                data:{id_projects:0,cbo_platform:_cbo_platform,app_id:_app_id,package_name:_package_name,version_type:_version_type,public_key:_public_key,inapp_product:_inapp_product,appstore_inapp_items:_appstore_inapp_items,gp_inapp_items:_gp_inapp_items,notes_p:notes_p},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
						$('.loading_warning').hide();
						$('#app_id').val('');
						$('#version_type').val('');
						$('#package_name').val('');
						$('#public_key').val('');
						$('#inapp_product').val('');
						$('#notes_p').val('');
						$('.textinput').val('');
						// load list ajax
						//loadlistproperty();
						
                    }else{
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                        $('.loading_warning').hide();
                    }
                }
            });
		
	}// end step 2
	
	function loadlistproperty(){
			$.ajax({
                url:baseUrl+'?control=projects&func=loadlist',
                type:"GET",
                data:{isok:1},
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
	}
    
    $(function(){
        $(".exportfile").click(function(){
            var id = '<?php echo $_GET['id'];?>';
            var id_game = $("select[name=id_game]").val();
            var id_app = $("select[name=cert_id]").val();
            $.ajax({
                url:baseUrl+'?control=signhistoryapp&func=export',
                type:"GET",
                data:{id:id,id_app:id_app,id_game:id_game},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                        $('.loading_warning').hide();
                    }else{
                        Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                        $('.loading_warning').hide();
                    }
                }
            });
        });
    });
</script>