<!--fancybox-->
<script src="<?php echo base_url('assets/fancybox/lib/jquery-1.10.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/source/jquery.fancybox.js?v=2.1.5'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/jquery.fancybox.css?v=2.1.5'); ?>" type="text/css" media="screen"/>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5'); ?>" type="text/css" media="screen"/>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7'); ?>" type="text/css" media="screen"/>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6'); ?>"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$(".various_main").fancybox({
				title:'GroupMain',
				maxWidth	: 500,
				maxHeight	: 500,
				fitToView	: false,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
			$(".various_support").fancybox({
				title:'GroupSupport',
				maxWidth	: 500,
				maxHeight	: 500,
				fitToView	: false,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
	</script>
<!--end fancybox-->
<style>
.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
}

.textinputplus{
	border:none !important;
}
</style>
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
<div class="loading_warning" style="text-align:center">
<img src="<?php echo base_url('assets/img/icon/loading_sign.gif'); ?>" />
</div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1100px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
     <?php //include_once 'include/toolbar.php';
		 include("class.php");
			//load hạng mục cha
			$catego = new ViewGroup(0,0);
	?>
</div> <!--content_form-->
 <div id="adminfieldset">
    <div class="adminheader"><a href="javascript:void(0);">Danh sách Game đang sử dụng</a></div>
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
    <form id="appFormRemove" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=removegame&id_template=<?php echo intval($_GET['id_template']); ?>" method="post" name="appFormRemove" enctype="multipart/form-data">
        <div class="rows">	
        <table class="table table-striped table-bordered table-condensed table-hover">
        	<thead>
            	<th>Game</th>
				 <th style="background-color:#B3AEB1;">Nhóm thực hiện</th>
                <th style="background-color:#A1B5B5;">Nhóm hỗ trợ</th>
                <th>Checklist</th>
                <th>Edit</th>
				<th>Status</th>
				<th>Date</th>
				<th>User</th>
            </thead>
            <?php
                    if(count($listGameChecklist)>0 && !empty($listGameChecklist)){
                        foreach($listGameChecklist as $v){
                ?>
                <tr>
                	<td><strong style="color:#9A0FE0"><?php echo $loadgame[$v['id_game']]['app_fullname']; ?></strong></td>
                    <td style="font-size:9px;">
                    <a class="various_main" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=templatechecklist&func=popup_group&id_game=<?php echo $v['id_game']; ?>&type=main">Thay đổi</a><br />
					<?php echo $catego->ShowGroupOnGame($v['id_game'],"main"); ?></td>
                    <td style="font-size:9px;"><a class="various_support" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=templatechecklist&func=popup_group&id_game=<?php echo $v['id_game']; ?>&type=support">Thay đổi</a><br />
					<?php echo $catego->ShowGroupOnGame($v['id_game'],"support"); ?></td>
					<td><!--<a href="<?php echo base_url();?>?control=gamechecklist&func=index&id_template=<?php echo intval($_GET['id_template']); ?>&id_game=<?php echo $v['id_game']; ?>" target="_blank" style="color:#E81287;text-decoration:none;">Checklist</a>-->
                    <a href="<?php echo base_url();?>?control=gamechecklisttemp&func=index&id_game=<?php echo $v['id_game']; ?>&id_template=<?php echo intval($_GET['id_template']); ?>" target="_blank" style="color:#E81287;text-decoration:none;">Checklist</a>
                    </td>
                    <td><a href="<?php echo base_url();?>?control=categametemplate&func=index&id_game=<?php echo $v['id_game']; ?>&id_template=<?php echo intval($_GET['id_template']); ?>" target="_blank" style="color:#00F;text-decoration:none;">Edit</a></td>
					<td>
                    <div id="divstatus_<?php echo $v['id'] ?>">
                    <a href="javascript:void(0)" onclick="UpStatusCate(<?php echo $v['id'] ?>,<?php echo $v['status']; ?>);"><?php echo $v['status']==0?"<strong style='color:green'>On</strong>":"<strong style='color:red'>Off</strong>";?></a>
                    </div>
                    </td>
					<td><?php echo $v['datecreate'] ?></td>
                    <td><?php echo $slbUser[$v['userlog']]['username'];?></td>
				</tr>
                 <?php
                        }
                    }
                ?>
        </table>
        </div>
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
                    <th align="center" width="70px">User</th>
           
                </tr>
            </thead>
            <tbody>
                <?php
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
						//include("listcate.php");
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
function UpStatusCate(id,status){
	$.ajax({
			url:baseUrl+'?control=templatechecklist&func=updatestatus',
			type:"GET",
			data:{id:id,status:status},
			async:false,
			dataType:"json",
			beforeSend:function(){
				$('.loading_warning').show();
			},
			success:function(f){
				if(f.error==0){
					$('#divstatus_'+id).html(f.html);
					$('.loading_warning').hide();
				}else{
					$('#divstatus_' + id).html(f.html);
					$('.loading_warning').hide();
				}
			}
		});
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
				$('.loading_warning').show();
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
