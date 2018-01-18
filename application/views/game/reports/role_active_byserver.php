<script src="<?php echo base_url('assets/multiselect/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

<script src="<?php echo base_url('assets/multiselect/js/bootstrap-multiselect.js') ?>"></script>
<script src="<?php echo base_url('assets/multiselect/js/prettify.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/bootstrap-multiselect.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/multiselect/css/prettify.css') ?>"/>

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
    <?php include_once 'tab.php'; ?>
    <div class="content_tab">
        <div class="filter">
            <form action="" method="POST" id="appForm">
                <span>Máy chủ :</span>
                <script>
                    jQuery('.dropdown input, .dropdown label').click(function (event) {
                        event.stopPropagation();
                    });
                    jQuery(document).ready(function () {
                        jQuery('#example39').multiselect({
                            includeSelectAllOption: true,
                            enableCaseInsensitiveFiltering: true
                        });
                    });
                </script>
                <select id="example39" class="server" name="server[]" multiple="multiple">
                    <?php
                        if(count($listServer)>0){
                            foreach($listServer as $v){
                    ?>
                    <option value="<?php echo $v['server_id'];?>"><?php echo $v['server_name'];?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
                <span>Từ ngày :</span> <input type="text" name="date_from" placeholder="Ngày bắt đầu" value="<?php echo (!empty($arrFilter['date_from']))?$arrFilter['date_from']:date('d-m-Y',  strtotime('-25 day'));?>"/>
                <span>Đến ngày :</span> <input type="text" name="date_to" placeholder="Ngày kết thúc" value="<?php echo (!empty($arrFilter['date_to']))?$arrFilter['date_to']:date('d-m-Y');?>"/>    
                <input type="button" onclick="onSubmit('<?php echo base_url().'?control='.$_GET['control'].'&func=ajax_'.$_GET['func'].'&game='.$_GET['game'];?>')" value="Tìm" class="btn btn-primary"/>
                <span class="loadExport">
                    <input type="button" value="Xuất Excel" class="disableExport btn"/>
                </span>
                
            </form>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="wrapper_scroolbar loadData">
                <div class="scroolbar" style="width:<?php echo count($listServer)*287;?>px">
                    <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th align="center" width="100px" rowspan="2">Active Users</th>
                                <?php
                                    if(count($listServer)>0){
                                        foreach($listServer as $v){
                                ?>
                                <th align="center" width="350px" colspan="3"><?php echo $v['server_name'];?></th>
                                <?php

                                        }
                                    }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                    if(count($listServer)>0){
                                        foreach($listServer as $v){
                                ?>
                                <th align="center">New Active</th>
                                <th align="center">Daily Active</th>
                                <th align="center">Total Active</th>
                                <?php
                                        }
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($listItems)>0){
                                    $i=0;
                                    foreach($listItems as $key=>$vtable){
                                        $i++;
                                        if($i==1) $status = count($vtable['data']);
                            ?>
                            <tr>
                                <td>
                                    <?php
                                        $date = new DateTime($vtable['date']);
                                        echo $date->format('d-m-Y');
                                    ?>
                                </td>
                                <?php
                                    for($i=0;$i<count($listServer);$i++){
                                ?>
                                <td><?php echo isset($vtable['data'][$i]["new_active"])?number_format($vtable['data'][$i]["new_active"]):"";?></td>
                                <td><?php echo isset($vtable['data'][$i]["daily_active"])?number_format($vtable['data'][$i]["daily_active"]):""?></td>
                                <td><?php echo isset($vtable['data'][$i]["total_active"])?number_format($vtable['data'][$i]["total_active"]):""?></td>
                                <?php
                                    }
                                ?>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    jQuery("input[name=server]").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 32 || (event.keyCode == 65 && event.ctrlKey === true) ||(event.keyCode >= 35 && event.keyCode <= 39)) 
        {
            jQuery(this).val(jQuery.trim(jQuery(this).val()));
            return;
        }else {
                if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });

    $('input[name=date_from]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: ''//HH:mm:ss
    });
    $('input[name=date_to]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: '',//HH:mm:ss
        /*onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }*/
    });
    function onExport(){
        jQuery("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name"
        });
    }
    function onSubmit(url){
        var date_from = $("input[name=date_from]").val();
        var date_to = $("input[name=date_to]").val();
        var server = $(".server").val();
        if(server==0){
            Lightboxt.showemsg('Thông báo', '<b>Vui lòng chọn máy chủ</b>', 'Đóng');
        }
        $.ajax({
            url:url,
            type:"POST",
            data:{server:server,date_from:date_from,date_to:date_to},
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
    function onSubmitExcel(formName,url){
        var theForm = document.getElementById(formName);
	theForm.action = url;	
	theForm.submit();
    }
</script>