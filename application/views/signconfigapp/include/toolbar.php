<div class="header_toolbar">
    <div class="header_title icon48-install"><?php echo $title;?></div>
    <div class="toolbar">
        <?php
            if($_GET['page']>0){
                $page = '&page='.$_GET['page'];
            }
            $lnkSort = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=sort".$page."')";
            $btnSort = '<div class="toolbar-button">
                            <a href="'.$lnkSort.'">
                                <img src="'.base_url().'assets/img/icon-32-sort.png"/>
                                <div>Sắp xếp</div>
                            </a>
                        </div>';
            
            $lnkActive = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=status&type=multi&s=1".$page."')";
            $btnActive = '<div class="toolbar-button">
                            <a href="'.$lnkActive.'">
                                <img src="'.base_url().'assets/img/icon-32-active.png"/>
                                <div>Bật</div>
                            </a>
                        </div>';
            
            $lnkInActive = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=status&type=multi&s=0".$page."')";
            $btnInActive = '<div class="toolbar-button">
                            <a href="'.$lnkInActive.'">
                                <img src="'.base_url().'assets/img/icon-32-inactive.png"/>
                                <div>Tắt</div>
                            </a>
                        </div>';
            
            $lnkAdd = base_url()."?control=".$_GET['control']."&func=add";
            $btnAdd = '<div class="toolbar-button">
                            <a href="'.$lnkAdd.'">
                                <img src="'.base_url().'assets/img/icon-32-default.png"/>
                                <div>Thêm</div>
                            </a>
                        </div>';
            $lnkDelete = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=delete&type=multi')";
            $btnDelete = '<div class="toolbar-button">
                            <a href="'.$lnkDelete.'" onclick="if(!window.confirm(\'Bạn có muốn xóa những dữ liệu này không ?\')) return false;">
                                <img src="'.base_url().'assets/img/icon-32-delete.png"/>
                                <div>Xóa</div>
                            </a>
                        </div>';
            if($_GET['id']>0){
                $id = '&id='.$_GET['id'];
            }
            $lnkSave = "javascript:checknull(".$_GET['id'].");";
            $btnSave = '<div class="toolbar-button">
                            <a href="'.$lnkSave.'">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu</div>
                            </a>
                        </div>';
			$lnkSaveCloseAdd = "javascript:checknull();";
            $btnSaveCloseAdd = '<div class="toolbar-button">
                            <a href="'.$lnkSaveCloseAdd.'">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu</div>
                            </a>
                        </div>';
            $lnkSaveClose = "javascript:checknull(".$_GET['id'].");";
            $btnSaveClose = '<div class="toolbar-button">
                            <a href="'.$lnkSaveClose.'">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu</div>
                            </a>
                        </div>';
            
            $lnkCancel = base_url()."?control=".$_GET['control']."&func=index";
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
                    //$strButton = $btnSort.' '.$btnActive.' '.$btnInActive.' '.$btnAdd.' '.$btnDelete;
					$strButton = $btnAdd.' '.$btnDelete;
                    break;
                case 'add':
                    $strButton = $btnSaveCloseAdd.' '.$btnCancel;
                    break;
                case 'edit':
                    $strButton = $btnSaveClose.' '.$btnCancel;
                    break;
                    
            }
			if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
           	 echo $strButton;
			}
        ?>
    </div>
    <div class="clr"></div>
</div>