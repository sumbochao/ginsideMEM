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
        <div id="adminfieldset" class="groupsignios" style="height:225px;">
            <div class="adminheader">Chọn thông tin</div>
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="cbo_game" id="cbo_game" class="chosen-select" tabindex="2" data-placeholder="Chọn danh mục">
                            <option value="0">Chọn game</option>
                             <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                        ?>
                        <option value="<?php echo $v['service_id']."|".$v['app_fullname'];?>" <?php echo $items['id_game']==$v['id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                        <?php
                                }
                            }
                        ?>
                   </select>
                    <div class="option_error">
                        <?php echo $errors['cbo_game'];?>
                    </div>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Bảng app</label>
                    <input type="hidden" name="cbo_type_app_h" id="cbo_type_app_h" />
                    <input type="hidden" name="cbo_type_app_id_h" id="cbo_type_app_id_h" />
                    <span class="loadapp">
                        <select name="cbo_type_app" id="cbo_type_app" class="chosen-select" tabindex="2" data-placeholder="Chọn bảng app" onchange="showValue(this.value)">
                        <option value="0">Chọn App</option>
                        <?php
								if(count($slbTable)>0){
									foreach($slbTable as $v){
										$lb=($v['id']==1)|| ($v['id']==2)?"WinStore":$v['cert_type'];
										if($v['id']!=1 && $v['id']<=3){
							?>
							<option value="<?php echo $v['id'];?>" <?php echo $items['cert_id']==$v['id']?'selected="selected"':'';?>><?php echo $lb;?></option>
							<?php
										}//end if
									} //end for
								} //end if
							?>
                    </select>
                    </span>
                    <div class="option_error">
                        <?php echo $errors['cbo_type_app'];?>
                    </div>
                </div>
     
                <div class="rows" style="display:none;">
                <label for="menu_group_id">Cấu trúc Channel</label>
                <input type="text" name="txt_p1" id="txt_p1" style="width:25px" maxlength="3" readonly="readonly" /> |
                <input type="text" name="txt_p2" id="txt_p2" style="width:36px;text-align:center" maxlength="10" value="me" readonly="readonly" /> |
                <input type="text" name="txt_p3" id="txt_p3" style="width:45px;text-align:center" maxlength="20" value="1.0.0" /> |
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
        <div id="adminfieldset" class="groupsignios space" style="height:225px;">
            <div class="adminheader">Thông tin chuỗi Channel WindowPhone</div>
            <div class="group_left">
               
                <!--<div class="rows">
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
                </div>-->
                
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
               
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </form>
    
</div>
<script type="text/javascript" language="javascript">
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
	
	function getChannel(){
		_p1=$('#txt_p1').val();
		_p2=$('#txt_p2').val();
		_p3=$('#txt_p3').val();
		_p4=$('#txt_p4').val();
		_p5=$('#txt_p5').val();
		_p_cbo_5=$('#cbo_p5_msv').val().split('|');
		
		_channel=_p1+'|'+ _p2 + '|'+ _p3 + '|'+ _p4 + '|' + _p_cbo_5[1] + '_' + _p5;
		$('#channel').val('channel='+ _channel);
	}
    function showApp(id_game){
		_arr=id_game.split('|'); // _arr[0]:id_game ,_aar[1]: service_id
        $.ajax({
            url:baseUrl+'?control=wpchannel&func=showapp',
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

    function showValue(type_app){
		
		_val=$('#cbo_type_app').val();
		if(_val==0){
			return false;
		}
		if(_val==1 || _val==2){
			//appstore,Appstore dev
			 $("input[name=txt_p1]").val(4);
			 $("input[name=txt_p4]").val('WPstore');
			  $("input[name=txt_p5]").val('store');
		}else{
			// inhouse
			$("input[name=txt_p1]").val(1);
			$("input[name=txt_p4]").val('Mestore');
			$("input[name=txt_p5]").val('file');
		}
		
        var id_game = $("select[name=cbo_game]").val();
		_arr=id_game.split('|'); // _arr[0]:id_game ,_aar[1]: service_id
		var type_app = $("#cbo_type_app").val();
		var type_app_value='';
			if(type_app==1 || type_app==2){
				type_app_value='Appstore';
			}else{
				type_app_value='Inhouse';
			}	
			
       showMsv(_arr[0],type_app_value);
    }
	
	 function showMsv(id_game,type_app){
        $.ajax({
            url:baseUrl+'?control=wpchannel&func=showmsv',
            type:"GET",
            data:{id_game:id_game,type_app:type_app},
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
    
</script>