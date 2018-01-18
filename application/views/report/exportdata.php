<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/submit.js'); ?>"></script>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <div class="filter">
			<select name="slbGame">
                <?php
                    if((@in_array('monggiangho', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="monggiangho" <?php echo ($arrFilter['slbGame']=='monggiangho')?'selected="selected"':'';?>>Mộng giang hồ</option>
                <?php } ?>
                <?php
                    if((@in_array('aow', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="aow" <?php echo ($arrFilter['slbGame']=='aow')?'selected="selected"':'';?>>Age of Warrior</option>
                <?php } ?>
                <?php
                    if((@in_array('naruto', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="naruto" <?php echo ($arrFilter['slbGame']=='naruto')?'selected="selected"':'';?>>Naruto</option>
                <?php } ?>
                <?php
                    if((@in_array('bth', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="bth" <?php echo ($arrFilter['slbGame']=='bth')?'selected="selected"':'';?>>Bá thiên hạ</option>
                <?php } ?>
                <?php
                    if((@in_array('eden', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                ?>
                <option value="eden" <?php echo ($arrFilter['slbGame']=='eden')?'selected="selected"':'';?>>Thiên thần truyện 3D</option>
                <?php } ?>
            </select>
            
            <span class="linelabel">Bắt đầu:</span> 
            <select name="operator_from" style="width: 140px;" onchange="loadOperator(this.value)">
                <option value="=" <?php echo ($arrFilter['operator_from']=='=')?'selected="selected"':'';?>>=</option>
                <option value=">" <?php echo ($arrFilter['operator_from']=='>')?'selected="selected"':'';?>>></option>
                <option value=">=" <?php echo ($arrFilter['operator_from']=='>=')?'selected="selected"':'';?>>>=</option>
            </select>
            <input type="text" name="price_from" placeholder="Giá trị" value="<?php echo $arrFilter['price_from'];?>"/>
            <span class="load_operator">
            <?php
                if($arrFilter['operator_from']=='>'){
            ?>
            
                Kết thúc:
                <select name="operator_to" style="width: 140px;">
                    <option value="<" <?php echo ($arrFilter['operator_to']=='<')?'selected="selected"':'';?>><</option>
                </select>
                <input type="text" name="price_to" placeholder="Giá trị" value="<?php echo $arrFilter['price_to'];?>"/>
            <?php
                }
            ?>
            <?php
                if($arrFilter['operator_from']=='>='){
            ?>
                Kết thúc:
                <select name="operator_to" style="width: 140px;">
                    <option value="<=" <?php echo ($arrFilter['operator_to']=='<=')?'selected="selected"':'';?>><=</option>
                </select>
                <input type="text" name="price_to" placeholder="Giá trị" value="<?php echo $arrFilter['price_to'];?>"/>
            
            <?php
                }
            ?>
            </span>
            <input type="text" name="date_from" placeholder="Ngày bắt đầu" value="<?php echo $arrFilter['date_from'];?>"/>
            <input type="text" name="date_to" placeholder="Ngày kết thúc" value="<?php echo $arrFilter['date_to'];?>"/>
			<?php
                if((@in_array($_GET['control'].'-filter_exportdata', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            ?>
            <input type="button" onclick="onSubmitForm('appForm','<?php echo base_url().'?control=report&func=exportdata&type=filter';?>')" value="Tìm" class="btnB btn-primary"/>
            <?php
                }else{
            ?>
            <input type="button" onclick='alert("Bạn không có quyền truy cập chức năng này !")' value="Tìm" class="btnB btn-primary"/>
            <?php } ?>
            
        </div>
        
            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center">Ngày thực hiện</th>
                        <th align="center">Số lượng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($listItems) !== TRUE){
                            foreach($listItems as $v){
                    ?>
                    <tr>
                        <td align="center" class="space_wrap"><?php echo gmdate('d-m-Y',  strtotime($v['date'])+7*3600);?></td>
                        <td align="center"><?php echo ($v['amount']>0)?number_format($v['amount'],0,',','.'):0;?></td>
                    </tr>
                    <?php
                            }
                        }else{
                    ?>
                    <tr>
                        <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
           
        <?php echo $pages?>
    </form>
</div>
<script type="text/javascript">
    $(function(){
        var operator = $("select[name=operator_from]").val();
        if(operator=='=') $(".load_operator").html("");
    });
    function loadOperator(value){
        if(value=='>'){
            var xhtml = 'Kết thúc: <select name="operator_to" style="width: 140px;">';
                xhtml +='<option value="<"><</option>';
                xhtml += '</select>';
                xhtml +=' <input type="text" name="price_to" placeholder="Giá trị" value=""/>';
            $(".load_operator").html(xhtml);
        }
        if(value=='>='){
            var xhtml = 'Kết thúc: <select name="operator_to" style="width: 140px;">';
                xhtml +='<option value="<="><=</option>';
                xhtml += '</select>';
                xhtml +=' <input type="text" name="price_to" placeholder="Giá trị" value=""/>';
            $(".load_operator").html(xhtml);
        }
        if(value=='='){
            $(".load_operator").html("");
        }
    }
    $('input[name=date_from]').datetimepicker({
       dateFormat: 'dd-mm-yy',
       timeFormat: 'HH:mm:ss'
    });
    $('input[name=date_to]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss',
        onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }
    });
    jQuery("input[name=price_from],input[name=price_to]").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 32 || (event.keyCode == 65 && event.ctrlKey === true) ||(event.keyCode >= 35 && event.keyCode <= 39)){
            jQuery(this).val(jQuery.trim(jQuery(this).val()));
            return;
        }else{
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
</script>
	