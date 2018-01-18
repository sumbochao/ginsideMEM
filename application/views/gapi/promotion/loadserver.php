<style>
    .listserver .rows{
        float: left;
        width: 245px;
        margin-right:10px;
        margin-bottom: 10px;
    }
    .table-bordered {
        border: 1px solid #ddd;
    }
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid #ddd;
    }
    .table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
        padding: 5px;
    }
    .listserver table tbody tr:nth-child(even),.modal-body table tbody tr:nth-child(even){
        background: #eee;
    }
    .listserver table tbody tr:nth-child(odd),.modal-body table tbody tr:nth-child(odd){
        background: #fff;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }
    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
        background-color: #dff0d8;
    }
    .red{
        color: red;
    }
</style>
<script>
var checked=false;
function checkedAll() {
    var theForm = document.appForm;
    if (checked == false)
    {
    	checked = true;
    	//theForm.checkValue.value = theForm.elements.length;
    }
    else
    {
    	checked = false;
    	//theForm.checkValue.value = 0;
    }
    
    var countCheckBox = 0;
    for (i=0; i<theForm.elements.length; i++) {
        if (theForm.elements[i].name=='cid[]'){
            theForm.elements[i].checked = checked;
            countCheckBox++;
        }
    }
    
    if (checked == true)
    {
    	theForm.checkValue.value = countCheckBox;
    }
    else
    {    	
    	theForm.checkValue.value = 0;
    }
}
</script>
<form name="appForm"  method="post" action="">
    <div class="listserver" id="appForm">
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="checkedAll();" id="checkbox" name="checkbox"/></th>
                    <th align="center" width="200px">ID máy chủ</th>
                    <th align="center">Tên máy chủ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($listServer)>0){
                        foreach ($listServer as $v){
                ?>
                <tr>
                    <td align="center"><input type="checkbox" serverid="<?php echo $v['server_id'];?>" servername="<?php echo $v['server_name'];?>" <?php  echo @in_array($v['server_id'], $s_id)?"checked":"" ?> name="cid[]" id="cid" class="add_checkbox" value="<?php echo $v['server_id'];?>"/></td>
                    <td align="center"><?php echo $v['server_id'];?></td>
                    <td align="center"><?php echo $v['server_name'];?></td>
                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td align="center" colspan="4" class="red">Bạn chưa chọn game !</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</form>