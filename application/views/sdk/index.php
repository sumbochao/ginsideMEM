<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
        	<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="Nhập sdk ..." title="Nhập sdk ..." maxlength="20" style="width:150px;"/>
            <select name="cbo_platform" id="cbo_platform">
                <option value="0">Chọn Platform</option>
                <?php
                    if(count($loadplatform)>0){
                        foreach($loadplatform as $key=>$value){
                ?>
                <option value="<?php echo $value;?>" <?php echo $_POST['cbo_platform']==$value?'selected="selected"':'';?>><?php echo $value;?></option>
                <?php
                        }
                    }
                ?>
            </select>
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
                    <th align="center" width="50px">ID</th>
                    <th align="center" width="150px">SDK Version</th>
                    <th align="center" width="150px">Platform</th>
                     <th align="center" width="150px">Date update</th> 
                     <th align="center" width="450px">Ghi chú</th>
                    <th align="center" width="100px">Duyệt</th>
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
                    <td><?php echo $v['id'];?></td>
                    <td><strong style="color:#900;"><?php echo $v['versions'];?></strong></td>
                    <td><?php echo $v['platform'];?></td>
                    <td><?php echo $v['datecreates'];?></td>
                    <td><?php echo $v['notes'];?></td>
                    <td>
                        <?php
                            if($_GET['page']>0){
                                $page = '&page='.$_GET['page'];
                            }
                            $imgActive = ($v['status']==1)?'active.png':'inactive.png';
                            
                            if((@in_array($_GET['control'].'-status', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                                $lnkActive = base_url()."?control=".$_GET['control']."&func=status&id=".$v['id']."&s=".$v['status'].$page;
                            }else{
                                $lnkActive = 'javascript:;';
                                $alert = 'onclick="alert(\'Bạn không có quyền truy cập chức năng này!\');"';
                            }
                            echo '<a href="'.$lnkActive.'" '.$alert.' title="Duyệt">
                                    <img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                        
                    </td>
					<td><?php echo $slbUser[$v['userid']]['username']; ?></td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id']."&sdk=".$v['versions']."&platform=".$v['platform']."&status=".$v['status']."&notes=".base64_encode($v['notes'])."".$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa '.$v['name'].' này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
							if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
            	                echo $btnEdit.' || '.$btnDelete;
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