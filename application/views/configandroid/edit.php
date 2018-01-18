<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php'; ?>
        <div id="adminfieldset">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
            	<div class="rows">	
                    <label for="menu_group_id">Chọn holder</label>
                    <select name="cbo_partner" id="cbo_partner" class="chosen-select" tabindex="2" data-placeholder="Chọn holder">
                            <option value="0">Chọn holder</option>
                             <?php
                            if(count($partner)>0){
                                foreach($partner as $v){
                        ?>
                        <option value="<?php echo $v['id']."|".$v['partner'];?>" <?php echo $items['id_partner']==$v['id']?'selected':'';?> ><?php echo $v['partner'];?></option>
                        <?php
                                }
                            }
                        ?>
                   </select>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Key Store</label>
                    <textarea class="textarea" name="keystore" id="keystore"><?php echo $items['keystore']; ?></textarea>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Store Pass</label>
                    <textarea class="textarea" name="storepass" id="storepass"><?php echo $items['storepass']; ?></textarea>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Alias</label>
                    <input type="text" name="alias" id="alias" value="<?php echo $items['alias']; ?>" />
                </div>
                <div class="rows">	
                    <label for="menu_group_id"></label>
                    <input type="button" name="btnEdit" id="btnEdit" value="Lưu" onclick="checknull();" />
                </div>
          		 <div class="rows">	
                    <label for="menu_group_id"></label>
                    <div class="option_error"><?php echo $errors; ?></div>
                  
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>
<script type="text/javascript">
	function checknull(){
		var _cbo_partner=$('#cbo_partner').val();
		var _keystore=$('#keystore').val();
		var _storepass=$('#storepass').val();
		var _alias=$('#alias').val();
		if(_cbo_partner == 0){
			alert('Không bỏ trống !');
			$('#cbo_partner').focus();
			return false;
		}
		if(_keystore == ''){
			alert('Không bỏ trống!');
			$('#keystore').focus();
			return false;
		}
		if(_storepass == ''){
			alert('Không bỏ trống!');
			$('#storepass').focus();
			return false;
		}
		if(_alias == ''){
			alert('Không bỏ trống!');
			$('#alias').focus();
			return false;
		}
		onSubmitForm('appForm','<?=base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&id=".$_GET['id']."&action=1"; ?>');
	}
</script>