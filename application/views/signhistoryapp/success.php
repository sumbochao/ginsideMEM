 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
<div class="loading_warning" style="text-align:center">
<img src="<?php echo base_url('assets/img/icon/loading_sign.gif'); ?>" />
</div>
<div id="content-t" style="min-height:500px; padding-top:10px">
 
    <div class="success_signios">Đã Signios thành công <a href="<?php echo base_url().'?control=signhistoryapp&func=index';?>">Quay về danh sách</a></div>
         
        <div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:2500px;">
    
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <!--<th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>-->
                    
                    <!--<th align="center" width="100px">EditPublished</th>-->
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
                    <th align="center">ID</th>
                    <th>Published</th>
                </tr>
            </thead>
            <tbody>
                <?php
					$i=0;
                    if(empty($listItem) !== TRUE){
                        foreach($listItem as $i=>$v){
							$i++;
							$rr=explode("|",$v['channel']);
							$rrr=explode("_",$rr[4]);
							//sdk_version
							if($v['current_sdk']!=""){
								$arr_sdk=explode("=",$v['current_sdk']);
								$sdk_version=$arr_sdk[1];
							}else{
								$sdk_version="";
							}
                ?>
                <tr id="rows_<?php echo $i?>" class="rows_class">
                    <!--<td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid[<?php echo $v['id'];?>]" name="cid[]"></td>-->
                    
                    <!--<td>
                    <select name="cbo_published" id="cbo_published" style="width:80px;" onchange="updatepublished(<?php echo $v['msv_id'] ?>,<?php echo $v['id'] ?>,this.value);">
                            <option value="0">Published</option>
                            <option value="no" <?php echo $v['published']=='no'?"selected":""; ?>>No</option>
                            <option value="yes" <?php echo $v['published']=='yes'?"selected":""; ?>>Yes</option>
                            <option value="waiting" <?php echo $v['published']=='waiting'?"selected":""; ?>>Waiting</option>
                            <option value="cancel" <?php echo $v['published']=='cancel'?"selected":""; ?>>Cancel</option>
                        </select> 
                        <div id="messinfo_<?php echo $v['id'] ?>" style="font-size:10px"></div>
                    </td>-->
                    <td><?php echo date('Y-m-d H:i:s',$v['created']);?></td>
                    <td style="text-align:left" title="<?php echo $slbGame[$v['id_game']]['app_fullname'];?>"><strong><?php echo $slbGame[$v['id_game']]['app_fullname'];?></strong><br />
                    <?php if(!empty($v['signed_file_path'])){?><a href="<?php echo $v['signed_file_path'];?>">Tải file</a><?php }?>
                    <br />
                    <?php echo $v['path_folder_sign']; ?>
                    </td>
                    <td><strong style="color:<?php echo $slbTable[$v['cert_id']]['cert_type']=="Appstore"?"#036":"#903"; ?>" ><?php echo $slbTable[$v['cert_id']]['cert_type'];?></strong></td>
                    <td><?php echo $v['bundleidentifier'];?></td>
                    <td><?php echo $sdk_version;?></td>
                    <td><strong style="color:#900"><a href="<?php echo base_url()."?control=mestoreversion&func=index&typeone=filter_one&service_id=".$slbGame[$v['id_game']]['service_id']."&platform=ios&msv_id=msv_".$rrr[1].""; ?>" style="text-decoration:none;color:inherit;" target="_blank">
					<?php echo "msv_".$rrr[1];?>
                    </a>
                    </strong></td>
                    <td><?php echo $v['version'];?></td>
                    <td><?php echo $v['bundle_version'];?></td>
                    <td><i style="color:#B017D2"><?php echo $v['channel'];?></i></td>
                    <td><?php echo $v['isok'];?></td>
                   
                    <td>
                    <a href="javascript:void(0)" onclick="popitup('<?=base_url()."popup.php?id=".$v['id'];?>','Xem log');">Xem</a> 
                 
                    </td>
                    <td><?php if(!empty($v['signed_file_path'])){?><a href="<?php echo $v['signed_file_path'];?>">Tải</a><?php }?></td>
                    <td>
                    <textarea name="notes" id="notes" cols="5" role="3" onchange="updatenotes(<?php echo $v['id'] ?>,this.value);"><?php echo $v['notes']; ?></textarea>
                   
                    </td>
                    <td title="<?php echo $v['ipa_name_sign']; ?>"><?php echo $v['ipa_name_sign']; ?></td>
                    <td><?php echo $slbUser[$v['id_user']]['username'];?></td>
                 
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
        	<?php include('redmineapi.php'); ?>
          </div> <!--scroolbar-->
        </div><!-- wrapper_scroolbar -->
      
   
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
function popitup(url,windowName) {
		var left = (screen.width/2)-(700/2);
  		var top = (screen.height/2)-(600/2);
       newwindow=window.open(url,windowName,'height=600,width=700,menubar=no,scrollbars=no, resizable=no,toolbar=no, location=no, directories=no, status=no, menubar=no,top='+top+', left='+left);
       if (window.focus) {newwindow.focus()}
       return false;
     }
function AlertOK(){
	$('.loading_warning').show();
}
</script>