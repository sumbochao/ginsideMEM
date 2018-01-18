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
<?php
	//echo date('Y-m-d H:i:s');
?>
<form action="" method="post" name="frmadd">
	<fieldset>
                <br>
                <label style="width: 100%; color: #299ada"><?php echo @$message?></label>
		<br><br>
		<label>User</label>
		<select id="username" name="username" onchange="setUser()" class="textinput">
                        <option value="" selected>Chọn user</option>
			<?php
			foreach($listuser as $key => $val){
			?>
			<?php
			if($key == $user){
			?>
			<option value="<?php echo $key?>" selected><?php echo $val['fullname'] . ' - ' . substr($val['security_code'],0,4)?></option>
			<?php
			}else{
			?>
			<option value="<?php echo $key?>"><?php echo $val['fullname'] . ' - ' . substr($val['security_code'],0,4)?></option>
				
			<?php
			}
			?>
			<?php
			}
			?>
		</select>
		<br>
		<br>
		<label>QR code</label>
		<img src="<?= $qrCodeUrl ?>"  />  
		<br><br>
		<label>Secret key</label>
		<span class="small-input" style="color:green; font-size:110%;font-weight: bold"><?= $secret ?></span>
                <br><br>
                <label>&nbsp;</label>
                <span class="small-input">Vui lòng nhập mã <strong>scan trên QR CODE</strong></span>
                <br><br>
                <label>Code</label>
                <input name="code" type="text"  class="textinput" id="code" value="<?= @$code ?>" class="textinput" placeholder="Nhập mã trên QR Code" />
                <br><br>
                <input type="hidden" value="<?= $secret ?>" name="secret" />
                <div style="clear: both"></div>
		<br>
                <input type="submit" id="save" value="Add" class="game-button" />
                <br>
                <br>
	</fieldset>
</form>

<script>
    function setUser(){
        var username = $('#username').val();
        $.ajax({
                type: "POST",
                dataType: 'json',
                url: '?control=account&func=setuserqr',
                data: {username:username},
                success: callback
        });
    }
    function callback(){
        window.location.href = '?control=account&func=qr';
    }
</script>