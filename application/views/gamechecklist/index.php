<?php include("header.php"); ?>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1250px;">

<label for="menu_group_id" style="font-size: 20px;color:#E45914;margin-left: 23px;margin-bottom: 0;width:100%;margin-bottom:20px;">
<?php echo $loadgame[intval($_GET['id_game'])]['app_fullname']; ?>
 <i style="font-size:12px;">CHECKLIST (<?php echo date('d-m-Y H:m:s'); ?>) </i>
<!--<a href="javascript:void(0);" title="Lưu" onclick="calljavascript(0);">
<img border="0" title="Lưu" src="<?php echo base_url()?>assets/img/icon-32-save.png">
</a>
<div id="mess" style="color:#008000;font-size:20px;font-weight:bold">
<?php echo base64_decode($_GET['mess']); ?>
</div>-->

</label>
<!--<form name="frmSerach" action="" method="post" enctype="multipart/form-data">
<select style="width:100px;" name="cbo_type" onchange="window.location.href='<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>&id_game=<?php echo $_GET['id_game'];?>&id_template=<?php echo $_GET['id_template'];?>&type=filter&c='+ this.value;">
    <option value="all">All</option>
    <option value="0">android</option>
    <option value="1">ios</option>
    <option value="2">wp</option>
    <option value="3">pc</option>
    <option value="4">web</option>
    <option value="5">events</option>
    <option value="6">systems</option>
    <option value="7">orther</option>
</select>
</form>-->
<form name="frmlist" id="frmlist" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=resultchecklist&id_game=<?php echo $_GET['id_game'];?>&id_template=<?php echo $_GET['id_template'];?>" enctype="multipart/form-data" method="post" style="height:500px;overflow-y:scroll;width:1290px;" >

<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort" >
            <!--<thead>
                <tr>
                	
                    <th align="center" width="250px">Hạng mục</th>
                    <th align="center" width="250px">Yêu cầu</th>
                    <th align="center" width="50px">Loại</th>
                    <th align="center" width="250px">Kết quả <br />Checklist mong muốn</th>
                    <th align="center" width="70px">Nhóm <br />thực hiện</th>
                    <th align="center" width="70px">Nhóm hỗ trợ</th>
                    <th align="center" width="70px">Người thực hiện <br />chọn tình trạng</th>
                    <th align="center" width="70px">Người thực hiện<br />ghi chú</th>
                    <th align="center" width="70px">Admin <br />chọn kết quả</th>
                    <th align="center" width="70px">Ghi chú admin</th>
                    <th align="center" width="150px">Ngày checklist</th>
                    <th align="center" width="70px">User check</th>
                    
                </tr>
            </thead>-->
            <tbody>
                <?php
					include("class.php");
					
					//load hạng mục cha
					$catego = new ViewGroup(0,0);
					$cl=0;
					if(count($categories)>0 && $categories != NULL){
						foreach($categories as $c=>$k){
						 $cl++;
                ?>
                <tr>
                    	<td colspan="13" style="background-color:#3A584C;">
                        <a href="javascript:void(0);" style="color:#fff;text-decoration:none;" onclick="showclass(<?php echo $k['id'];?>);">
						<b><?php echo mb_convert_case($k['names'], MB_CASE_UPPER, "UTF-8");?></b>
                        </a>
                        <!--| <a class="various" style="color:#fff;text-decoration:none;" href="#content-div-categories-<?php echo $k['id'];?>"> Xem mô tả </a>
                        <div style="display:none">
                       <div id="content-div-categories-<?php echo $k['id'];?>"><?php echo $k['notes'];?></div>
                    	</div> -->
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

function calljavascript(i){
		switch(i){
			 case 0: // save
			 	var c=confirm('Bạn có muốn cập nhật thông tin trên!');
				if(c){
					document.forms.frmlist.submit();
					//window.location.href='<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=resultchecklist&id_game=<?php echo $_GET['id_game'];?>&id_template=<?php echo $_GET['id_template'];?>';
				}
			 
			 break;
		}
	}
</script>
