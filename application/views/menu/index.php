<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
            <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" class="textinput" placeholder="Nhập từ khóa ..." title="Nhập từ khóa ..."/>
            <?php 
                if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                }else{
                    $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
                }
            ?>
			<select name="limitpage">
                <option value="0">Chọn dòng/trang</option>
                <option value="1" <?php echo $_SESSION['limitpage']=='1'?'selected="selected"':'';?>>40 dòng/trang</option>
                <option value="2" <?php echo $_SESSION['limitpage']=='2'?'selected="selected"':'';?>>80 dòng/trang</option>
                <option value="3" <?php echo $_SESSION['limitpage']=='3'?'selected="selected"':'';?>>160 dòng/trang</option>
                <option value="4" <?php echo $_SESSION['limitpage']=='4'?'selected="selected"':'';?>>300 dòng/trang</option>
                <option value="5" <?php echo $_SESSION['limitpage']=='5'?'selected="selected"':'';?>>Hiển thị tất cả</option>
            </select>
            <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>   
        </div>
        
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center">Tên</th>
                    <th align="center" width="100px">Duyệt</th>
                    <th align="center" width="100px">Sắp xếp</th>
                    <th align="center" width="100px">Chức năng</th>
                    <th align="center" width="100px">ID</th>
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
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid" name="cid[]"></td>
                    <td style="text-align:left"><?php echo $name;?></td>
                    <td>
                        <?php
                            if($_GET['page']>0){
                                $page = '&page='.$_GET['page'];
                            }
                            $imgActive = ($v['status']==1)?'active.png':'inactive.png';
                            
                            if((@in_array($_GET['control'].'-status', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                                $lnkActive = base_url()."?control=".$_GET['control']."&func=status&id=".$v['id']."&s=".$v['status'].$page;
                            }else{
                                $lnkActive = 'javascript:;';
                                $alert = 'onclick="alert(\'Bạn không có quyền truy cập chức năng này!\');"';
                            }
                            echo '<a href="'.$lnkActive.'" '.$alert.' title="Duyệt">
                                    <img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
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