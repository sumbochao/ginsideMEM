<?php
$datar=$catego->listC1($cc['id']);	
$j=0;
$img_on="<img boder='0' src='".base_url()."assets/img/tick.png'>";
if(count($datar)>0 && $datar != NULL){
	foreach($datar as $i=>$v){
		 $type_request=$catego->GetTypesRequest($v['id_request']);
?>
<tr id="res_row_<?php echo $v['id'];?>" class="res_row_tab_<?php echo $cc['id'];?>" style="display:none;">
             		<td style="background-color:#F5CA53;">
              
                    </td>
                    <td>
                    <a href="<?php echo base_url();?>?control=request&func=edit&id=<?php echo $v['id_request'];?>&id_template=<?php echo $_GET['id_template'];?>&id_categories=<?php echo $v['id_categories'];?>" target="_blank" style="color:#E81287;text-decoration:none;font-style:italic;"><?php echo $slbRequest[$v['id_request']]['titles'];?></a>
                    </td>
                    
                    <td>
                    	<?php
					
						 echo $type_request['android']=="true"?"android $img_on <br>":"";
						 echo $type_request['ios']=="true"?"ios $img_on<br>":"";
						 echo $type_request['wp']=="true"?"wp $img_on<br>":"";
						 echo $type_request['pc']=="true"?"PC $img_on<br>":"";
						 echo $type_request['web']=="true"?"Config $img_on<br>":"";
						 echo $type_request['events']=="true"?"Event $img_on<br>":"";
						 echo $type_request['systems']=="true"?"System $img_on<br>":"";
						 echo $type_request['orther']=="true"?"Orther $img_on":"";
						?>
                    </td>
                    <td><?php echo $type_request['admin_request'];?></td>
                    <td>
					<?php 
							  echo $catego->CreateControlGroup($v['id_request'],0);
					?>
                    </td>
                    <td>
					<?php 
							  echo $catego->CreateControlGroup($v['id_request'],1);
					?></td>
                   <!-- <td><?php echo $v['client_ios'];?></td>
                    <td><?php echo $v['client_android'];?></td>
                    <td><?php echo $v['client_wp'];?></td>
                    <td><?php echo $v['none_client'];?></td>-->
                    <!--<td><?php echo $v['datecheck'];?></td>
                    <td><?php echo $slbUser[$v['userchecklist']]['username'];?></td>-->
                    <td><?php echo $slbUser[$v['userlog']]['username'];?></td>
                   <!-- <td><?php echo stripslashes($v['notes']);?></td>-->
                </tr>
<?php
	   
		}//end for
	}
?>