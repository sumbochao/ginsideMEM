<?php
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
	
	.buttongreen{
		border: 0;
		outline: none;
		padding: 6px 9px;
		margin: 2px;
		cursor: pointer;
		font-family: 'PTSansRegular', Arial, Helvetica, sans-serif;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px!important;
		-o-border-radius: 3px;
		-khtml-border-radius: 3px;
		border-radius: 3px;
		text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
		color: #fff;
		text-shadow: 0 -1px 1px rgba(0,0,0,.25);
		background-color: #019ad2;
		background-repeat: repeat-x;
		background-image: -moz-linear-gradient(#33bcef,#019ad2);
		background-image: -ms-linear-gradient(#33bcef,#019ad2);
		background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#33bcef),color-stop(100%,#019ad2));
		background-image: -webkit-linear-gradient(#33bcef,#019ad2);
		background-image: -o-linear-gradient(#33bcef,#019ad2);
		background-image: linear-gradient(#33bcef,#019ad2);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef',endColorstr='#019ad2',GradientType=0);
		border-color: #057ed0;
		-webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.1);
		box-shadow: inset 0 1px 0 rgba(255,255,255,.1);
	}
	.buttongreen:hover{
		border: 0;
		outline: none;
		padding: 6px 9px;
		margin: 2px;
		cursor: pointer;
		font-family: 'PTSansRegular', Arial, Helvetica, sans-serif;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px!important;
		-o-border-radius: 3px;
		-khtml-border-radius: 3px;
		border-radius: 3px;
		text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
		color: #fff;
		text-shadow: 0 -1px 1px rgba(0,0,0,.25);
		background-color: #019ad2;
		background-repeat: repeat-x;
		background-image: -moz-linear-gradient(#019ad2,#33bcef);
		background-image: -ms-linear-gradient(#019ad2,#33bcef);
		background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#33bcef),color-stop(100%,#019ad2));
		background-image: -webkit-linear-gradient(#019ad2,#33bcef);
		background-image: -o-linear-gradient(#019ad2,#33bcef);
		background-image: linear-gradient(#019ad2,#33bcef);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef',endColorstr='#019ad2',GradientType=0);
		border-color: #057ed0;
		-webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.1);
		box-shadow: inset 0 1px 0 rgba(255,255,255,.1);
		text-decoration: none;
	}
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
<form action="" method="post" name="frmindex">
<?php
    //echo '<pre>';
    //print_r($result);
    //echo '</pre>';
?>
<a class="buttongreen" href="https://ginside.mobo.vn/?control=game&func=addgiftcode&app=<?php echo $_GET['app'];?>&data=<?php echo $_GET['data']; ?>">Thêm dữ liệu</a>
<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
 <!--<table width="100%" border="0" class="table table-hover table-striped table-vcenter">-->
	<thead>
	<tr>
		<th width="5%" align="center">Stt</th>
        <th>Message</th>
		<th align="center">Type</th>
		<th align="center">Photo</th>
        <th width="7%" align="center">Link</th>
		<th align="center">Startdate</th>
		<th align="center">Enddate</th>
		<th align="center">Status</th>
		<th align="center">App</th>
		<th align="center">Control</th>
	</tr>
	</thead>
	<tbody>
	<?php
        foreach($infomfb as $key => $val){
	?>
	<tr>
        <td><?php echo $key + 1?></td>
        <td><?php echo $val['message']?></td>
        <td><?php echo $val['type']?></td>
        <td><?php echo $val['photo']?></td>
		<td><?php echo $val['link']?></td>
		<td><?php echo $val['startdate']?></td>
		<td><?php echo $val['enddate']?></td>
		<td><?php echo ($val['status']==1)?"Hiện":"Ẩn";?></td>
		<td><?php echo $val['app']?></td>
		<td><?php echo $edit = "<a href='".base_url()."?control=game&func=addgiftcode&app=".$val['app']."&data=".$_GET['data']."&id=".$val['idfb']."'><img src='".base_url()."assets/img/icon/icon_edit.png'></a>";?> </td>
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
	