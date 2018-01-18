
<style>
    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  /*background-color: #D1D119;
  background-color: #eeeeea;*/
  background-color: #dff0d8;
}
#content-t table tbody tr:nth-child(even){
		background: #eee;
	}
#content-t table tbody tr:nth-child(odd){
		background: #fff;
	}
	.btnB {
display: inline-block;
padding: 4px 12px;
margin-bottom: 0;
font-size: 13px;
line-height: 18px;
text-align: center;
vertical-align: middle;
cursor: pointer;
color: #333333;
text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
background-color: #f5f5f5;
background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
background-repeat: repeat-x;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
border-color: #e6e6e6 #e6e6e6 #bfbfbf;
border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
border: 1px solid #cccccc;
border-bottom-color: #b3b3b3;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
-webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
-moz-box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
}
.btnB:hover, .btnB:focus {
color: #333333;
text-decoration: none;
background-position: 0 -15px;
-webkit-transition: background-position 0.1s linear;
-moz-transition: background-position 0.1s linear;
-o-transition: background-position 0.1s linear;
transition: background-position 0.1s linear;
}
.btnB:hover, .btnB:focus, .btnB:active, .btnB.active, .btnB.disabled, .btnB[disabled] {
color: #333333;
background-color: #e6e6e6;
}
.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
color: #fff;
background-color: #3276b1;
border-color: #285e8e;
}
select {
width: 205px;
border: 1px solid #cccccc;
background-color: #ffffff;
}
select, input[type="file"] {
height: 30px;
line-height: 30px;
}
select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
display: inline-block;
height: 30px;
padding: 4px 6px;
margin-bottom: 10px;
font-size: 14px;
line-height: 20px;
color: #555555;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
vertical-align: middle;
}
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
<form action="" method="post" name="frmindex">
<a class="btnB" href="/?control=giftcodemanager&func=addtypegiftcode">Thêm GiftCode</a>
<br/><br/>
<script>
$(document).ready(function() {
	$('#slbGame').change(function(){
		getid = $(this).val();
		window.location.href= '<?php echo base_url().'?control='.$_GET['control'].'&func='.$_GET['func'].'&idgame=';?>'+getid;
	});
});
</script>
<div class="filter">
    <select name="slbGame"  id="slbGame">
        <?php
            if(count($menugames)>0){
                foreach($menugames as $v){
                ?>
                <option value="<?php echo $v['alias'];?>" <?php echo ($v['alias']==$gamefirst)?'selected="selected"':'';?>><?php echo $v['display_name'];?></option>
                <?php
                }
            }
        ?>
    </select>
</div>
<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
 <!--<table width="100%" border="0" class="table table-hover table-striped table-vcenter">-->
	<thead>
	<tr>
		<th width="5%" align="center">Stt</th>
		<th align="center">Group Name</th>
        <th align="center">Alias</th>
        <th align="center">Status</th>
        <th width="7%" align="center">Order</th>
        <th width="7%" align="center">Game</th>
		<th align="center">Control</th>
	</tr>
	</thead>
	<tbody>
	<?php
        foreach($type_menu as $key => $val){
        $edit = "<a href='".base_url()."?control=giftcodemanager&func=addtypegiftcode&id=".$val['idx']."'><img src='".base_url()."assets/img/icon/icon_edit.png'></a>";
	?>
	    <tr>
                <td><?php echo $key + 1?></td>
                <td><?php echo $val['display_name']?></td>
                <td><?php echo $val['alias']?></td>
                <td><?php echo $val['isactive']==1?"Active":"Deactive";?></td>
                <td><?php echo $val['order']?></td>
                <td><?php echo $val['game']?></td>
                <td align="center"><?php echo $edit?></td>
            </tr>
       
	<?php
        }        
	?>
	
	</tbody>
</table>
   
</form>
</div>
<script>
	function deleteSubmit(id,icon){
		var theform = document.frmindex;
			
		if (confirm('Có đồng ý xóa không?')) {
			theform.game_id.value = id;
			theform.game_icon.value = icon;
			theform.action = "<?php echo base_url()?>index.php/account/delete";
			theform.submit();
			return true;
		}
	}
</script>