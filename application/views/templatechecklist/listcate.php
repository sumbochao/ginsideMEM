<?php
$cate_child=$catego->ShowCateloriesChild($k['id']);

if(count($cate_child)>0 && !empty($cate_child)){
	foreach($cate_child as $c1=>$cc){
?>
<tr id="row_<?php echo $k['id'];?>" class="row_tab_<?php echo $k['id'];?>" style="display:none;">
             		<td style="background-color:#F5CA53;padding-left:50px;" colspan="7">
                    <a href="javascript:void(0);" style="text-transform: uppercase;text-decoration:none;font-weight:bold;font-size:14px;" title="<?php echo $cc['notes'];?>" onclick="showRequest(<?php echo $cc['id'];?>);"><?php echo $cc['names'];?></a>[ status: <?php echo $cc['status']==0?"<img src='".base_url()."assets/img/tick.png' width='16' height='16' >":"<img src='".base_url()."assets/img/off.gif' width='16' height='16' >";?> ]
                    </td>
</tr>
<?php
	include("showrequest.php");
	}//end for
}//end if
		
?>
