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
				title:'LSApplicationQueriesSchemes',
				maxWidth	: 800,
				maxHeight	: 600,
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
.head{
	display:none;
}
.textinputplus{
	border:none !important;
}
.content_form .groupsignios .rows {
    margin-bottom:1px;
}
.content_form .groupsignios .textinput {
    margin-bottom:1px;
}
.content_form .groupsignios select {
    margin-bottom:1px;
}
.content_form .groupsignios table tr td {
   text-align:left;
}
.inner{
	height:910px;
}
.rows_t{
	display:none;
}
</style>

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
<div class="loading_warning" style="text-align:center"><img src="<?php echo base_url('assets/img/icon/loading_sign.gif'); ?>" /></div>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data" style="height:890px;">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset" class="groupsignios" style="height:170px;">
            <div class="adminheader">Thông tin Game</div>
            <div class="group_left">
            	<div class="rows">
                	 <div class="option_error" style="color:#F00;font-weight:bold;">
                		<?php echo $errors['google_err'];?>
                     </div>
                    <label for="menu_group_id">Chọn holder</label>
                    <select name="cbo_partner" id="cbo_partner" class="chosen-select" tabindex="2" data-placeholder="Chọn holder" onchange="getCert(this.value);">
                            <option value="null">Chọn holder</option>
                             <?php
                            if(count($partner)>0){
                                foreach($partner as $v){
                        ?>
                        <option value="<?php echo $v['id']."|".$v['partner'];?>" ><?php echo $v['partner'];?></option>
                        <?php
                                }
                            }
                        ?>
                   </select>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="id_game" id="id_game" class="chosen-select" tabindex="2" data-placeholder="Chọn danh mục">
                        <option value="0">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                        ?>
                        <option value="<?php echo $v['id']."|".$v['service_id']."|".$v['service']."|".$v['type'];?>" <?php echo $items['id_game']==$v['id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <div class="option_error">
                        <?php echo $errors['id_game'];?>
                    </div>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Chọn file Ipa</label>
                    <input type="file" name="ipa_file" id="ipa_file" accept=".ipa"/>
                    <div style="padding-left:152px;color:#F00;">Tên file không bao gồm ký tự lạ</div>
                    <div class="option_error"><?php echo $errors['ipa_file'];?></div>
                </div>
              
            </div>
            <div class="clr"></div>
        </div>
        <!-- end part 1 -->
        
        <!-- part 2 -->
        <div id="adminfieldset" class="groupsignios" style="left:5px;">
            <div class="adminheader">Nhập thông tin tùy chọn</div>
            <div class="group_left" style="height:370px;">
               
                <div class="rows">
                    <div class="cbo_sdk">
                    <label for="menu_group_id">Chọn SDK version</label>
                        <select name="cbo_sdk" id="cbo_sdk" class="chosen-select" tabindex="2"  style="width:150px;">
                            <option value="0">Chọn ...</option>
                            <?php
                            if(count($slbSdk)>0){
                                foreach($slbSdk as $v){
                        ?>
                        <option value="<?php echo $v['id']."|".str_replace("|","-",$v['versions']);?>"><?php echo $v['versions'];?></option>
                        <?php
                                }
                            }
                        ?>
                        </select>
                     	 <!--Lib_V3--> <input type="checkbox" name="cbo_libv3" id="cbo_libv3" value="ok" checked="checked" style="display:none" />
                    </div>
                </div>
                
                <div class="rows">
                    <label for="menu_group_id">Channel</label>
                    <input type="text" name="channel" id="channel" class="textinput" value="<?php echo $items['channel'];?>" maxlength="125" <?php 
                if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    echo "";
                }else{
                    echo "";
                }
            ?> />
                    <?php echo $errors['channel'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Version</label>
                    <input type="text" name="version" class="textinput" value="<?php echo $items['version'];?>" maxlength="25"/>
                    <?php echo $errors['version'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Bundle Version</label>
                    <input type="text" name="bundle_version" class="textinput" value="<?php echo $items['bundle_version'];?>" maxlength="25" />
                    <?php echo $errors['bundle_version'];?>
                </div>
                 
                <div class="rows">	
                    <label for="menu_group_id">Minimum OS Version</label>
                    <input type="text" name="minimum_os_version" class="textinput" value="<?php echo $items['minimum_os_version'];?>" maxlength="25"/>
                    <?php echo $errors['minimum_os_version'];?>
                </div>
                <div class="rows">
                <label for="menu_group_id">Ghi chú</label>
                <textarea name="notes" maxlength="1000" id="notes" cols="80" rows="3" style="width:300px;resize:none;height:170px;"></textarea>
                </div>
                <div class="rows">
                <label for="menu_group_id">LSApplication <br />QueriesSchemes</label>
                	<a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=signhistoryapp&func=popupsign">Show Edit</a>
                	<!--<a href="javascript:void(0)" onclick="popitup('<?=base_url()."popup_sign/popup_queriesschemes.php?id=1"; ?>','Xem log');">Show Edit</a>-->
                </div>
              
            </div>
            <div class="clr"></div>
        </div>
        <!-- end part 2 -->
        
        <!-- part 3-->
        <div id="adminfieldset" class="groupsignios" style="height:220px;top:-260px;">
            <div class="adminheader">Thông tin Sin App</div>
            <div class="group_left">
            	
  
                <div class="rows">	
                    <label for="menu_group_id">Bảng app</label>
                    <span class="loadapp">
                        <select name="cert_id" id="cert_id" data-placeholder="Chọn bảng app" onchange="showValue(this.value)">
                            <option value="0">Chọn bảng app</option>
                        </select>
                    </span>
                    <div class="option_error">
                        <?php echo $errors['cert_id'];?>
                    </div>
                    <input type="hidden" name="cert_name_text" id="cert_name_text"  />
                </div>
            
                
                <div class="rows">	
                    <label for="menu_group_id">BunldeID</label>
                    <select name="cbo_bunlderid" id="cbo_bunlderid" onchange="setBunlderId(this.value);" style="width:300px;">
                            <option value="0"> --- Chọn --- </option>
                   </select>
                    <div class="option_error">
                       
                    </div>
                </div>
                <div class="rows" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <input type="hidden" name="bundleidentifier_appstore" id="bundleidentifier_appstore" value="" maxlength="125"/>
                    <input type="text" name="bundleidentifier" id="bundleidentifier" class="txtbundleid textinput" value="<?php echo $items['bundleidentifier'];?>" maxlength="125"/>
                    <?php echo $errors['bundleidentifier'];?>
                </div>
                
                <div class="rows">	
                    <label for="menu_group_id">URL scheme</label>
                    <input type="hidden" name="url_scheme_appstore" id="url_scheme_appstore" value="" maxlength="125"/>
                    <input type="text" name="url_scheme" id="url_scheme" class="url_scheme textinput" value="<?php echo $items['url_scheme'];?>" maxlength="125"/>
                    <?php echo $errors['url_scheme'];?>
                </div>
                <div class="rows" style="display:none;">
                <label for="menu_group_id">Cấu trúc Channel</label>
                <input type="text" name="txt_p1" id="txt_p1" style="width:25px" maxlength="3" readonly="readonly" /> |
                <input type="text" name="txt_p2" id="txt_p2" style="width:36px;text-align:center" maxlength="10" value="me"/> |
                <input type="text" name="txt_p3" id="txt_p3" style="width:45px;text-align:center" maxlength="20" value="null" /> |
                <input type="text" name="txt_p4" id="txt_p4" style="width:85px;text-align:center" maxlength="80" readonly="readonly" /> |
                <input type="text" name="txt_p5" id="txt_p5" style="width:60px;text-align:center" maxlength="100" readonly="readonly" />
                </div>
                <div class="rows">
                    <div class="cbo_msv">
                    <label for="menu_group_id">Chọn Msv_</label>
                        <select name="cbo_p5_msv" id="cbo_p5_msv" style="width:150px;">
                            <option value="0">Chọn Msv...</option>
                        </select> 
                     <a href="<?php echo base_url()."?control=mestoreversion&func=add"; ?>" title="Thêm Msv" target="_blank"> Tạo mới Msv</a>
                    </div>
                </div>
				<div class="rows">
                    <div class="cbo_lydo">
                    <label for="menu_group_id">Lý do</label>
                        <select name="cbo_why" id="cbo_why" style="width:150px;">
                            <option value="">QC Testing</option>
                            <option value="SERVER_TEST">Server Testing</option>
                            <option value="GAME_TEST">GAME Testing</option>
                            <option value="FINAL">Kiểm duyệt</option>
                            <option value="DEMO">Thử nghiệm</option>
                            <option value="OTHER">Khác</option>
                        </select> 
                    </div>
                </div>
            	<div class="rows">
                    <div class="cbo_them" style="margin-top:10px;text-align:center">
                    	<label for="menu_group_id">
                       	 <a href="javascript:void(0);" onclick="addSign();"><img border="0" title="Xóa" src="<?php echo base_url().'assets/img/icon/cong.png'; ?>"></a>
                        </label>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <!-- end part 3 -->
        
        <!-- end part 4 -->
        <div id="adminfieldset" class="groupsignios" style="width:1030px;top:-280px;">
        	<div class="adminheader">Danh sách sign</div>
            <div class="group_left" style="width:100%">
            	<div class="rows">
                    <div class="list_items">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                    	<thead>
                        	<th>Loại</th>
                            <th>Bunlde</th>
                            <th>Msv</th>
                            <th>Channel</th>
                            <th></th>
                        </thead>
                        <tbody>
                        	<tr id="row_1" class="rows_t">
                            	<td>
                                <input type="hidden" id="txt_cert_id_1" name="txt_cert_id_1" />
                                <input type="text" id="txt_cert_1" name="txt_cert_1" style="width:100px;border:none" readonly="readonly" />
                                </td>
                                <td><input type="text" id="txt_bunlde_1" name="txt_bunlde_1" style="width:250px;border:none" readonly="readonly"/></td>
                                <td>
                                <input type="hidden" id="txt_msv_id_1" name="txt_msv_id_1" />
                                <input type="text" id="txt_msv_1" name="txt_msv_1" style="width:80px;border:none" readonly="readonly"/></td>
                                <td><input type="text" id="txt_channel_1" name="txt_channel_1" style="width:250px;border:none" readonly="readonly"/></td>
                                <td><a href="javascript:void(0);" onclick="clearSign(1);">Xóa</a></td>
                            </tr>
                            <tr id="row_2" class="rows_t">
                            	<td>
                                <input type="hidden" id="txt_cert_id_2" name="txt_cert_id_2" />
                                <input type="text" id="txt_cert_2" name="txt_cert_2" style="width:100px;border:none" readonly="readonly"/></td>
                                <td><input type="text" id="txt_bunlde_2" name="txt_bunlde_2" style="width:250px;border:none" readonly="readonly"/></td>
                                <td>
                                 <input type="hidden" id="txt_msv_id_2" name="txt_msv_id_2" />
                                <input type="text" id="txt_msv_2" name="txt_msv_2" style="width:80px;border:none" readonly="readonly"/></td>
                                <td><input type="text" id="txt_channel_2" name="txt_channel_2" style="width:250px;border:none" readonly="readonly"/></td>
                                <td><a href="javascript:void(0);" onclick="clearSign(2);">Xóa</a></td>
                            </tr>
                            <tr id="row_3" class="rows_t">
                            	<td>
                                <input type="hidden" id="txt_cert_id_3" name="txt_cert_id_3" />
                                <input type="text" id="txt_cert_3" name="txt_cert_3" style="width:100px;border:none" readonly="readonly"/></td>
                                <td><input type="text" id="txt_bunlde_3" name="txt_bunlde_3" style="width:250px;border:none" readonly="readonly"/></td>
                                <td> <input type="hidden" id="txt_msv_id_3" name="txt_msv_id_3" />
                                <input type="text" id="txt_msv_3" name="txt_msv_3" style="width:80px;border:none" readonly="readonly"/></td>
                                <td><input type="text" id="txt_channel_3" name="txt_channel_3" style="width:250px;border:none" readonly="readonly"/></td>
                                <td><a href="javascript:void(0);" onclick="clearSign(3);">Xóa</a></td>
                            </tr>
                            <tr>
                            	<td colspan="5" style="text-align:center;"><input type="submit" name="btn_Sign" id="btn_Sign" value="Sign App" onclick="ExeSign();" disabled="disabled" /></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end part 4 -->
    </form>
    
</div>
<script type="text/javascript">
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
	function maxLength(el) {    
		if (!('maxLength' in el)) {
			var max = el.attributes.maxLength.value;
			el.onkeypress = function () {
				if (this.value.length >= max) return false;
			};
		}
	}
	maxLength(document.getElementById("notes"));

	function checknullchennal(){
		_ch=$('#channel').val();
		_ga=$('#id_game').val();
		_app=$('#cert_id').val();
		_sdk=$('#cbo_sdk').val();
		_bunlderid=$('#cbo_bunlderid').val();
		_bundle=$('#bundleidentifier').val();
		_cbo_p5_msv=$('#cbo_p5_msv').val();
		if(_ga==0){
			alert('Vui lòng chọn game !');
			$('#id_game').focus();
			return false;
		}
		if(_app==0){
			alert('Vui lòng chọn app !');
			$('#cert_id').focus();
			return false;
		}
		if(_bunlderid==0){
			alert('Vui lòng nhập Bundle ID !');
			$('#cbo_bunlderid').focus();
			return false;
		}
		if(_bundle==''){
			alert('Vui lòng nhập Bundle ID !');
			$('#bundleidentifier').focus();
			return false;
		}
		if(_cbo_p5_msv==0){
			alert('Vui lòng chọn Msv!');
			$('#cbo_p5_msv').focus();
			return false;
		}
		if(_ch==''){
			alert('Không bỏ trống chuỗi Channel !');
			$('#channel').focus();
			return false;
		}
		/*if(_sdk==0){
			alert('Vui lòng chọn SDK version !');
			$('#cbo_sdk').focus();
			return false;
		}*/
		//check network
		$.ajax({
            url:baseUrl+'?control=signhistoryapp&func=checknetwork',
            type:"GET",
            data:{id_address:'1'},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
				$('.loading_warning').css('display','block');
            },
            success:function(f){
                if(f.error==0){
                    //Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $('.loading_warning').hide();
					onSubmitForm('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=".$_GET['func']; ?>');
                }else{
                   Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $('.loading_warning').hide();
                }
            }
        });
		
		
	}
	function getChannel(){
		_p1=$('#txt_p1').val();
		_p2=$('#txt_p2').val();
		_p3=$('#txt_p3').val();
		_p4=$('#txt_p4').val();
		_p5=$('#txt_p5').val();
		_p_cbo_5=$('#cbo_p5_msv').val().split('|');
		
		_channel=_p1+'|'+ _p2 + '|'+ _p3 + '|'+ _p4 + '|' + _p_cbo_5[1] + '_' + _p5;
		$('#channel').val(_channel);
	}
    function showApp(id_game){
		_arr=id_game.split('|'); // _arr[0]:id_game ,_aar[1]: service_id
        $.ajax({
            url:baseUrl+'?control=signhistoryapp&func=showapp',
            type:"GET",
            data:{id_game:_arr[0]},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(f.error==0){
                    $(".loadapp").html(f.html);
                    $("input[name=bundleidentifier],input[name=url_scheme]").val('');
                    $('.loading_warning').hide();
					//showMsv(_arr[1]);
                }else{
                    $(".loadapp").html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
	 function showMsv(service_id,type_app,bunlde_name,cert_id){
        $.ajax({
            url:baseUrl+'?control=signhistoryapp&func=showmsv',
            type:"GET",
            data:{service_id:service_id,type_app:type_app,bunlde_name:bunlde_name,cert_id:cert_id},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(f.error==0){
                    $(".cbo_msv").html(f.html);
                    $('.loading_warning').hide();
                }else{
                    $(".cbo_msv").html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
	
    function showValue(cert_id){
		//xóa dữ liệu cũ
		$("input[name=bundleidentifier_appstore],input[name=url_scheme_appstore],input[name=url_scheme]").val('');
		// xóa msv trước đó
		showMsv(0,'','',0);
		//
		//lấy tên bảng app gán vào control cert_name_text
		$('#cert_name_text').val($('#cert_id option:selected').text());
		
		var id_game=$('#id_game').val();
		if(id_game==0){
			alert('Vui lòng chọn game');
			$('#id_game').focus();
			return;
		}
		//goi hàm lấy bunlder
		getBunlderid(cert_id);
		
		_val=$('#cert_id').val();
		_idpartner=$('#cbo_partner').val().split('|');
		if(_val==0){
			return false;
		}
		
		/*if(_val==1 || _val==2){
			//appstore,Appstore dev
			 $("input[name=txt_p1]").val(2);
			 $("input[name=txt_p4]").val('Appstore');
			  $("input[name=txt_p5]").val('store');
		}else{
			// inhouse
			$("input[name=txt_p1]").val(1);
			$("input[name=txt_p4]").val('Ent');
			$("input[name=txt_p5]").val('file');
		}*/
		
        var id_game = $("select[name=id_game]").val().split('|');
		var type_app = $("#cert_id").val();
		var type_app_value=$("#cert_id option:selected").text();
		if(type_app_value =='AppstoreDev' || type_app_value =='Appstore'){
			//appstore,Appstore dev
			 $("input[name=txt_p1]").val(2);
			 $("input[name=txt_p4]").val('Appstore');
			  $("input[name=txt_p5]").val('store');
		}else{
			// inhouse
			$("input[name=txt_p1]").val(1);
			$("input[name=txt_p4]").val('Ent');
			$("input[name=txt_p5]").val('file');
		}
		
        $.ajax({
            url:baseUrl+'?control=signhistoryapp&func=showvalue',
            type:"GET",
            data:{cert_id:cert_id,id_game:id_game[0],idpartner:_idpartner[0]},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(f.error==0){
					//showMsv(id_game[0],type_app_value);
                //$("input[name=bundleidentifier],input[name=url_scheme]").val(f.bundleidentifier);
				$("input[name=bundleidentifier_appstore],input[name=url_scheme_appstore]").val(f.bundleidentifier_hide);
                    $('.loading_warning').hide();
                }
            }
        });
    }
	function getBunlderid(_cert_id){
		var _id_game_arr=$('#id_game').val().split('|');
		//_id_game_arr[1] là service_id,_id_game_arr[0] là id. Trong bảng scopes
		// vd : game iwinmobo trong bảng scopes có : service_id:118 , id:81
		var _id_game=_id_game_arr[0];
		var _platform='ios';
			$.ajax({
				url:baseUrl+'?control=signhistoryapp&func=getbunlderid',
				type:"GET",
				data:{id_game:_id_game,platform:_platform,cert_id:_cert_id},
				async:false,
				dataType:"json",
				beforeSend:function(){
					$('.loading_warning').show();
				},
				success:function(f){
					if(f.error==0){
						$("#cbo_bunlderid").html(f.html);
						$('.loading_warning').hide();
					}else{
						$("#cbo_bunlderid").html(f.html);
						$('.loading_warning').hide();
					}
				}
			});
		
	}
	function setBunlderId(_value){
		$('#bundleidentifier_appstore').val(_value);
		$('#url_scheme_appstore').val(_value);
		$('#bundleidentifier').val(_value)
		$('#url_scheme').val(_value);
		
		//get msv
		var id_game = $("select[name=id_game]").val().split('|');
		var _cert_id = $("#cert_id").val();
		var type_app_value=$("#cert_id option:selected").text();
		
		//nếu partner là Mecorp với partner_id=1
		/*if(type_app_value=="AppstoreDev"){
			_cert_id=2;
			type_app_value='Appstore';
		}*/
		showMsv(id_game[1],type_app_value,_value,_cert_id);
		//
		//$('#bundleidentifier_appstore').val(_value);
		//$('#url_scheme_appstore').val(_value);
	}
    function getCert(_idPartner){
			var _array=_idPartner.split('|');
			var _idP=_array[0];
			$.ajax({
				url:baseUrl+'?control=signhistoryapp&func=getcert',
				type:"GET",
				data:{idPartner:_idP},
				async:false,
				dataType:"json",
				beforeSend:function(){
					$('.loading_warning').show();
				},
				success:function(f){
					if(f.error==0){
						$("#cert_id").html(f.html);
						$('.loading_warning').hide();
					}else{
						$("#cert_id").html(f.html);
						$('.loading_warning').hide();
					}
				}
			});
	}
	
	function popitup(url,windowName) {
		var left = (screen.width/2)-(700/2);
  		var top = (screen.height/2)-(600/2);
       newwindow=window.open(url,windowName,'height=480,width=700,menubar=no,scrollbars=no, resizable=no,toolbar=no, location=no, directories=no, status=no, menubar=no,top='+top+', left='+left);
       if (window.focus) {newwindow.focus()}
       return false;
     }
	
	//up date 18/01/2016
	var status=0;
	function addSign(){
		//kiem tra dong trong trong table
		var _file_ipa = $('#ipa_file').val();
		var msv = $('#cbo_p5_msv').val();
		
		var r1 = $('#txt_cert_1').val();
		var r2 = $('#txt_cert_2').val();
		var r3 = $('#txt_cert_3').val();
		
		var b1 = $('#txt_bunlde_1').val();
		var b2 = $('#txt_bunlde_2').val();
		var b3 = $('#txt_bunlde_3').val();
		
		if(_file_ipa == ''){
			alert('Vui lòng chọn File IPA');
			return false;
		} //end if
		
		if(msv != 0){
			if(r1 == '' ){
				$('#row_1').css('display','table-row');
				$('#txt_cert_id_1').val($("#cert_id").val())
				$('#txt_cert_1').val($("#cert_id option:selected").text());
				$('#txt_bunlde_1').val($('#cbo_bunlderid').val());
				$('#txt_msv_1').val($('#cbo_p5_msv option:selected').text());
				$('#txt_msv_id_1').val($('#cbo_p5_msv').val());
				$('#txt_channel_1').val($('#channel').val());
				$('#btn_Sign').removeAttr('disabled');
				status++;
			}else if(r2 == '' ){
				$('#row_2').css('display','table-row');
				$('#txt_cert_id_2').val($("#cert_id").val())
				$('#txt_cert_2').val($("#cert_id option:selected").text());
				$('#txt_bunlde_2').val($('#cbo_bunlderid').val());
				$('#txt_msv_2').val($('#cbo_p5_msv option:selected').text());
				$('#txt_msv_id_2').val($('#cbo_p5_msv').val());
				$('#txt_channel_2').val($('#channel').val());
				status++;
				//kiem tra trung
				r1 = $('#txt_cert_1').val();
				r2 = $('#txt_cert_2').val();
				b1 = $('#txt_bunlde_1').val();
				b2 = $('#txt_bunlde_2').val();
				if(r1==r2 && b1==b2){
					$('#row_2').css('display','none');
					$('#txt_cert_id_2').val('')
					$('#txt_cert_2').val('');
					$('#txt_bunlde_2').val('');
					$('#txt_msv_2').val('');
					$('#txt_msv_id_2').val('');
					$('#txt_channel_2').val('');
					status--;
				}
				
			}else if(r3 == '' ){
				$('#row_3').css('display','table-row');
				$('#txt_cert_id_3').val($("#cert_id").val())
				$('#txt_cert_3').val($("#cert_id option:selected").text());
				$('#txt_bunlde_3').val($('#cbo_bunlderid').val());
				$('#txt_msv_3').val($('#cbo_p5_msv option:selected').text());
				$('#txt_msv_id_3').val($('#cbo_p5_msv').val());
				$('#txt_channel_3').val($('#channel').val());
				status++;
				
				//kiem tra trung
				r1 = $('#txt_cert_1').val();
				r2 = $('#txt_cert_2').val();
				r3 = $('#txt_cert_3').val();
				
				b1 = $('#txt_bunlde_1').val();
				b2 = $('#txt_bunlde_2').val();
				b3 = $('#txt_bunlde_3').val();
				
				if((r1==r3 && b1==b3) || (r2==r3 && b2==b3)){
					$('#row_3').css('display','none');
					$('#txt_cert_id_3').val('')
					$('#txt_cert_3').val('');
					$('#txt_bunlde_3').val('');
					$('#txt_msv_3').val('');
					$('#txt_msv_id_3').val('');
					$('#txt_channel_3').val('');
					status--;
				}
			}
			
		}else{
			alert('Vui lòng chọn Msv');
			return false;
		}//end if
		
	} //end func
	
	function clearSign(id){
		status--;
		$('#row_' + id).css('display','none');
		$('#txt_cert_id_' + id).val('')
		$('#txt_cert_' + id).val('');
		$('#txt_bunlde_' + id).val('');
		$('#txt_msv_' + id).val('');
		$('#txt_channel_' + id).val('');
		if(status==0){
			$('#btn_Sign').attr('disabled','disabled');
		}
	}
	
	function ExeSign(){
		var r1 = $('#txt_cert_1').val();
		var r2 = $('#txt_cert_2').val();
		var r3 = $('#txt_cert_3').val();
		if(r1 == '' && r2 == '' && r3 == ''){
			alert('Vui lòng chọn thông tin');
			return false;
		}else{
			$('.loading_warning').show();
			//alert('Nhấn nút OK để thực hiện');
		}
	}
    $(function(){
		$("#id_game").change(function(){
			var id_game = $(this).val().split('|');
			if(id_game[3]=='global'){
				$("input[name=txt_p2]").val('global');
			}else{
				$("input[name=txt_p2]").val('me');
			}
		});
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