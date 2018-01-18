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
</style>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/prettyPhotos/prettyPhoto.css'); ?>" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script type="text/javascript" src="<?php echo base_url('assets/css/prettyPhotos/jquery.prettyPhoto.js'); ?>"></script>
<script type="text/javascript" charset="utf-8">
			 $(document).ready(function(){
                $("a[rel^='prettyPhoto']").prettyPhoto({
                	allow_resize: false
                    });                
            });
$("a[rel^='prettyPhoto3']").prettyPhoto({animationSpeed:'fast',slideshow:10000});
$("a[rel^='prettyPhoto2']").prettyPhoto({animationSpeed:'fast',slideshow:10000});
</script>-->
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php
        if($_GET['type']=='success'){
    ?>
    <div class="success_signios">Đã Signios thành công <a href="<?php echo base_url().'?control=signhistoryapp&func=index';?>">Quay về danh sách</a></div>
    <!--Tung add-->
    <div class="wrapper_scroolbar">
            <div class="scroolbar">
    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                 
                    <th align="center" width="100px">Published</th>
                     <th align="center" width="210px">Date Create</th>
                    <th align="center">Game</th>
                    <th align="center">File IPA</th>
                    <th align="center" width="150px">Bảng app</th>
                    <th align="center" width="150px">BundleID</th>
                    <th align="center" width="150px">SDK</th>
                    <th align="center" width="150px">MSV</th>
                    <th align="center" width="150px">Version</th>
                    <th align="center" width="150px">Bunlde Version</th>
                    <th align="center" width="150px">Channel</th>
                    <th align="center" width="100px">Status</th>
                    <th align="center" width="100px">Xem log</th>
                    <th align="center" width="100px">Xem file</th>
                    <th align="center" width="300px">Ghi chú</th>
                    <th align="center" width="100px">Thành viên</th>
                    <th align="center" width="100px">Chức năng</th>
                    
                    <th align="center">ID</th>
                </tr>
            </thead>
            <tbody>
         
                <tr>
                
                    <td>
                    <select name="cbo_published" id="cbo_published" style="width:80px;" onchange="updatepublished(<?php echo $viewitem['rs']['msv_id'] ?>,<?php echo $viewitem['rs']['id'] ?>,this.value);">
                            <option value="0">Published</option>
                            <option value="no" <?php echo $viewitem['rs']['published']=='no'?"selected":""; ?>>No</option>
                            <option value="yes" <?php echo $viewitem['rs']['published']=='yes'?"selected":""; ?>>Yes</option>
                            <option value="waiting" <?php echo $viewitem['rs']['published']=='waiting'?"selected":""; ?>>Waiting</option>
                            <option value="cancel" <?php echo $viewitem['rs']['published']=='cancel'?"selected":""; ?>>Cancel</option>
                        </select> 
                        <div id="messinfo" style="font-size:10px"></div>
                    </td>
                    <td><?php echo date('Y-m-d H:i:s',$viewitem['rs']['created']);?></td>
                    <td style="text-align:left"><?php 
					echo substr($slbGame[$viewitem['rs']['id_game']]['app_fullname'],0,strlen($slbGame[$viewitem['rs']['id_game']]['app_fullname'])<=5?strlen($slbGame[$viewitem['rs']['id_game']]['app_fullname']):5);?></td>
                     <td><?php echo $viewitem['rs']['ipa_name_sign'];?></td>
                    <td><?php echo $slbTable[$viewitem['rs']['cert_id']]['cert_type'];?></td>
                    <td><?php echo $viewitem['rs']['bundleidentifier'];?></td>
                    <td><?php echo $viewitem['rs']['sdk'];?></td>
                    <td><?php $rr=explode("|",$viewitem['rs']['channel']);
							$rrr=explode("_",$rr[4]);
							echo "msv_".$rrr[1];
							 ?></td>
                    <td><?php echo $viewitem['rs']['version'];?></td>
                    <td><?php echo $viewitem['rs']['bundle_version'];?></td>
                    <td><?php echo $viewitem['rs']['channel'];?></td>
                    <td><?php echo $viewitem['rs']['isok'];?></td>
                    <td>
                    <a href="javascript:void(0)" onclick="popitup('<?=base_url()."popup.php?id=".$viewitem['rs']['id'];?>','Xem log');">Xem</a>
                   <!-- <a href="'<?=base_url()."?control=popup&func=index&iframe=true&width=500&height=500&id=".$viewitem['rs']['id'];?>" rel="prettyPhoto2[iframes]">View</a>-->
                    </td>
                
                    <td><?php if(!empty($viewitem['rs']['signed_file_path'])){?><a href="<?php echo $viewitem['rs']['signed_file_path'];?>">Tải file</a><?php }?></td>
                    <td><textarea name="notes" id="notes" cols="5" role="3" onchange="updatenotes(<?php echo $viewitem['rs']['id'] ?>,this.value);"><?php echo $viewitem['rs']['notes']; ?></textarea></td>
                    <td><?php echo $slbUser[$viewitem['rs']['id_user']]['username'];?></td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                           
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$viewitem['rs']['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$viewitem['rs']['id'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            echo $btnEdit.' '.$btnDelete;
                        ?>
                        
                        
                    </td>
                    <td><?php echo $viewitem['rs']['id'];?></td>
                </tr>
            </tbody>
        </table>
         </div> <!--scroolbar-->
        </div><!-- wrapper_scroolbar -->
        <!--End Tung-->
    <?php
        }
    ?>
    <?php
        if($_GET['type']=='unsuccess'){
    ?>
    <div class="unsuccess_signios">Signios thất bại <a href="<?php echo base_url().'?control=signhistoryapp&func=add';?>">Làm lại</a></div>
    <?php
        }
    ?>
    <?php
        if(!isset($_GET['type']) || $_GET['type']=="filter"){
    ?>
    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
        	<input type="text" name="keyword" id="keyword" maxlength="100" placeholder="Tìm kiếm file IPA" title="Ipa file" value="<?php echo set_value('keyword',$_POST['keyword']); ?>" onblur="searchvalues(this.value);" />
            <select name="id_game" class="chosen-select" tabindex="2" data-placeholder="Chọn game">
                <option value="0">Chọn game</option>
                <?php
                    if(count($slbGame)>0){
                        foreach($slbGame as $v){
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo $arrFilter['id_game']==$v['id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <select name="cert_id">
                <option value="0">Chọn bảng app</option>
                <?php
                    if(count($slbTable)>0){
                        foreach($slbTable as $v){
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo $arrFilter['cert_id']==$v['id']?'selected="selected"':'';?>><?php echo $v['cert_type']." - ".$partner[$v['idpartner']]['partner'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <?php 
                if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                }else{
                    $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
                }
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
         
        <div class="wrapper_scroolbar">
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
                    <th align="center" width="150px">Bảng app</th>
                    <th align="center" width="150px">BundleID</th>
                    <th align="center" width="150px">SDK</th>
                    <th align="center" width="150px">MSV</th>
                    <th align="center" width="150px">Version</th>
                    <th align="center" width="150px">Bunlde Version</th>
                    <th align="center" width="250px">Channel</th>
                    <th align="center" width="100px">Status</th>
                    <th align="center" width="100px">Xem log</th>
                    <th align="center" width="100px">Xem file</th>
                    <th align="center" width="300px">Ghi chú</th>
                    <th align="center" width="800px">File IPA</th>
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
							$rr=explode("|",$v['channel']);
							$rrr=explode("_",$rr[4]);
                ?>
                <tr id="rows_<?php echo $i?>" class="rows_class">
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
                    <td><?php echo date('Y-m-d H:i:s',$v['created']);?></td>
                    <td style="text-align:left" title="<?php echo $slbGame[$v['id_game']]['app_fullname'];?>"><?php echo $slbGame[$v['id_game']]['app_fullname'];
					/*echo substr($slbGame[$v['id_game']]['app_fullname'],0,strlen($slbGame[$v['id_game']]['app_fullname'])<=5?strlen($slbGame[$v['id_game']]['app_fullname']):5);*/
					?><br />
                    <?php if(!empty($v['signed_file_path'])){?><a href="<?php echo $v['signed_file_path'];?>">Tải file</a><?php }?>
                    </td>
                    <td><strong style="color:<?php echo $slbTable[$v['cert_id']]['cert_type']=="Appstore"?"#036":"#903"; ?>" ><?php echo $slbTable[$v['cert_id']]['cert_type'];?></strong></td>
                    <td><?php echo $v['bundleidentifier'];?></td>
                    <td><?php echo $v['sdk'];?></td>
                    <td><strong style="color:#900"><a href="<?php echo base_url()."?control=mestoreversion&func=index&typeone=filter_one&service_id=".$slbGame[$v['id_game']]['service_id']."&platform=ios&msv_id=msv_".$rrr[1].""; ?>" style="text-decoration:none;color:inherit;" target="_blank">
					<?php echo "msv_".$rrr[1];?>
                    </a>
                    </strong></td>
                    <td><?php echo $v['version'];?></td>
                    <td><?php echo $v['bundle_version'];?></td>
                    <td><i style="color:#B017D2"><?php echo $v['channel'];?></i></td>
                    <td><?php echo $v['isok'];?></td>
                    
                    <!--<td>
                        <?php
                            if($_GET['page']>0){
                                $page = '&page='.$_GET['page'];
                            }
                            $imgActive = ($v['status']==1)?'active.png':'inactive.png';
                            
                            if((@in_array($_GET['control'].'-status', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                                $lnkActive = base_url()."?control=".$_GET['control']."&func=status&id=".$v['id']."&s=".$v['status'].$page;
                            }else{
                                $lnkActive = 'javascript:;';
                                $alert = 'onclick="alert(\'Bạn không có quyền truy cập chức năng này!\');"';
                            }
                            echo '<a href="'.$lnkActive.'" '.$alert.' title="Duyệt">
                                    <img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                        
                    </td>-->
                    <!--<td><a href="<?php echo $v['log_file_path'];?>" target="_blank">Xem log</a></td>-->
                    <td>
                    <a href="javascript:void(0)" onclick="popitup('<?=base_url()."popup.php?id=".$v['id'];?>','Xem log');">Xem</a> 
                    <!--<a href="'<?=base_url()."?control=popup&func=index&id=".$v['id']."&iframe=true&width=500&height=500";?>" rel="prettyPhoto2[iframes]">View</a>-->
                    </td>
                    <td><?php if(!empty($v['signed_file_path'])){?><a href="<?php echo $v['signed_file_path'];?>">Tải</a><?php }?></td>
                    <td>
                    <textarea name="notes" id="notes" cols="5" role="3" onchange="updatenotes(<?php echo $v['id'] ?>,this.value);"><?php echo $v['notes']; ?></textarea>
                    <!--<a href="javascript:void(0);" onclick="Lightboxt.showemsg('Ghi chú','<b><?php echo nl2br($v['notes']); ?></b>', 'Đóng');">Xem</a>-->
                    </td>
                    <td title="<?php echo $v['ipa_name_sign']; ?>"><?php echo $v['ipa_name_sign']; ?></td>
                    <td><?php echo $slbUser[$v['id_user']]['username'];?></td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                           
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            echo $btnEdit.' '.$btnDelete;
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

function updatenotes(_id_ipa,_val_notes){
	c=confirm('Bạn có muốn thay đổi ?');
	if(c){
		$.ajax({
			url:baseUrl+'?control=signhistoryapp&func=updatenotes',
			type:"GET",
			data:{_id_ipa:_id_ipa,_val_notes:_val_notes},
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
function updatepublished(_msv_id,_id_ipa,_val_publish){
	if(_val_publish!=0){
		c=confirm('Bạn có muốn thay đổi ?');
		$("#messinfo").html('');
		if(c){
			$.ajax({
            url:baseUrl+'?control=signhistoryapp&func=updatepublished',
            type:"GET",
            data:{_msv_id:_msv_id,_id_ipa:_id_ipa,_val_publish:_val_publish},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
				$("#messinfo").html('');
            },
			success:function(f){
				if(f.error==0){
					$("#messinfo_"+_id_ipa).html(f.messg);
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
		var left = (screen.width/2)-(700/2);
  		var top = (screen.height/2)-(600/2);
       newwindow=window.open(url,windowName,'height=600,width=700,menubar=no,scrollbars=no, resizable=no,toolbar=no, location=no, directories=no, status=no, menubar=no,top='+top+', left='+left);
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
		 var f1 = cells[19].innerHTML;
		 $('#rows_'+i).css('display','table-row');
		 if(f1!=_val){
			$('#rows_'+i).css('display','none');
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
		 var f = cells[10].innerHTML;
		 var f1 = cells[15].innerHTML; //ipa
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