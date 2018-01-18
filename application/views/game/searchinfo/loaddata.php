<div tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="myCart">
    <div id="frmMain">
        <div class="modal-header">
          <button onclick="closePopup();" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Xem <?php echo $title;?></h3>
        </div>
		<?php
			$info = json_decode(base64_decode($info),true);
		?>
        <form name="frmLogin" action="" method="post" enctype="multipart/form-data">
            <div class="modal-body">
				<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<tr>
							<th align="center">CreateTime</th>
							<th align="center">Role Occupation</th>
							<th align="center">Role State</th>
							<th align="center">Server ID</th>
							<th align="center">User Online State</th>
							<th align="center">Character Name</th>
							<th align="center">Character ID</th>
							<th align="center">Level</th>
							<th align="center">Account Name</th>
							<th align="center">Gold</th>
							<th align="center">Exp</th>
							<th align="center">Play time</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center"><?php echo $info['createTime'];?></td>
							<td align="center"><?php echo $info['roleOccupation'];?></td>
							<td align="center"><?php echo $info['roleState'];?></td>
							<td align="center"><?php echo $info['server_id'];?></td>
							<td align="center"><?php echo $info['userOnlineState'];?></td>
							<td align="center"><?php echo $info['character_name'];?></td>
							<td align="center"><?php echo $info['character_id'];?></td>
							<td align="center"><?php echo $info['level'];?></td>
							<td align="center"><?php echo $info['accountName'];?></td>
							<td align="center"><?php echo $info['gold'];?></td>
							<td align="center"><?php echo $info['exp'];?></td>
							<td align="center"><?php echo $info['play_time'];?></td>
						</tr>
					</tbody>
				</table>
            </div>
            <div class="modal-footer"></div>
        </form>
    </div>
</div>