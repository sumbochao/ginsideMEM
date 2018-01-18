<div class="loading_warning" style="text-align:center;display:none;position: fixed;top: 0;height:100%;width: 100%;z-index: 9999;background: url('<?php echo base_url('assets/img/ajax-loader.gif'); ?>') no-repeat scroll center center black;">
<img src="<?php echo base_url('assets/img/icon/loading_sign.gif'); ?>" />
</div>
<form name="frmemail" id="frmemail" enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>?control=gamechecklisttemp&func=sendmail&idp1=<?php echo $_GET['idp1']; ?>&idp2=<?php echo $_GET['idp2']; ?>&id_game=<?php echo $_GET['id_game']; ?>&id_template=<?php echo $_GET['id_template']; ?>&id_request=<?php echo $_GET['id_request']; ?>&type=<?php echo $_GET['type']; ?>&type_account=admin&c1=<?php echo $_GET['c1']?>&c2=<?php echo $_GET['c2']?>&c3=<?php echo $_GET['c3']?>&action=send">
<table>
    <tr>
            <td><span style="font-weight:bold;font-size: 20px;color: red">CC:</span>
        	<?php
                    if(count($groups)>0){
                        foreach($groups as $j=>$v){
                ?>
                	<input type="checkbox" name="chk_groupcc[]" value="<?php echo $v['id'] ?>" <?php echo $v['id']==$id_nhomhotro[$v['id']]?'checked="checked"':'';?>/>
                    <label>
					<?php echo $v['names'] ?>
                	</label>
                 <?php
                        }//end for
                    }//end if
                ?>
        </td>
    </tr>
	<tr><td colspan="2"><hr></td></tr>
	<tr>
    	<td><span style="font-weight:bold;font-size: 20px;color: red">To:</span>
        	<?php
                    if(count($groups)>0){
                        foreach($groups as $j=>$v){
                ?>
                	<input type="checkbox" name="chk_group[]" value="<?php echo $v['id'] ?>" <?php echo $v['id']==$id_nhomthuchien[$v['id']]?'checked="checked"':'';?>/>
                    <label>
					<?php echo $v['names'] ?>
                	</label>
                 <?php
                        }//end for
                    }//end if
                ?>
        </td>
    </tr>
	<tr><td colspan="2"><hr></td></tr>
	<!--<tr>
    	<td>
        	<input type="text" name="txt_sub" id="txt_sub" style="width: 498px;" value="Request checklist [<?php //echo $Game;?>]" placeholder="Subject">
        </td>
    </tr>-->
	<tr>
    	<td>
        	<textarea name="txt_body" id="txt_body" style="margin: 0px; width: 498px; height: 150px;">Vui lòng hoàn thành yêu cầu này</textarea>
        </td>
    </tr>
	<tr>
    	<td>Nhóm hỗ trợ: <?php echo $nhomhotro;?> </td>
    </tr>
	<tr>
    	<td>Nhóm thực hiện: <?php echo $nhomthuchien;?> </td>
    </tr>
    <tr>
    	<td style="text-align:center">
        <input type="button" name="btn_sendmail" id="btn_sendmail" value="Gửi Mail" onclick="send_mail();">
        </td>
    </tr>
</table>
<?php echo $Mess; ?>
</form>
<script src="<?php echo base_url()?>assets/fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
function send_mail(){
	$('.loading_warning').show();
	//$('#btn_sendmail').css('display','none');
	document.frmemail.submit();
}
</script>