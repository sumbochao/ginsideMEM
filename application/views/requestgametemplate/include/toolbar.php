<div class="header_toolbar">
    <div class="header_title icon48-install"><?php echo $title. " Game: <strong style='color:#DA00FF'>".$loadgame[$_GET['id_game']]['app_fullname']."</strong>";?></div>
    <div class="toolbar">
        <?php
          
            $lnkAdd = base_url()."?control=".$_GET['control']."&func=add&id_categories=".$_GET['id_categories']."&id_template=".$_GET['id_template'];
            $btnAdd = '<div class="toolbar-button">
                            <a href="javascript:void(0);" onclick="calljavascript(1,0);">
                                <img src="'.base_url().'assets/img/icon/cong.png"/>
                                <div>Thêm</div>
                            </a>
                        </div>';
			$btnAddPlus = '<div class="toolbar-button">
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

            $lnkCancel = base_url()."?control=".$_GET['control']."&func=index&id_categories=".$_GET['id_categories']."&id_game=".$_GET['id_game'];
            $btnCancel = '<div class="toolbar-button">
                            <a href="'.$lnkCancel.'">
                                <img src="'.base_url().'assets/img/back.png" style="width:32px;height:32px"/>
                                <div>Trở về</div>
                            </a>
                        </div>';
			$lnkBack = base_url()."?control=".$_GET['control']."&func=index&id_game=".$_GET['id_game']."&id_categories=".$_GET['id_categories'];
            $btnBack = '<div class="toolbar-button">
                            <a href="'.$lnkBack.'">
                                <img src="'.base_url().'assets/img/back.png" style="width:32px;height:32px"/>
                                <div>Trở về</div>
                            </a>
                        </div>';
			$lnkBackHome = base_url()."?control=categametemplate&func=index&id_game=".$_GET['id_game'];
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
                    $strButton = $btnSave.' '.$btnBack;
                    break;
                case 'edit':
                    $strButton = $btnAddPlus.'  '.$btnSave.' '.$btnCancel;
                    break;
                    
            }
            echo $strButton;
        ?>
    </div>
    <div class="clr"></div>
</div>