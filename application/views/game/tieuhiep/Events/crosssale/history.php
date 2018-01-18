<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<style>
    .scroolbar{
        width: 2600px;
    }
    .title_list{
        font-weight: bold;
    }
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">   
            <?php include APPPATH . 'views/game/lk/Events/crosssale/tab.php'; ?>
            <div class="well form-horizontal">
                <form id="appForm" action="" method="post" name="appForm">
                    <div class="filter">
                        <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" placeholder="Nhập từ khóa ..." title="Nhập từ khóa ..."/>
                        <?php
                            $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                        ?>
                        <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>   
                    </div>
                    <div class="wrapper_scroolbar">
                        <div class="scroolbar">
                            <div class="title_list">List User Request: </div>
                            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                                <thead>
                                    <tr>
                                        <th align="center" width="100px">ID</th>
                                        <th align="center" width="120px">Config ID</th>
                                        <th align="center" width="150px">Device ID</th>
                                        <th align="center" width="150px">Game ID</th>
                                        <th align="center" width="150px">Game ID Receive</th>
                                        <th align="center" width="60px">Mobo ID</th>
                                        <th align="center" width="120px">Mobo Service ID</th>
                                        <th align="center" width="90px">Character ID</th>
                                        <th align="center" width="120px">Character Name</th>
                                        <th align="center" width="70px">Server ID</th>
                                        <th align="center" width="70px">Items</th>
                                        <th align="center" width="100px">Items Receive</th>
                                        <th align="center" width="70px">Status</th>
                                        <th align="center" width="150px">Receive Mobo Service ID</th>
                                        <th align="center" width="150px">Receive Mobo ID</th>
                                        <th align="center" width="150px">Receive Character ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(empty($listItem) !== TRUE){
                                            foreach($listItem as $i=>$v){
                                    ?>
                                    <tr>
                                        <td><?php echo $v['idx'];?></td>
                                        <td><?php echo $v['configID'];?></td>
                                        <td><?php echo $v['device_id'];?></td>
                                        <td><?php echo $v['gameID'];?></td>
                                        <td><?php echo $v['gameIDreceive'];?></td>
                                        <td><?php echo $v['mobo_id'];?></td>
                                        <td><?php echo $v['mobo_service_id'];?></td>
                                        <td><?php echo $v['character_id'];?></td>
                                        <td><?php echo $v['character_name'];?></td>
                                        <td><?php echo $v['server_id'];?></td>
                                        <td><?php echo $v['items'];?></td>
                                        <td><?php echo $v['items_receive'];?></td>
                                        <td><?php echo $v['status'];?></td>
                                        <td><?php echo $v['receive_mobo_service_id'];?></td>
                                        <td><?php echo $v['receive_mobo_id'];?></td>
                                        <td><?php echo $v['receive_character_id'];?></td>
                                    </tr>
                                    <?php
                                            }
                                        }else{
                                    ?>
                                    <tr>
                                        <td colspan="16" class="emptydata">Dữ liệu không tìm thấy</td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <div class="title_list">List History:</div>
                            <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
                                <thead>
                                    <tr>
                                        <th align="center" width="100px">ID</th>
                                        <th align="center" width="120px">Config ID</th>
                                        <th align="center" width="150px">Device ID</th>
                                        <th align="center" width="150px">Game ID</th>
                                        <th align="center" width="150px">Game ID Receive</th>
                                        <td align="center" width="150px">Type</td>
                                        <th align="center" width="60px">Mobo ID</th>
                                        <th align="center" width="120px">Mobo Service ID</th>
                                        <th align="center" width="70px">Server ID</th>
                                        <th align="center" width="70px">Items</th>
                                        <th align="center" width="100px">Rule Type</th>
                                        <th align="center" width="70px">Level</th>
                                        <th align="center" width="150px">Create Date</th>
                                        <th align="center" width="150px">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(empty($listItemHistory) !== TRUE){
                                            foreach($listItemHistory as $i=>$v){
                                    ?>
                                    <tr>
                                        <td><?php echo $v['idx'];?></td>
                                        <td><?php echo $v['configID'];?></td>
                                        <td><?php echo $v['device_id'];?></td>
                                        <td><?php echo $v['gameID'];?></td>
                                        <td><?php echo $v['gameIDreceive'];?></td>
                                        <td><?php echo $v['type'];?></td>
                                        <td><?php echo $v['mobo_id'];?></td>
                                        <td><?php echo $v['mobo_service_id'];?></td>
                                        <td><?php echo $v['server_id'];?></td>
                                        <td><?php echo $v['items'];?></td>
                                        <td><?php echo $v['ruleType'];?></td>
                                        <td><?php echo $v['level'];?></td>
                                        <td><?php echo $v['createDate'];?></td>
                                        <td><?php echo $v['status'];?></td>
                                    </tr>
                                    <?php
                                            }
                                        }else{
                                    ?>
                                    <tr>
                                        <td colspan="16" class="emptydata">Dữ liệu không tìm thấy</td>
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