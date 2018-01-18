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
<div class="loading_warning" style="text-align:center">
<img src="<?php echo base_url('assets/img/icon/loading_sign.gif'); ?>" />
</div>
 <div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:1066px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
        <?php include_once 'include/toolbar.php'; ?>
</div> <!--content_form-->
        <form id="appForm" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>&type=filter" method="post" name="appForm" enctype="multipart/form-data">
       <div class="filter">
       <input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="từ khóa ..." title="từ khóa ..." maxlength="20" style="width:150px;"/>
            
            <select name="id_template" id="id_template" data-placeholder="Chọn Template">
                <option value="0"> --- Chọn Template --- </option>
                <?php
                    if(count($slbtemplate)>0){
                        foreach($slbtemplate as $v){
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo ($_POST['id_template']==$v['id']) || ($_GET['id_template']==$v['id'])?'selected="selected"':'';?>><?php echo $v['template_name'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <input type="button" onclick="calljavascript(2);" value="Tìm" class="btnB btn-primary"/> 
       </div> <!--filter-->
       </form>
	   
	   <div id="view_transfer">
 	<form id="appFormTr" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=transferdata" method="post" name="appFormTr" enctype="multipart/form-data">
    <input type="hidden" name="cbo_temp" id="cbo_temp" value="<?php echo $_POST['id_template']==""?$_GET['id_template']:$_POST['id_template'] ; ?>" />
     <select name="cbo_template_source" id="cbo_template_source" data-placeholder="Chọn Template">
                <option value="0"> --- Chọn Checklist --- </option>
                 <?php
					
                    if(count($slbtemplate)>0){
                        foreach($slbtemplate as $v){
							$d['arr']=$obj->listGameChecklist($v['id']);
                ?>
                <optgroup label="<?php echo $v['template_name'];?>">
                	 <?php
							foreach($d['arr'] as $i){
					?>
                    <option value="<?php echo $i['id_game']."|".$i['id_template'];?>"><?php echo $ListGame[$i['id_game']]['app_fullname'];?></option>
                    <?php
							}
					?>
                </optgroup>
                <?php
                        }
                    }
                ?>
     </select>
     <input type="button" onclick="transfer_data();" value="Transfer data" class="btnB btn-primary"/> 
   </form>
   <div id="mess" style="color:#008000;font-size:20px;font-weight:bold">
	<?php echo base64_decode($_GET['mess']); ?>
    </div>
 </div> <!--end view_transfer-->
 
 
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
		 <!--<input type="submit" value="Tranfer" class="btnB btn-primary" name="btn_tranfer"/> -->
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr style="background-color:#8A98C7;">
                	<th align="center" width="50px">Chức năng</th>
                    <!--<th align="center" width="80px">Tạo yêu cầu<br />Template</th>-->
                    <th align="center" width="100px">Template</th>
                    <th align="center" width="300px">Hạng mục</th>
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
		if (!$this->db_slave)
		$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
                        foreach($listItems as $j=>$v){
							$i++;
							$this->db_slave->select(array('*'));
							$this->db_slave->from('tbl_categories');
							$this->db_slave->where('id_parrent', $v['id']);
							$this->db_slave->order_by('order','ASC');
        					$this->db_slave->order_by('id','DESC');
							$cate_child = $this->db_slave->get();
							 if (is_object($cate_child)) {
									$child = $cate_child->result_array();
								}
							
					
							
                ?>
                <tr>
                	<td>
                    <a href="<?php echo base_url()."?control=".$_GET['control']."&func=edit&id_template=".$v['id_template']."&id=".$v['id'] ?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url().'assets/img/icon_edit.png'; ?>"></a>
                        
<a onclick="checkdel('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id']."&id_template=".$v['id_template'] ?>')" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url().'assets/img/icon_del.png'; ?>"></a> 
                    </td>
                    <!--<td><a href="<?php echo base_url()."?control=".$_GET['control']."&func=checklist&idtemplate=".$v['id_template']."&idcategories=".$v['id'] ?>">Tạo</a></td>-->
                    <td style="background:#990">
                    <?php if($v['id_template']!=$static){ ?>
                    <strong style="color:#903;font-size:10px;"><?php echo $slbTemp[$v['id_template']]['template_name']; ?></strong>
                    <?php } ?>
                    </td>
                    <td><b>
                    <a href="javascript:void(0);" id="showmenu" onclick="showclass(<?php echo $v['id'] ?>);" style="color:#693;text-decoration:none;">
					<?php echo mb_convert_case($v['names'], MB_CASE_UPPER, "UTF-8");?>
                    </a>
                    </b></td>
       			    <td>
                    <!--<div id="divstatus_<?php echo $v['id'] ?>">
                    <a href="javascript:void(0)" onclick="UpStatusCate(<?php echo $v['id'] ?>,<?php echo $v['status']; ?>);"><?php echo $v['status']==0?"<strong style='color:green'>On</strong>":"<strong style='color:red'>Off</strong>";?></a>
                    </div>-->
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
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_categories.js'); ?>" type="text/javascript"></script>
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

function transfer_data(){
		var r1 = $('#cbo_template_source').val();
		var r2 = $('#cbo_temp').val();
		if(r1 == 0){
			alert('Vui lòng chọn checklist');
			return false;
		}else{
			if(r2 == ''){
				alert('Vui lòng chọn Template');
				return false;
			}else{
				$('.loading_warning').show();
				document.forms.appFormTr.submit();
			}
			//alert('Nhấn nút OK để thực hiện');
		}
}
</script>
