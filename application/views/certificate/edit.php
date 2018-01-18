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
                        <option value="<?php echo $v['id']."|".$v['partner'];?>" <?php echo $items['idpartner']==$v['id']?'selected':'';?> ><?php echo $v['partner'];?></option>
                        <?php
                                }
                            }
                        ?>
                   </select>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Loại Cert</label>
                    <!--<input type="text" name="cert_type" id="cert_type" class="textinput" value="<?php echo $items['cert_type']; ?>"/> -->
					<select name="cert_type" id="cert_type" class="chosen-select" tabindex="2" data-placeholder="Chọn Cert">
                            <option value="AppstoreDev" <?php echo $items['cert_type']=="AppstoreDev"?"selected":""; ?> >AppstoreDev</option>
                            <option value="Appstore" <?php echo $items['cert_type']=="Appstore"?"selected":""; ?>>Appstore</option>
                            <option value="Inhouse" <?php echo $items['cert_type']=="Inhouse"?"selected":""; ?>>Inhouse</option>
                   </select>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Tên Cert</label>
                    <textarea class="textarea" name="cert_name" id="cert_name"><?php echo $items['cert_name']; ?></textarea>
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
		var _cert_type=$('#cert_type').val();
		var _cert_name=$('#cert_name').val();
		if(_cbo_partner == 0){
			alert('Không bỏ trống !');
			$('#cbo_partner').focus();
			return false;
		}
		if(_cert_type == ''){
			alert('Không bỏ trống!');
			$('#cert_type').focus();
			return false;
		}
		if(_cert_name == ''){
			alert('Không bỏ trống!');
			$('#cert_name').focus();
			return false;
		}
		onSubmitForm('appForm','<?=base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&id=".$_GET['id']."&action=1"; ?>');
	}
</script>