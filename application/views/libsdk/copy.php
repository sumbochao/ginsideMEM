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
        <div class="option_error">
                       <strong style="color:#F00"><?php echo $errors;?></strong>
             </div>
        <div id="adminfieldset" class="groupsignios">
        	 
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
            	<div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="cbo_game" id="cbo_game" class="chosen-select" tabindex="2" data-placeholder="Chọn danh mục" onchange="calljavascript(-1);">
                            <option value="0">Chọn game</option>
                             <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                        ?>
                        <option value="<?php echo $v['service_id']."|".$v['service'];?>" <?php echo $itemview['game_code']==$v['service']?"selected":""; ?>><?php echo $v['app_fullname'];?></option>
                        <?php
                                }
                            }
                        ?>
                   </select>
                   <input type="hidden" name="game_name" id="game_name" value="<?php echo $itemview['game_name']; ?>"/>
                </div>
                <!--<div class="rows" style="display:none;">	
                    <label for="menu_group_id">Game Name</label>
                    <input type="text" name="game_name" id="game_name" class="textinput" readonly="readonly"/>
                </div>-->
                <div class="rows">	
                    <label for="menu_group_id">Platform</label>
                    <select name="cbo_platform" id="cbo_platform" onchange="calljavascript(2);">
                        <option value="0">Chọn Platform</option>
                        <?php
                            if(count($loadplatform)>0){
                                foreach($loadplatform as $key=>$value){
                        ?>
                        <option value="<?php echo $key;?>" <?php echo $itemview['platform']==$key?"selected":""; ?>><?php echo $value;?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Store Type</label>
                    <select name="cbo_story_stype" id="cbo_story_stype" onchange="calljavascript(1);">
                        <option value="0"> -- Chọn -- </option>
                        <option value="GooglePlay" <?php echo $itemview['story_stype']=="GooglePlay"?"selected":""; ?>>GooglePlay</option>
                      	<option value="WinStore" <?php echo $itemview['story_stype']=="WinStore"?"selected":""; ?>>WinStore</option>
                        <option value="Appstore" <?php echo $itemview['story_stype']=="Appstore"?"selected":""; ?>>Appstore</option>
                        <option value="Inhouse" <?php echo $itemview['story_stype']=="Inhouse"?"selected":""; ?>>Inhouse</option>
                    </select>
                    
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Package Type</label>
                    <select name="cbo_package_type" id="cbo_package_type">
                        <option value="0"> -- Chọn -- </option>
                        <option value="Full" <?php echo $itemview['package_type']=="Full"?"selected":""; ?> >Full</option>
                      	<option value="Lite" <?php echo $itemview['package_type']=="Lite"?"selected":""; ?>>Lite</option>
                    </select>
                    
                </div>
                 <div class="rows">	
                    <label for="menu_group_id">Package/Bundle</label>
                     <select name="cbo_package_name" id="cbo_package_name" style="width:300px;" onchange="calljavascript(3);">
                            <option value="0"> --- Chọn --- </option>
                   </select>
                </div>
                <div class="rows">
                    <div class="cbo_sdk">
                    <label for="menu_group_id">Chọn SDK version</label>
                    <input type="text" name="sdkversion" id="sdkversion" class="textinput" value=""/>
                       <!-- <select name="cbo_sdk" id="cbo_sdk"  style="width:150px;">
                            <option value="0">Chọn ...</option>
                        </select>-->
                     
                    </div>
                </div>
              
            </div>
            <div class="group_right">
                
            </div>
            <div class="clr"></div>
        </div>
        
        <div id="adminfieldset" class="groupsignios space" style="margin-left:1%;">
            <div class="adminheader">Nhập thông tin tùy chọn</div>
            <div class="group_left">
               <div class="cbo_msv">
                    <label for="menu_group_id">Chọn Msv</label>
                        <select name="cbo_msv" id="cbo_msv" style="width:150px;">
                            <option value="0">Chọn Msv...</option>
                        </select> 
                    </div>
                <div class="rows">	
                    <label for="menu_group_id">Client Version</label>
                    <input type="text" name="client_version" id="client_version" class="textinput" onkeyup="calljavascript(4);" value="<?php echo $itemview['client_version']; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Client Build</label>
                    <input type="text" name="client_build" id="client_build" class="textinput" value="<?php echo $itemview['client_build']; ?>"/>
                </div>
                <div class="rows" id="view_version_code">	
                    <label for="menu_group_id">Version Code</label>
                    <input type="text" name="version_code" id="version_code" class="textinput" value="<?php echo $itemview['version_code']; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Min SDK Version</label>
                    <input type="text" name="min_sdk_version" id="min_sdk_version" class="textinput" value="<?php echo $itemview['min_sdk_version']; ?>"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Target SDK Version</label>
                    <input type="text" name="target_sdk_version" id="target_sdk_version" class="textinput" value="<?php echo $itemview['target_sdk_version']; ?>"/>
                </div>
               
            </div>
            <div class="clr"></div>
        </div>
        
        <div id="adminfieldset" class="groupsignios" style="width:100%;margin-top:0">
            <div class="adminheader">File name và Ghi Chú</div>
            <div class="group_left">
            	 <div class="rows">	
                    <label for="menu_group_id"></label>
                    <input type="text" name="file_name" id="file_name" class="textinput" placeholder="File name" style="width:1000px;color:#900;font-weight:bold" value="<?php echo $itemview['file_name']; ?>"/>
                </div>
                <div class="rows">
                    <textarea name="notes" id="notes" cols="30" rows="5" style="width:1000px;height:80px;resize:none;"><?php echo $itemview['notes']; ?></textarea>
                </div>
               
            </div>
            <div class="clr"></div>
        </div>
        
        
    </form>
</div>
<script src="<?php echo base_url('assets/js/signscript/js_libsdk.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
	calljavascript(1);
	calljavascript(2);
	calljavascript(3);
	function calljavascript(i){
		switch(i){
			 case 0:
			 	checknull('appForm','<?=base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&id=".intval($_GET['id']); ?>');
			 break;
			 case 1:
			 	getBundle(<?php echo intval($_GET['id']) ?>,'cbo_game','cbo_platform',$('#cbo_story_stype').val(),'cbo_package_name');
				//claer msv
				showMsv(-1,'',0,'','');
			 break;
			 case 2:
			 	
			 	gm=$('#cbo_game').val();
			 	if(gm == 0){
					alert('Vui lòng chọn game');
					$('#cbo_game').focus();
					return;
				}
				
				pl=$('#cbo_platform').val();
				if(pl=='ios' || pl=='wp'){
					setInterfacePlatform('view_version_code','none');
				}else{
					setInterfacePlatform('view_version_code','block');
				}
			 	//getSdk('cbo_platform','cbo_sdk');
				//setSelectedTypeApp($('#cbo_platform').val(),'cbo_story_stype');
				//set setMinTargetSdkVersion
				setMinTargetSdkVersion($('#cbo_platform').val(),'min_sdk_version','target_sdk_version');
				//claer msv
				showMsv(-1,'',0,'','');
			 break;
			 case 3:
			 	service_id=$('#cbo_game').val().split('|');
			 	showMsv(<?php echo intval($_GET['id']) ?>,$('#cbo_platform').val(),service_id[0],$('#cbo_story_stype').val(),$('#cbo_package_name').val());
			 break;
			 case 4:
			 	//param id control,service game,bundle,type app,package type, client version, date
				ext='';
				if($('#cbo_platform').val()=='ios'){
					ext='ipa';
				}
				if($('#cbo_platform').val()=='android'){
					ext='apk';
				}
				if($('#cbo_platform').val()=='wp'){
					ext='xap';
				}
				var today = new Date();
				var d=today.getDate();
				var m=today.getMonth() + 1;
				var y=today.getFullYear();
				today=d+'.'+m+'.'+y; 
				var gm=$('#cbo_game').val().split('|');
				
			 	hardfilename('file_name',gm[1],$('#cbo_package_name').val(),$('#cbo_story_stype').val(),$('#cbo_package_type').val(),$('#client_version').val(),today,ext);
				
			 break;
			 default:
			 	//claer msv
				$('#game_name').val($('#cbo_game option:selected').text());
				showMsv(-1,'',0,'','');
			 break;
		}
	}
	//maxLength(document.getElementById("notes"));
</script>