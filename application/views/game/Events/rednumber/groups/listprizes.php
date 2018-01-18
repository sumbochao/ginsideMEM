<style>
    .listprizes .rows{
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
    .listprizes table tbody tr:nth-child(even),.modal-body table tbody tr:nth-child(even){
        background: #eee;
    }
    .listprizes table tbody tr:nth-child(odd),.modal-body table tbody tr:nth-child(odd){
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
    <div class="listprizes" id="appForm">
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="checkedAll();" id="checkbox" name="checkbox"/></th>
                    <th align="center" width="200px">ID</th>
                    <th align="center">Tên</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($listPrizes)>0){
                        foreach ($listPrizes as $v){
                ?>
                <tr>
                    <td align="center"><input type="checkbox" prizesid="<?php echo $v['prize'];?>" prizesname="<?php echo $v['name'];?>" <?php  echo in_array($v['prize'], $s_id)?"checked":"" ?> name="cid[]" id="cid" class="add_checkbox" value="<?php echo $v['prize'];?>"/></td>
                    <td align="center"><?php echo $v['prize'];?></td>
                    <td align="center"><?php echo $v['name'];?></td>
                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td align="center" colspan="4" class="red">Đang cập nhật giải thưởng !</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</form>