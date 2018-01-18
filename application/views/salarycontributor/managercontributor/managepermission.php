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
 <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
 <!--<table width="100%" border="0" class="table table-hover table-striped table-vcenter">-->
	<thead>
	<tr>
		<th width="50">Stt</th>
		<th width="200">UserName</th>
		<th>FullName</th>
		<th>SecurityCode</th>
		<th>Group</th>
		<th>Control</th>
	</tr>
	</thead>
	<tbody>
	<?php
        
	foreach($result as $key => $val){
	$stt = $start + $key + 1;
	
	if($val['status'] == 0){
            $sts = "<a href='".base_url()."?control=account&func=add&id=".$val['id']."&st=".$val['status']."'><img src='".base_url()."assets/img/icon/inactive.png'></a>";
	}else{
            $sts = "<a href='".base_url()."?control=account&func=add&id=".$val['id']."&st=".$val['status']."'><img src='".base_url()."assets/img/icon/active.png'></a>";
	}
	
	$edit = "<a href='".base_url()."?control=account&func=add&id=".$val['id']."'><img src='".base_url()."assets/img/icon/icon_edit.png'></a>";
	
        $delete = "<a href='".base_url()."?control=account&func=add&iddelete=".$val['id']."'><img src='".base_url()."assets/img/icon/action_delete.gif'></a>";
	
        
        ?>
	<tr>
            <td><?=$stt?></td>
            <td><?=$val['username']?></td>
            <td><?=$val['fullname']?></td>
			<td><?=$val['security_code']?></td>
			<td>
                <?php
                    switch ($val['id_group']){
                        case '1':
                            echo 'Toàn quyền';
                            break;
                        case '2':
                            echo 'Giới hạn quyền';
                            break;
						case '3':
                            echo 'User thường';
                            break;
                        default :
                            echo "";
                            break;
                    }
                ?>
            </td>
			<td>
                <?php
                        echo '<a href="'.base_url().'?control='.$_GET['control'].'&func=managepermission&view=gamepermission&id='.$val['id'].'" title="Phân quyền"><img src="'.base_url().'assets/img/exclamation.gif"/></a>'.'&nbsp;&nbsp;&nbsp;&nbsp;';
                ?>
            </td>
            
	</tr>
	<?php
         
	}
        
	?>
	
	</tbody>
</table>
    <?php echo $pages?>
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
	