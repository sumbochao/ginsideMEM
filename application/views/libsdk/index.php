<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
        	<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="Nhập sdk ..." title="Nhập sdk ..." maxlength="20" style="width:150px;"/>
            
            <select name="cbo_game" id="cbo_game" class="chosen-select" tabindex="2" data-placeholder="Chọn game">
                <option value="0">Chọn Game</option>
                <?php
                    if(count($slbGame)>0){
                        foreach($slbGame as $v){
                ?>
                <option value="<?php echo $v['service'];?>" <?php echo ($_POST['cbo_game']==$v['service']) || ($_GET['service']==$v['service'])?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            
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
            <input type="button" onclick="calljavascript(2);" value="Tìm" class="btnB btn-primary"/>   
        </div>
        
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px"><input type="checkbox" name="checkbox" onclick="checkedAll();"/></th>
                    <!--<th align="center" width="50px">STT</th>-->
                    <th align="center" width="150px">Game Code</th>
                    <th align="center" width="150px">Game Name</th>
                    <th align="center" width="150px">Platform</th>
                     <th align="center" width="150px">SDK Version</th> 
                     <th align="center" width="450px">PackageName</th>
                     <th align="center" width="450px">Date</th>
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
                    <!--<td><?php echo $i;?></td>-->
                    <td><strong style="color:#900;"><?php echo $v['game_code'];?></strong></td>
                    <td><?php echo $v['game_name'];?></td>
                    <td><?php echo $v['platform'];?></td>
                    <td><?php echo $v['sdkversion'];?></td>
                    <td><?php echo $v['package_name'];?></td>
                    <td><?php echo $v['datecreate'];?></td>
               		<td><?php echo $slbUser[$v['userlog']]['username']; ?></td>	
                  	<td>
                    <a href="<?php echo base_url()."?control=".$_GET['control']."&func=copyedit&id=".$v['id'] ?>" title="Copy"><img border="0" title="Copy" src="<?php echo base_url().'assets/img/icon/copy.png'; ?>"></a>
                    
                    	<a href="<?php echo base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id'] ?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url().'assets/img/icon_edit.png'; ?>"></a>
                        
<a onclick="checkdel('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'] ?>')" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url().'assets/img/icon_del.png'; ?>"></a> 
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
<script src="<?php echo base_url('assets/js/signscript/js_libsdk.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
(new TableDnD).init("tblsort");
//checkdelall('appForm',<?php echo base_url()."?control=".$_GET['control']."&func=delete&type=multi"; ?>);
function calljavascript(i){
		switch(i){
			 case 1: // xuất excel nhiều rows
			  var obj=document.forms.appForm;
			  var c=obj.elements['cid[]'];
			  if(typeof(c)==='undefined'){
			   	alert('Không có đối tượng Export file');
			  }else{
				exportExcelAll('<?php echo base_url()."?control=libsdk&func=exportexcel&type=all"; ?>');
			  }
			 break;
			 case 2: //tim kiếm
			    game=$('#cbo_game').val();
			 	if(game==0){
					alert('Vui lòng chọn game!');
					$('#cbo_game').focus();
					return;
				}
				onSubmitForm('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter"; ?>')
			 break;
			 default:
			 	
			 break;
		}
	}
</script>