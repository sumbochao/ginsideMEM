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
.scroolbar{
    height: 500px;
}
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once 'tab.php'; ?>
    <div class="content_tab">
        <div class="filter">
            <span class="loadExport">
                <input type="button" value="Xuất Excel" class="btn btn-primary" onclick="onExport();"/>
            </span>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="wrapper_scroolbar loadData">
                <div class="scroolbar" style="width:<?php echo count($listServer)*90;?>px">
                    <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th align="center" width="100px">Card ID</th>
                                <?php
                                    if(count($listServer)>0){
                                        foreach($listServer as $v){
                                ?>
                                <th align="center" width="100px">Server <?php echo $v;?></th>
                                <?php

                                        }
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($listItems)>0){
                                    foreach($listItems as $k=>$v){
                            ?>
                            <tr>
                                <td><?php echo $k;?></td>
                                <?php
                                    for($i=0;$i<count($listServer);$i++){
                                ?>
                                <td><?php echo isset($v[$i]["amount"])?number_format($v[$i]["amount"]):0;?></td>
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