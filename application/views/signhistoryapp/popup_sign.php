<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/theme.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<style>
#tblsort th{
	font-size:12px;
	font-weight:bold;
	color:#600;
}
#tblsort tr th{
	text-align:left;
}
#tblsort tr td{
	text-align:left;
}
</style>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
<div id="adminfieldset" class="groupsignios space">
            <!--<div class="adminheader"><strong>In App Items</strong></div>-->
            <div class="group_left">
                <div class="rows">
             
                    <label for="menu_group_id"></label>
                    <input type="text" name="txt_value" id="txt_value" class="textinput" value="" maxlength="200" style="width:250px;" onkeypress="runScript(event);" placeholder="LSApplicationQueriesSchemes" />
                    <input type="button" name="btnadd" id="btnadd" value="Lưu" class="btnB btn-primary" onclick="addkeys($('#txt_value').val());"/>
                     
                </div>
                <div class="rows">
                	<table width="100%" class="table" id="tblsort" style="background-color:transparent;margin-bottom:10px;">
                    	<thead>
                        	<tr>
                            
                            	<th>Name</th>
                                <th>Ngày tạo</th>
                                <th>User</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                     <?php
					if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
		
					?>
                    	<tr>
                        	<td><?php echo $v['notes']; ?></td>
                    		<td><?php echo $v['datecreate']; ?></td>
                            <td><?php echo $slbUser[$v['userlog']]['username'];?></td>
                            <td>
                        <a href="javascript:void(0);" onclick="deleteditem(<?php echo $v['id'];?>)"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>
                            </td>
                             
                        </tr>
                    <?php
					 } //end for
					} //end if
					?>
                        </tbody>
                    </table>
                	
                </div>
            </div>
           
            <div class="clr"></div>
        </div>
 </div> <!--content-t-->
<script language="javascript">
function deleteditem(id){
	c=confirm('Bạn có muốn xóa không ?');
	if(c){
		$.ajax({
				url:'<?php echo base_url()?>?control=signhistoryapp&func=deletekeyplist',
				type:"GET",
				data:{id:id},
				async:false,
				dataType:"json",
				beforeSend:function(){
					//$('.loading_warning').show();
				},
				success:function(f){
					if(f.error==0){
						window.location.href='<?php echo base_url(); ?>?control=signhistoryapp&func=popupsign';
					}else{
						alert('System Error');
						//$('.loading_warning').hide();
					}
				}
			});
	}
}
	function addkeys(val){
		if(val==''){
			alert('Không bỏ trống !');
			$('#txt_value').focus();
			return false;
		}
		//add 
		$.ajax({
                url:'<?php echo base_url()?>?control=signhistoryapp&func=addkeysplist',
                type:"GET",
                data:{val:val},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    //$('.loading_warning').show();
                },
                success:function(f){
					if(f.error==0){
						$('#txt_value').val('');
						window.location.href='<?php echo base_url(); ?>?control=signhistoryapp&func=popupsign';
					}else if(f.error==-1){
						alert('Dữ liệu đã tồn tại');
					}else{
						alert('System Error');
					}
                }
            });
		
	}//end step 1
	
</script>