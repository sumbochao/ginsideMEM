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
                            <a href="javascript:void(0);" onclick="checkdelall();">
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
            /*$lnknExport = "javascript:onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."')";*/
			$lnknExport = "javascript:checknullchennal();";
            $btnExport = '<div class="toolbar-button">
                            <a href="'.$lnknExport.'">
                                <img src="'.base_url().'assets/img/icon-48-cpanel.png" width="32"/>
                                <div>SAVE</div>
                            </a>
                        </div>';
			//new 
			 $lnkAddPlus = base_url()."?control=".$_GET['control']."&func=add";
            $btnAddPlus = '<div class="toolbar-button">
                            <a href="'.$lnkAddPlus.'">
                                <img src="'.base_url().'assets/img/icon/addicon.png"/>
                                <div>Tạo mới</div>
                            </a>
                        </div>';
        ?>
        <?php
            switch ($_GET['func']){
                case 'index':
                    //$strButton = $btnAdd.' '.$btnActive.' '.$btnInActive.' '.$btnDelete;
					if((@in_array($_GET['control'].'-add', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
						$strButton = $btnAddPlus;
					}
                    break;
                case 'add':
                    $strButton = $btnCancel;
                    break;
				case 'edit':
                    $strButton = $btnCancel;
                    break;
				case 'history':
                    $strButton = $btnCancel;
                    break;
                    
            }
            echo $strButton;
        ?>
    </div>
    <div class="clr"></div>
</div>