<script>$('.loading_warning').show();</script>
<?php
//$catego = new ViewGroup(0,0);
$cate_child=$catego->ShowCategoriesChild($k['id_game'],$k['id']);

if(count($cate_child) >0 && !empty($cate_child)){
	
?>
<table class="table con" id="tbltable_<?php echo $k['id']; ?>" style="display:none">
	<tbody>
    	<?php  foreach($cate_child as $c1=>$cc){ ?>
        <tr style="background-color:#D0BA7D;padding-left:50px;">
        	<td style="width:400px;"><a href="javascript:void(0);" class="aTog_<?php echo $k['id'];?>" style="text-transform: uppercase;text-decoration:none;font-weight:bold;font-size:14px;" title="<?php echo $cc['names'];?>" onclick="showRequest(<?php echo $cc['id'];?>);"><?php echo $cc['names'];?></a>
				<h5 style="float:right"><?php echo $catego->CountRequestOfType($k['id_game'],$cc['id'],0,$_POST['cbo_group']);?></h5>
				<!--<div id="ajax_statistical_view_<?php echo $cc['id'];?>">
				 <script language="javascript">
				 $(document).ready(function(e) {
					 statistical_compact(<?php echo $cc['id'];?>,<?php echo $cc['id_game'];?>);
					});
				 </script>
				</div>-->
				<br/>
				 Nhóm thực hiện : <strong><?php echo $catego->ShowGroupOnCate($cc['id_game'],$cc['id']); ?></strong>
			</td>
            <td style="width:150px;">
            	<a href="javascript:void(0);" style="color:#D00AC8" onclick="statistical(<?php echo $cc['id'];?>,<?php echo $cc['id_game'];?>,$('#cbo_group').val());">Thống kê chi tiết</a>
            </td>
            <td><div id="ajax_statistical_<?php echo $cc['id'];?>" onclick="$('#ajax_statistical_<?php echo $cc['id'];?>').html('');"></div></td>
        </tr>
        <tr style="background-color:#D0BA7D;">
            <td style="padding-bottom:0;" colspan="3">
            <?php include('showrequest.php'); ?>
            </td>
        </tr>
        <?php
				}//end for
		?>
    </tbody>
</table>
<?php
}//end if
		
?>
<script>$('.loading_warning').hide();</script>
