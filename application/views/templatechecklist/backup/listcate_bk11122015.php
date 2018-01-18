<?php
$catego = new ViewGroup();
$datar=$catego->listC($k['id']);
$cate_child=$catego->ShowCateloriesChild($k['id']);

if(count($cate_child)>0 && $cate_child != NULL){
	foreach($cate_child as $c=>$cc){
		
	}
}
		
$static=0;
$j=0;
$img_on="<img boder='0' src='".base_url()."assets/img/tick.png'>";
if(count($datar)>0 && $datar != NULL){
	foreach($datar as $i=>$v){
?>
<tr id="row_<?php echo $v['id'];?>" class="row_tab_<?php echo $k['id'];?>" style="display:none;">
             		<td style="background-color:#F5CA53;">
                    <?php if($static!=$v['id_categories']){ $j++; echo "<strong style='color:red'>".$j."</strong>"; ?> - <a href="<?php echo base_url();?>?control=categories&func=edit&id=<?php echo $v['id_categories'];?>&id_template=<?php echo $_GET['id_template'];?>" target="_blank" style="text-transform: uppercase;text-decoration:none;font-weight:bold;font-size:14px;" title="<?php echo $slbCategories[$v['id_categories']]['notes'];?>" onclick="showRequest(<?php echo $v['id'];?>);"><?php echo $slbCategories[$v['id_categories']]['names'];?></a>
                    [ status: <?php echo $slbCategories[$v['id_categories']]['status']==0?"<img src='".base_url()."assets/img/tick.png' width='16' height='16' >":"<img src='".base_url()."assets/img/off.gif' width='16' height='16' >";?> ]
                    <?php }//end if ?>
                    </td>
                    <td class="Request_<?php echo $v['id'];?>">
                    <a href="<?php echo base_url();?>?control=request&func=edit&id=<?php echo $v['id_request'];?>&id_template=<?php echo $_GET['id_template'];?>&id_categories=<?php echo $v['id_categories'];?>" target="_blank" style="color:#E81287;text-decoration:none;font-style:italic;"><?php echo $slbRequest[$v['id_request']]['titles'];?></a>
                    </td>
                    <td class="Request_<?php echo $v['id'];?>">
                    	<?php
						 $type_request=$catego->GetTypesRequest($v['id_request']);
						 echo $type_request['android']=="true"?"android ".$img_on.",":"";
						 echo $type_request['ios']=="true"?"ios ".$img_on.",":"";
						 echo $type_request['wp']=="true"?"wp ".$img_on.",":"";
						 echo $type_request['pc']=="true"?"PC ".$img_on.",":"";
						 echo $type_request['web']=="true"?"Web ".$img_on.",":"";
						 echo $type_request['events']=="true"?"Event ".$img_on.",":"";
						 echo $type_request['systems']=="true"?"System ".$img_on.",":"";
						 echo $type_request['orther']=="true"?"Orther ".$img_on.",":"";
						?>
                    </td>
                    <td class="Request_<?php echo $v['id'];?>">
					<?php $c1=new ViewGroup($v['id_request'],0);
							  echo $c1->CreateControlGroup();
					?>
                    </td>
                    <td class="Request_<?php echo $v['id'];?>">
					<?php $c2=new ViewGroup($v['id_request'],1);
							  echo $c2->CreateControlGroup();
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
	   $static=$v['id_categories']; 
		}//end for
	}
?>
