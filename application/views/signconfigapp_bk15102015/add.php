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
                    <label for="menu_group_id">Chọn holder</label>
                    <select name="cbo_partner" id="cbo_partner" class="chosen-select" tabindex="2" data-placeholder="Chọn holder" onchange="getCert(this.value);">
                            <option value="null">Chọn holder</option>
                             <?php
                            if(count($partner)>0){
                                foreach($partner as $v){
                        ?>
                        <option value="<?php echo $v['id']."|".$v['partner'];?>" <?php echo $items['idpartner']==$v['id']?"selected":""; ?> ><?php echo $v['partner'];?></option>
                        <?php
                                }
                            }
                        ?>
                   </select>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="id_game" class="chosen-select" tabindex="2" data-placeholder="Chọn danh mục">
                        <option value="0">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                        ?>
                        <option value="<?php echo $v['id'];?>" <?php echo $items['id_game']==$v['id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
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
                    <label for="menu_group_id">Bảng app</label>
                    <select name="cert_id" id="cert_id" data-placeholder="Chọn bảng app">
                        <option value="0">Chọn bảng app</option>
                    	<?php
						 if($_GET['func'] == 'edit'){
							if(count($cert_type)>0){
								foreach($cert_type as $v){
						?>
						<option value="<?php echo $v['id'];?>" <?php echo $items['cert_id']==$v['id']?'selected="selected"':'';?> ><?php echo $v['cert_type'];?></option>
						<?php
								} //end for
							} //end if
						 } //end if edit
						?>
                    </select>
                    <div class="option_error">
                        <?php echo $errors['cert_id'];?>
                    </div>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Provision</label>
                    <input type="file" name="provision" accept=".mobileprovision"/>
                    <div class="option_error"><?php echo $errors['provision'];?></div>
                </div>
                <?php
                    if($_GET['func'] == 'edit'){
                        $current_provision = '<div id="provision-content">';
                        if(!empty($items['provision'])){
                            $arrFile = explode('.', $items['provision']);
                            switch ($arrFile[1]){
                                default :
                                    $provisionUrl = APPLICATION_URL . '/assets/img/provision.png';
                                    break;
                            }
                            $removeLink = base_url('?control=signconfigapp&func=remove_provision&id='.$items['id'].'&file='.$items['provision']);
                            $current_provision .= '
                                <div class="rows">
                                    <label for="menu_group_id">File provision</label>
                                    <img src="' . $provisionUrl . '" class="img_banner" height="100"/>
                                </div>';
                            $current_provision .='<div class="rows">
                                                    <label for="menu_group_id"></label>
                                                    <a href="javascript:loadPage(\'div#provision-content\',\'' . $removeLink . '\')">Xóa</a> | 
                                                    <a href="'.base_url('?control=signconfigapp&func=download&id='.$items['id'].'&file='.$items['provision']).'">Tải</a>
                                                </div>
                                                ';
                        }

                        $current_provision .= '<input type="hidden" name="current_provision" value="'.$items['provision'].'"/>'
                                                        . '</div>';
                        $provision .=	$current_provision;
                    }
                    echo $provision;
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Entitlements</label>
                    <input type="file" name="entitlements" accept=".plist"/>
                    <div class="option_error"><?php echo $errors['entitlements'];?></div>
                </div>
                <?php
                    if($_GET['func'] == 'edit'){
                        $current_entitlements = '<div id="entitlements-content">';
                        if(!empty($items['entitlements'])){
                            $arrFile = explode('.', $items['entitlements']);
                            switch ($arrFile[1]){
                                default :
                                    $entitlementsUrl = APPLICATION_URL . '/assets/img/plist.jpg';
                                    break;
                            }
                            $removeLink = base_url('?control=signconfigapp&func=remove_entitlements&id='.$items['id'].'&file='.$items['entitlements']);
                            $current_entitlements .= '
                                <div class="rows">
                                    <label for="menu_group_id">File Plist</label>
                                    <img src="' . $entitlementsUrl . '" class="img_banner" height="100"/>
                                </div>';
                            $current_entitlements .='<div class="rows">
                                                    <label for="menu_group_id"></label>
                                                    <a href="javascript:loadPage(\'div#entitlements-content\',\'' . $removeLink . '\')">Xóa</a> | 
                                                    <a href="'.base_url('?control=signconfigapp&func=download&id='.$items['id'].'&file='.$items['entitlements']).'">Tải</a>
                                                </div>
                                                ';
                        }

                        $current_entitlements .= '<input type="hidden" name="current_entitlements" value="'.$items['entitlements'].'"/>'
                                                        . '</div>';
                        $entitlements .=	$current_entitlements;
                    }
                    echo $entitlements;
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Bundle ID</label>
                    <input type="text" name="bundleidentifier" class="textinput" value="<?php echo $items['bundleidentifier'];?>"/>
                    <?php echo $errors['bundleidentifier'];?>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1"  <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
                </div>
                <?php
                    if($_GET['func']=='edit'){
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Sắp xếp</label>
                    <input type="text" name="order" class="textinput" value="<?php echo $items['order'];?>"/>
                </div>
                <?php } ?>
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
	
	function getCert(_idPartner){
			var _array=_idPartner.split('|');
			var _idP=_array[0];
			$.ajax({
				url:baseUrl+'?control=signconfigapp&func=getcert',
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
</script>