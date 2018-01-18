<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center">Game</th>
                    <th align="center" width="300px">Service id</th>
                    <th align="center" width="140px">Service</th>
                    <th align="center" width="70px">Duyệt</th>
                    <th align="center" width="200px">Loại</th>
                    <th align="center" width="70px">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid" name="cid[]"></td>
                    <td><?php echo $v['app_fullname'];?></td>
                    <td><?php echo $v['service_id'];?></td>
                    <td><?php echo $v['service'];?></td>
                    <td>
                        <?php
                            if($_GET['page']>0){
                                $page = '&page='.$_GET['page'];
                            }
                            $imgActive = ($v['status']==1)?'active.png':'inactive.png';
                            
                            $lnkActive = base_url()."?control=".$_GET['control']."&func=status&module=all&id=".$v['id']."&s=".$v['status'].$page;
                            echo '<a href="'.$lnkActive.'" title="Duyệt">
                                    <img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                        
                    </td>
                    <td><?php echo ($v['type']=='local')?'Local':'Global';?></td>
                    <td><?php echo $v['id'];?></td>
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