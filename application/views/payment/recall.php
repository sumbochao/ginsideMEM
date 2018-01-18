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
.content_form{
    min-height:500px; 
    padding-top:10px;
    padding-bottom: 10px;
}
.content_form .rows{
    margin-top: 20px;
}
.content_form .rows:first-child{
    margin-top: 10px;
}
.error{
    padding-left: 31.5%;
    padding-top: 2px;
    color: red;
    margin-bottom: -10px;
}
.content_form .rows.rowsbtn{
    margin-top: 35px;
    margin-left: 40%;
}
.group_left{
    float: left;
    width: 490px;
    margin-right: 50px;
}
.group_right{
    float:left;
    width: 490px;
}
.clr{
    clear: both;
}
@media screen and (max-width: 1300px){
    .group_left,.group_right{
        float: none;
        width: auto;
        margin-right: 0px;
    }
    .content_form .rows.rowsbtn{
        margin-left: 0%;
    }
}
.content_form .full_columns .rows.first{
    margin-top: 10px;
}
.full_columns{
    border-top:1px solid #CCC;
    margin-top: 10px;
    padding-top: 10px;
}
.full_columns fieldset{
    border: 1px solid #dddddd;
    border-radius: 7px;
    margin: 0 0 10px;
    padding: 10px;
}
.full_columns legend {
    color: #0b55c4;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 0px;
    border-bottom: 0px;
    width: auto;
    padding: 0px 5px;
}
.content_form .errors{
    padding-left: 31.5%;
    padding-top: 2px;
    color: red;
    margin-bottom: -10px;
}
.content_form .errors.error_pay{
    padding-left: 14.5%;
}
</style>
<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

 
<div class="content_form" id="content-t">
    <form action="" method="post" name="frmadd">
        <div class="group_left">
            <div class="rows">	
                <label for="menu_group_id">Game</label>
                <select name="service_id" id="menu_group_id" class="textinput" onchange="getServer(this.value)">
                    <option value="">Chọn Game</option>
                    <?php
                        if(empty($listScopes) !== TRUE){
                            foreach($listScopes as $v){
                                if($v['service']>=1000){
                                    $selected = '';
                                    if($v['service']==$Item['service_id']){
                                        $selected = 'selected="selected"';
                                    }
                    ?>
                    <option value="<?php echo $v['service'];?>" <?php echo $selected; ?>><?php echo $v['app_fullname'];?></option>
                    <?php
                                }
                            }
                        }
                    ?>
                </select>
                <?php echo $errors['service_id'];?>
            </div>
            <div class="rows">
                <label for="menu_group_id">Server ID</label>
                <span class="loadserver">
                    <select name="game_server_id" class="textinput">
                        <option value="">Chọn server</option>
                        <?php
                            if(empty($slbServer) !== TRUE){
                                foreach($slbServer as $v){
                        ?>
                        <option value="<?php echo $v['server_id'];?>" <?php echo ($v['server_id']==$Item['game_server_id'])?'selected="selected"':'';?>><?php echo $v['server_name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </span>
                <?php echo $errors['game_server_id'];?>
            </div>
            <div class="rows">
                <label for="menu_group_id">Mã giao dịch</label>
                <input type="text" name="transaction_id" value="<?php echo $Item['transaction_id'];?>" class="transaction_id textinput" placeholder="Transaction Id"/>
                <?php echo $errors['transaction_id'];?>
            </div>
            <div class="rows">
                <label for="menu_group_id">Account ID</label>
                <input type="number" name="account_id" value="<?php echo $Item['account_id'];?>" class="account_id textinput" placeholder="Account Id"/>
                <?php echo $errors['account_id'];?>
            </div>
            <div class="rows">
                <label for="menu_group_id">Giá trị GD VND</label>
                <input type="number" name="money" value="<?php echo $Item['money'];?>" class="money textinput" placeholder="Money"/>
                <?php echo $errors['money'];?>
            </div>
        </div>
        <div class="group_right">
            <div class="rows">
                <label for="menu_group_id">Hình thức thanh toán</label>
                <select name="payment_type" id="menu_group_id" class="textinput">
                    <option value="">Chọn hình thức thanh toán</option>
                    <option value="card" <?php echo ($Item['payment_type']=='card')?'selected="selected"':''; ?>>Card</option>
                    <option value="inapp" <?php echo ($Item['payment_type']=='inapp')?'selected="selected"':''; ?>>Inapp</option>
                    <option value="btce" <?php echo ($Item['payment_type']=='btce')?'selected="selected"':''; ?>>BTC-E USD</option>
                </select>
                <?php echo $errors['payment_type'];?>
            </div>
			<?php
                switch ($Item['payment_type']){
                    case "card":
                       $listType = array(array('id'=>'gate','name'=>'Gate'),
                                         array('id'=>'viettel','name'=>'Viettel'),
                                         array('id'=>'vms','name'=>'Mobiphone'),
                                         array('id'=>'vina','name'=>'Vinaphone'),
                                    ); 
                        break;
                    case "btce":
                       $listType = array(array('id'=>'usd','name'=>'USD')); 
                        break;

                }
            ?>
            <div class="rows">
                <label for="menu_group_id">Loại thẻ</label>
				<span class="load_payment_type">
                <select name="payment_subtype" id="menu_group_id" class="textinput">
                    <option value="">Chọn Loại thẻ</option>
                    <?php
						if(empty($listType) !== TRUE){
							foreach($listType as $v){
					?>
					<option value="<?php echo $v['id'];?>" <?php echo ($Item['payment_subtype']==$v['id'])?'selected="selected"':''; ?>><?php echo $v['name'];?></option>
					<?php
							}
						}
					?>
                </select>
				</span>
                <?php echo $errors['payment_subtype'];?>
            </div>
            <div class="rows">
                <label for="menu_group_id">Platform</label>
                <select name="game_platform" id="menu_group_id" class="textinput">
                    <option value="">Chọn Platform</option>
                    <option value="android" <?php echo ($Item['game_platform']=='android')?'selected="selected"':''; ?>>Android</option>
                    <option value="ios" <?php echo ($Item['game_platform']=='ios')?'selected="selected"':''; ?>>Ios</option>
                    <option value="wp" <?php echo ($Item['game_platform']=='wp')?'selected="selected"':''; ?>>Wp</option>
                    <option value="web" <?php echo ($Item['game_platform']=='web')?'selected="selected"':''; ?>>Web</option>
                </select>
                <?php echo $errors['game_platform'];?>
            </div>
            <div class="rows">
                <label for="menu_group_id">Mã nhân vật</label>
                <input type="text" name="game_character_id" value="<?php echo $Item['game_character_id'];?>" class="game_character_id textinput" placeholder="Character ID"/>
                <?php echo $errors['game_character_id'];?>
            </div>
            <div class="rows">
                <label for="menu_group_id">Tên nhân vật</label>
                <input type="text" name="game_character_name" value="<?php echo $Item['game_character_name'];?>" class="textinput" placeholder="Character name"/>
                <?php echo $errors['game_character_name'];?>
            </div>
            <div class="rows">
                <label for="menu_group_id">Ngày</label>
                <input type="datetime" name="date" value="<?php echo (isset($Item['date']))?$Item['date']:date('d-m-Y H:i:s');?>" class="date textinput" placeholder="Date" readonly="readonly"/>
                <?php echo $errors['date'];?>
            </div>
        </div>
        <div class="clr"></div>        
        <div class="rows rowsbtn">
            <input type='submit' onclick='if(!window.confirm("Bạn có muốn thực hiện giao dịch không ?")) return false;' id='save' value='Thực hiện' class='game-button' />
            <input type='reset' value='Làm lại' class='game-button-cancel' />
        </div>
    </form>
</div>
<script type="text/javascript">
    $('.date').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss'
    });
    /*jQuery(document).ready(function() {
        $('.date').datepick();
    });*/
    function getServer(game){
        var url ='<?php echo base_url();?>?control=payment&func=getserver';
        jQuery.ajax({
            url:url,
            type:"POST",
            data:{game:game},
            async:false,
            dataType:"json",
            success:function(f){
                if(f.status==0){
                    jQuery('.loadserver').html(f.html);
                }else{
                    jQuery('.loadserver').html(f.html);
                }
            }
        });
    }
	$(function(){
        $("select[name=payment_type]").change(function(){
            var type = $(this).val();
            var url ='<?php echo base_url();?>?control=payment&func=getpayment_type';
            jQuery.ajax({
                url:url,
                type:"POST",
                data:{type:type},
                async:false,
                dataType:"json",
                success:function(f){
                    jQuery('.load_payment_type').html(f.html);
                }
            });
        });
    });
</script> 