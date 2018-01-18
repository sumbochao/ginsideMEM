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
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
<div id="adminfieldset" class="groupsignios space">
            <!--<div class="adminheader"><strong>In App Items</strong></div>-->
            <div class="group_left">
                <div class="rows">	
                    <label for="menu_group_id"></label>
                    <input type="text" name="inapp_items_show" id="inapp_items_show" class="textinput" value="" maxlength="200" style="width:250px;" onkeypress="runScript(event);" />
                    <input type="hidden" name="inapp_items" id="inapp_items" class="textinput" value="" maxlength="200" style="width:250px;" />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addtext();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a>
                     
                </div>
                <div class="rows" id="in_app" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ol class="payment"></ol>
                    <input type="button" name="btnadd" id="btnadd" value="Lưu" class="btnB btn-primary" onclick="addinapp();"/>
                </div>
                <hr />
                <div class="rows">
                	<ul>
                	<?php
					if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
					?>
                    	<li id="li_<?php echo $v['id'];?>"><strong style="color:#008199"><?php echo $v['code'];?></strong> 
                        <?php if($_SESSION['account']['id_group']==2|| $_SESSION['account']['id_group']==1 ){ ?>
                        <a href="javascript:void(0);" onclick="deletedinappitem(<?php echo $v['id'];?>)"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>
                        <?php
							}//end if
						?>
                        </li>
                    <?php }
					}
					?>
                    </ul>
                </div>
            </div>
           
            <div class="clr"></div>
        </div>
 </div> <!--content-t-->
<script language="javascript">

function deletedinappitem(id){
	c=confirm('Bạn có muốn xóa không ?');
	if(c){
		$.ajax({
				url:'<?php echo base_url()?>?control=projects&func=deletedinappitem',
				type:"GET",
				data:{id:id},
				async:false,
				dataType:"json",
				beforeSend:function(){
					//$('.loading_warning').show();
				},
				success:function(f){
					if(f.error==0){
						//loadlistproperty1(id_projects,0,'');
						$('#li_'+id).css('display','none');
						//$('.loading_warning').hide();
					}else{
						Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
						//$('.loading_warning').hide();
					}
				}
			});
	}
}
var j=0;
	function runScript(e) {
		if (e.keyCode == 13) {
			addtext();
			return false;
		}
	}
	function addtext(){
		_ival=$('#inapp_items_show').val();
		j++;
		if(_ival!=''){
			$('#in_app').css('display','block');
			$('ol').prepend("<li id='" + j +"'>" + _ival + " | <a href='javascript:void(0);' onclick='removetext(" + j +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
		}
	}
	function removetext(j){
		$("li").remove("#"+ j +"");
	}
	
	function addinapp(){
		//get in app array
		var list_array;
		$(".payment li").each(function( index ) {
			list_array += $(this).text();
		});
		_inapp_items=list_array.replace('undefined','');
		if(_inapp_items==''){
			alert('Không bỏ trống !');
			$('#inapp_items_show').focus();
			return false;
		}
		//add 
		$.ajax({
                url:'<?php echo base_url()?>?control=projects&func=addinapp',
                type:"GET",
                data:{code:_inapp_items,id_projects:<?php echo $_GET['id_projects'] ?>,id_projects_property:<?php echo $_GET['id_projects_property'] ?>},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    //$('.loading_warning').show();
                },
                success:function(f){
					$('#inapp_items_show').val('');
					$("ol li").remove();
					//alert('Thành công');
					window.location.href='<?php echo base_url(); ?>?control=projects&func=popupinapp&id_projects=<?php echo $_GET['id_projects'];?>&id_projects_property=<?php echo $_GET['id_projects_property'];?>';
                }
            });
		
	}//end step 1
	
</script>