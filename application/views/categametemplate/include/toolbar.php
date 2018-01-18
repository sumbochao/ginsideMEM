<div class="header_toolbar">
    <div class="header_title icon48-install"><?php echo $title;?></div>
    <div class="toolbar">
        <?php
          
            $lnkAdd = base_url()."?control=".$_GET['control']."&func=add&id_game=".intval($_GET['id_game'])."&id_template=".$_GET['id_template'];
            $btnAdd = '<div class="toolbar-button">
                            <a href="'.$lnkAdd.'">
                                <img src="'.base_url().'assets/img/icon/cong.png"/>
                                <div>Thêm</div>
                            </a>
                        </div>';
            $lnkDelete = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=delete&type=multi')";
            $btnDelete = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="checkdelall(\'appForm\',\''. base_url().'?control='.$_GET['control'].'&func=delete&type=multi'.'\')">
                                <img src="'.base_url().'assets/img/icon-32-delete.png" style="width:20px;height:20px;"/>
                                <div>Xóa</div>
                            </a>
                        </div>';
            $btnSave = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(1);">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu</div>
                            </a>
                        </div>';
			$btnSaveEdit = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(1,1);">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu</div>
                            </a>
                        </div>';

            $lnkCancel = base_url()."?control=".$_GET['control']."&func=index&id_game=".intval($_GET['id_game'])."&id_template=".$_GET['id_template'];
            $btnCancel = '<div class="toolbar-button">
                            <a href="'.$lnkCancel.'">
                                <img src="'.base_url().'assets/img/back.png" style="width:32px;height:32px"/>
                                <div>Trở về</div>
                            </a>
                        </div>';
			 $btnSaveChecklist = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(1);">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu</div>
                            </a>
                        </div>';
			$lnkBackHome = base_url()."?control=template&func=index";
            $btnBackHome = '<div class="toolbar-button">
                            <a href="'.$lnkBackHome.'">
                                <img src="'.base_url().'assets/img/back.png" style="width:20px;height:20px"/>
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
                    $strButton = $btnSave.' '.$btnCancel;
                    break;
                case 'edit':
                    $strButton = $btnSave.' '.$btnCancel;
					break;
				 case 'checklist':
                    $strButton = $btnSaveChecklist.'  '.$btnCancel;
                    break;
                    
            }
            echo $strButton;
        ?>
    </div>
    <div class="clr"></div>
</div>