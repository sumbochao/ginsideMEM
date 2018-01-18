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
            <div class="loadData">
                <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th align="center" width="50px">ID</th>
                            <th align="center" width="100px">Số ngọc hiện tại</th>
                            <th align="center" width="110px">Tổng ngọc nạp vào</th>
                            <th align="center" width="110px">Tổng ngọc xài</th>
                            <th align="center" width="110px">Ngày tạo ví ngọc</th>
                            <th align="center" width="110px">Trạng thái</th>
                            <th align="center" width="110px">Loại tài khoản</th>
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
                            <td><?php echo $v["amount"];?></td>
                            <td><?php echo $v["amount_cashin"]>0?number_format($v['amount_cashin']):0;?></td>
                            <td><?php echo $v["amount_cashout"]>0?number_format($v['amount_cashout']):0;?></td>
                            <td><?php echo date_format(date_create($v['create_date']),"d-m-Y G:i:s");?></td>
                            <td>
                                <?php
                                    switch ($v['status']){
                                        case '0':
                                            echo 'deactivate';
                                            break;
                                        case '1':
                                            echo 'activate';
                                            break;
                                        case '2':
                                            echo 'temp blocking';
                                            break;
                                        case '3':
                                            echo 'blocked';
                                            break;
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    switch ($v['account_type']){
                                        case '0':
                                            echo 'sandbox';
                                            break;
                                        case '1':
                                            echo 'production';
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
<script>
    function onSubmitFormAjax(){
        $.ajax({
            url:baseUrl+'?control=vicambo&func=ajax_accountwallet',
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