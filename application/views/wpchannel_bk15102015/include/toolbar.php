<div class="header_toolbar">
    <div class="header_title icon48-install"><?php echo $title;?></div>
    <div class="toolbar">
        <?php
            if($_GET['page']>0){
                $page = '&page='.$_GET['page'];
            }
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
            $lnkCancel = base_url()."?control=".$_GET['control']."&func=index";
            $btnCancel = '<div class="toolbar-button">
                            <a href="'.$lnkCancel.'">
                                <img src="'.base_url().'assets/img/back.png" style="width:32px;height:32px"/>
                                <div>Trở về</div>
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
            $lnknExport = "javascript:checknullchennal();";
            $btnExport = '<div class="toolbar-button">
                            <a href="'.$lnknExport.'">
                                <img src="'.base_url().'assets/img/icon-48-cpanel.png" width="32"/>
                                <div>Lưu lại</div>
                            </a>
                        </div>';
		
			$lnknEdit = "javascript:checkdatatext();";
            $btnEdit = '<div class="toolbar-button">
                            <a href="'.$lnknEdit.'">
                                <img src="'.base_url().'assets/img/icon-48-cpanel.png" width="32"/>
                                <div>Lưu lại</div>
                            </a>
                        </div>';
        ?>
        <?php
            switch ($_GET['func']){
                case 'index':
                    //$strButton = $btnAdd.' '.$btnActive.' '.$btnInActive.' '.$btnDelete;
					$strButton = $btnAdd;
                    break;
                case 'add':
                    $strButton = $btnExport.' '.$btnCancel;
                    break;
				 case 'edit':
                    $strButton = $btnEdit.' '.$btnCancel;
                    break;
                    
            }
            //echo $strButton;
        ?>
    </div>
    <div class="clr"></div>
</div>