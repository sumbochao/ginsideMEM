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
        <select name="type">
            <option value="0">Chọn loại</option>
            <option value="1" <?php echo ($_SESSION['filter']['type']==1)?'selected="selected"':'';?>>Giới thiệu</option>
            <option value="2" <?php echo ($_SESSION['filter']['type']==2)?'selected="selected"':'';?>>Sản phẩm</option>
            <option value="3" <?php echo ($_SESSION['filter']['type']==3)?'selected="selected"':'';?>>Đối tác</option>
			<option value="4" <?php echo ($_SESSION['filter']['type']==4)?'selected="selected"':'';?>>Sinh nhật</option>
        </select>
        <input type="submit" name="ok" class="btn btn-primary btnoption" value="Tìm kiếm"/>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center">Tên</th>
                    <th align="center" width="120px">Hình ảnh</th>
                    <th align="center" width="120px">Loại</th>
                    <th align="center" width="120px">Order</th>
                    <th align="center" width="120px">Chức năng</th>
                    <th align="center" width="100px">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $paget = array('1'=>'Giới thiệu','2'=>'Sản phẩm','3'=>'Đối tác','4'=>'Sinh nhật');
                    if($_GET['page']>0){
                        $page = '&page='.$_GET['page'];
                    }
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                            $name = json_decode($v['name'],true);
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid" name="cid[]"></td>
                    <td><?php echo $name['name_'.$defaultLanguage['code']];?></td>
                    <td>
                        <?php
                            if(!empty($v['image'])){
                        ?>
                        <img src="<?php echo $url_image.'/'.$v['image'];?>" height="57px">
                        <?php
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $paget[$v['type']];
                        ?>
                    </td>
                    <td>
                        <input type="hidden" name="listid[]" value="<?php echo $v['id'];?>" />
                        <input type="text" value="<?php echo ($i)+($pageInt);?>" name="listorder[]" id="listorder_<?php echo $i?>" class="ordertext">
                    </td>
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
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>