<?php
//echo $catego->CreateControlGroupSearch();
$categories=$obj_categories->listCategorisParentInTemp(intval($_GET['id_game']),intval($_GET['id_template']));
?>
<!--<select name="cbo_status">
 	<option value="">-- Chọn tình trạng --</option>
 	<option value="None" <?php echo $_POST['cbo_status']=="None"?"selected":""; ?> >None</option>
    <option value="Pass" <?php echo $_POST['cbo_status']=="Pass"?"selected":""; ?>>Pass</option>
    <option value="Fail" <?php echo $_POST['cbo_status']=="Fail"?"selected":""; ?>>Fail</option>
    <option value="Cancel" <?php echo $_POST['cbo_status']=="Cancel"?"selected":""; ?>>Cancel</option>
   <option value="Pending" <?php echo $_POST['cbo_status']=="Pending"?"selected":""; ?>>Pending</option>
   <option value="InProccess" <?php echo $_POST['cbo_status']=="InProccess"?"selected":"";?>>InProccess</option>
 </select>-->
 
 <!--<select name="cbo_loai">
 	<option value="">-- Chọn loại --</option>
 	<option value="ios" <?php echo $_POST['cbo_loai']=="ios"?"selected":""; ?> >IOS</option>
    <option value="android" <?php echo $_POST['cbo_loai']=="android"?"selected":""; ?>>Android</option>
    <option value="wp" <?php echo $_POST['cbo_loai']=="wp"?"selected":""; ?>>WP</option>
    <option value="pc" <?php echo $_POST['cbo_loai']=="pc"?"selected":""; ?>>PC Platform</option>
   <option value="web" <?php echo $_POST['cbo_loai']=="web"?"selected":""; ?>>Config</option>
   <option value="events" <?php echo $_POST['cbo_loai']=="events"?"selected":"";?>>Event</option>
   <option value="systems" <?php echo $_POST['cbo_loai']=="systems"?"selected":"";?>>System</option>
   <option value="orther" <?php echo $_POST['cbo_loai']=="other"?"selected":"";?>>Other</option>
 </select>-->

<!--<input type="submit" name="btnfilter" id="btnfilter" value="Lọc Client" class="btnB btn-primary" />
<input type="submit" name="btnfilter_admin" id="btnfilter_admin" value="Lọc Admin" class="btnB btn-primary" />-->
<br />
<style>
.lbl{
	width:70px;
}
.td_color{
	background-color:#40464A;
}
.frmBtn{
    margin-bottom: 0px !important;
}
</style>
<style>
    #addmail.modal{
        top:1%;left: 1%;right:1%;
        background: #FFF;
        overflow: visible;
        border-radius: 5px;
        height: 625px;
    }
    #addmail .modal-header{
        padding: 0px 0px 0px 10px;
    }
    #addmail .modal-footer{
        padding:10px 20px 20px 19px;
    }
    #addmail .modal-header .close{
        margin-right: 10px;
    }
    @media (max-width:999px){
        .modal-footer{
            margin-top: 0px;
        }
    }
    .modal-footer{
        margin-top: 32px;
    }
</style>
<table class="table table-bordered">
	<!--<thead>
        <th>Tìm kiếm nâng cao</th>
        <th>User/Admin</th>
    </thead>-->
    <tbody>
    	<tr>
        	<td class="td_color">
			<?php echo $catego->CreateControlGroupSearch();?>
            <select name="cbo_categories" id="cbo_categories">
                <option value=""> -- Hạng Mục -- </option>
                <?php
                    if(count($categories)>0){
                        foreach($categories as $item){
              
                ?>
                    <option value="<?php echo $item['id'];?>" <?php echo $item['id']==$_POST['cbo_categories']?'selected="selected"':'';?>><?php echo $item['names'];?></option>
                   
                <?php
                        }
                    }
                ?>
            </select>
            <input type="checkbox" name="chk_status_none" id="chk_none" value="NULL" <?php echo $_POST['chk_status_none']=="NULL"?"checked":"";  ?> />
            <label class="lbl" for="chk_none">None</label>
            <input type="checkbox" name="chk_status_pass" id="chk_pass" value="Pass" <?php echo $_POST['chk_status_pass']=="Pass"?"checked":"";  ?> />
            <label class="lbl" for="chk_pass" >Pass</label>
            <input type="checkbox" name="chk_status_fail" id="chk_fail" value="Fail" <?php echo $_POST['chk_status_fail']=="Fail"?"checked":"";  ?> />
            <label class="lbl" for="chk_fail" >Fail</label>
            <input type="checkbox" name="chk_status_cancel" id="chk_cancel" value="Cancel" <?php echo $_POST['chk_status_cancel']=="Cancel"?"checked":"";  ?> />
            <label class="lbl" for="chk_cancel" >Cancel</label>
            <input type="checkbox" name="chk_status_pending" id="chk_pending" value="Pending" <?php echo $_POST['chk_status_pending']=="Pending"?"checked":"";  ?> />
            <label class="lbl" for="chk_pending" >Pending</label>
            <input type="checkbox" name="chk_status_inproccess" id="chk_inproccess" value="InProccess" <?php echo $_POST['chk_status_inproccess']=="InProccess"?"checked":"";  ?> />
            <label class="lbl" for="chk_inproccess" >InProccess</label>
            
            <!--<input type="hidden" name="cbo_status" id="cbo_status" value="" />-->
            </td>
            <td class="td_color">
				<?php if(ViewGroup::$group_admin==-1){ ?>
                <a href="#addmail" onclick="loadIframecontentMail();" data-toggle="modal" class="btnB btn-primary frmBtn" <?php echo isset($_POST['btnfilter'])?"style='color:red'":""; ?> />Gửi mail</a>&nbsp;&nbsp;
                <?php }//end if ?>
				<input type="submit" name="btnfilter" id="btnfilter" value="Lọc User" class="btnB btn-primary" <?php echo isset($_POST['btnfilter'])?"style='color:red'":""; ?> />&nbsp;&nbsp;
                <input type="submit" name="btnfilter_admin" id="btnfilter_admin" value="Lọc Admin" class="btnB btn-primary" <?php echo isset($_POST['btnfilter_admin'])?"style='color:red'":""; ?> />
            </td>
        </tr>
    </tbody>
</table>
<script>
    function loadIframecontentMail() {
        var title = $('select[name="cbo_categories"]').find(":selected").text();
        var cbo_group = $('select[name="cbo_group"]').val();
        var cbo_categories = $('select[name="cbo_categories"]').val();
        if($('input[name=chk_status_none]:checked').val()!=undefined){
            var chk_status_none = $('input[name=chk_status_none]:checked').val();
        }else{
            var chk_status_none = "";
        }
        if($('input[name=chk_status_pass]:checked').val()!=undefined){
            var chk_status_pass = $('input[name=chk_status_pass]:checked').val();
        }else{
            var chk_status_pass = "";
        }
        if($('input[name=chk_status_fail]:checked').val()!=undefined){
            var chk_status_fail = $('input[name=chk_status_fail]:checked').val();
        }else{
            var chk_status_fail = "";
        }
        if($('input[name=chk_status_cancel]:checked').val()!=undefined){
            var chk_status_cancel = $('input[name=chk_status_cancel]:checked').val();
        }else{
            var chk_status_cancel = "";
        }
        if($('input[name=chk_status_pending]:checked').val()!=undefined){
            var chk_status_pending = $('input[name=chk_status_pending]:checked').val();
        }else{
            var chk_status_pending = "";
        }
        if($('input[name=chk_status_inproccess]:checked').val()!=undefined){
            var chk_status_inproccess = $('input[name=chk_status_inproccess]:checked').val();
        }else{
            var chk_status_inproccess = "";
        }
        var arrParam = '&cbo_group='+cbo_group+'&cbo_categories='+cbo_categories+'&chk_status_none='+chk_status_none+'&chk_status_pass='+chk_status_pass+'&chk_status_fail='+chk_status_fail+'&chk_status_cancel='+chk_status_cancel+'&chk_status_pending='+chk_status_pending+'&chk_status_inproccess='+chk_status_inproccess;
        $(".titlemail").text(title);
        jQuery("#ifmmail").html('<iframe style="width:100%;height:450px;border:0px;" id="ifmservercontent" src="<?php echo APPLICATION_URL;?>?control=gamechecklisttemp&func=viewmail&module=all&iframe=1&id_game=<?php echo $_GET['id_game']; ?>&id_template=<?php echo $_GET['id_template'];?>'+arrParam+'"></iframe>');
    } 
</script>
<div id="addmail" class="modal">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button" id="ifr">×</button>
        <h3 class="titlemail">Xác nhận</h3>
    </div>
    <div class="modal-body" id="ifmmail"></div>
    <div class="modal-footer">
        <a data-dismiss="modal" class="btn btn-default btn_cancel" href="#">Bỏ qua</a>
    </div>
</div>
<script language="javascript" type="text/javascript">
//hàm lọc kết quả checklist
function search_plus(loai){
	var _gr = $('#cbo_group').val();
	var _cate = $('#cbo_categories').val();
	var _str_status= '[{"none":' + $('#chk_none').prop("checked") + '},{"pass":' + $('#chk_pass').prop("checked") + '},{"fail":' + $('#chk_fail').prop("checked") + '},{"cancel":' + $('#chk_cancel').prop("checked") + '},{"pending":' + $('#chk_pending').prop("checked") + '},{"inproccess":' + $('#chk_inproccess').prop("checked") + '}]';
	$('#cbo_status').val(_str_status);
	/*try{
		$('#tblsort').css('display','none');
		$.ajax({
                url:baseUrl+'?control=gamechecklisttemp&func=search_plus',
                type:"GET",
				data:{loai:loai,group:_gr,cate:_cate,status:_str_status,id_game:<?php echo $_GET['id_game'] ?>},
                async:false,
				dataType:"json",
                beforeSend:function(){
                    $('.loading_warning').show();
                },
                success:function(f){
                    if(f.error==0){
						$('#search_plus_ajax').html(f.html);
					}else{
						$('#search_plus_ajax').html(f.html);
					}
					$('.loading_warning').hide();
                }
            });
			
	}catch(err){
		
	}*/
	
} //end func

</script>