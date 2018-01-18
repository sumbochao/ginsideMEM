<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<style>
#Lightboxt{
	width:800px !important;
	height:500px !important;
	left:22% !important;
	top:100px !important;
}
</style>

<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <!--<div class="filter">
        	<input type="text" name="keyword" id="keyword" value="<?php echo $_POST['keyword'];?>" class="textinput" placeholder="Nhập từ khóa ..." title="Nhập từ khóa ..." maxlength="20" style="width:350px;"/>
           
            <?php 
				function formatInterface($String,$type){
					$TSR="";
					$pos=explode(",",$String);
					switch($type){
						case "Xóa Payment":
							$STR.="<strong>Type:</strong> ".$pos[3]." <strong>Name:</strong> ".$pos[4]." <strong>PromotionKNB:</strong> ".$pos[5]." <strong>KNB:</strong> ".$pos[6]." <strong>Mcoin:</strong> ".$pos[7]." <strong>Vnd:</strong> ".$pos[8]. " <strong>Notes:</strong> ".$pos[9];
							break;
						case "Xóa dữ liệu [1]":
							$STR.="<strong>Mã:</strong> ".$pos[1]." <strong>Tên:</strong> ".$pos[2]." <strong>Tên cài đặt:</strong> ".$pos[2]." <strong>servicekeyapp:</strong> ".$pos[4]." <strong>servicekey:</strong> ".$pos[5]." <strong>facebookapp:</strong> ".$pos[6]. " <strong>facebookappid:</strong> ".$pos[7]. " <strong>facebookappsecret:</strong> ".$pos[8]. " <strong>itunesconnect:</strong> ".$pos[9]. " <strong>appleid:</strong> ".$pos[10]. " <strong>gacode:</strong> ".$pos[11]. " <strong>appsflyerid:</strong> ".$pos[12]. " <strong>googleproductapi:</strong> ".$pos[13]. " <strong>urlschemes:</strong> ".$pos[14]. " <strong>facebookurlschemes:</strong> ".$pos[15]. " <strong>googlesenderid:</strong> ".$pos[16]. " <strong>googleapikey:</strong> ".$pos[17]. " <strong>facebookfanpagelink:</strong> ".$pos[18]. " <strong>notes:</strong> ".$pos[21];
							break;
						case "Xóa dữ liệu [2]":
							$STR.="<strong>Platform:</strong> ".$pos[2]." <strong>App ID:</strong> ".$pos[3]." <strong>Package Name:</strong> ".$pos[4]." <strong>Public Key:</strong> ".$pos[6]." <strong>Publisher:</strong> ".$pos[8]." <strong>Names for this app:</strong> ".$pos[9]. " <strong>APN certificates:</strong> ".$pos[14]. " <strong>APN pass:</strong> ".$pos[15]. " <strong>Api Key:</strong> ".$pos[16]. " <strong>Client Key:</strong> ".$pos[17]. " <strong>Url scheme:</strong> ".$pos[18]. " <strong>Client secret:</strong> ".$pos[19]. " <strong>Notes:</strong> ".$pos[10];
							break;
						default:
							$STR=$String;
							break;
					}
					return $STR;
				}
                if((@in_array($_GET['control'].'-filter', $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                    $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&type=filter')";
                }else{
                    $lnkFilter = "alert('Bạn không có quyền truy cập chức năng này!')";
                }
            ?>
            <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>
            <strong style="color:#F00;padding-left:20px;"><?php echo base64_decode($_GET['info']);?></strong>   
        </div>-->
        <div class="wrapper_scroolbar_ss">
            <div class="scroolbar_ss">
        <div id="paging_div" style="float:left;margin-bottom:5px;">
        	<?php echo $pages?>
        </div> <!--paging_div-->
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th  width="10px">STT</th>
                    <th  width="50px">ID</th>
                    <th  width="100px">User</th>
                    <th  width="150px">Date</th>
                    <th  width="180px">Action</th>
                    <th>Data delete</th>
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
				$j=0;
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
							$j++;
							$valr='';
							$r1=explode(",",str_replace(array('{','}'),'',$v['logs']));
							for($ii=0;$ii <= count($r1);$ii++){
								$rw=explode(":",$r1[$ii]);
								$valr.=str_replace('"','',json_decode($rw[1])).",";
							}
							// định dạng hiển thị thông tin bị xóa
							
							
                ?>
                <tr>
                  
                
                    <td align="left"><?php echo $j;?></td>
                   <td align="left"><?php echo $v['id'];?></td>
                    <td align="left"><strong style="color:#900"><?php echo $slbUser[$v['username']]['username'];?></strong></td>
                     <td align="left"><?php echo $v['timesmodify'];?></td>
                    <td align="left"><?php echo $v['actions'];?></td>
                    <td align="left"><a href="javascript:void(0);" onclick="Lightboxt.showemsg('View','<?php echo formatInterface($valr,$v['actions']); ?>', 'Đóng');">View</a></td>
                    <!-- <td align="left"><?php echo $v['logs'];?></td>
                    <td align="left"><?php echo $v['urls'];?></td>-->
                    <!--<td><?php echo $v['ipaddress'];?></td>
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