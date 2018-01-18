<?php 
error_reporting(0);
?>
<?php
/*
<style>
	#content-t table thead tr{
		background: #f58220;
	}
	#content-t table thead tr th{
		padding: 5px;
		color: #eee;
	}
	#content-t table tbody tr td{
		padding: 10px 5px;
	}
	
	#content-t table tbody tr:nth-child(even){
		background: #ccc;
	}
	#content-t table tbody tr:nth-child(odd){
		background: #fff;
	}
	#content-t table tbody tr:hover{
		background: #f5b672;
	}
</style>
*/
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
<?php
    //echo '<pre>';
    //print_r($result);
    //echo '</pre>';
?>
<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
 <!--<table width="100%" border="0" class="table table-hover table-striped table-vcenter">-->
	<thead>
	<tr>
		<th width="5%" align="center">Stt</th>
        <th>Id</th>
		<th align="center">Game</th>
		<th align="center">Alias</th>
        <th width="7%" align="center">Order</th>
		<th align="center">Control</th>
	</tr>
	</thead>
	<tbody>
	<?php
    foreach($result as $key => $val){
	?>

        <?php
            $edit = "<a href='".base_url()."?control=giftcode&func=addmenu&id=".$val['id']."'><img src='".base_url()."assets/img/icon/icon_edit.png'></a>";
        ?>
        <tr>
            <td><?php echo $key + 1?></td>
            <td><?php echo $val['id']?></td>
            <td><?php echo $val['menu_name']?></td>
            <td><?php echo $val['alias']?></td>
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
	