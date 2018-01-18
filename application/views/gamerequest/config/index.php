<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
            <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" placeholder="Nhập từ khóa ..." title="Nhập từ khóa ..."/>
            <?php 
                if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
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
                    <th align="center">Name</th>
                    <th align="center" width="100px">Func</th>
                    <th align="center" width="200px">Dict</th>
                    <th align="center" width="70px">ActiveType</th>
                    <th align="center" width="70px">Type</th>
                    <th align="center" width="150px">CreateDate</th>
                    <th align="center" width="100px">Chức năng</th>
                    <th align="center" width="70px">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['idx'];?>" id="cid" name="cid[]"></td>
                    <td><?php echo $v['name'];?></td>
                    <td><?php echo $v['func'];?></td>
                    <td><?php echo $v['dict'];?></td>
                    <td>
                        <?php
                            $imgactiveType = ($v['activeType']==1)?'active.png':'inactive.png';
                            echo '<a title="activeType">
                                    <img border="0" title="activeType" src="'.base_url().'assets/img/'.$imgactiveType.'"> 
                                </a>';
                        ?>
                    </td>
                    <td>
                        <?php
                            $imgtype = ($v['type']==1)?'active.png':'inactive.png';
                            echo '<a title="type">
                                    <img border="0" title="type" src="'.base_url().'assets/img/'.$imgtype.'"> 
                                </a>';
                        ?>
                    </td>
                    <td><?php echo gmdate('d/m/Y G:i:s',$v['createDate']+7*3600);?></td>
                    
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['idx'].$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['idx'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            echo $btnEdit.' '.$btnDelete;
                        ?>
                        
                        
                    </td>
                    <td><?php echo $v['idx'];?></td>
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