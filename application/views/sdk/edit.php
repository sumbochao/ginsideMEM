<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
            	<div class="rows">	
                    <label for="menu_group_id">SDK Version</label>
                    <input type="text" name="txt_sdk_version" id="txt_sdk_version" class="textinput" value="<?php echo $_GET['sdk'];?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Platform</label>
                    <select name="cbo_platform" id="cbo_platform">
                        <option value="0">Chọn Platform</option>
                        <?php
                            if(count($loadplatform)>0){
                                foreach($loadplatform as $key=>$value){
                        ?>
                        <option value="<?php echo $value;?>" <?php echo ($_GET['platform']==$value)?'selected':'';?>><?php echo $value;?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" maxlength="125" id="notes" cols="30" rows="5" style="width:310px;height:150px;resize:none;"><?php echo base64_decode($_GET['notes']);?></textarea>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" id="status_off" value="0" <?php echo (intval($_GET['status'])==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" id="status_on" value="1" <?php echo (intval($_GET['status'])==1)?'checked="checked"':'';?>/> Bật
                </div>
                <div class="option_error">
                       <strong style="color:#F00"><?php echo $errors;?></strong>
                </div>
            </div>
            <div class="group_right">
                
            </div>
            <div class="clr"></div>
        </div>
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

	function checknull(){
		var _ver=$('#txt_sdk_version').val();
		var _cbo_platform=$('#cbo_platform').val();
		if(_ver==''){
			alert('Không bỏ trống SDK Version !');
			$('#txt_sdk_version').focus();
			return false;
		}
		if(_cbo_platform==0){
			alert('Không bỏ trống Platform!');
			$('#cbo_platform').focus();
			return false;
		}
		onSubmitForm('appForm','<?=base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&id=".$_GET['id']."&act=action"?>');
	}
</script>