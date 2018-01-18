<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<style>
    .scroolbar{
        width: 2600px;
    }
    .title_list{
        font-weight: bold;
    }
    .filter .title{
        position: relative;
        top:-4px;
        margin-left: 5px;
    }
    .filter .title:first-child{
        margin-left: 0px;
    }
    span#create{
        margin-bottom: 10px !important;
    }
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">   
            <?php include APPPATH . 'views/game/bog/Events/uocnguyen/tab.php'; ?>
            <div class="well form-horizontal">
                <form id="appForm" action="" method="post" name="appForm">
                    <script>
                        $(document).ready(function () {
                            $('#create').on('click', function () {
                                var start = $("input[name=start]").val();
                                var end = $("input[name=end]").val();
                                var server_id = $("select[name=server_id]").val();
                                window.location.href = '/?control=uocnguyen_bog&func=excel_history&server_id='+server_id+'&start='+start+'&end='+end;
                            });
                        });
                    </script>
                    <div class="filter">
                        <span class="title">Server:</span> <select name="server_id">
                            <option value="">Chọn server</option>
                            <?php
                                if(count($slbServer)>0){
                                    foreach($slbServer as $v){
                            ?>
                            <option value="<?php echo $v['server_id'];?>" <?php echo $_POST['server_id']==$v['server_id']?'selected="selected"':'';?>><?php echo $v['server_name'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                        <span class="title">Start:</span> <input type="text" name="start" class="datetime" placeholder="Ngày bắt đầu" value="<?php echo (!empty($_POST['start']))?$_POST['start']:date('d-m-Y G:i:s',  strtotime('-14 day'));?>"/>
                        <span class="title">End:</span> <input type="text" name="end" class="datetime" placeholder="Ngày kết thúc" value="<?php echo (!empty($_POST['end']))?$_POST['end']:date('d-m-Y G:i:s');?>"/>
                        <?php
                            $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter#history')";
                        ?>
                        <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btn btn-primary"/> 
                        <span id="create"  class="btn btn-primary"><span>Xuất Excel</span></span>
                    </div>
                    <?php
						if($_POST['server_id']>0){
					?>
                    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                        <thead>
                            <tr>
                                <th align="center" width="100px">STT</th>
                                <th align="center" width="120px">Ngày</th>
                                <th align="center" width="150px">Số lượng user tham gia</th>
                                <th align="center" width="150px">Số lần Ước Free</th>
                                <th align="center" width="150px">Số lần Ước trả phí</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(empty($listItem) !== TRUE){
                                    $i=0;
                                    foreach($listItem as $v){
                                        $i++;
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo date_format(date_create($v['created_date']),"d-m-Y");?></td>
                                <td><?php echo ($v['count_user']>0)?number_format($v['count_user'],0,',','.'):0;?></td>
                                <td><?php echo ($v['count_free']>0)?number_format($v['count_free'],0,',','.'):0;?></td>
                                <td><?php echo ($v['count_nofree']>0)?number_format($v['count_nofree'],0,',','.'):0;?></td>
                            </tr>
                            <?php
                                    }
                                }else{
                            ?>
                            <tr>
                                <td colspan="5" class="emptydata">Dữ liệu không tìm thấy</td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
					<?php
						}else{
					?>
					<table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                        <thead>
                            <tr>
                                <th align="center" width="100px">STT</th>
                                <th align="center" width="120px">Server</th>
                                <th align="center" width="150px">Tổng số lượng user tham gia</th>
                                <th align="center" width="150px">Tổng số lần Ước Free</th>
                                <th align="center" width="150px">Tổng số lần Ước trả phí</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(empty($listItem) !== TRUE){
                                    $i=0;
                                    foreach($listItem as $v){
                                        $i++;
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $v['server_id'];?></td>
                                <td><?php echo ($v['count_user']>0)?number_format($v['count_user'],0,',','.'):0;?></td>
                                <td><?php echo ($v['count_free']>0)?number_format($v['count_free'],0,',','.'):0;?></td>
                                <td><?php echo ($v['count_nofree']>0)?number_format($v['count_nofree'],0,',','.'):0;?></td>
                            </tr>
                            <?php
                                    }
                                }else{
                            ?>
                            <tr>
                                <td colspan="5" class="emptydata">Dữ liệu không tìm thấy</td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
					<?php
						}
					?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>