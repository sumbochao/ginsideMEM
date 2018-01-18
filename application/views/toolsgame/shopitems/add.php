
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
.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
}
.head{
	display:none;
}
.textinputplus{
	border:none !important;
}
.content_form .groupsignios .rows {
    margin-bottom:1px;
}
.content_form .groupsignios .textinput {
    margin-bottom:1px;
}
.content_form .groupsignios select {
    margin-bottom:1px;
}
.content_form .groupsignios table tr td {
   text-align:left;
}
.rows_t{
	display:none;
}
.groupsignios{
	clear:both;
	float:left;
}
.group_left .rows{
	margin-bottom:0;
}
</style>
<div class="loading_warning" style="text-align:center">
<img src="<?php echo base_url('assets/img/icon/loading_sign.gif'); ?>" />
</div>


<div class="wrapper_scroolbar">
 <div class="scroolbar" style="width:1050px;">
    
<div id="content-t" class="content_form" style=" padding-top:10px">

    <form id="appForm" action="" method="post" name="appForm" enctype="multipart/form-data" class="form-horizontal">
        <?php include_once 'include/toolbar.php'; ?>
 
        <div id="adminfieldset" class="groupsignios" style="height:auto;width:100%">
        	<div class="option_error" style="color:#369211;font-weight:bold;">
                		<?php echo $Mess;?>
            </div> <!--option_error-->
            <div class="adminheader">Thông tin Gói quà</div>
            <div class="group_left">

                <div class="rows">	
                    <label for="menu_group_id">Game</label>
                    <select name="game_id" id="game_id" class="chosen-select" tabindex="2" data-placeholder="Chọn danh mục">
                        <option value="0">Chọn game</option>
                        <?php
                            if(count($slbGame)>0){
                                foreach($slbGame as $v){
                        ?>
                        <option value="<?php echo $v['service_id']?>"><?php echo $v['app_fullname'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Tên gói quà</label>
                    <input type="text" name="titles_pack" id="titles_pack" class="textinput" maxlength="100" />
                </div>
                 <div class="rows">	
                    <label for="menu_group_id">Mô tả ngắn</label>
                    <input type="text" name="desc_pack" id="desc_pack" class="textinput" maxlength="100"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Link hình gói quà</label>
                    <input type="text" name="img_pack" id="img_pack" class="textinput"/>
                    <!--<input type="file" name="img_file" id="img_file" accept=".jpg,.png"/>
                    <div style="padding-left:152px;color:#F00;">Tên file không bao gồm ký tự lạ (.jpg,.png) </div>-->
                </div>
              	<div class="rows">	
                    <label for="menu_group_id">Số lượng</label>
                    <input type="text" name="num_pack" id="num_pack" value="1" class="textinput" maxlength="20" style="width:50px;text-align:center" onkeypress="return checkInp('num_pack');" onkeydown="return checkInp('num_pack');" onkeyup="return checkInp('num_pack');"/>
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Số lần mua trong ngày </label>
                    <input type="text" name="limit_buy_day" id="limit_buy_day" class="textinput" value="-1" maxlength="20" style="width:50px;text-align:center" onkeypress="return checkInp('limit_buy_day');" onkeydown="return checkInp('limit_buy_day');" onkeyup="return checkInp('limit_buy_day');"/>(Nếu = -1 là không giới hạn)
                </div>
                <div class="rows" style="width:800px;">	
                    <label for="menu_group_id">Ngày bắt đầu</label>
       <input type="text" id="start_date_pack" name="start_date_pack" value="" class="datepicker">
         
                    Ngày kết thúc
       <input type="text" id="expired_date_pack" name="expired_date_pack" value="" class="datepicker">
                </div>
                <div class="rows">	
                    <label for="menu_group_id">Hình thức mua</label>
                    <input type="text" name="values_query" id="values_query" class="textinput" placeholder="1,2" maxlength="100"/>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <!-- end part 1 -->
        
        
   
        <!--Add stype:inapp item-->
      <div id="adminfieldset" class="groupsignios" style="width:100%">
            <div class="adminheader">Khai báo Shop bán</div>
            <div>
            	<div class="rows">
               			<!--<label for="menu_group_id"></label>-->
               			<select name="cbo_shop" id="cbo_shop" style="width:130px;" onchange="changeShop(this.value)">
                        	<option value="-1">-- Loại Shop --</option>
                            <?php
                            if(count($slbShop)>0){
                                foreach($slbShop as $v){
                        ?>
                        <option value="<?php echo $v['id'];?>" ><?php echo $v['shop_name'];?></option>
                        <?php
                                }
                            }
                        ?>
                           
                        </select>
                        <input type="text" name="txt_gia" id="txt_gia" class="textinput" style="width:200px;" placeholder="Giá bán" onkeypress="return checkInp('txt_gia');" onkeyup="return checkInp('txt_gia');" onkeydown="return checkInp('txt_gia');"  />
                        <input type="text" name="txt_gia_giam" id="txt_gia_giam" class="textinput" style="width:200px;" placeholder="Giá cup" onkeypress="return checkInp('txt_gia_giam');" onkeyup="return checkInp('txt_gia_giam');" onkeydown="return checkInp('txt_gia_giam');"  />
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addvaluesplus();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a>
               </div>
               <div class="rows" id="in_app_plus" style="display:none;">	
                    <label for="menu_group_id"></label>
                    <ul class="paymentplus"></ul>
                </div>
                
                <div class="rows">
                	<div id="messplus" style="color:#F00;font-size:14px"><?php echo $error; ?></div>
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
       <!--End Add stype:inapp item-->
       
        <!--Add stype:inapp item-->
      <div id="adminfieldset" class="groupsignios" style="width:100%;">
            <div class="adminheader">Khai báo Items</div>
            <div class="group_left" style="width:750px;">
            	<div class="rows">
                        <input type="text" name="items_id" id="items_id" class="textinput" style="width:150px;" placeholder="Item ID" />
                        <input type="text" name="items_name" id="items_name" class="textinput" style="width:120px;" placeholder="Tên Items" /> 
                        <input type="text" name="items_count" id="items_count" class="textinput" style="width:120px;" placeholder="Số lượng" onkeypress="return checkInp('items_count');" onkeydown="return checkInp('items_count');" onkeyup="return checkInp('items_count');" />				
                        <input type="text" name="items_rate" id="items_rate" class="textinput" style="width:120px;" placeholder="Rate" onkeypress="return checkInp('items_rate');" onkeydown="return checkInp('items_rate');" onkeyup="return checkInp('items_rate');"/>  
                        <input type="text" name="items_type" id="items_type" class="textinput" style="width:120px;" placeholder="Type" />
                      
                    <a href="javascript:void(0);" title="Thêm mới" onclick="addvalues();">
                    <img src="<?php echo base_url()?>assets/img/icon/cong.png" alt="Thêm mới" id="imgact" />
                    </a>
               </div>
               <div class="rows" id="in_app">	
                    <label for="menu_group_id"></label>
                    <ol class="payment"></ol>
           
                </div>
                
                <div class="rows">
                	<div id="mess" style="color:#F00;font-size:14px"><?php echo $error; ?></div>
                </div>
        </div> <!--group_left-->
       </div> <!--groupsignios-->
	   <div id="adminfieldset" class="groupsignios" style="width:100%;">
            <div class="adminheader">Extent rule</div>
            <div class="group_left" style="width:750px;">
                <?php include_once 'extend_rules.php';?>
            </div> <!--group_left-->
        </div> <!--groupsignios-->
       <!--End Add stype:inapp item-->
 		<input type="hidden" name="js_list_array_cost" id="js_list_array_cost" />
        <input type="hidden" name="js_list_array_items" id="js_list_array_items" />
        <input type="submit" name="btn_add" id="btn_add" value="Lưu " onclick="addpack();" />
  
    </form>
   	

	
</div> <!--content-t-->

 </div>
</div> <!--wrapper_scroolbar-->

 

    
<script type="text/javascript">
 	var i=0;
	var j=0;
	var _val_json_cost = new Array();
	var _val_json_items = new Array();
	
	$(document).ready(function() {
			
			$('input[name=start_date_pack]').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'hh:mm:ss'//
			});
			
			$('input[name=expired_date_pack]').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'hh:mm:ss'//
			});
	$("#txt_gia_giam").hide();
		});
        function changeShop(id){
            if(id==3){
                $("#txt_gia_giam").show();
            }else{
                 $("#txt_gia_giam").hide();
            }
        }	
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	function maxLength(el) {    
		if (!('maxLength' in el)) {
			var max = el.attributes.maxLength.value;
			el.onkeypress = function () {
				if (this.value.length >= max) return false;
			};
		}
	}
	//maxLength(document.getElementById("notes"));
	function checkInp(itemid){
	  var x=document.getElementById(itemid).value;
	  if (isNaN(x)) 
	  {
		$('#' + itemid +'').val('');
		return false;
	  }
	}

	
	function addvaluesplus(){
		_gia=$('#txt_gia').val();
                _gia_giam=$('#txt_gia_giam').val();
		_type_shop=$('#cbo_shop').val();
		_name_shop=$('#cbo_shop option:selected').text();
		
		if(_type_shop==-1){
			alert('Vui lòng chọn loại Shop');
			$('#cbo_shop').focus();
			return false;
		}
		if(_gia.trim()==''){
			alert('Vui lòng không bỏ trống');
			$('#txt_gia').focus();
			return false;
		}
		
		j++;
		
		
		if(_gia!=''){
                        if(_type_shop==3){
                            _value='Type: <i style="color:#090">'+ _type_shop + '</i>; Name:<i style="color:#090">'+ _name_shop + '</i>;Giá : <i style="color:#090">'+ _gia + '</i>;Cup : <i style="color:#090">'+ _gia_giam + '</i>';
                        }else{
                            _value='Type: <i style="color:#090">'+ _type_shop + '</i>; Name:<i style="color:#090">'+ _name_shop + '</i>;Giá : <i style="color:#090">'+ _gia + '</i>';
                        }
			$('#in_app_plus').css('display','block');
			$('#in_app_plus ul').prepend("<li id='" + j +"' style='margin-bottom:5px;'>" + _value + " | <a href='javascript:void(0);' onclick='removetextplus(" + j +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
			//tạo json
                        if(_type_shop==3){
                            _val_json_cost[j] = '"' + _type_shop + '":"' + _gia+'_'+_gia_giam+'"';
                        }else{
                            _val_json_cost[j] = '"' + _type_shop + '":' + _gia +'';
                        }
		}
		
	} //end func
	
	function addvalues(){
		_items_id=$('#items_id').val();
		_items_name=$('#items_name').val();
		_items_count=$('#items_count').val();
		_items_rate=$('#items_rate').val();
		_items_type=$('#items_type').val();
		
		if(_items_id.trim()==''){
			alert('Vui lòng không bỏ trống items id');
			$('#items_id').focus();
			return false;
		}
		if(_items_name.trim()==''){
			alert('Vui lòng không bỏ tên Items');
			$('#items_name').focus();
			return false;
		}
		if(_items_count==''){
			alert('Vui lòng nhập số lượng');
			$('#items_count').focus();
			return false;
		}
		
		i++;
		if(_items_id!=''){
			_value='Items id: <i style="color:#090">'+ _items_id + '</i>; Items Name:<i style="color:#090">'+ _items_name + '</i>;Items Count: <i style="color:#090">'+ _items_count + '</i>; Items rate: <i style="color:#090">' + _items_rate + '</i>; Items Type: <i style="color:#090">' + _items_type + '</i>';
			
			$('#in_app').css('display','block');
			$('ol').prepend("<li id='" + i +"' style='margin-bottom:5px;'>" + _value + " | <a href='javascript:void(0);' onclick='removetext(" + i +");'><img src='<?php echo base_url()?>assets/img/icon/tru.png'/></a> </li>");
			//tạo json
			_val_json_items[i] ='{"item_id":"' + _items_id + '","item_name":"' + _items_name + '","count":' + _items_count + ',"rate":' + _items_rate + ',"type":"' + _items_type + '"}';
			
		}
	}//end func
	
	function removetext(j){
		$("li").remove("#"+ j +"");
		delete _val_json_items[j];
		_val_json_items.clean(undefined);
	}
	function removetextplus(jj){
		$("li").remove("#"+ jj +"");
		delete _val_json_cost[jj];
		_val_json_cost.clean(undefined);
	}
	
	
	function addpack(){
		//var _js_list_array_cost= JSON.stringify(_val_json_cost.filter(Boolean));
		var _json_cost= '{' + _val_json_cost.filter(Boolean) + '}';
		var _json_items= '[' + _val_json_items.filter(Boolean) + ']';
		
		
		
		if(_json_cost=='{}'){
			alert('Vui lòng nhập giá Shop');
		}else{
			$('#js_list_array_cost').val(_json_cost);
		}
		
		if(_json_items=='[]'){
			alert('Vui lòng tạo Items');
		}else{
			$('#js_list_array_items').val(_json_items);
		}
		
	}//end func
	
</script>