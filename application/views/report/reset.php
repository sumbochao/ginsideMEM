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
    padding-left: 14.5%;
    padding-top: 2px;
    color: red;
}
.formReset table{
    margin-top: 15px;
}
.content_form .rows.rowsbtn{
    margin-top: 35px;
}
.clr{
    clear: both;
}
</style>
<script src="<?php echo base_url('assets/js/ajax.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<div class="loading_warning"></div>
<div class="content_form formReset" id="content-t">
    <form action="" method="post" name="frmadd">
        <div class="rows">	
            <label for="menu_group_id">App</label>
            <select name="app" onchange="loadEvent(this.value);" id="menu_group_id" class="textinput">
                <option value="0">Chọn App</option>
                <?php
                    if(empty($slbApp) !== TRUE){
                        foreach($slbApp as $v){
							if((@in_array($v['id_app'].'_'.$v['alias_app'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){ 
                ?>
                <option value="<?php echo $v['id_app'];?>" <?php echo ($v['id_app']==$items['app'])?'selected="selected"':'';?>><?php echo $v['name_app'];?> (<?php echo $v['alias_app'];?>)</option>
                <?php
							}
                        }
                    }
                ?>
            </select>
			<?php
			if(2==1){
                if((@in_array($_GET['control'].'-filter_reset', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            ?>
            <input type='submit' onclick='if(!window.confirm("Bạn có muốn thực hiện reset không ?")) return false;' id='save' value='Reset' class='game-button' />
            <?php
                }else{
            ?>
            <input type='button' onclick='alert("Bạn không có quyền truy cập chức năng này !")' id='save' value='Reset' class='game-button' />
            <?php } ?>
			<?php } ?>
			<span class="loadButtonReset"></span>
            <?php echo $error; ?>
        </div>
        <div class="clr"></div>
        <div class="loadEvent">
            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center">Sự kiện</th>
                        <th align="center">Còn lại</th>
						<th align="center">Tổng</th>
                        <th align="center">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($listEvent) !== TRUE){
                            foreach($listEvent as $v){
                    ?>
                    <tr>
                        <td align="left"><?php echo $v['event'];?></td>
                        <td align="left"><?php echo ($v['count']>0)?number_format($v['count'],0,',','.'):0;?></td>
						<td align="left"><?php echo $v['totalcount'];?></td>
                        <td align="left"><?php echo $v['note'];?></td>
                    </tr>
                    <?php
                            }
                        }else{
                    ?>
                    <tr>
                        <td colspan="4" class="emptydata">Dữ liệu không tìm thấy</td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </form>
</div>