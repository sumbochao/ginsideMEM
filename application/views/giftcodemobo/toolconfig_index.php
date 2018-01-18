<?php 
error_reporting(0);
?>
<?php
/*
<style>
	#content-t table thead tr{
		background: #f58220;
	}
	#content-t table thead tr th{
		padding: 5px;
		color: #eee;
	}
	#content-t table tbody tr td{
		padding: 10px 5px;
	}
	
	#content-t table tbody tr:nth-child(even){
		background: #ccc;
	}
	#content-t table tbody tr:nth-child(odd){
		background: #fff;
	}
	#content-t table tbody tr:hover{
		background: #f5b672;
	}
</style>
*/
 ?>
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
</style>
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
    text-decoration: none;
    font-weight: bold;
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
    text-decoration: none;
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
<script>
    $(document).ready(function(){
        $('#menu_group_id').change(function(){
            typeevent = $(this).val();
            $.ajax({
                url:"/?control=miniapp&func=loadtypeeventcontent",
                type: "POST",
                data:{typeevent:typeevent}
            })
            .done(function (data) {
               $('#loadcontent').html(data);
            }).fail(function (data) {

            });
        });
    })

</script>
<div id="content-t" style="min-height:500px; padding-top:10px">
<form action="" method="post" name="frmindex">
    <div class="rows">
        <label for="menu_group_id">App</label>
        <a href="/?control=miniapp&func=addconfig" class="game-button">THÊM EVENT</a>
        <?php echo $error; ?>
    </div>
<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
 <!--<table width="100%" border="0" class="table table-hover table-striped table-vcenter">-->
	<thead>
	<tr>
		<th width="5%" align="center">Stt</th>
        <th>Id</th>
		<th align="center">Event</th>
		<th align="center">Note</th>
        <th width="7%" align="center">Name</th>
        <th width="7%" align="center">Type</th>
		<th width="7%" align="center">Icon</th>
		<th align="center">Control</th>
	</tr>
	</thead>
	<tbody id="loadcontent">
	<?php
    foreach($listconfig as $key => $val){
	?>

        <?php
            $edit = "<a href='".base_url()."?control=miniapp&func=addconfig&id=".$val['id']."'><img src='".base_url()."assets/img/icon/icon_edit.png'></a>";
        ?>
        <tr>
            <td><?php echo $key + 1?></td>
            <td><?php echo $val['id']?></td>
            <td><?php echo $val['event']?></td>
            <td><?php echo $val['note']?></td>
            <td><?php echo $val['name']?></td>
			<td><?php echo $val['type']?></td>
            <td><?php echo $val['iconimg']?></td>
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
	