<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<div class="loading_warning"></div>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
                $('#top').css('display','none');
				$('#footer').css('display','none');
				$('#left').css('display','none');
				
				if(document.getElementById('melogin_off').checked==true){
					document.getElementById('link').readOnly=false;
					document.getElementById('message').readOnly=false;
				}
            });
</script>
<form name="frm" enctype="multipart/form-data" method="post" action="<?php echo base_url()."?control=popupbutton&func=add&id=".$_GET['id']."&mebutton=".$_GET['mebutton']."&mechat=".$_GET['mechat']."&meevent=".$_GET['meevent']."&megame=".$_GET['megame']."&melogin=".$_GET['melogin']."&memsg=".$_GET['memsg'];?>">
<table width="100%" height="260px">
	<tr style="border-bottom:groove 1px #000000;">
    	<td><strong>Me Button</strong></td>
        <td><strong>Me Chat</strong></td>
        <td><strong>Me Event</strong></td>
        <td><strong>Me Game</strong></td>
        <td><strong>Me Login</strong></td>
    </tr>
    <tr style="border-bottom:groove 1px #000000;">
    	<td><input type="radio" name="mebutton" id="mebutton_on" value="on"/> On 
<input type="radio" name="mebutton" id="mebutton_off" value="off" /> Off</td>
<td><input type="radio" name="mechat" id="mechat_on" value="on"/> On 
<input type="radio" name="mechat" id="mechat_off" value="off" /> Off</td>
<td><input type="radio" name="meevent" id="meevent_on" value="on"/> On 
<input type="radio" name="meevent" id="meevent_off" value="off" /> Off</td>
<td><input type="radio" name="megame" id="megame_on" value="on"/> On 
<input type="radio" name="megame" id="megame_off" value="off" /> Off</td>
<td><input type="radio" name="melogin" id="melogin_on" value="on" onchange="showtextbox(true);"/> On 
<input type="radio" name="melogin" id="melogin_off" value="off" onchange="showtextbox(false);" /> Off</td>
    </tr>
    <tr>
    	<td colspan="5">Nếu Me Login bằng Off ( Vui lòng nhập thông tin bên dưới)</td>
    </tr>
    <tr class="cls_l">
    	<td>Link:</td>
        <td colspan="4"><input type="text" name="link" id="link" style="width:500px;" maxlength="125" readonly="readonly" value="<?php echo $_POST['link'] ?>" /></td>
    </tr>
    <tr class="cls_l">
    	<td>Message:</td>
        <td colspan="4"><input type="text" name="message" id="message" style="width:500px;" maxlength="125" readonly="readonly" value="<?php echo $_POST['message'] ?>" /></td>
    </tr>
    <tr>
    	<td colspan="5" style="text-align:center;">
        <input type="button" class="btnB btn-primary" name="btnsubmit" value="Save" onclick="actionAjax('<?php echo $_GET['id']; ?>',document.getElementById('mebutton_on').checked,document.getElementById('mechat_on').checked,document.getElementById('megame_on').checked,document.getElementById('meevent_on').checked,document.getElementById('melogin_on').checked,document.getElementById('link').value,document.getElementById('message').value);">
        </td>
    </tr>
    <tr>
    	<td colspan="5">
        <strong style="color:#F00;font-size:16px">
        <?php echo $error;?>
        </strong>
        <div id="infomess">
        </div>
        </td>
    </tr>
</table>
<div id="div_msg">
<table>
	<tr>
    	<td colspan="5">Nếu Me Login bằng Off ( Vui lòng nhập thông tin bên dưới)</td>
    </tr>
    <tr class="cls_l">
    	<td>Link:</td>
        <td colspan="4"><input type="text" name="link" id="link" style="width:500px;" maxlength="125" readonly="readonly" value="<?php echo $_POST['link'] ?>" /></td>
    </tr>
    <tr class="cls_l">
    	<td>Message:</td>
        <td colspan="4"><input type="text" name="message" id="message" style="width:500px;" maxlength="125" readonly="readonly" value="<?php echo $_POST['message'] ?>" /></td>
    </tr>
</table>
</div>
</form>
<script language="javascript">
function showtextbox(checkval){
	document.getElementById('link').readOnly=checkval;
	document.getElementById('message').readOnly=checkval;
}
check_button();
function check_button(){
	   me_button='<?php echo $_GET['mebutton'];?>';
	   me_chat='<?php echo $_GET['mechat'];?>';
	   me_event='<?php echo $_GET['meevent'];?>';
	   me_game='<?php echo $_GET['megame'];?>';
	   me_login='<?php echo $_GET['melogin'];?>';
	   me_msg='<?php echo $_GET['memsg'];?>';
	   <?php
	   if(!empty($_GET['memsg']) || $_GET['memsg']!=''){
	   		$arrjson=base64_decode($_GET['memsg']);
	   }else{
		    $arrjson="{\"link\":\"\",\"message\":\"\"}";
	   }
	   ?>
	   var obj = JSON.parse('<?php echo $arrjson; ?>');
	   document.getElementById('link').value=obj.link;
	   document.getElementById('message').value=obj.message;
	 
	   if(me_button=='on'){
		   document.getElementById('mebutton_on').checked=true;
	   }else{
		   document.getElementById('mebutton_off').checked=true;
	   }
	   if(me_chat=='on'){
		   document.getElementById('mechat_on').checked=true;
	   }else{
		   document.getElementById('mechat_off').checked=true;
	   }
	   if(me_event=='on'){
		   document.getElementById('meevent_on').checked=true;
	   }else{
		   document.getElementById('meevent_off').checked=true;
	   }
	   if(me_game=='on'){
		   document.getElementById('megame_on').checked=true;
	   }else{
		   document.getElementById('megame_off').checked=true;
	   }
	   if(me_login=='on'){
		   document.getElementById('melogin_on').checked=true;
	   }else{
		   document.getElementById('melogin_off').checked=true;
	   }
	   
     }
	 
	 function actionAjax(id,mebutton,mechat,megame,meevent,melogin,linktext,mess){
		 me_b=mebutton==true?'on':'off';
		 me_c=mechat==true?'on':'off';
		 me_g=megame==true?'on':'off';
		 me_e=meevent==true?'on':'off';
		 me_l=melogin==true?'on':'off';
        $.ajax({
            url:'<?php echo base_url(); ?>?control=popupbutton&func=actionajax',
            type:"POST",
            data:{id:id,mebutton:me_b,mechat:me_c,megame:me_g,meevent:me_e,melogin:me_l,linktext:linktext,mess:mess},
            async:false,
            dataType:"json",
            beforeSend:function(){
				
                $('.loading_warning').show();
				Lightboxt.showemsg('Thông báo', '<b>Vui lòng chờ ....</b>', 'Đóng');
				
            },
            success:function(f){
                $('#infomess').html(f.messg);
				Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
				$('.loading_warning').hide();
            }
        });
    }
	
</script>