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


.messageerror{color:red;font-size: 13px;font-style: italic}
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

});
function loadapp(value){

    $.ajax({
        url:"/?control=miniapp&func=loadbyapp",
        type: "POST",
        data:{idapp:value}
    })
    .done(function (data) {
        $('#id_event').html(data);
    }).fail(function (data) {
        $('#id_event').html('');
    });
}
function loadevent(value,id){
    params = value.split("_");
    if(params[0] =='like' || params[0]=='share'){

        $.ajax({
            url:"/?control=miniapp&func=loadtypeevent",
            type: "POST",
            dataType:"json",
            data:{typeevent:params[0],id:id}
        })
        .done(function (data) {
           $('.content_load').html(data);
        }).fail(function (data) {

        });
    }else{
        $('.content_load').html('');
    }
}
<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>
$(document).ready(function(){
    getvalue= $("#id_event").val();
    loadevent(getvalue,<?php echo $_GET['id'];?>);
})
    <?php } ?>

</script>
<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $button = "<input type='submit' id='save' value='Update' class='game-button' />";
    $menuId = "<input type='hidden' name='id' value='".$_GET['id']."' class='textinput'>";
}else{
    $button = "<input type='submit' id='save' value='Add' class='game-button' />";
    $menuId = '';
}
?>
<div id="content-t" style="min-height:500px; padding-top:10px">
<form action="" method="post" name="frmadd" enctype="multipart/form-data">

	<fieldset>
        <label for="id_app">APP</label>
        <select name="id_app" id="id_app" onchange="loadapp(this.value);" class="textinput">
            <option value="0">Chọn App</option>
            <?php
            if(empty($slbApp) !== TRUE){
                foreach($slbApp as $v){
                ?>
                    <option value="<?php echo $v['id_app'];?>" <?php echo ($v['id_app']==$items['id_app'])?'selected="selected"':'';?>><?php echo $v['name_app'];?></option>
                <?php
                }
            }
            ?>
        </select>
        <br/>
        <br/>
        <label for="id_event">Type_Events:</label>
        <select name="id_event" onchange="loadevent(this.value,'');" id="id_event" class="textinput">
            <option value="0">Chọn App</option>
            <?php
            if(empty($slType) !== TRUE){
                foreach($slType as $v){
                    ?>
                        <option  value="<?php echo $v['type']; ?>_<?php echo $v['id'];?>" <?php echo ($v['id']==$items['id_event'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                    <?php
                }
            }
            ?>
        </select>
        <br/>
		<br>
        <label for="alias">TITLE</label>
        <input type="text" name="title" id="title" value="<?php echo $items['title'];?>" class="textinput">
        <br><br>
        <label for="alias">PICTURED</label>
        <input type="file" name="picture"/>

        <br><br>

        <div class="content_load">
            <label for="alias">ID_FANPAGE</label>
            <input type="text" name="id_fanpage" id="id_fanpage" value="<?php echo $items['id_fanpage']?>" class="textinput">
            <br><br>
        </div>
		
		<label for="alias">COMMING SOOM</label>
        <input type="text" name="comingsoon" id="comingsoon" value="<?php echo $items['comingsoon'];?>" class="textinput">
        <br><br>
		<label for="isactive">IsActive</label>
		<input type="checkbox" name="isactive" id="isactive" <?php echo ($items['isactive'] == 1 )?'checked':'';?> class="textinput">
		<br><br>
		<label for="order">Order</label>
		<input type="text" name="order" id="order" value="<?php echo $items['order']?>" class="textinput">
		<br><br>
		
		<label for="isenable">IsEnable</label>
		<input type="checkbox" name="isenable" id="isenable" <?php echo ($items['isenable'] == 1 )?'checked':'';?> class="textinput">
		<br><br>
		
        <label class="messageerror"><?php echo $error; ?></label>
		
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
        theform.action = "<?php echo base_url()?>?control=miniapp&func=index";
        theform.submit();
        return true;
    }		
</script>