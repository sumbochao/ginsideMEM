<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
            <input type="text" name="keyword" value="<?php echo $arrFilter['keyword'];?>" placeholder="Nhập từ khóa ..." title="Nhập từ khóa ..."/>
            <select name="configID">
                <option value="" <?php echo ($arrFilter['configID']=='')?'selected="selected"':'';?>>Chọn cấu hình</option>
                <?php
                    if(empty($slbConfig) !== TRUE){
                        foreach($slbConfig as $v){
                ?>
                <option value="<?php echo $v['idx'];?>" <?php echo ($arrFilter['configID']==$v['idx'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <select name="gameID">
                <option value="" <?php echo ($arrFilter['slbGame']=='')?'selected="selected"':'';?>>Chọn game</option>
                <?php
                    if(empty($slbGame) !== TRUE){
                        foreach($slbGame as $v){
                ?>
                <option value="<?php echo $v['gameID'];?>" <?php echo ($arrFilter['gameID']==$v['gameID'])?'selected="selected"':'';?>><?php echo $v['name'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
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
                    <th align="center" width="120px">Config</th>
                    <th align="center">Name</th>
                    <th align="center" width="150px">Start date</th>
                    <th align="center" width="150px">End date</th>
                    <th align="center" width="150px">Game</th>
                    <th align="center" width="60px">Status</th>
                    <th align="center" width="70px">Order</th>
                    <th align="center" width="90px">Chức năng</th>
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
                    <td><?php echo $slbConfig[$v['configID']]['name'];?></td>
                    <td><?php echo $v['name'];?></td>
                    <td><?php echo $v['startDate'];?></td>
                    <td><?php echo $v['endDate'];?></td>
                    <td><?php echo $slbGame[$v['gameID']]['name'];?></td>
                    <td>
                        <?php
                            if($_GET['page']>0){
                                $page = '&page='.$_GET['page'];
                            }
                            $imgActive = ($v['status']==1)?'active.png':'inactive.png';
                            
                            if((in_array($_GET['control'].'-status', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                                $lnkActive = base_url()."?control=".$_GET['control']."&func=status&id=".$v['idx']."&s=".$v['status'].$page;
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
                        <input type="hidden" name="listid[]" value="<?php echo $v['idx'];?>" />
                        <input value="<?php echo $order=($i)+($pageInt);?>" name="listorder[]" id="listorder_<?php echo $i?>" class="ordertext">
                    </td>
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