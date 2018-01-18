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
.group_left{
	width:100%;
}
.group_left .rows{
	margin-bottom:0;
}
.group_left label{
	width:200px;
}
.group_left .rows input[type='text']{
	width:500px;
}
.groupsignios{
	clear:both;
	float:left;
}
.header_toolbar{
	width:100%;
}
.scroolbar{
	width:1500px;
}
#adminfieldset.groupsignios {
    width: 100%;
}
.textinputplus{
	border:none !important;
}
.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
	vertical-align:top;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:1000px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
        <?php include_once 'include/toolbar.php'; ?>
        <form id="appForm" name="appForm" action="<?php echo base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&action=add"; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div id="adminfieldset" class="groupsignios" style="width:100%;">
            <div class="adminheader">Nhập thông tin</div>
            <div class="group_left">
                <div class="rows">
                	<table class="table table-striped table-bordered table-condensed table-hover">
                    	<thead>
                            <th style="width:150px;">Tên nhóm</th>
                            <th style="width:150px;">Ghi chú</th>
                            <th></th> 
                		</thead>
                        <tbody>
                        <tr>
                        	
                        	<td style="vertical-align:top;">
                            <input type="text" name="names" id="names" class="textinput" value="<?php echo $_POST['names']; ?>" style="width:250px;" />
                            </td>
                            <td style="vertical-align:top;">
                             <input type="text" name="notes" id="notes" class="textinput" value="<?php echo $_POST['notes']; ?>" style="width:250px;" />
                            <!--<textarea name="notes" id="notes" style="height:50px;width:600px"><?php echo $_POST['notes']; ?></textarea>-->
                            </td>
                            <td> <input type="button" name="btnadd" id="btnadd" value="Lưu lại" class="btnB btn-primary" onclick="checkempty();"/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
               
                <div class="rows">
                	<div id="mess" style="color:#F00;font-size:20px;font-weight:bold"><?php echo $Mess; ?></div>
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
      
            </form>
           
        
        </div> <!--content_form-->
        
       
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
		 <input type="text" name="txt_u" id="txt_u" placeholder="Nhập account" />
         <input type="button" name="btns" value="Tìm" class="btnB btn-primary" onclick="searchgroup();" />
         <strong id="kq"></strong>
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                	<th align="center" width="80px">Chức năng</th>
                    <!--<th align="center" width="150px">Yêu cầu</th> -->
                    <th align="center" width="150px">User</th>
                    <th align="center" width="80px">Nhóm</th>
                    <th align="center" width="70px">Notes</th>
                   	<th align="center" width="70px">User</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					$i=0;
                    if(count($listItems)>0 && $listItems!= NULL){
                        foreach($listItems as $j=>$v){
							$i++;
                ?>
                <tr id="row_<?php echo $v['id'];?>" class="row_tab">
                	<td>
                    <div style="float:left;width:95px;margin:0px;" id="divfunc">
                    <a href="javascript:void(0);" onclick="showhide(<?php echo $v['id'];?>);" id="edit_<?php echo $v['id'];?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url()?>assets/img/icon_edit.png"></a>
                    <a href="javascript:void(0);" onclick="updaterows(<?php echo $v['id'];?>,$('#names_e_<?php echo $v['id'];?>').val(),$('#notes_e_<?php echo $v['id'];?>').val())" title="Sửa" id="save_row_<?php echo $v['id'];?>" style="display:none;"><img border="0" width="16" height="16" title="Lưu" src="<?php echo base_url()?>assets/img/icon/save.png"></a>
                    <a href="javascript:void(0);" onclick="showhidei(<?php echo $v['id'];?>);" id="cancel_<?php echo $v['id'];?>" title="Hủy" style="display:none;"><img border="0" title="Hủy" src="<?php echo base_url()?>assets/img/icon/inactive.png"></a>
                    <a onclick="calljavascript(0,<?php echo $v['id'];?>);" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>  
                   
                    </div>
                    </td>
                    <!-- <td><a href="<?php echo base_url();?>?control=request&func=index" target="_blank" title="Chọn yêu cầu">Thêm Yêu cầu</a></td> -->
                    <td><a href="<?php echo base_url();?>?control=groupuser&func=userongroup&id_group=<?php echo $v['id'];?>" target="_blank" title="Xem user" style="color:#903;font-style:italic;">Xem user</a> (<?php  if (!$this->db_slave)
		$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
		$this->db_slave->select(array('*'));
		$this->db_slave->from('tbl_user_on_group');
		$this->db_slave->where('id_group', $v['id']);
		$data = $this->db_slave->get();
		$result = $data->result_array();
		echo "<i style='color:#E28603'>".count($result)." user</i>"; ?> )</td>
                    <td>
                    <input type="text" name="names_e_<?php echo $v['id'];?>" id="names_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['names'];?>" style="width:250px;" />
                   </td>
                    <td>
                    <input type="text" name="notes_e_<?php echo $v['id'];?>" id="notes_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['notes'];?>" style="width:250px;" /></td>
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
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_groupuser.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i,id){
		switch(i){
			 case 0: // xóa
			 	deleteitem(id,'<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>')
			 
			 break;
			 default:
			 break;
		}
	}
</script>
