<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
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
    .scroolbar {
        width: 2500px;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once(APPPATH.'/views/game/fish/search/tab.php');?>
    <div class="content_tab">
        <div class="filter">
            <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                <span>Mobo Service ID:</span> <input type="text"name="mobo_service_id" placeholder="Mobo Service ID" value="<?php echo $_POST['mobo_service_id'];?>"/>
                <input type="button" onclick="onSubmitFormAjax()" value="Tìm" class="btn btn-primary btnsearch"/>
            </form>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="wrapper_scroolbar">
                <div class="scroolbar loadData">
                    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th align="center" width="50px">ID</th>
                                <th align="center" width="100px">Mobo Service ID</th>
                                <th align="center" width="110px">Mgày giao dịch</th>
                                <th align="center" width="110px">Số ngọc tiêu</th>
                                <th align="center" width="110px">Vàng nhận được</th>
                                <th align="center" width="110px">Mã nhân vật</th>
                                <th align="center" width="110px">Tên nhân vật</th>
                                <th align="center" width="110px">Mã giao dịch</th>
                                <th align="center" width="110px">Mục tiêu</th>
                                <th align="center" width="110px">ServerID</th>
                                <th align="center" width="110px">App Name</th>
                                <th align="center" width="110px">Nguồn xài</th>
                                <th align="center" width="110px">Tình trạng</th>
                                <th align="center" width="110px">Mô tả</th>
                                <th align="center" width="110px">IP Client</th>
                                <th align="center" width="110px">Số ngọc trước khi đổi</th>
                                <th align="center" width="110px">Loại tiêu</th>
                                <th align="center" width="110px">Platform</th>
                                <th align="center" width="110px">Loại giao dịch</th>
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
                                <td><?php echo $v['id'];?></td>
                                <td><?php echo $v["mobo_service_id"];?></td>
                                <td><?php echo date_format(date_create($v['log_date']),"d-m-Y G:i:s");?></td>
                                <td><?php echo $v["amount"]>0?number_format($v['amount']):0;?></td>
                                <td><?php echo $v["gold"]>0?number_format($v['gold']):0;?></td>
                                <td><?php echo $v["character_id"];?></td>
                                <td><?php echo $v["character_name"];?></td>
                                <td><?php echo $v["transaction_id"];?></td>
                                <td>
                                    <?php
                                        switch ($v['destination']){
                                            case '1':
                                                echo 'Vàng';
                                                break;
                                            case '2':
                                                echo 'chuyển tiền cá nhân lưu mobo account của tk nhận';
                                                break;
                                        }
                                    ?>
                                </td>
                                <td><?php echo $v["server_id"];?></td>
                                <td><?php echo $v["app_name"];?></td>
                                <td><?php echo $v["service_id"];?></td>
                                <td>
                                    <?php
                                        switch ($v['status']){
                                            case '1':
                                                echo 'Thành công';
                                                break;
                                            case '2':
                                                echo 'Thất bại';
                                                break;
                                            case '3':
                                                echo 'temp subtract';
                                                break;
                                        }
                                    ?>
                                </td>
                                <td><?php echo $v["description"];?></td>
                                <td><?php echo $v["ip_client"];?></td>
                                <td><?php echo $v["older_amount"];?></td>
                                <td>
                                    <?php
                                        switch ($v['type']){
                                            case '1':
                                                echo 'Vàng';
                                                break;
                                            case '2':
                                                echo 'Chuyển tiền cá nhân';
                                                break;
                                            case '3':
                                                echo 'Cá cược';
                                                break;
                                        }
                                    ?>
                                </td>
                                <td><?php echo $v["platform"];?></td>
                                <td>
                                    <?php
                                        switch ($v['sandbox']){
                                            case '1':
                                                echo 'Production';
                                                break;
                                            case '2':
                                                echo 'Sandbox';
                                                break;
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                                    }
                                }else{
                            ?>
                            <tr>
                                <td colspan="19" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
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
<script>
    function onSubmitFormAjax(){
        $.ajax({
            url:baseUrl+'?control=vicambo&func=ajax_cashout',
            type:"POST",
            data:$("#frmSendChest").serializeArray(),
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.error!="undefined" && f.error==0){
                    $(".loadData").html(f.html)
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                }
                $('.loading_warning').hide();
            }
        });
    }
</script>