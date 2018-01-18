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
	vertical-align:top;
}
#top{
	display:none !important;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1100px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
    <?php //include_once 'include/toolbar.php'; ?>
</div> <!--content_form-->

 <div id="adminfieldset">
    <div class="adminheader">Tạo Game Check List</div>
        <div class="rows">	
         <form id="appFormGame" name="appFormGame" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=addgame&id_template=<?php echo intval($_GET['id_template']); ?>" method="post" >
         <select name="cbo_game" id="cbo_game" class="chosen-select" tabindex="2" data-placeholder="Chọn game">
                <option value="0"> -- Chọn Game -- </option>
                <?php
                    if(count($loadgame)>0){
                        foreach($loadgame as $v){
                ?>
                <option value="<?php echo $v['service_id'];?>"><?php echo $v['app_fullname'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
             <input type="button" onclick="calljavascript(3);" value="Add Game" class="btnB btn-primary"/> 			 <div class="rows">
                	<div id="mess" style="color:#008000;font-size:20px;font-weight:bold">
					<?php echo base64_decode($_GET['mess']); ?>
                    </div>
             </div>
         </form>
        </div>
    <div class="clr"></div>
</div>
 <div id="adminfieldset">
    <div class="adminheader"><a href="javascript:void(0);">Danh sách Game đang sử dụng</a></div>
    <form id="appFormRemove" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=removegame&id_template=<?php echo intval($_GET['id_template']); ?>" method="post" name="appFormRemove" enctype="multipart/form-data">
        <div class="rows">	
        <table>
        	<thead>
            	<th>Game</th>
                <th>Checklist</th>
                <th>Edit</th>
            </thead>
            <?php
                    if(count($listGameChecklist)>0 && !empty($listGameChecklist)){
                        foreach($listGameChecklist as $v){
                ?>
                <tr>
                	<td><?php echo $loadgame[$v['id_game']]['app_fullname']; ?></td>
                    <td><a href="<?php echo base_url();?>?control=gamechecklist&func=index&id_template=<?php echo intval($_GET['id_template']); ?>&id_game=<?php echo $v['id_game']; ?>" target="_blank" style="color:#E81287;text-decoration:none;">Checklist</a></td>
                    <td><a href="<?php echo base_url();?>?control=categametemplate&func=index&id_game=<?php echo $v['id_game']; ?>" target="_blank" style="color:#00F;text-decoration:none;">Edit</a></td>
                </tr>
                 <?php
                        }
                    }
                ?>
        </table>
         <?php
                    if(count($listGameChecklist)>0 && !empty($listGameChecklist)){
                        foreach($listGameChecklist as $v){
                ?>
                <!--<input type="checkbox" name="chk_game[<?php echo $v['id_game'];?>]" id="chk_game_<?php echo $v['id_game'];?>" value="<?php echo $v['id_game'];?>" style="margin-left:10px;" />-->
				- <a href="<?php echo base_url();?>?control=gamechecklist&func=index&id_template=<?php echo intval($_GET['id_template']); ?>&id_game=<?php echo $v['id_game']; ?>" target="_blank" style="color:#E81287;text-decoration:none;">Checklist - <?php echo $loadgame[$v['id_game']]['app_fullname']; ?></a> | 
                <a href="<?php echo base_url();?>?control=categametemplate&func=index&id_game=<?php echo $v['id_game']; ?>" target="_blank" style="color:#00F;text-decoration:none;">Edit :<?php echo $loadgame[$v['id_game']]['app_fullname']; ?></a>
                <?php
                        }
                    }
                ?>
        </div>
        <!--<div class="rows" style="margin-top:15px;margin-left:15px;">
        	<input type="button" onclick="calljavascript(4);" value="Remove Game" style="font-size:10px;color:#98225D"/>
            
        </div>-->
        <!--<div class="rows">
        <label style="width:100%;margin-left:15px;">Click vào ô checkbox sau đó nhấn nút "Remove Game" sẽ xóa game khỏi Template này. Click vào tên game để Checklist kết quả</label>
        </div>-->
    </form>
    <div class="clr"></div>
</div>

<div id="adminfieldset">
    <div class="adminheader"><label for="menu_group_id" style="font-size:16px;color: #569688;width:100%;">BIỂU MẪU CHECKLIST : <?php echo $slbTemp[intval($_GET['id_template'])]['template_name']; ?></label></div>
   <div class="rows"> 
<form id="appForm" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>&id_template=<?php echo intval($_GET['id_template']); ?>&type=filter" method="post" name="appForm" enctype="multipart/form-data">
       <div class="filter" style="margin-top:10px;margin-left:15px;display:none;">
            <select name="cbo_categories" id="cbo_categories" data-placeholder="Chọn Template">
                <option value=""> --- Lọc Hạng mục --- </option>
                <?php
                    if(count($listCategories)>0 && $listCategories != NULL){
                        foreach($listCategories as $v){
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo $_POST['cbo_categories']==$v['id']?'selected="selected"':'';?> ><?php echo $v['names'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <input type="button" onclick="calljavascript(2);" value="Tìm" class="btnB btn-primary"/> 
            
       </div> <!--filter-->
</form>
		
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="300px"><a href="<?php echo base_url();?>?control=categories&func=index&cbo_template=<?php echo $_GET['id_template'];?>" target="_blank">Hạng mục</a></th>
                    <th align="center" width="300px">Yêu cầu</th>
                    <th align="center" width="300px">Loại</th>
                    <th align="center" width="300px">Yêu cầu mong muốn</th>
                    <th align="center" width="200px">Nhóm chính</th>
                    <th align="center" width="200px">Nhóm Hỗ trợ</th>
                    <!--<th align="center" width="170px">Check <br />Client IOS</th>
                    <th align="center" width="170px">Check <br />Client Android</th>
                    <th align="center" width="170px">Check <br />Client WinPhone</th>
                    <th align="center" width="170px">Check <br />None Client</th>-->
                    <!--<th align="center" width="70px">Date check</th>
                    <th align="center" width="70px">User check</th>-->
                    <th align="center" width="70px">User</th>
                    <!--<th align="center" width="70px">Notes</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
					include("class.php");
					//load hạng mục cha
					$catego = new ViewGroup(0,0);
					if(count($categories)>0 && $categories != NULL){
						foreach($categories as $c=>$k){
				?>
                	<tr>
                    	<td colspan="7" style="background-color:#3A584C;">
                        <a href="javascript:void(0);" style="color:#fff;text-decoration:none;" onclick="showclass(<?php echo $k['id'];?>);">
						<b><?php echo mb_convert_case($k['names'], MB_CASE_UPPER, "UTF-8");?></b>
                        </a>
                        </td>
                    </tr>
                <?php
						include("listcate.php");
						}//end for
					}//end if
						
                ?>
                
            </tbody>
        </table>
    </form>
    </div> <!--rows-->
    <div class="clr"></div>
 </div> <!--adminfieldset-->
            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_template.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function showclass(id){
	$('.row_tab_' + id).fadeToggle("fast", "linear");
}
function showRequest(id){
	$('.res_row_tab_' + id).fadeToggle("fast", "linear");
}
function calljavascript(i,id){
		switch(i){
			 case 0: // xóa
			 	deleteitem(id,'<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>')
			 
			 break;
			 case 2: //tim kiem
			 	document.forms.appForm.submit();
			 break;
			 case 3: //add game
			 	var _g = $('#cbo_game').val();
				if(_g==0){
					alert('Vui lòng chọn game');
					$('#cbo_game').focus();
					return;
				}
			 	document.forms.appFormGame.submit();
			 break;
			  case 4: //xóa game
			 	c=confirm('bạn có muốn Remove những game này ra khỏi Template');
				if(c){
					document.forms.appFormRemove.submit();
				}
			 	
			 break;
			 case 5:
			 	window.location.href='<?php echo base_url();?>?control=groupuser&func=userongroup&id_group=' + id;
			 break;
			 default:
			 break;
		}
	}
</script>
