<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
	
</script>
<style>
.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:1066px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
        <?php include_once 'include/toolbar.php'; include('class.php'); ?>
</div> <!--content_form-->
        <form id="appForm" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>&id_game=<?php echo $_GET['id_game'];?>&type=filter" method="post" name="appForm" enctype="multipart/form-data">
       <div class="filter">
        <!--<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="Hạng mục ..." title="Hạng mục ..." maxlength="20" style="width:550px;"/>-->
       		<select name="cbo_group" id="cbo_group">
            	<option value="">-- Group --</option>
                <?php 
				if(count($Group)>0 && !empty($Group)){
                        foreach($Group as $i=>$g){
							if($g['id']!=-1){
								//k hien thi nhom admin
				?>
                <option value="<?php echo $g['id'];?>" <?php echo $_POST['cbo_group']==$g['id']?"selected":"";?> ><?php echo $g['names'];?></option>
                <?php }}} ?>
            </select>
            <input type="button" onclick="calljavascript(2);" value="Tìm" class="btnB btn-primary"/>
            
       </div> <!--filter-->
       </form>
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
         <!--<input type="submit" value="Tranfer" class="btnB btn-primary" name="btn_tranfer"/>-->
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr style="background-color:#8A98C7;">
                	<th align="center" width="90px">Chức năng</th>
                    <th align="center" width="300px">Hạng mục <br />
                    GAME:<strong style="color:#906;"><?php echo $loadgame[intval($_GET['id_game'])]['app_fullname'] ?></strong></th>
                    <th width="100px">Nhóm thực hiện</th>
                    <th align="center" width="50px">Trạng thái</th>
                    <th align="center" width="60px">Yêu cầu <br />hạng mục</th>
                   <th align="center" width="30px">Sort</th>
                    <th align="center" width="50px">Date</th>
                   	<th align="center" width="50px">User</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					$img_on="<img boder='0' src='".base_url()."assets/img/tick.png'>";
					$img_off="<img boder='0' src='".base_url()."assets/img/tick2.png'>";
					$i=0;
					$static=0;
                    if(count($listItems)>0 && !empty($listItems)){
                        foreach($listItems as $j=>$v){
							$i++;
							$child=$cate->ShowCateChild($v['id_game'],$v['id']);
					
							
                ?>
                <tr>
                	<td>
                    <a href="<?php echo base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id']."&id_game=".$v['id_game']."&id_template=".$_GET['id_template'] ?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url().'assets/img/icon_edit.png'; ?>"></a>
                        
<a onclick="checkdel('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id']."&id_game=".$v['id_game']."&id_template=".$_GET['id_template'] ?>')" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url().'assets/img/icon_del.png'; ?>"></a> 
                    </td>
                    
                    <td><b>
                    <a href="javascript:void(0);" id="showmenu" onclick="showclass(<?php echo $v['id'] ?>);" style="color:#693;text-decoration:none;">
					<?php echo mb_convert_case($v['names'], MB_CASE_UPPER, "UTF-8");?>
                    </a>
                    </b></td>
                    <td><!--Nhóm thực hiện--></td>
       			    <td>
                    <div id="divstatus_<?php echo $v['id'] ?>">
                    <a href="javascript:void(0)" onclick="UpStatusCate(<?php echo $v['id'] ?>,<?php echo $v['status']; ?>);"><?php echo $v['status']==0?"<strong style='color:green'>On</strong>":"<strong style='color:red'>Off</strong>";?></a>
                    </div>
                    </td>
                    <td>
                    <!--<a href="<?php echo base_url()."?control=request&func=index&id_categories=".$v['id']."&id_template=".$v['id_template'] ?>">Xem</a>-->
                    </td>
                   <td><input type="text" name="sort[<?php echo $v['id'] ?>]" id="sort_<?php echo $v['id'] ?>" value="<?php echo $v['order'] ?>" style="width:35px;background-color:#0CF;color:#F00;font-size:16px" onkeypress="calljavascript(3,<?php echo $v['id'] ?>);" onkeyup="calljavascript(3,<?php echo $v['id'] ?>);" />
                   <div id="messsort_<?php echo $v['id'] ?>" style="font-size:9px;color:#900"></div>
                   </td>
                    <td><?php echo $v['datecreate'];?></td>
                    <td><?php echo $slbUser[$v['userlog']]['username'];?></td>
                </tr>
                <?php
						$static=$v['id_template'];
							//load cấp hạng mục con
							if(count($child)>0){
									include("listcate.php");
							}//end if
					
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
    </form>
         
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_categories_new.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
//(new TableDnD).init("tblsort");
function showclass(id){
	$('.child_' + id).fadeToggle("fast", "linear");
}
function calljavascript(i,id){
		switch(i){
			 case 2: //tim kiem
			 	document.forms.appForm.submit();
			 	//window.location.href='<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>&type=filter';
			 break;
			 case 3:
			 	Updatesort(id,document.getElementById('sort_' + id).value);
			 break;
			 default:
			 break;
		}
	}
</script>
