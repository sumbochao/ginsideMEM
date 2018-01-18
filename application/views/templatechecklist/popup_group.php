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
                	<table width="100%" class="table" id="tblsort" style="background-color:transparent;margin-bottom:10px;">
                    	<thead>
                        	<tr>
                            
                            	<th>Group hiện tại</th>
                                <th>Group thay thế</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                     <?php
				
					if(count($listItems) > 0){
                        foreach($listItems as $i=>$v){
		
					?>
                    	<tr>
                        	<td><?php echo $slbGroup[$v['id_group']]['names']; ?></td>
                    		<td>
                            	<select name="cbo_group_<?php echo $v['id_group']; ?>" id="cbo_group_<?php echo $v['id_group']; ?>">
                                        <?php 
                                        if(count($Group)>0 && !empty($Group)){
                                                foreach($Group as $i=>$g){
                                                    if($g['id']!=-1){
                                                        //k hien thi nhom admin
                                        ?>
                                        <option value="<?php echo $g['id'];?>" <?php echo $_POST['cbo_group']==$g['id']?"selected":"";?> ><?php echo $g['names'];?></option>
                                        <?php }}} ?>
                                    </select>
                            </td>
                            <td><a href="javascript:void(0);" onclick="ChangeGroup(<?php echo $v['id_game'];?>,<?php echo $v['id_group'];?>,$('#cbo_group_<?php echo $v['id_group']; ?>').val(),'<?php echo $_GET['type']; ?>');">Lưu</a></td>
                             
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
function ChangeGroup(id_game,id_gr_current,id_gr_change,type){
	c=confirm('Bạn có muốn thay thế không không ?');
	if(c){
		$.ajax({
				url:'<?php echo base_url()?>?control=templatechecklist&func=ChangeGroup',
				type:"GET",
				data:{id_game:id_game,id_gr_current:id_gr_current,id_gr_change:id_gr_change,type:type},
				async:false,
				dataType:"json",
				beforeSend:function(){
					//$('.loading_warning').show();
				},
				success:function(f){
					if(f.error==0){
						window.location.href='<?php echo base_url(); ?>?control=templatechecklist&func=popup_group&id_game='+id_game+'&type='+type;
					}else{
						alert('System Error');
						//$('.loading_warning').hide();
					}
				}
			});
	}
}
</script>