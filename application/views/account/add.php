<style>
.textinput
{
	width: 300px;
	border:1px solid #c5c5c5;
	padding:6px 7px;
	color:#323232;
	margin:0;
	
	background-color:#ffffff;
	outline:none;
	
	/* CSS 3 */
	
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	-o-border-radius:4px;
	-khtml-border-radius:4px;
	border-radius:4px;
	
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-khtml-box-sizing: border-box;
	
	-moz-box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);
	-o-box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);	
	-webkit-box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);
	-khtml-box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);
	box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);
}
input:focus.textinput
{
  box-shadow:0 0 10px #cdec96;
  background-color:#d6f8ff;
  color:#6d7e81;
}
label{
	width: 200px;
	color: #f36926;
}

.game-button{
	border:0;
	outline:none;
	padding:6px 9px;
	margin:2px;
	cursor:pointer;
	font-family:'PTSansRegular', Arial, Helvetica, sans-serif;
	/* CSS 3 */
	-webkit-border-radius:3px;
	-moz-border-radius:3px!important;
	-o-border-radius:3px;
	-khtml-border-radius:3px;
	border-radius:3px;
	
	text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4);
	
	color:#fff;
	text-shadow:0 -1px 1px rgba(0,0,0,.25);
	background-color:#019ad2;
	background-repeat:repeat-x;
	background-image:-moz-linear-gradient(#33bcef,#019ad2);
	background-image:-ms-linear-gradient(#33bcef,#019ad2);
	background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#33bcef),color-stop(100%,#019ad2));
	background-image:-webkit-linear-gradient(#33bcef,#019ad2);
	background-image:-o-linear-gradient(#33bcef,#019ad2);
	background-image:linear-gradient(#33bcef,#019ad2);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef',endColorstr='#019ad2',GradientType=0);
	border-color:#057ed0;
	-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
	box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
}
ul.error{
	padding: 5px;
	background: #f36926;
	margin-bottom: 30px;
}
ul.error li{
	margin-left: 20px;
	color:#eee;
}
</style>

<form action="" method="post" name="frmadd">
	<fieldset>
		<br>
		<label for="username">User Name</label>
		<input type="text" name="username" id="username" value="<?=$username?>" class="textinput">
		<br><br>
		<label for="fullname">Full Name</label>
		<input type="text" name="fullname" id="fullname" value="<?=$fullname?>" class="textinput">
		<br><br>
		<label for="fullname">Group</label>
                <select name="id_group" class="textinput">
                    <option value="1" <?php echo ($id_group==1)?'selected="selected"':'';?>>Toàn quyền</option>
                    <option value="2" <?php echo ($id_group==2)?'selected="selected"':'';?>>Giới hạn quyền</option>
                </select>
		<br><br>
		<!--
                <label for="password">Password</label>
		<input type="text" name="password" id="password" value="" class="textinput">
		<br><br>
		-->
                <!--<label for="password" style="float: left">Menu permission</label>-->
		<?php
		if(isset($id)){
		$button = "<input type='submit' id='save' value='Edit' class='game-button' />";
		?>
                <label for="password" style="float: left">Menu permission</label>
		<input type="hidden" name="adminid" value="<?=$id?>">
		<ul class="treeview" style="width:400px; float: left">
		<?php
			foreach($menu as $key => $val){
		?>
		<?php if($val['level'] == 0){?>
			<li><strong><?=$val['display_name']?></strong></li>
		<?php }else{
			?>
				<li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php echo $val['checked'] == 1?"checked":"" ;?> name="mid[]" value="<?=$val['id']?>" id="<?=$val['id']?>">&nbsp;<label for="<?=$val['id']?>" style="font-weight: normal; color:#333"><?=$val['display_name']?></label>
				<?php 
					if(isset($val['subtree']) && is_array($val['subtree'])){
						echo "<ul class='listsub'>";
						foreach ($val['subtree'] as $keysub => $valuesub) {
							if($val['idgroup'] == 3){
								if($valuesub['permission'] == 1){
					?>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php echo $valuesub['checked'] == 1?"checked":"" ;?> name="mid[]" value="<?=$valuesub['id']?>" id="<?=$valuesub['id']?>">&nbsp;<label for="<?=$valuesub['id']?>" style="font-weight: normal; color:#333"><?=$valuesub['display_name']?></label>
						
					<?php
								}
							}else{
					?>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php echo $valuesub['checked'] == 1?"checked":"" ;?> name="mid[]" value="<?=$valuesub['id']?>" id="<?=$valuesub['id']?>">&nbsp;<label for="<?=$valuesub['id']?>" style="font-weight: normal; color:#333"><?=$valuesub['display_name']?></label>
						<?php
							}
						}
							echo "</ul>";
					}
						?>
					</li>
			

		<?php } ?>
		
		<?php } ?>
		</ul>
                <div style="clear: both"></div>
                <label for="" style="float: left">IP permission</label>
                <ul class="treeview" style="width:400px; float: left">
		<?php
                foreach($ips as $val){
                ?>
                    <?php
                    if($val['checked'] == 0){
                    ?>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ips[]" value="<?=$val['ip']?>" id="<?=$val['ip']?>">&nbsp;<label for="<?=$val['ip']?>" style="font-weight: normal; color:#333"><?=$val['ip']?></label></li>
                    <?php
                    }else{
                    ?>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" checked name="ips[]" value="<?=$val['ip']?>" id="<?=$val['ip']?>">&nbsp;<label for="<?=$val['ip']?>" style="font-weight: normal; color:#333"><?=$val['ip']?></label></li>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
                </ul>
                <?php
                
		}else{
		$button = "<input type='submit' id='save' value='Add' class='game-button' />";
		?>
                
                <label for="password" style="float: left">Menu permission</label>
			<ul class="treeview" style="width:400px; float: left">
		<?php
		foreach($menu as $key => $val){
		?>
			<?php
				if($val['level'] == 0){
			?>
				<li><strong><?=$val['display_name']?></strong></li>
			<?php
				}else{
			?>
				<li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php echo $val['checked'] == 1?"checked":"" ;?> name="mid[]" value="<?=$val['id']?>" id="<?=$val['id']?>">&nbsp;<label for="<?=$val['id']?>" style="font-weight: normal; color:#333"><?=$val['display_name']?></label>
				<?php 
					if(isset($val['subtree']) && is_array($val['subtree'])){
						echo "<ul class='listsub'>";
						foreach ($val['subtree'] as $keysub => $valuesub) {
							if($val['idgroup'] == 3){
									if($valuesub['permission'] == 1){
							?>
								<li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php echo $valuesub['checked'] == 1?"checked":"" ;?> name="mid[]" value="<?=$valuesub['id']?>" id="<?=$valuesub['id']?>">&nbsp;<label for="<?=$valuesub['id']?>" style="font-weight: normal; color:#333"><?=$valuesub['display_name']?></label>
								
							<?php
										}
									}else{
							?>
								<li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php echo $valuesub['checked'] == 1?"checked":"" ;?> name="mid[]" value="<?=$valuesub['id']?>" id="<?=$valuesub['id']?>">&nbsp;<label for="<?=$valuesub['id']?>" style="font-weight: normal; color:#333"><?=$valuesub['display_name']?></label>
								<?php
									}
								}
								echo "</ul>";
							}
						?>
					</li>

				<!--<li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="mid[]" value="<?=$val['id']?>" id="<?=$val['id']?>">&nbsp;
				<label for="<?=$val['id']?>" style="font-weight: normal; color:#333"><?=$val['display_name']?></label></li>-->
			
			<?php
			}
			?>
		
		<?php
		}
		?>
		</ul>
                <div style="clear: both"></div>
                <label for="" style="float: left">IP permission</label>
                
                <ul class="treeview" style="width:400px; float: left">
		<?php
                foreach($ips as $val){
                ?>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ips[]" value="<?=$val['ip']?>" id="<?=$val['ip']?>">&nbsp;<label for="<?=$val['ip']?>" style="font-weight: normal; color:#333"><?=$val['ip']?></label></li>
                <?php
                }
                ?>
                </ul>
                
		<?php
		}
		?>
		<div style="clear: both"></div>
		<br>
		<?=$button?>
	</fieldset>
</form>
