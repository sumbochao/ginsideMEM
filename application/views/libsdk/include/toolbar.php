<div class="header_toolbar">
    <div class="header_title icon48-install"><?php echo $title;?></div>
    <div class="toolbar">
        <?php
          
            $lnkAdd = base_url()."?control=".$_GET['control']."&func=add";
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
                            <a href="javascript:void(0);" onclick="calljavascript(0);">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Lưu</div>
                            </a>
                        </div>';
            $btnCopy = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(5);">
                                <img src="'.base_url().'assets/img/icon-32-save.png"/>
                                <div>Copy</div>
                            </a>
                        </div>';
			$btnExcel = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(6);">
                                <img src="'.base_url().'assets/img/icon/excel.png"/>
                                <div>Xuất Excel</div>
                            </a>
                        </div>';
			$btnExcel1 = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(1);">
                                <img src="'.base_url().'assets/img/icon/excel1.png" style="width:20px;height:20px"/>
                                <div>Xuất Excel</div>
                            </a>
                        </div>';

            $lnkCancel = base_url()."?control=".$_GET['control']."&func=index";
            $btnCancelAdd = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(5);">
                                <img src="'.base_url().'assets/img/back.png" style="width:32px;height:32px"/>
                                <div>Trở về</div>
                            </a>
                        </div>';
			 $btnCancelEdit = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(7);">
                                <img src="'.base_url().'assets/img/back.png" style="width:32px;height:32px"/>
                                <div>Trở về</div>
                            </a>
                        </div>';
			 $btnCancelCopy = '<div class="toolbar-button">
                            <a href="'.$lnkCancel.'">
                                <img src="'.base_url().'assets/img/back.png" style="width:32px;height:32px"/>
                                <div>Trở về</div>
                            </a>
                        </div>';
        ?>
        <?php
            switch ($_GET['func']){
                case 'index':
					$strButton = $btnExcel1.'  '.$btnAdd.' '.$btnDelete;
                    break;
                case 'add':
                    $strButton = $btnSave.' '.$btnCancelAdd;
                    break;
				case 'copyedit':
                    $strButton = $btnSave.' '.$btnCancelCopy;
                    break;
                case 'edit':
                    $strButton = $btnExcel.'  '.$btnCopy.'  '.$btnSave.' '.$btnCancelEdit;
                    break;
                    
            }
            echo $strButton;
        ?>
    </div>
    <div class="clr"></div>
</div>