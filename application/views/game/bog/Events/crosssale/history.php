<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<style>
    .scroolbar{
        width: 1800px;
    }
    .title_list{
        font-weight: bold;
    }
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">   
            <?php include APPPATH . 'views/game/bog/Events/crosssale/tab.php'; ?>
            <div class="well form-horizontal">
                <form id="appForm" action="" method="post" name="appForm">
                    <div class="filter">
                        <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" placeholder="Nhập từ khóa ..." title="Nhập từ khóa ..."/>
                        <?php
                            $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                        ?>
                        <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btn btn-primary"/>   
                    </div>
                    <div class="wrapper_scroolbar">
                        <div class="scroolbar">
                            <div class="title_list">List History: </div>
                            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                                <thead>
                                    <tr>
                                        <th align="center" width="100px">ID</th>
                                        <th align="center" width="150px">Device ID</th>
                                        <th align="center" width="80px">Game ID</th>
                                        <th align="center" width="80px">Game ID Receive</th>
                                        <th align="center" width="70px">Status</th>
                                        <th align="center" width="100px">Create Date</th>
										<th align="center" width="60px">Mobo ID</th>
                                        <th align="center" width="120px">Mobo Service ID</th>
                                        <th align="center" width="70px">Server ID</th>
                                        <th align="center" width="70px">Items</th>
                                        
                                        <th align="center" width="50px">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(empty($listItemHistory) !== TRUE){
                                            foreach($listItemHistory as $i=>$v){
                                    ?>
                                    <tr>
                                        <td><?php echo $v['idx'];?></td>
                                        <td><?php echo $v['device_id'];?></td>
                                        <td><?php echo $v['gameID'];?></td>
                                        <td><?php echo $v['gamereceiveID'];?></td>
                                        <td><?php echo $v['status'];?></td>
                                        <td><?php echo $v['createDate'];?></td>
                                        <td><?php echo $v['mobo_id'];?></td>
                                        <td><?php echo $v['mobo_service_id'];?></td>
                                        <td><?php echo $v['server_id'];?></td>
                                        <td><?php echo $v['items'];?></td>
										<td><?php echo $v['type'];?></td>
                                    </tr>
                                    <?php
                                            }
                                        }else{
                                    ?>
                                    <tr>
                                        <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php echo $pages?>
                </form>
            </div>
        </div>
    </div>
</div>