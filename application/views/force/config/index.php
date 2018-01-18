<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center">ID</th>
                    <th align="center" width="100px">Service ID</th>
                    <th align="center" width="150px">Service Name</th>
                    <th align="center" width="200px">Forgot</th>
                    <th align="center" width="150px">Event</th>
                    <th align="center" width="150px">Support</th>
                    <th align="center" width="100px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($listItem) !== TRUE){
                        foreach($listItem as $i=>$v){
                ?>
                <tr>
                    <td><?php echo $v['id'];?></td>
                    <td><?php echo $v['service_id'];?></td>
                    <td><?php echo $listgame[$v['service_id']]['app_fullname'];?></td>
                    <td><?php echo $v['forgot'];?></td>
                    <td><?php echo $v['event']; ?></td>
                    <td><?php echo $v['support']; ?></td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id'].'&service_id='.$v['service_id'].$page.'&module=all" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            echo $btnEdit;
                        ?>
                    </td>
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
        <?php echo $pages?>
    </form>
</div>