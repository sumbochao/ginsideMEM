<?php
$xml=simplexml_load_string($listProjectRedmine) or die("Error: Cannot create object");
$i=0;
?>
<form name="frm_api" id="frm_api" enctype="multipart/form-data" method="post" action="<?php echo base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&id=".$_GET['id'] ?>" >
<table class="table table-striped" style="width:250px !important;">
	<tr>
    	<td><select name="cbo_projects" id="cbo_projects">
	<option value="">Chọn Projects</option>
    <?php
	foreach($xml as $v){
			echo "<option value='".$xml->project[$i]->id."'>".$xml->project[$i]->name."</option>";
			$i++;
	}
	?>
</select></td>
        <td><input type="submit" name="btn_exe" value="New Issues" class="btnB btn-primary" onclick="AlertOK();"></td>
    </tr>
    <tr>
    	<td colspan="2">
        <?php if($Mess!=""){ echo "<a href='".$Mess."' target='_blank'>".$Mess."</a>";} ;?>
        </td>
    </tr>
</table>
</form>