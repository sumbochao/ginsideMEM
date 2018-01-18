<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
            <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" class="textinput" placeholder="Nhập từ khóa ..." title="Nhập từ khóa ..."/>
            <?php 
                if((in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                }else{
                    $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
                }
            ?>
            <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>   
        </div>
        
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center">Tên chức năng</th>
                    <th align="center" width="100px">Controller</th>
                    <th align="center" width="150px">Action</th>
                    <th align="center" width="110px">Game</th>
                    <th align="center" width="130px">Loại</th>
                    <th align="center" width="80px">Sắp xếp</th>
                    <th align="center" width="87px">Chức năng</th>
                    <th align="center">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                            if($v['level'] == 1){
                                $name = '<div> <strong>+ ' . $v['name'] . '</strong></div>';
                            }else{
                                $x = 25 * ($v['level']-1);
                                $css = 'padding-left: ' . $x . 'px;';
                                $name = '<div style="' . $css . '">- ' . $v['name'] . '</div>';
                            }
                            $typeReport = !empty($v['report_game'])?'_'.$v['report_game']:'';
							$layout = !empty($v['layout'])?'_Menu:'.$v['layout']:'';
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid" name="cid[]"></td>
                    <td style="text-align:left"><?php echo $name;?></td>
                    <td><?php echo $v['controller'];?></td>
                    <td><?php echo $v['action'].$typeReport.$layout;?></td>
                    <td><?php echo $v['game'];?></td>
                    <td>
                        <?php
                            switch($v['id_type']){
                                case '0':
                                    echo 'Chức năng chính';
                                    break;
                                case '1':
                                    echo 'Dữ liệu game';
                                    break;
                                case '2':
                                    echo 'Mật định';
                                    break;
                                case '3':
                                    echo 'Báo cáo+reset';
                                    break;
                            }
                        ?>
                    </td>
                    <td>
                        <input type="hidden" name="listid[]" value="<?php echo $v['id'];?>" />
                        <input value="<?php echo $order=($i)+($pageInt);?>" name="listorder[]" id="listorder_<?php echo $i?>" class="ordertext">
                    </td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id'].$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'" title="Xóa">
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
<script type="text/javascript">
(new TableDnD).init("tblsort");
</script>