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
	width:70%;
}
.scroolbar{
	width:1500px;
}
#tblsort tr td{
	text-align:left;
}
td .textinputplus{
	display:none;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar">
            <div class="scroolbar" style="width:1050px;">
<!--<a href="javascript:void(0);" onClick="$('#content-t').css('display','block');" style="text-decoration:none;">Tạo Payment</a>-->
<div id="content-t" class="content_form" style="padding-top:10px;">
        <?php include_once 'include/toolbar.php'; ?>
         <form id="frmapp" name="frmapp" enctype="multipart/form-data" method="post" action="<?php echo base_url()."?control=projects&func=viewpayment&id_projects=".$_GET['id_projects']; ?>">
 		 <div id="adminfieldset" class="groupsignios" style="width:100%;margin-bottom:0;margin-top:10px;">
            <div class="adminheader">Thông tin tỷ giá</div>
            <div class="group_left">
            	<div class="rows">
                <table class="table" style="width:250px;margin-bottom:0;">
                	<th>MCOIN</th>
                    <th>KNB</th>
					<th>ĐƠN VỊ</th>
                    <th></th>
                    <tr>
                    	<td><input type="text" name="rate_mcoin" id="rate_mcoin" class="textinput" style="width:100px;text-align:center" placeholder="MCOIN" value="<?php echo $getrate['mcoin']==""?1:$getrate['mcoin']; ?>" /></td>
                        <td><input type="text" name="rate_gem" id="rate_gem" class="textinput" style="width:100px;text-align:center;" placeholder="GEM" value="<?php echo $getrate['gem']==""?1:$getrate['gem']; ?>" /></td>
						<td><input type="text" name="units" id="units" class="textinput" style="width:100px;text-align:center;" placeholder="Đơn vị" value="<?php echo $getrate['units']; ?>" /></td>
                        <td style="vertical-align:top;"><input type="submit" name="btn_update_rate" id="btn_update_rate" value="Cập nhật" class="btnB btn-primary" onclick="updaterate();"/></td>
                    </tr>
                    <!--<tr>
                    	<td colspan="2"><input type="submit" name="btn_update_rate" id="btn_update_rate" value="Cập nhật tỷ giá" class="btnB btn-primary" onclick="updaterate();"/></td>
                    </tr>-->
                </table>
               
                </div>
            </div>
        </div>
        </form>
        
        <form id="appForm" name="appForm" action="<?php echo base_url()."?control=projects&func=viewpayment&id_projects=".$_GET['id_projects']."action=add"; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
       
        <div id="adminfieldset" class="groupsignios" style="width:100%;">
            <div class="adminheader">Khai báo thanh toán</div>
            <div class="group_left">
            	<div class="rows">
               			<!--<label for="menu_group_id"></label>-->
               			<select name="cbo_type" id="cbo_type" style="width:80px;">
                            <!--<option value="inapp">InAppItem</option>-->
                            <option value="sms">SMS</option>
                            <option value="sms_7x65">sms_7x65</option>
                            <option value="sms_9029">sms_9029</option>
                            <option value="card">Card</option>
                            <option value="card_gate">card_gate</option>
                            <option value="card_telco">card_telco</option>
                            <option value="banking">Banking</option>
                            <option value="paymentindo">PaymnetIndo</option>
                        </select>
                        <input type="text" name="code" id="code" class="textinput" style="width:150px;" placeholder="Names" onkeypress="runScript(event);"  />
                        <input type="text" name="vnd" id="vnd" class="textinput" style="width:120px;" placeholder="vnd" onkeypress="return checkInp('vnd');" onkeydown="return checkInp('vnd');" /> 
                        <input type="text" name="mcoin" id="mcoin" class="textinput" style="width:120px;" placeholder="mcoin" onkeyup="calrate(this.value);" onkeypress="runScript(event);" onkeydown="return checkInp('mcoin');" />				
                        <input type="text" name="gem" id="gem" class="textinput" style="width:120px;" placeholder="knb" onkeypress="return checkInp('gem');" onkeydown="return checkInp('gem');"/>         				<input type="text" name="promotion_gem" id="promotion_gem" class="textinput" style="width:120px;" placeholder="Promotion knb" onkeypress="runScript(event);"/>
                        <input type="text" name="notes" id="notes" class="textinput" style="width:120px;" placeholder="Notes" onkeypress="runScript(event);" />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addvalues();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a>
               </div>
               <div class="rows" id="in_app" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ol class="payment"></ol>
                    <input type="button" name="btnadd" id="btnadd" value="Lưu" class="btnB btn-primary" onclick="addinapp($('#rate_mcoin').val(),$('#rate_gem').val());"/>
                </div>
                
                <div class="rows">
                	<div id="mess" style="color:#F00;font-size:14px"><?php echo $error; ?></div>
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
      
      <!--Add stype:inapp item-->
      <div id="adminfieldset" class="groupsignios" style="width:100%;">
            <div class="adminheader">Khai báo InApp</div>
            <div class="group_left">
            	<div class="rows">
               			<!--<label for="menu_group_id"></label>-->
               			<select name="cbo_platform" id="cbo_platform" style="width:80px;" onchange="getpackage(<?php echo isset($_GET['id_projects'])?intval($_GET['id_projects']):0; ?>,this.value);">
                        	<option value="0">Platform</option>
                            <?php
                            if(count($tpp1)>0){
                                foreach($tpp1 as $v){
                        ?>
                        <option value="<?php echo $v['platform'];?>" ><?php echo $v['platform'];?></option>
                        <?php
                                }
                            }
                        ?>
                           
                        </select>
                        
                        <select name="cbo_package" id="cbo_package" style="width:100px;">
                            <option value="0">BundleID PackageName PackageIdentity</option>
                        </select>
                         <input type="hidden" name="txt_id_projects_property" id="txt_id_projects_property" />
                        <input type="text" name="code_inapp" id="code_inapp" class="textinput" style="width:150px;" placeholder="Names" onkeypress="runScriptplus(event);"  />
                        <input type="text" name="vnd_inapp" id="vnd_inapp" class="textinput" style="width:120px;" placeholder="vnd" onkeypress="return checkInp('vnd_inapp');" onkeydown="return checkInp('vnd_inapp');" /> 
                        <input type="text" name="mcoin_inapp" id="mcoin_inapp" class="textinput" style="width:120px;" placeholder="mcoin" onkeyup="calrateplus(this.value);" onkeypress="return checkInp('mcoin_inapp');" onkeydown="return checkInp('mcoin_inapp');" />				
                        <input type="text" name="gem_inapp" id="gem_inapp" class="textinput" style="width:120px;" placeholder="knb" onkeypress="return checkInp('gem_inapp');" onkeydown="return checkInp('gem_inapp');"/>         				<input type="text" name="promotion_gem_inapp" id="promotion_gem_inapp" class="textinput" style="width:120px;" placeholder="Promotion knb" onkeypress="runScript(event);"/>
                        <input type="text" name="notes_inapp" id="notes_inapp" class="textinput" style="width:120px;" placeholder="Notes" onkeypress="runScriptplus(event);" />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addvaluesplus();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a>
               </div>
               <div class="rows" id="in_app_plus" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ol class="paymentplus"></ol>
                    <input type="button" name="btnaddplus" id="btnaddplus" value="Lưu" class="btnB btn-primary" onclick="addinappplus($('#rate_mcoin').val(),$('#rate_gem').val());"/>
                </div>
                
                <div class="rows">
                	<div id="messplus" style="color:#F00;font-size:14px"><?php echo $error; ?></div>
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
       <!--End Add stype:inapp item-->
       
            </form>
           
        
        </div> <!--content_form-->
        
       
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
         
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
					
                	 <th align="left" width="40px">Chức năng</th>
					 <th align="left" width="40px"><select name="cbofp" id="cbofp" onchange="setrowsplatform(this.value);" style="width:80px">
                        <option value="all">Platform</option>
                        <option value="ios">IOS</option>
                        <option value="android">Android</option>
                        <option value="wp">WinPhone</option>
                    </select></th>
                     <th width="0" style="display:none"></th>
                    <th width="0" style="display:none"></th>
                    <th align="left" width="50px"><select name="cbof" id="cbof" onchange="setrows(this.value);" style="width:80px">
                    <option value="all">Type</option>
                    <option value="inapp">InAppItem</option>
                    <option value="sms">SMS</option>
                    <option value="sms_7x65">sms_7x65</option>
                    <option value="sms_9029">sms_9029</option>
                    <option value="card">Card</option>
                    <option value="card_gate">card_gate</option>
                    <option value="card_telco">card_telco</option>
                    <option value="banking">Banking</option>
                    <option value="paymentindo">Payment Indo</option>
         	</select></th>
                    <th align="left" width="100px">Names</th>
                    <th align="left" width="50px">Vnd</th>
                    <th align="left" width="50px">Mcoin</th>
                    <th align="left" width="50px">KNB</th>
                     <th align="left" width="30px">Promotion<br/>KNB</th>
					 <th align="left" width="50px">Total KNB</th>
                    <th align="left" width="160px">Notes</th>
                   	<th align="left" width="70px">User</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					$i=0;
                    if(count($listData)>1){
                        foreach($listData as $j=>$v){
							$i++;
                ?>
                <tr id="row_<?php echo $v['id'];?>" class="row_tab">
					
                	<td>
                    <div style="float:left;width:80px;margin:0px;" id="divfunc">
                     <?php  if($_SESSION['account']['id_group']==2|| $_SESSION['account']['id_group']==1 || $_SESSION['account']['id_group']==64 || $_SESSION['account']['id_group']==61 || $_SESSION['account']['id_group']==71 || $_SESSION['account']['id_group']==80 || $_SESSION['account']['id_group']==72){ ?>
                    <!--<a href="<?php echo base_url(); ?>?control=projects&func=logupdate1&table=tbl_projects_property&id=<?php echo $v['id'];?>"  target="_blank" id="log_<?php echo $v['id'];?>" title="Log"><img border="0" width="16" height="16" title="Log" src="<?php echo base_url()?>assets/img/icon/log.jpg"></a>-->
                    <a href="javascript:void(0);" onclick="showhide(<?php echo $v['id'];?>);" id="edit_<?php echo $v['id'];?>" title="Sửa"><img border="0" title="Sửa" src="<?php echo base_url()?>assets/img/icon_edit.png"></a>
                    <a href="javascript:void(0);" onclick="updaterows(<?php echo $v['id'];?>,$('#code_e_<?php echo $v['id'];?>').val(),$('#promotion_gem_e_<?php echo $v['id'];?>').val(),$('#gem_e_<?php echo $v['id'];?>').val(),$('#mcoin_e_<?php echo $v['id'];?>').val(),$('#vnd_e_<?php echo $v['id'];?>').val(),$('#notes_e_<?php echo $v['id'];?>').val())" title="Sửa" id="save_row_<?php echo $v['id'];?>" style="display:none;"><img border="0" width="16" height="16" title="Lưu" src="<?php echo base_url()?>assets/img/icon/save.png"></a>
                    <a href="javascript:void(0);" onclick="showhidei(<?php echo $v['id'];?>);" id="cancel_<?php echo $v['id'];?>" title="Hủy" style="display:none;"><img border="0" title="Hủy" src="<?php echo base_url()?>assets/img/icon/inactive.png"></a>
                    <a onclick="deleteitem(<?php echo $v['id'];?>);" href="javascript:void(0);" title="Xóa"><img border="0" title="Xóa" src="<?php echo base_url()?>assets/img/icon_del.png"></a>  
                    <?php }else{ echo "Không có quyền";} ?>
                    </div>
                    </td>
					<td><?php echo $property[$v['id_projects_property']]['platform']; ?></td>
                    <td style="width:0px;display:none;"><?php echo trim($v['id']);?></td>
                    <td style="width:0px;display:none;"><?php echo trim($v['type']);?></td>
                    <td>
                    <div id="td_text_<?php echo $v['id']; ?>" class="cText"><?php echo $v['type'];?></div>
                    <input type="text" name="cbo_type_e_<?php echo $v['id'];?>" id="cbo_type_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['type'];?>" style="width:50px;" readonly="readonly" />
                   </td>
                   	
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['code'];?></div>
                    <input type="text" name="code_e_<?php echo $v['id'];?>" id="code_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['code'];?>" style="width:250px;" /></td>
                    
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['vnd']==""?0:number_format(trim($v['vnd']));?></div>
                    <input type="text" name="vnd_e_<?php echo $v['id'];?>" id="vnd_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['vnd'];?>" style="width:80px;" onkeypress="return checkInp('vnd_e_<?php echo $v['id'];?>');" onkeydown="return checkInp('vnd_e_<?php echo $v['id'];?>');" /></td>
                   
                 <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                 <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['mcoin']==""?0:number_format(trim($v['mcoin']));?></div>
                 <input type="text" name="mcoin_e_<?php echo $v['id'];?>" id="mcoin_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['mcoin'];?>" style="width:80px;" onkeypress="calrateid(this.value,<?php echo $v['id'];?>);" onkeydown="calrateid(this.value,<?php echo $v['id'];?>);" onkeyup="calrateid(this.value,<?php echo $v['id'];?>);" /></td>
                 
                 <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                 <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['gem']==""?0:number_format(trim($v['gem']));?></div>
                 <input type="text" name="gem_e_<?php echo $v['id'];?>" id="gem_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['gem'];?>"style="width:80px;" onkeypress="return checkInp('gem_e_<?php echo $v['id'];?>');" onkeydown="return checkInp('gem_e_<?php echo $v['id'];?>');"  /></td>
                 
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['promotion_gem']==""?0:number_format(trim($v['promotion_gem']));?></div>
                    <input type="text" name="promotion_gem_e_<?php echo $v['id'];?>" id="promotion_gem_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['promotion_gem'];?>" style="width:80px;" onkeypress="return checkInp('promotion_gem_e_<?php echo $v['id'];?>');" onkeydown="return checkInp('promotion_gem_e_<?php echo $v['id'];?>');"/></td>
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                     <script language="javascript" type="text/javascript">
					  var _x=$('#gem_e_<?php echo $v['id']  ?>').val()==''?0:$('#gem_e_<?php echo $v['id']  ?>').val();
					  var _y=$('#promotion_gem_e_<?php echo $v['id']  ?>').val()==''?0:$('#promotion_gem_e_<?php echo $v['id']  ?>').val();
					  var _knb = _x;
					  var _promo = _y;
					  var _total = parseFloat(_knb) + parseFloat( _promo);
					  document.write('<i style="color:#BB25AE">' + parseFloat(_total).toFixed(0).replace(/./g, function(c, i, a) {
    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
}) + '</i>');
                     </script>
                     </td>
                    <td id="td_control_<?php echo $v['id']  ?>" class="cControll">
                    <div id="td_text_<?php echo $v['id']  ?>" class="cText"><?php echo $v['notes'];?></div> 
                    <!--<textarea name="notes_e_" id="notes_e_"><?php echo $v['notes'];?></textarea>-->
                    <input maxlength="1000" type="text" name="notes_e_<?php echo $v['id'];?>" id="notes_e_<?php echo $v['id'];?>" class="textinputplus" value="<?php echo $v['notes'];?>" /></td>
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
         <div style="float:left;margin-bottom:10px;" id="divpage">
         	<?php echo $pages?>
         </div>
    </form>
         
            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->

<script type="text/javascript" language="javascript">
	function checkInp(itemid){
	  var x=document.getElementById(itemid).value;
	  if (isNaN(x)) 
	  {
		$('#' + itemid +'').val('');
		return false;
	  }
	}
	
	function calrate(_mcoin){
		rate_gem=$('#rate_gem').val();
		rate_mcoin=$('#rate_mcoin').val();
		if(rate_gem=='0' || rate_mcoin=='0')
			return;
		cur_mcoin=$('#mcoin').val();
		cur_gem=Math.floor((cur_mcoin*rate_gem)/rate_mcoin);
		$('#gem').val(cur_gem);
	}
	function calrateplus(_mcoin){
		rate_gem=$('#rate_gem').val();
		rate_mcoin=$('#rate_mcoin').val();
		if(rate_gem=='0' || rate_mcoin=='0')
			return;
		cur_mcoin=$('#mcoin_inapp').val();
		cur_gem=Math.floor((cur_mcoin*rate_gem)/rate_mcoin);
		$('#gem_inapp').val(cur_gem);
	}
	function calrateid(_mcoin,id){
		rate_gem=$('#rate_gem').val();
		rate_mcoin=$('#rate_mcoin').val();
		if(rate_gem=='0' || rate_mcoin=='0')
			return;
		cur_mcoin=$('#mcoin_e_' + id).val();
		cur_gem=Math.floor((cur_mcoin*rate_gem)/rate_mcoin);
		$('#gem_e_' + id).val(cur_gem);
	}
	var j=0;
	var jj=0;
	function runScript(e) {
		if (e.keyCode == 13) {
			addvalues();
			return false;
		}
	}
	function runScriptplus(e) {
		if (e.keyCode == 13) {
			addvaluesplus();
			return false;
		}
	}
	function addvalues(){
		_type=$('#cbo_type').val();
		_code=$('#code').val();
		_vnd=$('#vnd').val()==''?0:$('#vnd').val();
		_mcoin=$('#mcoin').val()==''?0:$('#mcoin').val();
		_gem=$('#gem').val()==''?0:$('#gem').val();
		_promotiongem=$('#promotion_gem').val()==''?0:$('#promotion_gem').val();
		_notes=$('#notes').val();
		if(_code==''){
			alert('Vui lòng không bỏ trống');
			$('#code').focus();
			return false;
		}
		if(_vnd==''){
			alert('Vui lòng không bỏ trống VND');
			$('#vnd').focus();
			return false;
		}
		j++;
		if(_code!=''){
			_value='Type: <i style="color:#090">'+ _type + '</i>; Name:<i style="color:#090">'+ _code + '</i>;VND: <i style="color:#090">'+ _vnd + '</i>; MCOIN: <i style="color:#090">' + _mcoin + '</i>; GEM: <i style="color:#090">' + _gem + '</i>; PROMOTION_GEM: <i style="color:#090">' + _promotiongem + '</i>; Notes: <i style="color:#090">' + _notes + '</i>';
			
			$('#in_app').css('display','block');
			$('ol').prepend("<li id='" + j +"' style='margin-bottom:5px;'>" + _value + " | <a href='javascript:void(0);' onclick='removetext(" + j +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
		}
	}
	function addvaluesplus(){
		_type='inapp';
		_code=$('#code_inapp').val();
		_vnd=$('#vnd_inapp').val()==''?0:$('#vnd_inapp').val();
		_mcoin=$('#mcoin_inapp').val()==''?0:$('#mcoin_inapp').val();
		_gem=$('#gem_inapp').val()==''?0:$('#gem_inapp').val();
		_promotiongem=$('#promotion_gem_inapp').val()==''?0:$('#promotion_gem_inapp').val();
		_notes=$('#notes_inapp').val();
		
		var ipp=$('#cbo_package').val().split(';');
		var id_projects_property=ipp[1];
		
		if(_code==''){
			alert('Vui lòng không bỏ trống');
			$('#code_inapp').focus();
			return false;
		}
		if(_vnd==''){
			alert('Vui lòng không bỏ trống VND');
			$('#vnd_inapp').focus();
			return false;
		}
		jj++;
		if(_code!=''){
			_value='Type: <i style="color:#090">'+ _type + '</i>; Name:<i style="color:#090">'+ _code + '</i>;VND: <i style="color:#090">'+ _vnd + '</i>; MCOIN: <i style="color:#090">' + _mcoin + '</i>; GEM: <i style="color:#090">' + _gem + '</i>; PROMOTION_GEM: <i style="color:#090">' + _promotiongem + '</i>; Notes: <i style="color:#090">' + _notes + ';id:'+ id_projects_property +'</i>';
			
			$('#in_app_plus').css('display','block');
			$('ol').prepend("<li id='" + jj +"' style='margin-bottom:5px;'>" + _value + " | <a href='javascript:void(0);' onclick='removetextplus(" + jj +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
		}
	}
	
	function removetext(j){
		$("li").remove("#"+ j +"");
	}
	function removetextplus(jj){
		$("li").remove("#"+ jj +"");
	}
	
	function updaterate(_mcoin,_gem,_id_projects){
		$.ajax({
                url:'<?php echo base_url()?>?control=projects&func=updaterate',
                type:"GET",
                data:{mcoin:_mcoin,gem:_gem,id_projects:_id_projects},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    //$('.loading_warning').show();
                },
                success:function(f){
					if(f.error==0){
						return true;
					}else{
						return false;
					}
                }
            });
			return false;
	}
	function addinapp(mcoin,gem){
		//get in app array
		var list_array;
		$(".payment li").each(function( index ) {
			list_array += $(this).text();
		});
		_inapp_items=list_array.replace('undefined','');
		if(_inapp_items==''){
			alert('Không bỏ trống !');
			$('#cbo_type').focus();
			return false;
		}
		//cap nhat ty gia
		$bool=updaterate(mcoin,gem,<?php echo $_GET['id_projects']; ?>);
		//add 
		$.ajax({
                url:'<?php echo base_url()?>?control=projects&func=addpaymentplus',
                type:"GET",
                data:{code:_inapp_items,id_projects:<?php echo $_GET['id_projects']; ?>},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    //$('.loading_warning').show();
                },
                success:function(f){
					if(f.error==0){
						$('#cbo_type').val('');
						$("ol li").remove();
						window.location.href='<?php echo base_url(); ?>?control=projects&func=viewpayment&id_projects=<?php echo $_GET['id_projects']; ?>';
					}else{
						alert(f.messg);
					}
                }
            });
		
	}
	function addinappplus(mcoin,gem){
		//get in app array
		var list_array;
		$(".paymentplus li").each(function( index ) {
			list_array += $(this).text();
		});
		_inapp_items=list_array.replace('undefined','');
		if(_inapp_items==''){
			alert('Không bỏ trống !');
			$('#code_inapp').focus();
			return false;
		}
		
		//cap nhat ty gia
		$bool=updaterate(mcoin,gem,<?php echo $_GET['id_projects']; ?>);
		//add 
		$.ajax({
                url:'<?php echo base_url()?>?control=projects&func=addpaymentplusforinapp',
                type:"GET",
                data:{code:_inapp_items,id_projects:<?php echo $_GET['id_projects']; ?>},
                async:false,
                dataType:"json",
                beforeSend:function(){
                    //$('.loading_warning').show();
                },
                success:function(f){
					if(f.error==0){
						$('#code_inapp').val('');
						$("ol li").remove();
						window.location.href='<?php echo base_url(); ?>?control=projects&func=viewpayment&id_projects=<?php echo $_GET['id_projects']; ?>';
					}else{
						alert(f.messg);
					}
                }
            });
		
	}
	
function checkempty(){
	var _code=$('#code').val();
	var _vnd=$('#vnd').val();
	var _gem=$('#gem').val();
	var _mcoin=$('#mcoin').val();
	var _promotion_gem=$('#promotion_gem').val();
			
	if(_code==''){
		alert('Không bỏ trống !');
		$('#code').focus();
		return false;
	}
	document.getElementById('appForm').submit();
}

function showbutton(){
	var _android=document.getElementById('chk_android').checked;
	var _ios=document.getElementById('chk_ios').checked;
	var _wp=document.getElementById('chk_wp').checked;
	if(_ios==false && _android == false && _wp == false){
		$('#btn_add').css('display','none');
	}
	if(_ios == true || _android == true || _wp == true){
		$('#btn_add').css('display','block');
	}
}
function updaterows(id,code_e,promotion_gem_e,gem_e,mcoin_e,vnd_e,notes_e){
	c=confirm('Bạn có muốn lưu không ?');
	if(c){
		if(code_e==''){
			alert('Không bỏ trống cột Names');
			return false;
		}
		$.ajax({
                url:baseUrl+'?control=projects&func=updaterowsinappitem',
                type:"GET",
				data:{id:id,code_e:code_e,promotion_gem_e:promotion_gem_e,gem_e:gem_e,mcoin_e:mcoin_e,vnd_e:vnd_e,notes_e:notes_e},
                async:false,
				dataType:"html",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(response){
                    if(response=='ok'){
						Lightboxt.showemsg('Thông báo','Đã lưu ...', 'Đóng');
						$('.row_tab').css('display','table-row');
						$('#save_row_'+id).css('display','none');
						$('#edit_'+id).css('display','block');
						$('#cancel_'+id).css('display','none');
						$('#log_'+id).css('display','block');
						$('.loading_warning').hide();
						//
						$('.cText').css('display','block');
						$('td .textinputplus').css('display','none');
						window.location.href='?control=projects&func=viewpayment&id_projects=<?php echo $_GET['id_projects']?>';
					}else{
						Lightboxt.showemsg('Thông báo', response, 'Đóng');
						 $('.loading_warning').hide();
					}
                }
            });
		return true;
	}else{
		$('#save_row_'+id).css('display','none');
		$('#edit_'+id).css('display','block');
		$('.row_tab').css('display','table-row');
		$('.loading_warning').hide();
		return false;
	}
}
function showhidei(id){
	$('#divfunc a').css('margin-left','10px');
	$('#divfunc a').css('float','left');
	$('#divfunc').css('width','inherit');
	
	$('#save_row_'+id).css('display','none');
	$('#cancel_'+id).css('display','none');
	$('#edit_'+id).css('display','table-row');
	$('.row_tab').css('display','table-row');
	$('#log_'+id).css('display','table-row');
	//
	$('#cbo_platform_e_text_'+id).css('display','block');
	$('#cbo_platform_e_'+id).css('display','none');
	//
	$('.cText').css('display','block');
	$('td .textinputplus').css('display','none');
}
function showhide(id){
	$('#divfunc a').css('margin-left','10px');
	$('#divfunc a').css('float','left');
	$('#divfunc').css('width','80px');
	
	$('#save_row_'+id).css('display','table-row');
	$('#cancel_'+id).css('display','table-row');
	$('#edit_'+id).css('display','none');
	$('.row_tab').css('display','none');
	$('#row_'+id).css('display','table-row');
	$('#log_'+id).css('display','none');
	//
	$('#cbo_platform_e_text_'+id).css('display','none');
	$('#cbo_platform_e_'+id).css('display','block');
	//
	$('.cText').css('display','none');
	$('td .textinputplus').css('display','block');
}
function deleteitem(id){
	c=confirm('Bạn có muốn xóa không ?');
	if(c){
			$.ajax({
					url:baseUrl+'?control=projects&func=deletelistinappitem',
					type:"GET",
					data:{id:id},
					async:false,
					dataType:"json",
					beforeSend:function(){
						$('.loading_warning').show();
					},
					success:function(f){
						if(f.error==0){
							window.location.href='<?php echo base_url();?>?control=projects&func=viewpayment&id_projects=<?php echo $_GET['id_projects'];?>';
							$('.loading_warning').hide();
						}else{
							Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
							$('.loading_warning').hide();
						}
					}
				});
		return true;
	}else{
		return false;
	}
}
function setrows(_val){
	var _plt = $('#cbofp').val();
	var t = document.getElementById('tblsort');
	var rows = t.rows;
	var sval=_val;
	//loc ket hop
	if(_val == 'inapp'){
		if(_plt != 'all'){
				
				for (var i=1; i <= rows.length; i++) {
					 var cells = rows[i].cells; 
					 var f1 = cells[3].innerHTML;
					 var id = cells[2].innerHTML;
					 var platform = cells[1].innerHTML;
					
					 $('#row_'+id).css('display','none');
					 if(f1 == sval && _plt == platform){
						$('#row_'+id).css('display','table-row');
					 }
					 if(_val=='all'){
						$('.row_tab').css('display','table-row');
						
					 }
				}
				return;
		}
		
	}
	
	for (var i=0; i<rows.length; i++) {
		 var cells = rows[i].cells; 
		 var f1 = cells[3].innerHTML;
		 var id = cells[2].innerHTML;
		 $('#row_'+id).css('display','table-row');
		 if(f1 != sval){
			$('#row_'+id).css('display','none');
		 }
		 if(_val=='all'){
			$('.row_tab').css('display','table-row');
			
		 }
    }
}
function setrowsplatform(_val){
	var t = document.getElementById('tblsort');
	var rows = t.rows;
	var sval=_val;
	for (var i=0; i<rows.length; i++) {
		 var cells = rows[i].cells; 
		 var f1 = cells[1].innerHTML;
		 var id = cells[2].innerHTML;
		 $('#row_'+id).css('display','table-row');
		 if(f1 != sval){
			$('#row_'+id).css('display','none');
		 }
		 if(_val=='all'){
			$('.row_tab').css('display','table-row');
			
		 }
    }
}
function getpackage(id_projects,platform){
	$.ajax({
		url:baseUrl+'?control=projects&func=getpackage',
		type:"GET",
		data:{id_projects:id_projects,platform:platform},
		async:false,
		dataType:"json",
		beforeSend:function(){
			$('.loading_warning').show();
		},
		success:function(f){
			if(f.error==0){
				$("#cbo_package").html(f.html);
				$('.loading_warning').hide();
			}else{
				$("#cbo_package").html(f.html);
				$('.loading_warning').hide();
			}
		}
	});
}
	
</script>
