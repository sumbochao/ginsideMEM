<?php

$datar=$catego->listC1($cc['id']);	
$j=0;
$img_on="<img boder='0' src='".base_url()."assets/img/tick.png'>";
if(count($datar)>0 && $datar != NULL){
	foreach($datar as $i=>$v){
		
		 $type_request=$catego->GetTypesRequest($v['id_request']);
		 //dua loai cua yeu cau vao mang de tao vong lap
		 $data_type = array(
			 0 => $type_request['android'],
			 1 => $type_request['ios'],
			 2 => $type_request['wp'],
			 3 => $type_request['pc'],
			 4 => $type_request['web'],
			 5 => $type_request['events'],
			 6 => $type_request['systems'],
			 7 => $type_request['orther']
		 );
		 $total_pass=0;
	     $total_fail=0;
		 $total_pass_user=0;
	     $total_fail_user=0;
		 //lay thong tin bang result de ghep voi bang template 
		 $show_result = $catego->getResultCheckList($_GET['id_template'],$_GET['id_game'],$v['id_categories'],$v['id_request']);
?>
<tr id="res_row_h_<?php echo $v['id'];?>" class="res_row_tab_<?php echo $cc['id'];?>" style="display:none;">
        <th width="50px"></th>
        <th align="center" width="450px">Yêu cầu</th>
        <th align="center" width="50px">Loại</th>
        <th align="center" width="250px">Kết quả <br />mong muốn</th>
        <th align="center" width="70px">Nhóm <br />thực hiện</th>
        <th align="center" width="70px">Nhóm hỗ trợ</th>
        <th align="center" width="70px">Chọn tình trạng</th>
        <th align="center" width="70px">Người thực hiện<br />ghi chú</th>
        <th align="center" width="70px">Admin <br />chọn kết quả</th>
        <th align="center" width="70px">Ghi chú admin</th>
        <th align="center" width="150px">Ngày checklist</th>
        <th align="center" width="70px">User check</th>
</tr>
<?php
		 for($o=0;$o <= count($data_type);$o++){
			 if($data_type[$o]!="" && !empty($data_type[$o])){
				 $j++;
?>
<tr id="res_row_<?php echo $v['id'];?>" class="res_row_tab_<?php echo $cc['id'];?>" style="display:none;">
             		
                    <td style="background-color:#F5CA53;">
              			<input class="btnB btn-primary" type="button" name="btn_update_" id="btn_update_<?php echo $cl.$j.$cc['id'];?>" value="Lưu" style="width:35px;font-size:9px;padding-left:10px;" onclick="ajax_update('<?php echo ViewGroup::$type_user_log;?>',<?php echo $_GET['id_game'];?>,<?php echo $_GET['id_template'];?>,<?php echo $v['id_categories'];?>,<?php echo $v['id_request'];?>,'mess_<?php echo $v['id'].$cl.$j.$cc['id'];?>','<?php echo $catego->ShowTypesControl($o);?>',$('#cbo_result_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#cbo_result_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val());" />
                        <br />
                    <div id="mess_<?php echo $v['id'].$cl.$j.$cc['id'];?>" style="color:green;font-weight:bold;font-size:9px;"></div>
                    </td>
                    <td style="width:400px;">
                    <a class="various" style="color:#268AB9;text-decoration:none;" href="#content-div-request-<?php echo $v['id'];?>"><?php echo nl2br($slbRequest[$v['id_request']]['titles']);?></a>
                    <div style="display:none">
                       <div id="content-div-request-<?php echo $v['id'];?>"><?php echo $slbRequest[$v['id_request']]['notes'];?></div>
                    </div>
                    </td>
                    <td><?php echo $catego->ShowTypes($o);?></td>
                    <td><?php echo nl2br($type_request['admin_request']);?></td>
                    <td>
					<?php echo $catego->CreateControlGroup($v['id_request'],0);?>
                    </td>
                    <td>
					<?php echo $catego->CreateControlGroup($v['id_request'],1);?></td>
                    <td>
                    <select name="cbo_result_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id']?>" id="cbo_result_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>" style="width:100px;" onchange="getresultimg(this.value,'img_status_<?php echo $v['id'].$cl.$j.$cc['id'];?>');">
                        <option value="None"  <?php echo $show_result[$catego->ShowTypesControl($o)]=="None"?"selected":""; ?> >None</option>
                        <option value="Pass" <?php echo $show_result[$catego->ShowTypesControl($o)]=="Pass"?"selected":""; ?>>Pass</option>
                        <option value="Fail" <?php echo $show_result[$catego->ShowTypesControl($o)]=="Fail"?"selected":""; ?>>Fail</option>
                        <option value="Cancel" <?php echo $show_result[$catego->ShowTypesControl($o)]=="Cancel"?"selected":""; ?>>Cancel</option>
                        <option value="Pending" <?php echo $show_result[$catego->ShowTypesControl($o)]=="Pending"?"selected":""; ?>>Pending</option>
                        <option value="InProccess" <?php echo $show_result[$catego->ShowTypesControl($o)]=="InProccess"?"selected":""; ?>>InProccess</option>
                    </select>
                    <?php echo $catego->showimg($show_result[$catego->ShowTypesControl($o)],$v['id'].$cl.$j.$cc['id'],"user"); ?>
                    </td>
                   <td><textarea name="notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id']?>" id="notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>" cols="5" rows="10" style="width:150px;height:100px;resize:none" placeholder="Người thực hiện ghi chú"><?php echo $show_result['notes_clients_'.$catego->ShowTypesControl($o)]; ?></textarea></td>
                    <td>
                    <select name="cbo_result_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id']?>" id="cbo_result_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>" style="width:100px;" onchange="getresultimg(this.value,'admin_img_status_<?php echo $v['id'].$cl.$j.$cc['id'];?>');ajax_update('<?php echo ViewGroup::$type_user_log;?>',<?php echo $_GET['id_game'];?>,<?php echo $_GET['id_template'];?>,<?php echo $v['id_categories'];?>,<?php echo $v['id_request'];?>,'mess_<?php echo $v['id'].$cl.$j.$cc['id'];?>','<?php echo $catego->ShowTypesControl($o);?>',$('#cbo_result_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#cbo_result_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val());" <?php echo ViewGroup::$type_user_log=="user"?"disabled='disabled'":""; ?> >
                        <option value="None" <?php echo $show_result['result_admin_'.$catego->ShowTypesControl($o)]=="None" || $show_result['result_admin_'.$catego->ShowTypesControl($o)]==""?"selected":""; ?>>None</option>
                        <option value="Pass" <?php echo $show_result['result_admin_'.$catego->ShowTypesControl($o)]=="Pass"?"selected":""; ?>>Pass</option>
                        <option value="Fail" <?php echo $show_result['result_admin_'.$catego->ShowTypesControl($o)]=="Fail"?"selected":""; ?>>Fail</option>
                    </select>
                    
                    <?php echo $catego->showimg($show_result['result_admin_'.$catego->ShowTypesControl($o)],$v['id'].$cl.$j.$cc['id'],"admin"); ?>
                    <br />
                    <strong style="color:#C09"><?php echo $slbUser[$show_result['admincheck']]['username'] ?></strong>
                    <br />
                    <?php echo $show_result['dateadmincheck']; ?>
                    </td>
                    <td><textarea  name="notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id']?>" id="notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>" cols="5" rows="10" style="width:150px;height:100px;resize:none" placeholder="Admin ghi chú" <?php echo ViewGroup::$type_user_log=="user"?"readonly='readonly'":""; ?> onchange="ajax_update('<?php echo ViewGroup::$type_user_log;?>',<?php echo $_GET['id_game'];?>,<?php echo $_GET['id_template'];?>,<?php echo $v['id_categories'];?>,<?php echo $v['id_request'];?>,'mess_<?php echo $v['id'].$cl.$j.$cc['id'];?>','<?php echo $catego->ShowTypesControl($o);?>',$('#cbo_result_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#notes_clients_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#cbo_result_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val(),$('#notes_admin_<?php echo $catego->ShowTypesControl($o);?>_<?php echo $type_request['id'].$cl.$j.$cc['id']?>').val());" ><?php echo $show_result['notes_admin_'.$catego->ShowTypesControl($o)]; ?></textarea></td>
                    <td><?php echo $show_result['datecreate'];?></td>
                    <td><strong><?php echo $slbUser[$show_result['userlog']]['username'];?></strong></td>
                </tr>
<?php
				if($show_result['result_admin_'.$catego->ShowTypesControl($o)]=="Pass"){
					 $total_pass=$total_pass +1;
					 
				}
				 if($show_result['result_admin_'.$catego->ShowTypesControl($o)]=="Fail"){
				 	$total_fail=$total_fail+1;
					
				 }
				 if($show_result['result_admin_'.$catego->ShowTypesControl($o)]=="None"){
				 	$total_fail=0;
					$total_pass=0;
				 }
				 //tinh ket qua user
				 if($show_result[$catego->ShowTypesControl($o)]=="Pass"){
					 $total_pass_user=$total_pass_user +1;
					 
				}
				 if($show_result[$catego->ShowTypesControl($o)]!="Pass" && $show_result[$catego->ShowTypesControl($o)]!="None" && $show_result[$catego->ShowTypesControl($o)]!="" ){
				 	$total_fail_user=$total_fail_user+1;
					
				 }
		 	
			}//end if
		 }//end for
?>
<tr id="res_row_<?php echo $v['id'];?>" class="res_row_tab_<?php echo $cc['id'];?>" style="display:none;">
<td colspan="12" style="padding-left:22px;">
Kết quả đánh giá Admin theo yêu cầu :<strong><?php echo $slbRequest[$v['id_request']]['titles'];?></strong> ( <font style="color:green"><?php echo $total_pass!=0?$total_pass." Pass":""; $catego->SetCountAdmin($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],$total_pass,0,"Pass");?></font>
<!--<img boder="0" src="<?php echo base_url()."/assets/img/tick.png"; ?>" style="width:14px;height:14px">-->:
<font style="color:red"><?php echo $total_fail!=0?$total_fail." Fail":""; $catego->SetCountAdmin($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],0,$total_fail,"Fail");?></font>
<!--<img boder="0" src="<?php echo base_url()."/assets/img/error.png"; ?>" style="width:14px;height:14px">--> )
<?php 
	if($total_fail==0 && $total_pass!=0){
		echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick.png' style='width:14px;height:14px' />"; 
		$catego->SetTotalResultRequest($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],"Pass");
	}elseif($total_fail==0 && $total_pass==0){
		echo "<i style='color:green'>NOT WORK</i>"; 
		$catego->SetTotalResultRequest($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],"NO");
	}else{
		echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png' style='width:14px;height:14px' />";
		$catego->SetTotalResultRequest($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],"Fail");
	}

?>
</td>
</tr>

<tr id="res_row_<?php echo $v['id'];?>" class="res_row_tab_<?php echo $cc['id'];?>" style="display:none;">
<td colspan="12" style="padding-left:22px;">
Kết quả USER theo yêu cầu :<strong><?php echo $slbRequest[$v['id_request']]['titles'];?></strong> ( <font style="color:green"><?php echo $total_pass_user!=0?$total_pass_user." Pass":""; $catego->SetCountUser($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],$total_pass_user,0,"Pass");?></font>
<!--<img boder="0" src="<?php echo base_url()."/assets/img/tick.png"; ?>" style="width:14px;height:14px">-->:
<font style="color:red"><?php echo $total_fail_user!=0?$total_fail_user." Fail":""; $catego->SetCountUser($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],0,$total_fail_user,"Fail");?></font>
<!--<img boder="0" src="<?php echo base_url()."/assets/img/error.png"; ?>" style="width:14px;height:14px">--> )
<?php 
	//user
	if($total_fail_user==0 && $total_pass_user!=0){
		echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick.png' style='width:14px;height:14px' />"; 
		$catego->SetTotalResultRequestUser($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],"Pass");
	}elseif($total_fail_user==0 && $total_pass_user==0){
		echo "<i style='color:green'>NOT WORK</i>"; 
		$catego->SetTotalResultRequestUser($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],"NO");
	}else{
		echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png' style='width:14px;height:14px' />";
		$catego->SetTotalResultRequestUser($_GET['id_game'],$_GET['id_template'],$v['id_categories'],$v['id_request'],"Fail");
	}

?>
</td>
</tr>

<tr id="res_row_<?php echo $v['id'];?>" class="res_row_tab_<?php echo $cc['id'];?>" style="display:none;"><td style="background-color:#FF0101;" colspan="12"></td></tr>

<?php
		}//end for
	}
?>
