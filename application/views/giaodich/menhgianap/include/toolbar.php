<div class="header_toolbar">
    <div class="header_title icon48-install"><?php echo $title;?></div>
    <div class="toolbar">
        <?php
            if($_GET['page']>0){
                $page = '&page='.$_GET['page'];
            }
            if(!empty($_GET['app'])){
                $game = '&app='.$_GET['app'];
            }
            $lnkSort = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=sort".$game.$page."')";
            $btnSort = '<div class="toolbar-button">
                            <a href="'.$lnkSort.'">
                                <img src="'.base_url().'assets/img/icon-32-sort.png"/>
                                <div>Sắp xếp</div>
                            </a>
                        </div>';
            
            $lnkActive = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=status&type=multi&s=true".$game.$page."')";
            $btnActive = '<div class="toolbar-button">
                            <a href="'.$lnkActive.'">
                                <img src="'.base_url().'assets/img/icon-32-active.png"/>
                                <div>Bật</div>
                            </a>
                        </div>';
            
            $lnkInActive = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=status&type=multi&s=false".$game.$page."')";
            $btnInActive = '<div class="toolbar-button">
                            <a href="'.$lnkInActive.'">
                                <img src="'.base_url().'assets/img/icon-32-inactive.png"/>
                                <div>Tắt</div>
                            </a>
                        </div>';
            if(!empty($_GET['app'])){
                $lnkAdd = base_url()."?control=".$_GET['control']."&func=add&module=all".$game;
                $btnAdd = '<div class="toolbar-button">
                            <a href="'.$lnkAdd.'">
                                <img src="'.base_url().'assets/img/icon-32-default.png"/>
                                <div>Thêm</div>
                            </a>
                        </div>';
            }
            $lnkDelete = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=delete&type=multi".$game."')";
            $btnDelete = '<div class="toolbar-button">
                            <a href="'.$lnkDelete.'" onclick="if(!window.confirm(\'Bạn có muốn xóa những dữ liệu này không ?\')) return false;">
                                <img src="'.base_url().'assets/img/icon-32-delete.png"/>
                                <div>Xóa</div>
                            </a>
                        </div>';
            if($_GET['id']>0){
                $id = '&id='.$_GET['id'];
            }
            $lnkSave = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func'].'&module=all'.$id.$game.$page."&types=1')";
            $btnSave = '<div class="toolbar-button">
                            <a href="'.$lnkSave.'">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu</div>
                            </a>
                        </div>';
            $lnkSaveClose = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func'].'&module=all'.$id.$game.$page."')";
            $btnSaveClose = '<div class="toolbar-button">
                            <a href="'.$lnkSaveClose.'">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu đóng</div>
                            </a>
                        </div>';
            
            $lnkCancel = base_url()."?control=".$_GET['control']."&func=index&module=all".$game.$page;
            $btnCancel = '<div class="toolbar-button">
                            <a href="'.$lnkCancel.'">
                                <img src="'.base_url().'assets/img/icon-32-cancel.png"/>
                                <div>Trở về</div>
                            </a>
                        </div>';
        ?>
        <?php
            switch ($_GET['func']){
                case 'index':
                    $strButton = $btnAdd;
                    break;
                case 'add':
                    $strButton = $btnSaveClose.' '.$btnCancel;
                    break;
                case 'edit':
                    $strButton = $btnSaveClose.' '.$btnCancel;
                    break;
                    
            }
            echo $strButton;
        ?>
    </div>
    <div class="clr"></div>
</div>