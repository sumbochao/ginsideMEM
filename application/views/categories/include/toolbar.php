<div class="header_toolbar">
    <div class="header_title icon48-install"><?php echo $title;?></div>
    <div class="toolbar">
        <?php
			if($_GET['id_template']>0){
				$id_template = $_GET['id_template'];
			}
			if($_POST['id_template']>0){
				$id_template = $_POST['id_template'];
			}
            $lnkAdd = base_url()."?control=".$_GET['control']."&func=add&id_template=".$id_template;
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
            if($_GET['id']>0){
                $id = '&id='.$_GET['id'];
            }
			if($_GET['id_categories']>0){
                $id_categories = '&id_categories='.$_GET['id_categories'];
            }
            $lnkSave = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func'].$id."&id_template=".$id_template.$id_categories."')";
            $btnSave = '<div class="toolbar-button">
                            <a href="'.$lnkSave.'">
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

            $lnkCancel = base_url()."?control=".$_GET['control']."&func=index&id_template=".$_GET['id_template'];
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
					$strButton = $btnAdd. '    '. $btnBackHome;
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