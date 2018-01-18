<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
            <select name="id_game">
                <option value="0">Chọn game</option>
                <?php
                    if(count($slbGame)>0){
                        foreach($slbGame as $v){
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo $arrFilter['id_game']==$v['id']?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <select name="cert_id">
                <option value="0">Chọn bảng Cert</option>
                <?php
                    if(count($slbTable)>0){
                        foreach($slbTable as $v){
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo $arrFilter['cert_id']==$v['id']?'selected="selected"':'';?>><?php echo $v['cert_type'];?></option>
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
                    <th align="center" width="150px">Holder</th>
                    <th align="center">Game</th>
                    <th align="center" width="150px">Bảng Cert</th>
                    <th align="center" width="150px">BundleID</th>
                     <th align="center" width="150px">Provision file</th>
                      <th align="center" width="150px">Entitlement file</th>
                    <th align="center" width="100px">Duyệt</th>
                    <!--<th align="center" width="100px">Sắp xếp</th>-->
                    <th align="center" width="100px">Chức năng</th>
                    <th align="center">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid" name="cid[]"></td>
                    <td></td>
                    <td style="text-align:left"><?php echo $slbGame[$v['id_game']]['app_fullname'];?></td>
                    <td><?php echo $slbTable[$v['cert_id']]['cert_type'];?></td>
                    <td><?php echo $v['bundleidentifier'];?></td>
                    <td><?php echo $v['provision'];?></td>
                    <td><?php echo $v['entitlements'];?></td>
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
                    <!--<td>
                        <input type="hidden" name="listid[]" value="<?php echo $v['id'];?>" />
                        <input value="<?php echo $order=($i)+($pageInt);?>" name="listorder[]" id="listorder_<?php echo $i?>" class="ordertext">
                    </td>-->
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
                            if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            					 echo $btnEdit.' '.$btnDelete;
							}
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