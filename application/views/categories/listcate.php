<?php
foreach($child as $jj=>$vv){
?>
<tr class="child_<?php echo $v['id'];?>" style="display:none;">
                	<td>
                    <a href="<?php echo base_url()."?control=".$_GET['control']."&func=edit&id_template=".$vv['id_template']."&id=".$vv['id'] ?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url().'assets/img/icon_edit.png'; ?>"></a>
                        
<a onclick="checkdel('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=delete&id=".$vv['id']."&id_template=".$vv['id_template'] ?>')" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url().'assets/img/icon_del.png'; ?>"></a> 
					<a href="<?php echo base_url()."?control=".$_GET['control']."&func=add&id_template=".$vv['id_template']."&id_categories=".$v['id'] ?>" title="Thêm"><img src="<?php echo base_url(); ?>assets/img/icon/cong.png" width="16" height="16" alt="Thêm"></a>
                    </td>
                    <!--<td><a href="<?php echo base_url()."?control=".$_GET['control']."&func=checklist&idtemplate=".$vv['id_template']."&idcategories=".$vv['id'] ?>">Tạo</a></td>-->
                    <td style="background:#990">
                    <?php if($vv['id_template']!=$static){ ?>
                    <strong style="color:#903;font-size:10px;"><?php echo $slbTemp[$vv['id_template']]['template_name']; ?></strong>
                    <?php } ?>
                    </td>
                    <td><i>___<?php echo $vv['names'];?></i>(<?php  
		$this->db_slave->select(array('*'));
		$this->db_slave->from('tbl_request');
		$this->db_slave->where('id_categories', $vv['id']);
		$data = $this->db_slave->get();
		$result = $data->result_array();
		echo "<i style='color:#E28603'>".count($result)." yêu cầu</i>"; ?> )</td>
       			    <td>
                    <div id="divstatus_<?php echo $vv['id'] ?>">
                    <a href="javascript:void(0)" onclick="UpStatusCate(<?php echo $vv['id'] ?>,<?php echo $vv['status']; ?>);"><?php echo $vv['status']==0?"<strong style='color:green'>On</strong>":"<strong style='color:red'>Off</strong>";?></a>
                    </div>
                    </td>
                    <td><a href="<?php echo base_url()."?control=request&func=index&id_categories=".$vv['id']."&id_template=".$vv['id_template'] ?>" target="_blank" >Xem</a></td>
                    <td><input type="text" name="sort[<?php echo $vv['id'] ?>]" id="sort_<?php echo $vv['id'] ?>" value="<?php echo $vv['order'] ?>" style="width:30px;" onkeypress="calljavascript(3,<?php echo $vv['id'] ?>);" onkeyup="calljavascript(3,<?php echo $vv['id'] ?>);" />
                    <div id="messsort_<?php echo $vv['id'] ?>" style="font-size:9px;color:#00F"></div>
                    </td>
                    <td><?php echo $vv['datecreate'];?></td>
                    <td><?php echo $slbUser[$vv['userlog']]['username'];?></td>
                </tr>
<?php } ?>