<?php 
error_reporting(0);
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
<?php 
    if((in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
        $lnkFilter = "taigc(68);";
    }else{
        $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
    }
?>
<div id="content-t" style="min-height:500px; padding-top:10px">
<form action="" method="post" name="frmindex">

<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
 <!--<table width="100%" border="0" class="table table-hover table-striped table-vcenter">-->
	<thead>
	<tr>
		<th width="5%" align="center">Stt</th>
		<th align="center">Control</th>
		<th width="7%" align="center">status</th>
		<th align="center">jsonItem</th>
        <th align="center">quantity</th>
        <th align="center">prefix</th>
        <th align="center">typeCode</th>
        <th align="center">game</th>
		<th align="center">actorOrder</th>
        <th align="center">description</th>
        <th align="center">endDate</th>
        
		
	</tr>
	</thead>
	<tbody>
	<?php
        foreach($listapprove as $key => $val){
            if($val['isactive'] ==0){
                $edit = "<a href='javascript:void(0);' onclick='upadtestatus(".$val['idx'].");' rel='".$val['idx']."'><img src='".base_url()."assets/img/accept.png'></a>";
            }elseif($val['isactive'] ==1){
				//$edit = "<a rel='".$val['idx']."' onclick='".$lnkFilter."' href='javascript:void(0);'>Tải giftcode</a>";
                $edit = "<a href='javascript:void(0);' onclick='taigc(".$val['idx'].");' rel='".$val['idx']."'>Tải giftcode</a>";
            }else{
                $edit ="Duyệt hoàn tất";
            }

	?>
	    <tr>
                <td><?php echo $key + 1?></td>
				<td align="center"><?php echo $edit?></td>
				<td style="color:red"><?php echo $val['isactive'] ==0?"Chưa duyệt":"Đã duyệt";?></td>
                <td><?php echo $val['jsonItem']?></td>
                <td><?php echo $val['quantity']?></td>
                <td><?php echo $val['prefix']?></td>
                <td><?php echo $val['typeCode']?></td>
                <td><?php echo $val['game']?></td>
                <td><?php echo $val['actorOrder']?></td>
                <td><?php echo $val['description']?></td>
                <td><?php echo $val['endDate']?></td>
                
                
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
    function upadtestatus(idx){

        if(idx == 0 || idx == ""){
            return false;
        }
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/?control=giftcodemanager&func=updatestatusgc",
                data: {idx:idx},
                beforeSend: function(  ) {
                }
            }).done(function(result) {
                console.log(result);
                alert(result.message);
                window.location.reload();

            });

    }
    function taigc(idx){
        if(idx == 0 || idx == ""){
            return false;
        }
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/?control=giftcodemanager&func=taigc",
            data: {idx:idx},
            beforeSend: function(  ) {
            }
        }).done(function(result) {
            if(result.code==0) {
				//downloadInnerHtml('giftcode',result.data,'text/html' );
                tableToExcel(result.data, 'dklp');
                return;
            }else{
                alert(result.message);
            }
            window.location.reload();

        });
    }
	var downloadInnerHtml = (function (filename, data, mimeType) {
		var link = document.createElement('a');
		mimeType = mimeType || 'text/plain';

		link.setAttribute('download', filename);
		link.setAttribute('href', 'data:' + mimeType  +  ';charset=utf-8,' + encodeURIComponent(data));
		link.click(); 
	});
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(data, name) {
            //if (!data.nodeType)
            //table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: data}
            window.location.href = uri + base64(format(template, ctx))
        }
    })();

</script>