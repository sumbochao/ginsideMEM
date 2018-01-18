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
        <div id="adminfieldset" class="groupsignios" style="height:375px;">
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
                        <option value="<?php echo $v['id']."|".$v['partner'];?>" ><?php echo $v['partner'];?></option>
                        <?php
                                }
                            }
                        ?>
                   </select>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="id_game" id="id_game" class="chosen-select" tabindex="2" data-placeholder="Chọn danh mục" onchange="showApp(this.value)">
                        <option value="0">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                        ?>
                        <option value="<?php echo $v['id']."|".$v['service_id'];?>" <?php echo $items['id_game']==$v['id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
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
                    <span class="loadapp">
                        <select name="cert_id" id="cert_id" class="chosen-select" tabindex="2" data-placeholder="Chọn bảng app" onchange="showValue(this.value)">
                            <option value="0">Chọn bảng app</option>
                            <?php
                                if(count($slbTable)>0 && $items['id_game']>0){
                                    foreach($slbTable as $v){
                            ?>
                            <option value="<?php echo $v['id'];?>" <?php echo $items['cert_id']==$v['id']?'selected="selected"':'';?>><?php echo $v['cert_type'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </span>
                    <div class="option_error">
                        <?php echo $errors['cert_id'];?>
                    </div>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Chọn file Ipa</label>
                    <input type="file" name="ipa_file" accept=".ipa"/>
                    <div style="padding-left:152px;color:#F00;">Tên file không bao gồm ký tự lạ</div>
                    <div class="option_error"><?php echo $errors['certificate'];?></div>
                </div>
                <?php
                    if($_GET['func'] == 'edit'){
                        $current_certificate = '<div id="certificate-content">';
                        if(!empty($items['ipa_file'])){
                            $arrFile = explode('.', $items['certificate']);
                            switch ($arrFile[1]){
                                default :
                                    $certificateUrl = APPLICATION_URL . '/assets/img/ipa.png';
                                    break;
                            }
                            $removeLink = base_url('?control=signhistoryapp&func=remove&id='.$items['id'].'&file='.$items['ipa_file']);
                            $current_certificate .= '
                                <div class="rows">
                                    <label for="menu_group_id">File ipa</label>
                                    <img src="' . $certificateUrl . '" class="img_banner" height="100"/>
                                </div>';
                            $current_certificate .='<div class="rows">
                                                    <label for="menu_group_id"></label>
                                                    <a href="javascript:loadPage(\'div#certificate-content\',\'' . $removeLink . '\')">Xóa</a> | 
                                                    <a href="'.base_url('?control=signhistoryapp&func=download&id='.$items['id'].'&file='.$items['ipa_file']).'">Tải</a>
                                                </div>
                                                ';
                        }

                        $current_certificate .= '<input type="hidden" name="current_certificate" value="'.$items['ipa_file'].'"/>'
                                                        . '</div>';
                        $certificate .=	$current_certificate;
                    }
                    echo $certificate;
                ?>
                
                <?php
                    if($_GET['func']=='edit'){
                ?>
                <div class="rows">	
                    <label for="menu_group_id">Sắp xếp</label>
                    <input type="text" name="order" class="textinput" value="<?php echo $items['order'];?>"/>
                </div>
                <?php } ?>
                <div class="rows">	
                    <label for="menu_group_id">Bundle ID</label>
                    <input type="hidden" name="bundleidentifier_appstore" id="bundleidentifier_appstore" value="" maxlength="125"/>
                    <input type="text" name="bundleidentifier" id="bundleidentifier" class="txtbundleid textinput" value="<?php echo $items['bundleidentifier'];?>" maxlength="125"/>
                    <?php echo $errors['bundleidentifier'];?>
                </div>
                
                <div class="rows">	
                    <label for="menu_group_id">URL scheme</label>
                    <input type="hidden" name="url_scheme_appstore" id="url_scheme_appstore" value="" maxlength="125"/>
                    <input type="text" name="url_scheme" class="url_scheme textinput" value="<?php echo $items['url_scheme'];?>" maxlength="125"/>
                    <?php echo $errors['url_scheme'];?>
                </div>
                <div class="rows" style="display:none;">
                <label for="menu_group_id">Cấu trúc Channel</label>
                <input type="text" name="txt_p1" id="txt_p1" style="width:25px" maxlength="3" readonly="readonly" /> |
                <input type="text" name="txt_p2" id="txt_p2" style="width:36px;text-align:center" maxlength="10" value="me" readonly="readonly" /> |
                <input type="text" name="txt_p3" id="txt_p3" style="width:45px;text-align:center" maxlength="20" value="null" /> |
                <input type="text" name="txt_p4" id="txt_p4" style="width:85px;text-align:center" maxlength="80" readonly="readonly" /> |
                <input type="text" name="txt_p5" id="txt_p5" style="width:60px;text-align:center" maxlength="100" readonly="readonly" />
                </div>
                <div class="rows">
                    <div class="cbo_msv">
                    <label for="menu_group_id">Chọn Msv_</label>
                        <select name="cbo_p5_msv" id="cbo_p5_msv" style="width:150px;">
                            <option>Chọn Msv...</option>
                        </select> 
                     <a href="<?php echo base_url()."?control=mestoreversion&func=add"; ?>" title="Thêm Msv" target="_blank"> Tạo mới Msv</a>
                    </div>
                </div>

            </div>
            <div class="clr"></div>
        </div>
        <div id="adminfieldset" class="groupsignios space">
            <div class="adminheader">Nhập thông tin tùy chọn</div>
            <div class="group_left">
               
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
                     
                    </div>
                </div>
                
                <div class="rows">
                    <label for="menu_group_id">Channel</label>
                    <input type="text" name="channel" id="channel" class="textinput" value="<?php echo $items['channel'];?>" maxlength="125" <?php 
                if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    echo "";
                }else{
                    echo "readonly='readonly'";
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
                <!--<div class="rows">	
                    <label for="menu_group_id">URL scheme</label>
                    <input type="text" name="url_scheme" class="url_scheme textinput" value="<?php echo $items['url_scheme'];?>"/>
                    <?php echo $errors['url_scheme'];?>
                </div>-->
                <script type="text/javascript">
                    jQuery(".txtbundleid").keyup(function() {
                        jQuery(".url_scheme").val(jQuery(".txtbundleid").val());
                    });
                </script>  
                <div class="rows">	
                    <label for="menu_group_id">Minimum OS Version</label>
                    <input type="text" name="minimum_os_version" class="textinput" value="<?php echo $items['minimum_os_version'];?>" maxlength="25"/>
                    <?php echo $errors['minimum_os_version'];?>
                </div>
                <div class="rows">
                <label for="menu_group_id">Ghi chú</label>
                <textarea name="notes" maxlength="1000" id="notes" cols="80" rows="3" style="width:300px;resize:none;"></textarea>
                </div>
                <!--<div class="rows">	
                    <label for="menu_group_id">Duyệt</label>
                    <input type="radio" name="status" value="0" <?php echo ($items['status']==0)?'checked="checked"':'';?>/> Tắt 
                    <input type="radio" name="status" value="1" <?php echo ($items['status']==1)?'checked="checked"':'';?>/> Bật
                </div>-->
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
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
	 function showMsv(service_id,type_app){
        $.ajax({
            url:baseUrl+'?control=signhistoryapp&func=showmsv',
            type:"GET",
            data:{service_id:service_id,type_app:type_app},
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
		
		_val=$('#cert_id').val();
		if(_val==0){
			return false;
		}
		if(_val==1 || _val==2){
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
		
        var id_game = $("select[name=id_game]").val().split('|');
		var type_app = $("#cert_id").val();
		var type_app_value='';
			if(type_app==1){
				type_app_value='Appstore';
			}else if(type_app==2){
				type_app_value='Appstore';
			}else if(type_app==3){
				type_app_value='Inhouse';
			}
			
        $.ajax({
            url:baseUrl+'?control=signhistoryapp&func=showvalue',
            type:"GET",
            data:{cert_id:cert_id,id_game:id_game[0]},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(f.error==0){
					showMsv(id_game[1],type_app_value);
                    $("input[name=bundleidentifier],input[name=url_scheme]").val(f.bundleidentifier);
					$("input[name=bundleidentifier_appstore],input[name=url_scheme_appstore]").val(f.bundleidentifier_hide);
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