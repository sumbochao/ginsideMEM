<table width="100%" class="table" id="tblsort" style="background-color:transparent;">
    <thead>
        <tr>
            <th>Tình Trạng</th>
            <th>Ghi chú</th>
            <th>Ngày</th>
            <th>Account</th>
        </tr>
    </thead>
    <tbody>
 <?php
 if($_GET['type_account']=="user"){
	if(empty($listLog) !== TRUE){
    	foreach($listLog as $i=>$v){
?>
    <tr>
        <td><strong style="color:#936"><?php echo $v['status_user']; ?></strong></td>
        <td><?php echo $v['notes_user']; ?></td>
        <td><?php echo $v['date_user_update']; ?></td>
        <td><i style="color:#90F"><?php echo $slbUser[$v['user_check']]['username'];?></i></td>
    </tr>
<?php
	 } //end for
	} //end if
 }else{
	 if(empty($listLog) !== TRUE){
    	foreach($listLog as $i=>$v){
?>
	
	<tr>
        <td><strong style="color:#936"><?php echo $v['status_admin']; ?></strong></td>
        <td><?php echo $v['notes_admin']; ?></td>
        <td><?php echo $v['date_admin_update']; ?></td>
        <td><i style="color:#90F"><?php echo $slbUser[$v['admin_check']]['username'];?></i></td>
    </tr>
<?php
	 } //end for
	} //end if
 }//end if
?>
    </tbody>
</table>