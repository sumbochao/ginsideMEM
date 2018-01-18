<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<!--<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
	
</script>-->

<!--fancybox-->
<script src="<?php echo base_url('assets/fancybox/lib/jquery-1.10.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/source/jquery.fancybox.js?v=2.1.5'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/jquery.fancybox.css?v=2.1.5'); ?>" type="text/css" media="screen"/>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5'); ?>" type="text/css" media="screen"/>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7'); ?>" type="text/css" media="screen"/>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6'); ?>"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$(".various").fancybox({
				title:'Thông tin mô tả',
				maxWidth	: 800,
				maxHeight	: 400,
				fitToView	: false,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
			
		});
	</script>
<!--end fancybox-->
<style>
.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
}

.textinputplus{
	border:none !important;
}

.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
	vertical-align:top;
}
#left{
	display:none !important;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1285px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
        <?php //include_once 'include/toolbar.php'; ?>
        </div> <!--content_form-->
<label for="menu_group_id" style="font-size: 20px;color:#E45914;margin-left: 23px;margin-bottom: 0;width:100%;margin-bottom:20px;"><?php echo $loadgame[intval($_GET['id_game'])]['app_fullname']; ?> <i style="font-size:12px;">CHECKLIST (<?php echo date('d-m-Y H:m:s'); ?>) </i>
<a href="javascript:void(0);" title="Lưu" onclick="calljavascript(0);">
<img border="0" title="Lưu" src="<?php echo base_url()?>assets/img/icon-32-save.png">
</a>
<div id="mess" style="color:#008000;font-size:20px;font-weight:bold">
<?php echo base64_decode($_GET['mess']); ?>
</div>
</label>
<form name="frmlist" id="frmlist" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=resultchecklist&id_game=<?php echo $_GET['id_game'];?>&id_template=<?php echo $_GET['id_template'];?>" enctype="multipart/form-data" method="post">
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="250px">Hạng mục</th>
                    <th align="center" width="250px">Yêu cầu</th>
                    <th align="center" width="70px">Nhóm chính</th>
                    <th align="center" width="70px">Nhóm hỗ trợ</th>
                    <th align="center" width="70px">Check <br />Client IOS</th>
                    <th align="center" width="70px">Check <br />Client Android</th>
                    <th align="center" width="70px">Check <br />Client WinPhone</th>
                    <th align="center" width="70px">Check <br />None Client</th>
                    <th align="center" width="70px">Notes</th>
                    <th align="center" width="150px">Date check</th>
                    <th align="center" width="70px">User check</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					class ViewGroup extends GroupuserModel{
						private $id_request=0;
						private $is=0;
						public function __construct($id_request,$is) {
							$this->id_request=$id_request;
							$this->is=$is;
							if (!$this->db_slave)
								$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
						}
						
						public function CreateControlGroup(){
								$Gn=$this->GroupuserModel->getItemId();
								
								$this->db_slave->select(array('*'));
								$this->db_slave->where('id_request',$this->id_request);
								if($this->is==0){
									$data = $this->db_slave->get('tbl_grand_request_group');
								}else{
									$data = $this->db_slave->get('tbl_grand_request_group_support');
								}
								if (is_object($data)) {
											$result = $data->result_array();
								}
								if(count($result)>0){
									echo "<select name='cbo_group_main_$id_request' id='cbo_group_main_$id_request' style='width:100px;border:none;background:transparent;' multiple='multiple'>";
									 foreach($result as $v){
										 echo "<option value='".$v['id_group']."'>".$Gn[$v['id_group']]['names']."</option>";
									 }//en for
									 echo "</section>";
								}
						}
						//hàm lấy thông tin bảng result
						public function getResultCheckList($id_template,$id_game,$id_categories,$id_request){
							$sql="select * from tbl_result_game_template_checklist where  id_template=$id_template and id_game=$id_game and id_categories=$id_categories and id_request=$id_request";
							$data=$this->db_slave->query($sql);
							if (is_object($data)) {
								$result = $data->row_array();
								return $result;
							}
						}//end func
						public function showimg($value){
							switch($value){
								case "None":
								echo "<img boder='0' src='".base_url()."assets/img/tick2.png'>"; 
								break;
								case "Pass":
								echo "<img boder='0' src='".base_url()."assets/img/tick.png' style='width:14px;height:14px' />"; 
								break;
								case "Fail":
								echo "<img boder='0' src='".base_url()."assets/img/error.png' style='width:14px;height:14px' />"; 
								break;
								case "Delay/Skip":
								echo "<img boder='0' src='".base_url()."assets/img/wait.png' style='width:14px;height:14px' />"; 
								break;
							}
						}
					} //end class
					
					
					$static=0;
					$i=0;
                    if(count($listGameChecklist)>0){
                        foreach($listGameChecklist as $j=>$v){
							
							$s1=new ViewGroup(0,0);
							$data = $s1->getResultCheckList($_GET['id_template'],$_GET['id_game'],$v['id_categories'],$v['id_request']);
							
                ?>
                <tr id="row_<?php echo $v['id'];?>" class="row_tab">
                    <td style="background-color:#F5CA53;">
                    <?php if($static!=$v['id_categories']){ $i++; echo "<strong style='color:red'>".$i."</strong>"; ?>
                    <strong><a class="various" style="color:#234AA5;text-decoration:none;" href="#content-div-categories-<?php echo $v['id_categories'];?>"><?php echo $slbCategories[$v['id_categories']]['names'];?></a></strong>
                    <?php }//end if ?>
                    <div style="display:none">
                        <div id="content-div-categories-<?php echo $v['id_categories'];?>"><?php echo stripcslashes($slbCategories[$v['id_categories']]['notes']);?></div>
                    </div>
                    </td>
                    <td><strong><a class="various" style="color:#008000;text-decoration:none;" href="#content-div-<?php echo $v['id_request'];?>"><?php echo $slbRequest[$v['id_request']]['titles'];?></a></strong>
                    <div style="display:none">
                        <div id="content-div-<?php echo $v['id_request'];?>"><?php echo stripcslashes($slbRequest[$v['id_request']]['notes']);?></div>
                    </div>
                    </td>
                    <td><?php $c1=new ViewGroup($v['id_request'],0);
							  echo $c1->CreateControlGroup();
					?>
                    </td>
                    <td><?php $c2=new ViewGroup($v['id_request'],1);
							  echo $c2->CreateControlGroup();
					?></td>
                    <td>
                    	<select name="cbo_client_ios_<?php echo $v['id_request']?>" style="width:100px;">
                        	
                            <option value="None" <?php 	echo $data['client_ios']=="None"?"selected":""; ?> >None</option>
                            <option value="Pass" <?php 	echo $data['client_ios']=="Pass"?"selected":""; ?>>Pass</option>
                            <option value="Fail" <?php 	echo $data['client_ios']=="Fail"?"selected":""; ?>>Fail</option>
                            <option value="Delay/Skip" <?php 	echo $data['client_ios']=="Delay/Skip"?"selected":""; ?>>Delay/Kips</option>
                        </select>
                        <?php echo $s1->showimg($data['client_ios']); ?>
                    </td>
                    <td>
                    	<select name="cbo_client_android_<?php echo $v['id_request']?>" style="width:100px;">
                        	<option value="None" <?php 	echo $data['client_android']=="None"?"selected":""; ?>>None</option>
                            <option value="Pass" <?php 	echo $data['client_android']=="Pass"?"selected":""; ?>>Pass</option>
                            <option value="Fail" <?php 	echo $data['client_android']=="Fail"?"selected":""; ?>>Fail</option>
                            <option value="Delay/Skip" <?php 	echo $data['client_android']=="Delay/Skip"?"selected":""; ?>>Delay/Kips</option>
                        </select>
                        <?php echo $s1->showimg($data['client_android']); ?>
                    </td>
                    <td>
                    	<select name="cbo_client_wp_<?php echo $v['id_request']?>" style="width:100px;">
                        	<option value="None" <?php 	echo $data['client_wp']=="None"?"selected":""; ?>>None</option>
                            <option value="Pass" <?php 	echo $data['client_wp']=="Pass"?"selected":""; ?>>Pass</option>
                            <option value="Fail" <?php 	echo $data['client_wp']=="Fail"?"selected":""; ?>>Fail</option>
                            <option value="Delay/Skip" <?php 	echo $data['client_wp']=="Delay/Skip"?"selected":""; ?>>Delay/Kips</option>
                        </select>
                        <?php echo $s1->showimg($data['client_wp']); ?>
                    </td>
                    <td>
                    	<select name="cbo_client_none_<?php echo $v['id_request']?>" style="width:100px;">
                        	<option value="None" <?php 	echo $data['none_client']=="None"?"selected":""; ?>>None</option>
                            <option value="Pass" <?php 	echo $data['none_client']=="Pass"?"selected":""; ?>>Pass</option>
                            <option value="Fail" <?php 	echo $data['none_client']=="Fail"?"selected":""; ?>>Fail</option>
                            <option value="Delay/Skip" <?php 	echo $data['none_client']=="Delay/Skip"?"selected":""; ?>>Delay/Kips</option>
                        </select>
                        <?php echo $s1->showimg($data['none_client']); ?>
                    </td>
                    <td>
                    <textarea name="notes_<?php echo $v['id_request']?>" cols="5" role="3" id="notes_<?php echo $v['id_request']?>"> <?php echo $data['notes']; ?></textarea>
                    </td>
                    <td><?php echo $data['datecreate']?></td>
                    <td><strong style="color:#900;"><?php echo $slbUser[$data['userlog']]['username'];?></strong></td>
                </tr>
                <?php
						$static=$v['id_categories']; 
                        }//end for
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
    </form>
         
            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_template.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i){
		switch(i){
			 case 0: // save
			 	var c=confirm('Bạn có muốn cập nhật thông tin trên!');
				if(c){
					document.forms.frmlist.submit();
					//window.location.href='<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=resultchecklist&id_game=<?php echo $_GET['id_game'];?>&id_template=<?php echo $_GET['id_template'];?>';
				}
			 
			 break;
			 default:
			 break;
		}
	}
</script>
