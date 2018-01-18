<?php 
error_reporting(0);
?>
<style>
    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  /*background-color: #D1D119;
  background-color: #eeeeea;*/
  background-color: #dff0d8;
}
#content-t table tbody tr:nth-child(even){
		background: #eee;
	}
#content-t table tbody tr:nth-child(odd){
		background: #fff;
	}
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
<form action="" method="post" name="frmindex">

<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
 <!--<table width="100%" border="0" class="table table-hover table-striped table-vcenter">-->
	<thead>
	<tr>
		<th width="5%" align="center">Stt</th>
		<th align="center">Group Name</th>
        <th align="center">Alias</th>
        <th align="center">Apilink</th>
		<th align="center">ApiCheck</th>
        <th width="7%" align="center">Order</th>
		<th align="center">Control</th>
	</tr>
	</thead>
	<tbody>
	<?php
        foreach($group_menu as $key => $val){
        $edit = "<a href='".base_url()."?control=giftcodemanager&func=addgroupmenu&id=".$val['id']."'><img src='".base_url()."assets/img/icon/icon_edit.png'></a>";
	?>
	    <tr>
                <td><?php echo $key + 1?></td>
                <td><?php echo $val['display_name']?></td>
                <td><?php echo $val['alias']?></td>
                <td><?php echo $val['apilink']?></td>
                <td><?php echo $val['apicheck']?></td>
                <td><?php echo $val['order']?></td>
                <td align="center"><?php echo $edit?></td>
            </tr>
       
	<?php
        }        
	?>
	
	</tbody>
</table>
   
</form>
</div>
<script>
	function deleteSubmit(id,icon){
		var theform = document.frmindex;
			
		if (confirm('Có đồng ý xóa không?')) {
			theform.game_id.value = id;
			theform.game_icon.value = icon;
			theform.action = "<?php echo base_url()?>index.php/account/delete";
			theform.submit();
			return true;
		}
	}
</script>