<?php
//$catego = new ViewGroup(0,0);
$cate_child=$catego->ShowCateloriesChild($k['id']);

if(count($cate_child) >0 && !empty($cate_child)){
	foreach($cate_child as $c1=>$cc){
?>

<tr id="row_<?php echo $k['id'];?>" class="row_tab_<?php echo $k['id'];?>" style="display:none;">
             		<td style="background-color:#F5CA53;padding-left:50px;" colspan="13">
                    <a href="javascript:void(0);" style="text-transform: uppercase;text-decoration:none;font-weight:bold;font-size:14px;" title="<?php echo $cc['names'];?>" onclick="showRequest(<?php echo $cc['id'];?>);"><?php echo $cc['names'];?></a> | 
					<!--<a class="various" style="color:#268AB9;text-decoration:none;" href="#content-div-categories-child-<?php echo $cc['id'];?>"> Xem mô tả </a>
                    <div style="display:none">
                       <div id="content-div-categories-child-<?php echo $cc['id'];?>"><?php echo $cc['notes'];?></div>
                    </div>-->
                     <?php 
					$arr_tt=$catego->CalResultRequestInCategories($_GET['id_game'],$_GET['id_template'],$cc['id']);
					$arr_tt_u=$catego->CalResultRequestInCategoriesUser($_GET['id_game'],$_GET['id_template'],$cc['id']);
					 ?>
                    Kết quả User:<?php 
					if(count($arr_tt_u)>0){
							$re=$catego->array_isearch("Fail",$arr_tt_u[0]);
							if(count($re)!=0){
								//fail
								echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png' style='width:14px;height:14px' />";
							}else{
								//Pass
								$re1=$catego->array_isearch("NO",$arr_tt_u[0]);
								if(count($re1)!=0){
									echo "<i style='color:#F5281D'>NOT WORK</i>";
								}else{
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick.png' style='width:14px;height:14px' />";
								}
							}
					}else{
						echo "<i style='color:#F5281D'>NOT WORK</i>";
					}
					 ?>
                    
                    Kết quả Admin:<?php 
					if(count($arr_tt)>0){
							$re=$catego->array_isearch("Fail",$arr_tt[0]);
							if(count($re)!=0){
								//fail
								echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/error.png' style='width:14px;height:14px' />";
							}else{
								//Pass
								$re1=$catego->array_isearch("NO",$arr_tt[0]);
								if(count($re1)!=0){
									echo "<i style='color:#F5281D'>NOT WORK</i>";
								}else{
									echo "<img boder='0' id='img_status_$id' src='".base_url()."assets/img/tick.png' style='width:14px;height:14px' />"; 
								}
							}
					}else{
						echo "<i style='color:#F5281D'>NOT WORK</i>";
					}
					 ?>
                    </td>
</tr>
<?php
	include("showrequest.php");
	}//end for
}//end if
		
?>