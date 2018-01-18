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
                    <th>ID cập nhật</th>
                    <th>Platform</th>
                    <th>BundleID/PackageName</th>
                    <th>App ID</th>
                    <th>Public Key</th>
                    <th>Wp(Publisher)</th>
                    <th>Wp(Properties)</th>
                    <th>APN Pass</th>
                    <th>API Key G+</th>
                    <th>Client ID G+</th>
                    <th>Client Secret</th>
                    <th>Url Scheme</th>
                    <th>Google AdWords</th>
                    <th>Facebook AppID</th>
                    <th>Facebook AppSecret</th>
                    <th>Facebook Schemes</th>
                    <th>Notes</th>
                    <!--<th  width="100px">Log</th>
                    <th  width="100px">Url</th>-->
                    <!--<th width="100px">IP Address</th>
                     <th  width="100px">Browser</th> 
                     <th  width="100px">Device</th>
                    <th  width="100px">Session</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
				$i=0;
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
							$i++;
							/*$r1=explode(",",$v['logs']);*/
							$r1=json_decode($v['logs']);
							
                ?>
                <tr>
                  
                	<!--stt 0-->
                    <td align="left"><?php echo $i;?></td>
                     <!--user 1-->
                    <td align="left"><strong style="color:#900"><?php echo $slbUser[$v['username']]['username'];?></strong></td>
                    <!--ngay 2-->
                     <td align="left"><?php echo $v['timesmodify'];?></td>
                     <!--action 3-->
                    <td align="left"><?php echo $v['actions'];?></td>
                     <!--id cap nhat 4-->
                     <td align="left"><?php echo $v['id_actions'];?></td>
                     <!--platform 5-->
                     <td align="left"><?php echo $r1->{'platform'};?></td>
                     <!--BundleID/PackageName-->
                     <td align="left"><?php echo $r1->{'package_name'};?></td>
                     <!--app_id-->  
                     <td align="left"><?php echo $r1->{'app_id'};?></td>
                     <!--Public Key-->
                     <td align="left"><?php echo $r1->{'public_key'};?></td>
                     
                     <!--Wp(Publisher)-->
                     <td align="left"><?php echo $r1->{'wp_p1'};?></td>
                     <!--Wp(Properties)-->
                     <td align="left"><?php echo $r1->{'wp_p2'};?></td>
             
             			<!--APN Pass-->
                     <td align="left"><?php echo $r1->{'pass_certificates'};?></td>
                     <!--API Key G+-->
                    <td align="left"><?php echo $r1->{'api_key'};?></td>
                    <!--Client ID G+-->
                    <td align="left"><?php echo $r1->{'client_key'};?></td>
                    <!--Client Secret-->
                    <td align="left"><?php echo $r1->{'client_secret'};?></td>
                    <!--Url Scheme-->
                     <td align="left"><?php echo $r1->{'url_scheme'};?></td>
                    <!--Google Adword-->
                     <td align="left"><?php echo $r1->{'googleproductapi'};?></td>
                     <!--Facebook AppID-->
                     <td align="left"><?php echo $r1->{'fb_appid'};?></td>
                     <!--Facebook AppSecret-->
                     <td align="left"><?php echo $r1->{'fb_appsecret'};?></td>
                     <!--Facebook Schemes-->
                     <td align="left"><?php echo $r1->{'fb_schemes'};?></td>
                     <!--Ghi chu-->
                     <td align="left"><?php echo $r1->{'notes'};?></td>
                     
           			
                     
                    <!-- <td align="left"><?php echo $v['logs'];?></td>
                    <td align="left"><?php echo $v['urls'];?></td>-->
                   <!-- <td><?php echo $v['ipaddress'];?></td>
                    <td><?php echo $v['browser'];?></td>
                    <td><?php echo $v['device'];?></td>
                    <td><?php echo $v['sessionuser'];?></td>-->
                    
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
	var f =Array();
	var fc = Array();
	for (var i=1; i<rows.length; i++) {
		 var cells = rows[i].cells;
		 	for( j=5; j <= 20;j++ ){
				f[j] = cells[j].innerHTML;
			}
			 
	   var cells1 = rows[i+1].cells;
	   		for( jj=5; jj <= 20;jj++ ){
				fc[jj] = cells1[jj].innerHTML;
			}
			
	   //so sanh
	   	for( k=5;k <= 20; k++ ){
				if(f[k] != fc[k]){
					cells[k].style.backgroundColor='#00FFFF';
				}
			}
    }
}
</script>