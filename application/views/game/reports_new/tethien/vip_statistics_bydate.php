<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>" media="all"/>
<script src="<?php echo base_url('assets/datetime/js/submit.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ajax.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

<script src="<?php echo base_url('assets/popup/bootstrap-modal.js') ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-transition.js') ?>"></script>
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
.filter span.loadExport{
    top:0px;
}
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once(APPLICATION_PATH.'/application/views/game/reports/tab.php');?>
    <div class="content_tab">
        <div class="filter">
            <span>Ngày :</span> <input type="text" name="date" placeholder="Ngày" value="<?php echo (!empty($arrFilter['date']))?$arrFilter['date']:date('d-m-Y');?>"/>    
            <input type="button" onclick="onSubmit('<?php echo base_url().'?control='.$_GET['control'].'&func=ajax_'.$_GET['func'].'&module=all&game='.$_GET['game'];?>')" value="Tìm" class="btn btn-primary"/>
            <span class="loadExport">
                <input type="button" value="Xuất Excel" class="disableExport btn"/>
            </span>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="wrapper_scroolbar">
                <div class="scroolbar" style="width:1500px">
                    <div class="loadData">
                        <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th align="center" width="100px">Date</th>
                                    <th align="center" width="100px">ServerID</th>
                                    <th align="center" width="100px">Vip 0</th>
                                    <th align="center" width="100px">Vip 1</th>
                                    <th align="center" width="100px">Vip 2</th>
                                    <th align="center" width="100px">Vip 3</th>
                                    <th align="center" width="100px">Vip 4</th>
                                    <th align="center" width="100px">Vip 5</th>
                                    <th align="center" width="100px">Vip 6</th>
                                    <th align="center" width="100px">Vip 7</th>
                                    <th align="center" width="100px">Vip 8</th>
                                    <th align="center" width="100px">Vip 9</th>
                                    <th align="center" width="100px">Vip 10</th>
                                    <th align="center" width="100px">Vip 11</th>
                                    <th align="center" width="100px">Vip 12</th>
                                    <th align="center" width="100px">Vip 13</th>
                                    <th align="center" width="100px">Vip 14</th>
                                    <th align="center" width="100px">Vip 15</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="18" class="emptydata">Dữ liệu không tìm thấy</td>
                                </tr>                     
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function onExport(){
        jQuery("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name"
        });
    }
    $('input[name=date]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: ''//HH:mm:ss
    });
    /*$('input[name=date_to]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss',
        /*onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }
    });*/
    function onSubmit(url){
        var date = $("input[name=date]").val();
        
        $.ajax({
            url:url,
            type:"POST",
            data:{date:date},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.error!="undefined"&&f.error==0){
                    $(".loadData").html(f.html);
                    $('.loading_warning').hide();
                    $(".loadExport").html('<input type="button" value="Xuất Excel" class="btn btn-primary" onclick="onExport();"/>');
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $(".loadData").html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
</script>