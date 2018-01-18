<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<style>
.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
}
.main-bar{
	display:none;
}
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
        	<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="Nhập tên dự án ..." title="Nhập tên dự án ..." maxlength="20" style="width:350px;"/>
           
            <?php 
           
				$lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
            ?>
            <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>
            <strong style="color:#F00;padding-left:20px;"><?php echo base64_decode($_GET['info']);?></strong>
            <div id="paging_div" style="float:left;margin-bottom:5px;margin-right:5px;">
        	<?php echo $pages?>
       	    </div> <!--paging_div-->   
        </div>
        
        
        <div class="wrapper_scroolbar" style="height:400px;" >
            <div class="scroolbar" style="width:1561px;">
        
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
            
                    <th align="center" width="20px">Xóa</th>
                    <th align="center" width="10px">STT</th>
                    <th align="center" width="10px">Payment</th>
					<th align="center" width="10px">Status</th>
                    <th align="center" width="100px">Mã dự án</th>
                    <th align="center" width="100px">Tên ngắn</th>
                    <th align="center" width="100px">Tên cài đặt/dự án</th>
                    <th align="center" width="100px">ServiceKeyApp</th>
                    <th align="center" width="100px">ServiceKey</th>
                    <!--<th align="center" width="100px">Ghi chú</th>-->
                    <th align="center" width="70px">Ngày</th>
                    <th align="center" width="70px">User</th>
                    <th align="center" width="70px">Log Update</th>
                    
                    
                </tr>
            </thead>
         <tbody>
                <?php
				$i=0;
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
							$i++;
							if (!$this->db_slave1)
								$this->db_slave1 = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
							$this->db_slave1->select(array('*'));
							$this->db_slave1->where('id_actions',$v['id']);
							$this->db_slave1->where('tables','tbl_projects');
							//$this->db_slave1->where('username',$v['userlog']);
							$data = $this->db_slave1->get('tbl_log');
							if(is_object($data)) {
								$count = $data->result_array();
							}
                ?>
                <?php if((@in_array($_GET['control'].'-status', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==68){ ?>
                <tr onclick="SetId(<?php echo $v['id'];?>);" ondblclick="OpenEdit(<?php echo $v['id'];?>);" contextmenu="rmenu" id="tr_menu_<?php echo $v['id'];?>" class="rows_class">
                <?php }else{ ?>
                 <tr id="tr_menu_<?php echo $v['id'];?>" class="rows_class">
                 <?php } ?>
                    <!--<td><input type="checkbox" value="<?php echo $v['id'];?>" id="cid[<?php echo $v['id'];?>]" name="cid[]"></td>-->
                    <td>
                    <div style="float:left">
                    
                     <?php  if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){ ?>
                     <a onclick="deleteoneitem(<?php echo $v['id'];?>);" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"> </a> 
                     <?php } ?> 

                     </div>
                    </td>
                    <td><?php echo $i;?></td>
                    <td><?php if($_SESSION['account']['id_group']==2|| $_SESSION['account']['id_group']==1){ ?><a href="<?php echo base_url(); ?>?control=projects&func=viewpayment&id_projects=<?php echo $v['id']; ?>" style="color:#F09;text-decoration:none" target="_blank">payment</a>
                     <?php } ?></td>
					 <td><div id="divstatus_<?php echo $v['id'] ?>">
                    <a href="javascript:void(0)" onclick="UpStatusCate(<?php echo $v['id'] ?>,<?php echo $v['status']; ?>);"><?php echo $v['status']==1?"<strong style='color:green'>On</strong>":"<strong style='color:red'>Off</strong>";?></a>
                    </div></td>
                    <td><a href="<?php echo base_url()?>?control=projects&func=edit&id=<?php echo $v['id'];?>" title="Sửa"><?php echo $v['code'];?></a></td>
                    <td><?php echo $v['names'];?></td>
                    <td><?php echo $v['namesetup'];?></td>
                    <td><?php if((@in_array($_GET['control'].'-status', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){echo $v['servicekeyapp'];}else{ echo $v['servicekeyapp']; }?></td>
                    <td><?php if((@in_array($_GET['control'].'-status', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){ echo $v['servicekey']; }else{ echo "*****************"; }?></td>
                  
                    <!--<td><?php echo $v['notes'];?></td>-->
                    <td><?php echo $v['datecreate'];?></td>
                    <td><a href="<?php echo base_url()?>?control=projects&func=edit&id=<?php echo $v['id'];?>" title="Sửa"><?php echo $slbUser[$v['userlog']]['username'];?></a></td>
                    <td><?php if(isset($count) && count($count)>0){ ?>
                     <a href="<?php echo base_url()?>?control=projects&func=logupdate&table=tbl_projects&id=<?php echo $v['id'];?>" target="_blank" >Xem Log</a> 
                     <?php }else{ ?>
                     <a href="javascript:void(0)" style="color:#333;text-decoration:none">Log Update</a>
                     <?php } ?> </td>
                    
                </tr>
                <?php
                        }
			
                    }else{
                ?>
                <tr>
                    <td colspan="12" class="emptydata">Dữ liệu không tìm thấy</td>
                </tr>
                <?php
                    }
                ?>
           </tbody>
        </table>
        
       
        </div> <!--scroolbar-->
        </div><!-- wrapper_scroolbar -->
    </form>
</div>

<div class="hide" id="rmenu">
    <ul style="margin-left:-38px;">
        <li>
          <a id="link_edit">Sửa</a>
        </li>
        <li>
            <a id="link_delete" href="javascript:void(0);">Xóa</a>
        </li>
    </ul>
</div>
<style>
.show {
    z-index:1000;
    position: absolute;
    background-color:#C0C0C0;
    border: 1px solid #FF0097;
    padding: 2px;
    display: block;
    margin: 0;
    list-style-type: none;
    list-style: none;
}

.hide {
    display: none;
}
.show li{ list-style: none; }
.show a { border: 0 !important; text-decoration: none; color:#0b55c4 !important; }
.show a:hover { text-decoration: underline !important; }
</style>
<script type="text/javascript">
var _id=0;
function OpenEdit(id){
	window.location.href='<?php echo base_url()?>?control=projects&func=edit&id='+id;
}
function SetId(id){
	_id=id;
}
			
	//contextmenu
		document.getElementById('tblsortsssssss').oncontextmenu=function(){
			myFunction(event);
		};	
		function myFunction(e) {
			var parentPosition = getPosition(e.currentTarget);
			var posx = e.clientX - parentPosition.x; //Left Position of Mouse Pointer
            var posy = (e.clientY - parentPosition.y) + 120; //Top Position of Mouse Pointer
			
			/*var myObject = document.getElementById("rmenu");
			 myObject.setAttribute("class",'show');*/
			document.getElementById("rmenu").className = "show";  
            /*document.getElementById("rmenu").style.top =  mouseY(event) + 'px';
            document.getElementById("rmenu").style.left = mouseX(event) + 'px';*/
			document.getElementById("rmenu").style.top =  posy +'px';
            document.getElementById("rmenu").style.left = posx + 'px';
			window.event.returnValue = false;
			//
			document.getElementById('link_edit').href='<?php echo base_url()?>?control=projects&func=edit&id='+_id;
			document.getElementById('link_delete').href='javascript:deleteoneitem('+_id +')';
			/*$('#link_delete').click(function(){
				deleteoneitem(_id);
			});*/
		}
		function getPosition(element) {
			var xPosition = 0;
			var yPosition = 0;
			  
			while (element) {
				xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
				yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
				element = element.offsetParent;
			}
			return { x: xPosition, y: yPosition };
		}
		$(document).bind("click", function(event) {
			document.getElementById("rmenu").className = "hide";
		});
	
		function mouseX(evt) {
			if (evt.pageX) {
				return evt.pageX;
			} else if (evt.clientX) {
			   return evt.clientX + (document.documentElement.scrollLeft ?
				   document.documentElement.scrollLeft :
				   document.body.scrollLeft);
			} else {
				return null;
			}
		}
		function mouseY(evt) {
			if (evt.pageY) {
				return evt.pageY;
			} else if (evt.clientY) {
			   return evt.clientY + (document.documentElement.scrollTop ?
			   document.documentElement.scrollTop :
			   document.body.scrollTop);
			} else {
				return null;
			}
		}
	  //end contextmenu
	
(new TableDnD).init("tblsort");
function deleteoneitem(id){
	c=confirm('Bạn có muốn xóa không ?');
	if(c){
		window.location.href=baseUrl+'?control=projects&func=deleteoneitemrow&id='+id;
		return true;
	}else{
		return false;
	}
}
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

function UpStatusCate(id,status){
	$.ajax({
			url:baseUrl+'?control=projects&func=updatestatus',
			type:"GET",
			data:{id:id,status:status},
			async:false,
			dataType:"json",
			beforeSend:function(){
				//$('.loading_warning').show();
			},
			success:function(f){
				if(f.error==0){
					$('#divstatus_'+id).html(f.html);
					//$('.loading_warning').hide();
				}else{
					$('#divstatus_' + id).html(f.html);
					//$('.loading_warning').hide();
				}
			}
		});
}
</script>