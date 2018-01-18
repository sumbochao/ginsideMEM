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
    .canhphai{
        text-align: right !important;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once(APPLICATION_PATH.'/application/views/game/reports/tab.php');?>
    <div class="content_tab">
        <div class="filter">
            <span>
                <input type="button" value="Xuất Excel" class="btn btn-primary" onclick="onExport();"/>
            </span>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="loadData">
                <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th align="center" width="100px">STT</th>
                            <th align="center" width="100px">ServerID</th>
                            <th align="center" width="100px">DAU</th>
                            <th align="center" width="100px">TotalInBalance</th>
                            <th align="center" width="100px">LastInBalance</th>
                            <th align="center" width="100px">Balance</th>
                            <th align="center" width="100px">BindBalance</th>
                            <th align="center" width="100px">Money</th>
                            <th align="center" width="100px">EnergyP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(is_array($listItems)){
                                $i=0;
                                foreach($listItems as $v){
                                    $i++;
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $v['serverid'];?></td>
                            <td><?php echo $v['DAU'];?></td>
                            <td class="canhphai"><?php echo ($v['TotalInBalance']>0)?number_format($v['TotalInBalance'],0):'0';?></td>
                            <td class="canhphai"><?php echo ($v['LastInBalance']>0)?number_format($v['LastInBalance'],0):'0';?></td>
                            <td class="canhphai"><?php echo ($v['Balance']>0)?number_format($v['Balance'],0):'0';?></td>
                            <td class="canhphai"><?php echo ($v['BindBalance']>0)?number_format($v['BindBalance'],0):'0';?></td>
                            <td class="canhphai"><?php echo ($v['Money']>0)?number_format($v['Money'],0):'0';?></td>
                            <td class="canhphai"><?php echo ($v['EnergyP']>0)?number_format($v['EnergyP'],0):'0';?></td>
                        </tr>
                        <?php
                                }
                            }else{
                        ?>
                        <tr>
                            <td colspan="8" class="emptydata">Dữ liệu không tìm thấy</td>
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
</script>