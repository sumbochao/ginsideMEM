<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<!--<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">-->
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<style>
    .success_signios{
        color: green;
        text-align: center;
        font-size: 20px;
    }
    .unsuccess_signios{
        color: red;
        text-align: center;
        font-size: 20px;
    }
	.main-bar{
	display:none;
	}
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php
        if($_GET['type']=='success'){
    ?>
    <div class="success_signios">Đã SignApk thành công <a href="<?php echo base_url().'?control=signapk&func=index';?>" style="float:right"><img src="/assets/img/back.png" style="width:32px;height:32px"/></a>
	<br />
    <strong style="text-align:center;color:#F00"><?php echo $_GET['mess']; ?></strong>
	</div>
    <?php
		include('success.php');
        }
    ?>
    
    <?php
        if($_GET['type']=='unsuccess'){
    ?>
    <div class="unsuccess_signios">SignApk thất bại <a href="<?php echo base_url().'?control=signapk&func=add';?>">Làm lại</a></div>
    <?php 
			if(isset($_GET['pac_file']) && !empty($_GET['pac_file'])){ 
					echo "<strong style='color:blue'>PackageName của file APK là :<i style='color:red'>".$_GET['pac_file']."</i> , không giống với PackageName được Sign : <i style='color:red'>".$_GET['pac_opt']."</i></strong>";
			}
	 ?>
	<?php
        }
    ?>
    <?php
        if(!isset($_GET['type']) || $_GET['type']=="filter"){
    ?>
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
        	<input type="text" name="keyword" id="keyword" maxlength="100" placeholder="Tìm kiếm file APK" title="Ipa file" value="" onblur="searchvalues(this.value);" />
            <select name="cbo_game" id="cbo_game" class="chosen-select" tabindex="2" data-placeholder="Chọn game">
                <option value="0">Chọn game</option>
                <?php
                    if(count($slbGame)>0){
                        foreach($slbGame as $v){
                ?>
                <option value="<?php echo $v['service_id'];?>" <?php echo $arrFilter['id_game']==$v['service_id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <select name="cbo_app" id="cbo_app">
                <option value="0">Chọn bảng app</option>
                <?php
                    if(count($slbTable)>0){
                        foreach($slbTable as $v){
							$lb=($v['id']==1)|| ($v['id']==2)?"GooglePlay":$v['cert_type'];
							if($v['id']!=2 && $v['id']<=3){
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo $arrFilter['type_app_id']==$v['id']?'selected="selected"':'';?>><?php echo $lb;?></option>
                <?php
							}//end if
                        } // end for
                    } //end if
                ?>
            </select>
            <?php 
                /*if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    $lnkFilter = "checkserach();";
                }else{
                    $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
                }*/
				$lnkFilter = "checkserach();";
            ?>
            <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>   
        </div>
        <div class="filter">
        <select name="cbo_published" id="cbo_published" onchange="setrows(this.value);" style="width:110px;margin-bottom:0;font-weight:bold;margin-bottom:10px;">
                        <option value="0" >Published</option>
                        	<option value="0">All</option>
                        	<option value="waiting">Waiting ...</option>
                            <option value="cancel">Cancel</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        
                    </select>
         </div>
         
        <div class="wrapper_scroolbar" style="height:400px;" >
            <div class="scroolbar" style="width:2500px;">
         <div style="float:left;margin-bottom:10px;" id="divpage">
         	<?php echo $pages?>
         </div>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    
                    <th align="center" width="100px">EditPublished</th>
                    <th align="center" width="210px">Date Create</th>
                    <th align="center" width="200px">Game</th>
                    <th align="center" width="200px">PackageName</th>
                    <th align="center" width="200px">VersionName</th>
                    <th align="center" width="200px">VersionCode</th>
                    <th align="center" width="150px">Bảng app</th>
                    <th align="center" width="450px">APK Signed</th>
                    <th align="center" width="150px">Channel</th>
                    <th align="center" width="150px">MSV</th>
                    <th align="center" width="150px">Link download</th>
                    <th align="center" width="100px">Xem log</th>
                    <th align="center" width="300px">Ghi chú</th>
                    <th align="center" width="100px">User</th>
                    <th align="center" width="100px">Xóa</th>
                    <th align="center">ID</th>
                    <th>Published</th>
                </tr>
            </thead>
            <tbody>
                <?php
					$i=0;
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
							$i++;
							$rr=explode("|",$v['channels']);
							$rrr=explode("_",$rr[4]);
                ?>
                <tr id="rows_<?php echo $v['id']?>" class="rows_class">
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid[<?php echo $v['id'];?>]" name="cid[]"></td>
                    
                    <td>
                    <select name="cbo_published" id="cbo_published" style="width:80px;" onchange="updatepublished(<?php echo $v['msv_id'] ?>,<?php echo $v['id'] ?>,this.value);">
                            <option value="0">Published</option>
                            <option value="no" <?php echo $v['published']=='no'?"selected":""; ?>>No</option>
                            <option value="yes" <?php echo $v['published']=='yes'?"selected":""; ?>>Yes</option>
                            <option value="waiting" <?php echo $v['published']=='waiting'?"selected":""; ?>>Waiting</option>
                            <option value="cancel" <?php echo $v['published']=='cancel'?"selected":""; ?>>Cancel</option>
                        </select> 
                        <div id="messinfo_<?php echo $v['id'] ?>" style="font-size:10px"></div>
                    </td>
                    <td><?php echo $v['datecreate'];?></td>
                    <td style="text-align:left" title="<?php echo $v['games'];?>"><?php echo $v['games'];	?>   <br /><a href="<?php echo $v['links_signed'];?>">Tải file apk</a>
                    <br /><strong style="color:#900">
                    <a href="<?php echo base_url()."?control=mestoreversion&func=index&typeone=filter_one&service_id=".$v['id_game']."&platform=android&msv_id=msv_".$rrr[1].""; ?>" style="text-decoration:none;color:inherit;" target="_blank">
					<?php echo "msv_".$rrr[1];?>
                    </a>
                    </td>
                    <td><strong ><?php echo $v['package_name'];?></strong></td>
                    <td><strong ><?php echo $v['version_name'];?></strong></td>
                    <td><strong ><?php echo $v['version_code'];?></strong></td>
                    <td><strong style="color:<?php echo $v['type_app']=="GooglePlay"?"#036":"#903"; ?>" ><?php echo $v['type_app'];?></strong></td>
                    <td><?php echo $v['filenames_signed'];?></td>
                    <td><?php echo $v['channels'];?></td>
                    <td><strong style="color:#900">
                    <a href="<?php echo base_url()."?control=mestoreversion&func=index&typeone=filter_one&service_id=".$v['id_game']."&platform=android&msv_id=msv_".$rrr[1].""; ?>" style="text-decoration:none;color:inherit;" target="_blank">
					<?php echo "msv_".$rrr[1];?>
                    </a>
                    </strong></td>
                    <td><a href="<?php echo $v['links_signed'];?>">Tải file apk</a></td>
                    <td>
                    <!--<a href="javascript:void(0)" onclick="popitup('<?=base_url()."popup_android.php?id=".$v['id'];?>','Xem log');">Xem</a>-->
                    <a href="javascript:void(0)" onclick="popitup('<?=$v['logs'];?>','Xem log');">Xem</a>
                    </td>
                    <td>
                    <textarea name="notes" id="notes" cols="5" role="3" onchange="updatenotes(<?php echo $v['id'] ?>,this.value);"><?php echo $v['notes']; ?></textarea></td>
                 <td><?php echo $slbUser[$v['userid']]['username'];?></td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                           
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            echo $btnDelete;
                        ?>
                        
                        
                    </td>
                    
                    <td><?php echo $v['id'];?></td>
                    <td><?php echo $v['published']; ?></td>
                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        	<?php echo $pages?>
          </div> <!--scroolbar-->
        </div><!-- wrapper_scroolbar -->
       
    </form>
    <?php } ?>
</div>
<script language="javascript">
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
function checkserach(){
	cbo_game=$('#cbo_game').val();
	/*if(cbo_game==0){
		alert('Vui lòng chọn game');
		$('#cbo_game').focus();
		return false;
	}else{
		onSubmitForm('appForm','<?php echo base_url()?>?control=<?php echo $_GET['control'] ?>&func=<?php echo $_GET['func'] ?>&type=filter')
	}*/
	onSubmitForm('appForm','<?php echo base_url()?>?control=<?php echo $_GET['control'] ?>&func=<?php echo $_GET['func'] ?>&type=filter');
}
function updatenotes(_id_apk,_val_notes){
	c=confirm('Bạn có muốn thay đổi ?');
	if(c){
		$.ajax({
			url:baseUrl+'?control=signapk&func=updatenotes',
			type:"GET",
			data:{_id_apk:_id_apk,_val_notes:_val_notes},
			async:false,
			dataType:"json",
			beforeSend:function(){
				$('.loading_warning').show();
			},
			success:function(f){
				if(f.error==0){
					$('.loading_warning').hide();
					Lightboxt.showemsg('Thông báo', f.messg, 'Đóng');
					
				}else{
					$('.loading_warning').hide();
					Lightboxt.showemsg('Thông báo', f.messg, 'Đóng');
				}
			}
		});
	}//end if

	return true;
}
function updatepublished(_msv_id,_id_apk,_val_publish){
	if(_val_publish!=0){
		c=confirm('Bạn có muốn thay đổi ?');
		$("#messinfo").html('');
		if(c){
			$.ajax({
            url:baseUrl+'?control=signapk&func=updatepublished',
            type:"GET",
            data:{_msv_id:_msv_id,_id_apk:_id_apk,_val_publish:_val_publish},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
				$("#messinfo").html('');
            },
			success:function(f){
				if(f.error==0){
					$("#messinfo_"+_id_apk).html(f.messg);
					$('.loading_warning').hide();
					//showMsv(_arr[1]);
				}else{
					$("#messinfo").html(f.messg);
					$('.loading_warning').hide();
				}
			}
			});
			return true;
		}else{
			$("#messinfo").html('');
			return false;
		}
	}
}
function popitup(url,windowName) {
		var left = (screen.width/2)-(900/2);
  		var top = (screen.height/2)-(500/2);
       newwindow=window.open(url,windowName,'height=500,width=900,menubar=no,scrollbars=no, resizable=no,toolbar=no, location=no, directories=no, status=no, menubar=no,top='+top+', left='+left);
       if (window.focus) {newwindow.focus()}
       return false;
     }

function checkdelall(){
	var myForm = document.forms.appForm;
	var myControls = myForm.elements['cid[]'];
	var isok=false;
	for (var i = 0; i < myControls.length; i++) {
		var aControl = myControls[i];
		if(aControl.checked){
			isok=true;
		}
	}
	if(!isok){
		alert('Vui lòng chọn dòng cần xóa'); return false;
	}else{
		c=confirm('Bạn có muốn xóa !');
		if(c){
			onSubmitForm('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=delete&type=multi"; ?>');
		return true;
		}
	}
}
function setrows(_val){
	var t = document.getElementById('tblsort');
	var rows = t.rows;
	for (var i=0; i<rows.length; i++) {
		 var cells = rows[i].cells; 
		 var f1 = cells[17].innerHTML;
		 var id = cells[16].innerHTML;
		 $('#rows_'+id).css('display','table-row');
		 if(f1!=_val){
			$('#rows_'+id).css('display','none');
		 }
		 if(_val=='0'){
			 $('.rows_class').css('display','table-row');
		 }
    }
}
function searchvalues(_val){
	var t = document.getElementById('tblsort');
	var rows = t.rows;
	$('.rows_class').css('display','table-row');
	for (var i=0; i<rows.length; i++) {
		 var cells = rows[i].cells; 
		 var f = cells[4].innerHTML;
		 var f1 = cells[8].innerHTML; //ipa
		 $('#rows_'+i).css('display','table-row');
		 //var regex = /.*/f1/.*/;
		 //var matchesRegex = regex.test(_val);
		 var myMatch = f1.search(_val);
		 var myMatch_notes = f.search(_val);
		 if(myMatch != -1) {
			$('#rows_'+i).css('display','table-row');
		 }else{
			$('#rows_'+i).css('display','none');
			if(myMatch_notes != -1) {
				 $('#rows_'+i).css('display','table-row');
			 }else{
				 $('#rows_'+i).css('display','none');
			 }
		 }
    }
}
</script>