<?php
//hiển thị yêu cầu theo hạng mục
$data=$catego->ShowRequestofCate($cc['id_game'],$cc['id']);	
$j=0;
$img_on="<img boder='0' src='".base_url()."assets/img/tick.png'>";
$data_type=array();

if(count($data)>0 && $data != NULL){ ?>
<table class="table request" id="tbltable_requset_<?php echo $cc['id']; ?>" style="display:none">
<?php 
	foreach($data as $i=>$v){
		  $data_type = array(
			 0 => $v['android'],
			 1 => $v['ios'],
			 2 => $v['wp'],
			 3 => $v['pc'],
			 4 => $v['web'],
			 5 => $v['events'],
			 6 => $v['systems'],
			 7 => $v['orther']
		 );
?>
<tr id="res_row_h_<?php echo $v['id'];?>">
        <th align="center" width="450px">Yêu cầu</th>
        <th align="center" width="50px">Loại</th>
        <th align="center" width="250px">Kết quả <br />mong muốn</th>
        <th align="center" width="70px">Nhóm <br />thực hiện</th>
        <th align="center" width="70px">Nhóm hỗ trợ</th>
        <th align="center" width="70px">Chọn tình trạng</th>
        <th align="center" width="70px">Người thực hiện<br />ghi chú</th>
         <th align="center" width="150px">Ngày checklist</th>
        <th align="center" width="70px">User check</th>
        <th align="center" width="70px">Admin <br />chọn kết quả</th>
        <th align="center" width="70px">Ghi chú admin</th>
        <th>Refesh</th>
</tr>
<?php
		for($o=0;$o <= count($data_type);$o++){
			 if($data_type[$o]!="" && !empty($data_type[$o])){
				 $j++;
				  $stype_css="";
				 //neu lọc theo status , chi hiển thị những status được chọn
					 if($get_status!=""){
						 $arr_statu_option=explode(",",$get_status);
						 if($btn_filter==1){
							 //user
						 	$sta="'".$v['result_'.$catego->ShowTypesControl($o)]."'";
						 }elseif($btn_filter==2){
							 //admin
							$sta="'".$v['result_admin_'.$catego->ShowTypesControl($o)]."'";
						 } //end if
						 $sta=$sta=="''"?"'NULL'":$sta;
						 if(in_array(trim($sta), $arr_statu_option)){
							 $stype_css="";
						 }else{
							 $stype_css="style='display:none;'";
						 }
						$sta="";
					 }
				 
?>
<tr id="res_row_<?php echo $v['id'];?>" <?php echo $stype_css;?> >
             		
                    <td style="width:400px;">
                    <a id="a_post_res_<?php echo $v['id']."_".$catego->ShowTypesControl($o);?>" style="color:#268AB9;text-decoration:none;" href="#content-div-request-<?php echo $v['id'];?>"><?php echo nl2br($v['titles']);?></a>
                    <!--<div style="display:none">
                       <div id="content-div-request-<?php echo $v['id'];?>"><?php echo $v['notes'];?></div>
                    </div>-->
                    </td>
                    <td><?php echo ViewGroup::ShowTypes($o);?></td>
                    <td><?php echo nl2br($v['admin_request']);?></td>
                    <td>
					<?php echo $catego->CreateControlGroup($v['id_game'],$v['id'],0);?>
                    </td>
                    <td>
					<?php echo $catego->CreateControlGroup($v['id_game'],$v['id'],1);?></td>
                    <td>
                    <!--Chọn tình trạng user -->
                    <div id="ajax_user_check_<?php echo $v['id'].$j.$cc['id']?>">
                    <select name="cbo_result_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>" id="cbo_result_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>" style="width:100px;" onchange="getresultimg(this.value,'img_status_<?php echo $v['id'].$j.$cc['id'];?>'); ajax_update_user('<?php echo $catego->ShowTypesControl($o);?>',<?php echo $v['id_game']?>,<?php echo $v['id_categories']?>,<?php echo $v['id']?>,'mess_user_<?php echo $v['id'].$j.$cc['id'];?>',this.value,$('#notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>').val(),<?php echo $_SESSION['account']['id']; ?>);" >
                        <option value="None"  <?php echo $v['result_'.$catego->ShowTypesControl($o)]=="None"?"selected":""; ?> >None</option>
                        <option value="Pass" <?php echo $v['result_'.$catego->ShowTypesControl($o)]=="Pass"?"selected":""; ?>>Pass</option>
                        <option value="Fail" <?php echo $v['result_'.$catego->ShowTypesControl($o)]=="Fail"?"selected":""; ?>>Fail</option>
                        <option value="Cancel" <?php echo $v['result_'.$catego->ShowTypesControl($o)]=="Cancel"?"selected":""; ?>>Cancel</option>
                        <option value="Pending" <?php echo $v['result_'.$catego->ShowTypesControl($o)]=="Pending"?"selected":""; ?>>Pending</option>
                        <option value="InProccess" <?php echo $v['result_'.$catego->ShowTypesControl($o)]=="InProccess"?"selected":""; ?>>InProccess</option>
                    </select>
                    <div id="show_img_user_<?php echo $v['id'].$j.$cc['id'];?>">
                    <?php echo $catego->showimg($v['result_'.$catego->ShowTypesControl($o)],$v['id'].$j.$cc['id'],"user"); ?>
                    </div>
                    <br />
                    <div id="mess_user_<?php echo $v['id'].$j.$cc['id'];?>" style="color:green;font-weight:bold;font-size:9px;"></div>
                    </div>
                    </td>
                   <td>
                   <!--Ghi chú user-->
                   <div id="ajax_user_notes_<?php echo $v['id'].$j.$cc['id']?>">
                   <textarea name="notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id']?>" id="notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>" cols="5" rows="10" style="width:150px;height:100px;resize:none" placeholder="Người thực hiện ghi chú" onchange="ajax_update_user('<?php echo $catego->ShowTypesControl($o);?>',<?php echo $v['id_game']?>,<?php echo $v['id_categories']?>,<?php echo $v['id']?>,'mess_user_<?php echo $v['id'].$j.$cc['id'];?>',$('#cbo_result_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>').val(),$('#notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>').val(),<?php echo $_SESSION['account']['id']; ?>);" ><?php echo $v['notes_'.$catego->ShowTypesControl($o)]; ?></textarea>
                   </div>
                   </td>
                   <td>
                    <div id="ajax_user_datecheck_<?php echo $v['id'].$j.$cc['id']?>">
					<?php echo $v['dateusercheck_'.$catego->ShowTypesControl($o)];?>
                    </div>
					
                    </td>
                    <td>
                    <div id="ajax_user_log_<?php echo $v['id'].$j.$cc['id']?>">
                    <strong><?php echo $slbUser[$v['usercheck_'.$catego->ShowTypesControl($o)]]['username'];?></strong>
                    </div>
					<a class="variouslog" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=gamechecklisttemp&func=logchecklist&id_game=<?php echo $cc['id_game']; ?>&id_request=<?php echo $v['id']; ?>&type=<?php echo $catego->ShowTypesControl($o); ?>&type_account=user">LogUser</a>
                    </td>
                    <td>
                    <!--Chọn tình trạng Admin-->
                    <select name="cbo_result_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>" id="cbo_result_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>" style="width:100px;" onchange="getresultimg(this.value,'admin_img_status_<?php echo $v['id'].$j.$cc['id'];?>'); ajax_update_admin('<?php echo $catego->ShowTypesControl($o);?>',<?php echo $v['id_game']?>,<?php echo $v['id_categories']?>,<?php echo $v['id']?>,'mess_admin_<?php echo $v['id'].$j.$cc['id'];?>',this.value,$('#notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>').val(),<?php echo $_SESSION['account']['id']; ?>);" <?php echo ViewGroup::$group_admin!=-1?"disabled='disabled'":""; ?> >
                        <option value="None" <?php echo $v['result_admin_'.$catego->ShowTypesControl($o)]=="None" || $v['result_admin_'.$catego->ShowTypesControl($o)]==""?"selected":""; ?>>None</option>
                        <option value="Pass" <?php echo $v['result_admin_'.$catego->ShowTypesControl($o)]=="Pass"?"selected":""; ?>>Pass</option>
                        <option value="Fail" <?php echo $v['result_admin_'.$catego->ShowTypesControl($o)]=="Fail"?"selected":""; ?>>Fail</option>
						<option value="Cancel" <?php echo $v['result_admin_'.$catego->ShowTypesControl($o)]=="Cancel"?"selected":""; ?>>Cancel</option>
                          <option value="Pending" <?php echo $v['result_admin_'.$catego->ShowTypesControl($o)]=="Pending"?"selected":""; ?>>Pending</option>
                           <option value="InProccess" <?php echo $v['result_admin_'.$catego->ShowTypesControl($o)]=="InProccess"?"selected":""; ?>>InProccess</option>
					</select>
                    <div id="mess_admin_<?php echo $v['id'].$j.$cc['id'];?>" style="color:green;font-weight:bold;font-size:9px;"></div>
                    <div id="show_img_admin_<?php echo $v['id'].$j.$cc['id'];?>">
                    <?php echo $catego->showimg($v['result_admin_'.$catego->ShowTypesControl($o)],$v['id'].$j.$cc['id'],"admin"); ?>
                    </div>
                    <div style="color:#C09;font-weight:bold;" id="ajax_admin_log_<?php echo $v['id'].$j.$cc['id']?>">
					<?php echo $slbUser[$v['admincheck']]['username'] ?>
                    </div>
					<a class="variouslog" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=gamechecklisttemp&func=logchecklist&id_game=<?php echo $cc['id_game']; ?>&id_request=<?php echo $v['id']; ?>&type=<?php echo $catego->ShowTypesControl($o); ?>&type_account=admin">LogAdmin</a>
                    <div id="ajax_admin_datecheck_<?php echo $v['id'].$j.$cc['id']?>">
                    <?php echo $v['dateadmincheck_'.$catego->ShowTypesControl($o)]; ?>
                    </div>
                    </td>
                    <td>
                    <!--Ghi chú Admin-->
                    <textarea  name="notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id']?>" id="notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>" cols="5" rows="10" style="width:150px;height:100px;resize:none" placeholder="Admin ghi chú" <?php echo ViewGroup::$group_admin!=-1?"readonly='readonly'":""; ?> onchange="ajax_update_admin('<?php echo $catego->ShowTypesControl($o);?>',<?php echo $v['id_game']?>,<?php echo $v['id_categories']?>,<?php echo $v['id']?>,'mess_admin_<?php echo $v['id'].$j.$cc['id'];?>',$('#cbo_result_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>').val(),$('#notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $v['id'].$j.$cc['id']?>').val(),<?php echo $_SESSION['account']['id']; ?>);" ><?php echo $v['notes_admin_'.$catego->ShowTypesControl($o)]; ?></textarea>
                    </td>
                    <td><a href="javascript:void(0);" onclick="refesh_result_user('<?php echo $catego->ShowTypesControl($o);?>',<?php echo $v['id_game']?>,<?php echo $v['id_categories']?>,<?php echo $v['id']?>,<?php echo $v['id'].$j.$cc['id']; ?>);">Refesh</a>
						<br />
						<hr />
						 <?php if(ViewGroup::$group_admin==-1){ ?>
						<a class="variousMail" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=gamechecklisttemp&func=sendmail&idp1=<?php echo $k['id']; ?>&idp2=<?php echo $cc['id']; ?>&id_game=<?php echo $cc['id_game']; ?>&id_template=<?php echo $cc['id_template']; ?>&id_request=<?php echo $v['id']; ?>&type=<?php echo $catego->ShowTypesControl($o); ?>&type_account=admin&c1=<?php echo base64_encode($k['names'])?>&c2=<?php echo base64_encode($cc['names'])?>&c3=<?php echo $v['titles'];?>" style="color:#07A924">SendMail</a>
						<?php }//end if ?>
					</td>
                </tr>
<?php
			 }//end if
		 }//end for
?>
<!--<tr id="res_row_<?php echo $v['id'];?>" class="res_row_tab_<?php echo $cc['id'];?>">
<td colspan="12"></td></tr>-->
<?php
		}//end for
?>
</table>
<?php
	}//end if
?>