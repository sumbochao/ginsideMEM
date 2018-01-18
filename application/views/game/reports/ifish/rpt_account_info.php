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
    input[type="submit"] {
        margin-bottom: 10px;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once(APPLICATION_PATH.'/application/views/game/reports/tab.php');?>
    <div class="content_tab">
        <div class="filter">
            <form action="" method="POST" id="appForm">
                <span>User ID:</span> <input type="text" name="msi" placeholder="Mobo Service ID" value="<?php echo $_POST['msi'];?>"/>
                <input type="submit" value="Tìm" class="btn btn-primary"/>
                <input type="button" value="Xuất Excel" class="btn btn-primary" onclick="onExport();"/>
            </form>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="loadData">
                <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th align="center" width="50px">STT</th>
                            <th align="center" width="50px">Mobo Service ID</th>
                            <th align="center" width="130px">Character ID</th>
                            <th align="center" width="100px">Tổng tiền đã nạp (VNDPaid)</th>
                            <th align="center" width="110px">Lượng ngọc trong ví hiện tại (CurrGem)</th>
                            <th align="center" width="110px">Tổng lượng ngọc đã nhận từ việc nạp tiền (GemReceived)</th>
                            <th align="center" width="110px">Tổng lượng ngọc đã chuyển vào game (GemUsed)</th>
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
                            <td><?php echo $v['mobo_service_id'];?></td>
                            <td><?php echo $v['character_id'];?></td>
                            <td><?php echo $v["VNDPaid"]>0?number_format($v['VNDPaid']):0;?></td>
                            <td><?php echo $v["CurrGem"]>0?number_format($v['CurrGem']):0;?></td>
                            <td><?php echo $v["GemReceived"]>0?number_format($v['GemReceived']):0;?></td>
                            <td><?php echo $v["GemUsed"]>0?number_format($v['GemUsed']):0;?></td>
                        </tr>
                        <?php
                                }
                            }else{
                        ?>
                        <tr>
                            <td colspan="7" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
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
    function onExport(){
        jQuery("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name"
        });
    }
    function onSubmitExcel(formName,url){
        var theForm = document.getElementById(formName);
	theForm.action = url;	
	theForm.submit();
    }
</script>