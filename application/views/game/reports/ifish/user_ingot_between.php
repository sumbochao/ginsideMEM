<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.table2excel.js') ?>"></script>
<style>
.loadserver .textinput{
    width:205px;
	margin-top:-10px;
}
.filter span{
    position: relative;
    top: -4px;
}
.content_tab{
    margin-top: 15px;
}
input[name="date_from"],input[name="date_to"]{
    width: 150px;
}
button.multiselect{
    top: -5px;
}
.multiselect-container .input-group .input-group-addon{
    top:0px;
}
.filter span.loadExport{
    top:0px;
}
.multiselect-container{
    height: 400px;
    overflow-y: scroll;
    width: 250px;
}
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once(APPLICATION_PATH.'/application/views/game/reports/tab.php');?>
    <div class="content_tab">
        <div class="filter">
            <form action="" method="POST" id="appForm">
                <span>Ngày bắt đầu:</span> <input type="text" class="datetime" name="date_from" placeholder="Ngày bắt đầu" value=""/>
                <span>Ngày kết thúc:</span> <input type="text" class="datetime" name="date_to" placeholder="Ngày kết thúc" value=""/>
                <input type="button" onclick="onSubmit('<?php echo base_url().'?control='.$_GET['control'].'&func=ajax_'.$_GET['func'];?>&game=ifish&module=all')" value="Tìm" class="btn btn-primary"/>
                <input type="button" value="Xuất Excel" class="btn btn-primary" onclick="onExport();"/>
            </form>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="loadData">
                <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th align="center" width="50px">STT</th>
                            <th align="center" width="50px">Ngày</th>
                            <th align="center" width="130px">Số lượng User mới nhận được sò</th>
                            <th align="center" width="100px">Số lượng User đang có sò</th>
                            <th align="center" width="110px">Tổng lượng sò phát sinh trong ngày</th>
							<th align="center" width="110px">Tổng sò</th>
							<th align="center" width="110px">Tổng ngọc</th>
							<th align="center" width="110px">Tổng vàng</th>
							<th align="center" width="110px">Tổng đóng góp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($listItems)>0){
                                $i=0;
                                foreach($listItems as $key=>$v){
                                    $i++;
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php  echo date_format(date_create($v['Date']),"d-m-Y");?></td>
                            <td><?php echo $v["NewUserIngot"]>0?number_format($v['NewUserIngot']):"0";?></td>
                            <td><?php echo $v["UserIngot"]>0?number_format($v['UserIngot']):"0"?></td>
                            <td><?php echo $v["TotalNewIngot"]>0?number_format($v['TotalNewIngot']):"0"?></td>
							<td><?php echo $v["TotalCurrIngot"]>0?number_format($v['TotalCurrIngot']):"0"?></td>
							<td><?php echo $v["TotalCurrSilver"]>0?number_format($v['TotalCurrSilver']):"0"?></td>
							<td><?php echo $v["TotalCurrScore"]>0?number_format($v['TotalCurrScore']):"0"?></td>
							<td><?php echo $v["TotalCurrIngotContribution"]>0?number_format($v['TotalCurrIngotContribution']):"0"?></td>
                        </tr>
                        <?php
                                }
                            }else{
                        ?>
                        <tr>
                            <td colspan="8" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
                        </tr> 
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: ''//HH:mm:ss
    });
    function onExport(){
        jQuery("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name"
        });
    }
    function onSubmit(url){
        var date_from = $("input[name=date_from]").val();
        if(date_from==''){
            Lightboxt.showemsg('Thông báo', '<b>Chọn ngày bắt đầu</b>', 'Đóng');
        }
        var date_to = $("input[name=date_to]").val();
        if(date_to==''){
            Lightboxt.showemsg('Thông báo', '<b>Chọn ngày kết thúc</b>', 'Đóng');
        }
        $.ajax({
            url:url,
            type:"POST",
            data:{date_from:date_from,date_to:date_to},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.error!="undefined"&&f.error==0){
                    $(".loadData").html(f.html);
                    $('.loading_warning').hide();
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $(".loadData").html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
    function onSubmitExcel(formName,url){
        var theForm = document.getElementById(formName);
	theForm.action = url;	
	theForm.submit();
    }
</script>