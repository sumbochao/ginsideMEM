<form id="appForm" action="" method="post" name="appForm">
    <?php include_once 'include/toolbar.php'; ?>
    <div class="filter">
        <select name="slbGame" onchange="listingRedirectUrl('1','<?php echo base_url().'?control='.$_GET['control'].'&func=index';?>',$(this),this.value)">
            <option value="0">Chọn game</option>
            <?php
                if(count($slbGame)>0){
                    foreach($slbGame as $v){
                        if((@in_array($v['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            ?>
            <option value="<?php echo $v['alias'];?>" <?php echo ($v['alias']==$_GET['idgame'])?'selected="selected"':'';?>><?php echo $v['game'];?></option>
            <?php
                        }
                    }
                }
            ?>
        </select>
    </div>
    <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
        <thead>
            <tr>
                <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                <th align="center">Name</th>
                <th align="center" width="200px">Client ID</th>
                <th align="center" width="200px">Client Secret</th>
                <th align="center" width="200px">Create_date</th>
                <th align="center" width="50px">Server_id</th>
                <th align="center" width="60px">Status</th>
                <th align="center" width="60px">Control</th>
                <th align="center" width="50px">ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if($_GET['page']>0){
                    $page = '&page='.$_GET['page'];
                }
                if(!empty($_GET['idgame'])){
                    $game = '&idgame='.$_GET['idgame'];
                }
                if(empty($listItems) !== TRUE){
                    foreach($listItems as $i=>$v){
            ?>
            <tr>
                <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid" name="cid[]"></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo $v['client_id'];?></td>
                <td><?php echo $v['client_secret'];?></td>
                <td>
                    <?php 
                        $create_date = DateTime::createFromFormat('Y-m-d G:i:s',$v['create_date']);
                        echo  $create_date->format('d-m-Y G:i:s');
                    ?>
                </td>
                <td><?php echo $v['server_id'];?></td>
                <td>
                    <?php
                        $imgActive = ($v['status']==1)?'active.png':'inactive.png';
                        $lnkActive = base_url()."?control=".$_GET['control']."&func=status&id=".$v['id']."&s=".$v['status'].$game.$page;
                        echo '<a href="'.$lnkActive.'" title="Duyệt">
                                <img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'"> 
                            </a>';
                    ?>
                </td>
                
                <td>
                    <?php
                        $btnEdit = '
                            <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id'].$game.$page.'" title="Sửa">
                                <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                            </a>';
                        $btnDelete ='
                            <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].$game.$page.'" title="Xóa">
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
<script>
    (new TableDnD).init("tblsort");
</script>