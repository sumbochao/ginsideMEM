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
.sub{margin-left:1.5em;}

.row-fluid [class*="span"] {
    display: block;
    float: left;
    width: 100%;
    margin-left: 2.127659574468085%;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.row-fluid .span4 {
    width: 31.914893617021278%;
}
.row-fluid .span3 {
    width: 23.404255319148934%;
}
.row-fluid .span2 {
    width: 14.893617021276595%;
}
.row-fluid .span5 {
    width: 40.42553191489362%;
}
/* Form horizontal */

.control-group { border-top: 1px solid #eee; box-shadow: 0 1px 0 #fff inset; -webkit-box-shadow: 0 1px 0 #fff inset; -moz-box-shadow: 0 1px 0 #fff inset; padding: 18px 16px; }
.control-group:first-child { border-top: 0; box-shadow: none; -webkit-box-shadow: none; -moz-box-shadow: none; }
.form-condensed .control-group { border-top: none; padding: 16px; }
.form-horizontal .control-group { *zoom: 1; }
.form-horizontal .control-group:before, .form-horizontal .control-group:after { display: table; line-height: 0; content: ""; }
.form-horizontal .control-group:after { clear: both; }
.form-horizontal .control-label { float: left; width: 18%; padding-top: 5px; }
.control-label > i { margin-top: 3px; margin-right: 6px; }
.form-horizontal .controls { *display: inline-block; *padding-left: 20px; position: relative;  *margin-left: 0; }
.form-horizontal .controls:first-child { *padding-left: 180px; }
.form-horizontal .help-block { margin-bottom: 0; }
.form-horizontal input + .help-block,
.form-horizontal select + .help-block,
.form-horizontal textarea + .help-block,
.form-horizontal .uneditable-input + .help-block,
.form-horizontal .input-prepend + .help-block,
.form-horizontal .input-append + .help-block
{ margin-top: 6px; }




/* # Media queries
================================================== */

@media (min-width: 1025px) and (max-width: 1280px) {

    .row-fluid { width: 100%; *zoom: 1; }
    .row-fluid:before, .row-fluid:after { display: table; line-height: 0; content: ""; }
    .row-fluid:after { clear: both; }
    .row-fluid [class*="span"] { display: block; float: left; width: 100%; min-height: 30px; margin-left: 2.7624309392265194%; *margin-left: 2.709239449864817%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .row-fluid [class*="span"]:first-child { margin-left: 0; }
    .row-fluid .controls-row [class*="span"] + [class*="span"] { margin-left: 2.7624309392265194%; }
    .row-fluid .span12 { width: 100%; *width: 99.94680851063829%; }
    .row-fluid .span11 { width: 91.43646408839778%; *width: 91.38327259903608%; }
    .row-fluid .span10 { width: 82.87292817679558%; *width: 82.81973668743387%; }
    .row-fluid .span9 { width: 74.30939226519337%; *width: 74.25620077583166%; }
    .row-fluid .span8 { width: 65.74585635359117%; *width: 65.69266486422946%; }
    .row-fluid .span7 { width: 57.18232044198895%; *width: 57.12912895262725%; }
    .row-fluid .span6 { width: 48.61878453038674%; *width: 48.56559304102504%; }
    .row-fluid .span5 { width: 40.05524861878453%; *width: 40.00205712942283%; }
    .row-fluid .span4 { width: 31.491712707182323%; *width: 31.43852121782062%; }
    .row-fluid .span3 { width: 22.92817679558011%; *width: 22.87498530621841%; }
    .row-fluid .span2 { width: 14.3646408839779%; *width: 14.311449394616199%; }
    .row-fluid .span1 { width: 5.801104972375691%; *width: 5.747913483013988%; }
    .row-fluid .offset12 { margin-left: 105.52486187845304%; *margin-left: 105.41847889972962%; }
    .row-fluid .offset12:first-child { margin-left: 102.76243093922652%; *margin-left: 102.6560479605031%; }
    .row-fluid .offset11 { margin-left: 96.96132596685082%; *margin-left: 96.8549429881274%; }
    .row-fluid .offset11:first-child { margin-left: 94.1988950276243%; *margin-left: 94.09251204890089%; }
    .row-fluid .offset10 { margin-left: 88.39779005524862%; *margin-left: 88.2914070765252%; }
    .row-fluid .offset10:first-child { margin-left: 85.6353591160221%; *margin-left: 85.52897613729868%; }
    .row-fluid .offset9 { margin-left: 79.8342541436464%; *margin-left: 79.72787116492299%; }
    .row-fluid .offset9:first-child { margin-left: 77.07182320441989%; *margin-left: 76.96544022569647%; }
    .row-fluid .offset8 { margin-left: 71.2707182320442%; *margin-left: 71.16433525332079%; }
    .row-fluid .offset8:first-child { margin-left: 68.50828729281768%; *margin-left: 68.40190431409427%; }
    .row-fluid .offset7 { margin-left: 62.70718232044199%; *margin-left: 62.600799341718584%; }
    .row-fluid .offset7:first-child { margin-left: 59.94475138121547%; *margin-left: 59.838368402492065%; }
    .row-fluid .offset6 { margin-left: 54.14364640883978%; *margin-left: 54.037263430116376%; }
    .row-fluid .offset6:first-child { margin-left: 51.38121546961326%; *margin-left: 51.27483249088986%; }
    .row-fluid .offset5 { margin-left: 45.58011049723757%; *margin-left: 45.47372751851417%; }
    .row-fluid .offset5:first-child { margin-left: 42.81767955801105%; *margin-left: 42.71129657928765%; }
    .row-fluid .offset4 { margin-left: 37.01657458563536%; *margin-left: 36.91019160691196%; }
    .row-fluid .offset4:first-child { margin-left: 34.25414364640884%; *margin-left: 34.14776066768544%; }
    .row-fluid .offset3 { margin-left: 28.45303867403315%; *margin-left: 28.346655695309746%; }
    .row-fluid .offset3:first-child { margin-left: 25.69060773480663%; *margin-left: 25.584224756083227%; }
    .row-fluid .offset2 { margin-left: 19.88950276243094%; *margin-left: 19.783119783707537%; }
    .row-fluid .offset2:first-child { margin-left: 17.12707182320442%; *margin-left: 17.02068884448102%; }
    .row-fluid .offset1 { margin-left: 11.32596685082873%; *margin-left: 11.219583872105325%; }
    .row-fluid .offset1:first-child { margin-left: 8.56353591160221%; *margin-left: 8.457152932878806%; }

}
.controls input[type="text"]{width:100%;}
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
$(function() {

    $('.timepicker2').datetimepicker({
        showSecond: false,
        timeFormat: 'hh:mm:ss',
        dateFormat: 'yy-mm-dd',
        stepHour: 1,
        stepMinute: 1
    });

});

var i = 2;

function createHtml(){
    htmlAppent = '<div class="control-group">'+
    '<div class="control-group">'+
        '<div class="span3">'+
            '<div>SERVER</div>'+
            '<input type="text" name="server_id[]" id="service_trustserver" value="" class="textinput">'+
        '</div>'+
        '<div class="span3">'+
            '<div>STATDATE</div>'+
            '<input type="text" name="service_start[]" placeholder="Ngày" value=""  class=" textinput timepicker2">'+
        '</div>'+
        '<div class="span3">'+
            '<div>ENDDATE</div>'+
            '<input type="text" name="service_end[]" placeholder="Ngày" value="" class="textinput timepicker2">'+
        '</div>'+
        '<div class="span1">'+
            '<span class="remove_field">Remove</span>'+
        '</div>'+

    '</div>'+
    '<div class="clear"></div>'+
    '</div>';

    return htmlAppent;
}
$(document).ready(function(){
    var loadcontent = $(".loadcontent");
    $('#addgroup').click(function() {
        getHtml = createHtml();
        $(loadcontent).append(getHtml);
        i++;
        $('.timepicker2').datetimepicker({
            showSecond: false,
            timeFormat: 'hh:mm:ss',
            dateFormat: 'yy-mm-dd',
            stepHour: 1,
            stepMinute: 1
        });
        return false;
    });
    $(loadcontent).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent().parent().parent().remove(); i--;
    })
});


</script>
<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $button = "<input type='submit' id='save' value='Update' class='game-button' />";
    $menuId = "<input type='hidden' name='id' value='".$_GET['id']."' class='textinput'>";
}else{
    $button = "<input type='submit' id='save' value='Add' class='game-button' />";
    $menuId = '';
}

$items = array();
if(isset($itemslist) && count($itemslist)>=1){
    $items = $itemslist[0];
}
$promition = array("is_hot",'is_new','is_norml');
?>
<div id="content-t" class="row-fluid" style="min-height:500px; padding-top:10px">
    <div class="form-horizontal">
<form action="" method="post" name="frmadd" enctype="multipart/form-data">

	<fieldset>
        <label for="id_app">GAME</label>
        <select name="id_app" id="id_app" onchange="loadapp(this.value);" class="textinput">
            <?php
            if(empty($slbApp) !== TRUE){
                foreach($slbApp as $v){
					if((@in_array($v['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                    <option value="<?php echo $v['id'];?>"><?php echo $v['game'];?></option>
                <?php
					}
                }
            }
            ?>
        </select>

        <br/>
		<br>
        <label for="alias">TITLE</label>
        <input type="text" name="title" id="title" value="<?php echo $items['service_title'];?>" class="textinput">
        <br><br>
        <label for="alias">LINK</label>
        <input type="text" name="link" id="link" value="<?php echo $items['service_url'];?>" class="textinput">
        <br><br>
        <label for="alias">PLATFORM</label>
        <div class="control-group">
            <div class="controls">
                <?php
                 $isandrod = $items['service_android'] ==1 ?"checked":"";
                $isios = $items['service_ios'] ==1 ?"checked":"";
                $iswp = $items['service_wp'] ==1 ?"checked":"";
                ?>
                <div class="span2">
                    <div>ANDROID</div>
                    <input type="checkbox" name="service_android" class="span12" <?php echo $isandrod;?> id="service_android" value="1" />
                </div>
                <div class="span2">
                    <div>IOS</div>
                    <input type="checkbox" name="service_ios" class="span12" <?php echo $isios;?> id="service_ios" value="1" />
                </div>
                <div class="span2">
                    <div>WP</div>
                    <input type="checkbox" name="service_wp" class="span12"  <?php echo $iswp;?> id="service_wp" value="1" />
                </div>
            </div>
        </div>

        <br><br>
        <label for="id_app">STATUS</label>
        <select id="service_status" class="textinput" name="service_status">
            <option value="true" <?php echo $items['service_status']=="true"?"selected":"" ?> >ENABLE</option>
            <option value="false" <?php echo $items['service_status']=="false"?"selected":"" ?>>DISABLE</option>
        </select>
        <br><br>
        <label for="id_app">PROMTION</label>
        <select id="service_ishot" name="service_ishot" class="textinput">
            <?php
                foreach($promition as $val){
                    if($val == $items['service_ishot']){
                        echo '<option value="'.$val.'" selected>'.strtoupper($val).'</option>';
                    }else{
                        echo '<option value="'.$val.'">'.strtoupper($val).'</option>';
                    }
                }
            ?>
        </select>
        <br><br>

        <?php
            if(isset($_GET['games'],$_GET['id']) && !empty($_GET['games'])){
        ?>
        <label for="id_app">LANG</label>
		<div class="control-group">
            <script>
                $(document).ready(function(){
                    $('.selectlanguage').change(function(){
						//console.log(this.options[this.value-1);
                        $('#txt_language').val($(this).find('option:selected').text());
                    });
                    $('.addselectlanguage').click(function(){
                        getid = $('.selectlanguage').val();
                        getcontent = $('#txt_language').val();

                        $.ajax({
                            url: "<?php echo $domain.'/responseginside/updateLanguage' ;?>",
                            type: "post",
                            dataType:"jsonp",
                            data: {idlang: getid,titlelang:getcontent},
                            success: function (data) {
                                if (data.code == 0) {
                                    alert('Cập nhật thành công');
                                }else{
                                    alert('Cập nhật thất bại');
                                }
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });
                    });
                });
            </script>
            <div class="controls-group addcontentlanguage">
				<select name="selectlanguage" class="selectlanguage">
                    <?php
					
                        foreach($itemslist as $key => $val){
                    ?>
                            <option value="<?php echo $val['id'] ?>"><?php echo "[" . $language[$val["alias"]] . "] - " ?><?php echo empty($val['title']) ? "" : $val["title"]?></option>
                    <?php }?>
                </select>
                <a href="javascript:void(0);" class="addselectlanguage" title="Save">
                    <img class="insertselectlanguage" src="/libraries/pannonia/pannonia/img/elements/interface/settings_option.png" alt=""/>
                </a>
                <br>
                <br/>
                <div class="controls-group">
                    <input type="text" name="txt_language" id="txt_language" value="<?php echo $items['title'];?>" class="textinput">
                </div>
                <br>
                <br/>

            </div>

        </div>
        <?php } ?>
        <!--
        <div class="span2">
						<div><?php echo strtoupper($val['name']);?></div>
						<input type="checkbox" name="service_lang[]" class="span12" <?php echo in_array($val['name'],$service_lang)?"checked":"";?> id="service_lang" value="<?php echo $val['name']; ?>" />
					</div>-->
		
        <br><br>
        <label for="alias">TRUST IP</label>
            <textarea rows="1" cols="10" id="service_trustip" name="service_trustip" class="textinput">
                <?php
                    echo $items['service_trustip'];
                ?>
            </textarea>

        <br><br>
		<label for="alias">STARTDATE</label>
        <input type="text" name="startdate" id="startdate" value="<?php echo $items['service_start'];?>" class="textinput timepicker2">
        <br><br>
		<label for="alias">ENDDATE</label>
        <input type="text" name="enddate" id="enddate" value="<?php echo $items['service_end'];?>" class="textinput timepicker2">
        <br><br>
		
        <div class="loadcontent">
            <?php
            if(!empty($items['jsonRule'])){
                $jsonItem = json_decode($items['jsonRule'],true);
				
                foreach($jsonItem as $val){
            ?>
                    <div class="control-group">
                        <div class="control-group">
                            <div class="span3">
                                <div>SERVER</div>
                                <input type="text" name="server_id[]" id="service_trustserver" value="<?php echo $val['server_id'];?>" class="textinput">
                            </div>
                            <div class="span3">
                                <div>STATDATE</div>
                                <input type="text" name="service_start[]" placeholder="Ngày" value="<?php echo $val['service_start'] ?>"  class=" textinput timepicker2">
                                <!--<div id="service_start"></div>-->
                            </div>
                            <div class="span3">
                                <div>ENDDATE</div>
                                <!--<div id="service_end"></div>-->
                                <input type="text" name="service_end[]" placeholder="Ngày" value="<?php echo $val['service_end'] ?>" class="textinput timepicker2">
                            </div>
                            <div class="span1">
                                <span class="remove_field">Remove</span>
                            </div>
                        </div>
                    </div>
            <?php    }
            }
            ?>


        </div>
        <div class="control-group">
            <div class="form-group">
                <button id="addgroup" class="base_button base_green base-small-border-radius"><span>ADD SERVER</span></button>
            </div>
        </div>
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
</div>
<script>
    function onCancel(){
        var theform = document.frmadd;
        theform.action = "<?php echo base_url()?>?control=socialme&func=index";
        theform.submit();
        return true;
    }		
</script>