<?php
foreach($child as $jj=>$vv){
?>
<tr class="child_<?php echo $v['id'];?>" style="display:none;">
                	<td>
                    <a href="<?php echo base_url()."?control=".$_GET['control']."&func=edit&id=".$vv['id']."&id_game=".$vv['id_game']."&id_template=".$_GET['id_template'] ?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url().'assets/img/icon_edit.png'; ?>"></a>
                        
<a onclick="checkdel('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=delete&id=".$vv['id']."&id_game=".$vv['id_game']."&id_template=".$_GET['id_template'] ?>')" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url().'assets/img/icon_del.png'; ?>"></a> 
					<a href="<?php echo base_url()."?control=".$_GET['control']."&func=add&id_game=".$vv['id_game']."&id_categories=".$v['id']."&id_template=".$_GET['id_template'] ?>" title="Thêm"><img src="<?php echo base_url(); ?>assets/img/icon/cong.png" width="16" height="16" alt="Thêm"></a>
                    </td>
                    <td><i>___<?php echo $vv['names'];?></i>(<?php  
		echo "<i style='color:#E28603'>".$cate->CountRequest($vv['id_game'],$vv['id'])." yêu cầu</i>"; ?> )</td>
        			<td><strong><?php echo $cate->ShowGroupOnCate($vv['id_game'],$vv['id']); ?></strong></td>
       			    <td>
                    <div id="divstatus_<?php echo $vv['id'] ?>">
                    <a href="javascript:void(0)" onclick="UpStatusCate(<?php echo $vv['id'] ?>,<?php echo $vv['status']; ?>);"><?php echo $vv['status']==0?"<strong style='color:green'>On</strong>":"<strong style='color:red'>Off</strong>";?></a>
                    </div>
                    </td>
                    <td><a href="<?php echo base_url()."?control=requestgametemplate&func=index&id_categories=".$vv['id']."&id_game=".$vv['id_game'] ?>" target="_blank" >Xem</a></td>
                    <td><input type="text" name="sort[<?php echo $vv['id'] ?>]" id="sort_<?php echo $vv['id'] ?>" value="<?php echo $vv['order'] ?>" style="width:30px;" onkeypress="calljavascript(3,<?php echo $vv['id'] ?>);" onkeyup="calljavascript(3,<?php echo $vv['id'] ?>);" />
                    <div id="messsort_<?php echo $vv['id'] ?>" style="font-size:9px;color:#00F"></div>
                    </td>
                    <td><?php echo $vv['datecreate'];?></td>
                    <td><?php echo $slbUser[$vv['userlog']]['username'];?></td>
                </tr>
<?php } ?>