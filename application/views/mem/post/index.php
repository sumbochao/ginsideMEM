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
        <select name="page">
            <option value="0">Chọn trang</option>
            <option value="1" <?php echo $_SESSION['filter']['page'] == 1 ? 'selected="selected"' : ''; ?>>GT - Work - Play</option>
            <option value="2" <?php echo $_SESSION['filter']['page'] == 2 ? 'selected="selected"' : ''; ?>>GT - Giá trị cốt lõi</option>
            <option value="4" <?php echo $_SESSION['filter']['page'] == 4 ? 'selected="selected"' : ''; ?>>GT - Sứ mệnh</option>
            <option value="3" <?php echo $_SESSION['filter']['page'] == 3 ? 'selected="selected"' : ''; ?>>SP - Game</option>
            <option value="5" <?php echo $_SESSION['filter']['page'] == 5 ? 'selected="selected"' : ''; ?>>SP - Niềm vui</option>
            <option value="6" <?php echo $_SESSION['filter']['page'] == 6 ? 'selected="selected"' : ''; ?>>SP - Giới thiệu MEM</option>
			<option value="7" <?php echo $_SESSION['filter']['page'] == 7 ? 'selected="selected"' : ''; ?>>SP - Lịch sử MEM</option>
        </select>
        <input type="submit" name="ok" class="btn btn-primary btnoption" value="Tìm kiếm"/>
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center">Tiêu đề</th>
                    <th align="center" width="120px">Hình ảnh</th>
                    <th align="center" width="120px">Trang</th>
                    <th align="center" width="120px">Order</th>
                    <th align="center" width="120px">Chức năng</th>
                    <th align="center" width="100px">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $pagesa = array('1'=>'GT - Work - Play','2'=>'GT - Giá trị cốt lõi','3'=>'SP - Game','4'=>'GT - Sứ mệnh','5'=>'SP - Niềm vui','6'=>'SP - Giới thiệu MEM','7'=>'SP - Lịch sử MEM');
                    if($_GET['page']>0){
                        $page = '&page='.$_GET['page'];
                    }
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                            $title = json_decode($v['title'],true);
                            $summary = json_decode($v['summary'],true);
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid" name="cid[]"></td>
                    <td><?php echo $title['title_'.$defaultLanguage['code']];?></td>
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
                            echo $pagesa[$v['page']];
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