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
<div class="loading_warning"></div>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset" class="groupsignios">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
            	<div class="rows">	
                    <label for="menu_group_id">Thông tin Msv_</label>
                    <input type="text" name="txt_msv" id="txt_msv" class="textinput" value="" maxlength="10" onkeypress="return checkInp();" onkeydown="return checkInp();" />
             
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Chọn game</label>
                    <input type="hidden" name="cbo_app_hiden" id="cbo_app_hiden" />
                    <select name="cbo_app" id="cbo_app" onchange="gettext();">
                            <option value="0">Chọn game</option>
                            <?php
                                if(count($loadgame)>0){
                                    foreach($loadgame as $v){
                            ?>
                            <option value="<?php echo $v['service_id'];?>" <?php echo (isset($_GET['service_id']) && ($_GET['service_id']==$v['service_id'])) || ($_POST['cbo_app']==$v['service_id'])?"selected":"" ?> ><?php echo $v['app_fullname'];?></option>
                            <?php
                                    }
                                }
                            ?>
                   </select>
                    <div class="option_error">
                       
                    </div>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Chọn Platform</label>
                    <span class="loadapp">
                        <select name="cbo_platform" id="cbo_platform" onchange="getCert(this.value);">
                            <option value="0">Chọn Platform</option>
                            <?php
                                if(count($loadplatform)>0){
                                    foreach($loadplatform as $key=>$value){
                            ?>
                            <option value="<?php echo $key;?>" <?php echo $_POST['cbo_platform']==$value?"selected":""; ?> ><?php echo $value;?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </span>
                    <div class="option_error">
                        
                    </div>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Chọn Status</label>
                    <select name="cbo_status" id="cbo_status">
                        <option value="0">Chọn Status</option>
                        <?php
                            if(count($loadstatus)>0){
                                foreach($loadstatus as $key=>$value){
                        ?>
                        <option value="<?php echo $key;?>" <?php echo $_POST['cbo_status']==$value?"selected":""; ?> ><?php echo $value;?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <div class="option_error"></div>
                </div>  
                <div class="rows">	
                    <label for="menu_group_id">Chọn App</label>
                   <!-- <select name="cbo_type_app" id="cbo_type_app">
                        <option value="0">Chọn App</option>
                         <?php
                                if(count($slbTable)>0){
                                    foreach($slbTable as $v){
                            ?>
                            <option value="<?php echo trim($v['cert_type']);?>"><?php echo $v['cert_type'];?></option>
                            <?php
                                    }
                                }
                            ?>
                    </select> -->
                    <input type="hidden" name="cbo_type_app_text" id="cbo_type_app_text" />
                    <select name="cbo_type_app" id="cbo_type_app" onchange="getBunlderid(this.value)">
                        <option value="0">Chọn App</option>
                         <!--<option value="Appstore dev">Appstore dev</option>
                         <option value="Appstore">Appstore</option>
                         <option value="Inhouse">Inhouse</option>-->
                    </select>
                    <div class="option_error"></div>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">BunlderID</label>
                    <select name="cbo_bunlderid" id="cbo_bunlderid">
                            <option value="0"> --- Chọn --- </option>
                   </select>
                    <div class="option_error">
                       
                    </div>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Tình trạng (Published)</label>
                    <select name="cbo_published" id="cbo_published">
                        <option value="0">Chọn tình trạng</option>
                        	<option value="waiting">Waiting For Publish</option>
                            <option value="yes">Yes</option>
                            <option value="no" selected="selected">No</option>
                    </select>
                    <div class="option_error"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <div id="adminfieldset" class="groupsignios space">
            <div class="adminheader">Ghi chú</div>
            <div class="group_left">
               
                <div class="rows">	
                    <label for="menu_group_id">Nội dung</label>
                    <textarea name="notes" maxlength="1000" id="notes" cols="30" rows="5" style="width:500px;height:150px;resize:none;"><?php echo $_POST['notes']; ?></textarea>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ngày Publish</label>
          			<input type="text" id="datepublish" name="datepublish" value="" class="datepicker">
                </div>
                
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
        <strong style="color:#F00">
        <?php
			echo $error;
		 ?>
         </strong>
    </form>
    
</div>
<script type="text/javascript">
$(document).ready(function () {
        $('input[name=datepublish]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
		});
 });
function checkInp()
{
  var x=document.getElementById('txt_msv').value;
  if (isNaN(x)) 
  {
    $('#txt_msv').val('');
	return false;
  }
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
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode > 31 && (charCode < 48 || charCode > 57)){
		return false;
	}
	
    return true;
}
function isNumber1(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
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
	function gettext(){
		var _tex=$('#cbo_app option:selected').text();
		document.getElementById('cbo_app_hiden').value=_tex;
	}
	function checkdatatext(){
		var _val=$('#txt_msv').val();
		var _cbo_app=$('#cbo_app').val();
		var _cbo_platform=$('#cbo_platform').val();
		var _cbo_status=$('#cbo_status').val();
		var _cbo_type_app=$('#cbo_type_app').val();
		var _bunlderid=$('#cbo_bunlderid').val();
		var _cbo_published=$('#cbo_published').val();
		if(_val==''){
			alert('Không bỏ trống Me Store Version (Msv_)!');
			$('#txt_msv').focus();
			return false;
		}
		if(_cbo_app==0){
			alert('Không bỏ trống Game!');
			$('#cbo_app').focus();
			return false;
		}
		if(_cbo_platform==0){
			alert('Không bỏ trống Platform!');
			$('#cbo_platform').focus();
			return false;
		}
		if(_cbo_status==0){
			alert('Không bỏ trống Status!');
			$('#cbo_status').focus();
			return false;
		}
		if(_cbo_type_app==0){
			alert('Không bỏ trống Chọn App!');
			$('#cbo_type_app').focus();
			return false;
		}
		if(_bunlderid==0){
			alert('Không bỏ trống Bunlder!');
			$('#cbo_bunlderid').focus();
			return false;
		}
		if(_cbo_published==0){
			alert('Không bỏ trống Tình trạng!');
			$('#cbo_published').focus();
			return false;
		}
		
			onSubmitForm('appForm','<?=base_url()."?control=".$_GET['control']."&func=".$_GET['func']?>');
			return true;
	}
    function showApp(id_game){
        $.ajax({
            url:baseUrl+'?control=signhistoryapp&func=showapp',
            type:"GET",
            data:{id_game:id_game},
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
                }else{
                    $(".loadapp").html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
    function showValue(cert_id){
        var id_game = $("select[name=id_game]").val();
        $.ajax({
            url:baseUrl+'?control=signhistoryapp&func=showvalue',
            type:"GET",
            data:{cert_id:cert_id,id_game:id_game},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(f.error==0){
                    $("input[name=bundleidentifier],input[name=url_scheme]").val(f.bundleidentifier);
                    $('.loading_warning').hide();
                }
            }
        });
    }
    function getCert(_platform){
			var _id_game=$('#cbo_app').val();
			if(_id_game==0){
				alert('Vui lòng chọn Game!');
				$('#cbo_app').focus();
				return;
			}
			$.ajax({
				url:baseUrl+'?control=mestoreversion&func=getcert',
				type:"GET",
				data:{id_game:_id_game,platform:_platform},
				async:false,
				dataType:"json",
				beforeSend:function(){
					$('.loading_warning').show();
				},
				success:function(f){
					if(f.error==0){
						$("#cbo_type_app").html(f.html);
						$('.loading_warning').hide();
					}else{
						$("#cbo_type_app").html(f.html);
						$('.loading_warning').hide();
					}
				}
			});
	}
	function getBunlderid(_cert_id){
		var _id_game=$('#cbo_app').val();
		if(_id_game==0){
			alert('Vui lòng chọn Game!');
			$('#cbo_app').focus();
			return;
		}
		var _platform=$('#cbo_platform').val();
		name_type_app=$('#cbo_type_app option:selected').text().split('-');
		$('#cbo_type_app_text').val(name_type_app[0]);
			$.ajax({
				url:baseUrl+'?control=mestoreversion&func=getbunlderid',
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