<?php 
error_reporting(0);
?>
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
<script>
	
	$(document).ready(function(){
		datasubmenu = $.parseJSON('<?php echo $sub_menu;?>');
		$('#menu_group_id').change(function() {
			groupmenu = $(this).val();
			html = "";
			html += "<option value='0' selected>---Chon Sub Menu---</option>";
			if(typeof datasubmenu[groupmenu]=='undefined'){

			}else{
				$.each(datasubmenu[groupmenu],function(key, el) {
					html += "<option value='"+el.id+"' >"+ el.display_name+"</option>";
				});
			}
			$('#menu_cp_parent').html(html);
		});
		<?php if(isset($menu_group_id) && $menu_group_id >=1 && $menu_cp_parent != 0 ){?>
		function getOption(){
			menu_group_id = <?php echo $menu_group_id;?>;
			if(menu_group_id != "" && menu_group_id > 0){
				html2 = "";
				$.each(datasubmenu[menu_group_id],function(key, el) {
					if(el.id == <?php echo $menu_cp_parent;?> )
					{ 
						html2 += "<option value='"+el.id+"' selected>"+ el.display_name+"</option>";
					}else{
						html2 += "<option value='"+el.id+"' >"+ el.display_name+"</option>";
					}
				});
				$('#menu_cp_parent').html(html2);
			}
		};
		getOption();
		<?php } ?>
	});

	
</script>
<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $button = "<input type='submit' id='save' value='Update' class='game-button' />";
    $menuId = "<input type='hidden' name='menuId' value='".$_GET['id']."' class='textinput'>";
}else{
    $button = "<input type='submit' id='save' value='Add' class='game-button' />";
    $menuId = '';
}
?>
<div id="content-t" style="min-height:500px; padding-top:10px">
<form action="" method="post" name="frmadd">
	<fieldset>
		<br>
                <label for="menu_group_id">Group Menu</label>

                <select name="menu_group_id" id="menu_group_id" class="textinput">
                    <option value="0" selected>---Chon Group Menu---</option>
                    <?php
                    foreach($group_menu as $g){
                    ?>
                    
                        <?php
                        if($g['id'] == $menu_group_id){
                        ?>
                            <option value="<?php echo $g['id']?>" selected><?php echo $g['menu_name']?></option>
                        <?php
                        }else{
                        ?>
                            <option value="<?php echo $g['id']?>"><?php echo $g['menu_name']?></option>
                        <?php
                        }
                        ?>

                    
                    <?php
                    }
                    ?>
                </select><br/><br/>

		<label for="alias">Alias</label>
		<input type="text" name="alias" id="alias" value="<?php echo $alias?>" class="textinput">
		<br><br>
		<label for="isactive">IsActive</label>
		<input type="checkbox" name="isactive" id="isactive" <?php echo ($isactive == 1 )?'checked':'';?> class="textinput">
		<br><br>
		<label for="order">Order</label>
		<input type="text" name="order" id="order" value="<?php echo $order?>" class="textinput">
		<br><br>
		
		<div style="clear: both"></div>
		<br>
		<?php echo $menuId?>
		<?php echo $button?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='button' name="btn_add" value='Cancel' class='game-button-cancel' onclick='onCancel()' />
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