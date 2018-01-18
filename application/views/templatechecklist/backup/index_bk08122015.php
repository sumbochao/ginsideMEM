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
.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
	vertical-align:top;
}
</style>
<div class="loading_warning"></div>
 <div class="wrapper_scroolbar" style="font-size:12px;">
            <div class="scroolbar" style="width:1100px;">
<div id="content-t" class="content_form" style="min-height:0; padding-top:10px">
    <?php //include_once 'include/toolbar.php'; ?>
</div> <!--content_form-->

 <div id="adminfieldset">
    <div class="adminheader">Tạo Game Check List</div>
        <div class="rows">	
         <form id="appFormGame" name="appFormGame" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=addgame&id_template=<?php echo intval($_GET['id_template']); ?>" method="post" >
         <select name="cbo_game" id="cbo_game" class="chosen-select" tabindex="2" data-placeholder="Chọn game">
                <option value="0"> -- Chọn Game -- </option>
                <?php
                    if(count($loadgame)>0){
                        foreach($loadgame as $v){
                ?>
                <option value="<?php echo $v['service_id'];?>"><?php echo $v['app_fullname'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
             <input type="button" onclick="calljavascript(3);" value="Add Game" class="btnB btn-primary"/> 			 <div class="rows">
                	<div id="mess" style="color:#008000;font-size:20px;font-weight:bold">
					<?php echo base64_decode($_GET['mess']); ?>
                    </div>
             </div>
         </form>
        </div>
    <div class="clr"></div>
</div>
 <div id="adminfieldset">
    <div class="adminheader">Danh sách Game đang sử dụng</div>
    <form id="appFormRemove" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=removegame&id_template=<?php echo intval($_GET['id_template']); ?>" method="post" name="appFormRemove" enctype="multipart/form-data">
        <div class="rows">	
         <?php
                    if(count($listGameChecklist)>0){
                        foreach($listGameChecklist as $v){
                ?>
                <input type="checkbox" name="chk_game[<?php echo $v['id_game'];?>]" id="chk_game_<?php echo $v['id_game'];?>" value="<?php echo $v['id_game'];?>" style="margin-left:10px;" />
				<a href="<?php echo base_url();?>?control=gamechecklist&func=index&id_template=<?php echo intval($_GET['id_template']); ?>&id_game=<?php echo $v['id_game']; ?>" target="_blank" style="color:#E81287;text-decoration:none;">Checklist - <?php echo $loadgame[$v['id_game']]['app_fullname']; ?></a>
                <?php
                        }
                    }
                ?>
        </div>
        <div class="rows" style="margin-top:15px;margin-left:15px;">
        	<input type="button" onclick="calljavascript(4);" value="Remove Game" style="font-size:10px;color:#98225D"/>
            
        </div>
        <div class="rows">
        <label style="width:100%;margin-left:15px;">Click vào ô checkbox sau đó nhấn nút "Remove Game" sẽ xóa game khỏi Template này. Click vào tên game để Checklist kết quả</label>
        </div>
    </form>
    <div class="clr"></div>
</div>

<div id="adminfieldset">
    <div class="adminheader"><label for="menu_group_id" style="font-size:16px;color: #569688;width:100%;">BIỂU MẪU : <?php echo $slbTemp[intval($_GET['id_template'])]['template_name']; ?></label></div>
   <div class="rows"> 
<form id="appForm" action="<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>&id_template=<?php echo intval($_GET['id_template']); ?>&type=filter" method="post" name="appForm" enctype="multipart/form-data">
       <div class="filter" style="margin-top:10px;margin-left:15px;">
            <select name="cbo_categories" id="cbo_categories" data-placeholder="Chọn Template">
                <option value=""> --- Lọc Hạng mục --- </option>
                <?php
                    if(count($listCategories)>0 && $listCategories != NULL){
                        foreach($listCategories as $v){
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo $_POST['cbo_categories']==$v['id']?'selected="selected"':'';?> ><?php echo $v['names'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <input type="button" onclick="calljavascript(2);" value="Tìm" class="btnB btn-primary"/> 
            
       </div> <!--filter-->
</form>
		
         <form name="frmlist" id="frmlist" enctype="multipart/form-data" method="post">
<table style="float:left;" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="300px"><a href="<?php echo base_url();?>?control=categories&func=index&cbo_template=<?php echo $_GET['id_template'];?>" target="_blank">Hạng mục</a></th>
                    <th align="center" width="300px">Yêu cầu</th>
                    <th align="center" width="200px">Nhóm chính</th>
                    <th align="center" width="200px">Nhóm Hỗ trợ</th>
                    <!--<th align="center" width="170px">Check <br />Client IOS</th>
                    <th align="center" width="170px">Check <br />Client Android</th>
                    <th align="center" width="170px">Check <br />Client WinPhone</th>
                    <th align="center" width="170px">Check <br />None Client</th>-->
                    <!--<th align="center" width="70px">Date check</th>
                    <th align="center" width="70px">User check</th>-->
                    <th align="center" width="70px">User</th>
                    <!--<th align="center" width="70px">Notes</th>-->
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
						}
						public function CreateControlGroup(){
								$Gn=$this->GroupuserModel->getItemId();
								if (!$this->db_slave)
								$this->db_slave = $this->load->database(array('db' => 'inside_info', 'type' => 'slave'), TRUE);
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
									echo "<select name='cbo_group_main_$id_request' id='cbo_group_main_$id_request' style='width:150px;border:none;background:transparent;' multiple='multiple' >";
									 foreach($result as $v){
										 echo "<option value='".$v['id_group']."' ondblclick='calljavascript(5,".$v['id_group'].");'>".$Gn[$v['id_group']]['names']."</option>";
									 }//en for
									 echo "</section>";
								}
						}
					} //end class
					
					$static=0;
					$j=0;
                    if(count($listItems)>0 && $listItems != NULL){
                        foreach($listItems as $i=>$v){
                ?>
                <tr id="row_<?php echo $v['id'];?>" class="row_tab">
             		<td style="background-color:#F5CA53;">
                    <?php if($static!=$v['id_categories']){ $j++; echo "<strong style='color:red'>".$j."</strong>"; ?> - <a href="<?php echo base_url();?>?control=categories&func=edit&id=<?php echo $v['id_categories'];?>&id_template=<?php echo $_GET['id_template'];?>" target="_blank" style="text-transform: uppercase;text-decoration:none;font-weight:bold;font-size:14px;" title="<?php echo $slbCategories[$v['id_categories']]['notes'];?>"><?php echo $slbCategories[$v['id_categories']]['names'];?></a>
                    [ status: <?php echo $slbCategories[$v['id_categories']]['status']==0?"<img src='".base_url()."assets/img/tick.png' width='16' height='16' >":"<img src='".base_url()."assets/img/off.gif' width='16' height='16' >";?> ]
                    <?php }//end if ?>
                    </td>
                    <td><a href="<?php echo base_url();?>?control=request&func=edit&id=<?php echo $v['id_request'];?>&id_template=<?php echo $_GET['id_template'];?>&id_categories=<?php echo $v['id_categories'];?>" target="_blank" style="color:#E81287;text-decoration:none;font-style:italic;"><?php echo $slbRequest[$v['id_request']]['titles'];?></a></td>
                    <td><?php $c1=new ViewGroup($v['id_request'],0);
							  echo $c1->CreateControlGroup();
					?>
                    </td>
                    <td><?php $c2=new ViewGroup($v['id_request'],1);
							  echo $c2->CreateControlGroup();
					?></td>
                   <!-- <td><?php echo $v['client_ios'];?></td>
                    <td><?php echo $v['client_android'];?></td>
                    <td><?php echo $v['client_wp'];?></td>
                    <td><?php echo $v['none_client'];?></td>-->
                    <!--<td><?php echo $v['datecheck'];?></td>
                    <td><?php echo $slbUser[$v['userchecklist']]['username'];?></td>-->
                    <td><?php echo $slbUser[$v['userlog']]['username'];?></td>
                   <!-- <td><?php echo stripslashes($v['notes']);?></td>-->
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
    </div> <!--rows-->
    <div class="clr"></div>
 </div> <!--adminfieldset-->
            
 </div> <!--scroolbar-->
</div> <!--wrapper_scroolbar-->
<script src="<?php echo base_url('assets/js/gamechecklist/js_gamechecklist_template.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
function calljavascript(i,id){
		switch(i){
			 case 0: // xóa
			 	deleteitem(id,'<?php echo base_url();?>?control=<?php echo $_GET['control'];?>&func=<?php echo $_GET['func'];?>')
			 
			 break;
			 case 2: //tim kiem
			 	document.forms.appForm.submit();
			 break;
			 case 3: //add game
			 	var _g = $('#cbo_game').val();
				if(_g==0){
					alert('Vui lòng chọn game');
					$('#cbo_game').focus();
					return;
				}
			 	document.forms.appFormGame.submit();
			 break;
			  case 4: //xóa game
			 	c=confirm('bạn có muốn Remove những game này ra khỏi Template');
				if(c){
					document.forms.appFormRemove.submit();
				}
			 	
			 break;
			 case 5:
			 	window.location.href='<?php echo base_url();?>?control=groupuser&func=userongroup&id_group=' + id;
			 break;
			 default:
			 break;
		}
	}
</script>
