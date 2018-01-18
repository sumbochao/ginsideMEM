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
                <span>User ID:</span> <input type="text" class="datetime" name="userid" placeholder="UserID" value="<?php echo $_POST['userid'];?>"/>
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
                            <th align="center" width="50px">User</th>
                            <th align="center" width="130px">Lượng sò hiện tại</th>
                            <th align="center" width="100px">Lượng sò đã kiếm được</th>
                            <th align="center" width="110px">Lượng Gold hiện tại</th>
                            <th align="center" width="110px">Lượng Gem hiện tại</th>
                            <th align="center" width="110px">Điểm cống hiến</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($listItems)>0){
                                $i=0;
								$totalIngot =0;
								$totalingot_earn =0;
								$totalScore=0;
								$totalsilverScore=0;
								$totalIngotContribution=0;
                                foreach($listItems as $key=>$v){
                                    $i++;
									$totalIngot+=$v['Ingot'];
									$totalingot_earn+=$v['ingot_earn'];
									$totalScore+=$v['Score'];
									$totalsilverScore+=$v['silverScore'];
									$totalIngotContribution+=$v['IngotContribution'];
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $v['UserID'];?></td>
                            <td><?php echo $v["Ingot"]>0?number_format($v['Ingot']):0;?></td>
                            <td><?php echo $v["ingot_earn"]>0?number_format($v['ingot_earn']):0;?></td>
                            <td><?php echo $v["Score"]>0?number_format($v['Score']):0;?></td>
                            <td><?php echo $v["silverScore"]>0?number_format($v['silverScore']):0;?></td>
                            <td><?php echo $v["IngotContribution"]>0?number_format($v['IngotContribution']):0;?></td>
                        </tr>
                        <?php
                                }
					    ?>
						<tr>
                            <td colspan="2">Tổng sò</td>
							<td><?php echo $totalIngot>0?number_format($totalIngot):0;?></td>
							<td><?php echo $totalingot_earn>0?number_format($totalingot_earn):0;?></td>
							<td><?php echo $totalScore>0?number_format($totalScore):0;?></td>
							<td><?php echo $totalsilverScore>0?number_format($totalsilverScore):0;?></td>
							<td><?php echo $totalIngotContribution>0?number_format($totalIngotContribution):0;?></td>
                        </tr>
						<?php
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