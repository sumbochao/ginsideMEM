<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<style>
    .ordertext{
        background:none !important;
        border: 0px !important;
        box-shadow:none !important;
    }
    .btnoption{
        position: relative;
        top: -4px;
    }
</style>
<div class="loading_warning"></div>
<div id="content-t" class="loadNavigator" style="min-height:500px; padding-top:10px">
    <?php include APPPATH . 'views/mem/tab.php'; ?>
    <form id="appForm" action="" method="post" name="appForm" style="margin-top:10px;">
        <?php include_once 'include/toolbar.php'; ?>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center">Tên</th>
                    <th align="center" width="600px">Mô tả</th>
                    <th align="center" width="120px">Chức năng</th>
                    <th align="center" width="100px">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                            $value = json_decode($v['value'],true);
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid" name="cid[]"></td>
                    <td><?php echo $v['name'];?></td>
                    <td><?php echo $value['value_'.$defaultLanguage['code']];?></td>
                    <td>
                        <?php
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&view=".$_GET['view']."&module=all&id=".$v['id'].$game.$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&view=".$_GET['view']."&module=all&id=".$v['id'].$page.'" title="Xóa">
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