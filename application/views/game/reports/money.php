<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
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
    <?php include_once 'tab.php'; ?>
    <div class="content_tab">
        <form id="appForm" action="" method="post" name="appForm">
            <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th align="center" width="100px">ServerID</th>
                        <th align="center" width="100px">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(is_array($money)){
                            foreach($money as $v){
                    ?>
                    <tr>
                        <td><?php echo $v['serverid'];?></td>
                        <td><?php echo ($v['amount']>0)?number_format($v['amount']):0;?></td>
                    </tr> 
                    <?php
                            }
                        }else{
                    ?>
                    <tr>
                        <td colspan="2" class="emptydata">Dữ liệu không tìm thấy</td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</div>