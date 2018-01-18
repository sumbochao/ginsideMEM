<script src="<?php echo base_url('assets/multiselect/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

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
                <select id="example39" class="server" name="server">
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
                <span>Vip :</span> <input type="text" name="vip" placeholder="Vip" value=""/>
                <input type="button" onclick="onSubmit('<?php echo base_url().'?control='.$_GET['control'].'&func=ajax_'.$_GET['func'].'&module=all&game='.$_GET['game'];?>')" value="Tìm" class="btn btn-primary"/>
                <span class="loadExport">
                    <input type="button" value="Xuất Excel" class="disableExport btn"/>
                </span>
                
            </form>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="loadData">
                <div>
                    <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th align="center">STT</th>
                                <th align="center">UID</th>
                                <th align="center">Custom Name</th>
								<th align="center">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($listItems)>0){
                                    $i=0;
                                    foreach($listItems as $v){
                                        $i++;
                            ?>
                            <tr>
                                <td><?php echo number_format($i,0);?></td>
                                <td><?php echo ($v["uid"]>0)?number_format($v['uid'],0):0;?></td>
                                <td><?php echo $v['customName'];?></td>
                            </tr>
                            <?php
                                    }
                                }else{
                            ?>
                            <tr>
                                <td colspan="4">Dữ liệu không tìm thấy</td>
                            </tr>
                            <?php
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
    jQuery("input[name=vip]").keydown(function(event) {
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
    function onExport(){
        jQuery("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name"
        });
    }
    function onSubmit(url){
        var vip = $("input[name=vip]").val();
        var server = $(".server").val();
        if(server==0){
            Lightboxt.showemsg('Thông báo', '<b>Vui lòng chọn máy chủ</b>', 'Đóng');
        }
        $.ajax({
            url:url,
            type:"POST",
            data:{server:server,vip:vip},
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