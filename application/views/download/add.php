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
	width: 150px;
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
.game-button:hover{
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
	background-image:-moz-linear-gradient(#019ad2,#33bcef);
	background-image:-ms-linear-gradient(#019ad2,#33bcef);
	background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#33bcef),color-stop(100%,#019ad2));
	background-image:-webkit-linear-gradient(#019ad2,#33bcef);
	background-image:-o-linear-gradient(#019ad2,#33bcef);
	background-image:linear-gradient(#019ad2,#33bcef);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef',endColorstr='#019ad2',GradientType=0);
	border-color:#057ed0;
	-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
	box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
}

.game-button-cancel{
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
	background-image:-moz-linear-gradient(#555555,#000000);
	background-image:-ms-linear-gradient(#555555,#000000);
	background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#555555),color-stop(100%,#000000));
	background-image:-webkit-linear-gradient(#555555,#000000);
	background-image:-o-linear-gradient(#555555,#000000);
	background-image:linear-gradient(#555555,#000000);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#555555',endColorstr='#000000',GradientType=0);
	border-color:#057ed0;
	-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
	box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
}

.game-button-cancel:hover{
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
	background-image:-moz-linear-gradient(#000000,#555555);
	background-image:-ms-linear-gradient(#000000,#555555);
	background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#000000),color-stop(100%,#555555));
	background-image:-webkit-linear-gradient(#000000,#555555);
	background-image:-o-linear-gradient(#000000,#555555);
	background-image:linear-gradient(#000000,#555555);
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
#content-t  input[type="checkbox"]{text-align: left;width: 20px;}
</style>

<?php
if(isset($_GET['app']) && !empty($_GET['app']) ){
    $button = "<input type='submit' id='save' value='Update' class='game-button' />";
    $menuId = "<input type='hidden' name='app' value='".$_GET['app']."' class='textinput'>";
}else{
    $button = "<input type='submit' id='save' value='Add' class='game-button' />";
    $menuId = '';
}
?>
<div id="content-t" style="min-height:500px; padding-top:10px">
<form action="" method="post" name="frmadd">
	<fieldset>
        <label for="linki_api">Link(IOS)_IPA:</label>
		<input type="text" name="linki_api" id="linki_api" value="<?php echo $linki_api?>" class="textinput">
		<br><br>
		<label for="ipi_api">IP(IOS)_IPA:</label>
		<input type="text" name="ipi_api" id="ipi_api" value="<?php echo $ipi_api?>" class="textinput">
		<br><br>
		
		<label for="linki_plist">Link(IOS)_PLIST:</label>
		<input type="text" name="linki_plist" id="linki_plist" value="<?php echo $linki_plist?>" class="textinput">
		<br><br>
		<label for="ipi_plist">IP(IOS)_PLIST:</label>
		<input type="text" name="ipi_plist" id="ipi_plist" value="<?php echo $ipi_plist?>" class="textinput">
		<br>
		<br>
		
		<label for="linki_apple">Link(IOS)_APPLE</label>
		<input type="text" name="linki_apple" id="linki_apple" value="<?php echo $linki_apple?>" class="textinput">
		<br><br>
		<label for="ipi_apple">IP(IOS)_APPLE:</label>
		<input type="text" name="ipi_apple" id="ipi_apple" value="<?php echo $ipi_apple?>" class="textinput">
		<br>
		<br>
		
		<label for="linka_apk">Link(ANDROID)_APK</label>
		<input type="text" name="linka_apk" id="linka_apk" value="<?php echo $linka_apk?>" class="textinput">
		<br><br>
		<label for="ipa_apk">IP(ANDROID)_APK:</label>
		<input type="text" name="ipa_apk" id="ipa_apk" value="<?php echo $ipa_apk?>" class="textinput">
		<br>
		<br>
		
		<label for="linka_gg">Link(ANDROID)_GG</label>
		<input type="text" name="linka_gg" id="linka_gg" value="<?php echo $linka_gg?>" class="textinput">
		<br><br>
		<label for="ipa_gg">IP(ANDROID)_GG:</label>
		<input type="text" name="ipa_gg" id="ipa_gg" value="<?php echo $ipa_gg?>" class="textinput">
		<br>
		<br>
		<label for="active">Status(1:0)</label>
		<input type="text" name="active" id="active" value="<?php echo $active?>" class="textinput">
		<br><br>
		<input type="hidden" name="idfb" id="idfb" value="<?php echo $_GET['id'];?>" class="textinput">
		<input type="hidden" name="app" id="app" value="<?php echo $_GET['app'];?>" class="textinput">
		<input type="hidden" name="data" id="data" value="<?php echo $_GET['data'];?>" class="textinput">
		
		<div style="clear: both"></div>
		<br>
		<?php echo $menuId?>
		<?php echo $button?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='button' value='Cancel' class='game-button-cancel' onclick='onCancel()' />
	</fieldset>
</form>
</div>
<script>
    function onCancel(){
        var theform = document.frmadd;
        theform.action = "<?php echo base_url()?>?control=menu&func=index";
        theform.submit();
        return true;
    }		
</script>