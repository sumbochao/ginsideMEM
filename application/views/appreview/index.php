<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>

<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center">Loại</th>
                    <th align="center" width="300px">Bundle/Package name</th>
                    <th align="center" width="140px">Version app</th>
                    <th align="center" width="90px">Trang thái</th>
                    <th align="center" width="150px">Chức năng</th>
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
                    <td>
                        <?php 
                            switch ($v['type']){
                                case 'ios':
                                    echo "IOS";
                                    break;
                                case 'android':
                                    echo "Android";
                                    break;
                            }
                        ?>
                    </td>
                    <td><?php echo $v['package_name'];?></td>
                    <td><?php echo $v['version'];?></td>
                    <td>
                        <?php
                            switch ($v['status']){
                                case '0';
                                    echo 'Approving';
                                    break;
                                case '1';
                                    echo 'Approved';
                                    break;
                                case '2';
                                    echo 'Reject';
                                    break;
                                case '3';
                                    echo 'Cancel';
                                    break;
                            }
                        ?>
                    </td><td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id'].$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa items này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            echo $btnEdit.' '.$btnDelete;
                        ?>
                        
                        
                    </td>
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