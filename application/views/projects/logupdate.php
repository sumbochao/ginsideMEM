<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <!--<div class="filter">
        	<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="Nhập từ khóa ..." title="Nhập từ khóa ..." maxlength="20" style="width:350px;"/>
           
            <?php 
                if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                }else{
                    $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
                }
            ?>
            <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>
            <strong style="color:#F00;padding-left:20px;"><?php echo base64_decode($_GET['info']);?></strong>   
        </div>-->
        <div class="wrapper_scroolbar">
            <div class="scroolbar">
        <div id="paging_div" style="float:left;margin-bottom:5px;">
        	<?php echo $pages?>
        </div> <!--paging_div-->
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>User</th>
                    <th>Ngày</th>
                    <th>Action</th>
                    <th></th>
                    <th>ID cập nhật</th>
                    <th>Mã dự án</th>
                    <th>Tên dự án</th>
                    <th>Tên cài đặt</th>
                    <th>Service Key App</th>
                    <th>Service Key</th>
                    <th>FacebookAppID</th>
                    <th>Facebook AppSecret</th>
                    <th>AppleID</th>
                    <th>GA Code</th>
                    <th>Appsflyer ID</th>
                    <th>Google AdWords Conversion Tracking Code IOS</th>
                    <th>Google Sender_ID (GCM)</th>
                    <th>Google API key (GCM)</th>
                     <th>URL Schemes</th>
                     <th>Facebook URL Schemes</th>
                    <th>Facebook Fanpage Link</th>
                    <th>Ghi chú</th>
                    <th>Màn hình</th>
                 	<th>ConfigLogout</th>
                    <th>DefaultLanguageSDK</th>
                    <th>Folder</th>
                </tr>
            </thead>
            <tbody>
                <?php
				$i=0;
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
							$i++;
							$r1=explode(",",$v['logs']);
                ?>
                <tr>
                  
                
                    <td align="left"><?php echo $i;?></td>
                    <td align="left"><strong style="color:#900"><?php echo $slbUser[$v['username']]['username'];?></strong></td>
                     <td align="left"><?php echo $v['timesmodify'];?></td>
                    <td align="left"><?php echo $v['actions'];?></td>
                    <td align="left"></td>
                     <td align="left"><?php echo $v['id_actions'];?></td>
                     <td align="left"><?php $rw=explode(":",$r1[1]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[2]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[3]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[4]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[5]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[7]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[8]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[10]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[11]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[12]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[13]); echo base64_decode($rw[1]);?></td>
                     <td align="left"><?php $rw=explode(":",$r1[16]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[17]); echo str_replace('"','',json_decode($rw[1]));?></td>
                    <td align="left"><?php $rw=explode(":",$r1[14]); echo str_replace('"','',json_decode($rw[1]));?></td>
                    <td align="left"><?php $rw=explode(":",$r1[15]); echo str_replace('"','',json_decode($rw[1]));?></td>
                    <td align="left"><?php $rw=explode(":",$r1[18]); echo str_replace('"','',json_decode($rw[1]));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[21]); echo str_replace(array('"','}'),'',json_decode(json_encode($rw[1])));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[22]); echo str_replace(array('"','}'),'',json_decode(json_encode($rw[1])));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[24]); echo str_replace(array('"','}'),'',json_decode(json_encode($rw[1])));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[25]); echo str_replace(array('"','}'),'',json_decode(json_encode($rw[1])));?></td>
                     <td align="left"><?php $rw=explode(":",$r1[26]); echo str_replace(array('"','}'),'',json_decode(json_encode($rw[1])));?></td>
                    
                    
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
<script language="javascript">
checkdata();
function checkdata(){
	var t = document.getElementById('tblsort');
	var rows = t.rows;
	for (var i=1; i<rows.length; i++) {
		 var cells = rows[i].cells; 
			 var f6 = cells[6].innerHTML;
			 var f7 = cells[7].innerHTML;
			 var f8 = cells[8].innerHTML;
			 var f9 = cells[9].innerHTML;
			 var f10 = cells[10].innerHTML;
			 var f11 = cells[11].innerHTML;
			 var f12 = cells[12].innerHTML;
			 var f13 = cells[13].innerHTML;
			 var f14 = cells[14].innerHTML;
			 var f15 = cells[15].innerHTML;
			 var f16 = cells[16].innerHTML;
			 var f17 = cells[17].innerHTML;
			 var f18 = cells[18].innerHTML;
			 var f19 = cells[19].innerHTML;
			 var f20 = cells[20].innerHTML;
			 var f21 = cells[21].innerHTML;
			 var f22 = cells[22].innerHTML;
			 //var f23 = cells[23].innerHTML;
			 var f24 = cells[24].innerHTML;
			 var f25 = cells[25].innerHTML;
			 var f26 = cells[26].innerHTML;
			 
	   var cells1 = rows[i+1].cells;
	   		 var f6c = cells1[6].innerHTML;
			 var f7c = cells1[7].innerHTML;
			 var f8c = cells1[8].innerHTML;
			 var f9c = cells1[9].innerHTML;
			 var f10c = cells1[10].innerHTML;
			 var f11c = cells1[11].innerHTML;
			 var f12c = cells1[12].innerHTML;
			 var f13c = cells1[13].innerHTML;
			 var f14c = cells1[14].innerHTML;
			 var f15c = cells1[15].innerHTML;
			 var f16c = cells1[16].innerHTML;
			 var f17c = cells1[17].innerHTML;
			 var f18c = cells1[18].innerHTML;
			 var f19c = cells1[19].innerHTML;
			 var f20c = cells1[20].innerHTML;
			 var f21c = cells1[21].innerHTML;
			 var f22c = cells1[22].innerHTML;
			 //var f23c = cells1[23].innerHTML;
			 
			 var f25c = cells1[25].innerHTML;
			 var f26c = cells1[26].innerHTML;
			 var f24c = cells1[24].innerHTML;
	   //so sanh
	        if(f6!=f6c){ cells[6].style.backgroundColor='#00FFFF';}
			if(f7!=f7c){ cells[7].style.backgroundColor='#00FFFF';}
			if(f8!=f8c){ cells[8].style.backgroundColor='#00FFFF';}
			if(f9!=f9c){ cells[9].style.backgroundColor='#00FFFF';}
			if(f10!=f10c){ cells[10].style.backgroundColor='#00FFFF';}
			if(f11!=f11c){ cells[11].style.backgroundColor='#00FFFF';}
			if(f12!=f12c){ cells[12].style.backgroundColor='#00FFFF';}
			if(f13!=f13c){ cells[13].style.backgroundColor='#00FFFF';}
			if(f14!=f14c){ cells[14].style.backgroundColor='#00FFFF';}
			if(f15!=f15c){ cells[15].style.backgroundColor='#00FFFF';}
			if(f16!=f16c){ cells[16].style.backgroundColor='#00FFFF';}
			if(f17!=f17c){ cells[17].style.backgroundColor='#00FFFF';}
			if(f18!=f18c){ cells[18].style.backgroundColor='#00FFFF';}
			if(f19!=f19c){ cells[19].style.backgroundColor='#00FFFF';}
			if(f20!=f20c){ cells[20].style.backgroundColor='#00FFFF';}
			if(f21!=f21c){ cells[21].style.backgroundColor='#00FFFF';}
			if(f22!=f22c){ cells[22].style.backgroundColor='#00FFFF';}
			//if(f23!=f23c){ cells[23].style.backgroundColor='#00FFFF';}
			if(f24!=f24c){ cells[24].style.backgroundColor='#00FFFF';}
			if(f25!=f25c){ cells[25].style.backgroundColor='#00FFFF';}
			if(f26!=f26c){ cells[26].style.backgroundColor='#00FFFF';}
			
		
			
    }
}
</script>