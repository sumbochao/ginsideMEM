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
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:1066px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
        <?php 
		include_once 'include/toolbar.php';
		include('class.php');
		$request = new ViewGroup(0,0);
		 ?>
</div> <!--content_form-->
        
       <form id="appForm" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>&id_categories=<?php echo $_GET['id_categories'];?>&id_template=<?php echo $_GET['id_template'];?>&type=filter" method="post" name="appForm" enctype="multipart/form-data">
       <div class="filter">
       <input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="từ khóa ..." title="từ khóa ..." maxlength="20" style="width:150px;"/>
            <select name="cbo_categories" id="cbo_categories" data-placeholder="Chọn hang muc">
                        <option value="0"> -- Hạng Mục -- </option>
                        <?php
						if (!$this->db_slave)
		$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
                            if(count($categories)>0){
                                foreach($categories as $item){
									$this->db_slave->select(array('*'));
									$this->db_slave->from('tbl_categories');
									$this->db_slave->where('id_parrent', $item['id']);
									$this->db_slave->order_by('order','ASC');
									$this->db_slave->order_by('id','DESC');
									$cate_child = $this->db_slave->get();
									 if (is_object($cate_child)) {
											$child = $cate_child->result_array();
										}
                        ?>
                        <optgroup label="<?php echo $item['names'];?>">
                        	<?php
									foreach($child as $items){
							?>
                            <option value="<?php echo $items['id'];?>" <?php echo ($_POST['cbo_categories']==$items['id']) || ($_GET['id_categories']==$items['id'])?'selected="selected"':'';?>><?php echo $items['names'];?></option>
                            <?php } ?>
                        </optgroup>
                        
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
                <tr style="background-color:#8A98C7">
                	<th align="center" width="50px">Chức năng</th>
                    <th align="center" width="80px">Hạng mục</th>
                    <th align="center" width="80px" style="color:#EC0909">Yêu cầu</th>
                    <th align="center" width="50px">Nhóm chính</th>
                    <th align="center" width="50px">IOS</th>
                    <th align="center" width="50px">Android</th>
                    <th align="center" width="50px">WP</th>
                    <th align="center" width="50px">PC</th>
                    <th align="center" width="50px">Config</th>
                    <th align="center" width="50px">Event</th>
                    <th align="center" width="50px">System</th>
                    <th align="center" width="50px">Other</th>
                    <th align="center" width="50px">Sort</th>
                    <!--<th align="center" width="70px">Date</th>-->
                   	<th align="center" width="50px">User</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					$img_on="<img boder='0' src='".base_url()."assets/img/tick.png'>";
					$img_off="<img boder='0' src='".base_url()."assets/img/tick2.png'>";
					$i=0;
					
                    if(count($listItems) > 0 && $listItems!= NULL){
                        foreach($listItems as $j=>$v){
							$i++;
                ?>
                <tr>
                	<td>
                    <a href="<?php echo base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id']."&id_template=".intval($_GET['id_template'])."&id_categories=".$v['id_categories']; ?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url().'assets/img/icon_edit.png'; ?>"></a>
                        
<a onclick="checkdel('appForm','<?php echo base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id']."&id_categories=".$v['id_categories']."&id_template=".intval($_GET['id_template']); ?>')" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url().'assets/img/icon_del.png'; ?>"></a> 
                    </td>
                    <td style="background:#990"><strong style="color:#903;font-size:10px;"><?php echo $slbCategories[$v['id_categories']]['names'];?></strong></td>
                    <td><i style="font-size:12px;font-weight: bold;"><a href="<?php echo base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id']."&id_template=".intval($_GET['id_template'])."&id_categories=".$v['id_categories']; ?>" title="<?php echo $v['admin_request'];?>"><?php echo $v['titles'];?></a></i></td>
                    <td><?php echo $request->CreateControlGroup($v['id'],0); ?></td>
                    <td><?php echo $v['ios']=="true"?$img_on:$img_off;?></td>
                    <td><?php echo $v['android']=="true"?$img_on:$img_off;?></td>
                    <td><?php echo $v['wp']=="true"?$img_on:$img_off;?></td>
                    <td><?php echo $v['pc']=="true"?$img_on:$img_off;?></td>
                    <td><?php echo $v['web']=="true"?$img_on:$img_off;?></td>
                    <td><?php echo $v['events']=="true"?$img_on:$img_off;?></td>
                    <td><?php echo $v['systems']=="true"?$img_on:$img_off;?></td>
                    <td><?php echo $v['orther']=="true"?$img_on:$img_off;?></td>
                    <!--<td><?php echo $v['notes'];?></td>-->
                    <!--<td><?php echo $v['datecreate'];?></td>-->
                    <td><input type="text" name="sort[<?php echo $v['id'] ?>]" id="sort_<?php echo $v['id'] ?>" value="<?php echo $v['sort'] ?>" style="width:35px;" onkeypress="calljavascript(3,<?php echo $v['id'] ?>);" onkeyup="calljavascript(3,<?php echo $v['id'] ?>);" />
                    <div id="messsort_<?php echo $v['id'] ?>" style="font-size:9px;color:#900"></div>
                    </td>
                    <td><?php echo $slbUser[$v['userlog']]['username'];?></td>
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
    </form>
         
            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_request.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i,id){
		switch(i){
			 case 0: // xóa
			 	deleteitem(id,'<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>')
			 
			 break;
			 case 1: // add new
			 		window.location.href='<?php 
					$arr=array_merge($_POST,$_GET);
					echo base_url()."?control=".$_GET['control']."&func=add&id_categories=".$arr['id_categories']."&id_template=".$_GET['id_template'] ?>';
			 break;
			 case 2: //tim kiem
			 	document.forms.appForm.submit();
			 break;
			 case 3:
			 	Updatesort(id,document.getElementById('sort_' + id).value);
			 break;
			 default:
			 break;
		}
	}
</script>
