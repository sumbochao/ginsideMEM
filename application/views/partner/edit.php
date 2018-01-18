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
                    <label for="menu_group_id">Tên đối tác</label>
                    <input type="text" name="partner" id="partner" class="textinput" value="<?php echo $_GET['partner'];?>"/>
                </div>
                <div class="rows">
                    <label for="menu_group_id">Url</label>
                    <input type="text" name="link_url" id="link_url" class="textinput" value="<?php echo base64_decode($_GET['link_url']);?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Ghi chú</label>
                    <textarea name="notes" maxlength="125" id="notes" cols="30" rows="5" style="width:310px;height:150px;resize:none;"><?php echo base64_decode($_GET['notes']);?></textarea>
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
		var _partner=$('#partner').val();
		if(_partner==''){
			alert('Không bỏ trống Tên đối tác !');
			$('#partner').focus();
			return false;
		}
		onSubmitForm('appForm','<?=base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&id=".$_GET['id']."&act=action"?>');
	}
</script>