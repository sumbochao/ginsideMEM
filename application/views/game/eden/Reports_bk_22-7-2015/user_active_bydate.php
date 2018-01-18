<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
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
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once 'tab.php'; ?>
    <div class="content_tab">
        <div class="filter">
            <span>Ngày :</span> <input type="text" name="date" placeholder="Ngày" value="<?php echo (!empty($arrFilter['date']))?$arrFilter['date']:date('d-m-Y');?>"/>    
            <?php
                if((@in_array($_GET['control'].'-filter_index', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            ?>
            <input type="button" onclick="onSubmit('<?php echo base_url().'?control=eden_reports&func=ajax_user_active_bydate';?>')" value="Tìm" class="btnB btn-primary"/>
            <?php
                }else{
            ?>
            <input type="button" onclick='alert("Bạn không có quyền truy cập chức năng này !")' value="Tìm" class="btnB btn-primary"/>
            <?php
                }
            ?>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="loadData">
                <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th align="center" width="100px">Date</th>
                            <th align="center" width="100px">Server</th>
                            <th align="center" width="100px">New Active</th>
                            <th align="center" width="100px">Total Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="emptydata">Dữ liệu không tìm thấy</td>
                        </tr>                     
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
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
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $(".loadData").html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
</script>