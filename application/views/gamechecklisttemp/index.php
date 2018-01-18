<?php include("header.php");include("class.php"); ?>
<div class="loading_warning" style="text-align:center">
<img src="<?php echo base_url('assets/img/icon/loading_sign.gif'); ?>" />
</div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1250px;">
<form name="frmlist" id="frmlist" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=index&module=all&id_game=<?php echo $_GET['id_game'];?>&id_template=<?php echo $_GET['id_template'];?>&type=search" enctype="multipart/form-data" method="post" style="height:500px;overflow-y:scroll;width:1290px;" >
<label for="menu_group_id" style="font-size: 20px;color:#E45914;margin-left: 23px;margin-bottom: 0;width:400px;margin-bottom:20px;">
<?php echo $loadgame[intval($_GET['id_game'])]['app_fullname']; ?>
 <i style="font-size:12px;">CHECKLIST (<?php echo date('d-m-Y H:m:s'); ?>) </i>
</label>
<?php 
		//phan tim kiem
		if(ViewGroup::$group_admin==-1){
			include('search.php');
	    }//end if
 ?>

<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed" id="tblsort" >
            <tbody>
                <?php
				$categories_parent=$catego->ShowCategoriesParent(intval($_GET['id_game']));
					if(count($categories_parent)>0 && $categories_parent != NULL){
						foreach($categories_parent as $c=>$k){
				
					
                ?>
                <tr id="root_td_<?php echo $k['id'];?>">
                    	<td colspan="13" style="background-color:#3A584C;">
                        <a id="a_pos_<?php echo $k['id'];?>" href="javascript:void(0);" style="color:#fff;text-decoration:none;" onclick="showclass(<?php echo $k['id'];?>);" onmouseover="checkexist_obj(<?php echo $k['id'];?>);" >
						<b><?php echo mb_convert_case($k['names'], MB_CASE_UPPER, "UTF-8");?></b>
                        </a>
						|
                        <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>?control=gamechecklisttemp&func=googlecharts&module=all&id_game=<?php echo $k['id_game']; ?>&id_parent=<?php echo $k['id'];?>&name=<?php echo $k['names'];?>" style="color:#07DA19">Thống kê biểu đồ</a>
                        <br><h5 style="color:#FDEC0E">
						<?php
                                $cate_child=$catego->ShowCategoriesChild($k['id_game'],$k['id']);
                                if(count($cate_child) >0 && !empty($cate_child)){
                                    foreach($cate_child as $c1=>$cc){
                                        $data=$catego->ShowRequestofCate($cc['id_game'],$cc['id']);
                                        if(count($data)>0 && $data != NULL){
                                            foreach($data as $i=>$v){
                                                $data_type = array(
                                                    0 => $v['android'],
                                                    1 => $v['ios'],
                                                    2 => $v['wp'],
                                                    3 => $v['pc'],
                                                    4 => $v['web'],
                                                    5 => $v['events'],
                                                    6 => $v['systems'],
                                                    7 => $v['orther']
                                                );
                                                for($o=0;$o <= count($data_type);$o++){
                                                    if($data_type[$o]!="" && !empty($data_type[$o])){
                                                        $j++;
                                                         $stype_css="";
                                                        //neu lọc theo status , chi hiển thị những status được chọn
                                                        if($get_status!=""){
                                                            $arr_statu_option=explode(",",$get_status);
                                                            if($btn_filter==1){
                                                                    //user
                                                                   $sta="'".$v['result_'.$catego->ShowTypesControl($o)]."'";
                                                            }elseif($btn_filter==2){
                                                                    //admin
                                                                   $sta="'".$v['result_admin_'.$catego->ShowTypesControl($o)]."'";
                                                            } //end if
                                                            $sta=$sta=="''"?"'NULL'":$sta;
                                                            if(in_array(trim($sta), $arr_statu_option)){
                                                                $dem[] = 1;
                                                            }
                                                        }else{
                                                            $dem[] = 1;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            ?>
                            <strong style="color:#ff6b12">Tìm thấy : <?php echo count($dem);?> </strong>
						<?php echo $catego->CountRequestOfType(intval($_GET['id_game']),$k['id'],1,$_POST['cbo_group']);?></h5>
						<a href="javascript:void(0);" style="color:#22EC0B" onclick="statistical_cate_parent(<?php echo $k['id'];?>,<?php echo $k['id_game'];?>,$('#cbo_group').val());">Thống kê chi tiết</a>
                        <div id="ajax_statistical_parent_<?php echo $k['id'];?>" style="color:#F5DEB3;font-size:16px;" onclick="$('#ajax_statistical_parent_<?php echo $k['id'];?>').html('');"></div>
						</td>
               </tr>
                <tr>
                    <td colspan="13" style="background-color:#3A584C;padding-bottom:0">
                    <?php include('listcate.php'); ?>
                    </td>
                </tr>
                    
                <?php
						}//end for
					}else{
						echo "<tr><td colspan='13'><strong style='color:red'>Không có dữ liệu!</strong></tr></td>";
					}//end if
						
                ?>
          		
            </tbody>
        </table>
    </form>
         
            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_template_new.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
showcatemath();
 //hàm hiển thị những danh mục thỏa điều kiện tìm kiếm
function showcatemath(){
	//alert('ok');
	<?php if(count($categories_parent)>0 && $categories_parent != NULL){
				foreach($categories_parent as $c=>$k){
	?>
			checkexist_obj(<?php echo $k['id'];?>);
	<?php 
				}//end for
		  }//end if
	?>

}//end func

function checkexist_obj(id){
		var obj_sub_total = document.getElementById('tbltable_' + id);
		if(obj_sub_total==null){
			$('#root_td_' + id).css('display','none');
		}
	}
function showclass(id){
	
	var c=$('#tbltable_' + id).css('display');
	if(c=='none'){
		$(".con").css('display','none');
		$('#tbltable_' + id).css('display','table');
		
	}else{
		$('#tbltable_' + id).css('display','none');
	}
	
}
function showRequest(id){
	$('#tbltable_requset_' + id).fadeToggle("fast", "linear");
}

gethashurl();
//use hash , to move postion
function gethashurl(){
	if(window.location.hash){
		var _has = window.location.hash.substring(1);
		var _arr= _has.split('-');
		showclass(_arr[0]);
		showRequest(_arr[1]);
		//window.location.hash = '#a_pos_' + _arr[0];
		window.location.hash = '#a_post_res_' + _arr[2] + '_' + _arr[3];
		//$('#a_pos_' + _arr[0]).scrollTo();
	}
}

</script>
