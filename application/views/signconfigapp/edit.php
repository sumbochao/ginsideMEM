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
                    <label for="menu_group_id">Chọn Platform</label>
                    <span class="loadapp">
                        <select name="cbo_platform" id="cbo_platform" onchange="showinterface(this.value);">
                            <option value="0">Chọn Platform</option>
                            <?php
                                if(count($loadplatform)>0){
                                    foreach($loadplatform as $key=>$value){
										if($items['platform']==$key){
                            ?>
                            <option value="<?php echo $key;?>" <?php echo $items['platform']==$key?'selected="selected"':'';?>><?php echo $value;?></option>
                            <?php
										}
                                    }
                                }
                            ?>
                        </select>
                    </span>
                    <div class="option_error">
                        <?php echo $errors['cbo_platform'];?>
                    </div>
                </div>
            	<div class="rows">	
                    <label for="menu_group_id">Chọn holder</label>
                    <select name="cbo_partner" id="cbo_partner" class="chosen-select" tabindex="2" data-placeholder="Chọn holder" onchange="getCert(this.value);">
                            <option value="null">Chọn holder</option>
                             <?php
                            if(count($partner)>0){
                                foreach($partner as $v){
									if($items['idpartner']==$v['id']){
                        ?>
                        <option value="<?php echo $v['id']."|".$v['partner'];?>" <?php echo $items['idpartner']==$v['id']?"selected":""; ?> ><?php echo $v['partner'];?></option>
                        <?php
									}
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
									if($items['id_game']==$v['id']){
                        ?>
                        <option value="<?php echo $v['id']."|".$v['service'];?>" <?php echo $items['id_game']==$v['id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                        <?php
									}
                                }
                            }
                        ?>
                    </select>
                    <div class="option_error">
                        <?php echo $errors['id_game'];?>
                    </div>
                     <input type="hidden" name="cert_name_app" id="cert_name_app" />
                </div>
                <div class="rows" id="view_Cert_A_WP" style="display:none;">
                    <label for="menu_group_id">Bảng app</label>
                    <select name="cert_id_a_wp" id="cert_id_a_wp" data-placeholder="Chọn bảng app" onchange="$('#cert_name_app').val($('#cert_id_a_wp option:selected').text());getBundle(<?php echo $_GET['id']; ?>);">
                        <option value="0">Chọn bảng app</option>
							<option value="1" <?php echo $items['cert_id']=='1'?'selected="selected"':'';?> >GooglePlay/WinStore</option>
							<option value="3" <?php echo $items['cert_id']=='3'?'selected="selected"':'';?>>Inhouse</option>
                    </select>
                    <div class="option_error">
                        <?php echo $errors['cert_id_a_wp'];?>
                    </div>
                </div>
                <div class="rows" id="view_Cert" style="display:none;">
                    <label for="menu_group_id">Bảng app</label>
                    <select name="cert_id" id="cert_id" data-placeholder="Chọn bảng app" onchange="$('#cert_name_app').val($('#cert_id option:selected').text());getBundle(<?php echo $_GET['id']; ?>)">
                        <option value="0">Chọn bảng app</option>
                    	<?php
						 if($_GET['func'] == 'edit'){
							if(count($cert_type)>0){
								foreach($cert_type as $v){
									if($items['cert_id']==$v['id']){
						?>
						<option value="<?php echo $v['id'];?>" <?php echo $items['cert_id']==$v['id']?'selected="selected"':'';?> ><?php echo $v['cert_type'];?></option>
						<?php
									}
								} //end for
							} //end if
						 } //end if edit
						?>
                    </select>
                    <div class="option_error">
                        <?php echo $errors['cert_id'];?>
                    </div>
                </div>
                <div class="rows" id="view_Provision" style="display:none;">	
                    <label for="menu_group_id">Provision</label>
                    <input type="file" name="provision" id="provision" accept=".mobileprovision"/>
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
                <div class="rows" id="view_Entitlements" style="display:none;">	
                    <label for="menu_group_id">Entitlements</label>
                    <input type="file" name="entitlements" id="entitlements" accept=".plist"/>
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
                <!--<div class="rows">	
                    <label for="menu_group_id" id="lbl_buldeid">Bundle ID</label>
                    <input type="text" name="bundleidentifier" id="bundleidentifier" class="textinput" value="<?php echo $items['bundleidentifier'];?>"/>
                    <?php echo $errors['bundleidentifier'];?>
                </div>-->
                <div class="rows">	
                    <label for="menu_group_id" id="lbl_buldeid">Bundle ID</label>
                    <select name="cbo_bundleidentifier" id="cbo_bundleidentifier" style="width:300px;">
                            <option value="0"> --- Chọn --- </option>
                   </select>
                    <div class="option_error">
                       <?php echo $errors['bundleidentifier'];?>
                    </div>
                </div>
               <div class="rows" id="view_clientid_google" style="display:none;">	
                    <label for="menu_group_id" id="lbl_buldeid">Client ID G+</label>
                    <input type="text" name="clientid_google" id="clientid_google" class="textinput" value="<?php echo $items['clientid_google'];?>"/>
                    <?php echo $errors['clientid_google'];?>
                </div>
                <div class="rows" id="view_url_scheme_google" style="display:none;">	
                    <label for="menu_group_id" id="lbl_buldeid">URL Scheme G+</label>
                    <input type="text" name="url_scheme_google" id="url_scheme_google" class="textinput" value="<?php echo $items['url_scheme_google'];?>"/>
                    <?php echo $errors['url_scheme_google'];?>
                </div>
               
            </div>
            <div class="group_right">
                
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>
<script type="text/javascript">
	showinterface('<?php echo $items['platform']; ?>');
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
	
	function showinterface(_platform){
		switch(_platform){
			case 'ios':
				$('#view_Provision').css('display','block');
				$('#view_Entitlements').css('display','block');
				$('#view_Cert').css('display','block');
				$('#view_Cert_A_WP').css('display','none');
				$('#lbl_buldeid').text('BundleID');
				$('#entitlements-content').css('display','block');
				$('#provision-content').css('display','block');
				//$('#view_clientid_google').css('display','block');
				//$('#view_url_scheme_google').css('display','block');
				break;
			case 'android':
				$('#view_Provision').css('display','none');
				$('#view_Entitlements').css('display','none');
				$('#view_Cert').css('display','none');
				$('#view_Cert_A_WP').css('display','block');
				$('#lbl_buldeid').text('Package Name');
				$('#entitlements-content').css('display','none');
				$('#provision-content').css('display','none');
				//$('#view_clientid_google').css('display','none');
				//$('#view_url_scheme_google').css('display','none');
				break;
			case 'wp':
				$('#view_Provision').css('display','none');
				$('#view_Entitlements').css('display','none');
				$('#view_Cert').css('display','none');
				$('#view_Cert_A_WP').css('display','block');
				$('#lbl_buldeid').text('Package Identity');
				$('#entitlements-content').css('display','none');
				$('#provision-content').css('display','none');
				//$('#view_clientid_google').css('display','none');
				//$('#view_url_scheme_google').css('display','none');
				break;
			default:
				$('#view_Provision').css('display','none');
				$('#view_Entitlements').css('display','none');
				$('#view_Cert').css('display','none');
				$('#view_Cert_A_WP').css('display','none');
				$('#entitlements-content').css('display','none');
				$('#provision-content').css('display','none');
				//$('#view_clientid_google').css('display','none');
				//$('#view_url_scheme_google').css('display','none');
				break;
		};
	}
	setdefault();
	getBundle(<?php echo $_GET['id']; ?>);
	function setdefault(){
		pl=$('#cbo_platform').val();
		if(pl=='ios'){
			$('#cert_name_app').val($('#cert_id option:selected').text());
		}else{
			$('#cert_name_app').val($('#cert_id_a_wp option:selected').text());
		}
	}
	function getBundle(id){
		var _id_game_arr=$('#id_game').val().split('|');
		//_id_game_arr[1] là service,_id_game_arr[0] là id. Trong bảng scopes
		// vd : game iwinmobo trong bảng scopes có : service_id:118 , id:81
		var _id_game=_id_game_arr[0];
		//truong hop game Mong Giang Ho , service ko giong voi servicekey projects
		var _service=_id_game_arr[1]=='monggiangho'?'mgh':_id_game_arr[1];
		var _platform=$('#cbo_platform').val();
		var _cert_name=$('#cert_name_app').val();
		//alert(_cert_name + ';' + _id_game[0] + ';' + _service + ';' + _platform );
			$.ajax({
				url:baseUrl+'?control=signconfigapp&func=getbundle',
				type:"GET",
				data:{id:id,id_game:_id_game,platform:_platform,cert_name:_cert_name,service:_service},
				async:false,
				dataType:"json",
				beforeSend:function(){
					$('.loading_warning').show();
				},
				success:function(f){
					if(f.error==0){
						$("#cbo_bundleidentifier").html(f.html);
						$('.loading_warning').hide();
					}else{
						$("#cbo_bundleidentifier").html(f.html);
						$('.loading_warning').hide();
					}
				}
			});
		
	}
	function checknull(_id){
		var platform=$('#cbo_platform').val();
		var partner=$('#cbo_partner').val();
		var idgame=$('#id_game').val();
		var cert_id_a_wp=$('#cert_id_a_wp').val();
		var cert_id=$('#cert_id').val();
		var provision=$('#provision').val();
		var entitlements=$('#entitlements').val();
		var bundleidentifier=$('#cbo_bundleidentifier').val();
		
		if(platform==0){
			alert('Vui lòng chọn Platform');
			$('#cbo_platform').focus();
			return;
		}
		if(partner=='null'){
			alert('Vui lòng chọn Holder');
			$('#cbo_partner').focus();
			return;
		}
		if(idgame==0){
			alert('Vui lòng chọn Game');
			$('#id_game').focus();
			return;
		}
		if(platform=='ios'){
				clientid_google=$('#clientid_google').val();
				url_scheme_google=$('#url_scheme_google').val();
				if(cert_id==0){
					alert('Vui lòng chọn Cert');
					$('#cert_id').focus();
					return;
				}
				/*if(clientid_google==''){
					alert('Vui lòng chọn Client ID G+');
					$('#clientid_google').focus();
					return;
				}
				if(url_scheme_google==''){
					alert('Vui lòng chọn URL Scheme G+');
					$('#url_scheme_google').focus();
					return;
				}*/
			
		}else{
				if(cert_id_a_wp==0){
					alert('Vui lòng chọn Cert');
					$('#cert_id_a_wp').focus();
					return;
				}
		}
		if(bundleidentifier==0){
			alert('Vui lòng chọn bundleidentifier');
			$('#cbo_bundleidentifier').focus();
			return;
		}
		onSubmitForm('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&id="; ?>' + _id)
	}
</script>