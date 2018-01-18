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
}</style>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
<div id="adminfieldset" class="groupsignios space">
            <!--<div class="adminheader"><strong>In App Items</strong></div>-->
            <div class="group_left">
                <div class="rows">
                	<div>
                    	Tỷ giá [ MCOIN:KNB ]
                        <input type="text" name="rate_mcoin" id="rate_mcoin" value="<?php echo $getrate['mcoin']==""?0:$getrate['mcoin']; ?>" readonly="readonly" style="width:50px;border:none;text-align:center;margin:0;" /> : <input type="text" name="rate_gem" id="rate_gem" value="<?php echo $getrate['gem']==""?0:$getrate['gem']; ?>" readonly="readonly" style="width:50px;border:none;text-align:center;margin:0;" />
                        
                    </div>	
                    <label for="menu_group_id"></label>
                    <input type="text" name="inapp_items_show" id="inapp_items_show" class="textinput" value="" maxlength="200" style="width:250px;" onkeypress="runScript(event);" placeholder="Names" />
                    <input type="text" name="vnd_show" id="vnd_show" class="textinput" value="" maxlength="200" style="width:100px;" placeholder="VND" onkeypress="runScript(event);" onkeyup="return checkInp('vnd_show');" onkeydown="return checkInp('vnd_show');" />
                    <input type="text" name="mcoin_show" id="mcoin_show" class="textinput" value="" maxlength="200" style="width:100px;" placeholder="MCOIN" onkeypress="runScript(event);" onkeyup="calrate(this.value);" onkeydown="return checkInp('mcoin_show');" />
                    <input type="text" name="gem_show" id="gem_show" class="textinput" value="" maxlength="200" style="width:100px;" placeholder="KNB" onkeypress="runScript(event);" onkeyup="return checkInp('gem_show');" onkeydown="return checkInp('gem_show');" />
                    <input type="text" name="promotion_gem_show" id="promotion_gem_show" class="textinput" value="" maxlength="200" style="width:100px;" placeholder="PROMOTION KNB" onkeypress="runScript(event);" onkeyup="return checkInp('promotion_gem_show');" onkeydown="return checkInp('promotion_gem_show');" />
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
                	<table width="100%" class="table" id="tblsort" style="background-color:transparent;margin-bottom:10px;">
                    	<thead>
                        	<tr>
                            	<th>Name</th>
                                <th>VND</th>
                                <th>MCOIN</th>
                                <th>KNB</th>
                                <th>PROMO KNB</th>
                                <th>Delete</th>
								<th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            	<?php
					if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
							$vnd = $v['vnd']==""?0:number_format(trim($v['vnd']));
							$mcoin = $v['mcoin']==""?0:number_format(trim($v['mcoin']));
							$gem = $v['vnd']==""?0:number_format($v['gem']);
							$promotion_gem = $v['promotion_gem']==""?0:number_format(trim($v['promotion_gem']));
					?>
                    	<tr>
                        	<td><?php echo $v['code']; ?></td>
                    		<td><?php echo $vnd; ?></td>
                            <td><?php echo $mcoin; ?></td>
                            <td><?php echo $gem; ?></td>
                            <td><?php echo $promotion_gem; ?></td>
                            <td>
                            <?php if($_SESSION['account']['id_group']==2|| $_SESSION['account']['id_group']==1 ){ ?>
                        <a href="javascript:void(0);" onclick="deletedinappitem(<?php echo $v['id'];?>)"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>
							<?php
                                }//end if
                            ?>
                            </td>
							<td><?php echo $slbUser[$v['userlog']]['username'];?></td>
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
function checkInp(itemid)
{
  var x=document.getElementById(itemid).value;
  if (isNaN(x)) 
  {
    $('#' + itemid +'').val('');
	return false;
  }
}
function calrate(_vnd){
		rate_gem=$('#rate_gem').val();
		rate_mcoin=$('#rate_mcoin').val();
		if(rate_gem=='0' || rate_mcoin=='0')
			return;
		cur_mcoin=$('#mcoin_show').val();
		cur_gem=Math.floor((cur_mcoin*rate_gem)/rate_mcoin);
		$('#gem_show').val(cur_gem);
	}
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
		_vnd=$('#vnd_show').val();
		_mcoin=$('#mcoin_show').val();
		_gem=$('#gem_show').val();
		_promotiongem=$('#promotion_gem_show').val();
		
		j++;
		if(_ival!=''){
			_value=_ival+';'+ _promotiongem + ';'+ _gem + ';' + _mcoin + ';' + _gem;
			$('#in_app').css('display','block');
			$('ol').prepend("<li id='" + j +"'>" + _value + " | <a href='javascript:void(0);' onclick='removetext(" + j +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
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
                url:'<?php echo base_url()?>?control=projects&func=addinappplus',
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