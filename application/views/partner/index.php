<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
        	<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="Nhập tên đối tác ..." title="Nhập tên đối tác ..." maxlength="20" style="width:350px;"/>
            <?php 
                if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                }else{
                    $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
                }
            ?>
            <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>   
        </div>
        
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <th align="center" width="50px">STT</th>
                    <th align="center" width="150px">Holder</th>
                     <th align="center" width="350px">Ghi chú</th>
                    <th align="center" width="200px">Ngày</th>
                    <th align="center" width="100px">User</th>
                    <th align="center" width="100px">Chức năng</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
				$i=0;
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
							$i++;
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid[<?php echo $v['id'];?>]" name="cid[]"></td>
                    <td><?php echo $i;?></td>
                    <td><strong style="color:#900;"><?php echo $v['partner'];?></strong></td>
                    <td><?php echo $v['notes'];?></td>
                    <td><?php echo $v['datecreates'];?></td>
               		 <td><?php echo $slbUser[$v['userid']]['username']; ?></td>	
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id']."&partner=".$v['partner']."&link_url=".base64_encode($v['link_url'])."&notes=".base64_encode(stripslashes($v['notes']))."".$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
							if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            	           		 echo $btnEdit.'   '.$btnDelete;
							}
                        ?>
                        
                        
                    </td>
                    
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

function checkdelall(){
	var myForm = document.forms.appForm;
	var myControls = myForm.elements['cid[]'];
	var isok=false;
	for (var i = 0; i < myControls.length; i++) {
		var aControl = myControls[i];
		if(aControl.checked){
			isok=true;
		}
	}
	if(!isok){
		alert('Vui lòng chọn dòng cần xóa'); return false;
	}else{
		c=confirm('Bạn có muốn xóa !');
		if(c){
			onSubmitForm('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=delete&type=multi"; ?>');
		return true;
		}
	}
}

</script>