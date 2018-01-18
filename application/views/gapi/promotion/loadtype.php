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
                    <th width="50px"><input type="checkbox" onclick="checkedAll();" id="checkbox" name="checkbox"/></th>
                    <th align="center">Hình thức</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($slbType)>0){
                        foreach ($slbType as $v){
                ?>
                <tr>
                    <td align="center"><input type="checkbox" typeid="<?php echo $v;?>" typename="<?php echo ucwords($v);?>" <?php  echo @in_array($v, $t_id)?"checked":"" ?> name="cid[]" id="cid" class="add_checkbox" value="<?php echo $v;?>"/></td>
                    <td align="center"><?php echo ucwords($v);?></td>
                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td align="center" colspan="2" class="red">Dữ liệu đang cập nhật !</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</form>